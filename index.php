<?php

	// Cargamos las capas necesarias
	require_once("view/hospital.php");
	require_once("bl/logica.php");
	
	//Recogemos el nombre del script
	$script = $_SERVER['PHP_SELF'];
	
	// Imprimimos la cabecera de la página
	cabecera($script);
	
	// Obtenemos los enlaces
	//enlaces($script);
	
	// Obtenemos la operación o la fijamos por defecto
	extract($_GET);
	if (!isset($operacion) or empty($operacion)) {
		$operacion = 'home';
	}
	
	// Elegimos el código a ejecutar en función de la operación
	switch ($operacion) {
		case 'home': // Home
			home();
			break;
		case 'form_hospital': // Formulario Hospital
			$campos = obtener_campos_table_fk_logica('hospital', 'hospital');
			$valores = obtener_valores_de_una_tabla('hospital');
			mostrar_entidad('Hospital', $campos, $valores, 'hospital');
			break;
		case 'form_departamento': // Formulario Departamento
			$campos = obtener_campos_table_fk_logica('hospital', 'dept');
			$valores = obtener_valores_de_una_tabla('dept');
			mostrar_entidad('Departamento', $campos, $valores, 'dept');
			break;
		case 'form_empleado': // Formulario Empleado
			$campos = obtener_campos_table_fk_logica('hospital', 'emp');
			$valores = obtener_valores_de_una_tabla('emp');
			mostrar_entidad('Empleado', $campos, $valores, 'emp');
			break;
		case 'form_doctor': // Formulario Doctor
			$campos = obtener_campos_table_fk_logica('hospital', 'doctor');
			$valores = obtener_valores_de_una_tabla('doctor');
			mostrar_entidad('Doctor', $campos, $valores, 'doctor');
			break;
		case 'form_sala': // Formulario Sala
			$campos = obtener_campos_table_fk_logica('hospital', 'sala');
			$valores = obtener_valores_de_una_tabla('sala');
			mostrar_entidad('Sala', $campos, $valores, 'sala');
			break;
		case 'form_plantilla': // Formulario Plantilla
			$campos = obtener_campos_table_fk_logica('hospital', 'plantilla');
			$valores = obtener_valores_de_una_tabla('plantilla');
			mostrar_entidad('Plantilla', $campos, $valores, 'plantilla');
			break;
		case 'form_enfermo': // Formulario Enfermo
			$campos = obtener_campos_table_fk_logica('hospital', 'enfermo');
			$valores = obtener_valores_de_una_tabla('enfermo');
			mostrar_entidad('Enfermo', $campos, $valores, 'enfermo');
			break;
		case 'alta': // Formulario para añadir según Tabla (dinámico)
			$nombre_entidad = $_GET['nombre_entidad'];
			$table = $_GET['table'];
			$fk_table_values = obtener_fk_logica('hospital', $table);
			if ($fk_table_values) {
				$campos = obtener_campos_table_no_fk_logica('hospital', $table);
				dar_de_alta_registros_segun_tabla($nombre_entidad, $campos, $table, $script, $fk_table_values);
			} else {
				$campos = obtener_campos_table_fk_logica('hospital', $table);
				dar_de_alta_registros_segun_tabla($nombre_entidad, $campos, $table, $script, $fk_table_values=null);
			}
			break;
		case 'alta_function': // Funciones para añadir registros a la bbdd
			extract($_POST);
			$form_data = $_POST;
			$count = count($form_data);
			$table = '';
			$nombre_entidad = '';
			$campos = '';
			$valores = '';
			//echo var_dump($form_data);
			
			foreach($form_data as $key=>$value) {
				if ($key == 'table') { $table .= $value; }
				if (--$count <= 1) { // Skip last 2 iteration => submit and hidden fields
					break;
				}
				
				$campos .= $key.',';
				$valores .= "'".$value."',";
			}
			
			$splitted = preg_split ("/\,/", $table);
			$i = 0;
			$len = count($splitted);
			foreach ($splitted as $item) {
				if ($i == 0) {
					// table
					$table = '';
					$table .= $item;
				} else if ($i == $len - 1) {
					// nombre_entidad
					$nombre_entidad .= $item;
				}
				$i++;
			}
			
			// Se lo pasamos a la funcion quitando el último caracter q es una coma
			insertar_nuevo_registro($table, rtrim($campos, ","), rtrim($valores, ","), strtolower($nombre_entidad));
			break;
		case 'baja':
			extract($_GET);
			$get_values = $_GET;
			$id = '';
			$field = '';
			$table = '';
			$nombre_entidad = '';
			
			foreach($get_values as $key=>$value) {
				if ($key == 'id') {
					$id .= $value;
				} elseif ($key == 'field') {
					$field .= $value;
				} elseif ($key =='table') {
					$table .= $value;
				}elseif ($key =='nent') {
					$nombre_entidad .= $value;
				}
			}
			
			baja_registro($table, $field, $id, strtolower($nombre_entidad));
			break;
	}
?>