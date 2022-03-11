<?php

session_start();
if (!isset($_SESSION["loggedin"])) {
    header("location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <title>Kezdőlap</title>
</head>

<body>
    <div class="container">
        <h1>Szia <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b></h1>
        <p>Sikeresen bejelentkeztél</p>
        <p><a href="logout.php" class="btn btn-danger">Kijelentkezés</a></p>
    </div>

</body>

</html>