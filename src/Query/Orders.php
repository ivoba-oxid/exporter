<?php

namespace IvobaOxid\Exporter\Query;

use IvobaOxid\Exporter\Entity\Config;
use OxidEsales\EshopCommunity\Core\Database\Adapter\DatabaseInterface;

class Orders implements QueryInterface
{
    private $db;
    private $config;
    private $filter;
    private $sort;

    /**
     * Orders constructor.
     * @param DatabaseInterface $db
     * @param Config $config
     * @param string|null $filter
     * @param string|null $sort
     */
    public function __construct(
        DatabaseInterface $db,
        Config $config,
        string $filter = null,
        string $sort = null
    ) {
        $this->db     = $db;
        $this->config = $config;
        $this->filter = $filter;
        $this->sort   = $sort;
    }

    public function get(array $context = [])
    {
        $data = [];

        $sql = "SELECT oxorder.*
                FROM oxorder";
        if ($this->filter) {
            $sql .= ' '.$this->filter;
        }
        if ($this->sort) {
            $sql .= ' '.$this->sort;
        }

        $result = $this->db->select($sql);
        if ($result !== false && $result->count() > 0) {
            foreach ($result as $row) {
                $data[] = $row;
            }
        }

        if ($this->config->getDebug()) {
            echo count($data)." orders found.<br>";
        }

        return $data;
    }
}
