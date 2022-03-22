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
$error_array = array();

if(isset($_POST['register_button'])) {

    $fname = strip_tags($_POST['reg_fname']);
    $fname = str_replace(' ', '', $fname);
    $fname = ucfirst(strtolower($fname));
    $_SESSION['reg_fname'] = $fname;

    $lname = strip_tags($_POST['reg_lname']);
    $lname = str_replace(' ', '', $lname);
    $lname = ucfirst(strtolower($lname));
    $_SESSION['reg_lname'] = $lname;

    $em = strip_tags($_POST['reg_email']);
    $em = str_replace(' ', '', $em);
    $em = ucfirst(strtolower($em));
    $_SESSION['reg_email'] = $em;

    $em2 = strip_tags($_POST['reg_email2']);
    $em2 = str_replace(' ', '', $em2);
    $em2 = ucfirst(strtolower($em2));
    $_SESSION['reg_email2'] = $em2;

    $password = strip_tags($_POST['reg_password']);
    $password2 = strip_tags($_POST['reg_password2']);

    $date = date('Y-m-d'); //use libriary

    if($em == $em2){
        if(filter_var($em, FILTER_VALIDATE_EMAIL)) {

            $em = filter_var($em, FILTER_VALIDATE_EMAIL);

            $e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em'");

            $num_rows = mysqli_num_rows($e_check);

            if($num_rows > 0) {
                array_push($error_array, 'Email already in use<br>');
            }

        }
        else {
            array_push($error_array, 'Invalid email format<br>');
        }
    } 
    else { 
            array_push($error_array, 'Email dont match<br>');
    }
    

    if(strlen($fname) > 25 || strlen($fname) < 2) {
            array_push($error_array, 'Your first name must be between 2 and 25 symbols<br>');
    }

    if(strlen($lname) > 25 || strlen($lname) < 2) {
            array_push($error_array, 'Your last name must be between 2 and 25 symbols<br>');
    }

    if($password != $password2) {
            array_push($error_array, 'Passwords do not match<br>');
    }
    else {
        if(preg_match('/[^A-Za-z0-9]/', $password)) {
            array_push($error_array, 'Password can only contain english symbols and numbers<br>');
        }
    }

    if(strlen($password) > 30) {
		array_push($error_array, "Your password must be betwen 5 and 30 characters<br>");
	}

    if(empty($error_array)) {
        $password = md5($password); 

        $username = strtolower($fname . '_' . $lname);
        $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");

        $i = 0;
        
        while(mysqli_num_rows($check_username_query) != 0) {
            $i++;
            $username = $usename . '_' . $i;
            $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
        }

        $rand = rand(1, 15);
        if($rand == 1) {
            $profile_pic = '/assets/images/profile_pics/defaults/head_amethyst.png';
        } else if($rand == 2) {
            $profile_pic = '/assets/images/profile_pics/defaults/head_belize_hole.png';
        } else if($rand == 3) {
            $profile_pic = '/assets/images/profile_pics/defaults/head_carrot.png';
        } else if($rand == 4) {
            $profile_pic = '/assets/images/profile_pics/defaults/head_deep_blue.png';
        } else if($rand == 5) {
            $profile_pic = '/assets/images/profile_pics/defaults/head_emerald.png';
        } else if($rand == 6) {
            $profile_pic = '/assets/images/profile_pics/defaults/head_green_sea.png';
        } else if($rand == 7) {
            $profile_pic = '/assets/images/profile_pics/defaults/head_nephritis.png';
        } else if($rand == 8) {
            $profile_pic = '/assets/images/profile_pics/defaults/head_pete_river.png';
        } else if($rand == 9) {
            $profile_pic = '/assets/images/profile_pics/defaults/head_pomegranate.png';
        } else if($rand == 10) {
            $profile_pic = '/assets/images/profile_pics/defaults/head_pumpkin.png';
        } else if($rand == 11) {
            $profile_pic = '/assets/images/profile_pics/defaults/head_red.png';
        } else if($rand == 12) {
            $profile_pic = '/assets/images/profile_pics/defaults/head_sun_flower.png';
        } else if($rand == 13) {
            $profile_pic = '/assets/images/profile_pics/defaults/head_turqoise.png';
        } else if($rand == 14) {
            $profile_pic = '/assets/images/profile_pics/defaults/head_wet_asphalt.png';
        } else if($rand == 15) {
            $profile_pic = '/assets/images/profile_pics/defaults/head_wisteria.png';
        }

        $query = mysqli_query($con, "INSERT INTO users VALUE (NULL, '$fname', '$lname', '$username', '$em', '$password', '$date', '$profile_pic', '0', '0', 'no', ',')"); 

        array_push($error_array, "<span style='color: #111111;'> Registration done. Now try to login!</span><br>");

        $_SESSION['reg_fname'] = '';
        $_SESSION['reg_lname'] = '';
        $_SESSION['reg_email'] = '';
        $_SESSION['reg_email2'] = '';
        $_SESSION['error_array'] = '';
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
        <?php if(in_array('Your first name must be between 2 and 25 symbols<br>', $error_array)) echo 'Your first name must be between 2 and 25 symbols<br>'; ?>

        <input type='text' name='reg_lname' placeholder='Last Name' value='<?php 
        if(isset($_SESSION['reg_lname'])) {
            echo $_SESSION['reg_lname'];
        } ?>' required>
        <br>
        <?php if(in_array('Your last name must be between 2 and 25 symbols<br>', $error_array)) echo 'Your last name must be between 2 and 25 symbols<br>'; ?>

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
        <?php if(in_array('Email already in use<br>', $error_array)) echo 'Email already in use<br>';
        else if(in_array('Invalid email format<br>', $error_array)) echo 'Invalid email format<br>';
        else if(in_array('Email dont match<br>', $error_array)) echo 'Email dont match<br>'; ?>

        <input type='password' name='reg_password' placeholder='Password' required>
        <br>
        <input type='password' name='reg_password2' placeholder='Confirm Password' required>
        <br>

        <?php if(in_array('Passwords do not match<br>', $error_array)) echo 'Passwords do not match<br>';
        else if(in_array('Password can only contain english symbols and numbers<br>', $error_array)) echo 'Password can only contain english symbols and numbers<br>';
        else if(in_array('Your password must be betwen 5 and 30 characters<br>', $error_array)) echo 'Your password must be betwen 5 and 30 characters<br>'; ?>

        <input type='submit' name='register_button' value='Register'>
        <br>

        <?php if(in_array("<span style='color: #111111;'> Registration done. Now try to login!</span><br>", $error_array)) echo "<span style='color: #blue;'> Registration done. Now try to login!</span><br>"; ?>
    </form>
</body>
</html>