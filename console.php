<?php
$login_error = "";
include_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Quiz Console</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="favicon.ico" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" href="css/font-awesome.css" >
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
	<style>
	.timer-row{
		top:0px !important;
	}
	</style>
</head>
<body>
	<div class="console-loader">
	</div>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-quiz100 quiz-bg col-md-11 col-sm-11 col-lg-11">
				<!-- <div class="col-md-10 col-sm-10 col-lg-10"> -->
				<b class="round-title"><?php echo $round_text ?> <br> <p><?php echo $round_descripton ?></p></b>
				<!-- </div> -->
				<!-- <div class=""> -->
				<div class="col-md-12 col-sm-12 col-lg-12">
					<div class="col-md-10 col-sm-10 col-lg-10">
						<h5><b class="big_name"><?php echo $user_name ?></b></h5><?php echo $user_college ?><hr>
					</div>
					<div class="row timer-row" id="timer-row" style="top:0px;">

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
								echo "<b style='color:red'> 00 : 00 </b>";
							} else {
								echo "<b style='color:red'>".addPreZeroTime(floor($time_left / 60)) . " : " . addPreZeroTime($time_left % 60) ."</b>";
							}

							function addPreZeroTime($value)
							{
								if($value<10){
									return "0".$value;
								}else{
									return $value;
								}
							}
							?>
							<hr>
						</div>
					</div>
					<div  class="question_space">
						<div class="col-md-12 col-sm-12 col-lg-12">
							<?php
							$questionorederno=$_SESSION['current_question'];
							$questionid=$_SESSION['question_order'][$questionorederno-1];
							$questions_query = mysqli_query($con, "SELECT * FROM `techfest_questions` WHERE `question_id`=$questionid");
							while ($row_question = mysqli_fetch_array($questions_query)) {
								$options_list=array($row_question['question_option_currect'],$row_question['question_option_wrong1'],$row_question['question_option_wrong2'],$row_question['question_option_wrong3']);
								shuffle($options_list);

								if(!isset($_SESSION['techfest_questions'][$questionid])){
									$_SESSION['techfest_questions'][$questionid]=array(
										'currect_answer'=>$row_question['question_option_currect'],
										'user_answer'=>0,
									);
								}

								?>
								<div class="circle col-md-2 col-sm-2 col-lg-2">
									<?php
									echo "Question<br>".$questionorederno;
									?>
								</div>
								<div class="question-box col-md-8 col-sm-8 col-lg-8">

									<div class="question-section align-middle">
										<?php echo $row_question['question_content'];?>
									</div>
									<div class="option-section col-md-12 col-sm-12 col-lg-12">
										<hr>
										<div class="col-md-12 col-sm-12 col-lg-12">
											<?php
											for($count=0;$count<4;$count++){
												?>
												<div class="col-md-12 col-sm-12 col-lg-12">
													<div class="col-md-1 col-sm-1 col-lg-1 option-count">
														<span><?php echo $option_codes[$count];?></span>
													</div>
													<label class="col-md-11 col-sm-11 col-lg-11">
														<?php
														if($_SESSION['techfest_questions'][$questionid]['user_answer']===$options_list[$count]){
															?>
															<input type="radio" name="quiz_options" checked value="<?php echo $options_list[$count];?>" />
															<?php
														}else {
															?>
															<input type="radio" name="quiz_options" value="<?php echo $options_list[$count];?>" />
															<?php
														}
														?>
														<div class="box">
															<span><?php echo $options_list[$count];?></span>
														</div>
													</label>
												</div>

												<?php
											}
											?>

										</div>
										<div class="action-section">
											<hr>
											<div class="row">
												<div class="col-md-12 col-sm-12 col-lg-12 action-button-group">
													<?php
													if(!$_SESSION['techfest_questions'][$questionid]['user_answer']==0){
														?>
														<div class="col-md-3 col-sm-3 col-lg-3 action-button bg-orange btn_reset_options">
															Reset Selection
														</div>
														<?php
													}else{
														?>
														<div class="col-md-3 col-sm-3 col-lg-3 action-button bg-orange btn_reset_options btn-hidden">
															Reset Selection
														</div>
														<?php
													} ?>
													<div class="col-md-3 col-sm-3 col-lg-3 action-button bg-magenta btn_mark_review">
														<?php
														if (in_array($questionorederno, $_SESSION['reviewed_questions'])){
															echo "Remove Review";
														}else{
															echo "Mark for Review";
														} ?>
													</div>
													<?php
													if($questionorederno<$question_count){
														?>
														<div class="col-md-3 col-sm-3 col-lg-3 action-button bg-green btn_next_question">
															Next Question
														</div>
														<?php
													}
													?>
												</div>
											</div>
										</div>
									</div>

								</div>
								<div class="status-section col-md-3 col-sm-3 col-lg-3">
									<div class="status-grid col-md-12 col-sm-12 col-lg-12">
										<?php
										for($i=1;$i<=$question_count;$i++){
											if($i==$questionorederno){
												?>
												<div class="grid-button grid-button-active">
													<?php echo $i ?>
												</div>
												<?php
											}else{
												if (in_array($i, $_SESSION['attended_questions'])){
													if (in_array($i, $_SESSION['reviewed_questions'])){
														?>
														<div class="grid-button grid-button-magenta">
															<?php echo $i ?>
														</div>
														<?php
													}else{
														?>
														<div class="grid-button grid-button-green">
															<?php echo $i ?>
														</div>
														<?php
													}
												}else{
													if (in_array($i, $_SESSION['reviewed_questions'])){
														?>
														<div class="grid-button grid-button-orange">
															<?php echo $i ?>
														</div>
														<?php
													}else{
														?>
														<div class="grid-button">
															<?php echo $i ?>
														</div>
														<?php
													}
												}
											}
										}
										?>

									</div>
									<div class="col-md-12 col-sm-12 col-lg-12 table-status">
										<table class="col-md-12 col-sm-12 col-lg-12">
											<tr>
												<td class="status-icon color-gray">Not Attended</td>
												<td class="status-count">
													<?php
													$s_count=count(array_diff($_SESSION['attended_questions'],$_SESSION['reviewed_questions']));
													$sr_count=count(array_intersect($_SESSION['attended_questions'],$_SESSION['reviewed_questions']));
													$nar_count=count($_SESSION['reviewed_questions'])-$sr_count;
													$na_count=$question_count-($s_count+$sr_count+$nar_count);
													echo $na_count;
													?>
												</td>
												<td class="status-break"></td>
												<td class="status-icon color-green">Submitted</td>
												<td class="status-count">
													<?php
													echo $s_count;
													?>
												</td>

											</tr>
											<tr>
												<td class="status-icon color-orange">Not Attended (Review)</td>
												<td class="status-count">
													<?php
													echo $nar_count;
													?>
												</td>
												<td class="status-break"></td>
												<td class="status-icon color-darkmagenta">Submitted (Review)</td>
												<td class="status-count">
													<?php
													echo $sr_count;
													?>
												</td>
											</tr>
										</table>
									</div>
									<div class="final-submit col-md-12 col-sm-12 col-lg-12">
										<div class="col-md-12 col-sm-12 col-lg-12 action-button bg-green btn-final-submit">
											Final Submit
										</div>
									</div>
								</div>

								<div class="modal fade" id="modal_result_generation_loader" role="dialog" data-backdrop="static" data-keyboard="false">
									<div class="modal-dialog" style="min-width: 40%;">
										<div class="modal-content">
											<div class="modal-body">
												<div class="col-sm-12" style="text-align: -webkit-center;">
														Generating Result, Please wait..!
												</div>
											</div>
										</div>
									</div>
								</div>


								<div class="modal fade" id="modal_confirm_final_submit" role="dialog" data-backdrop="static" data-keyboard="false">
									<div class="modal-dialog" style="min-width: 40%;">
										<!-- Modal content-->
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title">Confirm Your Submission</h4>
											</div>
											<div class="modal-body">
												<p>Are you sure want to submit your answers now?</p><br>
												<div class="col-sm-12" style="text-align: -webkit-center;">
													<table border="1" class="col-sm-10 review_class">
														<tr style="color:red">
															<th width="75%" >Total Number of Questions</th>
															<td width="25%">
																<?php
																echo $s_count + $na_count + $sr_count + $nar_count;
																?>
															</td>
														</tr>
														<tr>
															<th>Submitted Questions</th>
															<td>
																<?php
																echo $s_count;
																?>
															</td>
														</tr>
														<tr>
															<th>Not Attended Questions</th>
															<td>
																<?php
																echo $na_count;
																?>
															</td>
														</tr>
														<tr>
															<th>Submitted Review Questions</th>
															<td>
																<?php
																echo $sr_count;
																?>
															</td>
														</tr>
														<tr>
															<th>Non-Submitted Review Questions</th>
															<td>
																<?php
																echo $nar_count;
																?>
															</td>
														</tr>
													</table>
												</div>
											</div>
											<div class="modal-footer">
												<?php
													if($time_left>0){
														?>
															<button type="button" class="btn btn-danger" data-dismiss="modal">Back to Questions</button>
														<?php
													}
												 	?>
												<button type="button" class="btn btn-success confirm_submission">Confirm Submission</button>
											</div>

										</div>
									</div>
								</div>
								<div class="modal fade" id="modal_result_view" role="dialog" data-backdrop="static" data-keyboard="false">
									<div class="modal-dialog" style="min-width: 92%;">
										<!-- Modal content-->
										<div class="modal-content">
											<div class="modal-body col-sm-12 row">
												<div class="col-sm-4 col-md-4 col-lg-4">
													<div class="login100-pic js-tilt" data-tilt="" style="will-change: transform; transform: perspective(300px) rotateX(0deg) rotateY(0deg); width:100%;">
														<img src="quiz.png" alt="IMG">
													</div>
												</div>
												<div class="col-sm-8 col-md-8 col-lg-8" style="display:inline-block;">
													<h1 class="text-center">Result : <?php echo $round_text ;?> </h1><hr>
													<?php
														$currect_answer_count=0;
														$wrong_answer_count=0;
														$mark=0;

														foreach ($_SESSION['techfest_questions'] as $question) {
															if($question['currect_answer']===$question['user_answer']){
																$currect_answer_count++;
																$mark+=4;
															}else{
																$wrong_answer_count++;
																if($round==2){
																	$mark--;
																}
															}
														}
														$_SESSION['total_mark']=$mark;
													 ?>
													<div class="col-sm-12" style="text-align: -webkit-center;">
														<table border="1" width="100%" class="result_table" style="text-align: -webkit-center;">
															<tr>
																<th colspan="4" class="greeting_msg">
																0
																</th>
															</tr>
															<tr>
																<th colspan="2">	<h5> Your Score</h5></th>
																<td colspan="2">	<h5> <?php echo $mark." / ".($question_count*4)?></h5></td>
															</tr>
															<tr>
																<th colspan="2">	<h5> Pass Mark</h5></th>
																<td colspan="2">	<h5 class="passmark_display"></h5></td>
															</tr>
															<tr>
																<th width="20%"> Full Name</th>
																<td width="45%"> <?php echo $user_name;?></td>
																<th width="20%"> Total Questions</th>
																<td	width="15%"> <?php echo $question_count;?></td>
															</tr>
															<tr>
																<th> College</th>
																<td> <?php echo $user_college;?></td>
																<th> Answerd Questions</th>
																<td> <?php echo $s_count+$sr_count;?></td>
															</tr>
															<tr>
																<th>Quiz Round</th>
																<td> <?php echo $round_text;?></td>
																<th>Non-Answerd Questions</th>
																<td> <?php echo $na_count+$nar_count;?></td>
															</tr>

														</table>
													</div>
												</div>

											</div>
											<div class="modal-footer exit_next_round">


											</div>
										</div>
									</div>
								</div>
							<?php } ?>
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
		$('#timer-row').load('  #timer-row');
	},1000);
	</script>
	<script src="./js/custom.js">
	</script>
	<?php
	if($time_left<1){
		echo "<script> $('#modal_confirm_final_submit').modal('show');</script>";
	}
	 ?>

	<!-- <script>
	$(window).resize(function(){
	window.resizeTo(screen.width,screen.height);
});
</script> -->

</html>
