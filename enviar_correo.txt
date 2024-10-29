<?php
// Asegúrate de que el autoload de Composer esté incluido
require 'vendor/autoload.php'; // Ajusta la ruta si es necesario

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Crea una nueva instancia de PHPMailer
$mail = new PHPMailer(true); // Usar 'true' para habilitar excepciones

try {
    // Configuración del servidor SMTP
    $mail->isSMTP(); // Configurar para usar SMTP
    $mail->Host = 'smtp.gmail.com'; // Especificar el servidor SMTP
    $mail->SMTPAuth = true; // Habilitar autenticación SMTP
    $mail->Username = 'vaquitamarketplace@gmail.com'; // Tu correo
    $mail->Password = 'wgvdmvecnao'; // Tu contraseña o contraseña de aplicación
    $mail->SMTPSecure = 'tls'; // Habilitar cifrado TLS
    $mail->Port = 587; // Puerto para TLS

    // Configuración del contenido del correo
    $mail->setFrom('vaquitamarketplace@gmail.com', 'VaquitaMarketplace'); // Remitente
    $mail->addAddress('lizbeth.lgarcia@alumnos.udg.mx', 'Lizbeth'); // Destinatario
    $mail->Subject = 'Prueba'; // Asunto
    $mail->Body    = 'PRUEBA'; // Cuerpo del mensaje

    // Activa el modo de depuración
    $mail->SMTPDebug = 2; // Cambia a 0 para desactivar después de probar

    // Envía el correo
    $mail->send();
    echo 'El correo ha sido enviado';
} catch (Exception $e) {
    echo "No se pudo enviar el correo. Mailer Error: {$mail->ErrorInfo}";
}
?>

