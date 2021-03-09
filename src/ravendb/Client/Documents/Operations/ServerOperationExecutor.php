<?php


namespace RavenDB\Client\Documents\Operations;

use InvalidArgumentException;
use RavenDB\Client\Documents\DocumentStore;
use RavenDB\Client\Http\ClusterRequestExecutor;
use RavenDB\Client\Http\RequestExecutor;
use RavenDB\Client\Primitives\Closable;
use RavenDB\Client\Serverwide\Operations\IServerOperation;

class ServerOperationExecutor implements Closable
{
    private ?string $_nodeTag = null;
    private DocumentStore $_store;
    private RequestExecutor $_requestExecutor;
    private ?RequestExecutor $_initialRequestExecutor = null;

    public function __construct(?DocumentStore $store = null, ?RequestExecutor $requestExecutor, ?RequestExecutor $initialRequestExecutor = null, ?ServerOperationExecutor $cache = null, ?string $nodeTag = null)
    {
        if (null === $store) {
            throw new InvalidArgumentException("Store cannot be null");
        }

        if (null === $requestExecutor) {
            throw new InvalidArgumentException("RequestExecutor cannot be null");
        }
        $this->_store = $store;
        $this->_requestExecutor = $requestExecutor;
        $this->_initialRequestExecutor = $initialRequestExecutor;
        $this->_nodeTag = $nodeTag;
    }

    /*
     * public void send(IVoidServerOperation operation) {
        VoidRavenCommand command = operation.getCommand(_requestExecutor.getConventions());
        _requestExecutor.execute(command);
        }

     * */
    public function send(IServerOperation|IVoidServerOperation $operation)
    {
        // TODO: CHECK WITH MARCIN IF INTERFACE SHOULD BE CHECKED
        $command = $operation->getCommand($this->_requestExecutor->getConventions());
        $this->_requestExecutor->execute($command);
    }

    public function close()
    {
        // TODO: Implement close() method.
    }
}
