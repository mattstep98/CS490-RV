<?php
include "db.php";
$examID = $_POST["examID"];



$result = mysqli_query($connection, "SELECT DISTINCT username FROM CS490_studentGrading WHERE examID = '$examID'");
if (mysqli_num_rows($result) > 0) 
{
  $json = array();
  while($row = mysqli_fetch_assoc($result))
  {
    $json[] = $row;
  }
}
else 
{
 // No result, then we return the -1.
 $json = array("examID" => "-1");
}
echo json_encode($json);

mysqli_close($connection);

?>