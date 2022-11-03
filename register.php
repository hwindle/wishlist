<?php
  require_once('header.php');

  require_once('class/login.php');
  require_once('config/database.php');
  $db = new Database();
  $db_postgres = $db->getConnection();
  $user_obj = new User($db_postgres);

  if (isset($_POST['register-submit'])) {
    $user_obj->user_name = htmlspecialchars($_POST['user_name']);
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      $user_obj->email = trim($_POST['email']);
    } else {
      $user_obj->email = 'someone@example.com';
    }

    $cleaned_pass = preg_replace('/[a-zA-Z0-9]{8, 20}/', $_POST['password'], '');
    $cleaned_conf = preg_replace('/[a-zA-Z0-9]{8, 20}/', $_POST['confirm-pass'], '');
    if ($cleaned_conf == $cleaned_pass) {
      $user_obj->password = password_hash($cleaned_pass, PASSWORD_DEFAULT);
    } else {
      $e = 'Passwords must match. Line 22';
    }
    if ($user_obj->register()) {
      $e = 'Welcome new user, you are now registered.';
    } else {
      $e = 'Something went wrong and you aren\'t registered.';
    }
  } // isset

?>

<p>If you have already registered, please login.</p>
<form method="post" action="register.php">
  <div class="form-group">
    <label for="user_name">User</label>
    <input type="text" id="user_name" name="user_name" required>
  </div>
  <div class="form-group">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" required>
  </div>
  <div class="form-group">
    <label for="password">Password (letters, numbers only, 8 - 20)</label>
    <input type="password" id="password" name="password" required>
  </div>
  <div class="form-group">
    <label for="confirm-pass">Confirm Password</label>
    <input type="password" id="confirm-pass" name="confirm-pass" required>
  </div>
  <div class="form-group form-buttons">
    <button id="register-submit" name="register-submit" class="btn btn-primary btn-lg">Register</button>
  </div>
</form>
<p class="error-area">
  <?= $e; ?>
</p>

<?php
  require_once('footer.php');
?>