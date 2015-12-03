<?php
namespace Mediasender\Rest;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class RestClient
{
    protected $_apiEnctype;
    protected $_restClient;
    
    public function __construct($apiUser, $apiKey, $apiURL, $apiEnctype)
    {
        $this->_apiEnctype = $apiEnctype;
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
            $response = $this->_restClient->post($apiEndpoint, ['body' => $this->_encodePostDatas($postDatas)]);
            return $this->_responseHandler($response);
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