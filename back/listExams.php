<?php
//listExams.php, Matthew Stepnowski
include 'db.php';
$result = mysqli_query($connection, "SELECT DISTINCT examID, examName From CS490_exams");

if (mysqli_num_rows($result) > 0){
  $json = array();
  while($row = mysqli_fetch_assoc($result)){
    $json[] = $row;
  }
} 
else{
  //If no exams exist, return -1
  $json = array("ExamID" => "-1");
}
echo json_encode($json);
mysqli_close($connection);
?>            
