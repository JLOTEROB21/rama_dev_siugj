<?php session_start();
	
	include("conexionBD.php");
	include_once("nusoap/nusoap.php");
	include_once("sgjp/siajop.php");
	ini_set('default_socket_timeout', 160000);
	ini_set('post_max_size', '1024M');
	ini_set('upload_max_filesize', '1024M');
	include_once("latisErrorHandler.php");
	
	function obtenerDatosJuzgadoUGA($cveJuzgado)
	{
		global $con;
		$consulta="SELECT id__17_tablaDinamica,claveUnidad,nombreUnidad
					FROM _17_tablaDinamica u WHERE claveUnidad='".$cveJuzgado."'";
		
		$fDatos=$con->obtenerPrimeraFila($consulta);
		
		return '{"idUnidad":"'.$fDatos[0].'","claveUnidad":"'.$fDatos[1].'","nombreUnidad":"'.cv(utf8_encode($fDatos[2])).'"}';
				
	}
	
	function registrarPromocion($cadObj)
	{
		global $con;
		
		$obj=json_decode(utf8_encode($cadObj));		
		
		global $directorioInstalacion;	
		global $servidorPruebas;
		global $tipoMateria;
		$fechaActual=date("Y-m-d H:i:s");
		try
		{
			$consulta="SELECT idUsuario FROM 807_usuariosVSRoles WHERE idRol=-3000";
			$_SESSION["idUsr"]=$con->obtenerValor($consulta);
			if($_SESSION["idUsr"]=="")
				$_SESSION["idUsr"]=1;
			$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$_SESSION["idUsr"];
			
			$resRoles=$con->obtenerFilas($consulta);
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
			$_SESSION["idRol"]=$listaGrupo.",'-100_0'";
			$_SESSION["codigoUnidad"]="0001";
			$_SESSION["codigoInstitucion"]="0001";
			
			$arrDocumentosReferencia=array();			
			
			$arrValores=array();
			$idRegistroSolicitud=-1;			
			
			$consulta="SELECT COUNT(*) FROM _96_tablaDinamica WHERE idPromocionSICORE='".$obj->idPromocion."'";

			
			$nRegistro=$con->obtenerValor($consulta);
			$nRegistro=0;
			if($nRegistro>0)
			{
				$resultado='{"resultado":"2","mensaje":"La promoci&oacute;n ha sido registrada anteriormente","folioRegistro":"","fechaRecepcion":""}';
				return $resultado;
			}
			$idEtapaCambio=2;

			$datosDocumento=array();
			
			$datosDocumento["nombreDocumento"]=urldecode($obj->nombreDocumentoPromocion);
			$datosDocumento["descripcionDocumento"]="";//(string)$cXML->DatosSolicitud[0]->descripcionDocumento;
			$datosDocumento["contenido"]=$obj->documentoPromocion;
			$datosDocumento["contenidoPKCS7"]=$obj->documentoPromocionPKCS7;
			$idDocumentoServidor=-1;
			if($datosDocumento["contenido"]!="")
			{
				$idDocumento=generarNombreArchivoTemporal();
				$directorioDestino=$directorioInstalacion.'\\archivosTemporales\\'.$idDocumento;
				$datos=bD($datosDocumento["contenido"]);
				$f=file_put_contents($directorioDestino,$datos);
				
				if($f)
				{
					$idDocumentoServidor=registrarDocumentoServidorRepositorio($idDocumento,$datosDocumento["nombreDocumento"]);
					$consulta="UPDATE 908_archivos SET descripcion='".cv($datosDocumento["descripcionDocumento"])."' WHERE idArchivo=".$idDocumentoServidor;
					
					$con->ejecutarConsulta($consulta);
					if($datosDocumento["contenidoPKCS7"]!="")
					{
						$archivoOrigen=obtenerRutaDocumento($idDocumentoServidor);
						escribirContenidoArchivo($archivoOrigen.".pkcs7",bD($datosDocumento["contenidoPKCS7"]));
					}
				}
			}			
			
			$arrValores["asuntoPromocion"]=$obj->asunto;//(string)$cXML->DatosSolicitud[0]->carpetainvestigacion;
			
			$arrValores["numeroPromocion"]="";
			$arrValores["tipoPromociones"]=1;

			if($tipoMateria=="P")
			{
				
				$arrValores["tipoAudiencia"]=-1;
				$arrValores["carpetaAdministrativa"]=$obj->expediente;
				$arrValores["relacionPromocion"]=1;
				$arrValores["figuraPromovente"]=$obj->figuraPromovente;
			}
			else
			{
				$idEtapaCambio=1.5;
				$arrValores["idCarpetaAdministrativa"]=$obj->idExpediente;
			}
			$arrValores["idPromocionSICORE"]=$obj->idPromocion;
			
			$tipoAtencion=0;
			if($arrValores["tipoPromociones"]==2)
			{
				$consulta="SELECT tipoAtencion FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$tipoAudiencia;
				$tipoAtencion=$con->obtenerValor($consulta);
				if($tipoAtencion=="")
					$tipoAtencion=0;
			}
			
			$tipoSolicitud=0;
			if($tipoAtencion==2)
				$tipoSolicitud=2;
			else
				$tipoSolicitud=3;
			
			
	
			$consulta="SELECT count(*) FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$obj->expediente.
						"' and idCarpeta=".$obj->idExpediente;

			$nCarpeta=$con->obtenerValor($consulta);
			if($nCarpeta==0)
			{
				return '{"resultado":"0",mensaje":"La carpeta administrativa ingresada NO existe","folioRegistro":"","fechaRecepcion":""}';
			}
			
			$unidadGestionCarpeta=$obj->unidadGestion;		
			$fechaCreacion=$fechaActual;
			$fechaRecepcion=$fechaCreacion;

			if($tipoSolicitud!=2)
			{
				$fechaRecepcion=determinarFechaRecepcionDocumento($fechaCreacion,$obj->materia);
			}

			
			$arrValores["codigoInstitucion"]=$unidadGestionCarpeta;
			$arrValores["codigoUnidad"]=$unidadGestionCarpeta;
			
			$arrValores["usuarioPromovente"]=$obj->promovente;
			$arrValores["fechaCreacion"]=date("Y-m-d H:i:s",strtotime($fechaCreacion));
			$arrValores["fechaRecepcion"]=date("Y-m-d",strtotime($fechaRecepcion));
			$arrValores["horaRecepcion"]=date("H:i:s",strtotime($fechaRecepcion));		
			$arrValores["fechaHoraRecepcionPromocion"]=date("Y-m-d H:i:s",strtotime($fechaRecepcion));
			
			if($con->existeCampo("idExpediente","_96_tablaDinamica"))
			{
				$arrValores["idExpediente"]=$obj->idExpediente;		
			}
			else
			{
				if($con->existeCampo("idCarpeta","_96_tablaDinamica"))
					$arrValores["idCarpeta"]=$obj->idExpediente;	
			}
			
			$consulta="SELECT idActorProcesoEtapa FROM 944_actoresProcesoEtapa WHERE idProceso=103 AND actor IN('57_0') AND numEtapa=1";
			$idActorProcesoEtapa=$con->obtenerValor($consulta);
			$idRegistroSolicitud=crearInstanciaRegistroFormulario(96,-1,$idEtapaCambio,$arrValores,$arrDocumentosReferencia,-1,$idActorProcesoEtapa);

			if($idDocumentoServidor!=-1)
			{
				registrarDocumentoResultadoProceso(96,$idRegistroSolicitud,$idDocumentoServidor);
				
			}
			
			
			
			
			/*if(!$servidorPruebas)
			{
				if($tipoSolicitud==2)
				{
					
					$unidadGestion=asignarCarpetaGuardiaV3($arrValores["carpetaAdministrativa"],$arrValores["fechaCreacion"]);
					if($unidadGestion!=-1)
					{
						@asignarCarpetaUnidadGestionGuardia($arrValores["carpetaAdministrativa"],$unidadGestion);
					}
					@enviarCorreoWebServicesSolicitudPromocionUrgente($idRegistroSolicitud);
					
					//cambiarEtapaFormulario(96,$idRegistroSolicitud,5,"",-1,"NULL","NULL",704);
					
				}
				
				
			}*/
			


			$consulta="SELECT idActorProcesoEtapa FROM 944_actoresProcesoEtapa WHERE idProceso=103 AND actor IN('118_0','57_0','157_0') AND numEtapa=1";
			$idActorProcesoEtapa=$con->obtenerValor($consulta);
			if($tipoMateria!="SC")
				cambiarEtapaFormulario(96,$idRegistroSolicitud,100,"",-1,"NULL","NULL",$idActorProcesoEtapa);
			cambiarEtapaFormulario(96,$idRegistroSolicitud,$idEtapaCambio,"",-1,"NULL","NULL",$idActorProcesoEtapa);
			return '{"resultado":"1","mensaje":"","folioRegistro":"'.$idRegistroSolicitud.'","fechaRecepcion":"'.date("Y-m-d H:i:s",strtotime($fechaRecepcion)).'"}';
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","mensaje":"'.str_replace("\\","\\\\",$e->getMessage()).'","folioRegistro":"","fechaRecepcion":""}';
			
			
		}
		
		
		
	}
	
	function registrarRespuestaPromocion($cadObj)
	{
		global $con;
		
		$obj=json_decode($cadObj);		
		
		global $directorioInstalacion;	
		global $servidorPruebas;
		global $versionLatis;
		
		$fechaActual=strtotime(date("Y-m-d H:i:s"));
		try
		{
			$consulta="SELECT idUsuario FROM 807_usuariosVSRoles WHERE idRol=-3000";
			$_SESSION["idUsr"]=$con->obtenerValor($consulta);
			if($_SESSION["idUsr"]=="")
				$_SESSION["idUsr"]=1;
			$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$_SESSION["idUsr"];

			$resRoles=$con->obtenerFilas($consulta);
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
			$_SESSION["idRol"]=$listaGrupo.",'-100_0'";
			$_SESSION["codigoUnidad"]="0001";
			$_SESSION["codigoInstitucion"]="0001";

			$arrDocumentosReferencia=array();			
			
			$arrValores=array();
			$idRegistroSolicitud=-1;			

			/*$consulta="SELECT count(*) FROM 7071_promocionesRegistradasUsuario WHERE idRegistro=".$obj->idPromocion." AND situacionPromocion=3";
			$nRegistro=$con->obtenerValor($consulta);
			if($nRegistro>0)
			{
				$resultado='{"resultado":"1","mensaje":""}';
				return $resultado;
			}*/

			$datosDocumento=array();			
			$datosDocumento["nombreDocumento"]=$obj->nombreDocumentoPromocion;
			$datosDocumento["descripcionDocumento"]="";//(string)$cXML->DatosSolicitud[0]->descripcionDocumento;
			$datosDocumento["contenido"]=$obj->documentoPromocion;
			$datosDocumento["contenidoPKCS7"]=$obj->documentoPromocionPKCS7;
			$idDocumentoServidor=-1;

			if($datosDocumento["contenido"]!="")
			{
				$idDocumento=generarNombreArchivoTemporal();
				$directorioDestino=$directorioInstalacion.'\\archivosTemporales\\'.$idDocumento;
				$datos=bD($datosDocumento["contenido"]);
				$f=file_put_contents($directorioDestino,$datos);
				
				if($f)
				{
					$idDocumentoServidor=registrarDocumentoServidorRepositorio($idDocumento,$datosDocumento["nombreDocumento"],6);
					if($datosDocumento["contenidoPKCS7"]!="")
					{
						$archivoOrigen=obtenerRutaDocumento($idDocumentoServidor);
						escribirContenidoArchivo($archivoOrigen.".pkcs7",bD($datosDocumento["contenidoPKCS7"]));
					}
				}
			}		
				
			$consulta="UPDATE 7071_promocionesRegistradasUsuario SET situacionPromocion=3,fechaRespuesta='".date("Y-m-d H:i:s",$fechaActual).
					"',idDocumentoRespuesta=".$idDocumentoServidor." WHERE idRegistro=".$obj->idPromocion;

			if($con->ejecutarConsulta($consulta))
			{
				$consulta="SELECT expediente,cveUnidadGestion,cveMateria,idUsuarioRegistro FROM 7071_promocionesRegistradasUsuario WHERE idRegistro=".$obj->idPromocion;
				$fCarpeta=$con->obtenerPrimeraFila($consulta);
				$idUsuario=$fCarpeta[3];
				$consulta="SELECT Login,AES_DECRYPT(UNHEX(Password), '".bD($versionLatis)."'),Nombre FROM 800_usuarios WHERE idUsuario=".$idUsuario;
				$fUsr=$con->obtenerPrimeraFila($consulta);
				
				$nombreJuzgado="";
				$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$fCarpeta[1]."'";
				$fNombreJuzgado=$con->obtenerPrimeraFila($consulta);
				if($fNombreJuzgado)
				{
					$nombreJuzgado=$fNombreJuzgado[0];
				}
				else
				{
					$nombreJuzgado=obtenerNombreJuzgadoWS($fCarpeta[1],$fCarpeta[2]);
				}
				
				$arrParam["carpeta"]=$fCarpeta[0];
				$arrParam["juzgado"]=$nombreJuzgado;
				$arrParam["nombreUsuario"]=$fUsr[2];
				$arrParam["idUsuario"]=$idUsuario;
				@enviarMensajeEnvio(16,$arrParam,"sendMensajeEnvioGmailJuzgado",true);
				
				
				$consulta="SELECT * FROM 7071_promocionesRegistradasUsuario WHERE idRegistro=".$obj->idPromocion;
				$fPromocion=$con->obtenerPrimeraFilaAsoc($consulta);
				
				
				@registrarNotificacionAvisoRespuestaPromocionRecibida(5,"Respuesta a promoci&oacute;n recibida",$fPromocion["idUsuarioRegistro"],$fPromocion["expediente"],$obj->idPromocion);
				
				return '{"resultado":"1","mensaje":""}';
			}
			return '{"resultado":"0","mensaje":"Error desconocido"}';
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","mensaje":"'.str_replace("\\","\\\\",$e->getMessage()).'"}';
			
			
		}
		
		
		
	}
	
	function registrarCuentaAcceso($cadObj)
	{
		global $con;
		global $versionLatis;
		$cadObj=utf8_encode($cadObj);
		
		$obj=json_decode($cadObj);		
		
		$consulta="SELECT idUsuario FROM 807_usuariosVSRoles WHERE idRol=-3000";
		$_SESSION["idUsr"]=$con->obtenerValor($consulta);
		if($_SESSION["idUsr"]=="")
			$_SESSION["idUsr"]=1;
		$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$_SESSION["idUsr"];

		$resRoles=$con->obtenerFilas($consulta);
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
		$_SESSION["idRol"]=$listaGrupo.",'-100_0'";
		$_SESSION["codigoUnidad"]="0001";
		$_SESSION["codigoInstitucion"]="0001";
		global $directorioInstalacion;	
		global $servidorPruebas;
		try
		{
			$consulta="SELECT idUsuario FROM 800_usuarios WHERE idParticipanteSubsistema=".$obj->idParticipante;
			$idUsuario=$con->obtenerValor($consulta);
			$IDMail=13;
			if($idUsuario=="")
			{
				$IDMail=12;
				$login="";
				$arrMail=explode(",",$obj->email);
				
				if($obj->validarUsuarioMail==1)
				{
					$listaMail="";
					foreach($arrMail as $m)
					{
						if($listaMail=='')
							$listaMail="'".$m."'";
						else
							$listaMail.=",'".$m."'";
					}
					
					$arrUsuariosConcidencia="";
					$consulta="SELECT u.idUsuario,u.Nombre FROM 805_mails m,800_usuarios u WHERE m.Mail IN(".$listaMail.") AND u.idUsuario=m.idUsuario ORDER BY u.Nombre";
					$resMail=$con->obtenerFilas($consulta);
					while($fMail=mysql_fetch_row($resMail))
					{
						$consulta="SELECT Mail FROM 805_mails WHERE idUsuario=".$fMail[0]." AND Mail IN(".$listaMail.")";
						$mails=$con->obtenerListaValores($consulta);
						
						$oMail='{"idUsuario":"'.$fMail[0].'","nombre":"'.$fMail[1].'","mails":"'.$mails.'"}';
						if($arrUsuariosConcidencia=="")
							$arrUsuariosConcidencia=$oMail;
						else
							$arrUsuariosConcidencia.=",".$oMail;
					}
					
					if($arrUsuariosConcidencia!="")
					{
						return '{"resultado":"2","mensaje":"","idUsuarioSistema":"","arrUsuarioSistema":['.$arrUsuariosConcidencia.']}'; //ok
					}
					
				}
				
				foreach($arrMail as $m)
				{
					$consulta="SELECT COUNT(*) FROM 800_usuarios WHERE Login='".trim($m)."'";	
					$nMails=$con->obtenerValor($consulta);
					if($nMails==0)
					{
						$login=$m;
						break;
					}
				}
				if($login=="")
				{
					$nMails=1;
					while($nMails>0)
					{
						$login=rand(0,9999)."_".$arrMail[0];
						$consulta="SELECT COUNT(*) FROM 800_usuarios WHERE Login='".trim($login)."'";	
						$nMails=$con->obtenerValor($consulta);
					}
				}
				$passwd=generarPassword();
				$consulta="select HEX(AES_ENCRYPT('".$passwd."', '".bD($versionLatis)."'))";
				$passwd=$con->obtenerValor($consulta);
				
				$roles="152";
				if(isset($obj->roles))
				{
					$roles=$obj->roles;
				}
				
				if($roles=="")
					$roles="-1000";
				else
					$roles.=",-1000";
				
				$idUsuario=crearBaseUsuario($obj->apPaterno,$obj->apMaterno,$obj->nombre,$obj->email,"0000","",$roles,$login,$passwd);
				$consulta="UPDATE 800_usuarios SET cuentaActiva=1,cambiarDatosUsr=2,idParticipanteSubsistema=".$obj->idParticipante." WHERE idUsuario=".$idUsuario;
				$con->ejecutarConsulta($consulta);
			}
			$consulta="SELECT idRegistro FROM 7006_paquetesContratados WHERE idUsuario=".$_SESSION["idUsr"]." AND idPaquete=0";
			$idPaquete=$con->obtenerValor($consulta);
			
			if($idPaquete=="")
			{
				$consulta="INSERT INTO 7006_paquetesContratados(idUsuario,idPaquete,fechaContratacion,totalExpedientes,situacion,folioPaquete)
						VALUES(".$idUsuario.",0,'".date("Y-m-d H:i:s")."',0,1,'UNICO')";
				$con->ejecutarConsulta($consulta);		
				$idPaquete=$con->obtenerUltimoID();
			}
			
			
			$nombreJuzgado="";
			$consulta="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$obj->unidadGestion."'";
			$fNombreJuzgado=$con->obtenerPrimeraFila($consulta);
			if(!$fNombreJuzgado)
			{
				
				obtenerNombreJuzgadoWS($obj->unidadGestion,$obj->cveMateria);
			}
			
			
			$consulta="INSERT INTO 7006_usuariosVSCarpetasAdministrativas(idUsuario,idCarpetaAdministrativa,carpetaAdministrativa,cveMateria,situacion,
					unidadGestion,anioExpediente,idUsuarioExpediente,idFiguraExpediente,lblFiguraExpediente,detalleExpediente,idDetalleFigura,lblDetalleFigura,idPaquete,folioSolicitud)
					VALUES(".$idUsuario.",".$obj->idCarpeta.",'".$obj->carpeta."','".$obj->cveMateria."',1,'".$obj->unidadGestion.
					"',".$obj->anioExpediente.",".$obj->idParticipante.",".$obj->idFiguraJuridica.",'".$obj->lblFiguraExpediente.
					"','".cv($obj->detalleExpediente)."',".($obj->idDetalleFigura==""?"NULL":$obj->idDetalleFigura).",'".cv($obj->lblDetalleFigura)."',".$idPaquete.",'----')";
					
			if($con->ejecutarConsulta($consulta))
			{
				$consulta="SELECT Login,AES_DECRYPT(UNHEX(Password), '".bD($versionLatis)."'),Nombre FROM 800_usuarios WHERE idUsuario=".$idUsuario;
				$fUsr=$con->obtenerPrimeraFila($consulta);
				
				$arrParam["login"]=$fUsr[0];
				$arrParam["password"]=$fUsr[1];
				$arrParam["nombreUsuario"]=$fUsr[2];
				$arrParam["idUsuario"]=$idUsuario;
				@enviarMensajeEnvio($IDMail,$arrParam,"sendMensajeEnvioGmailJuzgado",true);
				return '{"resultado":"1","mensaje":"","idUsuarioSistema":"'.$idUsuario.'"}'; //ok
			}
			
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","mensaje":"'.str_replace("\\","\\\\",$e->getMessage()).'"}';
			
			
		}
		
		
		
	}
	
	function modificarCuentaAccesoCarpeta($cadObj)
	{
		global $con;
		global $versionLatis;
		
		$obj=json_decode($cadObj);		
		
		global $directorioInstalacion;	
		global $servidorPruebas;
		try
		{
			$consulta="SELECT carpetaAdministrativa,unidadGestion,cveMateria FROM 7006_usuariosVSCarpetasAdministrativas WHERE idUsuario=".$obj->idUsuario.
					" AND cveMateria='".$obj->cveMateria."' AND unidadGestion='".$obj->unidadGestion."' and idFiguraExpediente=".$obj->idFiguraJuridica.
					" AND idCarpetaAdministrativa= ".$obj->idCarpeta;
			$fCarpeta=$con->obtenerPrimeraFila($consulta);
			
			
			$nombreJuzgado="";
			$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$fCarpeta[1]."'";
			$fNombreJuzgado=$con->obtenerPrimeraFila($consulta);
			if($fNombreJuzgado)
			{
				$nombreJuzgado=$fNombreJuzgado[0];
			}
			else
			{
				$nombreJuzgado=obtenerNombreJuzgadoWS($fCarpeta[1],$fCarpeta[2]);
			}
			
			$consulta="	UPDATE 7006_usuariosVSCarpetasAdministrativas SET situacion=".$obj->situacion.
						" WHERE idUsuario=".$obj->idUsuario." and cveMateria='".$obj->cveMateria."' and idCarpetaAdministrativa=".$obj->idCarpeta." AND 
						unidadGestion='".$obj->unidadGestion."' and idFiguraExpediente=".$obj->idFiguraJuridica;
			if($con->ejecutarConsulta($consulta))
			{
				$consulta="SELECT Login,AES_DECRYPT(UNHEX(Password), '".bD($versionLatis)."'),Nombre FROM 800_usuarios WHERE idUsuario=".$obj->idUsuario;
				$fUsr=$con->obtenerPrimeraFila($consulta);
				$arrParam["carpeta"]=$fCarpeta[0];
				$arrParam["juzgado"]=$nombreJuzgado;
				
				$arrParam["carpetaHabilitada"]=$arrParam["carpeta"];
				$arrParam["juzgadoCarpeta"]=$arrParam["juzgado"];
				$arrParam["nombreUsuario"]=$fUsr[2];
				$arrParam["idUsuario"]=$obj->idUsuario;
				@enviarMensajeEnvio(($obj->situacion==1?13:14),$arrParam,"sendMensajeEnvioGmailJuzgado",true);
				return '{"resultado":"1","mensaje":""}';
			}
			
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","mensaje":"'.str_replace("\\","\\\\",$e->getMessage()).'"}';
			
			
		}
		
		
		
	}
	
	function obtenerJuzgadosMateria($cveMateria)
	{
		try
		{
			global $con;
			$arrFiguras="";
			$consulta="SELECT id__5_tablaDinamica,nombreTipo FROM _5_tablaDinamica WHERE permiteAccesoExpediente=1 ORDER BY nombreTipo";
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				$consulta="SELECT idDetalle,etiquetaDetalle FROM _5_gDetallesTipo WHERE idReferencia=".$fila[0];
				$arrDetalle=$con->obtenerFilasArreglo($consulta);
				
				$consulta="SELECT idOpcion FROM _5_tiposFiguras WHERE idPadre=".$fila[0];
				$lRelacion=$con->obtenerListaValores($consulta);
				
				$o="['".$fila[0]."','".cv($fila[1])."',".$arrDetalle.",'".$lRelacion."']";
				if($arrFiguras=="")
				{
					$arrFiguras=$o;
				}
				else
				{
					$arrFiguras.=",".$o;
				}
			}
			
			
			$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica u,_17_gridDelitosAtiende g WHERE
					g.tipoDelito='".$cveMateria."' AND g.idReferencia=u.id__17_tablaDinamica ORDER BY prioridad";
			
			$arrUnidades=utf8_encode($con->obtenerFilasJSON($consulta));
			
			return '{"resultado":"1","mensaje":"","arrJuzgados":'.$arrUnidades.',"arrFiguras":"'.bE($arrFiguras).'"}';
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","mensaje":"'.$e->getMessage().'"}';
			
			
		}
		
	}
	
	function obtenerExpedientesJuzgado($cveJuzgado,$anio)
	{
		try
		{
			
			global $con;
			global $tipoMateria;
			$victimas="";
			$imputados="";
			$delito="";
			$arrExpedientes="";
			
			if($tipoMateria!="P")
			{
				$consulta="SELECT idCarpeta,carpetaAdministrativa,idActividad,idFormulario,idRegistro FROM 7006_carpetasAdministrativas 
						WHERE unidadGestion='".$cveJuzgado."' and tipoCarpetaAdministrativa=1 AND carpetaAdministrativa 
						LIKE '%/".$anio."' ORDER BY carpetaAdministrativa";
			}
			else
			{
				$consulta="SELECT idCarpeta,carpetaAdministrativa,idActividad,idFormulario,idRegistro FROM 7006_carpetasAdministrativas 
						WHERE unidadGestion='".$cveJuzgado."' and tipoCarpetaAdministrativa=1 AND fechaCreacion>='".$anio."-01-01' 
						and fechaCreacion<='".$anio."-12-31 23:59:59' ORDER BY carpetaAdministrativa";
			}

			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				
				$o='{"idCarpeta":"'.$fila[0].'","carpetaAdministrativa":"'.$fila[1].'","idActividad":"'.$fila[2].'"}';
				
				if($arrExpedientes=="")
					$arrExpedientes=$o;
				else
					$arrExpedientes.=",".$o;
			}
			
			return '{"resultado":"1","mensaje":"","arrExpedientes":['.$arrExpedientes.']}';
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","mensaje":"'.$e->getMessage().'"}';
			
			
		}
		
	}
	
	function obtenerParticipantesExpedientes($idExpediente,$figuraJuridica)
	{
		try
		{
			global $con;
			$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE idCarpeta=".$idExpediente;
			$idActividad=$con->obtenerValor($consulta);
			$consulta="SELECT id__47_tablaDinamica as idParticipante,CONCAT(IF(nombre IS NULL,'',nombre),' ',
				IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno)) as nombre FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
				WHERE r.idActividad=".$idActividad." and idFiguraJuridica in(".$figuraJuridica.") AND r.idParticipante=p.id__47_tablaDinamica
				 order by nombre,apellidoPaterno,apellidoMaterno";
			$arrParticipantes=utf8_encode($con->obtenerFilasJSON($consulta));	
			return '{"resultado":"1","mensaje":"","arrParticipantes":'.$arrParticipantes.'}';
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","mensaje":"'.$e->getMessage().'"}';
			
			
		}
		
	}
	
	function registrarSolicitudAcceso($cadObj)
	{
		try
		{
			global $con;
			global $directorioInstalacion;
			
			$obj=json_decode(utf8_encode($cadObj));
			

			$consulta="SELECT idUsuario FROM 807_usuariosVSRoles WHERE idRol=-3000";
			$_SESSION["idUsr"]=$con->obtenerValor($consulta);
			if($_SESSION["idUsr"]=="")
				$_SESSION["idUsr"]=1;
			$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$_SESSION["idUsr"];
			
			$resRoles=$con->obtenerFilas($consulta);
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
			$_SESSION["idRol"]=$listaGrupo.",'-100_0'";
			$_SESSION["codigoUnidad"]="0001";
			$_SESSION["codigoInstitucion"]="0001";

			$consulta="SELECT idFormulario FROM 900_formularios WHERE categoriaFormulario=4";
			$idFormulario=$con->obtenerValor($consulta);
			
			$idProceso=obtenerIdProcesoFormulario($idFormulario);
			
			$x=0;
			$query[$x]="begin";
			$x++;
			
			if($obj->idUsuarioExpediente==-1)
			{
				
				
				$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE idCarpeta=".$obj->idExpediente;
				$idActividad=$con->obtenerValor($consulta);
				if($idActividad=="")
					$idActividad=-1;
				if($idActividad==-1)
				{
					$idActividad=generarIDActividad(-7006);
					$consulta="UPDATE 7006_carpetasAdministrativas SET idActividad=".$idActividad." WHERE idCarpeta=".$obj->idExpediente;
					$con->ejecutarConsulta($consulta);
					
					
				}
				
				
				$objPersona=$obj->oIdentifica[0];
				$query[$x]="INSERT INTO _47_tablaDinamica(tipoPersona,apellidoPaterno,apellidoMaterno,nombre,genero,otraNacionalidad,esMexicano,idActividad,
				figuraJuridica,tipoDefensor,curp,cedulaProfesional,rfcEmpresa,fechaNacimiento,edad,estadoCivil,tipoIdentificacion,otraIdentificacion) 
				VALUES(1,'".cv(trim($objPersona->apPaterno))."','".cv(trim($objPersona->apMaterno))."','".cv(trim($objPersona->nombre))."',
				".($objPersona->Genero==""?2:$objPersona->Genero).",'',3,".$idActividad.",".$obj->idFiguraJuridica.
				",".($obj->detalleFigura==""?"NULL":$obj->detalleFigura).",'".cv($objPersona->CURP)."',".($objPersona->cedulaProf==""?"NULL":"'".cv($objPersona->cedulaProf)."'")
				.",'".cv($objPersona->RFC)."',".($objPersona->fechaNacimiento==""?"NULL":"'".$objPersona->fechaNacimiento."'").",NULL,9999,'".
				$objPersona->tipoIdentificacion."','')";
				
				
				
				$x++;
				
				$query[$x]="set @idParticipante:=(select last_insert_id())";
				$x++;
				
				$query[$x]="INSERT INTO 7005_relacionFigurasJuridicasSolicitud(idActividad,idParticipante,idFiguraJuridica,situacion)
							VALUES(".$idActividad.",@idParticipante,".$obj->idFiguraJuridica.",0)";
				$x++;
				
				$query[$x]="INSERT INTO 7005_bitacoraCambiosFigurasJuridicas(idActividad,idParticipante,idFiguraJuridica,idActorRelacionado,
							situacionAnterior,situacionActual,fechaCambio,responsableCambio,comentariosAdicionales) values
							(".$idActividad.",@idParticipante,".$obj->idFiguraJuridica.",-1,NULL,1,'".date("Y-m-d H:i:s").
							"',".$_SESSION["idUsr"].",'')";
				$x++;
				
				if($obj->relacionadoCon!="")
				{
					
					$query[$x]="INSERT INTO 7005_relacionParticipantes(idActividad,idParticipante,idFiguraJuridica,idActorRelacionado,situacion)
						VALUES(".$idActividad.",@idParticipante,".$obj->idFiguraJuridica.",".$obj->relacionadoCon.",1)";
					$x++;
					$query[$x]="INSERT INTO 7005_bitacoraCambiosFigurasJuridicas(idActividad,idParticipante,idFiguraJuridica,idActorRelacionado,
						situacionAnterior,situacionActual,fechaCambio,responsableCambio,comentariosAdicionales) values
						(".$idActividad.",@idParticipante,".$obj->idFiguraJuridica.",".$obj->relacionadoCon.",NULL,1,'".date("Y-m-d H:i:s").
						"',".$_SESSION["idUsr"].",'')";
					$x++;
				
				}
				
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
			}
			else
			{
				$query[$x]="set @idParticipante:=".$obj->idUsuarioExpediente;
				$x++;
			}
			
			$query[$x]="commit";
			$x++;
			
			if($con->ejecutarBloque($query))
			{
				
				$consulta="select @idParticipante";
				$idUsuarioExpediente=$con->obtenerValor($consulta);
				
				$arrDocumentosReferencia=array();			
				
				$arrValores=array();
				$idRegistroSolicitud=-1;			
				
				$consulta="SELECT COUNT(*) FROM _".$idFormulario."_tablaDinamica WHERE idRegistroSolicitud='".$obj->idRegistro."'";
				$nRegistro=$con->obtenerValor($consulta);
				$nRegistro=0;
				if($nRegistro>0)
				{
					$resultado='{"resultado":"2","mensaje":"La promoci&oacute;n ha sido registrada anteriormente","folioRegistro":"","fechaRecepcion":""}';
					return $resultado;
				}
				
	
				$datosDocumento=array();
				
				$datosDocumento["nombreDocumento"]=urldecode($obj->nombreDocumento);
				$datosDocumento["descripcionDocumento"]="";//(string)$cXML->DatosSolicitud[0]->descripcionDocumento;
				$datosDocumento["contenido"]=$obj->documento;
				$datosDocumento["contenidoPKCS7"]=$obj->documentoPKCS7;
				$idDocumentoServidor=-1;
				if($datosDocumento["contenido"]!="")
				{
					$idDocumento=generarNombreArchivoTemporal();
					$directorioDestino=$directorioInstalacion.'\\archivosTemporales\\'.$idDocumento;
					$datos=bD($datosDocumento["contenido"]);
					$f=file_put_contents($directorioDestino,$datos);
					
					if($f)
					{
						$idDocumentoServidor=registrarDocumentoServidorRepositorio($idDocumento,$datosDocumento["nombreDocumento"]);
						$consulta="UPDATE 908_archivos SET descripcion='".cv($datosDocumento["descripcionDocumento"])."' WHERE idArchivo=".$idDocumentoServidor;
						
						$con->ejecutarConsulta($consulta);
						if($datosDocumento["contenidoPKCS7"]!="")
						{
							$archivoOrigen=obtenerRutaDocumento($idDocumentoServidor);
							escribirContenidoArchivo($archivoOrigen.".pkcs7",bD($datosDocumento["contenidoPKCS7"]));
						}
					}
				}			
				
				$arrValores["codigoInstitucion"]=$obj->unidadGestion;
				$arrValores["codigoUnidad"]=$obj->unidadGestion;
				$arrValores["folioSolicitud"]=$obj->folioSolicitud;
				$arrValores["idSolicitante"]=$idUsuarioExpediente;
				$arrValores["idFiguraJuridica"]=$obj->idFiguraJuridica;
				$arrValores["detalleFigura"]=$obj->detalleFigura==""?-1:$obj->detalleFigura;
				$arrValores["relacionadoCon"]=$obj->relacionadoCon==""?-1:$obj->relacionadoCon;
				$arrValores["expediente"]=$obj->expediente;		
				$arrValores["idExpediente"]=$obj->idExpediente;
				$arrValores["idRegistroSolicitud"]=$obj->idRegistro;
				
				$consulta="SELECT idActorProcesoEtapa FROM 944_actoresProcesoEtapa WHERE idProceso=".$idProceso." AND actor IN('-3000_0') AND numEtapa=1";
				$idActorProcesoEtapa=$con->obtenerValor($consulta);
				
				$idRegistroSolicitud=crearInstanciaRegistroFormulario($idFormulario,-1,1,$arrValores,$arrDocumentosReferencia,-1,$idActorProcesoEtapa);
	
				if($idDocumentoServidor!=-1)
				{
					registrarDocumentoResultadoProceso($idFormulario,$idRegistroSolicitud,$idDocumentoServidor);
					
					
				}
				
				
				return '{"resultado":"1","mensaje":"","idUsuarioExpediente":"'.$idUsuarioExpediente.'","fechaRecepcion":"'.date("Y-m-d H:i:s").'"}';
			}
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","mensaje":"'.$e->getMessage().'"}';
			
			
		}
	}
	
	
	function registarAutorizacionAcceso($cadObj)
	{
		global $con;
		global $versionLatis;
		
		$obj=json_decode($cadObj);		
		
		global $directorioInstalacion;	
		global $servidorPruebas;
		try
		{
			$consulta="SELECT carpetaAdministrativa,unidadGestion,cveMateria,idUsuario,comentariosAutorizacion FROM 7006_usuariosVSCarpetasAdministrativas 
					WHERE idRegistro= ".$obj->idSolicitudAcceso;
			$fCarpeta=$con->obtenerPrimeraFila($consulta);			
			
			$nombreJuzgado="";
			$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$fCarpeta[1]."'";
			$fNombreJuzgado=$con->obtenerPrimeraFila($consulta);
			if($fNombreJuzgado)
			{
				$nombreJuzgado=$fNombreJuzgado[0];
			}
			else
			{
				$nombreJuzgado=obtenerNombreJuzgadoWS($fCarpeta[1],$fCarpeta[2]);
			}
			
			$consulta="	UPDATE 7006_usuariosVSCarpetasAdministrativas SET comentariosAutorizacion='".cv($obj->comentarios)."',situacion=".
						($obj->resultado!=1?6:1).",fechaRespuesta='".date("Y-m-d H:i:s")."' WHERE idRegistro=".$obj->idSolicitudAcceso;
			if($con->ejecutarConsulta($consulta))
			{
				$consulta="SELECT Login,AES_DECRYPT(UNHEX(Password), '".bD($versionLatis)."'),Nombre FROM 800_usuarios WHERE idUsuario=".$fCarpeta[3];
				$fUsr=$con->obtenerPrimeraFila($consulta);
				$arrParam["expediente"]=$fCarpeta[0];
				$arrParam["juzgado"]=$nombreJuzgado;
				
				$arrParam["carpetaHabilitada"]=$arrParam["expediente"];
				$arrParam["juzgadoCarpeta"]=$arrParam["juzgado"];
				$arrParam["nombreUsuario"]=$fUsr[2];
				$arrParam["idUsuario"]=$fCarpeta[3];
				$arrParam["login"]=$fUsr[0];
				$arrParam["password"]=$fUsr[1];
				$arrParam["comentarios"]=trim($obj->comentarios)==""?"(Sin comentarios)":trim($obj->comentarios);
				@enviarMensajeEnvio(($obj->resultado==1?18:19),$arrParam,"sendMensajeEnvioGmailJuzgado",true);
				return '{"resultado":"1","mensaje":""}';
			}
			
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","mensaje":"'.str_replace("\\","\\\\",$e->getMessage()).'"}';
		}
		
		
		
	}
	
	function registarPublicacionAcuerdo($cadObj)
	{
		global $con;
		global $versionLatis;
		global $urlSitio;
		
		$consulta="SELECT idUsuario FROM 807_usuariosVSRoles WHERE idRol=-3000";
		$_SESSION["idUsr"]=$con->obtenerValor($consulta);
		if($_SESSION["idUsr"]=="")
			$_SESSION["idUsr"]=1;
		$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$_SESSION["idUsr"];
		
		$resRoles=$con->obtenerFilas($consulta);
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
		$_SESSION["idRol"]=$listaGrupo.",'-100_0'";
		$_SESSION["codigoUnidad"]="0001";
		$_SESSION["codigoInstitucion"]="0001";
		
		
		$obj=json_decode($cadObj);		
		$idDocumentoServidor=-1;
		global $directorioInstalacion;	
		global $servidorPruebas;
		try
		{
			$consulta="SELECT * FROM 7006_usuariosVSCarpetasAdministrativas WHERE idCarpetaAdministrativa=".$obj->idExpediente.
					" AND cveMateria='".$obj->cveMateria."' AND unidadGestion='".$obj->unidadGestion."'
					AND situacion=1";
					
			$res=$con->obtenerFilas($consulta);
			if($con->filasAfectadas>0)
			{
				if($obj->contenido!="")
				{
					$idDocumento=generarNombreArchivoTemporal();
					$directorioDestino=$directorioInstalacion.'\\archivosTemporales\\'.$idDocumento;
					$datos=bD($obj->contenido);
					$f=file_put_contents($directorioDestino,$datos);
					
					if($f)
					{
						$idDocumentoServidor=registrarDocumentoServidorRepositorio($idDocumento,$obj->nombreDocumento,6);
						if($obj->contenidoPKCS7!="")
						{
							$archivoOrigen=obtenerRutaDocumento($idDocumentoServidor);
							escribirContenidoArchivo($archivoOrigen.".pkcs7",bD($obj->contenidoPKCS7));
						}
					}
				}	
			}
			while($fila=mysql_fetch_assoc($res))		
			{
				$consulta="SELECT Login,AES_DECRYPT(UNHEX(Password), '".bD($versionLatis)."'),Nombre 
						FROM 800_usuarios WHERE idUsuario=".$fila["idUsuario"];
				$fUsr=$con->obtenerPrimeraFila($consulta);
				
				
				$nombreJuzgado="";
				$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$fila["unidadGestion"]."'";
				$fNombreJuzgado=$con->obtenerPrimeraFila($consulta);
				if($fNombreJuzgado)
				{
					$nombreJuzgado=$fNombreJuzgado[0];
				}
				else
				{
					$nombreJuzgado=obtenerNombreJuzgadoWS($fila["unidadGestion"],$fila["cveMateria"]);
				}
				$consulta="SELECT COUNT(*) FROM 7072_acuerdoGeneradosExpedientes WHERE idUsuario=".$fila["idUsuario"].
						" AND idRegistroAcuerdo=".$obj->idRegistroAcuerdo." and idExpediente=".$fila["idCarpetaAdministrativa"]."
						and cveJuzgado=".$fila["unidadGestion"];
				$nReg=$con->obtenerValor($consulta);
				if($nReg==0)
				{
					$consulta="INSERT INTO 7072_acuerdoGeneradosExpedientes(fechaRegistro,idUsuario,idExpediente,expediente,idDocumentoAcuerdo,
							cveJuzgado,fechaAcuerdo,idRegistroAcuerdo)
							VALUES('".date("Y-m-d H:i:s")."',".$fila["idUsuario"].",".$fila["idCarpetaAdministrativa"].",'".$fila["carpetaAdministrativa"].
							"',".$idDocumentoServidor.",'".$fila["unidadGestion"]."','".$obj->fechaAcuerdo."',".$obj->idRegistroAcuerdo.")";
					if($con->ejecutarConsulta($consulta))
					{
						$consulta="SELECT COUNT(*) FROM _481_chkReportes  WHERE idPadre=".$fila["idPaquete"]." AND idOpcion=2";

						$nReg=$con->obtenerValor($consulta);
						if($nReg>0)
						{
							$arrParam["expediente"]=$fila["carpetaAdministrativa"];
							$arrParam["juzgado"]=$nombreJuzgado;
							$arrParam["nombreUsuario"]=$fUsr[2];
							$arrParam["idUsuario"]=$fila["idUsuario"];
							$consulta="select HEX(AES_ENCRYPT('".$idDocumentoServidor."', '".bD($versionLatis)."'))";
							$idDocumento=$con->obtenerValor($consulta);
							$enlaceAcuerdo='<a href="'.$urlSitio.'paginasFunciones/descargarAcuerdo.php?d='.$idDocumento.'">Descargar acuerdo</a>';
							$arrParam["enlaceAcuerdo"]=$enlaceAcuerdo;

							@enviarMensajeEnvio(20,$arrParam,"sendMensajeEnvioGmailJuzgado",true);
						}
					}
				}
			}
			
			return '{"resultado":"1","mensaje":""}';
			
			
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","mensaje":"'.str_replace("\\","\\\\",$e->getMessage()).'"}';
			
			
		}
		
		
		
	}
	
	
	function registrarSolicitudLAVLV($cadObj)
	{
		global $con;

		$obj=json_decode(bD($cadObj));		
		global $directorioInstalacion;	
		global $servidorPruebas;
		global $tipoMateria;
		$fechaActual=date("Y-m-d H:i:s");
		try
		{
			$consulta="SELECT idUsuario FROM 807_usuariosVSRoles WHERE idRol=213";
			$_SESSION["idUsr"]=$con->obtenerValor($consulta);
			if($_SESSION["idUsr"]=="")
				$_SESSION["idUsr"]=1;
			$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$_SESSION["idUsr"];
			
			$resRoles=$con->obtenerFilas($consulta);
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
			$_SESSION["idRol"]=$listaGrupo.",'-100_0'";
			$_SESSION["codigoUnidad"]="0001";
			$_SESSION["codigoInstitucion"]="0001";
			
			$arrDocumentosReferencia=array();			
			
			$arrValores=array();
			$idRegistroSolicitud=-1;			
			
			$consulta="SELECT * FROM _622_tablaDinamica WHERE idRegistroPromocion='".$obj->idRegistroSolicitud."'";
			$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
			
			if($fRegistro)
			{
				$resultado='{"resultado":"1","mensaje":"","folioRegistro":"'.$fRegistro["codigo"].'","fechaRecepcion":"'.
							$fRegistro["fechaCreacion"].'","carpetaAdministrativa":"'.$fRegistro["carpetaAdministrativa"].
							'","unidadGestion":"'.$fRegistro["unidadGestion"].'","idRegistroRecepcion":"'.
							$fRegistro["id__622_tablaDinamica"].'"}';
				return $resultado;
			}
			$idEtapaCambio=1;

			$datosDocumento=array();
			
						
			$idActividad=generarIDActividad(622);
			$arrValores["idActividad"]=$idActividad;
			$arrValores["folioSolicitud"]=$obj->folioSolicitud;
			$arrValores["relatoriaHechos"]=$obj->relatoriaHechos;
			$arrValores["idRegistroPromocion"]=$obj->idRegistroSolicitud;
			$arrValores["registradoPor"]=$obj->registradoPor;
			$arrValores["adscripcionRegistrante"]=$obj->adscripcionRegistrante;
			$arrValores["emailRegistrante"]=$obj->emailRegistrante;
			$consulta="SELECT idActorProcesoEtapa FROM 944_actoresProcesoEtapa WHERE idProceso=250 AND actor IN('213_0') AND numEtapa=1";
			$idActorProcesoEtapa=$con->obtenerValor($consulta);
			$idRegistroSolicitud=crearInstanciaRegistroFormulario(622,-1,$idEtapaCambio,$arrValores,$arrDocumentosReferencia,-1,$idActorProcesoEtapa);
			foreach($obj->documentos as $d)
			{
				$idDocumento=generarNombreArchivoTemporal();
				$directorioDestino=$directorioInstalacion.'\\archivosTemporales\\'.$idDocumento;
				$datos=bD($d->contenido);
				$f=file_put_contents($directorioDestino,$datos);
				
				if($f)
				{
					$idDocumentoServidor=registrarDocumentoServidor($idDocumento,$d->nombreArchivo);
					$consulta="UPDATE 908_archivos SET descripcion='".cv($d->descripcion)."' WHERE idArchivo=".$idDocumentoServidor;
					
					$con->ejecutarConsulta($consulta);
					
					$consulta="INSERT INTO _622_gDocumentosComplementarios(idReferencia,documento,descripcion) VALUES(".$idRegistroSolicitud.",".$idDocumentoServidor.
								",'".cv($d->descripcion)."')";

					$con->ejecutarConsulta($consulta);
					
				}
			}
			
			foreach($obj->partes as $p)
			{
				$arrDocumentosReferencia=array();
				$figuraJuridica=$p->idFiguraJuridica;
				$arrValores=array();
				$idRegistroParticipante=-1;				
				$arrValores["tipoPersona"]=$p->tipoPersona;
				$arrValores["apellidoPaterno"]=$p->apellidoPaterno;
				$arrValores["apellidoMaterno"]=$p->apellidoMaterno;
				$sexo=$p->genero;
				if($sexo=="")
					$sexo=2;
				$arrValores["genero"]=$sexo;//Revisar
				$arrValores["curp"]=$p->curp;
				
				$fechaNacimiento=$p->fechaNacimiento;
				$arrValores["fechaNacimiento"]=($fechaNacimiento=="")?"NULL":$fechaNacimiento;
				if($p->estadoCivil!="")
					$arrValores["estadoCivil"]=$p->estadoCivil;
				
				$arrValores["nombre"]=$p->nombre;
				$arrValores["esMexicano"]=$p->esMexicano;
				$arrValores["idActividad"]=$idActividad;
				$arrValores["figuraJuridica"]=$p->idFiguraJuridica;
	
				$idRegistroParticipante=crearInstanciaRegistroFormulario(47,-1,1,$arrValores,$arrDocumentosReferencia,-1,245);
				
				
				$consulta="INSERT INTO 7005_relacionFigurasJuridicasSolicitud(idActividad,idParticipante,idFiguraJuridica) 
							VALUES(".$arrValores["idActividad"].",".$idRegistroParticipante.",".$p->idFiguraJuridica.")";
				$con->ejecutarConsulta($consulta);
					
			}
			
			cambiarEtapaFormulario(622,$idRegistroSolicitud,2,"",-1,"NULL","NULL",$idActorProcesoEtapa);

			$consulta="SELECT * FROM _622_tablaDinamica WHERE id__622_tablaDinamica=".$idRegistroSolicitud;
			$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
			
			
			$resultado='{"resultado":"1","mensaje":"","folioRegistro":"'.$fRegistro["codigo"].'","fechaRecepcion":"'.
							$fRegistro["fechaCreacion"].'","carpetaAdministrativa":"'.$fRegistro["carpetaAdministrativa"].
							'","unidadGestion":"'.$fRegistro["unidadGestion"].'","idRegistroRecepcion":"'.
							$fRegistro["id__622_tablaDinamica"].'"}';
			return $resultado;
			

			
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","mensaje":"'.cv($e->getMessage()).'","folioRegistro":"","fechaRecepcion":""}';
			
			
		}
		
		
		
	}
	
	
	function obtenerInformacionExpedienteJuzgado($idExpediente)
	{
		global $con;
		global $tipoMateria;
		try
		{
			$consulta="SELECT idActividad,idRegistro,unidadGestion FROM 7006_carpetasAdministrativas WHERE idCarpeta=".$idExpediente;
			$fila=$con->obtenerPrimeraFila($consulta);
			$idActividad=$fila[0];
			$lblDetalle="";
			if($tipoMateria=="P")
			{
				
				$consulta="SELECT nombreDirector,tituloUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$fila[2]."'";
				$filaUnidad=$con->obtenerPrimeraFila($consulta);
				$nombreDirector=$filaUnidad[0];
				
				$consulta="SELECT CONCAT(IF(nombre IS NULL,'',nombre),' ',
							IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno)) as nombre FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
							WHERE r.idActividad=".$idActividad." and idFiguraJuridica =2 AND r.idParticipante=p.id__47_tablaDinamica order 
							by nombre,apellidoPaterno,apellidoMaterno";
				$victimas=$con->obtenerListaValores($consulta);
				
				$consulta="SELECT CONCAT(IF(nombre IS NULL,'',nombre),' ',
							IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno)) as nombre FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
							WHERE r.idActividad=".$idActividad." and idFiguraJuridica =4 AND r.idParticipante=p.id__47_tablaDinamica order 
							by nombre,apellidoPaterno,apellidoMaterno";
				$imputados=$con->obtenerListaValores($consulta);
				
				$consulta="SELECT d.denominacionDelito FROM _61_tablaDinamica sd,_35_denominacionDelito d WHERE 
							idActividad=".$idActividad." AND d.id__35_denominacionDelito=sd.denominacionDelito";
				$delito=$con->obtenerListaValores($consulta);
				
				$lblDetalle='{"imputado":"'.cv($imputados==""?"------":$imputados).'","victima":"'.cv($victimas==""?"------":$victimas).
							'","delito":"'.cv($delito).'","nombreDirector":"'.cv($nombreDirector).'","tituloUnidad":"'.cv($filaUnidad[1]).'"}';
			}
			else
			{
				$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$fila[2]."'";
				$filaUnidad=$con->obtenerPrimeraFila($consulta);
				$consulta="SELECT CONCAT(IF(nombre IS NULL,'',nombre),' ',
							IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno)) as nombre FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
							WHERE r.idActividad=".$idActividad." and idFiguraJuridica =2 AND r.idParticipante=p.id__47_tablaDinamica order 
							by nombre,apellidoPaterno,apellidoMaterno";
				$listaActores=$con->obtenerListaValores($consulta);
				
				$consulta="SELECT CONCAT(IF(nombre IS NULL,'',nombre),' ',
							IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno)) as nombre FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
							WHERE r.idActividad=".$idActividad." and idFiguraJuridica =4 AND r.idParticipante=p.id__47_tablaDinamica order 
							by nombre,apellidoPaterno,apellidoMaterno";
				$listaDemandados=$con->obtenerListaValores($consulta);
				$consulta="SELECT t.tipoJuicio FROM _478_tablaDinamica s,_477_tablaDinamica t WHERE id__478_tablaDinamica=".$fila[1]."
						AND t.id__477_tablaDinamica=s.tipoJuicio";
				$tipoJuicio=$con->obtenerValor($consulta);
				$lblDetalle='{"actor":"'.cv($listaActores==""?"------":$listaActores).'","demandado":"'.cv($listaDemandados==""?"------":$listaDemandados).
							'","tipoJuicio":"'.cv($tipoJuicio).'","tituloUnidad":"'.cv($filaUnidad[0]).'"}';
			}
			
			return '{"resultado":"1","lblDetalle":"'.bE($lblDetalle).'"}';
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","mensaje":"'.cv($e->getMessage()).'"}';
			
			
		}
	}
		
	function obtenerAudienciasVirtualesJuzgadoMateria($arrExpedientes,$idUsuario)
	{
		global $con;
		global $urlPantallaAccesoReunion;
		try
		{
			$cadArrExpedientes=bD($arrExpedientes);		
			$oExpedientes=json_decode($cadArrExpedientes);
			$listaCarpetas="";
			foreach($oExpedientes->arrExpedientes as $o)
			{
				if($listaCarpetas=="")
					$listaCarpetas="'".$o->carpetaAdministrativa."'";
				else
					$listaCarpetas.=",'".$o->carpetaAdministrativa."'";
			}
			
			$consulta="SELECT idRegistroEvento AS idEvento,con.carpetaAdministrativa,fechaEvento,horaInicioEvento AS horaInicial,horaFinEvento AS horaFinal,
						horaInicioReal,horaTerminoReal,urlMultimedia,
						(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=e.tipoAudiencia) AS tipoAudiencia,
						s.nombreSala  AS sala,	idCentroGestion AS unidadGestion,e.situacion,
						(SELECT nombreInmueble FROM _1_tablaDinamica WHERE id__1_tablaDinamica=e.idEdificio) AS edificio,
						(SELECT GROUP_CONCAT(u.Nombre) FROM 7001_eventoAudienciaJuez eJ,800_usuarios u WHERE eJ.idRegistroEvento=e.idRegistroEvento 
						AND u.idUsuario=eJ.idJuez ORDER BY u.Nombre) AS juez,
						(SELECT DISTINCT p.passwdReunion FROM 7051_participantesReunionesVirtuales p,7006_carpetasAdministrativas c, 7005_relacionFigurasJuridicasSolicitud r
						WHERE idReunion=e.idReunionVirtual AND c.carpetaAdministrativa=con.carpetaAdministrativa AND r.idActividad=c.idActividad AND r.idCuentaAcceso=".$idUsuario." AND
						p.idAuxiliar=r.idParticipante LIMIT 0,1) as passwdReunion,'".$urlPantallaAccesoReunion."' as paginaMeeting,
						(SELECT reunionID FROM 7050_reunionesVirtualesProgramadas WHERE idRegistro=e.idReunionVirtual) as reunionID
							
						FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,_15_tablaDinamica s
						WHERE con.carpetaAdministrativa IN(".$listaCarpetas.") AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento 
						and s.id__15_tablaDinamica=e.idSala and s.perfilSala in(3,4)
						ORDER BY e.fechaEvento	";
			
			$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
			
			
			return '{"resultado":"1","arrAudiencias":'.$arrRegistros.'}';
		
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","arrAudiencias":"[]"}';
			
			
		}
		
		
	}

	function obtenerInfoCuentaAcceso($idUsuario,$palabraClave,$reenviarDatosAcceso)
	{
		global $con;
		try
		{
		
		
		
			if($palabraClave=="0C115FF2345E2C3722C93826F821BA13B1C3BBD1")
			{
				$consulta="SELECT DISTINCT idUsuario,u.Nombre,u.Login,AES_DECRYPT(UNHEX(PASSWORD), 'grup0latis17')AS PASSWORD,
							cuentaActiva,cambiarDatosUsr FROM 800_usuarios u 
							WHERE idUsuario=".$idUsuario;

				$fila=$con->obtenerPrimeraFila($consulta);
				if($reenviarDatosAcceso==1)
				{
					$arrParam["login"]=$fila[2];
					$arrParam["password"]=$fila[3];
					$arrParam["nombreUsuario"]=$fila[1];
					$arrParam["idUsuario"]=$idUsuario;
					if(!enviarMensajeEnvio(15,$arrParam,"sendMensajeEnvioGmailJuzgado",true))
					{
						return '{"resultado":"0","login":"No se pudo enviar correo electr&oacute;nico","password":"No se pudo enviar correo electr&oacute;nico"}';
					}
				}
				
				return '{"resultado":"1","login":"'.$fila[2].'","password":"'.$fila[3].'"}';	
			}
			else
			{
				return '{"resultado":"1","login":"Clave de sistema incorrecta","password":"Clave de sistema incorrecta"}';	
			}
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","login":"'.cv($e->getMessage()).'","password":"'.cv($e->getMessage()).'"}';
			
			
		}
	}
	
	function asociarCuentaAccesoCarpeta($cadObj)
	{
		global $con;
		global $versionLatis;
		
		$obj=json_decode(utf8_encode($cadObj));		

		global $directorioInstalacion;	
		global $servidorPruebas;
		try
		{
			$consulta="SELECT idUsuario FROM 807_usuariosVSRoles WHERE idRol=-3000";
			$_SESSION["idUsr"]=$con->obtenerValor($consulta);
			if($_SESSION["idUsr"]=="")
				$_SESSION["idUsr"]=1;
			
			$consulta="SELECT idRegistro FROM 7006_paquetesContratados WHERE idUsuario=".$_SESSION["idUsr"]." AND idPaquete=0";
			$idPaquete=$con->obtenerValor($consulta);
			
			if($idPaquete=="")
			{
				$consulta="INSERT INTO 7006_paquetesContratados(idUsuario,idPaquete,fechaContratacion,totalExpedientes,situacion,folioPaquete)
						VALUES(".$obj->idUsuario.",0,'".date("Y-m-d H:i:s")."',0,1,'UNICO')";
				$con->ejecutarConsulta($consulta);		
				$idPaquete=$con->obtenerUltimoID();
			}
			
			
			$nombreJuzgado="";
			$consulta="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$obj->unidadGestion."'";
			$fNombreJuzgado=$con->obtenerPrimeraFila($consulta);
			if(!$fNombreJuzgado)
			{
				
				obtenerNombreJuzgadoWS($obj->unidadGestion,$obj->cveMateria);
			}
			
			
			$consulta="INSERT INTO 7006_usuariosVSCarpetasAdministrativas(idUsuario,idCarpetaAdministrativa,carpetaAdministrativa,cveMateria,situacion,
					unidadGestion,anioExpediente,idUsuarioExpediente,idFiguraExpediente,lblFiguraExpediente,detalleExpediente,idDetalleFigura,lblDetalleFigura,idPaquete,folioSolicitud)
					VALUES(".$obj->idUsuario.",".$obj->idCarpeta.",'".$obj->carpeta."','".$obj->cveMateria."',1,'".$obj->unidadGestion.
					"',".$obj->anioExpediente.",".$obj->idParticipante.",".$obj->idFiguraJuridica.",'".$obj->lblFiguraExpediente.
					"','".cv($obj->detalleExpediente)."',".($obj->idDetalleFigura==""?"NULL":$obj->idDetalleFigura).",'".cv($obj->lblDetalleFigura)."',".$idPaquete.",'----')";
					
			if($con->ejecutarConsulta($consulta))
			{
				
				$arrRoles=explode(",",$obj->roles);
				
				
				foreach($arrRoles as $rol)
				{
					
					$consulta="SELECT COUNT(*) FROM 807_usuariosVSRoles WHERE idUsuario=".$obj->idUsuario." AND idRol=".$rol;
					$numRol=$con->obtenerValor($consulta);
					if($numRol==0)
					{
						$consulta="INSERT INTO 807_usuariosVSRoles(idUsuario,idRol,idExtensionRol,codigoRol) VALUES(".$obj->idUsuario.",".$rol.",0,'".$rol."_0')";
						$con->ejecutarConsulta($consulta);
					}
					
				}
				$consulta="SELECT Login,AES_DECRYPT(UNHEX(Password), '".bD($versionLatis)."'),Nombre FROM 800_usuarios WHERE idUsuario=".$obj->idUsuario;
				$fUsr=$con->obtenerPrimeraFila($consulta);
				
				$arrParam["login"]=$fUsr[0];
				$arrParam["password"]=$fUsr[1];
				$arrParam["nombreUsuario"]=$fUsr[2];
				$arrParam["idUsuario"]=$obj->idUsuario;
				@enviarMensajeEnvio(13,$arrParam,"sendMensajeEnvioGmailJuzgado",true);
				return '{"resultado":"1","mensaje":"","idUsuarioSistema":"'.$obj->idUsuario.'"}'; //ok
			}
			
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","mensaje":"'.str_replace("\\","\\\\",$e->getMessage()).'"}';
			
			
		}
		
		
		
	}
	

	function actualizarDireccionParticipante($idParticipante,$cadObj)
	{
		global $con;
		
		
		
		$obj=json_decode(bD($cadObj));		
		try
		{
			 
    
			$x=0;
			$query[$x]="begin";
			$x++;
			$query[$x]="UPDATE 803_direcciones SET Calle='".cv($obj->calle)."',Numero='".$obj->noExt."',Colonia='".cv($obj->colonia).
					"',Ciudad='".$obj->municipio."',CP=".($obj->cp==""?"NULL":$obj->cp).",Estado='".$obj->estado."',Municipio='".$obj->municipio."',NumeroInt='".$obj->noInt
					."' WHERE idUsuario=".$idParticipante." and Tipo=0";
			$x++;
			$query[$x]="DELETE FROM 805_mails WHERE idUsuario=".$idParticipante;
			$x++;
			$query[$x]="DELETE FROM 804_telefonos WHERE idUsuario=".$idParticipante;
			$x++;
			
			foreach($obj->arrTelefonos as $t)
			{
				$query[$x]="INSERT INTO 804_telefonos(Lada,Numero,Extension,Tipo,Tipo2,idUsuario) VALUES('".$t->lada.
						"','".$t->numero."','".$t->extension."',0,".$t->tipoTelefono.",".$idParticipante.")";
				$x++;

			}
			
			foreach($obj->mail as $m)
			{
				$query[$x]="INSERT INTO 805_mails(Mail,Tipo,Notificacion,idUsuario) VALUES('".$m->mail."',0,1,".$idParticipante.")";
				$x++;

			}


			
			$query[$x]="commit";
			$x++;
			
			if($con->ejecutarBloque($query))
			{
				return '{"resultado":"1","mensaje":""}';
			}
			
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","mensaje":"'.str_replace("\\","\\\\",$e->getMessage()).'"}';
			
			
		}
	}
	

	function obtenerAudienciasJuzgadoMateria($cveExpediente,$idExpediente,$idAudiencias)
	{
		global $con;
		
		try
		{
			$consulta="SELECT idRegistroEvento AS idEvento,con.carpetaAdministrativa,fechaEvento,horaInicioEvento AS horaInicial,horaFinEvento AS horaFinal,
						horaInicioReal,horaTerminoReal,urlMultimedia,
						(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=e.tipoAudiencia) AS tipoAudiencia,
						s.nombreSala  AS sala,	idCentroGestion AS unidadGestion,e.situacion,
						(SELECT nombreInmueble FROM _1_tablaDinamica WHERE id__1_tablaDinamica=e.idEdificio) AS edificio,
						(SELECT GROUP_CONCAT(u.Nombre) FROM 7001_eventoAudienciaJuez eJ,800_usuarios u WHERE eJ.idRegistroEvento=e.idRegistroEvento 
						AND u.idUsuario=eJ.idJuez ORDER BY u.Nombre) AS juez,'' as comentariosAdicionales,
						(SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=e.idCentroGestion) as nombreUnidad
							
						FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,_15_tablaDinamica s
						WHERE e.idRegistroEvento in(".$idAudiencias.") AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento 
						and s.id__15_tablaDinamica=e.idSala
						ORDER BY e.fechaEvento	";
			
			$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
			
			
			return '{"resultado":"1","arrAudiencias":'.$arrRegistros.'}';
		
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","arrAudiencias":"[]"}';
			
			
		}
		
		
	}
	
	function generarCodigoAccesoAudienciaVirtual($idExpediente,$idEvento,$idUsuario)
	{
		global $con;
		global $tipoMateria;
		
		$consulta="SELECT carpetaAdministrativa,idActividad FROM 7006_carpetasAdministrativas WHERE idCarpeta=".$idExpediente;
		$filaCarpeta=$con->obtenerPrimeraFila($consulta);
		$carpetaAdministrativa=$filaCarpeta[0];
		
		$consulta="SELECT idParticipante FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$filaCarpeta[1]." AND idCuentaAcceso=".$idUsuario;
		$idUsuarioBPM=$con->obtenerValor($consulta);
		
		$consulta="SELECT codigoGenerado FROM 7006_usuariosVSAudienciasCodigoGenerado WHERE idUsuario=".$idUsuarioBPM." AND idCarpetaAdministrativa=".$idExpediente.
					" and idEvento=".$idEvento;
		$codigoGenerado=$con->obtenerValor($consulta);
		if($codigoGenerado=="")
		{
			
			
			
			$codigoGenerado=rand(1000,9999)."-".rand(1000,9999)."-".rand(1000,9999)."-".rand(1000,9999);
			$consulta="	INSERT INTO 7006_usuariosVSAudienciasCodigoGenerado(idUsuario,idCarpetaAdministrativa,carpetaAdministrativa,codigoGenerado,fechaGeneracion,idEvento,cveMateria)
						VALUES(".$idUsuarioBPM.",".$idExpediente.",'".$carpetaAdministrativa."','".$codigoGenerado."','".date("Y-m-d H:i:s")."',".$idEvento.",'".$tipoMateria."')";
			
			if(!$con->ejecutarConsulta($consulta))
			{
				return '{"resultado":"0","codigoGenerado":""}';
			}
		}
		
		return '{"resultado":"1","codigoGenerado":"'.$codigoGenerado.'"}';
	}
	
	function obtenerInformacionAudienciaVirtual($reunionID)
	{
		global $con;
		
		$consulta="SELECT * FROM 7050_reunionesVirtualesProgramadas WHERE reunionID='".$reunionID."'";
		$filaInfo=$con->obtenerPrimeraFilaAsoc($consulta);
		
		if(!$filaInfo)
		{
			return '{"resultado":"2","infoAudiencia":""}';
		}
		
		
		
		return '{"resultado":"1","infoAudiencia":'.$infoAudiencia.'}';
		
		

		
	}
	
	function obtenerInformacionParticipacionAudienciaVirtual($idReunion,$passwdReunion)
	{
		global $con;
		
		$consulta="SELECT * FROM 7051_participantesReunionesVirtuales WHERE idReunion=".$idReunion." AND passwdReunion='".$passwdReunion."'";
		$fParticipante=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		if(!$fParticipante)
		{
			return '{"resultado":"2","registros":""}';
		}
		switch($fParticipante["tipoParticipante"])
		{
			case 1:
				$nombreParticipante=obtenerNombreUsuario($fParticipante["nombreParticipante"]);
			break;
			case 2:
				$nombreParticipante=$fParticipante["nombreParticipante"];
			break;
			
			case 4:
				$consulta=" SELECT apellidoPaterno,apellidoMaterno,nombre FROM _47_tablaDinamica WHERE id__47_tablaDinamica=".$fParticipante["nombreParticipante"];
				$fBusqueda=$con->obtenerPrimeraFila($consulta);
				$nombreParticipante=$fBusqueda[2]." ".$fBusqueda[0]." ".$fBusqueda[1];
			break;
		}
		return '{"resultado":"1","infoParticipante":{"tipoParticipante":"'.$fParticipante["tipoParticipante"].'","rolParticipante":"'.$fParticipante["rolParticipante"].
				'","nombreParticipante":"'.cv($nombreParticipante).'"}}';
		
		

		
	}
	
	
	function obtenerInformacionParticipanteAudienciaVirtual($idCarpeta,$idParticipante)
	{
		global $con;
		try
		{
			$consulta="SELECT idActividad,carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE idCarpeta=".$idCarpeta;
			$fCarpeta=$con->obtenerPrimeraFila($consulta);
	
			$idActividad=$fCarpeta[0];
			$carpetaJudicial=$fCarpeta[1];
			
			$consulta="SELECT CONCAT(IF(p.nombre IS NOT NULL,p.nombre,''),' ',IF(p.apellidoPaterno IS NOT NULL,p.apellidoPaterno,''),' ',
						IF(p.apellidoMaterno IS NOT NULL,p.apellidoMaterno,'')) AS nombre ,
						(SELECT nombreTipo FROM _5_tablaDinamica WHERE id__5_tablaDinamica=idFiguraJuridica) as figuraJuridica,r.idParticipante
						FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p WHERE p.id__47_tablaDinamica=r.idParticipante
						AND r.idCuentaAcceso=".$idParticipante." AND r.idActividad=".$idActividad;
						
			$fParticipante=$con->obtenerPrimeraFila($consulta);
			$participante=$fParticipante[0];
			$figuraJuridica=$fParticipante[1];
			$idParticipante=$fParticipante[2];							
										
			$consulta="SELECT * FROM 7006_documentosParticipantesCarpetaAdministrativa WHERE carpetaAdministrativa='".$carpetaJudicial.
											"' AND idParticipante=".$idParticipante." AND tipoValor=1";
											
			$fIdentificacion=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".
						($fIdentificacion["idDocumento"]==""?-1:$fIdentificacion["idDocumento"]);	
			$nombreAutorizacion=$con->obtenerValor($consulta);									
										
			return '{"resultado":"1","figuraJuridica":"'.cv($figuraJuridica).'","nombreParticipante":"'.cv($participante).
					'","identificacion":"'.$fIdentificacion["idDocumento"].'","nombreDocumento":"'.cv($nombreAutorizacion).'"}';
				
	
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","mensaje":"'.str_replace("\\","\\\\",$e->getMessage()).'"}';
			
			
		}
	}
	
	
	function obtenerInformacionDocumento($idDocumento)
	{
		global $con;
		try
		{
			$consulta="SELECT nomArchivoOriginal,tipoDocumento,fechaCreacion,tamano,
									(SELECT urlVisorContenido FROM 9010_tiposDocumentosArchivos WHERE idTipoDocumento=a.tipoDocumento)  as urlContenido,
									responsable
										FROM 908_archivos a WHERE idArchivo=".$idDocumento;
									
			$fRegistro=$con->obtenerPrimeraFila($consulta);							
										
			return '{"resultado":"1","nomArchivoOriginal":"'.$fRegistro[0].'","tipoDocumento":"'.$fRegistro[1].
					'","fechaCreacion":"'.$fRegistro[2].'","tamano":"'.$fRegistro[3].'","urlContenido":"'.$fRegistro[4].
					'","responsable":"'.$fRegistro[5].'"}';
				
	
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","mensaje":"'.str_replace("\\","\\\\",$e->getMessage()).'"}';
			
			
		}
	}
	
	
	function registrarRespuestaLAVLV($cadObj)
	{
		
		global $con;
		global $directorioInstalacion;
		try
		{
			
			$_SESSION["idUsr"]=1;
			if($_SESSION["idUsr"]=="")
				$_SESSION["idUsr"]=1;
			$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$_SESSION["idUsr"];
			
			$resRoles=$con->obtenerFilas($consulta);
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
			$_SESSION["idRol"]=$listaGrupo.",'-100_0'";
			$_SESSION["codigoUnidad"]="0001";
			$_SESSION["codigoInstitucion"]="0001";
			
			$cadObj=bD($cadObj);
			
			$obj=json_decode($cadObj);
			
			$idDocumentoServidor=-1;
			$idDocumento=generarNombreArchivoTemporal();
			$directorioDestino=$directorioInstalacion.'\\archivosTemporales\\'.$idDocumento;
			$datos=bD($obj->cuerpoDocumento);
			$f=file_put_contents($directorioDestino,$datos);
			
			if($f)
			{
				$idDocumentoServidor=registrarDocumentoServidor($idDocumento,$obj->nombreDocumento);
				
			}
			
			$consulta="UPDATE _483_tablaDinamica SET fechaRespuesta='".date("Y-m-d H:i:s")."',idDocumento=".$idDocumentoServidor." WHERE id__483_tablaDinamica=".$obj->idRegistro;
			if($con->ejecutarConsulta($consulta))
			{
				cambiarEtapaFormulario(483,$obj->idRegistro,3,"",-1,"NULL","NULL",862);
				return '{"resultado":"1","mensaje":""}';
			}
			else
			{
				return '{"resultado":"0","mensaje":""}';
			}
	
		}
		catch(Exception $e)
		{
			return '{"resultado":"0","mensaje":"'.str_replace("\\","\\\\",$e->getMessage()).'"}';
			
			
		}
	}
	

	$arrParam=array();
	$server = new soap_server;
	$ns=$urlSitio."/webServices";
	$server->configurewsdl('ApplicationServices',$ns);
	$server->wsdl->schematargetnamespace=$ns;
	$server->register('obtenerDatosJuzgadoUGA',array('cveJuzgado'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('registrarPromocion',array('cadObj'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('registrarRespuestaPromocion',array('cadObj'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('registrarCuentaAcceso',array('cadObj'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('modificarCuentaAccesoCarpeta',array('cadObj'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('obtenerJuzgadosMateria',array('cveMateria'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('obtenerExpedientesJuzgado',array('cveJuzgado'=>'xsd:string','anio'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('obtenerParticipantesExpedientes',array('idExpediente'=>'xsd:string','figuraJuridica'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('registrarSolicitudAcceso',array('cadObj'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('registarAutorizacionAcceso',array('cadObj'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('registarPublicacionAcuerdo',array('cadObj'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('registrarSolicitudLAVLV',array('cadObj'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('registrarRespuestaLAVLV',array('cadObj'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	
	$server->register('obtenerInformacionExpedienteJuzgado',array('idExpediente'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('obtenerAudienciasJuzgadoMateria',array('cveExpediente'=>'xsd:string','idExpediente'=>'xsd:string','idAudiencias'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('obtenerAudienciasVirtualesJuzgadoMateria',array('arrExpedientes'=>'xsd:string','idUsuario'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('generarCodigoAccesoAudienciaVirtual',array('idExpediente'=>'xsd:string','idEvento'=>'xsd:string','idUsuario'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('obtenerInfoCuentaAcceso',array('idUsuario'=>'xsd:string','palabraClave'=>'xsd:string','reenviarDatosAcceso'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('asociarCuentaAccesoCarpeta',array('cadObj'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('actualizarDireccionParticipante',array('idParticipante'=>'xsd:string','cadObj'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');	
	$server->register('obtenerInformacionAudienciaVirtual',array('reunionID'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('obtenerInformacionParticipacionAudienciaVirtual',array('idReunion'=>'xsd:string','passwdReunion'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('obtenerInformacionParticipanteAudienciaVirtual',array('idCarpeta'=>'xsd:string','idParticipante'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('obtenerInformacionDocumento',array('idDocumento'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	
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