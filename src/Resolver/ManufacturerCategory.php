<?php

namespace IvobaOxid\Exporter\Resolver;

use OxidEsales\Eshop\Core\Database\Adapter\DatabaseInterface;

class ManufacturerCategory implements ResolverInterface
{
    private $db;
    private $catId;
    private $manufacturers;

    public function __construct(DatabaseInterface $db, string $catId)
    {
        $this->db    = $db;
        $this->catId = $catId;
    }

    public function supports(): string
    {
        return 'manufacturer';
    }

    public function resolve(array $data)
    {
        // TODO: Implement resolve() method.
    }

    /**
     * @todo this might move to a dedicated loader class
     */
    protected function loadManufactures($productId, array $categoriesTitleCache)
    {
        $this->manufacturers = [];
        $sql                 = "select oxcatnid
                                from oxobject2category
                                where oxobjectid = '" . $productId . "'
                                order by oxtime;";
        $result              = $this->db->select($sql);
        if ($result !== false && $result->count() > 0) {
            while (!$result->EOF) {
                $data                               = $result->fetchRow();

//                if (isset($this->manufacturers[$data['oxcatnid']])) {
//                    if ($categoriesTitleCache[$categoriesTitleCache[$row['oxcatnid']]['parentid']]['parentid'] == 'oxrootid'
//                        && $categoriesTitleCache[$categoriesTitleCache[$row['oxcatnid']]['parentid']]['title'] == $categoriesTitleCache[$manufacturerCatID]['title']
//                    ) {
//                        return $categoriesTitleCache[$row['oxcatnid']]['title'];
//                    }
//                }
            }
        }
    }
}