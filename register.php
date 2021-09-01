<?php

session_start();

if (isset($_POST['user']) && isset($_POST['password'])) {

    require $_SERVER['DOCUMENT_ROOT'] .
        "/news_task/services/Sanitizevalidate.php";
    $sanitizeObject = new Sanitizevalidate;

    $user = $sanitizeObject->cleanInput($_POST['user'], 'string');
    $password = $sanitizeObject->cleanInput($_POST['password'], 'string');

    require $_SERVER['DOCUMENT_ROOT'] .
        "/news_task/services/Queries.php";

    $queryObject = new Queries;

    $message = '';
    if (
        $queryObject->checkIfUserExists(
            "SELECT * FROM users WHERE user = ? AND password = ?",
            [
                $user, $password
            ]
        ) > 0
    ) {
        $message = "User already exists";
    } else {
        $queryObject->executionQuery(
            "INSERT INTO users (user, password) VALUES (?, ?)",
            [
                $user, $password
            ]
        );
        $message = "Registered successfully";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/news_task/styles/style.css">
    <title>Register</title>
</head>

<body>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . "/news_task/header.php";
    ?>
    <section class="register">
        <?php if (isset($_SESSION['loged_in'])) : ?>
            <h3>Already logedin</h3>
        <?php else : ?>
            <form class="register__form">
                <h3>Register</h3>
                <input type="text" placeholder="username" name="user" required>
                <input type="password" placeholder="password" name="password" required>
                <button>Register</button>
            </form>
            <?php print $message; ?>
        <?php endif; ?>
    </section>
</body>

</html>