<?php
//teacherOverride.php, Matthew Stepnowski
include "db.php";
$examID = $_POST['examID'];
$questionID = $_POST['$questionID'];
$username = $_POST['username'];
$grade = $_POST['grade'];
$teacherComments = $_POST['teacherComments'];

$result = mysqli_query($connection, "UPDATE CS490_studentGrading SET grade='$grade',comments='$teacherComments' WHERE examID='$examID' and questionID='$questionID' and username='$username'");

// Pass back the string !!! if we failed to add a new question
if ($result){
  $json = array("message_type" => "success");
  echo json_encode($json);
}else{
  $json = array("message_type" => "error");
  echo json_encode($json);
}
mysqli_close($conn);
?>