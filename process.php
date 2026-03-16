<?php
// ── 1. Only run when form is submitted ──────────────────────────
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ── 2. Collect & sanitize inputs ────────────────────────────
    $first_name = htmlspecialchars(trim($_POST["first_name"] ?? ""));
    $last_name  = htmlspecialchars(trim($_POST["last_name"]  ?? ""));
    $age        = htmlspecialchars(trim($_POST["age"]        ?? ""));
    $email      = htmlspecialchars(trim($_POST["email"]      ?? ""));
    $course     = htmlspecialchars(trim($_POST["course"]     ?? ""));
    $gender     = htmlspecialchars(trim($_POST["gender"]     ?? ""));
    $hobbies    = isset($_POST["hobbies"]) ? $_POST["hobbies"] : [];

    // ── 3. Validation ────────────────────────────────────────────
    $errors = [];

    if (empty($first_name)) $errors[] = "First name is required.";
    if (empty($last_name))  $errors[] = "Last name is required.";

    if (empty($age) || !is_numeric($age) || $age < 1 || $age > 120)
        $errors[] = "Please enter a valid age.";

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors[] = "Please enter a valid email address.";

    if (empty($course))  $errors[] = "Please select a course.";
    if (empty($gender))  $errors[] = "Please select a gender.";

    // ── 4. Show errors OR success ────────────────────────────────
    if (!empty($errors)) {
        // Show error messages
        echo "<h2>Please fix the following errors:</h2><ul>";
        foreach ($errors as $error) {
            echo "<li style='color:red; font-size: 14px; font-family: Arial;'>$error</li>";
        }

        echo "</ul>";
        echo "<a href='index.html'>← Go Back</a>";

    } else {
        // ── 5. Display submitted info ────────────────────────────
        $full_name     = $first_name . " " . $last_name;
        $hobbies_list  = !empty($hobbies) ? implode(", ", $hobbies) : "None";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Successful</title>
    <style>
        body { font-family: Arial; background: #eed1b5; display: flex;
               justify-content: center; padding: 40px; }
        .card { background: white; border-radius: 12px; padding: 40px;
                max-width: 500px; width: 100%; box-shadow: 0 4px 20px rgba(0,0,0,0.1); display: flex; flex-direction: column; align-items: center; }
        h2 { color: #6b5c45; }
        .row { margin: 10px 0; font-size: 15px; }
        .label { color: #999; font-size: 13px; }
        .back-btn { display: inline-block; margin-top: 20px; padding: 10px 20px;
                    background: #7a6a55; color: white; border-radius: 8px;
                    text-decoration: none; }
    </style>
</head>
<body>
<div class="card">
    <h2> Registration Successful, <?= $first_name ?>!</h2>
    <p>Here is your submitted information:</p>
    <hr>
    <div class="row"><span class="label">Full Name</span><br><?= $full_name ?></div>
    <div class="row"><span class="label">Age</span><br><?= $age ?></div>
    <div class="row"><span class="label">Email</span><br><?= $email ?></div>
    <div class="row"><span class="label">Course</span><br><?= $course ?></div>
    <div class="row"><span class="label">Gender</span><br><?= $gender ?></div>
    <div class="row"><span class="label">Hobbies</span><br><?= $hobbies_list ?></div>
    <a href="index.html" class="back-btn">← Register Another</a>
</div>
</body>
</html>
<?php
    } // end else
} // end if POST
?>