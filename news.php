<?php

session_start();

if (isset($_GET['id'])) {

    require $_SERVER['DOCUMENT_ROOT'] .
        "/news_task/services/Sanitizevalidate.php";
    $sanitizeObject = new Sanitizevalidate;
    $id = $sanitizeObject->cleanInput($_GET['id'], 'int');
    
    require $_SERVER['DOCUMENT_ROOT'] .
        "/news_task/services/Queries.php";
    $data = new Queries;
    $todayDate = date("Y-m-d H:i:s");
    $singleItemFromNewsTable = $data->loadData(
        "SELECT short, full_text, type, updated_at FROM news WHERE id = ? AND visible_at <= '$todayDate' AND visible = true",
        [
            $id
        ]
    );

    $newsTypeField = $singleItemFromNewsTable[0]['type'];
    $news_typeArr = $data->loadData("SELECT text FROM news_type WHERE id = '$newsTypeField'");
    $newsTypeName = $news_typeArr[0]['text'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/news_task/styles/style.css">
    <title>Single article</title>
</head>

<body>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . "/news_task/header.php";
    ?>
    <section class="single_info">
        <?php foreach ($singleItemFromNewsTable as $arr) : ?>
            <div class="single_info__container">
                <p class="last_update">Last update <?php print date('Y-m-d', strtotime($arr['updated_at'])); ?></p>
                <h2><?php print $arr['short']; ?></h2>
                <p class="news_type"></p>
                <p class="full_text"><?php print $arr['full_text']; ?></p>
            </div>
        <?php endforeach; ?>
    </section>
</body>

</html>