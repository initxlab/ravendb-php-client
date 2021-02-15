<?php
namespace RavenDB\Connector;
use RavenDB\Contractor\ConnectorInterface;

class CurlConnector implements ConnectorInterface
{
    private array $config;

    public function __construct($config=[])
    {
        $this->config = $config;
    }

    public function getConfig(): array
    {
       return $this->config;
    }

    public function connect(){
        if(! array_key_exists(self::CONFIG_KEY_URL, $this->getConfig())){
            return "You have to define and url key and value in your config";
        }
        return curl_init();
    }

    public function startSession(){
        $initSession = $this->connect();
        curl_setopt($initSession,CURLOPT_URL,$this->getConfig()[self::CONFIG_KEY_URL]);
        curl_setopt($initSession,CURLOPT_HEADER,0);
        curl_exec($initSession);
        curl_close($initSession);
        return $initSession;
    }

}