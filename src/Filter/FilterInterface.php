<?php

namespace IvobaOxid\Exporter\Filter;

use IvobaOxid\OxidSiteMap\Entity\Page;

interface FilterInterface
{
    public function filter(Page $page);
}
