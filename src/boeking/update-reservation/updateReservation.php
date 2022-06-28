<?php
session_start();
require_once "../../DB_Connection.php";

$sth = $pdo->prepare("UPDATE `boekingen` SET `StartDatum` = ?, `FKtochtenID` = ?, `FKstatussenID` = ? WHERE ID = ?");
$sth->execute([$_GET['startDate'], $_GET['tour'], $_GET['status'], $_GET['ID']]);

if ($sth->rowCount() > 0) {
    $_SESSION['reservationError'] = "Sorry! Er ging iets mis met het bijwerken van uw boeking. Probeer het later opnieuw.";
} else {
    $_SESSION['success'] = true;
}
header("Location: ../index.php?selected=update-reservation&resId={$_GET['ID']}");
