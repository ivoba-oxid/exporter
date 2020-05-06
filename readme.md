# Exporter
CSV Export framework for OXID eShop.

## Requirements
- Oxid eShop >= 6
- PHP >= 7

## Installation
- run 'composer require ivoba-oxid/exporter'

## Usage
Create an exporter in source/, see exporter_example.php.

For custom Resolver or Queries, create a custom module and place code there.
Add an autooader in composer.json run composer install and include classes in your exporter.

    "autoload": {
        "psr-4": {
          ...
          "MyOxid\\Exporter\\": "./source/modules/my/exporter",

## todo
- evaluate new Article()->load()
- make cli command
  create file in bin
- get Attributes code/modules/marm/csvexporter/core/marmCsvExporter.php:507

## Credits
- https://github.com/marmaladeDE/csvexporter
- https://github.com/ivoba-oxid/oxid-sitemap
