<?php
declare(strict_types=1);

namespace IvobaOxid\Exporter\Tests;

use IvobaOxid\Exporter\Entity\Config;
use IvobaOxid\Exporter\Entry\EntryMaker;
use IvobaOxid\Exporter\Exporter;
use IvobaOxid\Exporter\Resolver\BaseResolver;
use IvobaOxid\Exporter\Resolver\FieldResolver;
use IvobaOxid\Exporter\Resolver\Image;
use IvobaOxid\Exporter\Resolver\TitleWithVariant;
use PHPUnit\Framework\TestCase;

class ExporterExampleTest extends TestCase
{
    public function testConstruct()
    {
        $config = new Config(__DIR__.'/example.csv', 'test.url', 1);
        $config->setDebug(true)
               ->setFields(explode('|', 'Product_Id;SKU;Product_Name;Image_URL'))
               ->setImgPath('/out/pictures/generated/product/1/380_340_75/');
        $queries    = [];
        $entryMaker = new EntryMaker(
            $config,
            [],
            [
                new FieldResolver('OXID', 'Product_Id'),
                new FieldResolver('OXARTNUM', 'SKU'),
                new TitleWithVariant('Product_Name'),
                new Image($config, 'Image_URL'),
            ]
        );
        $exporter   = new Exporter($config, $queries, $entryMaker);
        $this->assertInstanceOf(Exporter::class, $exporter);
    }
}
