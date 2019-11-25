<?php

namespace IvobaOxid\Exporter\Query;

class Products implements QueryInterface
{
    private $parentProducts;
    private $childProducts;

    /**
     * Products constructor.
     * @param $parentProducts
     * @param $childProducts
     */
    public function __construct(ParentProducts $parentProducts, ChildProducts $childProducts)
    {
        $this->parentProducts = $parentProducts;
        $this->childProducts  = $childProducts;
    }

    public function get(array $context = [])
    {
        $all     = [];
        $parents = $this->parentProducts->get();

        foreach ($parents as $parent) {
            if ($parent['OXVARNAME'] === '') {
                $all[] = $parent;
            } else {
                $children = $this->childProducts->get($parent);
                foreach ($children as $child) {
                    $all[] = $child;
                }
            }
        }

        return $all;
    }
}