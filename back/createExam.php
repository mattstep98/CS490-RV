<?php
//createExam.php, Matthew Stepnowski
include "db.php";
$examName = $_POST["examName"];
$examQuestionsAndPoints = $_POST["examQuestionsAndPoints"]; //this is a string 1,50,3,50 questionID followed by points

$counter = 1;
$result = mysqli_query($connection, "SELECT examID FROM CS490_exams");

if (mysqli_num_rows($result) > 0) 
{
  $json = array();
  while($row = mysqli_fetch_assoc($result))
  {
    $counter = $row["examID"];
  }
} 
$counter++;

//inserting questions for the exam into the exam table
$arr = explode(",",$examQuestionsAndPoints);
$size = sizeof($arr);

for($x=0;$x<$size;$x+=2){
  $questionID = $arr[$x];
  $points = $arr[$x+1];
  $result_exam = mysqli_query($connection, "INSERT INTO CS490_exams (examID, examName, questionID, points) VALUES ('$counter', '$examName' , '$questionID', '$points')");
  if (!$result_exam){
    echo "Error: " . $result_exam . "<br>" . mysqli_error($connection);
  }else{
  $json = array("message_type" => "success");
  }
}

echo json_encode($json);
mysqli_close($connection);
?>