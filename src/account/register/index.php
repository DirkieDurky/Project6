<?php
session_start();
include "../extend.php";
?>
<html lang="nl">

<head>
    <title>Account maken</title>
    <link rel=stylesheet href="../style.css">
</head>

<body id="createAccount">
    <div class="grid">
        <a class="backButton" id="createAccount" href="../logIn">Terug</a>
        <div class="field <?php if (isset($_SESSION['error']) && $_SESSION['error'] != "") {
                                echo "extend";
                            } ?>" id=createAccount>
            <h1>Account aanmaken</h1>
            <form action="createAccount.php">
                <label>
                    Naam:<br>
                    <input placeholder="Naam" type="text" name="name" value="<?= isset($_SESSION['creAccFirst']) ? $_SESSION['creAccFirst'] : "" ?>"><br>
                </label>
                <label>
                    Email:<br>
                    <input placeholder="Email" type="text" name="email" value="<?= isset($_SESSION['creAccEmail']) ? $_SESSION['creAccEmail'] : "" ?>"><br>
                </label>
                <label>
                    Telefoonnummer:<br>
                    <input placeholder="Telefoonnummer" type="text" name="phonenum" value="<?= isset($_SESSION['creAccNum']) ? $_SESSION['creAccNum'] : "" ?>"><br>
                    <label>
                        Wachtwoord:<br>
                        <input placeholder="Wachtwoord" type="password" name="pass"><br>
                    </label>
                    <label>
                        Herhaal wachtwoord:<br>
                        <input placeholder="Herhaal wachtwoord" type="password" name="repass"><br>
                    </label>
                    <input class="submit" type="submit" value="Account aanmaken">
            </form>
            <h4 class="error" id="createAccount"><?php if (isset($_SESSION['error'])) {
                                                        echo $_SESSION['error'];
                                                        unset($_SESSION['error']);
                                                    } ?></h4>
        </div>
    </div>
</body>

</html>