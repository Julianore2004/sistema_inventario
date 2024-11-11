<?php
require_once("../config/db.php");
require_once("../config/conexion.php");

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $limit = 10; // Limite de filas por página
    $offset = ($page - 1) * $limit; // Cálculo del offset para SQL

    $sWhere = "";
    if (!empty($q)) {
        $sWhere = "WHERE productos.id_categoria = '$q'";
    }

    // Consulta para contar el número total de registros
    $count_query = mysqli_query($con, "SELECT COUNT(*) AS total FROM products AS productos $sWhere");
    $row = mysqli_fetch_array($count_query);
    $total_rows = $row['total'];
    $total_pages = ceil($total_rows / $limit);

    // Consulta con límite y desplazamiento para paginación
    $sql = "SELECT productos.codigo_producto, productos.nombre_producto, categorias.nombre_categoria, productos.precio_producto, productos.stock 
            FROM products AS productos
            INNER JOIN categorias ON productos.id_categoria = categorias.id_categoria 
            $sWhere LIMIT $offset, $limit";

    $query = mysqli_query($con, $sql);

    if (!$query) {
        die("Error en la consulta SQL: " . mysqli_error($con));
    }

    if (mysqli_num_rows($query) > 0) {
        echo '<div class="table-responsive">
                <table class="table">
                    <tr class="success">
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Categoria</th>
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

        // Código de paginación
        echo '<td colspan="5"><span class="pull-right">
                <ul class="pagination pagination-large">';
        
        // Botón "Anterior"
        if ($page > 1) {
            echo '<li><a href="javascript:void(0);" onclick="load(' . ($page - 1) . ')">‹ Prev</a></li>';
        } else {
            echo '<li class="disabled"><span><a>‹ Prev</a></span></li>';
        }
        
        // Números de página
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo '<li class="active"><a>' . $i . '</a></li>';
            } else {
                echo '<li><a href="javascript:void(0);" onclick="load(' . $i . ')">' . $i . '</a></li>';
            }
        }

        // Botón "Siguiente"
        if ($page < $total_pages) {
            echo '<li><a href="javascript:void(0);" onclick="load(' . ($page + 1) . ')">Next ›</a></li>';
        } else {
            echo '<li class="disabled"><span><a>Next ›</a></span></li>';
        }

        echo '</ul></span></td>';
    } else {
        echo "No se encontraron resultados para la categoría seleccionada.";
    }
}
?>
