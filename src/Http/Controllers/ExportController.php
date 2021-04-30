<?php


namespace Lomkit\Export\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Lomkit\Export\Export;
use Lomkit\Export\Traits\FindsTools;
use STS\ZipStream\ZipStream;

class ExportController
{
    use FindsTools;

    public function fields(Request $request)
    {
        $export = $this->getFirstToolOfType(Export::class);

        if (!is_null($export)) {
            return response()->json($export->fields());
        }

        return response([]);
    }

    public function exportField(Request $request, $field) {
        $export = $this->getFirstToolOfType(Export::class);

        if (!is_null($export)) {
            $field = $export->fields()[$field];

            $results = $this->getResults($field);

            $exportName = $field['export_name'] ?? $field['table_name'];

            if ($results['type'] === 'zip') {
                $zip = \Zip::create($exportName.'.zip');

                foreach ($results['results'] as $locale => $result) {
                    $zip->addRaw(json_encode($result), $locale.'.json');
                }
                return $zip;
            }

            return response()->streamDownload(function () use ($results, $field) {
                echo json_encode($results['results']);
            }, $exportName.'.json');
        }
        return response('Export not found');
    }

    public function exportAll(Request $request) {
        $export = $this->getFirstToolOfType(Export::class);

        if (!is_null($export)) {
            $fields = $export->fields();

            $zip = \Zip::create('export.zip');

            foreach ($fields as $field) {
                $results = $this->getResults($field);

                $exportName = $field['export_name'] ?? $field['table_name'];

                if ($results['type'] === 'zip') {
                    foreach ($results['results'] as $locale => $result) {
                        $zip->addRaw(json_encode($result), "{$exportName}/{$locale}.json");
                    }
                } else {
                    $zip->addRaw(json_encode($results['results']), $exportName.'.json');
                }
            }

            return $zip;
        }
        return response('Export not found');
    }

    private function getResults($field) {
        $query = $this->createQuery($field);

        if (isset($field['locales']) && $field['locales'] !== false) {
            $results = [];

            $query->each(function($model) use ($field, &$results) {
                foreach ($field['locales'] as $locale => $text) {
                    $results[$locale][] = $model->setLocale($locale)->toArray();
                }
            });

            return ['type' => 'zip', 'results' => $results];
        }

        return ['type' => 'json', 'results' => $query->get()];
    }

    private function createQuery($field) {
        $className = 'App\\Models\\' . Str::singular(Str::studly($field['table_name']));

        if(!class_exists($className)) {
            abort(400, "Class {$className} does not exist");
        }

        $query = $className::query();
        // Apply selects
        if (isset($field['select'])) {
            $query->select($field['select']);
        }
        // Apply query
        if (isset($field['query'])) {
            $field['query']($query);
        }

        return $query;
    }
}
