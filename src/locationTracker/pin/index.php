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
    <form method="post">
        <input type="submit" name="knop" value="knop">
    </form>
</body>
</html>

<?php
require_once "../../account/DB_Connection.php";
$pin = rand(10000, 99999);

if (isset($_POST['knop'])){
    try {
        $sth = $pdo -> prepare("INSERT INTO `boekingen` (`Pincode`) VALUES (?);");
        $sth -> execute([$pin]);
    }
    catch (PDOException $e) {
        $sth = $pdo -> prepare("SELECT * FROM `boekingen` WHERE Pincode=?");
        $sth -> execute([$pin]);
        $row = $sth -> fetch();

        while ($row = $pin){
            $pin++;
        }

        $sth = $pdo -> prepare("INSERT INTO `boekingen` (`Pincode`) VALUES (?);");
        $sth -> execute([$pin]);
    }
}