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

    // check if admin exists
    if (
        $queryObject->checkIfUserExists(
            "SELECT * FROM users WHERE user = ? AND password = ?",
            [
                $user, $password
            ]
        ) > 0
        && $user = 'admin'
    ) {
        $_SESSION['loged_in'] = $user;
        header("Location: /news_task/admin/admin.php");
    } else if ($queryObject->checkIfUserExists(
        "SELECT * FROM users WHERE user = ? AND password = ?",
        [
            $user, $password
        ]
    ) > 0) {
        $_SESSION['loged_in'] = $user;
        header("Location: /news_task/index.php");
    }
    $_SESSION['login_error'] = 'Wrong username or password';
    header("Location: /news_task/login.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/news_task/styles/style.css">
    <title>Login</title>
</head>

<body>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . "/news_task/header.php";
    ?>
    <section class="login">
        <form class="login__form" method="POST">
            <?php if (isset($_SESSION['loged_in'])) : ?>
                <h3>Already logedin</h3>
            <?php else : ?>
                <h3>Login</h3>
                <input type="text" name="user" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            <?php endif; ?>
        </form>
    </section>
</body>

</html>