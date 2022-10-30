<?php
  require_once('header.php');

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