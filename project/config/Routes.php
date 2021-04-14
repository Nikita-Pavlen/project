<?php
use \Core\Route;

return [
  new Route('/', 'page', 'test'),
  new Route('/page/:num', 'page', 'test'),
  new Route('/form/', 'page', 'test'),
  new Route('/form/page/:num', 'page', 'test'),
  new Route('/cart', 'cart', 'cart'),
  new Route('/wishlist', 'cart', 'wishlist'),
  new Route('/product/:id', 'product', 'showProduct'),
  new Route('/admin/users', 'admin', 'showAdminUsers'),
  new Route('/admin/products', 'admin', 'showAdminProducts'),
  new Route('/admin/ban/:ban', 'admin', 'banned'),
  new Route('/admin/unban/:unban', 'admin', 'banned'),
  new Route('/admin/addnew', 'admin', 'addNewProduct'),
  new Route('/admin/deleteProduct/:delId', 'admin', 'deleteProduct'),
  new Route('/logout/:redir', 'page', 'logout'),
  new Route('/comment/:productId/:user', 'product', 'addComment'),
];