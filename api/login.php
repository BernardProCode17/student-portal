<?php
//imports
session_start();
require_once("dbinfo.php");
// require_once("databasefile.php");

// Variables
$login_error = array();
$username = "";
$password = "";

// Login in information entered check
if (empty($_POST['username']) && empty($_POST['password'])) {

   if (empty($_POST['username']) && empty($_POST['password'])) {
      $login_error[] = "<p>Please enter a username and password</p>";
   } else if (empty($_POST['username'])) {
      $login_error[] = "<p>Please enter your username</p>";
   } else if (empty($_POST["password"])) {
      $login_error[] = "<p>Please enter your password</p>";
   }
   header("Location: index.php");
   exit();
} else {

   $login_query = "SELECT username, password FROM user WHERE username='" . $_SESSION['username'] . "' AND password='" . $_SESSION['password'] . "'";

   $mysql = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

   try {
      if ($mysql->connect_error) {
         throw new Exception("Error Processing Request", $mysql->connect_error);
      }
   } catch (Exception $e) {
      echo "There was an unexpected error: " . " <br>" . $e->getMessage() . "<br> <br>" . " Please Return Later";
      exit();
   }

   $username = $mysql->real_escape_string(trim($_POST["username"]));
   $password = $mysql->real_escape_string(trim($_POST["password"]));

   $_SESSION["username"] = $username;
   $_SESSION["password"] = $password;

   $query_result = $mysql->query($login_query);

   if ($query_result->num_rows > 0) {
   } else {
      $login_error[] = "<p>Please enter a valid Username and Password</p>";
      header("Location: index.php");
      exit();
   }
}

if (!is_array($login_error)) {
   $login_error = array();
} else {
   null;
}


$_SESSION['login_error'] = $login_error;
$_SESSION['username'] = ucfirst($username);
$_SESSION['timeout'] = time();

header("Location: table.php");
exit();
