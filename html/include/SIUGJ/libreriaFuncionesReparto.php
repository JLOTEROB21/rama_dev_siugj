<?php
	function realizarRepartoAsignacionConJuez($idFormulario,$idRegistro)
	{
		global $con;
		
		$consulta="SELECT * FROM _977_tablaDinamica WHERE id__977_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		if(($fRegistro["idConjuezAsignado"]!="N/E")&&($fRegistro["idConjuezAsignado"]!=""))
		{
			return true;
		}
		
		
		
		$consulta="SELECT id__976_tablaDinamica FROM _976_tablaDinamica WHERE idEstado=2 ORDER BY id__976_tablaDinamica";
		$universoDespachos=$con->obtenerListaValores($consulta);
		$arrConfiguracion["tipoAsignacion"]="";
		$arrConfiguracion["serieRonda"]="GrupoConJuez";
		$arrConfiguracion["universoAsignacion"]=$universoDespachos;
		$arrConfiguracion["idObjetoReferencia"]=-1;
		$arrConfiguracion["pagarDeudasAsignacion"]=false;
		$arrConfiguracion["considerarDeudasMismaRonda"]=false;
		$arrConfiguracion["limitePagoRonda"]=0;
		$arrConfiguracion["escribirAsignacion"]=true;
		$arrConfiguracion["idFormulario"]=$idFormulario;
		$arrConfiguracion["idRegistro"]=$idRegistro;
		$resultado= obtenerSiguienteAsignacionObjeto($arrConfiguracion,true);
		$idConjuezAsignado=$resultado["idUnidad"];
		
		if($idConjuezAsignado=="")
			$idConjuezAsignado=-1;
		
		$consulta="UPDATE _977_tablaDinamica SET idConjuezAsignado=".$idConjuezAsignado.",fechaAsignacion='".date("Y-m-d H:i:s")."' WHERE  id__977_tablaDinamica=".$idRegistro;
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="SELECT * FROM _976_tablaDinamica WHERE id__976_tablaDinamica=".$idConjuezAsignado;
			$fConjuez=$con->obtenerPrimeraFilaAsoc($consulta);
			$arrParam=array();
			$arrParam["emailDestinatario"]=$fConjuez["mailContacto"];
			$arrParam["nombreDestinatario"]=$fConjuez["tituloConjuez"]." ".$fConjuez["nombre"]." ".$fConjuez["primerApellido"]." ".$fConjuez["segundoApellido"];
			$arrParam["codigoUnicoProceso"]=$fRegistro["carpetaAdministrativa"];
			
			$consulta="SELECT tipoProceso,idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fRegistro["carpetaAdministrativa"]."'";
			$fDatosExpediente=$con->obtenerPrimeraFilaAsoc($consulta);
			$tipoProceso=$fDatosExpediente["tipoProceso"];
			$idActividad=$fDatosExpediente["idActividad"];
			
			$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$fRegistro["codigoInstitucion"]."'";
			$despacho=$con->obtenerValor($consulta);
			
			$demantante="";
			$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
						FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
						AND r.idActividad=".$idActividad." AND r.idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='A') ORDER BY nombre,nombre,apellidoMaterno";
			
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
						AND r.idActividad=".$idActividad." AND r.idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='D') ORDER BY nombre,nombre,apellidoMaterno";
			
			$res=$con->obtenerFilas($consulta);
			while($filaImputado=$con->fetchRow($res))
			{
				$nombre=trim($filaImputado[0]);
				if($demandados=="")
					$demandados=$nombre;
				else
					$demandados.=", ".$nombre;
			}
			
			$arrParam["etDemandante"]=$tipoProceso==6?"ACCIONANTE":"ACTOR";
			$arrParam["etDemandado"]=$tipoProceso==6?"ACCIONADO":"DEMANDADO";;
			$arrParam["lblDemandante"]=$demantante;
			$arrParam["fieldDemandado"]=$demandados;
			$arrParam["despacho"]=$despacho;
			if(enviarMensajeEnvio(26,$arrParam))
				return true;
	
		}
		return false;
		
	}
	
	
	function realizarRepartoAsignacionSalaSeleccion($idFormulario,$idRegistro)
	{
		global $con;
		
		$consulta="SELECT * FROM _917_tablaDinamica WHERE id__917_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		if(($fRegistro["salaRevision"]!="N/E")&&($fRegistro["salaRevision"]!=""))
		{
			return true;
		}
		
		$carpetaAdministrativa=$fRegistro["carpetaAdministrativa"];
		
		$consulta="SELECT id__992_tablaDinamica FROM _992_tablaDinamica WHERE tipoSala=2";
		$universoDespachos=$con->obtenerListaValores($consulta);
		$arrConfiguracion["tipoAsignacion"]="";
		$arrConfiguracion["serieRonda"]="Grupo_SalaSeleccion";
		$arrConfiguracion["universoAsignacion"]=$universoDespachos;
		$arrConfiguracion["idObjetoReferencia"]=-1;
		$arrConfiguracion["pagarDeudasAsignacion"]=false;
		$arrConfiguracion["considerarDeudasMismaRonda"]=false;
		$arrConfiguracion["limitePagoRonda"]=0;
		$arrConfiguracion["escribirAsignacion"]=true;
		$arrConfiguracion["idFormulario"]=$idFormulario;
		$arrConfiguracion["idRegistro"]=$idRegistro;
		$resultado= obtenerSiguienteAsignacionObjeto($arrConfiguracion,true);
		$idSalaRevision=$resultado["idUnidad"];

		if($idSalaRevision=="")
			$idSalaRevision=-1;
		
		
		$query="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."' AND tipoCarpetaAdministrativa=1";
		$fDatosBase=$con->obtenerPrimeraFilaAsoc($query);
		$consulta=array();
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$query="SELECT despachoAsigando FROM _993_tablaDinamica WHERE idReferencia=".$idSalaRevision;
		$res=$con->obtenerFilas($query);
		while($fila=$con->fetchAssoc($res))
		{
			$consulta[$x]="INSERT INTO 7006_carpetasAdministrativas(carpetaAdministrativa,fechaCreacion,responsableCreacion,idFormulario,
							idRegistro,unidadGestion,etapaProcesalActual,idActividad,carpetaAdministrativaBase,
							tipoCarpetaAdministrativa,unidadGestionOriginal,especialidad,tipoProceso,claseProceso,subclaseProceso,tema,subtema) 
							VALUES('".$carpetaAdministrativa."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$idFormulario.",'".$idRegistro."','".
							$fila["despachoAsigando"]."',10,".$fDatosBase["idActividad"].",NULL,30,'".$fila["despachoAsigando"]."',".($fDatosBase["especialidad"]==""?"NULL":$fDatosBase["especialidad"]).",".
							($fDatosBase["tipoProceso"]==""?"NULL":$fDatosBase["tipoProceso"]).",".($fDatosBase["claseProceso"]==""?"NULL":$fDatosBase["claseProceso"]).
							",".($fDatosBase["subclaseProceso"]==""?"NULL":$fDatosBase["subclaseProceso"]).
							",".($fDatosBase["tema"]==""?"NULL":$fDatosBase["tema"]).",".($fDatosBase["subtema"]==""?"NULL":$fDatosBase["subtema"]).")";
			
	
			$x++;
		}
		$consulta[$x]="UPDATE _917_tablaDinamica SET salaRevision=".$idSalaRevision." WHERE  id__917_tablaDinamica=".$idRegistro;
		$x++;
		$consulta[$x]="commit";
		$x++;
		

		if($con->ejecutarBloque($consulta))
		{
			/*$consulta="SELECT * FROM _976_tablaDinamica WHERE id__976_tablaDinamica=".$idConjuezAsignado;
			$fConjuez=$con->obtenerPrimeraFilaAsoc($consulta);
			$arrParam=array();
			$arrParam["emailDestinatario"]=$fConjuez["mailContacto"];
			$arrParam["nombreDestinatario"]=$fConjuez["tituloConjuez"]." ".$fConjuez["nombre"]." ".$fConjuez["primerApellido"]." ".$fConjuez["segundoApellido"];
			$arrParam["codigoUnicoProceso"]=$fRegistro["carpetaAdministrativa"];
			
			$consulta="SELECT tipoProceso,idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fRegistro["carpetaAdministrativa"]."'";
			$fDatosExpediente=$con->obtenerPrimeraFilaAsoc($consulta);
			$tipoProceso=$fDatosExpediente["tipoProceso"];
			$idActividad=$fDatosExpediente["idActividad"];
			
			$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$fRegistro["codigoInstitucion"]."'";
			$despacho=$con->obtenerValor($consulta);
			
			$demantante="";
			$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
						FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
						AND r.idActividad=".$idActividad." AND r.idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='A') ORDER BY nombre,nombre,apellidoMaterno";
			
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
						AND r.idActividad=".$idActividad." AND r.idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='D') ORDER BY nombre,nombre,apellidoMaterno";
			
			$res=$con->obtenerFilas($consulta);
			while($filaImputado=$con->fetchRow($res))
			{
				$nombre=trim($filaImputado[0]);
				if($demandados=="")
					$demandados=$nombre;
				else
					$demandados.=", ".$nombre;
			}
			
			$arrParam["etDemandante"]=$tipoProceso==6?"ACCIONANTE":"ACTOR";
			$arrParam["etDemandado"]=$tipoProceso==6?"ACCIONADO":"DEMANDADO";;
			$arrParam["lblDemandante"]=$demantante;
			$arrParam["fieldDemandado"]=$demandados;
			$arrParam["despacho"]=$despacho;
			if(enviarMensajeEnvio(26,$arrParam))*/
				return true;
	
		}
		return false;
		
	}
	
	
	function realizarRepartoProcesosVarios($idFormulario,$idRegistro)
	{
		global $con;
		$idUsuarioRegistrante=$_SESSION["idUsr"];
		$consulta="SELECT * FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);


		$campoCarpetaAdministrativa="carpetaAdministrativa";
		
		
		switch($idFormulario)
		{
			case 944://apelacion
				$campoCarpetaAdministrativa="carpetaAdministrativa2daInstancia";
			break;
			case 677://Casacion
			case 952://Impedimento
				$campoCarpetaAdministrativa="carpetaAdministrativa2aInstancia";
			break;
		}
		
			
		
		if(($fRegistro[$campoCarpetaAdministrativa]!="N/E")&&($fRegistro[$campoCarpetaAdministrativa]!="")&&($idFormulario!=1204))
		{

			return true;
		}
		
	
		$asignacionAntecedente=false;
		$compReparto="";
		$etapaProcesal=1;
		
		$iActividadCarpetaBase=-1;
		$tipoCarpetaAdministrativa=1;
		$tipoProceso=0;
		$esSalaVirtual=false;
		$cveDespacho="";
		$carpetaAdministrativaBase="";
		
		$idFiguraDemandante=2;
		$idFiguraDemandado=4;
		
		switch($idFormulario)
		{
			case 952: //Casacion impedimento
				if($fRegistro["motivoReasignacion"]==1)
				{
					$etapaProcesal=3;
					$tipoCarpetaAdministrativa=20;
					$idFiguraDemandante=20;
					$idFiguraDemandado=21;
					
					$arrCarpetas=array();
					obtenerCarpetasPadre($fRegistro["carpetaAdministrativa"],$arrCarpetas);
					array_push($arrCarpetas,$fRegistro["carpetaAdministrativa"]);
					$listaExclusion="";
					foreach($arrCarpetas as $c)
					{
						$consulta="SELECT tipoCarpetaAdministrativa,unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$c."'";
						$fDatosCarpeta=$con->obtenerPrimeraFilaAsoc($consulta);
						$tipoCarpetaAdministrativa=$fDatosCarpeta["tipoCarpetaAdministrativa"];
						
						if($tipoCarpetaAdministrativa==20)
						{
							$consulta="SELECT idReferencia FROM _993_tablaDinamica WHERE despachoAsigando='".$fDatosCarpeta["unidadGestion"]."' AND presideSala=1";
							$sala=$con->obtenerValor($consulta);
							if($listaExclusion=="")
								$listaExclusion=$sala;
							else
								$listaExclusion.=",".$sala;
							
							
						}
					}
					
					if($listaExclusion=="")
						$listaExclusion=-1;
					
					
					$consulta="SELECT carpetaAdministrativa FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
					$carpetaAdministrativaBase=$con->obtenerValor($consulta);	
					
					
					$consulta="SELECT tipoProceso,idActividad,especialidad,claseProceso FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativaBase."'";
					$fCarpetaBase=$con->obtenerPrimeraFilaAsoc($consulta);
					$tipoProceso=$fCarpetaBase["tipoProceso"];
					$iActividadCarpetaBase=$fCarpetaBase["idActividad"];
					$fRegistro["especialidad"]=$fCarpetaBase["especialidad"];
					$fRegistro["claseProceso"]=$fCarpetaBase["claseProceso"];
					$esSalaVirtual=true;
						
					$consulta="SELECT id__992_tablaDinamica FROM _992_tablaDinamica WHERE tipoSala=3 AND corporacion='100000010002' and id__992_tablaDinamica in(24,25,26) 
								and id__992_tablaDinamica not in(".$listaExclusion.")";
								
					$universoDespachos=$con->obtenerListaValores($consulta);
					if($universoDespachos=="")
					{
						$query="update _".$idFormulario."_tablaDinamica set despachoAsignado='0000000000' where id__".$idFormulario."_tablaDinamica=".$idRegistro;
			
						return $con->ejecutarConsulta($query);
					}			
								
				}
			break;
			case 944: //Apelacion

			
				$idFiguraDemandante=18;
				$idFiguraDemandado=19;
				$etapaProcesal=2;
				$tipoCarpetaAdministrativa=2;
				
				$consulta="SELECT carpetaAdministrativa FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
				$carpetaAdministrativaBase=$con->obtenerValor($consulta);				
				$consulta="SELECT tipoProceso,idActividad,especialidad,claseProceso FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativaBase."'";
				$fCarpetaBase=$con->obtenerPrimeraFilaAsoc($consulta);
				$tipoProceso=$fCarpetaBase["tipoProceso"];
				$iActividadCarpetaBase=$fCarpetaBase["idActividad"];
				
				
				$fRegistro["especialidad"]=$fCarpetaBase["especialidad"];
				$fRegistro["claseProceso"]=$fCarpetaBase["claseProceso"];
				
				$consulta="SELECT * FROM _992_tablaDinamica WHERE tipoSala=3 AND corporacion='10000002' AND id__992_tablaDinamica<14";
				$esSalaVirtual=true;
				
				
				
				$consultaAuxiliar="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativaBase='".$carpetaAdministrativaBase.
							"' AND tipoCarpetaAdministrativa IN(2,3) ORDER BY fechaCreacion DESC limit 0,1";
				$universoAuxiliar=$con->obtenerValor($consultaAuxiliar);
				
				if($universoAuxiliar!="")
				{
					$consultaAuxiliar="SELECT idReferencia FROM _993_tablaDinamica WHERE despachoAsigando='".$universoAuxiliar."' AND presideSala=1";

					$universoAuxiliar=$con->obtenerValor($consultaAuxiliar);
					if($universoAuxiliar!="")
					{
						$consulta.=" and id__992_tablaDinamica=".$universoAuxiliar;
						$compReparto="_Reparto_Antecedente";
					}
					$asignacionAntecedente=true;
				}
				
			
				
				
			break;
			case 677://Casacion
				$etapaProcesal=3;
				$tipoCarpetaAdministrativa=20;
				$idFiguraDemandante=20;
				$idFiguraDemandado=21;
				$consulta="SELECT carpetaAdministrativa FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
				$carpetaAdministrativaBase=$con->obtenerValor($consulta);	
				
							
				$consulta="SELECT tipoProceso,idActividad,especialidad,claseProceso FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativaBase."'";
				$fCarpetaBase=$con->obtenerPrimeraFilaAsoc($consulta);
				$tipoProceso=$fCarpetaBase["tipoProceso"];
				$iActividadCarpetaBase=$fCarpetaBase["idActividad"];
				
				
				$fRegistro["especialidad"]=$fCarpetaBase["especialidad"];
				$fRegistro["claseProceso"]=$fCarpetaBase["claseProceso"];
				
				$consulta="SELECT id__992_tablaDinamica FROM _992_tablaDinamica WHERE tipoSala=3 AND corporacion='100000010002' and id__992_tablaDinamica in(24,25,26)";
				$esSalaVirtual=true;
				
				
				
				/*$consultaAuxiliar="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativaBase='".$carpetaAdministrativaBase.
							"' AND tipoCarpetaAdministrativa IN(2,3) ORDER BY fechaCreacion DESC limit 0,1";
				$universoAuxiliar=$con->obtenerValor($consultaAuxiliar);
				
				if($universoAuxiliar!="")
				{
					$consultaAuxiliar="SELECT idReferencia FROM _993_tablaDinamica WHERE despachoAsigando='".$universoAuxiliar."' AND presideSala=1";
					$universoAuxiliar=$con->obtenerValor($consultaAuxiliar);
					if($universoAuxiliar!="")
					{
						$consulta.=" and id__992_tablaDinamica=".$universoAuxiliar;
						$compReparto="_Reparto_Antecedente";
					}
					$asignacionAntecedente=true;
				}*/
				
				
			break;
			case 1162://Depósito Judicial
				$tipoProceso=21;
				$consulta="SELECT claveUnidad FROM _17_tablaDinamica WHERE categoriaDespacho=4 ORDER BY id__17_tablaDinamica";
				$fRegistro["especialidad"]=2;
				$fRegistro["claseProceso"]=34;
				$tipoCarpetaAdministrativa=50;

			break;
			case 1163://Pagos por Consignación
				$tipoProceso=22;
				$consulta="SELECT claveUnidad FROM _17_tablaDinamica WHERE categoriaDespacho=4 ORDER BY id__17_tablaDinamica";
				$fRegistro["especialidad"]=2;
				$fRegistro["claseProceso"]=35;
				$tipoCarpetaAdministrativa=60;
			break;
			case 1204://Registro de Costa
				$tipoProceso=23;
				$consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fRegistro["carpetaAdministrativa"]."'";
				$fRegistro["especialidad"]=2;
				$fRegistro["claseProceso"]=35;
				$tipoCarpetaAdministrativa=61;
				$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fRegistro["carpetaAdministrativa"]."'";
				$iActividadBase=$con->obtenerValor($consulta);
				
				$consulta="UPDATE _1204_tablaDinamica SET idActividad=".$iActividadBase." WHERE id__1204_tablaDinamica=".$idRegistro;
				$con->ejecutarConsulta($consulta);
				
			break;			
			case 1004://Acción Pública de Inconstitucionalidad
				$consulta="SELECT responsable FROM _1004_tablaDinamica WHERE id__1004_tablaDinamica=".$idRegistro;
				$idUsuarioRegistrante=$con->obtenerValor($consulta);
				$consulta="SELECT id__992_tablaDinamica FROM _992_tablaDinamica WHERE tipoSala=3 AND corporacion='100000010003'";
				$esSalaVirtual=true;
				
			break;
			case 1009://Registro de exequátur
				$consulta="SELECT id__992_tablaDinamica FROM _992_tablaDinamica WHERE tipoSala=3 AND corporacion='100000010002'  AND id__992_tablaDinamica<24";
				$esSalaVirtual=true;
			break;
			case 1010://Registro de medio de control de nulidad de asuntos de propiedad industrial / tributarios
			
				switch($fRegistro["tipoSubProceso"])
				{
					case 1: //Medio de Control Y Nulidad de Asuntos de Propiedad Industrial
						$consulta="SELECT id__992_tablaDinamica FROM _992_tablaDinamica WHERE tipoSala=3 AND corporacion='10000002' AND id__992_tablaDinamica>=14";
						$esSalaVirtual=true;
					break;
					case 2: //Medio de Control Y Nulidad de Asuntos Tributarios
						$consulta="SELECT id__992_tablaDinamica FROM _992_tablaDinamica WHERE tipoSala=3 AND corporacion='100000010004' AND id__992_tablaDinamica<>27";
						$esSalaVirtual=true;
						
					break;
				}
			
				//$consulta="SELECT claveUnidad FROM _17_tablaDinamica WHERE categoriaDespacho=6 and idEstado=2 and especialidad=".$fRegistro["especialidad"]." ORDER BY nombreUnidad";
			break;
			case 1013://Calificación de la Suspensión del Trabajo / Cese o paro colectivo del trabajo o actividades / Legalidad o ilegalidad de una suspensión o paro colectivo del trabajo
			case 1116://Recurso de revisión
				
				
				if($idFormulario==1116)
				{
					$consulta="SELECT procesoJudicial FROM _1116_tablaDinamica WHERE id__1116_tablaDinamica=".$idRegistro;
					$carpetaAdministrativaBase=$con->obtenerValor($consulta);
				}
				$consulta="SELECT id__992_tablaDinamica FROM _992_tablaDinamica WHERE tipoSala=3 AND corporacion='10000002' and id__992_tablaDinamica in(11,12,13)";
				$esSalaVirtual=true;
				
			break;
			case 1021:///Registro de nulidad laudo arbitral
				$consulta="SELECT id__992_tablaDinamica FROM _992_tablaDinamica WHERE tipoSala=3 AND corporacion='100000010002' and id__992_tablaDinamica in(24,25,26)";
				$esSalaVirtual=true;
			break;
		}
		$cveDespacho="";
		$idSalaVirtual="";
		$consulta="SELECT * FROM 7006_repartoManual WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
		$fReparto=$con->obtenerPrimeraFilaAsoc($consulta);
		if(!$fReparto)
		{

			$universoDespachos=$con->obtenerListaValores($consulta);
			$arrConfiguracion["tipoAsignacion"]="";
			$arrConfiguracion["serieRonda"]="GrupoReparto_".$idFormulario.$compReparto;
			$arrConfiguracion["universoAsignacion"]=$universoDespachos;
			$arrConfiguracion["idObjetoReferencia"]=-1;
			$arrConfiguracion["pagarDeudasAsignacion"]=false;
			$arrConfiguracion["considerarDeudasMismaRonda"]=false;
			$arrConfiguracion["limitePagoRonda"]=0;
			$arrConfiguracion["escribirAsignacion"]=true;
			$arrConfiguracion["idFormulario"]=$idFormulario;
			$arrConfiguracion["idRegistro"]=$idRegistro;
			
			$resultado= obtenerSiguienteAsignacionObjeto($arrConfiguracion,true);
			$idSalaVirtual=$resultado["idUnidad"];
			$cveDespacho=$idSalaVirtual;
			if($esSalaVirtual)
			{
				$consulta="SELECT despachoAsigando FROM _993_tablaDinamica WHERE idReferencia=".$cveDespacho." AND presideSala=1";
				$cveDespacho=$con->obtenerValor($consulta);
			}
		}
		else
		{
			$cveDespacho=$fReparto["despachoAsignado"];
			
			
			if($idFormulario==1013)
			{
				$consulta="SELECT idReferencia FROM _993_tablaDinamica WHERE despachoAsigando='".$cveDespacho."' AND presideSala=1";
				$idSalaVirtual=$con->obtenerValor($consulta);
				if($idSalaVirtual=="")
					$idSalaVirtual=-1;
			}
			
		}
		
		
		$consulta="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$cveDespacho."'";
		$idUnidadGestion=$con->obtenerValor($consulta);
		if($idUnidadGestion=="")
			$idUnidadGestion=-1;
			
		$anio=date("Y");
		
		if($tipoProceso==0)
		{
			if($con->existeCampo("tipoProceso","_".$idFormulario."_tablaDinamica"))
			{
			
				$consulta="SELECT carpetaAdministrativa,idActividad,tipoProceso FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
				
			}
			else
			{
				$query="SELECT idReferencia FROM _626_tablaDinamica WHERE id__626_tablaDinamica=".$fRegistro["claseProceso"];
				$tipoProceso=$con->obtenerValor($query);
				$consulta="SELECT carpetaAdministrativa,idActividad,'".$tipoProceso."' as tipoProceso FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
			}
		}
		else
		{
			$consulta="SELECT ".($campoCarpetaAdministrativa==""?"carpetaAdministrativa":$campoCarpetaAdministrativa).",".($iActividadCarpetaBase==-1?"idActividad":"'".$iActividadCarpetaBase."' as idActividad").",'".$tipoProceso."' as tipoProceso FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		}

		$fDatosCarpeta=$con->obtenerPrimeraFila($consulta);
	

		if(($fDatosCarpeta[0]!="")&&($fDatosCarpeta[0]!="N/E")&&($idFormulario!=1204))
			return true;
		
		$carpetaAdministrativa="";
		$crearActividad=false;
		switch($idFormulario)
		{
			case 1162:
			case 1163:
			case 1204:
				$carpetaAdministrativa=$fRegistro["codigo"];
			
			break;
			case 944:
				$arrCodigoUnico=obtenerSiguienteCodigoUnicoProceso2daInstanciaIncrementaDigitos($cveDespacho,$anio,2,$idFormulario,$idRegistro);	
				$carpetaAdministrativa=$arrCodigoUnico[0];
				$crearActividad=true;
			break;
			case 952:
			
				if($fRegistro["motivoReasignacion"]==1)
				{
					$arrCodigoUnico=obtenerSiguienteCodigoUnicoProcesoIncremental($cveDespacho,$anio,20,$idFormulario,$idRegistro);	
					$carpetaAdministrativa=$arrCodigoUnico[0];
				}
				
				if($fRegistro["motivoReasignacion"]==2)
				{
					$arrCodigoUnico=obtenerSiguienteCodigoUnicoProceso2daInstanciaIncrementaDigitos($cveDespacho,$anio,2,$idFormulario,$idRegistro);	
					$carpetaAdministrativa=$arrCodigoUnico[0];
				}
			
			break;
			case 677:
				$arrCodigoUnico=obtenerSiguienteCodigoUnicoProcesoIncremental($cveDespacho,$anio,20,$idFormulario,$idRegistro);	
				$carpetaAdministrativa=$arrCodigoUnico[0];
				$crearActividad=true;
			break;
			default:
				
				
				
				if(!$fReparto)
				{
					$arrCodigoUnico=obtenerSiguienteCodigoUnicoProceso($cveDespacho,$anio,$fDatosCarpeta[2],$idFormulario,$idRegistro);	
					$carpetaAdministrativa=$arrCodigoUnico[0];
				}
				else
				{
					$carpetaAdministrativa=$fReparto["cup"];
				}
				
			break;
			
			
		}
		
		$fechaCarpetaJudicial=date("Y-m-d H:i:s");
		$idActividad=$fDatosCarpeta[1];
		
		
		$idTRD="NULL";
		$version="NULL";
		$serie="NULL";
		$subserie="NULL";
		$idPerfilAcceso="-1";
		
		$query="SELECT perfilAccesoDefault FROM _1250_tablaDinamica WHERE id__1250_tablaDinamica=".$fDatosCarpeta[2];
		$idPerfilAcceso=$con->obtenerValor($query);
		
		$arrDatos=obtenerTRDExpediente($cveDespacho,$fechaCarpetaJudicial,$fDatosCarpeta[2]);
		if(isset($arrDatos["idSerie"]) &&($arrDatos["idSerie"]!=""))
		{
			$idTRD=$arrDatos["idTablaRetencion"];
			$version=$arrDatos["version"];
			$serie=$arrDatos["idSerie"];
			$subserie=$arrDatos["idSubserie"];
			
		}
		
		$analizarFiguraJuridica=false;

		$consulta=array();
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		if($crearActividad)
		{
			$idActividad=generarIDActividad($idFormulario,$idRegistro);
			$arrRelacionBase=array();
			
			
			$idParticipante="";
			$arrPromoventes=array();
			switch($idFormulario)
			{
				case 944:
					$analizarFiguraJuridica=true;
					$idParticipante=$fRegistro["promovente"];
					$query="SELECT idFiguraJuridica FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$iActividadCarpetaBase.
							" AND idParticipante=".$idParticipante;	
					$fPromovente=$con->obtenerValor($query);
					
					
					
				break;
				case 677:
					$analizarFiguraJuridica=true;
					$idParticipante=$fRegistro["responsable"];
					$query="SELECT idFiguraJuridica,idParticipante FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$iActividadCarpetaBase.
							" AND idCuentaAcceso=".$idParticipante;
					$fRegistroParticipante=$con->obtenerPrimeraFilaAsoc($query);
					
					$fPromovente=$fRegistroParticipante["idFiguraJuridica"];
					$idParticipante=$fRegistroParticipante["idParticipante"];
				break;
			}
			
			
			if($analizarFiguraJuridica)
			{
				
				if(($fPromovente==5)||($fPromovente==6))
				{
					$query="SELECT idActorRelacionado FROM 7005_relacionParticipantes WHERE idActividad=".$iActividadCarpetaBase." AND idParticipante=".$idParticipante;
					$rRelaciones=$con->obtenerFilas($query);
					while($fRelacion=$con->fetchAssoc($rRelaciones))
					{
						$arrPromoventes[$fRelacion["idActorRelacionado"]]=1;
					}
				}
				else
				{
					
					
					if(($idParticipante==0)&&($idFormulario==944))
					{
						$query="SELECT r.idParticipante as apelante FROM _782_gridApelantes gA,7005_relacionFigurasJuridicasSolicitud r WHERE idReferencia IN(
											SELECT id__782_tablaDinamica FROM _782_tablaDinamica WHERE idReferencia IN(
											SELECT idRegistroContenidoReferencia FROM 7007_contenidosCarpetaAdministrativa WHERE carpetaAdministrativa='".$carpetaAdministrativaBase."' AND tipoContenido=3)
											) AND naturaleza=2 and r.idRelacion=gA.apelante";

						$rApelantes=$con->obtenerFilas($query);
						if($con->filasAfectadas==0)
						{
							$query="SELECT r.idParticipante as apelante FROM _782_gridApelantes gA,7005_relacionFigurasJuridicasSolicitud r WHERE idReferencia IN(
											SELECT id__782_tablaDinamica FROM _782_tablaDinamica WHERE idReferencia IN(
											SELECT idRegistroContenidoReferencia FROM 7007_contenidosCarpetaAdministrativa WHERE carpetaAdministrativa='".$carpetaAdministrativaBase."' AND tipoContenido=3)
											) and r.idRelacion=gA.apelante";
							$rApelantes=$con->obtenerFilas($query);
							
						}
						
						if($con->filasAfectadas==0)
						{
							$arrPromoventes[$idParticipante]=1;
						}
						else
						{
							while($fApelante=$con->fetchAssoc($rApelantes))
							{
								$arrPromoventes[$fApelante["apelante"]]=1;
							}
						}
						
						
					}
					else
					{
						$arrPromoventes[$idParticipante]=1;
					}
					
				}
			}
			
			
			$query="SELECT r.* FROM 7005_relacionFigurasJuridicasSolicitud r,_5_tablaDinamica f WHERE r.idActividad=".$iActividadCarpetaBase.
					" AND r.idFiguraJuridica=f.id__5_tablaDinamica AND 	f.naturalezaFigura IN('A','D','N')";

			$rFiguras=$con->obtenerFilas($query);

			while($fFigura=$con->fetchAssoc($rFiguras))
			{
				
				if(($analizarFiguraJuridica)&&($fFigura["idFiguraJuridica"]!=5)&&($fFigura["idFiguraJuridica"]!=6))
				{
					if(isset($arrPromoventes[$fFigura["idParticipante"]]))
						$fFigura["idFiguraJuridica"]=$idFiguraDemandante;
					else
						$fFigura["idFiguraJuridica"]=$idFiguraDemandado;
				}
				
				
				
				$consulta[$x]="INSERT INTO 7005_relacionFigurasJuridicasSolicitud(idActividad,idParticipante,idFiguraJuridica,situacion,idCuentaAcceso,etapaProcesal,
								situacionProcesal,detalleSituacion,cuentaAccesoGenerica) values(".$idActividad.",".$fFigura["idParticipante"].",".
								$fFigura["idFiguraJuridica"].",".$fFigura["situacion"].",".($fFigura["idCuentaAcceso"]==""?"NULL":$fFigura["idCuentaAcceso"]).",".
								$fFigura["etapaProcesal"].",".$fFigura["situacionProcesal"].",".($fFigura["detalleSituacion"]==""?"NULL":$fFigura["detalleSituacion"]).
								",".$fFigura["cuentaAccesoGenerica"].")";
				$x++;
				
				$consulta[$x]="set @idPersonaJuridica_".$fFigura["idParticipante"].":=(select last_insert_id())";
				$x++;
				
				$query="SELECT * FROM 7005_relacionParticipantes WHERE idActividad=".$iActividadCarpetaBase." AND idParticipante=".$fFigura["idParticipante"];

				$rRelacion=$con->obtenerFilas($query);
				while($fRelacion=$con->fetchAssoc($rRelacion))
				{
					
					$consulta[$x]="INSERT INTO 7005_relacionParticipantes(idActividad,idParticipante,idFiguraJuridica,idActorRelacionado,situacion) values
									(".$idActividad.",@idPersonaJuridica_".$fFigura["idParticipante"].",".$fRelacion["idFiguraJuridica"].
									",@idPersonaJuridica_".$fRelacion["idActorRelacionado"].",".$fRelacion["situacion"].")";
					$x++;
					
				}
			}
		}
		
		
		$consulta[$x]="INSERT INTO 7006_carpetasAdministrativas(carpetaAdministrativa,fechaCreacion,responsableCreacion,idFormulario,
						idRegistro,unidadGestion,etapaProcesalActual,idActividad,carpetaAdministrativaBase,
						tipoCarpetaAdministrativa,unidadGestionOriginal,especialidad,tipoProceso,claseProceso,subclaseProceso,tema,subtema,
						idTRD,VERSION,serie,subserie,idPerfilAcceso) 
						VALUES('".$carpetaAdministrativa."','".$fechaCarpetaJudicial."',".$_SESSION["idUsr"].",".$idFormulario.",'".$idRegistro."','".
						$cveDespacho."',".$etapaProcesal.",".$idActividad.",'".$carpetaAdministrativaBase."',".$tipoCarpetaAdministrativa.",'".$cveDespacho."',".$fRegistro["especialidad"].",".
						$fDatosCarpeta[2].",".($fRegistro["claseProceso"]==""?"NULL":$fRegistro["claseProceso"]).",NULL,NULL,NULL,".($idTRD==""?"NULL":$idTRD).",".($version==""?"NULL":$version).
						",".($serie==""?"NULL":$serie).",".($subserie==""?"NULL":$subserie).",".$idPerfilAcceso.")";
		
		
		$x++;
		
		$consulta[$x]="set @idCarpeta:=(select last_insert_id())";
		$x++;
		
		if($esSalaVirtual)
		{
			$orden=1;
			$query="SELECT despachoAsigando FROM _993_tablaDinamica WHERE idReferencia=".$idSalaVirtual." AND presideSala=0";
			$resSalas=$con->obtenerFilas($query);
			while($filaSala=$con->fetchAssoc($resSalas))
			{
				$consulta[$x]="INSERT INTO 7006_carpetasAdministrativasDespachosColegiados(carpetaAdministrativa,despachoAsignado,orden) 
							VALUES('".$carpetaAdministrativa."','".$filaSala["despachoAsigando"]."',".$orden.")";
				$x++;
				$orden++;
			}
		}

		if($idFormulario!=1204)
		{
			$consulta[$x]="update _".$idFormulario."_tablaDinamica set ".$campoCarpetaAdministrativa."='".$carpetaAdministrativa.
						"',codigoInstitucion='".$cveDespacho."',despachoAsignado='".$cveDespacho.
						"' where id__".$idFormulario."_tablaDinamica=".$idRegistro;
			$x++;
		}
		if(!existeRol("'31_0'"))
		{
			if(isset($fRegistro["fechadeRecepcion"]))
			{
				$consulta[$x]="UPDATE _".$idFormulario."_tablaDinamica SET fechadeRecepcion='".date("Y-m-d")."',horaRecepcion='".date("H:i:s").
							"' WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
				$x++;
			}
			
			$query="SELECT idCuentaAcceso,idFiguraJuridica FROM 7005_relacionFigurasJuridicasSolicitud r,_5_tablaDinamica f 
						WHERE idActividad=".$idActividad." AND f.id__5_tablaDinamica=r.idFiguraJuridica AND f.naturalezaFigura IN('A','D','N')";

			$resAccesos=$con->obtenerFilas($query);
			
			
			$anioExpediente=date("Y",strtotime($fechaCarpetaJudicial));
			while($filaAcceso=$con->fetchAssoc($resAccesos))
			{
				if($filaAcceso["idCuentaAcceso"]!="")
				{
					$consulta[$x]="INSERT INTO 7006_usuariosVSCarpetasAdministrativas(idUsuario,idCarpetaAdministrativa,carpetaAdministrativa,
							cveMateria,situacion,fechaInicio,unidadGestion,anioExpediente,idUsuarioExpediente) values
							(".$filaAcceso["idCuentaAcceso"].",@idCarpeta,'".$carpetaAdministrativa."',".
							$fRegistro["especialidad"].",1,'".$fechaCarpetaJudicial."','".$cveDespacho."',".$anioExpediente.
							",-1)";
					$x++;
				}
			}
		}
		
		if($idFormulario==1004)
		{
			$consulta[$x]="UPDATE 04000_demandasProgramaTrabajo SET despachoAsignado='".$idSalaVirtual."',carpetaAdministrativa='".$carpetaAdministrativa."' WHERE iFormulario=".$idFormulario." AND iRegistro=".$idRegistro;
			$x++;
		}
		
		if($asignacionAntecedente)
		{
			$consulta[$x]="update _".$idFormulario."_tablaDinamica set asignadoAntecedente=1 where id__".$idFormulario."_tablaDinamica=".$idRegistro;
			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;
		
		
		if($con->ejecutarBloque($consulta))
		{
			if($idActividad!=-1)
			{
				
				if(($idFormulario!=944)&&($idFormulario!=677))
				{
				
					$query="SELECT * FROM 9503_documentosRegistradosProceso WHERE idActividad=".$idActividad." and idDocumento IS NOT NULL";
					$rDocumentos=$con->obtenerFilas($query);
					while($fDocumento=$con->fetchAssoc($rDocumentos))
					{
						registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$fDocumento["idDocumento"],$idFormulario,$idRegistro);
					}
				}
				else
				{
				
				
					$query="SELECT idDocumento FROM 9074_documentosRegistrosProceso WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro;
					$rDocumentos=$con->obtenerFilas($query);
					while($fDocumento=$con->fetchRow($rDocumentos))
					{
						registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$fDocumento[0],$idFormulario,$idRegistro);	
					}
					
					$query="select idDocumento from 9503_documentosRegistradosProceso WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro." and idDocumento is not null";
					$rDocumentos=$con->obtenerFilas($query);
					while($fDocumento=$con->fetchRow($rDocumentos))
					{
						registrarDocumentoCarpetaAdministrativa($carpetaAdministrativa,$fDocumento[0],$idFormulario,$idRegistro);	
					}
				}
				
			}
			
			return true;
	
		}
		return false;
		
		
	}
	
	function obtenerSiguienteCodigoUnicoProcesoIncremental($idUnidadGestion,$anio,$tipoCarpeta,$idFormulario,$idRegistro)
	{
		global $con;
		$tratarComoRadicacion=true;
		
		
		$consulta="SELECT carpetaAdministrativa FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$fDatosRadicacion=$con->obtenerPrimeraFilaAsoc($consulta);

		
		$procesoJudicialOrigen=substr($fDatosRadicacion["carpetaAdministrativa"],0,strlen($fDatosRadicacion["carpetaAdministrativa"])-2);
		$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa LIKE 
					'".$procesoJudicialOrigen."%' ORDER BY carpetaAdministrativa DESC";

		$ultimoProceso=$con->obtenerValor($consulta);
		$maxValor=substr($ultimoProceso,strlen($fDatosRadicacion["carpetaAdministrativa"])-2,2);
		
		$folioCorreccion=($maxValor*1)+1;
		
		$folioCorreccion=$folioCorreccion-5;
		if($folioCorreccion<1)
			$folioCorreccion=1;
		
		$carpetaAdministrativa=$procesoJudicialOrigen.str_pad($folioCorreccion,2,"0",STR_PAD_LEFT);
		
		while(existeCarpetaAdministrativa($carpetaAdministrativa,""))
		{
			$carpetaAdministrativa=$procesoJudicialOrigen.str_pad($folioCorreccion,2,"0",STR_PAD_LEFT);
			$folioCorreccion++;	
			
		}
		
		$folioActual=$folioCorreccion;
				
		$arrResultado[0]=$carpetaAdministrativa;
		$arrResultado[1]=$folioActual;
		return $arrResultado;
		
		
		
		
	}
	
	function generarRepartoProceso($idFormulario,$idRegistro)
	{
		global $con;
		
		
		$generarCarpetaJudicial=true;
		
		$arrDatosCarpeta=array();
		$universoReparto="";
		$objParametros["asignacionColegiada"]=false;
		$objParametros["aplicableA"]="-1";
		$objParametros["jurisdiccion"]="-1";
		$objParametros["especialidad"]="-1";
		$objParametros["tipoProceso"]="-1";
		$objParametros["temaProceso"]="-1";
		$objParametros["subTemaProceso"]="-1";
		$objParametros["cuantiaProceso"]="0";
		$objParametros["municipioRadicacion"]="";
		$objParametros["unidadesExcluye"]="";
		
		$consulta="SELECT * FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		//Datos Carpeta///
		$idActividad=isset($fRegistro["idActividad"])?$fRegistro["idActividad"]:-1;
		$arrDatosCarpeta["carpetaAdministrativa"]=$idActividad;
		$arrDatosCarpeta["carpetaAdministrativaBase"]="";
		$arrDatosCarpeta["etapaProcesal"]="NULL";
		$arrDatosCarpeta["tipoCarpetaAdministrativa"]="NULL";
		
		////----///
		
		$campoCarpetaAdministrativa="carpetaAdministrativa";
		$idUsuarioRegistrante=isset($_SESSION["idUsr"])?$_SESSION["idUsr"]:2;
		$asignacionAntecedente=false;
		$compReparto="";
		$iActividadCarpetaBase=-1;
		$universoAuxiliar="";
		$carpetaAdministrativaBase="";

		$idFiguraDemandante=2;
		$idFiguraDemandado=4;
		$analizarFiguraJuridica=false;
		$tipoSalaColegida=-1;
		$crearActividad=false;
		$modificarCampoInstitucion=true;
		$ignorarReparto=false;
		
		$fGrupoReparto=NULL;
		$fReparto=NULL;
		$metodoAsignacion=1;
		/////

		
		///Fase inicial				
		switch($idFormulario)
		{
			case 952://Impedimento
				$metodoAsignacion=2;
				$compReparto="_ImpedimentoReasignacion_".$idFormulario."_".$idRegistro;
				$modificarCampoInstitucion=false;
				$crearActividad=true;
				$campoCarpetaAdministrativa="carpetaAdministrativa2aInstancia";
				$query="SELECT carpetaAdministrativa FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
				$carpetaAdministrativaBase=$con->obtenerValor($query);	
				$arrDatosCarpeta["carpetaAdministrativaBase"]=$carpetaAdministrativaBase;
				$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativaBase."' ORDER BY idCarpeta DESC";
				$fDatosCarpeta=$con->obtenerPrimeraFilaAsoc($consulta);
				$iActividadCarpetaBase=$fDatosCarpeta["idActividad"];
			
				$arrDatosCarpeta["etapaProcesal"]=$fDatosCarpeta["etapaProcesalActual"];
				$arrDatosCarpeta["tipoCarpetaAdministrativa"]=$fDatosCarpeta["tipoCarpetaAdministrativa"];
			
				$consulta="SELECT idFormulario,idRegistro,AES_DECRYPT(UNHEX(idObjetoReferido), 'grup0latis17') AS idObjetoReferido,
							AES_DECRYPT(UNHEX(idUnidadReferida), 'grup0latis17') AS idUnidadReferida,
							fechaAsignacion,AES_DECRYPT(UNHEX(tipoRonda), 'grup0latis17') AS tipoRonda,
							AES_DECRYPT(UNHEX(noRonda), 'grup0latis17') AS noRonda,situacion,AES_DECRYPT(UNHEX(rondaPagada), 'grup0latis17') AS rondaPagada,
							AES_DECRYPT(UNHEX(comentariosAdicionales), 'grup0latis17') AS comentariosAdicionales,
							AES_DECRYPT(UNHEX(tipoAsignacion), 'grup0latis17') AS tipoAsignacion,
							AES_DECRYPT(UNHEX(idAsignacionPagada), 'grup0latis17') AS idAsignacionPagada,
							AES_DECRYPT(UNHEX(objParametros), 'grup0latis17') AS objParametros,idAsignacion 
							FROM 7001_asignacionesObjetos WHERE idFormulario=".$fDatosCarpeta["idFormulario"].
							" AND idRegistro=".$fDatosCarpeta["idRegistro"]." and situacion=1 order by idAsignacion desc";
			
			
				$fRegistroAsignacion=$con->obtenerPrimeraFilaAsoc($consulta);
				
				$objConfOriginal=unserialize($fRegistroAsignacion["objParametros"]);
				
				$arrGrupoReparto=explode("_",$objConfOriginal["serieRonda"]);
				$consulta="SELECT * FROM _642_tablaDinamica WHERE id__642_tablaDinamica=".$arrGrupoReparto[1];
				$fGrupoReparto=$con->obtenerPrimeraFilaAsoc($consulta);
				
				
				
				
				if(isset($objConfOriginal["objParametrosBase"]))
				{
					$objParametros=$objConfOriginal["objParametrosBase"];
					if(isset($objParametros["unidadesExcluye"])  &&($objParametros["unidadesExcluye"]!="") )
						$objParametros["unidadesExcluye"].=",".$fRegistroAsignacion["idUnidadReferida"];
					else
						$objParametros["unidadesExcluye"]=$fRegistroAsignacion["idUnidadReferida"];
				}
				else
				{
					
					$objParametros["asignacionColegiada"]=$fDatosCarpeta["tipoCarpetaAdministrativa"]==1?false:true;
					$objParametros["especialidad"]=$fDatosCarpeta["especialidad"];
					$objParametros["tipoProceso"]=$fDatosCarpeta["tipoProceso"];
					$objParametros["tema"]=$fDatosCarpeta["tema"];
					$objParametros["subtema"]=$fDatosCarpeta["subtema"];
					$objParametros["municipioRadicacion"]=obtenerLugarRadicacionCarpetaJudicial($carpetaAdministrativaBase);
					$objParametros["cuantiaProceso"]=obtenerCuantiaCarpetaJudicial($carpetaAdministrativaBase);
					$objParametros["tipoSalaColegida"]=26;
					$objParametros["unidadesExcluye"]=$fRegistroAsignacion["idUnidadReferida"];
					
					$arrUnidadesHistorial=explode(",",$objConfOriginal["universoAsignacion"]);
					foreach($arrUnidadesHistorial as $h)
					{
						if($h!=$fRegistroAsignacion["idUnidadReferida"])
						{
							if($universoReparto=="")
							{
								$universoReparto=$h;
							}
							else
							{
								$universoReparto.=",".$h;
							}
						}
					}
					
				
					
					
					
				}
				$arrDatosCarpeta["carpetaAdministrativaBase"]=$carpetaAdministrativaBase;
			
				$objParametrosGlobal=array();
				$objParametrosGlobal["iFormulario"]=$idFormulario;
				$objParametrosGlobal["iRegistro"]=$idRegistro;
				
				foreach($objParametros as $parametro=>$valor)
				{
					$objParametrosGlobal[$parametro]=$valor;
				}
				
				foreach($arrDatosCarpeta as $parametro=>$valor)
				{
					$objParametrosGlobal[$parametro]=$valor;
				}
				

				
				$fGrupoReparto=obtenerGrupoReparto($objParametrosGlobal);
				
				
				$arrResultado=obtenerDespachosAsociadosGrupoReparto($fGrupoReparto["id__642_tablaDinamica"],$objParametros["municipioRadicacion"],"");
				$arrUniversoDespachos=array();
				switch($objParametrosGlobal["aplicableA"])
				{
					case 1:
					
						foreach($arrResultado as $despacho=>$resto)
						{
							
							
							$arrUniversoDespachos[$resto["unidad"]]=$resto["codigoUnidad"];
						}
					
					
						/*foreach($arrResultado as $despacho=>$resto)
						{
							$arrUniversoDespachos[$resto["unidad"]]=$despacho;
						}*/
					
					break;
					case 2:
					case 3:
						foreach($arrResultado as $despacho=>$resto)
						{
							
							$consulta="SELECT u.idUsuario,Paterno,Materno,Nom FROM 
									802_identifica i,801_adscripcion a,807_usuariosVSRoles ur,800_usuarios u 
									WHERE a.Institucion='".$resto["codigoUnidad"]."' AND a.idUsuario=u.idUsuario  AND
									i.idUsuario=u.idUsuario AND ur.idUsuario=i.idUsuario AND ur.idRol IN(56,96) 
									AND u.idUsuario=a.idUsuario AND u.cuentaActiva=1";

							$fTitular=$con->obtenerPrimeraFilaAsoc($consulta);
							$nombreMagistrado=trim(trim($fTitular["Paterno"])." ".trim($fTitular["Materno"])." ".trim($fTitular["Nom"]));

							$arrUniversoDespachos[$nombreMagistrado]=$resto["codigoUnidad"];
						}
					
					break;
					
				}
				ksort($arrUniversoDespachos);
				$arrUniversoDespachosOrdinal=array();
				foreach($arrUniversoDespachos as $despacho)
				{
					array_push($arrUniversoDespachosOrdinal,$despacho);
				}


				$posActual=0;
				foreach($arrUniversoDespachosOrdinal as $pos=>$despacho)
				{
					if($despacho==$fRegistroAsignacion["idUnidadReferida"])
					{
						$posActual=$pos;
						break;
					}
				}
				/*
				$posActual++;
				if($posActual>=count($arrUniversoDespachosOrdinal))
				{
					$posActual=0;	
				}
				
				$fReparto["despachoAsignado"]=$arrUniversoDespachosOrdinal[$posActual];
				*/
				$universoReparto="";
				
				for($x=$posActual+1;$x<count($arrUniversoDespachosOrdinal);$x++)
				{
					if($universoReparto=="")
						$universoReparto=$arrUniversoDespachosOrdinal[$x];
					else
						$universoReparto.=",".$arrUniversoDespachosOrdinal[$x];
				}
				
				
				for($x=0;$x<$posActual;$x++)
				{
					if($universoReparto=="")
						$universoReparto=$arrUniversoDespachosOrdinal[$x];
					else
						$universoReparto.=",".$arrUniversoDespachosOrdinal[$x];
				}
				
				
				
			break;
			case 698:
			
				$arrDatosCarpeta["etapaProcesal"]=1;
				$arrDatosCarpeta["tipoCarpetaAdministrativa"]=1;
				
				$objParametros["aplicableA"]="1";
				$objParametros["jurisdiccion"]=$fRegistro["jurisdiccion"];
				$objParametros["especialidad"]=$fRegistro["especialidad"];
				$objParametros["tipoProceso"]=$fRegistro["tipoProceso"];
				$objParametros["cuantiaProceso"]=$fRegistro["cuantiaProceso"];
				$objParametros["municipioRadicacion"]=$fRegistro["municipioRadicacion"];
				
				$objParametros["temaProceso"]=$fRegistro["temaProceso"];
				$objParametros["subTemaProceso"]=$fRegistro["subtemaProceso"];
				
				
			break;
			case 717:
			
				$arrDatosCarpeta["etapaProcesal"]=1;
				$arrDatosCarpeta["tipoCarpetaAdministrativa"]=1;
				
				$objParametros["aplicableA"]="1";
				$objParametros["jurisdiccion"]=4;
				$objParametros["especialidad"]=2;
				$objParametros["tipoProceso"]=6;
				$objParametros["cuantiaProceso"]=0;
				$objParametros["municipioRadicacion"]=$fRegistro["ciudadRegistroTutela"];
				
				$objParametros["temaProceso"]=-1;
				$objParametros["subTemaProceso"]=-1;
				
				
			break;
			case 677://Casacion
			
				$arrDatosCarpeta["etapaProcesal"]=3;
				$arrDatosCarpeta["tipoCarpetaAdministrativa"]=20;
			
				$campoCarpetaAdministrativa="carpetaAdministrativa2aInstancia";
				$objParametros["asignacionColegiada"]=true;
				$idFiguraDemandante=20;
				$idFiguraDemandado=21;
				$tipoSalaColegida=26;
				$modificarCampoInstitucion=false;
				
				$query="SELECT carpetaAdministrativa FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
				$carpetaAdministrativaBase=$con->obtenerValor($query);			
				
				$arrDatosCarpeta["carpetaAdministrativaBase"]=$carpetaAdministrativaBase;
					
				$query="SELECT tipoProceso,idActividad,especialidad,claseProceso FROM 7006_carpetasAdministrativas 
							WHERE carpetaAdministrativa='".$carpetaAdministrativaBase."'";
				$fCarpetaBase=$con->obtenerPrimeraFilaAsoc($query);

				$iActividadCarpetaBase=$fCarpetaBase["idActividad"];
				
				$objParametros["aplicableA"]="3";
				$objParametros["jurisdiccion"]="4";
				$objParametros["especialidad"]=$fCarpetaBase["especialidad"];
				$objParametros["tipoProceso"]=14;
				$objParametros["tipoProcesoBase"]=$fCarpetaBase["tipoProceso"];
				$objParametros["tipoSalaColegida"]=$tipoSalaColegida;
				$objParametros["cuantiaProceso"]=obtenerCuantiaCarpetaJudicial($carpetaAdministrativaBase);
				$objParametros["municipioRadicacion"]=obtenerLugarRadicacionCarpetaJudicial($carpetaAdministrativaBase);
				
				
				
			break;
			case 944://apelacion
			case 911: //Tutela Pelacion
				$arrDatosCarpeta["etapaProcesal"]=2;
				$arrDatosCarpeta["tipoCarpetaAdministrativa"]=2;
			
			
				$campoCarpetaAdministrativa="carpetaAdministrativa2daInstancia";
				$objParametros["asignacionColegiada"]=true;
				$idFiguraDemandante=18;
				$idFiguraDemandado=19;
				$tipoSalaColegida=26;
				$objParametros["tipoSalaColegida"]=$tipoSalaColegida;
				$modificarCampoInstitucion=false;
				
				$query="SELECT carpetaAdministrativa FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
				$carpetaAdministrativaBase=$con->obtenerValor($query);			
				
				$arrDatosCarpeta["carpetaAdministrativaBase"]=$carpetaAdministrativaBase;
					
				$query="SELECT tipoProceso,idActividad,especialidad,claseProceso FROM 7006_carpetasAdministrativas 
							WHERE carpetaAdministrativa='".$carpetaAdministrativaBase."'";
				$fCarpetaBase=$con->obtenerPrimeraFilaAsoc($query);

				$iActividadCarpetaBase=$fCarpetaBase["idActividad"];
				
				$objParametros["aplicableA"]="2";
				$objParametros["jurisdiccion"]="4";
				$objParametros["especialidad"]=$fCarpetaBase["especialidad"];
				$objParametros["tipoProceso"]=$fCarpetaBase["tipoProceso"];
				$objParametros["cuantiaProceso"]=obtenerCuantiaCarpetaJudicial($carpetaAdministrativaBase);
				$objParametros["municipioRadicacion"]=obtenerLugarRadicacionCarpetaJudicial($carpetaAdministrativaBase);
				
				
				
			break;
			case 1004:
				$tipoSalaColegida=29;
				$arrDatosCarpeta["etapaProcesal"]=1;
				$arrDatosCarpeta["tipoCarpetaAdministrativa"]=1;
				$objParametros["asignacionColegiada"]=true;
				
				$objParametros["aplicableA"]="3";
				$objParametros["jurisdiccion"]=$fRegistro["jurisdiccion"];
				$objParametros["especialidad"]=$fRegistro["especialidad"];
				$objParametros["tipoProceso"]=8;
				$objParametros["cuantiaProceso"]=0;
				$objParametros["municipioRadicacion"]=$fRegistro["municipio"];
				
				$objParametros["temaProceso"]=-1;
				$objParametros["subTemaProceso"]=-1;
				$objParametros["tipoSalaColegida"]=$tipoSalaColegida;
				$ignorarReparto=true;
				
				
				
				$consulta="SELECT despachoAsignado FROM 04000_demandasProgramaTrabajo WHERE iFormulario=".$idFormulario." AND iRegistro=".$idRegistro;
				$idSalaAsignada=$con->obtenerValor($consulta);
				$consulta="SELECT despachoAsigando FROM _993_tablaDinamica WHERE idReferencia=".$idSalaAsignada." AND presideSala=1";
				$fReparto["despachoAsignado"]=$con->obtenerValor($consulta);
				
				
				
			break;
			case 1009:
				$tipoSalaColegida=30;
				$arrDatosCarpeta["etapaProcesal"]=1;
				$arrDatosCarpeta["tipoCarpetaAdministrativa"]=1;
				$objParametros["asignacionColegiada"]=true;
				
				$objParametros["aplicableA"]="2";
				$objParametros["jurisdiccion"]=4;//$fRegistro["jurisdiccion"];
				$objParametros["especialidad"]=$fRegistro["especialidad"];
				$objParametros["tipoProceso"]=9;
				$objParametros["cuantiaProceso"]=0;
				$objParametros["municipioRadicacion"]=$fRegistro["municipio"];
				
				$objParametros["temaProceso"]=-1;
				$objParametros["subTemaProceso"]=-1;
				$objParametros["tipoSalaColegida"]=$tipoSalaColegida;
			break;
			case 1010:
				$tipoSalaColegida=28;
				$arrDatosCarpeta["etapaProcesal"]=1;
				$arrDatosCarpeta["tipoCarpetaAdministrativa"]=1;
				$objParametros["asignacionColegiada"]=true;
				
				$objParametros["aplicableA"]="3";
				$objParametros["jurisdiccion"]=$fRegistro["jurisdiccion"];
				$objParametros["especialidad"]=$fRegistro["especialidad"];
				$objParametros["tipoProceso"]=$fRegistro["tipoProceso"];
				$objParametros["cuantiaProceso"]=0;
				$objParametros["municipioRadicacion"]=$fRegistro["municipio"];
				
				$objParametros["temaProceso"]=-1;
				$objParametros["subTemaProceso"]=-1;
				$objParametros["tipoSalaColegida"]=$tipoSalaColegida;
			break;
			case 1013:
				$tipoSalaColegida=26;
				$arrDatosCarpeta["etapaProcesal"]=1;
				$arrDatosCarpeta["tipoCarpetaAdministrativa"]=1;
				$objParametros["asignacionColegiada"]=true;
				
				$objParametros["aplicableA"]="2";
				$objParametros["jurisdiccion"]=$fRegistro["jurisdiccion"];
				$objParametros["especialidad"]=$fRegistro["especialidad"];
				$objParametros["tipoProceso"]=13;
				$objParametros["cuantiaProceso"]=0;
				$objParametros["municipioRadicacion"]=$fRegistro["municipios"];
				
				$objParametros["temaProceso"]=-1;
				$objParametros["subTemaProceso"]=-1;
				$objParametros["tipoSalaColegida"]=$tipoSalaColegida;
			break;
			case 1308:
				$generarCarpetaJudicial=true;
				$crearActividad=true;
				$arrDatosCarpeta["etapaProcesal"]=1;
				$arrDatosCarpeta["tipoCarpetaAdministrativa"]=110;
			
			
				$campoCarpetaAdministrativa="carpetaAdministrativa2aInstancia";
				$objParametros["asignacionColegiada"]=false;
				$modificarCampoInstitucion=false;
				
				$query="SELECT carpetaAdministrativa FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
				$carpetaAdministrativaBase=$con->obtenerValor($query);			
				
				
				
				
				$arrDatosCarpeta["carpetaAdministrativaBase"]=$carpetaAdministrativaBase;
					
				$query="SELECT tipoProceso,idActividad,especialidad,claseProceso,unidadGestion,carpetaAdministrativaBase FROM 7006_carpetasAdministrativas 
							WHERE carpetaAdministrativa='".$carpetaAdministrativaBase."'";
				$fCarpetaBase=$con->obtenerPrimeraFilaAsoc($query);
				$carpetaAdministrativaOrigen=$fCarpetaBase["carpetaAdministrativaBase"];
				$iActividadCarpetaBase=$fCarpetaBase["idActividad"];
				
				
				$objParametros["jurisdiccion"]="4";
				$objParametros["especialidad"]=$fCarpetaBase["especialidad"];
				$objParametros["tipoProceso"]=24;
				
				
				$consulta="SELECT * FROM _17_tablaDinamica WHERE claveUnidad='".$fCarpetaBase["unidadGestion"]."'";
				$fUnidadGestion=$con->obtenerPrimeraFilaAsoc($consulta);
				
				
				switch($fUnidadGestion["tipoUnidad"])
				{
					case 9://despacho 1 instancia
						$objParametros["aplicableA"]="1";
						$objParametros["temaProceso"]="53";
						$consulta="SELECT count(*) FROM _17_gridAtributosDespacho WHERE idReferencia=".$fUnidadGestion["id__17_tablaDinamica"]." and 
									idAtributoDespacho=1";
						$totalReg=$con->obtenerValor($consulta);
						if($totalReg>0)
						{
							$objParametros["temaProceso"]=52;
						}
						
					break;
					case 21://tribual superior
						$objParametros["aplicableA"]="2";
						$objParametros["temaProceso"]="54";
					break;
					
				}
				$objParametros["cuantiaProceso"]=obtenerCuantiaCarpetaJudicial($carpetaAdministrativaBase);
				$objParametros["municipioRadicacion"]=obtenerLugarRadicacionCarpetaJudicial($carpetaAdministrativaBase);
				
				
				
				
				$query="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativaOrigen."' ORDER BY idCarpeta DESC";
				$unidadBase=$con->obtenerValor($query);
				
				$query="UPDATE _1308_tablaDinamica SET despachoConflicto='".$unidadBase."' WHERE id__1308_tablaDinamica=".$idRegistro;
				$con->ejecutarConsulta($query);
				
			break;
		}
		
		
		
		

		if($generarCarpetaJudicial  && ($fRegistro[$campoCarpetaAdministrativa]!="N/E")&&($fRegistro[$campoCarpetaAdministrativa]!=""))
		{
			return true;
		}
		
		if((!$generarCarpetaJudicial) && ($fRegistro["despachoAsignado"]!="N/E")&&($fRegistro["despachoAsignado"]!=""))
		{
			return true;
		}
		
		$objParametrosGlobal=array();
		$objParametrosGlobal["iFormulario"]=$idFormulario;
		$objParametrosGlobal["iRegistro"]=$idRegistro;
		
		foreach($objParametros as $parametro=>$valor)
		{
			$objParametrosGlobal[$parametro]=$valor;
		}
		
		foreach($arrDatosCarpeta as $parametro=>$valor)
		{
			$objParametrosGlobal[$parametro]=$valor;
		}
		
		$cadObjParametros="";
		foreach($objParametrosGlobal as $llave=>$valor)
		{
			$atributo='"'.$llave.'":"'.$valor.'"';
			if($cadObjParametros=="")
				$cadObjParametros=$atributo;
			else
				$cadObjParametros.=",".$atributo;
		}
		$cadObjParametros='{'.$cadObjParametros.'}';
		$oObjParametros=json_decode($cadObjParametros);
		///Fase seleccion de grupo de reparto



		if((!$fGrupoReparto)&&(!$fReparto))
		{
			$fGrupoReparto=obtenerGrupoReparto($objParametrosGlobal);
		}
		
		if(!$fReparto)
		{
			$consulta="SELECT * FROM 7006_repartoManual WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
			$fReparto=$con->obtenerPrimeraFilaAsoc($consulta);
		}
		if((!$fGrupoReparto)&&(!$fReparto))
		{
			return false;
		}
		$idGrupoReparto=(!$fGrupoReparto || $fGrupoReparto["id__642_tablaDinamica"]=="")?-1:$fGrupoReparto["id__642_tablaDinamica"];

		$objParametros["tipoProceso"]=isset($objParametros["tipoProcesoBase"])?$objParametros["tipoProcesoBase"]:$objParametros["tipoProceso"];
		/////
		

		$consulta="SELECT * FROM _1288_tablaDinamica WHERE idReferencia=".$idGrupoReparto;
		$fAdicionales=$con->obtenerPrimeraFilaAsoc($consulta);
		$considerarAntecedente=!isset($fAdicionales["considerarAntecedente"])?false:($fAdicionales["considerarAntecedente"]==1);
		if($considerarAntecedente && ($universoReparto==""))
		{
			$universoAuxiliar=obtenerDespachoAntecedente($oObjParametros);
		}
		
		
		
		/////Reparto

		if(!$fReparto)
		{
			
			$universoDespachos="";
			if($universoReparto=="")
			{
				if($universoAuxiliar=="")
				{
					$arrResultado=obtenerDespachosAsociadosGrupoReparto($idGrupoReparto,$objParametros["municipioRadicacion"],$objParametros["unidadesExcluye"]);
						
					foreach($arrResultado as $juzgado)
					{
						if($universoDespachos=="")
							$universoDespachos=$juzgado["codigoUnidad"];
						else
							$universoDespachos.=",".$juzgado["codigoUnidad"];
					}
				}
				else
				{
					$universoDespachos=$universoAuxiliar;
					$asignacionAntecedente=true;
					$compReparto="_PorAntecedente";
				}
				
				
				
				
			}
			else
			{
				$universoDespachos=$universoReparto;
			}
			
			

			
			$pagarDeudasAsignacion=false;
			$limitePagoRonda=2;
			$funcValidacionSeleccion="";//"esDespachoDisponibleAsignacion('@idUnidad');";
			$funcValidacionPagoDeuda="";//"esDespachoDisponibleAsignacion('@idUnidad');";
			
						
			if($idGrupoReparto!=-1)
			{
				$consulta="SELECT * FROM _1288_tablaDinamica WHERE idReferencia=".$idGrupoReparto;
				$fComplementario=$con->obtenerPrimeraFilaAsoc($consulta);
				
				if($fComplementario)
				{
					$idFuncionValidacionAD="";//$fComplementario["funcionValidacionAsignacionDespacho"];
					$idFuncionValidacionC="";//$fComplementario["funcionValidacionCompensacion"];
					if(($idFuncionValidacionAD!="")&&($idFuncionValidacionAD!=-1))
					{
						$idFuncionValidacionAD="[".$idFuncionValidacionAD."]";
					}
					
					if(($idFuncionValidacionC!="")&&($idFuncionValidacionC!=-1))
					{
						$idFuncionValidacionC="[".$idFuncionValidacionC."]";
					}
					if($idFuncionValidacionAD==-1)
						$idFuncionValidacionAD="";
					
					if($idFuncionValidacionC==-1)
						$idFuncionValidacionC="";
					
					$pagarDeudasAsignacion=$fComplementario["considerarCompensacion"]==1;
					$limitePagoRonda=$fComplementario["limiteCompensacion"]==""?0:$fComplementario["limiteCompensacion"];
					$funcValidacionSeleccion=$idFuncionValidacionAD;
					$funcValidacionPagoDeuda=$idFuncionValidacionC;
					
				}
				
			}
			
			$arrConfiguracion["tipoAsignacion"]="";
			$arrConfiguracion["serieRonda"]="GrupoReparto_".$idGrupoReparto.$compReparto;
			$arrConfiguracion["universoAsignacion"]=$universoDespachos;
			$arrConfiguracion["idObjetoReferencia"]=-1;
			$arrConfiguracion["pagarDeudasAsignacion"]=$pagarDeudasAsignacion;
			$arrConfiguracion["considerarDeudasMismaRonda"]=false;
			$arrConfiguracion["limitePagoRonda"]=$limitePagoRonda;
			$arrConfiguracion["escribirAsignacion"]=true;
			$arrConfiguracion["idFormulario"]=$idFormulario;
			$arrConfiguracion["idRegistro"]=$idRegistro;
			$arrConfiguracion["metodoAsignacion"]=$metodoAsignacion;//$fGrupoReparto["metodoAsignacion"];//1 Aleatorio;2 Secuencial
			$arrConfiguracion["objParametrosBase"]=$objParametros;		
			$arrConfiguracion["funcValidacionSeleccion"]=$funcValidacionSeleccion;
			$arrConfiguracion["funcValidacionPagoDeuda"]=$funcValidacionPagoDeuda;
			$resultado= obtenerSiguienteAsignacionObjeto($arrConfiguracion,true);
			$cveDespacho=$resultado["idUnidad"];
		}
		else
		{
			$cveDespacho=$fReparto["despachoAsignado"];
		}


		$query="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$cveDespacho."'";
		$idUnidadGestion=$con->obtenerValor($query);
		if($idUnidadGestion=="")
			$idUnidadGestion=-1;
			
		$anio=date("Y");
		$fechaCarpetaJudicial=date("Y-m-d H:i:s");
		$carpetaAdministrativa="";
		
		$arrDatosCarpeta["carpetaAdministrativa"]=$carpetaAdministrativa;
		$arrDatosCarpeta["fechaCarpetaJudicial"]=$fechaCarpetaJudicial;
		$arrDatosCarpeta["idUsr"]=isset($_SESSION["idUsr"])?$_SESSION["idUsr"]:2;
		$arrDatosCarpeta["idFormulario"]=$idFormulario;
		$arrDatosCarpeta["idRegistro"]=$idRegistro;
		$arrDatosCarpeta["cveDespacho"]=$cveDespacho;
		$arrDatosCarpeta["idActividad"]=$idActividad;
		
		$arrDatosCarpeta["especialidad"]=$objParametros["especialidad"];
		$arrDatosCarpeta["tipoProceso"]=$objParametros["tipoProceso"];
		
		$arrDatosCarpeta["tema"]=$objParametros["temaProceso"]=="-1"?"NULL":$objParametros["temaProceso"];
		$arrDatosCarpeta["subtema"]=$objParametros["subTemaProceso"]=="-1"?"NULL":$objParametros["subTemaProceso"];

		///Fase de creacion de numero de expediente
		$idParticipante="";
		$fPromovente=NULL;
		
		$consulta=array();
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		if($generarCarpetaJudicial)
		{
			switch($idFormulario)
			{
				case 952:
					$arrCodigoUnico=obtenerSiguienteCodigoUnicoProceso($cveDespacho,$anio,$objParametros["tipoProceso"],$idFormulario,$idRegistro);	
					$arrDatosCarpeta["carpetaAdministrativa"]=$arrCodigoUnico[0];
					/*$ultimoDigito=substr($arrDatosCarpeta["carpetaAdministrativaBase"],strlen($arrDatosCarpeta["carpetaAdministrativaBase"])-1,1);
					if($ultimoDigito==0)
					{
						$arrCodigoUnico=obtenerSiguienteCodigoUnicoProceso($cveDespacho,$anio,$objParametros["tipoProceso"],$idFormulario,$idRegistro);	
						$arrDatosCarpeta["carpetaAdministrativa"]=$arrCodigoUnico[0];
					}
					else
					{
						$arrCodigoUnico=obtenerSiguienteCodigoUnicoProceso2daInstanciaIncrementaDigitos($cveDespacho,$anio,$objParametros["tipoProceso"],$idFormulario,$idRegistro);	
						$arrDatosCarpeta["carpetaAdministrativa"]=$arrCodigoUnico[0];
					}*/
				break;
				case 717:
				case 698: //Demanda ordinaria
				case 1004:
				case 1009:
				case 1010:
				case 1013:
					if((!$fReparto)|| !isset($fReparto["cup"]) || ($fReparto["cup"]=="") )
					{
						$arrCodigoUnico=obtenerSiguienteCodigoUnicoProceso($cveDespacho,$anio,$objParametros["tipoProceso"],$idFormulario,$idRegistro);	
						$arrDatosCarpeta["carpetaAdministrativa"]=$arrCodigoUnico[0];
					}
					else
					{
						$arrDatosCarpeta["carpetaAdministrativa"]=$fReparto["cup"];
					}
				break;
				case 677: //Apelacion
					
					if(!$fReparto)
					{
						$arrCodigoUnico=obtenerSiguienteCodigoUnicoProceso($cveDespacho,$anio,$objParametros["tipoProceso"],$idFormulario,$idRegistro);	
						$arrDatosCarpeta["carpetaAdministrativa"]=$arrCodigoUnico[0];
					}
					else
					{
						$arrDatosCarpeta["carpetaAdministrativa"]=$fReparto["cup"];
					}
					$crearActividad=true;
					$analizarFiguraJuridica=true;
					$idParticipante=$fRegistro["responsable"];
					
					
					
					$query="SELECT idParticipante FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$iActividadCarpetaBase.
							" AND idCuentaAcceso=".$idParticipante;	
					$idParticipante=$con->obtenerValor($query);
					if($idParticipante=="")
						$idParticipante=-1;
					
					
					$query="SELECT idFiguraJuridica FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$iActividadCarpetaBase.
							" AND idParticipante=".$idParticipante;	
					$fPromovente=$con->obtenerValor($query);
	
					
					
				break;
				case 911:
				case 944: //Apelacion
					
					if(!$fReparto)
					{
						$arrCodigoUnico=obtenerSiguienteCodigoUnicoProceso2daInstanciaIncrementaDigitos($cveDespacho,$anio,2,$idFormulario,$idRegistro);	
						$arrDatosCarpeta["carpetaAdministrativa"]=$arrCodigoUnico[0];
					}
					else
					{
						$arrDatosCarpeta["carpetaAdministrativa"]=$fReparto["cup"];
					}
					$crearActividad=true;
					$analizarFiguraJuridica=true;
					$idParticipante=$fRegistro["promovente"];
					$query="SELECT idFiguraJuridica FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$iActividadCarpetaBase.
							" AND idParticipante=".$idParticipante;	
					$fPromovente=$con->obtenerValor($query);
	
					
					
				break;
				case 1308:
					$arrCodigoUnico=obtenerSiguienteCodigoUnicoProceso2daInstanciaIncrementaDigitos($cveDespacho,$anio,2,$idFormulario,$idRegistro);	
					$arrDatosCarpeta["carpetaAdministrativa"]=$arrCodigoUnico[0];
					$crearActividad=true;
					$analizarFiguraJuridica=false;
					
					
					
				break;
			}

			//Fase de registro de expediente
			
			$query="SELECT id__626_tablaDinamica FROM _626_tablaDinamica WHERE idReferencia=".$objParametros["tipoProceso"];
			$claseProceso=$con->obtenerValor($query);
			if($claseProceso=="")
				$claseProceso=-1;
			$query="SELECT id__627_tablaDinamica FROM _627_tablaDinamica WHERE idReferencia=".$claseProceso;
			$subClaseProceso=$con->obtenerValor($query);
			if($subClaseProceso=="")
				$subClaseProceso="NULL";
			
			$arrDatosCarpeta["claseProceso"]=($claseProceso=="" || $claseProceso=="")?"NULL":$claseProceso;
			$arrDatosCarpeta["subclaseProceso"]=$subClaseProceso;
			
			$arrDatosCarpeta["claseProceso"]=$claseProceso;
			$arrDatosCarpeta["subclaseProceso"]=$subClaseProceso;
			$arrDatosCarpeta["idTRD"]=-1;
			$arrDatosCarpeta["VERSION"]=-1;
			$arrDatosCarpeta["serie"]=-1;
			$arrDatosCarpeta["subserie"]=-1;
			
			
			$query="SELECT perfilAccesoDefault FROM _1250_tablaDinamica WHERE id__1250_tablaDinamica=".$objParametros["tipoProceso"];
			$arrDatosCarpeta["idPerfilAcceso"]=$con->obtenerValor($query);
			if($arrDatosCarpeta["idPerfilAcceso"]=="")
				$arrDatosCarpeta["idPerfilAcceso"]=2; 
			
			$arrDatos=obtenerTRDExpediente($cveDespacho,$fechaCarpetaJudicial,$objParametros["tipoProceso"]);
			if(isset($arrDatos["idSerie"]) &&($arrDatos["idSerie"]!=""))
			{
				$arrDatosCarpeta["idTRD"]=$arrDatos["idTablaRetencion"];
				$arrDatosCarpeta["VERSION"]=$arrDatos["version"];
				$arrDatosCarpeta["serie"]=$arrDatos["idSerie"];
				$arrDatosCarpeta["subserie"]=$arrDatos["idSubserie"];
			}		
			
			
			
			if($crearActividad)
			{
				$idActividad=generarIDActividad($idFormulario,$idRegistro);
				$arrDatosCarpeta["idActividad"]=$idActividad;
				$arrRelacionBase=array();
				
				
				$arrPromoventes=array();
				
				
				if($analizarFiguraJuridica)
				{
					
					if(($fPromovente==5)||($fPromovente==6))
					{
						$query="SELECT idActorRelacionado FROM 7005_relacionParticipantes WHERE idActividad=".$iActividadCarpetaBase." AND idParticipante=".$idParticipante;
						$rRelaciones=$con->obtenerFilas($query);
						while($fRelacion=$con->fetchAssoc($rRelaciones))
						{
							$arrPromoventes[$fRelacion["idActorRelacionado"]]=1;
						}
					}
					else
					{
						
						
						if(($idParticipante==0)&&($idFormulario==944 ))//|| $idFormulario==911
						{
							$query="SELECT r.idParticipante as apelante FROM _782_gridApelantes gA,7005_relacionFigurasJuridicasSolicitud r WHERE idReferencia IN(
												SELECT id__782_tablaDinamica FROM _782_tablaDinamica WHERE idReferencia IN(
												SELECT idRegistroContenidoReferencia FROM 7007_contenidosCarpetaAdministrativa WHERE carpetaAdministrativa='".$carpetaAdministrativaBase."' AND tipoContenido=3)
												) AND naturaleza=2 and r.idRelacion=gA.apelante";
	
							$rApelantes=$con->obtenerFilas($query);
							if($con->filasAfectadas==0)
							{
								$query="SELECT r.idParticipante as apelante FROM _782_gridApelantes gA,7005_relacionFigurasJuridicasSolicitud r WHERE idReferencia IN(
												SELECT id__782_tablaDinamica FROM _782_tablaDinamica WHERE idReferencia IN(
												SELECT idRegistroContenidoReferencia FROM 7007_contenidosCarpetaAdministrativa WHERE carpetaAdministrativa='".$carpetaAdministrativaBase."' AND tipoContenido=3)
												) and r.idRelacion=gA.apelante";
								$rApelantes=$con->obtenerFilas($query);
								
							}
							
							if($con->filasAfectadas==0)
							{
								$arrPromoventes[$idParticipante]=1;
							}
							else
							{
								while($fApelante=$con->fetchAssoc($rApelantes))
								{
									$arrPromoventes[$fApelante["apelante"]]=1;
								}
							}
							
							
						}
						else
						{
							$arrPromoventes[$idParticipante]=1;
						}
						
					}
				}
				
	
				$query="SELECT r.* FROM 7005_relacionFigurasJuridicasSolicitud r,_5_tablaDinamica f WHERE r.idActividad=".$iActividadCarpetaBase.
						" AND r.idFiguraJuridica=f.id__5_tablaDinamica AND 	f.naturalezaFigura IN('A','D','N')";
	
				$rFiguras=$con->obtenerFilas($query);
	
				while($fFigura=$con->fetchAssoc($rFiguras))
				{
					
					if(($analizarFiguraJuridica)&&($fFigura["idFiguraJuridica"]!=5)&&($fFigura["idFiguraJuridica"]!=6))
					{
						if(isset($arrPromoventes[$fFigura["idParticipante"]]))
							$fFigura["idFiguraJuridica"]=$idFiguraDemandante;
						else
							$fFigura["idFiguraJuridica"]=$idFiguraDemandado;
					}
					
					
					
					$consulta[$x]="INSERT INTO 7005_relacionFigurasJuridicasSolicitud(idActividad,idParticipante,idFiguraJuridica,situacion,idCuentaAcceso,etapaProcesal,
									situacionProcesal,detalleSituacion,cuentaAccesoGenerica) values(".$idActividad.",".$fFigura["idParticipante"].",".
									$fFigura["idFiguraJuridica"].",".$fFigura["situacion"].",".($fFigura["idCuentaAcceso"]==""?"NULL":$fFigura["idCuentaAcceso"]).",".
									$fFigura["etapaProcesal"].",".$fFigura["situacionProcesal"].",".($fFigura["detalleSituacion"]==""?"NULL":$fFigura["detalleSituacion"]).
									",".$fFigura["cuentaAccesoGenerica"].")";
					$x++;
					
					$consulta[$x]="set @idPersonaJuridica_".$fFigura["idParticipante"].":=(select last_insert_id())";
					$x++;
					
					$query="SELECT * FROM 7005_relacionParticipantes WHERE idActividad=".$iActividadCarpetaBase." AND idParticipante=".$fFigura["idParticipante"];
	
					$rRelacion=$con->obtenerFilas($query);
					while($fRelacion=$con->fetchAssoc($rRelacion))
					{
						
						$consulta[$x]="INSERT INTO 7005_relacionParticipantes(idActividad,idParticipante,idFiguraJuridica,idActorRelacionado,situacion) values
										(".$idActividad.",@idPersonaJuridica_".$fFigura["idParticipante"].",".$fRelacion["idFiguraJuridica"].
										",@idPersonaJuridica_".$fRelacion["idActorRelacionado"].",".$fRelacion["situacion"].")";
						$x++;
						
					}
				}
			}
			
			$consulta[$x]="INSERT INTO 7006_carpetasAdministrativas(carpetaAdministrativa,fechaCreacion,responsableCreacion,idFormulario,
							idRegistro,unidadGestion,etapaProcesalActual,idActividad,carpetaAdministrativaBase,
							tipoCarpetaAdministrativa,unidadGestionOriginal,especialidad,tipoProceso,claseProceso,subclaseProceso,tema,subtema,
							idTRD,VERSION,serie,subserie,idPerfilAcceso) 
							VALUES('".$arrDatosCarpeta["carpetaAdministrativa"]."','".$arrDatosCarpeta["fechaCarpetaJudicial"]."',".$arrDatosCarpeta["idUsr"].
							",".$arrDatosCarpeta["idFormulario"].",'".$arrDatosCarpeta["idRegistro"]."','".
							$arrDatosCarpeta["cveDespacho"]."',".$arrDatosCarpeta["etapaProcesal"].",".$arrDatosCarpeta["idActividad"].
							",'".$arrDatosCarpeta["carpetaAdministrativaBase"]."',".$arrDatosCarpeta["tipoCarpetaAdministrativa"].",'".
							$arrDatosCarpeta["cveDespacho"]."',".$arrDatosCarpeta["especialidad"].",".$arrDatosCarpeta["tipoProceso"].",".$arrDatosCarpeta["claseProceso"].
							",".$arrDatosCarpeta["subclaseProceso"].",".$arrDatosCarpeta["tema"].",".$arrDatosCarpeta["subtema"].",".$arrDatosCarpeta["idTRD"].
							",".$arrDatosCarpeta["VERSION"].",".$arrDatosCarpeta["serie"].",".$arrDatosCarpeta["subserie"].",".$arrDatosCarpeta["idPerfilAcceso"].")";
			$x++;
			
			$consulta[$x]="set @idCarpeta:=(select last_insert_id())";
			$x++;
	
			if($objParametros["asignacionColegiada"])
			{
				$orden=1;
				$query="SELECT ds.idReferencia FROM _993_tablaDinamica ds,_992_tablaDinamica s WHERE ds.despachoAsigando='".$arrDatosCarpeta["cveDespacho"]."' 
						and ds.idReferencia=s.id__992_tablaDinamica and s.tipoUnidad=".$tipoSalaColegida."  AND presideSala=1";
				$idSalaVirtual=$con->obtenerValor($query);
				if($idSalaVirtual=="")
					$idSalaVirtual=-1;
					
				$query="SELECT despachoAsigando FROM _993_tablaDinamica WHERE idReferencia=".$idSalaVirtual." AND presideSala=0";
				$resSalas=$con->obtenerFilas($query);
				while($filaSala=$con->fetchAssoc($resSalas))
				{
					$consulta[$x]="INSERT INTO 7006_carpetasAdministrativasDespachosColegiados(carpetaAdministrativa,despachoAsignado,orden) 
								VALUES('".$arrDatosCarpeta["carpetaAdministrativa"]."','".$filaSala["despachoAsigando"]."',".$orden.")";
					$x++;
					$orden++;
				}
			}
		
		}
		///Fase final
		
		switch($idFormulario)
		{
			case 952:
			case 677:
			case 944: //apelacion
			case 698: //Demanda ordinaria
			case 717:	
			case 911:
			case 1004:
			case 1009:
			case 1010:
			case 1013:
			case 1308:
			
				if($con->existeCampo($campoCarpetaAdministrativa,"_".$idFormulario."_tablaDinamica"))
				{
					$consulta[$x]="update _".$idFormulario."_tablaDinamica set ".$campoCarpetaAdministrativa."='".$arrDatosCarpeta["carpetaAdministrativa"].
									"' where id__".$idFormulario."_tablaDinamica=".$idRegistro;
					$x++;
				}
				
				if($con->existeCampo("despachoAsignado","_".$idFormulario."_tablaDinamica"))
				{
					$consulta[$x]="update _".$idFormulario."_tablaDinamica set despachoAsignado='".$arrDatosCarpeta["cveDespacho"].
									"' where id__".$idFormulario."_tablaDinamica=".$idRegistro;
					$x++;
				}
			
				
				if($modificarCampoInstitucion)
				{
					$consulta[$x]="update _".$idFormulario."_tablaDinamica set codigoInstitucion='".$arrDatosCarpeta["cveDespacho"].
								"' where id__".$idFormulario."_tablaDinamica=".$idRegistro;
					$x++;
				}
			break;
		}
	
	
		if(!existeRol("'31_0'"))
		{
			if(isset($fRegistro["fechadeRecepcion"]))
			{
				$consulta[$x]="UPDATE _".$idFormulario."_tablaDinamica SET fechadeRecepcion='".date("Y-m-d")."' WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
				$x++;
			}
			
			if(isset($fRegistro["horadeRecepcion"]))
			{
				$consulta[$x]="UPDATE _".$idFormulario."_tablaDinamica SET horadeRecepcion='".date("H:i:s")."' WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
				$x++;
			}
			
			$query="SELECT idCuentaAcceso,idFiguraJuridica FROM 7005_relacionFigurasJuridicasSolicitud r,_5_tablaDinamica f 
				WHERE idActividad=".$idActividad." AND f.id__5_tablaDinamica=r.idFiguraJuridica AND f.naturalezaFigura IN('A','D','N')";

			$resAccesos=$con->obtenerFilas($query);
			
			
			
			$anioExpediente=date("Y",strtotime($fechaCarpetaJudicial));
			while($filaAcceso=$con->fetchAssoc($resAccesos))
			{
				if($filaAcceso["idCuentaAcceso"]!="")
				{
					$consulta[$x]="INSERT INTO 7006_usuariosVSCarpetasAdministrativas(idUsuario,idCarpetaAdministrativa,carpetaAdministrativa,
							cveMateria,situacion,fechaInicio,unidadGestion,anioExpediente,idUsuarioExpediente) values
							(".$_SESSION["idUsr"].",@idCarpeta,'".$arrDatosCarpeta["carpetaAdministrativa"]."',".
							$arrDatosCarpeta["especialidad"].",1,'".$arrDatosCarpeta["fechaCarpetaJudicial"]."','".$arrDatosCarpeta["cveDespacho"]."',".$anioExpediente.
							",-1)";
					$x++;
				}
			}
		}
		
		
		if($asignacionAntecedente)
		{
			if($con->existeCampo("asignadoAntecedente","_".$idFormulario."_tablaDinamica"))
			{
				$consulta[$x]="update _".$idFormulario."_tablaDinamica set asignadoAntecedente=1 where id__".$idFormulario."_tablaDinamica=".$idRegistro;
				$x++;
			}
		}
		
		//////
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
		{
			if($idActividad!=-1)
			{
				if(($idFormulario!=911)&&($idFormulario!=944)&&($idFormulario!=677))
				{
					$query="SELECT * FROM 9503_documentosRegistradosProceso WHERE idActividad=".$idActividad." and idDocumento IS NOT NULL";
					$rDocumentos=$con->obtenerFilas($query);
					while($fDocumento=$con->fetchAssoc($rDocumentos))
					{
		
						registrarDocumentoCarpetaAdministrativa($arrDatosCarpeta["carpetaAdministrativa"],$fDocumento["idDocumento"],$idFormulario,$idRegistro);
					}
				}
				else
				{
					$query="SELECT idDocumento FROM 9074_documentosRegistrosProceso WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro;
					$rDocumentos=$con->obtenerFilas($query);
					while($fDocumento=$con->fetchRow($rDocumentos))
					{
						registrarDocumentoCarpetaAdministrativa($arrDatosCarpeta["carpetaAdministrativa"],$fDocumento[0],$idFormulario,$idRegistro);	
					}
					
					$query="select idDocumento from 9503_documentosRegistradosProceso WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro." and idDocumento is not null";
					$rDocumentos=$con->obtenerFilas($query);
					while($fDocumento=$con->fetchRow($rDocumentos))
					{
						registrarDocumentoCarpetaAdministrativa($arrDatosCarpeta["carpetaAdministrativa"],$fDocumento[0],$idFormulario,$idRegistro);	
					}
				}
			}
			
			return true;
	
		}
		return false;
	}
	
	
	function obtenerCuantiaCarpetaJudicial($carpetaJudicial)
	{
		global $con;
		$arrCampos[0]="cuantiaProceso";
		
		
		
		
		$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaJudicial."'";
		$fCarpeta=$con->obtenerPrimeraFilaAsoc($consulta);
		
		if($fCarpeta["tipoCarpetaAdministrativa"]==1)
		{
			if($fCarpeta["idFormulario"]!=-1)
			{
				$consulta="SELECT * FROM _".$fCarpeta["idFormulario"]."_tablaDinamica WHERE id__".$fCarpeta["idFormulario"]."_tablaDinamica=".$fCarpeta["idRegistro"];
				$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
				foreach($arrCampos as $campo)
				{
					if(isset($fRegistro[$campo]))
						return $fRegistro[$campo]==""?0:$fRegistro[$campo];
				}
				
				if($fCarpeta["carpetaAdministrativaBase"]!="")
				{
					return obtenerCuantiaCarpetaJudicial($fCarpeta["carpetaAdministrativaBase"]);
				}
				
				return 0;
				
			}
		}
		else
		{	
			if($fCarpeta["carpetaAdministrativaBase"]=="")
				return 0;
			else
				return "-1";obtenerCuantiaCarpetaJudicial($fCarpeta["carpetaAdministrativaBase"]);
		}
	}
	
	function obtenerLugarRadicacionCarpetaJudicial($carpetaJudicial)
	{
		global $con;
		$arrCampos[0]="municipioRadicacion";
		$arrCampos[1]="ciudadRegistroTutela";
		$arrCampos[2]="municipio";
		$arrCampos[3]="municipios";
		
		
		
		$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaJudicial."'";
		$fCarpeta=$con->obtenerPrimeraFilaAsoc($consulta);
		if($fCarpeta["tipoCarpetaAdministrativa"]==1)
		{
			if($fCarpeta["idFormulario"]!=-1)
			{
				$consulta="SELECT * FROM _".$fCarpeta["idFormulario"]."_tablaDinamica WHERE id__".$fCarpeta["idFormulario"]."_tablaDinamica=".$fCarpeta["idRegistro"];
				
				$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
				foreach($arrCampos as $campo)
				{
					if(isset($fRegistro[$campo]))
						return $fRegistro[$campo];
				}
				
				if($fCarpeta["carpetaAdministrativaBase"]!="")
				{
					return obtenerLugarRadicacionCarpetaJudicial($fCarpeta["carpetaAdministrativaBase"]);
				}
			
				
				return "";
				
			}
		}
		else
		{	
			if($fCarpeta["carpetaAdministrativaBase"]=="")
				return "";
			else
				return "-1";obtenerCuantiaCarpetaJudicial($fCarpeta["carpetaAdministrativaBase"]);
		}
		
		
	}
	
	function obtenerGrupoReparto($objParametros)
	{
		global $con;
		$consulta="SELECT id__642_tablaDinamica FROM _642_tablaDinamica WHERE aplicableA=".$objParametros["aplicableA"]." and idEstado=20";
		$listaGrupos=$con->obtenerListaValores($consulta);
		
		if($listaGrupos=="")
			$listaGrupos=-1;

		$consulta="SELECT id__643_tablaDinamica FROM _643_tablaDinamica WHERE idReferencia in(".$listaGrupos.") 
						and jurisdiccion=".$objParametros["jurisdiccion"]." AND especialidad=".$objParametros["especialidad"].
						" and tipoProceso=".$objParametros["tipoProceso"]." 
						AND cmbTema=".$objParametros["temaProceso"]." order by id__643_tablaDinamica asc";
						
		
		$listaAmbitos=$con->obtenerListaValores($consulta);
		if($con->filasAfectadas==0)
		{
			$consulta="SELECT id__643_tablaDinamica FROM _643_tablaDinamica WHERE idReferencia in(".$listaGrupos.") 
					and jurisdiccion=".$objParametros["jurisdiccion"]." AND especialidad=".$objParametros["especialidad"].
					" and tipoProceso=".$objParametros["tipoProceso"]."  order by id__643_tablaDinamica asc";
	
			$listaAmbitos=$con->obtenerListaValores($consulta);
			if($con->filasAfectadas==0)
			{

				$consulta="SELECT id__643_tablaDinamica FROM _643_tablaDinamica WHERE idReferencia in(".$listaGrupos.") 
						and jurisdiccion=".$objParametros["jurisdiccion"]." AND especialidad=".$objParametros["especialidad"].
						"  order by id__643_tablaDinamica asc";
				$listaAmbitos=$con->obtenerListaValores($consulta);
				if($con->filasAfectadas==0)
				{

					
					$consulta="SELECT id__643_tablaDinamica FROM _643_tablaDinamica WHERE idReferencia in(".$listaGrupos.") 
						and jurisdiccion=".$objParametros["jurisdiccion"]."  order by id__643_tablaDinamica asc";
					$listaAmbitos=$con->obtenerListaValores($consulta);

					if($con->filasAfectadas==0)
					{
						$consulta="SELECT id__643_tablaDinamica FROM _643_tablaDinamica WHERE idReferencia in(".$listaGrupos.") 
									 order by id__643_tablaDinamica asc";
						$listaAmbitos=$con->obtenerListaValores($consulta);

					}
				}
			}
		}
		
		
		
		if($listaAmbitos=="")
			$listaAmbitos=-1;
		$consulta="SELECT * FROM _643_tablaDinamica WHERE id__643_tablaDinamica IN(".$listaAmbitos.")";

		$rAmbitos=$con->obtenerFilas($consulta);
		$listaAmbitos="";
		while($filaGrupoAux=$con->fetchAssoc($rAmbitos))
		{
			$considerarAmbito=false;
			if(($filaGrupoAux["funcionAplicacion"]=="")||($filaGrupoAux["funcionAplicacion"]=="-1"))
			{	
				$considerarAmbito=true;
			}
			else
			{
				$cache=NULL;
				
				$cadParametros="";
				foreach($objParametros as $campo=>$valor)
				{
					$token='"'.$campo.'":"'.cv($valor).'"';
					if($cadParametros=="")
						$cadParametros=$token;
					else
						$cadParametros.=",".$token;
				}
				$cadParametros='{'.$cadParametros.'}';
				$oParametros=json_decode($cadParametros);
				$resultadoEvaluacion=removerComillasLimite(resolverExpresionCalculoPHP($filaGrupoAux["funcionAplicacion"],$oParametros,$cacheCalculos));
				if($resultadoEvaluacion==1)
					$considerarAmbito=true;
			}
			if($considerarAmbito)
			{
				if($listaAmbitos=="")
					$listaAmbitos=$filaGrupoAux["id__643_tablaDinamica"];
				else
					$listaAmbitos.=",".$filaGrupoAux["id__643_tablaDinamica"];
			}
			
			
		}
		if($listaAmbitos=="")
			$listaAmbitos=-1;
		
		
		$filaGrupo=null;
		$consulta="SELECT * FROM _643_tablaDinamica WHERE id__643_tablaDinamica IN(".$listaAmbitos.") AND considerarCuantia=1 ";

		$rAmbitos=$con->obtenerFilas($consulta);

		while($filaGrupoAux=$con->fetchAssoc($rAmbitos))
		{
			$consulta="SELECT * FROM _643_tablaDinamica WHERE id__643_tablaDinamica=".$filaGrupoAux["id__643_tablaDinamica"];
			
			if(($filaGrupoAux["opCuantiaMinima"]!="")&&($filaGrupoAux["opCuantiaMinima"]!="-1"))
			{
				$consulta.=" and '".$objParametros["cuantiaProceso"]."'".$filaGrupoAux["opCuantiaMinima"]."montoCuantiaMinima";
			}
			
			if(($filaGrupoAux["opCuantiaMaxima"]!="")&&($filaGrupoAux["opCuantiaMaxima"]!="-1"))
			{
				$consulta.=" AND '".$objParametros["cuantiaProceso"]."'".$filaGrupoAux["opCuantiaMaxima"]."montoCuantiaMaxima";
			}
			
			
			$filaGrupo=$con->obtenerPrimeraFilaAsoc($consulta);
			
			if($filaGrupo)
				break;
		}

		
		if(!$filaGrupo)
		{
			$consulta="SELECT * FROM _643_tablaDinamica WHERE id__643_tablaDinamica IN(".$listaAmbitos.") AND considerarCuantia=0 order by  id__643_tablaDinamica asc";
			$filaGrupo=$con->obtenerPrimeraFilaAsoc($consulta);
		}
		
		$consulta="SELECT * FROM _642_tablaDinamica WHERE id__642_tablaDinamica=".($filaGrupo["idReferencia"]==""?-1:$filaGrupo["idReferencia"]);

		$fGrupoReparto=$con->obtenerPrimeraFilaAsoc($consulta);
		if(!$fGrupoReparto)
		{
			return;
		}
		
		return $fGrupoReparto;

	}
	
	function obtenerDespachoAntecedente($objParametros)
	{
		global $con;
		$consultaAuxiliar="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativaBase='".$objParametros->carpetaAdministrativaBase.
								"' AND tipoCarpetaAdministrativa IN(".$objParametros->tipoCarpetaAdministrativa.") ORDER BY fechaCreacion DESC limit 0,1";
		$universoAuxiliar=$con->obtenerValor($consultaAuxiliar);
		
		if($universoAuxiliar!="")
		{
			return $universoAuxiliar;
		}
		return "";
	}
	
	
	function esDespachoDisponibleAsignacion($fechaReferencia ,$cveDespacho)
	{
		global $con;
		$fechaActual=$fechaReferencia ;
		
		$consulta="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$cveDespacho."'";
		$idUnidad=$con->obtenerValor($consulta);
		
		$consulta="SELECT * FROM _20_tablaDinamica WHERE '".$fechaActual."'>=fechaInicial AND '".$fechaActual."'<=fechaFinal AND idEstado=1 and codigoInstitucion='".$cveDespacho."'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		if($fRegistro)
		{
			$arrRespuesta[0]=false;
			$arrRespuesta[1]="No considerado en reparto debido a que se ha detectado ".($fRegistro["tipoIncidencia"]=="3"?" una vacancia de juez/magistrado":" una incidencia").". Folio de registro: ".$fRegistro["codigo"];
			if(trim($fRegistro["comentarios"])!="")
			{
				$arrRespuesta[1].=". Comentarios: ".trim($fRegistro["comentarios"]);
			}
			return $arrRespuesta;
		}
		
		
		if(!esDiaHabilInstitucion($fechaActual,$cveDespacho))
		{
			$arrRespuesta[0]=false;
			$arrRespuesta[1]="No considerado en reparto debido a que se ha detectado el dia (".date("d/m/Y",strtotime($fechaActual)).") como NO h&aacute;bil para la instituci&oacute;n";
			if(trim($fRegistro["comentarios"])!="")
			{
				$arrRespuesta[1].=". Comentarios: ".trim($fRegistro["comentarios"]);
			}
			return $arrRespuesta;
		}
		
		return true;
	}
	
	function esMedioControlNulidadPropiedaIndustrial($iFormulario,$iRegistro)
	{
		global $con;
		
		$consulta="SELECT tipoSubProceso FROM _1010_tablaDinamica WHERE id__1010_tablaDinamica=".$iRegistro;
		$tipoSubProceso=$con->obtenerValor($consulta);
		if($tipoSubProceso==1)
		{
			return 1;
		}
		return 0;
		
	}
	
	function esMedioControlNulidadAsuntosTributarios($iFormulario,$iRegistro)
	{
		global $con;
		
		$consulta="SELECT tipoSubProceso FROM _1010_tablaDinamica WHERE id__1010_tablaDinamica=".$iRegistro;
		$tipoSubProceso=$con->obtenerValor($consulta);
		if($tipoSubProceso==2)
		{
			return 1;
		}
		return 0;
	}
?>
