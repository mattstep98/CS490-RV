<?php
//filterQuestions.php, Matthew Stepnowski  ...This is no longer in use, filtering is done by the front now
include "db.php";
$topic = $_POST["topic"];
$level = $_POST["level"];
if (!empty($topic) and !empty($level)){
  $result = mysqli_query($connection, "SELECT questionID, description, topic, level From CS490_questions Where topic = '$topic' and level = '$level'");
}
else if (!empty($topic)){
  $result = mysqli_query($connection, "SELECT questionID, description, topic, level From CS490_questions Where topic = '$topic'");
}
else if (!empty($level)){
  $result = mysqli_query($connection, "SELECT questionID, description, topic, level From CS490_questions Where level = '$level'");
}
else{
  $result = mysqli_query($connection, "SELECT questionID, description, topic, level From CS490_questions");
}

if (mysqli_num_rows($result) > 0){
  $json = array();
  while($row = mysqli_fetch_assoc($result)){
  $json[] = $row;
  }
}else{
  //return -1 if there is no results
  $json = array("QuestionID" => "-1");
}
echo json_encode($json);
mysqli_close($connection);
?>