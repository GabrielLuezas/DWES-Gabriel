<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editor PHP - Monokai UI</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;600&display=swap');
    :root{
      --bg: #272822;
      --card: #2a2d2b;
      --muted: #a6a28f;
      --accent: #66d9ef;
      --string: #e6db74;
      --keyword: #f92672;
      --variable: #fd971f;
      --green: #a6e22e;
      --purple: #ae81ff;
      --glass: rgba(255,255,255,0.03);
    }
    *{box-sizing:border-box;}
    body{
      margin:0; font-family: 'Fira Code', monospace; 
      background: linear-gradient(180deg,#1f1f1f 0%, #151515 100%);
      color:#f8f8f2;
      -webkit-font-smoothing:antialiased; -moz-osx-font-smoothing:grayscale;
    }

    header, footer {
      background: var(--card);
      padding: 16px 24px;
      text-align: center;
      box-shadow: 0 3px 10px rgba(0,0,0,0.4);
    }

    main {
      display: flex;
      flex-direction: column;
      height: calc(100vh - 140px);
    }

    .topbar {
  display: flex;
  justify-content: center; 
  align-items: center;
  padding: 10px 20px;
  background: var(--glass);
  border-bottom: 1px solid rgba(255,255,255,0.08);
  gap: 10px;
}
    .workspace {
      display: flex;
      flex: 1;
      overflow: hidden;
    }

    .editor, .preview {
      flex: 1;
      display: flex;
      flex-direction: column;
      background: var(--card);
      margin: 10px;
      border-radius: 10px;
      overflow: hidden;
      border: 1px solid rgba(255,255,255,0.05);
    }

    textarea {
      flex: 1;
      width: 100%;
      background: var(--bg);
      color: #f8f8f2;
      border: none;
      outline: none;
      resize: none;
      font-family: 'Fira Code', monospace;
      font-size: 15px;
      padding: 14px;
    }

    iframe {
      flex: 1;
      border: none;
      background: #fff;
    }

    .btn {
      display: inline-block;
      padding: 10px 16px;
      border-radius: 8px;
      background: var(--accent);
      color:#0d0d0d;
      font-weight:700;
      text-decoration:none;
      margin: 10px;
      text-align:center;
      cursor:pointer;
      transition: transform .15s ease;
      border:none;
    }
    .btn:hover { transform: scale(1.05); }

    footer { font-size: 13px; color: var(--muted); }
  </style>
</head>
<body>

   <header>
    <div class="brand">
      <div class="logo">TAREA</div>
    </div>

    <div class="notice">
       Crea una página en PHP que permita al usuario seleccionar su 
      <strong>idioma preferido</strong> (Español, Inglés o Francés). Guarda la selección en una 
      <strong>cookie</strong> para recordar la preferencia durante varios días. 
      Al volver a cargar la página, debe mostrarse automáticamente el contenido en el idioma guardado. 
      Incluye un botón para borrar la cookie y volver a elegir idioma.
    </div>
  </header>

  <main>
    <div class="topbar">
      <button class="btn" id="saveBtn">Guardar</button>
      <button class="btn" id="runBtn">Ejecutar</button>
    </div>

    <div class="workspace">
      <div class="editor">
        <textarea id="codeArea" placeholder="Escribe tu código PHP aquí..."><?php echo "Hola mundo!"; ?></textarea>
      </div>

      <div class="preview">
        <iframe id="previewFrame"></iframe>
      </div>
    </div>
  </main>

  <footer>
    Presentación Sesión y Cookies - Gabriel Luezas y Andoni Pastrana
    <div class="footer">
      <a href="index.php" class="btn secondary">← Volver al Home</a>
    </div>
  </footer>

  <script>
    const runBtn = document.getElementById('runBtn');
    const saveBtn = document.getElementById('saveBtn');
    const codeArea = document.getElementById('codeArea');
    const iframe = document.getElementById('previewFrame');

    // Guardar código en archivo PHP (save.php)
    saveBtn.addEventListener('click', async () => {
      const code = codeArea.value;
      const formData = new FormData();
      formData.append('code', code);

      const response = await fetch('save.php', {
        method: 'POST',
        body: formData
      });
      const result = await response.text();
    });

    // Ejecutar el archivo guardado dentro del iframe
    runBtn.addEventListener('click', () => {
      iframe.src = 'codigo.php?cache=' + Date.now();
    });
  </script>

</body>
</html>
