<?php 
    require_once('../server/db.php');
    require_once("teacherOperation.php");

   
    $con = Createdb();

    
    if(isset($_POST['create_exam'])) {
        $cal_date = $_POST['exam_date'];
        $exam_date = date('Y-m-d',strtotime($cal_date));
        $exam_id = $_POST['exam_Id'];
        $_SESSION['temp_exam_id'] = $exam_id;
        $exam_name = $_POST['exam_name'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $questions = $_POST['questions'];
        $_SESSION['temp_no_questions'] = $questions;
        $marks = $_POST['marks'];

        $classroomid = $_SESSION['classroom_id'];
        $query = "INSERT INTO $classroomid (exam_id, exam_name, exam_date, start_time, end_time, no_of_questions, marks_per_question, exam_status)
                    VALUES ('$exam_id', '$exam_name', '$exam_date', '$start_time', '$end_time', '$questions', '$marks', 'Incomplete')
                    ";

        $result = mysqli_query($GLOBALS['con'], $query);

        $classExamQuery = "CREATE TABLE IF NOT EXISTS `$exam_id` (
                    Sr_No INT AUTO_INCREMENT UNIQUE,
                    question VARCHAR(100),
                    option_1 VARCHAR(80),
                    option_2 VARCHAR(80),
                    option_3 VARCHAR(80),
                    option_4 VARCHAR(80),
                    answer_option VARCHAR(2)
                )";
        $createExamTable = mysqli_query($GLOBALS['con'], $classExamQuery);

        $resultTable = "result_" . $exam_id;

        $examResultquery = "CREATE TABLE IF NOT EXISTS $resultTable (
                    gr_no VARCHAR(10) PRIMARY KEY,
                    exam_status VARCHAR(10) DEFAULT 'Incomplete',
                    result INT(3)
                )";

        mysqli_query($GLOBALS['con'], $examResultquery);
        
        $sql = "SELECT GR_No FROM students 
                WHERE Elective_1 = '$classroomid' OR Elective_2 = '$classroomid' OR Elective_3 = '$classroomid'
               ";
        $answer = mysqli_query($GLOBALS['con'], $sql);
 
        if(mysqli_num_rows($answer) > 0) {
            while($row = mysqli_fetch_assoc($answer)) {
                $grNO = $row['GR_No'];

                $Query = "INSERT INTO $resultTable (GR_No) VALUES ('$grNO')";

                mysqli_query($GLOBALS['con'], $Query);
            }
        }
    }

    function getExams() {
        $classroomid = $_SESSION['classroom_id'];

        $query = "SELECT * FROM $classroomid WHERE exam_status = 'Incomplete'";

        $result = mysqli_query($GLOBALS['con'], $query);

        return $result;
    }

    function getQuestionCount() {
        $tableNam = $_SESSION['temp_exam_id'];

        $query = "SELECT COUNT(*) as total FROM `$tableNam`";
        $result = mysqli_query($GLOBALS['con'], $query);
        $row = mysqli_fetch_assoc($result);

        $count = $row['total'];
        return $count;
    }

    function updateExamStatus() {
        $tablenm = $_SESSION['classroom_id'];

        $query = "SELECT * FROM $tablenm";
        $result = mysqli_query($GLOBALS['con'], $query);
        
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $exam_id =  $row['exam_id'];
                $exam_date =  $row['exam_date'];
                $start_time =  $row['start_time'];
                $end_time =  $row['end_time'];

                if(($exam_date < date("Y-m-d")) || ($exam_date == date("Y-m-d") && $end_time < date("H:i:s"))) {
                    
                    $sql = "UPDATE $tablenm SET exam_status = 'Complete' WHERE exam_id = '$exam_id'";
                    mysqli_query($GLOBALS['con'], $sql);
        
                }
            }
        }
        // header("Refresh:0");   
    }
    
?>

    

