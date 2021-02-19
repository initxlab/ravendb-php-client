<?php
namespace RavenDB\Tests\Executor;
interface IEnv
{
    public const URL="http://devtool.infra:9095";
    public const ROUTE_DATABASES="/databases";
    public const QUERY_NAME="name";
}