<?php
session_start();

$faculties = ['Computer & IT', 'Engineering', 'Medicine', 'Business & Economics', 'Education'];
$departments = ['Computer Science', 'Information Technology', 'Software Engineering', 'Civil Engineering', 'Accounting', 'Education'];
$relationships = ['Father', 'Mother', 'Guardian', 'Brother', 'Sister', 'Uncle', 'Aunt'];

$fields = ['name','pob','dob','address','gender','telephone','email',
           'parent_name','parent_telephone','relationship',
           'student_id','faculty','department','class','reg_date'];

$old = array_fill_keys($fields, '');
$errors = [];

function clean($v) { return trim((string)$v); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($fields as $f) { $old[$f] = clean($_POST[$f] ?? ''); }

    // Validation runs in the same order as the form, so the first error is the first field on the page.
    $labels = [
        'name' => 'full name', 'pob' => 'place of birth', 'dob' => 'date of birth',
        'address' => 'address', 'gender' => 'gender', 'telephone' => 'telephone number',
        'email' => 'email address', 'parent_name' => "parent's name",
        'parent_telephone' => "parent's telephone number", 'relationship' => 'relationship',
        'student_id' => 'student ID', 'faculty' => 'faculty', 'department' => 'department',
        'class' => 'class', 'reg_date' => 'registration date',
    ];

    // Image is checked first for presence, but reported in form position (after email)
    $imgError = '';
    $file = $_FILES['image'] ?? null;
    if (!$file || $file['error'] === UPLOAD_ERR_NO_FILE) {
        $imgError = 'Upload a student photo.';
    } elseif ($file['error'] !== UPLOAD_ERR_OK) {
        $imgError = 'The upload failed. Try the file again.';
    } else {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedExt = ['png', 'jpg', 'jpeg', 'gif', 'webp'];
        $info = @getimagesize($file['tmp_name']);
        $allowedMime = ['image/png', 'image/jpeg', 'image/gif', 'image/webp'];
        if (!in_array($ext, $allowedExt, true) || $info === false || !in_array($info['mime'], $allowedMime, true)) {
            $imgError = 'Choose an image file (.png, .jpg, .jpeg, .gif or .webp).';
        } elseif ($file['size'] > 2 * 1024 * 1024) {
            $imgError = 'The image must be smaller than 2 MB.';
        }
    }

    // Empty checks
    foreach ($labels as $key => $label) {
        if ($old[$key] === '') {
            $errors[$key] = ($key === 'gender' || in_array($key, ['faculty','department','relationship'], true))
                ? "Select the $label."
                : "Enter the $label.";
        }
    }

    // Format checks (only if not already empty)
    foreach (['name' => 'Full name', 'parent_name' => "Parent's name"] as $key => $label) {
        if (!isset($errors[$key]) && !preg_match('/^[\p{L}]+(?:[\p{L} ]*[\p{L}])?$/u', $old[$key])) {
            $errors[$key] = "$label can contain only letters and spaces.";
        }
    }
    foreach (['telephone', 'parent_telephone'] as $key) {
        if (!isset($errors[$key]) && !preg_match('/^\+?[0-9 ]{6,15}$/', $old[$key])) {
            $errors[$key] = 'Enter 6 to 15 digits. A leading + is allowed.';
        }
    }
    if (!isset($errors['email']) && !filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Enter a valid email address, like name@example.com.';
    }
    if (!isset($errors['gender']) && !in_array($old['gender'], ['Male', 'Female'], true)) {
        $errors['gender'] = 'Select the gender.';
    }
    if (!isset($errors['dob'])) {
        $d = DateTime::createFromFormat('Y-m-d', $old['dob']);
        if (!$d || $d->format('Y-m-d') !== $old['dob'] || $d > new DateTime('today')) {
            $errors['dob'] = 'Enter a valid date of birth that is not in the future.';
        }
    }
    if (!isset($errors['reg_date'])) {
        $d = DateTime::createFromFormat('Y-m-d', $old['reg_date']);
        if (!$d || $d->format('Y-m-d') !== $old['reg_date']) {
            $errors['reg_date'] = 'Enter a valid registration date.';
        }
    }
    foreach ([['faculty', $faculties], ['department', $departments], ['relationship', $relationships]] as [$k, $list]) {
        if (!isset($errors[$k]) && !in_array($old[$k], $list, true)) {
            $errors[$k] = 'Choose one of the listed options.';
        }
    }
    if ($imgError) { $errors['image'] = $imgError; }

    if (!$errors) {
        $dir = __DIR__ . '/uploads/';
        if (!is_dir($dir)) { mkdir($dir, 0755, true); }
        $newName = uniqid('student_', true) . '.' . $ext;
        if (move_uploaded_file($file['tmp_name'], $dir . $newName)) {
            $_SESSION['student'] = $old + ['image' => 'uploads/' . $newName];
            header('Location: result.php');
            exit;
        }
        $errors['image'] = 'The image could not be saved. Check that the uploads folder is writable.';
    }
}

