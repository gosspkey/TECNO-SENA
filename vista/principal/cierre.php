<?php
// Cerrar la sesión
session_start(); // Inicia la sesión
session_unset(); // Elimina todas las variables de sesión
session_destroy(); // Destruye la sesión activa

// Redirige al usuario a la página de inicio
header("Location: ../../index.html");
exit();

?>