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
                }/*
                if(isset($_SESSION['photo'])){
                    $learnerEmail = $row['LearnerEmail']; // Make sure 'LearnerEmail' is a column in your 'request' table
                    $sqlPhoto = "SELECT photo
                    FROM learner As L
                    WHERE '$learnerEmail' = L.email ";
                    $resultPhoto = $connection->query($sqlPhoto);*/
                    session_start();
         
                ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Home
    </title>
    <link rel="stylesheet" href="styles.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
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

        <div class="wrapper-ratings">
            <h2 id="shiny"> Welcome Back, Learner! </h2>
            <div class="fDiv">
                <div class="sDiv">
                    <div class="tDiv">
                        <h4 class="Reviewer">Continue your sessions!</h4>
                        <p> check out your upcoming sessions </p>
                        <a class="button1" href="learnerCurrentSessions.php">My Sessions</a>
                    </div>
                </div>

                <div class="sDiv">
                    <div class="tDiv">
                        <h4 class="Reviewer">Request to learn a new language!</h4>
                        <p> make new learning requests for more sessions! </p>
                        <a class="button1" href="learnerReq.php">My Requests</a>
                    </div>
                </div>

                <div class="sDiv">
                    <div class="tDiv">
                        <h4 class="Reviewer">Your current tutors!</h4>
                        <p> view your tutors info! </p>
                        <a class="button1" href="learnerTutors.php">My Tutors</a>
                    </div>
                </div>


            </div>
        </div>

        <footer>
            <a href="contact.php">Contact us</a>
            <p class="copyright">Created by KSU Students!<br>&copy; 2024 Lanturn</p>
        </footer>
    </div>
</body>

</html>