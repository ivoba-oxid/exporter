<?php

namespace IvobaOxid\Exporter\Resolver;

use OxidEsales\Eshop\Core\Database\Adapter\DatabaseInterface;

class Category implements ResolverInterface
{

    private $categories;
    private $db;
    private $mainCategoryResolver;

    public function __construct(DatabaseInterface $db, ResolverInterface $mainCategoryResolver)
    {
        $this->db                   = $db;
        $this->mainCategoryResolver = $mainCategoryResolver;
    }

    public function supports(): string
    {
        return 'category';
    }

    public function resolve(array $data)
    {
        if (is_null($this->categories)) {
            $this->loadCategories();
        }

        $catId = $this->mainCategoryResolver->resolve($data);

        if ($catId) {
            if (isset($this->categories[$catId])) {
                return $this->categories[$catId];
            }
        }

        return null;
    }

    public function loadCategories()
    {
        if (is_array($this->categories)) {
            return $this->categories;
        }

        $this->categories = [];
        $sql              = "SELECT OXID, OXTITLE, OXPARENTID FROM oxcategories";
        $result           = $this->db->select($sql);
        if ($result !== false && $result->count() > 0) {
            foreach ($result as $row) {
                $this->categories[$row['OXID']] = [
                    'title'  => $row['OXTITLE'],
                    'parent' => $row['OXPARENTID'],
                ];
            }
        }

        return $this->categories;
    }
}