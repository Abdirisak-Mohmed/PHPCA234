<?php

echo '<div style="font-family:Arial,Helvetica,sans-serif; background:#f4f7fb; padding:30px; color:#222; max-width:1000px; margin:20px auto; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1);">';

echo '<h1 style="text-align:center; color:#123c69; margin-bottom:10px;">Jamhuriya University of Science and Technology</h1>';
echo '<p style="text-align:center; color:#666; font-size:16px; margin-bottom:30px;">PHP & MySQL - Assignment 1</p>';


// Function for section headings
function heading($number, $title) {
    echo '<h2 style="
        background:#123c69;
        color:white;
        padding:12px 15px;
        border-radius:6px;
        font-size:20px;
        margin-top:25px;
        box-shadow:0 2px 5px rgba(0,0,0,0.15);
    ">Question ' . $number . ': ' . $title . '</h2>';
}

function outputBox() {
    echo '<div style="
        background:white;
        border-left:5px solid #1d70a2;
        padding:15px 20px;
        margin-top:10px;
        margin-bottom:20px;
        border-radius:5px;
        line-height:1.8;
        box-shadow:0 2px 8px rgba(0,0,0,0.06);
    ">';
}


// Question 1
heading(1, 'Compare three integers - greatest and smallest (no min/max)');

$a = 15;
$b = 42;
$c = 7;

// Find greatest
if ($a >= $b && $a >= $c) {
    $greatest = $a;
} elseif ($b >= $a && $b >= $c) {
    $greatest = $b;
} else {
    $greatest = $c;
}

// Find smallest
if ($a <= $b && $a <= $c) {
    $smallest = $a;
} elseif ($b <= $a && $b <= $c) {
    $smallest = $b;
} else {
    $smallest = $c;
}

outputBox();
echo "Numbers: <strong>$a, $b, $c</strong><br>";
echo "Greatest: <strong style='color:green;'>$greatest</strong><br>";
echo "Smallest: <strong style='color:#d9534f;'>$smallest</strong>";
echo '</div>';


// Question 2
heading(2, 'Divisible by 3, 5, both, or none');

$num2 = 30;

outputBox();

if ($num2 % 3 == 0 && $num2 % 5 == 0) {
    echo "<strong>$num2</strong> is divisible by <span style='color:green;'>both 3 and 5</span>";
} elseif ($num2 % 3 == 0) {
    echo "<strong>$num2</strong> is divisible by <span style='color:green;'>3 only</span>";
} elseif ($num2 % 5 == 0) {
    echo "<strong>$num2</strong> is divisible by <span style='color:green;'>5 only</span>";
} else {
    echo "<strong>$num2</strong> is not divisible by 3 or 5";
}

echo '</div>';


// Question 3
heading(3, 'Odd numbers 2-20 and Even numbers 35 down to 7');

outputBox();

echo "<strong style='color:#123c69;'>Odd numbers from 2 to 20:</strong><br>";

for ($i = 2; $i <= 20; $i++) {
    if ($i % 2 != 0) {
        echo '<span style="
            display:inline-block;
            background:#e8f1f8;
            color:#123c69;
            padding:5px 9px;
            margin:3px;
            border-radius:4px;
            font-weight:bold;
        ">' . $i . '</span>';
    }
}

echo "<br><br><strong style='color:#123c69;'>Even numbers from 35 down to 7:</strong><br>";

for ($i = 35; $i >= 7; $i--) {
    if ($i % 2 == 0) {
        echo '<span style="
            display:inline-block;
            background:#e9f7ef;
            color:#198754;
            padding:5px 9px;
            margin:3px;
            border-radius:4px;
            font-weight:bold;
        ">' . $i . '</span>';
    }
}

echo '</div>';


// Question 4
heading(4, 'Divisible by 2 and 5 at the same time, from 50 to 2');

outputBox();

for ($i = 50; $i >= 2; $i--) {
    if ($i % 2 == 0 && $i % 5 == 0) {
        echo '<span style="
            display:inline-block;
            background:#fff3cd;
            color:#856404;
            padding:6px 10px;
            margin:3px;
            border-radius:4px;
            font-weight:bold;
        ">' . $i . '</span>';
    }
}

