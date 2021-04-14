<?php


namespace Core;


class Dispatcher
{
  public function getPage (Track $track)
  {
    $className = ucfirst ($track->controller) . 'Controller';
    $fullName = "\\Project\\Controllers\\$className";
    $controller = new $fullName();
    $params = $track->params;
    if (!empty($params)) {
    return $controller->{$track->action}($params);
    } else {
      return $controller->{$track->action}();
    }
  }
}