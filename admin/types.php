<?php

session_start();

if (isset($_SESSION["loged_in"]) && $_SESSION["loged_in"] === "admin") {

    require $_SERVER["DOCUMENT_ROOT"] . "/news_task/services/Queries.php";
    $queryObject = new Queries;

    $typesName = $queryObject->loadData("SELECT * FROM news_type");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/news_task/styles/style.css">
    <title>News types</title>
</head>

<body>
    <?php
    require $_SERVER["DOCUMENT_ROOT"] . "/news_task/header.php";
    ?>
    <?php if (isset($_SESSION["loged_in"]) && $_SESSION["loged_in"] === "admin") : ?>
        <div class="types__content">
            <?php foreach ($typesName as $arrItem) : ?>
                <div class="types__content_item">
                    <p>
                        <?php print $arrItem["text"]; ?>
                    </p>
                    <form method="POST" action="/news_task/admin/edit_news_type.php">
                        <button name="edit_type" value="<?php print $arrItem["id"]; ?>">Edit</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php
    else :
    ?><h2>Not loged in as admin</h2>
    <?php
    endif;
    ?>
</body>

</html>