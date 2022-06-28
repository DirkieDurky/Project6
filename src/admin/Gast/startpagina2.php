<?php
require_once "../../DB_Connection.php";
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
		.mySlides {
			display: none;
		}
	</style>
</head>

<body>
	<header>
		<div class="container"></div>
		<form action="../../account/logOut" method="post">
			<input class="uitloggen" type="submit" value="Uitloggen">
			
		</form>
<div class="container"></div>
		<input class="inlogscherm" disabled>
		<input class="ingelogd-als" value="Ingelogd als:" disabled>
		<input class="klant" value="Klant" disabled>
		<input class="mijn-donkey-travel" value="Mijn Donkey Travel" disabled>
		<img src="images/donkeytravellogo.png" alt="logo">
		<input class="trademark" value="© 2022, Donkey travel" disabled>
		
	</header>

	<main>
		<div class="container">
			<input class="balk" disabled>
			<input class="mijn_persoonsgegevens" value="Mijn persoonsgegevens" disabled>
			<input class="overzichtscherm" disabled>
		</div>

		<table class= "table1-2">
			<tr class= "tablerow1-2">
				<th>Naam</th>
			</tr>
		</table>

</body>
</html>