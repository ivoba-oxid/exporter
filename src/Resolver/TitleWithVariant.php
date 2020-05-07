<?php

namespace IvobaOxid\Exporter\Resolver;

use OxidEsales\Eshop\Core\Database\Adapter\DatabaseInterface;

class TitleWithVariant extends BaseResolver
{
    private $db;

    public function __construct(DatabaseInterface $db, string $supports)
    {
        $this->db = $db;
        parent::__construct($supports);
    }

    /**
     * @param array $data
     * @return string
     */
    public function resolve(array $data): string
    {
        $title = $data['OXTITLE'];
        if (!$title && $data['OXPARENTID']) {
            $sql    = 'select oxtitle from oxarticles where oxid = "'.$data['OXPARENTID'].'" limit 1';
            $result = $this->db->select($sql);
            if ($result !== false && $result->count() > 0) {
                $title = $result->fields['oxtitle'];
            }
        }
        if ($data['OXVARSELECT'] !== '') {
            $title .= ' '.$data['OXVARSELECT'];
        }

        return $title;
    }

}
