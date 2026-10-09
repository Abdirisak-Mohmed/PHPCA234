<?php
$countries = array(
    "Somalia" => array("capital" => "Mogadishu"),
    "Kenya"   => array("capital" => "Nairobi"),
    "Egypt"   => array("capital" => "Cairo"),
    "France"  => array("capital" => "Paris"),
    "Japan"   => array("capital" => "Tokyo"),
    "Brazil"  => array("capital" => "Brasília"),
);

function getCapital($countryName)
{
    global $countries;

    $countryName = ucwords(strtolower(trim($countryName)));

    if (isset($countries[$countryName])) {
        return $countries[$countryName]["capital"];
    }

    return "Capital not found";
}

/* Handle the search */
$search   = isset($_GET['country']) ? trim($_GET['country']) : "";
$result   = "";
$found    = false;
$matchKey = "";

if ($search !== "") {
    $result   = getCapital($search);
    $found    = ($result !== "Capital not found");
    $matchKey = ucwords(strtolower($search));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Country Capital Search</title>
<style>
    * { box-sizing: border-box; }
    body {
        margin: 0;
        min-height: 100vh;
        font-family: 'Segoe UI', Arial, sans-serif;
        background: linear-gradient(135deg, #eef2ff, #f5f3ff);
        color: #1e293b;
        padding: 40px 16px;
    }
    .container { max-width: 620px; margin: 0 auto; }
    h2 { text-align: center; margin: 0 0 6px; font-size: 28px; }
    .subtitle { text-align: center; color: #64748b; margin-bottom: 26px; }

    .search-box {
        display: flex;
        background: #fff;
        border-radius: 999px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.12);
        padding: 6px;
        border: 2px solid transparent;
        transition: border-color 0.2s;
    }
    .search-box:focus-within { border-color: #4f46e5; }
    .search-box input {
        flex: 1;
        border: none;
        outline: none;
        font-size: 16px;
        padding: 12px 20px;
        background: transparent;
        min-width: 0;
    }
    .search-box button {
        border: none;
        cursor: pointer;
        color: #fff;
        font-size: 15px;
        font-weight: 600;
        padding: 12px 28px;
        border-radius: 999px;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        transition: transform 0.15s, box-shadow 0.15s;
    }
    .search-box button:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
    }

    .result {
        margin: 24px 0;
        padding: 20px 24px;
        border-radius: 14px;
        text-align: center;
        font-size: 18px;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.1);
    }
    .result.ok   { background: #dcfce7; color: #166534; border-left: 6px solid #22c55e; }
    .result.fail { background: #fee2e2; color: #991b1b; border-left: 6px solid #dc2626; }
    .result strong { font-size: 24px; display: block; margin-top: 4px; }

    .countries {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.12);
        margin-top: 10px;
    }
    .countries th {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: #fff;
        padding: 14px 18px;
        text-align: left;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.8px;
    }
    .countries td {
        padding: 12px 18px;
        background: #fff;
        border-bottom: 1px solid #e2e8f0;
    }
    .countries td:first-child { font-weight: 600; border-left: 5px solid #22c55e; }
    .countries tr:hover td { background: #f8fafc; }
    .countries tr:last-child td { border-bottom: none; }
    .countries tr.match td { background: #fef9c3; color: #854d0e; }
    .countries tr.match td:first-child { border-left-color: #eab308; }
</style>
</head>
<body>
<div class="container">
    <h2>Country Capital Search</h2>
    <p class="subtitle">Type a country name to find its capital</p>

    <form method="get" class="search-box">
        <input type="text" name="country" placeholder="e.g. Kenya"
               value="<?php echo htmlspecialchars($search); ?>" autofocus>
        <button type="submit">Search</button>
    </form>

    <?php if ($search !== ""): ?>
        <?php if ($found): ?>
            <div class="result ok">
                The capital of <?php echo htmlspecialchars($matchKey); ?> is
                <strong><?php echo htmlspecialchars($result); ?></strong>
            </div>
        <?php else: ?>
            <div class="result fail">
                No capital found for "<?php echo htmlspecialchars($search); ?>"
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <table class="countries">
        <thead><tr><th>Country</th><th>Capital</th></tr></thead>
        <tbody>
        <?php foreach ($countries as $country => $info): ?>
            <tr class="<?php echo ($found && $country === $matchKey) ? 'match' : ''; ?>">
                <td><?php echo $country; ?></td>
                <td><?php echo $info['capital']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>