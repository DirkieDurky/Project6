<?php
require_once "../DB_Connection.php";
// session_start();
$_SESSION['reservationError'] = "";
$_SESSION['success'] = false;
?>
<!DOCTYPE html>
<html lang="nls">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../grid.css" rel="stylesheet" type="text/css">
    <link href="../../src/style.css" rel="stylesheet" type="text/css">
    <link href="create-reservation/style.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <title>Boeking aanmaken</title>
</head>

<body>
    <div class="test"></div>
    <div class="row main col-xl-12">
        <div class="col-xl-1"></div>
        <div class="col-xl-9">
            <div class="boeking-title">
                <h2>Boeking aanmaken:</h2>
            </div>
            <div class="col-xl-12 boeking">
                <form action="create-reservation/createReservation.php" class="reservationForm">
                    <div class="startDate">
                        <label>
                            Startdatum:<br>
                            <input name="startDate" placeholder="Startdatum" type="date">
                        </label><br>
                    </div>
                    <div class="tour">
                        <label>
                            Tocht:<br>
                            <select name="tour">
                                <?php
                                $sth = $pdo->prepare("SELECT `ID`,`Route` FROM `tochten`");
                                $sth->execute();
                                while ($result = $sth->fetch()) {
                                    echo "<option value='{$result['ID']}'>{$result['Route']}</option>";
                                }
                                ?>
                            </select>
                        </label><br>
                    </div>
                    <div class="status">
                        <label>
                            Status:<br>
                            <select name="status">
                                <?php
                                $sth2 = $pdo->prepare("SELECT `ID`,`Status` FROM `statussen`");
                                $sth2->execute();
                                while ($result = $sth2->fetch()) {
                                    echo "<option value='{$result['ID']}'>{$result['Status']}</option>";
                                }
                                ?>
                            </select>
                        </label><br>
                    </div>
                    <div class="container">
                        <input name=" submit" value="Boeken" type="submit">
                        <a class="backButton" href="index.php?selected=overview">Terug</a>
                    </div>
                </form>
                <span class="errorMessage">
                    <?php
                    echo $_SESSION['reservationError'];
                    $_SESSION['reservationError'] = "";
                    ?>
                </span>
                <span class="successMessage">
                    <?php
                    if ($_SESSION['success']) {
                        echo "Uw boeking is successvol aangemaakt!";
                        $_SESSION['success'] = false;
                    }
                    ?>
                </span>
            </div>
        </div>
    </div>


</body>