<?php
include_once("functions.php");
require_once("../DB_Connection.php");

$posities = json_decode($_POST["posities"]);
$PINCode = $_POST["PINCode"];
try {
     $sql = "SELECT ID, COUNT(*) AS Aantal 
                    FROM boekingen
                   WHERE PINCode = " . $PINCode;

     $pins = $pdo->query($sql)->fetch();
     $aantal = $pins["Aantal"];

     if ($aantal < 1) {
          echo "Onbekende PIN code";
          return;
     }

     $bid = $pins["ID"];
     foreach ($posities as $pos) {
          $tijd = date('Ymd') . $pos->Tijd;
          $sql = "INSERT 
                         INTO trackers (Lat, Lon, PINCode, Time) 
                       VALUES ('" . $pos->Lat . "', '" . $pos->Lon . "', '" . $PINCode . "', '" . $tijd . "')";
          if ($pdo->query($sql) != true) {
               echo "Error: " . $sql;
               return;
          }
     }
     echo count($posities);
} catch (PDOException $message) {
     echo $message->getMessage();
}
