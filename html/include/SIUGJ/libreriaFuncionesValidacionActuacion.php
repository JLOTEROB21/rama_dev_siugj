<?php	include_once("conexionBD.php");

$arrFormularios[0]=632;
$arrFormularios[1]=847;

function analisisRutaRegistroActuacion($idFormulario,$idRegistro)
{
	global $con;
	$numEtapa=0;
	$consulta="SELECT tipoActuacion FROM _699_tablaDinamica WHERE id__699_tablaDinamica=".$idRegistro;
	$tipoActuacion=$con->obtenerValor($consulta);


	$consulta="SELECT etapaActuacion FROM _700_tablaDinamica WHERE id__700_tablaDinamica=".$tipoActuacion;
	$numEtapa=$con->obtenerValor($consulta);
	if($numEtapa=="")
		$numEtapa=4;
	cambiarEtapaFormulario(699,$idRegistro,$numEtapa,"",-1,"NULL","NULL",0);
}


function permiteContestacionDemanda($cup,$idParticipante)
{
	global $con;
	return 1;
	$aFormularioDemanda=obtenerIdFormularioDemanda($cup);

	if(existeProcesoPasoEtapa($aFormularioDemanda["idFormulario"],$aFormularioDemanda["idRegistro"],3))
	{
		$consulta="SELECT COUNT(*) FROM _707_tablaDinamica WHERE carpetaAdministrativa='".$cup."' AND promovente=".$idParticipante;
		$numReg=$con->obtenerValor($consulta);
		return $numReg>1?1:0;	
	}
	
	return 0;
}


function permiteReformaDemanda($cup)
{
	global $con;
	return 1;
	$aFormularioDemanda=obtenerIdFormularioDemanda($cup);

	if(existeProcesoPasoEtapa($aFormularioDemanda["idFormulario"],$aFormularioDemanda["idRegistro"],3))
	{
		return 1;	
	}
	
	return 0;
}


function permiteEscritoSubsanacion($cup)
{
	global $con;
	return 1;
	$aFormularioDemanda=obtenerIdFormularioDemanda($cup);

	if(esProcesoEtapaActual($aFormularioDemanda["idFormulario"],$aFormularioDemanda["idRegistro"],3.5))
	{
		return 1;	
	}
	
	return 0;
}

function permiteContestacionReforma($cup)
{
	global $con;
	return 1;
	$consulta="SELECT COUNT(*) FROM _699_tablaDinamica WHERE carpetaAdministrativaActuacionesIntervinientes='".$cup."' AND tipoActuacion=3";
	$nReg=$con->obtenerValor($consulta);
	if($nReg>0)
	{
		return 1;	
	}
	
	return 0;
}


function permiteRegistroExcepcionsPrevias($cup)
{
	global $con;
	return 1;
	$aFormularioDemanda=obtenerIdFormularioDemanda($cup);

	if(existeProcesoPasoEtapa($aFormularioDemanda["idFormulario"],$aFormularioDemanda["idRegistro"],3))
	{
		return 1;	
	}
	
	return 0;
}

function permiteContestacionExcepcionsPrevias($cup)
{
	global $con;
	return 1;
	$consulta="SELECT COUNT(*) FROM _699_tablaDinamica WHERE carpetaAdministrativaActuacionesIntervinientes='".$cup."' AND tipoActuacion=5";
	$nReg=$con->obtenerValor($consulta);
	if($nReg>0)
	{
		return 1;	
	}
	
	return 0;
}

function permiteRegistroAllanamiento($cup)
{
	global $con;
	return 1;
	$aFormularioDemanda=obtenerIdFormularioDemanda($cup);

	if(existeProcesoPasoEtapa($aFormularioDemanda["idFormulario"],$aFormularioDemanda["idRegistro"],3))
	{
		return 1;	
	}
	
	return 0;
}

function permiteRegistroDemandaReconvencion($cup)
{
	global $con;
	return 1;
	$aFormularioDemanda=obtenerIdFormularioDemanda($cup);

	if(existeProcesoPasoEtapa($aFormularioDemanda["idFormulario"],$aFormularioDemanda["idRegistro"],3))
	{
		return 1;	
	}
	
	return 0;
}

function permiteContestacionRegistroDemandaReconvencion($cup)
{
	global $con;
	return 1;
	$consulta="SELECT COUNT(*) FROM _699_tablaDinamica WHERE carpetaAdministrativaActuacionesIntervinientes='".$cup."' AND tipoActuacion=8";
	$nReg=$con->obtenerValor($consulta);
	if($nReg>0)
	{
		return 1;	
	}
	
	return 0;
}

function permiteRegistroPruebas($cup)
{
	global $con;
	return 1;
	$aFormularioDemanda=obtenerIdFormularioDemanda($cup);

	if(existeProcesoPasoEtapa($aFormularioDemanda["idFormulario"],$aFormularioDemanda["idRegistro"],3))
	{
		return 1;	
	}
	
	return 0;
}

