<?php
//allQuestions.php, Matthew Stepnowski
include 'db.php';
$result = mysqli_query($connection, "SELECT questionID, description, questionConstraint, topic, level From CS490_questions");

if (mysqli_num_rows($result) > 0) {
  $json = array();
  while($row = mysqli_fetch_assoc($result)){
    $json[] = $row;
  }
}else{
  //Return error if there are no questions
  $json = array("message_type" => "error");
}
echo json_encode($json);

mysqli_close($connection);
?>  