<?php

namespace IvobaOxid\Exporter;

use IvobaOxid\Exporter\Entity\Config;
use IvobaOxid\Exporter\Entry\EntryMaker;
use IvobaOxid\Exporter\Query\QueryInterface;
use ParseCsv\Csv;
use ParseCsv\enums\FileProcessingModeEnum;

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
    /**
     * @var EntryMaker
     */
    private $entryMaker;
    /**
     * @var Csv
     */
    private $csv;
    /**
     * @var int
     */
    private $count = 0;

    /**
     * Exporter constructor.
     * @param Config $config
     * @param array $queries
     * @param EntryMaker $entryMaker
     */
    public function __construct(Config $config, array $queries, EntryMaker $entryMaker)
    {
        $this->config     = $config;
        $this->queries    = (function (QueryInterface ...$items) {
            return $items;
        })(...$queries);
        $this->entryMaker = $entryMaker;
        $this->csv = new Csv();
    }


    public function export(): void
    {
        $data = $this->loadData();

        $fields = [];
        if ($this->config->getHeadLine()) {
            $fields = $this->config->getFields();
        }
        $rows = [];
        foreach ($data as $datum) {
            $entry = $this->entryMaker->make($datum);
            if ($entry) {
                $rows[] = $entry;
            }
        }
        $this->csv->delimiter = $this->config->getDelimiter();
        $this->csv->enclose_all = $this->config->getQuote();
        $this->csv->linefeed = $this->config->getEol();
        $this->csv->output_encoding = 'UTF-8';
        $this->csv->save($this->config->getFile(), $rows, $append = FileProcessingModeEnum::MODE_FILE_OVERWRITE, $fields);

        if ($this->config->getDebug()) {
            echo "Done! Exported ".$this->count." articles!<br>";
        }
    }

    /**
     * @return array
     */
    protected function loadData(): array
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

        return $data;
    }
}
