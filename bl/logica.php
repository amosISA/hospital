<?php
	require_once('bd/bd.php');
	
	function obtener_campos_table_no_fk_logica($database, $table) {
		$con = abrir_conexion_bd();
		$campos = obtener_campos_table_no_fk_bd($con, $database, $table);
		return $campos;
	}
	
	function obtener_campos_table_fk_logica($database, $table) {
		$con = $con = mysqli_connect('localhost', 'root', '', 'hospital') or
		  die ("Imposible realizar la conexión $user@$host");
		$campos = obtener_campos_table_fk_bd($con, $database, $table);
		return $campos;
	}
	
	function obtener_fk_logica($database, $table) {
		$con = $con = mysqli_connect('localhost', 'root', '', 'hospital') or
		  die ("Imposible realizar la conexión $user@$host");
		$fk_table_values = obtener_fk_bd($con, $database, $table);
		return $fk_table_values;
	}
	
	function obtener_valores_de_una_tabla($table) {
		$con = $con = mysqli_connect('localhost', 'root', '', 'hospital') or
		  die ("Imposible realizar la conexión $user@$host");
		$valores = obtener_valores_tabla($con, $table);
		return $valores;
	}
	
	function insertar_nuevo_registro($table, $campos, $valores, $nombre_entidad) {
		$con = abrir_conexion_bd();
		add_nuevo_registro($con, $table, $campos, $valores, $nombre_entidad);
	}
	
	function baja_registro($table, $field_id, $id, $nombre_entidad) {
		$con = abrir_conexion_bd();
		baja_registro_bd($con, $table, $field_id, $id, $nombre_entidad);
	}
?>