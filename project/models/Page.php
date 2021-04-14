<?php


namespace Project\Models;

use \Core\Model;

class Page extends Model
{
  public function getProducts ($minPrice, $maxPrice, $types = [], $manufacturers = [])
  {
    if (empty($minPrice)) {
      $minPrice = $this->getMinPrice ()['min'];
    }
    if (empty($maxPrice)) {
      $maxPrice = $this->getMaxPrice ()['max'];
    }

    $query = "SELECT products.id, products.product_name, products.price, products.img, fixture_type.type, manufacturer.manufacturer FROM products 
LEFT JOIN manufacturer ON products.manufacturer_id=manufacturer.id
LEFT JOIN fixture_type ON products.type_id=fixture_type.id
WHERE products.price BETWEEN $minPrice AND $maxPrice";
    if (!empty($types)) {
      $query .= " AND fixture_type.type IN('" . implode ('\', \'', $types) . "')";
    }
    if (!empty($manufacturers)) {
      $query .= " AND manufacturer.manufacturer IN('" . implode ('\', \'', $manufacturers) . "')";
    }

    $result = mysqli_query (self::$link, $query) or die(mysqli_error (self::$link));
    for ($data = []; $elem = mysqli_fetch_assoc ($result); $data[] = $elem) ;

    return $data;
  }

  public function getTypes ()
  {
    $query = "SELECT type FROM fixture_type";
    $result = mysqli_query (self::$link, $query) or die(mysqli_error (self::$link));
    for ($data = []; $elem = mysqli_fetch_assoc ($result); $data[] = $elem) ;
    return $data;
  }

  public function getManufacturers ()
  {
    $query = "SELECT manufacturer FROM manufacturer";
    $result = mysqli_query (self::$link, $query) or die(mysqli_error (self::$link));
    for ($data = []; $elem = mysqli_fetch_assoc ($result); $data[] = $elem) ;
    return $data;
  }

  public function getMinPrice ()
  {
    $query = "SELECT MIN(price) as min FROM products";
    $result = mysqli_query (self::$link, $query) or die(mysqli_error (self::$link));
    return mysqli_fetch_assoc ($result);
  }

  public function getMaxPrice ()
  {
    $query = "SELECT MAX(price) as max FROM products";
    $result = mysqli_query (self::$link, $query) or die(mysqli_error (self::$link));
    return mysqli_fetch_assoc ($result);
  }

  private function checkPrices ($min, $max)
  {

  }

  /*public function getCount ($property)
  {
    $query = "SELECT COUNT(*) as count FROM $property";
    $result = mysqli_query (self::$link, $query) or die(mysqli_error (self::$link));
    return mysqli_fetch_assoc ($result)['count'];
  }*/
}