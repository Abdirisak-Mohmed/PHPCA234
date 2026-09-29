<?php
/* ============================================================
   Interactive PHP Demo — Variables, Conditions, Loops
   Now with animations!
   Run with:  php -S localhost:8000   (or drop into XAMPP htdocs)
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
$gradePercent = 0;
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["check_number"])) {
    $num = (int) $_POST["number"];

    // if / elseif / else
    if ($num % 2 === 0) {
        $numberResult = "$num is EVEN";
    } else {
        $numberResult = "$num is ODD";
    }

    $score = (int) $_POST["score"];
    $gradePercent = max(0, min(100, $score));
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
    $table[] = ["expr" => "$tableNum x $i", "val" => $tableNum * $i];
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
    --bg:#0b0d14; --bg2:#0f0a1a; --card:#171a2688; --border:#2a2f3d;
    --text:#e7e9ee; --muted:#9aa1b2; --accent:#7c9cff; --accent2:#5ee6c0; --accent3:#ff8ad4;
  }
  *{box-sizing:border-box}
  html{scroll-behavior:smooth}
  body{
    margin:0; padding:60px 20px 40px; color:var(--text);
    font-family:-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;
    line-height:1.5; min-height:100vh; overflow-x:hidden;
    background: radial-gradient(circle at 20% 20%, #1c1440 0%, transparent 45%),
                radial-gradient(circle at 80% 0%, #0d2b33 0%, transparent 40%),
                radial-gradient(circle at 50% 100%, #2a1030 0%, transparent 45%),
                var(--bg);
    background-size:200% 200%;
    animation: bgShift 18s ease infinite;
    position:relative;
  }
  @keyframes bgShift{
    0%{background-position:0% 50%}
    50%{background-position:100% 50%}
    100%{background-position:0% 50%}
  }

  /* floating particles canvas sits behind everything */
  #particles{position:fixed; inset:0; z-index:0; pointer-events:none}

  .wrap{max-width:980px;margin:0 auto; position:relative; z-index:1}

  h1{
    font-size:2.2rem;margin-bottom:6px;
    background:linear-gradient(90deg, var(--accent), var(--accent2), var(--accent3), var(--accent));
    background-size:300% auto;
    -webkit-background-clip:text; background-clip:text; color:transparent;
    animation: gradientMove 6s linear infinite;
    display:inline-block;
  }
  @keyframes gradientMove{ to { background-position: 300% center; } }

  .sub{color:var(--muted);margin-top:0;margin-bottom:36px; opacity:0; animation: fadeUp .8s .2s ease forwards}

  @keyframes fadeUp{
    from{opacity:0; transform:translateY(14px)}
    to{opacity:1; transform:translateY(0)}
  }
  @keyframes fadeIn{ from{opacity:0} to{opacity:1} }
  @keyframes pop{
    0%{transform:scale(.85); opacity:0}
    100%{transform:scale(1); opacity:1}
  }
  @keyframes pulse{
    0%,100%{box-shadow:0 0 0 0 rgba(94,230,192,.45)}
    50%{box-shadow:0 0 0 8px rgba(94,230,192,0)}
  }
  @keyframes float{
    0%,100%{transform:translateY(0)}
    50%{transform:translateY(-6px)}
  }
  @keyframes spin{ to{transform:rotate(360deg)} }
  @keyframes shimmer{
    0%{background-position:-200% 0}
    100%{background-position:200% 0}
  }

  .grid{display:grid;grid-template-columns:1fr 1fr;gap:24px}
  @media (max-width:760px){.grid{grid-template-columns:1fr}}

  .card{
    background:var(--card); backdrop-filter: blur(10px);
    border:1px solid var(--border); border-radius:16px;
    padding:22px 24px; margin-bottom:24px;
    opacity:0; transform:translateY(24px);
    animation: fadeUp .7s ease forwards;
    transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease;
    position:relative; overflow:hidden;
  }
  .card:hover{
    transform: translateY(-6px);
    border-color: var(--accent);
    box-shadow: 0 14px 40px -12px rgba(124,156,255,.35);
  }
  .card::before{
    content:""; position:absolute; inset:0; padding:1px; border-radius:16px;
    background:linear-gradient(120deg, transparent, rgba(124,156,255,.4), transparent);
    background-size:200% 100%;
    -webkit-mask:linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor; mask-composite: exclude;
    opacity:0; transition:opacity .35s ease;
    animation: shimmer 3s linear infinite;
    pointer-events:none;
  }
  .card:hover::before{ opacity:1 }

  .card:nth-child(1){animation-delay:.05s}
  .card:nth-child(2){animation-delay:.15s}
  .card:nth-child(3){animation-delay:.25s}
  .card:nth-child(4){animation-delay:.35s}
  .card:nth-child(5){animation-delay:.45s}
  .card:nth-child(6){animation-delay:.55s}

  .card h2{margin-top:0;font-size:1.1rem;color:var(--accent)}
  .tag{
    display:inline-block; font-size:.7rem; text-transform:uppercase; letter-spacing:.05em;
    background:rgba(124,156,255,.15); color:var(--accent); padding:3px 10px; border-radius:20px;
    margin-bottom:10px; animation: float 3.5s ease-in-out infinite;
  }
  code, pre{
    background:#0b0d13; border:1px solid var(--border); border-radius:8px;
    padding:2px 6px; font-size:.85em; color:var(--accent2);
  }
  pre{padding:12px; overflow-x:auto}
  label{display:block; font-size:.85rem; color:var(--muted); margin-bottom:4px; margin-top:12px}
  input[type=text], input[type=number]{
    width:100%; padding:10px 12px; border-radius:8px; border:1px solid var(--border);
    background:#0b0d13; color:var(--text); font-size:.95rem;
    transition: border-color .25s ease, box-shadow .25s ease;
  }
  input:focus{
    outline:none; border-color:var(--accent);
    box-shadow: 0 0 0 3px rgba(124,156,255,.25);
  }
  button{
    margin-top:14px; padding:11px 20px; border:none; border-radius:8px;
    background:linear-gradient(120deg, var(--accent), var(--accent3));
    background-size:200% auto;
    color:#0b0d13; font-weight:700; cursor:pointer; font-size:.9rem;
    transition: background-position .5s ease, transform .15s ease;
    position:relative; overflow:hidden;
  }
  button:hover{ background-position:right center; transform:translateY(-2px) }
  button:active{ transform:translateY(0) scale(.97) }

  .result{
    margin-top:14px; padding:12px 14px; border-radius:10px;
    background:rgba(94,230,192,.1); border:1px solid rgba(94,230,192,.3);
    color:var(--accent2); font-weight:600;
    animation: pop .4s ease;
  }

  .progress-outer{
    margin-top:10px; height:10px; border-radius:6px; background:#0b0d13;
    border:1px solid var(--border); overflow:hidden;
  }
  .progress-inner{
    height:100%; border-radius:6px;
    background:linear-gradient(90deg, var(--accent2), var(--accent));
    width:0%;
    transition: width 1.1s cubic-bezier(.22,1,.36,1);
  }

  ul.plain{list-style:none;padding:0;margin:0}
  ul.plain li{
    padding:6px 4px; border-bottom:1px dashed var(--border); font-size:.9rem;
    opacity:0; transform:translateX(-8px);
    animation: slideIn .45s ease forwards;
  }
  @keyframes slideIn{ to{opacity:1; transform:translateX(0)} }
  ul.plain li:last-child{border-bottom:none}
  ul.plain li:nth-child(1){animation-delay:.03s}
  ul.plain li:nth-child(2){animation-delay:.08s}
  ul.plain li:nth-child(3){animation-delay:.13s}
  ul.plain li:nth-child(4){animation-delay:.18s}
  ul.plain li:nth-child(5){animation-delay:.23s}
  ul.plain li:nth-child(6){animation-delay:.28s}
  ul.plain li:nth-child(7){animation-delay:.33s}
  ul.plain li:nth-child(8){animation-delay:.38s}
  ul.plain li:nth-child(9){animation-delay:.43s}
  ul.plain li:nth-child(10){animation-delay:.48s}

  .chip{
    display:inline-block; padding:6px 11px; margin:3px; border-radius:8px;
    background:#0b0d13; border:1px solid var(--border); font-size:.85rem;
    opacity:0; animation: pop .4s ease forwards;
    transition: transform .2s ease;
  }
  .chip:hover{ transform: translateY(-4px) scale(1.08); cursor:default }
  .chip.fizz{color:#ffb454;border-color:#ffb45455}
  .chip.buzz{color:#7c9cff;border-color:#7c9cff55}
  .chip.fizzbuzz{
    color:var(--accent2);border-color:#5ee6c055;
    animation: pop .4s ease forwards, pulse 2s ease-in-out infinite 1s;
  }

  .row{display:flex; gap:12px; flex-wrap:wrap}
  .row > div{flex:1; min-width:140px}

  .footer-note{
    color:var(--muted); font-size:.8rem; margin-top:30px; text-align:center;
    opacity:0; animation: fadeIn 1s 1s ease forwards;
  }

  .spinner-emoji{ display:inline-block; animation: spin 4s linear infinite; }
</style>
</head>
<body>

<canvas id="particles"></canvas>

<div class="wrap">

  <h1><span class="spinner-emoji">🐘</span> <?= htmlspecialchars($siteName) ?></h1>
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
        <div class="result">
          <?= htmlspecialchars($gradeResult) ?>
          <div class="progress-outer">
            <div class="progress-inner" data-target="<?= $gradePercent ?>"></div>
          </div>
        </div>
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
        <?php foreach ($table as $row): ?>
          <li><?= htmlspecialchars($row['expr']) ?> = <strong><?= $row['val'] ?></strong></li>
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
        <?php foreach ($countdown as $i => $val): ?>
          <span class="chip" style="animation-delay: <?= $i * 0.05 ?>s"><?= $val ?></span>
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
          <span class="<?= $class ?>" style="animation-delay: <?= $n * 0.04 ?>s"><?= htmlspecialchars($val) ?></span>
        <?php endforeach; ?>
      </div>
    </div>

  </div>

  <p class="footer-note">
    Single-file PHP demo &middot; run locally with XAMPP or <code>php -S localhost:8000</code>
  </p>
</div>

<script>
  // Animate the progress bar width after render
  document.querySelectorAll('.progress-inner').forEach(el => {
    const target = el.getAttribute('data-target');
    requestAnimationFrame(() => {
      setTimeout(() => { el.style.width = target + '%'; }, 80);
    });
  });

  // Lightweight floating particle background (pure canvas, no libraries)
  (function () {
    const canvas = document.getElementById('particles');
    const ctx = canvas.getContext('2d');
    let w, h, particles;

    function resize() {
      w = canvas.width = window.innerWidth;
      h = canvas.height = window.innerHeight;
    }
    window.addEventListener('resize', resize);
    resize();

    const COLORS = ['#7c9cff', '#5ee6c0', '#ff8ad4'];
    const COUNT = Math.min(60, Math.floor((w * h) / 22000));

    particles = Array.from({ length: COUNT }, () => ({
      x: Math.random() * w,
      y: Math.random() * h,
      r: Math.random() * 1.8 + 0.6,
      vx: (Math.random() - 0.5) * 0.25,
      vy: (Math.random() - 0.5) * 0.25,
      color: COLORS[Math.floor(Math.random() * COLORS.length)],
      alpha: Math.random() * 0.5 + 0.2
    }));

    function tick() {
      ctx.clearRect(0, 0, w, h);
      particles.forEach(p => {
        p.x += p.vx; p.y += p.vy;
        if (p.x < 0) p.x = w; if (p.x > w) p.x = 0;
        if (p.y < 0) p.y = h; if (p.y > h) p.y = 0;
        ctx.beginPath();
        ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
        ctx.fillStyle = p.color;
        ctx.globalAlpha = p.alpha;
        ctx.fill();
      });
      ctx.globalAlpha = 1;
      requestAnimationFrame(tick);
    }
    tick();
  })();
</script>
</body>
</html>
