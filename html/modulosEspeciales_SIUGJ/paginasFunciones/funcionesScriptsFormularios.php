<?php session_start();
	include_once("conexionBD.php");
	include_once("utiles.php");
	include_once("cConectoresGestorContenido/cOneDrive.php");
	include_once("SIUGJ/libreriasFuncionesDespachos.php");


	
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	
	switch($funcion)
	{
		case 1:
			obtenerActuacionesDiposnibles();
		break;
		case 2:
			obtenerPromoventeActuacionSesion();
		break;
		case 3:
			obtenerInformacionAmbitosAplicacionPlantillas();
		break;
		case 4:
			obtenerBitacoraEmbargo();
		break;
		case 5:
			ejecutarDisparadorReporte();
		break;
		case 6:
			obtenerInformacionAmbitosAplicacionSuspension();
		break;
		case 7:
			obtenerDistritosAmbitosAplicacionSuspensionTerminos();
		break;
		case 8:
			obtenerCircuitosAmbitosAplicacionSuspensionTerminos();
		break;
		case 9:
			obtenerMunicipiosAmbitosAplicacionSuspensionTerminos();
		break;
		case 10:
			obtenerDespachoAmbitosAplicacionSuspensionTerminos();
		break;
		case 11:
			generarDocumentoEditorTexto();
		break;
		case 12:
			registrarInformacionDocumento();
		break;
		case 13:
			modificarFechaPublicacion();
		break;
		case 14:
			obtenerModificacionesFechaPublicacion();
		break;
		case 15:
			obtenerNodosPublicacionArbol();
		break;
		case 16:
			obtenerRegistrosPublicacion();
		break;
		case 17:
			registrarRegistrosPublicacion();
		break;
		case 18:
			obtenerRegistrosPublicacionesFinales();
		break;
		case 19:
			busquedaDespachoPublicaciones();
		break;
		case 20:
			obtenerDespachosGrupoReparto();
		break;
		case 21:
			obtenerBitacoraReparto();
		break;
		
		
	}




	function obtenerActuacionesDiposnibles()
	{
		global $con;
		
		
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$fInfoCarpetasAdminsitrativas=NULL;
		$consulta="SELECT tipoCarpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$obj->cup."'";
		$tCarpetaAdministrativa=$con->obtenerValor($consulta);
		
		if($tCarpetaAdministrativa==3)
		{
			$arrCarpetas=array();
			obtenerCarpetasPadre($obj->cup,$arrCarpetas);
			if(sizeof($arrCarpetas)==0)
			{
				array_push($arrCarpetas,$obj->cup);
			}
			
			$carpetaBase=$arrCarpetas[0];
		
			$consulta="SELECT idActividad,tipoProceso,tipoCarpetaAdministrativa,etapaProcesalActual FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaBase."' and tipoCarpetaAdministrativa=1";
			$fInfoCarpetasAdminsitrativas=$con->obtenerPrimeraFilaAsoc($consulta);
		
		}
		else
		{
			$consulta="SELECT idActividad,tipoProceso,tipoCarpetaAdministrativa,etapaProcesalActual FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$obj->cup.
					"' and tipoCarpetaAdministrativa in(1,2,20)";
			$fInfoCarpetasAdminsitrativas=$con->obtenerPrimeraFilaAsoc($consulta);
			$tCarpetaAdministrativa=$fInfoCarpetasAdminsitrativas["etapaProcesalActual"];
		}
		


		$idActividad=$fInfoCarpetasAdminsitrativas["idActividad"];
		$tipoProceso=$fInfoCarpetasAdminsitrativas["tipoProceso"];
		
		$consulta="SELECT idFiguraJuridica FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad." AND idParticipante=".$obj->idParticipante;
		$idFiguraJuridica=$con->obtenerValor($consulta);
		if($idFiguraJuridica=="")
			$idFiguraJuridica=0;
			
		$tipoParticipante=$idFiguraJuridica;
		
		
		
		$consulta="SELECT idActorRelacionado FROM 7005_relacionParticipantes WHERE idActividad=".$idActividad." AND idParticipante=".$obj->idParticipante;
		$idActorRelacionado=$con->obtenerValor($consulta);
		if($idActorRelacionado!="")
		{
			$consulta="SELECT idFiguraJuridica FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad." AND idParticipante=".$idActorRelacionado;
			$idFiguraJuridica=$con->obtenerValor($consulta);
			if($idFiguraJuridica=="")
				$idFiguraJuridica=0;
			$tipoParticipante=$idFiguraJuridica;
		}
		
		$consulta="SELECT naturalezaFigura FROM _5_tablaDinamica WHERE id__5_tablaDinamica=".$tipoParticipante;
		$tipoParticipante=$con->obtenerValor($consulta);
		
		$arrRegistros="";
		
		
		$cacheCalculos=NULL;
		$cadParametros='{"cup":"'.$obj->cup.'","idParticipante":"'.$obj->idParticipante.'","tipoActuacion":"'.$obj->tipoActuacion.'","idFiguarJuridica":"'.$tipoParticipante.'"}';
		$objParametros=json_decode($cadParametros);
		
		
		$consulta="SELECT * FROM _700_tablaDinamica a,_700_intervinientesActuaciones i,_700_chkTiposProceso tP,_700_chkTiposCarpetas tC 
				WHERE tipoAccionActuaciones=".$obj->tipoActuacion."  AND i.idPadre=a.id__700_tablaDinamica and tP.idPadre=a.id__700_tablaDinamica
				and tP.idOpcion=".$tipoProceso." AND i.idOpcion='".$tipoParticipante."' and tC.idPadre=a.id__700_tablaDinamica and tC.idOpcion=".$tCarpetaAdministrativa;

		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			$continuar=true;
			if(($fila["idFuncionVisualizacion"]!=-1)||($fila["idFuncionVisualizacion"]==""))
			{

				$resultadoEvaluacion=removerComillasLimite(resolverExpresionCalculoPHP($fila["idFuncionVisualizacion"],$objParametros,$cacheCalculos));
				if(($resultadoEvaluacion==0)||($resultadoEvaluacion==false))
				{
					$continuar=false;
				}
			}
			
			if($continuar)
			{
				$o="['".$fila["id__700_tablaDinamica"]."','".cv($fila["nombreActuacion"])."']";
				if($arrRegistros=="")
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;
			}
			
		}
		
		echo "1|[".$arrRegistros."]";
	}
	
	function obtenerPromoventeActuacionSesion()
	{
		global $con;
		$cAdministrativa=$_POST["cAdministrativa"];
		$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cAdministrativa."'";
		$idActividad=$con->obtenerValor($consulta);
		$consulta="SELECT idParticipante FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad." AND idCuentaAcceso=".$_SESSION["idUsr"];
		$idParticipante=$con->obtenerValor($consulta);
		if($idParticipante=="")
			$idParticipante=-1;
		$nombre=obtenerNombreParticipante($idParticipante);
		echo "1|".$idParticipante."|".$nombre;
	}
	
	
	function obtenerInformacionAmbitosAplicacionPlantillas()
	{
		global $con;
		$idRegistro=$_POST["iR"];
		$tipoAmbito=$_POST["tA"];
		
		$consulta="";
		switch($tipoAmbito)
		{
			case 1:
				$consulta="SELECT codigoUnidad as cveElemento,unidad as nombreElemento FROM 817_organigrama WHERE  codigoUnidad  
						in(SELECT cveElemento FROM _10_ambitoAplicacionPlantilla WHERE idFormulario=10 and idReferencia=".$idRegistro.
					" AND tipoAmbito=1)ORDER BY unidad";
			break;
			case 2:
				
				$consulta="SELECT codigoUnidad as cveElemento,unidad as nombreElemento FROM 817_organigrama WHERE  codigoUnidad  
					in(SELECT cveElemento FROM _10_ambitoAplicacionPlantilla WHERE idFormulario=10 and idReferencia=".$idRegistro.
					" AND tipoAmbito=2)ORDER BY unidad";
			break;
			case 3:
				$consulta="SELECT codigoUnidad as cveElemento,unidad as nombreElemento  FROM 817_organigrama WHERE  codigoUnidad  
					in(SELECT cveElemento FROM _10_ambitoAplicacionPlantilla WHERE idFormulario=10 and idReferencia=".$idRegistro.
					" AND tipoAmbito=3)ORDER BY unidad";	
					
			break;
			case 4:
			
				$consulta="SELECT claveUnidad as cveElemento,nombreUnidad as nombreElemento FROM _17_tablaDinamica 
					where claveUnidad in(SELECT cveElemento FROM _10_ambitoAplicacionPlantilla WHERE idFormulario=10 and idReferencia=".$idRegistro." AND 
					tipoAmbito=4)  ORDER BY nombreUnidad";
			
			break;
			
		}
		
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
	}
	
	
	function obtenerBitacoraEmbargo()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		
		
		$consulta="SELECT fechaCreacion,carpetaAdministrativa FROM _1140_tablaDinamica WHERE id__1140_tablaDinamica=".$idRegistro;
		$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);
		$fechaSolicitud=$fRegistroBase["fechaCreacion"];
		$carpetaAdministrativa=$fRegistroBase["carpetaAdministrativa"];
		
		$arrRegistros=array();
		$o='{"idRegistro":"1","iFormulario":"'.$idFormulario.'","iRegistro":"'.$idRegistro.'","fechaMovimiento":"'.$fechaSolicitud.
				'","descripcion":"Registro de solicitud de embargo"}';
		array_push($arrRegistros,$o);
		
		
		
		$consulta="SELECT id__665_tablaDinamica, 
				(SELECT nombreFormato FROM _10_tablaDinamica WHERE id__10_tablaDinamica=c.idTipoDocumentoPrincipal) AS documento,idTipoDocumentoPrincipal, 
				(SELECT fechaCambio FROM 941_bitacoraEtapasFormularios WHERE idFormulario=665 AND idRegistro=c.id__665_tablaDinamica ORDER BY idRegistroEstado DESC LIMIT 0,1) 
				AS fechaCambio
				FROM _665_tablaDinamica c WHERE carpetaAdministrativa='".$carpetaAdministrativa."' and idTipoDocumentoPrincipal=706";
		
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		if($fRegistro)
		{
			$o='{"idRegistro":"2","iFormulario":"665","iRegistro":"'.$fRegistro["id__665_tablaDinamica"].'","fechaMovimiento":"'.$fRegistro["fechaCambio"].
				'","descripcion":"Envio de oficio de embargo a instituci&oacute;n responsable de embargo"}';
			array_push($arrRegistros,$o);
		}
		
		$consulta="SELECT id__1178_tablaDinamica FROM _1178_tablaDinamica WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		$idRegistroAux=$con->obtenerValor($consulta);
		if($idRegistroAux!="")
		{
			$consulta="SELECT fechaCambio FROM 941_bitacoraEtapasFormularios WHERE idFormulario=1178 AND idRegistro=".$idRegistroAux." and etapaActual=3
						ORDER BY idRegistroEstado DESC LIMIT 0,1";
			$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
			if($fRegistro)
			{
				$o='{"idRegistro":"3","iFormulario":"1178","iRegistro":"'.$idRegistroAux.'","fechaMovimiento":"'.$fRegistro["fechaCambio"].
					'","descripcion":"Recepci&oacute;n de respuesta de oficio de embargo"}';
				array_push($arrRegistros,$o);
			}
			
			$consulta="SELECT fechaCambio FROM 941_bitacoraEtapasFormularios WHERE idFormulario=1178 AND idRegistro=".$idRegistroAux." and etapaActual=7
						ORDER BY idRegistroEstado DESC LIMIT 0,1";
			$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
			if($fRegistro)
			{
				$o='{"idRegistro":"4","iFormulario":"1178","iRegistro":"'.$idRegistroAux.'","fechaMovimiento":"'.$fRegistro["fechaCambio"].
				'","descripcion":"Designaci&oacute;n de auxiliar de justicia"}';
			array_push($arrRegistros,$o);
			}
		}
		
		$consulta="SELECT fechaDiligencia,horaDiligencia,e.id__1221_tablaDinamica as idRegistro FROM _1220_tablaDinamica i,_1221_tablaDinamica e 
					WHERE i.idReferencia=e.id__1221_tablaDinamica AND e.carpetaAdministrativa='".$carpetaAdministrativa."' AND e.idEstado>1";

		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		if($fRegistro)
		{
			$o='{"idRegistro":"5","iFormulario":"1221","iRegistro":"'.$fRegistro["idRegistro"].'","fechaMovimiento":"'.($fRegistro["fechaDiligencia"]." ".$fRegistro["horaDiligencia"]).
				'","descripcion":"Diligencia de secuestro de bien"}';
			array_push($arrRegistros,$o);
		}
		
		
		$consulta="SELECT id__665_tablaDinamica, 
				(SELECT nombreFormato FROM _10_tablaDinamica WHERE id__10_tablaDinamica=c.idTipoDocumentoPrincipal) AS documento,idTipoDocumentoPrincipal, 
				(SELECT fechaCambio FROM 941_bitacoraEtapasFormularios WHERE idFormulario=665 AND idRegistro=c.id__665_tablaDinamica ORDER BY idRegistroEstado DESC LIMIT 0,1) 
				AS fechaCambio
				FROM _665_tablaDinamica c WHERE carpetaAdministrativa='".$carpetaAdministrativa."' and idTipoDocumentoPrincipal=715";
		
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		if($fRegistro)
		{
			$o='{"idRegistro":"6","iFormulario":"665","iRegistro":"'.$fRegistro["id__665_tablaDinamica"].'","fechaMovimiento":"'.$fRegistro["fechaCambio"].
				'","descripcion":"Levantamiento de medida de embargo"}';
			array_push($arrRegistros,$o);
		}
		
		$consulta="SELECT fechaCambio FROM 941_bitacoraEtapasFormularios WHERE idFormulario=1140 AND idRegistro=".$idRegistro." and etapaActual=8
						ORDER BY idRegistroEstado DESC LIMIT 0,1";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		if($fRegistro)
		{
			$o='{"idRegistro":"7","iFormulario":"1140","iRegistro":"'.$idRegistro.'","fechaMovimiento":"'.$fRegistro["fechaCambio"].
				'","descripcion":"Envio de bien a liquidaci&oacute;n"}';
			array_push($arrRegistros,$o);
		}
		
		
		$numReg=0;
		$aRegistros="";
		foreach($arrRegistros as $r)
		{
			if($aRegistros=="")
				$aRegistros=$r;
			else
				$aRegistros.=",".$r;
			
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$aRegistros.']}';
	}
	
	function ejecutarDisparadorReporte()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$cache=NULL;
		$arrValoresReemplazo=resolverExpresionCalculoPHP($obj->idFuncion,$obj,$cache);
		echo "1|";
	}
	
	function obtenerInformacionAmbitosAplicacionSuspension()
	{
		global $con;
		$idRegistro=$_POST["iR"];
		$tipoAmbito=$_POST["tA"];
		
		$consulta="";
		switch($tipoAmbito)
		{
			case 1:
				$consulta="SELECT codigoUnidad as cveElemento,unidad as nombreElemento FROM 817_organigrama WHERE  codigoUnidad  
						in(SELECT cveElemento FROM _1235_ambitoAplicacionSuspensionTerminos WHERE idFormulario=1235 and idReferencia=".$idRegistro.
					" AND tipoAmbito=1)ORDER BY unidad";
			break;
			case 2:
				
				$consulta="SELECT codigoUnidad as cveElemento,unidad as nombreElemento FROM 817_organigrama WHERE  codigoUnidad  
					in(SELECT cveElemento FROM _1235_ambitoAplicacionSuspensionTerminos WHERE idFormulario=1235 and idReferencia=".$idRegistro.
					" AND tipoAmbito=2)ORDER BY unidad";
			break;
			case 3:
				$consulta="SELECT codigoUnidad as cveElemento,unidad as nombreElemento  FROM 817_organigrama WHERE  codigoUnidad  
					in(SELECT cveElemento FROM _1235_ambitoAplicacionSuspensionTerminos WHERE idFormulario=1235 and idReferencia=".$idRegistro.
					" AND tipoAmbito=3)ORDER BY unidad";	
					
			break;
			case 4:
			
				$consulta="SELECT claveUnidad as cveElemento,nombreUnidad as nombreElemento FROM _17_tablaDinamica 
					where claveUnidad in(SELECT cveElemento FROM _1235_ambitoAplicacionSuspensionTerminos WHERE idFormulario=1235 and idReferencia=".$idRegistro." AND 
					tipoAmbito=4)  ORDER BY nombreUnidad";
			
			break;
			
		}
		
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
	}
	
	function obtenerDistritosAmbitosAplicacionSuspensionTerminos()
	{
		global $con;
		$idRegistro=$_POST["iR"];
		
		
		$consultas="SELECT codigoUnidad as cveDistrito,unidad as nombreDistrito FROM 817_organigrama WHERE institucion=10 AND codigoUnidad LIKE '10000003%' 
					and codigoUnidad not in(SELECT cveElemento FROM _1235_ambitoAplicacionSuspensionTerminos WHERE idReferencia=".$idRegistro." AND tipoAmbito=1)ORDER BY unidad";
		$arrDistritos=utf8_encode($con->obtenerFilasJSON($consultas));
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.($arrDistritos).'}';
		
	}
	
	function obtenerCircuitosAmbitosAplicacionSuspensionTerminos()
	{
		global $con;
		$idRegistro=$_POST["iR"];
		
		
		$consultas="SELECT codigoUnidad as cveCircuito,unidad as nombreCircuito FROM 817_organigrama WHERE institucion=12 AND codigoUnidad LIKE '10000003%'
					and codigoUnidad not in(SELECT cveElemento FROM _1235_ambitoAplicacionSuspensionTerminos WHERE idReferencia=".$idRegistro." AND tipoAmbito=2)ORDER BY unidad";
		$arrDistritos=utf8_encode($con->obtenerFilasJSON($consultas));
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.($arrDistritos).'}';
		
	}
	
	function obtenerMunicipiosAmbitosAplicacionSuspensionTerminos()
	{
		global $con;
		$idRegistro=$_POST["iR"];
		
		
		$consultas="SELECT codigoUnidad as cveMunicipio,unidad as nombreMunicipio  FROM 817_organigrama WHERE institucion=13 AND codigoUnidad LIKE '10000003%'
					and codigoUnidad not in(SELECT cveElemento FROM _1235_ambitoAplicacionSuspensionTerminos WHERE idReferencia=".$idRegistro." AND tipoAmbito=3)ORDER BY unidad";
		$arrDistritos=utf8_encode($con->obtenerFilasJSON($consultas));
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.($arrDistritos).'}';
		
	}
	
	function obtenerDespachoAmbitosAplicacionSuspensionTerminos()
	{
		global $con;
		$idRegistro=$_POST["iR"];
		$query=$_POST["query"];
		
		
		$consultas="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica 
					where claveUnidad not in(SELECT cveElemento FROM _1235_ambitoAplicacionSuspensionTerminos WHERE idReferencia=".$idRegistro.
					" AND tipoAmbito=4) and nombreUnidad like '%".$query."%' ORDER BY nombreUnidad";
		
		$arrDistritos=utf8_encode($con->obtenerFilasJSON($consultas));
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.($arrDistritos).'}';
		
	}
	
	function generarDocumentoEditorTexto()
	{
		global $con;
		global $baseDir;
		global $comandoLibreOffice;
		$cadObjConfiguracion="";
		$tipoDocumento=$_POST["tipoDocumento"];
		$cadObj=$_POST["cadObj"];
		
		$objParametros=json_decode($cadObj);
		
		$documentoBloqueado=0;
		$carpetaAdministrativa="";
		$idDocumentoAdjunto=-1;
		$reprocesar=false;
		$idRegistroFormato=-1;
		$tipoFormato=$tipoDocumento;
		$cuerpoDocumento="";
		$sL=0;
		$idPerfilEvaluacion=-1;
		$etapaActual=0;
	
		$consulta="";
		if(isset($objParametros->idRegistroFormato)&&($objParametros->idRegistroFormato!=-1))
		{
			$consulta="SELECT tipoFormato,idFormulario,idRegistro,idReferencia,cuerpoFormato,idRegistroFormato,
					documentoBloqueado,situacionActual,idPerfilEvaluacion,idDocumentoAdjunto,idDocumento FROM 3000_formatosRegistrados 
					WHERE idRegistroFormato=".$objParametros->idRegistroFormato;
		}
		else
		{
			if($objParametros->idFormulario==0)
			{
				$consulta="select * from 3000_formatosRegistrados where 1=2";
			}
			else
			{
				$consulta="SELECT tipoFormato,idFormulario,idRegistro,idReferencia,cuerpoFormato,idRegistroFormato,
							documentoBloqueado,situacionActual,idPerfilEvaluacion,idDocumentoAdjunto,idDocumento FROM 3000_formatosRegistrados 
							WHERE idFormulario=".$objParametros->idFormulario." and idReferencia=".$objParametros->idRegistro.
							" and idFormularioProceso=-1 and tipoFormato=".$tipoDocumento;
			}
		}
	
		if(isset($objParametros->reprocesar)&&($objParametros->reprocesar==1))
		{
			$reprocesar=true;
		}

		

		$fFormato=$con->obtenerPrimeraFila($consulta);
		
		$idRegistroFormato=$fFormato[5];	
		
		
		
		
		$idDocumento="";
		$idPerfilEvaluacion=-1;
		if((!$fFormato)||($reprocesar))
		{

			$consulta="SELECT * FROM _10_tablaDinamica WHERE id__10_tablaDinamica=".$tipoDocumento;
			$fRegistro=$con->obtenerPrimeraFila($consulta);	
	
			$funcionLlenado=($fRegistro[14]=="")?"-1":$fRegistro[14];
			$cuerpoDocumento=$fRegistro[12];
	
			if($funcionLlenado!="-1")
			{
				$cache=NULL;
	
				$arrValoresReemplazo=resolverExpresionCalculoPHP($funcionLlenado,$objParametros,$cache);
	
				if(gettype($arrValoresReemplazo)=="array")
				{
					foreach($arrValoresReemplazo as $llave=>$valor)
					{
						$cuerpoDocumento=str_replace("[".$llave."]",$valor,$cuerpoDocumento);
					}
				}
			}
			$cuerpoDocumento=str_replace('<img src="../images/marcador.png" width="12" />',"",$cuerpoDocumento);
			$cuerpoDocumento=bE(removerCaracteresNoImprimiblesPlantilla($cuerpoDocumento));
			$idPerfilEvaluacion=$fRegistro[17];
			if($idPerfilEvaluacion=="")
				$idPerfilEvaluacion=-1;		

			$consulta="SELECT noEtapa FROM _429_gridEtapas WHERE idReferencia=".$idPerfilEvaluacion." AND etapaInicial=1";
			$etapaActual=$con->obtenerValor($consulta);
			if($etapaActual=="")
				$etapaActual=0;
		
			if(($reprocesar)&&(isset($objParametros->idRegistroFormato) &&($objParametros->idRegistroFormato!=-1)))
			{
				$consulta="UPDATE 3000_formatosRegistrados SET idDocumentoAdjunto=NULL,cuerpoFormato='".$cuerpoDocumento.
						"' WHERE idRegistroFormato=".$objParametros->idRegistroFormato;
				$con->ejecutarConsulta($consulta);
			}
	
			
		}
		else
		{
			$idRegistroFormato=$fFormato[5];
			$tipoFormato=$fFormato[0];
			$cuerpoDocumento=$fFormato[4];
			$sL=$fFormato[6];
			$etapaActual=$fFormato[7]==""?0:$fFormato[7];
			$idPerfilEvaluacion=$fFormato[8];
			$idDocumentoAdjunto=$fFormato[9]==""?-1:$fFormato[9];
			$documentoBloqueado=$fFormato[6];
			$idDocumento=$fFormato[10];
		}
		$cAdministrativa=obtenerCarpetaAdministrativaProceso($objParametros->idFormularioBase,$objParametros->idRegistroBase);

		$consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cAdministrativa."' ORDER BY idCarpeta DESC";
		$despacho=$con->obtenerValor($consulta);

		$infoComp["idConexion"]=obtenerPerfilConfiguracionServiciosNubeDespacho($despacho,3);
				
		if(($infoComp["idConexion"]=="")||($infoComp["idConexion"]=="-1"))
		{
			echo "No existe cuenta de servicio a nube configurado para la creaci&oacute;n del documento";
			return;
		}
				

		$cDrive=new cOneDrive("","","","",$infoComp);
		
		$cDrive->conectar();
		$nombreDocumento="";
		$consulta="SELECT idRegistro,datosParametros,tituloDocumento FROM 7035_informacionDocumentos WHERE idFormulario=".$objParametros->idFormularioBase.
				" AND idReferencia=".$objParametros->idRegistroBase." AND idFormularioProceso=".$objParametros->iFormularioProceso;
		
		$fRegistroInfoBase=$con->obtenerPrimeraFilaAsoc($consulta);	
		
		if((!$fRegistroInfoBase)||($reprocesar))
		{
			$nombreDocumento=generarNombreArchivoTemporal();
			if($fRegistroInfoBase)
			{
				$objInfo=json_decode($fRegistroInfoBase["datosParametros"]);
				$nombreDocumento=str_replace(".docx","",$objInfo->nombreDocumento);
				
			}
			$consulta="SELECT nombreFormato FROM _10_tablaDinamica WHERE id__10_tablaDinamica=".$objParametros->tipoDocumento;

			$tituloDocumento=$con->obtenerValor($consulta);
			$rutaArchivoDestino=$baseDir."/archivosTemporales/".$nombreDocumento;
			
			$cuerpoDocumentoAux=str_replace("&quot;","\"",str_replace("&gt;",">",str_replace("&lt;","<",htmlentities((bD($cuerpoDocumento))))));
			$cuerpoDocumentoAux=str_replace("&amp;nbsp;","&nbsp;",$cuerpoDocumentoAux);

			escribirContenidoArchivo($rutaArchivoDestino,$cuerpoDocumentoAux);
			$comando=$comandoLibreOffice."  --headless --convert-to docx:\"Office Open XML Text\" ".$rutaArchivoDestino." --outdir ".($baseDir."/archivosTemporales/")." 2>&1";
			$arrResultado=array();
			$valResultado=0;
			$resultado=exec($comando,$arrResultado,$valResultado);
			$urlCompartir="";
			$urlEditar="";
			if(file_exists($rutaArchivoDestino.".docx"))
			{		

				$contenidoDocumento=bE(leerContenidoArchivo($rutaArchivoDestino.".docx"));
				if($cDrive->crearDocumento("/",$nombreDocumento.".docx",$contenidoDocumento))
				{

					unlink($rutaArchivoDestino);
					unlink($rutaArchivoDestino.".docx");
					//$urlCompartir=$cDrive->obtenerUrlDocumentoVisualizacionEmbebido("/".$nombreDocumento.".docx");
					$urlCompartir="../visoresGaleriaDocumentos/visorDocumentosOffice365.php";
					$urlEditar=$cDrive->obtenerUrlDocumentoEdicion("/".$nombreDocumento.".docx");	
				
					$cadObjConfiguracion='{"office365":"1","idConexion":"'.$infoComp["idConexion"].'","nombreDocumento":"'.$nombreDocumento.'.docx","urlEdicion":"'.$urlEditar.'","urlConsulta":"'.$urlCompartir.'"}';
				}	
			}
			
		}

		$fFormatoRegistrado=NULL;
		if($fRegistroInfoBase)
		{
			$consulta="SELECT * FROM 3000_formatosRegistrados WHERE idFormulario=-2 AND idRegistro=".$fRegistroInfoBase["idRegistro"];
			$fFormatoRegistrado=$con->obtenerPrimeraFilaAsoc($consulta);
		}
		
		
		if((!$fRegistroInfoBase)||(!$fFormatoRegistrado))
		{
			
			if(!$fRegistroInfoBase)
			{
				$consulta="INSERT INTO 7035_informacionDocumentos(fechaCreacion,idResponsableCreacion,tipoDocumento,tituloDocumento,carpetaAdministrativa,
						situacionDocumento,idFormulario,idReferencia,idFormularioProceso,datosParametros) values('".date("Y-m-d H:i")."',".$_SESSION["idUsr"].
						",".$objParametros->tipoDocumento.",'".cv($tituloDocumento)."','".$cAdministrativa."',1,".$objParametros->idFormularioBase.
						",".$objParametros->idRegistroBase.",".$objParametros->iFormularioProceso.",'".cv($cadObjConfiguracion)."')";
	
				$con->ejecutarConsulta($consulta);
				$consulta="SELECT idRegistro,datosParametros,tituloDocumento FROM 7035_informacionDocumentos WHERE idFormulario=".$objParametros->idFormularioBase.
					" AND idReferencia=".$objParametros->idRegistroBase." AND idFormularioProceso=".$objParametros->iFormularioProceso;
	
				$fRegistroInfoBase=$con->obtenerPrimeraFilaAsoc($consulta);		
			}
			
			if(!$fFormatoRegistrado)
			{
				$consulta="INSERT INTO 3000_formatosRegistrados(fechaRegistro,idResponsableRegistro,tipoFormato,cuerpoFormato,
							idFormulario,idRegistro,idReferencia,firmado,cadenaFirma,formatoPDF,idFormularioProceso,idPerfilEvaluacion,configuracionDocumento)
							VALUES('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$objParametros->tipoDocumento.",'".($cuerpoDocumento)."',-2,".
							$fRegistroInfoBase["idRegistro"].",".$fRegistroInfoBase["idRegistro"].
							",0,'','',".$objParametros->iFormularioProceso.",".$idPerfilEvaluacion.",'')";
		
				$con->ejecutarConsulta($consulta);
				$idRegistroFormato=$con->obtenerUltimoID();
				$documentoBloqueado=0;
			}
		}
		
		$actor=obtenerRolActualDocumento($objParametros,$idPerfilEvaluacion,$etapaActual,$idRegistroFormato);
		if(($actor=="0_0")&& isset($objParametros->rolDefault))
			$actor=$objParametros->rolDefault;
		$cadObj=$fRegistroInfoBase["datosParametros"];
		
		$objInfoDocumento=json_decode($cadObj);
		

		$urlEditar=$objInfoDocumento->urlEdicion;	
		$urlCompartir=$objInfoDocumento->urlConsulta;	
		$nombreDocumento=$objInfoDocumento->nombreDocumento;
		
		
		if($urlEditar=="")
		{
			//$urlCompartir=$cDrive->obtenerUrlDocumentoVisualizacionEmbebido("/".$nombreDocumento);
			$urlCompartir="../visoresGaleriaDocumentos/visorDocumentosOffice365.php";
			$urlEditar=$cDrive->obtenerUrlDocumentoEdicion("/".$nombreDocumento);

			if($urlEditar!="")
			{
				$cadObjDocumento='{"office365":"1","idConexion":"'.$objInfoDocumento->idConexion.'","nombreDocumento":"'.cv($objInfoDocumento->nombreDocumento).
								'","urlEdicion":"'.cv($urlEditar).'","urlConsulta":"'.cv($urlCompartir).'"}';
				$consulta="UPDATE 7035_informacionDocumentos SET datosParametros='".cv($cadObjDocumento)."' WHERE idRegistro=".$fRegistroInfoBase["idRegistro"];	

				$con->ejecutarConsulta($consulta);
			}
		}
			
		

		$permisos=obtenerPermisosActor($actor,$idRegistroFormato,$tipoDocumento,isset($objParametros->idFormulario)?$objParametros->idFormulario:-1,isset($objParametros->idRegistro)?$objParametros->idRegistro:-1);
		if((($idDocumentoAdjunto!="")&&($idDocumentoAdjunto!="-1"))||($idDocumento!=""))
		{
			$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".($idDocumento!=""?$idDocumento:$idDocumentoAdjunto);
			$nombreDocumento=$con->obtenerValor($consulta);
		}


		echo '1|{"idDocumentoAdjunto":"'.($idDocumento!=""?$idDocumento:$idDocumentoAdjunto).'","cuerpoDocumento":"'.($cuerpoDocumento).'","idRegistroFormato":"'.$idRegistroFormato.
				'","sL":"'.$sL.'","permisos":'.$permisos.',"urlCompartir":"'.$urlCompartir.'","urlEditar":"'.$urlEditar.'","nombreDocumento":"'.$nombreDocumento.
				'","nombreDocumentoPlantilla":"'.cv($fRegistroInfoBase["tituloDocumento"]).'","documentoBloqueado":"'.$documentoBloqueado.'"}';
	}
	
	
	function registrarInformacionDocumento()
	{
		global $con;
		global $baseDir;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$nombreArchivo=$obj->tituloDocumento;
		$arrDatos=explode(".",$nombreArchivo);
		
		
		$extension=mb_strtolower($arrDatos[count($arrDatos)-1]);
		
		$consulta="select if(idDocumento is not null,idDocumento,idDocumentoAdjunto) as idDocumentoAdjunto from 
					3000_formatosRegistrados where idRegistroFormato=".$obj->idRegistroFormato;;
		$idDocumento=$con->obtenerValor($consulta);
		
		
		$consulta="SELECT idRegistro,datosParametros,tituloDocumento,tipoDocumento FROM 7035_informacionDocumentos WHERE idFormulario=".$obj->idFormulario.
				" AND idReferencia=".$obj->idRegistro." AND idFormularioProceso=".$obj->idFormularioProceso;
		
		$fFormato=$con->obtenerPrimeraFilaAsoc($consulta);
		$rutaArchivoDestino=$baseDir."/archivosTemporales/".$obj->nombreArchivoTemp;
		$objInfo=NULL;
		$esOffice365=false;
		if($fFormato["datosParametros"]!="")
		{
			$objInfo=json_decode($fFormato["datosParametros"]);
			if($objInfo && $objInfo->office365)
				$esOffice365=true;
		}
		
		if(($esOffice365)&&(($extension=="docx")||($extension=="doc")))
		{
			$infoComp["idConexion"]=$objInfo->idConexion;
			$cDrive=new cOneDrive("","","","",$infoComp);
			$cDrive->conectar();
			
			if(file_exists($rutaArchivoDestino))
			{		
				
				$contenidoDocumento=bE(leerContenidoArchivo($rutaArchivoDestino));
				if($cDrive->crearDocumento("/",$objInfo->nombreDocumento,$contenidoDocumento))
				{
					unlink($rutaArchivoDestino);
					
					
					$consulta="UPDATE 3000_formatosRegistrados SET idDocumentoAdjunto=NULL WHERE idRegistroFormato=".$obj->idRegistroFormato;
					eC($consulta);
			
				}	
			}
		}
		else
		{
			$consulta="SELECT nombreFormato,categoriaDocumento FROM _10_tablaDinamica WHERE id__10_tablaDinamica=".$fFormato["tipoDocumento"];
			$fPlatilla=$con->obtenerPrimeraFilaAsoc($consulta);
			$tituloDocumento=$fPlatilla["nombreFormato"];
			$categoria=$fPlatilla["categoriaDocumento"];
			
			
			if($idDocumento=="")
				$idDocumento=registrarDocumentoServidorRepositorio($obj->nombreArchivoTemp,($tituloDocumento.".".$extension),$categoria,"");
			else
			{
				
				$cuerpoDocumento=leerContenidoArchivo($baseDir."/archivosTemporales/".$obj->nombreArchivoTemp);
				reemplazarArchivoRepositorio($idDocumento,$cuerpoDocumento);	
				unlink($baseDir."/archivosTemporales/".$obj->nombreArchivoTemp);
			}
			
			
			$consulta="UPDATE 3000_formatosRegistrados SET idDocumentoAdjunto=".$idDocumento." WHERE idRegistroFormato=".$obj->idRegistroFormato;
			eC($consulta);
		}
			
	}
	
	
	function modificarFechaPublicacion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		
		$consulta="INSERT INTO 3505_fechaPublicacionModificaciones(iFormulario,iRegistro,fechaOriginal,fechaActual,motivoCambio,fechaCambio,responsableCambio)
					VALUES(".$obj->iFormulario.",".$obj->iRegistro.",'".$obj->fechaOriginal."','".$obj->fechaActual."','".cv($obj->motivoCambio)."','".date("Y-m-d H:i:s").
					"',".$_SESSION["idUsr"].")";
		eC($consulta);
		
		
	}


	function obtenerModificacionesFechaPublicacion()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		
		$consulta="SELECT idRegistro,fechaOriginal,fechaActual as fechaCambio,fechaCambio as fechaOperacion,motivoCambio as comentarios,
					(select Nombre from 800_usuarios where idUsuario=responsableCambio) as responsable FROM 3505_fechaPublicacionModificaciones
					WHERE iFormulario=".$idFormulario." AND iRegistro=".$idRegistro;
					
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
			
		
	}
	
	
	function obtenerNodosPublicacionArbol()
	{
		global $con;
		$anio=$_POST["anio"];
		$codigoInstitucion=$_POST["codigoInstitucion"];
		$tipoPublicacion=$_POST["tipoPublicacion"];
		$anioActual=date("Y");
		$mesActual=date("m")*1;
		$arrNodos="";
		$consulta="SELECT claveElemento,UPPER(nombreElemento) as nombreElemento FROM 1018_catalogoVarios WHERE tipoElemento=34 ORDER BY CAST(claveElemento AS DECIMAL)";
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			$mostrarMes=false;
			
			if($anio<$anioActual)
			{
				$mostrarMes=true;
			}
			else
			{
				
				if(($fila["claveElemento"]*1)<=$mesActual)
				{
					$mostrarMes=true;
				}
			}
			
			if($mostrarMes)
			{
				$tablaPublicacion="";
				switch($tipoPublicacion)
				{
					case 1:
						$tablaPublicacion=1256;
					break;
					case 2:
						$tablaPublicacion=1258;
					break;
				}
				
				$fechaInicial=$anio."-".str_pad($fila["claveElemento"],2,"0",STR_PAD_LEFT)."-01";
				$fechaFinal=obtenerUltimoDiaMes($fechaInicial);
				$consulta="SELECT COUNT(*) FROM _".$tablaPublicacion."_tablaDinamica WHERE fechaEstimadaEstado>='".$fechaInicial."' AND fechaEstimadaEstado<='".$fechaFinal."' AND idEstado=3
							and codigoInstitucion='".$codigoInstitucion."'";
				$numRegistros=$con->obtenerValor($consulta);
				
				$o='{"icon":"../images/s.gif","cls":"expedienteDerivado","id":"m_'.$fila["claveElemento"].'","text":"'.cv($fila["nombreElemento"]).' ('.$numRegistros.')","leaf":true,"children":[]}';
				if($arrNodos=="")
					$arrNodos=$o;
				else
					$arrNodos.=",".$o;
			}
		}
		
		echo '['.$arrNodos.']';
	}
	
	
	function obtenerRegistrosPublicacion()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$sL=$_POST["sL"]==1;
		$medioNotificacion=$_POST["medioNotificacion"];
		$consulta="SELECT  ".($idFormulario==1259?"fechaEstimadaLista":"fechaEstimadaEstado")." as fechaEstimadaEstado,codigo FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		$fechaEstimadaEstado=$fRegistro["fechaEstimadaEstado"];
		$codigo=$fRegistro["codigo"];
		
		
		$existeRegistro=false;
		$consulta="SELECT COUNT(*) FROM 3506_publicacionesRegistro WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
		$numRegistros=$con->obtenerValor($consulta);
		if($numRegistros>0)
			$existeRegistro=true;
		
		

		$numReg=0;
		$arrRegistros="";
		$consulta="SELECT id__1251_tablaDinamica AS idRegistro,e.codigo,resumenActuacion,comentariosAdicionales,e.carpetaAdministrativa,
					c.idActividad,e.fechaCreacion,c.tipoProceso,t.fechaPublicacion
					FROM _1252_tablaDinamica t,_1251_tablaDinamica e,7006_carpetasAdministrativas c 
					WHERE e.id__1251_tablaDinamica=t.idReferencia AND c.carpetaAdministrativa=e.carpetaAdministrativa AND 
					t.metodoNotificacion=".$medioNotificacion." and (c.unidadGestion='".$_SESSION["codigoInstitucion"]."' or c.unidadGestion like '".substr($_SESSION["codigoInstitucion"],0,strlen($_SESSION["codigoInstitucion"])-4)."%')
					 AND ((t.fechaPublicacion<='".$fechaEstimadaEstado."' and e.idEstado=3) or  
					 (e.id__1251_tablaDinamica in (SELECT iRegistro FROM 3506_publicacionesRegistro WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro.")))
					ORDER BY t.id__1252_tablaDinamica";

		$resRegistros=$con->obtenerFilas($consulta);

		while($fila=$con->fetchAssoc($resRegistros))					
		{

			$demantante="";
			$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
						FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
						AND r.idActividad=".$fila["idActividad"]." AND r.idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='A') ORDER BY nombre,nombre,apellidoMaterno";
			
			$res=$con->obtenerFilas($consulta);
			while($filaImputado=$con->fetchRow($res))
			{
				$nombre=trim($filaImputado[0]);
				if($demantante=="")
					$demantante=$nombre;
				else
					$demantante.=", ".$nombre;
			}
			
			$demandados="";
			$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
						FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
						AND r.idActividad=".$fila["idActividad"]." AND r.idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='D') ORDER BY nombre,nombre,apellidoMaterno";
			
			$res=$con->obtenerFilas($consulta);
			while($filaImputado=$con->fetchRow($res))
			{
				$nombre=trim($filaImputado[0]);
				if($demandados=="")
					$demandados=$nombre;
				else
					$demandados.=", ".$nombre;
			}
			
			$consulta="SELECT nombreTipoProceso FROM _625_tablaDinamica WHERE id__625_tablaDinamica=".$fila["tipoProceso"];
			$tipoProceso=$con->obtenerValor($consulta);
			
			$incluirProgramacion=0;
			if($existeRegistro)
			{
				$consulta="SELECT publicar FROM 3506_publicacionesRegistro WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." and iRegistro=".$fila["idRegistro"];
				$incluirProgramacion=$con->obtenerValor($consulta);
				if($incluirProgramacion=="")
				{
					if($sL)
						continue;
					else
						$incluirProgramacion=0;
				}
				
					
			}
			else
			{
				$incluirProgramacion=1;
			}
			
			
			$o='{"idRegistro":"'.$fila["idRegistro"].'","codigo":"'.$fila["codigo"].'","resumenActuacion":"'.cv($fila["resumenActuacion"]).
				'","comentariosAdicionales":"'.cv($fila["comentariosAdicionales"]).'","carpetaAdministrativa":"'.$fila["carpetaAdministrativa"].
				'","demandante":"'.cv($demantante).'","demandando":"'.cv($demandados).'","tipoProceso":"'.cv($tipoProceso).'","fechaAuto":"'.
				date("Y-m-d",strtotime($fila["fechaCreacion"])).'","fechaPublicacion":"'.$fila["fechaPublicacion"].
				'","incluirProgramacion":"'.$incluirProgramacion.'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
					
	}
	
	function registrarRegistrosPublicacion()
	{
		global $con;
		global $baseDir;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$query="SELECT ".($obj->idFormulario==1259?"fechaEstimadaLista":"fechaEstimadaEstado")." as fechaEstimadaEstado,codigo,codigoInstitucion FROM _".$obj->idFormulario."_tablaDinamica WHERE id__".$obj->idFormulario."_tablaDinamica=".$obj->idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($query);
		
		$fechaEstimadaEstado=$fRegistro["fechaEstimadaEstado"];
		$codigo=$fRegistro["codigo"];
		
		$query="SELECT upper(unidad) FROM 817_organigrama WHERE codigoUnidad='".substr($fRegistro["codigoInstitucion"],0,strlen($fRegistro["codigoInstitucion"])-4)."'";
		$nombreDespacho=$con->obtenerValor($query);
		
		$nombreDespacho.="\r\nSALA LABORAL\r\nSECRETARIA";
		
		
		
		$arrRegistrosPublicaciones=array();
		$query="select * from 3506_publicacionesRegistro WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idRegistro;
		$resPublicacion=$con->obtenerFilas($query);
		
		while($filaPublicacion=$con->fetchAssoc($resPublicacion))
		{
			$arrRegistrosPublicaciones[$filaPublicacion["iRegistro"]]=1;
		}

		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 3506_publicacionesRegistro WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idRegistro;
		$x++;
		
		foreach($obj->arrRegistros as $r)
		{
			$consulta[$x]="INSERT INTO 3506_publicacionesRegistro(idFormulario,idReferencia,iRegistro,publicar) 
						VALUES(".$obj->idFormulario.",".$obj->idRegistro.",".$r->idActuacion.",".$r->publicar.")";
			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
		{
			foreach($arrRegistrosPublicaciones as $iRegistro=>$resto)
			{
				cambiarEtapaFormulario(1251,$iRegistro,3,"",-1,"NULL","NULL",0);
			}
			foreach($obj->arrRegistros as $r)
			{
				if($r->publicar==1)
					cambiarEtapaFormulario(1251,$r->idActuacion,3.5,"",-1,"NULL","NULL",0);
			}
			
			$plantilla="";
			$prefijoPublicacion="";
			$idFormularioEditor="";
			$categoriaPublicacion="";
			switch($obj->idFormulario)
			{
				case 1256:
					$idFormularioEditor=1265;
					$prefijoPublicacion="estado_";
					$categoriaPublicacion=174;
					$plantilla="plantillaEstadoElectronico.xlsx";
				break;
				case 1258:
					$idFormularioEditor=1266;
					$prefijoPublicacion="edicto_";
					$categoriaPublicacion=175;
					$plantilla="plantillaEdicto.xlsx";
				break;
				case 1259:
					$idFormularioEditor=1290;
					$prefijoPublicacion="lista_";
					$categoriaPublicacion=735;
					$plantilla="plantillaPublicacionLista.xlsx";
				break;
			}
			
			$libro=new cExcel("../plantillas/".$plantilla,true,"Excel2007");	
			if($obj->idFormulario==1259)
			{
				
				$textoLetra=convertirFechaLetra($fechaEstimadaEstado,false,false);
				$arrFecha=explode(" ",$textoLetra);
				$lblDiaFecha=mb_strtolower(convertirNumeroLetra(($arrFecha[0]*1),false,false));
				$lblAnioFecha=mb_strtolower(convertirNumeroLetra(($arrFecha[4]*1),false,false));
				
				
				$libro->setValor("A2",$nombreDespacho);
				$leyendaFinal="ACORDE CON LO REGULADO EN EL ARTÍCULO 110 DEL CÓDIGO GENERAL DEL PROCESO. SE FIJA LA PRESENTE LISTA DE TRASLADO HOY ".mb_strtoupper($lblDiaFecha)." (".$arrFecha[0].") DE\r\n".
							mb_strtoupper($arrFecha[2])." DE ".mb_strtoupper($lblAnioFecha)." (".$arrFecha[4].") A LAS SIETE (7) DE LA MAÑANA.\r\n".
							"Y SE DESFIJA EN LA MISMA FECHA A LAS CUATRO (4) DE LA TARDE.";
				$libro->setValor("A8",$leyendaFinal);
				$consulta="SELECT iRegistro FROM 3506_publicacionesRegistro WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idRegistro." AND publicar=1";
				$listaPublica=$con->obtenerListaValores($consulta);
				$numFilaAgregar=$con->filasAfectadas;
				
				if($listaPublica=="")
					$listaPublica=-1;
				
				$numFila=7;
				
				$libro->insertarFila(($numFila+1),$numFilaAgregar-1);
				
				$arrRegistros="";
				$consulta="SELECT id__1251_tablaDinamica AS idRegistro,e.codigo,resumenActuacion,comentariosAdicionales,e.carpetaAdministrativa,
							c.idActividad,e.fechaCreacion,c.tipoProceso,t.fechaPublicacion,c.unidadGestion
							FROM _1252_tablaDinamica t,_1251_tablaDinamica e,7006_carpetasAdministrativas c 
							WHERE e.id__1251_tablaDinamica=t.idReferencia AND c.carpetaAdministrativa=e.carpetaAdministrativa
							and id__1251_tablaDinamica in (".$listaPublica.")
							ORDER BY t.id__1252_tablaDinamica";
					
				$resRegistros=$con->obtenerFilas($consulta);
		
				while($fila=$con->fetchAssoc($resRegistros))					
				{
		
					$consulta="SELECT u.Nombre,i.Genero FROM 800_usuarios u,807_usuariosVSRoles uR,802_identifica i,801_adscripcion a WHERE 
								uR.idUsuario=u.idUsuario AND uR.idRol IN(56,96) AND u.cuentaActiva=1
								AND i.idUsuario=u.idUsuario and a.idUsuario=u.idUsuario and a.Institucion='".$fila["unidadGestion"]."' LIMIT 0,1";
							
					$fMagistrado=$con->obtenerPrimeraFilaAsoc($consulta);
		
					$demantante="";
					$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
								FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
								AND r.idActividad=".$fila["idActividad"]." AND r.idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='A') ORDER BY nombre,nombre,apellidoMaterno";
					
					$res=$con->obtenerFilas($consulta);
					while($filaImputado=$con->fetchRow($res))
					{
						$nombre=trim($filaImputado[0]);
						if($demantante=="")
							$demantante=$nombre;
						else
							$demantante.=", ".$nombre;
					}
					
					$demandados="";
					$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
								FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
								AND r.idActividad=".$fila["idActividad"]." AND r.idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='D') ORDER BY nombre,nombre,apellidoMaterno";
					
					$res=$con->obtenerFilas($consulta);
					while($filaImputado=$con->fetchRow($res))
					{
						$nombre=trim($filaImputado[0]);
						if($demandados=="")
							$demandados=$nombre;
						else
							$demandados.=", ".$nombre;
					}
					
					$consulta="SELECT nombreTipoProceso FROM _625_tablaDinamica WHERE id__625_tablaDinamica=".$fila["tipoProceso"];
					$tipoProceso=$con->obtenerValor($consulta);
					
					$libro->setValor("A".$numFila,"=CONCATENATE(\"".$fila["carpetaAdministrativa"]."\",\"\")");
					$libro->setValor("B".$numFila,$tipoProceso);
					$libro->setValor("C".$numFila,$demantante);
					$libro->setValor("D".$numFila,$demandados);
					$libro->setValor("E".$numFila,"5 DÍAS AL RECURRENTE Y SEGUIDAMENTE 5 DÍAS A LA PARTE CONTRARIA. IGUAL TÉRMINO CONCURRIRÁ PARA EL MINISTERIO PÚBLICO");
					$libro->setValor("F".$numFila,"5 DÍAS AL RECURRENTE Y SEGUIDAMENTE 5 DÍAS A LA PARTE CONTRARIA. IGUAL TÉRMINO CONCURRIRÁ PARA EL MINISTERIO PÚBLICO");
					$libro->setValor("G".$numFila,$fMagistrado["Nombre"]);
					$numFila++;
				}
			}
			else
			{
				
				$libro->setValor("C3","Fecha Fijación: ".date("d/m/Y",strtotime($fechaEstimadaEstado)));
				$libro->setValor("B3","=CONCATENATE(\"".$codigo."\",\"\")");
				$texto=$libro->getValor("A8");
				$libro->setValor("A1",$nombreDespacho);
				$libro->setValor("A8",str_replace("[fechaPublicacion]",date("d/m/Y",strtotime($fechaEstimadaEstado)),$texto));
				$libro->setValor("A10",obtenerNombreUsuario($_SESSION["idUsr"]));
				
				
				$consulta="SELECT iRegistro FROM 3506_publicacionesRegistro WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idRegistro." AND publicar=1";
				$listaPublica=$con->obtenerListaValores($consulta);
				$numFilaAgregar=$con->filasAfectadas;
				
				if($listaPublica=="")
					$listaPublica=-1;
				
				$numFila=7;
				
				$libro->insertarFila(($numFila+1),$numFilaAgregar-1);
				
				$arrRegistros="";
				$consulta="SELECT id__1251_tablaDinamica AS idRegistro,e.codigo,resumenActuacion,comentariosAdicionales,e.carpetaAdministrativa,
							c.idActividad,e.fechaCreacion,c.tipoProceso,t.fechaPublicacion
							FROM _1252_tablaDinamica t,_1251_tablaDinamica e,7006_carpetasAdministrativas c 
							WHERE e.id__1251_tablaDinamica=t.idReferencia AND c.carpetaAdministrativa=e.carpetaAdministrativa
							and id__1251_tablaDinamica in (".$listaPublica.")
							ORDER BY t.id__1252_tablaDinamica";
					
				$resRegistros=$con->obtenerFilas($consulta);
		
				while($fila=$con->fetchAssoc($resRegistros))					
				{
		
					$demantante="";
					$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
								FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
								AND r.idActividad=".$fila["idActividad"]." AND r.idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='A') ORDER BY nombre,nombre,apellidoMaterno";
					
					$res=$con->obtenerFilas($consulta);
					while($filaImputado=$con->fetchRow($res))
					{
						$nombre=trim($filaImputado[0]);
						if($demantante=="")
							$demantante=$nombre;
						else
							$demantante.=", ".$nombre;
					}
					
					$demandados="";
					$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
								FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
								AND r.idActividad=".$fila["idActividad"]." AND r.idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='D') ORDER BY nombre,nombre,apellidoMaterno";
					
					$res=$con->obtenerFilas($consulta);
					while($filaImputado=$con->fetchRow($res))
					{
						$nombre=trim($filaImputado[0]);
						if($demandados=="")
							$demandados=$nombre;
						else
							$demandados.=", ".$nombre;
					}
					
					$consulta="SELECT nombreTipoProceso FROM _625_tablaDinamica WHERE id__625_tablaDinamica=".$fila["tipoProceso"];
					$tipoProceso=$con->obtenerValor($consulta);
					
					$libro->setValor("A".$numFila,"=CONCATENATE(\"".$fila["carpetaAdministrativa"]."\",\"\")");
					$libro->setValor("B".$numFila,$tipoProceso);
					$libro->setValor("C".$numFila,$demantante);
					$libro->setValor("D".$numFila,$demandados);
					$libro->setValor("E".$numFila,str_replace("<br />","\r",$fila["resumenActuacion"]));
					$libro->setValor("F".$numFila,"=CONCATENATE(\"".date("d/m/Y",strtotime($fila["fechaCreacion"]))."\",\"\")");
					$libro->setValor("G".$numFila,"");
					$numFila++;
				}
			}
			
			
			$libro->generarArchivoServidor('PDF',$baseDir."/archivosTemporales/".$prefijoPublicacion.$codigo.".xlsx");
			if(file_exists($baseDir."/archivosTemporales/".$prefijoPublicacion.$codigo.".pdf"))
			{
				
				$query="select idRegistro FROM 7035_informacionDocumentos WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idRegistro;
				$idRegistro=$con->obtenerValor($query);
				$x=0;
				$consulta=array();
				$consulta[$x]="begin";
				$x++;
				
				if($idRegistro=="")
				{
					

					
					$idDocumento=registrarDocumentoServidorRepositorio($prefijoPublicacion.$codigo.".pdf",$prefijoPublicacion.$codigo.".pdf",$categoriaPublicacion);
					
					$consulta[$x]="INSERT INTO 7035_informacionDocumentos(fechaCreacion,idResponsableCreacion,tipoDocumento,tituloDocumento,
									modificaSituacionCarpeta,carpetaAdministrativa,situacionDocumento,perfilValidacion,idFormulario,
									idReferencia,idFormularioProceso) values('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$categoriaPublicacion.
									",'".$prefijoPublicacion.$codigo.".pdf',0,'',1,3,".$obj->idFormulario.",".$obj->idRegistro.",".$idFormularioEditor.")";
					$x++;
					
					$consulta[$x]="set @idRegistro:=(select last_insert_id())";
					$x++;
					
					$consulta[$x]="INSERT INTO 3000_formatosRegistrados(fechaRegistro,idResponsableRegistro,tipoFormato,idFormulario,idRegistro,
									idReferencia,firmado,documentoBloqueado,situacionActual,idPerfilEvaluacion,idDocumentoAdjunto,idFormularioProceso)
									values('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$categoriaPublicacion.",-2,@idRegistro,@idRegistro,0,0,1,3,".$idDocumento.",".$idFormularioEditor.")";
					$x++;
					
				}
				else
				{
					$query="SELECT idDocumentoAdjunto FROM 3000_formatosRegistrados WHERE idFormulario=-2 AND idRegistro=".$idRegistro;
					$idDocumentoAdjunto=$con->obtenerValor($query);
					$cuerpoDocumento=leerContenidoArchivo($baseDir."/archivosTemporales/".$prefijoPublicacion.$codigo.".pdf");
					reemplazarArchivoRepositorio($idDocumentoAdjunto,$cuerpoDocumento);
					unlink($baseDir."/archivosTemporales/".$prefijoPublicacion.$codigo.".pdf");
				}
				
				$consulta[$x]="commit";
				$x++;
				
				eB($consulta);
			}
		}
		
		
	}
	
	function obtenerRegistrosPublicacionesFinales()
	{
		global $con;
		$anio=$_POST["anio"];
		$mes=$_POST["mes"];
		$tipoPublicacion=$_POST["tipoPublicacion"];
		$codigoInstitucion=$_POST["codigoInstitucion"];
		
		$fechaInicial=$anio."-".str_pad($mes,2,"0",STR_PAD_LEFT)."-01";
		$fechaFinal=obtenerUltimoDiaMes($fechaInicial);

		
		$idFormulario="";
		switch($tipoPublicacion)
		{
			case 1:
				$idFormulario=1256;
			break;
			case 2:
				$idFormulario=1258;
			break;
		}
		
		
		$consulta="SELECT id__".$idFormulario."_tablaDinamica as idRegistro, codigo as noEstado,
				(SELECT idDocumento FROM 9074_documentosRegistrosProceso WHERE idFormulario=".$idFormulario." AND idRegistro=id__".$idFormulario."_tablaDinamica) as idDocumento,fechaEstimadaEstado as fechaEstado,
				(SELECT COUNT(*) FROM 3506_publicacionesRegistro r WHERE idFormulario=".$idFormulario." AND idReferencia=id__".$idFormulario."_tablaDinamica AND publicar=1) 
				as totalProvidencias FROM _".$idFormulario."_tablaDinamica 
				WHERE fechaEstimadaEstado>='".$fechaInicial."' AND fechaEstimadaEstado<='".$fechaFinal."' AND idEstado=3
				and codigoInstitucion='".$codigoInstitucion."'";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	
		
	}
	
	function busquedaDespachoPublicaciones()
	{
		global $con;
		$criterio=$_POST["criterio"];
		
		$consulta="SELECT claveUnidad AS codigoUnidad,nombreUnidad AS despacho FROM _17_tablaDinamica WHERE nombreUnidad LIKE '%".$criterio."%' ORDER BY nombreUnidad";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	}
	
	function obtenerDespachosGrupoReparto()
	{
		global $con;
		global $WHERE;
		$idGrupo=$_POST["idGrupo"];
		$arrResultado=obtenerDespachosAsociadosGrupoReparto($idGrupo);
		$arrRegistros="";
		$numReg=0;
		foreach($arrResultado as  $r)
		{
			
			$obj='{"codigoUnidad":"'.$r["codigoUnidad"].'","cveDespacho":"'.$r["claveDepartamental"].'","nombreDespacho":"'.cv($r["unidad"]).
					'","objConfiguracion":"'.bE($r["objConfiguracion"]).'","tipoUnidad":"'.cv($r["tipoUnidad"]).'"}';
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
			$numReg++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerBitacoraReparto()
	{
		global $con;
		global $versionLatis;
		
		$fechaInicio=$_POST["fechaInicio"];
		$fechaFin=$_POST["fechaFin"];
		$grupoReparto=$_POST["grupoReparto"];
		$circuitoJuicial=$_POST["circuitoJuicial"];
		$municipio=$_POST["municipio"];
		$tipoDespacho=$_POST["tipoDespacho"];
		
		
		
		$arrDespachos=array();
		$numReg=0;
		$arrRegistros="";
		$consulta="SELECT idAsignacion,idFormulario,idRegistro,AES_DECRYPT(UNHEX(idObjetoReferido), '".bD($versionLatis)."') AS idObjetoReferido,
					AES_DECRYPT(UNHEX(idUnidadReferida), '".bD($versionLatis)."') AS idUnidadReferida,
					 fechaAsignacion,
					AES_DECRYPT(UNHEX(tipoRonda), '".bD($versionLatis)."') AS tipoRonda,
					AES_DECRYPT(UNHEX(noRonda), '".bD($versionLatis)."') AS noRonda,
					situacion,rondaPagada,
					AES_DECRYPT(UNHEX(comentariosAdicionales), '".bD($versionLatis)."') AS comentariosAdicionales,
					AES_DECRYPT(UNHEX(tipoAsignacion), '".bD($versionLatis)."') AS tipoAsignacion,
					AES_DECRYPT(UNHEX(idAsignacionPagada), '".bD($versionLatis)."') AS idAsignacionPagada,
					AES_DECRYPT(UNHEX(objParametros), '".bD($versionLatis)."') AS objParametros FROM 
					7001_asignacionesObjetos where fechaAsignacion>='".$fechaInicio."' and fechaAsignacion<='".$fechaFin." 23:59:59'";
		if($grupoReparto!="")
		{
			$condAdicional="";
			$arrGruposRepartos=explode(",",$grupoReparto);
			foreach($arrGruposRepartos as $g)
			{
				$cond=" AES_DECRYPT(UNHEX(tipoRonda), '".bD($versionLatis)."') like 'GrupoReparto\_".$g."%'";
				if($condAdicional=="")
				{
					$condAdicional=$cond;
					
				}
				else
					$condAdicional.=" or ".$cond;
			}
			
			$consulta.=" and (".$condAdicional.")";
		}
			
		if($circuitoJuicial!="")
		{
			$condAdicional='';
			$consultaAux="SELECT codigoUnidad FROM 817_organigrama WHERE institucion=12 AND claveDepartamental='".$circuitoJuicial."'";

			$rCircuito=$con->obtenerFilas($consultaAux);
			while($fila=$con->fetchAssoc($rCircuito))
			{
				$token="AES_DECRYPT(UNHEX(idUnidadReferida), '".bD($versionLatis)."') like '".$fila["codigoUnidad"]."%'";
				if($condAdicional=="")
					$condAdicional=$token;
				else
					$condAdicional.=" and ".$token;
			}
				
				
			$consulta.=" and (".$condAdicional.")";
			
			
		}
		
		if($municipio!="")
		{
			$condAdicional='';
			$consultaAux="SELECT codigoUnidad FROM 817_organigrama WHERE institucion=13 AND claveDepartamental='".$municipio."'";

			$rCircuito=$con->obtenerFilas($consultaAux);
			while($fila=$con->fetchAssoc($rCircuito))
			{
				$token="AES_DECRYPT(UNHEX(idUnidadReferida), '".bD($versionLatis)."') like '".$fila["codigoUnidad"]."%'";
				if($condAdicional=="")
					$condAdicional=$token;
				else
					$condAdicional.=" and ".$token;
			}
				
				
			$consulta.=" and (".$condAdicional.")";
			
			
		}
		
		
		$considerarTiposDespacho=false;
		$arrTiposDespacho=array();
		if($tipoDespacho!="")
		{
			$considerarTiposDespacho=true;
		}

		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			$considerarDespacho=true;
			$consulta="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$fila["idUnidadReferida"]."'";
			$despacho=$con->obtenerValor($consulta);
			if($despacho=="")
				$considerarDespacho=false;

			if($considerarTiposDespacho)
			{
				$consultaAux="SELECT COUNT(*)  FROM _17_tablaDinamica d, _17_gridAtributosDespacho a WHERE a.idReferencia=d.id__17_tablaDinamica
							AND d.claveUnidad='".$fila["idUnidadReferida"]."' AND a.idAtributoDespacho IN(".$tipoDespacho.")";
				$nAtributos=$con->obtenerValor($consultaAux);			
				
				if($nAtributos==0)
					$considerarDespacho=false;
			}
			if($considerarDespacho)
			{
				if(!isset($arrDespachos[$fila["idUnidadReferida"]]))
				{
					$arrDespachos[$fila["idUnidadReferida"]][1]=0;
					$arrDespachos[$fila["idUnidadReferida"]][2]=0;

				}
				if($fila["situacion"]==3)
					$fila["situacion"]=1;
				if($fila["situacion"]!=20)
					$arrDespachos[$fila["idUnidadReferida"]][$fila["situacion"]]++;
				
	
				$o='{"idAsignacion":"'.$fila["idAsignacion"].'","idFormulario":"'.$fila["idFormulario"].'","idRegistro":"'.$fila["idRegistro"].
					'","idObjetoReferido":"'.$fila["idObjetoReferido"].'","idUnidadReferida":"'.cv($despacho).'","fechaAsignacion":"'.
					$fila["fechaAsignacion"].'","tipoRonda":"'.$fila["tipoRonda"].'","noRonda":"'.$fila["noRonda"].
					'","situacion":"'.$fila["situacion"].'","rondaPagada":"'.$fila["rondaPagada"].'","comentariosAdicionales":"'.$fila["comentariosAdicionales"].
					'","tipoAsignacion":"'.$fila["tipoAsignacion"].'","idAsignacionPagada":"'.$fila["idAsignacionPagada"].'","objParametros":"'.cv(json_encode(unserialize($fila["objParametros"]))).'"}';
			
				if($arrRegistros=="")
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;
				$numReg++;
			}
			
			
		}
		
		$arrStadisticas="";
		foreach($arrDespachos as $clave=>$valor)
		{
			$consulta="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$clave."'";
			$despacho=$con->obtenerValor($consulta);
			if($despacho!="")
			{

				$o='{"despacho":"'.cv($despacho).'","situacion_1":"'.$valor[1].'","situacion_2":"'.$valor[2].'"}';
			
				if($arrStadisticas=="")
					$arrStadisticas=$o;
				else
					$arrStadisticas.=",".$o;
			}
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.'],"arrStadisticas":['.$arrStadisticas.']}';
	}
?>