<?php session_start();
	include_once("conexionBD.php");
	include_once("utiles.php");
	

	
	;
	
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	$lenguaje=$_SESSION["leng"];
	
	switch($funcion)
	{
		case 1:
			obtenerHistorialObjeto();
		break;
		case 2:
			registrarCambioSituacionCObjeto();
		break;
		
	}
	
	function obtenerHistorialObjeto()
	{
		global $con;
		$tipoObjeto=$_POST["tipoObjeto"];
		$idRegistro=$_POST["idRegistro"];
		
		$consulta="SELECT idRegistro,fechaOperacion,idEstadoAnterior as etapaOriginal,idEstadoActual as etapaCambio,
				(SELECT Nombre FROM 800_usuarios WHERE idUsuario=b.idResponsableOperacion) AS responsable ,
				comentariosAdicionales as comentarios FROM 3022_bitacoraCambioSituacionObjeto b
				WHERE tipoObjeto=".$tipoObjeto." AND idRegistroReferencia=".$idRegistro." ORDER BY fechaOperacion DESC";
		
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
		
	}
	
	
	function registrarCambioSituacionCObjeto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		if(registrarCambioSituacionObjeto($obj->tipoObjeto,$obj->idRegistro,$obj->situacionActual,$obj->comentariosAdicionales))
		{
			echo "1|";
		}
		
	}
	
?>	