<?php
function products(): array { static $p; return $p ??= require __DIR__.'/../data/products.php'; }
function money(float $n): string { return CURRENCY . number_format($n, 2); }
function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
function cart(): array { return $_SESSION['cart'] ??= []; }
function cart_count(): int { return array_sum(cart()); }
function cart_total(): float {
  $t = 0; foreach (cart() as $id => $q) if (isset(products()[$id])) $t += products()[$id]['price'] * $q;
  return $t;
}
function handle_cart_actions(): void {
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
  $id = (int)($_POST['id'] ?? 0); $a = $_POST['action'] ?? '';
  if ($id && isset(products()[$id])) {
    if ($a === 'add') $_SESSION['cart'][$id] = (cart()[$id] ?? 0) + 1;
    if ($a === 'dec') { $_SESSION['cart'][$id] = (cart()[$id] ?? 0) - 1; if ($_SESSION['cart'][$id] <= 0) unset($_SESSION['cart'][$id]); }
    if ($a === 'remove') unset($_SESSION['cart'][$id]);
  }
  if ($a === 'clear') $_SESSION['cart'] = [];
  header('Location: ' . ($_POST['redirect'] ?? 'index.php')); exit;
}
