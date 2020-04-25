<?php
include "db.php";

function NTLMHash($Input)
{
// Convert the password from UTF8 to UTF16 (little endian)
$Input = iconv('UTF-8', 'UTF-16LE', $Input);

// Encrypt it with the MD4 hash
$MD4Hash = bin2hex(mhash(MHASH_MD4, $Input));

// You could use this instead, but mhash works on PHP 4 and 5 or above
// The hash function only works on 5 or above
//$MD4Hash=hash('md4',$Input);

// Make it uppercase, not necessary, but it's common to do so with NTLM hashes
$NTLMHash = strtoupper($MD4Hash);

// Return the result
return ($NTLMHash);
}

$username = $_POST['username'];

$password = NTLMHash($_POST['password']);

$result = mysqli_query($connection, "SELECT * FROM CS490_users WHERE username = '$username' AND password = '$password' ");

if (mysqli_num_rows($result) == 0) 
{
  $json = array("output" => "0", "role" => "false");
} 
else 
{
  $row = mysqli_fetch_assoc($result);
  $json = array("output" => "1", "role" => $row["status"]);
}
echo json_encode($json);
?>


