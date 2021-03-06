<?php

namespace IvobaOxid\Exporter\Resolver;

use IvobaOxid\Exporter\Entity\Config;
use OxidEsales\Eshop\Core\Database\Adapter\DatabaseInterface;

class Url extends BaseResolver
{
    private $config;
    private $db;
    private $mainCategoryIdResolver;
    private $nonSeoUrl;

    /**
     * Url constructor.
     * @param Config $config
     * @param DatabaseInterface $db
     * @param MainCategoryId $mainCategoryIdResolver
     * @param string $supports
     * @param string $nonSeourl
     */
    public function __construct(
        Config $config,
        DatabaseInterface $db,
        MainCategoryId $mainCategoryIdResolver,
        string $supports,
        string $nonSeourl = '/index.php?cl=details&anid='
    ) {
        $this->config                 = $config;
        $this->db                     = $db;
        $this->mainCategoryIdResolver = $mainCategoryIdResolver;
        $this->nonSeoUrl              = $nonSeourl;
        parent::__construct($supports);
    }

    public function resolve(array $data)
    {
        $oxid = $data['OXID'];

        $categoryId = $this->mainCategoryIdResolver->resolve($data);

        //if child has no maincategory take the parent category
        if (!$categoryId && isset($data['OXPARENTID'])) {
            $parent     = ['OXID' => $data['OXPARENTID']];
            $categoryId = $this->mainCategoryIdResolver->resolve($parent);
        }

        if ($categoryId) {
            $sql    = "SELECT OXSEOURL
                    FROM oxseo
                    WHERE OXOBJECTID = '".$oxid."' 
                    AND OXPARAMS = '".$categoryId."' 
                    AND OXLANG = ".$this->config->getLang();
            $result = $this->db->select($sql);
            if ($result !== false && $result->count() > 0) {
                $row = $result->getFields();

                return $this->config->getShopUrl().'/'.$row['OXSEOURL'];
            }
        }

        return $this->config->getShopUrl().$this->nonSeoUrl.$oxid;
    }

}
