<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ejemplos de Sesiones en PHP</title>
  <link rel="stylesheet" href="../assets/monokai.css">
  <style>
    .viewer-box {
      margin-top: 24px;
      background: var(--card);
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 8px 30px rgba(0,0,0,0.6);
    }
    iframe {
      width: 100%;
      height: 700px;
      border: none;
      border-radius: 8px;
      background: #1e1e1e;
    }
    select {
      background: var(--glass);
      color: #f8f8f2;
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 8px;
      padding: 8px 12px;
      font-family: 'Fira Code', monospace;
    }
    button {
      padding: 10px 16px;
      border-radius: 8px;
      border: none;
      background: var(--accent);
      color: #0d0d0d;
      font-weight: 700;
      cursor: pointer;
      transition: transform .15s ease, background .15s ease;
    }
    button:hover {
      background: var(--green);
      transform: translateY(-2px);
    }
    .topbar {
      display: flex;
      gap: 12px;
      align-items: center;
      margin-bottom: 12px;
    }
    .footer {
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Ejemplos de Sesiones en PHP</h1>

    <div class="topbar">
      <select id="selector">
        <option value="1">Ejemplo 1</option>
        <option value="2">Ejemplo 2</option>
        <option value="3">Ejemplo 3</option>
      </select>

      <button onclick="cargar('codigo')">Ver código</button>
      <button onclick="cargar('resultado')">Ver ejecución</button>
    </div>

    <div class="viewer-box">
      <iframe id="visor" src="../assets/mostrarCodigo.php?archivo=ejemplo1.php"></iframe>
    </div>

    <div class="footer">
      <a href="../index.php" class="btn secondary">← Volver al Home</a>
    </div>
  </div>

  <script>
    function cargar(tipo) {
      const select = document.getElementById('selector');
      const num = select.value;
      const archivo = `ejemplo${num}.php`; 
      const visor = document.getElementById('visor');

      if (tipo === 'codigo') {
        visor.src = `../assets/mostrarCodigo.php?archivo=${archivo}`;
      } else {
        visor.src = archivo;
      }
    }
  </script>
</body>
</html>
