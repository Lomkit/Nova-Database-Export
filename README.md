# Nova Export Database

> Laravel tools for exporting database.

## Setup
- Setup composer.json :

```php
{
    // ...
    "require": {
        "lomkit/nova-database-export": "*",
    },
    // ...
    "repositories": [
        { "type": "vcs", "url": "https://github.com/Lomkit/Nova-Database-Export.git" }
    ],
}
```

And then run `composer update`

## Usage

Just register the component in the tools section of NovaServiceProvider.php

```php
    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            Export::make()
                ->setFields(
                    [
                        'table_name' => 'competences',
                        'locales' => true,
                        'query' => function($query) { return $query->translated(); },
                        'select' => ['id', 'name', 'slug', 'mode_id', 'clan_id'],
                    ],
                    [
                        'table_name' => 'competences',
                        'locales' => ['en' => 'English', 'fr' => 'French'],
                        'query' => function($query) { return $query->translated(); },
                        'select' => ['id', 'name', 'slug', 'mode_id', 'clan_id'],
                    ],
                    [
                        'table_name' => 'competences',
                        'export_name' => 'competences_deux'
                    ],
                )
        ];
    }
```

The doc about the field object:

```
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
```
