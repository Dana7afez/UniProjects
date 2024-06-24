<?php 
session_start();
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutors</title>
    <link rel="stylesheet" href="styles.css">
    
</head>

<body>
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
    <h2 class="header4">Tutors</h2>

    <section>
    <div class="profile-cards-container"> 
    <?php
    $servername= "localhost";
    $username= "root" ;
    $password= "";
    $dbname= "lama" ;
    $connection= mysqli_connect($servername,$username,$password,$dbname);
    $database= mysqli_select_db($connection, $dbname);
    if (!$connection)
        die("Connection failed: " . mysqli_connect_error());

    $sql = "SELECT tutor.fname, tutor.lname, tutor.photo,tutor.email, tutor.bio, AVG(rate.star) AS avg_star 
            FROM tutor
            LEFT JOIN rate ON tutor.email = rate.TutorEmail
            GROUP BY tutor.fname, tutor.lname, tutor.photo, tutor.bio";

    $TutorFound = mysqli_query($connection,$sql);
    if($TutorFound && mysqli_num_rows($TutorFound) > 0) {
        while ($row = mysqli_fetch_assoc($TutorFound)) {
    ?>
        <div class="profile-card">
            <img src="../Web-Phase2/tutorImages/<?php echo $row['photo'];?>" alt="tutor photo" class="avatar">
            <h2 class="Tutorname"><?php echo $row['fname']." ".$row['lname']; ?></h2>
            <div class="rating">
                <?php
                $avg_rating = round($row['avg_star']);
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $avg_rating) {
                        echo '<span class="star">&#9733;</span>';
                    } else {
                        echo '<span class="star">&#9734;</span>';
                    }
                }
                ?>
            </div>
            <p class="details"><?php echo $row['bio']; ?> </p>
            <form method="POST" action="tutorDetails.php">
                <input type="hidden" name="tutorName" value="<?php echo $row['fname'] . ' ' . $row['lname']; ?>">
                <button type="submit" class="details-linkk">View Details</button>
            </form>
            <form method="GET" action="arrangeMeeting.php">
                <input type="hidden" name="tutorEmail" value="<?php echo $row['email']; ?>">
                <button type="submit" class="details-linkk">Arrange Meeting</button>
            </form>
            <form method="GET" action="requestSessionForm.php">
                <input type="hidden" name="firstName" value="<?php echo $row['fname'];?>">
                <input type="hidden" name="lastName" value="<?php echo $row['lname'];?>">
                <button type="submit" class="details-linkk">Request Session</button>
            </form>
        </div>
    <?php 
        } 
    } 
    mysqli_close($connection);
    ?>
    </div>
    </section>
    <footer>
        <a href="contact.php">Contact us</a>
        <p class="copyright">Created by KSU Students!<br>&copy; 2024 Lanturn</p>
    </footer>
</body>

</html>