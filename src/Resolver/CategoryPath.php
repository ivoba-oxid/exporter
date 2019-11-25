<?php

namespace IvobaOxid\Exporter\Resolver;

class CategoryPath implements ResolverInterface
{
    private $separator;
    private $mainCategoryIdResolver;
    private $categoryResolver;

    /**
     * CategoryPath constructor.
     * @param MainCategoryId $mainCategoryIdResolver
     * @param Category $catogoryResolver
     * @param string $separator
     */
    public function __construct(
        MainCategoryId $mainCategoryIdResolver,
        Category $categoryResolver,
        string $separator = '>'
    ) {
        $this->separator              = $separator;
        $this->mainCategoryIdResolver = $mainCategoryIdResolver;
        $this->categoryResolver       = $categoryResolver;
    }


    public function supports(): string
    {
        return 'categorypath';
    }

    public function resolve(array $data)
    {
        $categoryId = $this->mainCategoryIdResolver->resolve($data);

        //if child has no maincategory take the parent category
        if (!$categoryId && isset($data['OXPARENTID'])) {
            $parent = ['OXID' => $data['OXPARENTID']];
            $categoryId = $this->mainCategoryIdResolver->resolve($parent);
        }

        if ($categoryId) {
            $path       = [];
            $categories = $this->categoryResolver->loadCategories();
            while ($categoryId != 'oxrootid') {
                if(isset($categories[$categoryId])) {
                    array_unshift($path, $categories[$categoryId]['title']);

                    $categoryId = $categories[$categoryId]['parent'];
                }
                else{
                    break;
                }
            }

            return implode($this->separator, $path);
        }

        return '';
    }
}