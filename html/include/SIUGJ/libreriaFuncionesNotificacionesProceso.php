<?php

function esAutoAceptacionApelacionOrdinarioTribunalSuperior($idFormulario,$idRegistro)
{
	global $con;
	$arrTiposDocumentos[597]=1;
	$arrTiposDocumentos[730]=1;
	$arrTiposDocumentos[732]=1;
	
	$nombreTabla=obtenerNombreTabla($idFormulario);
	$consulta="SELECT tipoDocumento FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;

	$tipoDocumento=$con->obtenerValor($consulta);
	return isset($arrTiposDocumentos[$tipoDocumento])?1:0;
}


function esProvidenciaFalloTribunalSuperior($idFormulario,$idRegistro)
{
	global $con;
	$nombreTabla=obtenerNombreTabla($idFormulario);
	$consulta="SELECT providenciaAplicar FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;

	$tipoDocumento=$con->obtenerValor($consulta);
	return $tipoDocumento==15?1:0;
}

function esAutoAutorizaDesistimientoApelacionAuto($idFormulario,$idRegistro)
{
	global $con;
	$nombreTabla=obtenerNombreTabla($idFormulario);
	$consulta="SELECT tipoDocumento FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;

	$tipoDocumento=$con->obtenerValor($consulta);
	return ($tipoDocumento==609)?1:0;
}


function esAutoNiegaApelacionAuto($idFormulario,$idRegistro)
{
	global $con;
	$nombreTabla=obtenerNombreTabla($idFormulario);
	$consulta="SELECT tipoDocumento FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;

	$tipoDocumento=$con->obtenerValor($consulta);
	return ($tipoDocumento==598)?1:0;
}

function esAutoImpedimientoApelacionAuto($idFormulario,$idRegistro)
{
	global $con;
	$nombreTabla=obtenerNombreTabla($idFormulario);
	$consulta="SELECT tipoDocumento FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;

	$tipoDocumento=$con->obtenerValor($consulta);
	return ($tipoDocumento==540)?1:0;
}

function esAutoRechazaImpedimento($idFormulario,$idRegistro)
{
	global $con;
	$nombreTabla=obtenerNombreTabla($idFormulario);
	$consulta="SELECT tipoDocumento FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;

	$tipoDocumento=$con->obtenerValor($consulta);
	return ($tipoDocumento==611)?1:0;
}

function esProvidenciaPerdidaCompetencia($idFormulario,$idRegistro)
{
	global $con;
	$nombreTabla=obtenerNombreTabla($idFormulario);
	$consulta="SELECT providenciaAplicar FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;
	$tipoDocumento=$con->obtenerValor($consulta);
	return $tipoDocumento==18?1:0;
}

function esReasignacionPerdidaCompetencia($idFormulario,$idRegistro)
{
	global $con;
	$nombreTabla=obtenerNombreTabla($idFormulario);
	$consulta="SELECT motivoReasignacion FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;
	$motivoReasignacion=$con->obtenerValor($consulta);
	return $motivoReasignacion==2?1:0;
}

function esAutoPerdidaCompetencia($idFormulario,$idRegistro)
{
	global $con;
	$nombreTabla=obtenerNombreTabla($idFormulario);
	$consulta="SELECT tipoDocumento FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;

	$tipoDocumento=$con->obtenerValor($consulta);
	return ($tipoDocumento==611)?1:0;
}


function esProvidenciaAgendaAudiencia($idFormulario,$idRegistro)
{
	global $con;
	$nombreTabla=obtenerNombreTabla($idFormulario);
	$consulta="SELECT providenciaAplicar FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;
	$providenciaAplicar=$con->obtenerValor($consulta);
	
	$consulta="SELECT generaOrdenProgramacionAudiencia FROM _624_tablaDinamica WHERE id__624_tablaDinamica=".$providenciaAplicar;
	$generaOrdenProgramacionAudiencia=$con->obtenerValor($consulta);
	return $generaOrdenProgramacionAudiencia==1?1:0;
	
	
}

function esProvidenciaCorreTrasladoAgendaAudiencia($idFormulario,$idRegistro)
{
	global $con;
	$nombreTabla=obtenerNombreTabla($idFormulario);
	$consulta="SELECT providenciaAplicar FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;
	$providenciaAplicar=$con->obtenerValor($consulta);
	
	$consulta="SELECT generaOrdenProgramacionAudiencia FROM _624_tablaDinamica WHERE id__624_tablaDinamica=".$providenciaAplicar;
	$generaOrdenProgramacionAudiencia=$con->obtenerValor($consulta);
	return $generaOrdenProgramacionAudiencia==1?1:0;
}

