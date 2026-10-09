<?php
$capitals = array(
    "Somalia" => "Mogadishu",
    "Kenya"   => "Nairobi",
    "Egypt"   => "Cairo",
    "France"  => "Paris",
    "Japan"   => "Tokyo",
    "Brazil"  => "Brasília",
);

echo "
<style>
    .cap-table {
        width: 90%;
        max-width: 500px;
        margin: 30px auto;
        border-collapse: separate;
        border-spacing: 0;
        font-family: 'Segoe UI', Arial, sans-serif;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.12);
    }
    .cap-table th {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: #fff;
        padding: 14px 18px;
        text-align: left;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.8px;
    }
    .cap-table td {
        padding: 12px 18px;
        background: #fff;
        border-bottom: 1px solid #e2e8f0;
    }
    .cap-table td:first-child { font-weight: 600; border-left: 5px solid #22c55e; }
    .cap-table tr:hover td { background: #f8fafc; }
    .cap-table tr:last-child td { border-bottom: none; }
</style>";

echo "<table class='cap-table'>";
echo "<thead><tr><th>Country</th><th>Capital</th></tr></thead><tbody>";

foreach ($capitals as $country => $capital) {
    echo "<tr><td>$country</td><td>$capital</td></tr>";
}

echo "</tbody></table>";
?>