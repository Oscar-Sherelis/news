<?php

session_start();

if (!isset($_SESSION['loged_in']) || $_SESSION['loged_in'] !== 'admin') {
    $notLogedIn = 'Not logedin as admin';
}
require $_SERVER['DOCUMENT_ROOT'] . "/news_task/services/Queries.php";

$todayDate = date("Y-m-d H:i:s");
$data = new Queries;
$news = $data->loadData(
    "SELECT nw.id, nw.short, nt.text 
FROM news nw, news_type nt 
WHERE nw.visible_at <= '$todayDate' AND nw.visible = true AND nw.type = nt.id 
GROUP BY id"
);
$typesName = $data->loadData("SELECT * FROM news_type");

if (isset($_POST['news_type']) && isset($_POST['news_limit'])) {

    $newsType = filter_var($_POST['news_type'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $newsType = htmlentities($newsType, ENT_QUOTES, 'UTF-8');

    $newsLimit = filter_var($_POST['news_limit'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $newsLimit = htmlentities($newsLimit, ENT_QUOTES, 'UTF-8');

    if (is_int((int)$newsLimit) && is_int((int)$newsType)) {
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
    } else {
        $_POST['filter_form_error'] = 'Wrong input format';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Admin</title>
</head>

<body>
    <?php
    require '../header.php';
    ?>
    <?php if (!isset($notLogedIn)) : ?>
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
                <p class="filter_error">
                    <?php if (isset($_POST['filter_form_error'])) : ?>
                        <?php print $_POST['filter_form_error']; ?>
                    <?php endif; ?>
                </p>
            </form>
        </div>
        <div class="news__content">
            <?php foreach ($news as $arrItem) : ?>
                <a href="<?php print './news.php?id=' . $arrItem['id']; ?>">
                    <?php print $arrItem['short'] . " (" .  $arrItem['text'] . ")"; ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php
    elseif (isset($notLogedIn) && $notLogedIn === "Not logedin as admin") :
    ?><h2>Not loged in as admin</h2>
    <?php
    endif;
    ?>
</body>

</html>