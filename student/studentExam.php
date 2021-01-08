<?php
    require_once("studentOperation.php");
    
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
    if(!($_SESSION['access_to_exam'])) {
      header("location:  studentHome.php");
    }
    if(!$_SESSION['isstudentloggedin']) {
    session_reset();

    session_destroy();
    header("location: studentlogin.php");
    exit;
    }
    if(isset($_POST['T_logout'])) {
        session_reset();
  
        session_destroy();
        header("location: ../index.php");
    }
    if(isset($_POST['back_to_S_classroom'])) {
        header("location:  studentClassroom.php");
    }
    if(isset($_POST['submit_exam'])){

      // $tableName = "S_".$_SESSION['GR_No']. "_".$_SESSION['test_id'];

      // $Query = "SELECT * FROM $tableName";

      // $result = mysqli_query($GLOBALS['con'], $Query);

      // if(mysqli_num_rows($result) > 0) {
      //     while($row = mysqli_fetch_assoc($result)) {
      //         $srno = $row['sr_no'];

      //         $selected_option = $_POST[$srno];

      //         $tablenm = "S_".$_SESSION['GR_No']. "_".$_SESSION['test_id'];

      //         $addChoices = "UPDATE $tablenm SET your_choice = '$selected_option'
      //                        WHERE sr_no = '$srno'
      //                       ";

      //         mysqli_query($GLOBALS['con'], $addChoices);

      //     }
      // }
      // $resultTable =  "result_" . $_SESSION['test_id'];
      // $student_id = $_SESSION['GR_No'];

      // $updateResultTable = "UPDATE $resultTable SET exam_status = 'Complete' WHERE gr_no = '$student_id'";

      // mysqli_query($GLOBALS['con'], $updateResultTable);

      // header("location:  studentClassroom.php");

    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css_stylesheets/studentExam.css?v=<?php echo time(); ?>" type="text/css" />
  <title><?php echo $_SESSION['test_name']; ?></title>
  </head>
<body>
<div id="dark">
  <div class="head">
    <h1 class="headline">Online Exam System</h1>
    <div class="nav">
      <form method="post">
        <a href="../student/studentHome.php"><i id="home-icon" class="fa fa-home"></i></a>
        <input class="profile" type="submit" name="back_to_S_classroom" value="Classroom" > 
        <input name="T_logout" class="logout" type="submit" value="Log Out">
      </form>
    </div>
  </div>
</div>

      <div class="timer">
        <!-- <h1>01:00:00</h1>  -->
      </div>
      <div class='exam_form'>
          <h1><?php echo $_SESSION['test_name'];?></h1>
          <div class='exam_questions'>
            <form action='endexam.php' method="post" id='formid' >
              <table>
                <?php
                   $result = getExamQuestions();
                   if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                      $sr_no = $row['Sr_No'];
                      $question = $row['question'];
                      $option_a = $row['option_1'];
                      $option_b = $row['option_2'];
                      $option_c = $row['option_3'];
                      $option_d = $row['option_4'];
                      // $ans_op = $row['answer_option'];
                ?>
                <tr>
                  <td style='width: 10%;text-align: right;'>
                    <label><b>Q- <?php echo $sr_no?>: </b></label>
                  </td>
                  <td style='width: 90%;'>
                    <b><?php echo $question?></b>
                  </td>
                </tr>
                <tr>
                  <td style='width: 10%;text-align: right;'>
                    <label> a) </label> 
                  </td>
                  <td style='width: 90%;'>
                    <input value="a" type="radio" name="<?php echo $sr_no?>" id="a">
                    <label> <?php echo $option_a?></label>
                  </td>
                </tr>
                <tr>
                  <td style='width: 10%;text-align: right;'>
                    <label> b) </label>                  
                  <td style='width: 90%;'>
                    <input value="b" type="radio" name="<?php echo $sr_no?>" id="b">
                    <label> <?php echo $option_b?></label>
                  </td>
                </tr>
                <tr>
                  <td style='width: 10%;text-align: right;'>
                    <label> c) </label>                  
                  <td style='width: 90%;'>
                    <input value="c" type="radio" name="<?php echo $sr_no?>" id="c">
                    <label> <?php echo $option_c?></label>
                  </td>
                </tr>
                <tr>
                  <td style='width: 10%;text-align: right;'>
                    <label> d) </label>                 
                  <td style='width: 90%;'>
                    <input value="d" type="radio" name="<?php echo $sr_no?>" id="d">
                    <label> <?php echo $option_d?></label>
                  </td>
                </tr>
                <tr>
                  <td colspan='2'> <?php echo "  ";?> </td>
                </tr>

                <?php
                    }
                  }
                ?>
              </table>
              <hr>
              <div style="text-align: center;">
                  <input id="auto_onclick" name='submit_exam' type="submit" class="new_classroom submit" value='Submit Exam'>
                <!-- <button name='submit_exam' class='new_classroom submit'>Submit Exam</button> -->
              </div>
            </form>
          </div>
      </div>

<script>
  
      // document.getElementById("formid").submit();

    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>

