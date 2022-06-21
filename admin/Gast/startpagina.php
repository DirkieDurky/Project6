<?php
//$servername = "localhost"; 
//$username = "username"; 
//$password = "password";


function pdo_connect_mysql() {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'project6';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	exit('Failed to connect to database!'); 
    }
}

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

		<div class="uitloggen">
				<div class = "col-xl-9">
					<form action="../account/logOut" method="post">
          	<input class="uitloggen" type="submit" value="Uitloggen">
          </form>
</div>

<div class="title">
			<div class="container">
  			<a class="title" href="#">Klantenoverzicht</a>
</div>


		

</header>

</body>
</html>





