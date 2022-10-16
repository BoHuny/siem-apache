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