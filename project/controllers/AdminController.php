<?php


namespace Project\Controllers;

use \Core\Controller;
use \Project\Models\Admin;

class AdminController extends Controller
{
  public $title = 'Admin Page';
  public $layout = 'admin';

  public function showAdminUsers ()
  {
    if ($this->authCheck ()) {
      $data = ['page' => $this->generateUsersPage ()];
      return $this->render ('admin/showAdmin', $data);
    }
  }

  public function showAdminProducts ()
  {
    if ($this->authCheck ()) {
      $data = ['page' => $this->generateProductsPage ()];
      return $this->render ('admin/showAdmin', $data);
    }
  }

  public function banned ($params)
  {
    if ($this->authCheck ()) {
      $model = new Admin();

      if (isset($params['ban'])) {
        $model->banStatus ($params['ban'], 1);
      } else if (isset($params['unban'])) {
        $model->banStatus ($params['unban'], 0);
      }
      header ('Location: /admin/users');
      session_write_close ();
      exit();
    }
  }

  public function deleteProduct ($params)
  {
    if ($this->authCheck ()) {
      $model = new Admin();
      $model->deleteProductById ($params['delId']);

      header ('Location: /admin/products');
      session_write_close ();
      exit();
    }
  }

  public function addNewProduct ()
  {
    if ($this->authCheck ()) {
      $data = ['page' => $this->generateForm ()];
      return $this->render ('admin/showAdmin', $data);
    }
  }

  private function generateForm ()
  {
    $model = new Admin();
    $types = $model->getProperty ('fixture_type');
    $manufacturers = $model->getProperty ('manufacturer');

    if (isset($_SESSION['adding_access']) && !empty($_SESSION['adding_access'])) {
      $info = $_SESSION['adding_access'];
      unset($_SESSION['adding_access']);
    } else $info = '';

    $productNameValue = '';
    $typeSelected = '';
    $manufacturerSelected = '';
    $productPriceValue = '';
    $productImgValue = '';

    if (isset($_POST['add-new-product'])) {
      if ($model->checkProduct ($_POST['product_name'])) {
        $productNameValue = ' value="' . $_POST['product_name'] . '"';
        $typeSelected = $_POST['product_type'];
        $manufacturerSelected = $_POST['product_manufacturer'];
        $productPriceValue = ' value="' . $_POST['product_price'] . '"';
        $productImgValue = ' value="' . $_POST['product_img'] . '"';
        $info = '<p class="error">Продукт с таким названием уже существует</p>';
      } else {
        $model->addProduct ($_POST);
        $_SESSION['adding_access'] = '<p class="success">Продукт добавлен</p>';
        header ('Location: /admin/addnew');
        session_write_close ();
        exit();
      }
    }

    $page = $info . '<form action="/admin/addnew" method="post" id="add-new-product-form">
<input type="text" name="product_name" placeholder="Название продукта"' . $productNameValue . '>
<select name="product_type">';
    if (empty($typeSelected)) {
      $page .= '<option disabled selected value="">Тип прибора</option>';
    } else $page .= '<option disabled value="">Тип прибора</option>';

    foreach ($types as $type) {
      if ($type['type'] == $typeSelected) {
        $page .= '<option value="' . $type['type'] . '" selected>' . $type['type'] . '</option>';
      } else $page .= '<option value="' . $type['type'] . '">' . $type['type'] . '</option>';
    }
    $page .= '</select>
<select name="product_manufacturer">';
    if (empty($typeSelected)) {
      $page .= '<option disabled selected value="">Производитель</option>';;
    } else $page .= '<option disabled value="">Производитель</option>';

    foreach ($manufacturers as $manufacturer) {
      if ($manufacturer['manufacturer'] == $manufacturerSelected) {
        $page .= '<option value="' . $manufacturer['manufacturer'] . '" selected>' . $manufacturer['manufacturer'] . '</option>';
      } else $page .= '<option value="' . $manufacturer['manufacturer'] . '">' . $manufacturer['manufacturer'] . '</option>';
    }
    $page .= '</select>
<input type="number" name="product_price" min="0" placeholder="Цена"' . $productPriceValue . '>
<input type="number" name="product_img" min="0" placeholder="Номер изображения"' . $productImgValue . '>
<input type="submit" value="Добавить" name="add-new-product" class="submit__btn" disabled>
</form>';

    return $page;
  }

  private function generateProductsPage ()
  {
    $model = new Admin();
    $productsInfo = $model->getProducts ();

    $page = '<div class="table">
<div class="table_row">
<div class="str_title num">ID</div>
<div class="str_title">Название</div>
<div class="str_title">Тип</div>
<div class="str_title">Производитель</div>
<div class="str_title">Цена</div>
<div class="str_title">Номер изображения</div>
<div class="str_title"></div>
</div>';
    foreach ($productsInfo as $product) {
      $page .= '<div class="table_row">
<div class="str_elem num">' . $product['id'] . '</div>
<div class="str_elem">' . $product['product_name'] . '</div>
<div class="str_elem">' . $product['type'] . '</div>
<div class="str_elem">' . $product['manufacturer'] . '</div>
<div class="str_elem">' . $product['price'] . '</div>
<div class="str_elem">' . $product['img'] . '</div>
<div class="str_elem"><a href="/admin/deleteProduct/' . $product['id'] . '" class="ban_status">Удалить</a></div>
</div>';
    }
    $page .= '</div>
      <a href="/admin/addnew" class="admin__btn">
        <div>
          Добавить
        </div>
      </a>';

    return $page;
  }

  private function generateUsersPage ()
  {
    $model = new Admin();
    $usersInfo = $model->getUsers ();

    $page = '<div class="table">
<div class="table_row">
<div class="str_title num">ID</div>
<div class="str_title">Логин</div>
<div class="str_title">Статус</div>
<div class="str_title">Состояние бана</div>
<div class="str_title"></div>
</div>';
    foreach ($usersInfo as $user) {
      $page .= '<div class="table_row">
<div class="str_elem num">' . $user['id'] . '</div>
<div class="str_elem">' . $user['login'] . '</div>
<div class="str_elem">' . $user['status'] . '</div>';
      if ($user['banned'] == 0) {
        $page .= '<div class="str_elem">Не забанен</div>
<div class="str_elem"><a href="/admin/ban/' . $user['id'] . '" class="ban_status">Забанить</a></div>
</div>';
      } else {
        $page .= '<div class="str_elem">Забанен</div>
<div class="str_elem"><a href="/admin/unban/' . $user['id'] . '" class="ban_status">Разбанить</a></div>
</div>';
      }
    }
    $page .= '</div>';

    return $page;
  }

  private function authCheck ()
  {
    if (isset($_SESSION['auth']) && $_SESSION['auth'] == 2 && $_SESSION['banned'] == 0) {
      return true;
    }

    header ('Location: /');
    session_write_close ();
    exit();
  }
}