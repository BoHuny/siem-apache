<?php
    require_once 'includes/utils.php';

    if (isset($_POST['username']) && isset($_POST['password'])) {
        $formLogin = htmlspecialchars($_POST['username']);
        $formPassword = htmlspecialchars($_POST['password']);
        if (matchSQLi($formLogin) || matchSQLi($formPassword)) {
            error_log("Failed SQLi");
            header('Location: register.php?error=1');
            die();
        }
        $dbconn = getDatabaseConnection();
        $query = pg_query_params($dbconn, 'SELECT * FROM users WHERE username = $1;', array($formLogin));

        $data = pg_fetch_all($query);
        if ($data != null) {
            $user = $data[0];
            $password = $user['password'];
            $salt = $user['salt'];
            $hashedFormPassword = hash('sha256', $formPassword . $salt);
            if ($password == $hashedFormPassword) {
                header('Location: welcome.php?user=' . $formLogin);
                die();
            }
        }
        error_log("Failed connection");
        header('Location: login.php?error=1');
        die();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
    </head>
    <body>
        <?php if (isset($_GET['error'])) echo('<p id=\'error-box\' style=\'color:red\'>Connexion échouée</p>'); ?>
        <form action='login.php' method='post' style='position:absolute;top:40%;left:40%'>
            Username: <input type='text' name='username'><br>
            Password: <input type='password' name='password'><br>
            <input type='submit' value='Se connecter'/>
        </form>
    </body>
</html>