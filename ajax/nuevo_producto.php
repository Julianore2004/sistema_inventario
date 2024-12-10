<?php
include('is_logged.php'); // Archivo verifica que el usuario que intenta acceder a la URL está logueado

/* Inicia validación del lado del servidor */
if (empty($_POST['codigo'])) {
    $errors[] = "Código vacío";
} elseif (empty($_POST['nombre'])) {
    $errors[] = "Nombre del producto vacío";
} elseif ($_POST['stock'] == "") {
    $errors[] = "Stock del producto vacío";
} elseif (empty($_POST['precio'])) {
    $errors[] = "Precio de venta vacío";
} elseif (empty($_POST['imagen']) || !filter_var($_POST['imagen'], FILTER_VALIDATE_URL)) {
    $errors[] = "URL de imagen inválida";
} else {
    /* Connect to Database */
    require_once("../config/db.php"); // Contiene las variables de configuración para conectar a la base de datos
    require_once("../config/conexion.php"); // Contiene función que conecta a la base de datos
    include("../funciones.php");

    // Escaping, additionally removing everything that could be (html/javascript-) code
    $codigo = mysqli_real_escape_string($con, (strip_tags($_POST["codigo"], ENT_QUOTES)));
    $nombre = mysqli_real_escape_string($con, (strip_tags($_POST["nombre"], ENT_QUOTES)));
    $stock = intval($_POST['stock']);
    $id_categoria = intval($_POST['categoria']);
    $precio_venta = floatval($_POST['precio']);
    $imagen = mysqli_real_escape_string($con, (strip_tags($_POST["imagen"], ENT_QUOTES)));
    $date_added = date("Y-m-d H:i:s");

    // Verificar si el código del producto ya existe
    $check_query = mysqli_query($con, "SELECT * FROM products WHERE codigo_producto = '$codigo'");
    if (mysqli_num_rows($check_query) > 0) {
        $errors[] = "El código del producto ya existe. Por favor, ingrese un código único.";
    } else {
        // Insertar el nuevo producto
        $sql = "INSERT INTO products (codigo_producto, nombre_producto, date_added, precio_producto, stock, id_categoria, imagen)
                VALUES ('$codigo', '$nombre', '$date_added', '$precio_venta', '$stock', '$id_categoria', '$imagen')";

        $query_new_insert = mysqli_query($con, $sql);
        if ($query_new_insert) {
            $messages[] = "Producto ha sido ingresado satisfactoriamente.";
            $id_producto = get_row('products', 'id_producto', 'codigo_producto', $codigo);
            $user_id = $_SESSION['user_id'];
            $firstname = $_SESSION['firstname'];
            $nota = "$firstname agregó $stock producto(s) al inventario";
        } else {
            $errors[] = "Lo siento, algo ha salido mal. Intenta nuevamente." . mysqli_error($con);
        }
    }
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
