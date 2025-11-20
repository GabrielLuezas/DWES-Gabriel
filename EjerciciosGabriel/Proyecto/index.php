<?php
?><!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Proyecto: Ejemplos Sesiones y Cookies</title>
  <link rel="stylesheet" href="assets/monokai.css">
  <style>
    body {
      background: #111;
      color: #ddd;
      font-family: system-ui, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
    }

    .container {
      background: #1c1c1c;
      border-radius: 18px;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.6);
      padding: 50px 60px;
      max-width: 950px;
      width: 90%;
      text-align: center;
    }

    .brand {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 15px;
      margin-bottom: 30px;
    }

    .logo {
      background: linear-gradient(135deg, #ff5f9e, #5fd1ff);
      color: white;
      width: 60px;
      height: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      font-size: 1.2rem;
      border-radius: 15px;
      box-shadow: 0 0 10px rgba(255,255,255,0.15);
    }

    .title {
      font-size: 1.8rem;
      font-weight: 700;
      color: #fff;
    }

    .meta {
      font-size: 0.9rem;
      color: #aaa;
      margin-top: 2px;
    }

    .cards-group {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 25px;
      margin-bottom: 25px;
    }

    .card {
      background: #222;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
      transition: transform 0.2s ease, background 0.2s ease;
      flex: 1 1 350px;
      max-width: 400px;
      min-height: 180px;
    }

    .card:hover {
      transform: translateY(-5px);
      background: #262626;
    }

    .card h3 {
      margin-top: 0;
      color: #fff;
      font-size: 1.1rem;
    }

    .card p {
      font-size: 0.9rem;
      color: #bbb;
      margin-bottom: 15px;
      line-height: 1.4em;
    }

    .btn {
      display: inline-block;
      background: #5fd1ff;
      color: #000;
      padding: 8px 14px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.2s ease;
    }

    .btn:hover {
      filter: brightness(1.1);
      transform: scale(1.05);
    }

    .btn.secondary {
      background: #b3ff5f;
    }

    .footer {
      margin-top: 35px;
      font-size: 0.8rem;
      color: #888;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="brand">
      <div class="logo">PC</div>
      <div>
        <div class="title">Proyecto: Sesiones & Cookies</div>
      </div>
    </div>

    <!-- Grupo 1 -->
    <div class="cards-group">
      <div class="card">
        <h3>🧠 Ejemplos de Sesiones</h3>
        <p>Contadores de sesión, login simulado, carrito de compras en sesión y más. Los ejemplos muestran ejecución y código.</p>
        <a class="btn" href="sesiones/">Ver ejemplos de Sesiones</a>
      </div>

      <div class="card">
        <h3>🍪 Ejemplos de Cookies</h3>
        <p>Uso de cookies para contadores, preferencias y autenticación simple. Aprende cómo funcionan en práctica.</p>
        <a class="btn secondary" href="cookies/">Ver ejemplos de Cookies</a>
      </div>
    </div>

    <!-- Grupo 2 -->
    <div class="cards-group">
      <div class="card">
        <h3>📘 Tarea</h3>
        <p>Tarea que los alumnos harán.</p>
        <a class="btn secondary" href="minitarea.php">Ir a tarea</a>
      </div>

    </div>

    <div class="footer">
      Presentación Sesión y Cookies - Gabriel Luezas y Andoni Pastrana
    </div>
  </div>
</body>
</html>
