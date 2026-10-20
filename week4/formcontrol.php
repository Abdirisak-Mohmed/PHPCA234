<?php
$errors = [];
$submitted = $_SERVER['REQUEST_METHOD'] === 'POST';
$values = $submitted ? $_POST : [];
$subjects = [
    'math' => 'Mathematics',
    'science' => 'Science',
    'history' => 'History',
    'computer' => 'Computer Science',
    'arts' => 'Arts',
];
$genders = ['male', 'female', 'other'];

function formValue(string $name): string
{
    global $values;
    return htmlspecialchars((string) ($values[$name] ?? ''), ENT_QUOTES, 'UTF-8');
}

if ($submitted) {
    foreach (['firstname' => 'First name', 'lastname' => 'Last name', 'email' => 'Email address', 'birth' => 'Age', 'password' => 'Password'] as $field => $label) {
        if (trim((string) ($values[$field] ?? '')) === '') {
            $errors[$field] = $label . ' is required.';
        }
    }

    if (!empty($values['email']) && !filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Enter a valid email address.';
    }

    $phone = trim((string) ($values['phone'] ?? ''));
    if ($phone === '') {
        $errors['phone'] = 'Phone number is required.';
    } elseif (!preg_match('/^\+?[0-9\s\-()]{7,20}$/', $phone)) {
        $errors['phone'] = 'Enter a valid phone number.';
    } elseif (!empty($values['phone'])) {
        $phoneDigits = preg_replace('/\D/', '', $values['phone']);
        if (strlen($phoneDigits) < 7 || strlen($phoneDigits) > 15) {
            $errors['phone'] = 'Phone number must be between 7 and 15 digits.';
        }
    } else {
        $errors['phone'] = 'Phone number is required.';
    }

    if (isset($values['birth']) && $values['birth'] !== '' && (!filter_var($values['birth'], FILTER_VALIDATE_INT) || (int) $values['birth'] < 1 || (int) $values['birth'] > 100)) {
        $errors['birth'] = 'Age must be a whole number between 1 and 100.';
    }

    if (!isset($values['gender']) || !in_array($values['gender'], $genders, true)) {
        $errors['gender'] = 'Choose a valid gender.';
    }

    if (!isset($values['subject']) || !in_array($values['subject'], array_keys($subjects), true)) {
        $errors['subject'] = 'Choose a valid field of study.';
    }

    if (!isset($values['terms'])) {
        $errors['terms'] = 'You must agree to the terms and conditions.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #eef3ff, #f8f9fa);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .register-box {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 520px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .sub-title {
            text-align: center;
            color: #666;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-group {
            flex: 1;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
            color: #333;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
        }

        textarea {
            resize: vertical;
            min-height: 90px;
        }

        .checkbox-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 10px 0 20px;
            font-size: 14px;
        }

        .checkbox-row input {
            width: auto;
            margin: 0;
        }

        .field-error {
            display: block;
            color: #b02a37;
            font-size: 13px;
            margin: -10px 0 15px;
        }

        .button-group {
            display: flex;
            gap: 10px;
        }

        button {
            flex: 1;
            background: #28a745;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #218838;
        }

        .reset-btn {
            background: #dc3545;
        }

        .reset-btn:hover {
            background: #c82333;
        }
    </style>
</head>

<body>
    <div class="register-box">
        <h2>Create Your Account</h2>
        <p class="sub-title">Please fill in this form to register</p>

        <?php if ($submitted && !$errors): ?>
            <p role="status" style="color: #218838;">Registration form submitted successfully.</p>
        <?php endif; ?>

        <form action="#" method="POST" novalidate>
            <div class="form-row">
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" id="firstname" name="firstname" placeholder="Enter first name" value="<?= formValue('firstname') ?>">
                    <?php if (isset($errors['firstname'])): ?><small class="field-error" role="alert"><?= htmlspecialchars($errors['firstname'], ENT_QUOTES, 'UTF-8') ?></small><?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" id="lastname" name="lastname" placeholder="Enter last name" value="<?= formValue('lastname') ?>">
                    <?php if (isset($errors['lastname'])): ?><small class="field-error" role="alert"><?= htmlspecialchars($errors['lastname'], ENT_QUOTES, 'UTF-8') ?></small><?php endif; ?>
                </div>
            </div>

            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" value="<?= formValue('email') ?>">
            <?php if (isset($errors['email'])): ?><small class="field-error" role="alert"><?= htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8') ?></small><?php endif; ?>

            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="Enter phone number" value="<?= formValue('phone') ?>">
            <?php if (isset($errors['phone'])): ?><small class="field-error" role="alert"><?= htmlspecialchars($errors['phone'], ENT_QUOTES, 'UTF-8') ?></small><?php endif; ?>

            <div class="form-row">
                <div class="form-group">
                    <label for="birth">Age</label>
                    <input type="number" max="100" min="0" id="birth" name="birth" placeholder="Age" value="<?= formValue('birth') ?>">
                    <?php if (isset($errors['birth'])): ?><small class="field-error" role="alert"><?= htmlspecialchars($errors['birth'], ENT_QUOTES, 'UTF-8') ?></small><?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender">
                        <option value="male" <?= ($values['gender'] ?? '') === 'male' ? 'selected' : '' ?>>Male</option>
                        <option value="female" <?= ($values['gender'] ?? '') === 'female' ? 'selected' : '' ?>>Female</option>
                        <option value="other" <?= ($values['gender'] ?? '') === 'other' ? 'selected' : '' ?>>Other</option>
                    </select>
                    <?php if (isset($errors['gender'])): ?><small class="field-error" role="alert"><?= htmlspecialchars($errors['gender'], ENT_QUOTES, 'UTF-8') ?></small><?php endif; ?>
                </div>
            </div>

            <label for="subject">Field of Study</label>
            <select name="subject" id="subject">
                <?php foreach ($subjects as $value => $label): ?>
                    <option value="<?= $value ?>" <?= in_array($value, (array) ($values['subject'] ?? []), true) ? 'selected' : '' ?>><?= $label ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errors['subject'])): ?><small class="field-error" role="alert"><?= htmlspecialchars($errors['subject'], ENT_QUOTES, 'UTF-8') ?></small><?php endif; ?>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Create password">
            <?php if (isset($errors['password'])): ?><small class="field-error" role="alert"><?= htmlspecialchars($errors['password'], ENT_QUOTES, 'UTF-8') ?></small><?php endif; ?>

            <label for="address">Address</label>
            <textarea id="address" name="address" placeholder="Enter your address"><?= formValue('address') ?></textarea>
            <?php if (isset($errors['address'])): ?><small class="field-error" role="alert"><?= htmlspecialchars($errors['address'], ENT_QUOTES, 'UTF-8') ?></small><?php endif; ?>

            <div class="checkbox-row">
                <input type="checkbox" id="terms" name="terms" <?= isset($values['terms']) ? 'checked' : '' ?>>
                <label for="terms">I agree to the terms and conditions</label>
            </div>
            <?php if (isset($errors['terms'])): ?><small class="field-error" role="alert"><?= htmlspecialchars($errors['terms'], ENT_QUOTES, 'UTF-8') ?></small><?php endif; ?>

            <div class="button-group">
                <button type="submit">Register</button>
                <button type="reset" class="reset-btn">Reset</button>
            </div>
        </form>
    </div>
</body>

</html>