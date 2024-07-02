   <?php
   session_start();
   if (!isset($_SESSION['username'])) {
      header('Cache-control: no-cache, must-revalidate, max-age=0');
      header('Pragma: no-cache');
      header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');
      header('Location: logout.php');
   }
   require_once 'variables.php';
   require_once 'get_record_info.php';
   require_once 'timeout.php';
   timeout();
   ?>
   <!DOCTYPE html>
   <html lang="en">

   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Remove | Student Administration Portal</title>
      <?php echo '<link rel="stylesheet" href="../css/styles.css">' ?>
      <?php echo '<link rel="stylesheet" href="../css/normalize_reset.css">' ?>
      <link rel="stylesheet" href="../css/project_style.css">

   </head>

   <body>

      <header>
         <h1><?php echo FIRSTNAME . ' ' . LASTNAME ?></h1>
         <p><?php echo 'Student Administration Portal' ?></p>
         <nav>
            <ul>
               <li><a href="table.php">Home</a></li>
               <li><a href="add_student.php">Add Student</a></li>
               <!-- <li><a href="update_record.php">Update</a></li>
               <li><a href="delete_record.php">Remove</a></li> -->
               <li><a href="logout.php">Log Out</a></li>
            </ul>
         </nav>
      </header>

      <main>

         <div>
            <a href="table.php" class="link">Back</a>
         </div>

         <?php echo getRecordInfo() ?>

         <form action="delete_record_process.php" method="post">

            <fieldset>
               <h3>Are you sure you want to remove this record </h3>

               <?php echo isset($_SESSION['delMessage']) ? $_SESSION['delMessage'] : null; ?>

               <label for="yes">Yes</label>
               <input type="radio" name="remove_record" id="yes" value="yes">

               <label for="no">No</label>
               <input type="radio" name="remove_record" id="no" value="no">

               <input type="submit" value="Delete">

            </fieldset>

         </form>

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