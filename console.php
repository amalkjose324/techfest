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
			<div class="wrap-quiz100 quiz-bg col-md-11 col-sm-11 col-lg-11">
				<!-- <div class=""> -->
				<div class="col-md-12 col-sm-12 col-lg-12">
					<div class="col-md-10 col-sm-10 col-lg-10">
						<h5><b class="big_name">Anju V Thomas</b></h5>Amal Jyothi College of Engineering, Kanjirapally<hr>
					</div>
					<div class="row" id="timer-row">

						<div class="timer-view col-md-2 col-sm-2 col-lg-2" id="timer-view">
							<h5 class="timer-head">Time Remaining</h5>
							<?php
							if (empty($_SESSION['quiz_end_time'])) {
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
					</div>
					<div class="circle col-md-2 col-sm-2 col-lg-2">
						Question<br>1
					</div>
					<div class="question-box col-md-8 col-sm-8 col-lg-8">
						<div class="question-section">
							uiyiudfiogofdoiu clknf
							df sdf sfsdf i ugsd hug hugsudy fgsdgfusydg fusgd fsdui fusd uudfgu ysu sdusudgfuhsgdihf uhgdhiuhxugdufhsuhfgush
						</div>
						<div class="option-section col-md-12 col-sm-12 col-lg-12">
							<hr>
							<div class="col-md-12 col-sm-12 col-lg-12">
								<div class="col-md-12 col-sm-12 col-lg-12">
									<div class="col-md-1 col-sm-1 col-lg-1 option-count">
										<span>A</span>
									</div>
									<label class="col-md-11 col-sm-11 col-lg-11">
										<input type="radio" name="1" />
										<div class="box">
											<span>Option 1</span>
										</div>
									</label>
								</div>
								<div class="col-md-12 col-sm-12 col-lg-12">
									<div class="col-md-1 col-sm-1 col-lg-1 option-count">
										<span>B</span>
									</div>
									<label class="col-md-11 col-sm-11 col-lg-11">
										<input type="radio" name="1" />
										<div class="box">
											<span>Option 1</span>
										</div>
									</label>
								</div>
								<div class="col-md-12 col-sm-12 col-lg-12">
									<div class="col-md-1 col-sm-1 col-lg-1 option-count">
										<span>C</span>
									</div>
									<label class="col-md-11 col-sm-11 col-lg-11">
										<input type="radio" name="1" />
										<div class="box">
											<span>Option 1</span>
										</div>
									</label>
								</div>
								<div class="col-md-12 col-sm-12 col-lg-12">
									<div class="col-md-1 col-sm-1 col-lg-1 option-count">
										<span>D</span>
									</div>
									<label class="col-md-11 col-sm-11 col-lg-11">
										<input type="radio" name="1" />
										<div class="box">
											<span>Option 1</span>
										</div>
									</label>
								</div>
							</div>
							<div class="action-section">
								<hr>
								<div class="row">
									<div class="col-md-12 col-sm-12 col-lg-12 action-button-group">
										<div class="col-md-3 col-sm-3 col-lg-3 action-button bg-orange">
											Reset Selection
										</div>
										<div class="col-md-3 col-sm-3 col-lg-3 action-button bg-green">
											Next Question
										</div>
										<div class="col-md-3 col-sm-3 col-lg-3 action-button bg-magenta">
											Mark for Review
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="status-section col-md-3 col-sm-3 col-lg-3">
						<div class="status-grid col-md-12 col-sm-12 col-lg-12">
							<?php
							for($i=0;$i<30;$i++){
								?>
								<div class="grid-button">
									<?php echo $i+1 ?>
								</div>
								<?php
							}
							?>

						</div>
						<div class="col-md-12 col-sm-12 col-lg-12 table-status">
							<table class="col-md-12 col-sm-12 col-lg-12">
								<tr>
									<td class="status-icon color-gray">Not Attended</td>
									<td class="status-count">30</td>
									<td class="status-break"></td>
									<td class="status-icon color-green">Submitted</td>
									<td class="status-count">0</td>

								</tr>
								<tr>
									<td class="status-icon color-orange">Not Attended (Review)</td>
									<td class="status-count">0</td>
									<td class="status-break"></td>
									<td class="status-icon color-darkmagenta">Submitted (Review)</td>
									<td class="status-count">0</td>
								</tr>
							</table>
						</div>
						<div class="final-submit col-md-12 col-sm-12 col-lg-12">
							<div class="col-md-12 col-sm-12 col-lg-12 action-button bg-green">
								Final Submit
							</div>
						</div>
					</div>

					<!-- </div> -->
				</div>
			</div>
		</div>
	</body>
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
	<script>
	setInterval(function(){
      $('#timer-row').load(' #timer-row');
 },1000);
	</script>
	<!-- <script>
	$(window).resize(function(){
	window.resizeTo(screen.width,screen.height);
});
</script> -->
</body>

</html>
