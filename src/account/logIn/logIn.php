<?php
session_start();
require_once "../DB_Connection.php";
$_SESSION['appMan'] = 0;
unset($_SESSION['error']);
$_SESSION['errorLength'] = 0;

$_SESSION['logInPass'] = $_GET['pass'];
$_SESSION['logInEmail'] = $_GET['email'];

$sth = $pdo -> prepare("SELECT `ID`, `Wachtwoord` FROM `klanten` WHERE email=?");
$sth -> execute([$_GET['email']]);
$row = $sth -> fetch();

$_SESSION['loggedID'] = $row['ID'];
$emailCorrect = false;

if ($_GET['email'] == "") {
    $_SESSION['error'] .= "Geen email ingevoerd.<br>";
    unset($_SESSION['logInEmail']);
} else if ($row['ID'] == "") {
    $_SESSION['error'] .= "Er bestaat geen account dat deze email gebruikt.<br>";
    unset($_SESSION['logInEmail']);
} else {
    $emailCorrect = true;
}

if ($_GET['pass'] == "") {
    $_SESSION['error'] .= "Geen wachtwoord ingevoerd.<br>";
    unset($_SESSION['logInPass']);
} elseif (!password_verify($_GET['pass'],$row['Wachtwoord']) && $emailCorrect) {
    $_SESSION['error'] .= "Uw wachtwoord is onjuist.<br>";
    unset($_SESSION['logInPass']);
}

if ($_SESSION['error'] != "") {
    $_SESSION['errorLength'] = substr_count($_SESSION['error'], "<br>");
    $_SESSION['extendHeight'] = $_SESSION['logInFieldDefaultLength'] + ($_SESSION['errorLength'] * $_SESSION['lineHeight']);
    echo $_SESSION['error'];
    header("Location: index.php");
    exit();
} else {
    if ($_GET['rememberMe'] == TRUE){
        setcookie("loginEmail", $_GET['email'], time() + 2592000, "/");
    }

    header("Location: ../../index.php");
    exit();
}