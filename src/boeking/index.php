<?php
session_start();
require_once "../DB_Connection.php";
$sth = $pdo->prepare("SELECT * FROM `klanten` WHERE `ID` = ?");
$sth->execute([$_SESSION['loggedID']]);
$row = $sth->fetch();

$namelogin = $row['Naam'];
?>

<!DOCTYPE html>
<html lang="nls">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../grid.css" rel="stylesheet" type="text/css">
    <link href="../style.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <title>Boeking</title>
</head>

<body>
    <header>
        <div class="container">
            <div class="col-xl-12">
                <div class="col-xl-3 ">
                    <form action="../account/logOut" method="post">
                        <input class="uitloggen" type="submit" value="Uitloggen">
                    </form>
                </div>
                <div class="col-xl-9">
                    <div class="ingelogd-als">
                        <div class="col-xl-4 login-naam">ingelogd als:<br><?php echo $namelogin ?></div>
                            <div class="lijn"></div>
                        <h1 class="title">Mijn Donkey Travel</h1>                                                       
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main>
        <?php
        switch ($_GET['selected']) {
            case "overview":
                include "overview/index.php";
                break;
            case "create-reservation":
                include "create-reservation/index.php";
                break;
            case "update-reservation":
                include "update-reservation/index.php";
                break;
        }
        ?>
    </main>
</body>

</html>
