<?php

session_start();

$message = '';

if (isset($_SESSION["loged_in"]) && $_SESSION["loged_in"] === "admin") {

    require $_SERVER["DOCUMENT_ROOT"] .
        "/news_task/services/Sanitizevalidate.php";
    require $_SERVER["DOCUMENT_ROOT"] . "/news_task/services/Queries.php";

    $queryObject = new Queries;
    $sanitizeObject = new Sanitizevalidate;

    // if gets post req from types.php form
    if (isset($_POST["edit_type"])) {
        $newsTypeId = $sanitizeObject->cleanInput($_POST["edit_type"], "int");
        $typesName = $queryObject->loadData("SELECT * FROM news_type WHERE id = $newsTypeId");
    }

    if (isset($_POST["update_type_id"]) && isset($_POST["types_text"])) {
        $newsTypeId = $sanitizeObject->cleanInput($_POST["update_type_id"], "int");
        $typesText = $sanitizeObject->cleanInput($_POST["types_text"], "string");
        $updateType = $queryObject->executionQuery(
            "UPDATE news_type SET text = ? WHERE id = $newsTypeId",
            [$typesText]
        );
        $message = "Updated successfully";
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
    <title>Edit news types</title>
</head>

<body>
    <?php
    require $_SERVER["DOCUMENT_ROOT"] . "/news_task/header.php";
    ?>
    <?php if (isset($_SESSION["loged_in"]) && $_SESSION["loged_in"] === "admin") : ?>
        <div class="types__content">
            <?php if (isset($typesName)) : ?>
                <?php foreach ($typesName as $arrItem) : ?>
                    <div class="types__content_item">
                        <form method="POST">
                            <input type="text" name="types_text" value="<?php print $arrItem["text"]; ?>">
                            <button name="update_type_id" value="<?php print $arrItem["id"]; ?>">Update</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php print $message; ?>
        </div>
    <?php
    else :
    ?><h2>Not loged in as admin</h2>
    <?php
    endif;
    ?>
</body>

</html>