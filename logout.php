<?php
$_SESSION['user_id'] = null;
$_SESSION['user_name'] = null;
session_destroy();
header('Location: login.php');
exit;