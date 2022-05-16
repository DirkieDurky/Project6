<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=desplinterrekenen", "root", "");
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}