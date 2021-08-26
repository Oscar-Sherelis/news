<?php

session_start();

if (isset($_POST['user']) && isset($_POST['password'])) {

    $user = filter_var($_POST['user'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $user = htmlentities($user, ENT_QUOTES, 'UTF-8');
    $password = htmlentities($password, ENT_QUOTES, 'UTF-8');

    require "./services/Queries.php";
    $checkUser = new Queries;

    session_start();

    // check if admin exists
    if (
        $checkUser->checkIfUserExists(
            "SELECT * FROM users WHERE user = ? AND password = ?",
            [
                $user, $password
            ]
        ) > 0
        && $user = 'admin'
    ) {
        $_SESSION['loged_in'] = $user;
        header("Location: ./admin/admin.php");
    } else if ($checkUser->checkIfUserExists(
        "SELECT * FROM users WHERE user = ? AND password = ?",
        [
            $user, $password
        ]
    ) > 0) {
        $_SESSION['loged_in'] = $user;
        header("Location: ./index.php");
    } else {
        $_SESSION['login_error'] = 'Wrong username or password';
        header("Location: ./login.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/style.css">
    <title>Login</title>
</head>

<body>
    <?php

    require './header.php';

    ?>
    <section class="login">
        <form class="login__form" method="POST">
            <h3>Login</h3>
            <input type="text" name="user" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </section>
</body>

</html>