<?php
require_once("config/db.php");
require_once("config/conexion.php");

$id_categoria = isset($_GET['id_categoria']) ? intval($_GET['id_categoria']) : "";

if ($id_categoria) {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=reporte_stock.xls");
    echo "Código\tNombre\tCategoría\tPrecio\tStock\n";

    $sql = "SELECT products.codigo_producto, products.nombre_producto, categorias.nombre_categoria, products.precio_producto, products.stock 
        FROM products 
        INNER JOIN categorias ON products.id_categoria = categorias.id_categoria 
        WHERE products.id_categoria = '$id_categoria'";

    $query = mysqli_query($con, $sql);

    if (!$query) {
        die("Error en la consulta: " . mysqli_error($con));
    }

    while ($row = mysqli_fetch_assoc($query)) {
        echo "{$row['codigo_producto']}\t{$row['nombre_producto']}\t{$row['nombre_categoria']}\t{$row['precio_producto']}\t{$row['stock']}\n";
    }
}
?>
