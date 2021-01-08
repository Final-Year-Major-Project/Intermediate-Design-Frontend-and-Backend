<?php 
    require_once("db.php");

    $con = Createdb();

    if(!$con) {
        textNode('tomato' ,"Error: Cannot connect to the Database!");
    }

    // Create Button click for register student button
    if(isset($_POST['s_register'])) {
        $Grno = addStudent();
        $dpquery = "SELECT Department FROM students WHERE GR_No  ='$Grno'";
        $dpt = mysqli_query($GLOBALS['con'], $dpquery);

        if(mysqli_num_rows($dpt) > 0) {
            while($row = mysqli_fetch_assoc($dpt)) {
                $branch = $row['Department'];
            }

            if($branch) {
                addBranchId();
            }
        }
        
    }

    function getBranches() {
        $getbranch = "SELECT branch_Name FROM branches";

        $success = mysqli_query($GLOBALS['con'], $getbranch);

        if(mysqli_num_rows($success) > 0) {
            return $success;
        }
    }
    
    function addStudent() {
        $Grno = textboxValue("s_GR_No");
        $firstName = textboxValue("s_first_Name");
        $middleName = textboxValue("s_middle_Name");
        $lastName = textboxValue("s_last_Name");
        $Email = textboxValue("s_Email");
        $Department = $_POST['s_Department'];
        $pswd = textboxValue('s_password');
        $c_pswd = textboxValue('s_match_password');

        if($Grno &&$firstName && $middleName && $lastName && $Email && $Department && $pswd) {

            if(($pswd == $c_pswd)) {
                
                $sql = "INSERT INTO students (GR_No, first_Name, middle_Name, last_Name, Email, Department, Pswd) VALUES ('$Grno', '$firstName', '$middleName', '$lastName', '$Email', '$Department', '$pswd')";
            
                if(mysqli_query($GLOBALS['con'], $sql)) {
                    textNode('lightgreen' ,"Record Successfully Inserted..!");
                    return $Grno;
                }
                else {
                    textNode('tomato' ,"Error: Please provide the correct data!");
                    return false;
                }
            }
            else{
                textNode('tomato' ,"Error: Password did NOT match!");
                return false;
            }
        }
        else {
            textNode('tomato' ,"Please provide the data in Input fields..!");
            return false;
        }
    }
    // add branch id
    function addBranchId() {
        $Department = $GLOBALS['branch'];
        $grno = $GLOBALS['Grno'];
        $b_id = "SELECT branch_Id FROM branches WHERE branch_Name = '$Department'";

        $success = mysqli_query($GLOBALS['con'], $b_id);

        if(mysqli_num_rows($success) > 0) {
            while($row = mysqli_fetch_assoc($success)) {
                $br_id = $row['branch_Id'];
            } 
        }
        $sql = "UPDATE students SET branch_Id = '$br_id' WHERE GR_No = '$grno'";
        mysqli_query($GLOBALS['con'], $sql);
    }

    //  To escape SQL Injection
    function textboxValue($value) {
        $textbox = mysqli_real_escape_string($GLOBALS['con'], trim($_POST[$value]));
       if(empty($textbox)) {
           return false;
       }else {
           return $textbox;
       }
    }


    function textNode($color, $msg) {
        $element = "<h4 style='background-color: $color;padding: 1em;'>$msg</h4>";
        echo $element;
    }

?>