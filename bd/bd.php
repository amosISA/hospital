<?php
	function abrir_conexion_bd() {
		require_once("config/config.php");
		$con = mysqli_connect($host, $user, $password, $database) or
		  die ("Imposible realizar la conexión $user@$host");
		return $con;
	}
	
	function obtener_campos_table_no_fk_bd($connection, $database, $table) {
		$sentencia = "SELECT COLUMN_NAME
						FROM INFORMATION_SCHEMA.COLUMNS
						WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$table' AND COLUMN_KEY <> 'MUL'";
						
		$rs = mysqli_query($connection, $sentencia) or 
		  die ("Error de consulta" . $connection -> error);
		return $rs;
	}
	
	function obtener_campos_table_fk_bd($connection, $database, $table) {
		$sentencia = "SELECT COLUMN_NAME
						FROM INFORMATION_SCHEMA.COLUMNS
						WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$table'";
						
		$rs = mysqli_query($connection, $sentencia) or 
		  die ("Error de consulta" . $connection -> error);
		return $rs;
	}
	
	function obtener_fk_bd($connection, $database, $table) {
		$search_fks = "SELECT i.TABLE_NAME, i.CONSTRAINT_TYPE, i.CONSTRAINT_NAME, k.REFERENCED_TABLE_NAME, k.REFERENCED_COLUMN_NAME 
						FROM information_schema.TABLE_CONSTRAINTS i 
						LEFT JOIN information_schema.KEY_COLUMN_USAGE k ON i.CONSTRAINT_NAME = k.CONSTRAINT_NAME 
						WHERE i.CONSTRAINT_TYPE = 'FOREIGN KEY' 
						AND i.TABLE_SCHEMA = '$database'
						AND i.TABLE_NAME = '$table'";
				
		$rs = mysqli_query($connection, $search_fks);
		
		if(mysqli_num_rows($rs) > 0){
			$referenced_table = '';
			foreach ($rs as $v) {
				$referenced_table .= $v['REFERENCED_TABLE_NAME'];
				break; // only one iteration bc plantillas has the same FK pointer
			}
			
			$sentencia = "SELECT * FROM $database.$referenced_table";
			
			$rs2 = mysqli_query($connection, $sentencia) or 
			  die ("Error de consulta" . $connection -> error);
			return $rs2;
		}
	}
	
	function obtener_valores_tabla($connection, $table) {
		$sentencia = "SELECT * FROM HOSPITAL.$table";
		$rs = mysqli_query($connection, $sentencia) or 
		  die ("Error de consulta: " . $connection -> error);
		return $rs;
	}
	
	function add_nuevo_registro($connection, $tabla, $campos, $valores, $nombre_entidad) {
		$sentencia = "INSERT INTO $tabla ($campos) VALUES($valores)";
		
		if (mysqli_query($connection, $sentencia)) {
			header("location:index.php?operacion=form_$nombre_entidad&msg=ras");
		} else {
			$error = $connection -> error;
			header("location:index.php?operacion=form_$nombre_entidad&msg=rna&mtv=$error");
		}
	}
	
	function baja_registro_bd($connection, $table, $field_id, $id, $nombre_entidad) {
		$sentencia = "DELETE FROM $table WHERE $field_id='$id'";
		
		if (mysqli_query($connection, $sentencia)) {
			header("location:index.php?operacion=form_$nombre_entidad&msg=del");
		} else {
			$error = $connection -> error;
			header("location:index.php?operacion=form_$nombre_entidad&msg=rna&mtv=$error");
		}
		
		//mysqli_query($connection, $sentencia) or
		  // die ('Error de eliminación: ' . $connection -> error);
		//return mysqli_affected_rows($connection);
	}
?>