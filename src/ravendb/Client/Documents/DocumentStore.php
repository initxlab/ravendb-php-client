<?php
namespace RavenDB\Client\Documents;

/**
 * Class DocumentStore
 * @package RavenDB\Client\Documents
 */
class DocumentStore extends DocumentStoreBase
{
    public null|string $identifier;

    /**
     * Constructor
     * @param string|array $urls
     * @param string $database
     */
    public function __construct(string|array $urls,string $database)
    {
        $asUrl = null;
        if(is_string($urls)) { $asUrl = $urls;}

        $urls = $asUrl ?: $urls;
        $this->setUrls($urls);
        $this->setDatabase($database);
    }

    /**
     * @param string|null $identifier
     * @return string|null
     */
    public function setIdentifier(?string $identifier): ?string
    {
        return $this->identifier = $identifier;
    }

    /**
     * @return  string|null
     */
    public function getIdentifier(): ?string
    {
        if(null !== $this->identifier){
            return $this->identifier;
        }
        if (null === $this->urls){
            return null;
        }

        if(null !== $this->database){
            return implode(',',$this->urls)." (DB: ".$this->database.")";
        }

        return implode(',',$this->urls);

    }
}