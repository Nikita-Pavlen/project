<?php


namespace Core;


class View
{
  public function render (Page $page)
  {
    return $this->renderLayout ($page, $this->renderView ($page));
  }

  private function renderLayout (Page $page, $content)
  {
    $pathLayout = $_SERVER['DOCUMENT_ROOT'] . "/project/layouts/{$page->layout}.php";
    ob_start ();
    $title = $page->title;
    include ($pathLayout);
    return ob_get_clean ();
  }

  private function renderView (Page $page)
  {
    $pathView = $_SERVER['DOCUMENT_ROOT'] . "/project/views/{$page->view}.php";
    ob_start ();
    $data = $page->data;
    extract ($data);
    include ($pathView);
    return ob_get_clean ();
  }
}