<?php
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
                <a href="tutorHome.php"><img src="images/webLogo1.png" alt="logo"></a>
                <div class="nav-links">
                    <ul>
                        <li><a href="tutorHome.php">Home</a></li>
                        <li><a href="tutorReq.php">Requests</a></li>
                        <li><a href="tutorSessions.php">Sessions</a></li>
                        <li><a href="tutorRatings.php">Ratings/Reviews</a></li>
                    </ul>
                </div>
                <div class="user-profile">
                    <div class="menutoggle">
                        <img class="img2" src="../Web-Phase2/tutorImages/<?php echo $_SESSION['photo']; ?>" alt="User Profile Picture">
                        <div class="menu">
                            <ul class="list">
                                <li><a href="TutorPM.php">manage profile</a></li>
                                <li class="hehe"><a href="logout.php">Log out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
            <h1 class="header1">Lanturn</h1>
        </header>
            <div class="wrapper-ratings">
                <h2 id="shiny"> Welcome Back, Tutor! </h2>
                <div class="fDiv">
                    <div class="sDiv">
                        <div class="tDiv">
                            <h4 class="Reviewer">Continue your sessions</h4>
                            <p> check out your upcoming sessions </p>
                            <a class="button1" href="tutorSessions.php">My Sessions</a>
                        </div>

                    </div>

                    <div class="sDiv">
                        <div class="tDiv">
                            <h4 class="Reviewer">Check your requests!!</h4>
                            <p> Note: if there is less than an hour to a pending request, it will be rejeceted automatically </p>
                            <a class="button1" href="tutorReq.php">My Requests</a>
                        </div>
                    </div>

                    <div class="sDiv">
                        <div class="tDiv">
                            <h4 class="Reviewer">Your Ratings!</h4>
                            <p> for you to improve! </p>
                            <a class="button1" href="tutorRatings.php">My Ratings</a>
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