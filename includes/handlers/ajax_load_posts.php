<?php
include('../../config/config.php');
include('../classes/user.php');
include('../classes/post.php');

$limit = 10;

$posts = new Post($con, $_REQUEST['userLoggedIn']);
$posts->loadPostsFriends($_REQUEST, $limit);

?>