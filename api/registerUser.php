<?php
session_start();
require_once 'variables.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register | Student Administration Portal</title>
   <?php echo '<link rel="stylesheet" href="../css/styles.css">' ?>
   <?php echo '<link rel="stylesheet" href="../css/normalize_reset.css">' ?>
   <link rel="stylesheet" href="../css/project_style.css">

</head>

<body>

   <header>
      <h1><?php echo FIRSTNAME . ' ' . LASTNAME ?></h1>
      <p><?php echo 'Student Administration Portal' ?></p>

   </header>

   <main>

      <div>
         <?php

         if (isset($_GET['msg'])) {
            $msg = urldecode($_GET['msg']);
            $msg = html_entity_decode($msg);
            echo '' . $msg . '';
         }

         ?>

      </div>

      <form action="registerUser_processing.php" method="post" autocomplete="off">

         <fieldset>

            <label for="username">Enter Your Username</label>
            <input type="text" name="register-username" id="username">

            <label for="password">Enter Your Password</label>
            <input type="password" name="register-password" id="password">

            <input type="submit" value="Register">

         </fieldset>

      </form>

      <a href="../index.php" class='account-link'>Login</a>

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