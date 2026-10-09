<section class="max-w-4xl mx-auto px-4 py-12 w-full">
  <h2 class="text-2xl font-bold mb-6">Your Cart</h2>
  <?php if (!cart()): ?>
    <p class="text-gray-500">Your cart is empty. <a href="index.php" class="text-indigo-600">Continue shopping</a></p>
  <?php else: ?>
  <div class="bg-white rounded-xl shadow divide-y">
    <?php foreach (cart() as $id => $qty): $p = products()[$id]; ?>
    <div class="flex flex-wrap items-center gap-4 p-4">
      <div class="text-4xl"><?= $p['emoji'] ?></div>
      <div class="flex-1">
        <p class="font-semibold"><?= e($p['name']) ?></p>
        <p class="text-sm text-gray-500"><?= money($p['price']) ?> each</p>
      </div>
      <form method="post" class="flex items-center gap-2">
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="hidden" name="redirect" value="index.php?page=cart">
        <button name="action" value="dec" class="w-8 h-8 border rounded">−</button>
        <span class="w-6 text-center"><?= $qty ?></span>
        <button name="action" value="add" class="w-8 h-8 border rounded">+</button>
        <button name="action" value="remove" class="ml-3 text-red-500 text-sm">Remove</button>
      </form>
      <p class="w-24 text-right font-semibold"><?= money($p['price'] * $qty) ?></p>
    </div>
    <?php endforeach; ?>
    <div class="p-4 flex items-center justify-between">
      <form method="post"><input type="hidden" name="redirect" value="index.php?page=cart">
        <button name="action" value="clear" class="text-sm text-gray-500 hover:text-red-500">Clear cart</button></form>
      <p class="text-xl font-bold">Total: <?= money(cart_total()) ?></p>
    </div>
  </div>
  <a href="index.php?page=checkout" class="inline-block mt-6 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700">Proceed to Checkout</a>
  <?php endif; ?>
</section>
