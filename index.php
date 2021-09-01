<?php

session_start();
require $_SERVER['DOCUMENT_ROOT'] .
    "/news_task/services/Queries.php";
require $_SERVER['DOCUMENT_ROOT'] .
    "/news_task/services/Sanitizevalidate.php";
$sanitizeObject = new Sanitizevalidate;

$todayDate = date("Y-m-d H:i:s");
$data = new Queries;
// nw = news table
// nt = news_type table
$news = $data->loadData(
    "SELECT nw.id, nw.short, nt.text 
    FROM news nw, news_type nt 
    WHERE nw.visible_at <= '$todayDate'
    AND nw.visible = true 
    AND nw.type = nt.id 
    GROUP BY id"
);
$typesName = $data->loadData("SELECT * FROM news_type");

if (isset($_POST['news_type']) && isset($_POST['news_limit'])) {

    $newsType = $sanitizeObject->cleanInput($_POST['news_type'], 'int');
    $newsLimit = $sanitizeObject->cleanInput($_POST['news_limit'], 'int');

    $_POST['filter_form_error'] = '';
    $news = $data->loadData(
        "SELECT nw.id, nw.short, nt.text 
            FROM news nw, news_type nt 
            WHERE nw.visible_at <= '$todayDate' 
            AND nw.visible = true 
            AND nw.type = $newsType
            AND nw.type = nt.id 
            GROUP BY id
            LIMIT $newsLimit;",
    );
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/news_task/styles/style.css">
    <title>News</title>
</head>

<body>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . "/news_task/header.php";
    ?>
    <section class="news">
        <div class="filter_news">
            <form method="POST" class="news_limit_form">
                <select name="news_type">
                    <?php foreach ($typesName as $arr) : ?>
                        <option value="<?php print $arr['id']; ?>">
                            <?php print $arr['text']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="number" placeholder="Limit news number" name="news_limit" required>
                <button type="submit">Filter news</button>
            </form>
        </div>
        <div class="news__content">
            <?php foreach ($news as $arrItem) : ?>
                <div class="news__content_item">
                    <a href="<?php print './news.php?id=' . $arrItem['id']; ?>">
                        <?php print $arrItem['short'] . " (" .  $arrItem['text'] . ")"; ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</body>

</html>