echo '</div>';


// Question 5
heading(5, 'Reverse of a number (no strrev)');

$number5 = 12345;
$temp = $number5;
$reversed = 0;

while ($temp != 0) {
    $lastDigit = $temp % 10;
    $reversed = ($reversed * 10) + $lastDigit;
    $temp = (int)($temp / 10);
}

outputBox();

echo "Original number: <strong>$number5</strong><br>";
echo "Reversed number: <strong style='color:#198754;'>$reversed</strong>";

echo '</div>';


// Question 6
heading(6, 'LCM of two positive integers');

$x6 = 8;
$y6 = 12;

$max6 = ($x6 > $y6) ? $x6 : $y6;
$lcm = $max6;

while (true) {
    if ($lcm % $x6 == 0 && $lcm % $y6 == 0) {
        break;
    }
    $lcm += $max6;
}

outputBox();

echo "LCM of <strong>$x6</strong> and <strong>$y6</strong> = ";
echo "<strong style='color:green;'>$lcm</strong>";

echo '</div>';


// Question 7
heading(7, 'HCF (GCD) of two integers');

$x7 = 18;
$y7 = 24;

$hcf = 1;
$smallerOf = ($x7 < $y7) ? $x7 : $y7;

for ($i = 1; $i <= $smallerOf; $i++) {
    if ($x7 % $i == 0 && $y7 % $i == 0) {
        $hcf = $i;
    }
}

outputBox();

echo "HCF of <strong>$x7</strong> and <strong>$y7</strong> = ";
echo "<strong style='color:green;'>$hcf</strong>";

echo '</div>';


// Question 8
heading(8, 'Multiplication table (12 x 12)');

echo '<div style="overflow-x:auto; background:white; padding:15px; border-radius:6px; box-shadow:0 2px 8px rgba(0,0,0,0.06);">';

echo '<table border="1" cellpadding="8" cellspacing="0" style="
    border-collapse:collapse;
    width:100%;
    text-align:center;
    color:#123c69;
    font-weight:bold;
    background:white;
">';

for ($row = 1; $row <= 12; $row++) {
    echo "<tr>";

    for ($col = 1; $col <= 12; $col++) {

        $background = (($row == 1 || $col == 1)
            ? '#123c69'
            : (($row + $col) % 2 == 0 ? '#f4f8fb' : '#ffffff'));

        $color = ($row == 1 || $col == 1) ? 'white' : '#123c69';

        echo '<td style="
            border:1px solid #b8c7d1;
            padding:8px;
            background:' . $background . ';
            color:' . $color . ';
        ">' . ($row * $col) . '</td>';
    }

    echo "</tr>";
}

echo '</table>';
echo '</div>';


// Question 9
heading(9, 'Prime or non-prime');

$num9 = 29;
$isPrime = true;

if ($num9 < 2) {
    $isPrime = false;
} else {
    for ($i = 2; $i <= $num9 / 2; $i++) {
        if ($num9 % $i == 0) {
            $isPrime = false;
            break;
        }
    }
}

outputBox();

if ($isPrime) {
    echo "<strong>$num9</strong> is <strong style='color:green;'>a prime number</strong>";
} else {
    echo "<strong>$num9</strong> is <strong style='color:#d9534f;'>a non-prime number</strong>";
}

echo '</div>';


// Question 10
heading(10, 'Prime numbers from 10 to 50');

outputBox();

for ($num = 10; $num <= 50; $num++) {

    $prime = true;

    if ($num < 2) {
        $prime = false;
    } else {
        for ($i = 2; $i <= $num / 2; $i++) {
            if ($num % $i == 0) {
                $prime = false;
                break;
            }
        }
    }

    if ($prime) {
        echo '<span style="
            display:inline-block;
            background:#dff5e5;
            color:#198754;
            padding:6px 10px;
            margin:3px;
            border-radius:4px;
            font-weight:bold;
        ">' . $num . '</span>';
    }
}

echo '</div>';


// Footer
echo '<div style="
    text-align:center;
    margin-top:30px;
    padding:15px;
    color:white;
    background:#123c69;
    border-radius:6px;
    font-size:14px;
">
    PHP & MySQL Assignment 1
</div>';

echo '</div>';
?>