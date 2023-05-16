<?php
	include("conexionBD.php");
	include_once("PHPWord.php");
	include_once("zip.lib.php"); 
	ini_set("memory_limit","8000M");
	set_time_limit(999000);
	
	
	global $con;
	global $baseDir;
	global $arrMesLetra;
	global $tipoMateria;
	
	$nombreArchivo="";
	$arrArchivos=array();
	$arrCopiaOculta=array();
	$arrCopia=array();
	$prueba=false;
	$destinatario="";
	
	$consulta="SELECT idFormulario FROM 900_formularios WHERE categoriaFormulario=6";
	$iFormulario=$con->obtenerValor($consulta);
	$consulta="SELECT email,nombreDestinatario FROM _".$iFormulario."_tablaDinamica c,_".$iFormulario."_gridNotificacion g 
				WHERE g.idReferencia= c.id__".$iFormulario."_tablaDinamica AND c.tipoReporte=2";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		if($destinatario=="")
			$destinatario=$fila[0];
		else
		{
			$d[0]=$fila[0];
			$d[1]=utf8_decode($fila[1]);
			array_push($arrCopia,$d);
		}
	}
	if($prueba)
	{
		$arrCopia=array();
		$destinatario="marco.magana@grupolatis.net";
		
	}
	
	
	$mE=0;
	if(isset($_GET["mE"]))
		$mE=$_GET["mE"];
	
	
	$fechaInicio=null;
	$fechaFin=null;
	
	if(isset($_GET["fechaInicio"]))
		$periodoInicial=$_GET["fechaInicio"];
		
	if(isset($_GET["fechaFin"]))
		$periodoFinal=$_GET["fechaFin"];
	$fecha=date("Y-m-d");
	
	
	$materia="";
	
	switch($tipoMateria)
	{
		case "P":
			$materia="Penal";
		break;
		case "F":
			$materia="Familiar Oral";
		break;
		case "C":
			$materia="Civil Oral";
		break;
		
	}
	try
	{
		
		$idEdificio=0;
		$tipoTarea=9;
		$idRegistroTarea=registrarBitacoraEjecucionActividadTemporal($tipoTarea);
	

		$nFila=4;
		if($tipoMateria=="P")
		{
			$libro=new cExcel("../modulosEspeciales_SGJP/formatos/formatoReporteAudienciasPenal.xlsx",true,"Excel2007");	
			
		}
		else
		{
			$libro=new cExcel("../modulosEspeciales_SGJP/formatos/formatoReporteAudiencias.xlsx",true,"Excel2007");	
		}
		
		
		
		$libro->setValor("B1",date("d",strtotime($periodoInicial))." de ".($arrMesLetra[(date("m",strtotime($periodoInicial))*1)-1])." de ".date("Y",strtotime($periodoInicial)));
						//" al ".date("d",strtotime($periodoFinal))." de ".($arrMesLetra[(date("m",strtotime($periodoFinal))*1)-1])." de ".date("Y",strtotime($periodoFinal)));	
			
		$uG='0';	
		$idEdificio=0;
		$consulta="SELECT idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,(SELECT descripcionSituacion FROM 7011_situacionEventosAudiencia WHERE idSituacion=e.situacion) as situacion,
					(SELECT nombreInmueble FROM _1_tablaDinamica WHERE id__1_tablaDinamica=e.idEdificio) as edificio,
					(SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=e.idCentroGestion) as centroGestion,
					(SELECT nombreSala FROM _15_tablaDinamica WHERE id__15_tablaDinamica=e.idSala) as sala,
					(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=e.tipoAudiencia) as tipoAudiencia,idFormulario,idRegistroSolicitud,
					horaInicioReal,horaTerminoReal,urlMultimedia
					FROM 7000_eventosAudiencia e where fechaEvento>='".$periodoInicial."' and fechaEvento<='".$periodoFinal."' 
					and horaInicioEvento is not null and horaFinEvento is not null ";		
		$lblFechaAudiencia=convertirFechaLetra($periodoInicial,false,false);	
		if($uG!=0)		
		{
			$query="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$uG."'";
			$iUnidad=$con->obtenerValor($query);
			$consulta.=" and idCentroGestion=".$iUnidad;
		}
		else
		{
			$query="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE cmbCategoria=1";
			$iUnidad=$con->obtenerListaValores($query);
			$consulta.=" and idCentroGestion in(".$iUnidad.")";
		}
		
		if($idEdificio!=0)
		{
			$consulta.=" and idEdificio=".$idEdificio;
		}
		
		
		
		
		$numReg=0;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
		
			$query="SELECT GROUP_CONCAT(CONCAT('(',noJuez,') ',u.nombre, ' [',e.titulo,']') SEPARATOR '<br>') FROM 800_usuarios u,
						7001_eventoAudienciaJuez e WHERE u.idUsuario=e.idJuez AND e.idRegistroEvento=".$fila[0];
		
			$jueces=$con->obtenerValor($query);
			
			
			
			$carpeta="";
			$tipoAudiencia=$fila[8];
			$tAudiencia="";
			$carpetaInvestigacion="";
			$consulta="SELECT c.carpetaAdministrativa,(SELECT nombreTipoCarpeta FROM 7020_tipoCarpetaAdministrativa WHERE idTipoCarpeta=c.tipoCarpetaAdministrativa)  as tCarpeta
					FROM 7007_contenidosCarpetaAdministrativa con,7006_carpetasAdministrativas c 
					WHERE tipoContenido=3 and idRegistroContenidoReferencia=".$fila[0]." and c.carpetaAdministrativa=con.carpetaAdministrativa";
			if($registrarIDCarpeta)
			{
				$consulta="SELECT c.carpetaAdministrativa,(SELECT nombreTipoCarpeta FROM 7020_tipoCarpetaAdministrativa WHERE idTipoCarpeta=c.tipoCarpetaAdministrativa)  as tCarpeta
					FROM 7007_contenidosCarpetaAdministrativa con,7006_carpetasAdministrativas c 
					WHERE tipoContenido=3 and idRegistroContenidoReferencia=".$fila[0]." and c.idCarpeta=con.idCarpetaAdministrativa";
			}
			$fDatos=$con->obtenerPrimeraFila($consulta);
			
			$horaProgramada="De las ".date("H:i",strtotime($fila[2]))." hrs. a las ".date("H:i",strtotime($fila[3]))." Hrs";
			$horaRealizacion="";
			if($fila[11]!="")
				$horaRealizacion="De las ".date("H:i",strtotime($fila[11]))." hrs. a las ".date("H:i",strtotime($fila[12]))." Hrs";
			$libro->setValor("A".$nFila,$fila[0]);
			$libro->setValor("B".$nFila,$fDatos[0]);
			$libro->setValor("C".$nFila,$fDatos[1]);
			$libro->setValor("D".$nFila,$fila[1]);
			$libro->setValor("E".$nFila,$fila[4]);
			$libro->setValor("F".$nFila,$horaProgramada);
			$libro->setValor("G".$nFila,$horaRealizacion);
			$libro->setValor("H".$nFila,$fila[8]);
			$libro->setValor("I".$nFila,$fila[5]);
			$libro->setValor("J".$nFila,$fila[7]);
			$libro->setValor("K".$nFila,$jueces);
			$libro->setValor("L".$nFila,$fila[6]);
			$libro->setValor("M".$nFila,$fila[13]==""?"No":"Sí");
			$libro->setValor("N".$nFila,$fila[13]);
			
			
			if($tipoMateria=="P")
			{
				$arrRecursosAdicionalesRequeridos="";
				$consulta="SELECT * FROM 7001_recursosAdicionalesAudiencia WHERE idRegistroEvento=".$fila[0]." and tipoRecurso=1 and
				situacionRecurso in (SELECT idSituacion FROM 7011_situacionEventosAudiencia WHERE considerarDiponibilidad=1)	";
				
				$resRecursos=$con->obtenerFilas($consulta);
				while($filaRecurso=mysql_fetch_assoc($resRecursos))
				{
					
					$consulta="SELECT nombreRecurso FROM _628_tablaDinamica WHERE id__628_tablaDinamica=".$filaRecurso["idRecurso"];
					$nombreRecurso=$con->obtenerValor($consulta);
					if($arrRecursosAdicionalesRequeridos=="")
						$arrRecursosAdicionalesRequeridos=$nombreRecurso;
					else
						$arrRecursosAdicionalesRequeridos.="\n".$nombreRecurso;
				}
				
				$libro->setValor("O".$nFila,$arrRecursosAdicionalesRequeridos!=""?"Sí":"No");
				$libro->setValor("P".$nFila,$arrRecursosAdicionalesRequeridos);
			}
		
			$nFila++;
			
			
		}
		
		
		$nombreArchivo="informeAudiencias_".str_replace(" ","_",$materia)."_".str_replace("-","_",$periodoInicial).".xlsx";

		$libro->generarArchivoServidor("Excel2007",$nombreArchivo);
		
		$arrArchivos[0][0]=$nombreArchivo;
		$arrArchivos[0][1]=$nombreArchivo;
		$cuerpo="Adjunto al presente, se env&iacute;a la agenda de audiencias registradas en la materia ".$materia." del d&iacute;a  ".$lblFechaAudiencia;



		if(enviarMailGMail($destinatario,"TSJCDMX Audiencias programadas ".$materia." ".$lblFechaAudiencia,$cuerpo,$arrArchivos,$arrCopia,$arrCopiaOculta))
		{
			unlink($nombreArchivo);
			actualizarRegistroBitacoraEjecucionActividadTemporal($idRegistroTarea,1,"");
			if($mE==1)
			{
				echo "<body><script>window.parent.cerrarVentanaFancy();</script></body>";
			}
		}
		else
		{
			unlink($nombreArchivo);
			
		}
		
		
	}
	catch(Exception $e)
	{
		if(file_exists($nombreArchivo))
		{
			
			unlink($nombreArchivo);
		}
		actualizarRegistroBitacoraEjecucionActividadTemporal($idRegistroTarea,2,$e->getMessage());
	
	}
		
	
	
	
	
?>	