<?php

namespace IvobaOxid\Exporter\Entity;

class Config
{
    private $file;
    private $shopUrl;
    private $lang;

    private $delimiter = ';';
    private $eol = "\n";
    private $quote = true;
    private $headLine;
    private $fields;
    private $debug = false;

    private $imgPath = '';
    private $netPrices = false;
    private $defaultVat = 19; //german VAT

    /**
     * Config constructor.
     * @param string $file
     * @param string $shopUrl
     * @param int $lang
     */
    public function __construct(string $file, string $shopUrl, int $lang)
    {
        $this->file    = $file;
        $this->shopUrl = $shopUrl;
        $this->lang    = $lang;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @return string
     */
    public function getShopUrl(): string
    {
        return $this->shopUrl;
    }

    /**
     * @return int
     */
    public function getLang(): int
    {
        return $this->lang;
    }

    /**
     * @return string
     */
    public function getDelimiter():string
    {
        return $this->delimiter;
    }

    /**
     * @param string $delimiter
     * @return Config
     */
    public function setDelimiter(string $delimiter)
    {
        $this->delimiter = $delimiter;

        return $this;
    }

    /**
     * @return string
     */
    public function getEol():string
    {
        return $this->eol;
    }

    /**
     * @param string $eol
     * @return Config
     */
    public function setEol(string $eol)
    {
        $this->eol = $eol;

        return $this;
    }

    /**
     * @return bool
     */
    public function getQuote()
    {
        return $this->quote;
    }

    /**
     * @param bool $quote
     * @return Config
     */
    public function setQuote(bool $quote)
    {
        $this->quote = $quote;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHeadLine():?string
    {
        return $this->headLine;
    }

    /**
     * @param string $headLine
     * @return Config
     */
    public function setHeadLine(string $headLine)
    {
        $this->headLine = $headLine;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param mixed $fields
     * @return Config
     */
    public function setFields($fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @return bool
     */
    public function getDebug():bool
    {
        return $this->debug;
    }

    /**
     * @param bool $debug
     * @return Config
     */
    public function setDebug(bool $debug)
    {
        $this->debug = $debug;

        return $this;
    }

    /**
     * @return bool
     */
    public function getNetPrices(): bool
    {
        return $this->netPrices;
    }

    /**
     * @param bool $netPrices
     * @return $this
     */
    public function setNetPrices(bool $netPrices)
    {
        $this->netPrices = $netPrices;

        return $this;
    }

    /**
     * @return float
     */
    public function getDefaultVat(): float
    {
        return $this->defaultVat;
    }

    /**
     * @param float $defaultVat
     * @return $this
     */
    public function setDefaultVat(float $defaultVat)
    {
        $this->defaultVat = $defaultVat;

        return $this;
    }

    /**
     * @return string
     */
    public function getImgPath(): string
    {
        return $this->imgPath;
    }

    /**
     * @param string $imgPath
     * @return Config
     */
    public function setImgPath(string $imgPath): Config
    {
        $this->imgPath = $imgPath;

        return $this;
    }


//'export_parents' => 0,               // Should parents be shown in file !!!not available
//'export_children' => true,               // Should export artice with children article
//'filename' => '../../../../../export/lionshome.csv', // Export filename relative to this file (for local test)
//'limit' => 500,             // limit for export !!!not available
//'debug' => false,           // enable / disable debug-output
//'silent' => false,            // enable / disable regular messages
//'header' => true,            // enable / disable headerline
//'langid' => 0,               // LanguageId for which you want to export
//'shippingcost' => array(           //shipping cost categories
//array('from' => 0, 'cost' => 4.9)
//),
//'shippingcost_at' => array(           //shipping cost categories
//array('from' => 0, 'cost' => 8.5)
//),/**/
//'productLinkPrefix' => '/index.php?cl=details&anid=',       //standard product url prefix
//'googleProductLinkParameters' => 'utm_source=lionshome', //google parameters for product
//'imageurl' => '/out/pictures/generated/product/1/380_340_75/', //standard image url path
//'condition' => 'neu',                               //condition always new product
//'inStock' => true,                         //product in stock description
//'outOfStock' => false,                   //product out of stock description
//'cutFirstPosArticlenumber' => 0,                                   // cut the first n position from the article number
//'generalVat' => 19,                                  // general vat value for net prices
//'netPrices' => false,                                // net prices true/false
//'categoryPathSeparator' => '-',
//'quote' => true
}