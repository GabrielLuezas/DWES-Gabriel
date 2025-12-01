<?php
session_start();

// Función para obtener y limpiar el mensaje flash
function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $message;
    }
    return null;
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$flash = getFlashMessage();
$usuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bienvenido</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }
        
        h1 {
            color: #11998e;
            margin-bottom: 20px;
            font-size: 28px;
        }
        
        .flash-message {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            animation: slideIn 0.3s ease-out, fadeOut 0.5s ease-in 4.5s;
            animation-fill-mode: forwards;
        }
        
        .flash-message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
            }
        }
        
        .user-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        
        .user-info p {
            color: #555;
            font-size: 18px;
            margin: 10px 0;
        }
        
        .user-info strong {
            color: #11998e;
        }
        
        .logout-btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-top: 20px;
        }
        
        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .logout-btn:active {
            transform: translateY(0);
        }
        
        .success-icon {
            font-size: 60px;
            color: #38ef7d;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-icon">✓</div>
        <h1>¡Login Correcto!</h1>
        
        <?php if ($flash): ?>
            <div class="flash-message <?php echo $flash['type']; ?>" id="flashMessage">
                <?php echo $flash['text']; ?>
            </div>
        <?php endif; ?>
        
        <div class="user-info">
            <p>Bienvenido, <strong><?php echo htmlspecialchars($usuario); ?></strong></p>
            <p>Has iniciado sesión correctamente</p>
        </div>
        
        <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
    </div>
    
    <script>
        // Eliminar el mensaje flash del DOM después de 5 segundos
        const flashMessage = document.getElementById('flashMessage');
        if (flashMessage) {
            setTimeout(() => {
                flashMessage.remove();
            }, 5000);
        }
    </script>
</body>
</html>
