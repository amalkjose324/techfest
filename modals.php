<!-- <link rel="stylesheet" href="./css/bootstrap.min.css"> -->
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="./js/bootstrap.min.js"></script>
<!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#modal_confirm_final_submit">Open Modal</button> -->
<div class="modal fade" id="modal_instruction_round_1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" style="min-width: 80%;">
    <!-- Modal content-->
    <div class="modal-content modal-instructions">
      <div class="modal-header">
        <h4 class="modal-title">Instructions for Brain Droop, Science Quiz : Tech-Fest, Azure 2k18 </h4>
        <h4 style="display: inline-block;float:right">
          <div class="timer-view col-md-2 col-sm-2 col-lg-2" id="timer-view">
            <h4 class="timer-head">Time Left</h4>
            <h4 style="font-weight:bold;color:red" class="instruction_timer_val">

            </h4>
          </div>
        </h4>
      </div>
      <div class="modal-body">
        <p>Read the following instructions carefully.</p>
        <ol type = "1">
          <li>1. The Brain Droop, Science Quiz Entry limited to degree students.</li>
          <li>2. It consists of 3 Rounds of multiple choice questions that are worth 4 point each. </li>
          <li>3. Participants are not allowed to use mobile phones or any other electronic gadgets during the contest. </li>
          <li>4. The questions from the area of Current Affairs,Science and Technology and Mental Ability. </li>
          <li>5. In case of a tie during the final round (Round-3), additional questions will be considered to finalize the event winner. </li>

          <li><b>Round-1 : </b><br>
            <ol type = "a">
              <li style="margin-left:15px;">a) This round consists 30 Multiple choice questions that are worth 4 point each and No Negative Marking.</li>
              <li style="margin-left:15px;">b) There is a time limit of 15 Minutes to complete this round and, the result generation time may vary.</li>
              <li style="margin-left:15px;">c) The result, including mark and next round eligiblity will be automatically generated after the final submission of this round.</li>
            </ol>
          </li>
          <li><b>Round-2 : </b><br>
            <ol type = "a">
              <li style="margin-left:15px;">a) This round consists 20 Multiple choice questions that are worth 4 point each and including Negative mark (-1) for each wrong answers.</li>
              <li style="margin-left:15px;">b) There is a time limit of 10 Minutes to complete this round and, the result generation time may vary.</li>
              <li style="margin-left:15px;">c) If there is in any tie in the results, the completed time and previous round marks also be considered.</li>
            </ol>
          </li>
          <li><b>Round-3 : </b><br>
            <ol type = "a">
              <li style="margin-left:15px;">a) This round consists Multiple choice questions and includes Passing Questions .</li>
              <li style="margin-left:15px;">b) Each primary questions have the time limit of 60 Seconds and secondary questions have the time limit of 30 Seconds.</li>
              <li style="margin-left:15px;">c) Each currect answer of primary questions have 10 Marks and wrong answer have Negative marking of 5 marks .</li>
              <li style="margin-left:15px;">d) Each currect answer of secondary / passed questions have 5 Marks and wrong answer have Negative marking of 2 marks .</li>
            </ol>
          </li>
        </ol>
      </div>
      <div class="modal-footer begin-footbar">
        <button type="button" class="btn btn-success btn-begin-round-1" data-dismiss="modal">Ready to Begin Quiz</button>
      </div>
    </div>
  </div>
</div>
</div>
<script>
$(document).ready(function () {
  $('#modal_instruction_round_1').modal('show');
  $('.btn-begin-round-1').click(function () {
    $fun="begin_round_1_modal";
    $.ajax({
      type:'post',
      url:'./quizactions.php',
      async:false,
      data:{fun:$fun},
      success:function(response)
      {
        var obj = JSON.parse(response)[0]['val'];
        if(obj){
          $('#modal_instruction_round_1').modal('hide');
          window.location.href = 'console.php';
        }
      }
    });
  })
})
</script>

<script>
setInterval(function(){
  $fun="instruction_timer";
  $.ajax({
    type:'post',
    url:'./quizactions.php',
    async:false,
    data:{fun:$fun},
    success:function(response)
    {
      var obj = JSON.parse(response)[0]['val'];
      if(obj){
        $('.instruction_timer_val').html(JSON.parse(response)[0]['time']);
      }else{
        $('.instruction_timer_val').html("00 : 00");
        $('.begin-footbar').show();

      }
    }
  });

},1000);
</script>
