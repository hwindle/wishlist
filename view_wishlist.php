<?php
  require_once('header.php');

  require_once('class/wishlist.php');
  require_once('config/database.php');
  $db = new Database();
  $db_postgres = $db->getConnection();
  $wishlist = new Wishlist($db_postgres);

?>
<!-- little cards, wishlist items -->
<?php
  if ($_SESSION['user_id'] != null):
?>
  <h3>Wishlist</h3>
    <section class="card-container">
      <?php
        $stmt = $wishlist->getWishlist();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $result) {
          echo '<div class="wishlist-card">';
          echo "\n<h4>${result['item']}</h4>\n";
          echo "\n<h5>${result['shop_name']}</h5>\n";
          echo '<a class="buy-button" href="' . $result['url'] . '">
            Buy this</a><hr>';
          echo "\n<figure>\n";
          echo "<img src='./${result['pic']}' class='card-img' alt='${result['item']}'>\n";
          echo "</figure>\n";
          echo "\n<p class='prices'>£${result['price']} each, £${result['total_price']}  total for ${result['quantity']}.</p>\n";
          echo "\n<p class='priority'>Priority (100 highest): ${result['priority']}</p>\n";
          echo "\n<p class='category'>Category: ${result['category']}</p>\n";
          echo '</div>';
        }
        if ($results == null) {
          echo "\n<pNo rows</p>";
        }
      ?>
    </section>
  <div class="error-area"><?= $e; ?></div>
<?php
  endif; // session user logged in check
  require_once('footer.php');
?>