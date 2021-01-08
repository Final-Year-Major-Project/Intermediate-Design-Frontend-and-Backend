<?php
    require_once("studentOperation.php");
    
    if(!isset($_SESSION)) 
    { 
        session_start(); 
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
    if(isset($_POST['view_Tprofile'])) {
        header("location: studentProfile.php");
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classroom</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css_stylesheets/classroom.css?v=<?php echo time(); ?>" type="text/css" />
</head>
<body>
    <div id="dark">
        <div class="head">
            <h1 class="headline">Online Exam System</h1>
            <div class="nav">
                <form action="" method="post">
                  <a href="../student/studentHome.php"><i id="home-icon" class="fa fa-home"></i></a>
                  <input class="profile" type="submit" name="view_Tprofile" value="Profile">
                  <input class="logout" type="submit" name="T_logout" value="Log Out">
                </form>
            </div>
        </div>
        <div class="classroom">
            <a href="studentClassroom.php"><?php echo $_SESSION['classroom_name']; ?></a>
        </div>
        <div class="description">
            <b><i class="fa fa-chevron-right" aria-hidden="true"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i>Description: &nbsp;&nbsp;&nbsp;<?php echo $_SESSION['class_Description'];?> </i></i></b>
        </div>
        
        <?php
            
        ?>      <div class='table'>
                    <table class='table1'>
                        <tr style='background-color: rgb(71, 71, 182);color: white; height:45px;'>
                            <td colspan='7'><b>Scheduled Exams</b></td>
                        </tr>
                        <tr style='background-color: rgb(169, 169, 255);color:  rgb(0, 0, 125); height:42px;'>
                            <td style='width: 180px;';>Exam Name</td>
                            <td style='width: 120px;';>Exam Date </td>
                            <td>Start Time</td>
                            <td>End Time</td>
                            <td>Questions</td>
                            <td>Marks</td>
                            <td>Status</td>
                        </tr>

                        <?php
                            $result = getStExams();
                            if(mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $exam_id =  $row['exam_id'];
                                    $exam_name =  $row['exam_name'];
                                    $exam_date =  $row['exam_date'];
                                    $start_time =  $row['start_time'];
                                    $end_time =  $row['end_time'];
                                    $questions =  $row['no_of_questions'];
                                    $marks =  $row['marks_per_question'];
                                    $total_marks = $questions * $marks;
                                    $_SESSION['test_id'] = $exam_id;

                                    if(isset($_POST[$exam_id])) {
                                        $_SESSION['test_id'] = $exam_id;
                                        $_SESSION['test_name'] = $exam_name;
                                        $_SESSION['exam_end_time'] = $end_time;

                                        // creatChoicesTable();
                                        header("location: studentExam.php");
                                    }                                    
                        ?>
                        <tr style='background-color:  rgb(175, 175, 175);color: black; height:40px;'>
                            <td class='data'> <?php echo $exam_name ?> </td>
                            <td class='data'> <?php echo $exam_date ?> </td>
                            <td class='data'> <?php echo $start_time ?> </td>
                            <td class='data'> <?php echo $end_time ?> </td>
                            <td class='data'> <?php echo $questions ?> </td>
                            <td class='data'> <?php echo $total_marks ?> </td>
                            <td class='data'> 
                                <form method="post">

                                    <?php
                                        $button_status = verifyExamStatus();
                                        if(($exam_date == date("Y-m-d")) && ($start_time <= date("H:i:s")) &&($end_time > date("H:i:s"))) {
                                            if($button_status) {
                                                $_SESSION['access_to_exam'] = true;
                                    ?>
                                                <button name='<?php echo $exam_id;?>'class ="exview start_exam">Start Exam</button>
                                    <?php            
                                            }
                                            else {
                                                echo "Compleated";
                                            }
                                        }
                                        elseif(($exam_date == date("Y-m-d") && $start_time > date("H:i:s")) || $exam_date > date("Y-m-d")) {
                                            $_SESSION['access_to_exam'] = false;
                                    ?>
                                            Exam Not Started
                                    <?php
                                        }
                                        
                                        if($exam_date < date("Y-m-d")) {
                                            $_SESSION['access_to_exam'] = false;
                                            echo "Exam Ended";
                                            
                                            updateExamStatus();
                                        }
                                        elseif($exam_date == date("Y-m-d") && $end_time < date("H:i:s")) {
                                            $_SESSION['access_to_exam'] = false;
                                            echo "Exam Ended";
                                            
                                            updateExamStatus();
                                        }
                                        
                                    ?>
                                </form>
                            </td>
                        </tr>
                        <?php
                                }
                            }
                            else {
                        ?>
                        <tr  style='color:rgb(90, 90, 90);background-color:rgb(175, 175, 175);height:35px;font-size:18px;'>
                            <td colspan='7'>No Scheduled Exams</td>
                        </tr>
                        <?php 
                            }
                        ?>
                    </table>
                </div>
            
                <div class='table'>
                    <table class='table1'>
                        <tr style='background-color: rgb(71, 71, 182);color: white; height:40px;'>
                            <td colspan='6'><b>Compleated Exams</b></td>
                        </tr>
                        <tr style='background-color: rgb(169, 169, 255);color:  rgb(0, 0, 125); height:35px;'>
                            <td style='width: 180px;';>Exam Name</td>
                            <td style='width: 120px;';>Exam Date</td>
                            <td>Total Marks</td>
                            <td>Your Score</td>
                            <td>Is Attempted?</td>
                            <td style='width: 90px;';>Status</td>
                        </tr>

                    <?php
                        // $yourResult = getYourResult();
                        $result = getCompletedExams();
                        if(mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                $Cexam_sr_no = $row['Sr_No'];
                                $Cexam_id  = $row['exam_id'];
                                $Cexam_name =  $row['exam_name'];
                                $Cexam_date =  $row['exam_date'];
                                $questions =  $row['no_of_questions'];
                                $Cmarks =  $row['marks_per_question'];
                                $Ctotal_marks = $questions * $Cmarks;

                                $student = $_SESSION['GR_No'];
                                $table = "result_". $Cexam_id;
                                $sql = "SELECT * FROM $table WHERE gr_no = '$student'";

                                $sqlResult = mysqli_query($GLOBALS['con'], $sql);

                                if(mysqli_num_rows($sqlResult) > 0) {
                                    while($row = mysqli_fetch_assoc($sqlResult)) {
                                        $yourResult = $row['result'];
                                        $status = $row['exam_status'];
                                    }
                                }
                                if(isset($_POST[$Cexam_sr_no])) {
                                    $_SESSION['answer_key_ex_id'] = $Cexam_id;
                                    $_SESSION['answer_key_ex_name'] = $Cexam_name;

                                    header("location: answerKey.php");
                                }                                     
                    ?>

                        <tr style='background-color:  rgb(175, 175, 175);color: black; height:35px;'>
                            <td class='data' style='width: 180px;';><?php echo $Cexam_name?></td>
                            <td class='data' style='width: 120px;';><?php echo $Cexam_date?></td>
                            <td class='data'><?php echo $Ctotal_marks?></td>
                            <td class='data'>
                                <?php 
                                    echo $yourResult;
                                    if(!$yourResult) {
                                        echo '0';
                                    }
                                ?>
                            </td>
                            <td class='data'>
                                <?php
                                    if($status = 'Complete') {
                                        echo 'Attempted';
                                    }
                                    else {
                                        echo 'Not Attempted';
                                    }
                                ?>
                            </td>
                            <td class='data' style='width: 90px;';>
                                <form method="post">
                                    <button name='<?php echo $Cexam_sr_no;?>'class ="exview">View</button>                                    
                                </form>
                            </td>
                        </tr>

                    <?php
                            }
                        }
                        else {
                    ?>

                        <tr  style='color:rgb(90, 90, 90);background-color:rgb(175, 175, 175);height:35px;font-size:18px;'>
                            <td colspan='6s'>No Data</td>
                        </tr>
                    <?php
                        }
                    ?>
                    </table>
                </div>
    </div>


<script>
    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>