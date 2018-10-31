<?php
include_once "db_connection.php";

if(isset($_POST['password'])){
  $arr = array();
  if($_POST['password']=="reset@123"){
    session_destroy();
    array_push($arr, array("val" => true));
  }else{
    array_push($arr, array("val" => false));
  }
  echo json_encode($arr);
  exit();
}

if (!isset($_SESSION['userid'])) {
  echo "<script>window.location.href = './';</script>";
}else{
  ?>
  	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
  <script>
  show_prompt();
  function show_prompt() {
    $error_count=0;
    $prompt_msg="Enter your password. Note, all data in quiz will be loss.";
    while($error_count<3){
      $error_count++;
      $password=prompt($prompt_msg);
      $.ajax({
        type:'post',
        url:'./reset.php',
        async:false,
        data:{password:$password},
        success:function(response)
        {
          var obj = JSON.parse(response)[0]['val'];
          if(obj){
            $error_count=3;
          }
          else{
            $prompt_msg="Incurrect Password! Please try again ("+(3-$error_count)+" Chances left)";
          }
        }
      });
    }
    window.location.href='./';
  }
</script>
<?php
}
?>
