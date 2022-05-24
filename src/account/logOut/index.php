<?php
setcookie("loginEmail","",time() - 3600,"/");
header("Location: ../login");
exit();