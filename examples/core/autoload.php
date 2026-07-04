<?php
/**
 * @param $classname
 * @throws Exception
 */
spl_autoload_register(function($classname){
    $filename = ROOT_DIR.str_replace('\\', '/', $classname).".php";
    include_once($filename);
});
