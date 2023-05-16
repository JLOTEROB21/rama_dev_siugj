<?php session_start();
	;
	include("funcionesFormularios.php"); 
	include("configurarIdioma.php");
	include_once("cAlmacen.php");
	if(isset($_SESSION["leng"]))
	{
		$z=0;
		$consultaS;
		if(isset($_POST["parametros"]))
			$parametros=$_POST["parametros"];
		if(isset($_POST["funcion"]))
			$funcion=$_POST["funcion"];
		$lenguaje=$_SESSION["leng"];
		
		switch($funcion)
		{
			case 1:
				obtenerPacientes();
			break;
			case 2:
				obtenerIdDireccion();
			break;
			case 3:
				obtenerMedicosEspecialidad();
			break;
			case 4:
				buscarPaciente();
			break;
			case 5:
				guardarCita();
			break;
			case 6:
				obtenerCitas();
			break;
			case 7:
				obtenerCitasMedico();
			break;
			case 8:
				obtenerEstudiosLaboratorioDisciplina();
			break;
			case 9:
				obtenerDiagnosticos();
			break;
			case 10:
				obtenerHistorialConsulta();
			break;
		}
	}


function obtenerPacientes()
{
	global $con;
	$start=$_POST["start"];
	$limit=$_POST["limit"];
	$condWhere=" 1=1 ";
	if(isset($_POST["filter"]))
	{
		$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
	}
	$consulta="SELECT id__989_tablaDinamica AS idPaciente,apPaterno,apMaterno,nombre,fechaNacimiento,genero,estadoCivil,
	(SELECT idArchivoImagen FROM 9058_imagenesControlGaleria WHERE idElementoFormulario=7453 AND idRegistro=t.id__989_tablaDinamica limit 0,1)as imagen FROM _989_tablaDinamica t 
	where ".$condWhere." ORDER BY apPaterno,apMaterno,nombre limit ".$start.",".$limit;
	$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
	$consulta="SELECT count(*) FROM _989_tablaDinamica where ".$condWhere;
	$numReg=$con->obtenerValor($consulta);
	echo '{"numReg":"'.$numReg.'","registros":'.$arrRegistros.'}';
}

function obtenerIdDireccion()
{
	global $con;
	$idRegistro=$_POST["idRegistro"];
	$consulta="SELECT id__990_tablaDinamica FROM _990_tablaDinamica WHERE idReferencia=".$idRegistro;
	$idDireccion=$con->obtenerValor($consulta);	
	if($idDireccion=="")
		$idDireccion=-1;
	echo "1|".$idDireccion;
	
}

function obtenerMedicosEspecialidad()
{
	global $con;
	$idEspecialidad=$_POST["idEspecialidad"];
	$consulta="SELECT u.idUsuario,CONCAT(u.Paterno,' ', u.Materno,' ',u.Nom) AS nombre FROM _1005_medicosEspecialidad m,_1005_tablaDinamica e,802_identifica u WHERE e.id__1005_tablaDinamica=".$idEspecialidad." and
				m.idReferencia=e.id__1005_tablaDinamica AND u.idUsuario=m.medico ORDER BY u.Paterno, u.Materno,u.Nom";

	$arrRegistros=$con->obtenerFilasArreglo($consulta);
	echo "1|".$arrRegistros;
	
}

function buscarPaciente()
{
	global $con;
	$condicion=$_POST["condicion"];
	$consulta="select * from (
				SELECT id__989_tablaDinamica as idUsuario, CONCAT(apPaterno,' ',apMaterno,' ',nombre) AS nombre,
				(SELECT idArchivoImagen FROM 9058_imagenesControlGaleria WHERE idElementoFormulario=7453 AND idRegistro=t.id__989_tablaDinamica LIMIT 0,1)AS imagen
				 FROM _989_tablaDinamica t
	) as tmp where nombre like '%".$condicion."%' order by nombre";

	$res=$con->obtenerFilas($consulta);
	$arrRegistros="";
	
	while($fila=mysql_fetch_row($res))
	{
		$imagen="../images/imgNoDisponible.jpg";
		if($fila[2]!="")
		{
			$imagen="../paginasFunciones/obtenerArchivos.php?id=".bE($fila[2]);	
		}
		$o='{"idUsuario":"'.$fila[0].'","nombre":"'.cv($fila[1]).'","imagen":"'.$imagen.'"}';	
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
	}
	
	$numReg=$con->filasAfectadas;
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	
}

function guardarCita()
{
	global $con;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);	
	$consulta="INSERT INTO 1200_citasMedicas(fecha,hora,idEspecialidad,idMedico,idUsuario) VALUES('".$obj->fecha."','".$obj->hora."',".$obj->idEspecialidad.",".$obj->idMedico.",".$obj->idPaciente.")";
	eC($consulta);
}

