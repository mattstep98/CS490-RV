<?php
//listStudents.php, Matthew Stepnowski
include "db.php";
$result = mysqli_query($connection, "SELECT  username FROM CS490_users WHERE role = 'student'");
if (mysqli_num_rows($result) > 0){
  $json = array();
  while($row = mysqli_fetch_assoc($result)){
    $json[] = $row;
  }
}
else{
 $json = array("message_type" => "error");
}
echo json_encode($json);
mysqli_close($connection);
?>