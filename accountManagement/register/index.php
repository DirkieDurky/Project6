<?php
session_start();
include "../Css/extend.php";
?>
<html lang="nl">
<head>
    <title>Account maken</title>
    <link rel=stylesheet href="../Css/style.css">
</head>
<body id="signIn">
<div>
        <a class="backButton" id="createAccount" href="signIn.php">Terug</a>
</div>
<div class="field <?php if (isset($_SESSION['error'])&&$_SESSION['error']!=""){echo "extend";}?>" id=createAccount >
    <h1>Account aanmaken</h1>
    <form action="createAccountBackend.php">
        <label>
        Voornaam:<br>
        <input placeholder="Voornaam" type="text" name="firstname" value="<?= isset($_SESSION['creAccFirst']) ? $_SESSION['creAccFirst'] : ""?>"><br>
        </label>
        <label>
        Achternaam:<br>
        <input placeholder="Achternaam" type="text" name="lastname" value="<?= isset($_SESSION['creAccLast']) ? $_SESSION['creAccLast'] : ""?>"><br>
        <label>
        Email:<br>
        <input placeholder="Email" type="text" name="email" value="<?= isset($_SESSION['creAccEmail']) ? $_SESSION['creAccEmail'] : ""?>"><br>
        </label>
        <label>
        Wachtwoord:<br>
        <input placeholder="Wachtwoord" type="password" name="pass" value="<?= isset($_SESSION['creAccPass']) ? $_SESSION['creAccPass'] : ""?>"><br>
        </label>
        <label>
        Herhaal wachtwoord:<br>
        <input placeholder="Herhaal wachtwoord" type="password" name="repass" value="<?= isset($_SESSION['creAccRepass']) ? $_SESSION['creAccRepass'] : ""?>"><br>
        </label>
        <label class="teacher">
            Ik ben een leerling
            <input type="radio" name="teacher" value=0>
        </label>
        <label class="teacher">
            Ik ben een leraar
            <input type="radio" name="teacher" value=1>
        </label>
        <input class="submit" type="submit" value="Account aanmaken">
    </form>
    <h4 class="error" id="createAccount"><?php if(isset($_SESSION['error'])){echo $_SESSION['error']; unset($_SESSION['error']);}?></h4>
</div>
</body>
</html>