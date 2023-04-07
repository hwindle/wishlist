<?php

require_once('class/current.php');
$db = new Database();
$db_postgres = $db->getConnection();

$current = new Current($db_postgres);

$idToDelete = (int) $_GET['id'];
if ($current->deleteItem($idToDelete)) {
  return true;
} else {
  return false;
}