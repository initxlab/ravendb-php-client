<?php

namespace RavenDB\Client\Http;

class ServerNode
{
    public const Role = [
        "NONE",
        "PROMOTABLE",
        "MEMBER",
        "REHAB"
    ];
    private ?string $url=null;
    private ?string $database=null;
    private string $clusterTag;
    /*private Role $serverRole; TODO Mantis#5  MIGRATION Role Class */

    public function __construct()
    {
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getDatabase(): ?string
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
        if (get_class($this) === get_class($o)){
            return true;
        }elseif((null === $o || get_class($this) !== get_class($o)))
            return false;
        else{
            return false;
        }
    }
}