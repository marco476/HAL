<?php
use PHPUnit\Framework\TestCase;
use Components\Request\Request;

class RequestTest extends TestCase
{
    /* ----------------------------------
            getUri METHOD TESTS!
       --------------------------------- */
    public function testGetUri()
    {
        $expect = '/'; //Default value.
        $request = new Request();

        $this->assertEquals($expect, $request->getUri());
    }

    /* -------------------------------------
         getRequestMethod METHOD TESTS!
       ------------------------------------ */
    public function testGetRequestMethod()
    {
        $expect = Request::GET; //Default value.
        $request = new Request();

        $this->assertEquals($expect, $request->getRequestMethod());
    }

    /* ---------------------------------
         parameterInGet METHOD TESTS!
       -------------------------------- */
    public function testParameterInGetNoExist()
    {
        $expect = false;
        $request = new Request();

        $this->assertEquals($expect, $request->parameterInGet('notExist'));
    }

    public function testParameterInGet()
    {
        $key = 'toTest';
        $value = 'myTest';

        $_GET[$key] = $value;
        $expect = $value;
        $request = new Request();

        $this->assertEquals($expect, $request->parameterInGet($key));
    }

    public function testParameterInGetButIsInPost()
    {
        $key = 'toTest';
        $value = 'myTest';

        $_POST[$key] = $value;
        $expect = false;
        $request = new Request();

        $this->assertEquals($expect, $request->parameterInGet($key));
    }

    /* ---------------------------------
         parametersInGet METHOD TESTS!
       -------------------------------- */
    public function testParametersInGetNothingExist()
    {
        $expect = array();
        $request = new Request();
        $result = $request->parametersInGet(array(
            'notExist',
            'notExist2'
        ));

        $this->assertEquals($expect, $result);
    }

    public function testParametersInGetOneExistAndOneNo()
    {
        $keyExist = 'exist';
        $valueExist = 'valueExist';
        $_GET[$keyExist] = $valueExist;

        $expect = array($keyExist => $valueExist);
        $request = new Request();

        $result = $request->parametersInGet(array(
            $keyExist,
            'notExist'
        ));

        $this->assertEquals($expect, $result);
    }

    public function testParametersInGet()
    {
        $keyExist = 'exist';
        $keyExist2 = 'exist2';

        $valueExist = 'valueExist';
        $valueExist2 = 'valueExist2';

        $_GET[$keyExist] = $valueExist;
        $_GET[$keyExist2] = $valueExist2;

        $expect = array(
            $keyExist => $valueExist,
            $keyExist2 => $valueExist2
        );

        $request = new Request();

        $result = $request->parametersInGet(array(
            $keyExist,
            $keyExist2
        ));

        $this->assertEquals($expect, $result);
    }

    /* ---------------------------------
         parameterInPost METHOD TESTS!
       -------------------------------- */
    public function testParameterInPostNoExist()
    {
        $expect = false;
        $request = new Request();

        $this->assertEquals($expect, $request->parameterInPost('notExist'));
    }

    public function testParameterInPost()
    {
        $key = 'toTest';
        $value = 'myTest';

        $_POST[$key] = $value;
        $expect = $value;
        $request = new Request();

        $this->assertEquals($expect, $request->parameterInPost($key));
    }

    public function testParameterInPostButIsInGet()
    {
        $key = 'toTest';
        $value = 'myTest';

        $_GET[$key] = $value;
        $expect = false;
        $request = new Request();

        $this->assertEquals($expect, $request->parameterInPost($key));
    }

    /* ---------------------------------
         parametersInPost METHOD TESTS!
       -------------------------------- */
    public function testParametersInPostNothingExist()
    {
        $expect = array();
        $request = new Request();
        $result = $request->parametersInPost(array(
            'notExist',
            'notExist2'
        ));

        $this->assertEquals($expect, $result);
    }

    public function testParametersInPostOneExistAndOneNo()
    {
        $keyExist = 'exist';
        $valueExist = 'valueExist';
        $_POST[$keyExist] = $valueExist;

        $expect = array($keyExist => $valueExist);
        $request = new Request();

        $result = $request->parametersInPost(array(
            $keyExist,
            'notExist'
        ));

        $this->assertEquals($expect, $result);
    }

    public function testParametersInPost()
    {
        $keyExist = 'exist';
        $keyExist2 = 'exist2';

        $valueExist = 'valueExist';
        $valueExist2 = 'valueExist2';

        $_POST[$keyExist] = $valueExist;
        $_POST[$keyExist2] = $valueExist2;

        $expect = array(
            $keyExist => $valueExist,
            $keyExist2 => $valueExist2
        );

        $request = new Request();

        $result = $request->parametersInPost(array(
            $keyExist,
            $keyExist2
        ));

        $this->assertEquals($expect, $result);
    }
}
