<?php 
include_once("conexionBD.php");
include_once("utiles.php");
include_once("numeroToLetra.php");


function funcionLlenadoDocumentoBaseGeneral($idFormularioBase,$idRegistroBase)
{
	global $arrMesLetra;
	global $con;
	global $arrMesLetra;
	global $leyendaTribunal;
	
	

	$consulta="SELECT * FROM _".$idFormularioBase."_tablaDinamica WHERE id__".$idFormularioBase."_tablaDinamica=".$idRegistroBase;
	$fRegistroDatosBase=$con->obtenerPrimeraFilaAsoc($consulta);	
	$carpetaAdministrativo="";
	switch($idFormularioBase)
	{
		case 706:
			$consulta="SELECT carpetaAdministrativaContestacionExcepcionPrevia FROM _706_tablaDinamica WHERE id__706_tablaDinamica=".$idRegistroBase;
			$carpetaAdministrativo=$con->obtenerValor($consulta);
		break;
		default:
			$carpetaAdministrativo=obtenerCarpetaAdministrativaProceso($idFormularioBase,$idRegistroBase);
		break;
	}

	
	$consulta="SELECT carpetaAdministrativa,unidadGestion,idActividad,carpetaAdministrativaBase,tipoProceso FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativo."'";
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	if(!$fRegistro)
	{
		
		$fRegistro["idActividad"]=isset($fRegistroDatosBase["idActividad"])?$fRegistroDatosBase["idActividad"]:-1;
		$fRegistro["unidadGestion"]="-1";
		$fRegistro["tipoProceso"]=0;
	}
	$arrValores=array();
	
	
	$consulta="SELECT a.idUsuario,
			(SELECT COUNT(*) FROM 807_usuariosVSRoles uR2 WHERE uR2.idUsuario=a.idUsuario AND uR2.idRol=56) AS esJuez,
			i.Genero AS  genero,i.Nombre AS nombre 
			FROM  801_adscripcion a,807_usuariosVSRoles uR,802_identifica i WHERE a.Institucion='".$_SESSION["codigoInstitucion"]."'
			AND a.idUsuario=uR.idUsuario AND uR.idRol IN(56,96) AND i.idUsuario=a.idUsuario";
	$fJuez=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$titulo="";
	$tituloArticulo="";
	if($fJuez["esJuez"]==1)
	{
		if($fJuez["genero"]==1)//mujer
		{
			$titulo="Juez";
			$tituloArticulo="La juez";
		}
		else
		{
			$titulo="Juez";
			$tituloArticulo="El juez";
		}
	
	}
	else
	{
		
		if($fJuez["genero"]==1)//mujer
		{
			$titulo="Magistrada";
			$tituloArticulo="La Magistrada";
		}
		else
		{
			$titulo="Magistrado";
			$tituloArticulo="El Magistrado";
		}
	}	
	
	$arrValores["nombreJuezArticulo"]=$tituloArticulo." ".$fJuez["nombre"];
	$arrValores["nombreJuez"]=$titulo." ".$fJuez["nombre"];
	
	
	
	
	$consulta="SELECT upper(nombreUnidad) FROM _17_tablaDinamica WHERE claveUnidad='".$fRegistro["unidadGestion"]."'";
	$nombreDespacho=$con->obtenerValor($consulta);
	$fechaActual=date("Y-m-d");

	$codigoUnicoProcesoTribunalSuperior="";
	$codigoUnicoProcesoCorteSuprema="";
	if($idFormularioBase==672)
	{
		$consulta="SELECT carpetaAdministrativa2aInstancia,despachoAsignado FROM _672_tablaDinamica WHERE id__672_tablaDinamica=".$idRegistroBase;
		$fRegistroApelacion=$con->obtenerPrimeraFilaAsoc($consulta);
		$codigoUnicoProcesoTribunalSuperior=$fRegistroApelacion["carpetaAdministrativa2aInstancia"];
		
		$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$fRegistroApelacion["despachoAsignado"]."'";
		$nombreDespacho=$con->obtenerValor($consulta);
	}
	
	switch($idFormularioBase)
	{
		case 682:
		case 677:
			$codigoUnicoProcesoTribunalSuperior=$carpetaAdministrativo;
			
			$arrCarpetas=array();
			obtenerCarpetasPadre($carpetaAdministrativo,$arrCarpetas);
			
			if(sizeof($arrCarpetas)==0)
			{
				array_push($arrCarpetas,$carpetaAdministrativo);
			}
			
	
			
			$carpetaAdministrativo=$arrCarpetas[0];	
		break;
		case 899:	
			if($fRegistroDatosBase["fechaAudiencia"]!="")
			{
				$arrValores["fechaAudiencia"]=convertirFechaLetra($fRegistroDatosBase["fechaAudiencia"],false,false);
			}
		break;
		case 696:
			$consulta="SELECT tipoDocumento,idReferencia FROM _696_tablaDinamica WHERE id__696_tablaDinamica=".$idRegistroBase;
			$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);
			$tipoDocumento=$fRegistroBase["tipoDocumento"];
			
			
			
			switch($tipoDocumento)
			{
				case 576:
					$noMedida=1;
					$medidasCautelares="";
					$consulta="SELECT cM.medidaCautelar,g.detalles FROM _1237_gMedidasProvisionales g,_1237_tablaDinamica fM,_857_tablaDinamica cM WHERE g.idReferencia=fM.id__1237_tablaDinamica
							AND fM.idReferencia=".$fRegistroBase["idReferencia"]." AND cM.id__857_tablaDinamica=g.medidaProvisional";
							
					$rMedidas=$con->obtenerFilas($consulta);
					while($fMedida=$con->fetchAssoc($rMedidas))
					{
						$m="<b>".$noMedida.")</b> ".$fMedida["medidaCautelar"];
						
						if(trim($fMedida["detalles"])!="")
						{
							$m.=". ".$fMedida["detalles"];
						}
						
						if($medidasCautelares=="")
							$medidasCautelares=$m;
						else
							$medidasCautelares.="<br><br>".$m;
						$noMedida++;
					}
					$arrValores["lblMedidas"]="";
					if($medidasCautelares!="")
						$arrValores["lblMedidas"]="2. Decretar las siguientes medidas provisionales: <br><br>".trim($medidasCautelares);
				break;
				case 696:
				case 727:
					$idAudiencia=$fRegistroBase["idReferencia"];
					
					
					$consulta="SELECT idJuez FROM 7001_eventoAudienciaJuez WHERE idRegistroEvento=".$idAudiencia;
					$rJuez=$con->obtenerFilas($consulta);
					

					
					$consulta="SELECT * FROM _1124_tablaDinamica WHERE idReferencia=".$idAudiencia;
					$fResolutivos=$con->obtenerPrimeraFilaAsoc($consulta);
					$arrValores["nombreJuez"]="";
					while($fJuez=$con->fetchAssoc($rJuez))
					{
						if($arrValores["nombreJuez"]=="")
							$arrValores["nombreJuez"]=obtenerNombreUsuario($fJuez["idJuez"]);
						else
							$arrValores["nombreJuez"].="<br />".obtenerNombreUsuario($fJuez["idJuez"]);
					}
					$consulta="SELECT fechaEvento,horaInicioEvento,horaFinEvento FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idAudiencia;
					$fDatosEvento=$con->obtenerPrimeraFilaAsoc($consulta);
					
					$arrValores["fechaAudiencia"]=date("d/m/Y",strtotime($fDatosEvento["fechaEvento"]));
					$arrValores["horaInicio"]=date("H:i",strtotime($fDatosEvento["horaInicioEvento"]))." hrs.";
					$arrValores["horaFin"]=date("H:i",strtotime($fDatosEvento["horaFinEvento"]))." hrs.";
					$arrValores["excepcionesPrevias"]="";
					$arrValores["acuerdoConciliatorio"]="";
					if($fResolutivos["acuerdoConciliatorio"]==1)
					{
						$arrValores["acuerdoConciliatorio"]="Sí".($fResolutivos["detalleAcuerdoConciliatorio"]!=""?(". ".$fResolutivos["detalleAcuerdoConciliatorio"]):"");
					}
					else
					{
						$arrValores["acuerdoConciliatorio"]="No".($fResolutivos["detalleAcuerdoConciliatorio"]!=""?(". ".$fResolutivos["detalleAcuerdoConciliatorio"]):"");
					}
					if($fResolutivos["excepcionesPrevias"]==1)
					{
						$arrValores["excepcionesPrevias"]="En lo que tiene que ver con la etapa de resolución de EXCEPCIONES PREVIAS conforme a lo".
									" previsto en el artículo 32 del C. P. del T. y de la S.S., el juzgado procede a resolver las mismas en los siguientes términos:<br>br>".
									$fResolutivos["resolucionExcepcionesPrevias"];
					}
					else
					{
						$arrValores["excepcionesPrevias"]="SIN EXCEPCIONES PREVIAS";
					}
					$arrValores["saneamiento"]="";
					if($fResolutivos["presentanNulidades"]==1)
					{
						$arrValores["saneamiento"]="El Despacho no observa irregularidad alguno que invalide lo actuado y que pueda configurar una causal de nulidad o que pueda dar lugar a la aplicación de las medidas de saneamiento".
									", toda vez que en el trámite del proceso se ha verificado las normas propias del mismo, ya que se notificó en debida forma y se garantizó el derecho de contradicción y defensa.<br><br>".
									$fResolutivos["saneamientoProceso"];
					}
					else
					{
						$arrValores["saneamiento"]="SIN SANEAMIENTO EN EL PROCESO";
					}
					
					$arrValores["litigio"]="";
					if($fResolutivos["fijaLitigio"]==1)
					{
						$arrValores["litigio"]="En esta etapa de la diligencia, el litigio giraría en torno a:<br><br>".$fResolutivos["detalleFijaLitigio"];
					}
					else
					{
						$arrValores["litigio"]="NO SE FIJÓ LITIGIO";
					}
					
					$arrValores["decretoPruebas"]="";
					if($fResolutivos["pruebasDemandante"]==1)
					{
						$arrValores["decretoPruebas"]="A FAVOR DE LA PARTE DEMANDANTE:<br><br>".$fResolutivos["especifiquePruebasDemandante"];
					}
					
					
					if($fResolutivos["pruebasDemandada"]==1)
					{
						if($arrValores["decretoPruebas"]=="")
							$arrValores["decretoPruebas"]="A FAVOR DE LA PARTE DEMANDADA:<br><br>".$fResolutivos["especifiquePruebasDemandado"];
						else
							$arrValores["decretoPruebas"].="<br><br>A FAVOR DE LA PARTE DEMANDADA:<br><br>".$fResolutivos["especifiquePruebasDemandado"];
					}
					
					if($fResolutivos["pruebasDeOficio"]==1)
					{
						if($arrValores["decretoPruebas"]=="")
							$arrValores["decretoPruebas"]="PRUEBAS DE OFICIO:<br><br>".$fResolutivos["especifiquePruebasDeOficio"];
						else
							$arrValores["decretoPruebas"].="<br><br>PRUEBAS DE OFICIO:<br><br>".$fResolutivos["especifiquePruebasDeOficio"];
					}
					
					if($arrValores["decretoPruebas"]=="")
					{
						$arrValores["decretoPruebas"]="NO SE DECRETARON PRUEBAS";
					}
					
					$arrValores["practicaronPruebas"]="";
					if($fResolutivos["practicaronPruebas"]==1)
					{
						$arrValores["practicaronPruebas"]="Sí".($fResolutivos["especifiquePruebas"]!=""?(". ".$fResolutivos["especifiquePruebas"]):"");
					}
					else
					{
						$arrValores["practicaronPruebas"]="No".($fResolutivos["especifiquePruebas"]!=""?(". ".$fResolutivos["especifiquePruebas"]):"");
					}
					
					$arrValores["practicaronAlegatos"]="";
					if($fResolutivos["alegatosConclusion"]==1)
					{
						$arrValores["practicaronAlegatos"]="Sí".($fResolutivos["especifiqueAlegatosConclusion"]!=""?(". ".$fResolutivos["especifiqueAlegatosConclusion"]):"");
					}
					else
					{
						$arrValores["practicaronAlegatos"]="No".($fResolutivos["especifiqueAlegatosConclusion"]!=""?(". ".$fResolutivos["especifiqueAlegatosConclusion"]):"");
					}
					
					$arrValores["dictoFallo"]="";
					if($fResolutivos["dictoFallo"]==1)
					{
						$arrValores["dictoFallo"]="Sí".($fResolutivos["especifiqueFallo"]!=""?(". ".$fResolutivos["especifiqueFallo"]):"");
					}
					else
					{
						$arrValores["dictoFallo"]="No".($fResolutivos["especifiqueFallo"]!=""?(". ".$fResolutivos["especifiqueFallo"]):"");
					}
					
					$arrValores["final"]="No habiendo más pruebas qpor prácticar, el despacho dispone el CIERRE DEL DEBATE PROBATORIO ".
										"y concede a las partes el termino de ________ minutos para que formulen sus ALEGATOS DE CONCLUSIÓN.<BR><BR>".
										"Escuchados los ALEGATOS DE CONCLUSIÓN, este despacho dispondrá un receso para dictar sentencia que en derecho corresponda";
					
				break;
				case 739:
					$consulta="SELECT o.unidad FROM _1313_tablaDinamica t,817_organigrama o  WHERE idReferencia=".$fRegistroDatosBase["idReferencia"]." AND o.codigoUnidad=t.despachoAtiende";

					$lblDespacho=$con->obtenerValor($consulta);
					$arrValores["lblDespachoAtiende"]=$lblDespacho;
					
				break;
			}
		break;
	}
	
	$demantante="";
	$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
				FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
				AND r.idActividad=".$fRegistro["idActividad"]." AND r.idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='A') ORDER BY nombre,nombre,apellidoMaterno";
	
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
				AND r.idActividad=".$fRegistro["idActividad"]." AND r.idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='D') ORDER BY nombre,nombre,apellidoMaterno";
	
	$res=$con->obtenerFilas($consulta);
	while($filaImputado=$con->fetchRow($res))
	{
		$nombre=trim($filaImputado[0]);
		if($demandados=="")
			$demandados=$nombre;
		else
			$demandados.=", ".$nombre;
	}

	$arrValores["nombreDespacho"]=limpiarCadenaSerializacion($nombreDespacho);
	
	if($idFormularioBase==899)
	{
		$consulta="SELECT providenciaAplicar FROM _899_tablaDinamica WHERE id__899_tablaDinamica=".$idRegistroBase;
		$providenciaAplicar=$con->obtenerValor($consulta);
		
		switch($providenciaAplicar)
		{
			case 22:
			case 37:
				$noMedida=1;
				$medidasCautelares="";
				$consulta="SELECT cM.medidaCautelar,g.detalles FROM _1018_gMedidasProvicionales g,_1018_tablaDinamica fM,_857_tablaDinamica cM WHERE g.idReferencia=fM.id__1018_tablaDinamica
						AND fM.idReferencia=".$idRegistroBase." AND cM.id__857_tablaDinamica=g.medidaProvisional";
						
				$rMedidas=$con->obtenerFilas($consulta);
				while($fMedida=$con->fetchAssoc($rMedidas))
				{
					$m="<b>".$noMedida.")</b> ".$fMedida["medidaCautelar"];
					
					if(trim($fMedida["detalles"])!="")
					{
						$m.=". ".$fMedida["detalles"];
					}
					
					if($medidasCautelares=="")
						$medidasCautelares=$m;
					else
						$medidasCautelares.="<br><br>".$m;
					$noMedida++;
				}
				
				$arrValores["lblMedidas"]=trim($medidasCautelares);
			break;
			case 42:
				$noMedida=1;
				$medidasCautelares="";
				
				$consulta="SELECT * FROM _1104_tablaDinamica WHERE idReferencia=".$idRegistroBase;
				$fMedidas=$con->obtenerPrimeraFilaAsoc($consulta);
				
				if($fMedidas["decretanMediasCautelares"]==1)
				{
					$medidasCautelares="<b>Decretar las siguientes medidas cautelares:</b><br><br>";
					$consulta="SELECT cM.medidaCautelar,g.detalles FROM _1104_gMedidasCautelares g,_1104_tablaDinamica fM,_857_tablaDinamica cM WHERE g.idReferencia=fM.id__1104_tablaDinamica
							AND fM.idReferencia=".$idRegistroBase." AND cM.id__857_tablaDinamica=g.medidaCautelar";
	
					$rMedidas=$con->obtenerFilas($consulta);
					while($fMedida=$con->fetchAssoc($rMedidas))
					{
						$m="<b>".$noMedida.")</b> ".$fMedida["medidaCautelar"];
						
						if(trim($fMedida["detalles"])!="")
						{
							$m.=". ".$fMedida["detalles"];
						}
						
						if($medidasCautelares=="")
							$medidasCautelares=$m;
						else
							$medidasCautelares.="<br><br>".$m;
						$noMedida++;
					}
				}
				else
				{
					$medidasCautelares="<b>NO Decretar medidas cautelares...</b>";
				}
				$arrValores["medidasCautelares"]=trim($medidasCautelares);
			break;
		}
		
	}
	
	$arrValores["fechaActual"]=convertirFechaLetra($fechaActual,false,false);
	$arrValores["demandante"]=$demantante;
	$arrValores["demandado"]=$demandados;
	$arrValores["lblDemandado"]=$fRegistro["tipoProceso"]==6?"ACCIONADO":"DEMANDADO";
	$arrValores["lblActor"]=$fRegistro["tipoProceso"]==6?"ACCIONANTE":"DEMANDANTE";
	$arrValores["codigoUnicoProceso"]=$carpetaAdministrativo;
	$arrValores["codigoUnicoProcesoTribunalSuperior"]=$codigoUnicoProcesoTribunalSuperior;
	$arrValores["codigoUnicoProcesoCorteSuprema"]=$codigoUnicoProcesoCorteSuprema;
	$arrValores["nombreUsuario"]=obtenerNombreUsuario($_SESSION["idUsr"]);
	

	
	if($idFormularioBase==696)
	{
		$consulta="SELECT * FROM _696_tablaDinamica WHERE id__696_tablaDinamica=".$idRegistroBase;
		$fDatosAuto=$con->obtenerPrimeraFilaAsoc($consulta);
		
		if($fDatosAuto["tipoDocumento"]==625)
		{
			$idAudiencia=$fDatosAuto["idReferencia"];
			
			$consulta="SELECT * FROM _781_tablaDinamica WHERE idReferencia=".$idAudiencia;
			$fAudiencia=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$resolutivos="Se llevo a cabo la <b>Audiencia Inicial</b> registrandose los siguientes eventos: <br><br>";
			$resolutivos.="- ".($fAudiencia["propuestaConciliatoria"]==1?("Se realizó audiencia de conciliación: ".($fAudiencia["tipoAcuerdo"]==1?"Total":"Parcial")):"NO se realizó audiencia de conciliación")."<br><br>";
			$resolutivos.="- ".($fAudiencia["excepcionesPrevias"]==1?"Existen excepciones previas":"No existen excepciones previas")."<br><br>";
			$resolutivos.="- ".($fAudiencia["presentanNulidades"]==1?"Se sanearon las nulidades del proceso":"No se sanearon las nulidades del proceso")."<br><br>";
			$resolutivos.="- ".($fAudiencia["fijaLitigio"]==1?"Se procedió a fijar el litigio":"NO se fijó el litigio")."<br><br>";
			if($fAudiencia["fijaLitigio"]==1)
			{
				$resolutivos.="- ".($fAudiencia["liticonsorcio"]==1?("Se determina la vinculación de algún litisconsorcio: ".$fAudiencia["cualLitiConsorcio"]):"NO se determina la vinculación de algún litisconsorcio")."<br><br>";
				
			}
			$resolutivos.="- ".($fAudiencia["practicaronPruebas"]==1?"Se decretaron las siguientes pruebas:":"No se decretaron pruebas")."<br><br>";
			if($fAudiencia["practicaronPruebas"]==1)
			{
				$consulta="SELECT v.nombreElemento,descripcion FROM _781_gPruebas g,1018_catalogoVarios v WHERE idReferencia=".$fAudiencia["id__781_tablaDinamica"]."
							AND g.tipoPrueba=v.claveElemento AND v.tipoElemento=39  ORDER BY id__781_gPruebas";
			
				$rElementos=$con->obtenerFilas($consulta);
				while($fElemento=$con->fetchAssoc($rElementos))
				{
					$resolutivos.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(".$fElemento["nombreElemento"].") ".$fElemento["descripcion"]."<br><br>";
				}
			
			}
			
			$resolutivos.="- Se fija fecha para fecha de audiencia de trámite y juzgamiento el día: ".convertirFechaLetra($fAudiencia["fechaAudiencia"],false,false)."<br><br>";
			$arrValores["resolutivos"]=	$resolutivos;
		}
		
		if($fDatosAuto["tipoDocumento"]==626)
		{
			$idAudiencia=$fDatosAuto["idReferencia"];
			
			$consulta="SELECT * FROM _782_tablaDinamica WHERE idReferencia=".$idAudiencia;
			$fAudiencia=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$resolutivos="Se llevo a cabo la <b>Audiencia de Trámite y Juzgamiento</b> registrandose los siguientes eventos: <br><br>";
			$resolutivos.="- ".($fAudiencia["practicaronPruebas"]==1?"Se practicaron todas las pruebas":"NO se practicaron todas las pruebas")."<br><br>";
			$resolutivos.="- ".($fAudiencia["alegatosDemandante"]==1?"Se presentaron alegatos de conclusión por el demandante":"NO se presentaron alegatos de conclusión por el demandante")."<br><br>";
			$resolutivos.="- ".($fAudiencia["alegatosDemandado"]==1?"Se presentaron alegatos de conclusión por el demandado":"NO se presentaron alegatos de conclusión por el demandado")."<br><br>";
			$resolutivos.="- ".($fAudiencia["profiereSentencia"]==1?"Se profirió sentencia":"NO se profirió sentencia")." (".($fAudiencia["falloFavorableDemandante"]==1?"Favorable al demandante":"Favorable al demandado").")<br><br>";
			
			if($fAudiencia["profiereSentencia"]==1)
			{
				
				$resolutivos.="<B>RESOLUCIÓN</B><br><br>";
				$resolutivos.=$fAudiencia["resolucion"]."<br><br>";
				
				$resolutivos.="- ".($fAudiencia["sentenciaApelada"]==1?"La sentencia fu&eacute; apelada":"La sentencia no fu&eacute; apelada")."<br><br>";
				if($fAudiencia["sentenciaApelada"]==1)
				{
					$resolutivos.="- ".($fAudiencia["efectoConcedido"]==1?"Se concede la apelaci&oacute;n":"No se concede la apelaci&oacute;n");
					if($fAudiencia["concedeApelacion"]==1)
					{
						switch($fAudiencia["efectoConcedido"])
						{
							case 1:
								$resolutivos.=" bajo el efecto: Suspensivo";
							break;
							case 2:
								$resolutivos.=" bajo el efecto: Diferido";
							break;
							case 3:
								$resolutivos.=" bajo el efecto: Devolutivo";
							break;
						}
					}
					$resolutivos.="<br><br>";
					
					
					$resolutivos.="<B>APELANTES</B><br><br>";
					$consulta="SELECT CONCAT(r.participante,', ',IF(g.naturaleza=1,'Opositor','Recurrente')) AS participante 
								FROM _782_gridApelantes g,7005_relacionFigurasJuridicas r WHERE g.idReferencia=".$fAudiencia["id__782_tablaDinamica"]."
								AND r.idRelacion=g.apelante ORDER BY r.participante";
					$rParticipante=$con->obtenerFilas($consulta);
					while($fApelante=$con->fetchAssoc($rParticipante))
					{
						$resolutivos.="- ".limpiarCadenaSerializacion($fApelante["participante"])."<br>";
					}
								
													
				}
				
			
			}
			
			
			
			$arrValores["resolutivos"]=	$resolutivos;
		}
		
		if($fDatosAuto["tipoDocumento"]==628)
		{
			
			$consulta="SELECT causalRechazo,comentariosAdicionales FROM _1063_tablaDinamica WHERE idReferencia=".$idRegistroBase;
			$fAudiencia=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$consulta="SELECT contenido FROM 902_opcionesFormulario WHERE valor=".$fAudiencia["causalRechazo"]." AND idGrupoElemento=14366";
			$descripcionCausal=$con->obtenerValor($consulta);
			
			if($fAudiencia["comentariosAdicionales"]!="")
			{
				if($descripcionCausal=="")
					$descripcionCausal=$fAudiencia["comentariosAdicionales"];
				else
					$descripcionCausal.=".- ".$fAudiencia["comentariosAdicionales"];
			}
			
			$arrValores["descripcionCausal"]=	$descripcionCausal;
		}
		
		if($fDatosAuto["tipoDocumento"]==674)
		{
			$idAudiencia=$fDatosAuto["idReferencia"];
			
			$consulta="SELECT * FROM _1100_tablaDinamica WHERE idReferencia=".$idAudiencia;
			$fAudiencia=$con->obtenerPrimeraFilaAsoc($consulta);
			
			
			$resolutivos="Se llevo a cabo la <b>Audiencia Inicial</b> registrandose los siguientes eventos: <br><br>";
			
			if($fAudiencia["pruebaActor"]==1)
			{
				$resolutivos.="- Se decretan las siguientes pruebas para la parte demandante:<br><br>";
				
				$consulta="SELECT v.nombreElemento,descripcion FROM _1100_gPruebasActor g,1018_catalogoVarios v WHERE idReferencia=".$fAudiencia["id__1100_tablaDinamica"]."
							AND g.tipoPrueba=v.claveElemento AND v.tipoElemento=39  ORDER BY v.nombreElemento";
			
				$rElementos=$con->obtenerFilas($consulta);
				while($fElemento=$con->fetchAssoc($rElementos))
				{
					$resolutivos.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(".$fElemento["nombreElemento"].") ".$fElemento["descripcion"]."<br><br>";
				}
				
			}
			
			if($fAudiencia["pruebaDemandado"]==1)
			{
				$resolutivos.="- Se decretan las siguientes pruebas para la parte demandada:<br><br>";
				$consulta="SELECT v.nombreElemento,descripcionDemandado FROM _1100_gPruebasDemandado g,1018_catalogoVarios v WHERE idReferencia=".$fAudiencia["id__1100_tablaDinamica"]."
							AND g.tipoPruebaDemandado=v.claveElemento AND v.tipoElemento=39  ORDER BY v.nombreElemento";
			
				$rElementos=$con->obtenerFilas($consulta);
				while($fElemento=$con->fetchAssoc($rElementos))
				{
					$resolutivos.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(".$fElemento["nombreElemento"].") ".$fElemento["descripcionDemandado"]."<br><br>";
				}
			}
			
			
			if($fAudiencia["certificacionSuperIntendencia"]==1)
			{
				$resolutivos.="- Se solicitan las siguientes certificaciones a la Super Intendecia:<br><br>";
				$resolutivos.=$fAudiencia["Especifique"]."<br><br>";
			}
			
			
			if($fAudiencia["conceptoMinisterioPublico"]==1)
			{
				$resolutivos.="- Se solicita concepto al Ministerio Público:<br><br>";
			}
			
			
			
			
			$arrValores["resolutivos"]=	$resolutivos;
		}
		
		if($fDatosAuto["tipoDocumento"]==540)
		{
			$consulta="SELECT (SELECT medidaCautelar FROM _857_tablaDinamica WHERE id__857_tablaDinamica=causalImpedimento) AS causalImpedimento,
						detallesAdicionales FROM _975_tablaDinamica i WHERE idReferencia=".$idRegistroBase;
			
			$fRegistroCausal=$con->obtenerPrimeraFilaAsoc($consulta);
			$descripcionCausal=$fRegistroCausal["causalImpedimento"].". ".(trim($fRegistroCausal["detallesAdicionales"])==""?"":$fRegistroCausal["detallesAdicionales"]);
			$arrValores["causalImpedimento"]=	$descripcionCausal;
		}
	}
	
	
	foreach($arrValores as $llave=>$valor)
	{
		$arrValores[$llave]=limpiarCadenaSerializacion($valor);
	}
	
	return $arrValores;
}

