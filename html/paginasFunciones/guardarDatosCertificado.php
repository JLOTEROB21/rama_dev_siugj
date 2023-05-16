<?php session_start();
	include_once("conexionBD.php");
	include_once("cfdi/funciones.php");
	$contrasena=$_POST["contrasena"];
	$codigoUnidad=$_POST["codigoUnidad"];	
	$idFormulario=$_POST["idFormulario"];
	$idReferencia=$_POST["idReferencia"];
	$idResponsable=$_POST["idResponsable"];
	$fInicio="";
	$fFin="";
	$fechaActual=strtotime(date("Y-m-d H:i:s"));
	$noCertificado="";
	
	$pagina="";
	$arrParametros=array();
	
	$configuracion=$_POST["confReferencia"];
	
	
	if (!empty($_FILES['archivoCer']['name']))
	{
		$err=0;
		
		if(esCertificadoSelloDigital($_FILES['archivoCer']['tmp_name']))
		{
			$noCertificado=obtenerNumCertificado($_FILES['archivoCer']['tmp_name']);	
			
			//if(!existeCertificado($noCertificado))
			{
				if(esContrasenaCorrecta($_FILES['archivoKey']['tmp_name'],$contrasena))
				{
					$nombreArchivo=$baseDir."/archivosTemporales/".date("YmdHis_").rand(100,1000).".pem";
					$comando="openssl pkcs8 -inform DER  -in ".$_FILES['archivoKey']['tmp_name']." -passin pass:".$contrasena." -out ".$nombreArchivo;

					$resultado=shell_exec($comando);
					
					
					
					if(verificarCompatibilidadArchivosCerKey($_FILES['archivoCer']['tmp_name'],$nombreArchivo))
					{
					
						if(file_exists($nombreArchivo))
							unlink($nombreArchivo);
						$fInicio=obtenerFechaInicioVigencia($_FILES['archivoCer']['tmp_name']);	
						$fFin=obtenerFechaFinVigencia($_FILES['archivoCer']['tmp_name']);	
						
						if(!(($fechaActual>=strtotime($fInicio))  &&($fechaActual<=strtotime($fFin) )))
						{
							$err=3;
						}
					}
					else
					{
						if(file_exists($nombreArchivo))
							unlink($nombreArchivo);
						$err=5;
					}
					
				}
				else
					$err=2;
			}
			/*else
				$err=4;*/
		}
		else
			$err=1;
	}
	
	
	$pagina="../tesoreria/admonCertificado.php";

	if($err==0)
	{
		$arrParametros[0][0]="configuracion";
		$arrParametros[0][1]=$configuracion;
		
		$certificadoDigital=obtenerCertificadoDigitalB64($_FILES['archivoCer']['tmp_name']);
		$consulta="INSERT INTO 687_certificadosSelloDigital(noCertificado,fechaInicioVigencia,fechaFinVigencia,claveArchivoKey,codigoUnidad,activo,idReferencia,idFormulario,idResponsable,fechaRegistro,certificadoDigital)
					VALUES('".$noCertificado."','".$fInicio."','".$fFin."','".$contrasena."','".$codigoUnidad."',1,".$idReferencia.",".$idFormulario.",".$idResponsable.",'".date("Y-m-d H:i:s")."','".$certificadoDigital."')";
		

		if($con->ejecutarConsulta($consulta))
		{
			$idCertificado=$con->obtenerUltimoID();
			copy($_FILES['archivoCer']['tmp_name'],$baseDir."/tesoreria/certificados/".$idCertificado.".cer");
			copy($_FILES['archivoKey']['tmp_name'],$baseDir."/tesoreria/certificados/".$idCertificado.".key");
			$rutaArchivoKey=$baseDir."/tesoreria/certificados/".$idCertificado.".key";
			convertirKeyToPem($rutaArchivoKey,$contrasena);
			$rutaArchivoCer=$baseDir."/tesoreria/certificados/".$idCertificado.".cer";
			convertirCerToPem($rutaArchivoCer);
			
			convertirKeyToPemFinkok($baseDir."/tesoreria/certificados/".$idCertificado.".pem");
			
			
			
			
			
			$pagina="../tesoreria/admonCertificado.php";
			cambiarValorObjParametros($configuracion,"idCertificado",$idCertificado);
			
		}

		
	}
	else
	{
		$confReferencia=obtenerValorObjParametros($configuracion,"confReferencia");
		$arrParametros[0][0]="confReferencia";
		$arrParametros[0][1]=$confReferencia;
		$arrParametros[1][0]="err";
		$arrParametros[1][1]=$err;
		$arrParametros[2][0]="idCertificado";
		$arrParametros[2][1]=-1;
		$arrParametros[3][0]="codigoUnidad";
		$arrParametros[3][1]=$codigoUnidad;
		$arrParametros[4][0]="idFormulario";
		$arrParametros[4][1]=$idFormulario;
		$arrParametros[5][0]="idResponsable";
		$arrParametros[5][1]=$idResponsable;
		$arrParametros[6][0]="cPagina";
		$arrParametros[6][1]="sFrm=true";
		$arrParametros[7][0]="idReferencia";
		$arrParametros[7][1]=$idReferencia;
	}
	
	
?>
<html>
	<body>
    <?php
		enviarPagina($pagina,$arrParametros);
	?>
    </body>
</html>