function permiteRetiroDemanda($cup)
{
	global $con;
	return 1;
	$aFormularioDemanda=obtenerIdFormularioDemanda($cup);

	if(existeProcesoPasoEtapa($aFormularioDemanda["idFormulario"],$aFormularioDemanda["idRegistro"],3))
	{
		return 1;	
	}
	
	return 0;
}

function permiteRegistroSubsanacionContestacionDemanda($cup,$idParticipante)
{
	global $con;
	return 1;
	$consulta="SELECT COUNT(*) FROM _707_tablaDinamica WHERE carpetaAdministrativa='".$cup."' AND promovente=".$idParticipante." AND idEstado=3.6";

	$numReg=$con->obtenerValor($consulta);
	
	return $numReg>0?1:0;
	

}

function obtenerIdFormularioDemanda($cup)
{
	global $con;
	global $arrFormularios;
	$arrDatos=array();
	$consulta="SELECT idFormulario,idRegistro FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cup."'";
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	$nombreTabla=obtenerNombreTabla($fRegistro["idFormulario"]);
	$idProceso=obtenerIdProcesoFormulario($fRegistro["idFormulario"]);
	
	foreach($arrFormularios as $iFormulario)
	{
		$nombreTabla=obtenerNombreTabla($iFormulario);
		$consulta="SELECT * FROM _".$iFormulario."_tablaDinamica WHERE idProcesoPadre=".$idProceso." AND idReferencia=".$fRegistro["idRegistro"];

		$fRegistroBusqueda=$con->obtenerPrimeraFilaAsoc($consulta);

		if($fRegistroBusqueda)
		{
			$idFormulario=$iFormulario;
			$idRegistro=$fRegistroBusqueda["id_".$nombreTabla];
			$arrDatos["idFormulario"]=$idFormulario;
			$arrDatos["idRegistro"]=$idRegistro;
		
			return $arrDatos;
		}
	}
	
	
	$arrDatos["idFormulario"]=$fRegistro["idFormulario"];
	$arrDatos["idRegistro"]=$fRegistro["idRegistro"];
	
	return $arrDatos;
	
}

function existeProcesoPasoEtapa($idFormulario,$idRegistro,$numEtapa)
{
	global $con;
	$consulta="SELECT COUNT(*) FROM 941_bitacoraEtapasFormularios WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro." AND etapaActual=".$numEtapa;
	$nReg=$con->obtenerValor($consulta);
	return $nReg>0;
}

function esProcesoEtapaActual($idFormulario,$idRegistro,$numEtapa)
{
	global $con;
	$nombreTabla=obtenerNombreTabla($idFormulario);
	$consulta="SELECT idEstado FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;
	$nEtapActual=$con->obtenerValor($consulta);
	return $numEtapa==$nEtapActual;
}

function validarEnvioRadicacion($idFormulario,$idRegistro)
{
	global $con;
	$arrErrores=array();
	if($con->existeCampo("idActividad","_".$idFormulario."_tablaDinamica"))
	{
		
		$consulta="SELECT idActividad FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		
		$idActividad=$con->obtenerValor($consulta);
		
		
		$consulta="SELECT COUNT(*) FROM 7005_relacionFigurasJuridicasSolicitud r,_5_tablaDinamica f 
				WHERE idActividad=".$idActividad." AND  f.id__5_tablaDinamica=r.idFiguraJuridica AND naturalezaFigura='A'";
		$totalActores=$con->obtenerValor($consulta);
		$consulta="SELECT COUNT(*) FROM 7005_relacionFigurasJuridicasSolicitud r,_5_tablaDinamica f 
				WHERE idActividad=".$idActividad." AND  f.id__5_tablaDinamica=r.idFiguraJuridica AND naturalezaFigura='D'";
		$totalDemandados=$con->obtenerValor($consulta);
		
		
		if($totalActores==0)
		{
			$oError=array();
			$oError["seccion"]="Sujeros procesales";
			$oError["mensajeError"]="Debe indicar almenos un sujeto procesal en calidad de: Actor/Accionante";
			array_push($arrErrores,$oError);
		}
		
		if($totalDemandados==0)
		{
			$oError=array();
			$oError["seccion"]="Sujeros procesales";
			$oError["mensajeError"]="Debe indicar almenos un sujeto procesal en calidad de: Demandado/Accionado";
			array_push($arrErrores,$oError);
		}
		
		
	}
	return $arrErrores;
	
}



function esAutoEnviaConflictoCompetencial($idFormulario,$idRegistro)
{
	global $con;
	$consulta="SELECT tipoDocumento FROM _696_tablaDinamica WHERE id__696_tablaDinamica=".$idRegistro;
	$tipoDocumento=$con->obtenerValor($consulta);
	
	
	if($tipoDocumento==606)
		return 1;
	return 0;
	
	
	
}
?>