<?php
include('../DB_Connection.php');

$sth = $pdo->prepare("SELECT * FROM `boekingen`");
$sth->execute();

while ($row = $sth->fetch()) {
    if (isset($_GET['delete' . $row['ID']])) {
        echo "DELETE FROM `boekingen` WHERE `ID` = " . $row['ID'];
        $sth2 = $pdo->prepare("DELETE FROM `boekingen` WHERE `ID` = ?");
        $sth2->execute([$row['ID']]);
    }
}

header("Location: index.php");
