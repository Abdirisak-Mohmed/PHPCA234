<?php

echo "<h2 style='color:#123c69;'>PHP Conditions</h2>";

$name = "Ahmed";
$age = 20;
$mark = 75;

echo "<p>Name: <strong>$name</strong></p>";
echo "<p>Age: <strong>$age</strong></p>";
echo "<p>Mark: <strong>$mark</strong></p>";

if ($mark >= 80) {
    echo "<p style='color:green;'>Grade: A</p>";
} elseif ($mark >= 70) {
    echo "<p style='color:blue;'>Grade: B</p>";
} elseif ($mark >= 60) {
    echo "<p style='color:orange;'>Grade: C</p>";
} elseif ($mark >= 50) {
    echo "<p style='color:brown;'>Grade: D</p>";
} else {
    echo "<p style='color:red;'>Grade: F - Failed</p>";
}

?>
