<?php
session_start();
require_once "../DB_Connection.php";
$_SESSION['appMan'] = 0;
unset($_SESSION['error']);
$_SESSION['errorLength'] = 0;

$_SESSION['signInPass'] = $_GET['pass'];
$_SESSION['signInEmail'] = $_GET['email'];

$sth = $pdo -> prepare("SELECT * FROM `accounts` WHERE email=?");
$sth -> execute([$_GET['email']]);
$row = $sth -> fetch();

$_SESSION['loggedID'] = $row['id'];

if ($_GET['email'] == "") {
        $_SESSION['error'] .= "Geen email ingevoerd.<br>";
        unset($_SESSION['signInEmail']);
    } elseif ($row['email'] == "") {
        $_SESSION['error'] .= "Er bestaat geen account dat deze email gebruikt.<br>";
        unset($_SESSION['signInEmail']);
    }
    if ($_GET['pass'] == "") {
        $_SESSION['error'] .= "Geen wachtwoord ingevoerd.<br>";
        unset($_SESSION['signInPass']);
    } elseif (!password_verify($_GET['pass'],$row['password']) && $row != "") {
        $_SESSION['error'] .= "Uw wachtwoord is onjuist.<br>";
        unset($_SESSION['signInPass']);
    }

    if ($_SESSION['error'] != "") {
        $_SESSION['errorLength'] = substr_count($_SESSION['error'], "<br>");
        $_SESSION['extendHeight'] = 450 + ($_SESSION['errorLength'] * 24);
        echo $_SESSION['error'];
        header("Location: signIn.php");
        exit();
    } else {
        if ($_GET['rememberMe'] == TRUE){
            setcookie("loginEmail", $_GET['email'], time() + 2592000, "/");
        }
        if ($row['teacher'] == 0) {
            header("Location: ../Student/studentSite.php?selected=1");
            exit();
        } else {
            header("Location: ../teacher/teacherSite.php?selected=1");
            exit();
        }
    }