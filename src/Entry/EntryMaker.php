<?php

namespace IvobaOxid\Exporter\Entry;

use IvobaOxid\Exporter\Entity\Config;
use IvobaOxid\Exporter\Resolver\ResolverInterface;

class EntryMaker
{
    private $config;
    /**
     * @var FilterInterface[]
     */
    private $filters;
    private $resolvers;

    public function __construct(Config $config, array $filters = [], array $resolvers = [])
    {
        $this->config  = $config;
        $this->filters = (function (FilterInterface ...$items) {
            return $items;
        })(...$filters);

        foreach ($resolvers as $resolver) {
            if ($resolver instanceof ResolverInterface) {
                $this->resolvers[strtoupper($resolver->supports())] = $resolver;
            }
        }
    }


    public function make(array $data)
    {
        $entry   = null;
        $entries = [];
        $fields  = $this->config->getFields();

        $columns = explode('|', $fields);

        foreach ($columns as $column) {

            //Todo filter
            $column = strtoupper($column);
            $value  = '';
            if (isset($this->resolvers[$column])) {
                $value = $this->resolvers[$column]->resolve($data);
            } else {
                if (isset($data[$column])) {
                    $value = $data[$column];
                }
            }

            $entries[] = $this->quote().$value.$this->quote();
        }

        if ($entries) {
            $entry = implode($this->config->getDelimiter(), $entries).$this->config->getEol();
        }

        return $entry;
    }

    private function quote(): string
    {
        return $this->config->getQuote() ? '"' : '';
    }

    /**
     * caching explodes
     * fill $this->entryFields
     */
    public function cachingEntryFields(array $fields)
    {
        $result = array();
        $col    = 0;
        $conc   = 0;
        $fb     = 0;

        $columns = explode('|', $fields); //split the header
        foreach ($columns as $column) {
            $concatenations = explode('+', $column);

            foreach ($concatenations as $concatenate) {
                $varFallbacks = explode('/', $concatenate);
                foreach ($varFallbacks as $marker) {
                    $result[$col][$conc][$fb] = $marker;
                    $fb++;
                }

                $conc++;
            }
            $col++;
        }
        $this->entryFields = $result;
    }
}
