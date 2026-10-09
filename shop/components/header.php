<header class="bg-white shadow sticky top-0 z-10">
  <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
    <a href="index.php" class="text-2xl font-bold text-indigo-600">🛍️ <?= SITE_NAME ?></a>
    <nav class="flex items-center gap-6 text-sm font-medium">
      <a href="index.php" class="hover:text-indigo-600">Home</a>
      <a href="index.php#products" class="hover:text-indigo-600">Products</a>
      <a href="index.php?page=cart" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
        Cart <span class="ml-1 bg-white text-indigo-600 rounded-full px-2 text-xs"><?= cart_count() ?></span>
      </a>
    </nav>
  </div>
</header>
