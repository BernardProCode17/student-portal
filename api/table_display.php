<?php
require_once 'dbinfo.php';


function tableDisplay()
{
   $HTML_OutPut = '';

   // new SQL Object
   $mysql = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

   //Connect error
   try {
      if ($mysql->connect_error) {
         throw new Exception("Error Processing Request", $mysql->connect_error);
      }
   } catch (Exception $e) {
      echo "There was an unexpected error: " . " <br>" . $e->getMessage() . "<br> <br>" . " Please Return Later";
      exit();
   }

   // Table query
   $student_table_query = "SELECT id, firstname, lastname FROM students";
   $student_query = $mysql->query($student_table_query);
   if ($mysql->error) {
      echo "" . $mysql->error . "" . "";
   }
   $student_query_array = $student_query->fetch_all(MYSQLI_ASSOC);



   // HTML Table
   if (count($student_query_array) > 0) {
      $HTML_OutPut = "<table class='table'>";

      //Table Head
      $HTML_OutPut .= "<tr>";
      $student_table_fields = $student_query->fetch_fields();
      foreach ($student_table_fields as $field) {
         $HTML_OutPut .= "<th><a href='table.php?sort=" . $field->name . "'>" . ucfirst($field->name) . "</a></th>";
      }

      // Table Sort
      $sort_query = isset($_GET['sort']) ? $_GET['sort'] : null;
      if ($sort_query) {
         $student_table_query = "SELECT id, firstname, lastname FROM students ORDER BY $sort_query";
         $student_query = $mysql->query($student_table_query);
         $student_query_array = $student_query->fetch_all(MYSQLI_ASSOC);
      }
      $HTML_OutPut .= "</tr>";
   }

   // Table Row and data
   $student_query->data_seek(0);
 
   while ($row = $student_query->fetch_row()) {
      $HTML_OutPut .= "<tr>";
      foreach ($row as $record) {
         $HTML_OutPut .= "<td>" . ucfirst($record) . "</td>";
      }

      $HTML_OutPut .= "<td><a href='delete_record.php?id=" . $row[0] . "&firstname=" . $row[1] . "&lastname=" . $row[2] . "'>Delete</a></td>";
      $HTML_OutPut .= "<td><a href='update_record.php?id=" . $row[0] . "&firstname=" . $row[1] . "&lastname=" . $row[2] . "&from=table'>Update</a></td>";
      $HTML_OutPut .= "<tr>";
   }

   $HTML_OutPut .= "</table>";

   return $HTML_OutPut;
}
?>
