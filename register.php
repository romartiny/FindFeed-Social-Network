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