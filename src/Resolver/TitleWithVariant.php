<?php

namespace IvobaOxid\Exporter\Resolver;

class TitleWithVariant extends BaseResolver
{
    /**
     * @param array $data
     * @return string
     */
    public function resolve(array $data): string
    {
        $title = $data['OXTITLE'];
        if ($data['OXVARSELECT'] !== '') {
            $title .= ' '.$data['OXVARSELECT'];
        }

        return $title;
    }

}