function val($old, $k) { return htmlspecialchars($old[$k], ENT_QUOTES, 'UTF-8'); }
function cls($errors, $k) { return isset($errors[$k]) ? ' is-invalid' : ''; }
function err($errors, $k) {
    return isset($errors[$k]) ? '<div class="invalid-feedback d-block">' . htmlspecialchars($errors[$k]) . '</div>' : '';
}
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body { background:#eef3f1; font-family: system-ui, -apple-system, "Segoe UI", sans-serif; }
  .banner { background:#0f4c45; color:#fff; padding:2rem 0 3.5rem; }
  .banner h1 { font-size:1.9rem; font-weight:700; margin:0; }
  .banner p { margin:.25rem 0 0; opacity:.8; }
  .form-wrap { margin-top:-2.2rem; }
  .section-card { border:0; border-left:5px solid #0f4c45; border-radius:.5rem; box-shadow:0 1px 3px rgba(0,0,0,.08); }
  .section-card .card-header { background:#fff; font-weight:600; color:#0f4c45; border-bottom:1px solid #e3ebe8; }
  .btn-register { background:#0f4c45; border-color:#0f4c45; color:#fff; padding:.65rem 2rem; }
  .btn-register:hover { background:#0b3a35; color:#fff; }
  .error-summary { border-left:5px solid #b3261e; }
</style>
</head>
<body>
<div class="banner">
  <div class="container">
    <h1>Student registration</h1>
    <p>Jamhuriya University of Science &amp; Technology · Faculty of Computer &amp; IT</p>
  </div>
</div>

<div class="container form-wrap pb-5">
<form method="post" enctype="multipart/form-data" novalidate id="regForm">

<?php if ($errors): ?>
  <div class="alert alert-danger error-summary" role="alert">
    <strong>Fix <?= count($errors) ?> <?= count($errors) === 1 ? 'field' : 'fields' ?> to continue.</strong>
    <ul class="mb-0 mt-1">
      <?php foreach ($errors as $k => $m): ?>
        <li><a href="#<?= $k === 'gender' ? 'gender_male' : $k ?>" class="alert-link"><?= htmlspecialchars($m) ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

  <!-- Personal information -->
  <div class="card section-card mb-4">
    <div class="card-header">Personal information</div>
    <div class="card-body row g-3">
      <div class="col-md-6">
        <label for="name" class="form-label">Full name</label>
        <input type="text" id="name" name="name" class="form-control<?= cls($errors,'name') ?>" value="<?= val($old,'name') ?>">
        <?= err($errors,'name') ?>
      </div>
      <div class="col-md-6">
        <label for="pob" class="form-label">Place of birth</label>
        <input type="text" id="pob" name="pob" class="form-control<?= cls($errors,'pob') ?>" value="<?= val($old,'pob') ?>">
        <?= err($errors,'pob') ?>
      </div>
      <div class="col-md-6">
        <label for="dob" class="form-label">Date of birth</label>
        <input type="date" id="dob" name="dob" class="form-control<?= cls($errors,'dob') ?>" value="<?= val($old,'dob') ?>">
        <?= err($errors,'dob') ?>
      </div>
      <div class="col-md-6">
        <label class="form-label d-block">Gender</label>
        <div class="form-check form-check-inline">
          <input class="form-check-input<?= cls($errors,'gender') ?>" type="radio" name="gender" id="gender_male" value="Male" <?= $old['gender']==='Male'?'checked':'' ?>>
          <label class="form-check-label" for="gender_male">Male</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input<?= cls($errors,'gender') ?>" type="radio" name="gender" id="gender_female" value="Female" <?= $old['gender']==='Female'?'checked':'' ?>>
          <label class="form-check-label" for="gender_female">Female</label>
        </div>
        <?= err($errors,'gender') ?>
      </div>
      <div class="col-12">
        <label for="address" class="form-label">Address</label>
        <textarea id="address" name="address" rows="2" class="form-control<?= cls($errors,'address') ?>"><?= val($old,'address') ?></textarea>
        <?= err($errors,'address') ?>
      </div>
      <div class="col-md-6">
        <label for="telephone" class="form-label">Telephone</label>
        <input type="tel" id="telephone" name="telephone" class="form-control<?= cls($errors,'telephone') ?>" value="<?= val($old,'telephone') ?>" placeholder="+252 61 000 0000">
        <?= err($errors,'telephone') ?>
      </div>
      <div class="col-md-6">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-control<?= cls($errors,'email') ?>" value="<?= val($old,'email') ?>" placeholder="name@example.com">
        <?= err($errors,'email') ?>
      </div>
      <div class="col-12">
        <label for="image" class="form-label">Student photo</label>
        <input type="file" id="image" name="image" accept="image/png,image/jpeg,image/gif,image/webp" class="form-control<?= cls($errors,'image') ?>">
        <div class="form-text">PNG, JPG, JPEG, GIF or WEBP, up to 2 MB. Choose the file again after a failed submit.</div>
        <?= err($errors,'image') ?>
      </div>
    </div>
  </div>

  <!-- Parent information -->
  <div class="card section-card mb-4">
    <div class="card-header">Parent information</div>
    <div class="card-body row g-3">
      <div class="col-md-4">
        <label for="parent_name" class="form-label">Parent's name</label>
        <input type="text" id="parent_name" name="parent_name" class="form-control<?= cls($errors,'parent_name') ?>" value="<?= val($old,'parent_name') ?>">
        <?= err($errors,'parent_name') ?>
      </div>
      <div class="col-md-4">
        <label for="parent_telephone" class="form-label">Parent's telephone</label>
        <input type="tel" id="parent_telephone" name="parent_telephone" class="form-control<?= cls($errors,'parent_telephone') ?>" value="<?= val($old,'parent_telephone') ?>">
        <?= err($errors,'parent_telephone') ?>
      </div>
      <div class="col-md-4">
        <label for="relationship" class="form-label">Relationship</label>
        <select id="relationship" name="relationship" class="form-select<?= cls($errors,'relationship') ?>"><?= options($relationships, $old['relationship']) ?></select>
        <?= err($errors,'relationship') ?>
      </div>
    </div>
  </div>

  <!-- Academic information -->
  <div class="card section-card mb-4">
    <div class="card-header">Academic information</div>
    <div class="card-body row g-3">
      <div class="col-md-4">
        <label for="student_id" class="form-label">Student ID</label>
        <input type="text" id="student_id" name="student_id" class="form-control<?= cls($errors,'student_id') ?>" value="<?= val($old,'student_id') ?>">
        <?= err($errors,'student_id') ?>
      </div>
      <div class="col-md-4">
        <label for="faculty" class="form-label">Faculty</label>
        <select id="faculty" name="faculty" class="form-select<?= cls($errors,'faculty') ?>"><?= options($faculties, $old['faculty']) ?></select>
        <?= err($errors,'faculty') ?>
      </div>
      <div class="col-md-4">
        <label for="department" class="form-label">Department</label>
        <select id="department" name="department" class="form-select<?= cls($errors,'department') ?>"><?= options($departments, $old['department']) ?></select>
        <?= err($errors,'department') ?>
      </div>
      <div class="col-md-6">
        <label for="class" class="form-label">Class</label>
        <input type="text" id="class" name="class" class="form-control<?= cls($errors,'class') ?>" value="<?= val($old,'class') ?>" placeholder="e.g. Year 2, Section A">
        <?= err($errors,'class') ?>
      </div>
      <div class="col-md-6">
        <label for="reg_date" class="form-label">Registration date</label>
        <input type="date" id="reg_date" name="reg_date" class="form-control<?= cls($errors,'reg_date') ?>" value="<?= val($old,'reg_date') ?>">
        <?= err($errors,'reg_date') ?>
      </div>
    </div>
  </div>

  <button type="submit" class="btn btn-register btn-lg">Register student</button>
</form>
</div>

<script>
// Send the user to the first field that needs attention.
(function () {
  var bad = document.querySelector('.is-invalid');
  if (bad) {
    bad.scrollIntoView({ behavior: 'smooth', block: 'center' });
    bad.focus({ preventScroll: true });
  }
})();
</script>
</body>
</html>
