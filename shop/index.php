<?php
require __DIR__.'/config.php';
require __DIR__.'/includes/functions.php';

// Order placement (demo: saves to orders.log, then clears cart)
if (($_POST['action'] ?? '') === 'place_order' && cart()) {
  $line = date('c')." | ".strip_tags($_POST['name'])." | ".strip_tags($_POST['email'])." | ".money(cart_total())."\n";
  file_put_contents(__DIR__.'/data/orders.log', $line, FILE_APPEND);
  $_SESSION['cart'] = [];
  header('Location: index.php?page=checkout&placed=1'); exit;
}
handle_cart_actions();

$page = $_GET['page'] ?? 'home';
$title = SITE_NAME . ' - ' . ucfirst($page);

include 'components/head.php';
include 'components/header.php';

switch ($page) {
  case 'cart':     include 'components/cart.php'; break;
  case 'checkout': include 'components/checkout.php'; break;
  case 'product':  include 'components/product-detail.php'; break;
  default:
    include 'components/hero.php';
    include 'components/product-grid.php';
}

include 'components/footer.php';
