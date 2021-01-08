<?php
  require_once('teacherOperation.php');

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

    if(isset($_POST['new_class'])) {
        $displayform = true;
  
    }
    if(isset($_POST['back'])) {
        $displayform = false;
    }
    
    
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css_stylesheets/userHome.css?v=<?php echo time(); ?>" type="text/css">
  <title>Home</title>

  <style>
        <?php
            if($displayform) {
                echo "
                #dark::before {
                    
                    content: '';
                    opacity: 0.5;
                    background: black;
                    position: absolute;
                    height: 104%;
                    width: 100%;
                }
                #box {
                    padding-left: auto;
                    padding-right: auto;
                    opacity: 1;
                    background-color: gainsboro;
                    position: absolute;
                    top: 80px;
                    bottom: 100px;
                    left: 25%;
                    right: 25%;
                    height: 500px;
                    width: 50%;
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
            elseif(!$displayform) {
                echo "
                    #box {
                        display: none;
                    }
                    .popup {
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
        <a href=""><i id="home-icon" class="fa fa-home"></i></a>
        <input class="profile" type="submit" name="view_Tprofile" value="Profile" > 
        <input name="T_logout" class="logout" type="submit" value="Log Out">
      </form>
    </div>
  </div>
        
  <div class="user">
    <h1>Welcome Prof <?php echo $_SESSION['First_Name'];?></h1>
  </div>
  <div class='buttons'>
    <form  method='post'>
      <button name='new_class' class="new_classroom">
        Create A new Classroom
      </button>
    </form>
  </div>
  
  <div class="row">
    <?php
      
      $result = getClassroom();
      if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) { 
          $classroom_id = $row['classroom_id'];
          $classroom_name = $row['classroom_name'];
          $class_Description = $row['class_Description'];
          $Year = $row['Year'];
          $semister = $row['semister'];

          if(isset($_POST[$classroom_id])) {
            $_SESSION['classroom_id'] = $classroom_id;
            $_SESSION['classroom_name'] = $classroom_name;
            $_SESSION['class_Description'] = $class_Description;
           
            header("location: teacherClassroom.php");

            // echo $classroom_id;
          }
      ?>
    
        <div class='section'>    
          <div class='column'>
            <p class='info'> <?php echo $row['Year'];?> <?php echo "SEM ", $row['semister'];?></p>
            <h2 class='col-title'><?php echo $row['classroom_name'];?></h2>
            <p class='code'><?php echo $row['classroom_id'];?></p>
            <form method='post'>
              <button name='<?php echo $classroom_id;?>' class='view_classroom'> View </button>
            </form>
          </div>    
        </div>
    <?php
        }
    }
    else {
      echo "<h1 style='text-align:center;margin-top:50px;'><b>You have not created any Classroom yet</b></h1>";
    }
    ?>
    

  </div>
</div>


    
    <div id='box'>
      <form class='popup'  method='post'>
        <div class="inputs">

          <label><b>Classroom Name:</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <select name='classroom_name'  type='classroom_name' required> <br>
            <option  value=''>Choose Classroom Subject</option>

            <?php
                    $result = getSubject();
                    if($result) {
                    while($row = mysqli_fetch_assoc($result)) { 
                      $subject_Name = $row['subject_Name'];
                ?>
                <option style='color: black;' value='<?php echo $subject_Name;?>'><?php echo $row['subject_Name'];?></option>
            <?php
                }
            }
            ?>
          </select> <br>

          <label><b>Professor's Name:</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input name='Prof_name' type='text' placeholder=' Enter Your Name. Eg: S A Kulkarni' required> <br>

          <label><b>Classroom Description:</b></label>&nbsp;&nbsp;
          <input Value='None' name='classroom_description' type='text' placeholder=' Enter Classroom Description' required> <br>

          <button name='create_classroom' class='new_classroom submit'>Create</button>
        </div>
        </form>

        <form class='buttons' method="post">
          <button name='back' class='new_classroom back'>Cancel</button>
        </form>

    </div>


<script>
    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>
