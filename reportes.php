<?php 
session_start();
if (!isset($_SESSION['user_login_status']) || $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}

require_once("config/db.php");
require_once("config/conexion.php");

$active_categoria = "active";
$title = "Categorías | Simple Invoice";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("head.php"); ?>
</head>
<body>
    <?php include("navbar.php"); ?>

    <div class="container">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-default" onclick="exportar_excel();">
                        <span class="glyphicon glyphicon-download-alt"></span> Exportar Excel
                    </button>
                </div>
                <h4><i class="glyphicon glyphicon-search"></i> Buscar productos</h4>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" id="datos_cotizacion">
                    <div class="form-group row">
                        <label for="id_categoria" class="col-md-2 control-label">Categoría</label>
                        <div class="col-md-5">
                            <select class="form-control" name="id_categoria" id="id_categoria" onchange="load(1);">
                                <option value="">Selecciona una categoría</option>
                                <?php
                                $sql = "SELECT id_categoria, nombre_categoria FROM categorias";
                                $result = mysqli_query($con, $sql);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='{$row['id_categoria']}'>{$row['nombre_categoria']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-default" onclick="load(1);">
                                <span class="glyphicon glyphicon-search"></span> Buscar
                            </button>
                            <span id="loader"></span>
                        </div>
                    </div>
                </form>

                <div id="resultados"></div>
                <div class="outer_div"></div>
            </div>
        </div>
    </div>
	<hr>
	<?php
	include("footer.php");
	?>
    <script src="js/reportes.js"></script>
</body>
</html>
