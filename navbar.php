	<?php
		if (isset($title))
		{
	?>
<nav class="navbar navbar-default ">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Simple Stock</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class=""><a href="stock.php"><i class="glyphicon glyphicon-barcode"></i> Inventario</a></li>
		<li class=""><a href="categorias.php"><i class="glyphicon glyphicon-tags"></i> Categorías</a></li>
		<li class="active"><a href="reportes.php"><i class="glyphicon glyphicon-signal"></i> Reportes</a></li>
		<li class=""><a href="usuarios.php"><i class="glyphicon glyphicon-user"></i> Usuarios</a></li>
       </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="http://obedalvarado.pw/contacto/" target="_blank"><i class="glyphicon glyphicon-envelope"></i> Soporte</a></li>
		<li><a href="login.php?logout"><i class="glyphicon glyphicon-off"></i> Salir</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
	<?php
		}
	?>