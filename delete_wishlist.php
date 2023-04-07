<?php

require_once('class/wishlist.php');
$db = new Database();
$db_postgres = $db->getConnection();

$wishlist = new Wishlist($db_postgres);

$idToDelete = (int) $_GET['id'];
if ($wishlist->deleteItem($idToDelete)) {
  return true;
} else {
  return false;
}