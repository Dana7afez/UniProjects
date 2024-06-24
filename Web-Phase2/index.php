<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            Lanturn
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
                    <div class ="sign-links">
                        <button class="login" onclick="window.location.href= 'login.php';">Login</button>
                        <button class="register" onclick = "window.location.href='register.php';">Register</button>
                    </div>
                </nav>
                <h1 class="header1">Lanturn</h1>
            </header>
            
           <section>  
        <h2 class="text">Welcome to Lanturn!</h2>
        <div class="Reviewer">Step into a dynamic world where language and cultural exchanges come to life!</div>
           </section>
           <section class="wrapper-info">
            <div>Welcome to Lanturn, where communication and learning go hand in hand! We are passionate about helping individuals from all walks of life master new languages and unlock a world of opportunities. Whether you're a beginner starting from scratch or an advanced learner looking to refine your skills, we're here to support you every step of the way.</div>
            <div class="wrapper-info2">
            <div class="info-left">As a LEARNER, you'll gain access to fluent speakers from around the world, ready to guide you in achieving your learning goals. You'll enjoy personalized learning sessions, tailored to your proficiency level and interests, while immersing yourself with cultural insights that textbooks simply can't offer.<br><a class="edit" href = "registerLearner.php"><h2>Register as a Learner</h2></a></div>

            <div class="info-right">As a TUTOR, You will get the unique opportunity to share your language and culture as will as engage with eager learners. You'll improve your teaching skills, learn about new cultures, and hopefully make lifelong friends.<br><br><br><a class="edit" href = "registerTutor.php"><h2>Register as a Tutor</h2></a></div>
        </div>
        </section>
            <footer>
                <a href = "contact.php">Contact us</a>
                <p class="copyright">Created by KSU Students!<br>&copy; 2024 Lanturn</p>
            </footer>
        </div>
    </body>
</html>