<?php

function matchSQLi($input) {
    $suspiciousChars = [';', '--', '#', 'INSERT', 'SELECT', 'UPDATE', 'DELETE'];
    for ($i = 0; $i < count($suspiciousChars); $i++) {
        if (strpos($input, $suspiciousChars[$i]) !== false) {
            return true;
        }
    }
    return false;
}

function getDatabaseConnection() {
    $config = include('config.php');
    $dbconn = pg_connect('host=' . $config['DATABASE_HOST'] . ' port=' . $config['DATABASE_PORT'] . ' dbname=' . $config['DATABASE_NAME'] . ' user=' . $config['DATABASE_USERNAME'] . ' password=' . $config['DATABASE_PASSWORD']);
    return $dbconn;
}