<?php

namespace IvobaOxid\Exporter\Resolver;

use OxidEsales\Eshop\Core\Database\Adapter\DatabaseInterface;

class MainCategoryId extends BaseResolver
{
    private $db;

    public function __construct(DatabaseInterface $db, string $supports)
    {
        $this->db = $db;
        parent::__construct($supports);
    }

    public function resolve(array $data)
    {
        $sql    = "SELECT oxcatnid
                FROM oxobject2category
                WHERE oxobjectid = '".$data['OXID']."'
                ORDER BY oxtime
                LIMIT 1;";
        $result = $this->db->select($sql);
        if ($result !== false && $result->count() > 0) {
            $row = $result->getFields();

            return $row['oxcatnid'];
        }

        return null;
    }
}
