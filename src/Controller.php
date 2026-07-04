<?php

namespace x;

class Controller
{
    use View;

    protected string $route;

    protected $get = null;
    protected $post = null;

    public function __construct(array $route)
    {
        $this->route = implode(':', $route);

        $this->get = $_GET;
        $this->post = $_POST;
    }
}