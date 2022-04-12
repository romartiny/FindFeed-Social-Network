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

if(isset($_POST['remove_friend'])) {
    $user = new User($con, $userLoggedIn);
    $user->removeFriend($username);
}

if(isset($_POST['add_friend'])) {
    $user = new User($con, $userLoggedIn);
    $user->sendRequest($username);
}

if(isset($_POST['respond_request'])) {
    header('Location: requests.php');
}

?>

    <div class='profile_left'>
        <div class='profile_photo'>
            <img class='profile_pic_main'src='<?php echo $user_array['profile_pic']; ?>'>
        </div>
        <form action='<?php echo $username;?>' method='POST'>
            <?php $profile_user_obj = new User($con, $username); 
            if($profile_user_obj->isClosed()) {
                header('Location: user_closed.php');
            }

            $logged_in_user_obj = new User($con, $userLoggedIn);

            ?>

            <input type="submit" class='deep_blue' data-toggle="modal" data-target="#post_form" value='Post Something'> 

            <?
            
            if($userLoggedIn != $username) {
                if($logged_in_user_obj->isFriend($username)) {
                    echo '<input type="submit" name="remove_friend" class="danger" value="Remove Friend"><br>';
                } else if ($logged_in_user_obj->didReveiveRequest($username)) {
                    echo '<input type="submit" name="respond_request" class="warning" value="Respond to Request"><br>';
                } else if ($logged_in_user_obj->didSendRequest($username)) {
                    echo '<input type="submit" name="" class="default" value="Request Sent"><br>'; 
                } else {
                    echo '<input type="submit" name="add_friend" class="success" value="Add Friend"><br>'; 
                } 
            }

            
            ?>
        </form>
        
    </div>

    <div class='profile_info'>
        <p class='profile_first_name'>
            <?php echo $user_first_name ,' '; 
            echo $user_last_name;?>
        </p>
        <div class='profile_info_data'>
                <div class='profile_data'>
                    <p class='profile_text'><?php echo 'Posts <br>' . $user_array['num_posts']; ?></p>
                </div>
                <div class='profile_data'>
                    <p class='profile_text'><?php echo 'Likes <br>' . $user_array['num_likes']; ?></p>
                </div>
                <div class='profile_data'>
                    <p class='profile_text'>
                        <?php echo 'Friends <br>' . $num_friends;  
                            ?> (<?
                            if($userLoggedIn != $username) {
                            echo $logged_in_user_obj->getMutualFriends($username);
                        }?>)
                    </p>
                </div>
        </div>
    </div>
    
    <div class='profile_main_column column main-column'>
        <div class='posts_area'></div>
        <img id='loading' src='assets/images/icons/loading.gif' alt='loading'>
    </div>

    <div class="modal fade" id="post_form" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Send Post</h5>
            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">X</span>
            </button> -->
        </div>

        <div class="modal-body">
            <p>This will appear on the users profile page and also newsfeed for your friends to see!</p>

            <form class="profile_post" action="" method="POST">
                <div class='form-group'>
                    <textarea class='form-control' name='post_body'></textarea>
                    <input type='hidden' name='user_from' value='<?php echo $userLoggedIn;?>'>
                    <input type='hidden' name='user_to' value='<?php echo $username;?>'>
                </div>
            </form>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" name='post_button' id='submit_profile_post'>Post</button>
        </div>
        </div>
    </div>
    </div>

    <script>
    var userLoggedIn = '<?php echo $userLoggedIn; ?>';
    var profileUsername = '<?php echo $username;?>';

    $(document).ready(function() {

        $('#loading').show();

        $.ajax({
            url: 'includes/handlers/ajax_load_profile_posts.php',
            type: 'POST',
            data: 'page=1&userLoggedIn=' + userLoggedIn + "&profileUsername=" + profileUsername,
            cache: false,

            success: function(data) {
                $('#loading').hide();
                $('.posts_area').html(data);
            }

        });

        $(window).scroll(function() {
            var height = $('.posts_area').height();
            var scroll_top = $(this).scrollTop();
            var page = $('.posts_area').find('.nextPage').val();
            var noMorePosts = $('.posts_area').find('.noMorePosts').val();

            if ((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePosts == 'false') {
                $('#loading').show();

                var ajaxReq = $.ajax({
                    url: 'includes/handlers/ajax_load_profile_posts.php',
                    type: 'POST',
                    data: 'page=' + page + '&userLoggedIn=' + userLoggedIn + "&profileUsername=" + profileUsername,
                    cache: false,

                    success: function(response) {
                        $('.posts_area').find('.nextPage').remove();
                        $('.posts_area').find('.noMorePosts').remove();

                        $('#loading').hide();
                        $('.posts_area').append(response);
                    }

                });
                
            }

            return false;

        });

    });

</script>

</div>
</body>

</html>