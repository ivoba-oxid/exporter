<?php

namespace IvobaOxid\Exporter\Query;

use IvobaOxid\Exporter\Entity\Config;
use OxidEsales\EshopCommunity\Core\Database\Adapter\DatabaseInterface;

class ChildProducts implements QueryInterface
{
    private $db;

    private $config;

    /**
     * ParentProducts constructor.
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

        $andParent = "oxart.oxparentid != ''";
        if (isset($context['OXID'])) {
            $andParent = "oxart.oxparentid = '".$context['OXID']."'";
        }

        $sql = "SELECT oxartex.*,oxart.*
                FROM oxarticles oxart 
                LEFT JOIN oxartextends oxartex ON(oxart.oxid = oxartex.oxid)
                WHERE oxart.oxactive = 1 
                AND $andParent";

        $result = $this->db->select($sql);
        if ($result !== false && $result->count() > 0) {
            foreach ($result as $row) {
                $data[] = $row;
            }
        }

        if ($this->config->getDebug()) {
            echo count($data)." children products found.<br>";
        }

        return $data;
    }
}