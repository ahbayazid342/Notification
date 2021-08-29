<?php

include('connection.db.inc.php');
include('function.inc.php');

$msg = '';

if (isset($_POST['submit'])) {

    $user_name = get_safe_value($conn, $_POST['user_name']);
    $pass = get_safe_value($conn, $_POST['password']);

    $res = mysqli_query($conn, "SELECT * FROM user WHERE user_name = '$user_name' and password = '$pass'");

    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $_SESSION['UID'] = $row['id'];
        header('location:dashboard.php');
        die();
    } else {
        $msg = 'please enter correct information';
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>Login Page</title>
</head>

<body>

    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->

            <!-- Icon -->
            <div class="fadeIn first">
                <h3 style="font-weight: 700;">Login Form</h2>
            </div>

            <!-- Login Form -->
            <form method="POST">
                <input type="text" id="login" class="fadeIn second" name="user_name" placeholder="user name">
                <input type="text" id="password" class="fadeIn third" name="password" placeholder="password">
                <input type="submit" name="submit" class="fadeIn fourth" value="submit"> <br>
                <span style="color: red;">
                    <?php echo $msg  ?>
                </span>
            </form>

            <!-- Remind Passowrd -->
            <div id="formFooter">
                <a class="underlineHover" href="#">Forgot Password?</a>
            </div>

        </div>
    </div>

</body>