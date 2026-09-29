<?php
echo "<h2 style='color:blue;'>Two-Dimensional Array</h2>";

$students = [
    ["Ali", 20, "Computer Science"],
    ["Ahmed", 22, "Information Technology"],
    ["Hassan", 21, "Software Engineering"],
    ["Mohamed", 23, "Computer Science"]
];

echo "<table border='1' cellpadding='10' cellspacing='0' 
style='border-collapse:collapse; width:70%; text-align:center;'>";

echo "<tr style='background-color:#123c69; color:white;'>";
echo "<th>Name</th>";
echo "<th>Age</th>";
echo "<th>Department</th>";
echo "</tr>";

foreach ($students as $student) {
    echo "<tr>";
    echo "<td>$student[0]</td>";
    echo "<td>$student[1]</td>";
    echo "<td>$student[2]</td>";
    echo "</tr>";
}

echo "</table>";

$students = [
    ["Ali", 20, "Computer Science"],
    ["Ahmed", 22, "Information Technology"]
];

?>
