<?php
//teacherOverride.php, Matthew Stepnowski
include "db.php";
$examID = $_POST['examID'];
$questionID = $_POST['$questionID'];
$username = $_POST['username'];
$grade = $_POST['grade'];
$comments = $_POST['comments'];

$result = mysqli_query($connection, "UPDATE `CS490_studentGrading` SET `grade` = '$grade',`comments` = '$comments' WHERE `username` = '$username' and `examID` = '$examID' and `questionID` = '$questionID'");

if ($result){
  $json = array("message_type" => "success");
  echo json_encode($json);
}else{
  echo "Error: " . $result_exam . "<br>" . mysqli_error($connection);
}
mysqli_close($conn);
?>