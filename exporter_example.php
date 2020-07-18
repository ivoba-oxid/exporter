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
use \IvobaOxid\Exporter\Resolver\Currency;
use \IvobaOxid\Exporter\Resolver\Image;
use \IvobaOxid\Exporter\Resolver\StaticValue;
use \IvobaOxid\Exporter\Resolver\TitleWithVariant;

$langParams = Registry::getConfig()->getConfigParam('aLanguageParams');
$shopUrl    = Registry::get("oxConfigFile")->getVar('sShopURL');
$config     = new Config(__DIR__.'/export/example.csv', $shopUrl, $langParams['de']['baseId']);
$config->setDebug(true)
       ->setHeadLine('Product_id;Product_name;Image_URL')
       ->setFields(explode('|', 'oxid|oxtitle|empty|image'))
       ->setImgPath('/out/pictures/generated/product/1/380_340_75/');

$db = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC);

$queries              = [
    new Products(
        new ParentProducts($db, $config),
        new ChildProducts($db, $config)
    ),
];
$titleResolver        = new TitleWithVariant();
$currencyResolver     = new Currency(Registry::getConfig());
$imageResolver        = new Image($config);
$entryMaker           = new EntryMaker(
    $config,
    [],
    [
        $titleResolver,
        $currencyResolver,
        $imageResolver,
        new StaticValue('', 'empty')
    ]
);

$exporter = new Exporter($config, $queries, $entryMaker);

$exporter->export();
