<?php /** expects $p */ ?>
<div class="bg-white rounded-xl shadow hover:shadow-lg transition p-4 flex flex-col">
  <a href="index.php?page=product&id=<?= $p['id'] ?>" class="bg-indigo-50 rounded-lg h-40 flex items-center justify-center text-6xl mb-4"><?= $p['emoji'] ?></a>
  <span class="text-xs text-indigo-500 font-semibold uppercase"><?= e($p['cat']) ?></span>
  <h3 class="font-semibold text-lg"><?= e($p['name']) ?></h3>
  <p class="text-gray-500 text-sm flex-1"><?= e($p['desc']) ?></p>
  <div class="flex items-center justify-between mt-4">
    <span class="text-xl font-bold"><?= money($p['price']) ?></span>
    <form method="post">
      <input type="hidden" name="action" value="add">
      <input type="hidden" name="id" value="<?= $p['id'] ?>">
      <input type="hidden" name="redirect" value="index.php">
      <button class="bg-indigo-600 text-white px-3 py-2 rounded-lg text-sm hover:bg-indigo-700">Add to Cart</button>
    </form>
  </div>
</div>
