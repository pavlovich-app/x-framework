<?php

namespace core;

final class Application
{
    private $routing = [];

    /**
     * Application constructor.
     * @param array $routing
     */
    public function __construct( array $routing = [] )
    {
        $this->routing = $routing;
    }

    public function run(): void
    {
        try{
             echo $this->initRoute( $_SERVER['REQUEST_URI'] ) ;
        }catch(\Exception $e){
            echo $e->getMessage();
        }
    }

    /**
     * @param string|null $uri
     * @return string|null
     * @throws \Exception
     */
    private function initRoute( ?string $uri = '/' ): ?string
    {
        $uri = explode('?', $uri);
        $uri = array_shift($uri);
        if( array_key_exists($uri, $this->routing) ){
            $route = explode(':', $this->routing[$uri]);

            $controller = ('\\controllers\\'.ucfirst($route[0]).'Controller');
            $action     = ($route[1].'Action');

            return (new $controller())->{$action}();
        }

        throw new \Exception('Page not found', 404);
    }
}