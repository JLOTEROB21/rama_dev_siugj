<?php session_start();
	include("conexionBD.php"); 
	if (!empty($_FILES['archivo']['name']))
	{
		try
		{
			$binario_nombre_temporal=$_FILES['archivo']['tmp_name'] ;
			$binario_contenido='';
			$binario_contenido = addslashes(fread(fopen($binario_nombre_temporal, "rb"), filesize($binario_nombre_temporal)));
			$binario_nombre=$_FILES['archivo']['name'];
			$binario_peso=$_FILES['archivo']['size'];
			$binario_tipo=$_FILES['archivo']['type'];
			$consulta_insertar = "insert into 4022_alumnoVsDocumento(idAlumno,idDocumento,documento,idEstadoDocumento,fechaCreacion,responsable,nomArchivoOriginal,tipoArchivo,tamano)
									values(".$_POST["hIdAlumno"].",".$_POST["hIdDoc"].",'".$binario_contenido."',3,'".date('Y-m-d')."',".$_SESSION["idUsr"].",
									'".$binario_nombre."','".$binario_tipo."','".$binario_peso."')";
			$consulta_borrar = "DELETE FROM 4022_alumnoVsDocumento WHERE idAlumnoVsDocumento='".$_POST['idAlumnoDoc']. "' ";
			$con->ejecutarConsulta($consulta_borrar);
			$con->ejecutarConsulta($consulta_insertar);
			$idDoc=$con->obtenerUltimoID();
			$consulta="select nombreEstadoDoc from 4023_estadoDocumento where idEstadoDocumento=3";
			$estado=$con->obtenerValor($consulta);
			echo '{"success":true,"idDoc":"'.$idDoc.'","estado":"'.$estado.'","tipoDoc":"'.$_POST["hIdDoc"].'"}';
		}
		catch(Exception $e)
		{
			echo '{"success":false,"error":"'.$e->getMessage().'"}';
		}
	}

?>