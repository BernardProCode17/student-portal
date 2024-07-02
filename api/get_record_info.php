<?php
require_once 'dbinfo.php';
function getRecordInfo()
{

    $studentID = '';
    $firstname = '';
    $lastname = '';

    if (isset($_GET['id']) || isset($_GET['firstname']) || isset($_GET['lastname'])) { // Get the Student ID from the URL

        if (!empty($_GET['id']) || !empty($_GET['firstname']) || !empty($_GET['lastname'])) { // Check if the Student ID has a value

            //Store the ID and make connecting with the DataBase
            $SQL = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            $studentID = $SQL->real_escape_string($_GET['id']);
            $firstname = $SQL->real_escape_string($_GET['firstname']);
            $lastname =  $SQL->real_escape_string($_GET['lastname']);

            $_SESSION['studentID'] = $studentID;
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] =  $lastname;

            //Check for DataBase Error
            try {
                if ($SQL->connect_error) {
                    throw new Exception("Error Processing Request", $SQL->connect_error);
                }
            } catch (Exception $e) {
                "There was an unexpected error: " . " <br>" . $e->getMessage() . "<br> <br>" . " Please Return Later";
                exit();
            }


            //Record Query
            $Query = $SQL->prepare("SELECT * FROM students WHERE id= ? AND firstname= ? AND lastname= ?");
            $Query->bind_param("sss", $studentID, $firstname, $lastname);
            $Query->execute();
            $queryResults = $Query->get_result();

            if ($SQL->error) {
                return "" . $SQL->error . "" . "";
            }
            $_SESSION['studentID'] = $studentID;
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] =  $lastname;





            // Record Result
            if ($queryResults->num_rows > 0) {
                while ($recordRow = $queryResults->fetch_assoc()) {
                    $recordInfo = "<p class='recordinfo'><span>ID: " . $recordRow['id'] . "</span>" . "<span>First Name: " .  $recordRow['firstname'] . "</span>" .  "<span>Last Name: " . $recordRow['lastname'] ."</span></p>";
                    $_SESSION['RecordID'] = $recordRow['id'];
                    $_SESSION['RecordFirstname'] = $recordRow['firstname'];
                    $_SESSION['RecordLastname'] = $recordRow['lastname'];
                }
                $SQL->close();
                return $recordInfo; //Record information display
            } else {
                $SQL->close();
                return "<p>No Record found</p>";
            }
        } else {
            return "<p>Record Not Found</p>";
        }
    } else {
        return "<p>Record Not Found</p>";
    }
}
