<?php session_start();
	
	include("conexionBD.php");
	include_once("nusoap/nusoap.php");
	include_once("latisErrorHandler.php");

	ini_set('default_socket_timeout', 160000);
	ini_set('post_max_size', '4096M');
	ini_set('upload_max_filesize', '4096M');
	
	function obtenerExpedienteElectronico($cup,$token)
	{
		
		global $con;
		
		$aResultado=validarTokenServicio($token,(__FUNCTION__),basename((__FILE__)),"XML");
		
		$consulta="SELECT COUNT(*) FROM 8000_tokensAccesoWS WHERE token='".$token.
					"' AND nombreServicio='obtenerExpedienteElectronico' AND archivoServicio='wsServiciosGeneralesSIUGJ.php'";
		
		$numFila=$con->obtenerValor($consulta);
		
		if($aResultado[0]==0)
		{
			
			return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><expediente>'.$aResultado[1].'</expediente>';
		}
		
		try
		{
			$xml='<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
			$xml.='<expediente>';
			
			$expedientes=exportarExpedienteElectronicoWS($cup,-1,0);
			$xml.=$expedientes;
			$xml.='</expediente>';
			
			return $xml;
			
		}
		catch(Exception $e)
		{
			return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><expediente><resultado>0</resultado><error><![CDATA['.cv($e->getMessage()).']]></error></expediente>';
		}
	}

	function exportarExpedienteElectronicoWS($carpetaAdministrativa,$idCarpetaAdministrativa,$nivelExpediente)
	{
		global $con;
		$arrExpedientTable="";
	
		
		$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		if($idCarpetaAdministrativa!="-1")
			$consulta.=" AND idCarpeta=".$idCarpetaAdministrativa;	
		$filaArchivo=$con->obtenerPrimeraFilaAsoc($consulta);
		if(!$filaArchivo)
		{
			return '<resultado>0</resultado><error><![CDATA[El CUP ingresado no existe]]></error>';
		}
		/*foreach($filaArchivo as $llave=>$valor)
		{
			$arrExpedientTable.="<".$llave."><![CDATA[".$valor."]]></".$llave.">";
		}*/
		//<expedientTable>'.$arrExpedientTable.'</expedientTable>
		
		$demantantes="";
		$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
					FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
					AND r.idActividad=".$filaArchivo["idActividad"]." AND r.idFiguraJuridica in(2,7) ORDER BY nombre,nombre,apellidoMaterno";
		
		$res=$con->obtenerFilas($consulta);
		while($filaImputado=$con->fetchRow($res))
		{
			$nombre=trim($filaImputado[0]);
			$demantantes.="<demandante><![".$nombre."]]></demandante>";
		}
		
		$demandados="";
		$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
					FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
					AND r.idActividad=".$filaArchivo["idActividad"]." AND r.idFiguraJuridica in(4,8) ORDER BY nombre,nombre,apellidoMaterno";
		
		$res=$con->obtenerFilas($consulta);
		while($filaImputado=$con->fetchRow($res))
		{
			$nombre=trim($filaImputado[0]);
			$demandados.="<demandados><![".$nombre."]]></demandados>";
		}
		
		$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$filaArchivo["unidadGestion"]."'";
		$despacho=$con->obtenerValor($consulta);
		
		$xml='	<ExpedienteElectronico>
					<procesoJudial>'.$carpetaAdministrativa.'</procesoJudial>
					<demandantes>'.$demantantes.'</demandantes>
					<demandados>'.$demandados.'</demandados>
					<despacho><!['.cv($despacho).']]></despacho>
					<documentosExpedientes>';
			
		$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		if($idCarpetaAdministrativa!="-1")
			$consulta.=" AND idCarpeta=".$idCarpetaAdministrativa;	
	
		$fCarpeta=$con->obtenerPrimeraFilaAsoc($consulta);

		$consulta="SELECT * FROM 7007_contenidosCarpetaAdministrativa WHERE carpetaAdministrativa='".$carpetaAdministrativa."' and tipoContenido not in (3,-1)";
		if($idCarpetaAdministrativa!=-1)
		{
			$consulta.=" and idCarpetaAdministrativa=".$idCarpetaAdministrativa;
		}
		
		$consulta.=" order by idContenido";
		$res=$con->obtenerFilas($consulta);
		
		while($fila=$con->fetchAssoc($res))
		{
			$consulta="SELECT nomArchivoOriginal,tamano,descripcion,fechaCreacion,sha512,categoriaDocumentos FROM 
					908_archivos WHERE idArchivo=".$fila["idRegistroContenidoReferencia"];
			
			$fArchivo=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$nomArchivoOriginal=$fArchivo["nomArchivoOriginal"];		
			$tamano=$fArchivo["tamano"];		
			$arrExtensiones=explode(".",$nomArchivoOriginal);
			$extension=$arrExtensiones[count($arrExtensiones)-1];
			
			$tamanoBytes=bytesToSize($tamano, 0);
			$tipoDocumental="";
			$consulta="SELECT nombreCategoria FROM 908_categoriasDocumentos WHERE 
					idCategoria=".($fArchivo["categoriaDocumentos"]==""?-1:$fArchivo["categoriaDocumentos"]);
			$tipoDocumental=$con->obtenerValor($consulta);
			if($tipoDocumental=="")
				$tipoDocumental="NO ESPECIFICADO";
				
			$cuerpoBase64Documento=obtenerCuerpoDocumentoB64($fila["idRegistroContenidoReferencia"]);	
			
			$arrMetaData='';
			
			$consulta="SELECT * FROM 908_metaDataArchivos WHERE idArchivo=".$fila["idRegistroContenidoReferencia"];
			$rMetaDato=$con->obtenerFilas($consulta);
			
			while($fMetaData=$con->fetchAssoc($rMetaDato))
			{
				$arrMetaData.="<metaDato>";
				foreach($fMetaData as $llave=>$valor)
				{
					if($llave!="tagMetaDato")
						$arrMetaData.="<".$llave."><![CDATA[".$valor."]]></".$llave.">";
				}
				
				$arrMetaData.="</metaDato>";
			}
			
			
			
			
			
						
			$oNodo="<DocumentoIndizado>
						<Id>".$fila["idContenido"]."</Id>
						<Nombre_Documento><![CDATA[".cv($nomArchivoOriginal)."]]></Nombre_Documento>
						<Tipologia_Documental><![CDATA[".cv($tipoDocumental)."]]></Tipologia_Documental>
						<Fecha_Creacion_Documento><![CDATA[".cv($fArchivo["fechaCreacion"])."]]></Fecha_Creacion_Documento>
						<Fecha_Incorporacion_Expediente><![CDATA[".cv($fArchivo["fechaCreacion"])."]]></Fecha_Incorporacion_Expediente>
						<Valor_Huella><![CDATA[".cv($fArchivo["sha512"])."]]></Valor_Huella>
						<Funcion_Resumen>SHA512</Funcion_Resumen>
						<Orden_Documento_Expediente><![CDATA[".cv($fila["ordenDocumento"])."]]></Orden_Documento_Expediente>
						<Pagina_Inicio><![CDATA[".cv($fila["paginaInicio"])."]]></Pagina_Inicio>
						<Pagina_Fin><![CDATA[".cv($fila["paginaFin"])."]]></Pagina_Fin>
						<Formato><![CDATA[".$extension."]]></Formato>
						<Tamano><![CDATA[".$tamanoBytes."]]></Tamano>
						<metaDataDocumento>".$arrMetaData."</metaDataDocumento>
						<cuerpoBase64Documento><![CDATA[".$cuerpoBase64Documento."]]></cuerpoBase64Documento>
					</DocumentoIndizado>";
			$xml.=$oNodo;
			
		}
		
		$arrExpedientesAsociados="";
		if($nivelExpediente=="0")
		{
			$idCarpeta=$idCarpetaAdministrativa;
			if($idCarpeta==-1)
			{
				$consulta="SELECT idCarpeta FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
				$idCarpeta=$con->obtenerValor($consulta);
			}
			
			$consulta="SELECT carpetaAdministrativa,idCarpeta FROM 7006_carpetasAdministrativasRelacionadas WHERE carpetaAdministrativaBase='".$carpetaAdministrativa."'
					AND idCarpetaBase=".$idCarpeta." AND tipoRelacion=6 ORDER BY carpetaAdministrativa";
			
			$rCarpetasAsociadas=$con->obtenerFilas($consulta);
			while($fCarpetaAsociada=$con->fetchAssoc($rCarpetasAsociadas))
			{
				$arrExpediente=exportarExpedienteElectronicoWS($fCarpetaAsociada["carpetaAdministrativa"],$fCarpetaAsociada["idCarpeta"],($nivelExpediente++));
				$arrExpedientesAsociados.=$arrExpediente;	
			}
		}
		else
		{
			$consulta="SELECT carpetaAdministrativa,idCarpeta FROM 7006_carpetasAdministrativas WHERE 
					carpetaAdministrativaBase='".$carpetaAdministrativa."' AND idCarpetaAdministrativaBase=".$idCarpetaAdministrativa." ORDER BY carpetaAdministrativa";
			
			$rCarpetasAsociadas=$con->obtenerFilas($consulta);
			while($fCarpetaAsociada=$con->fetchAssoc($rCarpetasAsociadas))
			{
				$arrExpediente=exportarExpedienteElectronico($fCarpetaAsociada["carpetaAdministrativa"],$fCarpetaAsociada["idCarpeta"],($nivelExpediente++));
				$arrExpedientesAsociados.=$arrExpediente;	
			}
		}
		
		$xml.="</documentosExpedientes><expedientesAsociados>".$arrExpedientesAsociados."</expedientesAsociados></ExpedienteElectronico>";
		
		return $xml;
	}
	
	function registrarUsuarioSistema($oUsuario,$token)
	{
		
		global $con;
		$oUsuario=str_replace("\r","",$oUsuario);
		$oUsuario=str_replace("\n","",$oUsuario);
		$oUsuario=str_replace("\t","",$oUsuario);
		
		try
		{
			$objUsuario=json_decode($oUsuario);
			
			
			$consulta="SELECT COUNT(*) FROM 817_organigrama WHERE  codigoUnidad='".$objUsuario->adscripcion."'";
			$numReg=$con->obtenerValor($consulta);
			if($numReg==0)
			{
				return '{"resultado":"0","data":"","error":"La clave de adscripci&oacute;n ingresada no existe","codigoError":"20"}';
			}
			
			$arrRoles=explode(",",$objUsuario->roles);
			foreach($arrRoles as $r)
			{
				$consulta="SELECT COUNT(*) FROM 8001_roles WHERE  idRol=".$r."";
				$numReg=$con->obtenerValor($consulta);
				if($numReg==0)
				{
					return '{"resultado":"0","data":"","error":"El rol '.$r.' ingresado no existe","codigoError":"30"}';
				}
			}
			
			$idUsuario=crearBaseUsuario($objUsuario->apPaterno,$objUsuario->apMaterno,$objUsuario->nombre,$objUsuario->email,$objUsuario->adscripcion,"",$objUsuario->roles,$objUsuario->loginUsuario,$objUsuario->passwordUsuario,"-1",false);
			if($idUsuario!=-1)
			{
				$x=0;
				$query[$x]="begin";
				$x++;
				if(isset($objUsuario->telefono))
				{
					foreach($objUsuario->telefono as $t)
					{
						$query[$x]="INSERT INTO 804_telefonos(idUsuario,Numero,Extension,Tipo,Tipo2,codArea) values
									(".$idUsuario.",'".cv($t->numero)."','".cv($t->extension)."',1,".$t->tipoTelefono.",'".$t->codArea."')";
						$x++;
					}
				}
				
				if(isset($objUsuario->tipoIdentificacion) &&($objUsuario->tipoIdentificacion!=""))
				{
					$query[$x]="UPDATE 802_identifica SET tipoIdentificacion=".$objUsuario->tipoIdentificacion." WHERE idUsuario=".$idUsuario;
					$x++;
				}
				
				if(isset($objUsuario->numeroIdentificacion) &&($objUsuario->numeroIdentificacion!=""))
				{
					$query[$x]="UPDATE 802_identifica SET noIdentificacion='".cv($objUsuario->numeroIdentificacion)."' WHERE idUsuario=".$idUsuario;
					$x++;
				}
				
				if(isset($objUsuario->actualizarContrasena)&&(($objUsuario->actualizarContrasena==0)))
				{
					$query[$x]="UPDATE 800_usuarios SET cambiarDatosUsr=0 WHERE idUsuario=".$idUsuario;
					$x++;
				}
				
				
				$query[$x]="commit";
				$x++;
				if($con->ejecutarBloque($query))
				{
					return '{"resultado":"1","data":"'.$idUsuario.'","error":"","codigoError":"0"}';
				}
			}
			return '{"resultado":"1","data":"'.$idUsuario.'","error":"","codigoError":"0"}';
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","data":"","error":"'.cv($e->getMessage()).'","codigoError":"10"}';

		}
	}


	function obtenerMapaJudicial($parametrosQuery,$token)
	{
		global $con;
		
		$aResultado=validarTokenServicio($token,(__FUNCTION__),basename((__FILE__)),"XML");
		
		
		if($aResultado[0]==0)
		{
			return '{"resultado":"0","totalRegistros":"0","registros":[],"msgError":"'.$aResultado[1].'"}';

		}
		try
		{
			$oQuery=json_decode($parametrosQuery);
			if(!$oQuery)
			{
				return '{"resultado":"0","totalRegistros":"0","registros":[],"msgError":"Par&aacute;metros de consulta NO v&aacute;lidos"}';
	
			}
			
			
			$condWhere="";
			if(($oQuery->jurisdiccion!="")&&($oQuery->jurisdiccion!="-1"))
			{
				$condWhere=" o.codigoUnidad like '".$oQuery->jurisdiccion."%'";	
			}
			
			
			
			if(($oQuery->categoria!="")&&($oQuery->categoria!="-1"))
			{
				$consulta="SELECT codigoUnidad FROM 817_organigrama WHERE institucion=17 AND claveDepartamental='".$oQuery->categoria."'";
				$resCategorias=$con->obtenerFilas($consulta);
				$condCategoria="";
				if($condWhere!="")
					$condWhere.=" and ";	
				while($filaCategorias=$con->fetchAssoc($resCategorias))
				{
					if($condCategoria=='')
						$condCategoria=" o.codigoUnidad like '".$filaCategorias["codigoUnidad"]."%'";
					else
						$condCategoria.=" or o.codigoUnidad like '".$filaCategorias["codigoUnidad"]."%'";
				}
				
				$condWhere.=" (".$condCategoria.")";
					
			}
			
			if(($oQuery->distritoJudicial!="")&&($oQuery->distritoJudicial!="-1"))
			{
				
				$consulta="SELECT codigoUnidad FROM 817_organigrama WHERE institucion=10 AND claveDepartamental in('".$oQuery->distritoJudicial."')";
				$consulta=str_replace("''","'",$consulta);
				$resCategorias=$con->obtenerFilas($consulta);
				$condCategoria="";
				if($condWhere!="")
					$condWhere.=" and ";	
				while($filaCategorias=$con->fetchAssoc($resCategorias))
				{
					if($condCategoria=='')
						$condCategoria=" o.codigoUnidad like '".$filaCategorias["codigoUnidad"]."%'";
					else
						$condCategoria.=" or o.codigoUnidad like '".$filaCategorias["codigoUnidad"]."%'";
				}
				
				$condWhere.=" (".$condCategoria.")";
					
			}
			
			if(($oQuery->circuitoJudicial!="")&&($oQuery->circuitoJudicial!="-1"))
			{
				
				$consulta="SELECT codigoUnidad FROM 817_organigrama WHERE institucion=12 AND claveDepartamental in('".$oQuery->circuitoJudicial."')";
				$consulta=str_replace("''","'",$consulta);
				
				$resCategorias=$con->obtenerFilas($consulta);
				$condCategoria="";
				if($condWhere!="")
					$condWhere.=" and ";	
				while($filaCategorias=$con->fetchAssoc($resCategorias))
				{
					if($condCategoria=='')
						$condCategoria=" o.codigoUnidad like '".$filaCategorias["codigoUnidad"]."%'";
					else
						$condCategoria.=" or o.codigoUnidad like '".$filaCategorias["codigoUnidad"]."%'";
				}
				
				$condWhere.=" (".$condCategoria.")";
					
			}
			
			if(($oQuery->municipio!="")&&($oQuery->municipio!="-1"))
			{
				$consulta="SELECT codigoUnidad FROM 817_organigrama WHERE institucion=13 AND claveDepartamental='".$oQuery->municipio."'";
				$resMunicipios=$con->obtenerFilas($consulta);
				$condMunicipio="";
				if($condWhere!="")
					$condWhere.=" and ";	
				while($filaMunicipio=$con->fetchAssoc($resMunicipios))
				{
					if($condMunicipio=='')
						$condMunicipio=" o.codigoUnidad like '".$filaMunicipio["codigoUnidad"]."%'";
					else
						$condMunicipio.=" or o.codigoUnidad like '".$filaMunicipio["codigoUnidad"]."%'";
				}
				
				$condWhere.=" (".$condMunicipio.")";
			
			}
			
			if($oQuery->nombreDespacho!="")
			{
				if($condWhere=="")
					$condWhere=" unidad like '%".$oQuery->nombreDespacho."%'";	
				else
					$condWhere.=" and unidad like '%".$oQuery->nombreDespacho."%'";	
			}
			
			if($oQuery->claveDespacho!="")
			{
				if($condWhere=="")
					$condWhere=" claveDepartamental like '%".$oQuery->claveDespacho."%'";	
				else
					$condWhere.=" and claveDepartamental like '%".$oQuery->claveDespacho."%'";	
			}
			
			$consulta="SELECT idCategoriaUnidadOrganigrama FROM 817_categoriasUnidades WHERE esJuzgado=1";
			$listaTiposDespacho=$con->obtenerListaValores($consulta);
			if($listaTiposDespacho=="")
				$listaTiposDespacho=-1;
			
			$arrEstructuraOrganizacional=array();
			$consulta="select unidad,codigoUnidad,idOrganigrama,codigoFuncional,descripcion,institucion,codCentroCosto,unidadPadre,codigoIndividual,claveDepartamental,status,
						(case status when '1'  then 'Activo' when '0' then 'Inactivo' when '2' then 'Concentrador' end) as activo,
						(SELECT nombreCategoria FROM 817_categoriasUnidades WHERE idCategoriaUnidadOrganigrama=o.institucion) as tipoUnidad,
						o.institucion as idTipoUnidad
						from 817_organigrama o where ".($condWhere!=""?($condWhere." and "):"")." institucion in (".$listaTiposDespacho.") and status=1 order by  codigoFuncional";
			
			

			
			if(($oQuery->especialidad!="")&&($oQuery->especialidad!="-1"))
			{
				if(($oQuery->especialidad!="")&&($oQuery->especialidad!="-1"))
				{
					if($condWhere=="")
						$condWhere="e.especialidad=".$oQuery->especialidad;	
					else
						$condWhere.=" and e.especialidad=".$oQuery->especialidad;	
				}
				
				/*if(($fila["detalleAdicional"]!="")&&($fila["detalleAdicional"]!="-1"))
				{
					if($condWhere=="")
						$condWhere="e.detalleEspecialidad='".$fila["detalleAdicional"]."'";	
					else
						$condWhere.=" and e.detalleEspecialidad='".$fila["detalleAdicional"]."'";	
				}
	
	
				if($listaDespachosAtributos!="")
				{
					if($condWhere=="")
						$condWhere="d.id__17_tablaDinamica in(".$listaDespachosAtributos.")";	
					else
						$condWhere.=" and d.id__17_tablaDinamica in(".$listaDespachosAtributos.")";	
				}*/
	
				$consulta="select unidad,o.codigoUnidad,idOrganigrama,codigoFuncional,o.descripcion,institucion,codCentroCosto,o.unidadPadre,codigoIndividual,claveDepartamental,status,
							(case status when '1'  then 'Activo' when '0' then 'Inactivo' when '2' then 'Concentrador' end) as activo,
							(SELECT nombreCategoria FROM 817_categoriasUnidades WHERE idCategoriaUnidadOrganigrama=o.institucion) as tipoUnidad,
							o.institucion as idTipoUnidad
							from 817_organigrama o, _17_tablaDinamica d,_1284_tablaDinamica e where d.claveRegistro=o.codigoDepto and 
							e.idReferencia=d.id__17_tablaDinamica and ".($condWhere!=""?($condWhere." and "):"").
							" institucion in (".$listaTiposDespacho.") order by  codigoFuncional";
			}
			
			$arrDespachos=($con->obtenerFilasJSON($consulta));
			
			return '{"resultado":"1","totalRegistros":"'.$con->filasAfectadas.'","registros":'.$arrDespachos.'}';
		
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","totalRegistros":"0","registros":[],"msgError":"'.cv($e->getMessage()).'"}';

		}
	}
	
	function registroDespacho($datosRegistro,$token)
	{
		global $con;
		
		$aResultado=validarTokenServicio($token,(__FUNCTION__),basename((__FILE__)),"XML");
		
		
		if($aResultado[0]==0)
		{
			return '{"resultado":"0","totalRegistros":"0","registros":[],"msgError":"'.$aResultado[1].'"}';

		}
		try
		{
			$oQuery=json_decode($datosRegistro);
			if(!$oQuery)
			{
				return '{"resultado":"0","totalRegistros":"0","registros":[],"msgError":"Par&aacute;metros de consulta NO v&aacute;lidos"}';
	
			}
			
			
			
			$arrDocumentosReferencia=array();
			
			
			foreach($oQuery->arrDespachos as $d)
			{
				
				if(!isset($d->nombreDespacho)  ||($d->nombreDespacho==""))
				{
					return '{"resultado":"0","totalRegistros":"0","registros":[],"msgError":"El atributo \'nombreDespacho\' NO es v&aacute;lido"}';
				}
				
				
				if(!isset($d->claveDespacho)  ||($d->claveDespacho==""))
				{
					return '{"resultado":"0","totalRegistros":"0","registros":[],"msgError":"El atributo \'claveDespacho\' NO es v&aacute;lido"}';
				}
				
				$consulta="SELECT count(*) FROM _17_tablaDinamica where claveRegistro='".($d->claveDespacho)."'";
				$nReg=$con->obtenerValor($consulta);
				if($nReg>0)
				{
					return '{"resultado":"0","totalRegistros":"0","registros":[],"msgError":"La clave \''.$d->claveDespacho.'\' del despacho \''.$d->nombreDespacho.'\' ya ha sido regsitrada previamente"}';
				}
				
				
				
				if(!isset($d->categoria)  ||(	($d->categoria!="001") && ($d->categoria!="002") && ($d->categoria!="003") ))
				{
					return '{"resultado":"0","totalRegistros":"0","registros":[],"msgError":"El atributo \'categoria\' NO es v&aacute;lido"}';
				}
				
				if(!isset($d->fungeSecretaria)  ||(	($d->fungeSecretaria!="1") && ($d->fungeSecretaria!="0") ))
				{
					return '{"resultado":"0","totalRegistros":"0","registros":[],"msgError":"El atributo \'fungeSecretaria\' NO es v&aacute;lido"}';
				}
				
				if(!isset($d->esDespacho)  ||(	($d->esDespacho!="1") && ($d->esDespacho!="0") ))
				{
					return '{"resultado":"0","totalRegistros":"0","registros":[],"msgError":"El atributo \'esDespacho\' NO es v&aacute;lido"}';
				}
				
				
				if(isset($d->especialidad))
				{
					foreach($d->especialidad as $e)
					{
						$consulta="SELECT count(*) FROM _637_tablaDinamica where id__637_tablaDinamica=".($e->especialidad==""?-1:$e->especialidad);
						$nReg=$con->obtenerValor($consulta);
						if($nReg==0)
						{
							return '{"resultado":"0","totalRegistros":"0","registros":[],"msgError":"El atributo \'especialidad\' NO es v&aacute;lido"}';
						}
						
					}
				}
				
				if(isset($d->atributosDespacho))
				{
					foreach($d->atributosDespacho as $d)
					{
						$consulta="SELECT count(*) FROM _636_tablaDinamica where id__636_tablaDinamica=".($d->atributo==""?-1:$d->atributo);
						$nReg=$con->obtenerValor($consulta);
						if($nReg==0)
						{
							return '{"resultado":"0","totalRegistros":"0","registros":[],"msgError":"El atributo \'atributosDespacho\' NO es v&aacute;lido"}';
						}
						
					}
				}
				
				if(isset($d->tiposProcesoCompetencia))
				{
					foreach($d->tiposProcesoCompetencia as $t)
					{
						$consulta="SELECT count(*) FROM _625_tablaDinamica where id__625_tablaDinamica=".($t->tipoProceso==""?-1:$t->tipoProceso);
						$nReg=$con->obtenerValor($consulta);
						if($nReg==0)
						{
							return '{"resultado":"0","totalRegistros":"0","registros":[],"msgError":"El atributo \'tiposProcesoCompetencia\' NO es v&aacute;lido"}';
						}
						
					}
				}
				
				
				if(isset($d->datosDomiciliarios))
				{
					$consulta="SELECT COUNT(*) FROM 820_estados WHERE cveEstado='".$d->datosDomiciliarios->departamento."'";
					$nReg=$con->obtenerValor($consulta);
					
					if($nReg==0)
					{
						return '{"resultado":"0","totalRegistros":"0","registros":[],"msgError":"El departamento de los datos domiciliarios NO es v&aacute;lido"}';
					}
					
					$consulta="SELECT COUNT(*) FROM 821_municipios WHERE cveMunicipio='".$d->datosDomiciliarios->municipio."'";
					$nReg=$con->obtenerValor($consulta);
					
					if($nReg==0)
					{
						return '{"resultado":"0","totalRegistros":"0","registros":[],"msgError":"La ciudad de los datos domiciliarios NO es v&aacute;lido"}';
					}
					
					
					if(isset($d->datosDomiciliarios->correoElectronico))
					{
						foreach($d->datosDomiciliarios->correoElectronico as $c)
						{
							
							if(!validarCorreo($c->mail))
							{
								
								
								return '{"resultado":"0","totalRegistros":"0","registros":[],"msgError":"La direcci&oacute;n de correo \''.$c->mail.'\' NO es v&aacute;lida"}';
								
							}
						}
					}
					
					
					if(isset($d->datosDomiciliarios->telefonos))
					{
						foreach($d->datosDomiciliarios->telefonos as $t)
						{
							if(strlen($t->numero)!=10)
							{
								return '{"resultado":"0","totalRegistros":"0","registros":[],"msgError":"El n&uacute;mero de tel&eacute;fono debe ser de 10 d&iacute;gitos"}';
							}
						}
					}
					
				}
				
			}
			
			
			foreach($oQuery->arrDespachos as $d)
			{
				
				$tipoUnidad=-1;
				switch($d->categoria)
				{
					case "001":
						$tipoUnidad=9;
					break;
					case "002":
						$tipoUnidad=19;
					break;
					case "003":
						$tipoUnidad=21;
					break;
				}
				
				$consulta="SELECT count(*) FROM _17_tablaDinamica where claveRegistro='".($d->claveDespacho)."'";
				$nReg=$con->obtenerValor($consulta);
				if($nReg>0)
				{
					return '{"resultado":"0","totalRegistros":"0","registros":[],"msgError":"La clave \''.$d->claveDespacho.'\' del despacho \''.$d->nombreDespacho.'\' ya ha sido regsitrada previamente"}';
				}
				
				$arrValores=array();
				$arrValores["nombreUnidad"]=$d->nombreDespacho;
				$arrValores["idProcesoPadre"]="-1";
				$arrValores["claveRegistro"]=$d->claveDespacho;
				$arrValores["unidadPadre"]=$d->cveUnidadPadre;
				$arrValores["tipoUnidad"]=$tipoUnidad;
				$arrValores["jurisdiccion"]="-1";
				$arrValores["competencia"]="-1";
				$arrValores["fungeSecretaria"]=$d->fungeSecretaria;
				$arrValores["esDespacho"]=$d->esDespacho;

				
					
				$idRegistroRadicacion=crearInstanciaRegistroFormulario(17,-1,1,$arrValores,$arrDocumentosReferencia,-1,0,"");
				
				
				$query=array();
				$x=0;
				$query[$x]="begin";
				$x++;
				
				if(isset($d->especialidad))
				{
					foreach($d->especialidad as $e)
					{
						
						$query[$x]="INSERT _1284_tablaDinamica(idReferencia,fechaCreacion,responsable,idEstado,especialidad)
									VALUES(".$idRegistroRadicacion.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",1,".$e->especialidad.")";
						$x++;
					}
				}
				
				if(isset($d->atributosDespacho))
				{
					foreach($d->atributosDespacho as $d)
					{
						$query[$x]="INSERT INTO _17_gridAtributosDespacho(idReferencia,idAtributoDespacho) VALUES(".$idRegistroRadicacion.",".$d->atributo.")";
						$x++;
						
					}
				}
				
				if(isset($d->tiposProcesoCompetencia))
				{
					foreach($d->tiposProcesoCompetencia as $t)
					{
						$query[$x]="INSERT INTO _17_gridTiposProceso(idReferencia,tipoProceso) VALUES(".$idRegistroRadicacion.",".$t->tipoProceso.")";
						$x++;						
					}
				}
				
				if(isset($d->datosDomiciliarios))
				{
					$arrValores=array();
					$arrValores["calle"]=$d->datosDomiciliarios->domicilio;
					$arrValores["departamentos"]=$d->datosDomiciliarios->departamento;
					$arrValores["municipio"]=$d->datosDomiciliarios->municipio;
					$arrValores["latitud"]=$d->datosDomiciliarios->latitud;
					$arrValores["longitud"]=$d->datosDomiciliarios->longitud;
					
					$idRegistroDomicilio=crearInstanciaRegistroFormulario(638,-1,1,$arrValores,$arrDocumentosReferencia,-1,0,"");

					if(isset($d->datosDomiciliarios->correoElectronico))
					{
						foreach($d->datosDomiciliarios->correoElectronico as $c)
						{
							$query[$x]="INSERT INTO _638_gridCorreo(idReferencia,email) VALUES(".$idRegistroDomicilio.",'".cv($c->mail)."')";
							$x++;
							
						}
					}
					
					
					if(isset($d->datosDomiciliarios->telefonos))
					{
						foreach($d->datosDomiciliarios->telefonos as $t)
						{
							$query[$x]="INSERT INTO _638_gridTelefono(idReferencia,numero,extension) VALUES(".$idRegistroDomicilio.",'".cv($t->numero)."','".$t->extension."')";
							$x++;
						}
					}
					
				}
				
				
				
				
				$query[$x]="commit";
				$x++;
				
				if($con->ejecutarBloque($query))
				{
					registrarUnidadOrganigrama(17,$idRegistroRadicacion,false);
				}
				
			}
			
			return '{"resultado":"1","msgError":""}';
		
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","totalRegistros":"0","registros":[],"msgError":"'.cv($e->getMessage()).'"}';

		}
	}
	
	
	function validarCorreo($mail)
	{
		$valor=$mail;
			
		$filter="/^[A-Za-z0-9\._\-]+@[A-Za-z0-9_\-]+(\.[A-Za-z]+){1,5}$/";
		if ($mail == "" ) 
			return false;
		if (preg_match($filter,$mail)==1)
			return true;
		return false;
	}
	
	class soap_serverAuditoria extends nusoap_server 
	{
		function parseRequest($headers, $data) 
		{
			
			
			$this->debug('Entering parseRequest() for data of length ' . strlen($data) . ' headers:');
			$this->appendDebug($this->varDump($headers));
			if (!isset($headers['content-type'])) {
				$this->setError('Request not of type text/xml (no content-type header)');
				return false;
			}
			if (!strstr($headers['content-type'], 'text/xml')) {
				$this->setError('Request not of type text/xml');
				return false;
			}
			if (strpos($headers['content-type'], '=')) {
				$enc = str_replace('"', '', substr(strstr($headers["content-type"], '='), 1));
				$this->debug('Got response encoding: ' . $enc);
				if(preg_match('/^(ISO-8859-1|US-ASCII|UTF-8)$/i',$enc)){
					$this->xml_encoding = strtoupper($enc);
				} else {
					$this->xml_encoding = 'US-ASCII';
				}
			} else {
				// should be US-ASCII for HTTP 1.0 or ISO-8859-1 for HTTP 1.1
				$this->xml_encoding = 'ISO-8859-1';
			}
			$this->debug('Use encoding: ' . $this->xml_encoding . ' when creating nusoap_parser');
			// parse response, get soap parser obj
			$parser = new nusoap_parser(utf8_encode($data),$this->xml_encoding,'',$this->decode_utf8);
			// parser debug
			$this->debug("parser debug: \n".$parser->getDebug());
			// if fault occurred during message parsing
			if($err = $parser->getError())
			{
				$this->result = 'fault: error in msg parsing: '.$err;
				$this->fault('SOAP-ENV:Client',"error in msg parsing:\n".$err);
			// else successfully parsed request into soapval object
			} 
			else 
			{
				// get/set methodname
				$this->methodURI = $parser->root_struct_namespace;
				$this->methodname = $parser->root_struct_name;
				$this->debug('methodname: '.$this->methodname.' methodURI: '.$this->methodURI);
				$this->debug('calling parser->get_soapbody()');
				$this->methodparams = $parser->get_soapbody();
				// get SOAP headers
				$this->requestHeaders = $parser->getHeaders();
				// get SOAP Header
				$this->requestHeader = $parser->get_soapheader();
				// add document for doclit support
				$this->document = $parser->document;
				
				$url="../webServices/".basename((__FILE__));
				$objParams=json_encode($this->methodparams);
				
				aperturarSesionUsuario(2);
					
				guardarRegistroBitacoraSistema($url,$objParams,18,("Nombre del procedimento: ".$this->methodname));
				session_destroy();
				
			}
		 }
	}
	
	$arrParam=array();
	$server = new soap_serverAuditoria;
	$ns=$urlSitio."/webServices";
	$server->configurewsdl('ApplicationServices',$ns);
	$server->wsdl->schematargetnamespace=$ns;
	$server->register('obtenerExpedienteElectronico',array('cup'=>'xsd:string','token'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('registrarUsuarioSistema',array('oUsuario'=>'xsd:string','token'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('obtenerMapaJudicial',array('parametrosQuery'=>'xsd:string','token'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('registroDespacho',array('datosRegistro'=>'xsd:string','token'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	
	if (isset($HTTP_RAW_POST_DATA)) 
	{
		$input = $HTTP_RAW_POST_DATA;
	}
	else 
	{
		$input = implode("rn", file('php://input'));
	}
	
	
	$server->service($input);

?>