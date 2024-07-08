<?php
// Configuración del servidor FTP
$ftp_server = '192.168.1.5';
$ftp_usuario = 'android';
$ftp_contraseña = 'android';
$ftp_puerto = 2221;
$archivo_ftp = '/gen_signed3.apk';

// Conexión y descarga desde el servidor FTP
$ftp_conn = ftp_connect($ftp_server, $ftp_puerto);
$login = ftp_login($ftp_conn, $ftp_usuario, $ftp_contraseña);

// Validar la conexión y descargar el archivo
if ($ftp_conn && $login) {
    ob_start();
    $result = ftp_get($ftp_conn, 'php://output', $archivo_ftp, FTP_BINARY);
    $archivo = ob_get_clean();

    // Cerrar la conexión FTP
    ftp_close($ftp_conn);

    if ($result) {
        // Devolver el contenido del archivo descargado
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="gen_signed3.apk"');
        echo $archivo;
        exit;
    } else {
        // Manejar errores si la descarga falla
        header("HTTP/1.1 500 Internal Server Error");
        echo "Error: No se pudo descargar el archivo desde el servidor FTP.";
        exit;
    }
} else {
    // Manejar errores de conexión al servidor FTP
    header("HTTP/1.1 500 Internal Server Error");
    echo "Error: No se pudo conectar al servidor FTP.";
    exit;
}
?>