<?php
  require_once('header.php');

  require_once('class/login.php');
  require_once('config/database.php');
  $db = new Database();
  $db_postgres = $db->getConnection();
  $user_obj = new User($db_postgres);

  if (isset($_POST['login-submit'])) {
    $user_obj->user_name = htmlspecialchars($_POST['user_name']);
    $user_obj->password = password_verify($_POST['password']);
    if ($user_obj->login()) {
      $e = 'Welcome! :-)';
    } else {
      $e .= '<br>You are not logged in - login.php line 16';
    }
  }


?>

<h2>Login</h2>
<form method="post" action="login.php">
  <div class="form-group">
    <label for="user_name">User</label>
    <input type="text" id="user_name" name="user_name" required>
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>
  </div>
  <div class="form-group form-buttons">
    <button id="login-submit" name="login-submit" class="btn btn-primary btn-lg">Login</button>
  </div>
</form>
<p class="error-area">
  <?= $e; ?>
</p>

<?php
  require_once('footer.php');
?>