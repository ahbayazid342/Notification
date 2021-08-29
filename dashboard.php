<?php
include('connection.db.inc.php');
include('function.inc.php');

$msg = '';

if (!isset($_SESSION['UID'])) {
    header('location:index.php');
    die();
}

$uid = $_SESSION['UID'];


if (isset($_POST['submit'])) {
    $from_id = $_SESSION['UID'];
    $to_id = $_POST['to_id'];
    $message = $_POST['message'];

    $sql = "INSERT INTO message (from_id, to_id, message, status) VALUES ('$from_id', '$to_id', '$message', 0)";
    mysqli_query($conn, $sql);
    $msg = "message sent";
}

//find out to id user and retrive unseen message to check status 0
$sql = " SELECT user.name, message.message FROM user, message WHERE user.id = message.from_id and message.status = 0 and message.to_id = '$uid' ";
$res_message = mysqli_query($conn, $sql);
$num_unread_msg = mysqli_num_rows($res_message);



$sql = "SELECT id, name FROM user ORDER BY name asc";
$res_user = mysqli_query($conn, $sql);

?>

<!doctype html>
<html>

<head>
    <title>Facebook type Notifications system using PHP and Ajax</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="dashboard.css">

</head>

<body style="margin:0;padding:0;">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <div id="notification_box">
        <ul>
            <li id="notifications_container">
                <div id="notifications_counter">
                    <?php echo $num_unread_msg ?>
                </div>
                <div id="notifications_button">
                    <div class="notifications_bell white">

                    </div>
                </div>
                <div id="notifications">
                    <h3>Notifications</h3>
                    <div style="height:300px;" id="show_notification">
                        <?php
                        if ($num_unread_msg > 0) {
                            while ($row = mysqli_fetch_assoc($res_message)) { ?>
                                <p><strong> <?php echo $row['name'] ?> </strong> <?php echo $row['message'] ?></p>
                        <?php }
                        } ?>
                    </div>
                </div>
            </li>
            <li id="notifications_container"><a href="logout.php">Logout</a><?php $res = mysqli_query($conn, "select * from user where id = '$uid'");
                                                                            $row = mysqli_fetch_assoc($res);
                                                                            echo $row['name'] ?></li>
        </ul>
    </div>
    <div id="post">
        <div class="container">
            <div id="post-row" class="row justify-content-center align-items-center">
                <div id="post-column" class="col-md-6">
                    <div id="post-box" class="col-md-12">
                        <form id="post-form" class="form" action="" method="post">
                            <h2 class="text-center text-info">Post Form</h2>
                            <div class="form-group">
                                <label for="user" class="text-info">User:</label><br>
                                <select class="form-control" name="to_id" required>
                                    <option value="">Select User</option>
                                    <?php while ($row_user = mysqli_fetch_assoc($res_user)) { ?>
                                        <option value="<?php echo $row_user['id'] ?>"><?php echo $row_user['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="message" class="text-info">Message:</label><br>
                                <textarea class="form-control" name="message" required></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-success" value="Submit">
                                <span style="color:red;"><?php echo $msg ?></span>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        $('#notifications_button').click(function() {
            $('#notifications').fadeToggle('fast', 'linear');
            $('#notifications_counter').fadeOut('slow', 'linear');
            return false;
        });
        $(document).click(function() {
            $('#notifications').hide();
        });
    });
</script>

</html>