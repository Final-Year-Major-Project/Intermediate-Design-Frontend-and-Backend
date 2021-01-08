<?php
  require_once("classOperations.php");

    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

    if(!$_SESSION['isteacherloggedin']) {
      session_reset();

      session_destroy();
      header("location: teacherlogin.php");
      exit;
    }
    if(isset($_POST['T_logout'])) {
      session_reset();

      session_destroy();
      header("location: ../index.php");
    }
    if(isset($_POST['back_to_classroom'])) {
      header("location:  teacherClassroom.php");
    }
    $displayform = false;
    $displayform2 = false;
    if(isset($_POST['edit_exam_details'])) {
      $displayform = true;
    }
    
    
    for($i = 1; $i <= 100; $i++) {
      if(isset($_POST[$i])) {
        $displayform2 = true;
      }
    }
    


    if(isset($_POST['update_exam_details'])) {
        $id = $_POST['eid'];
        $name = $_POST['ename'];
        $date = $_POST['edate'];
        $St_T = $_POST['st_Time'];
        $end_T = $_POST['end_Time'];
        $Mark = $_POST['markperQ'];

        $tblname = $_SESSION['classroom_id'];

        $query = "UPDATE $tblname SET exam_name = '$name' WHERE exam_id = '$id'";
        mysqli_query($GLOBALS['con'], $query);

        $query = "UPDATE $tblname SET exam_date = '$date' WHERE exam_id = '$id'";
        mysqli_query($GLOBALS['con'], $query);

        $query = "UPDATE $tblname SET start_time = '$St_T' WHERE exam_id = '$id'";
        mysqli_query($GLOBALS['con'], $query);

        $query = "UPDATE $tblname SET end_time = '$end_T' WHERE exam_id = '$id'";
        mysqli_query($GLOBALS['con'], $query);

        $query = "UPDATE $tblname SET marks_per_question = '$Mark' WHERE exam_id = '$id'";
        mysqli_query($GLOBALS['con'], $query);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css_stylesheets/classroom.css?v=<?php echo time(); ?>" type="text/css" />
  <title>Home</title>
  <style>
      <?php
        if($displayform) {
          echo "
              #dark::before {
                  content: '';
                  opacity: 0.75;
                  background: black;
                  position: absolute;
                  height: 700%;
                  width: 100%;
              }
              #box {
                  opacity: 1;
                  background-color: gainsboro;
                  position: absolute;
                  top: 100px;
                  bottom: 100px;
                  left: 23%;
                  right: 23%;
                  height: 500px;
                  width: 54%;
                  box-shadow: 2px 4px 15px 1px black;
                  box-shadow: 9px 9px 7px 3px rgba(50, 50, 50, 0.75);  
              }
              .inputs {
                  margin-top: 80px;
                  Position: relatives;
                  margin-left: 10%;
              }
              
              @media (max-width: 768px) {  
                  #box {
                      width: 90%;
                      left: 5%; 
                  }
              }
          ";
      }
      else {
          echo "
              #box  {
                  display: none;
              }
          ";
      }
      if($displayform2) {
        echo "
            #dark::before {
                content: '';
                opacity: 0.75;
                background: black;
                position: absolute;
                height: 700%;
                width: 100%;
            }
            #box2 {
                opacity: 1;
                background-color: gainsboro;
                position: absolute;
                top: 100px;
                bottom: 100px;
                left: 23%;
                right: 23%;
                height: 500px;
                width: 54%;
                box-shadow: 2px 4px 15px 1px black;
                box-shadow: 9px 9px 7px 3px rgba(50, 50, 50, 0.75);   
            }
            .inputs2 {
                margin-top: 50px;
                Position: relatives;
                margin-left: 10%;
            }
            
            @media (max-width: 768px) {  
                #box {
                    width: 90%;
                    left: 5%; 
                }
            }
        ";
      }
      else {
          echo "
              #box2  {
                  display: none;
              }
          ";
      }
      ?>
  </style>

  </head>
