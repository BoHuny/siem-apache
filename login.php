<?php
    if (!isset($_GET['error']) && isset($_POST['username']) && isset($_POST['password'])) {
        $formLogin = $_POST['username'];
        $formPassword = $_POST['password'];
        $dbconn = pg_connect('host=192.168.1.14 port=5432 dbname=enterprise user=postgres password=root');
        $query = pg_query($dbconn, 'SELECT * FROM users WHERE username = \''. $formLogin . '\';');
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
        error_log("Failed connection from " . $_SERVER['REMOTE_ADDR']);
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
        <?php if (isset($_GET['error'])) echo('<p id=\'error-box\' style=\'color:red\'>Mauvais login ou mot de passe</p>'); ?>
        <form action='login.php' method='post'>
            Username: <input type='text' name='username'><br>
            Password: <input type='password' name='password'><br>
            <input type='submit' value='Se connecter'/>
        </form>
    </body>
</html>