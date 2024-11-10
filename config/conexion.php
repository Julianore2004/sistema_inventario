<?php

# Conexión a la base de datos
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$con) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (mysqli_connect_errno()) {
    die("La conexión falló: " . mysqli_connect_errno() . " - " . mysqli_connect_error());
}
?>
