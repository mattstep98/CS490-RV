<?php
include "db.php";

$examID = $_POST['examID'];
$examID = (int)$examID;

$result = mysqli_query($connection, "UPDATE CS490_studentGrading SET releaseGrades = 1 WHERE examID = '$examID'");

// Pass back the string !!! if we failed to add a new question
if ($result) {
  echo "Successfully Updated";
} 
else 
{
  echo "Error: " . $result . "<br>" . mysqli_error($connection);
}

mysqli_close($conn);
?>