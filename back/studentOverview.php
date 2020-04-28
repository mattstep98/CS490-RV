<?php
//studentOverview.php, Matthew Stepnowski
include "db.php";
$username = $_POST['username'];

$gradedResults = array(); //Gets an array of all exams that a student has taken
$result = mysqli_query($connection, "SELECT examID, questionID, overallGrade FROM CS490_studentGrading WHERE username = '$username'");
if (mysqli_num_rows($result) > 0){
  while($row = mysqli_fetch_assoc($result)){
    $gradedResults[] = $row;
  }
}
$arr = array(); //array of if an exam was released or not
$result = mysqli_query($connection, "SELECT examID, releaseGrades FROM CS490_exams");
if (mysqli_num_rows($result) > 0){
  while($row = mysqli_fetch_assoc($result)){
    $arr[] = $row;
  }
}
$exams = ($gradedResults);
$returnArray = array(); //json array that will be sent to the front to display grades

//taking information from both arrays to send to front (if a student can view the grade and if they can:the grade they got)
for($x=0; $x<sizeof($gradedResults);$x++){
  $sum = floatval(($gradedResults[$x]["overallGrade"]));
  for($y=$x+1;$y<=sizeof($gradedResults);$y++){
    if((intval($gradedResults[$x]["examID"]) == intval($gradedResults[$y]["examID"]))){
      $sum+= floatval($gradedResults[$y]["overallGrade"]);
    }else{
      $key = (json_encode(intval($exams[$x]["examID"])));
      $returnArray[$key] = $sum;
      $x = $y-1;
      break;
    }
  }
}
$result2 = mysqli_query($connection, "SELECT DISTINCT examID, releaseGrades FROM CS490_exams");
if (mysqli_num_rows($result2) > 0){
  while($row = mysqli_fetch_assoc($result2)){
    $release[] = $row;
  }
}
$releaseString = "";
foreach($release as $rel){
  $rel = ($rel["releaseGrades"]);  
  $releaseString =$releaseString.($rel);
}
for($x=1;$x<=strlen($releaseString);$x++){
  if((array_key_exists(strval($x),$returnArray)) and ($releaseString[($x-1)]=='0')){ //if the exam is graded, but the exam is not released.
    $returnArray[$x] = "Not Released";
  }
}


echo json_encode($returnArray);


mysqli_close($connection);
?>
