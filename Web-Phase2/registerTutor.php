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

$fname_err = $lname_err = $email_err = $city_err= $password_err = $age_err= $gender_err= $phone_err= $bio_err="" ;

$firname =$lasname =$email =$city =$password =$age=$gender=$phone=$bio="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname_err = $lname_err = $email_err = $city_err= $password_err = $age_err= $gender_err= $phone_err= $bio_err="" ;

    $firname = input_data($_POST["firstname"]);
    $lasname = input_data($_POST["lastname"]);
    $email = input_data($_POST["email"]);
    $city = input_data($_POST["city"]);
    $password = input_data($_POST["password"]);
    $age=input_data($_POST["age"]);
    $gender=input_data($_POST["gender"]);
    $phone=input_data($_POST["phonenumber"]);
    $bio=input_data($_POST["bio"]);


    $flag = true;

    if(empty($firname)){
        $fname_err="name is required" ;
        $flag=false; }
   else{
   if (!preg_match("/^[a-zA-Z]+$/",$firname )) {
        $fname_err ="name should contains only letters" ;
        $flag=false; } }


   if(empty($lasname)){
        $lname_err="name is required" ;
        $flag=false; }
        
   else{
  if (!preg_match("/^[a-zA-Z]+$/",$lasname )) {
        $lname_err ="name should contains only letters" ;
        $flag=false; } }

   if(empty($email)){
        $email_err="email is required" ;
        $flag=false; }
   else{
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $email_err="invalid email format" ;
        $flag=false; } }


   if(empty($city)){
        $city_err="city is required" ;
        $flag=false; }
   else {
   if (!preg_match("/^[a-zA-Z]+$/",$city )) {
        $city_err="city should contains only letters" ;
        $flag=false; } }

   if(empty($password)){
        $password_err="password is required" ;
        $flag=false; }
        
   else{
    if (strlen($password) < 8) {
        $password_err="should contains at least 8 characters" ;
        $flag=false; } }


   if(empty($age)){
         $age_err="age is required" ;
         $flag=false; }

   
   if(empty($gender)){
         $gender_err="gender is required" ;
         $flag=false; }
   else{
    if (!preg_match("/^[a-zA-Z]+$/",$gender )) {
         $gender_err ="gender should contains only letters" ;
         $flag=false; } }

   if(empty($phone)){
         $phone_err="phone is required" ;
         $flag=false; }
    else{
     if (!preg_match("/^05\d{8}$/", $phone)) {
          $phone_err = "number should start with 05";
          $flag = false;}}
        


   if(empty($bio)){
            $bio_err="bio is required" ;
            $flag=false; }
    else{
    if (!preg_match("/[a-zA-Z]/i", $bio)) {
            $bio_err = "enter a valid bio";
            $flag = false;}}
           
  if (get_learner_email($email) > 0) {
         $email_err = "this email is already taken,enter another one";
         $flag= false; }

  if (get_tutor_email($email) > 0) {
         $email_err = " this email is already taken,enter another one";
         $flag = false; } 
          
         

     if ($flag) {

        $file_name = $_FILES['image']['name'];
        $tempname = $_FILES['image']['tmp_name'];
        
        // Check if an image was uploaded
        if (!empty($file_name)) {
            // Move the uploaded image to the destination folder
            $folder = 'tutorImages/' . $file_name;
            
            if (move_uploaded_file($tempname, $folder)) {
                // Image uploaded successfully
                echo "Image uploaded successfully.";
            } else {
                // Failed to move the uploaded image
                echo "Failed to upload image.";
            }
        } else {
            // No image uploaded, set default image
            $file_name = 'usericon.png';
            $folder = 'tutorImages/' . $file_name;
            if (copy('images/' . $file_name, $folder)) {
                echo "Default image uploaded successfully.";
            } else {
                echo "Failed to upload default image.";
            }
        }
        
        if (tutor_signup($firname ,$lasname ,$email,$city ,$password ,$age,$gender,$phone,$bio,$file_name )) {
                
            $_POST["firstname"] =$_POST["lastname"]= $_POST["email"] = $_POST["city"] = $_POST["password"] = $_POST["age"]= $_POST["gender"] = $_POST["phonenumber"] = $_POST["bio"]= "";
            echo '<script>alert("Registration successful");window.location.href="loginTutor.php";</script>';

         }
         
         
         
            }



}




function input_data($data){
    //remove spaces slashes special symbols
    
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data; 
    
    }
    


  function tutor_signup($firname ,$lasname ,$email,$city ,$password ,$age,$gender,$phone,$bio,$file_name ){

    global $mysql;
    $query = "INSERT INTO tutor (fname, lname, email, age, gender, password, city, phone, bio, photo) VALUES ('$firname','$lasname','$email','$age','$gender','$password','$city','$phone','$bio','$file_name')";
    $result = mysqli_query($mysql, $query);
    return $result;
}
  
function get_learner_email($email)
{
    global $mysql;
    $query = "SELECT email FROM learner WHERE Email = '$email'";
    $result = mysqli_query($mysql, $query);
    return mysqli_num_rows($result);
}


