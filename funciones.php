<?php 
function get_row($table,$row, $id, $equal){
	global $con;
	$query=mysqli_query($con,"select $row from $table where $id='$equal'");
	$rw=mysqli_fetch_array($query);
	$value=$rw[$row];
	return $value;
}
function guardar_historial($id_producto,$user_id,$fecha,$nota,$reference,$quantity){
	global $con;
	$sql="INSERT INTO historial (id_historial, id_producto, user_id, fecha, nota, referencia, cantidad)
	VALUES (NULL, '$id_producto', '$user_id', '$fecha', '$nota', '$reference', '$quantity');";
	$query=mysqli_query($con,$sql);
	
	
}
function agregar_stock($id_producto,$quantity){
	global $con;
	$update=mysqli_query($con,"update products set stock=stock+'$quantity' where id_producto='$id_producto'");
	if ($update){
			return 1;
	} else {
		return 0;
	}	
		
}
function eliminar_stock($id_producto, $quantity) {
    global $con;

    // Obtener el stock actual del producto
    $query = mysqli_query($con, "SELECT stock FROM products WHERE id_producto='$id_producto'");
    if ($query) {
        $row = mysqli_fetch_array($query);
        $current_stock = $row['stock'];

        // Verificar si el stock actual es mayor o igual que la cantidad a eliminar
        if ($current_stock >= $quantity) {
            // Realizar la actualización del stock
            $update = mysqli_query($con, "UPDATE products SET stock=stock-'$quantity' WHERE id_producto='$id_producto'");
            if ($update) {
                return 1;
            } else {
                return 0;
            }
        } else {
            // No hay suficiente stock para eliminar la cantidad dada
            return -1; // Código de error para stock insuficiente
        }
    } else {
        return 0; // Error en la consulta para obtener el stock actual
    }
}
?>