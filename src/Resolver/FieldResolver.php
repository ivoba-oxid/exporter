<?php

namespace IvobaOxid\Exporter\Resolver;

class FieldResolver extends BaseResolver
{
    /**
     * @var string
     */
    private $field;

    /**
     * FieldResolver constructor.
     * @param $field
     */
    public function __construct(string $field, string $supports)
    {
        $this->field = $field;
        parent::__construct($supports);
    }

    /**
     * @param array $data
     * @return mixed|null
     */
    public function resolve(array $data)
    {
        return $data[$this->field] ?? null;
    }
}
