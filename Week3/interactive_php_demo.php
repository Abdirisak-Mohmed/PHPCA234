<?php
/* ============================================================
   Interactive PHP Demo — Variables, Conditions, Loops
   Run with:  php -S localhost:8000
   Then open: http://localhost:8000/interactive_php_demo.php
   ============================================================ */

session_start();

/* ---------------------------------------------------------
   1) VARIABLES
   --------------------------------------------------------- */
$siteName   = "PHP Playground";
$version    = 1.0;
$isFree     = true;
$features   = ["Variables", "Conditions", "Loops"];

/* ---------------------------------------------------------
   2) HANDLE FORM SUBMISSIONS (interactivity)
   --------------------------------------------------------- */

// --- Even/Odd + Grade checker (CONDITIONS) ---
$numberResult = null;
$gradeResult  = null;
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["check_number"])) {
    $num = (int) $_POST["number"];

    // if / elseif / else
    if ($num % 2 === 0) {
        $numberResult = "$num is EVEN";
    } else {
        $numberResult = "$num is ODD";
    }

    $score = (int) $_POST["score"];
    // switch statement
    switch (true) {
        case $score >= 90:
            $gradeResult = "Grade A (Excellent)";
            break;
        case $score >= 75:
            $gradeResult = "Grade B (Good)";
            break;
        case $score >= 50:
            $gradeResult = "Grade C (Pass)";
            break;
        default:
            $gradeResult = "Grade F (Fail)";
    }
}

// --- Multiplication table (FOR LOOP) ---
$table = [];
$tableNum = isset($_POST["table_num"]) ? (int) $_POST["table_num"] : 5;
if ($tableNum < 1) $tableNum = 1;
if ($tableNum > 20) $tableNum = 20;
for ($i = 1; $i <= 10; $i++) {
    $table[] = "$tableNum x $i = " . ($tableNum * $i);
}

// --- Countdown (WHILE LOOP) ---
$countFrom = isset($_POST["count_from"]) ? (int) $_POST["count_from"] : 10;
if ($countFrom < 1) $countFrom = 1;
if ($countFrom > 30) $countFrom = 30;
$countdown = [];
$c = $countFrom;
while ($c >= 0) {
    $countdown[] = $c;
    $c--;
}

// --- Word list (FOREACH LOOP) ---
$wordsInput = isset($_POST["words"]) && trim($_POST["words"]) !== ""
    ? $_POST["words"]
    : "apple, banana, cherry";
$wordsArray = array_map('trim', explode(",", $wordsInput));
$wordListHtml = [];
foreach ($wordsArray as $index => $word) {
    if ($word === "") continue;
    $wordListHtml[] = ($index + 1) . ". " . htmlspecialchars(ucfirst($word)) . " (" . strlen($word) . " letters)";
}

