<?php
namespace RavenDB\Annotation\Registry;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use RavenDB\Annotation\MyAnnotation;
use ReflectionException;

/**
 * Class AnnotationRegistry
 * @package RavenDB\Annotation\AnnotationRegistry
 * Read annotations within Entity in an attempt to return the type to format the data before storing them
 * Example of objects that may request custom formatting : Company, Address, Employee ...
 */
class AnnotationRegistry
{
    private object $object;
    private $formatScope;
    private const ANNOTATION_PROPERTY="dataFormatS";
    private const CLASS_EXISTS_KEYWORD="class_exists";

    /**
     * AnnotationRegistry constructor.
     * @param object $object
     * @throws ReflectionException
     */
    public function __construct(object $object)
    {
        $this->object=$object;

        AnnotationRegistry::registerLoader(self::CLASS_EXISTS_KEYWORD);
        $reflectionClass = new \ReflectionClass(get_class($this->object));

        try {
            $property = $reflectionClass->getProperty(self::ANNOTATION_PROPERTY);
            $reader = new AnnotationReader();
            $myAnnotation = $reader->getPropertyAnnotation($property, MyAnnotation::class);
            $this->formatScope = $myAnnotation->myProperty;
        } catch (ReflectionException $e) {
            /**
             * RAVENDB-TASK: To implement the expected exception message
            */
            $this->formatScope = "Unable to parse data. Unknown scope provided";
        }
    }

    /**
     * @return mixed
     */
    public function getFormatScope(): string
    {
        return $this->formatScope;
    }


}