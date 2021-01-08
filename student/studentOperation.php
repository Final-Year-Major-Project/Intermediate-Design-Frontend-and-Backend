<?php 
    require_once("../server/db.php");

    
    session_start();

    
    $con = Createdb();

    if(!$con) {
        echo "Cannot connect to the Database";
    }

    if(isset($_POST['S_login'])) {
        studentVerification();
    }

    function studentVerification() {

        $student_GRNo = $_POST['S_Gr_No_check'];
        $student_mail = $_POST['S_Email_check'];
        $student_pswd = $_POST['S_pswd_check'];

        if( $student_GRNo && $student_mail && $student_pswd) {

        $verify = "SELECT * FROM students WHERE GR_No = '$student_GRNo'";

        $success = mysqli_query($GLOBALS['con'], $verify);

            if(mysqli_num_rows($success) > 0) {
                $registration = true;
                    while($row = mysqli_fetch_assoc($success)) {
                        if($row['Email'] == $student_mail &&  $row['Pswd'] == $student_pswd) {
                        $_SESSION['isstudentloggedin'] = true;
                        $_SESSION['GR_No'] = $row['GR_No'];
                        $_SESSION['First_Name'] = $row['first_Name'];
                        $_SESSION['Middle_Name'] = $row['middle_Name'];
                        $_SESSION['Last_Name'] = $row['last_Name'];
                        $_SESSION['Email'] = $row['Email'];
                        $_SESSION['Department'] = $row['Department'];
                        $_SESSION['branch_Id'] = $row['branch_Id'];
                        
                        header('location: studentHome.php');
                        
                    }
                    else {
                        $_SESSION['isstudentloggedin'] = false;
                        textNode('tomato', "Error: Invalid Credentials!");
                    } 
                }
            }
            else {
                $_SESSION['isstudentloggedin'] = false;
                textNode('tomato', "Error: No such user Exists!");
            }
        }
    }
    
    function checkData() {
        $student_GRNo = $_SESSION['GR_No'];
        $verify = "SELECT * FROM students WHERE GR_No = '$student_GRNo'";

        $success = mysqli_query($GLOBALS['con'], $verify);

        if(mysqli_num_rows($success) > 0) {
            $registration = true;
            while($row = mysqli_fetch_assoc($success)) {
                $_SESSION['Personal_Email'] = $row['Personal_Email'];
                $_SESSION['C_address'] = $row['C_address'];
                $_SESSION['P_address'] = $row['P_addess'];
                $_SESSION['contact_No'] = $row['contact_No'];
                $_SESSION['guardians_contact_No'] = $row['guardians_contact_No'];
                $_SESSION['Year'] = $row['Year'];
                $_SESSION['Semister'] = $row['Semister'];
                $_SESSION['Divison'] = $row['Divison'];
                $_SESSION['Roll_No'] = $row['Roll_No'];
            }
        }
        $personal_data = $_SESSION['Personal_Email']&&$_SESSION['C_address']&&$_SESSION['P_address']&&$_SESSION['contact_No']&&$_SESSION['guardians_contact_No'];
        $Edu_data = $_SESSION['Semister']&&$_SESSION['Divison']&&$_SESSION['Roll_No'];

        if(empty($personal_data) && empty($Edu_data)) {
            $profile_strength = '33';
        }
        elseif(empty($personal_data) ||empty( $Edu_data)) {
            $profile_strength = '66';
        }
        else {
            $profile_strength = '100';
        }
        return $profile_strength;
    }

    function formStatus() {
        $profile_strength = checkData();
        $personal_data = $_SESSION['Personal_Email']&&$_SESSION['C_address']&&$_SESSION['P_address']&&$_SESSION['contact_No']&&$_SESSION['guardians_contact_No'];
        $Edu_data = $_SESSION['Semister']&&$_SESSION['Divison']&&$_SESSION['Roll_No'];

        if($profile_strength == '33') {
            $form = "displayboth";
        }
        elseif($profile_strength == '66') {
            if(empty($personal_data)) {
                $form = "displayPform";
            }
            else {
                $form = "displayEform";
            }
        }
        else {
            $form ="displaynone";
        }
        return $form;
    }
    function textNode($color, $msg) {
        $element = "<h4 style='background-color: $color;padding: 1em;'>$msg</h4>";
        echo $element;
    }

    if(isset($_POST['p_confirm'])) {
        insertPersonalData();
    }
    if(isset($_POST['ed_confirm'])) {
        insertEduData();
    }


    function insertPersonalData() {
        $Grno = $_SESSION['GR_No'];
        $Personal_Email = $_POST['p_email'];
        $Corresp_address = $_POST['c_address'];
        $Permant_address = $_POST['p_address'];
        $Contact_No = $_POST['c_number'];
        $Guardian_No = $_POST['g_c_number'];

        $sql = "UPDATE students SET Personal_Email = '$Personal_Email' WHERE GR_No = '$Grno'";
        mysqli_query($GLOBALS['con'], $sql);

        $sql = "UPDATE students SET C_address = '$Corresp_address' WHERE GR_No = '$Grno'";
        mysqli_query($GLOBALS['con'], $sql);

        $sql = "UPDATE students SET P_addess = '$Permant_address' WHERE GR_No = '$Grno'";
        mysqli_query($GLOBALS['con'], $sql);

        $sql = "UPDATE students SET contact_No = '$Contact_No' WHERE GR_No = '$Grno'";
        mysqli_query($GLOBALS['con'], $sql);

        $sql = "UPDATE students SET guardians_contact_No = '$Guardian_No' WHERE GR_No = '$Grno'";
        mysqli_query($GLOBALS['con'], $sql);

        checkData();
        formStatus();
    }


    function insertEduData() {
        $Grno = $_SESSION['GR_No'];
        $year = $_POST['Year'];
        $Semister = $_POST['Semister'];
        $Division = $_POST['Division'];
        $Roll_No = $_POST['rollno'];

        $sql = "UPDATE students SET Year = '$year' WHERE GR_No = '$Grno'";
        mysqli_query($GLOBALS['con'], $sql);

        $sql = "UPDATE students SET Semister = '$Semister' WHERE GR_No = '$Grno'";
        mysqli_query($GLOBALS['con'], $sql);

        $sql = "UPDATE students SET Divison = '$Division' WHERE GR_No = '$Grno'";
        mysqli_query($GLOBALS['con'], $sql);

        $sql = "UPDATE students SET Roll_No = '$Roll_No' WHERE GR_No = '$Grno'";
        mysqli_query($GLOBALS['con'], $sql);

        checkData();
        formStatus();
    }
    function getSubjects() {
        $branch = $_SESSION['branch_Id'];
        $year = $_SESSION['Year'];
        $sem = $_SESSION['Semister']; 

        $sql = "SELECT subject_id, subject_Name FROM subjects WHERE branch_Id = '$branch' AND Year = '$year' AND Semister = '$sem'";
        $result = mysqli_query($GLOBALS['con'], $sql);

        return $result;
    }

    if(isset($_POST['reg_subjects'])) {
        $temp_no = $_SESSION['GR_No'];
        $elective_1 = $_POST['elective_1'];
        $elective_2 = $_POST['elective_2'];
        $elective_3 = $_POST['elective_3'];

        if( !(($elective_1 == $elective_2) || ($elective_1 == $elective_3) || ($elective_2 == $elective_3))) {
            
            $sql = "UPDATE students SET Elective_1 = '$elective_1' WHERE GR_No = '$temp_no'";
            mysqli_query($GLOBALS['con'], $sql);

            $sql = "UPDATE students SET Elective_2 = '$elective_2' WHERE GR_No = '$temp_no'";
            mysqli_query($GLOBALS['con'], $sql);

            $sql = "UPDATE students SET Elective_3 = '$elective_3' WHERE GR_No = '$temp_no'";
            mysqli_query($GLOBALS['con'], $sql);

        }
        else { textNode('tomato', "Error: Two Electives cannot be Same."); }
    }

    function checkRegisteredSubj() {
        $grno = $_SESSION['GR_No'];

        $sql = "SELECT * FROM students WHERE GR_No = '$grno'";
        $result = mysqli_query($GLOBALS['con'], $sql);

        while($row = mysqli_fetch_assoc($result)) {
            if( empty($row['Elective_1']) || empty($row['Elective_2']) || empty($row['Elective_3'])) {
                return false;
            }
            else {
                return true;
            }
        }        
    }
    function getSClassroom() {
        $status = checkRegisteredSubj();
        if($status){
            $grno = $_SESSION['GR_No'];

            $sql = "SELECT * FROM students WHERE GR_No = '$grno'";
            $result = mysqli_query($GLOBALS['con'], $sql);
            
            while($row = mysqli_fetch_assoc($result)) {
                $Elective_1 = $row['Elective_1'];
                $Elective_2 = $row['Elective_2'];
                $Elective_3 = $row['Elective_3'];

                $sql = "SELECT * FROM classrooms WHERE classroom_id = '$Elective_1' OR classroom_id = '$Elective_2' OR classroom_id = '$Elective_3'";
                $newResult =  mysqli_query($GLOBALS['con'], $sql);

                return $newResult;
            }
        }
        else {
            return false;
        }

        
    }

    function getStExams() {
        $tablename = $_SESSION['classroom_id'];

        $query = "SELECT * FROM $tablename WHERE exam_status = 'Incomplete'";

        $result = mysqli_query($GLOBALS['con'], $query);

        return $result;
    }

    function getExamQuestions() {
        $tablenm = $_SESSION['test_id'];

        $query = "SELECT * FROM $tablenm";

        $result = mysqli_query($GLOBALS['con'], $query);

        return $result;
    }

    function verifyExamStatus() {
        $tableName = "result_" . $_SESSION['test_id'];
        $student_id = $_SESSION['GR_No'];

        $sql = "SELECT exam_status FROM $tableName WHERE gr_no = '$student_id'";

        $ans = mysqli_query($GLOBALS['con'], $sql);

        if(mysqli_num_rows($ans) > 0) {
            while($row = mysqli_fetch_assoc($ans)) {
                $status = $row['exam_status'];
            }

            if($status == 'Incomplete') {
                return true;
            }
            else {
                return false;
            }
        }
    }

    function updateExamStatus() {
        $tablenm = $_SESSION['classroom_id'];

        $testid = $_SESSION['test_id'];

        $sql = "UPDATE $tablenm SET exam_status = 'Complete' WHERE exam_id = '$testid'";
        
        mysqli_query($GLOBALS['con'], $sql);

        // header("Refresh:0");
    }

    function getCompletedExams() {
        $tablename = $_SESSION['classroom_id'];

        $query = "SELECT * FROM $tablename WHERE exam_status = 'Complete'";

        $result = mysqli_query($GLOBALS['con'], $query);

        return $result;

        header("Refresh:0");
    }

    function getAnswerKey() {
        $tablename = $_SESSION['answer_key_ex_id'];
        $query = "SELECT * FROM $tablename";
        
        $result = mysqli_query($GLOBALS['con'], $query);
    
        return $result;
        
    }

?>


<?php

    function viewFullQuestions() {
        $Q_no = $_SESSION['q_no'];
        $ques = $_SESSION['respective_question'];
        $a = $_SESSION['respective_option_a'];
        $b = $_SESSION['respective_option_b'];
        $c = $_SESSION['respective_option_c'];
        $d = $_SESSION['respective_option_d'];
        $ans = $_SESSION['respective_answer'];

        $space = ' ';
?>
    <div id="box2">
        <form  method="post" class="popup">
            <div class="">
                <div class='answer_key'>
                    <h3 style='text-align:center;'> <?php echo "Question ". $Q_no ?> </h3>
                    <ul>
                        <li><b><?php echo "Q- ". $ques?></b></li>
                        <li><?php echo "a) ".$a?></li>
                        <li><?php echo "b) ".$c?></li> 
                        <li><?php echo "c) ".$c?></li>
                        <li><?php echo "d) ".$d?></li>
                        <li><b><?php echo "Answer ".$ans?></b></li>

                    </ul>
                
                </div>
                
                                
            </div>
        </form>

        <form method="post" class='buttons'>
            <button name="back" class="new_classroom back_key">Back</button>  
        </form>
        
    </div>

<?php 
    }