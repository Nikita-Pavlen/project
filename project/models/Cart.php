<?php


namespace Project\Models;

use \Core\Model;


class Cart extends Model
{
  public function getEvery ($name)
  {
    $query = "SELECT *, manufacturer.id as manufacturer_id, manufacturer, fixture_type.id as type_id, type FROM products
LEFT JOIN manufacturer ON products.manufacturer_id=manufacturer.id
LEFT JOIN fixture_type ON products.type_id=fixture_type.id
WHERE products.product_name='$name'";
    $result = mysqli_query (self::$link, $query) or die(mysqli_error (self::$link));

    return mysqli_fetch_assoc ($result);
  }
}