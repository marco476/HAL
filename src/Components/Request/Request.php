<?php

namespace Components\Request;

/**
 * Class Request
 * @package Components\Request
 */
class Request extends RequestAbstract
{
    /**
     * Request method processable are GET and POST
     *
     * @var array
     */
    protected $requestMethodAccept = array(self::GET, self::POST);

    /**
     * List request headers by client
     *
     * @var array
     */
    protected $headersList = array();

    /**
     * @var null
     */
    protected $uri = null;

    /**
     * @var null
     */
    protected $requestMethod = null;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->uri = !empty($_SERVER['REQUEST_URI']) ? strtolower($_SERVER['REQUEST_URI']) : '/';
        $this->requestMethod = !empty($_SERVER['REQUEST_METHOD']) ? strtoupper($_SERVER['REQUEST_METHOD']) : self::GET;
        $this->headersList = $this->clientHeaders();
    }

    /**
     * @return string|null
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return string|null
     */
    public function getRequestMethod()
    {
        return $this->requestMethod;
    }

    /**
     * Return $name $_GET parameter.
     * If not exist, return false.
     *
     * @param $name
     * @return bool
     */
    public function parameterInGet($name)
    {
        return $this->existParamGet($name) ? $_GET[$name] : false;
    }

    /**
     * Return parameters's array in $_GET.
     * If no one parameters exist in $_GET, return empty array.
     *
     * @param array $params
     * @return array
     */
    public function parametersInGet(array $params)
    {
        $value = array();

        foreach ($params as $param) {
            if ($this->existParamGet($param)) {
                $value[$param] = $_GET[$param];
            }
        }

        return $value;
    }

    /**
     * Return $name $_POST parameter.
     * If not exist, return false.
     *
     * @param $name
     * @return bool
     */
    public function parameterInPost($name)
    {
        return $this->existParamPost($name) ? $_POST[$name] : false;
    }

    /**
     * Return parameters's array in $_POST.
     * If no one parameters exist in $_POST, return empty array.
     *
     * @param array $params
     * @return array
     */
    public function parametersInPost(array $params)
    {
        $value = array();

        foreach ($params as $param) {
            if ($this->existParamPost($param)) {
                $value[$param] = $_POST[$param];
            }
        }

        return $value;
    }

    /**
     * Return $param $_GET or $_POST parameter.
     * If $param is an array, return parameters's array in $_GET or $_POST.
     *
     * @param $param
     * @return array|bool
     */
    public function parameters($param)
    {
        //Only GET and POST are processable!
        if (empty($param) || !in_array($this->requestMethod, $this->requestMethodAccept)) {
            return false;
        }

        return is_array($param) ? $this->multiParameters($param) : $this->singleParameter($param);
    }

    /**
     * Return parameter value or false if not exist.
     * If parameter exist in GET and in POST, return an array with values.
     *
     * @param $name
     * @return array|bool
     */
    protected function singleParameter($name)
    {
        $value = false;
        $existInGet = $this->existParamGet($name);
        $existInPost = $this->existParamPost($name);

        if ($existInGet && $existInPost) {
            //The parameter exist in GET and in POST.

            $value = array(
                self::GET => $_GET[$name],
                self::POST => $_POST[$name]
            );
        } elseif ($existInGet) {
            //The parameter exist in GET.

            $value = $_GET[$name];
        } elseif ($existInPost) {
            //The parameter exist in POST.

            $value = $_POST[$name];
        }

        return $value;
    }

    /**
     * Return array with parameters value or empty array
     * if no parameters exist.
     *
     * @param array $params
     * @return array
     */
    protected function multiParameters(array $params)
    {
        $value = array();

        foreach ($params as $param) {
            $valueParam = $this->singleParameter($param);

            if (!empty($valueParam)) {
                $value[$param] = $valueParam;
            }
        }

        return $value;
    }

    /**
     * Return $name parameter in $_GET.
     * Return false in not exist.
     *
     * @param $name
     * @return bool
     */
    protected function existParamGet($name)
    {
        return isset($_GET[$name]);
    }

    /**
     * Return $name parameter in $_POST.
     * Return false in not exist.
     *
     * @param $name
     * @return bool
     */
    protected function existParamPost($name)
    {
        return isset($_POST[$name]);
    }

    /**
     * http://www.faqs.org/rfcs/rfc3875.html
     * "Meta-variables with names beginning with HTTP_ contain values
     * read from the client request header fields, if the protocol used
     * is HTTP. The HTTP header field name is converted to upper
     * case, has all occurrences of - replaced with _ and has HTTP_
     * prepended to give the meta-variable name."
     *
     * @return array
     */
    protected function clientHeaders()
    {
        $headers = array();

        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) != 'HTTP_') {
                continue;
            }

            $header = strtoupper(str_replace(' ', '-', str_replace('_', ' ', substr($key, 5))));
            $headers[$header] = $value;
        }

        return $headers;
    }

    /**
     * @return array
     */
    public function getHeadersList()
    {
        return $this->headersList;
    }

    /**
     * @param $header
     * @return array|bool|mixed
     */
    public function headers($header)
    {
        if (empty($header)) {
            return false;
        }

        return is_array($header) ? $this->multiHeaders($header) : $this->singleHeader($header);
    }

    /**
     * @param $header
     * @return bool|mixed
     */
    protected function singleHeader($header)
    {
        $header = strtoupper($header);
        return array_key_exists($header, $this->headersList) ? $this->headersList[$header] : false;
    }

    /**
     * @param array $headers
     * @return array
     */
    protected function multiHeaders(array $headers)
    {
        $value = array();

        foreach ($headers as $header) {
            $valueHeader = $this->singleHeader($header);

            if (!empty($valueHeader)) {
                $value[$header] = $valueHeader;
            }
        }

        return $value;
    }

}
