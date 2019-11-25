<?php

namespace IvobaOxid\Exporter\Query;

use IvobaOxid\Exporter\Entity\Config;
use OxidEsales\EshopCommunity\Core\Database\Adapter\DatabaseInterface;

class Orders implements QueryInterface
{
    private $db;
    private $config;

    /**
     * Orders constructor.
     * @param DatabaseInterface $db
     * @param Config $config
     */
    public function __construct(DatabaseInterface $db, Config $config)
    {
        $this->db     = $db;
        $this->config = $config;
    }

    public function get(array $context = [])
    {
        $data = [];

        $sql = "SELECT oxorder.*
                FROM oxorder";

        if(isset($context['filter'])) {
            $sql .= ' '.$context['filter'];
        }
        if(isset($context['sort'])) {
            $sql .= ' '.$context['sort'];
        }

        $result = $this->db->select($sql);
        if ($result !== false && $result->count() > 0) {
            foreach ($result as $row) {
                $data[] = $row;
            }
        }

        if ($this->config->getDebug()) {
            echo count($data) . " orders found.<br>";
        }

        return $data;
    }
}
