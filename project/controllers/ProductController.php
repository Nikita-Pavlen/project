<?php


namespace Project\Controllers;

use \Core\Controller;
use Core\Model;
use Project\Models\Product;

class ProductController extends Controller
{
  public $layout = 'product';

  public function showProduct ($params)
  {
    $model = new Product();
    $product = $model->getProduct ($params['id']);

    if (!$product) {
      $this->title = '404 Error';
      $this->layout = 'error';
      $data = ['info' => 'Page Not Found'];
      return $this->render ('error/notFound', $data);
    }

    $this->title = $product['product_name'];
    $img = '<img src="/project/webroot/img/' . strtolower ($product['manufacturer']) . '/full_' . $product['img'] . '.jpg" alt="Изображение товара" class="full__img" hidden>';
    if (!empty($product)) {
      $data = [
        'data' => $this->generatePage ($product),
        'full' => $img,
        'comments' => $this->generateCommentsBlock ($model->getComments ($params['id']), $params['id'])
      ];
      return $this->render ('product/showProduct', $data);
    }
  }

  public function addComment ($params)
  {
    if (isset($_POST['send-comment'])) {
      $model = new Product();
      $date = date ('Y-m-d H:i:s', time ());
      $model->addComment ($date, htmlspecialchars ($_POST['comment']), $params['user'], $params['productId']);
    }

    header ('Location: /product/' . $params['productId']);
    session_write_close ();
    exit();
  }

  private function generatePage ($product)
  {
    $isInCart = '';
    $isInWish = '';
    $inCartValue = 'В корзину';
    $inWishValue = 'В желаемое';

    if ($this->checkCookie ($product['product_name'], 'cartProduct')) {
      $isInCart = ' active__incart';
      $inCartValue = 'Убрать';
    }
    if ($this->checkCookie ($product['product_name'], 'wishProduct')) {
      $isInWish = ' active__inwish';
      $inWishValue = 'Отменить';
    }

    $page = '<div class="product__info">
<div class="img__container">
<img src="/project/webroot/img/' . strtolower ($product['manufacturer']) . '/mid_' . $product['img'] . '.jpg" alt="Изображение товара">
</div>
<div class="information">
<h3>' . $product['product_name'] . '</h3>
<p>Тип прибора: ' . $product['type'] . '</p>
<p>Производитель: ' . $product['manufacturer'] . '</p>
<h4>Описание товара:</h4>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab aliquid assumenda dolorum eaque fuga fugit hic ipsum laboriosam laborum molestias nam nemo pariatur quasi quia quisquam, veritatis voluptatum. Nostrum, repudiandae!</p>
</div>
<div class="btn__price-info">
<h3>' . $product['price'] . ' Р</h3>
<div class="main__btn__container' . $isInCart . '">
<button class="btn main__btn" data-btntype="cart" data-productname="' . $product['product_name'] . '">' . $inCartValue . '</button>
</div>
<div class="side__btn__container' . $isInWish . '">
<button class="btn side__btn" data-btntype="wish" data-productname="' . $product['product_name'] . '">' . $inWishValue . '</button>
</div>
</div>
</div>';

    return $page;
  }

  private function generateCommentsBlock ($comments, $productId)
  {
    $page = '<div class="comments__block">
<h3>Комментарии</h3>';
    if ($comments) {
      foreach ($comments as $comment) {
        $date = date ('d.m.Y H:i', strtotime ($comment['date']));
        $page .= '<div class="comment">
<h4>' . $comment['user'] . '</h4>
<p class="date">' . $date . '</p>
<p>' . $comment['comment'] . '</p>
</div>';
      }
    } else {
      $page .= '<div class="comment">
<p class="empty__comment">Комментариев нет. Станьте первым.</p>
</div>';
    }
    if (isset($_SESSION['auth'])) {
      if ($_SESSION['banned'] == 0) {
        $isDisabled = '';
        $info = '';
      } else {
        $isDisabled = ' disabled';
        $info = 'Вы не можете оставлять комментарии. Вы были забанены администрацией сайта.';
      }
    } else {
      $isDisabled = ' disabled';
      $info = 'Только авторизованные пользователи могут оставлять комментарии. Пожалуйста, авторизуйтесь.';
    }
    $page .= '<div class="comment__form">
<h3>Ваш комментарий</h3>
<form action="/comment/' . $productId . '/' . $_SESSION['user_login'] . '" method="post">
<textarea name="comment" placeholder="Введите текст"' . $isDisabled . '>' . $info . '</textarea>
<input type="submit" id="send-comment" value="Отправить" name="send-comment" hidden>
</form>
</div>
</div>';
    return $page;
  }

  private function checkCookie ($name, $cookieName)
  {
    if (isset($_COOKIE[$cookieName])) {
      $arrCookies = explode (', ', $_COOKIE[$cookieName]);
      if (in_array ($name, $arrCookies)) {
        return true;
      }
    }
    return false;
  }
}