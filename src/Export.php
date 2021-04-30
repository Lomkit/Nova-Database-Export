<?php

namespace Lomkit\Export;

use Illuminate\Support\Str;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class Export extends Tool
{
    private $fields;

    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('export', __DIR__.'/../dist/js/tool.js');
        Nova::style('export', __DIR__.'/../dist/css/tool.css');
    }

    /**
     * Set the fields that will be displayed to front side
     *
     * @param array ...$fields {
     *     Fields Options.
     *
     *     @type string $table_name The table name that will be exported
     *     @type boolean|array $locales [ Optional ] The langs that will be used to create the file,
     *          you can either pass a boolean or array if you want to defined the locales.
     *     @type boolean $select [ Optional ] The select that need to be applied.
     *     @type string $export_name [ Optional ] Define the export name in the zip / json.
     *     @type callable $query [ Optional ] The function to alterate the query if necessary, by
     *          default, all the data will be selected.
     *     @type string $name [ Optional ] The name that will be displayed to front-end. Defaults to
     *          the table name to title.
     * }
     * @return Export
     */
    public function setFields(...$fields): Export
    {
        foreach ($fields as &$field) {
            if (!isset($field['name'])) {
                $field['name'] = Str::title($field['table_name']);
            }
            if (isset($field['locales']) && is_bool($field['locales']) && $field['locales'] === true) {
                $field['locales'] = config('lomkit.locales', []);
            }
        }
        $this->fields = $fields;

        return $this;
    }

    public function fields() {
        return $this->fields;
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        return view('export::navigation');
    }
}
