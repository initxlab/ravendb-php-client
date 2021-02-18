<?php
namespace RavenDB\Client\Http;

class Role
{
    private const NONE="NONE";
    private const PROMOTABLE="PROMOTABLE";
    private const MEMBER="MEMBER";
    private const REHAB="REHAB";

    public function getRoleNone(): string {
        return self::NONE;
    }

    public function getPromotable(): string {
        return self::PROMOTABLE;
    }

    public function getMember(): string {
        return self::MEMBER;
    }

    public function getRehab(): string {
        return self::REHAB;
    }

}