<?php
include("conexionBD.php");
include_once("zip.lib.php"); 

if(isset($_GET['f'])) 
{	
		$idDocumento=$_GET['f'];
		$sql = "SELECT nomArchivoOriginal,documento,tipoArchivo,tamano,enBD,documentoRepositorio,idArchivo FROM 908_archivos WHERE sha512='".$idDocumento."'";
		$res=$con->obtenerPrimeraFila($sql);
		if($res)
		{
			$idDocumento=$res[6];
			$res[0]=str_replace(",","",$res[0]);
			header("Content-type: ".$res[2]);
			header("Content-Disposition: attachment; filename=".$res[0]);
	
			if($res[4]==1)
				echo $res[1];
			else
			{
				echo obtenerCuerpoDocumentoB64($idDocumento,false);
			}
		}
		else
		{
			$consulta="SELECT tituloSistema FROM 903_variablesSistema";
			$fSistema=$con->obtenerPrimeraFila($consulta);	
		?>
        
        
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
            <link rel="stylesheet" type="text/css" href="../css/hayas.css.php" media="screen" />
            <link rel="stylesheet" type="text/css" href="../estilos/estilos.css" media="screen" />
            <!--[if IE 8]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE8.css" media="screen" /><![endif]-->
            <!--[if IE 7]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE7.css" media="screen" /><![endif]-->
            <!--[if IE 6]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE6.css" media="screen" /><![endif]-->
            <!--[if IE]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE8.css" media="screen" /><![endif]-->
            
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title><?php echo $fSistema[0]?></title>
            </head>
            
            <body>
                <table width="100%">
                <tr>
                    <td align="center">
                        <table width="100%" >
                            <tr>
                                <td align="left"  style="padding-left:60px; padding-top:20px">
                                    <img src="<?php echo $urlSitio?>principalPortal/imagesInstitucionales/header.png" width="100%" >
                                </td>  
                            </tr>
                            <tr>
                                <td align="center"><br />
                                    <table width="800">
                                        <tr>
                                            <td>
                               
                                                <fieldset class="frameHijo"><legend><b>Documento Inexistente</b></legend>
                                                    <table width="100%">
                                                        <tr>
                                                            <td width="145">
                                                                <img src="<?php echo $urlSitio?>images/prohibido.png" />
                                                            </td>
                                                            <td><span class="letraRoja">El documento al que desea acceder NO existe<br />
                                                            <br />
                                                            </span>
                                                                
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </fieldset>
                                
                                        
                                            </td>
                                        </tr>
                                    </table>
                                
                                </td>
                            </tr>
                        </table>                
                    </td>
                </tr>
               </table>
            </body>
            </html>
        
        
        <?php	
			
			
		}
	
}
else
{
	
	if(isset($_GET["nfy"]))
	{
		$consulta="SELECT AES_DECRYPT(UNHEX('".$_GET["nfy"]."'), '".bD($versionLatis)."') AS idNotificacion";
		$idNotificacion=$con->obtenerValor($consulta);
		$consulta="SELECT * FROM _665_tablaDinamica WHERE id__665_tablaDinamica=".$idNotificacion;
		$fNotificacion=$con->obtenerPrimeraFila($consulta);
		
		if(!$fNotificacion)
		{
			?>
        
        
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
            <link rel="stylesheet" type="text/css" href="../css/hayas.css.php" media="screen" />
            <link rel="stylesheet" type="text/css" href="../estilos/estilos.css" media="screen" />
            <!--[if IE 8]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE8.css" media="screen" /><![endif]-->
            <!--[if IE 7]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE7.css" media="screen" /><![endif]-->
            <!--[if IE 6]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE6.css" media="screen" /><![endif]-->
            <!--[if IE]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE8.css" media="screen" /><![endif]-->
            
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title><?php echo $fSistema[0]?></title>
            </head>
            
            <body>
                <table width="100%">
                <tr>
                    <td align="center">
                        <table width="100%" >
                            <tr>
                                <td align="left"  style="padding-left:60px; padding-top:20px">
                                    <img src="<?php echo $urlSitio?>principalPortal/imagesInstitucionales/header.png" width="100%" >
                                </td>  
                            </tr>
                            <tr>
                                <td align="center"><br />
                                    <table width="800">
                                        <tr>
                                            <td>
                               
                                                <fieldset class="frameHijo"><legend><b>Documento Inexistente</b></legend>
                                                    <table width="100%">
                                                        <tr>
                                                            <td width="145">
                                                                <img src="<?php echo $urlSitio?>images/prohibido.png" />
                                                            </td>
                                                            <td><span class="letraRoja">El documento al que desea acceder NO existe<br />
                                                            <br />
                                                            </span>
                                                                
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </fieldset>
                                
                                        
                                            </td>
                                        </tr>
                                    </table>
                                
                                </td>
                            </tr>
                        </table>                
                    </td>
                </tr>
               </table>
            </body>
            </html>
        
        
        <?php	
		}
		else
		{
			$zip = new zip();
			$archivoZip=$baseDir."/archivosTemporales/notificacion_".$idNotificacion;
			
			$arrRutaDocumentos=array();
			$consulta="SELECT * FROM _665_gridDocumentosNotificar WHERE idReferencia=".$idNotificacion;
			$resDest=$con->obtenerFilas($consulta);
			while($fArchivo=mysql_fetch_assoc($resDest))
			{
				$rutaArchivo=obtenerDocumentoFisico($fArchivo["idDocumento"]);
				array_push($arrRutaDocumentos,$rutaArchivo);
				$zip->addFile($rutaArchivo,($fArchivo["nombreDocumento"]));
			}
			
			 
			$pathSave = $archivoZip.'.zip';
			$zip->saveZip($pathSave);
			$zip->downloadZip($pathSave);
			unlink($pathSave);
			foreach($arrRutaDocumentos as $r)
			{
				unlink($r);
			}
			
			
		}
	}
	else
	{
		
		if(isset($_GET["nfys"]))
		{
			$consulta="SELECT AES_DECRYPT(UNHEX('".$_GET["nfys"]."'), '".bD($versionLatis)."') AS idNotificacion";
			$idNotificacion=$con->obtenerValor($consulta);
			$consulta="SELECT * FROM _633_tablaDinamica WHERE id__633_tablaDinamica=".$idNotificacion;
			$fNotificacion=$con->obtenerPrimeraFila($consulta);
			if(!$fNotificacion)
			{
				?>
			
			
				<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<link rel="stylesheet" type="text/css" href="../css/hayas.css.php" media="screen" />
				<link rel="stylesheet" type="text/css" href="../estilos/estilos.css" media="screen" />
				<!--[if IE 8]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE8.css" media="screen" /><![endif]-->
				<!--[if IE 7]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE7.css" media="screen" /><![endif]-->
				<!--[if IE 6]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE6.css" media="screen" /><![endif]-->
				<!--[if IE]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE8.css" media="screen" /><![endif]-->
				
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title><?php echo $fSistema[0]?></title>
				</head>
				
				<body>
					<table width="100%">
					<tr>
						<td align="center">
							<table width="100%" >
								<tr>
									<td align="left"  style="padding-left:60px; padding-top:20px">
										<img src="<?php echo $urlSitio?>principalPortal/imagesInstitucionales/header.png" width="100%" >
									</td>  
								</tr>
								<tr>
									<td align="center"><br />
										<table width="800">
											<tr>
												<td>
								   
													<fieldset class="frameHijo"><legend><b>Documento Inexistente</b></legend>
														<table width="100%">
															<tr>
																<td width="145">
																	<img src="<?php echo $urlSitio?>images/prohibido.png" />
																</td>
																<td><span class="letraRoja">El documento al que desea acceder NO existe<br />
																<br />
																</span>
																	
																</td>
															</tr>
														</table>
													</fieldset>
									
											
												</td>
											</tr>
										</table>
									
									</td>
								</tr>
							</table>                
						</td>
					</tr>
				   </table>
				</body>
				</html>
			
			
			<?php	
			}
			else
			{
				$zip = new zip();
				$arrRutaDocumentos=array();
				$archivoZip=$baseDir."/archivosTemporales/notificacion_".$idNotificacion;
				
				$consulta="SELECT a.idArchivo,a.nomArchivoOriginal,a.sha512,a.tamano FROM 9074_documentosRegistrosProceso d,908_archivos a
					WHERE d.idFormulario=633 AND d.idRegistro=".$idNotificacion." and  a.idArchivo=d.idDocumento";
				
				$resDest=$con->obtenerFilas($consulta);
				while($fArchivo=mysql_fetch_assoc($resDest))
				{
					$rutaArchivo=obtenerDocumentoFisico($fArchivo["idArchivo"]);
					array_push($arrRutaDocumentos,$rutaArchivo);
					$zip->addFile($rutaArchivo,($fArchivo["nomArchivoOriginal"]));
				}
				
				 
				$pathSave = $archivoZip.'.zip';
				$zip->saveZip($pathSave);
				$zip->downloadZip($pathSave);
				unlink($pathSave);
				foreach($arrRutaDocumentos as $r)
				{
					unlink($r);
				}
				
			}
		}
	}
}
?>