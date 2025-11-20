<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejemplos de Sesiones en PHP</title>
    <link rel="stylesheet" href="estilos.css">
    <script>
        function cargarEjemplo(num, tipo = 'codigo') {
            const visor = document.getElementById("visor");
            const archivo = `ejemplos/sesionesEjemplo${num}.php`;

            if (tipo === 'codigo') {
                visor.src = `mostrarCodigo.php?archivo=${archivo}`;
            } else {
                visor.src = archivo;
            }

            document.querySelectorAll(".nav-btn").forEach(b => b.classList.remove("activo"));
            document.getElementById("btn" + num).classList.add("activo");
        }
    </script>
</head>
<body>
    <div class="contenedor">
        <h1>Ejemplos de Sesiones en PHP</h1>

        <div class="navbar">
            <button id="btn1" class="nav-btn activo" onclick="cargarEjemplo(1)">Ejemplo 1</button>
            <button id="btn2" class="nav-btn" onclick="cargarEjemplo(2)">Ejemplo 2</button>
            <button id="btn3" class="nav-btn" onclick="cargarEjemplo(3)">Ejemplo 3</button>
        </div>

        <div class="botones">
            <button onclick="cargarEjemplo(document.querySelector('.activo').id.replace('btn',''), 'codigo')">Ver código</button>
            <button onclick="cargarEjemplo(document.querySelector('.activo').id.replace('btn',''), 'resultado')">Ver funcionamiento</button>
        </div>

        <iframe id="visor" src="mostrarCodigo.php?archivo=ejemplos/sesionesEjemplo1.php"></iframe>

        <p><a href="index.php" class="volver">← Volver al Home</a></p>
    </div>
</body>
</html>
