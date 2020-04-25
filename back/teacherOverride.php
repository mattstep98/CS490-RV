<?php
include "db.php";
$examID = $_POST['examID'];
$questionID = $_POST['$questionID'];
$username = $_POST['username'];
$grade = $_POST['grade'];
$teacherComments = $_POST['teacherComments'];

$result = mysqli_query($connection, "UPDATE CS490_studentGrading SET grade='$grade',comments='$teacherComments' WHERE examID='$examID' and questionID='$questionID' and username='$username'");

// Pass back the string !!! if we failed to add a new question
if ($result) {
echo "Successfully Updated";
} else {
echo "Error: " . $result . "<br>" . mysqli_error($connection);
}

mysqli_close($conn);
?>