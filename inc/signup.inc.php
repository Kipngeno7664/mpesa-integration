<?php

if (isset($_POST['signup'])) {

    require 'config.inc.php';

    $fName = mysqli_real_escape_string($db, $_POST['fName']);
    $lName = mysqli_real_escape_string($db, $_POST['lName']);
    $uName = mysqli_real_escape_string($db, $_POST['uName']);
    $phone = mysqli_real_escape_string($db, $_POST['contactNumber']);
    $uMail = mysqli_real_escape_string($db, $_POST['uMail']);
    $pass = mysqli_real_escape_string($db, $_POST['pass']);
    $re_pass = mysqli_real_escape_string($db, $_POST['re_pass']);

    if (empty($fName) || empty($lName) || empty($uName) || empty($phone) || empty($uMail) || empty($pass) || empty($re_pass) ) {
        header("Location: ../signin.php?error=emptyFields&fName=" . $fName . "&lName=" . $lName . "&uName=" . $uName . "&mail=" . $uMail . "&contactNumber" . $phone);
        exit();
    } elseif (!preg_match("#[A-Z]+#", $pass)) { // check the password does have at least 1 capital letter
        header("Location: ../signin.php?error=pwdNoUppercase&fName=" . $fName . "&lName=" . $lName . "&phone=" . $phone . "&mail=" . $uMail . "&uName=" . $uName);
        exit();
    } elseif (!preg_match("#[a-z]+#", $pass)) { // check the password does have at least 1 lower case letter
        header("Location: ../signin.php?error=pwdNoLowercase&fName=" . $fName . "&lName=" . $lName . "&phone=" . $phone . "&mail=" . $uMail . "&uName=" . $uName);
        exit();
    } elseif (!preg_match("#[0-9]+#", $pass)) { // check the password does have at least 1 lower case letter
        header("Location: ../signin.php?error=pwdNoNumber&fName=" . $fName . "&lName=" . $lName . "&phone=" . $phone . "&mail=" . $uMail . "&uName=" . $uName);
        exit();
    } elseif ($pass !== $re_pass) {
        header("Location: ../signin.php?error=pwdMatch&fName=" . $fName . "&lName=" . $lName . "&phone=" . $phone . "&mail=" . $uMail . "&uName=" . $uName);
        exit();
    } elseif (!filter_var($uMail, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../signin.php?error=invalidEmail&fName=" . $fName . "&lName=" . $lName . "&phone=" . $phone . "&uName=" . $uName);
        exit();
    } else {

        $sql = "SELECT uid FROM users WHERE uName=?;";
        $stmt = mysqli_stmt_init($db);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../signin.php?error=sqlError");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $uName);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            if ($resultCheck > 0) {
                header("Location: ../signin.php?error=userTaken&fName=" . $fName . "&lName=" . $lName  . "&mail=" . $uMail . "&contactNumber" . $phone);
                exit();
            } else {
                $sql = "INSERT INTO users (fName, lName, uName, phoneNo, uMail, pass) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($db);

                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../signin.php?error=sqlError");
                    exit();
                } else {
                    $passHashed = password_hash($pass, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "ssssss", $uName, $lName, $uName, $phone, $uMail, $passHashed);
                    mysqli_stmt_execute($stmt);
                }

                session_start();
                $_SESSION['userID'] = $uName;
                $_SESSION['fName'] = $fName;
                $_SESSION['lName'] = $lName;
                $_SESSION['contactNumber'] = $phone;
                $_SESSION['uMail'] = $uMail;

                // header("Location: ../signin.php?signup=success");
                header("Location: ../signin.php");
                exit();
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($db);
} else {
    header("Location: ../signin.php");
    exit();
}