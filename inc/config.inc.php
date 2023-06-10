<?php

    $dbServerName = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $databaseName = "landslide";

    $db = mysqli_connect($dbServerName, $dbUsername, $dbPassword, $databaseName);

    // $dbm = new mysqli_connect($dbServerName, $dbUsername, $dbPassword, $databaseName);
    if (!$db) {
        die("Connection Failed ! " . mysqli_connect_errno());
    }
