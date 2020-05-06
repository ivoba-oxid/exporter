<?php

namespace IvobaOxid\Exporter\Resolver;

class CategoryPath extends BaseResolver
{
    private $separator;
    private $mainCategoryIdResolver;
    private $categoryResolver;

    public function __construct(
        MainCategoryId $mainCategoryIdResolver,
        Category $categoryResolver,
        string $separator = '>',
        string $supports
    ) {
        $this->separator              = $separator;
        $this->mainCategoryIdResolver = $mainCategoryIdResolver;
        $this->categoryResolver       = $categoryResolver;
        parent::__construct($supports);
    }

    public function resolve(array $data)
    {
        $categoryId = $this->mainCategoryIdResolver->resolve($data);

        //if child has no maincategory take the parent category
        if (!$categoryId && isset($data['OXPARENTID'])) {
            $parent     = ['OXID' => $data['OXPARENTID']];
            $categoryId = $this->mainCategoryIdResolver->resolve($parent);
        }

        if ($categoryId) {
            $path       = [];
            $categories = $this->categoryResolver->loadCategories();
            while ($categoryId != 'oxrootid') {
                if (isset($categories[$categoryId])) {
                    array_unshift($path, $categories[$categoryId]['title']);

                    $categoryId = $categories[$categoryId]['parent'];
                } else {
                    break;
                }
            }

            return implode($this->separator, $path);
        }

        return '';
    }
}
