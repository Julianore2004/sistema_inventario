<?php 
require_once("config/db.php");
require_once("config/conexion.php");

$id_categoria = isset($_GET['id_categoria']) ? intval($_GET['id_categoria']) : null;

// Configuración de encabezados para la exportación a Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporte_stock.xls");

// Título de columnas para el archivo Excel
echo "Codigo\tNombre\tCategoria\tPrecio\tStock\n";

// Consulta para extraer los productos, según la categoría (si se especifica) o en general
$sql = "SELECT products.codigo_producto, products.nombre_producto, categorias.nombre_categoria, products.precio_producto, products.stock 
        FROM products 
        INNER JOIN categorias ON products.id_categoria = categorias.id_categoria";

if ($id_categoria) {
    $sql .= " WHERE products.id_categoria = '$id_categoria'";
}

$query = mysqli_query($con, $sql);

if (!$query) {
    die("Error en la consulta: " . mysqli_error($con));
}

// Generación de filas de datos
while ($row = mysqli_fetch_assoc($query)) {
    echo "{$row['codigo_producto']}\t{$row['nombre_producto']}\t{$row['nombre_categoria']}\t" . number_format($row['precio_producto'], 2) . "\t{$row['stock']}\n";
}
?>
