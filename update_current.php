<?php
require_once('header.php');

require_once('class/current.php');
require_once('config/database.php');
$db = new Database();
$db_postgres = $db->getConnection();

$current = new Current($db_postgres);

$idToUpdate = (int) $_GET['id'];

$sqlQuery = 'SELECT * FROM current_items WHERE current_id = ? LIMIT 1';
$stmt = $db->conn->prepare($sqlQuery);
$stmt->bindParam(1, $idToUpdate);
try {
  $stmt->execute();
  $initialData = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $err) {
  $e .= '<p class="php-error">Fetching one item failed: ' . $err->getMessage() . '</p>';
}

if (isset($_POST['update-current-submit']) && isset($_SESSION['user_id'])) {
  // Create the variables for the class (all public vars)
  $current->item = $_POST['item'];
  $current->user_id = $_SESSION['user_id'];
  $current->description = $_POST['description'];
  $current->status = $_POST['status'];
  $current->place = $_POST['place'];
  // Access createCurrent method
  if ($current->updateItem($idToUpdate)) {
    $e .= '<p class="success">Current item updated successfully.</p>';
  } else {
    $e .= '<p class="php-error">updateItem method returned false on statement execute.</p>';
  }
}
?>

<h3>Update a current item</h3>
<form method="post" action="update_current.php">
  <div class="form-group">
    <label for="item">Item </label>
    <input type="text" id="item" name="item" value="<?= $initialData['item'] ?>" class="form-control" required>
  </div>
  <div class="form-group">
    <label for="description">Description</label>
    <input type="text" id="description" name="description" class="form-control" value="<?= $initialData['description'] ?>"  required>
  </div>
  <div class="form-group">
    <div class="col">
      <label for="status">Status </label>
      <select id="status" name="status" class="form-control" value="<?= $initialData['status'] ?>" >
        <option value="Good">Good</option>
        <option value="Gift">Gift</option>
        <option value="Maybe replace">Maybe replace</option>
        <option value="Replace">Replace</option>
        <option value="Garbage">Garbage</option>
      </select>
    </div>
    <div class="col">
      <label for="place">Place </label>
      <select id="place" name="place" class="form-control" value="<?= $initialData['place'] ?>" >
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
    <button id="update-current-submit" name="update-current-submit" class="btn btn-primary btn-lg">Update Item</button>
  </div>
</form>
<div class="error-area">
  <?= $e; ?>
</div>

<?php
require_once('footer.php');
?>