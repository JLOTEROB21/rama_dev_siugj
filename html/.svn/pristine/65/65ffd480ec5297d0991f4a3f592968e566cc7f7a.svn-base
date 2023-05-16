<?php

	include("conexionBD.php");
	include_once("PHPWord.php");
	include_once("zip.lib.php"); 
	include_once("numeroToLetra.php"); 
	
	$tipoOficio=1;
	if(isset($_POST["tipoOficio"]))
		$tipoOficio=$_POST["tipoOficio"];
	
	switch($tipoOficio)
	{
		case 1:		
			$fechaActual=strtotime(date("Y-m-d"));
			
			$idFormulario=-1;
			$idRegistro=-1;
			if(isset($_POST["idFormulario"]))
				$idFormulario=$_POST["idFormulario"];
			
			if(isset($_POST["idRegistro"]))
				$idRegistro=$_POST["idRegistro"];
			
			$consulta="SELECT idRegistroEvento,tipoAudiencia,horaInicioEvento,idSala,idCentroGestion FROM 7000_eventosAudiencia WHERE idFormulario=".$idFormulario." AND
					 idRegistroSolicitud=".$idRegistro;
			
			$fRegistroEvento=$con->obtenerPrimeraFila($consulta);
			
			$idRegistroEvento=$fRegistroEvento[0];
			$tipoAudiencia=$fRegistroEvento[1];
			
			$PHPWord = new PHPWord();
			$document = $PHPWord->loadTemplate($baseDir.'\\modulosEspeciales_SGJP\\formatos\\notificacionJuez.docx');	
			if($fRegistroEvento[4]==49)
				$document = $PHPWord->loadTemplate($baseDir.'\\modulosEspeciales_SGJP\\formatos\\notificacionJuezAdolescentes.docx');	
			$arrValores=array();
			
			$arrValores["fechaGeneracion"]=date("d",$fechaActual)." de ".$arrMesLetra[(date("m",$fechaActual)*1)-1]." de ".date("Y",$fechaActual);
			
			$consulta="SELECT fj.clave,upper(u.Nombre)  FROM 7001_eventoAudienciaJuez j,_26_tablaDinamica fj,800_usuarios u 
						WHERE idRegistroEvento=".$idRegistroEvento." AND fj.usuarioJuez=j.idJuez AND u.idUsuario=j.idJuez";

			$fDatosEvento=$con->obtenerPrimeraFila($consulta);
			
			
			$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa 
						WHERE idFormulario=".$idFormulario." AND tipoContenido=3 AND idRegistroContenidoReferencia=".$idRegistroEvento;
			$cAdministrativa=$con->obtenerValor($consulta);
			
			$consulta="SELECT  idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cAdministrativa."'";
			$idActividad=$con->obtenerValor($consulta);
			if($idActividad=="")
				$idActividad=-1;
				
			$arrValores["nombreJuez"]=$fDatosEvento[1];
			$arrValores["noJuez"]=$fDatosEvento[0]*1;
			
			$arrValores["noCausa"]=$cAdministrativa;
			
			
			$consulta="SELECT GROUP_CONCAT(de.denominacionDelito) FROM _61_tablaDinamica d,_35_denominacionDelito de 
						WHERE idActividad=".$idActividad." AND d.denominacionDelito=de.id__35_denominacionDelito";
			
			$arrValores["delito"]=$con->obtenerValor($consulta);
			
			$consulta="SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$fRegistroEvento[1];
			$tipoAudiencia=$con->obtenerValor($consulta);
			
			$arrValores["tipoAudiencia"]=$tipoAudiencia;
			
			$consulta="SELECT nombreSala FROM _15_tablaDinamica WHERE id__15_tablaDinamica=".$fRegistroEvento[3];
			
			$nombreSala=$con->obtenerValor($consulta);
			$nombreSala=str_replace("Sala ","",$nombreSala);
			$arrValores["noOficio"]="__________________";
			$arrValores["sala"]=$nombreSala;
			$arrValores["fecha"]=date("d/m/Y",strtotime($fRegistroEvento[2]));
			$arrValores["hora"]=date("H:i",strtotime($fRegistroEvento[2]));
			$arrValores["leyendaTribunal"]=$leyendaTribunal;
			$consulta="SELECT claveFolioCarpetas,upper(nombreDirector) FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$fRegistroEvento[4];

			$fDatosUGA=$con->obtenerPrimeraFila($consulta);
			
			
			$numeroUGA=convertirNumeroLetra(($fDatosUGA[0]*1),false,false);
			
			$arrValores["noUGA"]=strtoupper($numeroUGA);
			$arrValores["directorUGA"]=$fDatosUGA[1];
			if($arrValores["noUGA"]=="UN")
				$arrValores["noUGA"]="UNO";
			foreach($arrValores as $llave=>$valor)
			{
				$document->setValue("[".$llave."]",utf8_decode($valor));	
			}
			
			$nombreAleatorio=generarNombreArchivoTemporal();
			$nomArchivo=$nombreAleatorio.".docx";
			$document->save($nomArchivo);
			
			$nombreFinal=str_replace(".docx",".pdf",$nomArchivo);

			generarDocumentoPDF($nomArchivo,false,false,true,$nombreFinal,"","./");

			header("Content-type:application/pdf"); 
			header("Content-length: ".filesize($nombreFinal)); 
			header("Content-Disposition: inline; filename=".$nombreFinal);
			readfile($nombreFinal);
			

			//unlink($nombreFinal);
		break;		
		case 2:
			$idFormulario=-1;
			$idRegistro=-1;
			if(isset($_POST["idFormulario"]))
				$idFormulario=$_POST["idFormulario"];
			
			if(isset($_POST["idRegistro"]))
				$idRegistro=$_POST["idRegistro"];
			
			$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE idFormulario=".$idFormulario." AND
					 idRegistroSolicitud=".$idRegistro;
			$idRegistroEvento=$con->obtenerValor($consulta);
			$datosEvento=obtenerDatosEventoAudiencia($idRegistroEvento);
			
			
			$PHPWord = new PHPWord();
			$document = $PHPWord->loadTemplate($baseDir.'\\modulosEspeciales_SGJP\\formatos\\acuseProgramacionAudiencia.docx');
			
			$fechaActual=strtotime($datosEvento->fechaEvento);
			$arrValores=array();
			
			$fechaFin=strtotime($datosEvento->horaFin);
			$arrValores["lblCarpetaJudicial"]=$tipoMateria=="P"?"Carpeta Judicial":"No. Expediente";
			$arrValores["lblCentroGestion"]=$tipoMateria=="P"?"Unidad de Gestión":"Juzgado";
			$arrValores["carpetaJudicial"]=$datosEvento->carpetaAdministrativa;
			$arrValores["fechaAudiencia"]=utf8_encode($arrDiasSemana[(date("w",$fechaActual)*1)])." ".date("d",$fechaActual)." de ".$arrMesLetra[(date("m",$fechaActual)*1)-1]." de ".date("Y",$fechaActual);;
			$arrValores["tipoAudiencia"]=$datosEvento->tipoAudiencia;
			$arrValores["duracion"]=(($fechaFin-strtotime($datosEvento->horaInicio))/60)." minutos";
			$arrValores["horario"]="De las ".date("H:i",strtotime($datosEvento->horaInicio))." hrs. a las ".date("H:i",strtotime($datosEvento->horaFin)).
					" hrs. del ".$arrDiasSemana[(date("w",$fechaFin)*1)]." ".date("d",$fechaFin)." de ".$arrMesLetra[(date("m",$fechaFin)*1)-1]." de ".date("Y",$fechaFin);
			$arrValores["sala"]=$datosEvento->sala;
			$arrValores["centroGestion"]=$datosEvento->unidadGestion;
			$arrValores["edificio"]=$datosEvento->edificio;
			$arrValores["nombreJuez"]=$datosEvento->jueces[0]->nombreJuez;
			$arrValores["leyendaTribunal"]=$leyendaTribunal;
			
			foreach($arrValores as $llave=>$valor)
			{
				$document->setValue("[".$llave."]",utf8_decode($valor));	
			}
			
			$nombreAleatorio=generarNombreArchivoTemporal();
			$nomArchivo=$nombreAleatorio.".docx";
			$document->save($nomArchivo);
			
			$nombreFinal=str_replace(".docx",".pdf",$nomArchivo);
			generarDocumentoPDF($nomArchivo,false,false,true,$nombreFinal,"","./");
			
			header("Content-type:application/pdf"); 
			header("Content-length: ".filesize($nombreFinal)); 
			header("Content-Disposition: inline; filename=".$nombreFinal);
			readfile($nombreFinal);
			
			
			unlink($nombreFinal);
			
			
		break;
	}
	
	
?>