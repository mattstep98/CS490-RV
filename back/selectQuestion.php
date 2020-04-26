<?php
//selectQuestion.php, Matthew Stepnowski
include "db.php";

$questionID = $_POST["questionID"];

$result = mysqli_query($connection, "SELECT questionID, description, questionContraint, topic, level From CS490_questions Where questionID = '$questionID'");

if (mysqli_num_rows($result) > 0){
  $json = array();
  while($row = mysqli_fetch_assoc($result)){
    $json[] = $row;
  }
}else{
  $json = array("QuestionID" => "-1");
}
echo json_encode($json);
mysqli_close($connection);
?>