<?php


namespace Project\Models;

use \Core\Model;

class Product extends Model
{
  public function getProduct ($id)
  {
    $query = "SELECT *, manufacturer.id as manufacturer_id, manufacturer, fixture_type.id as type_id, type FROM products
LEFT JOIN manufacturer ON products.manufacturer_id=manufacturer.id
LEFT JOIN fixture_type ON products.type_id=fixture_type.id
WHERE products.id='$id'";
    $result = mysqli_query (self::$link, $query) or die(mysqli_error (self::$link));

    return mysqli_fetch_assoc ($result);
  }

  public function getComments ($id)
  {
    $query = "SELECT comments.date, comments.comment, users.login as user FROM comments
LEFT JOIN users ON comments.user_id=users.id
WHERE comments.product_id=$id ORDER BY comments.date DESC";

    $result = mysqli_query (self::$link, $query) or die(mysqli_error (self::$link));

    for ($data = []; $elem = mysqli_fetch_assoc ($result); $data[] = $elem) ;

    return $data;
  }

  public function addComment ($date, $comment, $user, $productId)
  {
    $comment = mysqli_real_escape_string (self::$link, $comment);
    $userId = mysqli_fetch_assoc (mysqli_query (self::$link, "SELECT id FROM users WHERE login='$user'"))['id'];
    $query = "INSERT INTO comments (date, comment, user_id, product_id) VALUES ('$date', '$comment', $userId, $productId)";
    mysqli_query (self::$link, $query);
  }
}