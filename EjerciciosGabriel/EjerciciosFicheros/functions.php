<?php
require_once 'config.php';

if (!file_exists(USERS_FILE)) {
    file_put_contents(USERS_FILE, json_encode([]));
}

function getUsers() {
    $content = file_get_contents(USERS_FILE);
    return json_decode($content, true) ?? [];
}

function saveUser($user) {
    $users = getUsers();
    $users[] = $user;
    file_put_contents(USERS_FILE, json_encode($users, JSON_PRETTY_PRINT));
}

function emailExists($email) {
    $users = getUsers();
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            return true;
        }
    }
    return false;
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';

function sendConfirmationEmail($email, $name) {
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      
        $mail->isSMTP();                                            
        $mail->Host       = SMTP_HOST;                    
        $mail->SMTPAuth   = true;                               
        $mail->Username   = SMTP_USER;                     
        $mail->Password   = SMTP_PASS;                              
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           
        $mail->Port       = SMTP_PORT;                                   

        $mail->setFrom(SMTP_USER, 'Tu App PHP');
        $mail->addAddress($email, $name);    

        $mail->isHTML(true);                      
        $mail->Subject = 'Confirmacion de Registro';
        $mail->Body    = "Hola $name,<br><br>Gracias por registrarte en nuestra plataforma.<br><br>Tus datos han sido guardados correctamente.";
        $mail->AltBody = "Hola $name,\n\nGracias por registrarte en nuestra plataforma.\n\nTus datos han sido guardados correctamente.";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}





function sendLoginNotification($email, $name) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER;
        $mail->Password   = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = SMTP_PORT;

        // Recipients
        $mail->setFrom(SMTP_USER, 'Seguridad App PHP');
        $mail->addAddress($email, $name);

        // Gather Header/Server Info
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'Desconocida';
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Desconocido';
        $time = date('Y-m-d H:i:s');
        $serverProtocol = $_SERVER['SERVER_PROTOCOL'] ?? 'Desconocido';
        $requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'Desconocido';
        $acceptLanguage = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'Desconocido';
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Alerta de Inicio de Sesion';
        
        $bodyContent = "Hola $name,<br><br>Se ha detectado un nuevo inicio de sesión en tu cuenta.<br><br>";
        $bodyContent .= "<strong>Detalles de la conexión:</strong><br>";
        $bodyContent .= "<ul>";
        $bodyContent .= "<li><strong>Fecha y Hora:</strong> $time</li>";
        $bodyContent .= "<li><strong>IP:</strong> $ip</li>";
        $bodyContent .= "<li><strong>Navegador/Dispositivo:</strong> $userAgent</li>";
        $bodyContent .= "<li><strong>Protocolo:</strong> $serverProtocol</li>";
        $bodyContent .= "<li><strong>Método:</strong> $requestMethod</li>";
        $bodyContent .= "<li><strong>Lenguaje:</strong> $acceptLanguage</li>";
        $bodyContent .= "</ul><br>";
        $bodyContent .= "Si no has sido tú, por favor cambia tu contraseña inmediatamente.";

        $mail->Body    = $bodyContent;
        $mail->AltBody = strip_tags(str_replace("<br>", "\n", $bodyContent));

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
