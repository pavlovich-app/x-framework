<?php

namespace x;

final class Application
{
    private $config = [];
    private $routing = [];

    /**
     * Application constructor.
     * @param array $settings
     */
    public function __construct(array $settings = [])
    {
        $this->config = $settings['config'];
        $this->routing = $settings['routing'];
    }

    public function run(): void
    {
        try {
            echo $this->initRoute($_SERVER['REQUEST_URI']);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param string|null $uri
     * @return string|null
     * @throws \Exception
     */
    private function initRoute(?string $uri = '/'): ?string
    {
        $uri = explode('?', $uri);
        $uri = array_shift($uri);
        if (array_key_exists($uri, $this->routing)) {
            $route = explode(':', $this->routing[$uri]);
            $baseNamespace = $this->config['app_namespace'];

            $controller = $baseNamespace . '\\controllers\\' . ucfirst($route[0]) . 'Controller';

            $action = ($route[1] . 'Action');

            return (new $controller($route))->{$action}();
        }

        throw new \Exception('Page not found', 404);
    }
}