<?php
session_start();
include "../extend.php";
require_once "../../DB_Connection.php";
$_SESSION['count'] = 0;
if (isset($_COOKIE['loginID'])) {
    $sth = $pdo->prepare("SELECT * FROM `klanten` WHERE `ID` = ?");
    $sth->execute([$_COOKIE['loginID']]);
    $row = $sth->fetch();
    $foundUser = $row;
    if ($foundUser['Token'] == $_COOKIE['token']) {
        $_SESSION['loggedID'] = $foundUser['ID'];
        header("Location: ../../");
        exit();
    }
}
?>
<html lang="nl">

<head>
    <title>Inloggen</title>
    <link href=../style.css rel=stylesheet>
    <link href=../../style.css rel=stylesheet>
</head>

<body id="logIn">
    <h1>Inloggen bij Mijn Donkey Travel</h1><br>
    <div class="field <?= isset($_SESSION['error']) && $_SESSION['error'] != "" ? "extend" : "" ?>" id="logIn">
        <form action="logIn.php">
            <div class=email>
                <label>
                    Email:<br>
                    <input class="input" name="email" placeholder="Email" type="text" value="<?= (isset($_SESSION['logInEmail'])) ? $_SESSION['logInEmail'] : "" ?>">
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
        <h4 class="error" id="logIn">
            <?php if (isset($_SESSION['error'])) {
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            } ?></h4>
    </div>
</body>

</html>