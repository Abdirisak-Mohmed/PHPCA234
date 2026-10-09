<?php


/* ================= COUNTRIES & CAPITALS ================= */
echo "<h2 class='tr-title'>Countries and their capitals</h2>";

$countries = array(
    "Somalia" => array("capital" => "Mogadishu"),
    "Kenya"   => array("capital" => "Nairobi"),
    "Egypt"   => array("capital" => "Cairo"),
    "France"  => array("capital" => "Paris"),
    "Japan"   => array("capital" => "Tokyo"),
    "Brazil"  => array("capital" => "Brasília"),
);

echo "<table class='transcript'>";
echo "<thead><tr><th>Country</th><th>Capital</th></tr></thead><tbody>";

foreach ($countries as $country => $info) {
    echo "<tr class='pass'>";
    echo "<td>$country</td>";
    echo "<td>{$info['capital']}</td>";
    echo "</tr>";
}

echo "</tbody></table>";

function getCapital($countryName, $countries)
{
    // Make the search case-insensitive: "kenya", "KENYA" and "Kenya" all work
    $countryName = ucwords(strtolower(trim($countryName)));

    if (isset($countries[$countryName])) {
        return $countries[$countryName]["capital"];
    }

    return "Capital not found";
}

/* Examples */
echo "The capital of Somalia is " . getCapital("Somalia", $countries) . "<br>";
echo "The capital of kenya is "   . getCapital("kenya", $countries)   . "<br>";
echo "The capital of Japan is "   . getCapital("Japan", $countries)   . "<br>";
echo "The capital of Peru is "    . getCapital("Peru", $countries)    . "<br>";


echo "<h2 class='tr-title'>Question 5: Student transcript</h2>";

$transcript = array(
    "Semester 1" => array(
        array("subject1", 9, 26, 10, 40),
        array("subject2", 9, 26, 10, 40),
        array("subject3", 9, 26, 10, 10),
    ),
    "Semester 2" => array(
        array("subject1", 9, 26, 10, 0),
        array("subject2", 9, 26, 10, 40),
        array("subject3", 9, 26, 10, 40),
    ),
);



// Define pass mark and warning limit for styling
$passMark  = 50;   // below this = red
$warnLimit = 60;   // pass mark up to this = yellow

echo "
<style>
    .tr-title {
        font-family: 'Segoe UI', Arial, sans-serif;
        color: #1e293b;
        text-align: center;
        margin: 30px 0 15px;
    }
    .transcript {
        width: 90%;
        max-width: 900px;
        margin: 0 auto 40px;
        border-collapse: separate;
        border-spacing: 0;
        font-family: 'Segoe UI', Arial, sans-serif;
        font-size: 15px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.12);
    }
    .transcript thead th {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: #fff;
        padding: 14px 12px;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.8px;
    }
    .transcript td, .transcript tbody th {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #e2e8f0;
    }
    .transcript td:first-of-type { font-weight: 600; text-align: left; padding-left: 18px; }
    .transcript tbody th {
        background: #eef2ff;
        color: #4338ca;
        font-size: 15px;
        border-right: 3px solid #4f46e5;
        width: 120px;
    }
    .transcript td { background: #fff; transition: filter 0.2s; }
    .transcript tr:hover td { filter: brightness(0.96); }

    /* Row colours (start from the subject cell) */
    .transcript tr.fail td { background: #fee2e2; color: #991b1b; }
    .transcript tr.warn td { background: #fef9c3; color: #854d0e; }
    .transcript tr.fail td:first-of-type { border-left: 5px solid #dc2626; }
    .transcript tr.warn td:first-of-type { border-left: 5px solid #eab308; }
    .transcript tr.pass td:first-of-type { border-left: 5px solid #22c55e; }

    .transcript tbody tr:last-child td,
    .transcript tbody tr:last-child th { border-bottom: none; }

    .badge {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        color: #fff;
    }
    .badge.pass { background: #16a34a; }
    .badge.fail { background: #dc2626; }
</style>";

echo "<table class='transcript'>";
echo "<thead><tr><th>Semester</th><th>Course</th><th>CW1</th><th>MidTerm</th><th>CW2</th><th>Final</th><th>Total</th><th>Status</th></tr></thead><tbody>";

foreach ($transcript as $sem => $courses) {
    $first = true;
    foreach ($courses as $c) {
        $total  = $c[1] + $c[2] + $c[3] + $c[4];
        $status = ($total >= $passMark) ? "Pass" : "Fail";

        if ($total < $passMark) {
            $class = "fail";
        } elseif ($total < $warnLimit) {
            $class = "warn";
        } else {
            $class = "pass";
        }

        $badge = strtolower($status);

        echo "<tr class='$class'>";
        if ($first) {
            echo "<th rowspan='" . count($courses) . "'>$sem</th>";
            $first = false;
        }
        echo "<td>{$c[0]}</td><td>{$c[1]}</td><td>{$c[2]}</td><td>{$c[3]}</td><td>{$c[4]}</td>";
        echo "<td><strong>$total</strong></td><td><span class='badge $badge'>$status</span></td></tr>";
    }
}
echo "</tbody></table>";

?>
