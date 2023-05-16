<?php session_start();
	include_once("conexionBD.php");
	include_once("utiles.php");
	include_once("sgjp/libreriaFuncionesSicore.php");
	include_once("PDFMerger.php");
	

	
	;
	
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	$lenguaje=$_SESSION["leng"];
	
	switch($funcion)
	{
		case 1:
			obtenerCarpetasUsuario();
		break;
		case 2:
			obtenerPromocionesUsuario();
		break;
		case 3:
			registrarPromocionUsuario();
		break;
		case 4:
			enviarPromocionJuzgado();
		break;
		case 5:
			crearCuentaAccesoUsuario();
		break;
		case 6:
			obtenerJuzgadosMateria();
		break;
		case 7:
			obtenerExpedienteJuzgados();
		break;
		case 8:
			obtenerParticipantesExpediente();
		break;
		case 9:
			guardarSolicitudAccesoExpediente();
		break;
		case 10:
			obtenerExpedientesAsociadosUsuario();
		break;
		case 11:
			generarDocumentoSolicitudAcceso();
		break;
		case 12:
			enviarSolicitudAccesoJuzgado();
		break;
		case 13:
			recuperarDatosAcceso();
		break;
		case 14:
			obtenerRegistrosSeguimiento();
		break;
		case 15:
			obtenerAudienciasExpediente();
		break;
		case 16:
			obtenerDatosAccesoVideoGrabacion();
		break;
		case 17:
			registrarFirmaCertificacionProcesoModuloGlobal();
		break;
		case 18:
			generarDocumentoImpresionUnico();
		break;
		case 19:
			obtenerResultadoBusquedaJuzgado();
		break;
		case 20:
			registrarParticipanteActividad();
		break;
		
		
		case 100:
			obtenerUsuariosAccesoSicoreEvento();
		break;
		case 101:
			registrarUsuarioAccesoSicoreEvento();
		break;
		case 102:
			cambiarSituacionAccesoSicore();
		break;
		case 103:
			reintentarRegistroAcceso();
		break;
		
		case 200:
			registrarMarcaDocumentoPendienteFirma();
		break;
		case 201:
			obtenerRegistrosDocumentosPendientesFirma();
		break;
		case 202:
			obtenerDocumentosGeneradosExpediente();
		break;
		case 203:
			buscarDuplicidadBilleteDeposito();
		break;
		case 204:
			registrarModificacionConfiguracionPublicacion();
		break;
		case 205:
			obtenerSolicitudesLAMVLV();
		break;
		case 206:
			enviarSolicitudUGJ();
		break;
		case 207:
			crearNuevoUsuarioSIGUE();
		break;
		case 208:
			obtenerInformacionExpedienteJuzgado();
		break;
		case 209:
			obtenerAudienciasVirtualesExpediente();
		break;
		case 210:
			generarCodigoAccesoAudienciaVirtual();
		break;

	}
	
	
	function obtenerCarpetasUsuario()
	{
		global $con;
		
		$anio=$_POST["anio"];
		$noExpediente=$_POST["noExpediente"];
		$compNoExpediente="";
		if($noExpediente!="")
			$compNoExpediente.=" and carpetaAdministrativa like '%".$noExpediente."%'";
		$arrRegistros="";
		$consulta="SELECT DISTINCT m.claveMateria,m.materia,u.idUsuario,m.accesoVideograbaciones FROM 7006_usuariosVSCarpetasAdministrativas u,_480_tablaDinamica m 
					WHERE idUsuario=".$_SESSION["idUsr"]." and u.situacion=1 ";

		if($anio!=0)
		{
			$consulta.=" and anioExpediente=".$anio;
		}

		$consulta.=" ".$compNoExpediente." AND m.claveMateria=u.cveMateria ORDER BY materia";
		$rMateria=$con->obtenerFilas($consulta);
		while($fMateria=mysql_fetch_row($rMateria))
		{
			$arrJuzgados="";
			
			$consulta="SELECT DISTINCT unidadGestion FROM 7006_usuariosVSCarpetasAdministrativas WHERE idUsuario=".$fMateria[2].
					" AND cveMateria='".$fMateria[0]."'";
			$rJuzgado=$con->obtenerFilas($consulta);
			while($fJuzgado=mysql_fetch_row($rJuzgado))
			{
				$nombreJuzgado="";
				$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$fJuzgado[0]."'";
				$fNombreJuzgado=$con->obtenerPrimeraFila($consulta);
				if($fNombreJuzgado)
				{
					$nombreJuzgado=$fNombreJuzgado[0];
				}
				else
				{
					$nombreJuzgado=obtenerNombreJuzgadoWS($fJuzgado[0],$fMateria[0]);
				}
				
				
				$arrExpedientes="";
				$oExpediente="";
				$consulta="SELECT idCarpetaAdministrativa,carpetaAdministrativa FROM 7006_usuariosVSCarpetasAdministrativas u WHERE 
						idUsuario=".$fMateria[2]." and u.situacion=1 ";
						
				if($anio!=0)
				{
					$consulta.=" AND  anioExpediente=".$anio;
				}
				$consulta.="  ".$compNoExpediente." and cveMateria='".$fMateria[0].
						"' AND unidadGestion='".$fJuzgado[0]."' ORDER BY carpetaAdministrativa";
				$rExpedientes=$con->obtenerFilas($consulta);
				while($fExpediente=mysql_fetch_row($rExpedientes))
				{
					$oExpediente='{"icon":"../images/s.gif","id":"e_'.$fExpediente[0].'","text":"'.$fExpediente[1].'","expediente":"'.$fExpediente[1].
								'","idExpediente":"'.$fExpediente[0].'","tipo":"3","leaf":true,expanded:true,"unidadGestion":"'.$fJuzgado[0].
								'","idMateria":"'.$fMateria[0].'","accesoVideograbaciones":"'.($fMateria[3]!=1?0:1).'"}';
					if($arrExpedientes=="")
						$arrExpedientes=$oExpediente;
					else
						$arrExpedientes.=",".$oExpediente;
				}
				
				
				
				$oJuzgado='{"icon":"../images/s.gif","id":"'.$fJuzgado[0].'","tipo":"2","juzgado":"'.cv(mb_strtoupper($nombreJuzgado)).'","text":"<b>'.cv(mb_strtoupper($nombreJuzgado)).'</b>","leaf":false,"children":['.$arrExpedientes.'],expanded:true}';
				if($arrJuzgados=="")
				{
					$arrJuzgados=$oJuzgado;
				}
				else
					$arrJuzgados.=",".$oJuzgado;
			}
			
			
			
			$o='{"icon":"../images/s.gif","id":"'.$fMateria[0].'","materia":"'.cv($fMateria[1]).'","tipo":"1","text":"<span style=\'color:#900\'><b>Materia:</b></span> '.cv($fMateria[1]).'","leaf":false,"children":['.$arrJuzgados.'],expanded:true}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		
		echo '['.$arrRegistros.']';
	}
	
	function obtenerPromocionesUsuario()
	{
		global $con;
		$iE=bD($_POST["iE"]);
		$nE=bD($_POST["nE"]);
		$cveMateria=bD($_POST["cM"]);
		$cveUnidadGestion=bD($_POST["cG"]);
		
		$consulta="SELECT idRegistro,expediente,fechaRegistro,asunto,situacionPromocion,fechaRecepcionJuzgado,
					(SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=p.idDocumentoPromocion)as nombreDocumentoPromocion,
					idDocumentoPromocion,fechaRespuesta,idDocumentoRespuesta,
					(SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=p.idDocumentoRespuesta)as nombreDocumentoRespuesta,
					cveUnidadGestion AS juzgado,folioRegistroJuzgado FROM 7071_promocionesRegistradasUsuario p
					WHERE idUsuarioRegistro=".$_SESSION["idUsr"]." AND idExpediente=".$iE."  AND cveMateria='".$cveMateria.
					"' AND cveUnidadGestion='".$cveUnidadGestion."' order by fechaRegistro desc";
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
		
		
		
	}
	
	function registrarPromocionUsuario()
	{
		global $con;
		global $baseDir;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$archivoDestino=$baseDir."/archivosTemporales/".$obj->idDocumento;
		if(file_exists($archivoDestino."_doc"))
		{
			$obj->idDocumento.="_doc";
			$arrDocumento=explode(".",$obj->nombreDocumento);
			$nDomento="";
			for($x=0;$x<sizeof($arrDocumento)-1;$x++)
			{
				$nDomento.=$arrDocumento[$x];
			}
			
			$nDomento.=".pdf";
			$obj->nombreDocumento=$nDomento;
		}
		$idDocumento=registrarDocumentoServidorRepositorio($obj->idDocumento,$obj->nombreDocumento,1);
		
		if(file_exists($archivoDestino))
			@unlink($archivoDestino);
		if(file_exists($archivoDestino."_doc"))
			@unlink($archivoDestino."_doc");
		
		$consulta="INSERT INTO 7071_promocionesRegistradasUsuario(expediente,idExpediente,fechaRegistro,idUsuarioRegistro,asunto,
									situacionPromocion,idDocumentoPromocion,cveUnidadGestion,cveMateria)
									VALUES('".$obj->expediente."',".$obj->idExpediente.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".cv($obj->asunto).
									"',1,".$idDocumento.",'".$obj->cveUnidadGestion."','".$obj->cveMateria."')";
		if($con->ejecutarConsulta($consulta))
		{
			echo "1|".$con->obtenerUltimoID();
		}
	}
	
	function enviarPromocionJuzgado()
	{
		global $con;
		$idPromocion=bD($_POST["iP"]);
		
		$consulta="SELECT * FROM 7071_promocionesRegistradasUsuario WHERE idRegistro=".$idPromocion;
		$fPromo=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$fPromo["idDocumentoPromocion"];
		$nombreDocumentoPromocion=$con->obtenerValor($consulta);
		$archivoOrigen=obtenerRutaDocumento($fPromo["idDocumentoPromocion"]);
		$documentoPromocion=bE(leerContenidoArchivo($archivoOrigen));
		$documentoPromocionPKCS7="";
		if(file_exists($archivoOrigen.".pkcs7"))
		{
			$documentoPromocionPKCS7=bE(leerContenidoArchivo($archivoOrigen.".pkcs7"));
		}
		$consulta="SELECT idUsuarioExpediente,idFiguraExpediente FROM 7006_usuariosVSCarpetasAdministrativas WHERE idUsuario=".
				$fPromo["idUsuarioRegistro"]." AND cveMateria='".$fPromo["cveMateria"]."' AND unidadGestion='".$fPromo["cveUnidadGestion"].
				"' AND idCarpetaAdministrativa='".$fPromo["idExpediente"]."'";
		$fInfoPromovente=$con->obtenerPrimeraFila($consulta);
		
		
		$cadObj='{"expediente":"'.$fPromo["expediente"].'","idExpediente":"'.$fPromo["idExpediente"].'","asunto":"'.cv($fPromo["asunto"]).
				'","unidadGestion":"'.$fPromo["cveUnidadGestion"].'","materia":"'.$fPromo["cveMateria"].'","promovente":"'.$fInfoPromovente[0].
				'","figuraPromovente":"'.$fInfoPromovente[1].'","nombreDocumentoPromocion":"'.cv($nombreDocumentoPromocion).'","documentoPromocion":"'.
				$documentoPromocion.'","idUsuarioRegistro":"'.$fPromo["idUsuarioRegistro"].'","documentoPromocionPKCS7":"'.$documentoPromocionPKCS7.
				'","idPromocion":"'.$idPromocion.'"}';
		
		$fDatosServidor=obtenerURLComunicacionServidorMateria($fPromo["cveMateria"]);
		$url=$fDatosServidor[0].($fDatosServidor[1]!=""?":".$fDatosServidor[1]:"");

		
		
		$client = new nusoap_client("http://".$url."/webServices/wsInterconexionSistemasBPM.php?wsdl","wsdl");
		$parametros=array();
		$parametros["cadObj"]=$cadObj;
		
		$response = $client->call("registrarPromocion", $parametros);

		$oResp=json_decode($response);
		
		if($oResp->resultado==1)
		{
			$consulta="UPDATE 7071_promocionesRegistradasUsuario SET fechaRecepcionJuzgado='".$oResp->fechaRecepcion.
						"',situacionPromocion=2,folioRegistroJuzgado='".$oResp->folioRegistro."' WHERE idRegistro=".$idPromocion;
			if($con->ejecutarConsulta($consulta))	
			{
				echo "1|".$oResp->fechaRecepcion."|".$oResp->folioRegistro;
			}
		}
		else
		{
			echo $oResp->mensaje;
		}
		
		
	}
	
	function crearCuentaAccesoUsuario()
	{
		global $con;
		global $versionLatis;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$consulta="SELECT * FROM 800_usuarios WHERE Login='".$obj->mail."'";
		$fMail=$con->obtenerPrimeraFila($consulta);
		if($fMail)
		{
			echo "<br>La direcci&oacute;n de correo electr&oacute;nico ingresada ya ha sido registrada anteriormente";
			return;
		}
		$passwd=generarPassword();
		$consulta="select HEX(AES_ENCRYPT('".$passwd."', '".bD($versionLatis)."'))";
		$passwd=$con->obtenerValor($consulta);
		$idUsuario=crearBaseUsuario($obj->apPaterno,$obj->apMaterno,$obj->nombre,$obj->mail,"0000","","-1000,152",$obj->mail,$passwd);
		
		$query=array();
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="UPDATE 803_direcciones SET Calle='".cv($obj->calle)."',Numero='".cv($obj->noExt)."',Colonia='".cv($obj->colonia).
				"',CP=".($obj->cp==''?"NULL":$obj->cp).",Estado='".$obj->estado."',Municipio=".$obj->municipio.
				",NumeroInt='".cv($obj->noInt)."' WHERE idUsuario=".$idUsuario." and Tipo=1";
		$x++;
		$query[$x]="UPDATE 802_identifica SET fechaNacimiento='".$obj->fechaNacimiento."',Genero=".$obj->genero.
				",CURP='".cv($obj->curp)."',cedulaProf='".cv($obj->cedulaProfesional)."',tipoIdentificacion=".($obj->tipoIdentificacion==""?"NULL":$obj->tipoIdentificacion).
				",noIdentificacion=".($obj->noIdentificacion==""?"NULL":"'".cv($obj->noIdentificacion)."'").",profesion='".cv($obj->profesion)."',nombreDespacho='".cv($obj->nombreDespacho)."'
				WHERE idUsuario=".$idUsuario;
		$x++;
		
		foreach($obj->telefonos as $t)
		{
			$query[$x]="INSERT INTO 804_telefonos(Lada,Numero,Extension,Tipo,idUsuario)
						VALUES('".$t->lada."','".$t->numero."','".$t->extension."',".$t->tipoTelefono.",".$idUsuario.")";
			$x++;
		}
		
		$query[$x]="commit";
		$x++;
		if($con->ejecutarBloque($query))
		{
			$consulta="SELECT Login,AES_DECRYPT(UNHEX(Password), '".bD($versionLatis)."'),Nombre FROM 800_usuarios WHERE idUsuario=".$idUsuario;
			$fUsr=$con->obtenerPrimeraFila($consulta);
			
			$arrParam["login"]=$fUsr[0];
			$arrParam["password"]=$fUsr[1];
			$arrParam["nombreUsuario"]=$fUsr[2];
			$arrParam["idUsuario"]=$idUsuario;
			$arrParam["idActivacion"]=bE("idUsuario:".$idUsuario);
			
			
			if(enviarMensajeEnvio(17,$arrParam,"sendMensajeEnvioGmailJuzgado"))
			{
				echo "1|";
			}
		}
		
	}
	
	function obtenerJuzgadosMateria()
	{
		global $con;
		$cveMateria=$_POST["cveMateria"];
		$fDatosServidor=obtenerURLComunicacionServidorMateria($cveMateria);
		$url=$fDatosServidor[0].($fDatosServidor[1]!=""?":".$fDatosServidor[1]:"");
		$client = new nusoap_client("http://".$url."/webServices/wsInterconexionSistemasBPM.php?wsdl","wsdl");
		$parametros=array();
		$parametros["cveMateria"]=$cveMateria;
		
		$response = $client->call("obtenerJuzgadosMateria", $parametros);
		

		$oResp=json_decode(utf8_encode($response));
		
		if($oResp->resultado==1)
		{
			$aJuzgado="";
			foreach($oResp->arrJuzgados as $j)
			{
				$oJuzgado="['".$j->claveUnidad."','".cv($j->nombreUnidad)."']";
				if($aJuzgado=="")
					$aJuzgado=$oJuzgado;
				else
					$aJuzgado.=",".$oJuzgado;
					
			}
			echo "1|[".$aJuzgado."]|[".bD($oResp->arrFiguras)."]";
			return;
		}
		
		echo $oResp->mensaje;
		
	}
	
	function obtenerExpedienteJuzgados()
	{
		global $con;
		$cveMateria=$_POST["cveMateria"];
		$cveJuzgado=$_POST["cveJuzgado"];
		$anio=$_POST["anio"];
		$fDatosServidor=obtenerURLComunicacionServidorMateria($cveMateria);
		$url=$fDatosServidor[0].($fDatosServidor[1]!=""?":".$fDatosServidor[1]:"");
		$client = new nusoap_client("http://".$url."/webServices/wsInterconexionSistemasBPM.php?wsdl","wsdl");

		$parametros=array();
		$parametros["cveJuzgado"]=$cveJuzgado;
		$parametros["anio"]=$anio;
		
		$response = $client->call("obtenerExpedientesJuzgado", $parametros);

		$oResp=json_decode(utf8_encode($response));
		$arrExpedientes="";
		if($oResp->resultado==1)
		{

			foreach($oResp->arrExpedientes as $e)
			{
				$o="['".$e->idCarpeta."','".cv($e->carpetaAdministrativa)."','".cv($e->idActividad)."','']";
				if($arrExpedientes=="")
					$arrExpedientes=$o;
				else
					$arrExpedientes.=",".$o;
					
			}
			echo "1|[".$arrExpedientes."]";
			return;
		}
		
		echo $oResp->mensaje;
		
	}
	
	function obtenerParticipantesExpediente()
	{
		global $con;
		$cveMateria=$_POST["cveMateria"];
		$iC=$_POST["iC"];
		$partes=$_POST["partes"];
		
		$fDatosServidor=obtenerURLComunicacionServidorMateria($cveMateria);
		$url=$fDatosServidor[0].($fDatosServidor[1]!=""?":".$fDatosServidor[1]:"");
		$client = new nusoap_client("http://".$url."/webServices/wsInterconexionSistemasBPM.php?wsdl","wsdl");
		$parametros=array();
		$parametros["idExpediente"]=$iC;
		$parametros["figuraJuridica"]=$partes;

		$response = $client->call("obtenerParticipantesExpedientes", $parametros);
		$oResp=json_decode(utf8_encode($response));
		$arrParticipantes="";
		if($oResp->resultado==1)
		{

			foreach($oResp->arrParticipantes as $p)
			{
				$o="['".$p->idParticipante."','".cv($p->nombre)."']";
				if($arrParticipantes=="")
					$arrParticipantes=$o;
				else
					$arrParticipantes.=",".$o;
					
			}
			echo "1|[".$arrParticipantes."]";
			return;
		}
		
		echo $oResp->mensaje;
		
	}
	
	function guardarSolicitudAccesoExpediente()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$fechaInicio=date("Y-m-d H:i:s");
		$fechaVencimiento="'".date("Y-m-d H:i:s",strtotime("+6 moths",strtotime($fechaInicio)))."'";
		
		if($obj->idPaquete!=0)
		{
			$consulta="SELECT idRegistro,folioPaquete,p.totalExpedientes,
					(SELECT COUNT(*) FROM 7006_usuariosVSCarpetasAdministrativas WHERE idPaquete=p.idRegistro) AS asignados
					 FROM 7006_paquetesContratados p WHERE idRegistro=".$obj->idPaquete;
			$fDatosPaquete=$con->obtenerPrimeraFila($consulta);
			if($fDatosPaquete[2]<($fDatosPaquete[3]+1))
			{
				echo "<br>Se ha alcanzado el total de expedientes permitidos para el paquete seleccionado";
				return;
			}
		}
		else
		{
			$fechaVencimiento="NULL";
		}
		$consulta="SELECT COUNT(*) FROM 7006_usuariosVSCarpetasAdministrativas WHERE idUsuario=".$_SESSION["idUsr"].
					" AND idCarpetaAdministrativa=".$obj->expediente." AND cveMateria='".$obj->materia."'
				AND unidadGestion='".$obj->juzgado."'";
		$nReg=$con->obtenerValor($consulta);
		if($nReg>0)
		{
			echo "<br>Ya se encuentra registrada una relaci&oacute;n de acceso del expediente seleccionado";
			return;
		}
		
		$consulta="SELECT COUNT(*) FROM _17_tablaDinamica WHERE claveUnidad='".$obj->juzgado."'";
		$nReg=$con->obtenerValor($consulta);
		if($nReg==0)
			@obtenerNombreJuzgadoWS($obj->juzgado,$obj->materia);
		
		$consulta="INSERT INTO 7006_usuariosVSCarpetasAdministrativas(idUsuario,idCarpetaAdministrativa,carpetaAdministrativa,
					cveMateria,situacion,fechaSolicitud,fechaInicio,fechaVencimiento,unidadGestion,anioExpediente,
					idFiguraExpediente,lblFiguraExpediente,idDetalleFigura,lblDetalleFigura,detalleExpediente,idPaquete,
					idPersonaRelaciona,lblPersonaRelacion,idDocumentoSolicitud,folioSolicitud) values
					(".$_SESSION["idUsr"].",".$obj->expediente.",'".$obj->lblExpediente."','".$obj->materia."',2,'".date("Y-m-d H:i:s")."',
					'".$fechaInicio."',".$fechaVencimiento.",'".$obj->juzgado."',".$obj->anio.",".$obj->figuraJuridica.",'".cv($obj->lblFiguraExpediente)."',
					".($obj->detalleFiguraJuridica==""?"NULL":$obj->detalleFiguraJuridica).",'".cv($obj->lblDetalleFigura)."','".($obj->detalleExpediente)."',
					".$obj->idPaquete.",".($obj->relacionadoCon==""?"NULL":$obj->relacionadoCon).",'".cv($obj->lblRelacionadoCon).
					"',".$obj->idDocumentoSolicitud.",'".$obj->folioSICORE."')";
		if($con->ejecutarConsulta($consulta))
		{
			echo "1|".$con->obtenerUltimoID();
		}
	}
	
	function obtenerExpedientesAsociadosUsuario()
	{
		global $con;
		$cadCondWhere="1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		$cadCondWhere=str_replace("like '","like '%",$cadCondWhere);
		$cadCondWhere=str_replace("situacion ","u.situacion ",$cadCondWhere);
		
		$consulta="SELECT idCarpetaAdministrativa,carpetaAdministrativa,cveMateria,fechaVencimiento,u.situacion,upper(nombreUnidad) as nombreUnidad,
				anioExpediente,lblFiguraExpediente AS figuraExpediente,lblDetalleFigura,detalleExpediente,lblPersonaRelacion,
				fechaRespuesta,fechaSolicitud, pq.folioPaquete as noPaquete,u.idRegistro,folioSolicitud,idDocumentoSolicitud,
				(SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=u.idDocumentoSolicitud) as nombreDocumentoSolicitud FROM 
				7006_usuariosVSCarpetasAdministrativas u,_17_tablaDinamica j,7006_paquetesContratados pq WHERE u.idUsuario=".$_SESSION["idUsr"]."
				AND j.claveUnidad=u.unidadGestion AND pq.idRegistro=u.idPaquete and ".$cadCondWhere." order by fechaSolicitud desc";	

		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	}
	
	function generarDocumentoSolicitudAcceso()
	{
		global $con;
		$obj=json_decode($_POST["cadObj"]);
		
		$consulta="SELECT idFormulario FROM 900_formularios WHERE categoriaFormulario=1";
		$idFormulario=$con->obtenerValor($consulta);
		
		$consulta="SELECT funcionGeneradoraDocumentos FROM _".$idFormulario."_tablaDinamica WHERE claveMateria='".$obj->cveMateria."'";
		$funcionGeneradoraDocumentos=$con->obtenerValor($consulta);
		if($funcionGeneradoraDocumentos=="")
		{
			echo "<br>NO se ha configurado una funci&oacute;n de generaci&oacute;n de documento de solicitud de acceso para la materia";
			return;
		}
		$arrResp=array();
		eval('$arrResp='.$funcionGeneradoraDocumentos.'($obj,$obj->asociarDocumento==1);');
		echo "1|".$arrResp[0]."|".$arrResp[1];
		
	}
	
	function enviarSolicitudAccesoJuzgado()
	{
		global $con;
		$idRegistro=bD($_POST["iR"]);
		
		$consulta="SELECT * FROM 7006_usuariosVSCarpetasAdministrativas WHERE idRegistro=".$idRegistro;
		$fPromo=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$fPromo["idDocumentoSolicitud"];
		$nombreDocumento=$con->obtenerValor($consulta);
		$archivoOrigen=obtenerRutaDocumento($fPromo["idDocumentoSolicitud"]);
		$documento=bE(leerContenidoArchivo($archivoOrigen));
		$documentoPKCS7="";
		if(file_exists($archivoOrigen.".pkcs7"))
		{
			$documentoPKCS7=bE(leerContenidoArchivo($archivoOrigen.".pkcs7"));
		}
		
		$idUsuarioExpediente=-1;
		
		$consulta="SELECT idFormulario FROM 900_formularios WHERE categoriaFormulario=1";
		$idFormulario=$con->obtenerValor($consulta);
		
		$consulta="SELECT ipServidor,promocioneFirmadas,envioSolicitudDigital FROM _".$idFormulario."_tablaDinamica WHERE claveMateria='".$fPromo["cveMateria"]."'";
		$fMateria=$con->obtenerPrimeraFila($consulta);
		$ipServidor=$fMateria[0];
		if($fMateria[2]==0)
		{
			$documento="";
			$documentoPKCS7="";
		}
		
		$consulta="SELECT claveMateria FROM _".$idFormulario."_tablaDinamica WHERE ipServidor='".$ipServidor."'";
		$listaMaterias=$con->obtenerListaValores($consulta,"'");
		if($listaMaterias=="")
			$listaMaterias=-1;
		
		$consulta="SELECT idUsuarioExpediente FROM 7006_usuariosVSCarpetasAdministrativas WHERE idUsuario=".$fPromo["idUsuario"].
				" AND cveMateria IN(".$listaMaterias.") AND idUsuarioExpediente IS NOT NULL";		
		$idUsuarioExpediente=$con->obtenerValor($consulta);
		if($idUsuarioExpediente=="")
			$idUsuarioExpediente=-1;
			
		$fDatosServidor=obtenerURLComunicacionServidorMateria($fPromo["cveMateria"]);
		$url=$fDatosServidor[0].($fDatosServidor[1]!=""?":".$fDatosServidor[1]:"");
		$client = new nusoap_client("http://".$url."/webServices/wsInterconexionSistemasBPM.php?wsdl","wsdl");
		
		$consulta="SELECT Nom AS nombre,Paterno AS apPaterno,Materno AS apMaterno,Genero,CURP,RFC,tipoIdentificacion,cedulaProf,fechaNacimiento 
				FROM 802_identifica WHERE idUsuario=".$fPromo["idUsuario"];
	
		$oIdentifica=utf8_encode($con->obtenerFilasJSON($consulta));		
		
		$consulta="SELECT Mail FROM 805_mails WHERE idUsuario=".$fPromo["idUsuario"];		
		$oMails=utf8_encode($con->obtenerFilasJSON($consulta));
		
		$consulta="SELECT Lada,Numero,Extension,Tipo FROM 804_telefonos WHERE idUsuario=".$fPromo["idUsuario"];
		$oTelefonos=utf8_encode($con->obtenerFilasJSON($consulta));
		
		$consulta="SELECT Calle,Numero,NumeroInt,Colonia,CP,Estado,Municipio FROM 803_direcciones WHERE idUsuario=".$fPromo["idUsuario"]." AND Tipo=1";
		$oDomicilio=utf8_encode($con->obtenerFilasJSON($consulta));
		$cadObj="";
		
		if($idUsuarioExpediente==-1)
		{
			$cadObj='{"expediente":"'.$fPromo["carpetaAdministrativa"].'","idExpediente":"'.$fPromo["idCarpetaAdministrativa"].
					'","unidadGestion":"'.$fPromo["unidadGestion"].'","materia":"'.$fPromo["cveMateria"].'",
					"idFiguraJuridica":"'.$fPromo["idFiguraExpediente"].'","nombreDocumento":"'.cv($nombreDocumento).'","documento":"'.
					$documento.'","idSolicitante":"'.$fPromo["idUsuario"].'","documentoPKCS7":"'.$documentoPKCS7.
					'","idRegistro":"'.$idRegistro.'","folioSolicitud":"'.$fPromo["folioSolicitud"].
					'","detalleFigura":"'.$fPromo["idDetalleFigura"].'","relacionadoCon":"'.
					$fPromo["idPersonaRelaciona"].'","idUsuarioExpediente":"'.$idUsuarioExpediente.'",
					"oIdentifica":'.$oIdentifica.',"mails":'.$oMails.',"telefonos":'.$oTelefonos.',"domicilio":'.$oDomicilio.'}';
		}
		else
		{
			$cadObj='{"expediente":"'.$fPromo["carpetaAdministrativa"].'","idExpediente":"'.$fPromo["idCarpetaAdministrativa"].
					'","unidadGestion":"'.$fPromo["unidadGestion"].'","materia":"'.$fPromo["cveMateria"].'",
					"idFiguraJuridica":"'.$fPromo["idFiguraExpediente"].'","nombreDocumento":"'.cv($nombreDocumento).'","documento":"'.
					$documento.'","idSolicitante":"'.$fPromo["idUsuario"].'","documentoPKCS7":"'.$documentoPKCS7.
					'","idRegistro":"'.$idRegistro.'","folioSolicitud":"'.$fPromo["folioSolicitud"].
					'","detalleFigura":"'.$fPromo["idDetalleFigura"].'","relacionadoCon":"'.
					$fPromo["idPersonaRelaciona"].'","idUsuarioExpediente":"'.$idUsuarioExpediente.'"}';
		}
		
		$parametros=array();
		$parametros["cadObj"]=$cadObj;
		
		$response = $client->call("registrarSolicitudAcceso", $parametros);

		$oResp=json_decode(str_replace("\\","\\\\",$response));

		if($oResp->resultado==1)
		{
			$consulta="UPDATE 7006_usuariosVSCarpetasAdministrativas SET fechaRecepcionJuzgado='".$oResp->fechaRecepcion.
						"',situacion=3,idUsuarioExpediente=".$oResp->idUsuarioExpediente." WHERE idRegistro=".$idRegistro;
			if($con->ejecutarConsulta($consulta))	
			{
				echo "1|".$oResp->fechaRecepcion;
			}
		}
		else
		{
			echo $oResp->mensaje;
		}
		
		
	}
	
	function recuperarDatosAcceso()
	{
		global $con;
		global $versionLatis;
		$mail=$_POST["mail"];
		$consulta="SELECT idUsuario FROM 805_mails WHERE Mail='".cv($mail)."' ORDER BY idMail DESC";
		$idUsuario=$con->obtenerValor($consulta);
		
		if($idUsuario=="")
		{
			echo "2|";
		}
		else
		{
			$consulta="SELECT Login,AES_DECRYPT(UNHEX(Password), '".bD($versionLatis)."'),Nombre FROM 800_usuarios WHERE idUsuario=".$idUsuario;
			$fUsr=$con->obtenerPrimeraFila($consulta);
			
			$arrParam["nombreUsuario"]=$fUsr[2];
			$arrParam["idUsuario"]=$idUsuario;
			$arrParam["login"]=$fUsr[0];
			$arrParam["password"]=$fUsr[1];
			
			@enviarMensajeEnvio(15,$arrParam,"sendMensajeEnvioGmailJuzgado");
			echo "1|";
		}
	}
	
	function obtenerRegistrosSeguimiento()
	{
		global $con;
		$idExpediente=bD($_POST["iE"]);
		$unidadGestion=bD($_POST["cG"]);
		$consulta="SELECT idRegistro,fechaRegistro,idDocumentoAcuerdo,
				(SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=a.idDocumentoAcuerdo) AS nombreDocumentoAcuerdo,
				'' as idDocumentoPromocion,  '' AS nombreDocumentoPromocion,1 AS tipo,CONCAT('Acuerdo del ',DATE_FORMAT(fechaAcuerdo,'%d/%m/%Y')) AS asunto
				FROM 7072_acuerdoGeneradosExpedientes a WHERE idUsuario=".$_SESSION["idUsr"]." AND idExpediente=".$idExpediente." AND cveJuzgado='".$unidadGestion."'
				UNION
				SELECT idRegistro,fechaRegistro,p.idDocumentoPromocion AS idDocumentoAcuerdo,
				(SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=p.idDocumentoPromocion) AS nombreDocumentoAcuerdo,
				p.idDocumentoRespuesta AS idDocumentoPromocion,
				(SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=p.idDocumentoRespuesta) AS nombreDocumentoPromocion,
				2 AS tipo,CONCAT('Registro de promoción asunto: ',asunto) AS asunto FROM 7071_promocionesRegistradasUsuario p
				WHERE idUsuarioRegistro=".$_SESSION["idUsr"]." AND idExpediente=".$idExpediente." AND cveUnidadGestion='".$unidadGestion."' ORDER BY fechaRegistro";
		
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
		
	}

	
	function registrarMarcaDocumentoPendienteFirma()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$consulta="SELECT COUNT(*) FROM 3000_documentosAsignadosAtencion WHERE iFormulario=".$obj->iFormulario." AND iReferencia=".
				$obj->iReferencia." AND idResponsableAtencion=".$_SESSION["idUsr"];
		
		$nRegistros=$con->obtenerValor($consulta);
		if($nRegistros>0)
		{
			cambiarEtapaFormulario($obj->iFormulario,$obj->iReferencia,$obj->etapaCambio,$obj->comentarios,-1,"NULL","NULL",$obj->actor);
			
			echo "1|";
			return;
		}
		$consulta="SELECT * FROM 7035_informacionDocumentos WHERE idFormulario=".$obj->iFormulario." AND idReferencia=".$obj->iReferencia;
		$fDatosDocumento=$con->obtenerPrimeraFila($consulta);

		$consulta="SELECT idRegistroFormato FROM 3000_formatosRegistrados WHERE idFormulario=-2 AND idRegistro=".$fDatosDocumento[0];

		$idDocumentoFormato=$con->obtenerValor($consulta);
		$idCarpetaAdministrativa="";
		$nomTabla="_".$obj->iFormulario."_tablaDinamica";
		if($con->existeCampo("idExpediente",$nomTabla))
		{
			$consulta="SELECT idExpediente FROM ".$nomTabla." WHERE id_".$nomTabla."=".$obj->iReferencia;
			$idCarpetaAdministrativa=$con->obtenerValor($consulta);
		}
		else
		{
			if($con->existeCampo("idCarpetaAdministrativa",$nomTabla))
			{
				$consulta="SELECT idCarpetaAdministrativa FROM ".$nomTabla." WHERE id_".$nomTabla."=".$obj->iReferencia;
				$idCarpetaAdministrativa=$con->obtenerValor($consulta);
			}
			else
			{
				$consulta="SELECT codigoInstitucion FROM ".$nomTabla." WHERE id_".$nomTabla."=".$obj->iReferencia;
				$codigoInstitucion=$con->obtenerValor($consulta);
				$consulta="SELECT idCarpeta FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fDatosDocumento[9].
						"' AND unidadGestion='".$codigoInstitucion."'";
				$idCarpetaAdministrativa=$con->obtenerValor($consulta);
			}
		}
		
		
		$consulta="INSERT INTO 3000_documentosAsignadosAtencion(idDocumentoFormato,situacionActual,fechaAsignacion,idCarpetaAdministrativa,
					iFormulario,iReferencia,idResponsableAtencion,actor,idInformacionDocumento) values(
					".$idDocumentoFormato.",0,'".date("Y-m-d H:i:s")."',".($idCarpetaAdministrativa==""?"NULL":$idCarpetaAdministrativa).",".$obj->iFormulario.",".$obj->iReferencia.",".
					$_SESSION["idUsr"].",".$obj->actor.",".$fDatosDocumento[0].")";

		if($con->ejecutarConsulta($consulta))
		{
			cambiarEtapaFormulario($obj->iFormulario,$obj->iReferencia,$obj->etapaCambio,$obj->comentarios,-1,"NULL","NULL",$obj->actor);
			echo "1|";
		}
	}
	
	function obtenerRegistrosDocumentosPendientesFirma()
	{
		global $con;
		$periodoInicio=$_POST["periodoInicio"];
		$periodoFin=$_POST["periodoFin"];
		$tipoDocumentos=$_POST["tipoDocumentos"];
		$numReg=0;
		$arrRegistros="";
		
		$consulta="SELECT a.*,i.tituloDocumento,c.carpetaAdministrativa,i.idFormulario,i.idReferencia,f.tipoFormato,f.fechaFirma,f.idDocumento, 
				date_format(a.fechaAsignacion,'%d/%m/%Y') as fecha,
				(SELECT nombreUnidad FROM _17_tablaDinamica j,7006_carpetasAdministrativas c WHERE c.idCarpeta=a.idCarpetaAdministrativa 
				AND j.claveUnidad=c.unidadGestion) as juzgado,f.firmado,f.documentoBloqueado,f.idDocumento,c.secretariaAsignada,
				f.configuracionDocumento FROM 3000_documentosAsignadosAtencion a,
				3000_formatosRegistrados f,7035_informacionDocumentos i,7006_carpetasAdministrativas c WHERE a.idResponsableAtencion=".$_SESSION["idUsr"].
				" and a.situacionActual in(".$tipoDocumentos.") and f.idRegistroFormato=a.idDocumentoFormato and i.idRegistro=a.idInformacionDocumento
				and a.fechaAsignacion>='".$periodoInicio."' and a.fechaAsignacion<='".$periodoFin." 23:49:59' and c.idCarpeta=a.idCarpetaAdministrativa";

		$resDocumentos=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($resDocumentos))
		{
			if($tipoDocumentos==0)
			{
				if(existeRol("'56_0'"))
				{
					$consulta="SELECT * FROM _".$fila["idFormulario"]."_tablaDinamica WHERE id__".$fila["idFormulario"]."_tablaDinamica=".
								$fila["idReferencia"]." and idEstado=4.7";
					if($fila["idFormulario"]==478)
					{
						$consulta="SELECT * FROM _".$fila["idFormulario"]."_tablaDinamica WHERE id__".$fila["idFormulario"]."_tablaDinamica=".
									$fila["idReferencia"]." and idEstado in(4.8,4.9)";
					}
				}
				else
				{
					$consulta="SELECT * FROM _".$fila["idFormulario"]."_tablaDinamica WHERE id__".$fila["idFormulario"]."_tablaDinamica=".
								$fila["idReferencia"]." and idEstado=5.7";
					if($fila["idFormulario"]==478)
					{
						$consulta="SELECT * FROM _".$fila["idFormulario"]."_tablaDinamica WHERE id__".$fila["idFormulario"]."_tablaDinamica=".
									$fila["idReferencia"]." and idEstado in(5.8,5.9)";
					}
				}
			}
			$fRegistro=$con->obtenerPrimeraFila($consulta);
			if(!$fRegistro)
				continue;
			$consulta="SELECT notificadoSICOR,fechaNotificacion,folioSICOR,notificadoSICORCancelacion,fechaNotificacionCancelacion,
						folioSICORCancelacion FROM _487_tablaDinamica WHERE idAcuerdo=".($fila["idDocumento"]==""?-1:$fila["idDocumento"]);
			$filaPublicacion=$con->obtenerPrimeraFilaAsoc($consulta);	
			
			$consulta="SELECT complementario2 FROM 947_actoresProcesosEtapasVSAcciones WHERE idActorProcesoEtapa=".$fila["actor"];
			$objConfirma=$con->obtenerValor($consulta);	
			$o='{"idDocumento":"'.$fila["idDocumentoFormato"].'","nombreDocumento":"'.cv($fila["tituloDocumento"]).'","situacionActual":"'.
					$fila["situacionActual"].'","fechaAsignacion":"'.$fila["fechaAsignacion"].'","carpetaAdministrativa":"'.
					cv($fila["carpetaAdministrativa"]).'","actor":"'.$fila["actor"].'",
					"juzgado":"'.cv($fila["juzgado"]).'","iFormulario":"'.$fila["idFormulario"].'","iRegistro":"'.$fila["idReferencia"].
					'","tipoDocumento":"'.$fila["tipoFormato"].'","notificadoSicor":"'.($filaPublicacion["fechaNotificacion"]==""?0:1).
					'","fechaNotificacionSicor":"'.$filaPublicacion["fechaNotificacion"].'","idAcuseSicor":"'.$filaPublicacion["folioSICOR"].
					'","fechaFirma":"'.$fila["fechaFirma"].'","fecha":"'.$fila["fecha"].
					'","documentoFirmado":"'.$fila["firmado"].'","documentoBloqueado":"'.$fila["documentoBloqueado"].
					'","fechaAtencion":"'.$fila["fechaAtencion"].'","comentariosAdicionales":"'.cv($fila["comentariosAdicionales"]).
					'","idDocumentoPDF":"'.$fila["idDocumento"].'","idRegistroAtencion":"'.$fila["idRegistro"].'","objConfirma":'.$objConfirma.
					',"secretaria":"'.$fila["secretariaAsignada"].'","configuracionDocumento":"'.$fila["configuracionDocumento"].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	
	function registrarFirmaCertificacionProcesoModuloGlobal()
	{
		global $con;
		
		
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
				
		$accionFirma=$obj->accionFirma;
		$idFormulario=$obj->idFormulario;
		$idRegistro=$obj->idRegistro;
		$comentario=$obj->comentario;
		$etapa=$obj->etapa;
		$actor=$obj->actor;
		$cadenaFirma=$obj->cadenaFirma;
		$idPerfil=obtenerIdPerfilActivoProcesoActor($actor,$idFormulario);
		$continuarProceso=true;
		if($accionFirma==1)
		{
			$consulta="INSERT INTO 9073_firmasCertificacionesProcesos(idFormulario,idRegistro,idActor,cadenaFirma,fechaFirma,responsableFirma,comentarios)
				VALUES(".$idFormulario.",".$idRegistro.",".$actor.",'".$cadenaFirma."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".cv($comentario)."')";
			$continuarProceso=$con->ejecutarConsulta($consulta);
		}
		if($continuarProceso)
		{
			$consulta="UPDATE 3000_documentosAsignadosAtencion SET situacionActual=1,fechaAtencion='".date("Y-m-d H:i:s").
						"',comentariosAdicionales='".cv($comentario)."' WHERE idRegistro=".$obj->idRegistroAtencion;
			$con->ejecutarConsulta($consulta);
			if($etapa!=0)
			{
				if(isset($obj->funcionEjecucion)&&($obj->funcionEjecucion!=""))
				{
					@eval("@".bD($obj->funcionEjecucion).";");
				}
				if(cambiarEtapaFormulario($idFormulario,$idRegistro,$etapa,$comentario,$idPerfil,"NULL","NULL",$actor))
				{
					echo "1|";

				}
			}
			else
				echo "1|";
		}
	}
	
	
	function generarDocumentoImpresionUnico()
	{
		global $con;
		global $baseDir;
		
		$arrDocumentosGenerados=array();
		$listaDocumento=$_POST["listaDocumento"];
		$nArchivoFinal=generarNombreArchivoTemporal();
		$nombreArchivoFinal=$baseDir."/archivosTmpPDF/".$nArchivoFinal.".pdf";
		$merge = new PDFMerger();
		$arrDocumentos=explode(",",$listaDocumento);
		foreach($arrDocumentos as $d)
		{
			$cuerpoDocumento=obtenerCuerpoDocumentoSICORB64($d);
			$nombreArchivoTmp=$baseDir."/archivosTmpPDF/".generarNombreArchivoTemporal();
			if(escribirContenidoArchivo($nombreArchivoTmp,bD($cuerpoDocumento)))
			{
				array_push($arrDocumentosGenerados,$nombreArchivoTmp);
			}
		}
		
		foreach($arrDocumentosGenerados as $d)
		{
			$merge->addPDF($d);
			
		}
		
		$merge->merge("file",$nombreArchivoFinal);
		
		foreach($arrDocumentosGenerados as $d)
		{
			
			unlink($d);
		}
		echo "1|".$nArchivoFinal;
	}
	
	function obtenerResultadoBusquedaJuzgado()
	{
		global $con;
		$consulta="";
		
		$tipoFigura=$_POST["tipoFigura"];
		$tipoCriterio=$_POST["tipoCriterio"];
		$valor=$_POST["valor"];
		$porcentaje=$_POST["porcentaje"];
		$juzgado=$_POST["juzgado"];
		
		$arrValoresBusqueda=explode(" ",trim($valor));
		for($x=0;$x<sizeof($arrValoresBusqueda);$x++)
		{
			$arrValoresBusqueda[$x]=normalizaToken($arrValoresBusqueda[$x]);
		}
		$resultado=buscarCoincidenciasCriterio($tipoCriterio,$valor,60,$tipoFigura);
		
		$arrResultados=$resultado[2];
		$arrRegistros="";
		$numReg=0;

		foreach($arrResultados as $idActividad=>$resto)
		{
			$datosImputado="<table>";
			$consulta="SELECT nombre,apellidoPaterno,apellidoMaterno,t.nombreTipo FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r,_5_tablaDinamica t WHERE 
					r.idParticipante=p.id__47_tablaDinamica AND r.idActividad=".$idActividad." AND t.id__5_tablaDinamica=r.idFiguraJuridica 
					ORDER BY t.nombreTipo,nombre,apellidoPaterno,apellidoMaterno";
			
			$resImputados=$con->obtenerFilas($consulta);
			while($fImputados=mysql_fetch_row($resImputados))
			{
				$nombreImputado=$fImputados[0].' '.$fImputados[1].' '.$fImputados[2];
				$nombreImputado=formatearNombreBusqueda($nombreImputado,$arrValoresBusqueda);
				$datosImputado.='<tr><td>'.cv($nombreImputado).' ('.$fImputados[3].')</td></tr>';
			}
					
			$datosImputado.="</table>";
			
			$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE idActividad=".$idActividad;
			if($juzgado!="")
				$consulta.=" and unidadGestion='".$juzgado."'";
			$fCarpeta=$con->obtenerPrimeraFilaAsoc($consulta);
			if(!$fCarpeta)
				continue;
			
			$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$fCarpeta["unidadGestion"]."'";
			$unidadGestion=$con->obtenerValor($consulta);
			
			
			$consulta="SELECT * FROM _478_tablaDinamica WHERE id__478_tablaDinamica=".$fCarpeta["idRegistro"];
			$fDatosExpediente=$con->obtenerPrimeraFilaAsoc($consulta);
			$tipoExpediente="";
			$tipoJuicio="";
			$secretariaAsignada="";
			if($fDatosExpediente)
			{
				$secretariaAsignada=$fDatosExpediente["secretariaAsignada"];
				
				$consulta="SELECT contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=7773 AND valor=".$fDatosExpediente["tipoExpediente"];
				$tipoExpediente=$con->obtenerValor($consulta);
				$consulta="SELECT tipoJuicio FROM _477_tablaDinamica WHERE id__477_tablaDinamica=".$fDatosExpediente["tipoJuicio"];
				$tipoJuicio=$con->obtenerValor($consulta);
			}
			$o='{"iRegistro":"'.$fCarpeta["idRegistro"].'","iFormulario":"'.$fCarpeta["idFormulario"].'","tipoJuicio":"'.$tipoJuicio.'","secretariaAsignada":"'.
				$secretariaAsignada.'","tipoExpediente":"'.$tipoExpediente.'","idExpediente":"'.$fCarpeta["idCarpeta"].'","fechaRecepcion":"'.$fCarpeta["fechaCreacion"].
				'","expediente":"'.$fCarpeta["carpetaAdministrativa"].'","juzgado":"'.$unidadGestion.'","datosImputado":"'.$datosImputado.
				'","idEstado":"'.$fCarpeta["situacion"].'","porcentaje":"'.(isset($resultado[1][$idActividad])?$resultado[1][$idActividad]:0).'"}';
			
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
	}
	
	function registrarParticipanteActividad()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$query="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE idCarpeta=".$obj->idCarpeta;
		$idActividad=$con->obtenerValor($query);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="INSERT INTO _47_tablaDinamica(fechaCreacion,idEstado,tipoPersona,apellidoPaterno,apellidoMaterno,nombre,genero,
						idActividad,figuraJuridica)
						values('".date("Y-m-d H:i:s")."',1,1,'".cv($obj->apPaterno)."','".cv($obj->apMaterno)."','".cv($obj->nombre)."',".$obj->genero.
						",".$idActividad.",".$obj->figura.")";
		$x++;
		$consulta[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;
		$consulta[$x]="INSERT INTO 7005_relacionFigurasJuridicasSolicitud(idActividad,idParticipante,idFiguraJuridica,situacion,
						etapaProcesal,situacionProcesal)
						values(".$idActividad.",@idRegistro,".$obj->figura.",1,1,1)";
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$query="select @idRegistro";
			$idRegistro=$con->obtenerValor($query);
			$arrPromoventes="";
			$query="SELECT id__47_tablaDinamica, nombre,apellidoPaterno,apellidoMaterno,fj.nombreTipo FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r,
					_5_tablaDinamica fj WHERE p.id__47_tablaDinamica=r.idParticipante AND r.idActividad=".$idActividad." 
					AND fj.id__5_tablaDinamica=r.idFiguraJuridica ORDER BY nombre,apellidoPaterno,apellidoMaterno";
			$res=$con->obtenerFilas($query);
			while($fila=mysql_fetch_row($res))
			{
				$oPromovente="['".$fila[0]."','".cv($fila[1]." ".$fila[2]." ".$fila[3])." (".$fila[4].")']";
				if($arrPromoventes=="")
					$arrPromoventes=$oPromovente;
				else
					$arrPromoventes.=",".$oPromovente;
			}
			
			echo "1|[".$arrPromoventes."]|".$idRegistro;
		}
	}


	
	function obtenerAudienciasExpediente()
	{
		global $con;
		$cveMateria=$_POST["cveMateria"];
		$exp=$_POST["exp"];
		$iC=$_POST["iC"];
		$arrAudiencias="";
		$totalAudiencias=0;
		$fDatosServidor=obtenerURLComunicacionServidorMateria($cveMateria);
		$url=$fDatosServidor[0].($fDatosServidor[1]!=""?":".$fDatosServidor[1]:"");

		$client = new nusoap_client("http://".$url."/webServices/wsInterconexionSistemasBPM.php?wsdl","wsdl");
		$parametros=array();
		$parametros["cveExpediente"]=$exp;
		$parametros["idExpediente"]=$iC;
		
		$consulta="SELECT idEventoAudiencia FROM 7006_usuariosVSAudiencias WHERE idUsuario=".$_SESSION["idUsr"].
				" AND cveMateria='".$cveMateria."' AND idCarpetaAdministrativa=".$iC;
		
		
		$parametros["idAudiencias"]=$con->obtenerListaValores($consulta);
		if($parametros["idAudiencias"]=="")
			$parametros["idAudiencias"]=-1;

		$response = $client->call("obtenerAudienciasJuzgadoMateria", $parametros);

		$oResp=json_decode(utf8_encode($response));
		
		if($oResp->resultado==1)
		{
			$numReg=0;
			$arrAudiencias="";
			foreach($oResp->arrAudiencias as $a)
			{
				$o='{"idEvento":"'.$a->idEvento.'","carpetaAdministrativa":"'.$a->carpetaAdministrativa.'","fechaEvento":"'.$a->fechaEvento.
					'","horaInicial":"'.$a->horaInicial.'","horaFinal":"'.$a->horaFinal.'","horaInicioReal":"'.$a->horaInicioReal.
					'","horaTerminoReal":"'.$a->horaTerminoReal.'","urlMultimedia":"'.$a->urlMultimedia.'","tipoAudiencia":"'.$a->tipoAudiencia.
					'","sala":"'.$a->sala.'","unidadGestion":"'.$a->unidadGestion.'","situacion":"'.$a->situacion.
					'","juez":"'.$a->juez.'","edificio":"'.$a->edificio.'","comentariosAdicionales":"'.$a->comentariosAdicionales.'"}';
				if($arrAudiencias=="")
					$arrAudiencias=$o;
				else
					$arrAudiencias.=",".$o;
				$numReg++;
			}
			
			echo '{"numReg":"'.$numReg.'","registros":['.$arrAudiencias.']}';
			
		}
		
	}
	
	function obtenerDatosAccesoVideoGrabacion()
	{
		global $con;
		$fechaActual=strtotime(date("Y-m-d H:i:s"));
		$codigoAcceso=bD($_POST["codigoAcceso"]);
		$consulta="SELECT * FROM 7000_accesosVideoGrabacion WHERE codigoAcceso='".$codigoAcceso."'";
		$fAcceso=$con->obtenerPrimeraFila($consulta);
		if(!$fAcceso)
		{
			echo "1|2";
		}
		else
		{
			$fechaExpira=strtotime($fAcceso[8]);
			if($fechaExpira<$fechaActual)
				echo "1|3";
			else
				echo "1|1|".$fAcceso[4];
		}
		
	}

	function obtenerUsuariosAccesoSicoreEvento()
	{
		global $con;
		$idEvento=$_POST["idEvento"];
		$consulta="SELECT r.idRegistro,cveUsuario,concat(if(p.nombre is not null,p.nombre,''),' ',if(p.apellidoPaterno is not null,p.apellidoPaterno,''),' ',
				if(p.apellidoMaterno is not null,p.apellidoMaterno,'')) as nombre,r.situacion,rF.idFiguraJuridica as participacion,
				(SELECT comentariosAdicionales FROM 3022_bitacoraCambioSituacionObjeto WHERE tipoObjeto=1 AND 
				idRegistroReferencia=r.idRegistro and idEstadoActual=r.situacion ORDER BY fechaOperacion DESC limit 0,1) as comentariosAdicionales 
				FROM 3021_registroAccesosSICORE r,7005_relacionFigurasJuridicasSolicitud rF, _47_tablaDinamica p
				WHERE idEventoAudiencia=".$idEvento." and rF.idRelacion=r.idRegistroRelacion and 
				p.id__47_tablaDinamica=rF.idParticipante";
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
		
		
		
		
	}
	
	function registrarUsuarioAccesoSicoreEvento()
	{
		global $con;
		$idEvento=$_POST["idEvento"];
		$cveUsuario=$_POST["cveUsuario"];
		
		$idUsuarioSicore=substr($cveUsuario,4,7)*1;
		$idFigura=substr($cveUsuario,-2)*1;
		$consulta="SELECT nombreTipo FROM _5_tablaDinamica WHERE id__5_tablaDinamica=".$idFigura;
		$lblFiguraExpediente=$con->obtenerValor($consulta);
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa 
				WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$idEvento;
		$cAdministrativa=$con->obtenerValor($consulta);
		
		$consulta="SELECT u.claveUnidad FROM 7000_eventosAudiencia e,_17_tablaDinamica u WHERE idRegistroEvento=".$idEvento."
					AND u.id__17_tablaDinamica=e.idCentroGestion";
		$cveUnidad=$con->obtenerValor($consulta);
		
		$consulta="SELECT idCarpeta,fechaCreacion,idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cAdministrativa.
				"' AND unidadGestion='".$cveUnidad."'";
		$fDatosCarpeta=$con->obtenerPrimeraFila($consulta);
		
		$idCarpeta=$fDatosCarpeta[0];
		try
		{
			$x=0;
			$query[$x]="begin";
			$x++;
			$fDatosServidor=obtenerURLComunicacionServidorMateria("SW");
			$url=$fDatosServidor[0].($fDatosServidor[1]!=""?":".$fDatosServidor[1]:"");
			$client = new nusoap_client("http://".$url."/webServices/wsInterconexionSistemasBPM.php?wsdl","wsdl");
			
			$consulta="SELECT * FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$fDatosCarpeta[2]." AND idCuentaAcceso=".$idUsuarioSicore;
			$fRelacionCarpeta=$con->obtenerPrimeraFilaAsoc($consulta);
			$idParticipante="";
			$idRegistroRelacion="-1";
			if(!$fRelacionCarpeta)
			{
				$esCuentaGenerica="";
				$consulta="SELECT * FROM 7005_relacionFigurasJuridicasSolicitud WHERE idCuentaAcceso=".$idUsuarioSicore;
				$fRelacionCarpeta=$con->obtenerPrimeraFilaAsoc($consulta);
				if(!$fRelacionCarpeta)
				{
					$parametros=array();
					$parametros["idUsuario"]=$idUsuarioSicore;
					
					$response = $client->call("obtenerInformacionCuenta", $parametros);		
					$oResp=json_decode($response);	
					
					switch($oResp->resultado)
					{
						case 1:
						
							//---
							$idActividad=$fDatosCarpeta[2];
							if($idActividad=="")
								$idActividad=-1;
							if($idActividad==-1)
							{
								$idActividad=generarIDActividad(-7006);
								$consulta="UPDATE 7006_carpetasAdministrativas SET idActividad=".$idActividad." WHERE idCarpeta=".$idCarpeta;
								$con->ejecutarConsulta($consulta);
								
								
							}
							
							$obj=$oResp->objUsuario;
							
							$objPersona=$obj->oIdentifica[0];
							$esCuentaGenerica=$obj->esCuentaGenerica;
							$query[$x]="INSERT INTO _47_tablaDinamica(tipoPersona,apellidoPaterno,apellidoMaterno,nombre,genero,otraNacionalidad,esMexicano,idActividad,
							figuraJuridica,tipoDefensor,curp,cedulaProfesional,rfcEmpresa,fechaNacimiento,edad,estadoCivil,tipoIdentificacion,otraIdentificacion) 
							VALUES(1,'".cv(trim($objPersona->apPaterno))."','".cv(trim($objPersona->apMaterno))."','".cv(trim($objPersona->nombre))."',
							".($objPersona->Genero==""?2:$objPersona->Genero).",'',3,".$idActividad.",".$idFigura.
							",NULL,'".cv($objPersona->CURP)."',".($objPersona->cedulaProf==""?"NULL":"'".cv($objPersona->cedulaProf)."'")
							.",'".cv($objPersona->RFC)."',".($objPersona->fechaNacimiento==""?"NULL":"'".$objPersona->fechaNacimiento."'").",NULL,9999,'".
							$objPersona->tipoIdentificacion."','')";
							$x++;
							
							$query[$x]="set @idParticipante:=(select last_insert_id())";
							$x++;
							
							$oDomicilio=$obj->domicilio[0];
							
							$query[$x]="INSERT INTO _48_tablaDinamica(idReferencia,fechaCreacion,responsable,idEstado,calle,noInterior,noExt,colonia,
										codigoPostal,entidadFederativa,municipio)
										
										values(@idParticipante,'".date("Y-m-d H:i:s")."',1,0,'".cv($oDomicilio->Calle)."','".cv($oDomicilio->NumeroInt).
										"','".cv($oDomicilio->Numero)."','".cv($oDomicilio->Colonia)."','".cv($oDomicilio->CP)."','".cv($oDomicilio->Estado).
										"','".cv($oDomicilio->Municipio)."')";
							$x++;
							
							$query[$x]="set @idDomicilio:=(select last_insert_id())";
							$x++;
							
							foreach($obj->mails as $oM)
							{
								$query[$x]="INSERT INTO _48_correosElectronico(idReferencia,correo) VALUES(@idDomicilio,'".$oM->Mail."')";
								$x++;
								
							}
							
							foreach($obj->telefonos as $oT)
							{
								$query[$x]="INSERT INTO _48_telefonos(idReferencia,tipoTelefono,lada,numero,extension) 
											VALUES(@idDomicilio,'".$oT->Tipo."','".$oT->Lada."','".$oT->Numero."',".
											($oT->Extension==""?"NULL":$oT->Extension).")";
								$x++;
								
							}
						
						break;
						case 0:
							echo "0|".$oResp->mensaje;
							return;
						break;
					}
				}
				else
				{
					$query[$x]="set @idParticipante:=".$fRelacionCarpeta["idParticipante"];
					$x++;
					$idRegistroRelacion=$fRelacionCarpeta["idRelacion"];
					$esCuentaGenerica=$fRelacionCarpeta["situacion"];
				}
				
				$query[$x]="INSERT INTO 7005_relacionFigurasJuridicasSolicitud(idActividad,idParticipante,idFiguraJuridica,
								situacion,idCuentaAcceso,etapaProcesal,situacionProcesal,detalleSituacion,cuentaAccesoGenerica)
								values(".$fDatosCarpeta[2].",@idParticipante,".$idFigura.",1,".
								$idUsuarioSicore.",1,1,NULL,".$esCuentaGenerica.")";
				$x++;
				$query[$x]="set @idRelacion:=(select last_insert_id())";
				$x++;
				
				$query[$x]="INSERT INTO 7005_bitacoraCuentasAcceso(idActividad,idParticipante,idFiguraJuridica,
					fechaCreacion,responsable,situacionAnterior,situacionActual,aplicado) 
					VALUES(".$fDatosCarpeta[2].",@idParticipante,".$idFigura.",'".date("Y-m-d H:i:s").
					"',".$_SESSION["idUsr"].",NULL,1,1)";
				$x++;
				
				$query[$x]="INSERT INTO 7005_bitacoraCambiosFigurasJuridicas(idActividad,idParticipante,idFiguraJuridica,idActorRelacionado,
										situacionAnterior,situacionActual,fechaCambio,responsableCambio,comentariosAdicionales) values
										(".$fDatosCarpeta[2].",@idParticipante,".$idFigura.",-1,NULL,1,'".date("Y-m-d H:i:s").
										"',".$_SESSION["idUsr"].",'')";
				$x++;
				
				
			}
			else
			{
				$query[$x]="set @idParticipante:=".$fRelacionCarpeta["idParticipante"];;
				$x++;
				
				$query[$x]="set @idRelacion:=".$fRelacionCarpeta["idRelacion"];;
				$x++;
			}
			$consulta="select count(*) from 3021_registroAccesosSICORE WHERE idEventoAudiencia=".$idEvento.
								" AND idRegistroRelacion=".$idRegistroRelacion;	
			$numReg=$con->obtenerValor($consulta);
			if($numReg==0)
			{
				$query[$x]="INSERT INTO 3021_registroAccesosSICORE(idEventoAudiencia,idRegistroRelacion,situacion,fechaRegistro,cveUsuario)
							values(".$idEvento.",@idRelacion,1,'".date("Y-m-d H:i:s")."','".$cveUsuario."')";
				$x++;
			}
			$query[$x]="commit";
			$x++;
			
			if($con->ejecutarBloque($query))
			{
				$consulta="select @idParticipante";
				$idParticipante=$con->obtenerValor($consulta);
				$consulta="select @idRelacion";
				$idRegistroRelacion=$con->obtenerValor($consulta);
				
				$cadObj='{"idEvento":"'.$idEvento.'","cveUsuario":"'.$cveUsuario.
						'","idCarpeta":"'.$idCarpeta.'","carpetaJudicial":"'.$cAdministrativa.
						'","cveMateria":"PO","unidadGestion":"'.$cveUnidad.'","anioExpediente":"'.
						date("Y",strtotime($fDatosCarpeta[1])).'","idUsuarioExpediente":"'.$idParticipante.'",
						"idFiguraExpediente":"'.$idFigura.'","lblFiguraExpediente":"'.
						bE($lblFiguraExpediente).'"}';
				
				$parametros=array();
				$parametros["cadObj"]=$cadObj;
				
				$response = $client->call("registrarAccesoVideoGrabacionAudiencia", $parametros);	
				
				$oResp=json_decode($response);	
				
				switch($oResp->resultado)
				{
					case 1:			
						$consulta="UPDATE 3021_registroAccesosSICORE SET situacion=2 WHERE idEventoAudiencia=".$idEvento.
								" AND idRegistroRelacion=".$idRegistroRelacion;			
						eC($consulta);
					break;
					case 2:
						echo "1|0";
						return;
					
					break;
					default:
						echo "0|".$oResp->mensaje;
						return;
					break;
				}
			}
		}
		catch(Exception $e)
		{
			echo "0|".$e->getMessage();
		}
		
	}
	
	function cambiarSituacionAccesoSicore()
	{
		global $con;
		try
		{
			$iA=$_POST["iA"];
			$situacion=$_POST["situacion"];
			$comentarios=$_POST["comentarios"];
			
			
			$consulta="SELECT rF.*,r.* FROM 3021_registroAccesosSICORE r,7005_relacionFigurasJuridicasSolicitud rF WHERE r.idRegistro=".$iA."
					AND rF.idRelacion=r.idRegistroRelacion";
			$fRegistroAcceso=$con->obtenerPrimeraFilaAsoc($consulta);

			$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa 
				WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$fRegistroAcceso["idEventoAudiencia"];
			$cAdministrativa=$con->obtenerValor($consulta);
			
			$consulta="SELECT u.claveUnidad FROM 7000_eventosAudiencia e,_17_tablaDinamica u WHERE idRegistroEvento=".$fRegistroAcceso["idEventoAudiencia"]."
						AND u.id__17_tablaDinamica=e.idCentroGestion";
			$cveUnidad=$con->obtenerValor($consulta);
			
			$consulta="SELECT idCarpeta,fechaCreacion,idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cAdministrativa.
					"' AND unidadGestion='".$cveUnidad."'";
			$fDatosCarpeta=$con->obtenerPrimeraFila($consulta);
			
			
			$fDatosServidor=obtenerURLComunicacionServidorMateria("SW");
			$url=$fDatosServidor[0].($fDatosServidor[1]!=""?":".$fDatosServidor[1]:"");
			$client = new nusoap_client("http://".$url."/webServices/wsInterconexionSistemasBPM.php?wsdl","wsdl");
			
			$parametros=array();
			$parametros["cadObj"]='{"idCarpetaAdministrativa":"'.$fDatosCarpeta[0].'","cveMateria":"PO","idUsuario":"'.
									$fRegistroAcceso["idCuentaAcceso"].'", "idEventoAudiencia":"'.
									$fRegistroAcceso["idEventoAudiencia"].'","situacion":"'.($situacion==2?1:$situacion).'"}';
			
			
			$response = $client->call("cambiarSituacionAccesoVideo", $parametros);		
			$oResp=json_decode($response);	

			if($oResp->resultado==1)
			{
				if(registrarCambioSituacionObjeto(1,$iA,$situacion,$comentarios))
				{
					
					$consulta="SELECT situacionActual FROM 7005_bitacoraCuentasAcceso WHERE idActividad=".$fRegistroAcceso["idActividad"].
										" AND idParticipante=".$fRegistroAcceso["idParticipante"]." AND idFiguraJuridica=".
										$fRegistroAcceso["idFiguraJuridica"]." order by fechaCreacion desc limit 0,1";
					$situacionAnterior=$con->obtenerValor($consulta);
					
					$consulta="SELECT COUNT(*) FROM 3021_registroAccesosSICORE WHERE idRegistroRelacion=".$fRegistroAcceso["idRelacion"].
								" AND situacion=1";
					$numReg=$con->obtenerValor($consulta);
					$consulta=array();
					$x=0;
					$consulta[$x]="begin";
					$x++;
					
					switch($situacion)
					{
						case 0:
							
							
							
							if($numReg==0)
							{
								
								
								$consulta[$x]="INSERT INTO 7005_bitacoraCuentasAcceso(idActividad,idParticipante,idFiguraJuridica,fechaCreacion,responsable,situacionAnterior,situacionActual,
											aplicado,comentariosAdicionales) 
											VALUES(".$fRegistroAcceso["idActividad"].",".$fRegistroAcceso["idParticipante"].",".
											$fRegistroAcceso["idFiguraJuridica"].",'".date("Y-m-d H:i:s").
											"',".$_SESSION["idUsr"].",".$situacionAnterior.",2,1,'".cv($comentarios)."')";
								$x++;
								$consulta[$x]="UPDATE 7005_relacionFigurasJuridicasSolicitud SET situacion=0 WHERE idRelacion=".$fRegistroAcceso["idRelacion"];
								$x++;
								
							}
						break;
						case 2:
							
							if($situacionAnterior!=1)
							{
								$consulta[$x]="INSERT INTO 7005_bitacoraCuentasAcceso(idActividad,idParticipante,idFiguraJuridica,fechaCreacion,responsable,situacionAnterior,situacionActual,
											aplicado,comentariosAdicionales) 
											VALUES(".$fRegistroAcceso["idActividad"].",".$fRegistroAcceso["idParticipante"].",".
											$fRegistroAcceso["idFiguraJuridica"].",'".date("Y-m-d H:i:s").
											"',".$_SESSION["idUsr"].",".$situacionAnterior.",1,1,'".cv($comentarios)."')";
								$x++;
							}
						
							$consulta[$x]="UPDATE 7005_relacionFigurasJuridicasSolicitud SET situacion=1 WHERE idRelacion=".$fRegistroAcceso["idRelacion"];
							$x++;
						break;
						
					}
					$consulta[$x]="commit";
					$x++;
					eB($consulta);

				}
			}
			else
			{
				echo "0|".$oResp->mensaje;	
			}
			
		
		}
		catch(Exception $e)
		{
			echo "0|".$e->getMessage();
		}
		
		
	}
	
	function reintentarRegistroAcceso()
	{
		global $con;
		$iA=$_POST["iA"];
		try
		{
			
			$consulta="SELECT rF.*,r.* FROM 3021_registroAccesosSICORE r,7005_relacionFigurasJuridicasSolicitud rF WHERE r.idRegistro=".$iA."
					AND rF.idRelacion=r.idRegistroRelacion";
			$fRegistroAcceso=$con->obtenerPrimeraFilaAsoc($consulta);

			$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa 
				WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$fRegistroAcceso["idEventoAudiencia"];
			$cAdministrativa=$con->obtenerValor($consulta);
			
			$consulta="SELECT u.claveUnidad FROM 7000_eventosAudiencia e,_17_tablaDinamica u WHERE idRegistroEvento=".$fRegistroAcceso["idEventoAudiencia"]."
						AND u.id__17_tablaDinamica=e.idCentroGestion";
			$cveUnidad=$con->obtenerValor($consulta);
			
			$consulta="SELECT idCarpeta,fechaCreacion,idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cAdministrativa.
					"' AND unidadGestion='".$cveUnidad."'";
			$fDatosCarpeta=$con->obtenerPrimeraFila($consulta);
			
			$idFigura=$fRegistroAcceso["idFiguraJuridica"];
			$consulta="SELECT nombreTipo FROM _5_tablaDinamica WHERE id__5_tablaDinamica=".$idFigura;
			$lblFiguraExpediente=$con->obtenerValor($consulta);
			
			$cadObj='{"idEvento":"'.$fRegistroAcceso["idEventoAudiencia"].'","cveUsuario":"'.$fRegistroAcceso["cveUsuario"].
						'","idCarpeta":"'.$fDatosCarpeta[0].'","carpetaJudicial":"'.$cAdministrativa.
						'","cveMateria":"PO","unidadGestion":"'.$cveUnidad.'","anioExpediente":"'.
						date("Y",strtotime($fDatosCarpeta[1])).'","idUsuarioExpediente":"'.$fRegistroAcceso["idCuentaAcceso"].'",
						"idFiguraExpediente":"'.$idFigura.'","lblFiguraExpediente":"'.
						bE($lblFiguraExpediente).'"}';
			
			$fDatosServidor=obtenerURLComunicacionServidorMateria("SW");
			$url=$fDatosServidor[0].($fDatosServidor[1]!=""?":".$fDatosServidor[1]:"");
			$client = new nusoap_client("http://".$url."/webServices/wsInterconexionSistemasBPM.php?wsdl","wsdl");
			
			$parametros=array();
			$parametros["cadObj"]=$cadObj;
			
			$response = $client->call("registrarAccesoVideoGrabacionAudiencia", $parametros);	
			
			$oResp=json_decode($response);	
			
			switch($oResp->resultado)
			{
				case 1:			
					$consulta="UPDATE 3021_registroAccesosSICORE SET situacion=2 WHERE idEventoAudiencia=".$fRegistroAcceso["idEventoAudiencia"].
							" AND idRegistroRelacion=".$fRegistroAcceso["idRelacion"];			
					eC($consulta);
				break;
				case 2:
					echo "1|0";
					return;
				
				break;
				default:
					echo "0|".$oResp->mensaje;
					return;
				break;
			}
			
		
		}
		catch(Exception $e)
		{
			echo "0|".$e->getMessage();
		}
		
		
	}
	
	function obtenerDocumentosGeneradosExpediente()
	{
		global $con;
		$idExpediente=$_POST["idExpediente"];
		
		$numReg=0;
		$arrExpedientes="";
		$consulta="SELECT * FROM _552_tablaDinamica WHERE idCarpetaAdministrativa=".$idExpediente." ORDER BY fechaCreacion";

		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$o='{"idRegistro":"'.$fila["id__552_tablaDinamica"].'","idFormulario":"552","folioRegistro":"'.$fila["codigo"].
				'","tipoDocumento":"'.$fila["tipoDocumento"].'","comentariosAdicionales":"'.cv($fila["comentariosAdicionales"]).
				'","fechaCreacion":"'.$fila["fechaCreacion"].'","idEstado":"'.$fila["idEstado"].'"}';
			if($arrExpedientes=="")
				$arrExpedientes=$o;
			else
				$arrExpedientes.=",".$o;
			$numReg++;
		}
		
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrExpedientes.']}';
		
	}

	function buscarDuplicidadBilleteDeposito()
	{
		global $con;
		$idRegistro=$_POST["iR"];
		$nBillete=$_POST["nB"];
		$consulta="SELECT COUNT(*) FROM _509_tablaDinamica WHERE noBillete='".cv($nBillete*1)."' AND id__509_tablaDinamica<>".$idRegistro;
		$numReg=$con->obtenerValor($consulta);
		if($numReg>0)
			echo "1|1";
		else
			echo "1|0";
	}
	
	function registrarModificacionConfiguracionPublicacion()
	{
		global $con;
		global $baseDir;
		global $tipoServidor;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		
		$consulta="UPDATE 3000_formatosRegistrados SET configuracionDocumento='".$obj->configuracionDocumento."' WHERE idRegistroFormato=".$obj->idRegistroDocumento;
		ec($consulta);
		
		
	}
	
	function obtenerSolicitudesLAMVLV()
	{
		global $con;
		$numReg=0;
		$registros="";
		$consulta="SELECT * FROM _483_tablaDinamica WHERE responsable=".$_SESSION["idUsr"]." ORDER BY fechaCreacion DESC";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$situacionPromocion=$fila["idEstado"];
			$consulta="SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
				WHERE r.idActividad=".$fila["idActividad"]." and idFiguraJuridica=2 AND r.idParticipante=p.id__47_tablaDinamica order 
				by nombre,apellidoPaterno,apellidoMaterno";
		
			$victimas=$con->obtenerValor($consulta);
			
			$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".
					((($fila["idDocumento"]=="") ||($fila["idDocumento"]=="N/E" ))?-1:$fila["idDocumento"]);
			$nomArchivoOriginal=$con->obtenerValor($consulta);
			
			$o='{"idRegistro":"'.$fila["id__483_tablaDinamica"].'","expediente":"'.$fila["carpetaAdministrativa"].'","fechaRegistro":"'.$fila["fechaCreacion"].
				'","victima":"'.cv($victimas).'","situacionPromocion":"'.$situacionPromocion.'","fechaRespuesta":"'.$fila["fechaRespuesta"].
				'","fechaRecepcionJuzgado":"'.$fila["fechaRecepcion"].'","idDocumentoRespuesta":"'.$fila["idDocumento"].
				'","nombreDocumentoRespuesta":"'.$nomArchivoOriginal.'","juzgado":"'.$fila["unidadGestion"].
				'","folioRecepcion":"'.$fila["folioRecepcion"].'"}';

			if($registros=="")
				$registros=$o;
			else
				$registros.=",".$o;
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$registros.']}';
		
	}
	
	
	function enviarSolicitudUGJ()
	{
		global $con;
		$idRegistro=bD($_POST["iP"]);
		
		
		if(cambiarEtapaFormulario(483,$idRegistro,2,"",-1,"NULL","NULL",862))
		{
			$consulta="SELECT * FROM _483_tablaDinamica WHERE id__483_tablaDinamica=".$idRegistro;
			$fila=$con->obtenerPrimeraFilaAsoc($consulta);
			echo "1|".$fila["fechaRecepcion"]."|".$fila["folioRecepcion"];
		}
		
	
		
	}
	
	
	function crearNuevoUsuarioSIGUE()
	{
		global $con;
		global $mostrarXML;
		global $urlSitio;
		global $versionLatis;
		
		$cadObjJson=$_POST["datosAutor"];
		
		$objJson=json_decode($cadObjJson);
		
		
		$apPaterno=$objJson->apPaterno;
		$apMaterno=$objJson->apMaterno;
		$nombre=$objJson->nombres;
		$prefijo="";
		if(isset($objJson->prefijo))
			$prefijo=$objJson->prefijo;
		$nombreC=trim($nombre).' '.trim($apPaterno).' '.trim($apMaterno);
		$mail=$objJson->email;
		$codInstitucion="";
		if(isset($objJson->codInstitucion))
			$codInstitucion=$objJson->codInstitucion;
		$codDepto="";
		if(isset($objJson->codDepto))
			$codDepto=$objJson->codDepto;
			
		if(isset($objJson->objDatosOfertaEducativa))	
		{
			$query="SELECT sede FROM 4513_instanciaPlanEstudio where idInstanciaPlanEstudio=".$objJson->objDatosOfertaEducativa->idInstancia;
			$codInstitucion=$con->obtenerValor($query);
		}
		$idIdioma="1";
		$password=generarPassword();
		$sexo=0;
		if(isset($objJson->sexo))
			$sexo=$objJson->sexo;
		$mailUsr=$mail;
		$status="5";
		$telefonos="";
		
		if(isset($objJson->telefonos))
		{
			$telefonos=$objJson->telefonos;
		}
		
		
		
		$query="insert into 800_usuarios(Login,Status,FechaCambio,Password,Nombre,idIdioma,cuentaActiva,cambiarDatosUsr) values('".cv(trim($mail))."',".$status.",'".date('Y-m-d')."',HEX(AES_ENCRYPT('".$password."', '".bD($versionLatis)."')),'".cv($nombreC)."',".$idIdioma.",0,2)";
		if(!$con->ejecutarConsulta($query))
		{
			echo "|";
			return ;
		}
		$x=0;	
		
		$idUsuario=$con->obtenerUltimoID();
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="insert into 805_mails(Mail,Tipo,Notificacion,idUsuario) values('".cv(trim($mail))."',0,1,".$idUsuario.")";
		$x++;
		$consulta[$x]="insert into 807_usuariosVSRoles(idUsuario,idRol,idExtensionRol,codigoRol) values(".$idUsuario.",-1000,0,'-1000_0')";
		$x++;
		$arrRolesUsuario["152_0"]="1";
		$arrRolesUsuario["157_0"]="1";
		
		foreach($arrRolesUsuario as $rol=>$resto)
		{
			$arrDatos=explode("_",$rol);
			$consulta[$x]="insert into 807_usuariosVSRoles(idUsuario,idRol,idExtensionRol,codigoRol) values(".$idUsuario.",".$arrDatos[0].",".$arrDatos[1].",'".$rol."')";
			$x++;
		}
		$consulta[$x]="insert into 802_identifica(Nom,Paterno,Materno,Nombre,Status,idUsuario,Prefijo,Genero,fechaNacimiento) 
					  values('".cv($nombre)."','".cv($apPaterno)."','".cv($apMaterno)."','".cv($nombreC)."',".$status.",".$idUsuario.",'".$prefijo."',".
					  $sexo.",".(isset($objJson->fechaNacimiento)?"'".$objJson->fechaNacimiento."'":"NULL").")";
		$x++;
		$consulta[$x]="insert into 801_adscripcion(Institucion,Status,idUsuario,codigoUnidad) values('".cv($codInstitucion)."',".$status.",".$idUsuario.",'".$codDepto."')";
		$x++;
		$consulta[$x]="insert into 803_direcciones(idUsuario,Tipo) values(".$idUsuario.",0)";
		$x++;
		if(isset($objJson->direccion))
		{
			$oDireccion=$objJson->direccion;
			$consulta[$x]="insert into 803_direcciones(idUsuario,Tipo,Calle,Numero,Colonia,CP,Estado,Municipio,NumeroInt) values(".$idUsuario.
							",0,'".cv($oDireccion->calle)."','".cv($oDireccion->noExt)."','".cv($oDireccion->colonia)."',".
							($oDireccion->cp==""?"NULL":$oDireccion->cp).",'".cv($oDireccion->estado).
							"','".cv($oDireccion->municipio)."','".cv($oDireccion->noInt)."')";
			$x++;
		}
		else
		{
			$consulta[$x]="insert into 803_direcciones(idUsuario,Tipo) values(".$idUsuario.",0)";
			$x++;
		}
		$consulta[$x]="insert into 803_direcciones(idUsuario,Tipo) values(".$idUsuario.",1)";
		$x++;
		$consulta[$x]="insert into 806_fotos(idUsuario) values(".$idUsuario.")";
		$x++;
		if($telefonos!="")
		{
			$arrTelefonos=explode(",",$telefonos);
			$ct=sizeof($arrTelefonos);
			for($y=0;$y<$ct;$y++)
			{
				$datosTel=explode("_",$arrTelefonos[$y]);
				$tipo=$datosTel[0];
				$codArea=$datosTel[1];
				$lada=$datosTel[2];
				$tel=$datosTel[3];
				$ext=$datosTel[4];
				$consulta[$x]="	insert into 804_telefonos(codArea,Lada,Numero,Extension,Tipo,Tipo2,idUsuario) 
								values('".$codArea."','".$lada."','".$tel."','".$ext."',1,".$tipo.",".$idUsuario.")";
				$x++;
			}
		}
		
		
		$consulta[$x]="commit";
		$x++;
		

		if($con->ejecutarBloque($consulta))		
		{
			$query="Select u.idUsuario,u.login,u.Nombre,a.Institucion,a.codigoUnidad,u.status,u.cambiarDatosUsr 
					from 800_usuarios u,801_adscripcion a where a.idUsuario=u.idUsuario and u.idUsuario=".$idUsuario;
			$fila=$con->obtenerPrimeraFila($query);
			
			
			
			$query="select codigoRol from 807_usuariosVSRoles where idUsuario=".$idUsuario;
			$resRoles=$con->obtenerFilas($query);
			$listaGrupo="";
			while($fRoles=mysql_fetch_row($resRoles))
			{
				$arrRol=explode("_",$fRoles[0]);
				$rol="'".$fRoles[0]."'";
				if($arrRol[1]!="0")
					$rol.=",'".$arrRol[0]."_-1'";
				
				if($listaGrupo=="")
					$listaGrupo=$rol;
				else
					$listaGrupo.=",".$rol;
			}
			if($listaGrupo=="")
				$listaGrupo='-1';
			
			
			$arrParam["login"]=$mail;
			$arrParam["password"]=$password;
			$arrParam["nombreUsuario"]=$nombreC;
			$arrParam["idUsuario"]=$idUsuario;
			$arrParam["idActivacion"]=bE("cuenta:".$idUsuario);
			if(@enviarMensajeEnvio(17,$arrParam,"sendMensajeEnvioGmailJuzgado"))
			{
				echo "1|";
			}
			
			
		}
		else
			echo "|";
	}
	
	function obtenerInformacionExpedienteJuzgado()
	{
		global $con;
		$idExpediente=$_POST["idExpediente"];
		$cveMateria=$_POST["cveMateria"];

		$fDatosServidor=obtenerURLComunicacionServidorMateria($cveMateria);
		$url=$fDatosServidor[0].($fDatosServidor[1]!=""?":".$fDatosServidor[1]:"");
		$client = new nusoap_client("http://".$url."/webServices/wsInterconexionSistemasBPM.php?wsdl","wsdl");
		$parametros=array();
		$parametros["idExpediente"]=$idExpediente;

		
		$response = $client->call("obtenerInformacionExpedienteJuzgado", $parametros);

		$oResp=json_decode(utf8_encode($response));
		$arrExpedientes="";
		if($oResp->resultado==1)
		{

			
			echo "1|".$oResp->lblDetalle;
			return;
		}
		
		echo $oResp->mensaje;
		
	}
	
	
	function obtenerAudienciasVirtualesExpediente()
	{
		global $con;
		global $versionLatis;
		$cveMateria="PO";		
		$arrAudiencias="";
		$arrExpedientes="";
		$totalAudiencias=0;
		$fDatosServidor=obtenerURLComunicacionServidorMateria($cveMateria);
		$url=$fDatosServidor[0].($fDatosServidor[1]!=""?":".$fDatosServidor[1]:"");
		
		$arrUnidadGestion=array();
		$consulta="SELECT id__17_tablaDinamica,claveUnidad FROM _17_tablaDinamica";
		$res=$con->obtenerFilas($consulta);
		
		while($fila=mysql_fetch_assoc($res))
		{
			$arrUnidadGestion[$fila["id__17_tablaDinamica"]]=$fila["claveUnidad"];
		}
		$arrCarpetas=array();
		
		$client = new nusoap_client("http://".$url."/webServices/wsInterconexionSistemasBPM.php?wsdl","wsdl");
		$parametros=array();
		$consulta="SELECT * FROM 7006_usuariosVSCarpetasAdministrativas WHERE idUsuario=".$_SESSION["idUsr"].
					" AND cveMateria='".$cveMateria."'";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$oAux=array();
			$oAux["carpetaAdministrativa"]=$fila["carpetaAdministrativa"];
			$oAux["idCarpetaAdministrativa"]=$fila["idCarpetaAdministrativa"];
			$oAux["materia"]=$fila["cveMateria"];
			$oAux["unidadGestion"]=$fila["unidadGestion"];			
			array_push($arrCarpetas,$oAux);
			
			$o='{"carpetaAdministrativa":"'.$fila["carpetaAdministrativa"].'","idCarpeta":"'.$fila["idCarpetaAdministrativa"].'"}';
			if($arrExpedientes=="")
				$arrExpedientes=$o;
			else
				$arrExpedientes.=",".$o;
		}
		$arrExpedientes='{"arrExpedientes":['.$arrExpedientes.']}';
	
		$parametros["arrExpedientes"]=bE($arrExpedientes);
		$parametros["idUsuario"]=$_SESSION["idUsr"];
		
		$response = $client->call("obtenerAudienciasVirtualesJuzgadoMateria", $parametros);
		$oResp=json_decode(utf8_encode($response));

		if($oResp->resultado==1)
		{
			$numReg=0;
			$arrAudiencias="";
			foreach($oResp->arrAudiencias as $a)
			{
				$idCarpetaAdministrativa="";
				$oCarpeta=NULL;
				foreach($arrCarpetas as $c)
				{
					$unidadGestion=$arrUnidadGestion[$a->unidadGestion];
					if(($c["carpetaAdministrativa"]==$a->carpetaAdministrativa)&&($c["materia"]==$cveMateria)&&($c["unidadGestion"]==$unidadGestion))
					{
						$oCarpeta=$c;
						break;
					}
				}
				
				$idCarpetaAdministrativa=$oCarpeta["idCarpetaAdministrativa"];
				
				$consulta="SELECT codigoGenerado FROM 7006_usuariosVSAudienciasCodigoGenerado WHERE idUsuario=".$_SESSION["idUsr"].
							" AND idCarpetaAdministrativa=".$idCarpetaAdministrativa."
							AND carpetaAdministrativa='".$a->carpetaAdministrativa."' AND cveMateria='".$cveMateria."'
							and idEvento=".$a->idEvento;
				$codigoGenerado=$con->obtenerValor($consulta);
				
				$consulta="select HEX(AES_ENCRYPT('".$a->reunionID."_".$a->passwdReunion."', '".bD($versionLatis)."'))";
				$claveAcceso=$con->obtenerValor($consulta);
				
				$urlReunionVirtual="";
				if($a->reunionID!="")
					$urlReunionVirtual=$a->paginaMeeting."?meeting=".$claveAcceso;
				
				$o='{"idEvento":"'.$a->idEvento.'","carpetaAdministrativa":"'.$a->carpetaAdministrativa.'","fechaEvento":"'.$a->fechaEvento.
					'","horaInicial":"'.$a->horaInicial.'","horaFinal":"'.$a->horaFinal.'","horaInicioReal":"'.$a->horaInicioReal.
					'","horaTerminoReal":"'.$a->horaTerminoReal.'","urlMultimedia":"'.$a->urlMultimedia.'","tipoAudiencia":"'.$a->tipoAudiencia.
					'","sala":"'.$a->sala.'","unidadGestion":"'.$a->unidadGestion.'","situacion":"'.$a->situacion.
					'","juez":"'.$a->juez.'","edificio":"'.$a->edificio.'","codigoGenerado":"'.$codigoGenerado.'","idExpediente":"'.$idCarpetaAdministrativa.
					'","cveMateria":"'.$oCarpeta["materia"].'","urlReunionVirtual":"'.$urlReunionVirtual.'"}';
				if($arrAudiencias=="")
					$arrAudiencias=$o;
				else
					$arrAudiencias.=",".$o;
				$numReg++;
			}
			
			echo '{"numReg":"'.$numReg.'","registros":['.$arrAudiencias.']}';
			
		}
		
	}
	
	function generarCodigoAccesoAudienciaVirtual()
	{
		global $con;
		
		$idExpediente=$_POST["idExpediente"];
		$cveMateria=$_POST["cveMateria"];
		$idEvento=$_POST["idEvento"];
		$idUsuario=$_SESSION["idUsr"];
		$carpetaAdministrativa=$_POST["carpetaAdministrativa"];
		$fDatosServidor=obtenerURLComunicacionServidorMateria($cveMateria);
		$url=$fDatosServidor[0].($fDatosServidor[1]!=""?":".$fDatosServidor[1]:"");
		$client = new nusoap_client("http://".$url."/webServices/wsInterconexionSistemasBPM.php?wsdl","wsdl");
		$parametros=array();
		$parametros["idExpediente"]=$idExpediente;
		$parametros["idEvento"]=$idEvento;
		$parametros["idUsuario"]=$idUsuario;
		
		
		$response = $client->call("generarCodigoAccesoAudienciaVirtual", $parametros);

		$oResp=json_decode(utf8_encode($response));

		if($oResp->resultado==1)
		{
			$consulta="INSERT INTO 7006_usuariosVSAudienciasCodigoGenerado(idUsuario,idCarpetaAdministrativa,carpetaAdministrativa,cveMateria,codigoGenerado,fechaGeneracion,idEvento)
							VALUES(".$_SESSION["idUsr"].",".$idExpediente.",'".$carpetaAdministrativa."','".$cveMateria."','".$oResp->codigoGenerado."','".date("Y-m-d H:i:s")."',".$idEvento.")";
			
			if($con->ejecutarConsulta($consulta))
			{
				echo "1|".$oResp->codigoGenerado;
			}
		}
	}
	
?>