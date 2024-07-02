<?php
session_start();
require_once 'dbinfo.php';

$message = array();
if (isset($_POST['remove_record']) && !empty($_POST['remove_record'])) { // Chek if the radio button was clicked

   // get the Student ID parameter from the getRecordInfo() //delete_record_process.php
   if (isset($_SESSION['studentID'])) {
      $student_id = $_SESSION['studentID'];
   }

   if ($student_id) { // check if student ID has a value

      //Store the radio button value
      $delRecord = $_POST['remove_record'];
      //Open databse connection
      $delSQL = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

      try {
         if ($delSQL->connect_error) {
            throw new Exception("Error Processing Request", $delSQL->connect_error);
         }
      } catch (Exception $e) {
         "There was an unexpected error: " . " <br>" . $e->getMessage() . "<br> <br>" . " Please Return Later";
         exit();
      }

      //Query preparation and execution // SQL Injection Protection
      if ($delRecord === 'yes') {
         $delQuery = $delSQL->prepare("DELETE FROM students WHERE id = ?");
         $delQuery->bind_param("s", $student_id);
         $delQuery->execute();

         if ($delQuery->affected_rows > 0) { // Check if record was deleted
            $message[] =  "<p>Student record with <br>ID:" . $student_id . "<br> was deleted from the Database</p>"; // deleted message
         } else {
            $message[] = "<p>No Student Record was deleted</p>"; 
         }
      } else { // Value: No Block
         $message[] = "<p>No Student Record was deleted</p>";
      }
   }else{
      $message[] = "<p>No Student Record was Found</p>"; // No Student ID
   }
} else {
   $message[] = "<p> Please select Yes or No</p>"; // No Radio Button was selected
}

$_SESSION['message'] = $message; // message array
header("Location: table.php"); // redirect to the tables page
exit();
