<?php

namespace RavenDB\Client\Http;

class ServerNode
{
    private string $url;
    private string $database;
    private string $clusterTag;
    private Role $serverRole;

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getDatabase(): string
    {
        return $this->database;
    }

    public function setDatabase(string $database): void
    {
        $this->database = $database;
    }

    public function getClusterTag(): string
    {
        return $this->clusterTag;
    }

    public function setClusterTag(string $clusterTag): void
    {
        $this->clusterTag = $clusterTag;
    }

    public function getServerRole(): Role
    {
        return $this->serverRole;
    }

    public function setServerRole(Role $serverRole)
    {
        $this->serverRole = $serverRole;
    }

    public function equals(object $o): bool
    {
        if (get_class($this) === get_class($o)) return true;
        if (null === $o || get_class($this) !== get_class($o)) return false;
    }

}