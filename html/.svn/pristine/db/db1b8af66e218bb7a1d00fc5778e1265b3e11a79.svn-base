<?php session_start();
	include("conexionBD.php"); 
	include_once("cfdi/cFactura.php");
	include_once("conectorMail/cSendMail.php");
		
	$parametros="";
	if(isset($_POST["funcion"]))
	{
		$funcion=$_POST["funcion"];
		if(isset($_POST["param"]))
		{
			$p=$_POST["param"];
			$parametros=json_decode($p,true);
			
		}
	}	
	
	switch($funcion)
	{
		case 1: 
			obtenerComprobantesRecepcionBuzon();
		break;
		case 2: 
			realizarConexionBuzonRecepcion();
		break;
		case 3:
			obtenerDirectoriosBuzon();
		break;
		case 4:
			sincronizarEmailCorreoBuzon();
		break;
		case 5:
			obtenerDatosComplementoNotario();
		break;
	}
	
	
	function obtenerComprobantesRecepcionBuzon()
	{
		global $con;
		$listComprobantes="";
		$idEmpresa=bD($_POST["e"]);
		$consulta="SELECT idComprobante,fechaRecepcion,fechaComprobante,folioUUID,CONCAT(rfc1,'-',rfc2,'-',rfc3) AS rfcEmisor,
					IF(e.tipoEmpresa=1,CONCAT(e.razonSocial,' ',e.apPaterno,' ',e.apMaterno),e.razonSocial) AS nombreEmpresa, 
					montoTotal,c.situacion,visualizado,c.tipoIntegracion FROM 723_comprobantesRecibidosBuzon c, 6927_empresas e
					WHERE idEmpresaReceptora=16 AND e.idEmpresa=".$idEmpresa;	

		$arrRegistros="";
		$numReg=0;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$o='{"idComprobante":"'.cv($fila[0]).'","fechaRecepcion":"'.cv($fila[1]).'","fechaComprobante":"'.cv($fila[2]).'","folioUUID":"'.cv($fila[3]).'","rfcEmisor":"'.cv($fila[4]).
				'","nombreEmpresa":"'.cv($fila[5]).'","montoTotal":"'.cv($fila[6]).'","situacion":"'.cv($fila[7]).'","visualizado":"'.cv($fila[8]).'","tipoIntegracion":"'.$fila[9].'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
				
			if($listComprobantes=="")	
				$listComprobantes=$fila[0];
			else
				$listComprobantes.=$fila[1];
				
			$numReg++;
		}
		
		
		if($listComprobantes!="")	
		{
			$consulta="update 723_comprobantesRecibidosBuzon set visualizado=1 where idComprobante in (".$listComprobantes.")";	
			$con->ejecutarConsulta($consulta);
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
	}
	
	function realizarConexionBuzonRecepcion()
	{
		global $con;	
		
		$cadObj=bD($_POST ["cadObj"]);
		$obj=json_decode($cadObj);
		$comp="";
		if($obj->utilizarSSL==1)
		{
			$comp="/ssl";
		}
		$c=new cSendMail("{".$obj->urlServidorEmail.":".$obj->puertoConexion.$comp."/novalidate-cert}",$obj->emailConexion,$obj->passwdConexion);
		if($c->conectarServidor())
		{
			$c->cerrarConexionServidor();
			echo "1|1";
		}
		else
			echo "1|0|".imap_last_error();
	}
	
	function obtenerDirectoriosBuzon()
	{
		$cadObj=bD($_POST ["cadObj"]);
		$obj=json_decode($cadObj);
		$comp="";
		if($obj->utilizarSSL==1)
		{
			$comp="/ssl";
		}
		$c=new cSendMail("{".$obj->urlServidorEmail.":".$obj->puertoConexion.$comp."/novalidate-cert}",$obj->emailConexion,$obj->passwdConexion);
		if($c->conectarServidor())
		{
			$arrDirectorios=$c->obtenerDirectorioBuzon();
			asort($arrDirectorios);
			$aDirectorios="";
			foreach($arrDirectorios as $a)
			{
				if($aDirectorios=="")
					$aDirectorios="['".$a->name."']";
				else
					$aDirectorios.=",['".$a->name."']";
			}
			$c->cerrarConexionServidor();
			echo "1|1|[".$aDirectorios."]";
		}
		else
			echo "1|0|".imap_last_error();
		
	}
		
	function sincronizarEmailCorreoBuzon()
	{
		global $con;
		global $referenciaFiltros;
		
		
		$idEmpresa=$_POST["idEmpresa"];	
		$consulta="SELECT * FROM 6927_datosBuzonRecepcionComprobantes WHERE idEmpresa=".$idEmpresa;
		$datosBuzon=$con->obtenerPrimeraFila($consulta);
		
		$consulta="SELECT CONCAT(rfc1,rfc2,rfc3) FROM 6927_empresas WHERE idEmpresa=".$idEmpresa;
		$rfcEmpresa=$con->obtenerValor($consulta);
		
		$directoriosBusqueda=$datosBuzon[6];
		$arrDirectoriosValidos=explode(",",$directoriosBusqueda);
		$moverCorreosProcesados=$datosBuzon[8];
		
		$comp="";
		if($datosBuzon[3]==1)
		{
			$comp="/ssl";
		}
		
		$vFactura=new cFacturaCFDI();
		
		$c=new cSendMail("{".$datosBuzon[1].":".$datosBuzon[2].$comp."/novalidate-cert}",$datosBuzon[4],$datosBuzon[5]);
		if($c->conectarServidor())
		{
			
			
			if($moverCorreosProcesados==1)
				$c->prepararEstructuraBuzonLatis();
			$arrDirectoriosDisponibles=$c->obtenerDirectorioBuzon();
			
			foreach($arrDirectoriosDisponibles as $d)
			{
				if(existeValor($arrDirectoriosValidos,$d->name))	
				{

					$arrMail=$c->obtenerCorreosBandeja($d->name);	
					foreach($arrMail as $m)
					{
						$cabecera=$c->obtenerCabeceraMail($m);
						$fecha=strtotime($cabecera->date);
						$fechaMail=date("Y-m-d H:i:s",$fecha);

						$numComprobantes=0;
						$situacion=0;
						$moverMail=false;
						
						$arrAdjuntos=$c->obtenerAdjuntosMail($m);
						
						if(sizeof($arrAdjuntos)>0)
						{
							$query=array();
							$x=0;
							$query[$x]="begin";
							$x++;
							foreach($arrAdjuntos as $a)
							{
								$CFDI=$vFactura->estructuraXMLCFDIValida($a["attachment"]);
								if($CFDI)
								{
									$numComprobantes++;
									$objXML=$vFactura->convertirXMLCadenaToObj($a["attachment"]);
									if($objXML["datosReceptor"]["rfc"]==$rfcEmpresa)
									{
										$consulta="SELECT count(folioUUID) FROM 719_comprobanteFacturaEgreso WHERE folioUUID='".$objXML["folioUUID"]."'";
										$nReg=$con->obtenerValor($consulta);
										if($nReg==0)
										{
											
											if($vFactura->selloXMLCFDICorrecto($a["attachment"]))
											{
												switch($vFactura->validarXMLSATWS($a["attachment"]))
												{
													case "0":
														$situacion=6;		
													break;
													case "1":
														$situacion=1;		
													break;
													case "2":
														$situacion=3;		
													break;
												}
											}
											else
											{
												$situacion=2;		
											}
										}
										else
											$situacion=4;		
									}
									else
										$situacion=5;	
								
								
									$query[$x]="INSERT INTO 723_comprobantesRecibidosBuzon(fechaRecepcionMensaje,fechaImportacion,fechaComprobante,folioUUID,situacion,idEmpresaReceptora,asuntoMensaje,emailEnvio)
												VALUES('".$fechaMail."','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s", strtotime($objXML["fechaComprobante"]))."','".$objXML["folioUUID"]."',".$situacion.",".$idEmpresa.
												",'".cv($cabecera->subject)."','".cv($cabecera->from)."')";
									$x++;	
								
								
									if($situacion==1)
									{
										$moverMail=true;
										$consulta="SELECT idEmpresa FROM 6927_empresas WHERE CONCAT(rfc1,rfc2,rfc3)='".$objXML["datosEmisor"]["rfc"]."' AND referencia='".$referenciaFiltros."'";
										$idEmpresaEmisor=$con->obtenerValor($consulta);	
										if($idEmpresaEmisor=="")
										{
											
											$tipoEmpresa=1;//Persona fisica
											if(strlen($objXML["datosEmisor"]["rfc"])==12)
												$tipoEmpresa=2; //Persona moral
											
											$rfc1="";
											$rfc2="";
											$rfc3="";
											switch($tipoEmpresa)
											{
												case 1:
													$rfc1=substr($objXML["datosEmisor"]["rfc"],0,4);
													$rfc2=substr($objXML["datosEmisor"]["rfc"],4,6);
													$rfc3=substr($objXML["datosEmisor"]["rfc"],10,3);
													
												break;
												case 2:
													$rfc1=substr($objXML["datosEmisor"]["rfc"],0,3);
													$rfc2=substr($objXML["datosEmisor"]["rfc"],3,6);
													$rfc3=substr($objXML["datosEmisor"]["rfc"],9,3);
												break;	
											}
											
											$domicilio=$objXML["datosEmisor"]["domicilio"];
											
											
											$consulta="SELECT cveEstado FROM 820_estados WHERE estado='".$domicilio["estado"]."'";
											$estado=$con->obtenerValor($consulta);
											$consulta="SELECT cveMunicipio FROM 821_municipios WHERE cveEstado='".$estado."' AND municipio='".$domicilio["municipio"]."'";
											$municipio=$con->obtenerValor($consulta);
											$regimen="";
											foreach($objXML["datosEmisor"]["regimenFiscal"] as $r)
											{
												if($regimen=="")	
													$regimen=$r;
												else
													$regimen.=", ".$r;
											}
											
											$query[$x]="INSERT INTO 6927_empresas(tipoEmpresa,razonSocial,rfc1,rfc2,rfc3,direccion,numero,numeroInt,colonia,codPostal,estado,municipio,situacion,localidad,esEmpresaUsuario,referencia,regimenFiscal,importado)
														VALUES(".$tipoEmpresa.",'".cv($objXML["datosEmisor"]["razonSocial"])."','".$rfc1."','".$rfc2."','".$rfc3."','".cv($domicilio["calle"])."','".cv($domicilio["noExterior"])."','".cv($domicilio["noInterior"]).
														"','".cv($domicilio["colonia"])."','".cv($domicilio["codigoPostal"])."','".$estado."','".$municipio."',1,'".cv($domicilio["localidad"])."',0,'".$referenciaFiltros."','".cv($regimen)."',1)";
											$x++;
											
											$query[$x]="set @idEmpresaEmisor:=(select last_insert_id())";
											$x++;
											
											$query[$x]="INSERT INTO 6927_categoriaEmpresa(idEmpresa,idCategoria) VALUES(@idEmpresaEmisor,2)";
											$x++;
											
										}
										else
										{
											$query[$x]="set @idEmpresaEmisor:=".$idEmpresaEmisor;
											$x++;
											$consulta="SELECT count(*) FROM 6927_categoriaEmpresa WHERE idEmpresa=".$idEmpresaEmisor." and idCategoria=2";
											$nReg=$con->obtenerValor($consulta);
											if($nReg==0)
											{
												$query[$x]="INSERT INTO 6927_categoriaEmpresa(idEmpresa,idCategoria) VALUES(@idEmpresaEmisor,2)";
												$x++;
											}
										}
										$idFormaPago="";
										$otroFormaPago="";
										
										$consulta="SELECT idFormaPago FROM 710_metodoPagoComprobante WHERE formaPago='".$objXML["metodoDePago"]."'";
										$idFormaPago=$con->obtenerValor($consulta);
										if($idFormaPago=="")
										{
											$idFormaPago=5;
											$otroFormaPago=$objXML["metodoDePago"];
										}
										
										if($objXML["descuento"]=="")
											$objXML["descuento"]=0;
										$query[$x]="INSERT INTO 719_comprobanteFacturaEgreso(tipoComprobante,fechaCreacion,idEmpresa,idProveedor,fechaDocumento,condicionPago,idFormaPago,
												otroFormaPago,noCuentaPago,subtotal,total,descuentos,comentariosAdicionales,idFactura,motivoDescuento,folio,serie,folioUUID,ivaDeducible,formaPago,importado)
												VALUES(1,'".date("Y-m-d H:i:s")."',".$idEmpresa.",@idEmpresaEmisor,'".date("Y-m-d H:i:s", strtotime($objXML["fechaComprobante"]))."','".cv($objXML["condicionesDePago"]).
												"',".$idFormaPago.",'".cv($otroFormaPago)."','".$objXML["numCtaPago"]."',".$objXML["subtotal"].",".$objXML["total"].",".$objXML["descuento"].",'',NULL,'".cv($objXML["motivoDescuento"])."',
												'".cv($objXML["folio"])."','".cv($objXML["serie"])."','".cv($objXML["folioUUID"])."',0,'".cv($objXML["formaPago"])."',1)";
										$x++;
										
										$query[$x]="set @idComprobante:=(select last_insert_id())";
										$x++;
										
										foreach($objXML["conceptos"] as $p)	
										{
											$query[$x]="INSERT INTO 720_conceptosFacturaEgreso(idComprobante,descripcionConcepto,cantidad,costoUnitario,subtotal,tasaIVA,totalIVA,total,deducible,descuentoUnitario,descuentoTotal)
														VALUES(@idComprobante,'".cv($p["descripcion"])."',".$p["cantidad"].",".$p["valorUnitario"].",".$p["importe"].",0,0,".$p["importe"].",0,0,0)";
											$x++;	
										}
										
										$arrImpuestosRetenciones=$vFactura->obtenerImpuestosRetencionesObj($objXML);
										foreach($arrImpuestosRetenciones as $i)
										{
											if($i["tasa"]=="")
												$i["tasa"]="NULL";
											$query[$x]="INSERT INTO 721_impuestosRetencionesComprobanteEgreso(idComprobante,tipoConcepto,idConcepto,tasaConcepto,montoConcepto)
														VALUES(@idComprobante,".$i["tipoConcepto"].",".$i["idConcepto"].",".$i["tasa"].",".$i["montoConcepto"].")";
											$x++;
										}
										
										
										
									}
								
								
								}
								
							}
							
							$query[$x]="commit";
							$x++;
							if($con->ejecutarBloque($query))
							{
								if($numComprobantes==0)
								{
									$c->moverCorreoBuzon($m,"INBOX.ProcesadosLatis.CorreosVarios");
								}
								else
								{
									if($moverMail)
										$c->moverCorreoBuzon($m,"INBOX.ProcesadosLatis");
								}
							}
							
						}
						else
						{
							$c->moverCorreoBuzon($m,"INBOX.ProcesadosLatis.CorreosVarios");
						}
					}
				}
			}
			
			
			$c->cerrarConexionServidor();
			echo "1|1|";			
			
		}
		else
			echo "1|0|".imap_last_error();	
		
	}
	
	
	function obtenerDatosComplementoNotario()
	{
		global $con;
		$idEmpresa=$_POST["iE"];
		
		$consulta="SELECT * FROM _1026_tablaDinamica WHERE empresa=".$idEmpresa;
		$fEmpresa=$con->obtenerPrimeraFila($consulta);
		$consulta="SELECT estado FROM 820_estados WHERE  cveEstadoSAT='".$fEmpresa[13]."'";
		$entidadFederativa=$con->obtenerValor($consulta);
		$cadObj='{"noNotaria":"'.$fEmpresa[11].'","curpNotario":"'.$fEmpresa[12].'","entidadFederativa":"'.$entidadFederativa.'","cveEntidadFederativa":"'.$fEmpresa[13].'","adscripcion":"'.cv($fEmpresa[14]).'"}';
		echo "1|".$cadObj;
		
		
		
	}
?>