<?php
namespace RavenDB\Contractor;
interface ConnectorInterface
{
    public const CONFIG_KEY_URL="url";
    public const CONFIG_KEY_USER="username";
    public const CONFIG_KEY_PASSWORD="password";
    public const CONFIG_KEY_CERT="pem";
    public function getConfig():array;
    public function connect();
}