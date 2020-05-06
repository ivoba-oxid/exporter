<?php

namespace IvobaOxid\Exporter\Resolver;

use IvobaOxid\Exporter\Entity\Config;

class Image extends BaseResolver
{
    private $config;
    private $field;
    private $imageKey;

    public function __construct(Config $config, string $supports, string $imageKey = 'OXPIC1')
    {
        $this->config   = $config;
        $this->imageKey = $imageKey;
        parent::__construct($supports);
    }

    public function resolve(array $data)
    {
        if (isset($data[$this->imageKey]) && !empty($data[$this->imageKey])) {
            $image = $data[$this->imageKey];
        }

        if (isset($image)) {
            return $this->config->getShopUrl().$this->config->getImgPath().$image;
        }

        return '';
    }
}
