<?php


namespace Project\Models;

use \Core\Model;

class Admin extends Model
{
  public function getUsers ()
  {
    $query = "SELECT users.id, users.login, users.banned, statuses.statusName as status FROM users
LEFT JOIN statuses ON users.status=statuses.id";
    $result = mysqli_query (self::$link, $query);

    for ($data = []; $elem = mysqli_fetch_assoc ($result); $data[] = $elem) ;

    return $data;
  }

  public function getProducts ()
  {
    $query = "SELECT products.id, products.product_name, products.price, products.img, fixture_type.type, manufacturer.manufacturer FROM products 
LEFT JOIN manufacturer ON products.manufacturer_id=manufacturer.id
LEFT JOIN fixture_type ON products.type_id=fixture_type.id";
    $result = mysqli_query (self::$link, $query);

    for ($data = []; $elem = mysqli_fetch_assoc ($result); $data[] = $elem) ;

    return $data;
  }

  public function banStatus ($id, $value)
  {
    $query = "UPDATE users SET banned='$value' WHERE id=$id";
    mysqli_query (self::$link, $query);
  }

  public function getProperty ($name)
  {
    $query = "SELECT * FROM $name";
    $result = mysqli_query (self::$link, $query);

    for ($data = []; $elem = mysqli_fetch_assoc ($result); $data[] = $elem) ;

    return $data;
  }

  public function checkProduct ($name)
  {
    $query = "SELECT product_name FROM products WHERE product_name='$name'";
    $result = mysqli_query (self::$link, $query);

    return mysqli_fetch_assoc ($result);
  }

  public function addProduct ($product)
  {
    $typeId = mysqli_fetch_assoc (mysqli_query (self::$link, "SELECT id FROM fixture_type WHERE type='$product[product_type]'"))['id'];
    $manufacturerId = mysqli_fetch_assoc (mysqli_query (self::$link, "SELECT id FROM manufacturer WHERE manufacturer='$product[product_manufacturer]'"))['id'];

    $query = "INSERT INTO products (product_name, price, type_id, manufacturer_id, img) VALUES ('$product[product_name]', $product[product_price], $typeId, $manufacturerId, $product[product_img])";
    mysqli_query (self::$link, $query);
  }

  public function deleteProductById ($id)
  {
    $query = "DELETE FROM products WHERE id='$id'";
    mysqli_query (self::$link, $query);
  }
}