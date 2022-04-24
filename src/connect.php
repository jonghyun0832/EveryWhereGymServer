<?php

    $host = '127.0.0.1';
    $user = 'jonghyun';
    $pw = 'tjwhdgus';
    $dbname = 'db';
    $conn = mysqli_connect($host, $user, $pw, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

?>