<?php session_start();
	include_once("conexionBD.php");
	include_once("sgjp/cSendMail.php");
	require_once('tcpdf/tcpdf_include.php');
	require_once('tcpdf/tcpdf.php');

	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];

	
	switch($funcion)
	{
		case 1:
			registrarConfiguracionSMTP();
		break;
		case 2:
			obtenerConfiguracionSMTP();
		break;
		case 3:
			obtenerConfiguracionesCOnexiones();
		break;
		case 4:
			obtenerBuzonesCorreos();
		break;
		case 5:
			obtenerCorreosBuzon();
		break;
		case 6:
			obtenerDocumentoAdjuntoMail();
		break;
		case 7:
			agregarCorreoElectronicoExpediente();
		break;
		case 8:
			removerConfiguracionSMTP();
		break;
		case 9:
			cambiarSituacionConfiguracionSMTP();
		break;
	}

function registrarConfiguracionSMTP()
{
	global $con;
	global $versionLatis;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	$comp="";
	if($obj->utilizarSSL==1)
	{
		$comp="/ssl";
	}

	$cadenaConexion="{".$obj->hostIMAP.":".$obj->puertoIMAP.$comp."/novalidate-cert".$comp."}";
	$c=new cSendMail($cadenaConexion,$obj->usuario,bD($obj->passwd));
	if($c->conectarServidor())
	{
		
		$c->cerrarConexionServidor();
		
		
		if($obj->idRegistro=="-1")
		{
			$consulta="INSERT INTO 805_configuracionMailSMTP(idUsuario,mail,contrasena,hostSMTP,puertoSMTP,autenticacionSMTP,hostIMAP,puertoIMAP,utilizarSSL,descripcion) 
						VALUES(".$_SESSION["idUsr"].",'".cv($obj->usuario).
						"',HEX(AES_ENCRYPT('".bD($obj->passwd)."', '".bD($versionLatis)."')),'".cv($obj->hostSMTP)."',".$obj->puertoSMTP.
						",".$obj->autenticacionSMTP.",'".cv($obj->hostIMAP)."',".$obj->puertoIMAP.",".$obj->utilizarSSL.",'".cv($obj->descripcion)."')";

		}
		else
		{
			$consulta="update 805_configuracionMailSMTP set mail='".cv($obj->usuario)."',contrasena=HEX(AES_ENCRYPT('".bD($obj->passwd).
					"', '".bD($versionLatis)."')),hostSMTP='".cv($obj->hostSMTP)."',puertoSMTP=".$obj->puertoSMTP.
					",autenticacionSMTP=".$obj->autenticacionSMTP.",hostIMAP='".cv($obj->hostIMAP)."',puertoIMAP=".$obj->puertoIMAP.
					",utilizarSSL=".$obj->utilizarSSL.",descripcion='".cv($obj->descripcion)."' where idRegistro=".$obj->idRegistro;
		}
		
		eC($consulta);	
	}
	else
	{
		echo "<br>No se pudo conectar con el servidor";
	}


	
	
	
	
}

function obtenerConfiguracionSMTP()
{
	global $con;

	$iC=$_POST["iC"];
	$consulta="SELECT mail,hostSMTP,puertoSMTP,autenticacionSMTP,hostIMAP,puertoIMAP,utilizarSSL,descripcion,situacionActual FROM 805_configuracionMailSMTP WHERE idRegistro=".$iC;
	$arrObjetos=utf8_encode($con->obtenerFilasJSON($consulta));

	echo "1|".($arrObjetos);
	
	
}

function obtenerConfiguracionesCOnexiones()
{
	global $con;
	
	$consulta="SELECT idRegistro,mail,descripcion,hostSMTP,puertoSMTP,hostIMAP,puertoIMAP,situacionActual FROM 805_configuracionMailSMTP where situacionActual<>0 ORDER BY descripcion";
	$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
	echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	
}

function obtenerBuzonesCorreos()
{
	global $con;
	global $versionLatis;
	$idCuentaMail=bD($_POST["iC"]);

	$query="SELECT hostIMAP,puertoIMAP,utilizarSSL,mail,AES_DECRYPT(UNHEX(contrasena), '".bD($versionLatis).
			"') AS contrasena FROM 805_configuracionMailSMTP WHERE idRegistro=".$idCuentaMail;
	$fDatos=$con->obtenerPrimeraFila($query);			
	if(!$fDatos)
	{
		echo "<br>Primero debe configurar su servidor de correo saliente";
		return;
	}
	
	$comp="";
	if($fDatos[2]==1)
	{
		$comp="/ssl";
	}
	$aDirectorios=array();
	$arrDirectoros="";
	$baseMail="{".$fDatos[0].":".$fDatos[1].$comp."/novalidate-cert".$comp."}";
	$c=new cSendMail($baseMail,$fDatos[3],$fDatos[4]);
	if($c->conectarServidor())
	{
		$arrDirectorio=$c->obtenerDirectorioBuzon();

		foreach($arrDirectorio as $directorio)
		{
			$arrDirectorio=explode("}",$directorio->name);
			
			$arrSubCarpetas=explode("/",$arrDirectorio[1]);
			for($nivel=0;$nivel<sizeof($arrSubCarpetas);$nivel++)
			{
				$subIndex="";
				for($nivelBase=0;$nivelBase<=$nivel;$nivelBase++)
				{
					$subIndex.='["'.$arrSubCarpetas[$nivelBase].'"]';
				}
				
				eval('if(!isset($aDirectorios'.$subIndex.'))$aDirectorios'.$subIndex.'=array();');
				
			}
			
			
			
		}
		
		
		foreach($aDirectorios as $directorio=>$resto)
		{
			if(strtoupper($directorio)=="[GMAIL]")
			{
				continue;
			}
			$llaveBase=$baseMail.$directorio;
			
			$nodosHijos=obtenerNodosHijosDirectorio($resto,$llaveBase);

			$infoComplementaria="";
			if($nodosHijos=="[]")
				$infoComplementaria=',"leaf":true';
			else
				$infoComplementaria=',"leaf":false,"expanded":true,children:'.$nodosHijos;

			$textoNodo=mb_strtoupper(str_replace("]","",str_replace("[","",str_replace("INBOX","Recibidos",$directorio))));
			
			if($nodosHijos!="[]")
			{
				$textoNodo='<b>'.$textoNodo.'</b>';
			}
				
			$o='{"icon":"../images/bullet_green.png","id":"'.$llaveBase.'","text":"'.cv($textoNodo).
				'"'.$infoComplementaria.'}';
				
			if($arrDirectoros=="")
				$arrDirectoros=$o;
			else
				$arrDirectoros.=",".$o;
		}
		
		$c->cerrarConexionServidor();
		
	}
	
	echo '['.$arrDirectoros.']';
	
}

function obtenerNodosHijosDirectorio($nodoBase,$llaveBasePadre)
{
	$arrDirectoros="";
	foreach($nodoBase as $directorio=>$resto)
	{
		$llaveBase=$llaveBasePadre."/".$directorio;
		
		$nodosHijos=obtenerNodosHijosDirectorio($resto,$llaveBase);
		$infoComplementaria="";
		if($nodosHijos=="[]")
			$infoComplementaria=',"leaf":true';
		else
			$infoComplementaria=',"leaf":false,children:'.$nodosHijos;
		
		$textoNodo=mb_strtoupper(str_replace("]","",str_replace("[","",$directorio)));
			
		if($nodosHijos!="[]")
		{
			$textoNodo='<b>'.$textoNodo.'</b>';
		}
			
			
		$o='{"icon":"../images/bullet_green.png","id":"'.$llaveBase.'","expanded":true,"text":"'.cv($textoNodo).'"'.$infoComplementaria.'}';
			
		if($arrDirectoros=="")
			$arrDirectoros=$o;
		else
			$arrDirectoros.=",".$o;
	}
	
	return '['.$arrDirectoros.']';
}

function obtenerCorreosBuzon()
{
	global $con;
	global $versionLatis;
	
	$arrMails="";
	$bandeja=$_POST["b"];
	$iC=bD($_POST["iC"]);
	$start=$_POST["start"];
	$limit=$_POST["limit"];
	$final=$start+$limit-1;
	
	$fechaEnvio=date("Y-m-d");


	$fechaEnvio=strtotime("-15 days",strtotime($fechaEnvio));
	$fechaEnvio=date("d",$fechaEnvio)."-".date("M",$fechaEnvio)."-".date("Y",$fechaEnvio);
	
	$arrRegistros="";
	$numReg=0;

	$query="SELECT hostIMAP,puertoIMAP,utilizarSSL,mail,AES_DECRYPT(UNHEX(contrasena), '".bD($versionLatis).
			"') AS contrasena FROM 805_configuracionMailSMTP WHERE idRegistro=".$iC;
	$fDatos=$con->obtenerPrimeraFila($query);			
	if(!$fDatos)
	{
		echo "<br>Primero debe configurar su servidor de correo saliente";
		return;
	}
	
	$comp="";
	if($fDatos[2]==1)
	{
		$comp="/ssl";
	}
	$numReg=0;
	$aDirectorios=array();
	$arrDirectoros="";
	$baseMail="{".$fDatos[0].":".$fDatos[1].$comp."/novalidate-cert".$comp."}";
	$c=new cSendMail($baseMail,$fDatos[3],$fDatos[4]);
	if($c->conectarServidor())
	{
		$arrCorreos=$c->obtenerCorreosBandeja($bandeja);
		
		$arrCorreosAuxiliar=array();
		for($x=sizeof($arrCorreos)-1;$x>=0;$x--)
		{	
			array_push($arrCorreosAuxiliar,$arrCorreos[$x]);
		}
		$arrCorreos=$arrCorreosAuxiliar;
		
		if($final>sizeof($arrCorreos)-1)
		{
			$final=sizeof($arrCorreos)-1;
		}

		for($posMail=$start;$posMail<=$final;$posMail++)
		{
			$iC=$arrCorreos[$posMail];
			$asunto=$c->obtenerAsuntoMail($iC);
			$aRemitente=$c->obtenerRemitente($iC);
			$remitente="";
			if(trim($aRemitente[0])<>trim($aRemitente[1]))
				$remitente=$aRemitente[0]."<br>[".$aRemitente[1]."]";
			else
				$remitente=$aRemitente[0];
			$adjuntos=$c->obtenerAdjuntosMail($iC);
			$arrAdjuntos="";
			foreach($adjuntos as $a)
			{
				$o="['".cv($a["filename"])."','".strlen($a["attachment"])."']";
				if($arrAdjuntos=="")
					$arrAdjuntos=$o;
				else
					$arrAdjuntos.=",".$o;
			}
			$fechaRecepcion=$c->obtenerFechaMail($iC);
			$cuerpo=$c->obtenerCuerpoMail($iC,false);
			
			$oMail='{"idMail":"'.$iC.'","asunto":"'.cv($asunto).'","remitente":"'.cv($remitente).
				'","adjuntos":['.$arrAdjuntos.'],"fechaRecepcion":"'.$fechaRecepcion.'","cuerpo":"'.bE(utf8_encode($cuerpo)).'"}';
			if($arrMails=="")
				$arrMails=$oMail;
			else
				$arrMails.=",".$oMail;
				
			
			
			
		}
		$c->cerrarConexionServidor();
		echo '{"numReg":"'.sizeof($arrCorreos).'","registros":['.$arrMails.']}';
	}
}

function obtenerDocumentoAdjuntoMail()
{
	global $con;
	global $baseDir;
	global $versionLatis;
	$cadObj=$_POST["cadObj"];
	
	$obj=json_decode($cadObj);
	$query="SELECT hostIMAP,puertoIMAP,utilizarSSL,mail,AES_DECRYPT(UNHEX(contrasena), '".bD($versionLatis).
			"') AS contrasena FROM 805_configuracionMailSMTP WHERE idRegistro=".bD($obj->iC);
	$fDatos=$con->obtenerPrimeraFila($query);			
	if(!$fDatos)
	{
		echo "<br>Primero debe configurar su servidor de correo saliente";
		return;
	}
	
	$comp="";
	if($fDatos[2]==1)
	{
		$comp="/ssl";
	}
	$numReg=0;
	$aDirectorios=array();
	$arrDirectoros="";
	$baseMail="{".$fDatos[0].":".$fDatos[1].$comp."/novalidate-cert".$comp."}";
	$c=new cSendMail($baseMail,$fDatos[3],$fDatos[4]);
	if($c->conectarServidor())
	{
		$adjuntos=$c->obtenerAdjuntosMail($obj->idMail);

		$arrAdjuntos="";
		foreach($adjuntos as $a)
		{
			if($a["filename"]==$obj->nombreArchivo)
			{
				$nombreArchivo=rand()."_".date("dmY_Hms");
				$rutaFinal=$baseDir."/archivosTemporales/".$nombreArchivo;
				escribirContenidoArchivo($rutaFinal,$a["attachment"]);
				echo "1|".$nombreArchivo;
				return;
			}
		}
		$c->cerrarConexionServidor();
	}
}


function agregarCorreoElectronicoExpediente()
{
	global $con;
	global $baseDir;
	global $versionLatis;
	$cadObj=$_POST["cadObj"];
	$obj=json_decode($cadObj);
	
	$query="SELECT hostIMAP,puertoIMAP,utilizarSSL,mail,AES_DECRYPT(UNHEX(contrasena), '".bD($versionLatis).
			"') AS contrasena FROM 805_configuracionMailSMTP WHERE idRegistro=".bD($obj->iC);
	$fDatos=$con->obtenerPrimeraFila($query);			
	if(!$fDatos)
	{
		echo "<br>Primero debe configurar su servidor de correo saliente";
		return;
	}
	
	$comp="";
	if($fDatos[2]==1)
	{
		$comp="/ssl";
	}
	
	
	
	$arrMailsInvolucrados=array();
	$aDirectorios=array();
	$arrDirectoros="";
	$baseMail="{".$fDatos[0].":".$fDatos[1].$comp."/novalidate-cert".$comp."}";
	$c=new cSendMail($baseMail,$fDatos[3],$fDatos[4]);
	if($c->conectarServidor())
	{
		foreach($obj->arrMails as $archivo)
		{
			if(!isset($arrMailsInvolucrados[$archivo->idMail]))
			{
				$idMail=$archivo->idMail;
				$arrMailsInvolucrados[$idMail]=1;
				$arrMetaDatos=array();
				$cabecera=$c->obtenerCabeceraMail($idMail);
				
				$o='{"idPropiedad":"10","tipoEntrada":"6","valor":"'.cv($cabecera->subject).'","valorEtiqueta":"'.cv($cabecera->subject).'"}';
				array_push($arrMetaDatos,json_decode($o));
				$o='{"idPropiedad":"11","tipoEntrada":"6","valor":"'.cv($cabecera->from).'","valorEtiqueta":"'.cv($cabecera->from).'"}';
				array_push($arrMetaDatos,json_decode($o));
				$o='{"idPropiedad":"12","tipoEntrada":"6","valor":"'.cv($cabecera->to).'","valorEtiqueta":"'.cv($cabecera->to).'"}';
				array_push($arrMetaDatos,json_decode($o));
				$o='{"idPropiedad":"13","tipoEntrada":"5","valor":"'.date("Y-m-d H:i:s",strtotime($cabecera->date)).'","valorEtiqueta":"'.date("Y-m-d H:i:s",strtotime($cabecera->date)).'"}';
				array_push($arrMetaDatos,json_decode($o));
				$o='{"idPropiedad":"14","tipoEntrada":"6","valor":"'.cv($idMail).'","valorEtiqueta":"'.cv($idMail).'"}';
				array_push($arrMetaDatos,json_decode($o));
				
				$cuerpo="<b>De:</b> ".$cabecera->from."<br><b>Para:</b> ".$cabecera->to."<br><b>Asunto:</b> ".$cabecera->subject."<br><b>Fecha:</b> ".date("d/m/Y H:i:s",strtotime($cabecera->date))."<br><br><br>";
				
				$cuerpo.=$c->obtenerCuerpoMail($idMail,true);
				
				$nombreArchivo=rand()."_".date("dmY_Hms");
				$rutaFinal=$baseDir."/archivosTemporales/".$nombreArchivo;
				
				$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				$pdf->AddPage();
				$pdf->writeHTML($cuerpo, true, false, true, false, '');
				$pdf->Output($rutaFinal, 'F');
				
				
				$idDocumento=registrarDocumentoServidorRepositorio($nombreArchivo,"Correo_Electronico.pdf",152,"");
				if($idDocumento!=-1)
				{
					if(registrarDocumentoCarpetaAdministrativa($obj->carpetaAdministrativa,$idDocumento,-1,-10,$obj->idCarpetaAdministrativa))
					{
						$x=0;
						$consulta=array();
						$consulta[$x]="begin";
						$x++;
						$tipoDocumental=152;
						foreach($arrMetaDatos as $m)
						{
							
							$query="SELECT * FROM 20003_catalogoMetaDatos WHERE idMetaDato=".$m->idPropiedad;
							$fMetaDato=$con->obtenerPrimeraFilaAsoc($query);
							
							$consulta[$x]="INSERT INTO 908_metaDataArchivos(idArchivo,idMetaDato,valor,valorEtiqueta,nombreMetaDato,metodoResolucion,tipoEntrada,funcionSistema,tagMetaDato)
											VALUES(".$idDocumento.",'".cv($m->idPropiedad)."','".cv($m->valor)."','".cv($m->valorEtiqueta).
											"','".cv($fMetaDato["nombreMetaDato"])."','".cv($fMetaDato["metodoResolucion"]).
											"',".$fMetaDato["tipoDatoEntrada"].",".($fMetaDato["funcionSistema"]==""?-1:$fMetaDato["funcionSistema"]).
											",'".cv($fMetaDato["tagMeta"])."')";
							$x++;
							
						}
						
						
						$cacheCalculos=NULL;
						
						$query="SELECT idPerfilMetaDatos FROM 908_categoriasDocumentos WHERE idCategoria=".$tipoDocumental;
						$idPerfilMetaDatos=$con->obtenerValor($query);
				
						$query="SELECT cM.idMetaDato,cM.nombreMetaDato,cM.metodoResolucion,
								cM.tipoDatoEntrada,cM.funcionSistema,cM.tagMeta FROM 20006_metaDatoPerfil m,20003_catalogoMetaDatos cM 
								WHERE idPerfilMetaDato=".$idPerfilMetaDatos." and cM.idMetaDato=m.idMetaDato and cM.metodoResolucion=1";
						$res=$con->obtenerFilas($query);
						while($fMetaDato=mysql_fetch_assoc($res))
						{
							$cadParametros='{"idMetaDato":"'.$fMetaDato["idMetaDato"].'","carpetaAdministrativa":"'.$obj->carpetaAdministrativa.
											'","idCarpetaAdministrativa":"'.$obj->idCarpetaAdministrativa.'","idDocumento":"'.$idDocumento.'"}';
							$objParametros=json_decode($cadParametros);
							$resultado=removerComillasLimite(resolverExpresionCalculoPHP($fMetaDato["funcionSistema"],$objParametros,$cacheCalculos));
							
							$consulta[$x]="INSERT INTO 908_metaDataArchivos(idArchivo,idMetaDato,valor,valorEtiqueta,nombreMetaDato,metodoResolucion,tipoEntrada,funcionSistema,tagMetaDato)
												VALUES(".$idDocumento.",'".cv($fMetaDato["idMetaDato"])."','".cv($resultado)."','".cv($resultado).
												"','".cv($fMetaDato["nombreMetaDato"])."','".cv($fMetaDato["metodoResolucion"]).
												"',".$fMetaDato["tipoDatoEntrada"].",".($fMetaDato["funcionSistema"]==""?-1:$fMetaDato["funcionSistema"]).
												",'".cv($fMetaDato["tagMeta"])."')";
							$x++;
						}
						
						
						$consulta[$x]="commit";
						$x++;
				
						$con->ejecutarBloque($consulta);
					}
					
				}
				
			}
			
			$adjuntos=$c->obtenerAdjuntosMail($archivo->idMail);
			$arrAdjuntos="";
			if(count($adjuntos)>0)
			{
				foreach($adjuntos as $a)
				{
	
					if($a["filename"]==$archivo->nombreArchivo)
					{
						$nombreArchivo=rand()."_".date("dmY_Hms");
						$rutaFinal=$baseDir."/archivosTemporales/".$nombreArchivo;
						escribirContenidoArchivo($rutaFinal,$a["attachment"]);
						$idDocumento=registrarDocumentoServidorRepositorio($nombreArchivo,$archivo->nombreArchivo,0,"");
						if($idDocumento!=-1)
						{
							if(registrarDocumentoCarpetaAdministrativa($obj->carpetaAdministrativa,$idDocumento,-1,-10,$obj->idCarpetaAdministrativa))
							{
								$x=0;
								$consulta=array();
								$consulta[$x]="begin";
								$x++;
								$tipoDocumental=0;
								foreach($archivo->metaDatos as $m)
								{
									if($m->idPropiedad!=0)
									{
										$query="SELECT * FROM 20003_catalogoMetaDatos WHERE idMetaDato=".$m->idPropiedad;
										$fMetaDato=$con->obtenerPrimeraFilaAsoc($query);
										
										$consulta[$x]="INSERT INTO 908_metaDataArchivos(idArchivo,idMetaDato,valor,valorEtiqueta,nombreMetaDato,metodoResolucion,tipoEntrada,funcionSistema,tagMetaDato)
														VALUES(".$idDocumento.",'".cv($m->idPropiedad)."','".cv($m->valor)."','".cv($m->valorEtiqueta).
														"','".cv($fMetaDato["nombreMetaDato"])."','".cv($fMetaDato["metodoResolucion"]).
														"',".$fMetaDato["tipoDatoEntrada"].",".($fMetaDato["funcionSistema"]==""?-1:$fMetaDato["funcionSistema"]).
														",'".cv($fMetaDato["tagMeta"])."')";
										$x++;
									}
									else
										$tipoDocumental=$m->valor;
								}
								
								
								$cacheCalculos=NULL;
								
								$query="SELECT idPerfilMetaDatos FROM 908_categoriasDocumentos WHERE idCategoria=".$tipoDocumental;
								$idPerfilMetaDatos=$con->obtenerValor($query);
						
								$query="SELECT cM.idMetaDato,cM.nombreMetaDato,cM.metodoResolucion,
										cM.tipoDatoEntrada,cM.funcionSistema,cM.tagMeta FROM 20006_metaDatoPerfil m,20003_catalogoMetaDatos cM 
										WHERE idPerfilMetaDato=".$idPerfilMetaDatos." and cM.idMetaDato=m.idMetaDato and cM.metodoResolucion=1";
								$res=$con->obtenerFilas($query);
								while($fMetaDato=mysql_fetch_assoc($res))
								{
									$cadParametros='{"idMetaDato":"'.$fMetaDato["idMetaDato"].'","carpetaAdministrativa":"'.$obj->carpetaAdministrativa.
													'","idCarpetaAdministrativa":"'.$obj->idCarpetaAdministrativa.'","idDocumento":"'.$idDocumento.'"}';
									$objParametros=json_decode($cadParametros);
									$resultado=removerComillasLimite(resolverExpresionCalculoPHP($fMetaDato["funcionSistema"],$objParametros,$cacheCalculos));
									
									$consulta[$x]="INSERT INTO 908_metaDataArchivos(idArchivo,idMetaDato,valor,valorEtiqueta,nombreMetaDato,metodoResolucion,tipoEntrada,funcionSistema,tagMetaDato)
														VALUES(".$idDocumento.",'".cv($fMetaDato["idMetaDato"])."','".cv($resultado)."','".cv($resultado).
														"','".cv($fMetaDato["nombreMetaDato"])."','".cv($fMetaDato["metodoResolucion"]).
														"',".$fMetaDato["tipoDatoEntrada"].",".($fMetaDato["funcionSistema"]==""?-1:$fMetaDato["funcionSistema"]).
														",'".cv($fMetaDato["tagMeta"])."')";
									$x++;
								}
								$consulta[$x]="UPDATE 908_archivos SET categoriaDocumentos=".$tipoDocumental." WHERE idArchivo=".$idDocumento;
								$x++;
								
								$consulta[$x]="commit";
								$x++;
								
								$con->ejecutarBloque($consulta);
							}
							
						}
					}
				}
			}
		}
		$c->cerrarConexionServidor();
		echo "1|";
	}
}

function removerConfiguracionSMTP()
{
	global $con;
	$idRegistro=$_POST["iR"];
	
	$consulta="UPDATE 805_configuracionMailSMTP SET situacionActual=0 WHERE idRegistro=".$idRegistro;
	eC($consulta);
	
}

function cambiarSituacionConfiguracionSMTP()
{
	global $con;
	$idRegistro=$_POST["iR"];
	$situacion=$_POST["s"];
	
	$consulta="UPDATE 805_configuracionMailSMTP SET situacionActual=".$situacion." WHERE idRegistro=".$idRegistro;
	eC($consulta);
	
}
?>