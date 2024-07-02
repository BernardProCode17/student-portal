<?php
session_start();
require_once 'dbinfo.php';

$message = array();
// $studentID = $_SESSION['studentID'];

$studentID = $_SESSION['studentID'];

if (isset($_POST['student_id']) || isset($_POST['firstname']) || isset($_POST['lastname'])) { // Check if form fields has been filled out

   if (!empty($_POST['student_id']) && !empty($_POST['firstname']) && !empty($_POST['lastname'])) { // Check if form fields has been filled out

      // store student information
      $student_id = $_POST['student_id'];
      $firstname = $_POST['firstname'];
      $lastname = $_POST['lastname'];

      //Open databse connection
      $updateSQL = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
      // check for connection errors
      try {
         if ($updateSQL->connect_error) {
            throw new Exception("Error Processing Request", $updateSQL->connect_error);
         }
      } catch (Exception $e) {
         "There was an unexpected error: " . " <br>" . $e->getMessage() . "<br> <br>" . " Please Return Later";
         exit();
      }

      // Checks if the id 
      $CheckQuery = $updateSQL->prepare("SELECT id FROM students WHERE id= ?");
      $CheckQuery->bind_param("s", $studentID);
      $CheckQuery->execute();
      $CheckResult = $CheckQuery->get_result();
      if ($CheckResult->num_rows > 0) {
         $message[] = "<p></p>";
      } else {
         // SQL injection protection
         $updateQuery = $updateSQL->prepare("UPDATE students SET id= ?, firstname= ?, lastname= ? WHERE id= ?");
         $updateQuery->bind_param("ssss", $student_id, $firstname, $lastname, $studentID);
         $updateQuery->execute();

         // check for match row, and send the success message
         if ($updateQuery->affected_rows > 0) {
            $message[] =  "<p>Student record with: <br>ID: " . $student_id . "<br> First name: " . $firstname . "<br> Last Name " . $lastname . "<br> was updates in the Database</p>"; // deleted message
         } else {
            $message[] = "<p>No Student Record was updated</p>";
         }
      }
   } else {
      $message[] = "<p>Please fill in all the fields</p>";
   }
} else {
   $message[] = "<p>Please fill in all the fields</p>";
}


$_SESSION['message'] = $message; // message array
header("Location: table.php"); // redirect to the tables page
exit();
