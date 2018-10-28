<?php
session_start();
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
$_SESSION['question_order']=range(1, 20);
shuffle($_SESSION['question_order']);

print_r($_SESSION['question_order'][1]);
// print_r($val=$_SESSION['quiz'][1]);
// $allKeys = array_keys($_SESSION['quiz'][1]);
// echo $allKeys[0];
// print_r($_SESSION['quiz'][1][$val]);
?>
