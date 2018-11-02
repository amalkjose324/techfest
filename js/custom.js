$(document).on("click",".grid-button",function () {
  $qid=(this.innerHTML).trim();
  $selected_val=$('input[name=quiz_options]:checked').val();
  if (typeof $selected_val === "undefined") {
    $selected_val=0;
  }
  $fun="question_change";
  $.ajax({
    type:'post',
    url:'./quizactions.php',
    async:false,
    data:{question_id:$qid,fun:$fun,selected_option:$selected_val},
    success:function(response)
    {
      var obj = JSON.parse(response)[0]['val'];
      if(obj){
        $('.question_space').load(' .question_space');
      }
    }
  });
})
$(document).on("click",".btn_next_question",function () {
  $fun="question_change_next_question";
  $selected_val=$('input[name=quiz_options]:checked').val();
  if (typeof $selected_val === "undefined") {
    $selected_val=0;
  }
  $.ajax({
    type:'post',
    url:'./quizactions.php',
    async:false,
    data:{fun:$fun,selected_option:$selected_val},
    success:function(response)
    {
      var obj = JSON.parse(response)[0]['val'];
      if(obj){
        $('.question_space').load(' .question_space');
      }
    }
  });
})
$(document).on("click",".btn_reset_options",function () {
  $fun="question_option_reset";
  $.ajax({
    type:'post',
    url:'./quizactions.php',
    async:false,
    data:{fun:$fun},
    success:function(response)
    {
      var obj = JSON.parse(response)[0]['val'];
      if(obj){
        $('.question_space').load(' .question_space');
      }
    }
  });
})
$(document).on("click",".btn_mark_review",function () {
  $fun="question_review_set_reset";
  $selected_val=$('input[name=quiz_options]:checked').val();
  if (typeof $selected_val === "undefined") {
    $selected_val=0;
  }
  $.ajax({
    type:'post',
    url:'./quizactions.php',
    async:false,
    data:{fun:$fun,selected_option:$selected_val},
    success:function(response)
    {
      var obj = JSON.parse(response)[0]['val'];
      if(obj){
        $('.question_space').load(' .question_space');
      }
    }
  });
})
$(document).on("change","input[name=quiz_options]",function () {
  $('.btn_reset_options').removeClass('btn-hidden');
})
