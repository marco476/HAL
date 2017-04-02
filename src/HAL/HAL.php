<?php
namespace HAL;

use Helper\RequestMethodHelper;

class HAL
{
    //Request method processable are GET and POST
    protected $requestMethodProcessable = array(RequestMethodHelper::GET, RequestMethodHelper::POST);
    protected $getVariables = array();
    protected $postVariables = array();

    protected $uri;
    protected $requestMethod;

    public function __construct()
    {
        $this->uri = !empty($_SERVER['REQUEST_URI']) ? strtolower($_SERVER['REQUEST_URI']) : '/';
        $this->requestMethod = !empty($_SERVER['REQUEST_METHOD']) ? strtoupper($_SERVER['REQUEST_METHOD']) : RequestMethodHelper::GET;

        //Insert request method variables into a variable class.
        $this->insertRequestMethodVariables();
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getRequestMethod()
    {
        return $this->requestMethod;
    }

    public function post($name){

    }

    protected function insertRequestMethodVariables(){
        //Only GET and POST are processable!
        if(!in_array($this->requestMethod, $this->requestMethodProcessable)){
            return false;
        }

        $nameVariableClass = $this->requestMethod == RequestMethodHelper::GET ? 'getVariables' : 'postVariables';
        eval("return \$this->\$nameVariableClass = \$_" . $this->requestMethod . ";");
    }
}
