<?php
include('is_logged.php'); // Archivo verifica que el usuario que intenta acceder a la URL está logueado

/* Inicia validación del lado del servidor */
if (empty($_POST['nombre'])) {
    $errors[] = "Nombre vacío";
} else if (!empty($_POST['nombre'])) {
    /* Connect To Database */
    require_once("../config/db.php"); // Contiene las variables de configuración para conectar a la base de datos
    require_once("../config/conexion.php"); // Contiene función que conecta a la base de datos

    // Escaping, additionally removing everything that could be (html/javascript-) code
    $nombre = mysqli_real_escape_string($con, (strip_tags($_POST["nombre"], ENT_QUOTES)));
    $descripcion = mysqli_real_escape_string($con, (strip_tags($_POST["descripcion"], ENT_QUOTES)));
    $date_added = date("Y-m-d H:i:s");

    // Verificar si el nombre de la categoría ya existe
    $check_query = mysqli_query($con, "SELECT * FROM categorias WHERE nombre_categoria = '$nombre'");
    if (mysqli_num_rows($check_query) > 0) {
        $errors[] = "El nombre de la categoría ya existe. Por favor, ingrese un nombre único.";
        echo '<script type="text/javascript">alert("El nombre de la categoría ya existe. Por favor, ingrese un nombre único.");</script>';
    } else {
        // Insertar la nueva categoría
        $sql = "INSERT INTO categorias (nombre_categoria, descripcion_categoria, date_added) VALUES ('$nombre', '$descripcion', '$date_added')";
        $query_new_insert = mysqli_query($con, $sql);
        if ($query_new_insert) {
            $messages[] = "Categoría ha sido ingresada satisfactoriamente.";
        } else {
            $errors[] = "Lo siento, algo ha salido mal. Intenta nuevamente." . mysqli_error($con);
        }
    }
} else {
    $errors[] = "Error desconocido.";
}

if (isset($errors)) {
    ?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Error!</strong>
        <?php
        foreach ($errors as $error) {
            echo $error;
        }
        ?>
    </div>
    <?php
}

if (isset($messages)) {
    ?>
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>¡Bien hecho!</strong>
        <?php
        foreach ($messages as $message) {
            echo $message;
        }
        ?>
    </div>
    <?php
}
?>
<?php
include('is_logged.php'); // Archivo verifica que el usuario que intenta acceder a la URL está logueado

/* Inicia validación del lado del servidor */
if (empty($_POST['nombre'])) {
    $errors[] = "Nombre vacío";
} else if (!empty($_POST['nombre'])) {
    /* Connect To Database */
    require_once("../config/db.php"); // Contiene las variables de configuración para conectar a la base de datos
    require_once("../config/conexion.php"); // Contiene función que conecta a la base de datos

    // Escaping, additionally removing everything that could be (html/javascript-) code
    $nombre = mysqli_real_escape_string($con, (strip_tags($_POST["nombre"], ENT_QUOTES)));
    $descripcion = mysqli_real_escape_string($con, (strip_tags($_POST["descripcion"], ENT_QUOTES)));
    $date_added = date("Y-m-d H:i:s");

    // Verificar si el nombre de la categoría ya existe
    $check_query = mysqli_query($con, "SELECT * FROM categorias WHERE nombre_categoria = '$nombre'");
    if (mysqli_num_rows($check_query) > 0) {
        $errors[] = "El nombre de la categoría ya existe. Por favor, ingrese un nombre único.";
        echo '<script type="text/javascript">alert("El nombre de la categoría ya existe. Por favor, ingrese un nombre único.");</script>';
    } else {
        // Insertar la nueva categoría
        $sql = "INSERT INTO categorias (nombre_categoria, descripcion_categoria, date_added) VALUES ('$nombre', '$descripcion', '$date_added')";
        $query_new_insert = mysqli_query($con, $sql);
        if ($query_new_insert) {
            $messages[] = "Categoría ha sido ingresada satisfactoriamente.";
        } else {
            $errors[] = "Lo siento, algo ha salido mal. Intenta nuevamente." . mysqli_error($con);
        }
    }
} else {
    $errors[] = "Error desconocido.";
}

if (isset($errors)) {
    ?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Error!</strong>
        <?php
        foreach ($errors as $error) {
            echo $error;
        }
        ?>
    </div>
    <?php
}

if (isset($messages)) {
    ?>
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>¡Bien hecho!</strong>
        <?php
        foreach ($messages as $message) {
            echo $message;
        }
        ?>
    </div>
    <?php
}
?>
