<?php
	include("sesiones.php");
	include("conexionBD.php"); 
	$idUsuario="-1";
	if(isset($_POST["idUsuario"]))
		$idUsuario=$_POST["idUsuario"];
	$ciclo=$_POST["ciclo"];
	$idGrado=$_POST["idGrado"];
	$idGrupo=$_POST["idGrupo"];
	if($idGrupo=="-1")
		$idGrupo="NULL";
	$idSeccion=$_POST["idSeccion"];
	$redireccionar=false;
	$cadena="";
	if($idGrado!=0)
	{
		$cadena=" and idGrado=".$idGrado;
	}
	
	$conMapa="SELECT idMapaCurricular FROM 4029_mapaCurricular WHERE idPrograma=".$idSeccion." AND ciclo=".$ciclo;
	$idMapaCurricular=$con->obtenerValor($conMapa);
	
	$conMaterias="SELECT idMateria,idGrado FROM 4031_elementosMapa WHERE idMapaCurricular=".$idMapaCurricular." AND idTipoMateria=1".$cadena;
	$resMaterias=$con->obtenerFilas($conMaterias);
	
	$consulta="begin";
	$ct=0;
	if($con->ejecutarConsulta($consulta))
	{
		
	$consulta="select idAlumnoTabla from 4118_alumnos where ciclo=".$ciclo." and idUsuario=".$idUsuario." and idPrograma=".$idSeccion;
	$idAlumno=$con->obtenerValor($consulta);
		
		if($idAlumno=="")
			$query[$ct]="insert into 4118_alumnos(ciclo,idPrograma,idGrado,idGrupo,idUsuario) values(".$ciclo.",".$idSeccion.",".$idGrado.",".$idGrupo.",".$idUsuario.")";
		else
			$query[$ct]="update 4118_alumnos set ciclo=".$ciclo.",idPrograma=".$idSeccion.",idGrado=".$idGrado.",idGrupo=".$idGrupo." where idAlumnoTabla=".$idAlumno;
		$ct++;
		while($fila=mysql_fetch_row($resMaterias))
		{
			$conExiste="SELECT idAlumnosElementoMapa FROM 4120_alumnosVSElementosMapa WHERE idMAteria=".$fila[0]." AND idGrupo=".$idGrupo." AND idPrograma=".$idSeccion." AND situacion=2 AND idUsuario=".$idUsuario ;
			$existe=$con->obtenerValor($conExiste);
			if($existe=="")
			{
				$query[$ct]="INSERT INTO 4120_alumnosVSElementosMapa (idMateria,idGrupo,idPrograma,situacion,idUsuario) VALUES('".$fila[0]."',".$idGrupo.",'".$idSeccion."','2','".$idUsuario."')" ;
				$ct++;
			}
			else
			{
				$query[$ct]="update 4120_alumnosVSElementosMapa set idGrupo=".$idGrupo.",situacion='2' where idAlumnosElementoMapa=".$existe ;
				$ct++;
			}
		}
		$query[$ct]="commit";
		if($con->ejecutarBloque($query));
		{
			$redireccionar=true;
		}
	}
	//$consulta="select idAlumnoTabla from 4118_alumnos where ciclo=".$ciclo." and idUsuario=".$idUsuario;
//	$idAlumno=$con->obtenerValor($consulta);
//	if($idAlumno=="")
//		$consulta="insert into 4118_alumnos(ciclo,idPrograma,idGrado,idGrupo,idUsuario) values(".$ciclo.",".$idSeccion.",".$idGrado.",".$idGrupo.",".$idUsuario.")";
//	else
//		$consulta="update 4118_alumnos set ciclo=".$ciclo.",idPrograma=".$idSeccion.",idGrado=".$idGrado.",idGrupo=".$idGrupo." where idAlumnoTabla=".$idAlumno;
//	if($con->ejecutarConsulta($consulta));
//	{
//		$redireccionar=true;
//	}
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<form action="intermediaMostrar.php" method="post" id="frmEnvio">
	<input type="hidden" name="idUsuario" value="<?php echo $idUsuario?>" />
</form>
<?php
	if($redireccionar)
	{
?>
<script>
		document.getElementById('frmEnvio').submit();
</script>
<?php } ?>
</body>
</html>