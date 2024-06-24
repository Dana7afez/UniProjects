<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "lama";

// Create connection
$mysql = new mysqli($servername, $username, $password, $database);

// Check connection
if ($mysql->connect_error) {
    die("Connection failed: " . $mysql->connect_error);
}


if(isset($_POST['submit'])){

 $uemail= $_POST['email'];
 $upassword= $_POST['password'];

 $query = "SELECT * FROM learner WHERE Email='$uemail' AND password ='$upassword'";
 $Found = mysqli_query($mysql,$query);

  if($Found){

    if(mysqli_num_rows($Found) > 0){

       while($row = mysqli_fetch_assoc($Found)){
       
        if($upassword==$row['password']){
            $_SESSION['fname'] = $row['fname'];
            $_SESSION['lname']=$row['lname'];
            $_SESSION['email']=$row['email'];
            $_SESSION['city']=$row['city'];
            $_SESSION['password']=$row['password'];
            $_SESSION['location']=$row['location'];
            $_SESSION['photo']=$row['photo'];

            header('Location:learnerHome.php');
        
       }

    }

  }

}
echo '<script>alert("invalid email or password");window.location.href="loginLearner.php";</script>';

}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            Login
        </title>
        <link rel = "stylesheet" href = "styles.css">
        <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    </head>
    <body>
        <div class="wrapper">
            <header>
                <nav>
                    <a href ="index.php"><img src="images/webLogo1.png" alt="logo"></a>
                    <div class ="nav-links">
                        <ul>
                            <li><a href = "index.php">Home</a></li>
                            <li><a href = "about.php">About</a></li>
                            <li><a href = "contact.php">Contact us</a></li>
                        </ul>
                    </div>
                </nav>
                <h2 class="header1">Lanturn</h2>
            </header>
            <section>
                <div class="wrapper-login"> 
                    <form action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                        <h1 class="header2">Login</h1>
                        <div class="input-box-login">
                            <label> Email</label>
                            <input type="email" name="email" placeholder="email" required>
                        </div>
            
                        <div class="input-box-login">
                            <label> password </label>
                            <input type="password" name="password" placeholder="password" required>
                        </div>
            
                        <div class="forgot">
                            <a href="forgotpass.php" > forgot password?</a> 
                        </div>
                        <button type="submit" class="submit-continer" name="submit" >Login</button>
                        <div class="dontHaveAccount">
                            <a href="register.php">Don't have an account? Register now
                            </a>
                        </div>
                    </form>
                </div>
            </section>
            <footer>
                <a href = "contact.php">Contact us</a>
                <p class="copyright">Created by KSU Students!<br>&copy; 2024 Lanturn</p>
            </footer>
        </div>
    </body>
</html>