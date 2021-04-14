<?php


namespace Core;


class Router
{
  public function getTrack ($routes, $uri)
  {
    foreach ($routes as $route) {
      $pattern = $this->getPattern ($route->path);
      //Регулярка просто ищет роут, который совпадает с URI
      if (preg_match ($pattern, $uri, $params)) {
        $params = $this->clearParams ($params);
        return new Track($route->controller, $route->action, $params);
      }
    }
    return new Track('error', 'notFound');
  }

  private function getPattern ($path)
  {
    //Регулярка ищет текст после '/:', этот текст станет названием параметра.
    return '#^' . preg_replace ("#/:([^/]+)#", '/(?<$1>[^/]+)', $path) . '/?$#';
  }

  private function clearParams ($params)
  {
    $result = [];
    foreach ($params as $key => $param) {
      if (!is_numeric ($key)) {
        $result[$key] = $param;
      }
    }
    return $result;
  }
}