<?php

$student = array(
    "CA234" => array("Name" => "Ahmed Ali", "Phone" => "618561650", "Address" => "Hodan KBB"),
    "CA235" => array("Name" => "Jamal Jamac", "Phone" => "610000000", "Address" => "Kaaraan Chelsi Village"),
    "CA233" => array("Name" => "Hussien Hassan", "Phone" => "611121210", "Address" => "Hodan KBB")
);

echo "<table border ='1'>";

echo "<tr>";
echo "<tr>Classes</tr>";
foreach ($student["CA233"] as $k => $v) {
    echo "<th>$k</th>";
}
echo "<tr/>";

foreach ($student as $k => $v) {
    echo "<tr>";
    echo "<td>$k</td>";
    foreach ($v as $key => $value) {
        echo "<td>$value</td>";
    }
    echo "</tr>";
};
