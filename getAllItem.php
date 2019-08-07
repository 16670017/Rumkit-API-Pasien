<?php

include('dbconn.php');
 
 	$query = "SELECT * FROM pasien";
 	$exeQuery = mysqli_query($db, $query);

 	$array = array();
	while ($data = mysqli_fetch_assoc($exeQuery)) {
				$array[]=$data;
	}

 	
	$response["error"] = false;
	$response["items"] = $array;
	echo json_encode($response);

?>