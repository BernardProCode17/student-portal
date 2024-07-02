<?php
require_once 'dbinfo.php';
$Registered_userName = '';
$Registered_password = '';
$registaration_message = array();

if (isset($_POST['register-username']) && isset($_POST['register-password'])) {

   if (!empty($_POST['register-username']) && !empty($_POST['register-password'])) {
      $Registered_userName = trim(ucwords($_POST['register-username']));
      $Registered_password = trim(ucwords($_POST['register-password']));

      // SQL connection
      $SQL = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
      if ($SQL->connect_error) {
         echo 'Failed to connect to MySQL: ' . $SQL->connect_error;
         exit();
      }
      //  username= ? AND , $Registered_userName
      //Check if user has already been registered
      $register_SQL = $SQL->prepare("SELECT * FROM user WHERE username = ? AND password = ?");
      $register_SQL->bind_param("ss", $Registered_userName, $Registered_password);
      $register_SQL->execute();
      $SQL_Results = $register_SQL->get_result();

      if ($SQL_Results->num_rows > 0) {
         $row = $SQL_Results->fetch_assoc();
         $id = $row['primary_key'];
         // $register_SQL->store_result();

         $registaration_message[] = "<p>Your accout has already been registered</p>";
         $messageArray = implode(' ', $registaration_message);
         $encode = urlencode($messageArray);
         header("Location: registerUser.php?msg=$encode");
         exit();
      } else if ($register_SQL->affected_rows <= 0) {

         //SQL table insert
         //Add new user to the database
         try {

            $register_SQL = $SQL->prepare("INSERT INTO user (username, password) VALUES (?, ?)");
            $register_SQL->bind_param("ss", $Registered_userName, $Registered_password);
            $register_SQL->execute();
            $registaration_message[] = "<p class='registerMessage'> Your username and password has been registered</p>";
         } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
               $registaration_message[] = "<p class='registerMessage'>Please enter a unique username and password</p>";
            }else{
               $registaration_message[] = "<p>An error has occurred: " . $e->getMessage() . "</p>";
            }
         }

         $messageArray = implode(' ', $registaration_message);
         $encode = urlencode($messageArray);
         header("Location: registerUser.php?msg=$encode");
         exit();
      } else {
         $registaration_message[] = "<p class='registerMessage'> Your username and password has not been registered</p>";

         $messageArray = implode(' ', $registaration_message);
         $encode = urlencode($messageArray);
         header("Location: registerUser.php?msg=$encode");
         exit();
      }
   } else {
      $registaration_message[] = "<p>Please enter your username and password</p>";

      $messageArray = implode(' ', $registaration_message);
      $encode = urlencode($messageArray);
      header("Location: registerUser.php?msg=$encode");
      exit();
   }
} else {
   $registaration_message[] = "<p>Please enter your username and password</p>";

   $messageArray = implode(' ', $registaration_message);
   $encode = urlencode($messageArray);
   header("Location: registerUser.php?msg=$encode");
   exit();
}
