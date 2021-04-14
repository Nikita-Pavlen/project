<?php


namespace Project\Controllers;

use \Core\Controller;
use \Project\Models\Cart;

class CartController extends Controller
{
  public function cart ()
  {
    $this->title = 'Корзина';
    $this->layout = 'cart';
    $arr = $this->showCart ('cart');
    return $this->render ($arr[0], $arr[1]);
  }

  public function wishlist ()
  {
    $this->title = 'Желаемое';
    $this->layout = 'wishlist';
    $arr = $this->showCart ('wishlist');
    return $this->render ($arr[0], $arr[1]);
  }

  private function showCart ($param)
  {
    if ($param == 'cart') {
      if (isset($_COOKIE['cartProduct'])) {
        $info = $this->generatePage (explode (', ', $_COOKIE['cartProduct']), $param);
      } else {
        $info = '<div class="empty__cart">
<h3>Ваша корзина пуста.</h3>
<a href="/"><button class="btn on-main-page">Вернуться на главную</button></a>
</div>';
      }
    } else {
      if (isset($_COOKIE['wishProduct'])) {
        $info = $this->generatePage (explode (', ', $_COOKIE['wishProduct']), $param);
      } else {
        $info = '<div class="empty__cart">
<h3>Ваш список желаемого пуст.</h3>
<a href="/"><button class="btn on-main-page">Вернуться на главную</button></a>
</div>';
      }
    }
    $data = ['data' => $info];
    return ['cart/showCart', $data];
  }

  private function generatePage ($products, $param)
  {
    $model = new Cart();
    $info = '';
    $totalPrice = 0;
    foreach ($products as $elem) {
      $product = $model->getEvery ($elem);

      if (isset($_COOKIE[str_replace (' ', '_', $product['product_name'])])) {
        $countProducts = $_COOKIE[str_replace (' ', '_', $product['product_name'])];
      } else $countProducts = 1;

      $totalPrice += $product['price'] * $countProducts;
      $info .= '<div class="product" data-productname="' . $product['product_name'] . '">
<div class="icon__container">
<img src="/project/webroot/img/' . strtolower ($product['manufacturer']) . '/icon_' . $product['img'] . '.jpg" alt="Иконка товара">
</div>
<div class="info__container">
<h3>' . $product['product_name'] . '</h3>
<p>Производитель: ' . $product['manufacturer'] . '</p>
<p>Тип прибора: ' . $product['type'] . '</p>
<p>Цена (Шт.): ' . $product['price'] . ' Р</p>
</div>
<div class="btn__container">
<div class="price">
<span class="price__value">' . $product['price'] * $countProducts . '</span> Р
</div>';
      if ($param == 'cart') {
        $info .= '<div class="count__products">
<input type="number" min="1" value="' . $countProducts . '" data-productname="' . $product['product_name'] . '" data-productprice="' . $product['price'] . '"> Шт
</div>';
      }
      $info .= '<button class="btn delete__one" data-productname="' . $product['product_name'] . '" data-productprice="' . $product['price'] . '">Убрать</button>';
      if ($param == 'wishlist') {
        $info .= '<button class="btn add-in-cart" data-productname="' . $product['product_name'] . '" data-productprice="' . $product['price'] . '">В корзину</button>';
      }
      $info .= '</div>
</div>';
    }
    if ($param == 'cart') {
      $info .= '<div class="bottom__btn">
<span class="bottom">Итого к оплате: <span class="total">' . $totalPrice . '</span> Р</span>
<button class="btn bottom delete__all">Очистить</button>
<button class="btn bottom buy">Купить</button>
</div>';
    } else {
      $info .= '<div class="bottom__btn">
<button class="btn bottom delete__all">Убрать все</button>
<button class="btn bottom in-cart-all">Все в корзину</button>
</div>';
    }
    return $info;
  }
}