<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="">
        <form class="" method="get">
            <input type="text" name="PIN">
            <input type="submit" name="Knop">
        </form>
    </div>
</body>
</html>

<?php
require_once "../DB_Connection.php";
session_start();

$sth = $pdo->prepare("SELECT `Route` FROM `tochten` WHERE `ID` = (SELECT `FKtochtenID` from `boekingen` WHERE `Pincode` = ?");
$sth->execute([$_GET['PIN']]);
$row = $sth->fetch();

$_SESSION['loggedID'] = $row['ID'];

if (isset($_GET['Knop'])){
    if ($_GET['PIN'] == ""){
        echo "Je hebt geen pincode ingevoerd!";
    }
    else if ($row['ID'] == ""){
        echo "Deze Pincode bestaat niet!";
    }
}