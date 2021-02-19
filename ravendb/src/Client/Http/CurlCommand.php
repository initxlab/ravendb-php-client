<?php
namespace RavenDB\Client\Http;
use CurlHandle;
use RavenDB\Client\Exceptions\CurlErrException;

/**
 * Class CurlCommand
 * @package RavenDB\Client\Http
 */
class CurlCommand extends RavenCommand
{
    private CurlHandle|bool $response;
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
     * @return CurlHandle|bool
     */
    public function getResponse(): CurlHandle|bool {
        return $this->response;
    }

    /**
     * @param string $path
     * @param array $query
     * @return CurlHandle|bool
     */
    public function createRequest($path="", array $query=[]): CurlHandle|bool {
        $append_query="";
        if( count($query) > 0 ){ $append_query = "?".http_build_query($query); }

        $curl_session = curl_init($this->node->getUrl().$path.$append_query);
        curl_setopt($curl_session, CURLOPT_HEADER,$this->headerCode);
        curl_exec($curl_session);
        curl_close($curl_session);
        return $this->response = $curl_session;
    }

   public function curlPutData(array $data=[],string $path=""): bool|string
   {
       $ch = curl_init($this->node->getUrl().$path."?".http_build_query($data));
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
       curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
       $response = curl_exec($ch);
       if (!$response) {
           return false;
       }
       return "success";
   }

   public function curlResponseContentType(){
        return $this->getResponse()["content_type"];
   }

   public function curlResponseHttpCode(){
        return $this->getResponse()["http_code"];
   }
}