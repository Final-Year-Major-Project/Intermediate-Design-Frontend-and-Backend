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
    if(isset($_POST['edit_exam_details'])) {
      $displayform = true;
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
  
    <div class='table'>
        <table class='table1'>
            <tr style='background-color: rgb(71, 71, 182);color: white; height:50px;'>
                <td colspan='4'><b><?php echo "Result - ".$_SESSION['exam_name_results'];?></b></td>
            </tr>
            <tr style='background-color: rgb(169, 169, 255);color:  rgb(0, 0, 125); height:45px;'>
                <td>GR No</td>
                <td>Name</td>
                <td>Status</td>
                <td>Marks</td>
            </tr>

            <?php
                $result = getClassroomResult();
                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $grno = $row['gr_no'];
                        $student_result =  $row['result'];
                        $exam_status =  $row['exam_status'];

                        $sql = "SELECT first_Name, last_Name FROM students WHERE GR_No = '$grno'";
                        $ans = mysqli_query($GLOBALS['con'], $sql);
                        if(mysqli_num_rows($ans) > 0) {
                            while($row = mysqli_fetch_assoc($ans)) {
                                $first_Name = $row['first_Name'];
                                $last_Name = $row['last_Name'];
                            }
                        }
            ?>
                        
            <tr class='data' style='background-color:  rgb(175, 175, 175);color: black;height:40px;'>
                <td><?php echo $grno ?></td>
                <td><?php echo $first_Name."  ".$last_Name ?></td>
                <td>
                    <?php 
                        if($exam_status == 'Complete') {
                            echo "Present";
                        }
                        else {
                            echo "Absent";
                        }
                    ?>
                </td>
                <td><?php echo $student_result ?></td>
            </tr>

            <?php
                    }           
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
