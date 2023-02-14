<?php
$ac=$_POST["ac"];
$newac=$_POST["newac"];
$pw=$_POST["pw"];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zipit";
$conn = new mysqli($servername, $username, $password,$dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT appass FROM ap WHERE apname='".$ac."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
	$appw=$row["appass"];
  }
}
if(!password_verify($pw, $appw)){
	die("Error");
}
$sql = "UPDATE ap SET apname='".$newac."' WHERE apname='".$ac."'";
if ($conn->query($sql) === TRUE) {
	echo "sucess";
} 
else {
  echo "Error updating record: " . $conn->error;
}
$conn->close();
?>