<?php
DEFINE('DB_USER', 'root');
DEFINE('DB_PSWD', '');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'lama');

// Establish database connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PSWD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Start session
session_start();
$learnerEmail = $_SESSION['email'];

if (isset($_GET['reqID'])) {
    $reqID = $_GET['reqID'];
}

// Check if the user has already rated this session
$ratingCheckQuery = "SELECT * FROM rate WHERE rID = ?";
$stmt = $conn->prepare($ratingCheckQuery);
$stmt->bind_param("i", $reqID);
$stmt->execute();
$resultCheck = $stmt->get_result();

if ($resultCheck->num_rows > 0) {
    echo '<script>alert("You have already rated this session!");</script>';
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reqIDpost = $_POST['reqID'] ?? '';
    $star_rating = $_POST['rating'] ?? '';
    $feedback = $_POST['feedback'];
    $date_time = date('Y-m-d H:i:s');

    // Fetch tutor email from the database based on reqID
    $getTutorEmailQuery = "SELECT TutorEmail FROM request WHERE ReqID = ?";
    $stmt = $conn->prepare($getTutorEmailQuery);
    $stmt->bind_param("i", $reqIDpost);
    $stmt->execute();
    $stmt->bind_result($tutor_email);
    $stmt->fetch();
    $stmt->close();
  
    // Insert rating into the database
    $sql1 = "INSERT INTO rate (rID, star, feedback, dateAndtime, tutorEmail, learnerEmail) 
             VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql1);
    $stmt->bind_param("isssss", $reqIDpost, $star_rating, $feedback, $date_time, $tutor_email, $learnerEmail);
    
    if ($stmt->execute()) {
        echo '<script>alert("Rate added successfully");</script>';
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    $stmt->close();

    // Redirect after processing
    header("Location: learnerPrevSessions.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate Tutor</title>
    <link rel="stylesheet" href="styles.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <script>
        //redirect after showing the alert
        window.onload = function() {
            var alertMessage = "<?php echo isset($resultCheck) && $resultCheck->num_rows > 0 ? 'You have already rated this session!' : ''; ?>";
            if (alertMessage) {
                window.location.href = "learnerPrevSessions.php";
            }
        };
    </script>
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
                                <li><a href="learnerPM.php">Manage Profile</a></li>
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
                <h2 class="header2">Rate Tutor</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="rate-form" method="POST">
                    <br>
                    <label>Rate:</label>
                    <div class="rateyo" id= "rating"
                    data-rateyo-rating="4"
                    data-rateyo-num-stars="5"
                    data-rateyo-score="3">
                    </div>
           
               <span class='result'>0</span>
               <input type="hidden" name="rating">
                    <div class="input-box-rate">
                        <label>Give your feedback</label>
                        <br>
                        <textarea rows="3" cols="71" name="feedback"></textarea>
                    </div>
                    <input type="hidden" name="reqID" value="<?php echo htmlspecialchars($reqID ?? ''); ?>">
                    <button type="submit" name="submit" id="submit" value="Submit">Submit</button>
                    
                </form>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
        <script>


            $(function () {
                $(".rateyo").rateYo().on("rateyo.change", function (e, data) {
                    var rating = data.rating;
                    $(this).parent().find('.score').text('score :'+ $(this).attr('data-rateyo-score'));
                    $(this).parent().find('.result').text('rating :'+ rating);
                    $(this).parent().find('input[name=rating]').val(rating); //add rating value to input field
                });
            });
        
        </script>
            </div>
        </section>
        <footer>
            <a href="contact.php">Contact us</a>
            <p class="copyright">Created by KSU Students!<br>&copy; 2024 Lanturn</p>
        </footer>
    </div>
    <script>
        document.getElementById("rate-form").addEventListener("submit", function(event) {
            var rating = document.getElementById('rating');
            var feedback = document.querySelector('textarea[name="feedback"]').value.trim();
            var errMsg = "";

            // Check if rating is selected
            if (!rating) {
                errMsg += "Please select a rating.\n";
            }

            // Check if feedback is provided
            if (feedback === '') {
                errMsg += "Please provide feedback.\n";
            }

            // Display error message if any
            if (errMsg !== "") {
                alert(errMsg);
                event.preventDefault(); // Prevent form submission
            }
        });
    </script>
</body>
</html>