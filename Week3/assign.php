<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>PHP Assignment 2</title>
<style>
  body { font-family: Arial, sans-serif; margin: 20px; }
  table { border-collapse: collapse; margin: 10px 0; }
  td, th { border: 1px solid #333; padding: 6px 12px; text-align: center; }
  th { background: #ddd; }
  .dark { background: #999; }
  h2 { margin-top: 40px; border-bottom: 2px solid #333; }
</style>
<link rel="stylesheet" href="style.css">
</head>
<body>

<?php
/* ================= QUESTION 1 ================= */
echo "<h2>Question 1: One-dimensional array</h2>";

$arr = array(5, -7, 12, 10, -7, 11, -6, 12, 1, -7, 2, 9);

echo "<b>Elements:</b> " . implode(", ", $arr) . "<br>";

$total = 0; $even = 0; $odd = 0;
foreach ($arr as $v) {
    $total += $v;
    if ($v % 2 == 0) $even += $v; else $odd += $v;
}
echo "Total of all elements = $total<br>";
echo "Total of even elements = $even<br>";
echo "Total of odd elements = $odd<br>";

$min = min($arr);
$max = max($arr);
$minPos = array_keys($arr, $min);
$maxPos = array_keys($arr, $max);

echo "Minimum element is $min in " . count($minPos) . " positions: " . implode(", ", $minPos) . "<br>";
echo "Maximum element is $max in " . count($maxPos) . " positions: " . implode(", ", $maxPos) . "<br>";


/* ================= QUESTION 2 ================= */
echo "<h2>Question 2: Colors (associative 2D array)</h2>";

$colors = array(
    "Light"  => array("Red" => "Light Red",  "Green" => "Light Green",  "Blue" => "Light Blue"),
    "Normal" => array("Red" => "Normal Red", "Green" => "Normal Green", "Blue" => "Normal Blue"),
    "Dark"   => array("Red" => "Dark Red",   "Green" => "Dark Green",   "Blue" => "Dark Blue"),
);

echo "<table><tr><th></th>";
foreach (array_keys($colors["Light"]) as $col) echo "<th>$col</th>";
echo "</tr>";
foreach ($colors as $row => $cells) {
    echo "<tr><th>$row</th>";
    foreach ($cells as $cell) echo "<td>$cell</td>";
    echo "</tr>";
}
echo "</table>";


/* ================= QUESTION 3 ================= */
echo "<h2>Question 3: Square array</h2>";

$m = array(
    array(2, -6, 8),
    array(-6, 1, 6),
    array(7, 8, -6),
);
$n = count($m);

$oddSum = 0; $evenSum = 0; $all = 0;
$rowSum = array_fill(0, $n, 0);
$colSum = array_fill(0, $n, 0);
$diag1 = 0; $diag2 = 0;

for ($i = 0; $i < $n; $i++) {
    for ($j = 0; $j < $n; $j++) {
        $v = $m[$i][$j];
        $all += $v;
        $rowSum[$i] += $v;
        $colSum[$j] += $v;
        if ($v % 2 == 0) $evenSum += $v; else $oddSum += $v;
        if ($i == $j) $diag1 += $v;            // main diagonal
        if ($i + $j == $n - 1) $diag2 += $v;   // anti diagonal
    }
}

// min / max and their positions
$minV = $maxV = $m[0][0];
foreach ($m as $r) { $minV = min($minV, min($r)); $maxV = max($maxV, max($r)); }
$minP = array(); $maxP = array();
for ($i = 0; $i < $n; $i++) {
    for ($j = 0; $j < $n; $j++) {
        if ($m[$i][$j] == $minV) $minP[] = "[$i,$j]";
        if ($m[$i][$j] == $maxV) $maxP[] = "[$i,$j]";
    }
}

$span = $n + 2;
echo "<table>";
echo "<tr><td colspan='$span'>Total odd elements = $oddSum</td></tr>";
echo "<tr><td colspan='$span'>Total even elements = $evenSum</td></tr>";

// top line: main diagonal | column totals | anti diagonal
echo "<tr><td class='dark'>$diag1</td>";
foreach ($colSum as $c) echo "<td>$c</td>";
echo "<td class='dark'>$diag2</td></tr>";

// matrix rows with row totals on both sides
for ($i = 0; $i < $n; $i++) {
    echo "<tr><td>{$rowSum[$i]}</td>";
    for ($j = 0; $j < $n; $j++) echo "<td>{$m[$i][$j]}</td>";
    echo "<td>{$rowSum[$i]}</td></tr>";
}

// bottom line: anti diagonal | column totals | main diagonal
echo "<tr><td class='dark'>$diag2</td>";
foreach ($colSum as $c) echo "<td>$c</td>";
echo "<td class='dark'>$diag1</td></tr>";

echo "<tr><td colspan='$span'>Total all elements = $all</td></tr>";
echo "<tr><td colspan='$span'>Min element is: $minV in " . count($minP) . " positions:<br>" . implode(", ", $minP) . "</td></tr>";
echo "<tr><td colspan='$span'>Maximum element is: $maxV in " . count($maxP) . " positions:<br>" . implode(", ", $maxP) . "</td></tr>";
echo "</table>";


/* ================= QUESTION 4 ================= */
echo "<h2>Question 4: Students (associative 2D array)</h2>";

/* Note: array keys must be unique. The assignment table repeats CA221,
   so the third row uses CA225 to avoid overwriting the first row. */
$students = array(
    "CA221" => array("Name" => "Mohamed Ahmed Ali", "Phone" => "0648440403", "Address" => "Laba Dhagax, Wardhiigley"),
    "CA223" => array("Name" => "Ahmed Abdi Jama",   "Phone" => "0647223201", "Address" => "Taleex, Hodan"),
    "CA225" => array("Name" => "Amina Nur Adan",    "Phone" => "0646990276", "Address" => "Macmacaanka, Dharkeynley"),
);

echo "<table><tr><th></th><th>Name</th><th>Phone</th><th>Address</th></tr>";
foreach ($students as $id => $info) {
    echo "<tr><th>$id</th>";
    foreach ($info as $value) echo "<td>$value</td>";
    echo "</tr>";
}
echo "</table>";


/* ================= QUESTION 5 ================= */
echo "<h2>Question 5: Student transcript</h2>";

$transcript = array(
    "Semester 1" => array(
        array("subject1", 9, 26, 10, 40),
        array("subject2", 9, 26, 10, 40),
        array("subject3", 9, 26, 10, 40),
    ),
    "Semester 2" => array(
        array("subject1", 9, 26, 10, 0),
        array("subject2", 9, 26, 10, 40),
        array("subject3", 9, 26, 10, 40),
    ),
);

echo "<table>";
echo "<tr><th>Semester</th><th>Course</th><th>CW1</th><th>MidTerm</th><th>CW2</th><th>Final</th><th>Total</th><th>Status</th></tr>";
foreach ($transcript as $sem => $courses) {
    $first = true;
    foreach ($courses as $c) {
        $total  = $c[1] + $c[2] + $c[3] + $c[4];
        $status = ($total >= 50) ? "Pass" : "Fail";
        echo "<tr>";
        if ($first) {
            echo "<th rowspan='" . count($courses) . "'>$sem</th>";
            $first = false;
        }
        echo "<td>{$c[0]}</td><td>{$c[1]}</td><td>{$c[2]}</td><td>{$c[3]}</td><td>{$c[4]}</td>";
        echo "<td>$total</td><td>$status</td></tr>";
    }
}
echo "</table>";
?>

</body>
</html>