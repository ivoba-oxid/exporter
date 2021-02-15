<?php

require_once __DIR__.'/bootstrap.php';

use \OxidEsales\Eshop\Core\Registry;
use \OxidEsales\Eshop\Core\DatabaseProvider;
use \IvobaOxid\Exporter\Query\ChildProducts;
use \IvobaOxid\Exporter\Entity\Config;
use \IvobaOxid\Exporter\Entry\EntryMaker;
use \IvobaOxid\Exporter\Exporter;
use \IvobaOxid\Exporter\Query\ParentProducts;
use \IvobaOxid\Exporter\Query\Products;
use \IvobaOxid\Exporter\Resolver\Image;
use \IvobaOxid\Exporter\Resolver\StaticValue;
use \IvobaOxid\Exporter\Resolver\TitleWithVariant;

$langParams = Registry::getConfig()->getConfigParam('aLanguageParams');
$shopUrl    = Registry::get("oxConfigFile")->getVar('sShopURL');
$config     = new Config(__DIR__.'/export/example.csv', $shopUrl, $langParams['de']['baseId']);
$config->setDebug(true)
       ->setFields(explode(';', 'Product_id;Product_name;Image_URL'))
       ->setImgPath('/out/pictures/generated/product/1/380_340_75/');

$db = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC);

$queries       = [
    new Products(
        new ParentProducts($db, $config),
        new ChildProducts($db, $config)
    ),
];
$titleResolver = new TitleWithVariant($db, 'Product_name');
$idResolver    = new FieldResolver('OXID', 'Product_id');
$imageResolver = new Image($config, 'Image_URL');
$entryMaker    = new EntryMaker(
    $config,
    [],
    [
        $idResolver,
        $titleResolver,
        $imageResolver,
        new StaticValue('', 'empty'),
    ]
);

$exporter = new Exporter($config, $queries, $entryMaker);

$exporter->export();
