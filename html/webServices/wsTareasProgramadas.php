<?php session_start();
	ini_set("memory_limit","8000M");
	set_time_limit(9990000);
	ini_set('default_socket_timeout', 160000);
	ini_set('post_max_size', '1024M');
	ini_set('upload_max_filesize', '1024M');
	include("conexionBD.php");
	include_once("nusoap/nusoap.php");
	include_once("latisErrorHandler.php");
	include_once("PHPWord.php");
	include_once("zip.lib.php"); 
	
	function revisionTareasTrabajo($fechaInicio,$fechaFin,$revisionTotal=0)
	{
		global $con;		
		
		$tipoTarea=2;
		$idRegistroTarea=registrarBitacoraEjecucionActividadTemporal($tipoTarea);
		try
		{
			$_SESSION["idUsr"]=3789;
			$_SESSION["deshabilitarNotificaciones"]=false;
			$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$_SESSION["idUsr"];
			$resRoles=$con->obtenerFilas($consulta);
			$listaGrupo="";
			while($fRoles=mysql_fetch_row($resRoles))
			{
				$arrRol=explode("_",$fRoles[0]);
				$rol="'".$fRoles[0]."'";
				if($arrRol[1]!="0")
					$rol.=",'".$arrRol[0]."_-1'";
				
				if($listaGrupo=="")
					$listaGrupo=$rol;
				else
					$listaGrupo.=",".$rol;
			}
			if($listaGrupo=="")
				$listaGrupo='-1';
			$_SESSION["idRol"]=$listaGrupo.",'-100_0'";
			$_SESSION["codigoUnidad"]="001";
			$_SESSION["codigoInstitucion"]="001";	
			
			$fechaReferencia=date("Y-m-d",strtotime("-1 days",strtotime(date("Y-m-d"))));
			
			$consulta="SELECT * FROM _46_tablaDinamica WHERE idEstado>1.4 AND fechaCreacion>='".$fechaReferencia." 00:01'
						AND (id__46_tablaDinamica NOT 
						IN(
						SELECT iRegistro FROM 9060_tableroControl_4 WHERE iFormulario=46 AND fechaRegistroSistema>='".$fechaReferencia." 00:01'
						) or notificacionCorreo=0)
						
						
						
						";
			
			if($fechaInicio!=null)
			{
				$consulta="SELECT * FROM _46_tablaDinamica WHERE idEstado>1.4 AND fechaCreacion>='".$fechaInicio." 00:01'
						AND fechaCreacion<='".$fechaFin." 23:59:59' and (id__46_tablaDinamica NOT 
						IN(
						SELECT iRegistro FROM 9060_tableroControl_4 WHERE iFormulario=46 AND fechaRegistroSistema>='".$fechaInicio." 00:01'
						 AND fechaRegistroSistema<='".$fechaFin." 23:59:59') or notificacionCorreo=0)";
			}
			
			$resIniciales=$con->obtenerFilas($consulta);	
			
			$consulta="SELECT * FROM _96_tablaDinamica WHERE idEstado>1.4 AND fechaHoraRecepcionPromocion>='".$fechaReferencia." 00:01'
						AND (id__96_tablaDinamica NOT 
						IN(SELECT iRegistro FROM 9060_tableroControl_4 WHERE iFormulario=96 AND fechaRegistroSistema>='".$fechaReferencia." 00:01') or 
						notificacionCorreo=0)";
			if($fechaInicio!=null)
			{
				$consulta="SELECT * FROM _96_tablaDinamica WHERE idEstado>1.4 AND fechaHoraRecepcionPromocion>='".$fechaInicio." 00:01'
						AND fechaHoraRecepcionPromocion<='".$fechaFin." 23:59:59' and (id__96_tablaDinamica NOT 
						IN(SELECT iRegistro FROM 9060_tableroControl_4 WHERE iFormulario=96 AND fechaRegistroSistema>='".$fechaInicio.
						" 00:01' and fechaRegistroSistema<='".$fechaFin." 23:59:59') or 
						notificacionCorreo=0)";
			}
			
			$resPromociones=$con->obtenerFilas($consulta);	
			
			$consulta="SELECT * FROM _92_tablaDinamica WHERE idEstado>1.4 AND fechaCreacion>='".$fechaReferencia." 00:01'
						AND (id__92_tablaDinamica NOT 
						IN(SELECT iRegistro FROM 9060_tableroControl_4 WHERE iFormulario=92 AND fechaRegistroSistema>='".$fechaReferencia." 00:01'))";
			if($fechaInicio!=null)
			{
				$consulta="SELECT * FROM _92_tablaDinamica WHERE idEstado>1.4 AND fechaCreacion>='".$fechaInicio." 00:01'
						AND fechaCreacion<='".$fechaFin." 23:59:59' and (id__92_tablaDinamica NOT 
						IN(SELECT iRegistro FROM 9060_tableroControl_4 WHERE iFormulario=92 AND fechaRegistroSistema>='".$fechaInicio.
						" 00:01' and fechaRegistroSistema<='".$fechaFin." 23:59:59') )";
			}
			$resExhortos=$con->obtenerFilas($consulta);	
			
			
			$consulta="SELECT * FROM _622_tablaDinamica WHERE idEstado>=2 AND fechaCreacion>='".$fechaReferencia." 00:01'
					AND (id__622_tablaDinamica NOT 
					IN(
					SELECT iRegistro FROM 9060_tableroControl_4 WHERE iFormulario=622 AND fechaRegistroSistema>='".$fechaReferencia." 00:01'
					) or notificacionCorreo=0)
					
					
					
					";
		
			if($fechaInicio!=null)
			{
				$consulta="SELECT * FROM _622_tablaDinamica WHERE idEstado>=2 AND fechaCreacion>='".$fechaInicio." 00:01'
						AND fechaCreacion<='".$fechaFin." 23:59:59' and (id__622_tablaDinamica NOT 
						IN(
						SELECT iRegistro FROM 9060_tableroControl_4 WHERE iFormulario=622 AND fechaRegistroSistema>='".$fechaInicio." 00:01'
						 AND fechaRegistroSistema<='".$fechaFin." 23:59:59') or notificacionCorreo=0)";
			}
			
			$resLAVLV=$con->obtenerFilas($consulta);
			
			$consulta="SELECT idFormulario,idRegistroSolicitud,idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaAsignacion>='".$fechaReferencia.
					" 00:01' AND notificadoPGJ IN (0,2) AND situacion=1";
		
			if($fechaInicio!=null)
			{
				$consulta="SELECT idFormulario,idRegistroSolicitud,idRegistroEvento FROM 7000_eventosAudiencia WHERE fechaAsignacion>='".$fechaInicio." 00:01' 
						AND fechaAsignacion<='".$fechaFin." 23:59:59'  and notificadoPGJ IN (0,2) AND situacion=1";
				
			}
			
			$resEventoNotificadoPGJ=$con->obtenerFilas($consulta);
			
			while($fila=mysql_fetch_assoc($resIniciales))
			{
				$consulta="INSERT INTO 9076_registrosAsociados(idTarea,iFormulario,iRegistro,situacion,tipoTarea) 
						VALUES(".$idRegistroTarea.",46,".$fila["id__46_tablaDinamica"].",0,".$tipoTarea.")";
				$con->ejecutarConsulta($consulta);
				
			}
			while($fila=mysql_fetch_assoc($resPromociones))
			{
		
				$consulta="INSERT INTO 9076_registrosAsociados(idTarea,iFormulario,iRegistro,situacion,tipoTarea) 
						VALUES(".$idRegistroTarea.",96,".$fila["id__96_tablaDinamica"].",0,".$tipoTarea.")";
				$con->ejecutarConsulta($consulta);
			}	
			
			while($fila=mysql_fetch_assoc($resExhortos))
			{
		
				$consulta="INSERT INTO 9076_registrosAsociados(idTarea,iFormulario,iRegistro,situacion,tipoTarea) 
						VALUES(".$idRegistroTarea.",92,".$fila["id__92_tablaDinamica"].",0,".$tipoTarea.")";
				$con->ejecutarConsulta($consulta);
			}
			
			while($fila=mysql_fetch_assoc($resLAVLV))
			{
		
				$consulta="INSERT INTO 9076_registrosAsociados(idTarea,iFormulario,iRegistro,situacion,tipoTarea) 
						VALUES(".$idRegistroTarea.",622,".$fila["id__622_tablaDinamica"].",0,".$tipoTarea.")";
				$con->ejecutarConsulta($consulta);
			}	
			
			while($fila=mysql_fetch_assoc($resEventoNotificadoPGJ))
			{
		
				$consulta="INSERT INTO 9076_registrosAsociados(idTarea,iFormulario,iRegistro,situacion,tipoTarea) 
						VALUES(".$idRegistroTarea.",7000,".$fila["idRegistroEvento"].",0,".$tipoTarea.")";
				$con->ejecutarConsulta($consulta);
			}	
			
			if(mysql_num_rows($resIniciales)>0)
				mysql_data_seek($resIniciales,0);
				
			if(mysql_num_rows($resPromociones)>0)
				mysql_data_seek($resPromociones,0);
				
			if(mysql_num_rows($resExhortos)>0)
				mysql_data_seek($resExhortos,0);

			if(mysql_num_rows($resLAVLV)>0)
				mysql_data_seek($resLAVLV,0);
			
			if(mysql_num_rows($resEventoNotificadoPGJ)>0)
				mysql_data_seek($resEventoNotificadoPGJ,0);
							
			while($fila=mysql_fetch_assoc($resIniciales))
			{
				cambiarEtapaFormulario(46,$fila["id__46_tablaDinamica"],$fila["idEstado"],"",-1,"NULL","NULL",1022);
				$consulta="UPDATE 9076_registrosAsociados SET situacion=1 WHERE iFormulario=46 AND iRegistro=".$fila["id__46_tablaDinamica"].
						" AND tipoTarea=".$tipoTarea;
				
				$con->ejecutarConsulta($consulta);			
			}
				
			
			while($fila=mysql_fetch_assoc($resPromociones))
			{
				cambiarEtapaFormulario(96,$fila["id__96_tablaDinamica"],$fila["idEstado"],"",-1,"NULL","NULL",613);
				$consulta="UPDATE 9076_registrosAsociados SET situacion=1 WHERE iFormulario=96 AND iRegistro=".$fila["id__96_tablaDinamica"].
						" AND tipoTarea=".$tipoTarea;
				$con->ejecutarConsulta($consulta);	
			}	
			
			while($fila=mysql_fetch_assoc($resExhortos))
			{
				cambiarEtapaFormulario(92,$fila["id__92_tablaDinamica"],$fila["idEstado"],"",-1,"NULL","NULL",717);
				$consulta="UPDATE 9076_registrosAsociados SET situacion=1 WHERE iFormulario=92 AND iRegistro=".$fila["id__92_tablaDinamica"].
						" AND tipoTarea=".$tipoTarea;
				$con->ejecutarConsulta($consulta);	
			}	
			
			
			while($fila=mysql_fetch_assoc($resLAVLV))
			{
				cambiarEtapaFormulario(622,$fila["id__622_tablaDinamica"],$fila["idEstado"],"",-1,"NULL","NULL",1153);
				$consulta="UPDATE 9076_registrosAsociados SET situacion=1 WHERE iFormulario=622 AND iRegistro=".$fila["id__622_tablaDinamica"].
						" AND tipoTarea=".$tipoTarea;
				$con->ejecutarConsulta($consulta);	
			}
			
			while($fila=mysql_fetch_assoc($resEventoNotificadoPGJ))
			{
				if(reportarAudienciaPGJ($fila["idFormulario"],$fila["idRegistroSolicitud"]))
				{
					$consulta="UPDATE 9076_registrosAsociados SET situacion=1 WHERE iFormulario=7000 AND iRegistro=".$fila["idRegistroEvento"].
							" AND tipoTarea=".$tipoTarea;
					$con->ejecutarConsulta($consulta);	
				}
			}
			
					
			actualizarRegistroBitacoraEjecucionActividadTemporal($idRegistroTarea,1,"");
			
			return "OK";
			
		}
		catch(Exception $e)
		{
			
			actualizarRegistroBitacoraEjecucionActividadTemporal($idRegistroTarea,2,$e->getMessage());
			return $e->getMessage();
			
		}
		
		
	}
	
	function revisionSolicitudesInicialesNOUrgentes()
	{
		global $con;
		$fechaActual=date("Y-m-d H:i:s");
		$tipoTarea=3;
		
		$idRegistroTarea=registrarBitacoraEjecucionActividadTemporal($tipoTarea);
		try
		{
			$_SESSION["idUsr"]=3789;
			$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$_SESSION["idUsr"];
			$resRoles=$con->obtenerFilas($consulta);
			$listaGrupo="";
			while($fRoles=mysql_fetch_row($resRoles))
			{
				$arrRol=explode("_",$fRoles[0]);
				$rol="'".$fRoles[0]."'";
				if($arrRol[1]!="0")
					$rol.=",'".$arrRol[0]."_-1'";
				
				if($listaGrupo=="")
					$listaGrupo=$rol;
				else
					$listaGrupo.=",".$rol;
			}
			if($listaGrupo=="")
				$listaGrupo='-1';
			$_SESSION["idRol"]=$listaGrupo.",'-100_0'";
			$_SESSION["codigoUnidad"]="001";
			$_SESSION["codigoInstitucion"]="001";	
			if(esHorarioNormalDiaHabil($fechaActual))
			{
				$consulta="SELECT * FROM _46_tablaDinamica WHERE idEstado=1.4 AND ctrlSolicitud IS NOT NULL AND ctrlSolicitud<>'' AND tipoAudiencia
							IN(
							SELECT id__4_tablaDinamica FROM _4_tablaDinamica WHERE tipoAtencion=1
							) and fechaCreacion<='".$fechaActual."'";
				
				$resIniciales=$con->obtenerFilas($consulta);	
				
				while($fila=mysql_fetch_assoc($resIniciales))
				{
					$consulta="INSERT INTO 9076_registrosAsociados(idTarea,iFormulario,iRegistro,situacion,tipoTarea) 
							VALUES(".$idRegistroTarea.",46,".$fila["id__46_tablaDinamica"].",0,".$tipoTarea.")";
					$con->ejecutarConsulta($consulta);
					
				}
				
				if(mysql_num_rows($resIniciales)>0)
					mysql_data_seek($resIniciales,0);
					
				
				while($fila=mysql_fetch_assoc($resIniciales))
				{
					cambiarEtapaFormulario(46,$fila["id__46_tablaDinamica"],2.7,"",-1,"NULL","NULL",1022);
					$consulta="UPDATE 9076_registrosAsociados SET situacion=1 WHERE iFormulario=46 AND iRegistro=".$fila["id__46_tablaDinamica"].
						" AND tipoTarea=".$tipoTarea;
				
					$con->ejecutarConsulta($consulta);	
				}
			}
			actualizarRegistroBitacoraEjecucionActividadTemporal($idRegistroTarea,1,"");
			return "OK";
			
		}
		catch(Exception $e)
		{
			actualizarRegistroBitacoraEjecucionActividadTemporal($idRegistroTarea,2,$e->getMessage());
			return $e->getMessage();
			
		}
	}
	
	function generarInformeAudienciasDelDia()
	{
		ini_set("memory_limit","8000M");
		set_time_limit(999000);
		global $con;
		global $baseDir;
		
		$nomArchivo="";
		$nomArchivoFinal="";
		$arrArchivos=array();
		$arrCopiaOculta=array();
		$arrCopia=array();
		$prueba=false;
		$destinatario="";
		
		$consulta="SELECT idFormulario FROM 900_formularios WHERE categoriaFormulario=6";
		$iFormulario=$con->obtenerValor($consulta);
		$consulta="SELECT email,nombreDestinatario FROM _".$iFormulario."_tablaDinamica c,_".$iFormulario."_gridNotificacion g 
					WHERE g.idReferencia= c.id__".$iFormulario."_tablaDinamica AND c.tipoReporte=1";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			if($destinatario=="")
				$destinatario=$fila[0];
			else
			{
				$d[0]=$fila[0];
				$d[1]=utf8_decode($fila[1]);
				array_push($arrCopiaOculta,$d);
			}
		}
		
		
		if($prueba)
		{
			$arrCopiaOculta=array();
			$destinatario="marco.magana@grupolatis.net";
			
		}
		
		
		
		$fechaInicio=null;
		$fechaFin=null;
		
		
		$fecha=date("Y-m-d");
		
		$tipoTarea=8;
		
	
		$tipoTareaRealizacion="[Programado M]";
		
		
		if((strtotime(date("Y-m-d H:i"))>=strtotime("08:25")) &&(strtotime(date("Y-m-d H:i"))<strtotime("16:00")))
			$tipoTareaRealizacion="[Programado 830]";
		
		if(strtotime(date("Y-m-d H:i"))>strtotime("16:00"))
			$tipoTareaRealizacion="[Programado T]";
		
		
		$consulta="SELECT COUNT(*) FROM 9075_bitacoraEjecucionActividadTemporal WHERE fechaInicioEjecucion>='".$fecha."' 
					AND fechaInicioEjecucion<='".$fecha." 23:59:59' AND tipoActividad=8 AND resultado=1 and comentariosAdicionales='".$tipoTareaRealizacion."'";
		$nReg=$con->obtenerValor($consulta);
		
		if($nReg>0)	
		{
			return "OK";
		}
		
		$idRegistroTarea=registrarBitacoraEjecucionActividadTemporal($tipoTarea);
		
		try
		{
			$PHPWord = new PHPWord();
			$document = $PHPWord->loadTemplate($baseDir.'\\modulosEspeciales_SGJP\\formatos\\plantillaAudienciasDiarias.docx');	
			$arrUgas[15]["leyenda"]="UNIDAD UNO";
			$arrUgas[15]["leyendaResumen"]="UGJ-01";
			$arrUgas[16]["leyenda"]="UNIDAD DOS";
			$arrUgas[16]["leyendaResumen"]="UGJ-02";
			$arrUgas[17]["leyenda"]="UNIDAD TRES";
			$arrUgas[17]["leyendaResumen"]="UGJ-03";
			$arrUgas[25]["leyenda"]="UNIDAD CUATRO";
			$arrUgas[25]["leyendaResumen"]="UGJ-04";
			$arrUgas[32]["leyenda"]="UNIDAD CINCO";
			$arrUgas[32]["leyendaResumen"]="UGJ-05";
			$arrUgas[33]["leyenda"]="UNIDAD SEIS";
			$arrUgas[33]["leyendaResumen"]="UGJ-06";
			$arrUgas[34]["leyenda"]="UNIDAD SIETE";
			$arrUgas[34]["leyendaResumen"]="UGJ-07";
			$arrUgas[35]["leyenda"]="UNIDAD OCHO";
			$arrUgas[35]["leyendaResumen"]="UGJ-08";
			$arrUgas[48]["leyenda"]="UNIDAD NUEVE";
			$arrUgas[48]["leyendaResumen"]="UGJ-09";
			$arrUgas[47]["leyenda"]="UNIDAD DIEZ";
			$arrUgas[47]["leyendaResumen"]="UGJ-10";
			$arrUgas[46]["leyenda"]="UNIDAD ONCE";
			$arrUgas[46]["leyendaResumen"]="UGJ-11";
			$arrUgas[50]["leyenda"]="UNIDAD DOCE\rÓrdenes de Aprehensión y Cateos";
			$arrUgas[50]["leyendaResumen"]="UGJ-12";
			$arrUgas[49]["leyenda"]="UNIDAD DE ADOLESCENTES";
			$arrUgas[49]["leyendaResumen"]="UGJ-ASOL";
			$arrUgas[36]["leyenda"]="UNIDAD ESPECIALIZADA EN EJECUCIÓN Y SANCIONES PENALES (SULLIVAN)";
			$arrUgas[36]["leyendaResumen"]="EJEC-SUL";
			$arrUgas[51]["leyenda"]="UNIDAD ESPECIALIZADA EN EJECUCIÓN Y SANCIONES PENALES (NORTE)";
			$arrUgas[51]["leyendaResumen"]="EJEC-NTE";
			$arrUgas[53]["leyenda"]="UNIDAD ESPECIALIZADA EN EJECUCIÓN Y SANCIONES PENALES (ORIENTE)";
			$arrUgas[53]["leyendaResumen"]="EJEC-OTE";
			$arrUgas[52]["leyenda"]="UNIDAD DE GESTIÓN JUDICIAL EN MATERIA DE EJECUCIÓN EN MEDIDAS SANCIONADORAS";
			$arrUgas[52]["leyendaResumen"]="UGJEMS";
			
			
			$consulta="SELECT idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,
					(SELECT nombreInmueble FROM _1_tablaDinamica WHERE id__1_tablaDinamica=e.idEdificio) as edificio,
					(SELECT nombreSala FROM _15_tablaDinamica WHERE id__15_tablaDinamica=e.idSala) as sala,
					(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=e.tipoAudiencia) as tipoAudiencia,
					u.nombreUnidad,u.claveUnidad,id__17_tablaDinamica
					FROM 7000_eventosAudiencia e,_17_tablaDinamica u where e.fechaEvento='".$fecha."' and e.situacion in(0,1,2,4,5)
					and u.id__17_tablaDinamica=e.idCentroGestion order by u.prioridad,e.horaInicioEvento";
			$rAudiencias=$con->obtenerFilas($consulta);
			$totalAudiencias=$con->filasAfectadas;
			$lblFechaAudiencia=convertirFechaLetra($fecha,false,false);
			$fechaAudiencias=date("d/m/Y",strtotime($fecha));
			$arrParam["lblFechaAudiencia"]=mb_strtoupper($lblFechaAudiencia);
			$arrParam["fechaAudiencias"]=$fechaAudiencias;
			$arrParam["totalAudiencias"]=$totalAudiencias;
			
			$inicioTabla='<w:tbl>
							<w:tblPr>
								<w:tblStyle w:val="TableNormal"/>
								<w:tblW w:w="0" w:type="auto"/>
								<w:tblInd w:w="108" w:type="dxa"/>
								<w:tblBorders>
									<w:top w:val="single" w:space="0" w:color="000000" w:sz="4"/>
									<w:left w:val="single" w:space="0" w:color="000000" w:sz="4"/>
									<w:bottom w:val="single" w:space="0" w:color="000000" w:sz="4"/>
									<w:right w:val="single" w:space="0" w:color="000000" w:sz="4"/>
									<w:insideH w:val="single" w:space="0" w:color="000000" w:sz="4"/>
									<w:insideV w:val="single" w:space="0" w:color="000000" w:sz="4"/>
								</w:tblBorders>
								<w:tblLayout w:type="fixed"/>
								<w:tblLook w:val="01E0" w:noVBand="0" w:noHBand="0" w:lastColumn="1" w:firstColumn="1" w:lastRow="1" w:firstRow="1"/>
							</w:tblPr>
							<w:tblGrid>
								<w:gridCol w:w="2640"/>
								<w:gridCol w:w="480"/>
								<w:gridCol w:w="1694"/>
								<w:gridCol w:w="994"/>
								<w:gridCol w:w="1790"/>
								<w:gridCol w:w="1212"/>
								<w:gridCol w:w="858"/>
								<w:gridCol w:w="2356"/>
								<w:gridCol w:w="1154"/>
								<w:gridCol w:w="2410"/>
								<w:gridCol w:w="2635"/>
								<w:gridCol w:w="1509"/>
							</w:tblGrid>';
			$encabezado='<w:tr w:rsidR="00D64538" w:rsidTr="007E5632">
							<w:trPr>
								<w:trHeight w:val="631"/>
							</w:trPr>
							<w:tc>
								<w:tcPr>
									<w:tcW w:w="19732" w:type="dxa"/>
									<w:gridSpan w:val="12"/>
									<w:shd w:val="clear" w:color="auto" w:fill="FF0000"/>
								</w:tcPr>
								<w:p w:rsidRDefault="00D64538" w:rsidR="00D64538" w:rsidP="004437BC">
									<w:pPr>
										<w:pStyle w:val="TableParagraph"/>
										<w:spacing w:before="29"/>
										<w:ind w:left="6497"/>
										<w:rPr>
											<w:sz w:val="44"/>
										</w:rPr>
									</w:pPr>
									<w:r>
										<w:rPr>
											<w:color w:val="FFFFFF"/>
											<w:sz w:val="44"/>
										</w:rPr>
										<w:t xml:space="preserve">TOTAL </w:t>
									</w:r>
									<w:r w:rsidR="004437BC" w:rsidRPr="004437BC">
										<w:rPr>
											<w:b/>
											<w:color w:val="FFFFFF"/>
											<w:sz w:val="48"/>
										</w:rPr>
										<w:t>'.$totalAudiencias.'</w:t>
									</w:r>
									<w:r>
										<w:rPr>
											<w:b/>
											<w:color w:val="FFFFFF"/>
											<w:sz w:val="48"/>
										</w:rPr>
										<w:t xml:space="preserve"> </w:t>
									</w:r>
									<w:r>
										<w:rPr>
											<w:color w:val="FFFFFF"/>
											<w:sz w:val="44"/>
										</w:rPr>
										<w:t xml:space="preserve">AUDIENCIAS - </w:t>
									</w:r>
									<w:r w:rsidR="004437BC">
										<w:rPr>
											<w:color w:val="FFFFFF"/>
											<w:sz w:val="44"/>
										</w:rPr>
										<w:t>'.$fechaAudiencias.'</w:t>
									</w:r>
								</w:p>
							</w:tc>
						</w:tr>';
			
			$ugaActual="";
			
			$encabezado2='<w:tr w:rsidR="00D64538" w:rsidTr="007E5632">
							<w:trPr>
								<w:trHeight w:val="438"/>
							</w:trPr>
							<w:tc>
								<w:tcPr>
									<w:tcW w:w="2640" w:type="dxa"/>
									<w:shd w:val="clear" w:color="auto" w:fill="538235"/>
								</w:tcPr>
								<w:p w:rsidRDefault="00D64538" w:rsidR="00D64538" w:rsidP="00D24AF0">
									<w:pPr>
										<w:pStyle w:val="TableParagraph"/>
										<w:spacing w:before="111"/>
										<w:ind w:left="414" w:right="407"/>
										<w:jc w:val="center"/>
										<w:rPr>
											<w:b/>
											<w:sz w:val="18"/>
										</w:rPr>
									</w:pPr>
									<w:r>
										<w:rPr>
											<w:b/>
											<w:color w:val="FFFFFF"/>
											<w:w w:val="95"/>
											<w:sz w:val="18"/>
										</w:rPr>
										<w:t>UNIDAD DE GESTION</w:t>
									</w:r>
								</w:p>
							</w:tc>
							<w:tc>
								<w:tcPr>
									<w:tcW w:w="480" w:type="dxa"/>
									<w:shd w:val="clear" w:color="auto" w:fill="538235"/>
								</w:tcPr>
								<w:p w:rsidRDefault="00D64538" w:rsidR="00D64538" w:rsidP="00D24AF0">
									<w:pPr>
										<w:pStyle w:val="TableParagraph"/>
										<w:spacing w:before="111"/>
										<w:ind w:left="73" w:right="67"/>
										<w:jc w:val="center"/>
										<w:rPr>
											<w:b/>
											<w:sz w:val="18"/>
										</w:rPr>
									</w:pPr>
									<w:r>
										<w:rPr>
											<w:b/>
											<w:color w:val="FFFFFF"/>
											<w:sz w:val="18"/>
										</w:rPr>
										<w:t>No.</w:t>
									</w:r>
								</w:p>
							</w:tc>
							<w:tc>
								<w:tcPr>
									<w:tcW w:w="1694" w:type="dxa"/>
									<w:shd w:val="clear" w:color="auto" w:fill="538235"/>
								</w:tcPr>
								<w:p w:rsidRDefault="00D64538" w:rsidR="00D64538" w:rsidP="00D24AF0">
									<w:pPr>
										<w:pStyle w:val="TableParagraph"/>
										<w:spacing w:before="111"/>
										<w:ind w:left="226" w:right="215"/>
										<w:jc w:val="center"/>
										<w:rPr>
											<w:b/>
											<w:sz w:val="18"/>
										</w:rPr>
									</w:pPr>
									<w:r>
										<w:rPr>
											<w:b/>
											<w:color w:val="FFFFFF"/>
											<w:w w:val="90"/>
											<w:sz w:val="18"/>
										</w:rPr>
										<w:t>CARPETA</w:t>
									</w:r>
								</w:p>
							</w:tc>
							<w:tc>
								<w:tcPr>
									<w:tcW w:w="994" w:type="dxa"/>
									<w:shd w:val="clear" w:color="auto" w:fill="538235"/>
								</w:tcPr>
								<w:p w:rsidRDefault="00D64538" w:rsidR="00D64538" w:rsidP="00D24AF0">
									<w:pPr>
										<w:pStyle w:val="TableParagraph"/>
										<w:spacing w:before="111"/>
										<w:ind w:left="274"/>
										<w:rPr>
											<w:b/>
											<w:sz w:val="18"/>
										</w:rPr>
									</w:pPr>
									<w:r>
										<w:rPr>
											<w:b/>
											<w:color w:val="FFFFFF"/>
											<w:w w:val="95"/>
											<w:sz w:val="18"/>
										</w:rPr>
										<w:t>HORA</w:t>
									</w:r>
								</w:p>
							</w:tc>
							<w:tc>
								<w:tcPr>
									<w:tcW w:w="1790" w:type="dxa"/>
									<w:shd w:val="clear" w:color="auto" w:fill="538235"/>
								</w:tcPr>
								<w:p w:rsidRDefault="00D64538" w:rsidR="00D64538" w:rsidP="00D24AF0">
									<w:pPr>
										<w:pStyle w:val="TableParagraph"/>
										<w:spacing w:before="1"/>
										<w:ind w:left="43" w:right="32"/>
										<w:jc w:val="center"/>
											<w:rPr>
											<w:b/>
										<w:sz w:val="18"/>
										</w:rPr>
									</w:pPr>
									<w:r>
										<w:rPr>
											<w:b/>
											<w:color w:val="FFFFFF"/>
											<w:w w:val="90"/>
											<w:sz w:val="18"/>
										</w:rPr>
										<w:t>TIPOS DE</w:t>
									</w:r>
								</w:p>
								<w:p w:rsidRDefault="00D64538" w:rsidR="00D64538" w:rsidP="00D24AF0">
									<w:pPr>
										<w:pStyle w:val="TableParagraph"/>
										<w:spacing w:before="14" w:lineRule="exact" w:line="197"/>
										<w:ind w:left="43" w:right="33"/>
										<w:jc w:val="center"/>
										<w:rPr>
											<w:b/>
											<w:sz w:val="18"/>
										</w:rPr>
									</w:pPr>
									<w:r>
										<w:rPr>
											<w:b/>
											<w:color w:val="FFFFFF"/>
											<w:w w:val="95"/>
											<w:sz w:val="18"/>
										</w:rPr>
										<w:t>AUDIENCIAS</w:t>
									</w:r>
								</w:p>
								</w:tc>
							<w:tc>
								<w:tcPr>
									<w:tcW w:w="1212" w:type="dxa"/>
									<w:shd w:val="clear" w:color="auto" w:fill="538235"/>
								</w:tcPr>
								<w:p w:rsidRDefault="00D64538" w:rsidR="00D64538" w:rsidP="00D24AF0">
								<w:pPr>
									<w:pStyle w:val="TableParagraph"/>
									<w:spacing w:before="111"/>
									<w:ind w:right="270"/>
									<w:jc w:val="right"/>
										<w:rPr>
										<w:b/>
									<w:sz w:val="18"/>
									</w:rPr>
								</w:pPr>
								<w:r>
									<w:rPr>
										<w:b/>
										<w:color w:val="FFFFFF"/>
										<w:w w:val="80"/>
										<w:sz w:val="18"/>
									</w:rPr>
									<w:t>EDIFICIO</w:t>
								</w:r>
								</w:p>
							</w:tc>
							<w:tc>
								<w:tcPr>
									<w:tcW w:w="858" w:type="dxa"/>
									<w:shd w:val="clear" w:color="auto" w:fill="538235"/>
								</w:tcPr>
								<w:p w:rsidRDefault="00D64538" w:rsidR="00D64538" w:rsidP="00D24AF0">
								<w:pPr>
									<w:pStyle w:val="TableParagraph"/>
									<w:spacing w:before="111"/>
									<w:ind w:left="197"/>
									<w:rPr>
										<w:b/>
										<w:sz w:val="18"/>
									</w:rPr>
								</w:pPr>
								<w:r>
									<w:rPr>
										<w:b/>
										<w:color w:val="FFFFFF"/>
										<w:w w:val="85"/>
										<w:sz w:val="18"/>
									</w:rPr>
									<w:t>SALA</w:t>
								</w:r>
								</w:p>
							</w:tc>
							<w:tc>
								<w:tcPr>
									<w:tcW w:w="2356" w:type="dxa"/>
									<w:shd w:val="clear" w:color="auto" w:fill="538235"/>
								</w:tcPr>
								<w:p w:rsidRDefault="00D64538" w:rsidR="00D64538" w:rsidP="00D24AF0">
								<w:pPr>
									<w:pStyle w:val="TableParagraph"/>
									<w:spacing w:before="111"/>
									<w:ind w:left="886" w:right="873"/>
									<w:jc w:val="center"/>
										<w:rPr>
										<w:b/>
									<w:sz w:val="18"/>
									</w:rPr>
								</w:pPr>
								<w:r>
									<w:rPr>
										<w:b/>
										<w:color w:val="FFFFFF"/>
										<w:w w:val="85"/>
										<w:sz w:val="18"/>
									</w:rPr>
									<w:t>JUEZ</w:t>
								</w:r>
								</w:p>
							</w:tc>
							<w:tc>
								<w:tcPr>
									<w:tcW w:w="1154" w:type="dxa"/>
									<w:shd w:val="clear" w:color="auto" w:fill="538235"/>
								</w:tcPr>
								<w:p w:rsidRDefault="00D64538" w:rsidR="00D64538" w:rsidP="00D24AF0">
									<w:pPr>
										<w:pStyle w:val="TableParagraph"/>
										<w:spacing w:before="111"/>
										<w:ind w:left="71" w:right="60"/>
										<w:jc w:val="center"/>
											<w:rPr>
											<w:b/>
										<w:sz w:val="18"/>
										</w:rPr>
									</w:pPr>
									<w:r>
										<w:rPr>
											<w:b/>
											<w:color w:val="FFFFFF"/>
											<w:w w:val="90"/>
											<w:sz w:val="18"/>
										</w:rPr>
										<w:t>IMPUTADOS</w:t>
									</w:r>
								</w:p>
							</w:tc>
							<w:tc>
								<w:tcPr>
									<w:tcW w:w="2410" w:type="dxa"/>
									<w:shd w:val="clear" w:color="auto" w:fill="538235"/>
								</w:tcPr>
								<w:p w:rsidRDefault="00D64538" w:rsidR="00D64538" w:rsidP="00D24AF0">
									<w:pPr>
										<w:pStyle w:val="TableParagraph"/>
										<w:spacing w:before="111"/>
										<w:ind w:left="62" w:right="50"/>
										<w:jc w:val="center"/>
											<w:rPr>
											<w:b/>
										<w:sz w:val="18"/>
										</w:rPr>
									</w:pPr>
									<w:r>
										<w:rPr>
											<w:b/>
											<w:color w:val="FFFFFF"/>
											<w:w w:val="95"/>
											<w:sz w:val="18"/>
										</w:rPr>
										<w:t>NOMBRE DE IMPUTADO</w:t>
									</w:r>
								</w:p>
							</w:tc>
							<w:tc>
								<w:tcPr>
									<w:tcW w:w="2635" w:type="dxa"/>
									<w:shd w:val="clear" w:color="auto" w:fill="538235"/>
								</w:tcPr>
								<w:p w:rsidRDefault="00D64538" w:rsidR="00D64538" w:rsidP="00D24AF0">
									<w:pPr>
										<w:pStyle w:val="TableParagraph"/>
										<w:spacing w:before="111"/>
										<w:ind w:left="98" w:right="86"/>
										<w:jc w:val="center"/>
										<w:rPr>
											<w:b/>
											<w:sz w:val="18"/>
										</w:rPr>
									</w:pPr>
									<w:r>
										<w:rPr>
											<w:b/>
											<w:color w:val="FFFFFF"/>
											<w:w w:val="90"/>
											<w:sz w:val="18"/>
										</w:rPr>
										<w:t>DELITOS</w:t>
									</w:r>
								</w:p>
							</w:tc>
							<w:tc>
								<w:tcPr>
									<w:tcW w:w="1509" w:type="dxa"/>
									<w:shd w:val="clear" w:color="auto" w:fill="538235"/>
								</w:tcPr>
								<w:p w:rsidRDefault="00D64538" w:rsidR="00D64538" w:rsidP="00D24AF0">
									<w:pPr>
										<w:pStyle w:val="TableParagraph"/>
										<w:spacing w:before="1"/>
										<w:ind w:left="118" w:right="104"/>
										<w:jc w:val="center"/>
											<w:rPr>
											<w:b/>
										<w:sz w:val="18"/>
										</w:rPr>
									</w:pPr>
									<w:r>
										<w:rPr>
											<w:b/>
											<w:color w:val="FFFFFF"/>
											<w:w w:val="90"/>
											<w:sz w:val="18"/>
										</w:rPr>
										<w:t>CARPETA DE</w:t>
									</w:r>
								</w:p>
								<w:p w:rsidRDefault="00D64538" w:rsidR="00D64538" w:rsidP="00D24AF0">
									<w:pPr>
										<w:pStyle w:val="TableParagraph"/>
										<w:spacing w:before="14" w:lineRule="exact" w:line="197"/>
										<w:ind w:left="115" w:right="104"/>
										<w:jc w:val="center"/>
											<w:rPr>
											<w:b/>
										<w:sz w:val="18"/>
										</w:rPr>
									</w:pPr>
									<w:r>
										<w:rPr>
											<w:b/>
											<w:color w:val="FFFFFF"/>
											<w:w w:val="90"/>
											<w:sz w:val="18"/>
										</w:rPr>
										<w:t>INVESTIGACIÓN</w:t>
									</w:r>
								</w:p>
							</w:tc>
						</w:tr>';
			
			$contenido=	'<w:tr w:rsidR="00D64538" w:rsidTr="003A1211">
								<w:trPr>
									<w:trHeight w:val="899"/>
								</w:trPr>
								<w:tc>
									<w:tcPr>
										<w:tcW w:w="2640" w:type="dxa"/>
										<w:shd w:val="clear" w:color="auto" w:fill="[colorFondo]"/>
										<w:vAlign w:val="center"/>
									</w:tcPr>
									<w:p w:rsidRDefault="007E5632" w:rsidR="00D64538" w:rsidP="00D24AF0">
									<w:pPr>
										<w:pStyle w:val="TableParagraph"/>
										<w:spacing w:before="135"/>
										<w:ind w:left="412" w:right="407"/>
										<w:jc w:val="center"/>
											<w:rPr>
											<w:b/>
										<w:sz w:val="18"/>
										</w:rPr>
									</w:pPr>
									<w:r>
										<w:rPr>
											<w:b/>
											<w:color w:val="000000"/>
											<w:w w:val="95"/>
											<w:sz w:val="18"/>
										</w:rPr>
										<w:t>[unidadGestion]</w:t>
									</w:r>
									</w:p>
								</w:tc>
								<w:tc>
									<w:tcPr>
										<w:tcW w:w="480" w:type="dxa"/>
										<w:shd w:val="clear" w:color="auto" w:fill="D9D9D9"/>
										<w:vAlign w:val="center"/>
									</w:tcPr>
									<w:p w:rsidRDefault="007E5632" w:rsidR="00D64538" w:rsidP="00D24AF0">
									<w:pPr>
										<w:pStyle w:val="TableParagraph"/>
										<w:spacing w:before="135"/>
										<w:ind w:left="10"/>
										<w:jc w:val="center"/>
										<w:rPr>
											<w:sz w:val="18"/>
										</w:rPr>
									</w:pPr>
									<w:r>
										<w:rPr>
											<w:w w:val="91"/>
											<w:sz w:val="18"/>
										</w:rPr>
										<w:t>[no]</w:t>
									</w:r>
									</w:p>
								</w:tc>
								<w:tc>
									<w:tcPr>
										<w:tcW w:w="1694" w:type="dxa"/>
										<w:vAlign w:val="center"/>
									</w:tcPr>
									<w:p w:rsidRDefault="006D539D" w:rsidR="00D64538" w:rsidP="00D24AF0">
									<w:pPr>
										<w:pStyle w:val="TableParagraph"/>
										<w:spacing w:before="135"/>
										<w:ind w:left="226" w:right="216"/>
										<w:jc w:val="center"/>
										<w:rPr>
											<w:b/>
											<w:sz w:val="18"/>
										</w:rPr>
									</w:pPr>
									<w:r>
										<w:rPr>
											<w:b/>
											<w:color w:val="FF0000"/>
											<w:sz w:val="18"/>
										</w:rPr>
										<w:t></w:t>
									</w:r>
									<w:r w:rsidR="007E5632">
										<w:rPr>
											<w:b/>
											<w:color w:val="FF0000"/>
											<w:sz w:val="18"/>
										</w:rPr>
										<w:t>[carpetaJ]</w:t>
									</w:r>
									</w:p>
								</w:tc>
								<w:tc>
									<w:tcPr>
										<w:tcW w:w="994" w:type="dxa"/>
										<w:vAlign w:val="center"/>
									</w:tcPr>
									<w:p w:rsidRDefault="007E5632" w:rsidR="00D64538" w:rsidP="003A1211" w:rsidRPr="003A1211">
									<w:pPr>
										<w:pStyle w:val="TableParagraph"/>
										<w:spacing w:before="135"/>
										<w:ind w:left="43" w:right="34"/>
										<w:jc w:val="center"/>
										<w:rPr>
											<w:sz w:val="18"/>
										</w:rPr>
									</w:pPr>
									<w:r w:rsidRPr="003A1211">
										<w:rPr>
											<w:sz w:val="18"/>
										</w:rPr>
										<w:t>[hora]</w:t>
									</w:r>
									</w:p>
								</w:tc>
								<w:tc>
									<w:tcPr>
										<w:tcW w:w="1790" w:type="dxa"/>
										<w:vAlign w:val="center"/>
									</w:tcPr>
									<w:p w:rsidRDefault="007E5632" w:rsidR="00D64538" w:rsidP="00D24AF0">
										<w:pPr>
											<w:pStyle w:val="TableParagraph"/>
											<w:spacing w:before="135"/>
											<w:ind w:left="43" w:right="34"/>
											<w:jc w:val="center"/>
											<w:rPr>
												<w:sz w:val="18"/>
											</w:rPr>
										</w:pPr>
										<w:r>
											<w:rPr>
												<w:sz w:val="18"/>
											</w:rPr>
											<w:t>[tipoAudiencia]</w:t>
										</w:r>
									</w:p>
								</w:tc>
								<w:tc>
									<w:tcPr>
										<w:tcW w:w="1212" w:type="dxa"/>
										<w:vAlign w:val="center"/>
									</w:tcPr>
									<w:p w:rsidRDefault="007E5632" w:rsidR="00D64538" w:rsidP="00D24AF0">
										<w:pPr>
											<w:pStyle w:val="TableParagraph"/>
											<w:spacing w:before="135"/>
											<w:ind w:right="212"/>
											<w:jc w:val="right"/>
											<w:rPr>
												<w:sz w:val="18"/>
											</w:rPr>
										</w:pPr>
										<w:r>
											<w:rPr>
												<w:w w:val="90"/>
												<w:sz w:val="18"/>
											</w:rPr>
											<w:t>[edificio]</w:t>
										</w:r>
									</w:p>
								</w:tc>
								<w:tc>
									<w:tcPr>
										<w:tcW w:w="858" w:type="dxa"/>
										<w:vAlign w:val="center"/>
									</w:tcPr>
									<w:p w:rsidRDefault="007E5632" w:rsidR="00D64538" w:rsidP="003A1211">
										<w:pPr>
											<w:pStyle w:val="TableParagraph"/>
											<w:spacing w:before="135"/>
											<w:ind w:left="226" w:right="216"/>
											<w:jc w:val="center"/>
											<w:rPr>
												<w:sz w:val="18"/>
											</w:rPr>
										</w:pPr>
										<w:r>
											<w:rPr>
												<w:w w:val="80"/>
												<w:sz w:val="18"/>
											</w:rPr>
											<w:t>[sala]</w:t>
										</w:r>
									</w:p>
								</w:tc>
								<w:tc>
									<w:tcPr>
										<w:tcW w:w="2356" w:type="dxa"/>
										<w:shd w:val="clear" w:color="auto" w:fill="C3BEF7"/>
										<w:vAlign w:val="center"/>
									</w:tcPr>
									<w:p w:rsidRDefault="007E5632" w:rsidR="00D64538" w:rsidP="003A1211">
										<w:pPr>
											<w:pStyle w:val="TableParagraph"/>
											<w:spacing w:before="135"/>
											<w:ind w:left="226" w:right="216"/>
											<w:jc w:val="center"/>
											<w:rPr>
												<w:sz w:val="18"/>
											</w:rPr>
										</w:pPr>
										<w:r>
											<w:rPr>
												<w:w w:val="90"/>
												<w:sz w:val="18"/>
											</w:rPr>
											<w:t>[juez]</w:t>
										</w:r>
									</w:p>
								</w:tc>
								<w:tc>
									<w:tcPr>
										<w:tcW w:w="1154" w:type="dxa"/>
										<w:vAlign w:val="center"/>
									</w:tcPr>
									<w:p w:rsidRDefault="007E5632" w:rsidR="00D64538" w:rsidP="00D24AF0">
										<w:pPr>
											<w:pStyle w:val="TableParagraph"/>
											<w:spacing w:before="135"/>
											<w:ind w:left="10"/>
											<w:jc w:val="center"/>
											<w:rPr>
												<w:sz w:val="18"/>
											</w:rPr>
										</w:pPr>
										<w:r>
											<w:rPr>
												<w:w w:val="91"/>
												<w:sz w:val="18"/>
											</w:rPr>
											<w:t>[imputados]</w:t>
										</w:r>
									</w:p>
								</w:tc>
								<w:tc>
									<w:tcPr>
										<w:tcW w:w="2410" w:type="dxa"/>
										<w:shd w:val="clear" w:color="auto" w:fill="D9D9D9"/>
										<w:vAlign w:val="center"/>
									</w:tcPr>
									<w:p w:rsidRDefault="007E5632" w:rsidR="00D64538" w:rsidP="00D24AF0">
										<w:pPr>
											<w:pStyle w:val="TableParagraph"/>
											<w:spacing w:before="135"/>
											<w:ind w:left="62" w:right="51"/>
											<w:jc w:val="center"/>
											<w:rPr>
												<w:sz w:val="18"/>
											</w:rPr>
										</w:pPr>
										<w:r>
											<w:rPr>
												<w:w w:val="85"/>
												<w:sz w:val="18"/>
											</w:rPr>
											<w:t>[nImputados]</w:t>
										</w:r>
									</w:p>
								</w:tc>
								<w:tc>
									<w:tcPr>
										<w:tcW w:w="2635" w:type="dxa"/>
										<w:vAlign w:val="center"/>
									</w:tcPr>
									<w:p w:rsidRDefault="007E5632" w:rsidR="00D64538" w:rsidP="00D24AF0">
										<w:pPr>
											<w:pStyle w:val="TableParagraph"/>
											<w:spacing w:before="121" w:lineRule="auto" w:line="256"/>
											<w:ind w:left="101" w:right="86"/>
											<w:jc w:val="center"/>
											<w:rPr>
												<w:sz w:val="18"/>
											</w:rPr>
										</w:pPr>
										<w:r>
											<w:rPr>
												<w:w w:val="80"/>
												<w:sz w:val="18"/>
											</w:rPr>
											<w:t>[delitos]</w:t>
										</w:r>
									</w:p>
								</w:tc>
								<w:tc>
									<w:tcPr>
										<w:tcW w:w="1509" w:type="dxa"/>
										<w:vAlign w:val="center"/>
									</w:tcPr>
									<w:p w:rsidRDefault="007E5632" w:rsidR="00D64538" w:rsidP="00D24AF0">
										<w:pPr>
											<w:pStyle w:val="TableParagraph"/>
											<w:spacing w:before="121" w:lineRule="auto" w:line="256"/>
											<w:ind w:left="122" w:right="104"/>
											<w:jc w:val="center"/>
											<w:rPr>
												<w:sz w:val="18"/>
											</w:rPr>
										</w:pPr>
										<w:r>
											<w:rPr>
												<w:w w:val="85"/>
												<w:sz w:val="18"/>
											</w:rPr>
											<w:t>[carpetaInv]</w:t>
										</w:r>
									</w:p>
								</w:tc>
							</w:tr>';
			
			$resumen='<w:tr w:rsidR="00D64538" w:rsidTr="007E5632">
							<w:trPr>
								<w:trHeight w:val="498"/>
							</w:trPr>
							<w:tc>
								<w:tcPr>
									<w:tcW w:w="19732" w:type="dxa"/>
									<w:gridSpan w:val="12"/>
									<w:shd w:val="clear" w:color="auto" w:fill="FFFF00"/>
								</w:tcPr>
								<w:p w:rsidRDefault="007A06BE" w:rsidR="00D64538" w:rsidP="007A06BE">
									<w:pPr>
										<w:pStyle w:val="TableParagraph"/>
										<w:tabs>
											<w:tab w:val="left" w:pos="11800"/>
										</w:tabs>
										<w:spacing w:before="82"/>
										<w:ind w:left="6414" w:right="6091"/>
										<w:jc w:val="center"/>
										<w:rPr>
											<w:b/>
											<w:sz w:val="28"/>
										</w:rPr>
									</w:pPr>
									<w:r>
										<w:rPr>
											<w:b/>
											<w:w w:val="95"/>
										</w:rPr>
										<w:t>[lblUGA]</w:t>
									</w:r>
									<w:r w:rsidR="00D64538">
										<w:rPr>
											<w:b/>
											<w:w w:val="95"/>
										</w:rPr>
										<w:t xml:space="preserve">: TOTAL DE AUDIENCIAS: </w:t>
									</w:r>
									<w:r>
										<w:rPr>
											<w:b/>
											<w:w w:val="95"/>
											<w:sz w:val="28"/>
										</w:rPr>
										<w:t>[tAudienciaUGA]</w:t>
									</w:r>
								</w:p>
							</w:tc>
						</w:tr>';
			$cierreTabla='</w:tbl>';
			
			$tblAudiencias=$inicioTabla.$encabezado;
			
			$totalAudienciasUga=1;
			$ugaAbierta=false;
			$colorFondo="F8ACDA";
			while($filaAudiencia=mysql_fetch_assoc($rAudiencias))
			{
				if($filaAudiencia["id__17_tablaDinamica"]!=$ugaActual)
				{
					$colorFondo=($colorFondo=="F8ACDA"?"C5DFB4":"F8ACDA");
					if($ugaAbierta)
					{
						$arrDatos=array();
						$arrDatos["lblUGA"]=$arrUgas[$ugaActual]["leyendaResumen"];
						$arrDatos["tAudienciaUGA"]=$totalAudienciasUga-1;
						$lblResumen=$resumen;
						foreach($arrDatos as $campo=>$valor)
						{
							$lblResumen=str_replace("[".$campo."]",$valor,$lblResumen);
						}
						$tblAudiencias.=$lblResumen;
					}
					$tblAudiencias.=$encabezado2;
					$ugaAbierta=true;
					$ugaActual=$filaAudiencia["id__17_tablaDinamica"];
					$totalAudienciasUga=1;
				}
				
				$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$filaAudiencia["idRegistroEvento"];
				$carpetaAdministrativa=$con->obtenerValor($consulta);
				
				$consulta="SELECT noJuez,(SELECT Nombre FROM 800_usuarios WHERE idUsuario=j.idJuez) FROM 7001_eventoAudienciaJuez j WHERE idRegistroEvento=".$filaAudiencia["idRegistroEvento"];
				$fJuez=$con->obtenerPrimeraFila($consulta);
				$consulta="SELECT idActividad,upper(carpetaInvestigacion) FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
				$fInfoCarpeta=$con->obtenerPrimeraFila($consulta);
				
				
				$consulta="SELECT concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )
						FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fInfoCarpeta[0]." and
						i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
				$imputados=$con->obtenerListaValores($consulta);
				
				$tImputados=$con->filasAfectadas;
				
				
				$consulta="SELECT GROUP_CONCAT(de.denominacionDelito) FROM _61_tablaDinamica d,_35_denominacionDelito de WHERE d.idActividad= ".$fInfoCarpeta[0]."
							AND de.id__35_denominacionDelito=d.denominacionDelito ORDER BY d.denominacionDelito";
				$lblDelitos=$con->obtenerValor($consulta);
				
				$juez="(".$fJuez[0].") ".$fJuez[1];
				$lblContenido=$contenido;
				$arrDatos=array();
				$arrDatos["unidadGestion"]=$arrUgas[$ugaActual]["leyenda"];
				$arrDatos["no"]=$totalAudienciasUga;
				$arrDatos["carpetaJ"]=$carpetaAdministrativa;
				$arrDatos["hora"]="De las ".date("H:i",strtotime($filaAudiencia["horaInicioEvento"]))." hrs. a las ".date("H:i",strtotime($filaAudiencia["horaFinEvento"]))." hrs.";
				$arrDatos["tipoAudiencia"]=$filaAudiencia["tipoAudiencia"];
				$arrDatos["edificio"]=$filaAudiencia["edificio"];
				$arrDatos["sala"]=$filaAudiencia["sala"];
				$arrDatos["juez"]=$juez;
				$arrDatos["imputados"]=$imputados;
				$arrDatos["nImputados"]=$tImputados;
				$arrDatos["delitos"]=$lblDelitos;
				$arrDatos["carpetaInv"]=$fInfoCarpeta[1];
				$arrDatos["colorFondo"]=$colorFondo;
				foreach($arrDatos as $campo=>$valor)
				{
					$lblContenido=str_replace("[".$campo."]",$valor,$lblContenido);
				}
				$tblAudiencias.=$lblContenido;
				$totalAudienciasUga++;
			}
			
			$arrDatos=array();
			$arrDatos["lblUGA"]=$arrUgas[$ugaActual]["leyendaResumen"];
			$arrDatos["tAudienciaUGA"]=$totalAudienciasUga;
			$lblResumen=$resumen;
			foreach($arrDatos as $campo=>$valor)
			{
				$lblResumen=str_replace("[".$campo."]",$valor,$lblResumen);
			}
			$tblAudiencias.=$lblResumen;
			$tblAudiencias.=$cierreTabla;
			
			$arrParam["tblAudiencias"]=$tblAudiencias;
			
			foreach($arrParam as $campo=>$valor)
			{
				$document->setValue("[".$campo."]",utf8_decode($valor));	
			}
			
			
			$nombreAleatorio=generarNombreArchivoTemporal();
			$nomArchivo=$nombreAleatorio.".docx";
			$document->save($nomArchivo);
			
			$nomArchivoFinal=str_replace(".docx",".pdf",$nomArchivo);
			$nombreFinal="audienciasProgramadas_".str_replace("/","_",$fecha).".pdf";
			generarDocumentoPDF($nomArchivo,false,false,true,$nomArchivo,"MS_OFFICE","./");
			
			if(file_exists($nomArchivoFinal))
			{
				$arrArchivos[0][0]="./".$nomArchivoFinal;
				$arrArchivos[0][1]=$nombreFinal;
				$cuerpo="Adjunto al presente, se env&iacute;a la agenda de audiencias registradas en sistema del d&iacute;a  ".$lblFechaAudiencia;
				if(enviarMailGMail($destinatario,"TSJCDMX Audiencias programadas ".$lblFechaAudiencia,$cuerpo,$arrArchivos,$arrCopia,$arrCopiaOculta))
				{
					unlink($nomArchivoFinal);
					actualizarRegistroBitacoraEjecucionActividadTemporal($idRegistroTarea,1,$fechaInicio==null?$tipoTareaRealizacion:"");
					return "OK";
				}
				else
				{
					unlink($nomArchivoFinal);
					return "No se ha podido enviar correo";
				}
			}
			else
			{
				
				return "No se puedo generar archivo: ".$nomArchivoFinal;
			}
			
			
		}
		catch(Exception $e)
		{
			if(file_exists($nomArchivo))
			{
				
				unlink($nomArchivo);
			}
			actualizarRegistroBitacoraEjecucionActividadTemporal($idRegistroTarea,2,$e->getMessage());
			return $e->getMessage();
		}
		
		
	}
	
	$arrParam=array();
	$server = new soap_server;
	$ns=$urlSitio."/webServices";
	$server->configurewsdl('ApplicationServices',$ns);
	$server->wsdl->schematargetnamespace=$ns;
	$server->register('revisionTareasTrabajo',array('fechaInicio'=>'xsd:string','fechaFin'=>'xsd:string','revisionTotal'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('revisionSolicitudesInicialesNOUrgentes',array(),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('generarInformeAudienciasDelDia',array(),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	
	if (isset($HTTP_RAW_POST_DATA)) 
	{
		$input = $HTTP_RAW_POST_DATA;
	}
	else 
	{
		$input = implode("rn", file('php://input'));
	}
	
	
	$server->service($input);//Copiado
?>