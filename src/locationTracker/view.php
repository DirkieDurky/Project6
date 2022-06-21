<?php

$pin = -1;
$route = NULL;
$viewguesttrackers = -1;
if (isset($_GET["PINCode"]))
{    $pin = $_GET["PINCode"];
}
if (isset($_GET["RouteName"]))
{    $route = $_GET["RouteName"];
}
if (isset($_GET["VGT"]))
{    $viewguesttrackers = 1;
}

if ($route) 
{    $content = '
     <body onload="Init()">
          <div id="map">
          </div>
         <div id="status">
              <span id="tijd"></span>&nbsp;
              <span id="messages"></span>&nbsp;
              <span id="action"></span>&nbsp;
              <span id="error"></span>
         </div>
     </body>';
}
else
{    $content = '  
     <body>
          <header>
               Donkey Travel Locatietracker
          </header>
          
          <section>
               <article>
                    <div id="map">
                         <p>Routenaam is ongeldig, 
                         </p>
                    </div>
               </article>
          </section>
          <footer>
               <span>&nbsp;</span>
          </footer>
     </body>';
}


echo '
     <!DOCTYPE html>
     <html lang="nl">
     <head>
          <title>Donkey Travel Locatietracker</title>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <script
			  src="https://code.jquery.com/jquery-3.6.0.js"
			  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
			  crossorigin="anonymous"></script>
          <script type="application/javascript" src="locviewer.js?' . mt_rand() . '"></script>
       	<script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.14.1/build/ol.js"></script>
          <link href="vstyle.css" type="text/css" rel="stylesheet"/>
       	<script>
       	     var PINCode = "' . $pin . '";
       	     var RouteName = "' . $route . '";
       	     var VGT = "' . $viewguesttrackers . '";
       	</script>
     </head>' .
     $content .
     '</html>';
?>

