<?php
$id=$_POST["id"];
$server=$_POST["server"];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zipit";
$conn = new mysqli($servername, $username, $password,$dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT name, img, address, connected, max_load FROM server WHERE id=".$server;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
	$name=$row["name"];
	$img=$row["img"];
	$address=$row["address"];
	$connected=$row["connected"];
	$max_load=$row["max_load"];  
  }
}
$max_load = ($connected/$max_load)*100;
$max_load = intval($max_load);
$connected++;
$sql = "UPDATE server SET connected=".$connected." WHERE id=".$server;
if ($conn->query($sql) === TRUE) {
} else {
  echo "Error updating record: " . $conn->error;
}
$length="32";
$keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$pw = '';
$flag=0;
while($flag==0){
	$ac = '';
	$max = mb_strlen($keyspace, '8bit') - 1;
    if ($max < 1) {
        throw new Exception('$keyspace must be at least two characters long');
    }
    for ($i = 0; $i < $length; ++$i) {
        $ac .= $keyspace[random_int(0, $max)];
   }
	$sql = "SELECT username FROM radcheck WHERE username='".$ac."'";
	$result = $conn->query($sql);
	if ($result->num_rows == 0) {
		$flag=1;
	}
}
$max = mb_strlen($keyspace, '8bit') - 1;
    if ($max < 1) {
        throw new Exception('$keyspace must be at least two characters long');
    }
    for ($i = 0; $i < $length; ++$i) {
        $pw .= $keyspace[random_int(0, $max)];
   }
$sql = "select u1.id + 1 as start from radcheck as u1 left outer join radcheck as u2 on u1.id + 1 = u2.id where u2.id is null";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
	$start=$row["start"];
  }
}
$sql = "INSERT INTO radcheck (id, username, attribute, op, value, apid) VALUES ('".$start."', '".$ac."', 'Cleartext-Password', ':=', '".$pw."', '".$id."')";
if ($conn->query($sql) === TRUE) {
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
echo '<div class="row justify-content-center">
				<div class="col-7 col-lg-3 countryname">
				<img src="country/'.$img.'.png" alt="'.$name.'"> '.$name.'
			</div>
				<div class="col-3 col-lg-2">
					Load : <br>'.$max_load.'%
				</div>
			</div>
			<br>
			<div class="row justify-content-center">
				<div class="col-lg-4 col-10">
					<div class="col-lg-12 col-12 wrapper" id="ser"><div class="name" id="sername">Server Address</div><div class="input" id="serin">'.$address.'</div></div>
							<div class="col-lg-10 col-10 aution" id="serau"><br></div>
				</div>
			</div>	
			<div class="row justify-content-center">
				<div class="col-lg-4 col-10">
					<div class="col-lg-12 col-12 wrapper" id="ac"><div class="name" id="acname">ID</div><div class="input" id="acin">'.$ac.'</div></div>
							<div class="col-lg-10 col-10 aution" id="acau"><br></div>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-lg-4 col-10">
					<div class="col-lg-12 col-12 wrapper" id="pw"><div class="name" id="pwname">Password</div><div class="input" id="pwin">'.$pw.'</div></div>
							<div class="col-lg-10 col-10 aution" id="pwau"><br></div>
				</div>
			</div>';
?>
