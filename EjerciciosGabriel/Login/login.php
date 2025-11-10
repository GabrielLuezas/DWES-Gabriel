<?php


$usuario = "Gabriel";
$password = "rootroot";

if($_POST['usuario']==$usuario && $_POST['password']== $password){
    header("Location:logincorrecto.html");
}else{
    header("Location:loginincorrecto.html");
}

?>