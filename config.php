<?php
include_once "db_connection.php";
if (!isset($_SESSION['userid'])) {
	 echo "<script>window.location.href = './';</script>";
}else if($_SESSION['u_type']==2){
	echo "<script>window.location.href = 'admin-console.php';</script>";
}
$_SESSION['techfest_questions']=array();
$userid=$_SESSION['userid'];
$round=0;
$user_name="";
$user_college="";
$user_query = mysqli_query($con, "SELECT * FROM `techfest_users` WHERE `user_id`=$userid");
while ($row = mysqli_fetch_array($user_query)) {
  $round=$row['user_round'];
  $user_name=$row['user_fullname'];
  $user_college=$row['user_college'];
}
$instruction_duration=180;
$duration =0;
$question_count=0;
if($round==1){
  $question_count=30;
  $duration=900;
  $round_text="Round-1";
  $round_descripton ="30 Questions : Negative Marking : No";
}
else if($round==2){
  $question_count=20;
  $duration=600;
  $round_text="Round-2";
  $round_descripton ="20 Questions : Negative Marking : Yes (Correct : +4, Incurrect : -1)";
}
$_SESSION['question_order']=range(1, $question_count);
shuffle($_SESSION['question_order']);


$questions_query = mysqli_query($con, "SELECT * FROM `techfest_questions` WHERE `question_round`=$round");
while ($row_question = mysqli_fetch_array($questions_query)) {
  $qid=$row_question['question_id'];
  $_SESSION['techfest_questions'][$qid]=array(
    'currect_answer'=>$row_question['question_option_currect'],
    'user_answer'=>'',
    'question_status'=>0,
  );

}



if(isset($_POST['session_out'])){
	session_destroy();
	echo "<script>window.location.href = './';</script>";
}
?>
