<?php

session_start();

$message = "";

if (isset($_SESSION['loged_in']) && $_SESSION['loged_in'] === 'admin') {

    require $_SERVER["DOCUMENT_ROOT"] . "/news_task/services/Queries.php";
    $data = new Queries;

    $typesNameArr = $data->loadData("SELECT * FROM news_type");

    if (isset($_POST['add_article'])) {

        $todayDate = date("Y-m-d H:i:s");
        $shortText = $_POST["short"];
        $visible = (int)$_POST["visible"];
        $selectedType = (int)$_POST["select_type"];
        $fullText = $_POST["full_text"];

        $data->executionQuery(
            "INSERT INTO news 
            (short, full_text, visible, type, created_at, updated_at, visible_at)
            VALUES(?, ?, $visible, $selectedType, '$todayDate', '$todayDate', '$todayDate') ",
            [$shortText, $fullText]
        ) ? $message = "Something went wrong" : $message = "Successfully updated";
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
    <title>New article</title>
</head>

<body>
    <?php if (isset($_SESSION['loged_in']) && $_SESSION['loged_in'] === 'admin') : ?>
        <?php
        require $_SERVER['DOCUMENT_ROOT'] . "/news_task/header.php";
        ?>
        <form class="new_article_form" method="POST">
            <label>Short
                <input type="text" name="short" required>
            </label>
            <label>Visible (1 - yes, 0 - no)
                <input type="Number" name="visible" value="<?php print $arr["visible"] ?>" required>
            </label>
            <label>Type
                <select name="select_type">
                    <?php foreach ($typesNameArr as $typeArr) : ?>
                        <option value="<?php print $typeArr["id"]; ?>" required>
                            <?php print $typeArr["text"]; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Full text
                <textarea name="full_text" id="full_text">
                    </textarea>
            </label>
            <button name="add_article">Add new article</button>
            <p><?php print $message; ?></p>
        </form>
        <script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
        </script>
        <script type="text/javascript">
            CKEDITOR.replace('full_text', {
                height: 200,
                filebrowserUploadUrl: "./upload.php"
            })
        </script>
    <?php else : ?>
        <h2>Not loged in as admin</h2>
    <?php endif; ?>
</body>

</html>