function obtenerTipoAudienciaAgendaProvidencia($idFormulario,$idRegistro)
{
	global $con;
	$nombreTabla=obtenerNombreTabla($idFormulario);
	$consulta="SELECT providenciaAplicar FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;
	$providenciaAplicar=$con->obtenerValor($consulta);
	
	$consulta="SELECT tipoAudiencia FROM _624_tablaDinamica WHERE id__624_tablaDinamica=".$providenciaAplicar;
	$tipoAudiencia=$con->obtenerValor($consulta);
	return $tipoAudiencia;
}

function esAutoAgendaAudiencia($idFormulario,$idRegistro)
{
	global $con;
	$nombreTabla=obtenerNombreTabla($idFormulario);
	$consulta="SELECT tipoDocumento FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;
	$tipoDocumento=$con->obtenerValor($consulta);
	
	$arrAutosAgendanAudiencia=array();
	$arrAutosAgendanAudiencia["625"]=1;
	
	return isset($arrAutosAgendanAudiencia[$tipoDocumento])?1:0;
}


function esTutelaConMedidaCautelar($idFormulario,$idRegistro)
{
	global $con;
	$consulta="SELECT medidaProvisional FROM _847_tablaDinamica WHERE id__847_tablaDinamica=".$idRegistro;
	$medidaProvisional=$con->obtenerValor($consulta);
	return $medidaProvisional==1?1:0;
}

function esTutelaSinMedidaCautelar($idFormulario,$idRegistro)
{
	global $con;
	$consulta="SELECT medidaProvisional FROM _847_tablaDinamica WHERE id__847_tablaDinamica=".$idRegistro;
	$medidaProvisional=$con->obtenerValor($consulta);
	return $medidaProvisional==0?1:0;
}

function generarTareaEstudio($idFormulario,$idRegistro)
{
	global $con;
	

	$consulta="SELECT carpetaAdministrativa FROM _899_tablaDinamica WHERE id__899_tablaDinamica=".$idRegistro;
	$carpetaAdministrativa=$con->obtenerValor($consulta);
	$consulta="SELECT id__847_tablaDinamica FROM _847_tablaDinamica WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
	$idRegistro=$con->obtenerValor($consulta);
	
	
	
	return cambiarEtapaFormulario(847,$idRegistro,2.2,"",-1,"NULL","NULL",0);
}


function registrarNotificacionReporte($idReporte,$idDisparador,$arrRegistros)
{
	global $con;
	$aRegistros=bD($arrRegistros);
	$oRegistros=json_decode('{"registros":'.$aRegistros.'}');
	$arrDocumentos=array();
	
	$consulta="SELECT cuerpoNotificacion FROM _1232_tablaDinamica WHERE id__1232_tablaDinamica=".$idDisparador;
	$cuerpoNotificacion=$con->obtenerValor($consulta);
	
	$consulta="SELECT destinatario FROM _1233_tablaDinamica WHERE idReferencia=".$idDisparador;
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchAssoc($res))
	{
		$cuerpoActual=$cuerpoNotificacion;
		
		$arrParametros=array();
		$arrParametros["destinatario"]=obtenerNombreUsuario($fila["destinatario"]);
		$arrParametros["totalRegistros"]=count($oRegistros->registros);
		
		foreach($arrParametros as $campo=>$valor)
		{
			$cuerpoActual=str_replace("{".$campo."}",$valor,$cuerpoActual);
		}
		
		
		$arrValores=array();
		$arrValores["tipoReporte"]=$idReporte;
		$arrValores["destinatarioReporte"]=$fila["destinatario"];
		$arrValores["responsable"]=$fila["destinatario"];
		$arrValores["detallesAdicionalesReporte"]=$cuerpoActual;
		
		$idRegistroInstancia=crearInstanciaRegistroFormulario(1212,-1,2,$arrValores,$arrDocumentos,-1,0);
	}
	return 1;
}


function esAutoImpedimientoConflicto($idFormulario,$idRegistro,$idFormularioEvaluacion)
{
	global $con;
	$nombreTabla=obtenerNombreTabla($idFormulario);
	$consulta="SELECT tipoDocumento FROM ".$nombreTabla." WHERE id_".$nombreTabla."=".$idRegistro;

	$tipoDocumento=$con->obtenerValor($consulta);
	if(($tipoDocumento==540)||($tipoDocumento==606))
	{
		return mostrarSeccionEdicionDocumentoSeleccionFormato($idFormulario,$idRegistro,$idFormularioEvaluacion);
	}
	
	return 0;
}

?>