<!DOCTYPE html>
<html>
<head>
    <title>Hola PHP</title>
</head>
<body>
        <?php 

        $errorAMostrar=32767;
        $listaErrores=array(
            "1" => "E_ERROR Error fatal en tiempo de ejecución. La ejecución del script se detiene",
            "2" => "E_WARNING Advertencia en tiempo de ejecución. El script no se detiene",
            "4" => "E_PARSE Error de sintaxis al compilar",
            "8" => "E_NOTICE Notificación. Puede indicar error o no",
            "16" => "E_CORE_ERROR Error fatal al iniciar PHP",
            "32" => "E_CORE_WARNING Advertencia al iniciar PHP",
            "64" => "E_COMPILE_ERROR Error fatal al compilar",
            "128" => "E_COMPILE_WARNING Advertencia fatal al compilar",
            "256" => "E_USER_ERROR Error generado por el usuario",
            "512" => "E_USER_WARNING Advertencia generada por el usuario",
            "1024" => "E_USER_NOTICE Notificación generada por el usuario",
            "2048" => "E_STRICT Sugerencias para mejorar la portabilidad",
            "4096" => "E_RECOVERABLE_ERROR Error fatal capturable",
            "8192" => "E_DEPRECATED Advertencia de código obsoleto",
            "16384" => "E_USER_DEPRECATED Como la anterior, generada por el usuario",
            
        );
        if($errorAMostrar == E_ALL){
                echo "<b>32767</b>: E_ALL Todos los errores<br>";
        }else{
            foreach($listaErrores as $constante => $descripcion){
            if($errorAMostrar & $constante){
                echo "<b>$constante</b>: $descripcion<br>";
            }
    
        }
        }

        

    ?>
    
</body>
</html>