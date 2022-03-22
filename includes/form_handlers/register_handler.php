<?php

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