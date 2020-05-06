<?php

namespace IvobaOxid\Exporter\Resolver;

class BaseResolver implements ResolverInterface
{
    /**
     * @var string
     */
    protected $supports;

    /**
     * BaseResolver constructor.
     * @param string $supports
     */
    public function __construct(string $supports)
    {
        $this->supports = $supports;
    }

    /**
     * @return string
     */
    public function supports(): string
    {
        return $this->supports;
    }

    /**
     * @param array $data
     * @return mixed|null
     */
    public function resolve(array $data)
    {
        return $data[$this->supports] ?? null;
    }
}
