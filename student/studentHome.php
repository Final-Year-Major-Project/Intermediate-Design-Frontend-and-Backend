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
    if(isset($_POST['s_logout'])) {
        session_reset();

        session_destroy();
        header("location: ../index.php");
        exit;
    }
    if(isset($_POST['view_Sprofile'])) {
      header("location: studentProfile.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css_stylesheets/userHome.css?v=<?php echo time(); ?>" type="text/css" />
  <title>Home</title>
</head>
<body>
  
  <div class="head">
    <h1 class="headline">Online Exam System</h1>
    <div class="nav">
        <form action="" method="post">
          <a href=""><i id="home-icon" class="fa fa-home"></i></a>
          <input class="profile" type="submit" name="view_Sprofile" value="Profile" >
          <input class="logout" type="submit" name="s_logout" value="Log Out">
        </form>
    </div>
  </div>
        
  <div class="user">
    <h1>Welcome <?php echo $_SESSION['First_Name'];?></h1>
  </div>

  <div class="row" >
  <?php

      $result = getSClassroom();
      if($result) {
        if(mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) { 
            $classroom_id = $row['classroom_id'];
            $classroom_name = $row['classroom_name'];
            $class_Description = $row['class_Description'];
            $Year = $row['Year'];
            $semister = $row['semister'];
            $prof = $row['professor_Name'];

            if(isset($_POST[$classroom_id])) {
              $_SESSION['classroom_id'] = $classroom_id;
              $_SESSION['classroom_name'] = $classroom_name;
              $_SESSION['class_Description'] = $class_Description;
            
              header("location: studentClassroom.php");
            }
    ?>
      
          <div class='section'>    
            <div class='column'>
              <p class='info'> <?php echo $row['Year'];?> <?php echo "SEM ", $row['semister'];?></p>
              <h2 class='col-title'><?php echo $row['classroom_name'];?></h2>
              <p class='code'><?php echo $row['classroom_id'];?></p>
              <p class='prof'><?php echo "Prof ", $row['professor_Name'];?></p>
              <form method='post'>
                <button name='<?php echo $classroom_id;?>' class='view_classroom'> View </button>
              </form>
            </div>    
          </div> 
      <?php
          }
      }
    }
    else {
      echo "<h1 style='text-align:center;margin-top:50px;'><b>You have NOT Enrolled any Classroom Yet</b></h1>";
    }
    ?>
  </div>

<script>
    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>
