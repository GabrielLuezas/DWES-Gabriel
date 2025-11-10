<?php
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    $trimeado = explode("@", $correo);


    echo $trimeado[0];
?>

