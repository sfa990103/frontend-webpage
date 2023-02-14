<?php
$id=$_POST["id"];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zipit";
$conn = new mysqli($servername, $username, $password,$dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT COUNT(apid) FROM radcheck WHERE apid=".$id;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
	$num=$row["COUNT(apid)"];
  }
}
$conn->close();
echo 'You have '.$num.' devices linked. <a href="manage.html">Manage Them.</a>';
?>
