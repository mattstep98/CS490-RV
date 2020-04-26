<?php
include "db.php";
//takeExam.php, Matthew Stepnowski
$examID=$_POST['examID'];
$examID = (int)$examID;

$result = mysqli_query($connection, "SELECT examID, questionID, points FROM CS490_exams WHERE ExamID = '$examID'");
if (mysqli_num_rows($result) > 0){
  $json = array();
  while($row = mysqli_fetch_assoc($result)){
    $questionID = $row["questionID"];
    $question_query = mysqli_query($connection, "SELECT questionID, description FROM CS490_questions WHERE questionID = '$questionID'");
    $question = mysqli_fetch_assoc($question_query);
    $row["questionID"] = $question["questionID"];
    $row["description"] = $question["description"];
    $json[] = $row;
  }
}else{
  $json = array("message_type" => "-1");
}
echo json_encode($json);
mysqli_close($connection);
?>