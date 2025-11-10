<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

    <?php  
    //8 Exportar
    //4 Borrar registros
    //2 Modificar
    //1 Leer

    //Declararar un array de personas 

    $empleadosArray =
    [
        [
            "Nombre" => "Gabriel",
            "Apellido" => "Luezas",
            "Permisos" => 7
        ],
        [
            "Nombre" => "Pepito",
            "Apellido" => "Marinero",
            "Permisos" => 15
        ],
        [
            "Nombre" => "Proxing",
            "Apellido" => "33",
            "Permisos" => 3
        ],
        [
            "Nombre" => "Ash",
            "Apellido" => "Ketchum",
            "Permisos" => 11
        ],

        ];

    

    foreach ($empleadosArray as $empleado) {


        $permisos = $empleado["Permisos"]; 
        $binario = str_pad(decbin($permisos), 4, "0", STR_PAD_LEFT);

        echo "<strong>" . $empleado["Nombre"] . " " . $empleado["Apellido"] . "</strong><br>";
        echo "<hr>";


        if (($permisos & 1) != 0) {
        echo " Puede leer<br>";
        } else {
        echo " No puede leer<br>";
        }

        if (($permisos & 2) != 0) { 
        echo " Puede modificar<br>";
        } else {
        echo " No puede modificar<br>";
        }

        if (($permisos & 4) != 0) { 
        echo " Puede borrar registros<br>";
        } else {
        echo " No puede borrar registros<br>";
        }

        if (($permisos & 8) != 0) { 
        echo " Puede exportar<br>";
        } else {
        echo " No puede exportar<br>";
        }

    echo "<hr>";

    }



    ?>  

</body>
</html>

