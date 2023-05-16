<?php include_once("conexionBD.php");


function rendererNotificacionCorreo($idFormulario,$idRegistro,$etiquetaNotificacion)
{
	global $con;
	$consulta="SELECT * FROM _665_tablaDinamica WHERE id__665_tablaDinamica=".$idRegistro;
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);


	$consulta="SELECT plantillaMensajeEnvio FROM _666_tablaDinamica WHERE id__666_tablaDinamica=".$fRegistro["tipoNotificacion"];
	$fTipoNotificacion=$con->obtenerPrimeraFilaAsoc($consulta);

	
	$consulta="SELECT asunto FROM 2011_mensajesEnvio WHERE idMensajeEnvio=".$fTipoNotificacion["plantillaMensajeEnvio"];
	$asuntoMensaje=$con->obtenerValor($consulta);

	
	return "'".$etiquetaNotificacion.": ".$asuntoMensaje."'";
	
}

function rendererNotificacionProvidencia($idFormulario,$idRegistro,$etiquetaNotificacion)
{
	global $con;
	$consulta="SELECT providenciaAplicar FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
	$providencia=$con->obtenerValor($consulta);

	switch($providencia)
	{
		case 18:
			if(esProcesoApelacionAuto($idFormulario,$idRegistro)==1)
			{
				$consulta="SELECT nombreActuacion FROM _624_tablaDinamica WHERE id__624_tablaDinamica=".$providencia;
				$nombreProviencia=$con->obtenerValor($consulta);
				return "'PROVIDENCIA: ".$nombreProviencia."'";
			}
			else
			{
				return "'INACTIVIDAD DE EXPEDIENTE'";
			}
		break;
		case 17:
			return "'Registro de Envío de Expediente a Corte Suprema (Impedimento)'";
		break;
		default:
			$consulta="SELECT nombreActuacion FROM _624_tablaDinamica WHERE id__624_tablaDinamica=".$providencia;
			$nombreProviencia=$con->obtenerValor($consulta);
			return "'Registro de Providencia: ".$nombreProviencia."'";
		break;
	}
	
}


function rendererActuacionSugerida($idFormulario,$idRegistro,$etiquetaNotificacion)
{
	global $con;
	$consulta="SELECT tipoActuacion FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
	$providencia=$con->obtenerValor($consulta);

	$consulta="SELECT nombreActuacion FROM _700_tablaDinamica WHERE id__700_tablaDinamica=".($providencia==""?-1:$providencia);
	$nombreProviencia=$con->obtenerValor($consulta);
	return "'".($nombreProviencia==""?"REGISTRO DE ACTUACIÓN":$nombreProviencia)."'";
	
}


function rendererActuacionRegistrada($idFormulario,$idRegistro,$etiquetaNotificacion)
{
	global $con;
	$consulta="SELECT tipoActuacion FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
	$providencia=$con->obtenerValor($consulta);

	$consulta="SELECT nombreActuacion FROM _700_tablaDinamica WHERE id__700_tablaDinamica=".$providencia;
	$nombreProviencia=$con->obtenerValor($consulta);
	return "'".$etiquetaNotificacion.$nombreProviencia."'";
	
}




?>