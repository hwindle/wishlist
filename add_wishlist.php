<?php
  require_once('header.php');

  require_once('class/wishlist.php');
  require_once('config/database.php');
  $db = new Database();
  $db_postgres = $db->getConnection();
  $wishlist = new Wishlist($db_postgres);
  if (isset($_POST['add-wishlist-submit']) && isset($_SESSION['user_id'])) {
    // Create the variables for the class (all public vars)
    $wishlist->item = $_POST['item'];
    $wishlist->user_id = $_SESSION['user_id'];
    $wishlist->category = $_POST['category'];
    $wishlist->shopName = $_POST['store-name'];
    // url

    // pic (url)

    // quantity int

    // price float

    // room

    // priority int
    $wishlist->description = $_POST['description'];
    $wishlist->status = $_POST['status'];
    $wishlist->place = $_POST['place'];
    // Access createCurrent method
    if ($wishlist->createCurrent()) {
      $e .= '<p class="success">Current item added successfully.</p>';
    } else {
      $e .= '<p class="php-error">createCurrent method returned false on statement execute.</p>';
    }
  }
?>

<h3>Add a wishlist product</h3>
<form method="post" action="add_wishlist.php">
  <div class="form-group">
    <div class="col">
      <label for="item">Item </label>
      <input type="text" id="item" name="item" class="form-control" required>
    </div>
    <div class="col">
      <label for="category">Category</label>
      <select id="category" name="category" class="form-control">
        <option value="Crafting">Crafting</option>
        <option value="Furniture">Furniture</option>
        <option value="Electronics">Electronics</option>
        <option value="IT">IT</option>
        <option value="Books">Books</option>
        <option value="Media">Media</option>
        <option value="Clothes">Clothes</option>
        <option value="Food">Food</option>
        <option value="Household">Household</option>
        <option value="Hobbies">Hobbies</option>
        <option value="DIY">DIY</option>
        <option value="Gifts">Gifts</option>
        <option value="other">Other</option>
      </select>
    </div>
  </div>
  <div class="form-group">
    <div class="col">
      <label for="priority">priority</label>
      <input type="number" id="priority" name="priority" class="form-control" min="1" max="100" value="50" required>
    </div>
    <div class="col">
      <label for="store-name">Store Name</label>
      <input type="text" id="store-name" name="store-name" required>
    </div>
  </div>
  <div class="form-group">
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
    <button id="add-wishlist-submit" name="add-wishlist-submit" class="btn btn-primary btn-lg">Add Item</button>
  </div>
</form>
<div class="error-area">
  <?= $e; ?>
</div>

<?php
  require_once('footer.php');
?>