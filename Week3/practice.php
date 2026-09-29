<?php

echo "<div style='font-family:Arial; padding:20px;'>";

echo "<h2 style='color:#123c69;'>PHP Array Practice</h2>";

$numbers = [15, 8, 25, 10, 30, 7, 18];

echo "<h3>Numbers:</h3>";

foreach ($numbers as $number) {
    echo "<span style='
        display:inline-block;
        background:#e8f1f8;
        color:#123c69;
        padding:8px 12px;
        margin:4px;
        border-radius:5px;
        font-weight:bold;
    '>$number</span>";
}

echo "<hr>";

echo "<p>Total numbers: <strong>" . count($numbers) . "</strong></p>";

echo "<p>First number: <strong>" . $numbers[0] . "</strong></p>";

echo "<p>Last number: <strong>" . $numbers[count($numbers) - 1] . "</strong></p>";

// Find the largest number
$largest = $numbers[0];

foreach ($numbers as $number) {
    if ($number > $largest) {
        $largest = $number;
    }
}

echo "<p style='color:green;'>
        Largest number: <strong>$largest</strong>
      </p>";

// Find the smallest number
$smallest = $numbers[0];

foreach ($numbers as $number) {
    if ($number < $smallest) {
        $smallest = $number;
    }
}

echo "<p style='color:red;'>
        Smallest number: <strong>$smallest</strong>
      </p>";

echo "</div>";

?>
