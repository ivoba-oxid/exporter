<?php
declare(strict_types=1);

namespace IvobaOxid\Exporter\Tests;

use IvobaOxid\Exporter\Entity\Config;
use IvobaOxid\Exporter\Entry\EntryMaker;
use IvobaOxid\Exporter\Exporter;
use PHPUnit\Framework\TestCase;

class ExporterExampleTest extends TestCase
{
    public function testConstruct()
    {
        $config = new Config(__DIR__.'/example.csv', 'test.url', 1);
        $config->setDebug(true)
               ->setHeadLine('Product_id;Product_name;Image_URL')
               ->setFields(explode('|', 'oxid|oxtitle|image'))
               ->setImgPath('/out/pictures/generated/product/1/380_340_75/');
        $queries    = [];
        $entryMaker = new EntryMaker(
            $config,
            [],
            []
        );
        $exporter   = new Exporter($config, $queries, $entryMaker);
        $this->assertInstanceOf(Exporter::class, $exporter);
    }
}
