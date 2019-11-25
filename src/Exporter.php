<?php

namespace IvobaOxid\Exporter;

use IvobaOxid\Exporter\Entity\Config;
use IvobaOxid\Exporter\Entry\EntryMaker;
use IvobaOxid\Exporter\Query\QueryInterface;

class Exporter
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var array[QueryInterface]
     */
    private $queries;

    private $entryMaker;

    private $fileHandle;

    private $count = 0;

    /**
     * Exporter constructor.
     * @param Config $config
     * @param QueryInterface[] $queries
     * @param EntryMaker $entryMaker
     */
    public function __construct(Config $config, array $queries, EntryMaker $entryMaker)
    {
        $this->config     = $config;
        $this->queries    = (function (QueryInterface ...$items) {
            return $items;
        })(...$queries);
        $this->entryMaker = $entryMaker;
    }


    public function export()
    {
        $data = [];

        foreach ($this->queries as $query) {
            $queryData = $query->get();
            foreach ($queryData as $queryDatum) {
                if (isset($data[$queryDatum['OXID']])) {
                    $data = array_merge($data[$queryDatum['OXID']], $queryDatum);
                } else {
                    $data[$queryDatum['OXID']] = $queryDatum;
                }
            }
        }

        $this->initFile();
        $this->writeHeadLine();

        foreach ($data as $datum) {
            $entry = $this->entryMaker->make($datum);
            if ($entry) {
                $this->writeToFile($entry);
            }
        }

        if ($this->config->getDebug()) {
            echo "Done! Exported ".$this->count." articles!<br>";
        }
    }

    private function initFile()
    {
        if (file_exists($this->config->getFile())) {
            unlink($this->config->getFile());
        }
        $this->fileHandle = fopen($this->config->getFile(), "w+");
    }

    private function writeHeadLine()
    {
        if ($this->config->getHeadLine()) {
            $data = $this->config->getHeadLine();
            //todo maybe apply config->seperator and config->quote to data
            fputs($this->fileHandle, $data.$this->config->getEol());
        }
    }

    private function writeToFile(string $entry)
    {
        fputs($this->fileHandle, $entry);
        $this->count++;
        if ($this->config->getDebug()) {
            echo $entry."<br>";
        }
    }

    public function __destruct()
    {
        if ($this->fileHandle) {
            fclose($this->fileHandle);
        }
    }
}
