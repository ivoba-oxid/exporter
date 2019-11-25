<?php

namespace IvobaOxid\Exporter\Resolver;

class TitleWithVariant implements ResolverInterface
{
    public function supports(): string
    {
        return 'oxtitle';
    }

    public function resolve(array $data)
    {
        $title = $data['OXTITLE'];
        if ($data['OXVARSELECT'] !== '') {
            $title .= ' '.$data['OXVARSELECT'];
        }

        return $title;
    }

}