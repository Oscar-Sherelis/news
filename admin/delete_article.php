<?php

session_start();

if (isset($_SESSION['loged_in']) && $_SESSION['loged_in'] === 'admin') {
    $message = '';
    if (isset($_POST['delete_article']) && is_int((int)$_POST['delete_article'])) {
        require $_SERVER['DOCUMENT_ROOT'] . "/news_task/services/Queries.php";
        $data = new Queries;
        $idInput = (int)$_POST['delete_article'];
        $news = $data->executionQuery("DELETE FROM news WHERE id= $idInput");
        $message = 'Deleted successfully';
    } else {
        $message = 'Invalid input';
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
    <title>Delete article</title>
</head>

<body>
    <?php if (isset($_SESSION['loged_in']) && $_SESSION['loged_in'] === 'admin') : ?>
        <?php
        require $_SERVER['DOCUMENT_ROOT'] . "/news_task/header.php";
        ?>
        <h2><?php print $message; ?></h2>
    <?php else : ?>
        <h2>Not loged in as admin</h2>
    <?php endif; ?>
</body>

</html>