<?php
namespace RavenDB\Client\Http;
use CurlHandle;
use RavenDB\Client\Exceptions\CurlErrException;
use stdClass;

/**
 * Class CurlCommand
 * @package RavenDB\Client\Http
 */
class CurlCommand extends RavenCommand
{
    private stdClass|bool $response;
    private string $url;
    private int $headerCode;

    public function __construct(private ?ServerNode $node = null, private $fullHeader = false) {
        $this->headerCode = false === $this->fullHeader ? 0 :42;

        if(null !== $this->node){
            $this->url = $this->node->getUrl();
        }
    }

    /**
     * Return bool or CurlHandle resource
     * @return stdClass|bool
     */
    public function getResponse(): stdClass|bool {
        return $this->response;
    }

    /**
     * @param string $path
     * @param array $query
     * @return stdClass
     */
    public function createRequest(string $path="", array $query=[]): stdClass {
        $append_query="";
        if( count($query) > 0 ){ $append_query = "?".http_build_query($query); }
        $url = $this->node->getUrl().$path.$append_query;
        $curl_session = curl_init($url);
        curl_setopt($curl_session, CURLOPT_HEADER,$this->headerCode);
        curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl_session);
        curl_close($curl_session);
        return $this->response = json_decode($response);
    }

   public function curlResponseContentType(){
        return $this->getResponse()["content_type"];
   }

   public function curlResponseHttpCode(){
        return $this->getResponse()["http_code"];
   }
}