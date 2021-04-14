<?php


namespace Project\Controllers;


use \Core\Controller;

class ErrorController extends Controller
{
  public $title = '404 Error';
  public $layout = 'error';

  public function notFound ()
  {
    $data = ['info' => 'Page Not Found'];
    return $this->render ('error/notFound', $data);
  }
}