function obtenerCitas()
{
	global $con;
	
	$idEspecialidad=$_POST["idEspecialidad"];
	$idMedico=$_POST["idMedico"];
	$fechaInicio=$_POST["start"];
	$fechaFin=$_POST["end"];
	
	$dFecha=explode("-",$fechaInicio);
	$fechaInicio=$dFecha[2]."-".$dFecha[0]."-".$dFecha[1];
	$dFecha=explode("-",$fechaFin);
	$fechaFin=$dFecha[2]."-".$dFecha[0]."-".$dFecha[1];	
	$arrEvento="";
	
	
	
	
	
	/*$consulta="SELECT * FROM 1200_citasMedicas WHERE fecha>='".$fechaInicio."' AND fecha<='".$fechaFin."' and idEspecialidad=".$idEspecialidad." and idMedico=".$idMedico;
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT concat(apPaterno,' ',apPaterno,' ',nombre) FROM _989_tablaDinamica WHERE  id__989_tablaDinamica=".$fila[5];
		$nombrePaciente=$con->obtenerValor($consulta);
		
		$obj='	{
					  "id": "'.$fila[0].'",
					  "cid": "1",
					  "title": "<span title=\'Cita con paciente: '.cv($nombrePaciente).'\' alt=\'Cita con paciente: '.cv($nombrePaciente).'\'> Cita con paciente: '.cv($nombrePaciente).'</span>",
					  "start": "'.$fila[1].' '.$fila[2].'",
					  "end": "'.$fila[1].' '.date("H:i:s",strtotime("+30 minutes",strtotime($fila[2]))).'",
					  "ad": 0,
					  "notes": "",
					  "loc":"'.$fila[5].'",
					  "url":"",
					  "rem":"",
					  "rO":0,
					  "tipoEvento":"1"
				  }';
		if($arrEvento=="")
			$arrEvento=$obj;
		else
			$arrEvento.=",".$obj;	
	}*/
	echo  	'{
				  "evts": ['.$arrEvento.']
			  }';
}

function obtenerCitasMedico()
{
	global $con;
	
	
	$idMedico=$_POST["idMedico"];
	$fechaInicio=$_POST["start"];
	$fechaFin=$_POST["end"];
	
	$dFecha=explode("-",$fechaInicio);
	$fechaInicio=$dFecha[2]."-".$dFecha[0]."-".$dFecha[1];
	$dFecha=explode("-",$fechaFin);
	$fechaFin=$dFecha[2]."-".$dFecha[0]."-".$dFecha[1];	
	$arrEvento="";
	$consulta="SELECT * FROM 1200_citasMedicas WHERE fecha>='".$fechaInicio."' AND fecha<='".$fechaFin."' and  idMedico=".$idMedico;
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT concat(apPaterno,' ',apPaterno,' ',nombre) FROM _989_tablaDinamica WHERE  id__989_tablaDinamica=".$fila[5];
		$nombrePaciente=$con->obtenerValor($consulta);
		
		$obj='	{
					  "id": "'.$fila[0].'",
					  "cid": "1",
					  "title": "<span title=\'Cita con paciente: '.cv($nombrePaciente).'\' alt=\'Cita con paciente: '.cv($nombrePaciente).'\'> Cita con paciente: '.cv($nombrePaciente).'</span>",
					  "start": "'.$fila[1].' '.$fila[2].'",
					  "end": "'.$fila[1].' '.date("H:i:s",strtotime("+30 minutes",strtotime($fila[2]))).'",
					  "ad": 0,
					  "notes": "",
					  "loc":"'.$fila[5].'",
					  "url":"",
					  "rem":"",
					  "rO":0,
					  "tipoEvento":"1"
				  }';
		if($arrEvento=="")
			$arrEvento=$obj;
		else
			$arrEvento.=",".$obj;	
	}
	echo  	'{
				  "evts": ['.$arrEvento.']
			  }';
}


function obtenerEstudiosLaboratorioDisciplina()
{	
	global $con;
	$idDiciplina=$_POST["idDiciplina"];
	$consulta="SELECT id__1008_tablaDinamica,estudio,preparacionPaciente FROM _1008_tablaDinamica WHERE disciplina=".$idDiciplina." ORDER BY estudio";
	$arrDisciplina=$con->obtenerFilasArreglo($consulta);
	echo "1|".$arrDisciplina;
}

function obtenerDiagnosticos()
{
	global $con;
	$condicion=$_POST["query"];
	$consulta="SELECT id__994_tablaDinamica,enfermedad FROM _994_tablaDinamica WHERE enfermedad LIKE '%".$condicion."%'";

	$res=$con->obtenerFilas($consulta);
	$arrRegistros="";
	
	while($fila=mysql_fetch_row($res))
	{
		
		$o='{"idEnfermedad":"'.$fila[0].'","enfermedad":"'.cv($fila[1]).'"}';	
		if($arrRegistros=="")
			$arrRegistros=$o;
		else
			$arrRegistros.=",".$o;
	}
	
	$numReg=$con->filasAfectadas;
	echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
}

function obtenerHistorialConsulta()
{
	global $con;	
	$idUsuario=$_POST["idUsuario"];
	$consulta="	SELECT id__1003_tablaDinamica as idConsulta,u.nombre as medico, fechaCreacion as fechaConsulta  FROM _1003_tablaDinamica t, 800_usuarios u WHERE idReferencia IN (
				SELECT idCita FROM 1200_citasMedicas WHERE idUsuario=".$idUsuario.") AND u.idUsuario=t.responsable ORDER BY fechaCreacion DESC";
	$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));			
	$numReg=$con->filasAfectadas;
	echo '{"numReg":"'.$numReg.'","registros":'.$arrRegistros.'}';
}
?>