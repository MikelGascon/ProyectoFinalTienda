<?php
session_start();

// Destruir la sesión de admin
unset($_SESSION['admin_logueado']);
unset($_SESSION['admin_usuario']);

// Redirigir al login común
header('Location: ../login.php');
exit;
