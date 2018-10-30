<?php
include_once "db_connection.php";

    $file="test.txt";
    $fopen = fopen($file, 'r');
    $fread = trim(fread($fopen,filesize($file)));
    fclose($fopen);
    $remove = "\n";
    $split = explode($remove, $fread);
    $array[] = null;
    $tab = "\t";
    foreach ($split as $string)
    {
        $row = explode($tab, $string);
        print_r($row);
        $currect_answer= $row[5];
        //
        //   $qst=$row[0];
        //   $res=mysqli_query($con,"INSERT INTO `techfest_questions`(`question_content`) VALUES  ('$qst')");
        //   #echo "INSERT INTO `techfest_questions`(`question_content`) VALUES  ('$qst')";
        //    $res1=mysqli_query($con,"select * from techfest_questions where question_content='$qst'");
        //    #echo "select * from techfest_question where question_content='$qst'";
        //    $r=mysqli_fetch_array($res1);
        //   echo $row[1];
        //   echo "<br>".$row[2];
        //   echo "<br>".$row[3];
        //    echo "<br>".$row[4];
        //   $id=$r['question_id'];
        //   $ans=$row[5];
        //   echo $ans;
        //     $i=1;
        //   while($i<=4)
        //   {
        //     if($ans==$row[$i])
        //     {
        //       echo "<br>aa";
        //       echo "<br>".$row[$i];
        //       #$res=mysqli_query($con,"INSERT INTO `techfest_choices`(`choice_question_id`, `choice_content`, `choice_iscurrect`) VALUES ('$id','$row[$i]','1')");
        //       #echo "INSERT INTO `techfest_choices`(`choice_question_id`, `choice_content`, `choice_iscurrect`) VALUES ('$id','$row[$i]','1')";
        //       $i=$i+1;
        //       echo $i;
        //     }
        //     else {
        //           echo "<br>".$row[$i];
        //         #$res=mysqli_query($con,"INSERT INTO `techfest_choices`(`choice_question_id`, `choice_content`, `choice_iscurrect`) VALUES ('$id','$row[$i]','0')");
        //       #  echo "INSERT INTO `techfest_choices`(`choice_question_id`, `choice_content`, `choice_iscurrect`) VALUES ('$id','$row[$i]','0')";
        //         $i=$i+1;
        //         echo "<br>".$i;
        //     }
        //   }

    }
?>
