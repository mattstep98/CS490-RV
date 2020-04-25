<?php
include "db.php";
$result = mysqli_query($connection, "SELECT  username FROM CS490_users WHERE role = 'student'");
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
 $json = array("message" => "No Students");
}
echo json_encode($json);

mysqli_close($connection);

?>