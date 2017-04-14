<?php
use PHPUnit\Framework\TestCase;
use Components\Request\Request;

class RequestTest extends TestCase
{
    /* ----------------------------------
            getUri METHOD TESTS!
       --------------------------------- */
    public function testGetUriNoIstance()
    {
        $expect = null;
        $request = new Request();

        $this->assertEquals($expect, $request->getUri());
    }

    public function testGetUri()
    {
        $expect = '/';
        $request = Request::getIstance();

        $this->assertEquals($expect, $request->getUri());
    }

    /* -------------------------------------
         getRequestMethod METHOD TESTS!
       ------------------------------------ */
    public function testGetRequestMethodNoIstance()
    {
        $expect = null;
        $request = new Request();

        $this->assertEquals($expect, $request->getRequestMethod());
    }

    public function testGetRequestMethod()
    {
        $expect = Request::GET;
        $request = Request::getIstance();

        $this->assertEquals($expect, $request->getRequestMethod());
    }
}
