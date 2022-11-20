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
    $wishlist->url = $_POST['url'];
    /* Basename strips any .. chars, creates a correctly formatted
      URI. $_FILES['pic'] refers to the input name attribute value,
       the ['name'] part is the filename from the user input.
    */
    $pic_unchecked = 'uploaded_imgs/' . basename($_FILES['pic']['name']);
    // Check if the file was a valid picture under 4MB
    if (isset($_FILES['pic']) && $_FILES['pic']['error'] == 0) {
      $allowed_ext = array('jpg' => 'image/jpg',
                        'jpeg' => 'image/jpeg',
                        'png' => 'image/png');
      $file_name = $_FILES['pic']['name'];
      $file_type = $_FILES['pic']['type'];
      $file_size = $_FILES['pic']['size'];
      // is the extension correct?
      $ext = pathinfo($file_name, PATHINFO_EXTENSION);
      if (!array_key_exists($ext, $allowed_ext)) {
        $e .= '<p class="php-error">Error: Please select either a .jpg, .jpeg or .png please.</p>';
      } // extensions if    
      $maxSize = 4 * 1024 * 1024;
      if ($file_size > $maxSize) {
        $e .= '<p class="php-error">Error: File size is larger than the allowed limit.</p>';
      }                    
      // Verify meta info in the file to make sure it's a pic
      if (in_array($file_type, $allowed_ext)) {
        // Check whether file exists before uploading it
        if (file_exists('uploaded_imgs/' . $_FILES['pic']['name'])) {
          $e .= '<p class="php-error">' . $file_name . 
            ' already exists. You have uploaded that one.</p>';
        } else {
          if (move_uploaded_file($_FILES['pic']['tmp_name'], $pic_unchecked)) {
            $e .= '<p class="success">The file ' . $file_name . 
                  ' has been received. </p>';
          } else {
            $e .= '<p class="php-error">Sorry, there was an error uploading your file.</p>';
          }
        } // if - checking if file is a duplicate
      } else {
        $e .= '<p class="php-error">Please try again. Line 53, add_wishlist.php</p>';
      }
      $wishlist->pic = $pic_unchecked;
    } else {
      $e .= '<p class="php-error">File upload error: ' 
        . $_FILES['pic']['error'] . '</p>';
    } // end if - mimetype checking

    $wishlist->quantity = $_POST['quantity'];
    $wishlist->price = $_POST['price'];
    $wishlist->priority = $_POST['priority'];
    $wishlist->room = $_POST['room'];
    // Access createCurrent method
    if ($wishlist->createWishlist()) {
      $e .= '<p class="success">Current item added successfully.</p>';
    } else {
      $e .= '<p class="php-error">createCurrent method returned false on statement execute.</p>';
    }
  }
?>

<h3>Add a wishlist product</h3>
<form method="post" action="add_wishlist.php" enctype="multipart/form-data">
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
      <label for="pic">pic</label>
      <input type="file" id="pic" name="pic" class="form-control" required>
    </div>
    <div class="col">
      <label for="quantity">Quantity</label>
      <input type="number" min="1" max="1000" id="quantity" name="quantity" required>
    </div>
    <div class="col">
      <label for="url">Web address</label>
      <input type="url" id="url" name="url" required>
    </div>
  </div>
  <div class="form-group">
    <div class="col">
      <label for="price">Price (£)</label>
      <input type="number" id="price" name="price" step="0.01" min="0.0" max="200000.00" required>
    </div>
    <div class="col">
      <label for="room">Room</label>
      <select id="room" name="room" class="form-control">
        <option value="Kitchen">Kitchen</option>
        <option value="Bedroom">Bedroom</option>
        <option value="Garden">Garden</option>
        <option value="Living room">Living room</option>
        <option value="Dining room">Dining room</option>
        <option value="Bathroom">Bathroom</option>
        <option value="Garage">Garage</option>
        <option value="Other">Other</option>
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