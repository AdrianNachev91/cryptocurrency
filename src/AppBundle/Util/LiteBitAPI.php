<?php

namespace AppBundle\Util;


use Circle\RestClientBundle\Services\Curl;
use Circle\RestClientBundle\Services\RestClient;

class LiteBitAPI
{
    /** @var string */
    private $litebitURL;
    /** @var string */
    private $litebitVersion;
    /** @var RestClient */
    private $rest;

    /** @var string */
    private $endpoint;

    /**
     * LiteBitAPI constructor.
     * @param string $litebitURL
     * @param string $litebitVersion
     * @param Curl $rest
     */
    public function __construct(string $litebitURL, string $litebitVersion, RestClient $rest)
    {
        $this->litebitURL = $litebitURL;
        $this->litebitVersion = $litebitVersion;
        $this->rest = $rest;
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * @param string $endpoint
     * @return LiteBitAPI
     */
    public function setEndpoint(string $endpoint): LiteBitAPI
    {
        $this->endpoint = $endpoint;
        return $this;
    }

    public function getCurrencyData() {
        $url = $this->litebitURL . '/' . $this->litebitVersion . '/' . $this->endpoint . '/';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $data = curl_exec($curl);

        curl_close($curl);

        return json_decode($data, true);
    }
}