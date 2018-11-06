<?php
include_once "db_connection.php";
// include_once 'modals.php';

if (!isset($_SESSION['userid'])) {
  echo "<script>window.location.href = './';</script>";
}
?>
<link rel="stylesheet" href="./css/bootstrap.min.css">
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="./js/bootstrap.min.js"></script>

<!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#modal_confirm_final_submit">Open Modal</button> -->
<div class="modal fade" id="modal_session_reset_pop" role="dialog" data-backdrop="static" data-keyboard="false">
   <div class="modal-dialog">
     <!-- Modal content-->
     <div class="modal-content">
       <div class="modal-header">
         <h4 class="modal-title">Enter your password. Note, all data in quiz will be loss.</h4>
       </div>
       <form class="form_reset_modal" method="post" action="./" onsubmit=" return">
       <div class="modal-body">
          <div class="form-group">
            <input type="password" class="form-control" id="passval" placeholder="Password" required autofocus>
          </div>
          <div class="form-group" style="text-align:center;">
            <span class="label label-danger error_modal_reset form-control" style="padding:0.6em;border-radius:8px;"></span>
          </div>
       </div>
       <div class="modal-footer text-center">
         <button type="button" class="btn btn-danger close_reset_modal">Cancel</button>
         <button type="submit" class="btn btn-success submit_reset_modal">Submit</button>
       </div>
     </form>
     </div>
   </div>
 </div>
<script>
$(document).ready(function () {
  $('#modal_session_reset_pop').modal('show');
  $('.close_reset_modal').click(function () {
    $('#modal_session_reset_pop').modal('hide');
    window.location.href='./';
  })
  $error_count=3;
  $('.form_reset_modal').on("submit",function () {
    $password=$('#passval').val();
    $fun="reset_session";
    $password.trim();
    $.ajax({
      type:'post',
      url:'./quizactions.php',
      async:false,
      data:{password:$password,fun:$fun},
      success:function(response)
      {
        var obj = JSON.parse(response)[0]['val'];
        if(obj){
            window.location.href='./';
        }
        else{
          $error_count--;
          if($error_count>0){
            $('.error_modal_reset').html("Invalid Password..!  (Remaining "+$error_count+" more attempts)");
          }else{
            window.location.href='./';
          }
        }
      }
    });
    return false;
  })
})
</script>
