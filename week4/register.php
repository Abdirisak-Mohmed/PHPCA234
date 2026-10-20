<?php
// ============================================================
// register.php - Foomka diiwaangelinta ardayga (Tailwind CSS)
// Faylkan wuxuu sameeyaa: muujinta foomka + xaqiijinta (validation)
// + keydinta sawirka + u gudbinta result.php haddii wax walba sax yihiin
// ============================================================

// Bilaw session si xogta ardayga loogu wareejiyo result.php
session_start();

// ---------- Liisaska ikhtiyaarada (dropdown) ----------
$faculties     = ['Computer & IT', 'Engineering', 'Medicine', 'Business & Economics', 'Education'];
$departments   = ['Computer Science', 'Information Technology', 'Software Engineering', 'Civil Engineering', 'Accounting', 'Education'];
$relationships = ['Father', 'Mother', 'Guardian', 'Brother', 'Sister', 'Uncle', 'Aunt'];

// Magacyada dhammaan goobaha foomka (name="" ee HTML-ka)
$fields = ['name','pob','dob','address','gender','telephone','email',
           'parent_name','parent_telephone','relationship',
           'student_id','faculty','department','class','reg_date'];

// $old waxay hayaan qiimaha uu isticmaaluhu geliyay, si foomku u dhex ahaado marka uu error jiro
$old = array_fill_keys($fields, '');
// $errors waxay hayaan fariimaha khaladaadka: 'magaca goobta' => 'fariinta'
$errors = [];

// Function yar oo ka saara meelaha bannaan ee hore iyo dambe
function clean($v) { return trim((string)$v); }

// ---------- Marka la riixo batoonka Register (POST) ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1) Ka soo qaad qiimaha goob walba oo nadiifi
    foreach ($fields as $f) { $old[$f] = clean($_POST[$f] ?? ''); }

    // Magacyada la tusayo fariimaha khaladka (ordering-ku wuxuu la mid yahay foomka,
    // sidaas darteed khalad kowaad wuxuu noqonayaa goobta ugu sarreysa foomka)
    $labels = [
        'name' => 'full name', 'pob' => 'place of birth', 'dob' => 'date of birth',
        'address' => 'address', 'gender' => 'gender', 'telephone' => 'telephone number',
        'email' => 'email address', 'parent_name' => "parent's name",
        'parent_telephone' => "parent's telephone number", 'relationship' => 'relationship',
        'student_id' => 'student ID', 'faculty' => 'faculty', 'department' => 'department',
        'class' => 'class', 'reg_date' => 'registration date',
    ];

    // 2) Hubi sawirka (image) - ma la soo geliyay? Nooca ma sax yahay?
    $imgError = '';
    $file = $_FILES['image'] ?? null;
    if (!$file || $file['error'] === UPLOAD_ERR_NO_FILE) {
        // Wax fayl ah lama dooran
        $imgError = 'Upload a student photo.';
    } elseif ($file['error'] !== UPLOAD_ERR_OK) {
        // Upload-ku wuu fashilmay
        $imgError = 'The upload failed. Try the file again.';
    } else {
        // Ka qaad extension-ka (png, jpg...) oo ka dhig xarfo yaryar
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedExt = ['png', 'jpg', 'jpeg', 'gif', 'webp'];
        // getimagesize wuxuu hubiyaa in faylku runtii sawir yahay (ma aha kaliya magaciisa)
        $info = @getimagesize($file['tmp_name']);
        $allowedMime = ['image/png', 'image/jpeg', 'image/gif', 'image/webp'];
        if (!in_array($ext, $allowedExt, true) || $info === false || !in_array($info['mime'], $allowedMime, true)) {
            $imgError = 'Choose an image file (.png, .jpg, .jpeg, .gif or .webp).';
        } elseif ($file['size'] > 2 * 1024 * 1024) {
            // Xadka cabbirka: 2 MB
            $imgError = 'The image must be smaller than 2 MB.';
        }
    }

    // 3) Hubi in goob walba aysan bannaanayn (required)
    foreach ($labels as $key => $label) {
        if ($old[$key] === '') {
            // Radio/select = "Select ...", goobaha kale = "Enter ..."
            $errors[$key] = ($key === 'gender' || in_array($key, ['faculty','department','relationship'], true))
                ? "Select the $label."
                : "Enter the $label.";
        }
    }

    // 4) Hubi qaabka (format) - kaliya haddii goobtu aysan bannaanayn

    // Magaca: xarfo iyo meel bannaan oo kaliya (\p{L} = xarfo kasta oo luqad ah)
    foreach (['name' => 'Full name', 'parent_name' => "Parent's name"] as $key => $label) {
        if (!isset($errors[$key]) && !preg_match('/^[\p{L}]+(?:[\p{L} ]*[\p{L}])?$/u', $old[$key])) {
            $errors[$key] = "$label can contain only letters and spaces.";
        }
    }
    // Telefoonka: 6-15 lambar, + ayaa laga yaabaa horta
    foreach (['telephone', 'parent_telephone'] as $key) {
        if (!isset($errors[$key]) && !preg_match('/^\+?[0-9 ]{6,15}$/', $old[$key])) {
            $errors[$key] = 'Enter 6 to 15 digits. A leading + is allowed.';
        }
    }
    // Email-ka: filter_var wuxuu hubiyaa qaabka name@example.com
    if (!isset($errors['email']) && !filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Enter a valid email address, like name@example.com.';
    }
    // Jinsiga: waa inuu noqdaa Male ama Female
    if (!isset($errors['gender']) && !in_array($old['gender'], ['Male', 'Female'], true)) {
        $errors['gender'] = 'Select the gender.';
    }
    // Taariikhda dhalashada: waa inuu sax noqdaa oo aan mustaqbalka ahayn
    if (!isset($errors['dob'])) {
        $d = DateTime::createFromFormat('Y-m-d', $old['dob']);
        if (!$d || $d->format('Y-m-d') !== $old['dob'] || $d > new DateTime('today')) {
            $errors['dob'] = 'Enter a valid date of birth that is not in the future.';
        }
    }
    // Taariikhda diiwaangelinta: waa inay taariikh sax ah noqotaa
    if (!isset($errors['reg_date'])) {
        $d = DateTime::createFromFormat('Y-m-d', $old['reg_date']);
        if (!$d || $d->format('Y-m-d') !== $old['reg_date']) {
            $errors['reg_date'] = 'Enter a valid registration date.';
        }
    }
    // Dropdown-ada: qiimaha waa inuu ku jiraa liiska (ka hortag wax-ka-beddelka)
    foreach ([['faculty', $faculties], ['department', $departments], ['relationship', $relationships]] as [$k, $list]) {
        if (!isset($errors[$k]) && !in_array($old[$k], $list, true)) {
            $errors[$k] = 'Choose one of the listed options.';
        }
    }
    // Ku dar khaladka sawirka (haddii uu jiro)
    if ($imgError) { $errors['image'] = $imgError; }

    // 5) Haddii khalad la'aan - keydi sawirka oo u gudbi bogga natiijada
    if (!$errors) {
        $dir = __DIR__ . '/uploads/';
        if (!is_dir($dir)) { mkdir($dir, 0755, true); }   // samee folder-ka haddii uusan jirin
        // Magac gaar ah (unique) si sawirro isku magac ahi isu qoraan
        $newName = uniqid('student_', true) . '.' . $ext;
        if (move_uploaded_file($file['tmp_name'], $dir . $newName)) {
            // Ku keydi xogta session-ka, kadibna u wareeji result.php
            $_SESSION['student'] = $old + ['image' => 'uploads/' . $newName];
            header('Location: result.php');
            exit;   // jooji code-ka halkan
        }
        $errors['image'] = 'The image could not be saved. Check that the uploads folder is writable.';
    }
}

