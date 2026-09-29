<?php
echo "<h2 style='color:blue;'>Single Dimensional Array</h2>";

$fruits = ["Apple", "Banana", "Orange", "Mango", "Watermelon"];

echo "<h3>My Fruits:</h3>";

echo "<ul style='color:green; font-size:18px;'>";

foreach ($fruits as $fruit) {
    echo "<li>$fruit</li>";
}

echo "</ul>";

echo "<p>Total fruits: <strong>" . count($fruits) . "</strong></p>";
?>
