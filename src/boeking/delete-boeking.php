<?php
include('../DB_Connection.php');

$sth2 = $pdo->prepare("DELETE FROM `boekingen` WHERE `ID` = ?");
$sth2->execute([$_GET['delete']]);

header("Location: index.php?selected=overview");
