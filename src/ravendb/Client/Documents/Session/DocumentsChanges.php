<?php

namespace RavenDB\Client\Documents\Session;

use RavenDB\Client\Util\StringUtils;

class DocumentsChanges
{
    const ChangeType = [
        "DOCUMENT_DELETED",
        "DOCUMENT_ADDED",
        "FIELD_CHANGED",
        "NEW_FIELD",
        "REMOVED_FIELD",
        "ARRAY_VALUE_CHANGED",
        "ARRAY_VALUE_ADDED",
        "ARRAY_VALUE_REMOVED"
    ];

    private object $fieldOldValue;

    private object $fieldNewValue;

    private string $change;

    private String $fieldName;

    private String $fieldPath;

    public function getFieldOldValue():object {
        return $this->fieldOldValue;
    }

    /**
     * @param object $fieldOldValue
     */
    public function setFieldOldValue(object $fieldOldValue): void
    {
        $this->fieldOldValue = $fieldOldValue;
    }

    /**
     * @return object
     */
    public function getFieldNewValue(): object
    {
        return $this->fieldNewValue;
    }

    /**
     * @param object $fieldNewValue
     */
    public function setFieldNewValue(object $fieldNewValue): void
    {
        $this->fieldNewValue = $fieldNewValue;
    }

    /**
     * @return String
     */
    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    /**
     * @param String $fieldName
     */
    public function setFieldName(string $fieldName): void
    {
        $this->fieldName = $fieldName;
    }

    /**
     * Path of field on which the change occurred.
     * @return String
     */
    public function getFieldPath(): string
    {
        return $this->fieldPath;
    }

    /**
     * fieldPath Path of field on which the change occurred.
     * @param String $fieldPath
     */
    public function setFieldPath(string $fieldPath): void
    {
        $this->fieldPath = $fieldPath;
    }

    /**
     * @return string
     */
    public function getChange(): string
    {
        return $this->change;
    }

    /**
     * @param string $change
     * @throws \Exception
     */
    public function setChange(string $change): void
    {
        if(!in_array($change,self::ChangeType)) throw new \Exception('Invalid Change Type');
        $this->change = self::ChangeType[$change];
    }

    public function getFieldFullName(){
        return StringUtils::isEmpty($this->fieldPath) ? $this->fieldName : $this->fieldPath.".".$this->fieldName;
    }
}
