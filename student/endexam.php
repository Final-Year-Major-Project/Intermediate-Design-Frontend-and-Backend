<?php

require_once("studentOperation.php");

echo "<script>
        alert('Are you sure you want to end the Test?');
    </script>";

    
    $tableName = $_SESSION['test_id'];

      $Query = "SELECT * FROM $tableName";

      $result = mysqli_query($GLOBALS['con'], $Query);

      $count = 0;
      if(mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
              $srno = $row['Sr_No'];
              $Answer = $row['answer_option'];
              

              $selected_option = $_POST[$srno];

              if($Answer == $selected_option) {
                  $count = $count + 1;
              }

          }
      }

      $table = $_SESSION['classroom_id'];
      $query = "SELECT * FROM $table WHERE exam_id = '$tableName'";
      $Result = mysqli_query($GLOBALS['con'], $query);

      if(mysqli_num_rows($Result) > 0) {
        while($row = mysqli_fetch_assoc($Result)) {
            $marks_per_q = $row['marks_per_question'];
        }
      }      

      $score = $count * $marks_per_q; 

      $resultTable =  "result_" . $_SESSION['test_id'];     
      $student_id = $_SESSION['GR_No'];

      $updateResultTable = "UPDATE $resultTable SET exam_status = 'Complete' WHERE gr_no = '$student_id'";
      mysqli_query($GLOBALS['con'], $updateResultTable);

      $updateResultTable = "UPDATE $resultTable SET result = $score WHERE gr_no = '$student_id'";
      mysqli_query($GLOBALS['con'], $updateResultTable);


      header("location:  studentClassroom.php");
