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
      if(isset($_POST['view_Tprofile'])) {
        header("location: teacherProfile.php");
    }

  $displayform = false;
  $displayform2 = false;

if(isset($_POST['getform'])) {
  $displayform = true;
}
if(isset($_POST['create_exam'])) {
    $displayform2 = true;
}  
if(isset($_POST['add_question'])) {
    $displayform2 = true;
}
if(isset($_POST['add_last_q'])) {
    $displayform2 = false;
}
$examid = uniqid('test_');

  
if(isset($_POST['editex'])) {
    $_SESSION['examination_id'] = $exam_id;
    
    header("location: editexam.php");
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
            if(isset($_POST['back'])) {
                $displayform = false;
                echo "
                #box {
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
                  <input class="profile" type="submit" name="view_Tprofile" value="Profile"
                    <?php if($displayform) { echo"disabled style='font-weight: bold;'"; }  ?>
                  >
                  <input class="logout" type="submit" name="T_logout" value="Log Out"
                  <?php if($displayform) { echo"disabled style='font-weight: bold;'"; }  ?>
                  >
                </form>
            </div>
        </div>
        <div class="classroom">
            <a href="teacherClassroom.php"><?php echo $_SESSION['classroom_name']; ?></a>
        </div>
        <div class="description">
            <b><i class="fa fa-chevron-right" aria-hidden="true"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i>Description: &nbsp;&nbsp;&nbsp;<?php echo $_SESSION['class_Description'];?> </i></i></b>

        </div>
        <div class="buttons">
            <form method="post">
                <button name="getform" class="getdata">Create A <br> New Exam</button>
            </form>
        </div>
        
                <div class='table'>
                    <table class='table1'>
                        <tr style='background-color: rgb(71, 71, 182);color: white; height:40px;'>
                            <td colspan='8'><b>Scheduled Exams</b></td>
                        </tr>
                        <tr style='background-color: rgb(169, 169, 255);color:  rgb(0, 0, 125); height:35px;'>
                            <td style='width: 100px;';>ID</td>
                            <td style='width: 180px;';>Name</td>
                            <td style='width: 120px;';>Date</td>
                            <td>Start Time</td>
                            <td>End Time</td>
                            <td>Questions</td>
                            <td>Total Marks</td>
                            <td>Status</td>
                        </tr>
                    <?php
                        $result = getExams();
                        if(mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                $sr_no = $row['Sr_No'];
                                $exam_id =  $row['exam_id'];
                                $exam_name =  $row['exam_name'];
                                $exam_date =  $row['exam_date'];
                                $start_time =  $row['start_time'];
                                $end_time =  $row['end_time'];
                                $questions =  $row['no_of_questions'];
                                $marks =  $row['marks_per_question'];

                                $total_marks = $questions * $marks;
                        
                                if(isset($_POST[$exam_id])) {
                                    $_SESSION['examination_id'] = $exam_id;
                                    $_SESSION['examination_name'] = $exam_name;

                                    header("location: editExam.php");
                                }
                                if(isset($_POST[$sr_no])) {
                                    $tblnam = $_SESSION['classroom_id'];
                                    $resultTbl = "result_".$exam_id;

                                    $delQuery = "DELETE FROM $tblnam WHERE Sr_No = $sr_no";
                                    $runDelQuery = mysqli_query($GLOBALS['con'], $delQuery);

                                    $delTblQuery = "DROP TABLE $exam_id";
                                    $runDelTblQuery = mysqli_query($GLOBALS['con'], $delTblQuery);

                                    $delresultTblQuery = "DROP TABLE $resultTbl";
                                    $runDelTblQuery = mysqli_query($GLOBALS['con'], $delresultTblQuery);

                                    header("Refresh:0");
                                }

                    ?>
                        <tr style='background-color:  rgb(175, 175, 175);color: black; height:35px;'>
                            <td class='data'> <?php echo $exam_id ?> </td>
                            <td class='data'> <?php echo $exam_name ?> </td>
                            <td class='data'> <?php echo $exam_date ?> </td>
                            <td class='data'> <?php echo $start_time ?> </td>
                            <td class='data'> <?php echo $end_time ?> </td>
                            <td class='data'> <?php echo $questions ?> </td>
                            <td class='data'> <?php echo $total_marks ?> </td>
                            <td class='data'> 
                                <form method="post">
                    <?php
                            if($exam_date == date("Y-m-d") && $start_time > date("H:i:s") || $exam_date > date("Y-m-d")) {
                    ?>

                                    <button name='<?php echo $exam_id;?>'class ="exview">View</button>
                                    <button name='<?php echo $sr_no;?>'class ="exview"><i class="fa fa-trash del_exam"></i></button>
                    <?php 
                            }
                            
                            else {
                                    echo "Exam Started";
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
                        <tr style='background-color:  rgb(175, 175, 175);color: black; height:35px;'>
                            <td colspan='8'>No Data</td>
                        </tr>
                    <?php }?>
                    </table>
                </div>
        <?php
            
        ?>
                <div class='table'>
                    <table class='table1'>
                        <tr style='background-color: rgb(71, 71, 182);color: white; height:40px;'>
                            <td colspan='6'><b>Compleated Exams</b></td>
                        </tr>
                        <tr style='background-color: rgb(169, 169, 255);color:  rgb(0, 0, 125); height:35px;'>
                            <td style='width: 70px;';>ID</td>
                            <td style='width: 180px;';>Exam Name</td>
                            <td style='width: 120px;';>Exam Date</td>
                            <td>Total Marks</td>
                            <td>Class Average</td>
                            <td style='width: 90px;';>Status</td>
                        </tr>
                        
                        <?php
                            $result = getCompletedExams();
                            if(mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    $Cexam_id = $row['exam_id'];
                                    $Cexam_name =  $row['exam_name'];
                                    $Cexam_date =  $row['exam_date'];
                                    $questions =  $row['no_of_questions'];
                                    $Cmarks =  $row['marks_per_question'];
                                    $Ctotal_marks = $questions * $Cmarks; 

                                    $resultButton_name = "result_".$Cexam_id;

                                    $tablename = "result_". $Cexam_id;
                                    $avg_sql = "SELECT AVG(result) AS class_avg FROM $tablename";
                                    $avg_result = mysqli_query($GLOBALS['con'], $avg_sql);
                                    $row = mysqli_fetch_assoc($avg_result);
                                    $class_Average = $row['class_avg'];

                                    if(isset($_POST[$Cexam_id])) {
                                        $_SESSION['exam_id_results'] = $Cexam_id;
                                        $_SESSION['exam_name_results'] = $Cexam_name;

                                        header("location: examResult.php");
                                    }

                        ?>
                            <tr class='data' style='background-color:  rgb(175, 175, 175);color: black; height:35px;'>
                                <td style='width: 70px;';><?php echo $Cexam_id?></td>
                                <td style='width: 180px;';><?php echo $Cexam_name?></td>
                                <td style='width: 120px;';><?php echo $Cexam_date?></td>
                                <td><?php echo $Ctotal_marks?></td>
                                <td><?php echo $class_Average?></td>
                                <td style='width: 90px;';>
                                <form method="post">
                                    <button name='<?php echo $Cexam_id;?>'class ="exview">View Result</button>
                                </form>
                                </td>
                            </tr>

                        <?php
                                }
                            }
                            else {  
                        ?>

                        <tr style='background-color:  rgb(175, 175, 175);color: black; height:35px;'>
                            <td colspan='6'>No Data</td>
                        </tr>
                        <?php
                            }
                        ?>
                    </table>
                </div>
        <?php
            
        ?>
    </div>

    <div id="box">
        <form  method="post" class="popup">
            <div class="inputs">
                <div class="info">
                    <label><b>Exam Id:</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input value='<?php echo $examid?>' name='exam_Id' type='text' readonly="readonly"> <br>

                    <label><b>Exam Name:</b></label>&nbsp;
                    <input  name='exam_name' type='text' placeholder='Enter Exam Name' required> <br>

                    <label><b>Exam Date:</b></label>&nbsp;&nbsp;
                    <input  name='exam_date' type='date' placeholder='Enter Exam Date' required> <br>

                    <label><b>Start Time:</b></label>&nbsp;&nbsp;
                    <input  name='start_time' type='time' step="1" placeholder='Enter Exam Start Time' required> <br>

                    <label><b>End Time:</b></label>&nbsp;&nbsp;
                    <input  name='end_time' type='time' step="1" placeholder='Enter Exam End Time' required> <br>

                    <label><b>Questions:</b></label>&nbsp;&nbsp;
                    <input  name='questions' type='number' min='1' max='100' placeholder='Enter total number of questions' required> <br>

                    <label><b>Marks per question:</b></label>
                    <input name='marks' type='number' min='1' max='4' placeholder='Enter Marks per question' required> <br>
                </div>

                <button name='create_exam' class='new_classroom submit'>Create</button>
            </div>
        </form>
        <form method="post" class='buttons'>
            <button name="back" class="new_classroom back">Back</button>  
        </form>
    </div>

    <?php 
        if(isset($_POST['create_exam'])) {
            addQuestions(); 
        }

        if(isset($_POST['add_question'])) {
            $exam_id = $_SESSION['temp_exam_id'];
            $ques_no = $_SESSION['temp_no_questions'];
    
            $question = $_POST['question'];
            $option_1 = $_POST['option_1'];
            $option_2 = $_POST['option_2'];
            $option_3 = $_POST['option_3'];
            $option_4 = $_POST['option_4'];
            $answer_op = $_POST['answer_op'];
    
            $query = "INSERT INTO `$exam_id` (question, option_1, option_2, option_3, option_4, answer_option)
                                    VALUES ('$question', '$option_1', '$option_2', '$option_3', '$option_4', '$answer_op')    
                                ";
            $result = mysqli_query($GLOBALS['con'], $query); 
    
            $count = getQuestionCount();
    
            if($ques_no > $count) {
                addQuestions();
            }
        }

        if(isset($_POST['add_last_q'])) {
            $exam_id = $_SESSION['temp_exam_id'];
            $ques_no = $_SESSION['temp_no_questions'];
    
            $question = $_POST['question'];
            $option_1 = $_POST['option_1'];
            $option_2 = $_POST['option_2'];
            $option_3 = $_POST['option_3'];
            $option_4 = $_POST['option_4'];
            $answer_op = $_POST['answer_op'];
        
            $query = "INSERT INTO `$exam_id` (question, option_1, option_2, option_3, option_4, answer_option)
                                    VALUES ('$question', '$option_1', '$option_2', '$option_3', '$option_4', '$answer_op')    
                                ";
            $result = mysqli_query($GLOBALS['con'], $query); 
    
            $count = getQuestionCount();

            if($ques_no > $count) {
                addQuestions();
            }
        }
    ?>
<script>
    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>
