<?php
ob_start();

$timezone = date_default_timezone_set('Europe/Warsaw');

session_start();

$con = mysqli_connect('localhost', 'root', 'root', 'social');

if(mysqli_connect_errno()) {
    echo  'Error with the connection: ' . mysqli_connect_errno();
}

?>