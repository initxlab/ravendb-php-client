<?php
namespace RavenDB\RavenDBInterface;
use RavenDB\Dev\PlaceHolder\AgentOptions;
use RavenDB\Dev\PlaceHolder\WebSocketClientOptions;

interface ICertificate
{
    public function toAgentOptions():?AgentOptions;
    public function toWebSocketOptions():?WebSocketClientOptions;
}