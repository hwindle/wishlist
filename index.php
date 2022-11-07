<?php
  require_once('header.php');

?>
<button class="btn btn-success btn-lg">
  <a href="register.php">Register</a>
</button>
<!-- list of current items, sort by status -->
<?php
  if ($_SESSION['user_id'] != null):
?>
  <h3>Current Items</h3>
  <table class="table" id="current-items">
    <thead>
      <tr>
        <th>Item</th>
        <th>Description</th>
        <th>Status</th>
        <th>Place</th>
      </tr>
    </thead>
    <tbody>
      
    </tbody>
    <tfoot>
      <tr>
        <th>Item</th>
        <th>Description</th>
        <th>Status</th>
        <th>Place</th>
      </tr>
    </tfoot>
  </table>
  <p class="errors"><?= $e; ?></p>
<?php
  endif; // session user logged in check
  require_once('footer.php');
?>