<?php

    function addQuestions() {
        $ques_no = $_SESSION['temp_no_questions'];
        $no = getQuestionCount() + 1;
?>
    <div id="box2">
        <form  method="post" class="popup">
            <div class="inputs2">
                <div class="info">

                    <label><b>Question<?php echo " $no"?>:</b></label>
                    <input  name='question' type='text' placeholder='Enter the Question' required> <br>
                
                    <label><b>Option 1:</b></label>
                    <input name='option_1' type='text' placeholder='Enter Option 1' required> <br>
                    
                    <label><b>Option 2:</b></label>
                    <input name='option_2' type='text' placeholder='Enter Option 2' required> <br>

                    <label><b>Option 3:</b></label>
                    <input name='option_3' type='text' placeholder='Enter Option 3' required> <br>

                    <label><b>Option 4:</b></label>
                    <input name='option_4' type='text' placeholder='Enter Option 4' required> <br>

                    <label><b>Answer:</b></label>
                    <input name='answer_op' type='text' placeholder='Enter Answer Option' required> <br>                    
        
                </div>
                <?php
                    if($ques_no == $no) {
                ?>    
                    <button name='add_last_q' class='new_classroom submit'>Add</button>
                <?php
                    }
                    else {
                ?>
                <button name='add_question' class='new_classroom submit'>Add</button>
                <?php
                    }
                ?>
            </div>
        </form>

        <form method="post" class='buttons'>
            <button name="back" class="new_classroom back">Back</button>  
        </form>
        
    </div>

<?php 
    }
    function getExamDetails() {
        $tablename = $_SESSION['classroom_id'];
        $editexamid = $_SESSION['examination_id'];

        $query = "SELECT * FROM $tablename WHERE exam_id = '$editexamid'";

        $result = mysqli_query($GLOBALS['con'], $query);

        return $result;
    }

    function getALLExamQuestions() {
        $tablename = $_SESSION['examination_id'];
        $query = "SELECT * FROM $tablename";
    
        $result = mysqli_query($GLOBALS['con'], $query);

        return $result;
    }

    function getCompletedExams() {
        $tablename = $_SESSION['classroom_id'];

        $query = "SELECT * FROM $tablename WHERE exam_status = 'Complete'";

        $result = mysqli_query($GLOBALS['con'], $query);

        return $result;
    }

    
    function getClassroomResult() {
        $table = "result_".$_SESSION['exam_id_results'];
        $query = "SELECT * FROM $table";

        $result = mysqli_query($GLOBALS['con'], $query);

        return $result;
     }

     function getQuestionTobeedited() {
        $table = $_SESSION['exam_id_results'];

        $query = "SELECT * FROM $table WHERE Sr_No = ''";

        $result = mysqli_query($GLOBALS['con'], $query);

        return $result;
     }
?>


<?php
    function editEachQuestionForm() {
        $Q_no = $_SESSION['q_no'];
        $ques = $_SESSION['respective_question'];
        $a = $_SESSION['respective_option_a'];
        $b = $_SESSION['respective_option_b'];
        $c = $_SESSION['respective_option_c'];
        $d = $_SESSION['respective_option_d'];
        $ans = $_SESSION['respective_answer'];


?>
        <div id="box2">
              <form  method="post" class="popup">
                <div class="inputs2">
                  <div class="info">
                    <label><b>Question<?php echo " $Q_no"?>:</b></label>
                    <input value='<?php echo $ques?>'  name='Q_no' type='text' placeholder='Enter the Question' required> <br>
                      
                    <label><b>Option 1:</b></label>
                    <input value='<?php echo $a?>' name='a' type='text' placeholder='Enter Option 1' required> <br>
                          
                    <label><b>Option 2:</b></label>
                    <input value='<?php echo $b?>' name='b' type='text' placeholder='Enter Option 2' required> <br>

                    <label><b>Option 3:</b></label>
                    <input value='<?php echo $c?>' name='c' type='text' placeholder='Enter Option 3' required> <br>

                    <label><b>Option 4:</b></label>
                    <input value='<?php echo $d?>' name='d' type='text' placeholder='Enter Option 4' required> <br>

                    <label><b>Answer:</b></label>
                    <input value='<?php echo $ans?>' name='ans' type='text' placeholder='Enter Answer Option' required> <br>                    
                  </div>
                    <button name='edit_question' class='new_classroom submit'>Add</button>
                </div>
              </form>
              <form method="post" class='buttons'>
                    <button name="back" class="new_classroom back">Back</button>  
              </form>
            </div>
<?php
    }

    if(isset($_POST['edit_question'])) {
        $tblName = $_SESSION['examination_id'];
        $Q_no = $_SESSION['q_no'];

        $edited_question = $_POST['Q_no'];
        $edited_option_a = $_POST['a'];
        $edited_option_b = $_POST['b'];
        $edited_option_c = $_POST['c'];
        $edited_option_d = $_POST['d'];
        $edited_ansewer = $_POST['ans'];
        
        $sql = "UPDATE $tblName SET question = '$edited_question' WHERE Sr_No = '$Q_no'";
        mysqli_query($GLOBALS['con'], $sql);

        $sql = "UPDATE $tblName SET option_1 = '$edited_option_a' WHERE Sr_No = '$Q_no'";
        mysqli_query($GLOBALS['con'], $sql);

        $sql = "UPDATE $tblName SET option_2 = '$edited_option_b' WHERE Sr_No = '$Q_no'";
        mysqli_query($GLOBALS['con'], $sql);

        $sql = "UPDATE $tblName SET option_3 = '$edited_option_c' WHERE Sr_No = '$Q_no'";
        mysqli_query($GLOBALS['con'], $sql);

        $sql = "UPDATE $tblName SET option_4 = '$edited_option_d' WHERE Sr_No = '$Q_no'";
        mysqli_query($GLOBALS['con'], $sql);

        $sql = "UPDATE $tblName SET answer_option = '$edited_ansewer' WHERE Sr_No = '$Q_no'";
        mysqli_query($GLOBALS['con'], $sql);

    }   

?>