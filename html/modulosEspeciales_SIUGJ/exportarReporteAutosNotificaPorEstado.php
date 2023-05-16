<?php session_start();

	include("conexionBD.php");
	
	$fechaInicio=$_GET["fechaInicio"];
	$fechaFin=$_GET["fechaFin"];
	
	$libro=new cExcel($baseDir."/modulosEspeciales_SIUGJ/plantillas/autosNotificaEstado.xlsx",true,"Excel2007");
	
	
	$libro->setValor("B2","Del ".date("d/m/Y",strtotime($fechaInicio))." al ".date("d/m/Y",strtotime($fechaFin)));
	
	$numFila=5;
	$numElemento=1;
	$consulta="SELECT a.idArchivo AS idDocumento,a.nomArchivoOriginal AS nombreAuto,(SELECT nombreCategoria FROM 908_categoriasDocumentos WHERE idCategoria=a.categoriaDocumentos)
				 AS tipoDocumento,f.fechaBloqueo AS  fechaCreacion,
					0 AS enviadoEstado,'' AS fechaEnvioEstado,i.carpetaAdministrativa,i.idFormulario AS iFormulario,i.idReferencia AS iFormulario
					FROM 3000_formatosRegistrados f,7035_informacionDocumentos i,7006_carpetasAdministrativas c,908_archivos a,908_categoriasDocumentos cD,908_tipoDocumentos tD 
					WHERE f.fechaBloqueo>='".$fechaInicio."' 
					AND f.fechaBloqueo <='".$fechaFin." 23:59:59'
					AND f.idFormulario=-2 AND f.idRegistro=i.idRegistro AND i.carpetaAdministrativa=c.carpetaAdministrativa AND c.unidadGestion='".$_SESSION["codigoInstitucion"]."'
					AND a.idArchivo=f.idDocumento AND cD.idCategoria=a.categoriaDocumentos AND tD.idRegistro=cD.idCategoriaDocumento AND tD.seNotificaEstado=1 ORDER BY f.fechaBloqueo";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($res))
	{
		
		$libro->setValor("A".$numFila,$numElemento);
		$libro->setValor("B".$numFila,date("d/m/Y",strtotime($fila["fechaCreacion"])));
		$libro->setValor("C".$numFila,$fila["carpetaAdministrativa"]);
		$libro->setValor("D".$numFila,$fila["nombreAuto"]);
		$libro->setValor("E".$numFila,$fila["tipoDocumento"]);
		$libro->setValor("F".$numFila,$fila["enviadoEstado"]==1?'Sí':'No');
		$libro->setValor("G".$numFila,"");
		$libro->setBorde("A".$numFila.":G".$numFila,"DE");
		$numFila++;
		$numElemento++;
		
	}
	$directorioDestino=$baseDir."/archivosTemporales/reporteAutoEstado_".str_replace("-","_",$fechaInicio)."_al_".str_replace("-","_",$fechaFin);
	$libro->generarArchivoServidor("PDF",$directorioDestino);
	$archivoDestino=$directorioDestino.".pdf";
	header("Content-type:application/pdf"); 
	header("Content-length: ".filesize($archivoDestino)); 
	header("Content-Disposition: attachment; filename=reporteAutoEstado_".str_replace("-","_",$fechaInicio)."_al_".str_replace("-","_",$fechaFin).".pdf");
	readfile($archivoDestino);
	
	unlink($directorioDestino);
	unlink($archivoDestino);
	
	
	
?>