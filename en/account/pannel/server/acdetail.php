<?php
$ac=$_POST["ac"];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zipit";
$conn = new mysqli($servername, $username, $password,$dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT id, plan, expired_date FROM ap WHERE apname='".$ac."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
	$id=$row["id"]; 
	$plan=$row["plan"];
	$expired_date=$row["expired_date"];
  }
}
switch($plan){
	case "a":
		$plan="HKiersVPN Starter Yearly";
		$max_devices="1";
		break;
	case "b":
		$plan="HKiersVPN Basic Yearly";
		$max_devices="3";
		break;
	case "c":
		$plan="HKiersVPN Pro Yearly";
		$max_devices="5";
		break;
	case "d":
		$plan="HKiersVPN Starter Monthly";
		$max_devices="1";
		break;
	case "e":
		$plan="HKiersVPN Basic Monthly";
		$max_devices="3";
		break;
	case "f":
		$plan="HKiersVPN Pro Monthly";
		$max_devices="5";
		break;
	case "u";
		$plan="HKiersVPN Admin";
		$max_devices="10";
		break;
	default:
		$plan="404";
		$max_devices="0";
		break;
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
$data = array("plan" => $plan, "expired_date" => $expired_date, "num" => $num, "max_device" => $max_devices);
echo json_encode($data);
?>