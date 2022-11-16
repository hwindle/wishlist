<?php
  require_once('header.php');

  require_once('class/current.php');
  require_once('config/database.php');
  $db = new Database();
  $db_postgres = $db->getConnection();
  $current = new Current($db_postgres);
  if (isset($_POST['add-current-submit']) && isset($_SESSION['user_id'])) {
    // Create the variables for the class (all public vars)
    $current->item = $_POST['item'];
    $current->user_id = $_SESSION['user_id'];
    $current->description = $_POST['description'];
    $current->status = $_POST['status'];
    $current->place = $_POST['place'];
    // Access createCurrent method
    if ($current->createCurrent()) {
      $e .= '<p class="success">Current item added successfully.</p>';
    } else {
      $e .= '<p class="php-error">createCurrent method returned false on statement execute.</p>';
    }
  }
?>

<h3>Add a current item</h3>
<form method="post" action="add_current.php">
  <div class="form-group">
    <label for="item">Item </label>
    <input type="text" id="item" name="item" class="form-control" required>
  </div>
  <div class="form-group">
    <label for="description">Description</label>
    <input type="text" id="description" name="description" class="form-control" required>
  </div>
  <div class="form-group">
    <div class="col">
      <label for="status">Status </label>
      <select id="status" name="status" class="form-control">
        <option value="Good">Good</option>
        <option value="Gift">Gift</option>
        <option value="Maybe replace">Maybe replace</option>
        <option value="Replace">Replace</option>
        <option value="Garbage">Garbage</option>
      </select>
    </div>
    <div class="col">
      <label for="place">Place </label>
      <select id="place" name="place" class="form-control">
        <option value="Kitchen">Kitchen</option>
        <option value="Bedroom">Bedroom</option>
        <option value="Outside">Outside</option>
        <option value="Living room">Living room</option>
        <option value="Dining room">Dining room</option>
        <option value="Bathroom">Bathroom</option>
        <option value="Bedroom-2">Smaller bedroom</option>
        <option value="Hall">Hall</option>
      </select>
    </div>
  </div>
  <div class="form-group form-buttons">
    <button id="add-current-submit" name="add-current-submit" class="btn btn-primary btn-lg">Add Item</button>
  </div>
</form>
<div class="error-area">
  <?= $e; ?>
</div>

<?php
  require_once('footer.php');
?>