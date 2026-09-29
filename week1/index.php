<?php
// index.php

// Handle form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $message = "Hello, " . $name . "! Welcome to my PHP page.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>My First PHP Page</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        form { margin-top: 20px; }
        input[type="text"] { padding: 8px; width: 200px; }
        input[type="submit"] { padding: 8px 12px; }
        .message { margin-top: 20px; font-weight: bold; color: green; }
    </style>
</head>
<body>
    <h1>Welcome to My PHP Page</h1>
    <p>This is a simple PHP example that greets you when you enter your name.</p>

    <form method="post" action="">
        <label for="name">Enter your name:</label><br>
        <input type="text" id="name" name="name" required>
        <input type="submit" value="Submit">
    </form>

    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
</body>
</html>
