<?php
session_start();
session_destroy();
header("Location: sesionesEjemplo1.php");
exit;
?>
