<?php
$login_error = "";
include_once "db_connection.php";
if (!isset($_SESSION['userid'])) {
	// echo "<script>window.location.href = './';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Quiz Console</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico" />
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
<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-quiz100 quiz-bg col-md-11 col-sm-11 ">

				<div class="col-md-12">
					<div class="col-md-8">
						<h5><b class="big_name">Anju V Thomas</b></h5>Amal Jyothi College of Engineering, Kanjirapally<hr>
					</div>
					<div class="timer-view col-md-4">
						<h5 class="timer-head">Time Remaining</h5>
						<?php
						if (empty($_SESSION['quiz_end_time'])) {
							$duration                  = 30;
							$_SESSION['quiz_end_time'] = strtotime(date('Y-m-d H:i:s')) + $duration;
						}
						$quiz_time_now = strtotime(date('Y-m-d H:i:s'));
						$quiz_time_end = $_SESSION['quiz_end_time'];
						$time_left     = $quiz_time_end - $quiz_time_now;
						if ($time_left < 1) {
							echo "0 : 0";

						} else {
							echo floor($time_left / 60) . " : " . $time_left % 60;

						}
						?>
						<hr>
					</div>



					<form name="submit" method="post" action="#">
						<p class="oval"><b><br>	QUESTION <br><font size="5">
							<?php
							$qry = "select * from techfest_questions";
							$res = mysqli_query($con, $qry);
							$i   = 0;
							while ($row = mysqli_fetch_array($res)) {
								$i = $i + 1;
								echo "$i </b></font></p><div id='v'><br>";
								$id = $row['question_id'];
								echo $row['question_content'];
								$qry1 = "select * from techfest_choices where choice_question_id='$id'";
								$res1 = mysqli_query($con, $qry1);
								$i    = 0;
								while ($row1 = mysqli_fetch_array($res1)) {
									?>
									<input type="radio" name="ans" value="<?php echo $row1['choice_content']; ?>"> <?php echo $row1['choice_content'];?></input>
									<?php
								}
							}
							?>
						</div>
					</div>


				</div>

			</div>
		</div>
		<div id="i">
			<br><br>
			<?php
			$qry = "select * from techfest_questions";
			$res = mysqli_query($con, $qry);
			$i   = 1;
			while ($row = mysqli_fetch_array($res)) {
				if ($_SESSION['question_id'] == "") {
					?>
					<a class="button1 col-md-2"><?php echo $i;
					$i = $i + 1;
					?>
				</a>


				<?php
			} else {?>
				<a class="button3 col-md-2"><?php echo $i;
				$i = $i + 1;
				?>
			</a>
			<?php
		}
	}
	?>
</div>
<div id="b">
	<input type="button" value="PREV" class="button2">
	<input type="submit" value="SUBMIT" name="submit" class="button2">
	<input type="button" value="REVIEW" class="button2">
</form>


<?php
if (isset($_POST['submit'])) {
	$_SESSION['question_id'] = $_POST['ans'];
	echo $_SESSION['question_id'];
}
?>
</div>
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

</body>

</html>
