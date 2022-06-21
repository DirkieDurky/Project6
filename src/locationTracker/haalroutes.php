<?php
     header("Access-Control-Allow-Origin: *");     
     header("Content-Type: application/json; charset=UTF-8");
     $files = scandir('routes/', 0);
     $list = array(); 
     $colors = array("Magenta", "FireBrick", "Blue", "Sienna", "DeepPink", 
                     "DarkOrange", "BlueViolet", "DarkMagenta", "Fuchsia", 
                     "Maroon", "MediumVioletRed", "Cyan");
     $ccount = 0;
     for($i = 0; $i < count($files); $i++)
     {    $file = $files[$i];
          if (($file != ".") && ($file != ".."))
          {    $list[] = array("naam" => $file, "kleur" => $colors[$ccount]);
               $ccount++;
               if ($ccount > 11)
               {    $ccount = 0;
               }
          }
     }
     echo json_encode($list, JSON_FORCE_OBJECT);    
?>