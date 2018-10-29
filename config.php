<?php
include_once "db_connection.php";
if (!isset($_SESSION['userid'])) {
	 echo "<script>window.location.href = './';</script>";
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

$questions_query = mysqli_query($con, "SELECT * FROM `techfest_questions` WHERE `question_type`=$round");
while ($row_question = mysqli_fetch_array($questions_query)) {
  $qid=$row_question['question_id'];
  $_SESSION['techfest_questions'][$qid]=array(
    'question'=>$row_question['question_content'],
    'user_answer-id'=>0,
    'question_status'=>0,
  );
  $choice_query = mysqli_query($con, "SELECT * FROM `techfest_choices` WHERE `choice_question_id`=$qid");
  while ($row_choice = mysqli_fetch_array($choice_query)) {
    $cid=$row_choice['choice_id'];
    $_SESSION['techfest_questions'][$qid]=array(
      'options'=>array(
        $cid=>$row_choice['choice_content'],
      ),
      'answer_id'=>10,
    );
    if($row_choice['choice_iscurrect']==1){
      $_SESSION['techfest_questions'][$qid]=array(
        'answer_id'=>$cid,
      );
    }
  }

}



print_r($_SESSION['techfest_questions']);
$_SESSION['question_order']=range(1, $question_count);
shuffle($_SESSION['question_order']);
?>
