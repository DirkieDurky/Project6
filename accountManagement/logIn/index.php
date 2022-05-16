<?php
session_start();
include "../extend.php";
require_once "../DB_Connection.php";
$_SESSION['count'] = 0;
if (isset($_COOKIE['loginEmail'])) {
    $sth = $pdo -> prepare("SELECT * FROM `accounts` WHERE Email=?");
    $sth -> execute([$_COOKIE['loginEmail']]);
    $row = $sth -> fetch();
    $_SESSION['loggedID'] = $row['id'];
    if ($row['teacher'] == FALSE) {
        header("Location: ../Student/studentSite.php?selected=1");
        exit();
    } else {
        header("Location: ../teacher/teacherSite.php?selected=1");
        exit();
    }
}
?>
<html lang="nl">
<head>
    <title>Inloggen</title>
    <link href=../style.css rel=stylesheet>
</head>
<body id="logIn">
<div class="field <?= isset($_SESSION['error']) && $_SESSION['error']!="" ? "extend" : ""?>" id="logIn">
    <h1>Inloggen bij Mijn Donkey Travel</h1><br>
    <form action="logIn.php">
        <div class=name>
            <label>
                Email:<br>
                <input class="input" name="email" placeholder="Email" type="text" value="<?= (isset($_SESSION['logInEmail'])) ? $_SESSION['logInEmail'] : ""?>">
            </label><br>
        </div>
        <div class=pass>
            <label>
                Wachtwoord:<br>
                <input class="input" name="pass" placeholder="Wachtwoord" type="password">
            </label><br>
        </div>
        <label>
            Onthoud mijn gevens
            <input type="checkbox" name="rememberMe">
        </label><br>
        <input class="submit" name="submit" type="submit" value="Inloggen"><br>
    </form>
    <a class="hyperlinks" href="../register">Ik heb nog geen account</a>
    <h4 class="error" id="logIn"><?php if(isset($_SESSION['error'])){echo $_SESSION['error']; unset($_SESSION['error']);}?></h4>
</div>
</body>
</html>