// FizzBuzz demo (loop + condition combined), fixed range 1-20
$fizzbuzz = [];
for ($n = 1; $n <= 20; $n++) {
    if ($n % 15 === 0) {
        $fizzbuzz[] = "FizzBuzz";
    } elseif ($n % 3 === 0) {
        $fizzbuzz[] = "Fizz";
    } elseif ($n % 5 === 0) {
        $fizzbuzz[] = "Buzz";
    } else {
        $fizzbuzz[] = (string) $n;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($siteName) ?> — PHP Demo</title>
<style>
  :root{
    --bg:#0f1117; --card:#171a23; --border:#2a2f3d;
    --text:#e7e9ee; --muted:#9aa1b2; --accent:#7c9cff; --accent2:#5ee6c0;
  }
  *{box-sizing:border-box}
  body{
    margin:0; padding:40px 20px; background:var(--bg); color:var(--text);
    font-family:-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;
    line-height:1.5;
  }
  .wrap{max-width:960px;margin:0 auto}
  h1{font-size:1.9rem;margin-bottom:4px}
  .sub{color:var(--muted);margin-top:0;margin-bottom:32px}
  .grid{display:grid;grid-template-columns:1fr 1fr;gap:24px}
  @media (max-width:760px){.grid{grid-template-columns:1fr}}
  .card{
    background:var(--card); border:1px solid var(--border); border-radius:14px;
    padding:22px 24px; margin-bottom:24px;
  }
  .card h2{margin-top:0;font-size:1.1rem;color:var(--accent)}
  .tag{
    display:inline-block; font-size:.7rem; text-transform:uppercase; letter-spacing:.05em;
    background:rgba(124,156,255,.15); color:var(--accent); padding:2px 8px; border-radius:20px;
    margin-bottom:10px;
  }
  code, pre{
    background:#0b0d13; border:1px solid var(--border); border-radius:8px;
    padding:2px 6px; font-size:.85em; color:var(--accent2);
  }
  pre{padding:12px; overflow-x:auto}
  label{display:block; font-size:.85rem; color:var(--muted); margin-bottom:4px; margin-top:12px}
  input[type=text], input[type=number]{
    width:100%; padding:9px 10px; border-radius:8px; border:1px solid var(--border);
    background:#0b0d13; color:var(--text); font-size:.95rem;
  }
  button{
    margin-top:14px; padding:10px 18px; border:none; border-radius:8px;
    background:var(--accent); color:#0b0d13; font-weight:600; cursor:pointer; font-size:.9rem;
  }
  button:hover{opacity:.9}
  .result{
    margin-top:14px; padding:12px 14px; border-radius:10px;
    background:rgba(94,230,192,.1); border:1px solid rgba(94,230,192,.3);
    color:var(--accent2); font-weight:600;
  }
  ul.plain{list-style:none;padding:0;margin:0}
  ul.plain li{
    padding:4px 0; border-bottom:1px dashed var(--border); font-size:.9rem;
  }
  ul.plain li:last-child{border-bottom:none}
  .chip{
    display:inline-block; padding:5px 10px; margin:3px; border-radius:8px;
    background:#0b0d13; border:1px solid var(--border); font-size:.85rem;
  }
  .chip.fizz{color:#ffb454;border-color:#ffb45455}
  .chip.buzz{color:#7c9cff;border-color:#7c9cff55}
  .chip.fizzbuzz{color:var(--accent2);border-color:#5ee6c055}
  .row{display:flex; gap:12px; flex-wrap:wrap}
  .row > div{flex:1; min-width:140px}
  .footer-note{color:var(--muted); font-size:.8rem; margin-top:30px; text-align:center}
</style>
</head>
<body>
<div class="wrap">

  <h1>🐘 <?= htmlspecialchars($siteName) ?></h1>
  <p class="sub">
    Version <?= $version ?> &middot;
    Free: <?= $isFree ? "Yes" : "No" ?> &middot;
    Covers: <?= implode(", ", $features) ?>
  </p>

  <div class="grid">

    <!-- ============ VARIABLES CARD ============ -->
    <div class="card">
      <span class="tag">Variables</span>
      <h2>Basic PHP Variables</h2>
      <p>These are defined once in the PHP code and printed below:</p>
      <pre>$siteName = "<?= htmlspecialchars($siteName) ?>";
$version  = <?= $version ?>;
$isFree   = <?= $isFree ? 'true' : 'false' ?>;
$features = [<?= "'" . implode("', '", $features) . "'" ?>];</pre>
      <ul class="plain">
        <li>String: <code><?= htmlspecialchars($siteName) ?></code></li>
        <li>Float: <code><?= $version ?></code></li>
        <li>Boolean: <code><?= var_export($isFree, true) ?></code></li>
        <li>Array count: <code><?= count($features) ?></code> items</li>
      </ul>
    </div>

    <!-- ============ CONDITIONS CARD ============ -->
    <div class="card">
      <span class="tag">Conditions</span>
      <h2>Even/Odd &amp; Grade Checker</h2>
      <form method="post">
        <div class="row">
          <div>
            <label>Enter a number</label>
            <input type="number" name="number" value="<?= isset($_POST['number']) ? htmlspecialchars($_POST['number']) : 7 ?>">
          </div>
          <div>
            <label>Enter a score (0-100)</label>
            <input type="number" name="score" value="<?= isset($_POST['score']) ? htmlspecialchars($_POST['score']) : 82 ?>">
          </div>
        </div>
        <button type="submit" name="check_number" value="1">Check</button>
      </form>
      <?php if ($numberResult): ?>
        <div class="result"><?= htmlspecialchars($numberResult) ?></div>
        <div class="result"><?= htmlspecialchars($gradeResult) ?></div>
      <?php endif; ?>
    </div>

    <!-- ============ FOR LOOP CARD ============ -->
    <div class="card">
      <span class="tag">For Loop</span>
      <h2>Multiplication Table</h2>
      <form method="post">
        <label>Table for number</label>
        <input type="number" name="table_num" value="<?= $tableNum ?>">
        <button type="submit">Generate</button>
      </form>
      <ul class="plain">
        <?php foreach ($table as $line): ?>
          <li><?= htmlspecialchars($line) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <!-- ============ WHILE LOOP CARD ============ -->
    <div class="card">
      <span class="tag">While Loop</span>
      <h2>Countdown</h2>
      <form method="post">
        <label>Count down from</label>
        <input type="number" name="count_from" value="<?= $countFrom ?>">
        <button type="submit">Countdown</button>
      </form>
      <p style="margin-top:14px">
        <?php foreach ($countdown as $val): ?>
          <span class="chip"><?= $val ?></span>
        <?php endforeach; ?>
        🚀
      </p>
    </div>

    <!-- ============ FOREACH LOOP CARD ============ -->
    <div class="card">
      <span class="tag">Foreach Loop</span>
      <h2>Word Inspector</h2>
      <form method="post">
        <label>Comma-separated words</label>
        <input type="text" name="words" value="<?= htmlspecialchars($wordsInput) ?>">
        <button type="submit">Inspect</button>
      </form>
      <ul class="plain">
        <?php foreach ($wordListHtml as $item): ?>
          <li><?= $item ?></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <!-- ============ COMBINED DEMO CARD ============ -->
    <div class="card">
      <span class="tag">Loop + Condition</span>
      <h2>FizzBuzz (1–20)</h2>
      <p>Classic combo: a <code>for</code> loop with <code>if/elseif/else</code> inside.</p>
      <div>
        <?php foreach ($fizzbuzz as $n => $val): ?>
          <?php
            $class = "chip";
            if ($val === "Fizz") $class .= " fizz";
            elseif ($val === "Buzz") $class .= " buzz";
            elseif ($val === "FizzBuzz") $class .= " fizzbuzz";
          ?>
          <span class="<?= $class ?>"><?= htmlspecialchars($val) ?></span>
        <?php endforeach; ?>
      </div>
    </div>

  </div>

  <p class="footer-note">
    Single-file PHP demo &middot; run locally with <code>php -S localhost:8000</code>
  </p>
</div>
</body>
</html>
