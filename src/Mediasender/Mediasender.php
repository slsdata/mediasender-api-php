<?php
namespace Mediasender;

require_once 'defines/constantes.php';

use Mediasender\Rest\RestClient;

class Mediasender
{
    protected static $_apiURL = "api.media-sender.com";
    protected static $_apiVersion = "v1";
    protected static $_apiSSL = true;
    protected static $_apiForceUTF8 = false;
    
    private $_apiEnctype = "json";
    private $_apiUser;
    protected $_restClient;
    
    public function __construct($params = array())
    {
        $this->_apiUser = (isset($params["api_user"])) ? $params["api_user"] : null;
        $apiKey = (isset($params["api_password"])) ? $params["api_password"] : null;
        $this->_apiEnctype = (isset($params["api_enctype"]) && in_array($params["api_enctype"], array("json", "xml"))) ? $params["api_enctype"] : $this->_apiEnctype;
        $apiURL = (isset($params["api_url"])) ? $params["api_url"] : self::$_apiURL;
        $apiVersion = (isset($params["api_version"])) ? $params["api_version"] : self::$_apiVersion;
        $apiSSL = (isset($params["api_ssl"])) ? $params["api_ssl"] : self::$_apiSSL;
        $apiForceUTF8 = (isset($params["api_force_utf8"])) ? $params["api_force_utf8"] : self::$_apiForceUTF8;
        
        $this->_restClient = new RestClient($this->_apiUser, $apiKey, $this->_generateFullURL($apiURL, $apiVersion, $apiSSL), $this->_apiEnctype, $apiForceUTF8);
    }
    
    /*******************************************************/
    /*******************************************************/
    /*****                   BASES                     *****/
    /*******************************************************/
    /*******************************************************/
    
    public function get_bases($getParams = array())
    {
        return $this->_restClient->get("base", $getParams);
    }
    
    public function get_base($id)
    {
        return $this->_restClient->get("base/".$id);
    }
    
    public function add_base($postDatas = array())
    {
        return $this->_restClient->post("base", $postDatas);
    }
    
    public function update_base($id, $putDatas = array())
    {
        return $this->_restClient->put("base/".$id, $putDatas);
    }
    
    /*******************************************************/
    /*******************************************************/
    /*****                 CAMPAIGNS                   *****/
    /*******************************************************/
    /*******************************************************/
    
    public function get_campaigns($getParams = array())
    {
        return $this->_restClient->get("campaign", $getParams);
    }
    
    public function get_campaign($id)
    {
        return $this->_restClient->get("campaign/".$id);
    }
    
    public function update_campaign($id, $putDatas = array())
    {
        return $this->_restClient->put("campaign/".$id, $putDatas);
    }
    
    /*******************************************************/
    /*******************************************************/
    /*****                 CUSTOMERS                   *****/
    /*******************************************************/
    /*******************************************************/
    
    public function get_customers($getParams = array())
    {
        return $this->_restClient->get("customer", $getParams);
    }
    
    public function get_customer($id)
    {
        return $this->_restClient->get("customer/".$id);
    }
    
    public function add_customer($postDatas = array())
    {
        return $this->_restClient->post("customer", $postDatas);
    }
    
    public function update_customer($id, $putDatas = array())
    {
        return $this->_restClient->put("customer/".$id, $putDatas);
    }
    
    /*******************************************************/
    /*******************************************************/
    /*****                  CONTACTS                   *****/
    /*******************************************************/
    /*******************************************************/
    
    public function get_contacts($getParams = array())
    {
        return $this->_restClient->get("contact", $getParams);
    }
    
    public function get_contact($id, $getParams = array())
    {
        return $this->_restClient->get("contact/".$id, $getParams);
    }
    
    public function add_contact($postDatas = array())
    {
        return $this->_restClient->post("contact", $postDatas);
    }
    
    public function addupdate_contact($postDatas = array())
    {
        $postDatas["request"] = "insertupdate";
        return $this->_restClient->post("contact", $postDatas);
    }
    
    public function update_contact($id, $putDatas = array())
    {
        return $this->_restClient->put("contact/".$id, $putDatas);
    }
    
    /*******************************************************/
    /*******************************************************/
    /*****                  SENDINGS                   *****/
    /*******************************************************/
    /*******************************************************/
    
    public function get_sendings($getParams = array())
    {
        return $this->_restClient->get("sending", $getParams);
    }
    
    public function get_sending($id)
    {
        return $this->_restClient->get("sending/".$id);
    }
    
    public function update_sending($id, $putDatas = array())
    {
        return $this->_restClient->put("sending/".$id, $putDatas);
    }
    
    /*******************************************************/
    /*******************************************************/
    /*****                   HISTORY                   *****/
    /*******************************************************/
    /*******************************************************/
    
    public function get_historycampaign($getParams = array())
    {
        return $this->_restClient->get("history/campaign", $getParams);
    }
    
    public function get_historycontact($getParams = array())
    {
        return $this->_restClient->get("history/contact", $getParams);
    }
    
    public function get_historysending($getParams = array())
    {
        return $this->_restClient->get("history/sending", $getParams);
    }
    
    public function get_historythematic($getParams = array())
    {
        return $this->_restClient->get("history/thematic", $getParams);
    }
    
    /*******************************************************/
    /*******************************************************/
    /*****                  THEMATICS                  *****/
    /*******************************************************/
    /*******************************************************/
    
    public function get_thematics($getParams = array())
    {
        return $this->_restClient->get("thematic", $getParams);
    }
    
    public function get_thematic($id)
    {
        return $this->_restClient->get("thematic/".$id);
    }
    
    public function add_thematic($postDatas = array())
    {
        return $this->_restClient->post("thematic", $postDatas);
    }
    
    public function update_thematic($id, $putDatas = array())
    {
        return $this->_restClient->put("thematic/".$id, $putDatas);
    }
    
    /*******************************************************/
    /*******************************************************/
    /*****               OTHERS METHODS                *****/
    /*******************************************************/
    /*******************************************************/
    
    public function test_login()
    {
        $response = $this->_restClient->get("test");
        if(isset($response->http_response_code) && $response->http_response_code == 200){
            return 'Hello "'.$this->_apiUser.'", login successfull !';
        }else{
            return 'Hello "'.$this->_apiUser.'", login fail !';
        }
    }
    
    private function _generateFullURL($apiURL, $apiVersion, $apiSSL)
    {
        if(!$apiSSL){
            return "http://".$apiURL."/".$apiVersion."/";
        }else{
            return "https://".$apiURL."/".$apiVersion."/";
        }
    }
}