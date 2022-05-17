<?php
session_start();
require_once "../DB_Connection.php";
unset($_SESSION['error']);
$_SESSION['errorLength'] = 0;

$_SESSION['creAccFirst'] = $_GET['name'];
$_SESSION['creAccEmail'] = $_GET['email'];
$_SESSION['creAccNum'] = $_GET['phonenum'];
$_SESSION['creAccPass'] = $_GET['pass'];
$_SESSION['creAccRepass'] = $_GET['repass'];

if ($_GET['name'] == ""){
    $_SESSION['error'] .= "Geen voornaam ingevoerd.<br>";
    unset($_SESSION['creAccFirst']);
} else if (!preg_match('/^[a-zA-Z \.]+$/', $_GET['name'])){
    $_SESSION['error'] .= "Voornaam is niet geldig.<br>";
    unset($_SESSION['creAccFirst']);
}
if ($_GET['email'] == ""){
    $_SESSION['error'] .= "Geen email ingevoerd.<br>";
    unset($_SESSION['creAccEmail']);
} else if (!filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] .= "Email is niet geldig.<br>";
        unset($_SESSION['creAccEmail']);
    } else {
        $sth = $pdo -> prepare("SELECT * FROM `klanten` WHERE email=?");
        $sth -> execute([$_GET['email']]);
        $row = $sth -> fetch();
        if ($row != "") {
            $_SESSION['error'] .= "Er bestaat al een ander account dat dit email gebruikt.<br>";
            unset($_SESSION['creAccEmail']);
        }
    }
if ($_GET['phonenum'] == ""){
    $_SESSION['error'] .= "Geen telefoonnummer ingevoerd.<br>";
    unset($_SESSION['creAccNum']);
} else if (!preg_match('/^\d{10,11}$/', $_GET['phonenum'])){
    $_SESSION['error'] .= "Telefoonnummer is niet geldig.<br>";
    unset($_SESSION['creAccNum']);
}
if ($_GET['pass'] == ""){
    $_SESSION['error'] .= "Geen wachtwoord ingevoerd.<br>";
} else {
    if (!preg_match('@[A-Z]@', $_GET['pass'])) {
        $_SESSION['error'] .= "Wachtwoord moet minstens 1 hoofdletter bevatten.<br>";
    }
    if (!preg_match('@[a-z]@', $_GET['pass'])) {
        $_SESSION['error'] .= "Wachtwoord moet minstens 1 kleine letter bevatten.<br>";
    }
    if (!preg_match('@[0-9]@', $_GET['pass'])) {
        $_SESSION['error'] .= "Wachtwoord moet minstens 1 cijfer bevatten.<br>";
    }
    if (!preg_match('@[^\w]@', $_GET['pass'])) {
        $_SESSION['error'] .= "Wachtwoord moet minstens 1 speciaal karakter bevatten.<br>";
    }
    if (strlen($_GET['pass'])<8){
        $_SESSION['error'] .= "Wachtwoord moet minstens 8 karakters bevatten.<br>";
    }
    if ($_GET['pass']!=$_GET['repass']){
        $_SESSION['error'] .= "Wachtwoorden komen niet overeen.<br>";
    }
    unset($_SESSION['creAccPass']);
    unset($_SESSION['creAccRepass']);
}

$_SESSION['errorLength'] = substr_count($_SESSION['error'],"<br>");

if ($_SESSION['error']!=""){
    $_SESSION['extendHeight'] = $_SESSION['createAccFieldDefaultLength'] + ($_SESSION['errorLength'] * $_SESSION['lineHeight']);
    header("Location: index.php");
    exit();
} else {
    $pass = password_hash($_GET['pass'],PASSWORD_DEFAULT);

    $sth = $pdo -> prepare("INSERT INTO `klanten` (`Naam`,`Email`,`Telefoon`,`Wachtwoord`) VALUES (?,?,?,?);");
    $sth -> execute([$_GET['name'], $_GET['email'], $_GET['phonenum'], $pass]);

    $sth = $pdo -> prepare("SELECT `ID` FROM `klanten` WHERE email=?");
    $sth -> execute([$_GET['email']]);
    $row = $sth -> fetch();

    if (!isset($row['ID'])) {
        $_SESSION['error'] .= "Er ging aan onze kant iets mis bij het maken van je account, sorry! Probeer het later opnieuw.<br>";
        $_SESSION['extendHeight'] = $_SESSION['createAccFieldDefaultLength'] + 40;
        header("Location: createAccount.php");
        exit();
    }

    $_SESSION['loggedID'] = $row['id'];

    header("Location: ../../index.php");
    exit();
}