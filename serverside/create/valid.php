<?php
$servername = "localhost";
$username = "jqdnPISt0YvNpd8f";
$password = "KwjOP9iooLKFVOtw";
$dbname = "zipit";
$data = $_POST['data'];
$value = $_POST['value'];
$flag = "true";

// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT ".$value." FROM radcheck";
if($value=="apname"){
	$data=hash('sha256', $data);
}
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
	if($row[$value]==$data){
		$flag="false";
	}
  }
}
$conn->close();
echo $flag;
?>