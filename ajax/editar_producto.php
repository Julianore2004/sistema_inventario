<?php
    include('is_logged.php'); // Verifica que el usuario esté logueado

    /* Inicia validación del lado del servidor */
    if (empty($_POST['mod_id'])) {
        $errors[] = "ID vacío";
    } else if (empty($_POST['mod_codigo'])) {
        $errors[] = "Código vacío";
    } else if (empty($_POST['mod_nombre'])) {
        $errors[] = "Nombre del producto vacío";
    } else if ($_POST['mod_categoria'] == "") {
        $errors[] = "Selecciona la categoría del producto";
    } else if (empty($_POST['mod_precio'])) {
        $errors[] = "Precio de venta vacío";
    } else if (
        !empty($_POST['mod_id']) &&
        !empty($_POST['mod_codigo']) &&
        !empty($_POST['mod_nombre']) &&
        $_POST['mod_categoria'] != "" &&
        !empty($_POST['mod_precio'])
    ) {
        /* Conexión a la base de datos */
        require_once("../config/db.php"); // Contiene las variables de configuración para conectar a la base de datos
        require_once("../config/conexion.php"); // Contiene la función que conecta a la base de datos

        // Escapando y limpiando los datos
        $codigo = mysqli_real_escape_string($con, (strip_tags($_POST["mod_codigo"], ENT_QUOTES)));
        $nombre = mysqli_real_escape_string($con, (strip_tags($_POST["mod_nombre"], ENT_QUOTES)));
        $categoria = intval($_POST['mod_categoria']);
        $stock = intval($_POST['mod_stock']);
        $precio_venta = floatval($_POST['mod_precio']);
        $id_producto = $_POST['mod_id'];

        // Verificar si se ha enviado una nueva URL de imagen
        $imagen = $_POST['mod_imagen'];  // Usamos directamente la URL de la imagen
        $ruta_imagen = '';

        if (!empty($imagen)) {
            // Usar la URL proporcionada por el usuario
            $ruta_imagen = $imagen;
        } else {
            // Si no se proporciona una nueva imagen, se usa la imagen actual
            $ruta_imagen = $_POST['mod_imagen_actual'];
        }

        // Actualizar los datos del producto
        $sql = "UPDATE products SET 
                codigo_producto = '".$codigo."', 
                nombre_producto = '".$nombre."', 
                id_categoria = '".$categoria."', 
                precio_producto = '".$precio_venta."', 
                stock = '".$stock."', 
                imagen = '".$ruta_imagen."' 
                WHERE id_producto = '".$id_producto."'";

        // Realizar la consulta de actualización
        $query_update = mysqli_query($con, $sql);

        if ($query_update) {
            // Mostrar solo el mensaje de éxito sin incluir la URL de la imagen
            $messages[] = "Producto ha sido actualizado satisfactoriamente.";
        } else {
            $errors[] = "Lo siento, algo ha salido mal. Intenta nuevamente." . mysqli_error($con);
        }
    } else {
        $errors[] = "Error desconocido.";
    }

    // Mostrar errores
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

    // Mostrar mensajes de éxito
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
