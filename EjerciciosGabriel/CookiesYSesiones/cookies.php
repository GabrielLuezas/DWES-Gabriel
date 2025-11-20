<?php

setcookie('gabriel', '20', time() + 6000, "/", "", false, false);


$mensaje = ($_COOKIE['gabriel']) ;


echo $_COOKIE['gabriel'];

?>