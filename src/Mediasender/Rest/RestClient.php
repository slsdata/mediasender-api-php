<?php
namespace Mediasender\Rest;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use ForceUTF8\Encoding;

class RestClient
{
    protected $_apiEnctype;
    protected $_restClient;
    protected $_forceUTF8;
    
    public function __construct($apiUser, $apiKey, $apiURL, $apiEnctype, $apiForceUTF8)
    {
        $this->_apiEnctype = $apiEnctype;
        $this->_forceUTF8 = $apiForceUTF8;
        $this->_restClient = new Client([
            'base_url' => $apiURL,
            'defaults' => [
                'headers' => [
                    'Content-Type' => 'application/'.$this->_apiEnctype,
                    'Accept' => 'application/'.$this->_apiEnctype,
                    'User-Agent' => SDK_USER_AGENT.'/'.SDK_VERSION.';php'
                ],
                'config' => [
                    'curl' => [
                        CURLOPT_FORBID_REUSE => true
                    ]
                ],
                'auth' => [$apiUser, $apiKey, 'digest'],
                'exceptions' => false
            ]
        ]);
    }
    
    public function post($apiEndpoint, $postDatas = array())
    {
        try {
            if(($encodedDatas = $this->_encodePostDatas($postDatas)) !== false){
                $response = $this->_restClient->post($apiEndpoint, ['body' => $encodedDatas]);
                return $this->_responseHandler($response);
            }else{
                return $this->_errorEncodage();
            }
        }catch(RequestException $e){
            return $this->_errorHandler($e);
        }
    }
    
    public function get($apiEndpoint, $getParams = array())
    {
        try {
            $response = $this->_restClient->get($apiEndpoint, ['query' => $getParams]);
            return $this->_responseHandler($response);
        }catch(RequestException $e){
            return $this->_errorHandler($e);
        }
    }
    
    public function delete($apiEndpoint)
    {
        try {
            $response = $this->_restClient->delete($apiEndpoint);
            return $this->_responseHandler($response);
        }catch(RequestException $e){
            return $this->_errorHandler($e);
        }
    }
    
    public function put($apiEndpoint, $putDatas = array())
    {
        try {
            $response = $this->_restClient->put($apiEndpoint, ['body' => $this->_encodePostDatas($putDatas)]);
            return $this->_responseHandler($response);
        }catch(RequestException $e){
            return $this->_errorHandler($e);
        }
    }
    
    private function _responseHandler($response)
    {
        $result = new \stdClass();
        $result->http_response_code = $response->getStatusCode();
        $result->http_response_body = (string)$response->getBody();
        return $result;
    }
    
    private function _errorEncodage()
    {
        $result = new \stdClass();
        $result->http_response_code = "5.0.0";
        $result->http_response_body = "Encodage error";
        return $result;
    }
    
    private function _errorHandler($exception)
    {
        $result = new \stdClass();
        $result->http_error_request = $exception->getRequest();
        if($exception->hasResponse()){
            $result->http_error_response = (string)$exception->getResponse();
        }
        return $result;
    }
    
    private function _encodePostDatas($datas)
    {
        if($this->_forceUTF8){
            $datas = $this->_encodeUTF8($datas);
        }
        
        switch($this->_apiEnctype){
            case "json":
                $datas = json_encode($datas);
                break;
            case "xml":
                $datas = $this->_array2xml($datas);
                break;
        }
        return $datas;
    }
    
    private function _encodeUTF8($datas)
    {
        array_walk_recursive($datas, function(&$item){
            if(!mb_detect_encoding($item, 'UTF-8', true)){
                $item = utf8_encode($item);
                //$item = Encoding::fixUTF8($item);
            }
        });
        return $datas;
    }
    
    private function _array2xml($array)
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><request></request>');
        foreach($array as $key => $value){
            if(is_array($value)){
                $subnode = $xml->addChild("$key");
                array_to_xml($value, $subnode);
            }else{
                $xml->addChild("$key", htmlspecialchars("$value"));
            }
        }
        return $xml->asXML();
    }
}