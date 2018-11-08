<?php
include_once "db_connection.php";
if (!isset($_SESSION['userid'])) {
	echo "<script>window.location.href = './';</script>";
}else if($_SESSION['u_type']==2){
	echo "<script>window.location.href = 'admin-console.php';</script>";
}
if(!isset($_SESSION['techfest_questions'])){
	$_SESSION['techfest_questions']=array();
}
if(!isset($_SESSION['attended_questions'])){
	$_SESSION['attended_questions']=array();
}
if(!isset($_SESSION['reviewed_questions'])){
	$_SESSION['reviewed_questions']=array();
}
$userid=$_SESSION['userid'];
$round=0;
$user_name="";
$user_college="";
$user_query = mysqli_query($con, "SELECT * FROM `techfest_users` WHERE `user_id`=$userid");
while ($row = mysqli_fetch_array($user_query)) {
	$round=$_SESSION['user_round']=$row['user_round'];
	$user_name=$row['user_fullname'];
	$user_college=$row['user_college'];
}
$instruction_duration=180;
$duration =0;
$question_count=0;
if($round==1){
	$question_count=30;
	$duration=600;
	$round_text="Round-1";
	$round_descripton ="30 Questions : Negative Marking : No";
}
else if($round==2){
	$question_count=20;
	$duration=420;
	$round_text="Round-2";
	$round_descripton ="20 Questions : Negative Marking : Yes (Correct : +4, Incurrect : -1)";
}else if($round==0){
	echo "<script>window.location.href = './';</script>";
}else if($round==5){
	mysqli_query($con,"UPDATE `techfest_users` SET `user_login_status`=0 WHERE `user_id`=$userid");
	echo "<script>alert('You are not permitted to view this page because, you are not eligible for next round.)</script>";
	session_destroy();
	echo "<script>window.location.href = './';</script>";
}else if($round==3){
	mysqli_query($con,"UPDATE `techfest_users` SET `user_login_status`=0 WHERE `user_id`=$userid");
	echo "<script>alert('Next round will be after 10 minuts at Admission Cell')</script>";
	session_destroy();
	echo "<script>window.location.href = './';</script>";
}else if($round==4){
	mysqli_query($con,"UPDATE `techfest_users` SET `user_login_status`=0 WHERE `user_id`=$userid");
	echo "<script>alert('Result will be published later')</script>";
	session_destroy();
	echo "<script>window.location.href = './';</script>";
}

if(!isset($_SESSION['question_order'])){
	$_SESSION['question_order']=range(1, $question_count);
	shuffle($_SESSION['question_order']);
}

if(!isset($_SESSION['current_question'])){
	$_SESSION['current_question']=1;
}

$option_codes=array("A","B","C","D");

?>
