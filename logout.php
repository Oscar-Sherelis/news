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
    <title>Logout</title>
</head>

<body>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . "/news_task/header.php";
    ?>
    <?php if (isset($_SESSION['loged_in'])) : ?>
        <?php session_destroy(); ?>
        <div class='main'>You have been logged out. Please
            <a href='/news_task/index.php'>click here</a> to refresh the screen.
        <?php else : ?>
            <div class='main'>
                You cannot log out because you are not logged in
            <?php endif; ?>
</body>

</html>