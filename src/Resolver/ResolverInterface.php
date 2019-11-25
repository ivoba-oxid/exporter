<?php

namespace IvobaOxid\Exporter\Resolver;

interface ResolverInterface
{
    public function supports(): string;

    public function resolve(array $data);
}