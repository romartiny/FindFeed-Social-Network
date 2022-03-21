<?php
session_start();

$con = mysqli_connect('localhost', 'root', 'root', 'social');

if(mysqli_connect_errno()) {
    echo  'Error with the connection: ' . mysqli_connect_errno();
}

$fname = '';
$lname = '';
$em = '';
$em2 = '';
$password = '';
$password2 = '';
$date = '';
$error_array = '';

if(isset($_POST['register_button'])) {

    //first name
    $fname = strip_tags($_POST['reg_fname']);
    $fname = str_replace(' ', '', $fname);
    $fname = ucfirst(strtolower($fname));
    $_SESSION['reg_fname'] = $fname;

    //last name
    $lname = strip_tags($_POST['reg_lname']);
    $lname = str_replace(' ', '', $lname);
    $lname = ucfirst(strtolower($lname));
    $_SESSION['reg_lname'] = $lname;

    //email
    $em = strip_tags($_POST['reg_email']);
    $em = str_replace(' ', '', $em);
    $em = ucfirst(strtolower($em));
    $_SESSION['reg_email'] = $em;

    //email repeat
    $em2 = strip_tags($_POST['reg_email2']);
    $em2 = str_replace(' ', '', $em2);
    $em2 = ucfirst(strtolower($em2));
    $_SESSION['reg_email2'] = $em2;

    //password
    $password = strip_tags($_POST['reg_password']);
    $password2 = strip_tags($_POST['reg_password2']);

    //date
    $date = date('Y-m-d'); //use libriary

    if($em == $em2){
        if(filter_var($em, FILTER_VALIDATE_EMAIL)) {

            $em = filter_var($em, FILTER_VALIDATE_EMAIL);

            $e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em'");

            $num_rows = mysqli_num_rows($e_check);

            if($num_rows > 0) {
                echo 'Email already in use';
            }

        }
        else {
            echo 'Invalid format';
        }
    } 
    else {
        echo 'Email dont match';
    }

    if(strlen($fname) > 25 || strlen($fname) < 2) {
        echo 'Your first name must be between 2 and 25 symbols';
    }

    if(strlen($lname) > 25 || strlen($lname) < 2) {
        echo 'Your last name must be between 2 and 25 symbols';
    }

    if($password != $password2) {
        echo 'Passwords do not match';
    }
    else {
        if(preg_match('/[^A-Za-z0-9]/', $password)) {
            echo 'Password can only contain english symbols and numbers';
        }
    }

    if(strlen($password > 30 || strlen($password)) < 5) {
        echo 'Password must be between 5 and 30 symbols';
    }


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action='register.php' method='post'>
        <input type='text' name='reg_fname' placeholder='First Name' value='<?php 
        if(isset($_SESSION['reg_fname'])) {
            echo $_SESSION['reg_fname'];
        } ?>' required>
        <br>
        <input type='text' name='reg_lname' placeholder='Last Name' value='<?php 
        if(isset($_SESSION['reg_lname'])) {
            echo $_SESSION['reg_lname'];
        } ?>' required>
        <br>
        <input type='email' name='reg_email' placeholder='Email' value='<?php 
        if(isset($_SESSION['reg_email'])) {
            echo $_SESSION['reg_email'];
        } ?>' required>
        <br>
        <input type='email' name='reg_email2' placeholder='Confirm Email' value='<?php 
        if(isset($_SESSION['reg_email2'])) {
            echo $_SESSION['reg_email2'];
        } ?>' required>
        <br>
        <input type='password' name='reg_password' placeholder='Password' required>
        <br>
        <input type='password' name='reg_password2' placeholder='Confirm Password' required>
        <br>
        <input type='submit' name='register_button' value='Register'>
    </form>
</body>
</html>