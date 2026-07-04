<?php
namespace core;

trait View
{
    protected $layout = 'layouts:default';
    protected $title = null;

    /**
     * @param string $path
     * @param array $params
     * @return string
     * @throws \Exception
     */
    protected function render(string $path, array $params = []): string
    {
        $page = $this->render_partial($path, $params);
        return $this->render_partial($this->layout, ['page' => $page]);
    }

    /**
     * @param string $path
     * @param array $params
     * @return string
     * @throws \Exception
     */
    protected function render_partial( string $path, array $params = [] ): string
    {
        if (is_array($params) && !empty($params)) {
            extract($params);
        }

        $path = VIEWS_DIR.str_replace(':','/', $path).'.php';

        if(!file_exists($path) ){
            throw new \Exception('File does not exists', 500);
        }

        ob_start();
        include $path;
        return ob_get_clean();
    }


    /**
     * @param string $path
     * @return string
     */
    protected function registerJS(string $path): string
    {
        $path = str_replace(':', '/', $path);
        return "<script src=\"{$path}\"></script>";
    }

    /**
     * @param string $path
     * @return string
     */
    protected function registerCSS(string $path): string
    {
        $path = str_replace(':', '/', $path);
        return "<link rel=\"stylesheet\" href=\"{$path}\">";
    }

    /**
     * @param string $var
     * @return string
     */
    protected function encode( string $var ): string {
        return htmlspecialchars($var);
    }
}