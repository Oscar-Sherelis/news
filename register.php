<?php

session_start();

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
        <form class="register__form">
            <h3>Register</h3>
            <input type="text" name="user" required>
            <input type="password" name="password" required>
            <button type="submit">Register</button>
        </form>
    </section>
</body>

</html>