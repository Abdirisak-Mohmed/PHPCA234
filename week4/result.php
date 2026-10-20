<?php
session_start();
if (empty($_SESSION['student'])) { header('Location: register.php'); exit; }
$s = $_SESSION['student'];
function h($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body { background:#eef3f1; font-family: system-ui, -apple-system, "Segoe UI", sans-serif; }
  .banner { background:#0f4c45; color:#fff; padding:2rem 0 3.5rem; }
  .banner h1 { font-size:1.9rem; font-weight:700; margin:0; }
  .banner p { margin:.25rem 0 0; opacity:.8; }
  .wrap { margin-top:-2.2rem; }
  .panel { border:0; border-radius:.5rem; box-shadow:0 1px 3px rgba(0,0,0,.08); }
  .table th { width:35%; background:#f6faf9; color:#0f4c45; }
  .section-row th { background:#0f4c45 !important; color:#fff !important; width:auto; }
  .photo { width:100%; max-width:220px; aspect-ratio:1; object-fit:cover; border-radius:.5rem; border:3px solid #fff; box-shadow:0 1px 4px rgba(0,0,0,.2); }
  .btn-main { background:#0f4c45; border-color:#0f4c45; color:#fff; }
  .btn-main:hover { background:#0b3a35; color:#fff; }
</style>
</head>
<body>
<div class="banner">
  <div class="container">
    <h1>Registration complete</h1>
    <p><?= h($s['name']) ?> is registered. Here is what was submitted.</p>
  </div>
</div>

<div class="container wrap pb-5">
  <div class="card panel">
    <div class="card-body">
      <div class="row g-4">
        <div class="col-md-3 text-center">
          <img class="photo" src="<?= h($s['image']) ?>" alt="Photo of <?= h($s['name']) ?>">
        </div>
        <div class="col-md-9">
          <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0">
              <?php foreach ($sections as $title => $rows): ?>
                <tr class="section-row"><th colspan="2"><?= h($title) ?></th></tr>
                <?php foreach ($rows as $label => $key): ?>
                  <tr><th scope="row"><?= h($label) ?></th><td><?= nl2br(h($s[$key])) ?></td></tr>
                <?php endforeach; ?>
              <?php endforeach; ?>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <a href="register.php" class="btn btn-main mt-4">Register another student</a>
</div>
</body>
</html>
