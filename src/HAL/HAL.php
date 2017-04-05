<?php
namespace HAL;

use Components\Request;

class HAL
{
    public $request;

    public function __construct()
    {
        $this->request = new Request();
    }
}
