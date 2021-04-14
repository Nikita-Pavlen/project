<?php

namespace Core;
session_start ();

error_reporting (E_ALL);
ini_set ('display_errors', 'on');

require_once $_SERVER['DOCUMENT_ROOT'] . '/project/config/connection.php';

spl_autoload_register (function ($class) {
  $path = preg_replace_callback ('#(\w+)\\\\#', function ($matches) {
    return lcfirst ($matches[1]) . '/';
  }, $class);
  require ($path . '.php');
});

$routes = require $_SERVER['DOCUMENT_ROOT'] . '/project/config/Routes.php';
$track = (new Router)->getTrack ($routes, $_SERVER['REQUEST_URI']);
$page = (new Dispatcher)->getPage ($track);

echo (new View)->render ($page);