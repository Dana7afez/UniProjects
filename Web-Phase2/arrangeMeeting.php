<?php
session_start();
if(isset($_POST['submit'])){



    $name = $_POST['name'];
    $mailFrom = $_POST['email'];
    $details = $_POST['message'];
    $title = "Meeting Request";

    $mailTo = $_GET['tutorEmail'];
    $headers = "From: ".$mailFrom;
    $txt = "You have received an email from ".$name.".\n\n".$details;


    mail($mailTo, $title,$txt,$headers);
    header("Location: arrangeMeeting.php?mailsend");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Rate tutor
    </title>
    <link rel="stylesheet" href="styles.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    

</head>

<body>
    <div class="wrapper">
        <header>
            <nav>
                <a href="learnerHome.php"><img src="images/webLogo1.png" alt="logo"></a>
                <div class="nav-links">
                    <ul>
                        <li><a href="learnerHome.php">Home</a></li>
                        <li><a href="learnerReq.php">Requests</a></li>
                        <li><a href="learnerCurrentSessions.php">Sessions</a></li>
                        <li><a href="learnerTutors.php">Tutors</a></li>
                    </ul>
                </div>
                <div class="user-profile">
                    <div class="menutoggle">
                        <img class="img2" src="../Web-Phase2/learnerImages/<?php echo $_SESSION['photo']; ?>" alt="User Profile Picture">
                        <div class="menu">
                            <ul class="list">
                                <li><a href="learnerPM.php">manage profile</a></li>
                                <li class="hehe"><a href="logout.php">Log out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

            </nav>
            <h1 class="header1">Lanturn</h1>
        </header>
        <section>
                        <div class="wrapper-rate">
                            <h2>Arrange Meeting </h2>
                        
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        
                                <div class="input-box-rate">
                                    <label>Name</label>
                                    <input type="text" name="name" placeholder=" name" >
                                </div>
                        
                                <div class="input-box-rate">
                                    <label>Email</label>
                                    <input type="text" name="email" placeholder="email">
                                </div>
                        
                        
                                <div class="input-box-rate">
                                    <label> Enter meeting details (date-time-learning goals) </label>
                                    <br>
                                    <textarea rows="3" cols="70" name="message"></textarea>
                                </div>
                        
                        
                        
                                <button type="submit" class="submit-continer">Submit</button>
                        
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
