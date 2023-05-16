<?php  session_start();

		include("conexionBD.php");

	$idFormulario=990;
	$idRegistro=5;
	if(isset($_POST["idRegistro"]))
		$idRegistro=$_POST["idRegistro"];
	else
		if(isset($_GET["idRegistro"]))
			$idRegistro=$_GET["idRegistro"];	

	$libro=new cExcel($baseDir."/modulosEspeciales_SIUGJ/plantillas/InformeSeleccion.xlsx",true,"Excel2007");		
	
	
	$consulta="SELECT * FROM _990_tablaDinamica WHERE id__990_tablaDinamica=".$idRegistro;

	$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$habilitarConJuez=false;
	$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$fRegistroBase["despachoAsignado"]."'";
	$despachoEnvia=$con->obtenerValor($consulta);
	
	$carpetaAdministrativa=$fRegistroBase["codigo"];
	
	$libro->setValor("C2",$fRegistroBase["codigo"]);
	$libro->setValor("C3",$despachoEnvia);
	$libro->setValor("C4",date("d/m/Y H:i:s"));
	
	$totalTutelas=0;
	$totalTutelasRecomendadas=0;
	
	
	
	$numFilas=10;
	$numReg=1;
	$consulta="SELECT * FROM _917_tablaDinamica WHERE idReferencia=".$idRegistro;
	$rTutelas=$con->obtenerFilas($consulta);
	while($fTutela=mysql_fetch_assoc($rTutelas))
	{
		
		$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$fTutela["carpetaAdministrativa"]."'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		$consulta="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$fTutela["codigoInstitucion"]."'";
		$despachoEnvia=$con->obtenerValor($consulta);
		
		$libro->setValor("A".$numFilas,$numReg.".-");
		$libro->setValor("B".$numFilas,$fTutela["folioCorteConstitucional"]);
		$libro->setValor("C".$numFilas,$fTutela["carpetaAdministrativa"]);
		$libro->setValor("D".$numFilas,$despachoEnvia);
		
		$query="SELECT candidatoSeleccion FROM _995_tablaDinamica WHERE idReferencia=".$fTutela["id__917_tablaDinamica"];
		$candidatoSeleccion=$con->obtenerValor($query);
		
		
		if($candidatoSeleccion==1)
			$totalTutelasRecomendadas++;
		
		$libro->setValor("E".$numFilas,$candidatoSeleccion==1?'Sí':'No');
		
		
		$query="SELECT CONCAT(if( apellidoPaterno IS NULL,'',apellidoPaterno),' ',if(apellidoMaterno IS NULL,'',apellidoMaterno) ) AS apellido,
				if (nombre IS NULL,'',nombre) as nombre,i.folioIdentificacion
				 FROM _47_tablaDinamica i,7005_relacionFigurasJuridicasSolicitud r,_5_tablaDinamica f WHERE r.idActividad=".$fRegistro["idActividad"]."
				and r.idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='A') AND r.idParticipante=i.id__47_tablaDinamica 
				AND f.id__5_tablaDinamica=r.idFiguraJuridica ORDER BY nombre,apellidoPaterno,apellidoMaterno";
		
		$accionado=$con->obtenerListaValores($query);
		
		$libro->setValor("F".$numFilas,$accionado);
		
		$query="SELECT CONCAT(if( apellidoPaterno IS NULL,'',apellidoPaterno),' ',if(apellidoMaterno IS NULL,'',apellidoMaterno) ) AS apellido,
				if (nombre IS NULL,'',nombre) as nombre,i.folioIdentificacion
				FROM _47_tablaDinamica i,7005_relacionFigurasJuridicasSolicitud r,_5_tablaDinamica f WHERE r.idActividad=".$fRegistro["idActividad"]."
				and r.idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='D') AND r.idParticipante=i.id__47_tablaDinamica 
				AND f.id__5_tablaDinamica=r.idFiguraJuridica ORDER BY nombre,apellidoPaterno,apellidoMaterno";
		
		$accionate=$con->obtenerListaValores($query);
		
		$libro->setValor("G".$numFilas,$accionate);
		
		//$libro->setBorde("A".$numFilas.":G".$numFilas,"DE");
		
		
		$consulta="SELECT * FROM _989_tablaDinamica WHERE idReferencia=".$fTutela["id__917_tablaDinamica"];
		$fRegistroEstudio=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$numFilas++;
		
		$consulta="SELECT contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=13570 AND valor=".$fRegistroEstudio["criteriosObjetivos"];
		$valor=$con->obtenerValor($consulta);
		$libro->setValor("C".$numFilas,$valor);
		$libro->setValor("B".$numFilas,"Criterios Objetivos:");
		$libro->setNegritas("B".$numFilas);
		$libro->setAltoFila($numFilas,18);
		$numFilas++;
		
		$consulta="SELECT contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=13571 AND valor=".$fRegistroEstudio["criteriosSubjetivos"];
		$valor=$con->obtenerValor($consulta);
		$libro->setValor("C".$numFilas,$valor);
		$libro->setValor("B".$numFilas,"Criterios Subjetivos:");
		$libro->setNegritas("B".$numFilas);
		$libro->setAltoFila($numFilas,18);
		$numFilas++;
		
		$consulta="SELECT contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=13572 AND valor=".$fRegistroEstudio["criteriosComplementarios"];
		$valor=$con->obtenerValor($consulta);
		$libro->setValor("C".$numFilas,$valor);
		$libro->setValor("B".$numFilas,"Criterios Complementarios:");
		$libro->setNegritas("B".$numFilas);
		$libro->setAltoFila($numFilas,18);
		$numFilas++;
		$libro->setValor("C".$numFilas,$fRegistroEstudio["otrosCriterios"]);
		$libro->setValor("B".$numFilas,"Otros Criterios:");
		$libro->setNegritas("B".$numFilas);
		$libro->setAltoFila($numFilas,18);
		$numFilas++;
		
		$numReg++;
		$numFilas+=3;
		$totalTutelas++;
	
	}
	

	
	$libro->setValor("C5",$totalTutelas);
	$libro->setValor("C6",$totalTutelasRecomendadas);
	
	
	$nombreArchivoFinal="informeRecomendacion_".str_replace("/","_",$fRegistroBase["codigo"]);
	$directorioDestino=$baseDir."/archivosTemporales/".$nombreArchivoFinal;
	
	$archivoFinal=$directorioDestino.".pdf";
	$libro->generarArchivoServidor("PDF",$directorioDestino);
	

	if(file_exists($archivoFinal))
	{
		$tamano=filesize($archivoFinal);
		$idDocumentoRegistrado=registrarDocumentoServidorRepositorio($nombreArchivoFinal.".pdf",$nombreArchivoFinal.".pdf",107,"");
		
		
		registrarDocumentoResultadoProceso($idFormulario,$idRegistro,$idDocumentoRegistrado);
		header("Content-type:application/pdf"); 
		header("Content-length: ".$tamano); 
		header("Content-Disposition: inline; filename=".$nombreArchivoFinal.".pdf");
		echo obtenerCuerpoDocumentoB64($idDocumentoRegistrado,false);
		
		

		
	}
	else
	{
		echo "NO existe";	
	}
	
	
		
?>