<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define('ROOT_DIR', __DIR__.'/../');
define('CONFIG_DIR', __DIR__.'/../config/');
define('CONTROLLERS_DIR', __DIR__.'/../controllers/');
define('CORE_DIR', __DIR__.'/../core/');
define('MODELS_DIR', __DIR__.'/../models/');
define('PUBLIC_DIR', __DIR__.'/../public/');
define('VIEWS_DIR', __DIR__.'/../views/');

include_once CORE_DIR.'autoload.php';

$routing = include_once CONFIG_DIR . '/routing.php';

(new x\Application($routing))->run();