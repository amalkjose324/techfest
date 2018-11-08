<?php
include_once "db_connection.php";

if(isset($_POST['fun'])&&$_POST['fun']=="question_change"){
  $arr = array();
  $qid=$_POST['question_id'];
  $current_question=$_SESSION['current_question'];
  $current_question_id=$_SESSION['question_order'][$current_question-1];
  $selected_val=$_POST['selected_option'];
  if(!$selected_val==0){
    if ((array_search($current_question, $_SESSION['attended_questions'])) === false) {
      array_push($_SESSION['attended_questions'], $current_question);
    }
  }else{
    if (($key = array_search($current_question, $_SESSION['attended_questions'])) !== false) {
      array_splice($_SESSION['attended_questions'], $key, 1);
    }
  }
  $_SESSION['techfest_questions'][$current_question_id]['user_answer']=$selected_val;
  $_SESSION['current_question']=$qid;
  if($_SESSION['current_question']==$qid){
    array_push($arr, array("val" => true));
  }else{
    array_push($arr, array("val" => false));
  }
  echo json_encode($arr);
  exit();
}
if(isset($_POST['fun'])&&$_POST['fun']=="question_change_next_question"){
  $arr = array();
  $current_question=$_SESSION['current_question'];
  $current_question_id=$_SESSION['question_order'][$current_question-1];
  $_SESSION['current_question']=$current_question+1;
  $selected_val=$_POST['selected_option'];
  if(!$selected_val==0){
    if ((array_search($current_question, $_SESSION['attended_questions'])) === false) {
      array_push($_SESSION['attended_questions'], $current_question);
    }
  }else{
    if (($key = array_search($current_question, $_SESSION['attended_questions'])) !== false) {
      array_splice($_SESSION['attended_questions'], $key, 1);
    }
  }
  $_SESSION['techfest_questions'][$current_question_id]['user_answer']=$selected_val;
  array_push($arr, array("val" => true));
  echo json_encode($arr);
  exit();
}
if(isset($_POST['fun'])&&$_POST['fun']=="question_final_submit"){
  $arr = array();
  $current_question=$_SESSION['current_question'];
  $current_question_id=$_SESSION['question_order'][$current_question-1];
  $selected_val=$_POST['selected_option'];
  if(!$selected_val==0){
    if ((array_search($current_question, $_SESSION['attended_questions'])) === false) {
      array_push($_SESSION['attended_questions'], $current_question);
    }
  }else{
    if (($key = array_search($current_question, $_SESSION['attended_questions'])) !== false) {
      array_splice($_SESSION['attended_questions'], $key, 1);
    }
  }
  $_SESSION['techfest_questions'][$current_question_id]['user_answer']=$selected_val;
  array_push($arr, array("val" => true));
  echo json_encode($arr);
  exit();
}
if(isset($_POST['fun'])&&$_POST['fun']=="question_option_reset"){
  $arr = array();
  $current_question=$_SESSION['current_question'];
  $current_question_id=$_SESSION['question_order'][$current_question-1];
  $_SESSION['techfest_questions'][$current_question_id]['user_answer']=0;
  if (($key = array_search($current_question, $_SESSION['attended_questions'])) !== false) {
    array_splice($_SESSION['attended_questions'], $key, 1);
  }
  array_push($arr, array("val" => true));
  echo json_encode($arr);
  exit();
}
if(isset($_POST['fun'])&&$_POST['fun']=="reset_session"){
  $userid=$_SESSION['userid'];
  $arr = array();
  if($_POST['password']=="123"){
    mysqli_query($con,"UPDATE `techfest_users` SET `user_login_status`=0 WHERE `user_id`=$userid");
    session_destroy();
    array_push($arr, array("val" => true));
  }else{
    $_SESSION['reset_session_error_count']--;
    array_push($arr, array("val" => false));
  }
  echo json_encode($arr);
  exit();
}

