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
    if(isset($_POST['goto_home'])) {
        header("location: studentHome.php");
    }

    $profile_strength = checkData();
    $formstatus = formStatus();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400&display=swap" rel="stylesheet">
  <link href="../css_stylesheets/profile.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" /> 
  
  <title>Home</title>

  <style>
    .scale {
      
      <?php 
      
          if($profile_strength == '100') {
            echo "background-color: lightgreen;";
          }
      ?>
      border: 2px solid gray;
      border-radius: 25px;
    }
    .yellow { height: 100%; width: 66%; border-radius: 25px;
        <?php 
            // echo "padding: 5px;";
            if($profile_strength == '66') {
              echo "background-color: rgb(233, 221, 49);";
            }
        ?>
    }
    .red { height: 100%; width: 66%; border-radius: 25px;
        <?php 
            if($profile_strength == '33') {
              echo "background: linear-gradient(0deg,  rgb(218, 120, 103), tomato,  rgb(218, 120, 103));";
            }
        ?>
    }
    b {
      margin-top: 600px;
    }
  </style>
</head>
<body>

  <div class="head">
    <h1 class="headline">Online Exam System</h1>
    <div class="nav">
        <form method="post">
          <i id="home-icon" class="fa fa-home"></i>
          <input class="profile" name="goto_home" type="submit" value="Home" >
          <input class="logout" type="submit" name="s_logout" value="Log Out">
        </form>
    </div>
  </div>
  <div class="Profile_Strength">
    <h3 class="name">Profile strength:</h3>
    <div class="scale">
        <?php if($profile_strength == "100") {echo "<b>$profile_strength%</b>";}?>
        <div class="yellow">
        <?php if($profile_strength == "66") {echo "<b>$profile_strength%</b>";}?>
          <div class="red">
            <?php if($profile_strength == "33") {echo "<b>$profile_strength%</b>";}?>
          </div>
        </div>
    </div>

  </div>
    <form method="post">
    <div class="buttons">
      <?php echo"<button class='getdata' name='registeration_data'>View Registration Information</button>";?>
      <?php 
        if($formstatus == 'displayboth') {
          echo"<button class='getdata' name='personal_data_reg'>Compleate Personal Profile</button>";
          echo"<button class='getdata' name='Academic_data_reg'>Compleate Academic Profile</button>";
        }
        elseif($formstatus == 'displayPform') {
          echo"<button class='getdata' name='personal_data_reg'>Compleate Personal Profile</button>";
          echo"<button class='getdata' name='Academic_data'>View Academic Information</button>";
        }
        elseif($formstatus == 'displayEform') {
          echo"<button class='getdata' name='personal_data'>View Personal Information</button>";
          echo"<button class='getdata' name='Academic_data_reg'>Compleate Academic Profile</button>";
        }
        else {
          echo"<button class='getdata' name='personal_data'>View Personal Information</button>";
          echo"<button class='getdata' name='Academic_data'>View Academic Information</button>";
          if(!checkRegisteredSubj()) {
            echo"<button class='getdata' name='subject_registeration'>Subject registration</button>";
          }
          
        }
      ?>
      
    </div>
    </form>
    <?php 

      $GR_No =  $_SESSION['GR_No'];
      $First_Name = $_SESSION['First_Name'];
      $Middle_Name = $_SESSION['Middle_Name'];
      $Last_Name = $_SESSION['Last_Name'];
      $Email = $_SESSION['Email'];
      $Department = $_SESSION['Department'];
      $P_email = $_SESSION['Personal_Email'];
      $C_address = $_SESSION['C_address'];
      $P_address = $_SESSION['P_address'];
      $c_no = $_SESSION['contact_No'];
      $g_c_no = $_SESSION['guardians_contact_No'];
      $Year = $_SESSION['Year'];
      $semister = $_SESSION['Semister'];
      $division = $_SESSION['Divison'];
      $roll_no = $_SESSION['Roll_No'];

      if(isset($_POST['registeration_data'])) {
        
        
        

        echo "<div id='registeration_data' class='container'>
        <div class='top'></div>
        <img src='../css_stylesheets/images/profile.png' alt=''>
        <hr>
          <table>
            <tr>
                <td><b>GR No:</b></td>
                <td>$GR_No</td>
            </tr>
            <tr>
                <td><b>Name:</b></td>
                <td>$First_Name</td>
                <td>$Middle_Name</td>
                <td>$Last_Name</td>
            </tr>
            <tr>
              <td><b>Email:</b></td>
              <td colspan='2'>$Email</td>
            </tr>
            <tr>
              <td><b>Department:</b></td>
              <td colspan='2'>$Department</td>
            </tr>
          <table>
        <form action='' method='post'>
            <input class='edit' type='submit' value='Edit'>
        </form>
    </div>";
    }

    ?>
    
    <form method="post" autocompleate="off">
      <?php 
        
        if(isset($_POST['personal_data_reg'])) {
          echo "<div class='form'>
                  <label><b>Personal Email:</b></label> 
                  <input type='text' placeholder='Enter Personal Email Id' name='p_email' required> <br>

                  <label><b>Correspondencs Address:</b></label> 
                  <input type='text' placeholder='Enter Correspondencs Address' name='c_address' required> <br>

                  <label><b>Permanant Address:</b></label> 
                  <input type='text' placeholder='Enter Permanant Address' name='p_address' required> <br>

                  <label><b>Contact Number</b></label> 
                  <input type='text' placeholder='Enter Contact Number' name='c_number' required> <br>

                  <label><b>Parents contact Number</b></label>
                  <input type='text' placeholder='Enter Parents contact Number' name='g_c_number' required> <br>

                  <button class='confirm' name='p_confirm'>Confirm</button>
                </div>";
        }
        if(isset($_POST['Academic_data_reg'])) {
          echo "<div class='form'>
                  <label><b>Year:</b></label> &nbsp;&nbsp;&nbsp;
                  <select name='Year' required>
                    <option value=''>Choose your option</option>
                    <option value='FY'>FY</option>
                    <option value='SY'>SY</option>                   
                    <option value='TY'>TY</option>
                    <option value='FINAL'>FINAL</option>
                  </select>
                  <br>

                  <label><b>Semister:</b></label> &nbsp;&nbsp;&nbsp;
                  <select name='Semister' required>
                    <option value=''>Choose your option</option>
                    <option value='1'>SEM 1</option>
                    <option value='2'>SEM 2</option>
                  </select>
                  <br>

                  <label><b>Divison:</b></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <select name='Division' required>
                    <option value=''>Choose your option</option>
                    <option value='A'>A</option>
                    <option value='B'>B</option>
                  </select>
                  <br>

                  <label><b>Roll Number:</b></label>
                  <input type='text' placeholder='Enter Your Roll Number' name='rollno' required> <br>

                  <button class='confirm' name='ed_confirm'>Confirm</button>
                </div>";
        }
        if(isset($_POST['personal_data'])) {
          echo "<div id='registeration_data personal-data' class='container'>
                  <div class='top'></div>
                  <img src='../css_stylesheets/images/profile.png' alt=''>
                  <table style='margin-top: 0px;padding: 4px;'>
                    <tr>
                        <td><b>Name:</b></td>
                        <td>$First_Name</td>
                        <td>$Middle_Name</td>
                        <td>$Last_Name</td>
                    </tr>
                  </table>
                  <hr>
                  <table>              
                      <tr>
                          <td><b>Personal Email:</b></td>
                          <td colspan='2'>$P_email</td>
                      </tr>
                      <tr>
                          <td><b>Contact No:</b></td>
                          <td colspan='2'>$c_no</td>
                      </tr>
                      <tr>
                          <td><b>Parents Contact:</b></td>
                          <td colspan='2'>$g_c_no</td>
                      </tr>
                      <tr>
                          <td><b>Correspondence Address:</b></td>
                          <td colspan='3'>$C_address</td>
                      </tr>
                      <tr>
                          <td><b>Permanant Address:</b></td>
                          <td colspan='3'>$P_address</td>
                      </tr>
                      
                  </table>
                  <form action='' method='post'>
                      <input class='edit' type='submit' value='Edit'>
                  </form>
                </div>";
        }
        if(isset($_POST['Academic_data'])) {
          echo "<div id='registeration_data personal-data' class='container'>
                  <div class='top'></div>
                  <img src='../css_stylesheets/images/profile.png' alt=''>
                  <table style='margin-top: 0px;padding: 4px;'>
                    <tr>
                        <td><b>Name:</b></td>
                        <td>$First_Name</td>
                        <td>$Middle_Name</td>
                        <td>$Last_Name</td>
                    </tr>
                  </table>
                  <hr>
                  <table>
                      <tr>
                          <td><b>Year:</b></td>
                          <td colspan='2'>$Year</td>
                      </tr>            
                      <tr>
                          <td><b>Semister:</b></td>
                          <td colspan='2'>$semister</td>
                      </tr>
                      <tr>
                          <td><b>Division:</b></td>
                          <td colspan='2'>$division</td>
                      </tr>
                      <tr>
                          <td><b>Roll Number:</b></td>
                          <td colspan='2'>$roll_no</td>
                      </tr>                      
                  </table>
                  <form action='' method='post'>
                      <input class='edit' type='submit' value='Edit'>
                  </form>
                </div>";
        }
      ?>
    </form>
    
        <?php
            if(isset($_POST['subject_registeration'])) {
              
        ?>
            <form method='post'>
              <div class='subject-register'>
                <label><b>Elective 1:</b></label>&nbsp;&nbsp;&nbsp;
                <select  name='elective_1' type='text' Placeholder-'Choose Your Subjects' required>
                  <option  value=''>Choose Your Subjects</option>

                  <?php      
                    $result = getSubjects();                              
                    while($row = mysqli_fetch_assoc($result)) { 
                      $subject_Name = $row['subject_Name'];
                      $subject_id = $row['subject_id'];
                  ?>
                    <option value='<?php echo $subject_id;?>'><?php echo $row['subject_Name'];?></option>
                  <?php
                    }                            
                  ?>
                  
                </select> <br>

                <label><b>Elective 2:</b></label>&nbsp;&nbsp;&nbsp;
                <select name='elective_2' type='text' Placeholder-'xxxxxx' required>
                  <option value=''>Choose Your Subjects</option>

                  <?php  
                    $result = getSubjects();                                  
                    while($row = mysqli_fetch_assoc($result)) { 
                      $subject_Name = $row['subject_Name'];
                      $subject_id = $row['subject_id'];
                  ?>
                  <option value='<?php echo $subject_id;?>'><?php echo $row['subject_Name'];?></option>
                  <?php
                     }                            
                  ?>

                </select> <br>  

                <label><b>Elective 3:</b></label>&nbsp;&nbsp;&nbsp;
                <select name='elective_3' type='text' Placeholder-'xxxxxx' required>
                  <option value=''>Choose Your Subjects</option>

                  <?php    
                    $result = getSubjects();                                
                    while($row = mysqli_fetch_assoc($result)) { 
                      $subject_Name = $row['subject_Name'];
                      $subject_id = $row['subject_id'];
                  ?>
                  <option value='<?php echo $subject_id;?>'><?php echo $row['subject_Name'];?></option>
                  <?php
                    }                            
                  ?>

                </select> <br> 

                <button class='confirm' name='reg_subjects'>Confirm</button> <br>
              </div>
            </form>
                      
           <?php   
            }
        ?>
<script>
    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>