<?php

echo "<h2 style='color:#123c69;'>PHP Loops</h2>";

echo "<h3>Numbers from 1 to 10</h3>";

for ($i = 1; $i <= 10; $i++) {
    echo "<span style='
        display:inline-block;
        background:#e8f1f8;
        color:#123c69;
        padding:8px 12px;
        margin:4px;
        border-radius:5px;
        font-weight:bold;
    '>$i</span>";
}

echo "<h3>Even Numbers</h3>";

for ($i = 2; $i <= 20; $i += 2) {
    echo "<span style='
        display:inline-block;
        background:#dff5e5;
        color:green;
        padding:8px 12px;
        margin:4px;
        border-radius:5px;
    '>$i</span>";
}

echo "<h3>Multiplication Table of 5</h3>";

for ($i = 1; $i <= 10; $i++) {
    $result = 5 * $i;

    echo "<p>5 × $i = <strong>$result</strong></p>";
}

?>
