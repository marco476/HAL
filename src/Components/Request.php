<?php
namespace Components;

class Request extends RequestAbstract
{
    //Request method processable are GET and POST
    protected $requestMethodProcessable = array(self::GET, self::POST);

    protected $uri;
    protected $requestMethod;

    public function __construct()
    {
        $this->uri = !empty($_SERVER['REQUEST_URI']) ? strtolower($_SERVER['REQUEST_URI']) : '/';
        $this->requestMethod = !empty($_SERVER['REQUEST_METHOD']) ? strtoupper($_SERVER['REQUEST_METHOD']) : RequestMethodHelper::GET;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getRequestMethod()
    {
        return $this->requestMethod;
    }

    //Return $name $_GET parameter.
    //If not exist, return false.
    public function parameterInGet($name)
    {
        return $this->existParamGet($name) ? $_GET[$name] : false;
    }

    //Return parameters's array in $_GET.
    //If no one parameters exist in $_GET, return empty array.
    public function parametersInGet(array $params)
    {
        $value = array();

        foreach ($params as $param) {
            if ($this->existParamGet($param)) {
                $value[] = $_GET[$param];
            }
        }

        return $value;
    }

    //Return $name $_POST parameter.
    //If not exist, return false.
    public function parameterInPost($name)
    {
        return $this->existParamPost($name) ? $_POST[$name] : false;
    }

    //Return parameters's array in $_POST.
    //If no one parameters exist in $_POST, return empty array.
    public function parametersInPost(array $params)
    {
        $value = array();

        foreach ($params as $param) {
            if ($this->existParamPost($param)) {
                $value[] = $_POST[$param];
            }
        }

        return $value;
    }

    //Return $param $_GET or $_POST parameter.
    //If $param is an array, return parameters's array in $_GET or $_POST.
    public function parameters($param)
    {
        //Only GET and POST are processable!
        if (empty($param) || !in_array($this->requestMethod, $this->requestMethodProcessable)) {
            return false;
        }

        if (is_array($param)) {
            $value = $this->multiParameters($param);
        } else {
            $value = $this->singleParameter($param);
        }

        return $value;
    }

    protected function singleParameter($name)
    {
        $value = false;

        if ($this->existParamGet($name)) {
            $value = $_GET[$name];
        } elseif ($this->existParamPost($name)) {
            $value = $_POST[$name];
        }

        return $value;
    }

    protected function multiParameters(array $params)
    {
        $value = array();

        foreach ($params as $param) {
            if ($this->existParamGet($param)) {
                $value[] = $_GET[$param];
            } elseif ($this->existParamPost($param)) {
                $value[] = $_POST[$param];
            }
        }

        return $value;
    }

    //Return $name parameter in $_GET.
    //Return false in not exist.
    protected function existParamGet($name)
    {
        return isset($_GET[$name]);
    }

    //Return $name parameter in $_POST.
    //Return false in not exist.
    protected function existParamPost($name)
    {
        return isset($_POST[$name]);
    }
}