function funcionLlenadoDocumentoBaseGeneralCorteSuprema($idFormularioBase,$idRegistroBase)
{
	global $arrMesLetra;
	global $con;
	global $arrMesLetra;
	global $leyendaTribunal;
	
	
	
	
	$carpetaAdministrativo=obtenerCarpetaAdministrativaProceso($idFormularioBase,$idRegistroBase);
	$consulta="SELECT carpetaAdministrativa,unidadGestion,idActividad,carpetaAdministrativaBase FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativo."'";
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	
	
	$arrValores=array();
	$consulta="SELECT upper(nombreUnidad) FROM _17_tablaDinamica WHERE claveUnidad='".$fRegistro["unidadGestion"]."'";
	$nombreDespacho=$con->obtenerValor($consulta);
	$fechaActual=date("Y-m-d");

	$codigoUnicoProcesoTribunalSuperior="";
	$codigoUnicoProcesoCorteSuprema="";
	
	$codigoUnicoProcesoCorteSuprema=$carpetaAdministrativo;
	
	$arrCarpetas=array();
	obtenerCarpetasPadre($carpetaAdministrativo,$arrCarpetas);
	
	if(sizeof($arrCarpetas)==0)
	{
		array_push($arrCarpetas,$carpetaAdministrativo);
	}
	$carpetaAdministrativo=$arrCarpetas[0];	
	$codigoUnicoProcesoTribunalSuperior=$fRegistro["carpetaAdministrativaBase"];
	
	$demantante="";
	$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
				FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
				AND r.idActividad=".$fRegistro["idActividad"]." AND r.idFiguraJuridica in(2,7) ORDER BY nombre,nombre,apellidoMaterno";
	
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
				AND r.idActividad=".$fRegistro["idActividad"]." AND r.idFiguraJuridica in(4,8) ORDER BY nombre,nombre,apellidoMaterno";
	
	$res=$con->obtenerFilas($consulta);
	while($filaImputado=$con->fetchRow($res))
	{
		$nombre=trim($filaImputado[0]);
		if($demandados=="")
			$demandados=$nombre;
		else
			$demandados.=", ".$nombre;
	}

	$arrValores["nombreDespacho"]=trim($nombreDespacho);
	$arrValores["fechaActual"]=convertirFechaLetra($fechaActual,false,false);
	$arrValores["demandante"]=$demantante;
	$arrValores["demandado"]=$demandados;
	$arrValores["codigoUnicoProceso"]=$carpetaAdministrativo;
	$arrValores["codigoUnicoProcesoTS"]=$codigoUnicoProcesoTribunalSuperior;
	$arrValores["codigoUnicoProcesoSC"]=$codigoUnicoProcesoCorteSuprema;
	
	foreach($arrValores as $llave=>$valor)
	{
		$arrValores[$llave]=limpiarCadenaSerializacion($valor);
	}
	return $arrValores;
}
?>
