<?php

namespace IvobaOxid\Exporter\Resolver;


use OxidEsales\Eshop\Core\Database\Adapter\DatabaseInterface;

class Manufacturer implements ResolverInterface
{

    const OXMANUFACTURERID = 'OXMANUFACTURERID';
    private $db;
    private $manufacturers;

    /**
     * Manufacturer constructor.
     * @param DatabaseProvider $db
     */
    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }


    public function supports(): string
    {
        return 'manufacturer';
    }

    public function resolve(array $data)
    {
        if (is_null($this->manufacturers)) {
            $this->loadManufactures();
        }

        if (isset($data[self::OXMANUFACTURERID]) && $data[self::OXMANUFACTURERID]) {
            return $this->manufacturers[self::OXMANUFACTURERID];
        }

        return '';
    }

    /**
     * @todo this might move to a dedicated loader class
     */
    protected function loadManufactures()
    {
        $this->manufacturers = [];
        $sql                 = "SELECT oxmanufacturers.OXID, oxmanufacturers.OXTITLE FROM oxmanufacturers";
        $result              = $this->db->select($sql);
        if ($result !== false && $result->count() > 0) {
            foreach ($result as $row) {
                $this->manufacturers[$row['OXID']] = $row['OXTITLE'];
            }
        }
    }
}