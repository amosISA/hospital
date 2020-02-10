<?php
	function cabecera($script) {
?>

<!DOCTYPE html>
<html lang="es">
 <head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Hospital</title>
	
	<link rel="shortcut icon" href="https://demo.learncodeweb.com/favicon.ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
 </head>

 <body>
	<div class="bg-light border-bottom shadow-sm sticky-top" style="margin-bottom:50px;">
		<div class="container">
			<header class="blog-header py-1">
				<nav class="navbar navbar-expand-lg navbar-light bg-light"> <a class="navbar-brand text-muted p-0 m-0" href="<?php echo $script . "?operacion=home" ?>"><b>ASIX 2020</b></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav mr-auto" style="margin-left:30px;">
							<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="menu-item-17" class="nav-item"><a title="Hospitales" href="<?php echo $script . "?operacion=form_hospital" ?>" class="nav-link">Hospitales</a></li>
							<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="menu-item-16" class="nav-item"><a title="Departamentos" href="<?php echo $script . "?operacion=form_departamento" ?>" class="nav-link">Departamentos</a></li>
							<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="menu-item-558" class="nav-item"><a title="Empleados" href="<?php echo $script . "?operacion=form_empleado" ?>" class="nav-link">Empleados</a></li>
							<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="menu-item-14" class="nav-item"><a title="Doctores" href="<?php echo $script . "?operacion=form_doctor" ?>" class="nav-link">Doctores</a></li>
							<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="menu-item-559" class="nav-item"><a title="Salas" href="<?php echo $script . "?operacion=form_sala" ?>" class="nav-link">Salas</a></li>
							<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="menu-item-15" class="nav-item"><a title="Plantillas" href="<?php echo $script . "?operacion=form_plantilla" ?>" class="nav-link">Plantillas</a></li>
							<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="menu-item-15" class="nav-item"><a title="Enfermos" href="<?php echo $script . "?operacion=form_enfermo" ?>" class="nav-link">Enfermos</a></li>
						</ul>
					</div>
				</nav>
			</header>
		</div> <!--/.container-->
	</div>
	
	<?php
		}
		function mostrar_entidad($nombre_entidad, $campos, $valores, $table) {
	?>
	
	<div class="container">
	
		<?php

			if(isset($_REQUEST['msg']) and $_REQUEST['msg']=="ras"){
				echo	'<div class="alert alert-success"><i class="fa fa-thumbs-up"></i> Registro añadido!</div>';
			}elseif(isset($_REQUEST['msg']) and $_REQUEST['msg']=="rna"){
				echo	'<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Registro no añadido: <strong>' . $_REQUEST['mtv'] . '!</strong></div>';
			}elseif(isset($_REQUEST['msg']) and $_REQUEST['msg']=="del"){
				echo	'<div class="alert alert-success"><i class="fa fa-exclamation-triangle"></i><strong> Registro borrado correctamente!</strong></div>';
			}

		?>
		
		<div class="card">
			<div class="card-header"><i class="fa fa-fw fa-globe"></i> <strong>Listado</strong> <a href="<?php echo $_SERVER['PHP_SELF'] . "?operacion=alta&nombre_entidad=$nombre_entidad&table=$table" ?>" class="float-right btn btn-dark btn-sm"><i class="fa fa-fw fa-plus-circle"></i> Añadir</a></div>
			<div class="card-body">
				<div class="col-sm-12">
					<h5 class="card-title"><i class="fa fa-fw fa-search"></i> Buscar <?php echo $nombre_entidad; ?></h5>
					<form action="" method="post">
						<div class="row">
							<div class="col-6">
								<div class="form-group">
									<input type="text" name="search" id="search" class="form-control" placeholder="¿Qué quieres buscar?">
									<label>&nbsp;</label>
									<div>
										<button type="submit" name="submit" value="search" id="submit" class="btn btn-primary"><i class="fa fa-fw fa-search"></i> Buscar</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<hr>
		
		<div>
			<table class="table table-striped table-bordered">
				<?php
					// SEARCH ENGINE - Buscar registros
					if($_POST){
						$search_value=$_POST["search"];
						$con=new mysqli('localhost','root','','hospital');
						if($con->connect_error){
							echo 'Connection Faild: '.$con->connect_error;
						}else{
							$array_fields = array();
							foreach ($campos as $value){ 
								foreach ($value as $val){ 
									array_push($array_fields, $val);
								}
							} 
							
							$my_custom_sql = "select * from $table where ";
							foreach ($array_fields as $val) {
								$my_custom_sql .= "$val like '%$search_value%' or ";
							}
							
							$sql=substr($my_custom_sql, 0, -3);
							$res=$con->query($sql);
				?>			
				
				<thead>
					<tr class="bg-primary text-white">
						<?php
							// Recorremos los campos de cada tabla
							foreach ($campos as $value){ 
								foreach ($value as $val){ 
									echo '<th>' . $val . '</th>';
								}
							} 
						?>
						<th class="text-center">Acción</th>
					</tr>
				</thead>
				<tbody>
					
						<?php
						
							// Metemos los valores en un array para recorrerlos
							// De lo contrario estaríamos recorriendo un objeto de mysql
							$array_de_valores = array();
							while ($valor=mysqli_fetch_array($res)) {
								
								foreach ($res as $val) {
									array_push($array_de_valores, $val);
									
								}
							}
							
							$j = 0;
							$len2 = count($valores);
							$table_field_name2='';
							foreach($valores as $key=>$val) {
								foreach($val as $k=>$v) {
									if ($j == 0) {
										$table_field_name2 .= $k;
									}
									$j++;
									break;
								}
							}
							
							// Metemos los valores en la tabla
							$keys = array_keys($array_de_valores);
							for($i = 0; $i < count($array_de_valores); $i++) {
								$first_value_id = reset($array_de_valores[$keys[$i]]);
								echo "<tr>";
								foreach($array_de_valores[$keys[$i]] as $key => $value) {
									echo '<td id="' . $value . '">' . $value . '</td>';
								}
								
								//<a href="edit-users.php?editId='.$first_value_id.'" class="text-primary"><i class="fa fa-fw fa-edit"></i> Editar</a> |
								echo '<td align="center">
										<a onclick="return confirm(' . "'Desea borrar el registro?'" . ')" href="'. $_SERVER['PHP_SELF'] . '?operacion=baja&id='.$first_value_id. '&field='. $table_field_name2 .'&table='. $table .'&nent='.$nombre_entidad.'" class="text-danger"><i class="fa fa-fw fa-trash"></i> Borrar</a>
									  </td></tr>';
							}
						?>
						
					</tr>
				</tbody>
					
				<?php
						}
					} else {
				?>
				
				<thead>
					<tr class="bg-primary text-white">
						<?php
							// Recorremos los campos de cada tabla
							foreach ($campos as $value){ 
								foreach ($value as $val){ 
									echo '<th>' . $val . '</th>';
								}
							} 
						?>
						<th class="text-center">Acción</th>
					</tr>
				</thead>
				<tbody>
					
						<?php
						
							// Metemos los valores en un array para recorrerlos
							// De lo contrario estaríamos recorriendo un objeto de mysql
							$array_de_valores = array();
							while ($valor=mysqli_fetch_array($valores)) {
								
								foreach ($valores as $val) {
									array_push($array_de_valores, $val);
									
								}
							}
							
							$i = 0;
							$len = count($valores);
							$table_field_name='';
							foreach($valores as $key=>$val) {
								foreach($val as $k=>$v) {
									if ($i == 0) {
										$table_field_name .= $k;
									}
									$i++;
									break;
								}
							}
							
							// Metemos los valores en la tabla
							$keys = array_keys($array_de_valores);
							for($i = 0; $i < count($array_de_valores); $i++) {
								$first_value_id = reset($array_de_valores[$keys[$i]]);
								echo "<tr>";
								foreach($array_de_valores[$keys[$i]] as $key => $value) {
									echo '<td id="' . $value . '">' . $value . '</td>';
								}
								
								//<a href="edit-users.php?editId='.$first_value_id.'" class="text-primary"><i class="fa fa-fw fa-edit"></i> Editar</a> |
								echo '<td align="center">
										<a onclick="return confirm(' . "'Desea borrar el registro?'" . ')" href="'. $_SERVER['PHP_SELF'] . '?operacion=baja&id='.$first_value_id. '&field='. $table_field_name .'&table='. $table .'&nent='.$nombre_entidad.'" class="text-danger"><i class="fa fa-fw fa-trash"></i> Borrar</a>
									  </td></tr>';
							}
						?>
						
					</tr>
				</tbody>
			</table>
		</div> <!--/.col-sm-12-->
		
	</div>
	
	<?php
					}
		}
		function home() {
	?>
	
	<div class="container">
		<div class="row">
			<div class="col-3">
				<h4>GRUPO</h4>
				<ul class="list-group">
					<li class="list-group-item">Asier Guardiola</li>
					<li class="list-group-item">Ferran Esteve</li>
					<li class="list-group-item">Hodei Cortajanera</li>
					<li class="list-group-item">Geoffrey Gonzalez</li>
					<li class="list-group-item">Jose Manuel Gil</li>
					<li class="list-group-item">Bryan Andino</li>
					<li class="list-group-item">Amos Isaila</li>
				</ul>
			</div>
			<div class="col">
				<h4>GESTIÓN DE UN HOSPITAL</h4>
				<div>Con la siguiente Web realizada con PHP pretendemos automatizar 
				toda la gestión realativa a un hospital determinado.</div><br />
				
				<div><u>Cosas que podemos hacer con cada enlace de la barra de navegación</u>:</div>
				
				<ul>
					<li>Obtener un listado de la entidad respectiva</li>
					<li>Crear, modificar o eliminar cualquier camp</li>
					<li>Buscar registros</li>
				</ul>
			</div>
		</div>
	</div>
	
	<?php
		}
		function dar_de_alta_registros_segun_tabla($nombre_entidad, $campos, $table, $script, $fk_table_values) {
	?>
		
		<div class="container">
			<div class="card">
				<div class="card-header"><i class="fa fa-fw fa-plus-circle"></i> <strong>Añadir <?php echo $nombre_entidad; ?></strong> <a href="<?php echo $script . "?operacion=form_" . strtolower($nombre_entidad); ?>" class="float-right btn btn-dark btn-sm"><i class="fa fa-fw fa-globe"></i> Listado <?php echo $nombre_entidad; ?></a></div>
				<div class="card-body">
					<div class="col-sm-6">
						<?php
							if(isset($_REQUEST['msg']) and $_REQUEST['msg']=="un"){
								echo	'<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Record not added <strong>Please try again!</strong></div>';
							}
						?>
					
						<h5 class="card-title">Los campos con <span class="text-danger">*</span> son obligatorios!</h5>
						<form method="post" action="<?php echo "$script?operacion=alta_function"; ?>">
						
							<?php 
								// Creamos los inputs relacionados con otras tablas
								if (isset($fk_table_values)) {
									$field_name_col = '';
									$i = 0;
									$len = count($fk_table_values);
									foreach($fk_table_values as $key=>$value) {
										foreach ($value as $k=>$val){ 
											if ($i == 0) { $field_name_col .= $k.',';}break;
										}
									}
							?>
									
							<div class="form-group">
								<label><?php echo current(explode(',', $field_name_col)); ?> <span class="text-danger">*</span></label>
								<select class="browser-default custom-select" name="<?php echo current(explode(',', $field_name_col)); ?>">
									<option selected>Elige un valor</option>
										
								<?php
										$i = 0;
										$len = count($fk_table_values);
										foreach($fk_table_values as $key=>$value) {
											foreach ($value as $k=>$val){ 
								?>
												<option value="<?php if ($i == 0) { echo $val; ?>"><?php echo $val;}break; ?> </option>
											
												<?php
											}
										}
									}
								?>
								
								</select>
							</div>
							
							<?php
								// Creamos los inputs para añadir
								if ($table == 'enfermo') {
									foreach ($campos as $value){ 
										foreach ($value as $k=>$val){
											if ($val == 'S') {
											?>
												<div class="custom-control custom-radio" name="<?php echo $val; ?>" style="margin-top:10px;">
													<input type="radio" class="custom-control-input" id="defaultGroupExample1" name="<?php echo $val; ?>" value="M">
													<label class="custom-control-label" for="defaultGroupExample1">Hombre</label>
												</div>
												
												<div class="custom-control custom-radio" name="<?php echo $val; ?>" style="margin-bottom:10px;">
													<input type="radio" class="custom-control-input" id="defaultGroupExample2" name="<?php echo $val; ?>" value="F">
													<label class="custom-control-label" for="defaultGroupExample2">Mujer</label>
												</div>
											<?php
											} else {
										?>
												<div class="form-group">
													<label><?php echo $val; ?> <span class="text-danger">*</span></label>
													<input type="text" name="<?php echo $val; ?>" id="<?php echo $val; ?>" class="form-control" placeholder="Introduzca <?php echo $val; ?>" required>
												</div>
										<?php
											}
										}
									}
								} else {
									foreach ($campos as $value){ 
										foreach ($value as $k=>$val){ 
							?>
							
							<div class="form-group">
								<label><?php echo $val; ?> <span class="text-danger">*</span></label>
								<input type="text" name="<?php echo $val; ?>" id="<?php echo $val; ?>" class="form-control" placeholder="Introduzca <?php echo $val; ?>" required>
							</div>
							
							<?php
										}
									}
								} 
							?>
							
							<input type="hidden" id="table" name="table" value="<?php echo $table . ',' . $nombre_entidad; ?>">
							<div class="form-group">
								<button type="submit" name="submit" value="submit" id="submit" class="btn btn-primary"><i class="fa fa-fw fa-plus-circle"></i> Añadir <?php echo $nombre_entidad; ?></button>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>
	<?php
		}
	?>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  </body>
</html>
<!-- FIN -->