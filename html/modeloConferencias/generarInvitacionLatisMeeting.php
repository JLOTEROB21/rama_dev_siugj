<?php session_start();

	include("conexionBD.php");
	include_once("PHPWord.php");
	include_once("zip.lib.php"); 
	
	
	$idRegistro=-1;
	if(isset($_POST["idRegistro"]))
		$idRegistro=$_POST["idRegistro"];
	
		
	$urlAccesoAudiencia=$urlPantallaAccesoReunion;
		
	$PHPWord = new PHPWord();
	$document = $PHPWord->loadTemplate($baseDir.'\\modeloConferencias\\plantillas\\invitacionLatisMeeting.docx');	
	
	
	$consulta="SELECT * FROM 7051_participantesReunionesVirtuales WHERE idRegistro=".$idRegistro;
	$fParticipante=$con->obtenerPrimeraFilaAsoc($consulta);
	
	
	$consulta="SELECT * FROM 7050_reunionesVirtualesProgramadas WHERE idRegistro=".$fParticipante["idReunion"];
	$fReunion=$con->obtenerPrimeraFilaAsoc($consulta);
	
	
	$fechaReunion=strtotime($fReunion["fechaProgramada"]);
		
	$lblHoras="";
	$horas=floor ($fReunion["duracion"]/60);
	
	if($horas>0)
	{
		$lblHoras=$horas." ".($horas==1?"hora":"horas");
		
	}
	
	$minutos=$fReunion["duracion"]-($horas*60);
	if($minutos>0)
	{
		$lblHoras.=", ".$minutos." minutos";
	}
	
	
	
	
	$nombreParticipante="";
	
	switch($fParticipante["tipoParticipante"])
	{
		case 1:
			$nombreParticipante=obtenerNombreUsuario($fParticipante["nombreParticipante"]);
		break;
		case 2:
			$nombreParticipante=$fParticipante["nombreParticipante"];
		break;
		
		case 4:
			$consulta=" SELECT apellidoPaterno,apellidoMaterno,nombre FROM _47_tablaDinamica WHERE id__47_tablaDinamica=".$fParticipante["nombreParticipante"];
			$fBusqueda=$con->obtenerPrimeraFila($consulta);
			$nombreParticipante=$fBusqueda[2]." ".$fBusqueda[0]." ".$fBusqueda[1];
		break;
	}
	
	$arrValores["nombreParticipante"]=$nombreParticipante;
	$arrValores["urlReunion"]=$urlAccesoAudiencia;
	$arrValores["codigoAcceso"]=$fReunion["reunionID"];
	$arrValores["password"]=$fParticipante["passwdReunion"];
	$arrValores["tituloReunion"]=$fReunion["nombreReunion"];
	$arrValores["fecha"]=$arrDiasSemana[date("w",$fechaReunion)*1].", ".date("d",$fechaReunion)." de ".$arrMesLetra[(date("m",$fechaReunion)*1)-1]." de ".date("Y",$fechaReunion);
	$arrValores["hora"]=date("h:i a",$fechaReunion)." | (UTC-05:00) Guadalajara, Ciudad de México, Monterrey | ".$lblHoras;
	
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
	
?>