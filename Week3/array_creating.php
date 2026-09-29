<?php
echo "<h2 style='color:blue;'>Creating an Array</h2>";

$students = array("Ali", "Ahmed", "Hassan", "Mohamed");

echo "<h3>Students:</h3>";

foreach ($students as $student) {
    echo "<p style='color:green;'>$student</p>";
}
?>
