<?php $done = isset($_GET['placed']); ?>
<section class="max-w-2xl mx-auto px-4 py-12 w-full">
<?php if ($done): ?>
  <div class="bg-white rounded-xl shadow p-8 text-center">
    <div class="text-6xl mb-4">✅</div>
    <h2 class="text-2xl font-bold mb-2">Order placed!</h2>
    <p class="text-gray-500 mb-6">Thank you for shopping with <?= SITE_NAME ?>.</p>
    <a href="index.php" class="text-indigo-600">Back to home</a>
  </div>
<?php elseif (!cart()): ?>
  <p>Your cart is empty. <a class="text-indigo-600" href="index.php">Shop now</a></p>
<?php else: ?>
  <h2 class="text-2xl font-bold mb-6">Checkout</h2>
  <form method="post" action="index.php?page=checkout" class="bg-white rounded-xl shadow p-6 space-y-4">
    <input type="hidden" name="action" value="place_order">
    <input required name="name" placeholder="Full name" class="w-full border rounded-lg px-4 py-2">
    <input required type="email" name="email" placeholder="Email" class="w-full border rounded-lg px-4 py-2">
    <textarea required name="address" placeholder="Shipping address" class="w-full border rounded-lg px-4 py-2"></textarea>
    <p class="font-bold">Total: <?= money(cart_total()) ?></p>
    <button class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700">Place Order</button>
  </form>
<?php endif; ?>
</section>
