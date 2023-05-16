<?php  session_start();

	include("conexionBD.php");

	$formato="1"; //1=xml; 2 json
	$carpetaAdministrativa=$_POST["cA"];	
	$idCarpeta=$_POST["idCarpeta"];
	$formato=$_POST["formato"];
	$nombreArhivoTemporal=generarNombreArchivoTemporal();
	$directorioDestino=$baseDir."/archivosTemporales/".$nombreArhivoTemporal;
	if($formato==1)
	{
		$xml='<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
				<TipoDocumentoFoliado xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">';
		
		$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		if($idCarpeta!="-1")
			$consulta.=" AND idCarpeta=".$idCarpeta;	
	
		$fCarpeta=$con->obtenerPrimeraFilaAsoc($consulta);
	
		$consulta="SELECT * FROM 7007_contenidosCarpetaAdministrativa WHERE carpetaAdministrativaRaiz='".$carpetaAdministrativa."' and tipoContenido not in (3,-1) and copia=0";
		if($idCarpeta!=-1)
		{
			$consulta.=" and idCarpetaAdministrativaRaiz=".$idCarpeta;
		}
		
		$consulta.=" order by idContenido";
		$res=$con->obtenerFilas($consulta);
		
		while($fila=mysql_fetch_assoc($res))
		{
			$consulta="SELECT nomArchivoOriginal,tamano,descripcion,fechaCreacion,sha512,categoriaDocumentos FROM 908_archivos WHERE idArchivo=".$fila["idRegistroContenidoReferencia"];
			
			$fArchivo=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$nomArchivoOriginal=$fArchivo["nomArchivoOriginal"];		
			$tamano=$fArchivo["tamano"];		
			$arrExtensiones=explode(".",$nomArchivoOriginal);
			$extension=$arrExtensiones[count($arrExtensiones)-1];
			
			$tamanoBytes=bytesToSize($tamano, 0);
			$tipoDocumental="";
			$consulta="SELECT nombreCategoria FROM 908_categoriasDocumentos WHERE idCategoria=".($fArchivo["categoriaDocumentos"]==""?-1:$fArchivo["categoriaDocumentos"]);
			$tipoDocumental=$con->obtenerValor($consulta);
			if($tipoDocumental=="")
				$tipoDocumental="NO ESPECIFICADO";
				
			$consulta="SELECT valor FROM 908_metaDataArchivos WHERE idArchivo=".$fila["idRegistroContenidoReferencia"]." AND idMetaDato=1";
			$descripcion=$con->obtenerValor($consulta);
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
						<Formato><![CDATA[".($extension=="PDF"?"PDF/A":$extension)."]]></Formato>
						<Tamano><![CDATA[".$tamanoBytes."]]></Tamano>
						<Observaciones><![CDATA[".cv($descripcion)."]]></Observaciones>
					</DocumentoIndizado>";
			$xml.=$oNodo;
			
		}
		$xml.="</TipoDocumentoFoliado>";
		
		$nombreArchivoFinal="eIndice_".str_replace("-","_",$carpetaAdministrativa).".xml";
		escribirContenidoArchivo($directorioDestino,$xml);		
		$idDocumentoRegistrado=registrarDocumentoServidorRepositorio($nombreArhivoTemporal,$nombreArchivoFinal,2,"");
		$rutaDocumento=obtenerRutaDocumento($idDocumentoRegistrado);

			
		header("Content-type:application/xml"); 
		header("Content-Disposition: attachment; filename=".$nombreArchivoFinal);
		readfile($rutaDocumento);
		
		
	}
	else
	{
		
		$arrDocumentos='';
		$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		if($idCarpeta!="-1")
			$consulta.=" AND idCarpeta=".$idCarpeta;	
	
		$fCarpeta=$con->obtenerPrimeraFilaAsoc($consulta);
	
		$consulta="SELECT * FROM 7007_contenidosCarpetaAdministrativa WHERE carpetaAdministrativaRaiz='".$carpetaAdministrativa."' and tipoContenido not in (3,-1) and copia=0";
		if($idCarpeta!=-1)
		{
			$consulta.=" and idCarpetaAdministrativaRaiz=".$idCarpeta;
		}
		
		$consulta.=" order by idContenido";
		$res=$con->obtenerFilas($consulta);
		
		while($fila=mysql_fetch_assoc($res))
		{
			$consulta="SELECT nomArchivoOriginal,tamano,descripcion,fechaCreacion,sha512,categoriaDocumentos FROM 908_archivos WHERE idArchivo=".$fila["idRegistroContenidoReferencia"];
			
			$fArchivo=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$nomArchivoOriginal=$fArchivo["nomArchivoOriginal"];		
			$tamano=$fArchivo["tamano"];		
			$arrExtensiones=explode(".",$nomArchivoOriginal);
			$extension=$arrExtensiones[count($arrExtensiones)-1];
			
			$tamanoBytes=bytesToSize($tamano, 0);
			$tipoDocumental="";
			$consulta="SELECT nombreCategoria FROM 908_categoriasDocumentos WHERE idCategoria=".($fArchivo["categoriaDocumentos"]==""?-1:$fArchivo["categoriaDocumentos"]);
			$tipoDocumental=$con->obtenerValor($consulta);
			if($tipoDocumental=="")
				$tipoDocumental="NO ESPECIFICADO";
			$consulta="SELECT valor FROM 908_metaDataArchivos WHERE idArchivo=".$fila["idRegistroContenidoReferencia"]." AND idMetaDato=1";
			$descripcion=$con->obtenerValor($consulta);
			$oNodo=	'	{
							"Id":"'.cv($fila["idContenido"]).'",
							"Nombre_Documento":"'.cv($nomArchivoOriginal).'",
							"Tipologia_Documental":"'.cv($tipoDocumental).'",
							"Fecha_Creacion_Documento":"'.cv($fArchivo["fechaCreacion"]).'",
							"Fecha_Incorporacion_Expediente":"'.cv($fArchivo["fechaCreacion"]).'",
							"Valor_Huella":"'.cv($fArchivo["sha512"]).'",
							"Funcion_Resumen":"SHA512",
							"Orden_Documento_Expediente":"'.cv($fila["ordenDocumento"]).'",
							"Pagina_Inicio":"'.cv($fila["paginaInicio"]).'",
							"Pagina_Fin":"'.cv($fila["paginaFin"]).'",
							"Formato":"'.cv($extension=="PDF"?"PDF/A":$extension).'",
							"Tamano":"'.cv($tamanoBytes).'",
							"Observaciones":"'.cv($descripcion).'"
						}
					';		
			if($arrDocumentos=="")
				$arrDocumentos=$oNodo;
			else
				$arrDocumentos.=",".$oNodo;
			
		}
		
		$objJSON='{"TipoDocumentoFoliado":['.$arrDocumentos.']}';
		escribirContenidoArchivo($directorioDestino,$objJSON);
		
		$nombreArchivoFinal="eIndice_".str_replace("-","_",$carpetaAdministrativa).".json";	
		$idDocumentoRegistrado=registrarDocumentoServidorRepositorio($nombreArhivoTemporal,$nombreArchivoFinal,2,"");
		$rutaDocumento=obtenerRutaDocumento($idDocumentoRegistrado);
		
		
		header("Content-type:application/json"); 
		header("Content-Disposition: attachment; filename=".$nombreArchivoFinal);
		readfile($rutaDocumento);
		
		
	}
		
?>