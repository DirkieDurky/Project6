<!DOCTYPE html>
<html lang="en">

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
                        <div class="lijn"></div>
                        <div class="title">
                            <h1>Mijn Donkey Travel</h1>
                        </div>
                    </div>
                    <div class="account-boeking">

                    </div>
                </div>

            </div>
        </div>
    </header>
    <main>
        <div class="row main col-xl-12">
            <div class="col-xl-1"></div>
            <div class="col-xl-9">
                <div class="boeking-title">
                    <h2>Boeking overzicht:</h2>
                </div>
                <div class="col-xl-12 boeking">
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
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>


            </div>
            <div class="col-xl-2"></div>
        </div>
    </main>

</body>

</html>