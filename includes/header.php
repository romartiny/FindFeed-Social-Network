<?php
require 'config/config.php';
include('includes/classes/user.php');
include('includes/classes/post.php');

if(isset($_SESSION['username'])) {
    $userLoggedIn = $_SESSION['username'];
    $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
    $user = mysqli_fetch_array($user_details_query);
}
else {
    header('Location: register.php');
}

?>

<html lang="en">

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="assets/js/bootstrap1.js"></script>

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous"> -->
    <script src="https://kit.fontawesome.com/6ee2d24a43.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <title>Findfeed</title>
</head>

<body>

    <div class='top_bar'>

        <div class='logo'>
            <a href='index.php'>Findfeed</a>
        </div>

        <nav>
            <a href='<?php echo $userLoggedIn ?>'>
                <?php echo $user['first_name'];?>
            </a>

            <a href='index.php'>
                <i class="fa-solid fa-home"></i>
            </a>

            <a href='#'>
                <i class="fa-solid fa-envelope"></i>
            </a>

            <a href='requests.php'>
                <i class="fa-solid fa-bell"></i>
            </a>

            <a href='#'>
                <i class="fa-solid fa-user-group"></i>
            </a>

            <a href='#'>
                <i class="fa-solid fa-gear"></i>
            </a>

            <a href='includes/handlers/logout.php'>
                <i class="fa-solid fa-right-from-bracket"></i>
            <a>
        </nav>
    </div>

    <div class='wrapper'>