<?php
// borrar cookies comunes del proyecto
setcookie('visitas', '', time()-3600);
setcookie('pref_tema', '', time()-3600);
setcookie('auth_user', '', time()-3600);
header('Location: index.php');
exit;
?>