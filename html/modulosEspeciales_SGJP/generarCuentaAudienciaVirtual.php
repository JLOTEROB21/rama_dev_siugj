<?php session_start();

	include("conexionBD.php");
	include_once("PHPWord.php");
	include_once("zip.lib.php"); 
	
	
	$idParticipante=493891;
	$idParticipante=-1;
	if(isset($_POST["idParticipante"]))
		$idParticipante=$_POST["idParticipante"];
	
	$carpetaAdministrativa="001/0001/2020";
	$carpetaAdministrativa="";
	if(isset($_POST["carpetaAdministrativa"]))
		$carpetaAdministrativa=$_POST["carpetaAdministrativa"];
	
	$reenviarDatosAcceso=0;
	if(isset($_POST["reenviarDatosAcceso"]))
		$reenviarDatosAcceso=$_POST["reenviarDatosAcceso"];
		
	$datosParticante=obtenerUltimoDomicilioFiguraJuridica($idParticipante);	
	$datosParticante=json_decode($datosParticante);
	$mail="";
	
	foreach($datosParticante->correos as $m)
	{
		if($mail=="")
			$mail=$m->mail;
		else
			$mail.=", ".$m->mail;
	}
		
	$PHPWord = new PHPWord();
	$document = $PHPWord->loadTemplate($baseDir.'\\modulosEspeciales_SGJP\\formatos\\formatoAccesoAudienciaVirtual.docx');	
	
	
	
	$fechaActual=strtotime(date("Y-m-d"));
	
	
	$consulta="SELECT ug.nombreUnidad AS unidadGestion,c.idActividad 
				FROM 7006_carpetasAdministrativas c,_17_tablaDinamica ug WHERE carpetaAdministrativa='".$carpetaAdministrativa."' AND
				ug.claveUnidad=c.unidadGestion";
	$fCarpetaJudicial=$con->obtenerPrimeraFila($consulta);
	$unidadGestion=$fCarpetaJudicial[0];
	$idActividad=$fCarpetaJudicial[1];
	
	$arrValores=array();
	
	$arrValores["dia"]=date("d",$fechaActual);
	$arrValores["mes"]=$arrMesLetra[(date("m",$fechaActual)*1)-1];
	$arrValores["anio"]=date("Y",$fechaActual);
	
	$arrValores["unidad"]=mb_strtoupper($unidadGestion);
	

	$consulta="SELECT nombre,apellidoPaterno,apellidoMaterno FROM _47_tablaDinamica WHERE id__47_tablaDinamica=".$idParticipante;

	$solicitante=$con->obtenerPrimeraFila($consulta);
	
	$consulta="SELECT idCuentaAcceso FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad." AND idParticipante=".$idParticipante;
	$idCuentaAcceso=$con->obtenerValor($consulta);
	
	
	$fDatosServidor=obtenerURLComunicacionServidorMateria("SW");
	
	$url=$fDatosServidor[0].($fDatosServidor[1]!=""?":".$fDatosServidor[1]:"");
	
	$client = new nusoap_client("http://".$url."/webServices/wsInterconexionSistemasBPM.php?wsdl","wsdl");
	
	$parametros=array();
	$parametros["idUsuario"]=$idCuentaAcceso;
	$parametros["palabraClave"]=$llaveFirmado;
	$parametros["reenviarDatosAcceso"]=$reenviarDatosAcceso;
	
	$response = $client->call("obtenerInfoCuentaAcceso", $parametros);
	
	
	$oJuzgado=json_decode($response);
	$usuario="No se pudo obtener Usuario";
	if($oJuzgado->resultado==1)
	{
		$usuario=$oJuzgado->login;
	}
	else
	{
		
		echo '<script>window.parent.msgBox(\''.$oJuzgado->login.'\');</script>';
		return;
	}
	
	
	$arrValores["idUsuario"]=$idCuentaAcceso;
	$arrValores["usuario"]=$usuario;
	$arrValores["password"]="(Enviado por correo electrónico)";
	$arrValores["mail"]=$mail;
	$arrValores["nombreSolicitante"]=$solicitante[0]." ".$solicitante[1]." ".$solicitante[2];
	$arrValores["carpetaAdministrativa"]=$carpetaAdministrativa;
	$arrValores["direccion"]="http://siguepj.poderjudicialcdmx.gob.mx:812/principalPortal/principal.php";
	
	
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