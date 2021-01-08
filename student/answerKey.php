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
    if(isset($_POST['back_to_classroom'])) {
        header("location:  studentClassroom.php");
    }
    $displayform2 = false;
    if(isset($_POST['edit_question'])) {
        // $displayform2 = true;
        echo "Hello ";
    }

    for($i = 1; $i <= 100; $i++) {
        if(isset($_POST[$i])) {
            $displayform2 = true;
        }
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
                        border: 4px solid rgb(32, 32, 209);
                        opacity: 1;
                        background-color: gainsboro;
                        position: absolute;
                        top: 80px;
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
                    <input class="profile" type="submit" name="back_to_classroom" value="Classroom" > 
                    <input name="T_logout" class="logout" type="submit" value="Log Out">
                </form>
            </div>
        </div>

        <div class='table'>
            <table class='table1'>
                <tr style='background-color: rgb(71, 71, 182);color: white; height:50px;'>
                    <td colspan='8'>
                        <b>
                            <?php echo "Answer Key - ".$_SESSION['answer_key_ex_name'];                            ?>
                        </b>
                    </td> 
                </tr>
                <tr style='background-color: rgb(169, 169, 255);color:  rgb(0, 0, 125);height:45px;'>
                    <td style='width: 70px;';>Q-No</td>
                    <td style='width: 280px;';>Question</td>
                    <td style='width: 120px;';>Option a</td>
                    <td>Option b</td>
                    <td>Option c</td>
                    <td>Option d</td>
                    <td>Answer</td>
                    <td style='width: 90px;';>Status</td>
                </tr>

                <?php
                    $result = getAnswerKey();
                    if(mysqli_num_rows($result) > 0) {
                      while($row = mysqli_fetch_assoc($result)) {
                            $srno = $row['Sr_No'];
                            $question =  $row['question'];
                            $option_a =  $row['option_1'];
                            $option_b =  $row['option_2'];
                            $option_c =  $row['option_3'];
                            $option_d =  $row['option_4'];
                            $answer =  $row['answer_option'];

                           if(isset($_POST[$srno])) {
                               $_SESSION['q_no']= $srno;
                               $_SESSION['respective_question'] = $question;
                               $_SESSION['respective_option_a'] = $option_a;
                               $_SESSION['respective_option_b'] = $option_b;
                               $_SESSION['respective_option_c'] = $option_c;
                               $_SESSION['respective_option_d'] = $option_d;
                               $_SESSION['respective_answer'] = $answer;

                               viewFullQuestions();
                           }
                ?>

                <tr style='background-color:  rgb(175, 175, 175);color: black;height:40px;'>
                    <td class='data'> <?php echo $srno ?> </td>
                    <td class='data' style='width: 200px;'> <?php echo $question ?> </td>
                    <td class='data'> <?php echo $option_a ?> </td>
                    <td class='data'> <?php echo $option_b ?> </td>
                    <td class='data'> <?php echo $option_c ?> </td>
                    <td class='data'> <?php echo $option_d ?> </td>
                    <td class='data'> <?php echo $answer ?> </td>
                    <td class='data'> 
                        <form method="post">
                            <button name='<?php echo $srno?>'class ="exview">View all</button>
                        </form>
                    </td>
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