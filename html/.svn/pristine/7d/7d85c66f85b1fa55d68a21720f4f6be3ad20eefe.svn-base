<?php
	include("conexionBD.php");
	include_once("PHPWord.php");
	include_once("zip.lib.php"); 
	ini_set("memory_limit","8000M");
	set_time_limit(999000);
	
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
	
	if(isset($_GET["fechaInicio"]))
		$fechaInicio=$_GET["fechaInicio"];
		
	if(isset($_GET["fechaFin"]))
		$fechaFin=$_GET["fechaFin"];
	$fecha=date("Y-m-d");
	
	$tipoTarea=8;
	$mE=0;
	if(isset($_GET["mE"]))
		$mE=$_GET["mE"];

	$tipoTareaRealizacion="[Programado Manual]";
		
		
	
	
	if($fechaInicio==null)
	{	
		$consulta="SELECT COUNT(*) FROM 9075_bitacoraEjecucionActividadTemporal WHERE fechaInicioEjecucion>='".$fecha."' 
					AND fechaInicioEjecucion<='".$fecha." 23:59:59' AND tipoActividad=8 AND resultado=1 and comentariosAdicionales='".$tipoTareaRealizacion."'";
		$nReg=$con->obtenerValor($consulta);
		if($nReg>0)	
		{
			return;
		}
	}
	else
	{
		$fecha=$fechaInicio;
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
		$arrUgas[50]["leyenda"]="UNIDAD DOCE             Órdenes de Aprehensión y Cateos";
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
								<w:gridSpan w:val="13"/>
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
								<w:tcW w:w="2400" w:type="dxa"/>
								<w:shd w:val="clear" w:color="auto" w:fill="538235"/>
							</w:tcPr>
							<w:p w:rsidRDefault="00D64538" w:rsidR="00D64538" w:rsidP="00D24AF0">
								<w:pPr>
									<w:pStyle w:val="TableParagraph"/>
									<w:spacing w:before="111"/>
									<w:ind w:left="10" w:right="10"/>
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
								<w:tcW w:w="1644" w:type="dxa"/>
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
								<w:tcW w:w="1700" w:type="dxa"/>
								<w:shd w:val="clear" w:color="auto" w:fill="538235"/>
							</w:tcPr>
							<w:p w:rsidRDefault="00D64538" w:rsidR="00D64538" w:rsidP="00D24AF0">
								<w:pPr>
									<w:pStyle w:val="TableParagraph"/>
									<w:spacing w:before="1"/>
									<w:ind w:left="10" w:right="10"/>
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
									<w:ind w:left="10" w:right="10"/>
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
								<w:tcW w:w="1160" w:type="dxa"/>
								<w:shd w:val="clear" w:color="auto" w:fill="538235"/>
							</w:tcPr>
							<w:p w:rsidRDefault="00D64538" w:rsidR="00D64538" w:rsidP="00D24AF0">
							<w:pPr>
								<w:pStyle w:val="TableParagraph"/>
								<w:spacing w:before="111"/>
								<w:ind w:left="5" w:right="5"/>
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
								<w:t>EDIFICIO</w:t>
							</w:r>
							</w:p>
						</w:tc>
						
						
							
						<w:tc>
							<w:tcPr>
								<w:tcW w:w="800" w:type="dxa"/>
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
								<w:tcW w:w="1850" w:type="dxa"/>
								<w:shd w:val="clear" w:color="auto" w:fill="538235"/>
							</w:tcPr>
							<w:p w:rsidRDefault="00D64538" w:rsidR="00D64538" w:rsidP="00D24AF0">
							<w:pPr>
								<w:pStyle w:val="TableParagraph"/>
								<w:spacing w:before="111"/>
								<w:ind w:left="10" w:right="10"/>
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
								<w:t>TELEPRESENCIA</w:t>
							</w:r>
							</w:p>
						</w:tc>
						<w:tc>
							<w:tcPr>
								<w:tcW w:w="2050" w:type="dxa"/>
								<w:shd w:val="clear" w:color="auto" w:fill="538235"/>
							</w:tcPr>
							<w:p w:rsidRDefault="00D64538" w:rsidR="00D64538" w:rsidP="00D24AF0">
							<w:pPr>
								<w:pStyle w:val="TableParagraph"/>
								<w:spacing w:before="111"/>
								<w:ind w:left="10" w:right="10"/>
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
								<w:tcW w:w="2000" w:type="dxa"/>
								<w:shd w:val="clear" w:color="auto" w:fill="538235"/>
							</w:tcPr>
							<w:p w:rsidRDefault="00D64538" w:rsidR="00D64538" w:rsidP="00D24AF0">
								<w:pPr>
									<w:pStyle w:val="TableParagraph"/>
									<w:spacing w:before="111"/>
									<w:ind w:left="10" w:right="10"/>
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
								<w:tcW w:w="2150" w:type="dxa"/>
								<w:shd w:val="clear" w:color="auto" w:fill="538235"/>
							</w:tcPr>
							<w:p w:rsidRDefault="00D64538" w:rsidR="00D64538" w:rsidP="00D24AF0">
								<w:pPr>
									<w:pStyle w:val="TableParagraph"/>
									<w:spacing w:before="111"/>
									<w:ind w:left="10" w:right="10"/>
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
								<w:tcW w:w="1350" w:type="dxa"/>
								<w:shd w:val="clear" w:color="auto" w:fill="538235"/>
							</w:tcPr>
							<w:p w:rsidRDefault="00D64538" w:rsidR="00D64538" w:rsidP="00D24AF0">
								<w:pPr>
									<w:pStyle w:val="TableParagraph"/>
									<w:spacing w:before="1"/>
									<w:ind w:left="10" w:right="10"/>
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
									<w:ind w:left="10" w:right="10"/>
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
									<w:tcW w:w="2400" w:type="dxa"/>
									<w:shd w:val="clear" w:color="auto" w:fill="[colorFondo]"/>
									<w:vAlign w:val="center"/>
								</w:tcPr>
								<w:p w:rsidRDefault="007E5632" w:rsidR="00D64538" w:rsidP="00D24AF0">
								<w:pPr>
									<w:pStyle w:val="TableParagraph"/>
									<w:spacing w:before="135"/>
									<w:ind w:left="10" w:right="10"/>
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
									<w:tcW w:w="1644" w:type="dxa"/>
									<w:vAlign w:val="center"/>
								</w:tcPr>
								<w:p w:rsidRDefault="006D539D" w:rsidR="00D64538" w:rsidP="00D24AF0">
								<w:pPr>
									<w:pStyle w:val="TableParagraph"/>
									<w:spacing w:before="135"/>
									<w:ind w:left="5" w:right="5"/>
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
									<w:tcW w:w="1700" w:type="dxa"/>
									<w:vAlign w:val="center"/>
								</w:tcPr>
								<w:p w:rsidRDefault="007E5632" w:rsidR="00D64538" w:rsidP="00D24AF0">
									<w:pPr>
										<w:pStyle w:val="TableParagraph"/>
										<w:spacing w:before="135"/>
										<w:ind w:left="10" w:right="10"/>
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
									<w:tcW w:w="1160" w:type="dxa"/>
									<w:vAlign w:val="center"/>
								</w:tcPr>
								<w:p w:rsidRDefault="007E5632" w:rsidR="00D64538" w:rsidP="00D24AF0">
									<w:pPr>
										<w:pStyle w:val="TableParagraph"/>
										<w:spacing w:before="10"/>
										<w:ind w:left="5" w:right="5"/>
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
										<w:t>[edificio]</w:t>
									</w:r>
								</w:p>
							</w:tc>
							<w:tc>
								<w:tcPr>
									<w:tcW w:w="800" w:type="dxa"/>
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
									<w:tcW w:w="1850" w:type="dxa"/>
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
										<w:t>[recursos]</w:t>
									</w:r>
								</w:p>
							</w:tc>
							<w:tc>
								<w:tcPr>
									<w:tcW w:w="2050" w:type="dxa"/>
									<w:shd w:val="clear" w:color="auto" w:fill="C3BEF7"/>
									<w:vAlign w:val="center"/>
								</w:tcPr>
								<w:p w:rsidRDefault="007E5632" w:rsidR="00D64538" w:rsidP="003A1211">
									<w:pPr>
										<w:pStyle w:val="TableParagraph"/>
										<w:spacing w:before="135"/>
										<w:ind w:left="10" w:right="10"/>
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
										<w:t>[nImputados]</w:t>
									</w:r>
								</w:p>
							</w:tc>
							<w:tc>
								<w:tcPr>
									<w:tcW w:w="2000" w:type="dxa"/>
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
										<w:t>[imputados]</w:t>
									</w:r>
								</w:p>
							</w:tc>
							<w:tc>
								<w:tcPr>
									<w:tcW w:w="2150" w:type="dxa"/>
									<w:vAlign w:val="center"/>
								</w:tcPr>
								<w:p w:rsidRDefault="007E5632" w:rsidR="00D64538" w:rsidP="00D24AF0">
									<w:pPr>
										<w:pStyle w:val="TableParagraph"/>
										<w:spacing w:before="121" w:lineRule="auto" w:line="256"/>
										<w:ind w:left="10" w:right="10"/>
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
									<w:tcW w:w="1350" w:type="dxa"/>
									<w:vAlign w:val="center"/>
								</w:tcPr>
								<w:p w:rsidRDefault="007E5632" w:rsidR="00D64538" w:rsidP="00D24AF0">
									<w:pPr>
										<w:pStyle w:val="TableParagraph"/>
										<w:spacing w:before="121" w:lineRule="auto" w:line="256"/>
										<w:ind w:left="10" w:right="10"/>
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
								<w:gridSpan w:val="13"/>
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
			
			
			
			$arrRecursosAdicionalesRequeridos="";
			$consulta="SELECT * FROM 7001_recursosAdicionalesAudiencia WHERE idRegistroEvento=".$filaAudiencia["idRegistroEvento"]." and tipoRecurso=1 and
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
			
			$arrDatos["recursos"]=$arrRecursosAdicionalesRequeridos;
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
				if($mE==1)
				{
					echo "<body><script>window.parent.cerrarVentanaFancy();</script></body>";
				}
			}
			else
				unlink($nomArchivoFinal);
		}
		else
		{
			echo "No se puedo generar archivo: ".$nomArchivoFinal;
		}
		
	}
	catch(Exception $e)
	{
		if($mE==1)
		{
			echo $e->getMessage();
		}
		if(file_exists($nomArchivo))
		{
			
			unlink($nomArchivo);
		}
		actualizarRegistroBitacoraEjecucionActividadTemporal($idRegistroTarea,2,$e->getMessage());
	}
	
	
	
	
?>	