<?php 	error_reporting(E_ALL ^ E_DEPRECATED);

mb_internal_encoding('UTF-8');

include_once("cConexion.php");

	
	//Investigacion 
	//Expendiente grupoLatisMigracion

	$DB_Host_ENV=getenv("DB_Host");
    $DB_User_ENV=getenv("DB_User");
    $DB_Passwd_ENV=getenv("DB_Passwd");
    $DB_DATABASE_ENV=getenv("DB_DATABASE");
    $urlSite_ENV=getenv("urlSite");
	$microsoftGraphClientSecret_ENV=getenv("microsoftGraphClientSecret_ENV_VAR");
	$microsoftGraphClientID_ENV=getenv("microsoftGraphClientID_ENV_VAR");
	$googleClientSecret_ENV=getenv("googleClientSecret_ENV_VAR");
	$googleClientID_ENV=getenv("googleClientID_ENV_VAR");
	$timeSession=getenv("TimeSession");
	
	$con=new cConexion($DB_Host_ENV,$DB_User_ENV,$DB_Passwd_ENV,$DB_DATABASE_ENV,true);//tus datso
	include_once("funcionesComunes.php");
	include_once("funcionesSistema.php");
	include_once("funcionesSistemaAux.php");

	if(!isset($_SESSION["configuracionBitacora"]))
	{
		$_SESSION["configuracionBitacora"]=array();
		$consulta=" SELECT * FROM 00021_tiposRegistroBitacoraAcceso";
		$resBitacora=$con->obtenerFilas($consulta);
		while($fBitacora=mysql_fetch_assoc($resBitacora))
		{
			$_SESSION["configuracionBitacora"][$fBitacora["idRegistroBitacora"]]=$fBitacora["valor"];
		}
	}
	$tipoServidor=1; //Linux, 2 Windows
	//---agenda

	$tiempoSesion=$timeSession;
	$urlSitio=$urlSite_ENV;
	$baseDir=$_SERVER["DOCUMENT_ROOT"]."";
	$urlRepositorioDocumentos=$baseDir;
	$directorioInstalacion=$baseDir;
	$guardarArchivosBD=false;
	$considerarDeprecated=false;
	$SO=$tipoServidor; //1 Linux; 2 Windows
	$desHabilitarImageSize=true;
	$habilitarEnvioCorreo=true;
	$mailAdministrador="comunicado@siugj.co";
	$nombreEmisorAdministrador="MAJO Admon";
	$considerarFichaMedica=false;
	$incluirCabeceraISO=false;
	$codificarUTF8uEJ=false;
	$codificarUTF8uE=false;
	$decodificarUTF8uEJ=false;
	$considerarJustificacionFaltas=false;
	$considerarReporteConducta=false; 
	$considerarAlumnosAsociados=false;
	$externosOrganigrama=false;
	$considerarDisponibilidadSujetosProcesajes=false;
	
	//---------------Programa academico
	$tituloPrograma="Plan de estudios";
	$tituloProgramaPlural="Planes de estudio";
	$tituloDefMateriaSingular="Materia";
	$tituloDefMateriaPlural="Materias";
	$tituloDefGrupoSingular="Grupo";
	$tituloDefGrupoPlural="Grupos";
	$tituloProfesorSingular="Profesor";
	$tituloProfesorPlural="Profesores";
	$tituloParticipanteInvitadoSingular="Profesor invitado";
	$tituloParticipanteInvitadoPlural="Profesores invitado";
	$preguntarNivel=false;
	$preguntarTipoPrograma=true;
	$mostrarEnVistaMateriasTipoCriterioEval=true;
	$calcularGradoMapa=false;
	$mostrarCalEvidencia="false";
	$mostrarTotalSoicitados="false";
	$habilitarAsitencias="true";
	$habilitarFaltas="false";
	$profesorJustificaFalta="true";
	$borrarFaltas="true";
	$calcularAsistencias="false";
	$manejarSedes="true";
	//imagenes
	$imgExtValidas="jpg|gif|png"; //extensiones v�lidas
	
	//log de sistema
	$logInicioSesion=true;
	$logFinSesion=true;
	$logSistemaAccesoPaginas=true;
	$logSistemaModificacionBD=false; //insert,delete,update
	$logSistemaConsultaBD=false; //select
	//Configuracion materia
	$considerarActitudes=true;
	$considerarCompetencias=true;
	$considerarCriteriosE=true;
	$considerarHabilidades=true;
	$considerarTecnicasColaborativas=true;
	$considerarAreaPractica=true;
	$considerarProductos=true;
	//Video
	$videoExtValidas="flv";
	//Archivos
	$maxTamanioArchivos=3; //MB;
	$arrMesLetra[0]="Enero";
	$arrMesLetra[1]="Febrero";
	$arrMesLetra[2]="Marzo";
	$arrMesLetra[3]="Abril";
	$arrMesLetra[4]="Mayo";
	$arrMesLetra[5]="Junio";
	$arrMesLetra[6]="Julio";
	$arrMesLetra[7]="Agosto";
	$arrMesLetra[8]="Septiembre";
	$arrMesLetra[9]="Octubre";
	$arrMesLetra[10]="Noviembre";
	$arrMesLetra[11]="Diciembre";
	$arrDiasSemana[0]="Domingo";
	$arrDiasSemana[1]="Lunes";
	$arrDiasSemana[2]="Martes";
	$arrDiasSemana[3]="Mi�rcoles";
	$arrDiasSemana[4]="Jueves";
	$arrDiasSemana[5]="Viernes";
	$arrDiasSemana[6]="S�bado";
	
	$arrPosicionOrd[1]="Primera";
	$arrPosicionOrd[2]="Segunda";
	$arrPosicionOrd[3]="Tercera";
	$arrPosicionOrd[4]="Cuarta";
	$arrPosicionOrd[5]="Quinta";
	$arrPosicionOrd[6]="Sexta";
	$arrPosicionOrd[7]="S�ptima";
	$arrPosicionOrd[8]="Octava";
	$arrPosicionOrd[9]="Novenda";
	$arrPosicionOrd[10]="D�cima";
	
	$arrPosicionOrd[11]="D�cimo primera";
	$arrPosicionOrd[12]="D�cimo segunda";
	$arrPosicionOrd[13]="D�cimo tercera";
	$arrPosicionOrd[14]="D�cimo cuarta";
	$arrPosicionOrd[15]="Decimo quinta";
	
	$tipoOrganigrama=1; //0 General; 1 Estructura gobierno
	///Configuracion comites
	$lblComiteS="Comisi&oacute;n";
	$lblComiteP="Comisiones";
	
	$tipoCosto=1; //1 Ultimo costo; 2 Promedio
	$nPromedio=2;
	$tipoOG="2"; //estandar 2010;2 estandar 2011
	
	//Nomina
	$considerarAdscripcion=true;
	
	$arrFechasHorario[0]="2011-06-05";
	$arrFechasHorario[1]="2011-06-06";
	$arrFechasHorario[2]="2011-06-07";
	$arrFechasHorario[3]="2011-06-08";
	$arrFechasHorario[4]="2011-06-09";
	$arrFechasHorario[5]="2011-06-10";
	$arrFechasHorario[6]="2011-06-11";
	
	
	$permitirRegistro=true;
	$mostrarBusquedaInstitucion=false;
	$procesoRegistroAsociado=-1;
	
	$consultaInclude="select distinct archivoInclude from 9033_funcionesSistema WHERE archivoInclude<>''";
	$resInclude=$con->obtenerFilas($consultaInclude);
	while($fInclude=mysql_fetch_row($resInclude))
	{
		
		if(file_exists($baseDir."/include/".$fInclude[0]))
		{

			include_once($fInclude[0]);	

		}
	}
	
	$iEstiloMenu=5;
	
	$mostrarOpcionRegresar=false;
	$referenciaFiltros=".";
	if(isset($_SESSION["codigoInstitucion"]))
		$referenciaFiltros=$_SESSION["codigoInstitucion"];
	//$referenciaFiltros=".";
	$paginaInicioLogin="../principalPortal/inicio.php";
	$paginaCierreLogin="../principalPortal/index.php";
	
	
	//Estilo
	
	$consultaEstilo="SELECT estiloLetraFormulario,estiloLetraControles FROM 4081_colorEstilo";
	$fEstilo=$con->obtenerPrimeraFila($consultaEstilo);
	if(!$fEstilo)
	{
		$fEstilo[0]="corpo8_bold";
		$fEstilo[1]="";
	}
	$estiloLetraFormulario=$fEstilo[0];
	$estiloLetraControles=$fEstilo[1];
	
	$visorListadoProcesosProcesos="../modeloProyectos/visorRegistrosProcesosV2.php";
	$visorExpedienteProcesos="../modeloPerfiles/vistaDTDv3.php";
	$pathScriptsPaginasDinamicas="../modulosEspeciales_SGJP/Scripts";
	$comandoLibreOffice='export HOME=/tmp && libreoffice ';
	$urlWebServicesConversionPDF="http://192.168.0.129:9091/Service.asmx";
	$funcionWebServicesConversionPDF="convertirPDFToWORD";
	
	
	$servidorPruebas=true;
		
	
	$leyendaTribunal=utf8_encode('A�o de Leona Vicario, Benem�rita Madre de la Patria');
	$versionLatis="Z3J1cDBsYXRpczE3";
	$Enable_AES_Ecrypt=true;
	
	$arrRutasAlmacenamientoDocumentos[0]=$baseDir."/repositorioDocumentos";
	$arrRutasAlmacenamientoDocumentos[1]=$baseDir."/documentosUsr";
	//$arrRutasAlmacenamientoDocumentos[1]="Z:\\repositorioDocumentos";
	//$arrRutasAlmacenamientoDocumentos[2]="http://172.17.222.30";

	
	$arrRutasAlmacenamientoXMLSolicitudes[0]=$urlRepositorioDocumentos."/repositorioDocumentosXMLSolicitudes";
	
	
	//$tipoFirmaPermitida[1]=false; 	//FIEL;
	$tipoFirmaPermitida[2]=true;	//FIREL
	$tipoFirmaPermitida[4]=true;	//DOcumento escaneado
	$URLServidorFirma="http://192.168.0.129/firmaDocumentos.asmx";
	$nombreFuncionFirma="firmaDocumento";
	$llaveFirmado="1919191919";
	$tipoMateria="SJCOL";
	$respaldarDocumentoPrevioFirma=false;
	
	$arrAudienciasIntermedias["15"]=1;
	$arrAudienciasIntermedias["142"]=1;
	$arrAudienciasIntermedias["223"]=1;
	
	//PGJ
	$pruebasPGJ=false;
	$cancelarNotificacionesPGJ=false;
	$urlPruebas="http://172.22.109.163/wsTribunalSJ.asmx?wsdl";
	$urlProduccion="http://172.22.109.146/wsTribunalSJ.asmx?wsdl";
	
	//Servicio QR
	$utilizarServidorQR=false;
	$urlServidorQR="http://172.19.223.26/service/index.php?wsdl";
	$llaveQR="C1423387-CFC4-460A-BA43-5F7663E19167";
	
	//Contenido Carpeta judicial
	$registrarIDCarpeta=false;
	
	//Sevicio USMECA
	$urlWSSobreseimientoUsmeca="http://10.17.5.29:8080/solicitud-evaluacion/SolicitudSobreseimientoService?WSDL";
	$nombreFuncionSobreseimientoUsmeca="SolicitudSobreseimientoService";

	$urlWSInformeMedidaSCPUsmeca="http://10.17.5.29:8080/solicitud-evaluacion/SolicitudService?WSDL";
	$nombreFuncionInformeMedidaSCPUsmeca="SolicitudImposicionService";
	
	$considerarSecretariasTareas=false;
	$rutaImgenesEscenario="../images";
	
	
	//Big Blue  Button
	$URLServidorBBB="https://api.mynaparrot.com/bigbluebutton/novant";
	$llaveServidorBBB="SFVojfNTgrMzPqrsyvgO";
	$prefijoUsuarioBBB="novant";
	$urlPantallaAccesoReunion=$urlSitio."/principalPortal/startMeeting.php";
	$pathScriptsPaginasDinamicas="../paginasScripts";
	
	
	$funcionEnvioCorreoElectronico="sendMensajeEnvioWebMailServer";
	
	$habilitarLatisScan=true;
	
	
	//OCR
	$comandoOCRMYPDF="export HOME=/tmp && python3.8 /usr/bin/ocrmypdf";
	$comandoPDFTOTXT="export HOME=/tmp && python3.8  /usr/bin/pdf2txt";//"export HOME=/tmp && python3.8  /usr/bin/pdf2txt.py";

	//fuentes
	$extensionesFuentesPermitidas["ttf"]=1;
	
	//Microsft Graph
	$microsoftGraphClientSecret=$microsoftGraphClientSecret_ENV;
	$microsoftGraphClientID=$microsoftGraphClientID_ENV;  //1d520ff3-b3c5-4627-a41f-abaffce47847

	//Google
	$googleClientSecret=$googleClientSecret_ENV;
	$googleClientID=$googleClientID_ENV;
?>