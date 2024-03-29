<?php
  //if ($_SESSION['user_id'] != null) {
    session_start();
  //}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/styles.css">
  <title>Home | Wishlist Program</title>
</head>
<body>
  <header>
    <div id="logo"></div>
    <div class="header-titles">
      <h1>Wishlist</h1>
    </div>
  </header>
  <nav class="navbar-nav" aria-role="navigation">
    <ul class="menu">
      <li class="item">
        <a href="index.php" class="nav-link"><span id="home"></span>
          Home
        </a>
      </li>
      <li class="item">
        <a href="add_current.php" class="nav-link"><span class="pencil"></span>
          Add Current
        </a>
      </li>
      <li class="item">
        <a href="view_wishlist.php" class="nav-link">
          View Wishlist
        </a>
      </li>
      <li class="item">
        <a href="add_wishlist.php" class="nav-link"><span class="pencil"></span>
          Add Wishlist
        </a>
      </li>
      <!-- php if/else here -->
<?php
  if ($_SESSION['user_id'] != null) {
    echo <<<'LIST'
    <li class="item button secondary">
      <a href="logout.php" class="nav-link">
        Logout
      </a>
    </li>
    LIST;
  } else {
    echo <<<'LOGIN'
    <li class="item button">
      <a href="register.php">Register</a>
    </li>
    <li class="item button secondary">
    <a href="login.php" class="nav-link">
      Login
    </a>
    </li>
    LOGIN;
  }
?>
    <!-- rest of list -->       
    </ul>
  </nav>
  
