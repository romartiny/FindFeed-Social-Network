<?php
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

    //last name
    $lname = strip_tags($_POST['reg_lname']);
    $lname = str_replace(' ', '', $lname);
    $lname = ucfirst(strtolower($lname));

    //email
    $em = strip_tags($_POST['reg_em']);
    $em = str_replace(' ', '', $em);
    $em = ucfirst(strtolower($em));

    //email repeat
    $em2 = strip_tags($_POST['reg_em2']);
    $em2 = str_replace(' ', '', $em2);
    $em2 = ucfirst(strtolower($em2));

    //password
    $password = strip_tags($_POST['reg_password']);
    $password2 = strip_tags($_POST['reg_password2']);

    //date
    $date = date('Y-m-d'); //use libriary


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
        <input type='text' name='reg_fname' placeholder='First Name' required>
        <br>
        <input type='text' name='reg_lname' placeholder='Last Name' required>
        <br>
        <input type='email' name='reg_email' placeholder='Email' required>
        <br>
        <input type='email' name='reg_email2' placeholder='Confirm Email' required>
        <br>
        <input type='password' name='reg_password' placeholder='Password' required>
        <br>
        <input type='password' name='reg_password2' placeholder='Confirm Password' required>
        <br>
        <input type='submit' name='registration_button' value='Register'>
    </form>
</body>
</html>