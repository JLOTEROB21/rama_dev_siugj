<?php
	 session_start();

	include("conexionBD.php");

	$formato="1"; //1=xml; 2 json
	$carpetaAdministrativa="";
	$idCarpeta=-1;
	if(isset($_POST["cA"]))
		$carpetaAdministrativa=$_POST["cA"];	

	if(isset($_POST["idCarpeta"]))
		$idCarpeta=$_POST["idCarpeta"];
	
	$xml='<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
	$xml.='<expedientes>';
	
	$expedientes=exportarExpedienteElectronico($carpetaAdministrativa,$idCarpeta,0);
	$xml.=$expedientes;
	$xml.='</expedientes>';

	$nombreArchivoFinal="eExpediente_".str_replace("-","_",$carpetaAdministrativa).".xml";	
	header("Content-type:application/xml"); 
	header("Content-Disposition: attachment; filename=".$nombreArchivoFinal);
	echo $xml;
	
	
	
	function exportarExpedienteElectronico($carpetaAdministrativa,$idCarpetaAdministrativa,$nivelExpediente)
	{
		global $con;
		$arrExpedientTable="";
	

		$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		if($idCarpetaAdministrativa!="-1")
			$consulta.=" AND idCarpeta=".$idCarpetaAdministrativa;	
		$filaArchivo=$con->obtenerPrimeraFilaAsoc($consulta);
		
		foreach($filaArchivo as $llave=>$valor)
		{
			$arrExpedientTable.="<".$llave."><![CDATA[".$valor."]]></".$llave.">";
		}
		
		
		$xml='	<ExpedienteElectronico>
					<procesoJudial>'.$carpetaAdministrativa.'</procesoJudial>
					<expedientTable>'.$arrExpedientTable.'</expedientTable>
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
		
		while($fila=mysql_fetch_assoc($res))
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
			
			while($fMetaData=mysql_fetch_assoc($rMetaDato))
			{
				$arrMetaData.="<metaDato>";
				foreach($fMetaData as $llave=>$valor)
				{
					if($llave!="tagMetaDato")
						$arrMetaData.="<".$llave."><![CDATA[".$valor."]]></".$llave.">";
				}
				
				$arrMetaData.="</metaDato>";
			}
			
			
			
			$arrArchiveTable="";
			$consulta="SELECT * FROM 908_archivos WHERE idArchivo=".$fila["idRegistroContenidoReferencia"];
			$filaArchivo=$con->obtenerPrimeraFilaAsoc($consulta);
			foreach($filaArchivo as $llave=>$valor)
			{
				if($llave=="cuerpoDocumento")
					$valor="";
				$arrArchiveTable.="<".$llave."><![CDATA[".$valor."]]></".$llave.">";
			}
	
			
			$arrContentTable="";
			$consulta="SELECT * FROM 7007_contenidosCarpetaAdministrativa WHERE idContenido=".$fila["idContenido"];
			$filaArchivo=$con->obtenerPrimeraFilaAsoc($consulta);
	
			foreach($filaArchivo as $llave=>$valor)
			{
				$arrContentTable.="<".$llave."><![CDATA[".$valor."]]></".$llave.">";
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
						<archiveTable>".$arrArchiveTable."</archiveTable>
						<archiveContentTable>".$arrContentTable."</archiveContentTable>
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
			while($fCarpetaAsociada=mysql_fetch_assoc($rCarpetasAsociadas))
			{
				$arrExpediente=exportarExpedienteElectronico($fCarpetaAsociada["carpetaAdministrativa"],$fCarpetaAsociada["idCarpeta"],($nivelExpediente++));
				$arrExpedientesAsociados.=$arrExpediente;	
			}
		}
		else
		{
			$consulta="SELECT carpetaAdministrativa,idCarpeta FROM 7006_carpetasAdministrativas WHERE 
					carpetaAdministrativaBase='".$carpetaAdministrativa."' AND idCarpetaAdministrativaBase=".$idCarpetaAdministrativa." ORDER BY carpetaAdministrativa";
			
			$rCarpetasAsociadas=$con->obtenerFilas($consulta);
			while($fCarpetaAsociada=mysql_fetch_assoc($rCarpetasAsociadas))
			{
				$arrExpediente=exportarExpedienteElectronico($fCarpetaAsociada["carpetaAdministrativa"],$fCarpetaAsociada["idCarpeta"],($nivelExpediente++));
				$arrExpedientesAsociados.=$arrExpediente;	
			}
		}
		
		$xml.="</documentosExpedientes><expedientesAsociados>".$arrExpedientesAsociados."</expedientesAsociados></ExpedienteElectronico>";
		
		return $xml;
	}
?>