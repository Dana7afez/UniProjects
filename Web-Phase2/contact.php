<?php


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

$fname_err = $email_err =  $title_err = $bio_err="" ;

$firname =$email =$title =$bio="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname_err = $email_err =  $title_err = $bio_err="" ;


    $firname = input_data($_POST["name"]);
    $email = input_data($_POST["email"]);
    $title = input_data($_POST["title"]);
    $bio=input_data($_POST["message"]);



    $flag = true;

    if(empty($firname)){
        $fname_err="name is required" ;
        $flag=false; }
   else{
   if (!preg_match("/^[a-zA-Z]+$/",$firname )) {
        $fname_err ="name should contains only letters" ;
        $flag=false; } }


     if(empty($email)){
            $email_err="email is required" ;
            $flag=false; }
    else{
     if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
            $email_err="invalid email format" ;
            $flag=false; } }   


    if(empty($title)){
            $title_err="title is required" ;
            $flag=false; }

    if(empty($bio)){
                $bio_err="bio is required" ;
                $flag=false; }
    else{
    if (!preg_match("/[a-zA-Z]/i", $bio)) {
                $bio_err = "enter a valid bio";
                $flag = false;}}



     if ($flag && contact($firname ,$email,$title ,$bio)) {
                    
          $_POST["name"] = $_POST["email"] = $_POST["message"] =$_POST["title"]= "";
          echo '<script>alert("Your message was successfly sent");window.location.href="contact.php";</script>'; }
                    







}

function input_data($data){
    //remove spaces slashes special symbols
    
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data; 
    
    }

    function contact($firname ,$email,$title ,$bio )
    {
        global $mysql;
        $query = "INSERT INTO contact VALUES ('$firname','$email','$title','$bio')";
        $result = mysqli_query($mysql, $query);
        return $result;
    }
    






?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            Contact Us
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
                        <div class="sign-links">
                            <button class="login" onclick="window.location.href= 'login.php';">Login</button>
                            <button class="register" onclick="window.location.href='register.php';">Register</button>
                        </div>
                        </nav>
                        <h1 class="header1">Lanturn</h1>
                        </header>
                        <section>
                        <div class="wrapper-rate">
                            <h2> Contact us</h2>
                        
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        
                                <div class="input-box-rate">
                                    <label>Name<span style="color:red;font-size: 11px;"> *<?php echo $fname_err; ?> </span></label>
                                    <input type="text" name="name" placeholder=" name" >
                                </div>
                        
                                <div class="input-box-rate">
                                    <label>Email<span style="color:red;font-size: 11px;"> *<?php echo $email_err; ?> </span></label>
                                    <input type="text" name="email" placeholder="email">
                                </div>
                        
                                <div class="input-box-rate">
                                    <label>Title<span style="color:red;font-size: 11px;"> *<?php echo $title_err; ?> </span></label>
                                    <input type="text" name="title" placeholder=" title">
                                </div>
                        
                        
                        
                                <div class="input-box-rate">
                                    <label> what can we help you with<span style="color:red;font-size: 11px;"> *<?php echo $bio_err; ?> </span></label>
                                    <br>
                                    <textarea rows="3" cols="70" name="message"></textarea>
                                </div>
                        
                        
                        
                                <button type="submit" class="submit-continer">submit </button>
                        
                            </form>
                        </div>
                    </section>
                        <footer>
                            <a href="contact.php">Contact us</a>
                            <p class="copyright">Created by KSU Students!<br>&copy; 2024 Lanturn</p>
                        </footer>
        </div>
    </body>
</html>