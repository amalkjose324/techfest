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
?>
