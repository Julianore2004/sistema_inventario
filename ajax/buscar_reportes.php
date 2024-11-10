<?php
require_once("../config/db.php");
require_once("../config/conexion.php");

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    
    $sWhere = "";
    if (!empty($q)) {
        $sWhere = "WHERE productos.id_categoria = '$q'";
    }
    
    $sql = "SELECT productos.codigo_producto, productos.nombre_producto, categorias.nombre_categoria, productos.precio_producto, productos.stock 
            FROM products AS productos
            INNER JOIN categorias ON productos.id_categoria = categorias.id_categoria 
            $sWhere";
    
    // Verifica si la consulta fue exitosa
    $query = mysqli_query($con, $sql);
    
    if (!$query) {
        // Si la consulta falla, muestra el error
        die("Error en la consulta SQL: " . mysqli_error($con));
    }
    
    if (mysqli_num_rows($query) > 0) {
        echo '<div class="table-responsive">
                  <table class="table">
                    <tr class="success">
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th class="text-right">Precio</th>
                        <th class="text-center">Stock</th>
                    </tr>';
        
        while ($row = mysqli_fetch_array($query)) {
            echo '<tr>
                    <td>' . $row['codigo_producto'] . '</td>
                    <td>' . $row['nombre_producto'] . '</td>
                    <td>' . $row['nombre_categoria'] . '</td>
                    <td class="text-right">' . number_format($row['precio_producto'], 2) . '</td>
                    <td class="text-center">' . $row['stock'] . '</td>
                  </tr>';
        }
        
        echo '</table></div>';
    } else {
        echo "No se encontraron resultados para la categoría seleccionada.";
    }
}
?>
