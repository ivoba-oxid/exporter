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

    public function __construct(DatabaseInterface $db, string $catId, string $supports)
    {
        $this->db    = $db;
        $this->catId = $catId;
        parent::__construct($supports);
    }

    public function resolve(array $data)
    {
        // if variant use parentId
        $id = $data['OXID'];
        if ($data['OXPARENTID']) {
            $id = $data['OXPARENTID'];
        }

        $sql    = "select oxcategories.oxtitle
                    from oxobject2category, oxcategories
                    where oxobject2category.oxobjectid = '".$id."'
                    and oxcategories.oxid = oxobject2category.oxcatnid
                    and oxcategories.oxparentid = '".$this->catId."';";
        $result = $this->db->select($sql);
        if ($result !== false && $result->count() > 0) {
            while (!$result->EOF) {
                return $result->fields['oxtitle'];
            }
        }

        return null;
    }
}
