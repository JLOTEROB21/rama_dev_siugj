<?php session_start();
	include("conexionBD.php");
	aperturarSesionUsuario(2);
					
	$fechaBase=date("Y-m-d");
	
	$nombreArchivo="log_".$fechaBase."_".date("His").".txt";
	
	$consulta="select * from 903_variablesSistema";
	$filaVariablesSistemas=$con->obtenerPrimeraFilaAsoc($consulta);
	$diasMantenerAuditoria=$filaVariablesSistemas["diasMantenerAuditoria"];
	
	$arrArchivos="";
	$fechaBase=date("Y-m-d",strtotime("-".$diasMantenerAuditoria." days",strtotime($fechaBase)));
	$consulta="SELECT * FROM 8000_logSistema WHERE fecha<='".$fechaBase."'";	
	$res=$con->obtenerFilas($consulta);
	$numRegistro=0;
	$filaCabecera="";
	while($fila=$con->fetchAssoc($res))
	{
		$filaRegistro="";
		foreach($fila as $clave=>$valor)
		{
			if($numRegistro==0)
			{
				if($filaCabecera=="")
				{
					$filaCabecera=$clave;	
				}
				else
				{
					$filaCabecera.="|@|".$clave;
				}
			}
			
			if($filaRegistro=="")
			{
				$filaRegistro=$valor;
			}
			else
			{
				$filaRegistro.="|@|".$valor;
			}
			
		}
		
		if($arrArchivos=="")
			$arrArchivos=$filaCabecera."\r\n".$filaRegistro;
		else
			$arrArchivos.="\r\n".$filaRegistro;
		
		$numRegistro++;
	}
	$archivoDestino=$baseDir."/archivosTemporales/".$nombreArchivo;
	
	if(escribirContenidoArchivo($archivoDestino,$arrArchivos))
	{
		
		$idDocumento=registrarDocumentoServidorRepositorio($nombreArchivo,$nombreArchivo,-10);
		if($idDocumento>0)
		{
			unlink($archivoDestino);
			$consulta="delete FROM 8000_logSistema WHERE fecha<='".$fechaBase."'";	
			$con->ejecutarConsulta($consulta);
		}
	}
	
	
	
	
	session_destroy();
	
?>
