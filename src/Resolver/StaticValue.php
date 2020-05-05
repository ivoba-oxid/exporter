<?php

namespace IvobaOxid\Exporter\Resolver;

class StaticValue implements ResolverInterface
{
    private $supports;
    private $value;

    public function __construct(string $supports, $value)
    {
        $this->supports = $supports;
        $this->value    = $value;
    }

    public function supports(): string
    {
        return $this->supports;
    }

    public function resolve(array $data)
    {
        return $this->value;
    }
}
