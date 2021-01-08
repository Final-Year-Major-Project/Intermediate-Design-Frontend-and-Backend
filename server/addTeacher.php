<?php 
    require_once('db.php');

    $con = Createdb();

    if(!$con) {
        echo "Cannot connect to the Database";
    }

    if(isset($_POST['t_register'])) {
        $refNo = addTeacher();
        $dpquery = "SELECT Department FROM teachers WHERE Ref_ID  = '$refNo'";
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

    function addTeacher() {

        $Refno = textboxValue("t_Ref_Id");
        $firstName = textboxValue("t_first_Name");
        $middleName = textboxValue("t_middle_Name");
        $lastName = textboxValue("t_last_Name");
        $Email = textboxValue("t_Email");
        $Department = $_POST['t_Department']; 
        $pswd = textboxValue('t_password');
        $c_pswd = textboxValue('t_match_password');

        if($Refno && $firstName && $middleName && $lastName && $Email && $Department && $pswd) {

            if(($pswd == $c_pswd)) {

                $sql = "INSERT INTO teachers (Ref_ID, first_Name, middle_Name, last_Name, Email, Department, Pswd, verified) VALUES ('$Refno', '$firstName', '$middleName', '$lastName', '$Email', '$Department', '$pswd', false)";

                if(mysqli_query($GLOBALS['con'], $sql)) {
                    textNode('lightgreen' ,"Record Successfully Inserted..!");
                    return $Refno;
                    
                }
                else {
                    textNode('tomato' ,"Error: Please provide the correct data!");
                }
            }
            else {
                textNode('tomato' ,"Error: Password did NOT match!");
            }
        }
        else {
            textNode('tomato' ,"Please provide the data in Input fields..!");
        }
    }

    function addBranchId() {
        $Department = $GLOBALS['branch'];
        $refId = $GLOBALS['refNo'];
        $b_id = "SELECT branch_Id FROM branches WHERE branch_Name = '$Department'";

        $success = mysqli_query($GLOBALS['con'], $b_id);

        if(mysqli_num_rows($success) > 0) {
            while($row = mysqli_fetch_assoc($success)) {
                $br_id = $row['branch_Id'];
            } 
        }
        $sql = "UPDATE teachers SET branch_Id = '$br_id' WHERE Ref_ID = '$refId'";
        mysqli_query($GLOBALS['con'], $sql);
    }


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