<?php
    session_start();
    session_destroy();
    header("Location: ./login.php");
    exit; // Es buena práctica incluir exit() después de una redirección para asegurar que el script se detenga
?>