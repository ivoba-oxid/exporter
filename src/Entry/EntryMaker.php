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


    public function make(array $data): array
    {
        $entry   = null;
        $entries = [];
        $columns = $this->config->getFields();

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

            $entries[] = $value;

        }

        return $entries;
    }
}
