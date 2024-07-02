<?php
session_start();
require_once 'variables.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home | Student Administration Portal</title>
   <link rel="stylesheet" href="css/styles.css">
   <link rel="stylesheet" href="css/normalize_reset.css">
   <link rel="stylesheet" href="css/project_style.css">
</head>

<body>

   <header>
      <h1><?php echo FIRSTNAME . ' ' . LASTNAME ?></h1>
      <p><?php echo 'Student Administration Portal' ?></p>
      <!-- <nav>
         <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="#">About</a></li>
         </ul>
      </nav> -->
   </header>

   <main>

      <div>
         <?php
         if (isset($_SESSION['login_error'])) {
            foreach ($_SESSION['login_error'] as $error) {
               echo '' . $error . '';
            }
         }
         ?>
      </div>

      <form action="api/login.php" method="post">

         <fieldset>

            <label for="username">Username</label>
            <input type="text" name="username" id="username">

            <label for="password">Password</label>
            <input type="password" name="password" id="password">

            <input type="submit" value="login">

         </fieldset>

      </form>
      <p class='account'>Do you have an account?</p>
      <a href="api/registerUser.php" class="account-link">Register Here</a>
   </main>

</body>

<footer>
   <h3>Bernard Clarke</h3>

   <section class="footer-tags">
      <p>PHP SQL</p>
      <p>FWD 35</p>
      <p id="year">2023</p>
   </section>
</footer>

</html>