<body>
<div id="dark">
  <div class="head">
    <h1 class="headline">Online Exam System</h1>
    <div class="nav">
      <form action="" method="post">
        <a href="../teacher/teacherHome.php"><i id="home-icon" class="fa fa-home"></i></a>
        <input class="profile" type="submit" name="back_to_classroom" value="Classroom" > 
        <input name="T_logout" class="logout" type="submit" value="Log Out">
      </form>
    </div>
  </div>


  <div class='table'>
    <table class='table1'>
      <tr style='background-color: rgb(71, 71, 182);color: white; height:50px;'>
        <td colspan='8'><b><?php echo "Edit ".$_SESSION['examination_name'];?></b></td>
      </tr>
      <tr style='background-color: rgb(169, 169, 255);color:  rgb(0, 0, 125); height:45px;'>
        <td style='width: 70px;';>ID</td>
        <td style='width: 200px;';>Name</td>
        <td style='width: 120px;';>Date</td>
        <td>Start time</td>
        <td>End time</td>
        <td>Questions</td>
        <td>Marks/Qs</td>
        <td style='width: 90px;';>Status</td>
      </tr>

      <?php
        $result = getExamDetails();
        if(mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
            $exam_id =  $row['exam_id'];
            $exam_name =  $row['exam_name'];
            $exam_date =  $row['exam_date'];
            $start_time =  $row['start_time'];
            $end_time =  $row['end_time'];
            $questions =  $row['no_of_questions'];
            $marks =  $row['marks_per_question'];
      ?>
        <tr style='background-color:  rgb(175, 175, 175);color: black; height:40px;'>
          <td class='data'> <?php echo $exam_id ?> </td>
          <td style='width: 200px;' class='data'> <?php echo $exam_name ?> </td>
          <td class='data'> <?php echo $exam_date ?> </td>
          <td class='data'> <?php echo $start_time ?> </td>
          <td class='data'> <?php echo $end_time ?> </td>
          <td class='data'> <?php echo $questions ?> </td>
          <td class='data'> <?php echo $marks ?> </td>
          <td class='data'> 
            <form method="post">
              <button name='edit_exam_details'class ="exview">Edit</button>
            </form>
          </td>
        </tr>

      <?php
          }
        }
      ?>
      <tr style='background-color: rgb(169, 169, 255);color:  rgb(0, 0, 125);height:45px;'>
        <td style='width: 70px;';>Q-No</td>
        <td style='width: 200px;';>Question</td>
        <td style='width: 120px;';>Option a</td>
        <td>Option b</td>
        <td>Option c</td>
        <td>Option d</td>
        <td>Answer</td>
        <td style='width: 90px;';>Status</td>
      </tr>

      <?php
        $result2 = getALLExamQuestions();
        if(mysqli_num_rows($result2) > 0) {
          while($row = mysqli_fetch_assoc($result2)) {
            $No = $row['Sr_No'];
            $question =  $row['question'];
            $option_a =  $row['option_1'];
            $option_b =  $row['option_2'];
            $option_c =  $row['option_3'];
            $option_d =  $row['option_4'];
            $answer =  $row['answer_option'];

            if(isset($_POST[$No])) {
              $_SESSION['q_no']= $No;
              $_SESSION['respective_question'] = $question;
              $_SESSION['respective_option_a'] = $option_a;
              $_SESSION['respective_option_b'] = $option_b;
              $_SESSION['respective_option_c'] = $option_c;
              $_SESSION['respective_option_d'] = $option_d;
              $_SESSION['respective_answer'] = $answer;

              editEachQuestionForm();
            }


      ?>

        <tr style='background-color:  rgb(175, 175, 175);color: black;height:40px;'>
          <td class='data'> <?php echo $No ?> </td>
          <td class='data'> <?php echo $question ?> </td>
          <td class='data'> <?php echo $option_a ?> </td>
          <td class='data'> <?php echo $option_b ?> </td>
          <td class='data'> <?php echo $option_c ?> </td>
          <td class='data'> <?php echo $option_d ?> </td>
          <td class='data'> <?php echo $answer ?> </td>
          <td class='data'> 
            <form method="post">
              <button name='<?php echo $No ?>'class ="exview">Edit</button>
            </form>
          </td>
        </tr>

      <?php
          }
        }
      ?>

    </table>
  </div>


      <div id="box">
        <form  method="post" class="popup">
            <div class="inputs">
                <div class="info">
                    <label><b>Exam Id:</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input value='<?php echo $exam_id?>' name='eid' type='text' readonly="readonly"> <br>

                    <label><b>Exam Name:</b></label>&nbsp;
                    <input value='<?php echo $exam_name?>'  name='ename' type='text' placeholder='Enter Exam Name' required> <br>

                    <label><b>Exam Date:</b></label>&nbsp;&nbsp;
                    <input value='<?php echo $exam_date?>'  name='edate' type='date' placeholder='Enter Exam Date' required> <br>

                    <label><b>Start Time:</b></label>&nbsp;&nbsp;
                    <input value='<?php echo $start_time?>'  name='st_Time' type='time' step="1" placeholder='Enter Exam Start Time' required> <br>

                    <label><b>End Time:</b></label>&nbsp;&nbsp;
                    <input value='<?php echo $end_time?>'  name='end_Time' type='time' step="1" placeholder='Enter Exam End Time' required> <br>

                    <label><b>Marks per question:</b></label>
                    <input value='<?php echo $marks?>'  name='markperQ' type='number' min='1' max='4' placeholder='Enter Marks per question' required> <br>
                </div>

                <button name='update_exam_details' class='new_classroom submit'>Update</button>
            </div>
        </form>
        <form method="post" class='buttons'>
            <button name="back" class="new_classroom back">Back</button>  
        </form>
      </div>

      <?php
      
      ?>
      

      

</div>
<script>
    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>