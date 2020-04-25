<?php
include "db.php";
$examName = $_POST["examName"];
$examQuestionsAndPoints = $_POST["examQuestionsAndPoints"];  // Array should looks like [{questionID : 1, points : 25}, {questionID : 2, points : 25}, {questionID : 3, points : 50}];
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
echo $counter;

foreach($arr as $item) 
{ 
  $questionID = $item["questionID"];
  $points = $item["points"];
  $result_exam = mysqli_query($connection, "INSERT INTO CS490_exams (examID, examName, questionID, points) VALUES ('$counter', '$examName' , '$questionID', '$points')");
  if (!$result_exam) 
  {
    echo "Error: " . $result_exam . "<br>" . mysqli_error($connection);
  }
}
echo "Created New Exam Successfully";




mysqli_close($connection);
?>