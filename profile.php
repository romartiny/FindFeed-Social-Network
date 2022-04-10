<?php
include('includes/header.php');
// session_destroy();
if(isset($_GET['profile_username'])) {
    $username = $_GET['profile_username'];
    $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
    $user_array = mysqli_fetch_array($user_details_query);

    $num_friends = substr_count($user_array['friend_array'], ',') - 1;
    $user_first_name = $user_array['first_name'];
    $user_last_name = $user_array['last_name'];
}

?>

    <div class='profile_left'>
        <div class='profile_photo'>
            <img src='<?php echo $user_array['profile_pic']; ?>'>
        </div>
    </div>

    <div class='profile_info'>
        <p class='profile_first_name'>
            <?php echo $user_first_name ,' '; 
            echo $user_last_name;?>
        </p>
        <div class='profile_info_data'>
                <div class='profile_data'>
                    <p class='profile_text'>Posts</p>
                    <p><?php echo $user_array['num_posts']; ?></p>
                </div>
                <div class='profile_data'>
                    <p class='profile_text'><?php echo 'Likes: ' . $user_array['num_likes']; ?></p>
                </div>
                <div class='profile_data'>
                    <p class='profile_text'><?php echo 'Friend: ' . $num_friends; ?></p>
                </div>
        </div>
    </div>
    
    <div class='main_column column'>
        <?php echo $username ?>
    </div>

</div>
</body>

</html>