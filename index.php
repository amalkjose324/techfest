<?php
$login_error = "";
include_once "db_connection.php";
if (isset($_SESSION['userid'])) {
  $userid = $_SESSION['userid'];
  if($_SESSION['u_type']==2){
      echo "<script>window.location.href = 'admin-console.php';</script>";
  }else   if($_SESSION['u_type']==1){
    echo "<script>window.location.href = 'console.php';</script>";
  }
}else{
  session_unset();
}

if (isset($_POST['login_submit'])) {
  $un    = $_POST['username'];
  $pw    = $_POST['password'];
  $query = mysqli_query($con, "SELECT * FROM `techfest_users` WHERE `user_username`='$un' AND `user_password`='$pw' AND `user_login_status`=0");
  if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_array($query)) {
      mysqli_query($con,"UPDATE `techfest_users` SET `user_login_status`=1 WHERE `user_username`='$un'");
      if ($row['user_type'] == 1) {
        $_SESSION['u_type']=1;
        if ($row['user_round'] == 0) {
          include_once 'modals.php';
          $_SESSION['temp_userid']=$row['user_id'];
        }else{
            $_SESSION['userid']=$row['user_id'];
          echo "<script>window.location.href = 'console.php';</script>";
        }
      } else {
        $_SESSION['u_type']=2;
          $_SESSION['userid']=$row['user_id'];
        echo "<script>window.location.href = 'admin-console.php';</script>";
      }
    }
  } else {
    $login_error = "Invalid username or password..!";
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Brain Droop : Login</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--===============================================================================================-->
  	<link rel="icon" type="image/png" href="favicon.ico" />
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" >
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="css/util.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <!--===============================================================================================-->
</head>

<body onkeydown="return (event.keyCode != 116)">

  <div class="limiter">

    <div class="container-login100">
      <div class="wrap-login100">
        <div class="login100-pic js-tilt" data-tilt>
          <img src="quiz.png" alt="IMG">
        </div>

        <form class="login100-form validate-form" autocomplete="off" action="" method="POST">
          <span class="login100-form-title">
            Participants Login
          </span>

          <div class="wrap-input100 validate-input" data-validate="Invalid Username..!">
            <input class="input100" type="text" name="username" placeholder="Username" autocomplete=off autofocus>
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-user" aria-hidden="true"></i>
            </span>
          </div>

          <div class="wrap-input100 validate-input" data-validate="Invalid Password..!">
            <input class="input100" type="password" name="password" placeholder="Password" autocomplete=off>
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-lock" aria-hidden="true"></i>
            </span>
          </div>

          <div class="container-login100-form-btn">
            <button type="submit" class="login100-form-btn" name="login_submit">
              Login
            </button>
          </div>

          <div class="text-center p-t-12">
            <span class="txt1">
              <?php echo $login_error; ?>
            </span>
            <a class="txt2" href="#">

            </a>
          </div>

          <div class="text-center p-t-136">
            <a class="txt2" href="#">

            </a>
          </div>
        </form>
      </div>
    </div>
  </div>




  <!--===============================================================================================-->
  <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
  <!--===============================================================================================-->
  <script src="vendor/bootstrap/js/popper.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <!--===============================================================================================-->
  <script src="vendor/select2/select2.min.js"></script>
  <!--===============================================================================================-->
  <script src="vendor/tilt/tilt.jquery.min.js"></script>



  <!--===============================================================================================-->
  <script src="js/main.js"></script>
  <script src="js/scripts.js"> </script>
  <!-- <script>window.open("console.php","fs","height=screen.height,width=screen.width,left=0,top=0;resizable=false,fullscreen=yes,resizable=no"); -->
  </script>
</body>

</html>
