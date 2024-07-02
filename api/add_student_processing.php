<?php
session_start();
require_once 'dbinfo.php';
$student_id = $_POST['student_id'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$message = array();

if (isset($_POST['student_id']) && isset($_POST['firstname']) && isset($_POST['lastname'])) {

    // check if fields  has been filled out
    if (empty($_POST['student_id']) || empty($_POST['firstname']) || empty($_POST['lastname'])) {
        $message[] = "<p>Please fill out all fields</p>";
        $_SESSION['message'] = $message;
        header("Location: add_student.php"); // Send user back to the add student page to fill in all the fields 
        exit();
    } else { // trim and uppercase the the first later of the names
        $student_id = trim(ucwords($_POST['student_id']));
        $firstname = trim(ucwords($_POST['firstname']));
        $lastname = trim(ucwords($_POST['lastname']));
    }

    // Database connection
    $SQL = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($SQL->connect_error) {
        echo 'Failed to connect to MySQL: ' . $SQL->connect_error;
        exit();
    }
    // SQL query injection protection
    $registerStudent = $SQL->prepare("SELECT * FROM students WHERE id = ?");
    $registerStudent->bind_param("s", $student_id);
    $registerStudent->execute();
    $registeredResult = $registerStudent->get_result();

    // Check if student already registered
    if ($registeredResult->num_rows > 0) {
        $message[] = "<p>Student already registered: $student_id</p>";
        $_SESSION['message'] = $message;
        header("Location: table.php");
        exit();
    } else { // add student to the database
        $student_query = $SQL->prepare("INSERT INTO students (id, firstname,  lastname) VALUES ( ?, ?, ?) ");
        $student_query->bind_param("sss", $student_id, $firstname, $lastname);
        $student_query->execute();

        $message[] = "<p>Student added successfully: $student_id , $firstname, $lastname</p>";
        $_SESSION['message'] = $message;
        header("Location: table.php");
    }
} else {
    $message[] = "<p>Please fill out all fields</p>";
    $_SESSION['message'] = $message;
    header("Location: add_student.php");
    exit();
}
