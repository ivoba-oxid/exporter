<?php

namespace IvobaOxid\Exporter\Resolver;

use OxidEsales\Eshop\Core\Database\Adapter\DatabaseInterface;

/**
 * In case you use a category for manufacturers
 *
 * Class ManufacturerCategory
 * @package IvobaOxid\Exporter\Resolver
 */
class ManufacturerCategory extends BaseResolver
{
    private $db;
    private $catId;
    private $manufacturers;

    public function __construct(DatabaseInterface $db, string $catId, string $supports)
    {
        $this->db    = $db;
        $this->catId = $catId;
        parent::__construct($supports);
    }

    public function resolve(array $data)
    {
        if ($this->manufacturers === null) {
            $this->loadManufactures();
        }

        $sql    = "select oxcatnid
                    from oxobject2category
                    where oxobjectid = '".$data['OXID']."'
                    order by oxtime;";
        $result = $this->db->select($sql);
        if ($result !== false && $result->count() > 0) {
            while (!$result->EOF) {
                $data = $result->fetchRow();
                if (isset($this->manufacturers[$data['oxcatnid']])) {
                    return $this->manufacturers[$data['oxcatnid']];
                }
            }
        }

        return null;
    }

    protected function loadManufactures()
    {
        $this->manufacturers = [];
        $sql                 = "select oxid, oxtitle 
                             from oxcategories
                             where oxparentid = '".$this->catId."'";
        $result              = $this->db->select($sql);
        if ($result !== false && $result->count() > 0) {
            foreach ($result as $row) {
                $this->manufacturers[$row['oxid']] = $row['oxtitle'];
            }
        }
    }
}