function get_tutor_email($email)
{
    global $mysql;
    $query = "SELECT email FROM tutor WHERE Email = '$email'";
    $result = mysqli_query($mysql, $query);
    return mysqli_num_rows($result);
}





?>












<!DOCTYPE html>
<html>
    <head>
        <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
        <title>
            Register
        </title>
        <link rel = "stylesheet" href = "styles.css">
        <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    </head>
    <body>
        <div class="wrapper">
            <header>
                <nav>
                    <a href ="index.php"><img src="images/webLogo1.png"></a>
                    <div class ="nav-links">
                        <ul>
                            <li><a href = "index.php">Home</a></li>
                            <li><a href = "about.php">About</a></li>
                            <li><a href = "contact.php">Contact us</a></li>
                        </ul>
                    </div>
                </nav>
                <h1 class="header1">Join Lanturn</h1>
            </header>
            <section>
                <div class="wrapper-register">
                <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <h1>Registration</h1>
                        <h5>Tutor</h5>
                        <p style="font-size:18px"><span style="color:red"> * </span>required field</p>
                        <div class="input-box-register">
            
                            <div class="input-field-register">
                             <label> First name<span style="color:red;font-size: 11px;"> *<?php echo $fname_err; ?> </span></label>
                                <input type="text"name="firstname" placeholder="first name" value="<?php if (isset($_POST["firstname"])) echo $_POST["firstname"]; ?>" > 
                            </div>
                            
                            <div class="input-field-register">
                                <label> Last name<span style="color:red;font-size: 11px;"> *<?php echo $lname_err; ?> </span></label>
                                    <input type="text" name="lastname" placeholder="last name" value="<?php if (isset($_POST["lastname"])) echo $_POST["lastname"]; ?>" > 
                            </div>
                        </div>
                                
                        <div class="input-box-register">
                            <div class="input-field-register">
                                    <label> Age<span style="color:red;font-size: 11px;"> *<?php echo $age_err; ?> </span></label>
                                    <input type="text" name="age" placeholder="age" value="<?php if (isset($_POST["age"])) echo $_POST["age"]; ?>" > 
                            </div>
            
                            <div class="input-field-register">
                                    <label> Gender<span style="color:red;font-size: 11px;"> *<?php echo $gender_err; ?> </span></label>
                                    <input type="text" name="gender" placeholder="gender" value="<?php if (isset($_POST["gender"])) echo $_POST["gender"]; ?>" >
                            </div> 
            
                        </div>
            
            
            
            
                        <div class="input-box-register">
                            <div class="input-field-register">
                                    <label> Email<span style="color:red;font-size: 11px;"> *<?php echo $email_err; ?> </span></label>
                                    <input type="text" name="email" placeholder="email"  value="<?php if (isset($_POST["email"])) echo $_POST["email"]; ?>"> 
                            </div>
            
                            <div class="input-field-register">
                                    <label> Password<span style="color:red;font-size: 11px;"> *<?php echo $password_err; ?> </span></label>
                                    <input type="password" name="password" placeholder="password"  value="<?php if (isset($_POST["password"])) echo $_POST["password"]; ?>">
                            </div> 
                            
                        </div>
            
            
            
                        <div class="input-box-register">
            
                            <div class="input-field-register">
                                    <label> City<span style="color:red;font-size: 11px;"> *<?php echo $city_err; ?> </span></label>
                                    <input type="text" name="city" placeholder="city" value="<?php if (isset($_POST["city"])) echo $_POST["city"]; ?>" > 
                            </div>
            
                            <div class="input-field-register">
                                    <label> Phone number<span style="color:red;font-size: 11px;"> *<?php echo $phone_err; ?> </span></label>
                                    <input type="tel" name="phonenumber" placeholder="phone number"  value="<?php if (isset($_POST["phonenumber"])) echo $_POST["phonenumber"]; ?>"> 
                            </div>
                        </div>
            
            
                        
                        <div class="input-box-register"> 
                            <div class="input-field-register">
                            <label>Short bio including languages spoken and cultural knowledge<span style="color:red;font-size: 11px;"> *<?php echo $bio_err; ?> </span></label>
                            <textarea rows="3" cols="60" name="bio"  value="<?php if (isset($_POST["bio"])) echo $_POST["bio"]; ?>"> </textarea>
                            </div>
            
                        </div>
            
            
            
                        <div class="image-part">
            
                        <label> Photo (optional)</label>
                        <input type="file" name="image" accept="image" >
                        </div>
            
                        
                        <button type="submit" class="submit-continer"> Register</button>
                        <div class="haveAccount">
                            <a href="login.php">Have an account? Login</a>
                        </div>
                        
                    </form>
            
                </div>
            </section>
            <footer>
                <a href = "contact.php">Contact us</a>
                <p class="copyright">Created by KSU Students!<br>&copy 2024 Lanturn</p>
            </footer>
        </div>
    </body>
</html>
