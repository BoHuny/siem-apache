<!DOCTYPE html>
<html>
    <head>
        <title>Welcome to our website!</title>
    </head>
    <body>
        <h1>Bienvenue <?php if (isset($_GET['user'])) echo $_GET['user'] ?> !</h1>
        <a href="index.php"> Se déconnecter </a>
    </body>
</html>

<?php
if (!isset($_GET['user'])) {
    header('Location: index.php');
    die();
}
?>
