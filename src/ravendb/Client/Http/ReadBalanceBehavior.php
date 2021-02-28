<?php

namespace RavenDB\Client\Http;
class ReadBalanceBehavior
{
    const NONE = "NONE";
    const ROUND_ROBIN = "ROUND_ROBIN";
    const FASTEST_NODE = "FASTEST_NODE";
}