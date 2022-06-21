<?php
     header('Content-Type: application/json');
     
	include_once("functions.php");
	
	$pincode = $_POST["PINCode"] ?? $_GET["pin"] ?? NULL;
	
	if (isset($pincode)) {
		try 
		{    $db = ConnectDB();
		  $sql = "   SELECT Lat, Lon
					   FROM trackers
					  WHERE PINCode = " . $pincode . "
				   ORDER BY Time";

		  $query = $db->prepare($sql);
		  $query->execute();
		  $data = $query->fetchAll(PDO::FETCH_ASSOC);
		  echo json_encode($data);
		} 
		catch(PDOException $message) 
		{    echo $message->getMessage();
		}
	}
?>