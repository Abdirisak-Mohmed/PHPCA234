<?php
$q = trim($_GET['q'] ?? ''); $cat = $_GET['cat'] ?? '';
$list = array_filter(products(), fn($p) =>
  ($q === '' || stripos($p['name'], $q) !== false) && ($cat === '' || $p['cat'] === $cat));
$cats = array_unique(array_column(products(), 'cat'));
?>
<section id="products" class="max-w-6xl mx-auto px-4 py-12 w-full">
  <h2 class="text-2xl font-bold mb-6">Our Products</h2>
  <form method="get" action="index.php#products" class="flex flex-wrap gap-3 mb-8">
    <input name="q" value="<?= e($q) ?>" placeholder="Search products..." class="border rounded-lg px-4 py-2 flex-1 min-w-[200px]">
    <select name="cat" class="border rounded-lg px-4 py-2">
      <option value="">All categories</option>
      <?php foreach ($cats as $c): ?><option <?= $c === $cat ? 'selected' : '' ?>><?= e($c) ?></option><?php endforeach; ?>
    </select>
    <button class="bg-gray-800 text-white px-5 py-2 rounded-lg">Filter</button>
  </form>
  <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($list as $p) include __DIR__.'/product-card.php'; ?>
    <?php if (!$list): ?><p class="text-gray-500">No products found.</p><?php endif; ?>
  </div>
</section>
