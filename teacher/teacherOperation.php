<?php 
    require_once('../server/db.php');

    session_start();

    $con = Createdb();

    if(!$con) {
        echo "Cannot connect to the Database";
    }
    if(isset($_POST['T_login'])) {
        teacherVerification();
    }

    if(isset($_POST['create_classroom'])) {
        $Prof_Id = $_SESSION['Ref_ID'];
        $branchId = $_SESSION['Branch_Id'];
        $Prof_name = $_POST['Prof_name'];
        $classroom_name = $_POST['classroom_name'];
        $classroom_description = $_POST['classroom_description'];

        $query = "SELECT subject_id, Year, Semister FROM subjects WHERE branch_Id ='$branchId' AND subject_Name='$classroom_name'";
        $result = mysqli_query($GLOBALS['con'], $query);

        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $subject_id = $row['subject_id'];
                $Year = $row['Year'];
                $Semister = $row['Semister'];
                
                $classquery = "INSERT INTO classrooms (classroom_id, classroom_name, Year, branch_Id, semister, professor_Name, Prof_Ref_Id, class_Description) VALUES ('$subject_id', '$classroom_name', '$Year', '$branchId', '$Semister', '$Prof_name', '$Prof_Id', '$classroom_description')";
                $createClass = mysqli_query($GLOBALS['con'], $classquery);

                $classTablequery = "CREATE TABLE IF NOT EXISTS $subject_id (
                                Sr_No INT AUTO_INCREMENT UNIQUE,
                                exam_id VARCHAR(20) PRIMARY KEY,
                                exam_name VARCHAR(30) UNIQUE,
                                exam_date DATE,
                                start_time TIME,
                                end_time TIME,
                                no_of_questions INT(3),
                                marks_per_question INT(2),
                                exam_status VARCHAR(15),
                                highest_marks INT(3),
                                class_average INT(3)
                            )";
                $createClassTable = mysqli_query($GLOBALS['con'], $classTablequery);
            }
        }        
    }


    function teacherVerification() {
        $teacher_Refno = $_POST['T_Ref_No_check'];
        $teacher_Email = $_POST['T_Email_check'];
        $teacher_pswd = $_POST['T_pswd_check'];

        if( $teacher_Refno && $teacher_Email && $teacher_pswd) {

            $verify = "SELECT * FROM teachers WHERE Ref_ID = '$teacher_Refno'";

            $success = mysqli_query($GLOBALS['con'], $verify);

            if(mysqli_num_rows($success) > 0) {
                while($row = mysqli_fetch_assoc($success)) {
                    if($row['Email'] == $teacher_Email &&  $row['Pswd'] == $teacher_pswd) {
                        $_SESSION['isteacherloggedin'] = true;
                        $_SESSION['Ref_ID'] = $row['Ref_ID'];
                        $_SESSION['First_Name'] = $row['first_Name'];
                        $_SESSION['Middle_Name'] = $row['middle_Name'];
                        $_SESSION['Last_Name'] = $row['last_Name'];
                        $_SESSION['Email'] = $row['Email'];
                        $_SESSION['Department'] = $row['Department'];
                        $_SESSION['Branch_Id'] = $row['branch_Id'];
                        header('location: teacherHome.php');
                        
                    }
                    else {
                        $_SESSION['isteacherloggedin'] = false;
                        textNode('tomato', "Error: Invalid Credentials!");
                    }
                }
            }
            else {
                $_SESSION['isteacherloggedin'] = false;
                textNode('tomato', "Error: No such user Exists!");
            }
        }
    }
    function getSubject() {
        $branch_id = $_SESSION['Branch_Id'];
        $query = "SELECT subject_Name FROM subjects 
                  WHERE branch_Id = '$branch_id' AND subject_id NOT IN (
                      SELECT classroom_id FROM classrooms WHERE branch_Id = '$branch_id'
                  )
        
                 ";
        $getSubjects = mysqli_query($GLOBALS['con'], $query);
    
        return $getSubjects;
    }


    function getClassroom() {
        $refId = $_SESSION['Ref_ID'];
        $query = "SELECT * FROM classrooms WHERE Prof_Ref_Id = '$refId' ";
        $result = mysqli_query($GLOBALS['con'], $query);

        return $result;
    }

    function textNode($color, $msg) {
        $element = "<h4 style='background-color: $color;padding: 1em;'>$msg</h4>";
        echo $element;
    }

?>