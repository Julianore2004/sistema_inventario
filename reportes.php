<?php
	/*-------------------------
	Autor: Obed Alvarado
	Web: obedalvarado.pw
	Mail: info@obedalvarado.pw
	---------------------------*/
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$active_categoria="active";
	$title="Categorías | Simple Invoice";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("head.php");?>
  </head>
  <body>
	<?php
	include("navbar.php");
	?>
<div class="container">
	<div class="panel panel-success">
		<div class="panel-heading">
		    <div class="btn-group pull-right">
				<button type="button" class="btn btn-default" onclick="exportar_excel();"><span class="glyphicon glyphicon-download-alt"></span> Exportar excel</button>
			</div>
			<h4><i class="glyphicon glyphicon-search"></i> Buscar productos</h4>
		</div>
		<div class="panel-body">
		
			
			
					<!-- Modal -->
	<div class="modal fade" id="nuevoCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-edit"></i> Agregar nueva categoría</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_categoria" name="guardar_categoria">
			<div id="resultados_ajax"></div>
			  <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="nombre" name="nombre" required="">
				</div>
			  </div>
			 
				  
			  <div class="form-group">
				<label for="descripcion" class="col-sm-3 control-label">Descripción</label>
				<div class="col-sm-8">
					<textarea class="form-control" id="descripcion" name="descripcion" maxlength="255"></textarea>
				  
				</div>
			  </div>
			  
	 
			 
			 
			
		  </form></div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
		  </div>
		  
		</div>
	  </div>
	</div>
			<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-edit"></i> Editar categoría</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_categoria" name="editar_categoria">
			<div id="resultados_ajax2"></div>
			  <div class="form-group">
				<label for="mod_nombre" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_nombre" name="mod_nombre" required="">
					<input type="hidden" name="mod_id" id="mod_id">
				</div>
			  </div>
			   
			  
			 
			  <div class="form-group">
				<label for="mod_descripcion" class="col-sm-3 control-label">Descripción</label>
				<div class="col-sm-8">
				  <textarea class="form-control" id="mod_descripcion" name="mod_descripcion"></textarea>
				</div>
			  </div>
			  
			 
			 
			 
			 
			
		  </form></div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="actualizar_datos">Actualizar datos</button>
		  </div>
		  
		</div>
	  </div>
	</div>
				<form class="form-horizontal" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Categoría</label>
							<div class="col-md-5">
								<select class="form-control" name="id_categoria" id="id_categoria" onchange="load(1);">
									<option value="">Selecciona una categoría</option>
																		<option value="488">12344</option>			
																			<option value="1">Baleritos</option>			
																			<option value="478">Cascos</option>			
																			<option value="471">Contabilidad</option>			
																			<option value="486">LAPTOP</option>			
																			<option value="2">Mouse</option>			
																			<option value="481">Notebook</option>			
																			<option value="484">Prueba</option>			
																			<option value="487">sdad</option>			
																			<option value="489">utiles de escritorio</option>			
																			<option value="483">VSP</option>			
																		</select>
							</div>
							<div class="col-md-3">
								<button type="button" class="btn btn-default" onclick="load(1);">
									<span class="glyphicon glyphicon-search"></span> Buscar</button>
								<span id="loader"></span>
							</div>
							
						</div>
				
				
				
			</form>
				<div id="resultados"></div><!-- Carga los datos ajax -->
				<div class="outer_div">			<div class="table-responsive">
			  <table class="table">
				<tbody><tr class="success">
					<th>Código</th>
					<th>Nombre</th>
					<th>Categoría</th>
					<th class="text-right">Precio</th>
					<th class="text-center">Stock</th>
					
				</tr>
									<tr>
						
						<td>0000-350-3500</td>
						<td>Filtro de gasolina</td>
						<td>Baleritos</td>
						<td class="text-right">8.00</td>
						<td class="text-center">83.00</td>
					
						
					</tr>
										<tr>
						
						<td>MS170</td>
						<td>Motosierra MS170 Stihl</td>
						<td>Mouse</td>
						<td class="text-right">350.00</td>
						<td class="text-center">643.00</td>
					
						
					</tr>
										<tr>
						
						<td>MS250</td>
						<td>Motosierra MS250 Stihl</td>
						<td>Mouse</td>
						<td class="text-right">500.00</td>
						<td class="text-center">20.00</td>
					
						
					</tr>
										<tr>
						
						<td>MS310</td>
						<td>Motosierra MS310 Stihl</td>
						<td>Mouse</td>
						<td class="text-right">600.00</td>
						<td class="text-center">22,951.00</td>
					
						
					</tr>
										<tr>
						
						<td>MS381</td>
						<td>Motosierra MS381 Stihl</td>
						<td>Mouse</td>
						<td class="text-right">750.00</td>
						<td class="text-center">64.00</td>
					
						
					</tr>
										<tr>
						
						<td>MS650</td>
						<td>Motosierra MS660 Stihl</td>
						<td>Mouse</td>
						<td class="text-right">900.00</td>
						<td class="text-center">300.00</td>
					
						
					</tr>
										<tr>
						
						<td>0000-930-2203</td>
						<td>Cuerda de arranque stihl</td>
						<td>Baleritos</td>
						<td class="text-right">23.00</td>
						<td class="text-center">404.00</td>
					
						
					</tr>
										<tr>
						
						<td>MS310CARB</td>
						<td>Carburador MS310</td>
						<td>Baleritos</td>
						<td class="text-right">80.00</td>
						<td class="text-center">20.00</td>
					
						
					</tr>
										<tr>
						
						<td>MS250CARB</td>
						<td>Carburador MS250</td>
						<td>Baleritos</td>
						<td class="text-right">80.00</td>
						<td class="text-center">163.00</td>
					
						
					</tr>
										<tr>
						
						<td>S-300</td>
						<td>Carcasa de motor MS250</td>
						<td>Baleritos</td>
						<td class="text-right">100.00</td>
						<td class="text-center">504.00</td>
					
						
					</tr>
									<tr>
					<td colspan="5"><span class="pull-right">
					<ul class="pagination pagination-large"><li class="disabled"><span><a>‹ Prev</a></span></li><li class="active"><a>1</a></li><li><a href="javascript:void(0);" onclick="load(2)">2</a></li><li><span><a href="javascript:void(0);" onclick="load(2)">Next ›</a></span></li></ul></span></td>
				</tr>
			  </tbody></table>
			</div>
			</div><!-- Carga los datos ajax -->
			
		
	
			
			
			
  </div>
</div>
		 
	</div>                 