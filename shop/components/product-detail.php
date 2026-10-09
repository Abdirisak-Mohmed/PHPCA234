<?php $p = products()[(int)($_GET['id'] ?? 0)] ?? null; ?>
<section class="max-w-4xl mx-auto px-4 py-12 w-full">
<?php if (!$p): ?>
  <p>Product not found. <a class="text-indigo-600" href="index.php">Go back</a></p>
<?php else: ?>
  <div class="bg-white rounded-xl shadow p-8 grid md:grid-cols-2 gap-8">
    <div class="bg-indigo-50 rounded-lg h-64 flex items-center justify-center text-8xl"><?= $p['emoji'] ?></div>
    <div>
      <span class="text-xs text-indigo-500 font-semibold uppercase"><?= e($p['cat']) ?></span>
      <h1 class="text-3xl font-bold mb-2"><?= e($p['name']) ?></h1>
      <p class="text-gray-600 mb-4"><?= e($p['desc']) ?></p>
      <p class="text-3xl font-bold mb-6"><?= money($p['price']) ?></p>
      <form method="post">
        <input type="hidden" name="action" value="add">
        <input type="hidden" name="id" value="<?= $p['id'] ?>">
        <input type="hidden" name="redirect" value="index.php?page=cart">
        <button class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">Add to Cart</button>
      </form>
    </div>
  </div>
<?php endif; ?>
</section>
