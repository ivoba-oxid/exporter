<?php

namespace IvobaOxid\Exporter\Query;

interface QueryInterface
{
    /**
     * @param array $context
     * @return mixed
     */
    public function get(array $context = []);
}
