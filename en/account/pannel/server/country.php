<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zipit";
$conn = new mysqli($servername, $username, $password,$dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM server";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
	$i=0;
  while($row = $result->fetch_assoc()) {
	$id[$i]=$row["id"];
	$name[$i]=$row["name"];
	$img[$i]=$row["img"];
	$address[$i]=$row["address"];
	$connected[$i]=$row["connected"];
	$max_load[$i]=$row["max_load"];
	$i++;
  }
}
$conn->close();
for($x=0;$x<$i-1;$x++){
	for($y=$x+1;$y<$i-1;$y++){
		if($name[$x]==$name[$y]&&$x!=$y&&$connected[$x]/$max_load[$x]<$connected[$y]/$max_load[$y]){
			$connected[$x]=$connected[$x]+$connected[$y];
			$max_load[$x]=$max_load[$x]+$max_load[$y];
			array_splice($name,$y,$y);
			array_splice($img,$y,$y);
			array_splice($address,$y,$y);
			array_splice($id,$y,$y);
			array_splice($connected,$y,$y);
			array_splice($max_load,$y,$y);
		}
		else if($name[$x]==$name[$y]&&$x!=$y&&$connected[$y]/$max_load[$y]<$connected[$x]/$max_load[$x]){
			$connected[$y]=$connected[$x]+$connected[$y];
			$max_load[$y]=$max_load[$x]+$max_load[$y];
			array_splice($name,$x,$x);
			array_splice($img,$x,$x);
			array_splice($address,$x,$x);
			array_splice($id,$x,$x);
			array_splice($connected,$x,$x);
			array_splice($max_load,$x,$x);
		}
	}
}
for($x=0;$x < sizeof($name);$x++){
	if($max_load[$x]!=0){
		$max_load[$x] = ($connected[$x]/$max_load[$x])*100;
		$max_load[$x] = intval($max_load[$x]);
		if($max_load[$x]<51){
			echo '<tr><td class="country"><img src="country/'.$img[$x].'.png" alt="'.$img[$x].'"> '.$name[$x].'</td><td class="load"><font color="green">Load : '.$max_load[$x].'%</font></td><td class="power"><a href="details.html?server='.$id[$x].'"><i class="fas fa-wifi"></i></a></td></tr>';
		}
		else if($max_load[$x]>50 && $max_load[$x]<80){
			echo '<tr><td class="country"><img src="country/'.$img[$x].'.png" alt="'.$img[$x].'"> '.$name[$x].'</td><td class="load"><font color="yellow">Load : '.$max_load[$x].'%</font></td><td class="power"><a href="details.html?server='.$id[$x].'"><i class="fas fa-wifi"></i></a></td></tr>';
		}
		else{
			echo '<tr><td class="country"><img src="country/'.$img[$x].'.png" alt="'.$img[$x].'"> '.$name[$x].'</td><td class="load"><font color="red">Load : '.$max_load[$x].'%</font></td><td class="power"><a href="details.html?server='.$id[$x].'"><i class="fas fa-wifi"></i></a></td></tr>';
		}
	}
	else{
		echo '<tr><td class="country"><img src="country/'.$img[$x].'.png" alt="'.$img[$x].'"> '.$name[$x].'</td><td class="load"><font color="green">Load : '.$max_load[$x].'%</green></td><td class="power"><a href=""><i class="fas fa-wifi"></i></a></td></tr>';
	}
	
}
?>