<?php

namespace RavenDB\Tests\Client\CrudEntities;

class FamilyMembers
{
    private array $members;

    public function getMembers(): array   {
        return $this->members;
    }

    public function setMembers(array $members): void {
        $this->members = $members;
    }
}