// ---------- Functions caawiya HTML-ka ----------

// Ku soo celi qiimihii hore si badbaado leh (ka hortag XSS)
function val($old, $k) { return htmlspecialchars($old[$k], ENT_QUOTES, 'UTF-8'); }

// Tailwind classes ee input/select/textarea: casaan haddii khalad jiro, kale cagaar
// Wuxuu kaloo ku daraa aria-invalid si JavaScript-ku u helo goobta khaladka leh
function f($errors, $k, $extra = '') {
    $base = 'w-full rounded-md border px-3 py-2 text-sm shadow-sm outline-none focus:ring-2 ' . $extra;
    if (isset($errors[$k])) {
        return 'class="' . $base . ' border-red-500 bg-red-50 focus:ring-red-200" aria-invalid="true"';
    }
    return 'class="' . $base . ' border-slate-300 bg-white focus:border-brand focus:ring-emerald-200"';
}
// Muuji fariinta khaladka goobta hoosteeda
function err($errors, $k) {
    return isset($errors[$k]) ? '<p class="mt-1 text-sm text-red-600">' . htmlspecialchars($errors[$k]) . '</p>' : '';
}
// Samee <option> liis ah, oo kii hore la doortay u calaamadee selected
function options($list, $selected) {
    $out = '<option value="">Select…</option>';
    foreach ($list as $o) {
        $s = $o === $selected ? ' selected' : '';
        $out .= '<option' . $s . '>' . htmlspecialchars($o) . '</option>';
    }
    return $out;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Student registration</title>
<!-- Tailwind CSS (CDN) + midabka brand-ka -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = { theme: { extend: { colors: { brand: { DEFAULT: '#0f4c45', dark: '#0b3a35' } } } } };
</script>
</head>
<body class="bg-slate-100 text-slate-800 antialiased">

<!-- Madaxa bogga -->
<header class="bg-brand pb-14 pt-8 text-white">
  <div class="mx-auto max-w-4xl px-4">
    <h1 class="text-3xl font-bold">Student registration</h1>
    <p class="mt-1 text-emerald-100/80">Jamhuriya University of Science &amp; Technology · Faculty of Computer &amp; IT</p>
  </div>
</header>

<main class="mx-auto -mt-8 max-w-4xl px-4 pb-12">
<!-- enctype="multipart/form-data" waa lagama maarmaan si sawirka loo upload gareeyo.
     novalidate = validation-ka browser-ka waa la damiyay, PHP ayaa samaynaya -->
<form method="post" enctype="multipart/form-data" novalidate id="regForm" class="space-y-6">

<?php if ($errors): ?>
  <!-- Ururinta khaladaadka: link walba wuxuu geeyaa goobta khaladka leh -->
  <div role="alert" class="rounded-lg border-l-4 border-red-600 bg-red-50 p-4 text-red-800 shadow-sm">
    <p class="font-semibold">Fix <?= count($errors) ?> <?= count($errors) === 1 ? 'field' : 'fields' ?> to continue.</p>
    <ul class="mt-1 list-inside list-disc text-sm">
      <?php foreach ($errors as $k => $m): ?>
        <li><a href="#<?= $k === 'gender' ? 'gender_male' : $k ?>" class="underline hover:text-red-950"><?= htmlspecialchars($m) ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

  <!-- ===== QAYBTA 1: Personal information (Xogta shakhsiga) ===== -->
  <section class="overflow-hidden rounded-lg border-l-4 border-brand bg-white shadow-sm">
    <h2 class="border-b border-slate-200 px-5 py-3 font-semibold text-brand">Personal information</h2>
    <div class="grid gap-4 p-5 md:grid-cols-2">
      <!-- Magaca -->
      <div>
        <label for="name" class="mb-1 block text-sm font-medium">Full name</label>
        <input type="text" id="name" name="name" <?= f($errors,'name') ?> value="<?= val($old,'name') ?>">
        <?= err($errors,'name') ?>
      </div>
      <!-- Goobta dhalashada (POB) -->
      <div>
        <label for="pob" class="mb-1 block text-sm font-medium">Place of birth</label>
        <input type="text" id="pob" name="pob" <?= f($errors,'pob') ?> value="<?= val($old,'pob') ?>">
        <?= err($errors,'pob') ?>
      </div>
      <!-- Taariikhda dhalashada (DOB) -->
      <div>
        <label for="dob" class="mb-1 block text-sm font-medium">Date of birth</label>
        <input type="date" id="dob" name="dob" <?= f($errors,'dob') ?> value="<?= val($old,'dob') ?>">
        <?= err($errors,'dob') ?>
      </div>
      <!-- Jinsiga (radio buttons) -->
      <div>
        <span class="mb-1 block text-sm font-medium">Gender</span>
        <div class="flex gap-6 pt-2">
          <label class="flex items-center gap-2 text-sm">
            <input type="radio" name="gender" id="gender_male" value="Male" class="h-4 w-4 accent-emerald-800 <?= isset($errors['gender']) ? 'outline outline-2 outline-red-500' : '' ?>" <?= $old['gender']==='Male'?'checked':'' ?>>
            Male
          </label>
          <label class="flex items-center gap-2 text-sm">
            <input type="radio" name="gender" id="gender_female" value="Female" class="h-4 w-4 accent-emerald-800 <?= isset($errors['gender']) ? 'outline outline-2 outline-red-500' : '' ?>" <?= $old['gender']==='Female'?'checked':'' ?>>
            Female
          </label>
        </div>
        <?= err($errors,'gender') ?>
      </div>
      <!-- Cinwaanka -->
      <div class="md:col-span-2">
        <label for="address" class="mb-1 block text-sm font-medium">Address</label>
        <textarea id="address" name="address" rows="2" <?= f($errors,'address') ?>><?= val($old,'address') ?></textarea>
        <?= err($errors,'address') ?>
      </div>
      <!-- Telefoonka -->
      <div>
        <label for="telephone" class="mb-1 block text-sm font-medium">Telephone</label>
        <input type="tel" id="telephone" name="telephone" <?= f($errors,'telephone') ?> value="<?= val($old,'telephone') ?>" placeholder="+252 61 000 0000">
        <?= err($errors,'telephone') ?>
      </div>
      <!-- Email -->
      <div>
        <label for="email" class="mb-1 block text-sm font-medium">Email</label>
        <input type="email" id="email" name="email" <?= f($errors,'email') ?> value="<?= val($old,'email') ?>" placeholder="name@example.com">
        <?= err($errors,'email') ?>
      </div>
      <!-- Sawirka (accept = browser-ku wuxuu tusayaa sawirro oo kaliya) -->
      <div class="md:col-span-2">
        <label for="image" class="mb-1 block text-sm font-medium">Student photo</label>
        <input type="file" id="image" name="image" accept="image/png,image/jpeg,image/gif,image/webp"
               <?= f($errors,'image','file:mr-3 file:rounded file:border-0 file:bg-brand file:px-3 file:py-1 file:text-sm file:text-white hover:file:bg-brand-dark') ?>>
        <p class="mt-1 text-xs text-slate-500">PNG, JPG, JPEG, GIF or WEBP, up to 2 MB. Choose the file again after a failed submit.</p>
        <?= err($errors,'image') ?>
      </div>
    </div>
  </section>

  <!-- ===== QAYBTA 2: Parent information (Xogta waalidka) ===== -->
  <section class="overflow-hidden rounded-lg border-l-4 border-brand bg-white shadow-sm">
    <h2 class="border-b border-slate-200 px-5 py-3 font-semibold text-brand">Parent information</h2>
    <div class="grid gap-4 p-5 md:grid-cols-3">
      <div>
        <label for="parent_name" class="mb-1 block text-sm font-medium">Parent's name</label>
        <input type="text" id="parent_name" name="parent_name" <?= f($errors,'parent_name') ?> value="<?= val($old,'parent_name') ?>">
        <?= err($errors,'parent_name') ?>
      </div>
      <div>
        <label for="parent_telephone" class="mb-1 block text-sm font-medium">Parent's telephone</label>
        <input type="tel" id="parent_telephone" name="parent_telephone" <?= f($errors,'parent_telephone') ?> value="<?= val($old,'parent_telephone') ?>">
        <?= err($errors,'parent_telephone') ?>
      </div>
      <!-- Xiriirka (dropdown) -->
      <div>
        <label for="relationship" class="mb-1 block text-sm font-medium">Relationship</label>
        <select id="relationship" name="relationship" <?= f($errors,'relationship') ?>><?= options($relationships, $old['relationship']) ?></select>
        <?= err($errors,'relationship') ?>
      </div>
    </div>
  </section>

  <!-- ===== QAYBTA 3: Academic information (Xogta waxbarasho) ===== -->
  <section class="overflow-hidden rounded-lg border-l-4 border-brand bg-white shadow-sm">
    <h2 class="border-b border-slate-200 px-5 py-3 font-semibold text-brand">Academic information</h2>
    <div class="grid gap-4 p-5 md:grid-cols-3">
      <div>
        <label for="student_id" class="mb-1 block text-sm font-medium">Student ID</label>
        <input type="text" id="student_id" name="student_id" <?= f($errors,'student_id') ?> value="<?= val($old,'student_id') ?>">
        <?= err($errors,'student_id') ?>
      </div>
      <div>
        <label for="faculty" class="mb-1 block text-sm font-medium">Faculty</label>
        <select id="faculty" name="faculty" <?= f($errors,'faculty') ?>><?= options($faculties, $old['faculty']) ?></select>
        <?= err($errors,'faculty') ?>
      </div>
      <div>
        <label for="department" class="mb-1 block text-sm font-medium">Department</label>
        <select id="department" name="department" <?= f($errors,'department') ?>><?= options($departments, $old['department']) ?></select>
        <?= err($errors,'department') ?>
      </div>
      <div class="md:col-span-1">
        <label for="class" class="mb-1 block text-sm font-medium">Class</label>
        <input type="text" id="class" name="class" <?= f($errors,'class') ?> value="<?= val($old,'class') ?>" placeholder="e.g. Year 2, Section A">
        <?= err($errors,'class') ?>
      </div>
      <div class="md:col-span-1">
        <label for="reg_date" class="mb-1 block text-sm font-medium">Registration date</label>
        <input type="date" id="reg_date" name="reg_date" <?= f($errors,'reg_date') ?> value="<?= val($old,'reg_date') ?>">
        <?= err($errors,'reg_date') ?>
      </div>
    </div>
  </section>

  <!-- Batoonka diiwaangelinta -->
  <button type="submit" class="rounded-md bg-brand px-8 py-3 font-medium text-white shadow-sm transition hover:bg-brand-dark focus:outline-none focus:ring-2 focus:ring-emerald-300 focus:ring-offset-2">
    Register student
  </button>
</form>
</main>

<script>
// Haddii khalad jiro: u rar goobta ugu horreysa ee khaladka leh oo cursor-ka ku dhig
// (taasi waa shuruudda "put the user at that point on the form")
(function () {
  var bad = document.querySelector('[aria-invalid="true"]') || document.querySelector('input[name="gender"].outline');
  if (bad) {
    bad.scrollIntoView({ behavior: 'smooth', block: 'center' });
    bad.focus({ preventScroll: true });
  }
})();
</script>
</body>
</html>
