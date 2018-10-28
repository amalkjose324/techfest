<?php
include_once "db_connection.php";
if (!isset($_SESSION['userid'])) {
	 echo "<script>window.location.href = './';</script>";
}
$userid=$_SESSION['userid'];
$round=0;
$query = mysqli_query($con, "SELECT * FROM `techfest_users` WHERE `user_id`=$userid");
while ($row = mysqli_fetch_array($query)) {
  $round=$row['user_round'];
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

$_SESSION['techfest_questions'] = array(
  5 => array(
    'question'=>'Question1',
    'options'=>array(
      11=>'Option1',
      12=>'Option2',
      13=>'Option3',
      14=>'Option4',
    ),
    'answer_id'=>13,
    'user_answer-id'=>13,
    'question_status'=>0,
  )
);
$_SESSION['question_order']=range(1, $question_count);
shuffle($_SESSION['question_order']);

?>
