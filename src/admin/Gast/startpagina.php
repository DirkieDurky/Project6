<?php
//$servername = "localhost"; 
//$username = "username"; 
//$password = "password";

require_once "../../DB_Connection.php";
/*try {
	$conn = new PDO("mysql:host=$servername;dbname=project6"); 
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "Connectie succesvol"; 
} catch (Exception $e) {
	echo "Connectie gefaald: " . $e->getMessage(); 
}
*/
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>gast overzicht</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
			<meta charset="utf-8">
			<title>Project 6 Donkey Travel</title>
			<link rel="stylesheet" type="text/css" href="css/style.css">
			<link rel="stylesheet" type="text/css" href="css/grid.css">
			<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
			<style>
			.mySlides {display:none;}
			</style>
</head>

<body>
	<header>
			<div class = "container"></div> 
						<form action=".../account/logOut/index.php" method="post">
          				<input class="uitloggen" type="submit" value="Uitloggen">
          				</form>
          					<input class= "inlogscherm">
          						<input class= "ingelogd-als" value="Ingelogd als:">
          						<input class= "medewerker" value="Medewerker">
          						<input class= "mijn-donkey-travel" value="Mijn Donkey Travel">
					</div>
	</header>

	<main>					
			<div class="container">
				<input class="balk">
  					<input class="klantenoverzicht" value="klantenoverzicht">
  				<input class="overzichtscherm"> 	
			</div>
	<main>
	
</body>
</html>
