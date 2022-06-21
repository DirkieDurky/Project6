<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=project-6", "root", "");
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}