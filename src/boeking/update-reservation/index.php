<?php
require_once "../DB_Connection.php";
session_start();
$_SESSION['reservationError'] = "";
$_SESSION['success'] = false;

$sth = $pdo->prepare("SELECT `boekingen`.`StartDatum`,`tochten`.`Route`,`statussen`.`Status` FROM `boekingen`
LEFT JOIN `tochten` ON `boekingen`.`FKtochtenID` = `tochten`.`ID`
LEFT JOIN `statussen` ON `boekingen`.`FKstatussenID` = `statussen`.`ID`
WHERE `boekingen`.`ID` = ?");
$sth->execute([$_GET['resId']]);
$result = $sth->fetch();
?>
<!DOCTYPE html>
<html lang="nls">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/src/grid.css" rel="stylesheet" type="text/css">
    <link href="/src/style.css" rel="stylesheet" type="text/css">
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
                <form action="update-reservation/updateReservation.php" class="reservationForm">
                    <input type="hidden" name="ID" value=<?= $_GET['resId'] ?> />
                    <div class="startDate">
                        <label>
                            Startdatum:<br>
                            <input name="startDate" placeholder="Startdatum" type="date" value="<?= $result['StartDatum'] ?>">
                        </label><br>
                    </div>
                    <div class="tour">
                        <label>
                            Tocht:<br>
                            <select name="tour">
                                <?php
                                $sth = $pdo->prepare("SELECT `ID`,`Route` FROM `tochten`");
                                $sth->execute();
                                while ($tourResult = $sth->fetch()) {
                                    $selected = "";
                                    if ($result['Route'] == $tourResult['Route']) $selected = "selected='selected'";
                                    echo "<option value='{$tourResult['ID']}' $selected>{$tourResult['Route']}</option>";
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
                                while ($statusResult = $sth2->fetch()) {
                                    $selected = "";
                                    if ($result['Status'] == $statusResult['Status']) $selected = "selected='selected'";
                                    echo "<option value='{$statusResult['ID']}' $selected>{$statusResult['Status']}</option>";
                                }
                                ?>
                            </select>
                        </label><br>
                    </div>
                    <input name="submit" value="Boeken" type="submit">
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