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

    public function testParameterInGetButInPost()
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
}
