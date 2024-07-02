<?php
require_once 'variables.php';
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Logout | Student Administraion Portal</title>
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
      if(isset($_GET['msg'])){
         $msg = $_GET['msg'];
         echo''. $msg .'';
      }
      ?>
   </div>

      <a href="index.php" class='link'>Login</a>

   </main>

   <footer>
      <h3>Bernard Clarke</h3>

      <section class="footer-tags">
         <p>PHP SQL</p>
         <p>FWD 35</p>
         <p id="year">2023</p>
      </section>
      
   </footer>

</body>

</html>