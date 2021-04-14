<?php


namespace Core;


class Model
{
  protected static $link;

  public function __construct ()
  {
    if (!self::$link) {
      self::$link = mysqli_connect (DB_HOST, DB_USER, DB_PASS, DB_NAME);
      mysqli_query (self::$link, "SET NAMES 'utf8'");
    }
  }

  public function getUser ($login)
  {
    $query = "SELECT * FROM users WHERE login='$login'";
    $result = mysqli_query (self::$link, $query);

    return mysqli_fetch_assoc ($result);
  }

  public function addUser ($login, $password)
  {
    $query = "INSERT INTO users (login, password, status, banned) VALUES ('$login', '$password', 1, 0)";
    mysqli_query (self::$link, $query);
  }
}