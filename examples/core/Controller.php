<?php
namespace core;

class Controller
{
    use View;
    protected $get = null;
    protected $post = null;

    public function __construct()
    {
        $this->get  = $_GET;
        $this->post = $_POST;
    }
}