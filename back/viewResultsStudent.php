<?php
//viewResultsStudent.php, Matthew Stepnowski
include "db.php";
$username = $_POST['username'];
$examID = $_POST['examID'];

$result = mysqli_query($connection, "SELECT DISTINCT releaseGrades FROM CS490_exams WHERE examID = '$examID'");
$releaseGradesQ = mysqli_fetch_assoc($result); //returns if we should release the grades to this student
$shouldWeRelease = $releaseGradesQ["releaseGrades"];

if ($shouldWeRelease == 1){
  $result = mysqli_query($connection, "SELECT CS490_questions.description,CS490_questions.questionConstraint, CS490_studentGrading.grade, CS490_studentGrading.comments,
  CS490_studentGrading.studentAnswer FROM CS490_studentGrading INNER JOIN CS490_questions ON CS490_studentGrading.questionID=CS490_questions.questionID WHERE username = '$username' and examID = '$examID'");
  if (mysqli_num_rows($result) > 0){
    $json = array();
    while($row = mysqli_fetch_assoc($result)){
      $json[] = $row;
    }
  }else{
   $json = array("message_type" => "error");
  }
  echo json_encode($json);
}else{
  $json = array("message_type" => "Not Permitted To View Grades");
  echo json_encode($json);
}

mysqli_close($connection);
?>