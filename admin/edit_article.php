<?php

session_start();

$newsToEdit = [];
$message = "";

if (isset($_SESSION["loged_in"]) && $_SESSION["loged_in"] === "admin") {
    require $_SERVER["DOCUMENT_ROOT"] . "/news_task/services/Queries.php";
    $data = new Queries;

    // load form to edit
    if (isset($_POST["edit_article"]) && is_int((int)$_POST["edit_article"])) {

        $idInput = (int)$_POST["edit_article"];
        $newsToEdit = $data->loadData("SELECT * FROM news WHERE id= $idInput");
        $typesNameArr = $data->loadData("SELECT * FROM news_type");
    }

    // update row
    if (isset($_POST["submit_article_edit"])) {
        
        $todayDate = date("Y-m-d H:i:s");
        $idInput = (int)$_POST["submit_article_edit"];
        $visible = (int)$_POST["visible"];
        $selectedType = (int)$_POST["select_type"];
        $shortText = $_POST["short"];
        $fullText = $_POST["full_text"];

    
        $data->executionQuery(
            "UPDATE news 
        SET 
        short = ?, 
        full_text = ?, 
        visible = $visible, 
        type = $selectedType, 
        updated_at = ?
        WHERE id = $idInput",
            [$shortText, $fullText, $todayDate]
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
    <title>Edit article</title>
</head>

<body>
    <?php if (isset($_SESSION["loged_in"]) && $_SESSION["loged_in"] === "admin") : ?>
        <?php
        require $_SERVER["DOCUMENT_ROOT"] . "/news_task/header.php";
        ?>
        <form class="edit_form" method="POST">
            <?php foreach ($newsToEdit as $arr) : ?>
                <label>Short
                    <input type="text" name="short" value="<?php print $arr["short"] ?>" required>
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
                        <?php print $arr["full_text"]; ?>
                    </textarea>
                </label>
                <button name="submit_article_edit" value="<?php print $arr["id"]; ?>">Submit changes</button>
            <?php endforeach; ?>
            <p><?php print $message; ?></p>
        </form>
        <script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
        </script>
        <script type="text/javascript">
            CKEDITOR.replace("full_text", {
                height: 200,
                filebrowserUploadUrl: "/news_task/upload.php"
            })
        </script>
    <?php else : ?>
        <h2>Not loged in as admin</h2>
    <?php endif; ?>
</body>

</html>