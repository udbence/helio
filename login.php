<?php

session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

$db_connection = mysqli_connect('localhost', 'root', '', 'helio', 3306);


$email = $password = $msg = $script = "";


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = md5($_POST['pwd']);

    $sql_login = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $check = mysqli_query($db_connection, $sql_login);
    if ($check->num_rows) {
        $_SESSION["loggedin"] = true;
        $_SESSION["email"] = $email;
        header("location: index.php");
    } else {
        $msg = 'Rossz Email cím vagy jelszó';
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style type="text/css">
    html {
        text-align: center;
    }

    body {
        font: 14px sans-serif;
        text-align: center;
    }

    .container {
        width: 350px;
        padding: 20px;
        margin: auto;
    }

    .none {
        display: none;
    }
    </style>
    <title>Bejelentkezés</title>
</head>

<body>
    <div class="container" id=login>
        <h2>Bejelentkezés</h2>
        <span>
            <?php echo $msg; ?>
        </span>
        <form method="post">

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="name" class="form-control" id="name" placeholder="Email" name="email">
            </div>

            <div class="form-group">
                <label for="pwd">Jelszó:</label>
                <input type="password" class="form-control" id="pwd" placeholder="Jelszó" name="pwd">
            </div>

            <input type="submit" class="btn btn-primary" value="Belépés">
        </form>
        <p><a class="btn" href="registration.php">Regisztráció</a></p>
    </div>
</body>

</html>