<?php
namespace RavenDB\Auth;
use RavenDB\Dev\PlaceHolder\AgentOptions;
use RavenDB\Dev\PlaceHolder\Buffer;
use RavenDB\Dev\PlaceHolder\WebSocketClientOptions;
use RavenDB\RavenDBInterface\ICertificate;

class Certificate implements ICertificate
{
    protected const PEM_CERTIFICATE_TYPE="pem";
    protected const PFX_CERTIFICATE_TYPE="pfx";

    protected $_certificate;
    // protected Buffer|string $_certificate; // <-- php8.x only

    public function __construct($_certificate=null)
    {
        if(null !== $_certificate && $_certificate instanceof Buffer){
            $this->_certificate = new Buffer();
        }else{
            $this->_certificate = strval($_certificate) ;
        }
    }

    /**
     * @return string|null
     */
    public function getCertificate()
    {
        return $this->_certificate;
    }

    public function toAgentOptions(): ?AgentOptions
    {
        // TODO: Implement toAgentOptions() method.
    }

    public function toWebSocketOptions(): ?WebSocketClientOptions
    {
        // TODO: Implement toWebSocketOptions() method.
    }


}
