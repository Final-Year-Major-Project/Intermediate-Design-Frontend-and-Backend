<?php 
    require_once('./server/addStudent.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css_stylesheets/login.css?v=<?php echo time(); ?>" type="text/css" />
    <title>App</title>
</head>
<body>
    <div class="head">
        <h1 class="headline">Online Exam System</h1>
        <div class="nav">
            <a href="index.php"><i id="home-icon" class="fa fa-home"></i></a>
            <a class="home" href="index.php">Home</a>
            <a href="./student/studentlogin.php"><input class="signup" type="button" value="Log In" name="login"></a>
        </div>
    </div>
    <div class="user">
        <h1>Student Registration</h1>
    </div>

    <form action="" method="POST" autocomplete="off">
        <div class="container">
        
        <marquee behavior="scroll" direction="left" scrollamount="7" bgcolor="#0000ff" onmouseover="this.stop();" onmouseout="this.start();">
            <div style="color:white;font-weight: 750;">Use Your Official College Email Id for Registration</div>
        </marquee> <br>

            <label><b>GR Number</b></label> &nbsp;&nbsp;&nbsp;
            <input type="text" placeholder="Enter GR Number" name="s_GR_No" required> <br>

            <label><b>First Name</b></label> &nbsp;&nbsp;&nbsp;
            <input type="text" placeholder="Enter First Name" name="s_first_Name" required> <br>
            
            <label><b>Middle Name</b></label> &nbsp;&nbsp;&nbsp;
            <input type="text" placeholder="Enter Middle Name" name="s_middle_Name" required> <br>
            
            <label><b>Last Name</b></label> &nbsp;&nbsp;&nbsp;
            <input type="text" placeholder="Enter Last Name" name="s_last_Name" required> <br>
            
            <label><b>Email</b></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="text" placeholder="Enter Email" name="s_Email" required> <br>
            
            <label><b>Department</b></label> &nbsp;&nbsp;&nbsp;
            <select name="s_Department" required>
                <option value="">Choose your option</option>

                <?php
                    $result = getBranches();
                    if($result) {
                    while($row = mysqli_fetch_assoc($result)) { 
                        $branch_name = $row['branch_Name'];
                ?>
                <option value='<?php echo $branch_name;?>'><?php echo $row['branch_Name'];?></option>
            <?php
                }
            }
            ?>
            </select> <br>

            <label><b>Password</b></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="s_password" type="password" pattern=".{8,}" required title="Minimum 8 Characters required" placeholder="Enter Password" required>
            <br>

            <label><b>Check Password</b></label> &nbsp;&nbsp;
            <input name="s_match_password" type="password" pattern=".{8,}" required title="Minimum 8 Characters required" placeholder="Enter Password" required>
            <br>

            <button name="s_register">Register</button>

        </div>
    </form>


<script>
    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>