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
$LearnerEmail = $_SESSION['email'];

// Define variables
$selectedLanguage = $selectedProficiency = $date = $time = $selectedDuration = "";
$selectedLanguageErr = $selectedProficiencyErr = $dateErr = $timeErr = $selectedDurationErr = "";
$TutorFName = $TutorLName = $TutorEmail = "";

// Retrieve tutor's email based on first name and last name
if (isset($_GET['firstName']) && isset($_GET['lastName'])) {
    $TutorFName = $_GET['firstName'];
    $TutorLName = $_GET['lastName'];

    $query0 = "SELECT email FROM tutor WHERE fname LIKE '%$TutorFName%' AND lname LIKE '%$TutorLName%'";

    $result0 = mysqli_query($conn, $query0);
    if ($result0 && mysqli_num_rows($result0) > 0) {
        $row = mysqli_fetch_assoc($result0);
        // define('TutorEmail', $row['email']);
        $TutorEmail = $row['email'];
    } else {
        echo "Error retrieving tutor's email: " . mysqli_error($conn);

    }
}

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tutorEmailPost = $_POST['tutorEmail'] ?? '';
    // Validate that language is selected
    if (empty($_POST["language"])) {
        $selectedLanguageErr = "Please select a language.";
    } else {
        $selectedLanguage = $_POST["language"];
    }

    // Validate that proficiency is selected
    if (empty($_POST["prolevel"])) {
        $selectedProficiencyErr = "Please select a proficiency level.";
    } else {
        $selectedProficiency = $_POST["prolevel"];
    }

    // Validate date
    if (empty($_POST["date"])) {
        $dateErr = "Please select a date.";
    } else {
        $date = $_POST["date"];
        // Check if the selected date is not before today
        if (strtotime($date) < strtotime(date("Y-m-d"))) {
            $dateErr = "Please select a valid date.";
        }
    }

    // Validate time
    if (empty($_POST["time"])) {
        $timeErr = "Please select a time.";
    } else {
        $time = $_POST["time"];
        // Check if the selected time is not before the current time
        if (strtotime($date . " " . $time) < strtotime(date("Y-m-d H:i"))) {
            $timeErr = "Please select a valid time .";
        }
    }

    // Validate selected duration
    if (empty($_POST["duration"])) {
        $selectedDurationErr = "Please select a duration.";
    } else {
        $selectedDuration = $_POST["duration"];
    }
    if (empty($selectedLanguageErr) && empty($selectedProficiencyErr) && empty($dateErr) && empty($timeErr) && empty($selectedDurationErr)) {

        $query5 = "INSERT INTO request (language, prolevel, date, time, duration, status,  TutorEmail, LearnerEmail) 
                   VALUES ('$selectedLanguage', '$selectedProficiency', '$date', '$time', '$selectedDuration', 'pending',  '$tutorEmailPost', '$LearnerEmail')";

        $result2 = mysqli_query($conn, $query5);


        if ($result2) {

            mysqli_close($conn);
            // Display a confirmation dialog and redirect to home page
            echo "<script>alert('Request submitted successfully!'); window.location.href = 'learnerHome.php';</script>";
            exit();
        } else {

            echo "Error: " . mysqli_error($conn);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request session</title>

    <link rel="stylesheet" href="styles.css">
    <script>
        function validateForm() {
            var language = document.forms["appoint-form"]["language"].value;
            var proficiency = document.forms["appoint-form"]["prolevel"].value;
            var date = document.forms["appoint-form"]["date"].value;
            var time = document.forms["appoint-form"]["time"].value;
            var duration = document.forms["appoint-form"]["duration"].value;
            var errMsg = "";

            if (language == "") {
                errMsg += "Please select a language.\n";
            }
            if (proficiency == "") {
                errMsg += "Please select a proficiency level.\n";
            }
            if (date == "") {
                errMsg += "Please select a date.\n";
            } else if (new Date(date) < new Date()) {
                errMsg += "Please select a valid date.\n";
            }
            if (time == "") {
                errMsg += "Please select a time.\n";
            } else {
                var dateTime = new Date(date + " " + time);
                if (dateTime < new Date()) {
                    errMsg += "Please select a valid time.\n";
                }
            }
            if (duration == "") {
                errMsg += "Please select a duration.\n";
            }

            if (errMsg !== "") {
                alert(errMsg);
                return false;
            }
            return true;
        }
    </script>


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

    <section>
        <div id="arrange">
            <div class="container">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="appoint-form" method="POST"
                    onsubmit="return validateForm()">
                    <h2 id="form-head">Request a session with <?php echo $TutorFName . ' ' . $TutorLName; ?></h2>
                    <label for="dropdown" id="city" class="format">SELECT LANGUAGE: </label>
                    <select id="dropdown" name="language">
                        <option value="" disabled selected>Select the language</option>
                        <option value="English">English</option>
                        <option value="Spanish">Spanish </option>
                        <option value="French">French </option>
                    </select>
                    <label for="dropdown2" id="level" class="format">SELECT PROFICIENCY LEVEL </label>
                    <select id="dropdown2" name="prolevel">
                        <option value="" disabled selected>Select the proficiency level</option>
                        <option value="beginner">Beginner </option>
                        <option value="intermediate">Intermediate </option>
                        <option value="advance">Advance </option>
                    </select>
                    <label for="date" id="date-time" class="format">SELECT DATE AND TIME </label>
                    <input type="date" id="date" name="date" class="dtt" required>
                    <input type="time" id="time" name="time" min="08:00" max="20:00" value="08:00" class="dtt" required>
                    <label for="dropdown3" id="duration" class="format">SELECT DURATION </label>
                    <select id="dropdown3" name="duration">
                        <option value="" disabled selected>Select the duration</option>
                        <option value="1">1hr </option>
                        <option value="1.5">1.5hr </option>
                        <option value="2">2hr </option>
                    </select>
                    <input type="hidden" name="tutorEmail" value="<?php echo htmlspecialchars($TutorEmail ?? ''); ?>">
                    <button type="submit" name="submit" id="submit" value="Submit">Submit</button>
                    <button id="return" onclick="window.location.href='learnerTutors.php';">Return</button>

                </form>
            </div>
        </div>
    </section>

    <footer>
        <a href="contact.php">Contact us</a>
        <p class="copyright">Created by KSU Students!<br>&copy; 2024 Lanturn</p>
    </footer>
</body>

</html>