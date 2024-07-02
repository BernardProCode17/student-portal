<?php


function timeout(){

   $timeout_dureation = 1800;
   $timeout_message = '';
   
   if (isset($_SESSION['timeout'])){
      $timeout = $_SESSION['timeout'];
   }
   
   if (time() - $timeout > $timeout_dureation){
      $timeout_message = "<p>You have been logout, due to inactivity</p>";
      session_unset();
      session_destroy();

      header("Location: logout.php?msg=" . $timeout_message);
      exit();
   }
   $timeout = time();
}
?>