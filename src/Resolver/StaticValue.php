<?php

namespace IvobaOxid\Exporter\Resolver;

class StaticValue extends BaseResolver
{
    /**
     * @var
     */
    private $value;

    /**
     * StaticValue constructor.
     * @param $value
     * @param string $supports
     */
    public function __construct($value, string $supports)
    {
        $this->value    = $value;
        parent::__construct($supports);
    }

    /**
     * @param array $data
     * @return mixed|null
     */
    public function resolve(array $data)
    {
        return $this->value;
    }
}