if(isset($_POST['fun'])&&$_POST['fun']=="begin_round_1_modal"){
  $userid=$_SESSION['userid']=$_SESSION['temp_userid'];
  $arr = array();
  if(mysqli_query($con, "UPDATE `techfest_users` SET `user_round` = 1 WHERE `user_id`=$userid")){
    array_push($arr, array("val" => true));
  }else{
    array_push($arr, array("val" => false));
  }
  echo json_encode($arr);
  exit();
}
if(isset($_POST['fun'])&&$_POST['fun']=="round_2_winner"){
  $userid=$_SESSION['userid'];
  $arr = array();
  if(mysqli_query($con, "UPDATE `techfest_users` SET `user_round` = 4 WHERE `user_id`=$userid")){
    array_push($arr, array("val" => true));
    session_destroy();
  }else{
    array_push($arr, array("val" => false));
  }
  echo json_encode($arr);
  exit();
}
if(isset($_POST['fun'])&&$_POST['fun']=="exit_from_quiz"){
  $userid=$_SESSION['userid']=$_SESSION['temp_userid'];
  $arr = array();
  if(mysqli_query($con, "UPDATE `techfest_users` SET `user_round` = 5,`user_login_status`=0 WHERE `user_id`=$userid")){
    session_destroy();
    array_push($arr, array("val" => true));
  }else{
    array_push($arr, array("val" => false));
  }
  echo json_encode($arr);
  exit();
}
if(isset($_POST['fun'])&&$_POST['fun']=="final_submission"){
  $userid=$_SESSION['userid'];
  $user_round=$_SESSION['user_round'];
  $_SESSION['final_submit']=true;
  $time_remain=$_SESSION['quiz_remain_time'];
  mysqli_query($con, "UPDATE `techfest_users` SET `user_submission` = 1,`user_round_2_time`=$time_remain WHERE `user_id`=$userid");
  $_SESSION['quiz_end_time']=strtotime(date('Y-m-d H:i:s'));
  $currect_answer_count=0;
  $wrong_answer_count=0;
  $mark=0;
  foreach ($_SESSION['techfest_questions'] as $question) {
    if($question['currect_answer']===$question['user_answer']){
      $currect_answer_count++;
      $mark+=4;
    }else{
      $wrong_answer_count++;
      if($user_round==2){
        if(!$question['user_answer']==0){
          $mark--;
        }
      }
    }
  }
  $arr = array();
  mysqli_query($con, "UPDATE `techfest_users` SET `user_round".$user_round."_mark` = $mark WHERE `user_id`=$userid");
  $selcheck=mysqli_query($con,"SELECT * FROM `techfest_users` WHERE `user_round`=$user_round AND `user_submission`=0");
  if(mysqli_num_rows($selcheck)>0){
    array_push($arr, array("val" => false));
  }else{
    $passmark=0;
    $winners=$user_round==1?3:4;
    $selcheck=mysqli_query($con,"SELECT `user_round".$user_round."_mark` AS `mark` FROM `techfest_users` ORDER BY `user_round".$user_round."_mark` DESC LIMIT $winners,1");
    while ($selcheckrow=mysqli_fetch_array($selcheck)) {
      $passmark=$selcheckrow['mark'];
    }
    if($mark>=$passmark){
      array_push($arr, array("val" => true,"pass_status"=>true,"pass_mark"=>$passmark,"userround"=>$user_round));
    }else{
      array_push($arr, array("val" => true,"pass_status"=>false,"pass_mark"=>$passmark,"userround"=>$user_round));
    }
  }
  echo json_encode($arr);
  exit();
}

if(isset($_POST['fun'])&&$_POST['fun']=="question_review_set_reset"){
  $arr = array();
  $current_question=$_SESSION['current_question'];
  $current_question_id=$_SESSION['question_order'][$current_question-1];
  $selected_val=$_POST['selected_option'];
  $_SESSION['techfest_questions'][$current_question_id]['user_answer']=$selected_val;
  if(!$selected_val==0){
    if ((array_search($current_question, $_SESSION['attended_questions'])) === false) {
      array_push($_SESSION['attended_questions'], $current_question);
    }
  }else{
    if (($key = array_search($current_question, $_SESSION['attended_questions'])) !== false) {
      array_splice($_SESSION['attended_questions'], $key, 1);
    }
  }
  if (($key = array_search($current_question, $_SESSION['reviewed_questions'])) !== false) {
    array_splice($_SESSION['reviewed_questions'], $key, 1);
  }else{
    array_push($_SESSION['reviewed_questions'], $current_question);
  }
  array_push($arr, array("val" => true));
  echo json_encode($arr);
  exit();

}
if(isset($_POST['fun'])&&$_POST['fun']=="continue_to_next_round"){
  $arr = array();
  $userid=$_SESSION['userid'];
  unset($_SESSION['current_question']);
  unset($_SESSION['question_order']);
  unset($_SESSION['quiz_end_time']);
  unset($_SESSION['techfest_questions']);
  unset($_SESSION['attended_questions']);
  unset($_SESSION['reviewed_questions']);
  unset($_SESSION['final_submit']);
  mysqli_query($con, "UPDATE `techfest_users` SET `user_round` = `user_round`+1 WHERE `user_id`=$userid");

  array_push($arr, array("val" => true));
  echo json_encode($arr);
  exit();
}

if(isset($_POST['fun'])&&$_POST['fun']=="instruction_timer"){
  $arr = array();
  if (!isset($_SESSION['instruction_end_time'])) {
    $_SESSION['instruction_end_time'] = strtotime(date('Y-m-d H:i:s')) + 60;
    // echo "yes";
  }
  $instruction_time_now = strtotime(date('Y-m-d H:i:s'));
  $instruction_end_time = $_SESSION['instruction_end_time'];
  $instruction_time_left     = $instruction_end_time - $instruction_time_now;
  if ($instruction_time_left < 1) {
    array_push($arr, array("val" => false,"time"=>"00 : 00"));
  } else {
    $timeval= addPreZeroTime(floor($instruction_time_left / 60)) . " : " . addPreZeroTime($instruction_time_left % 60);
    array_push($arr, array("val" => true,"time"=>$timeval));
  }
  echo json_encode($arr);
  exit();
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
