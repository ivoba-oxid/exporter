<?php

namespace IvobaOxid\Exporter\Entity;

class Config
{
    private $file;
    private $shopUrl;
    private $lang;

    private $delimiter = ';';
    private $eol = "\r";
    private $quote = true;
    private $fields;
    private $debug = false;
    private $printHeader = true;

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
    public function getDelimiter(): string
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
    public function getEol(): string
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
     * @return bool
     */
    public function getPrintHeader(): bool
    {
        return $this->printHeader;
    }

    /**
     * @param bool $printHeader
     * @return $this
     */
    public function setPrintHeader(bool $printHeader)
    {
        $this->printHeader = $printHeader;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getFields(): ?array
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @return bool
     */
    public function getDebug(): bool
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
}
