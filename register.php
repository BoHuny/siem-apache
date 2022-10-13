<?php
    function generateSalt() {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $salt = '';
        for ($i = 0; $i < 32; $i++) {
            $salt .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $salt;
    }

    $wrong_credentials = false;
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $formLogin = $_POST['username'];
        $formPassword = $_POST['password'];
        $salt = generateSalt();
        $dbconn = pg_connect('host=192.168.1.14 port=5432 dbname=enterprise user=postgres password=root');
        $password = hash('sha256', $formPassword . $salt);
        $query = pg_query($dbconn, 'INSERT INTO users(username, password, salt) VALUES(\'' . $formLogin . '\', \'' . 
            $password . '\', \'' . $salt . '\');');
        header('Location: welcome.php');
        die();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
    </head>
    <body>
        <form action='register.php' method='post'>
            Username: <input type='text' name='username'><br>
            Password: <input type='password' name='password'><br>
            <input type='submit' value="S'inscrire"/>
        </form>
    </body>
</html>