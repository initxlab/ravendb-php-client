<?php

namespace RavenDB\Tests\Client;

use RavenDB\Client\Http\URL;
use RavenDB\Tests\Client\Driver\RavenServerLocator;
use RavenDB\Tests\Client\Util\System;
use RavenDB\Tests\Client\Util\StringUtils;

class TestSecuredServiceLocator extends RavenServerLocator
{
    public static string $ENV_CERTIFICATE_PATH = "RAVENDB_JAVA_TEST_CERTIFICATE_PATH";
    public static string $ENV_TEST_CA_PATH = "RAVENDB_JAVA_TEST_CA_PATH";
    public static string $ENV_HTTPS_SERVER_URL = "RAVENDB_JAVA_TEST_HTTPS_SERVER_URL";

    public function getCommandArguments():array
    {
        $httpsServerUrl = $this->getHttpsServerUrl();
        try {
            $url = new URL($httpsServerUrl);
            $host = $url->getHost();
            $tcpServerUrl = "tcp://" . $host . ":38882";
            return [
                "--Security.Certificate.Path=" . $this->getServerCertificatePath(),
                "--ServerUrl=" . $httpsServerUrl,
                "--ServerUrl.Tcp=" . $tcpServerUrl
            ];
        } catch (MalformedURLException $e) {
            throw new RuntimeException($e);
        }
    }

    private function getHttpsServerUrl(): string
    {
        $httpsServerUrl = System::getenv(self::$ENV_HTTPS_SERVER_URL);
        if (StringUtils::isBlank($httpsServerUrl)) {
            throw new IllegalStateException("Unable to find RavenDB https server url. " .
                "Please make sure " . self::$ENV_HTTPS_SERVER_URL . " environment variable is set and is valid " .
                "(current value = " . $httpsServerUrl . ")");
        }
        return $httpsServerUrl;
    }

    public function getServerCertificatePath(): string
    {
        $certificatePath = System::getenv(self::$ENV_CERTIFICATE_PATH);
        if (StringUtils::isBlank($certificatePath)) {
            throw new IllegalStateException("Unable to find RavenDB server certificate path. " .
                "Please make sure " . self::$ENV_CERTIFICATE_PATH . " environment variable is set and is valid " .
                "(current value = " . $certificatePath . ")");
        }

        return $certificatePath;
    }

    public function getServerCaPath(): string
    {
        return System::getenv(self::$ENV_TEST_CA_PATH);
    }
}
