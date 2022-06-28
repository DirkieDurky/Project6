<!DOCTYPE html>
<html lang="nls">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/src/grid.css" rel="stylesheet" type="text/css">
    <link href="/src/style.css" rel="stylesheet" type="text/css">
    <link href="./style.css" rel="stylesheet" type="text/css">
    <link href="../css/style.css" rel="stylesheet" type="text/css">
    <title>Boeking overzicht</title>
</head>

<body>
    <div class="account-boeking">

    </div>
    <div class="row main col-xl-12">
        <div class="col-xl-1"></div>
        <div class="col-xl-9">
            <div class="boeking-title">
                <h2>Boeking overzicht:</h2>
            </div>
            <div class="col-xl-12 boeking">
                <form action="delete-boeking.php">
                    <div class="logo col-xl-2">
                        <p class="link-startpagina"><a href="#"><img src="images/donkeytravellogo.png" width="80" height="60"></a></p>
                    </div>
                    <table class="col-xl-10">
                        <tr>
                            <th>Startdatum</th>
                            <th>Einddatum</th>
                            <th>PIN Code</th>
                            <th>Tocht</th>
                            <th>Status</th>
                        </tr>
                        <tr>
                            <?php
                            require_once('../DB_Connection.php');
                            $result = $pdo->prepare("SELECT boekingen.ID, klanten.naam, boekingen.StartDatum, tochten.Omschrijving, statussen.Status 
                                                     FROM boekingen LEFT JOIN klanten ON boekingen.FKklantenID = klanten.ID
                                                                    LEFT JOIN tochten ON boekingen.FKtochtenID = tochten.ID 
                                                                    LEFT JOIN statussen ON boekingen.FKstatussenID = statussen.ID");
                            $result->execute();
                            while ($row = $result->fetch()) {
                            ?>
                        <tr>
                            <td><?php echo $row['StartDatum']  ?></td>
                            <td><?php ?></td>
                            <td><?php ?></td>
                            <td><?php echo $row['Omschrijving'] ?></td>
                            <td><?php echo $row['Status'] ?></td>
                            <td><input type="submit" value="delete" name="delete<?= $row['ID'] ?>"></td>
                        </tr>
                    <?php } ?>
                    </table>
                </form>
            </div>
        </div>
    </div>
</body>