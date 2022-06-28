<?php
session_start();
require_once "../../DB_Connection.php";

$pin = rand(10000, 99999);
$sth2 = $pdo->prepare("SELECT `ID` FROM `boekingen` WHERE Pincode=?");
$sth2->execute([$pin]);
while ($sth2->fetch()) {
    $pin++;
    $sth2 = $pdo->prepare("SELECT `ID` FROM `boekingen` WHERE Pincode=?");
    $sth2->execute([$pin]);
}

// echo "INSERT INTO `boekingen` (`StartDatum`,`Pincode`,`FKtochtenID`,`FKklantenID`,`FKstatussenID`) VALUES ({$_GET['startDate']},{$pin},{$_GET['tour']},{$_SESSION['loginID']},{$_GET['status']});";
$sth = $pdo->prepare("INSERT INTO `boekingen` (`StartDatum`,`Pincode`,`FKtochtenID`,`FKklantenID`,`FKstatussenID`) VALUES (?,?,?,?,?);");
$sth->execute([$_GET['startDate'], $pin, $_GET['tour'], $_SESSION['loginID'], $_GET['status']]);

$sth3 = $pdo->prepare("SELECT `ID` FROM `boekingen` WHERE `ID` = ?");
$sth3->execute([$pdo->lastInsertId()]);
if ($sth3->fetch()) {
    $_SESSION['reservationError'] = "Sorry! Er ging iets mis met het toevoegen van uw boeking. Probeer het later opnieuw.";
} else {
    $_SESSION['success'] = true;
}
header("Location: ../index.php?selected=create-reservation");
