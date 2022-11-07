<?php
  require_once('header.php');

  require_once('class/current.php');
  require_once('config/database.php');
  $db = new Database();
  $db_postgres = $db->getConnection();
  $current = new Current($db_postgres);

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
      <?php
        $stmt = $current->getCurrentItems();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $result) {
          echo '<tr>';
          echo "\n<td>${result['item']}</td>\n";
          echo "\n<td>${result['description']}</td>\n";
          echo "\n<td>${result['status']}</td>\n";
          echo "\n<td>${result['place']}</td>\n";
          echo '</tr>';
        }
        if ($results == null) {
          echo "\n<tr><td>No rows</td><td></td><td></td><td></td></tr>";
        }
      ?>
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