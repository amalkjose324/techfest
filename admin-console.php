<?php
include_once "db_connection.php";
if (!isset($_SESSION['userid'])) {
  echo "<script>window.location.href = './';</script>";
}else if(!$_SESSION['u_type']==2){
  echo "<script>window.location.href = 'console.php';</script>";
}

function pre_postRemover($value)
{
  $value = preg_replace('/^\"/', '', $value);
  $value = preg_replace('/\"$/', '', $value);
  return $value;
}
if(isset($_POST['filesubmit'])){
  $type=$_POST['filetype'];
  $type_text=$type==1?'Users':'Questions';
  $uq_count=0;
  $file=$_FILES['file']['tmp_name'];
  $fopen = fopen($file, 'r');
  $fread = trim(fread($fopen,filesize($file)));
  fclose($fopen);
  $remove = "\n";
  $split = explode($remove, $fread);
  $array[] = null;
  $tab = "\t";
  foreach ($split as $string)
  {
    if($uq_count==0){
      $uq_count++;
      continue;
    }
    $row = explode($tab, $string);
    // print_r($row);
    if($type==2){
      $question=pre_postRemover($row[0]);
      $round=$_POST['question_round'];
      $option1=pre_postRemover($row[1]);
      $option2=pre_postRemover($row[2]);
      $option3=pre_postRemover($row[3]);
      $option4=pre_postRemover($row[4]);
      $q_insert_query=mysqli_query($con,"INSERT INTO `techfest_questions`(`question_content`, `question_option_currect`, `question_option_wrong1`, `question_option_wrong2`, `question_option_wrong3`, `question_round`) VALUES ('$question','$option1','$option2','$option3','$option4',$round)");
      if(mysqli_affected_rows($con)>0){
        $uq_count++;
      }
    }else{
      $username=pre_postRemover($row[2]);
      $password=pre_postRemover($row[3]);
      $fullname=pre_postRemover($row[0]);
      $college=pre_postRemover($row[1]);
      $u_insert_query=mysqli_query($con,"INSERT INTO `techfest_users`(`user_username`, `user_password`, `user_fullname`, `user_college`) VALUES ('$username','$password','$fullname','$college')");
      if(mysqli_affected_rows($con)>0){
        $uq_count++;
      }
    }
  }
  $uq_count--;
  echo "<script>alert('$uq_count $type_text Added');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Quiz Console</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--===============================================================================================-->
  <link rel="icon" type="image/png" href="favicon.ico" />
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" >
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="css/util.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <!--===============================================================================================-->
</head>
<body>
  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-quiz100 quiz-bg col-md-11 col-sm-11 col-lg-11" style="overflow: overlay;">
        <div class="row col-sm-12 text-center">
          <div class="col-sm-4">
            <h3>View Data</h3>
            <hr/>
            <ul class="nav nav-tabs ">
              <div class="form-group col-sm-12">
                <a data-toggle="tab" href="#menu1">
                  <li class="form-control btn-sel sel-active">Users</li>
                </a>
              </div>
              <div class="form-group col-sm-12">
                <a data-toggle="tab" href="#menu2">
                  <li class="form-control btn-sel">Questions</li>
                </a>
              </div>
              <div class="form-group col-sm-12">
                <a data-toggle="tab" href="#menu3">
                  <li class="form-control btn-sel">Marks</li>
                </a>
              </div>
            </ul>
            <hr>
            <h3>Upload Users / Questions</h3>
            <hr/>
              <p>
              <a href="./assets/Questions_Format.xlsx" download="Questions_Format.xlsx" class="download_link col-sm-6 text-center"><i class="fa fa-download"></i>Questions Format</a>
              <a href="./assets/Users_Format.xlsx" download="Users_Format.xlsx" class="download_link col-sm-6 text-center"><i class="fa fa-download"></i>Users Format</a>
            </p>
            <hr>
            <form action="" method="post" enctype="multipart/form-data" onsubmit="return " id="fileupload_form">
              <div class="form-group">
                <select name="filetype" id="filetype" class="form-control">
                  <option selected disabled>File Type</option>
                  <option value="1">Users List</option>
                  <option value="2">Questions List</option>
                </select>
              </div>
              <div class="form-group">
                <select name="question_round" id="question_round"class="form-control">
                  <option selected disabled>Select Round</option>
                  <option value="1">Round-1</option>
                  <option value="2">Round-2</option>
                </select>
              </div>
              <div class="form-group">
                <input type="file" name="file" placeholder="Path / Drag file here" id="file" pattern="[a-zA-Z0-9_-\s]{0,}\.txt" title="Text files (.txt) required" class="form-control" >
              </div>
              <div class="form-group">
                <button type="submit" name="filesubmit" class="btn btn-primary col-sm-8 filesubmit">Submit</button>
              </div>
            </form>
          </div>

          <div class="col-sm-8 col-auto" >
            <div class="tab-content">

              <div id="menu1" class="tab-pane active">
                <h3>Users</h3>
                <p>
                  <table class="table table-striped dataTable">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>College</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $user_sel_query=mysqli_query($con,"SELECT * FROM `techfest_users` WHERE `user_type`=1");
                      while ($user_sel_row=mysqli_fetch_array($user_sel_query)) {
                        ?>
                        <tr>
                          <td><?php echo $user_sel_row['user_fullname']?></td>
                          <td><?php echo $user_sel_row['user_username']?></td>
                          <td><?php echo $user_sel_row['user_password']?></td>
                          <td><?php echo $user_sel_row['user_college']?></td>
                        </tr>
                        <?php
                      }
                      ?>
                    </tbody>
                  </table>
                </p>
              </div>
              <div id="menu2" class="tab-pane fade">
                <h3>Questions</h3>
                <p>
                  <table class="table table-striped dataTable">
                    <thead>
                      <tr>
                        <th>Round</th>
                        <th>Question</th>
                        <th>Option-1</th>
                        <th>Option-2</th>
                        <th>Option-3</th>
                        <th>Option-4</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $question_sel_query=mysqli_query($con,"SELECT * FROM `techfest_questions`");
                      while ($question_sel_row=mysqli_fetch_array($question_sel_query)) {
                        $options=array($question_sel_row['question_option_currect'],$question_sel_row['question_option_wrong1'],$question_sel_row['question_option_wrong2'],$question_sel_row['question_option_wrong3']);
                        shuffle($options);
                        ?>
                        <tr>
                          <td><?php echo "Round-".$question_sel_row['question_round']?></td>
                          <td><?php echo $question_sel_row['question_content']?></td>
                          <?php
                          foreach ($options as $option) {
                            if($option==$question_sel_row['question_option_currect']){
                              ?><td style="color:red;"><?php echo $option?></td><?php
                            }else{
                              ?><td><?php echo $option?></td><?php
                            }
                          }
                          ?>
                        </tr>
                        <?php
                      }
                      ?>
                    </tbody>
                  </table>
                </p>
              </div>
              <div id="menu3" class="tab-pane fade">
                <h3>Marks</h3>
                <p>
                  <table class="table table-striped dataTable">
                    <thead>
                      <tr>
                        <th>Student</th>
                        <th>College</th>
                        <th>Mark (Round-1)</th>
                        <th>Mark (Round-2)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $mark_sel_query=mysqli_query($con,"SELECT * FROM `techfest_users` WHERE `user_type`=1");
                      while ($mark_sel_row=mysqli_fetch_array($mark_sel_query)) {
                        ?>
                        <tr>
                          <td><?php echo $mark_sel_row['user_fullname']?></td>
                          <td><?php echo $mark_sel_row['user_college']?></td>
                          <td><?php echo $mark_sel_row['user_round1_mark']?></td>
                          <td><?php echo $mark_sel_row['user_round2_mark']?></td>
                        </tr>
                        <?php
                      }
                      ?>
                    </tbody>
                  </table>
                </p>
              </div>
            </div>
          </div>


        </div>
      </div>

    </div>
  </div>
</body>
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/bootstrap/js/popper.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/tilt/tilt.jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function () {
  $('#question_round').hide();
  $('#filetype').on("change",function () {
    var val=$(this).val();
    if(val==1){
      $('#question_round').hide();
    }else if(val==2){
      $('#question_round').show();
    }
  });
  $('.btn-sel').each(function () {
    $(this).click(function () {
      $('.btn-sel').removeClass('sel-active');
      $(this).addClass('sel-active');
    });
  });
  $('.dataTable').each(function () {
    $(this).DataTable();
  });
  $('.download_link').each(function () {
    $(this).click(function () {
      alert("Open downloaded file in Excel and save as .txt file to upload");
    })
  })
  $('#fileupload_form').on("submit",function () {
    var ftype=$('#filetype').val();
    var roundval=$('#question_round').val();
    var filename=$('#file').val();
    var fileRegExp= /\.txt$/;
    var numRegExp=/^[1-2]{1}$/;
    if(!numRegExp.test(ftype)){
      alert("Select an upload type!");
      $('#filetype').focus();
      return false;
    }else{
      if(ftype==1){
        if(!fileRegExp.test(filename)){
          alert("Select Valid Text (.txt) file!");
          $('#file').val('');
          $('#file').focus();
          return false;
        }else{
          return true;
        }
      }else if(ftype==2){
        if(!numRegExp.test(roundval)){
          alert("Select Question Round!");
          $('#question_round').focus();
          return false;
        }else if(!fileRegExp.test(filename)){
          alert("Select Valid Text (.txt) file!");
          $('#file').val('');
          $('#file').focus();
          return false;
        }else{
          return true;
        }
      }else{
        alert("Select an upload type!");
        $('#filetype').focus();
        return false;
      }
    }
  })
})
</script>
</html>
