<?php
session_start();
if (isset($_SESSION["loggedin"])) {
    header("location: index.php");
    exit;
}

$db_connection = mysqli_connect('localhost', 'root', '', 'helio', 3306);


$email = $password = $password2 = $email_err = $password_err = $password_err2 = "";

if (isset($_POST['submit']) && !empty($_POST['submit'])) {
    $msg = "";
    $email = $_POST['email'];
    $password = $_POST['pwd'];
    $password2 = $_POST['pwd2'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = 'Rossz E-mail cím formátum';
    }
    if (empty($password)) {
        $password_err = "Nem adtál meg jelszót";
    }

    if (empty($password2)) {
        $password_err2 = "Nem adtál meg jelszót ellenőrzőt";
    } else if ($password !== $password2) {
        $password_err2 = 'Nem egyezik a két jelszó';
    }

    $sql_checkemail = "SELECT * FROM users WHERE email = '$email'";
    $check = mysqli_query($db_connection, $sql_checkemail);
    if ($check->num_rows && empty($email_err)) $email_err = 'A megadott Email cím már használatban van!';

    if (empty($email_err) && empty($password_err) && empty($password_err2)) {
        $hash_password = md5($password);
        $sql = "INSERT INTO users (email, password) VALUES ('$email', '$hash_password')";
        mysqli_query($db_connection, $sql);
        $email = $password = $password2 = $email_err = $password_err = $password_err2 = "";
    }
}

?>


<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
    html {
        text-align: center;
    }

    body {
        font: 14px sans-serif;
    }

    .container {
        width: 350px;
        padding: 20px;
        margin: auto;
    }
    </style>
    <title>Regisztráció</title>
</head>

<body>
    <div class="container">
        <h2>Regisztráció </h2>
        <form method="post">

            <div class="form-group">
                <label for="name">Email:</label>
                <input type="text" class="form-control" id="name" placeholder="Email" name="email" required>
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>

            <div class="form-group">
                <label for="pwd">Jelszó:</label>
                <input type="password" class="form-control" id="pwd" placeholder="Jelszó" name="pwd">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>

            <div class="form-group">
                <label for="pwd">Jelszó újra:</label>
                <input type="password" class="form-control" id="pwdAgain" placeholder="Jelszó" name="pwd2">
                <span class="help-block"><?php echo $password_err2; ?></span>
            </div>

            <input type="submit" name="submit" class="btn btn-primary" value="Regisztráció">

        </form>
        <p><a class="btn" href="index.php">Belépés</a></p>
    </div>
</body>

</html>