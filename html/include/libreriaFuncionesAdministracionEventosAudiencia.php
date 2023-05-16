<?php include_once("conexionBD.php");

function notificarEventoAudienciaSala($idEvento)
{
	global $con;
	
	$consulta="SELECT * FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
	$fDatosEvento=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$consulta="SELECT id__15_tablaDinamica as idSala,perfilSala,funcionesNotificacion,funcionCancelacion,urlServicioGrabacion,
					valorComplementario FROM _15_tablaDinamica WHERE id__15_tablaDinamica=".$fDatosEvento["idSala"];
	$fDatosSala=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$consulta="SELECT claveUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$fDatosEvento["idCentroGestion"];
	$unidadGestion=$con->obtenerValor($consulta);
	
	$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$idEvento;
	$carpetaAdministrativa=$con->obtenerValor($consulta);	
	
	$fDatosSala["fechaEvento"]=$fDatosEvento["fechaEvento"];
	$fDatosSala["horaInicioEvento"]=$fDatosEvento["horaInicioEvento"];
	$fDatosSala["horaFinEvento"]=$fDatosEvento["horaFinEvento"];
	$fDatosSala["tipoAudiencia"]=$fDatosEvento["tipoAudiencia"];
	$fDatosSala["carpetaAdministrativa"]=$carpetaAdministrativa;
	$fDatosSala["unidadGestion"]=$unidadGestion;
	$fDatosSala["idSala"]=$fDatosEvento["idSala"];
	$fDatosSala["idSala"]=$fDatosEvento["idSala"];
	$fDatosSala["idFormulario"]=$fDatosEvento["idFormulario"];
	$fDatosSala["idRegistro"]=$fDatosEvento["idRegistroSolicitud"];
	
	
	if(($fDatosSala["funcionesNotificacion"]!=-1)&&($fDatosSala["funcionesNotificacion"]!=""))
	{
		
		$cacheCalculos=NULL;
		$fDatosSala["idEvento"]=$idEvento;
		
		$consulta="SELECT nombreFuncionPHP FROM 9033_funcionesSistema WHERE idFuncion=".$fDatosSala["funcionesNotificacion"];
		$nombreFuncionPHP=$con->obtenerValor($consulta);
		$resultado=false;
		@eval('$resultado='.$nombreFuncionPHP.'($fDatosSala);');
		return $resultado;

		
	}
}

function notificarCancelacionEventoAudienciaSala($idEvento,$motivoCancelacion="")
{
	global $con;
	
	$consulta="SELECT * FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
	$fDatosEvento=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$consulta="SELECT id__15_tablaDinamica as idSala,perfilSala,funcionesNotificacion,funcionCancelacion,urlServicioGrabacion,
					valorComplementario FROM _15_tablaDinamica WHERE id__15_tablaDinamica=".$fDatosEvento["idSala"];
	$fDatosSala=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$consulta="SELECT claveUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$fDatosEvento["idCentroGestion"];
	$unidadGestion=$con->obtenerValor($consulta);
	
	$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$idEvento;
	$carpetaAdministrativa=$con->obtenerValor($consulta);	
	
	$fDatosSala["fechaEvento"]=$fDatosEvento["fechaEvento"];
	$fDatosSala["horaInicioEvento"]=$fDatosEvento["horaInicioEvento"];
	$fDatosSala["horaFinEvento"]=$fDatosEvento["horaFinEvento"];
	$fDatosSala["tipoAudiencia"]=$fDatosEvento["tipoAudiencia"];
	$fDatosSala["carpetaAdministrativa"]=$carpetaAdministrativa;
	$fDatosSala["unidadGestion"]=$unidadGestion;
	$fDatosSala["idSala"]=$fDatosEvento["idSala"];
	$fDatosSala["motivoCancelacion"]=$motivoCancelacion;

	if(($fDatosSala["funcionCancelacion"]!=-1)&&($fDatosSala["funcionCancelacion"]!=""))
	{
		
		$cacheCalculos=NULL;
		$fDatosSala["idEvento"]=$idEvento;
		
		$consulta="SELECT nombreFuncionPHP FROM 9033_funcionesSistema WHERE idFuncion=".$fDatosSala["funcionCancelacion"];
		$nombreFuncionPHP=$con->obtenerValor($consulta);
		$resultado=false;

		@eval('$resultado='.$nombreFuncionPHP.'($fDatosSala);');
		return $resultado;

		
	}
}

function registrarSituacionAccionEventoAudienciaOperador($idEventoAudiencia,$tipoAccion,$situacion,$idReferencia1="",$idReferencia2="",$valorComplementario1="",$valorComplementario2="",$valorComplementario3="")
{
	global $con;
	$consulta="INSERT INTO 7000_notificacionesEventosOperadoresServicios(idRegistroEvento,tipoAccion,notificado,fechaUltimaOperacion,
				idReferencia1,idReferencia2,valorComplementario1,valorComplementario2,valorComplementario3)
				VALUES(".$idEventoAudiencia.",".$tipoAccion.",".$situacion.",'".date("Y-m-d H:i:s")."','".cv($idReferencia1).
				"','".cv($idReferencia2)."','".cv($valorComplementario1)."','".cv($valorComplementario2)."','".cv($valorComplementario3)."')";
	return $con->ejecutarConsulta($consulta);
}
?>