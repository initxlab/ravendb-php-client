<?php

namespace RavenDB\Client\Documents\Session;
use Doctrine\Common\Collections\ArrayCollection;

class DocumentsByEntityHolder
{
    private ArrayCollection $_documentsByEntity;
    private ArrayCollection $_onBeforeStoreDocumentsByEntity;
    private bool $_prepareEntitiesPuts;

    public function size():int{
        return $this->_documentsByEntity->count() + (null !== $this->_onBeforeStoreDocumentsByEntity ? count($this->_onBeforeStoreDocumentsByEntity) : 0);
    }

    /**
     * @throws \Exception
     */
    public function evict($entity):void {
        if($this->_prepareEntitiesPuts) throw new \Exception("Cannot Evict entity during OnBeforeStore");
        $this->_documentsByEntity->remove($entity);
    }

    public function put(object $entity, DocumentInfo $documentInfo):void {
        if(!$this->_prepareEntitiesPuts){
            $this->_documentsByEntity->set($entity,$documentInfo);
            return;
        }
        $this->createOnBeforeStoreDocumentsByEntityIfNeeded();
        $this->_onBeforeStoreDocumentsByEntity->set($entity,$documentInfo);
    }

    private function createOnBeforeStoreDocumentsByEntityIfNeeded():void{
        if(null !== $this->_onBeforeStoreDocumentsByEntity){
            return;
        }
        $this->_onBeforeStoreDocumentsByEntity = new ArrayCollection();
    }
    public function prepareEntitiesPuts(){
        $this->_prepareEntitiesPuts = true;
    }

    public function clear():void {
        $this->_documentsByEntity->clear();
        if(null !== $this->_onBeforeStoreDocumentsByEntity) $this->_onBeforeStoreDocumentsByEntity->clear();
    }

    public function get(object $entity):DocumentInfo{
        $documentInfo = $this->_documentsByEntity->get($entity);
        if(null !== $documentInfo){
            return $documentInfo;
        }
        if(null !== $this->_onBeforeStoreDocumentsByEntity){
            return $this->_onBeforeStoreDocumentsByEntity->get($entity);
        }
    }

    /**
     * @throws \Exception
     * TODO CHECK WITH TECH IF THIS IS CLOSURE TYPE OF IMPLEMENTATION IN JAVA
     */
    public function iterator(): ArrayCollection {
        $firstIterator = $this->_documentsByEntity->getIterator();
        $secondIterator = $this->_documentsByEntity;
        $firstIteratorFunc = function () use ($firstIterator){
        };

        $secondIterator = $this->_documentsByEntity;
        $secondIteratorFunc = function () use ($secondIterator){
        };
    }

}
/*TODO : CHECK THE LEFT METHODS WITH TECH SUPPORT*/
/*
 *  @Override
        public Iterator<DocumentsByEntityEnumeratorResult> iterator() {
            Iterator<DocumentsByEntityEnumeratorResult> firstIterator
                    = Iterators.transform(_documentsByEntity.entrySet().iterator(),
                        x -> new DocumentsByEntityEnumeratorResult(x.getKey(), x.getValue(), true));

            if (_onBeforeStoreDocumentsByEntity == null) {
                return firstIterator;
            }

            Iterator<DocumentsByEntityEnumeratorResult> secondIterator
                    = Iterators.transform(_onBeforeStoreDocumentsByEntity.entrySet().iterator(),
                        x -> new DocumentsByEntityEnumeratorResult(x.getKey(), x.getValue(), false));

            return Iterators.concat(firstIterator, secondIterator);
        }

        @Override
        public Spliterator<DocumentsByEntityEnumeratorResult> spliterator() {
            return Spliterators.spliterator(iterator(), size(), Spliterator.ORDERED);
        }

*/