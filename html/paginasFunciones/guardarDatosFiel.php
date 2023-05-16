<?php session_start();
	include_once("conexionBD.php");
	include_once("cfdi/funciones.php");
	
	$contrasena=$_POST["contrasena"];
	$idEmpresa=$_POST["idEmpresa"];
	
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
		
		if(esCertificadoFiel($_FILES['archivoCer']['tmp_name']))
		{
			$noCertificado=obtenerNumCertificado($_FILES['archivoCer']['tmp_name']);	
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
					else
					{
						if(!esCertificadoEmpresa($idEmpresa,$_FILES['archivoCer']['tmp_name']))
						{
							$err=4;
							
						}

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
			{
				$err=2;

			}
			
		}
		else
			$err=1;
	}
	
	
	$pagina="../tesoreria/autorizacionManifiesto.php";
	$ejecutarScript=false;
	if($err==0)
	{
		$arrParametros[0][0]="configuracion";
		$arrParametros[0][1]=$configuracion;
		
		//$certificadoDigital=obtenerCertificadoDigitalB64($_FILES['archivoCer']['tmp_name']);
		if(!file_exists($baseDir."/tesoreria/fiel"))
		{
			
			mkdir($baseDir."/tesoreria/fiel");	
		}
		
		if(file_exists($baseDir."/tesoreria/fiel"))
		{
			
			copy($_FILES['archivoCer']['tmp_name'],$baseDir."/tesoreria/fiel/".$idEmpresa.".cer");
			copy($_FILES['archivoKey']['tmp_name'],$baseDir."/tesoreria/fiel/".$idEmpresa.".key");
			$consulta="UPDATE 6927_empresas SET situacionManifiesto='1',cadenaManifiesto='".$contrasena."' WHERE idEmpresa=".$idEmpresa;
			if($con->ejecutarConsulta($consulta))
			{
				$ejecutarScript=true;
			}
		}
		
	}
	else
	{
		$confReferencia=obtenerValorObjParametros($configuracion,"confReferencia");
		$arrParametros[0][0]="confReferencia";
		$arrParametros[0][1]=$confReferencia;
		$arrParametros[1][0]="err";
		$arrParametros[1][1]=$err;
		$arrParametros[2][0]="idEmpresa";
		$arrParametros[2][1]=$idEmpresa;
		$arrParametros[3][0]="cPagina";
		$arrParametros[3][1]="sFrm=true";
	}
	
	
	
?>
<html>
	<body>
    <?php

		if($err!=0)
			enviarPagina($pagina,$arrParametros);
		else
		{
			if($ejecutarScript)
			{
	?>
    			<script>
    			window.parent.recargarPagina();
				</script>
    <?php	
			}
		}
	?>
    </body>
</html>
