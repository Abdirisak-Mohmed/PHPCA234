<?php
// ============================================================
// result.php - Bogga natiijada (Tailwind CSS)
// Wuxuu muujiyaa xogta ardayga ee la gudbiyay, qaab miis (table) ah
// ============================================================

session_start();

// Haddii xog session-ka ku jirin (tusaale: qof si toos ah u furay bogga),
// dib ugu celi foomka
if (empty($_SESSION['student'])) { header('Location: register.php'); exit; }

// Xogta ardayga ee register.php ku keydiyay
$s = $_SESSION['student'];

// Function gaaban oo xogta u badbaadiya muujinta HTML (ka hortag XSS)
function h($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

// Qaabka miiska: 'Cinwaanka qaybta' => ['Label la tusayo' => 'furaha xogta ee $s']
$sections = [
  'Personal information' => [
    'Full name' => 'name', 'Place of birth' => 'pob', 'Date of birth' => 'dob',
    'Gender' => 'gender', 'Address' => 'address', 'Telephone' => 'telephone', 'Email' => 'email',
  ],
  'Parent information' => [
    "Parent's name" => 'parent_name', "Parent's telephone" => 'parent_telephone', 'Relationship' => 'relationship',
  ],
  'Academic information' => [
    'Student ID' => 'student_id', 'Faculty' => 'faculty', 'Department' => 'department',
    'Class' => 'class', 'Registration date' => 'reg_date',
  ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Registration complete</title>
<!-- Tailwind CSS (CDN) + midabka brand-ka -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = { theme: { extend: { colors: { brand: { DEFAULT: '#0f4c45', dark: '#0b3a35' } } } } };
</script>
</head>
<body class="bg-slate-100 text-slate-800 antialiased">

<!-- Madaxa: fariin guul ah oo leh magaca ardayga -->
<header class="bg-brand pb-14 pt-8 text-white">
  <div class="mx-auto max-w-4xl px-4">
    <h1 class="text-3xl font-bold">Registration complete</h1>
    <p class="mt-1 text-emerald-100/80"><?= h($s['name']) ?> is registered. Here is what was submitted.</p>
  </div>
</header>

<main class="mx-auto -mt-8 max-w-4xl px-4 pb-12">
  <div class="rounded-lg bg-white p-5 shadow-sm">
    <div class="grid gap-6 md:grid-cols-[14rem_1fr]">
      <!-- Dhinaca bidix: sawirka ardayga -->
      <div class="flex justify-center md:justify-start">
        <img src="<?= h($s['image']) ?>" alt="Photo of <?= h($s['name']) ?>"
             class="aspect-square w-52 rounded-lg border-4 border-white object-cover shadow-md">
      </div>
      <!-- Dhinaca midig: miiska xogta (overflow-x-auto = shaashadaha yaryar waa la dhaqaajin karaa) -->
      <div class="overflow-x-auto">
        <table class="w-full border-collapse text-left text-sm">
          <?php foreach ($sections as $title => $rows): ?>
            <!-- Safka cinwaanka qaybta -->
            <tr><th colspan="2" class="bg-brand px-4 py-2 font-semibold text-white"><?= h($title) ?></th></tr>
            <?php foreach ($rows as $label => $key): ?>
              <!-- Safka xogta: label + qiimaha (nl2br wuxuu ilaaliyaa safafka cusub ee cinwaanka) -->
              <tr class="border-b border-slate-200">
                <th scope="row" class="w-2/5 bg-slate-50 px-4 py-2 font-medium text-brand"><?= h($label) ?></th>
                <td class="px-4 py-2"><?= nl2br(h($s[$key])) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endforeach; ?>
        </table>
      </div>
    </div>
  </div>

  <!-- Ku laabo foomka si arday cusub loo diiwaangeliyo -->
  <a href="register.php" class="mt-6 inline-block rounded-md bg-brand px-6 py-2.5 font-medium text-white shadow-sm transition hover:bg-brand-dark">
    Register another student
  </a>
</main>
</body>
</html>
