<?php session_start();
	include_once("conexionBD.php");
	include_once("utiles.php");
	
	
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	$lenguaje=$_SESSION["leng"];
	
	switch($funcion)
	{
		case 1:
			registrarDocumentosProceso();
		break;
		case 2:
			registrarDocumentosProcesoCarpetaJudicial();
		break;
		case 3:
			removerDocumentosProcesoCarpetaJudicial();
		break;
		case 4:
			obtenerConfiguracionDocumentosModuloRegistro();
		break;
		case 5:
			registrarConfiguracionDocumentosModuloRegistro();
		break;
	}




	function registrarDocumentosProceso()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$listaDocumentos="";
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($obj->arrDocumentos as $d)
		{
			if(($d->presentaDocumento==1)&&($d->idRegistro!=-1))
			{
				if($listaDocumentos=="")
					$listaDocumentos=$d->idRegistro;
				else
					$listaDocumentos.=",".$d->idRegistro;
			}
			
		}
		if($listaDocumentos=="")
			$listaDocumentos=-1;

		if($obj->idActividad!=-1)
			$consulta[$x]="DELETE FROM 9503_documentosRegistradosProceso WHERE idActividad=".$obj->idActividad." AND idRegistro NOT IN(".$listaDocumentos.")";
		else
			$consulta[$x]="DELETE FROM 9503_documentosRegistradosProceso WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idRegistro." and idRegistro NOT IN(".$listaDocumentos.")";
		$x++;
		
		foreach($obj->arrDocumentos as $d)
		{
			
			if($d->presentaDocumento==1)
			{

				$idDocumento="NULL";
				
				if($d->documentoDigital!="")
				{
					
					$arrDocumentosNombre=explode("|",$d->documentoDigital);
					$idDocumento=$arrDocumentosNombre[1];
					$nombreDocumento=$arrDocumentosNombre[0];
					
					if(strpos($idDocumento,"_")!==false)
					{
						$idDocumento=registrarDocumentoServidorRepositorio($idDocumento,$nombreDocumento,$d->idDocumento,"");
					}
					
				}
				if($d->idRegistro<0)
				{
					$consulta[$x]="INSERT INTO 9503_documentosRegistradosProceso(idActividad,idTipoDocumento,idDocumento,presentaDocumento,idFormulario,idReferencia)
								VALUES(".$obj->idActividad.",".$d->idDocumento.",".$idDocumento.",1,".$obj->idFormulario.",".$obj->idRegistro.")";
					$x++;
				}
				else
				{
					$consulta[$x]="UPDATE 9503_documentosRegistradosProceso SET idDocumento=".$idDocumento." WHERE idRegistro=".$d->idRegistro;
					$x++;
				}
			}
		}
		
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$arrDocumentos=obtenerDocumentacionRequeridaClaseProceso($obj->idFormulario,$obj->idRegistro);
			echo "1|".bE($arrDocumentos);
		}
		
	}
	
	
	function registrarDocumentosProcesoCarpetaJudicial()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$listaDocumentos="";
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($obj->arrDocumentos as $d)
		{
			$query="SELECT categoriaDocumentos FROM 908_archivos WHERE idArchivo=".$d->idDocumento;
			$idTipoDocumento=$con->obtenerValor($query);
			
			$consulta[$x]="INSERT INTO 9503_documentosRegistradosProceso(idTipoDocumento,idDocumento,presentaDocumento,idFormulario,idReferencia)
							values(".$idTipoDocumento.",".$d->idDocumento.",1,".$obj->idFormulario.",".$obj->idReferencia.")";
			
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
		{
			$arrDocumentos=obtenerDocumentacionRequeridaClaseProceso($obj->idFormulario,$obj->idReferencia);
			echo "1|".bE($arrDocumentos);
		}
	}
	
	function removerDocumentosProcesoCarpetaJudicial()
	{
		global $con;
		$listaDocumentos=$_POST["listaDocumentos"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 9503_documentosRegistradosProceso WHERE idRegistro IN(".$listaDocumentos.")";
		$x++;
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
		{
			echo "1|";
		}
	}
	
	function obtenerConfiguracionDocumentosModuloRegistro()
	{
		global $con;
		$idFormularioProceso=$_POST["idFormularioProceso"];
		$idProceso=$_POST["idProceso"];
		$consulta="SELECT tipoDocumento,obligatorio,funcionAplicacion,
				(SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=d.funcionAplicacion) AS  nombreFuncion
				FROM 3025_documentosPermitidosRegistro d
				WHERE idProceso=".$idProceso." AND idFormularioProceso=".$idFormularioProceso;
				
				
		$arrFilas=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrFilas.'}'	;	
				
	}
	
	function registrarConfiguracionDocumentosModuloRegistro()
	{
		global $con;
		
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 3025_documentosPermitidosRegistro WHERE idProceso=".$obj->idProceso." AND idFormularioProceso=".$obj->idFormularioProceso;
		$x++;
		foreach($obj->arrFilas as $d)
		{
			$consulta[$x]="INSERT INTO 3025_documentosPermitidosRegistro(idProceso,idFormularioProceso,tipoDocumento,obligatorio,funcionAplicacion)
							values(".$obj->idProceso.",".$obj->idFormularioProceso.",".$d->tipoDocumento.",".$d->obligatorio.",".
							($d->funcionAplicacion==""?"NULL":$d->funcionAplicacion).")";
			
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
		{
			echo "1|";
		}
	}
?>