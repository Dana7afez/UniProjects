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
                <h1 class="header1">Lanturn</h1>
            </header>
            <section>
                <div class="wrapper-login"> 
                    <h2 class="header2">Login</h2>
                    <div class="login-type">
                        <!--<button class="login-as-learner" onclick="window.location.href= 'loginLearner.html';">Login as a learner</button>
                        <button class="login-as-tutor" onclick="window.location.href= 'loginTutor.html';">Login as a tutor</button>-->
                        <ul>
                            <li><a href = "loginLearner.php">Login as a Learner</a></li>
                            <li><a href = "loginTutor.php">Login as a Tutor</a></li>
                        </ul>
                    </div>
                </div>
            </section>
            <footer>
                <a href = "contact.php">Contact us</a>
                <p class="copyright">Created by KSU Students!<br>&copy; 2024 Lanturn</p>
            </footer>
        </div>
    </body>
</html>