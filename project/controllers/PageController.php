<?php


namespace Project\Controllers;

use \Core\Controller;
use \Project\Models\Page;


class PageController extends Controller
{
  public $title = 'Главная';

  public function logout ($params)
  {
    unset($_SESSION['auth']);
    unset($_SESSION['banned']);

    header ('Location: ' . str_replace ('@', '/', $params['redir']));
    session_write_close ();
    exit();
  }

  public function test ($params = '')
  {
    $model = new Page();

    if (isset($_SESSION['post']) && !preg_match ('#form#', $_SERVER['REQUEST_URI'])) {
      unset($_SESSION['post']);
    }

    if (isset($_POST['cancel'])) {
      unset($_SESSION['post']);
      header ('Location: /');
      session_write_close ();
      exit();
    }

    if (isset($_POST['enter_filter'])) {
      $_SESSION['post'] = $_POST;
      if ($_SESSION['post']['minPrice'] < 0) {
        $_SESSION['post']['minPrice'] = '';
      }
      if ($_SESSION['post']['maxPrice'] < 0) {
        $_SESSION['post']['maxPrice'] = '';
      }
      if (is_numeric ($_SESSION['post']['minPrice']) && is_numeric ($_SESSION['post']['maxPrice']) && $_SESSION['post']['minPrice'] > $_SESSION['post']['maxPrice']) {
        list($_SESSION['post']['minPrice'], $_SESSION['post']['maxPrice']) = array ($_SESSION['post']['maxPrice'], $_SESSION['post']['minPrice']);
      }
    }

    if (!empty($_SESSION['post'])) {
      $minPrice = $_SESSION['post']['minPrice'];
      $maxPrice = $_SESSION['post']['maxPrice'];
      if (isset($_SESSION['post']['manufacturer'])) {
        $manufacturer = $_SESSION['post']['manufacturer'];
      } else {
        $manufacturer = [];
      }
      if (isset($_SESSION['post']['type'])) {
        $type = $_SESSION['post']['type'];
      } else {
        $type = [];
      }
      $products = $model->getProducts ($minPrice, $maxPrice, $type, $manufacturer);
    } else {
      $products = $model->getProducts ($model->getMinPrice ()['min'], $model->getMaxPrice ()['max']);
    }

    if ((isset($params['num']) && $params['num'] == 1) || empty($params)) {
      $arrPagin = $this->pagination ($products, 1);
    } else if (is_numeric ($params['num'])) {
      $arrPagin = $this->pagination ($products, $params['num']);
    } else {
      $this->title = 'Page Not Found';
      $this->layout = 'error';
      $data = ['info' => 'Page Not Found'];
      return $this->render ('error/notFound', $data);
    }


    $types = $model->getTypes ();
    $manufacturers = $model->getManufacturers ();

    $data = [
      'products' => $arrPagin['show'],
      'types' => $types,
      'manufacturers' => $manufacturers,
      'minPrice' => $model->getMinPrice ()['min'],
      'maxPrice' => $model->getMaxPrice ()['max'],
      'totalProducts' => $arrPagin['totalProducts'],
      'curPage' => $arrPagin['curPage'],
      'showPages' => 2,
    ];

    return $this->render ('page/test', $data);
  }

  private function pagination ($products, $page)
  {
    $productsOnPage = 5;
    $startIndex = ($page - 1) * $productsOnPage;
    $totalProducts = ceil (count ($products) / $productsOnPage);
    $result = [];
    for ($i = $startIndex; $i < $startIndex + $productsOnPage; $i++) {
      if (isset($products[$i])) {
        $result[] = $products[$i];
      }
    }

    return ['show' => $result, 'totalProducts' => $totalProducts, 'curPage' => $page];
  }
}