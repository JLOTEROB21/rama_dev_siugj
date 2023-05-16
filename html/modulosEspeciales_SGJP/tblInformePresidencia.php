<?php include("sesiones.php");
	include("conexionBD.php");

	$periodoInicio="-1";
	if(isset($_POST["fechaInicio"]))
		$periodoInicio=$_POST["fechaInicio"];
	$periodoFinal="-1";
	if(isset($_POST["fechaFin"]))
		$periodoFinal=$_POST["fechaFin"];
	?>
    
    <html>
    	<head>
    	<style>
			.tblTablaDatos
			{
				border-style:solid;
				border-width:1px;
				border-color:#000;
				border-spacing:0px;
			
				
			}
			
			.tblTablaDatos td
			{
				border-style:solid;
				border-width:1px;
				border-color:#000;
				font-size:13px;
				
			}
			
			.SeparadorSeccion 
			{
				-webkit-box-shadow: rgb(153, 153, 153) 10px 5px 10px 1px;
				background-color: rgb(175, 52, 52) !important;
				border-bottom-color: rgba(0, 0, 0, 0.14902) !important;
				border-bottom-left-radius: 4px;
				border-bottom-right-radius: 4px;
				border-bottom-style: solid !important;
				border-bottom-width: 1px !important;
				border-collapse: collapse;
				border-image-outset: 0px;
				border-image-repeat: stretch;
				border-image-slice: 100%;
				border-image-source: none;
				border-image-width: 1;
				border-left-color: rgba(0, 0, 0, 0.14902) !important;
				border-left-style: solid !important;
				border-left-width: 1px !important;
				border-right-color: rgba(0, 0, 0, 0.14902) !important;
				border-right-style: solid !important;
				border-right-width: 1px !important;
				border-top-color: rgba(0, 0, 0, 0.14902) !important;
				border-top-left-radius: 4px;
				border-top-right-radius: 4px;
				border-top-style: solid !important;
				border-top-width: 1px !important;
				box-shadow: rgb(153, 153, 153) 10px 5px 10px 1px;
				color: rgb(255, 255, 255) !important;
				display: block;
				font-family: verdana, arial, helvetica !important;
				font-size: 15px !important;
				font-style: normal;
				font-variant: normal;
				font-weight: bold;
				height: 17px !important;
				text-align: left !important;
				text-shadow: rgb(0, 0, 0) 2px 2px 0px;
				white-space: normal;
				word-wrap: break-word;
				width:900px;
				padding:5px;
				
		}
			
		</style>
        	<script src="../Scripts/ChartsJS/chart.min.js"></script>
			<script src="../Scripts/ChartsJS/utils.js"></script>
            <script src="../Scripts/ChartsJS/chartjs-plugin-datalabels.min.js"></script>
        </head>
    	<body style="background-color:#FFF">
    <?php
	
	$mesInicial=date("m",strtotime($periodoInicio))*1;
	$mesFinal=date("m",strtotime($periodoFinal))*1;
	$arrCentroGestion=array();
	$consulta="SELECT id__17_tablaDinamica,claveUnidad,nombreUnidad,colorAsociado FROM _17_tablaDinamica u,_17_tiposCarpetasAdministra tC WHERE cmbCategoria=1
			and tC.idPadre=u.id__17_tablaDinamica and tC.idOpcion=1 ORDER BY prioridad";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$fechaInicial=$periodoInicio;
		
		$arrCentroGestion[$fila[1]]=array();
		$arrCentroGestion[$fila[1]]["nombreUnidad"]=$fila[2];
		$arrCentroGestion[$fila[1]]["colorAsociado"]=$fila[3];
		$arrCentroGestion[$fila[1]]["carpetasMes"]=array();
		$arrCentroGestion[$fila[1]]["totalCarpetas"]=0;
		for($mes=$mesInicial;$mes<=$mesFinal;$mes++)
		{
			$fechaFinal=date("Y-m",strtotime($fechaInicial))."-".getUltimoDiaMes(date("Y",strtotime($fechaInicial)),date("m",strtotime($fechaInicial)));
			if(strtotime($fechaFinal)>strtotime($periodoFinal))
			{
				$fechaFinal=$periodoFinal;
			}
			$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE fechaCreacion>='".$fechaInicial."' 
						AND fechaCreacion<='".$fechaFinal." 23:59:59' AND unidadGestion='".$fila[1]."' 
						and tipoCarpetaAdministrativa=1";

			$nCarpetas=$con->obtenerValor($consulta);
			$arrCentroGestion[$fila[1]]["carpetasMes"][$mes]=$nCarpetas;
			$arrCentroGestion[$fila[1]]["totalCarpetas"]+=$nCarpetas;
			$fechaInicial=date("Y-m-01",strtotime("+1 month",strtotime($fechaInicial)));
			
		}
		
		$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE fechaCreacion>='".$periodoInicio."' 
						AND fechaCreacion<='".$periodoFinal." 23:59:59' AND unidadGestion='".$fila[1]."' 
						and tipoCarpetaAdministrativa=1";
		$arrCentroGestion[$fila[1]]["listadoGlobalCarpetas"]=$con->obtenerListaValores($consulta,"'");
		if($arrCentroGestion[$fila[1]]["listadoGlobalCarpetas"]=="")
			$arrCentroGestion[$fila[1]]["listadoGlobalCarpetas"]=-1;
	}
	
	
	function getUltimoDiaMes($elAnio,$elMes) 
	{
	  	return date("d",(mktime(0,0,0,$elMes+1,1,$elAnio)-1));
	}
	
	echo "<div class='SeparadorSeccion'>Carpetas de investigación recibidas por mes</div><br>";
	
	$tblReporte='<table class="tblTablaDatos">
					<tr>
						<td width="150">
							<b>MES</b>
						</td>';
	
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		$tblReporte.='	<td width="200">
							<b>'.$resto["nombreUnidad"].'</b>
						</td>
						
						';
	}
	$tblReporte.='	<td width="200">
					  	<b>Total</b>
				  	</td>
				  </tr>';
	

	for($mes=$mesInicial;$mes<=$mesFinal;$mes++)
	{
		$tblReporte.='<tr>
						<td><b>'.$arrMesLetra[$mes-1].'</b></td>';
		$total=0;
		foreach($arrCentroGestion as $unidadGestion=>$resto)
		{
			$total+=$resto["carpetasMes"][$mes];
			$tblReporte.='	<td width="200" align="center">
								'.$resto["carpetasMes"][$mes].'
							</td>							
							';
		}						
		
		
		$tblReporte.='	<td width="200" align="center">
					  	'.$total.'
				  	</td>
				  </tr>';
		
	}
	
	$tblReporte.='<tr>
					<td><b>Total</b></td>';
	$total=0;
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		$total+=$resto["totalCarpetas"];
		$tblReporte.='	<td width="200" align="center">
							'.$resto["totalCarpetas"].'
						</td>							
						';
	}						
	
	
	$tblReporte.='	<td width="200" align="center">
					'.$total.'
				</td>
			  </tr>';
		
	
	
	$tblReporte.='</table>';
	echo $tblReporte."<br><br>";
	
	$x=0;
	$grafica=array();
	
	$titulo="";
	
	
	
	$lblEtiquetas="";
	for($mes=$mesInicial;$mes<=$mesFinal;$mes++)
	{
		
		if($lblEtiquetas=="")
			$lblEtiquetas="'".$arrMesLetra[$mes-1]."'";
		else
			$lblEtiquetas.=",'".$arrMesLetra[$mes-1]."'";
	}
	
	$lblEtiquetas="[".$lblEtiquetas."]";
	$arrDataSets="";
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		
		
		
		$arrDatosDatSet="";
		foreach($resto["carpetasMes"] as $mes=>$totalMes)
		{
			if($arrDatosDatSet=="")
				$arrDatosDatSet=$resto["carpetasMes"][$mes];
			else
				$arrDatosDatSet.=",".$resto["carpetasMes"][$mes];
		}
		
		
		$oDataSet=" {
						label: '".cv($resto["nombreUnidad"])."',
						borderColor: '#".$resto["colorAsociado"]."',
						backgroundColor: color('#".$resto["colorAsociado"]."').alpha(0.8).rgbString(),
						borderColor: '#".$resto["colorAsociado"]."',
						borderWidth: 2,
						fill: false,
						lineTension:0,
						pointBorderWidth:2,
						datalabels: {
										align: 'end',
										anchor: 'end'
									},
						data: 	[
									".$arrDatosDatSet."
								]
					}";
		
		if($arrDataSets=="")
			$arrDataSets=$oDataSet;
		else
			$arrDataSets.=",".$oDataSet;
	}	
	
	
	
	
	?>
        <div id="container" style="width: 90%;">
            <canvas id="canvas"></canvas>
        </div>
        <script>
        
        var color = Chart.helpers.color;
        var horizontalBarChartData = {
                                        labels: <?php echo $lblEtiquetas?>,
                                        datasets: [
                                                    
                                                    <?php
														echo $arrDataSets
													?>
                                        
                                                ]
                            
                                    };
    
          var ctx = document.getElementById('canvas').getContext('2d');
            window.myGrafico = new Chart(ctx, {
                                                        type: 'bar',
                                                        data: horizontalBarChartData,
                                                        plugins: [ChartDataLabels],
                                                        
                                                        options: {
                                                                    responsive: true,
                                                                    
                                                                    legend: {
                                                                                position: 'bottom'
                                                                                
                                                                            },
                                                                    title: {
                                                                                display: true,
                                                                                fontSize:14,
                                                                                text: 'Carpetas de investigación recibidas por mes'
                                                                            },
                                                                    scales: {
                                                                                xAxes: [
                                                                                            {
                                                                                                display: true,
                                                                                                ticks:	{
                                                                                                            autoSkip: false/*,
                                                                                                            maxRotation: 90,
                                                                                                            minRotation: 90*/
                                                                                                        }
                                                                                            }
                                                                                        ],
                                                                                yAxes: 	[
                                                                                            {
                                                                                                display: true
                                                                                            }
                                                                                        ]
                                                                            }
                                                                }
                                                    }
                                                );
    
        
    
        
        </script>
	<?php
	echo "<br><br><div class='SeparadorSeccion'>Número de Carpetas Judiciales con o sin detenido</div><br>";
	
	$consulta="SELECT COUNT(*) FROM _46_tablaDinamica s,7006_carpetasAdministrativas c WHERE c.fechaCreacion>='".$periodoInicio."' 
				AND c.fechaCreacion<='".$periodoFinal."  23:59:59' and c.carpetaAdministrativa=s.carpetaAdministrativa 
				and idEstado>1.4 AND tipoAudiencia=26";

	$totalConDetenido=$con->obtenerValor($consulta);
	
	
	$consulta="SELECT COUNT(*) FROM _46_tablaDinamica s,7006_carpetasAdministrativas c WHERE c.fechaCreacion>='".$periodoInicio."' 
				AND c.fechaCreacion<='".$periodoFinal."  23:59:59' and c.carpetaAdministrativa=s.carpetaAdministrativa 
				and idEstado>1.4 AND tipoAudiencia=1";
	$totalSinDetenido=$con->obtenerValor($consulta);
	
	$tblReporte='<table class="tblTablaDatos">
					<tr>
						<td width="250">
							<b>TIPO DE JUDICIALIZACI&Oacute;N</b>
						</td>
						<td width="150">
							<b>N&Uacute;MERO DE CAUSAS</b>
						</td>
					</tr>
					<tr>
						<td width="150">
							CON DETENIDO
						</td>
						<td width="150" align="center">
							'.number_format($totalConDetenido).'
							
						</td>
					</tr>
					<tr>
						<td width="150">
							SIN DETENIDO
						</td>
						<td width="150" align="center">
							'.number_format($totalSinDetenido).'
						</td>
					</tr>
					<tr>
						<td width="150">
							<b>TOTAL GENERAL</b>
						</td>
						<td width="150" align="center">
							'.number_format($totalConDetenido+$totalSinDetenido).'
						</td>
					</tr>
						';
	
	$tblReporte.='</table><br><br>';
	
	echo $tblReporte;	
	
	
	$lblEtiquetas="['SIN DETENIDO','CON DETENIDO']";
	
	
	$dataSet1=$totalSinDetenido.",".$totalConDetenido;
	$totalGlobal=$totalSinDetenido +$totalConDetenido;
	?>	
      <br><br>
      <div id="container2" style="width: 65%;">
          <canvas id="canvas2" ></canvas>
      </div>
      <br><br>
      <script>
      
      var horizontalBarChartData = {
                                      labels: <?php echo $lblEtiquetas?>,
                                      datasets: [
                                                  {
                                                      label: '',
                                                      backgroundColor: [color('#0080FF').alpha(0.7).rgbString(),color('#990000').alpha(0.7).rgbString()],
                                                      datalabels: 	{
																		align: 'end',
																		anchor: 'end'
																		
																	},
                                                      borderWidth: 1,
                                                      
                                                      data: 	[
                                                                  <?php echo $dataSet1?>
                                                              ]
                                                  }
                                      
                                              ]
                          
                                  };

          var ctx = document.getElementById('canvas2').getContext('2d');
          window.myHorizontalBar = new Chart(ctx, {
                                                      type: 'pie',
                                                      data: horizontalBarChartData,
                                                      plugins: [ChartDataLabels],
                                                      options: {
														  		 layout: {
																			padding: {
																						left: 10,
																						right: 10,
																						top: 10,
																						bottom: 10
																					}
																		},
														  		plugins:	{
																				datalabels: {
																									formatter: function(value, context) 
																									{
																										var porcentaje=0;
																										if(context.dataIndex==context.chart.data.datasets[0].data.length-1)
																										{
																											var x;
																											var total=0;
																											for(x=0;x<context.chart.data.datasets[0].data.length-1;x++)
																											{
																												porcentaje=(context.chart.data.datasets[0].data[x]/<?php echo $totalGlobal ?>)*100;
																												porcentaje=porcentaje.toFixed(2);
																												total+=porcentaje;
																											}
																											porcentaje=100-total;
																											porcentaje=porcentaje.toFixed(2);
																										}
																										else
																										{
																											porcentaje=(value/<?php echo $totalGlobal ?>)*100;
																											porcentaje=porcentaje.toFixed(2);
																										}
	
																										return  context.chart.data.labels[context.dataIndex]+' ('+value+') '+porcentaje+'%';
																									}
																							},
																			},
                                                                  indexAxis: 'y',
                                                                  // Elements options apply to all of the options unless overridden in a dataset
                                                                  // In this case, we are setting the border of each horizontal bar to be 2px wide
                                                                  elements: {
                                                                                  bar: {
                                                                                          borderWidth: 2,
                                                                                      }
                                                                              },
                                                                  responsive: true,
																  
                                                                  legend: {
                                                                              position: 'bottom',
																			  display: false,
                                                                              labels:	{
                                                                                         
                                                                                      }
                                                                          },
                                                                  title: {
                                                                              display: true,
                                                                              fontSize:14,
																			  padding:40,
                                                                              text: 'Número de Carpetas Judiciales con o sin detenido'
                                                                          }
                                                              }
                                                  }
                                              );

      

    
      
      </script>
	<?php
	
	echo "<br><br><div class='SeparadorSeccion'>Número de Carpetas Judiciales con o sin detenido por Unidad de Gesti&oacute;n</div><br>";
	
	
	$tblReporte='<table class="tblTablaDatos">
					<tr>
						<td width="250">
							<b>UNIDAD DE GESTI&Oacute;N</b>
						</td>
						<td width="150">
							<b>CON DETENIDO</b>
						</td>
						<td width="150">
							<b>SIN DETENIDO</b>
						</td>
					</tr>';
	$tGlobalCD=0;
	$tGlobalSD=0;
	$consulta="SELECT id__17_tablaDinamica,claveUnidad,nombreUnidad FROM _17_tablaDinamica u,_17_tiposCarpetasAdministra tC WHERE cmbCategoria=1
			and tC.idPadre=u.id__17_tablaDinamica and tC.idOpcion=1 ORDER BY prioridad";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT COUNT(*) FROM _46_tablaDinamica s,7006_carpetasAdministrativas c WHERE c.fechaCreacion>='".$periodoInicio."' 
				AND c.fechaCreacion<='".$periodoFinal."  23:59:59' and c.unidadGestion='".$fila[1]."' and c.carpetaAdministrativa=s.carpetaAdministrativa 
				and idEstado>1.4 AND tipoAudiencia=26";

		$totalConDetenido=$con->obtenerValor($consulta);
		$tGlobalCD+=$totalConDetenido;
		
		$consulta="SELECT COUNT(*) FROM _46_tablaDinamica s,7006_carpetasAdministrativas c WHERE c.fechaCreacion>='".$periodoInicio."' 
					AND c.fechaCreacion<='".$periodoFinal."  23:59:59' and c.unidadGestion='".$fila[1]."' and c.carpetaAdministrativa=s.carpetaAdministrativa 
					and idEstado>1.4 AND tipoAudiencia=1";
		$totalSinDetenido=$con->obtenerValor($consulta);
		$tGlobalSD+=$totalSinDetenido;
		$tblReporte.= '<tr><td>'.$fila[2].'</td><td>'.$totalConDetenido.'</td><td>'.$totalSinDetenido.'</td></tr>';
	}
	$tblReporte.='<tr>
						<td width="250">
							<b>TOTAL</b>
						</td>
						<td width="150">
							<b>'.$tGlobalCD.'</b>
						</td>
						<td width="150">
							<b>'.$tGlobalSD.'</b>
						</td>
					</tr>
					</table><br><br>';
	
	echo $tblReporte;	
	
	$consulta="SELECT COUNT(*) FROM _46_tablaDinamica s,7006_carpetasAdministrativas c WHERE c.fechaCreacion>='".$periodoInicio."' 
				AND c.fechaCreacion<='".$periodoFinal."  23:59:59' and c.carpetaAdministrativa=s.carpetaAdministrativa 
				and idEstado>1.4 AND tipoAudiencia=26";

	$totalConDetenido=$con->obtenerValor($consulta);
	
	
	$consulta="SELECT COUNT(*) FROM _46_tablaDinamica s,7006_carpetasAdministrativas c WHERE c.fechaCreacion>='".$periodoInicio."' 
				AND c.fechaCreacion<='".$periodoFinal."  23:59:59' and c.carpetaAdministrativa=s.carpetaAdministrativa 
				and idEstado>1.4 AND tipoAudiencia=1";
	$totalSinDetenido=$con->obtenerValor($consulta);
	
	
	
	echo "<div class='SeparadorSeccion'>Número de casos en los que se declara la legalidad de la detención y la no legalidad de la detención</div><br>";
	
	$tblReporte='<table class="tblTablaDatos">
					<tr>
						<td width="450">
							<b>UGJ</b>
						</td>
						<td width="150">
							<b>LEGAL DETENCIÓN</b>
						</td>
						<td width="150">
							<b>NO LEGAL DETENCIÓN</b>
						</td>
					</tr>';
	
	
	$granTotalIlegalidad=0;
	$granTotalLegalidad=0;
	
	$arrLegalidad=array();
	
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		
		$totalIlegalidad=0;
		$totalLegalidad=0;
		$listaCarpetas="";
		$consulta="SELECT c.carpetaAdministrativa FROM _46_tablaDinamica s,7006_carpetasAdministrativas c WHERE  
					c.fechaCreacion>='".$periodoInicio."' AND c.fechaCreacion<='".$periodoFinal.
				"  23:59:59' AND tipoAudiencia=26 and idEstado>1.4 and	c.carpetaAdministrativa=s.carpetaAdministrativa
				AND c.unidadGestion='".$unidadGestion."' ";
		$listaCarpetas=$con->obtenerListaValores($consulta,"'");
		if($listaCarpetas=="")
			$listaCarpetas=-1;
		$arrCentroGestion[$unidadGestion]["listadoCarpetas"]=$listaCarpetas;
		
		$totalControles=$con->filasAfectadas;
		
		if($listaCarpetas=="")
			$listaCarpetas=-1;
		$consulta="SELECT COUNT(*) FROM 7007_contenidosCarpetaAdministrativa c,3013_registroResolutivosAudiencia r 
					WHERE carpetaAdministrativa IN(".$listaCarpetas.") and c.tipoContenido=3 AND r.idEvento=
					c.idRegistroContenidoReferencia AND r.tipoResolutivo=82";
		$totalIlegalidad=$con->obtenerValor($consulta);
		$totalLegalidad=$totalControles-$totalIlegalidad;
		
		$arrLegalidad[$unidadGestion]["totalLegalidad"]=$totalLegalidad;
		$arrLegalidad[$unidadGestion]["totalIlegalidad"]=$totalIlegalidad;
		
		
		$tblReporte.='	<tr>	
							<td >
								'.$resto["nombreUnidad"].'
							</td>
							<td  align="center">
							'.number_format($totalLegalidad).'
							</td>
							<td  align="center">
							'.number_format($totalIlegalidad).'
							</td>
						</tr>
						';
		$granTotalIlegalidad+=	$totalIlegalidad;
		$granTotalLegalidad+=	$totalLegalidad;		
	}
	
	$tblReporte.='	<tr>	
						<td >
							<b>TOTAL GENERAL</b>
						</td>
						<td  align="center">
						'.number_format($granTotalLegalidad).'
						</td>
						<td  align="center">
						'.number_format($granTotalIlegalidad).'
						</td>
					</tr>
					';
	
	$tblReporte.='</table><br><br>';
	
	echo $tblReporte;	
	
	
	
	$lblEtiquetas="['LEGAL DETENCIÓN','NO LEGAL DETENCIÓN']";
	$arrDatosDatSet="";
	$arrDataSets="";
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		
		
		
		
		$oDataSet=" {
						label: '".cv($resto["nombreUnidad"])."',
						borderColor: '#".$resto["colorAsociado"]."',
						backgroundColor: color('#".$resto["colorAsociado"]."').alpha(0.8).rgbString(),
						borderWidth: 2,
						fill: false,
						lineTension:0,
						pointBorderWidth:2,
						datalabels: {
										align: 'end',
										anchor: 'end'
									},
						data: 	[
									".$arrLegalidad[$unidadGestion]["totalLegalidad"].",".$arrLegalidad[$unidadGestion]["totalIlegalidad"]."
								]
					}";
		
		if($arrDataSets=="")
			$arrDataSets=$oDataSet;
		else
			$arrDataSets.=",".$oDataSet;
		
	}
	
	
		
		
		
	
	

	?>
        <div id="container3" style="width: 90%;">
            <canvas id="canvas3"></canvas>
        </div>
        <script>
        

        horizontalBarChartData = {
                                        labels: <?php echo $lblEtiquetas?>,
                                        datasets: [
                                                    
                                                    <?php
														echo $arrDataSets
													?>
                                        
                                                ]
                            
                                    };
    
          ctx = document.getElementById('canvas3').getContext('2d');
            window.myGrafico = new Chart(ctx, {
                                                        type: 'bar',
                                                        data: horizontalBarChartData,
                                                        plugins: [ChartDataLabels],
                                                        
                                                        options: {
                                                                    responsive: true,
                                                                    
                                                                    legend: {
                                                                                position: 'bottom'
                                                                                
                                                                            },
                                                                    title: {
                                                                                display: true,
                                                                                fontSize:14,
																				padding:40,
                                                                                text: 'Número de casos en los que se declara la legalidad de la detención y la no legalidad de la detención'
                                                                            },
                                                                    scales: {
                                                                                xAxes: [
                                                                                            {
                                                                                                display: true,
                                                                                                ticks:	{
                                                                                                            autoSkip: false/*,
                                                                                                            maxRotation: 90,
                                                                                                            minRotation: 90*/
                                                                                                        }
                                                                                            }
                                                                                        ],
                                                                                yAxes: 	[
                                                                                            {
                                                                                                display: true
                                                                                            }
                                                                                        ]
                                                                            }
                                                                }
                                                    }
                                                );
    
        
    
        
        </script>
        <?php
	echo "<div class='SeparadorSeccion'>Número de vinculación a proceso</div><br>";
	
	$tblReporte='<table class="tblTablaDatos">
					<tr>
						<td width="450">
							<b>UGJ</b>
						</td>
						<td width="150">
							<b>NÚMERO DE CAUSAS</b>
						</td>
						
					</tr>';
	
	
	
	$granTotal=0;
	$arrResultados=array();
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		
		$listaCarpetas=$arrCentroGestion[$unidadGestion]["listadoCarpetas"];
			
		$consulta="SELECT COUNT(*) FROM 7007_contenidosCarpetaAdministrativa c,3013_registroResolutivosAudiencia r 
					WHERE carpetaAdministrativa IN(".$listaCarpetas.") and c.tipoContenido=3 AND r.idEvento=
					c.idRegistroContenidoReferencia AND r.tipoResolutivo=50 and valor='1'";
		$total=$con->obtenerValor($consulta);
		
		
		$arrResultados[$unidadGestion]["total"]=$total;
		
		
		
		$tblReporte.='	<tr>	
							<td >
								'.$resto["nombreUnidad"].'
							</td>
							<td  align="center">
							'.number_format($total).'
							</td>
							
						</tr>
						';
		$granTotal+=	$total;
			
	}
	
	$tblReporte.='	<tr>	
						<td >
							<b>TOTAL GENERAL</b>
						</td>
						<td  align="center">
						'.number_format($granTotal).'
						</td>
						
					</tr>
					';
	
	$tblReporte.='</table><br><br>';
	
	echo $tblReporte;	
	
	
	
	$lblEtiquetas="";
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		if($lblEtiquetas=="")
			$lblEtiquetas="'".$resto["nombreUnidad"]."'";
		else
			$lblEtiquetas.=",'".$resto["nombreUnidad"]."'";
		
	}
	$lblEtiquetas="[".$lblEtiquetas."]";
	$dataSet1="";
	$colores="";
	
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		if($dataSet1=="")
		{
			$dataSet1=$arrResultados[$unidadGestion]["total"];
			$colores="'#".$resto["colorAsociado"]."'";
		}
		else
		{
			$dataSet1.=",".$arrResultados[$unidadGestion]["total"];
			$colores.=",'#".$resto["colorAsociado"]."'";
		}
	}
	$colores="[".$colores."]";
	
	?>
        <div id="container4" style="width: 90%;">
            <canvas id="canvas4"></canvas>
        </div>
        <script>
        

        horizontalBarChartData = {
                                        labels: <?php echo $lblEtiquetas?>,
                                        datasets: 	[
                                                    	{
															  label: 'Unidades de Gestión Judicial',
															  backgroundColor: <?php echo $colores?>,
															  borderColor: <?php echo $colores?>,
															  borderWidth: 1,
															  datalabels: {
																				align: 'end',
																				anchor: 'end'
																			},
															  data: 	[
																		  <?php echo $dataSet1?>
																	  ]
														  }
                                                   
                                        
                                                	]
                            
                                    };
    
          ctx = document.getElementById('canvas4').getContext('2d');
            window.myGrafico = new Chart(ctx, {
                                                        type: 'bar',
                                                        data: horizontalBarChartData,
                                                        plugins: [ChartDataLabels],
                                                        
                                                        options: {
                                                                    responsive: true,
                                                                    
                                                                    legend: {
                                                                                position: 'bottom',
																				display: false
                                                                                
                                                                            },
                                                                    title: {
                                                                                display: true,
                                                                                fontSize:14,
																				padding:40,
                                                                                text: 'Número de vinculación a proceso'
                                                                            },
                                                                    scales: {
                                                                                xAxes: [
                                                                                            {
                                                                                                display: true,
                                                                                                ticks:	{
                                                                                                            autoSkip: false/*,
                                                                                                            maxRotation: 90,
                                                                                                            minRotation: 90*/
                                                                                                        }
                                                                                            }
                                                                                        ],
                                                                                yAxes: 	[
                                                                                            {
                                                                                                display: true
                                                                                            }
                                                                                        ]
                                                                            }
                                                                }
                                                    }
                                                );
    
        
    
        
        </script>
        <?php
	echo "<div class='SeparadorSeccion'>Número de procedimientos abreviados concretados</div><br>";
	
	$tblReporte='<table class="tblTablaDatos">
					<tr>
						<td width="450">
							<b>UGJ</b>
						</td>
						<td width="150">
							<b>NÚMERO</b>
						</td>
						
					</tr>';
	
	
	
	$granTotal=0;
	$arrResultados=array();
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		
		
		
		$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE fechaCreacion>='".$periodoInicio."' 
						AND fechaCreacion<='".$periodoFinal." 23:59:59' and carpetaAdministrativaBase 
						IN(SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='".$unidadGestion.
					"' AND tipoCarpetaAdministrativa=1) AND tipoCarpetaAdministrativa=6";

		$total=$con->obtenerValor($consulta);
		$arrResultados[$unidadGestion]["total"]=$total;
		
		
		
		$tblReporte.='	<tr>	
							<td >
								'.$resto["nombreUnidad"].'
							</td>
							<td  align="center">
							'.number_format($total).'
							</td>
							
						</tr>
						';
		$granTotal+=	$total;
			
	}
	
	$tblReporte.='	<tr>	
						<td >
							<b>TOTAL GENERAL</b>
						</td>
						<td  align="center">
						'.number_format($granTotal).'
						</td>
						
					</tr>
					';
	
	$tblReporte.='</table><br><br>';
	
	echo $tblReporte;	
	
	
	
	
	$lblEtiquetas="";
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		if($lblEtiquetas=="")
			$lblEtiquetas="'".$resto["nombreUnidad"]."'";
		else
			$lblEtiquetas.=",'".$resto["nombreUnidad"]."'";
		

	}
	$lblEtiquetas="[".$lblEtiquetas."]";
	$dataSet1="";
	$colores="";
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		
		if($dataSet1=="")
		{
			$dataSet1=$arrResultados[$unidadGestion]["total"];
			$colores="'#".$resto["colorAsociado"]."'";
		}
		else
		{
			$dataSet1.=",".$arrResultados[$unidadGestion]["total"];
			$colores.=",'#".$resto["colorAsociado"]."'";
		}
		
		
		
	}
	$colores="[".$colores."]";
	?>
        <div id="container5" style="width: 90%;">
            <canvas id="canvas5"></canvas>
        </div>
        <script>
        

        horizontalBarChartData = {
                                        labels: <?php echo $lblEtiquetas?>,
                                        datasets: 	[
                                                    	{
															  label: 'Unidades de Gestión Judicial',
															  backgroundColor: <?php echo $colores?>,
															  borderColor: <?php echo $colores?>,
															  borderWidth: 1,
															  datalabels: {
																				align: 'end',
																				anchor: 'end'
																			},
															  data: 	[
																		  <?php echo $dataSet1?>
																	  ]
														  }
                                                   
                                        
                                                	]
                            
                                    };
    
          ctx = document.getElementById('canvas5').getContext('2d');
            window.myGrafico = new Chart(ctx, {
                                                        type: 'bar',
                                                        data: horizontalBarChartData,
                                                        plugins: [ChartDataLabels],
                                                        
                                                        options: {
                                                                    responsive: true,
                                                                    
                                                                    legend: {
                                                                                position: 'bottom',
																				display: false
                                                                                
                                                                            },
                                                                    title: {
                                                                                display: true,
                                                                                fontSize:14,
																				padding:40,
                                                                                text: 'Número de procedimientos abreviados concretados'
                                                                            },
                                                                    scales: {
                                                                                xAxes: [
                                                                                            {
                                                                                                display: true,
                                                                                                ticks:	{
                                                                                                            autoSkip: false/*,
                                                                                                            maxRotation: 90,
                                                                                                            minRotation: 90*/
                                                                                                        }
                                                                                            }
                                                                                        ],
                                                                                yAxes: 	[
                                                                                            {
                                                                                                display: true
                                                                                            }
                                                                                        ]
                                                                            }
                                                                }
                                                    }
                                                );
    
        
    
        
        </script>
        <?php
	echo "<div class='SeparadorSeccion'>Número de vinculaciones a proceso en las que se dictaron medidas cautelares</div><br>";
	
	$tblReporte='<table class="tblTablaDatos">
					<tr>
						<td width="450">
							<b>UGJ</b>
						</td>
						<td width="150">
							<b>NÚMERO</b>
						</td>
						
					</tr>';
	
	
	
	$granTotal=0;
	$arrResultados=array();
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		
		$listaCarpetas=$arrCentroGestion[$unidadGestion]["listadoCarpetas"];
			
			
		
		$consulta="SELECT COUNT(distinct c.idRegistroContenidoReferencia) FROM 7007_contenidosCarpetaAdministrativa c,
				3013_registroResolutivosAudiencia r,3014_registroMedidasCautelares m 
					WHERE carpetaAdministrativa IN(".$listaCarpetas.") and c.tipoContenido=3 AND r.idEvento=
					c.idRegistroContenidoReferencia AND r.tipoResolutivo=50 and valor='1'
					and m.idEventoAudiencia=c.idRegistroContenidoReferencia";

		$total=$con->obtenerValor($consulta);
		
		
		$arrResultados[$unidadGestion]["total"]=$total;
		
		
		
		$tblReporte.='	<tr>	
							<td >
								'.$resto["nombreUnidad"].'
							</td>
							<td  align="center">
							'.number_format($total).'
							</td>
							
						</tr>
						';
		$granTotal+=	$total;
			
	}
	
	$tblReporte.='	<tr>	
						<td >
							<b>TOTAL GENERAL</b>
						</td>
						<td  align="center">
						'.number_format($granTotal).'
						</td>
						
					</tr>
					';
	
	$tblReporte.='</table><br><br>';
	
	echo $tblReporte;	
	
	
	
	$dataSet1="";
	$lblEtiquetas="";
	$colores="";
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		if($dataSet1=="")
		{
			$dataSet1=$arrResultados[$unidadGestion]["total"];
			$colores="'#".$resto["colorAsociado"]."'";
			$lblEtiquetas="'".cv($resto["nombreUnidad"])."'";
		}
		else
		{
			$dataSet1.=",".$arrResultados[$unidadGestion]["total"];
			$colores.=",'#".$resto["colorAsociado"]."'";
			$lblEtiquetas.=",'".cv($resto["nombreUnidad"])."'";
		}
		
	}
	$lblEtiquetas="[".$lblEtiquetas."]";
	$colores="[".$colores."]";
	?>
        <div id="container6" style="width: 90%;">
            <canvas id="canvas6"></canvas>
        </div>
        <script>
        

        horizontalBarChartData = {
                                        labels: <?php echo $lblEtiquetas?>,
                                        datasets: 	[
                                                    	{
															  label: 'Unidades de Gestión Judicial',
															  backgroundColor: <?php echo $colores?>,
															  borderColor: <?php echo $colores?>,
															  borderWidth: 1,
															  datalabels: {
																				align: 'end',
																				anchor: 'end'
																			},
															  data: 	[
																		  <?php echo $dataSet1?>
																	  ]
														  }
                                                   
                                        
                                                	]
                            
                                    };
    
          ctx = document.getElementById('canvas6').getContext('2d');
            window.myGrafico = new Chart(ctx, {
                                                        type: 'bar',
                                                        data: horizontalBarChartData,
                                                        plugins: [ChartDataLabels],
                                                        
                                                        options: {
                                                                    responsive: true,
                                                                    
                                                                    legend: {
                                                                                position: 'bottom',
																				display: false
                                                                                
                                                                            },
                                                                    title: {
                                                                                display: true,
                                                                                fontSize:14,
																				padding:40,
                                                                                text: 'Número de vinculaciones a proceso en las que se dictaron medidas cautelares'
                                                                            },
                                                                    scales: {
                                                                                xAxes: [
                                                                                            {
                                                                                                display: true,
                                                                                                ticks:	{
                                                                                                            autoSkip: false/*,
                                                                                                            maxRotation: 90,
                                                                                                            minRotation: 90*/
                                                                                                        }
                                                                                            }
                                                                                        ],
                                                                                yAxes: 	[
                                                                                            {
                                                                                                display: true
                                                                                            }
                                                                                        ]
                                                                            }
                                                                }
                                                    }
                                                );
    
        
    
        
        </script>
        <?php
	echo "<div class='SeparadorSeccion'>Número de acuerdos reparatorios</div><br>";
	
	$tblReporte='<table class="tblTablaDatos">
					<tr>
						<td width="450">
							<b>UGJ</b>
						</td>
						<td width="150">
							<b>NÚMERO</b>
						</td>
						
					</tr>';
	
	
	
	$granTotal=0;
	$arrResultados=array();
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		
		$listaCarpetas=$arrCentroGestion[$unidadGestion]["listadoCarpetas"];
			
		$consulta="SELECT COUNT(distinct c.idRegistroContenidoReferencia) FROM 7007_contenidosCarpetaAdministrativa c,3014_registroAcuerdosReparatorios r
					 WHERE carpetaAdministrativa IN(".$listaCarpetas.") and c.tipoContenido=3 AND r.idEvento=
					c.idRegistroContenidoReferencia AND r.acuerdoAprobado=1";
		$total=$con->obtenerValor($consulta);
		
		
		$arrResultados[$unidadGestion]["total"]=$total;
		
		
		
		$tblReporte.='	<tr>	
							<td >
								'.$resto["nombreUnidad"].'
							</td>
							<td  align="center">
							'.number_format($total).'
							</td>
							
						</tr>
						';
		$granTotal+=	$total;
			
	}
	
	$tblReporte.='	<tr>	
						<td >
							<b>TOTAL GENERAL</b>
						</td>
						<td  align="center">
						'.number_format($granTotal).'
						</td>
						
					</tr>
					';
	
	$tblReporte.='</table><br><br>';
	
	echo $tblReporte;	
	
	
	
	
	$dataSet1="";
	$lblEtiquetas="";
	$colores="";
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		if($dataSet1=="")
		{
			$dataSet1=$arrResultados[$unidadGestion]["total"];
			$colores="'#".$resto["colorAsociado"]."'";
			$lblEtiquetas="'".cv($resto["nombreUnidad"])."'";
		}
		else
		{
			$dataSet1.=",".$arrResultados[$unidadGestion]["total"];
			$colores.=",'#".$resto["colorAsociado"]."'";
			$lblEtiquetas.=",'".cv($resto["nombreUnidad"])."'";
		}
		
	}
	$lblEtiquetas="[".$lblEtiquetas."]";
	$colores="[".$colores."]";
	
	
	?>
        <div id="container7" style="width: 90%;">
            <canvas id="canvas7"></canvas>
        </div>
        <script>
        

        horizontalBarChartData = {
                                        labels: <?php echo $lblEtiquetas?>,
                                        datasets: 	[
                                                    	{
															  label: 'Unidades de Gestión Judicial',
															  backgroundColor: <?php echo $colores?>,
															  borderColor: <?php echo $colores?>,
															  borderWidth: 1,
															  datalabels: {
																				align: 'end',
																				anchor: 'end'
																			},
															  data: 	[
																		  <?php echo $dataSet1?>
																	  ]
														  }
                                                   
                                        
                                                	]
                            
                                    };
    
          ctx = document.getElementById('canvas7').getContext('2d');
            window.myGrafico = new Chart(ctx, {
                                                        type: 'bar',
                                                        data: horizontalBarChartData,
                                                        plugins: [ChartDataLabels],
                                                        
                                                        options: {
                                                                    responsive: true,
                                                                    
                                                                    legend: {
                                                                                position: 'bottom',
																				display: false
                                                                                
                                                                            },
                                                                    title: {
                                                                                display: true,
                                                                                fontSize:14,
																				padding:40,
                                                                                text: 'Número de acuerdos reparatorios'
                                                                            },
                                                                    scales: {
                                                                                xAxes: [
                                                                                            {
                                                                                                display: true,
                                                                                                ticks:	{
                                                                                                            autoSkip: false/*,
                                                                                                            maxRotation: 90,
                                                                                                            minRotation: 90*/
                                                                                                        }
                                                                                            }
                                                                                        ],
                                                                                yAxes: 	[
                                                                                            {
                                                                                                display: true
                                                                                            }
                                                                                        ]
                                                                            }
                                                                }
                                                    }
                                                );
    
        
    
        
        </script>
        <?php
	echo "<div class='SeparadorSeccion'>Número de suspensiones condicionales del proceso</div><br>";
	
	$tblReporte='<table class="tblTablaDatos">
					<tr>
						<td width="450">
							<b>UGJ</b>
						</td>
						<td width="150">
							<b>NÚMERO</b>
						</td>
						
					</tr>';
	
	
	
	$granTotal=0;
	$arrResultados=array();
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		
		$listaCarpetas=$arrCentroGestion[$unidadGestion]["listadoCarpetas"];
			
		$consulta="SELECT COUNT(*) FROM 7007_contenidosCarpetaAdministrativa c,3013_registroResolutivosAudiencia r 
					WHERE carpetaAdministrativa IN(".$listaCarpetas.") and c.tipoContenido=3 AND r.idEvento=
					c.idRegistroContenidoReferencia AND r.tipoResolutivo=10";
		$total=$con->obtenerValor($consulta);
		
		
		$arrResultados[$unidadGestion]["total"]=$total;
		
		
		
		$tblReporte.='	<tr>	
							<td >
								'.$resto["nombreUnidad"].'
							</td>
							<td  align="center">
							'.number_format($total).'
							</td>
							
						</tr>
						';
		$granTotal+=	$total;
			
	}
	
	$tblReporte.='	<tr>	
						<td >
							<b>TOTAL GENERAL</b>
						</td>
						<td  align="center">
						'.number_format($granTotal).'
						</td>
						
					</tr>
					';
	
	$tblReporte.='</table><br><br>';
	
	echo $tblReporte;	
	
	
	
	$dataSet1="";
	$lblEtiquetas="";
	$colores="";
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		if($dataSet1=="")
		{
			$dataSet1=$arrResultados[$unidadGestion]["total"];
			$colores="'#".$resto["colorAsociado"]."'";
			$lblEtiquetas="'".cv($resto["nombreUnidad"])."'";
		}
		else
		{
			$dataSet1.=",".$arrResultados[$unidadGestion]["total"];
			$colores.=",'#".$resto["colorAsociado"]."'";
			$lblEtiquetas.=",'".cv($resto["nombreUnidad"])."'";
		}
		
	}
	$lblEtiquetas="[".$lblEtiquetas."]";
	$colores="[".$colores."]";
	
			
	?>
        <div id="container8" style="width: 90%;">
            <canvas id="canvas8"></canvas>
        </div>
        <script>
        

        horizontalBarChartData = {
                                        labels: <?php echo $lblEtiquetas?>,
                                        datasets: 	[
                                                    	{
															  label: 'Unidades de Gestión Judicial',
															  backgroundColor: <?php echo $colores?>,
															  borderColor: <?php echo $colores?>,
															  borderWidth: 1,
															  datalabels: {
																				align: 'end',
																				anchor: 'end'
																			},
															  data: 	[
																		  <?php echo $dataSet1?>
																	  ]
														  }
                                                   
                                        
                                                	]
                            
                                    };
    
          ctx = document.getElementById('canvas8').getContext('2d');
            window.myGrafico = new Chart(ctx, {
                                                        type: 'bar',
                                                        data: horizontalBarChartData,
                                                        plugins: [ChartDataLabels],
                                                        
                                                        options: {
                                                                    responsive: true,
                                                                    
                                                                    legend: {
                                                                                position: 'bottom',
																				display: false
                                                                                
                                                                            },
                                                                    title: {
                                                                                display: true,
                                                                                fontSize:14,
																				padding:40,
                                                                                text: 'Número de suspensiones condicionales del proceso'
                                                                            },
                                                                    scales: {
                                                                                xAxes: [
                                                                                            {
                                                                                                display: true,
                                                                                                ticks:	{
                                                                                                            autoSkip: false/*,
                                                                                                            maxRotation: 90,
                                                                                                            minRotation: 90*/
                                                                                                        }
                                                                                            }
                                                                                        ],
                                                                                yAxes: 	[
                                                                                            {
                                                                                                display: true
                                                                                            }
                                                                                        ]
                                                                            }
                                                                }
                                                    }
                                                );
    
        
    
        
        </script>
        <?php
	echo "<div class='SeparadorSeccion'>Número de carpetas que llegan a audiencia intermedia</div><br>";
	
	$tblReporte='<table class="tblTablaDatos">
					<tr>
						<td width="450">
							<b>UGJ</b>
						</td>
						<td width="150">
							<b>NÚMERO</b>
						</td>
						
					</tr>';
	
	
	
	$granTotal=0;
	$arrResultados=array();
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		
		$listaCarpetas=$arrCentroGestion[$unidadGestion]["listadoCarpetas"];
			
		$consulta="SELECT COUNT(distinct c.carpetaAdministrativa) FROM 7007_contenidosCarpetaAdministrativa c,7000_eventosAudiencia e 
					WHERE carpetaAdministrativa IN(".$listaCarpetas.") and c.tipoContenido=3 AND e.idRegistroEvento=
					c.idRegistroContenidoReferencia and e.tipoAudiencia=15 and e.situacion in (1,2,4,5)";
		$total=$con->obtenerValor($consulta);
		
		
		$arrResultados[$unidadGestion]["total"]=$total;
		
		
		
		$tblReporte.='	<tr>	
							<td >
								'.$resto["nombreUnidad"].'
							</td>
							<td  align="center">
							'.number_format($total).'
							</td>
							
						</tr>
						';
		$granTotal+=	$total;
			
	}
	
	$tblReporte.='	<tr>	
						<td >
							<b>TOTAL GENERAL</b>
						</td>
						<td  align="center">
						'.number_format($granTotal).'
						</td>
						
					</tr>
					';
	
	$tblReporte.='</table><br><br>';
	
	echo $tblReporte;	
	
	
	$dataSet1="";
	$lblEtiquetas="";
	$colores="";
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		if($dataSet1=="")
		{
			$dataSet1=$arrResultados[$unidadGestion]["total"];
			$colores="'#".$resto["colorAsociado"]."'";
			$lblEtiquetas="'".cv($resto["nombreUnidad"])."'";
		}
		else
		{
			$dataSet1.=",".$arrResultados[$unidadGestion]["total"];
			$colores.=",'#".$resto["colorAsociado"]."'";
			$lblEtiquetas.=",'".cv($resto["nombreUnidad"])."'";
		}
		
	}
	$lblEtiquetas="[".$lblEtiquetas."]";
	$colores="[".$colores."]";
			
	?>
        <div id="container9" style="width: 90%;">
            <canvas id="canvas9"></canvas>
        </div>
        <script>
        

        horizontalBarChartData = {
                                        labels: <?php echo $lblEtiquetas?>,
                                        datasets: 	[
                                                    	{
															  label: 'Unidades de Gestión Judicial',
															  backgroundColor: <?php echo $colores?>,
															  borderColor: <?php echo $colores?>,
															  borderWidth: 1,
															  datalabels: {
																				align: 'end',
																				anchor: 'end'
																			},
															  data: 	[
																		  <?php echo $dataSet1?>
																	  ]
														  }
                                                   
                                        
                                                	]
                            
                                    };
    
          ctx = document.getElementById('canvas9').getContext('2d');
            window.myGrafico = new Chart(ctx, {
                                                        type: 'bar',
                                                        data: horizontalBarChartData,
                                                        plugins: [ChartDataLabels],
                                                        
                                                        options: {
                                                                    responsive: true,
                                                                    
                                                                    legend: {
                                                                                position: 'bottom',
																				display: false
                                                                                
                                                                            },
                                                                    title: {
                                                                                display: true,
                                                                                fontSize:14,
																				padding:40,
                                                                                text: 'Número de carpetas que llegan a audiencia intermedia'
                                                                            },
                                                                    scales: {
                                                                                xAxes: [
                                                                                            {
                                                                                                display: true,
                                                                                                ticks:	{
                                                                                                            autoSkip: false/*,
                                                                                                            maxRotation: 90,
                                                                                                            minRotation: 90*/
                                                                                                        }
                                                                                            }
                                                                                        ],
                                                                                yAxes: 	[
                                                                                            {
                                                                                                display: true
                                                                                            }
                                                                                        ]
                                                                            }
                                                                }
                                                    }
                                                );
    
        
    
        
        </script>
        <?php
	echo "<br><br><div class='SeparadorSeccion'>Número de carpetas que llegaron a juicio oral</div><br>";
	
	$tblReporte='<table class="tblTablaDatos">
					<tr>
						<td width="450">
							<b>UGJ</b>
						</td>
						<td width="150">
							<b>NÚMERO</b>
						</td>
						
					</tr>';
	
	
	
	$granTotal=0;
	$arrResultados=array();
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		
		$listaCarpetas=$arrCentroGestion[$unidadGestion]["listadoCarpetas"];
			
		$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas
					WHERE carpetaAdministrativaBase IN(".$listaCarpetas.") and tipoCarpetaAdministrativa=5";
		$total=$con->obtenerValor($consulta);
		
		
		$arrResultados[$unidadGestion]["total"]=$total;
		
		
		
		$tblReporte.='	<tr>	
							<td >
								'.$resto["nombreUnidad"].'
							</td>
							<td  align="center">
							'.number_format($total).'
							</td>
							
						</tr>
						';
		$granTotal+=	$total;
			
	}
	
	$tblReporte.='	<tr>	
						<td >
							<b>TOTAL GENERAL</b>
						</td>
						<td  align="center">
						'.number_format($granTotal).'
						</td>
						
					</tr>
					';
	
	$tblReporte.='</table><br><br>';
	
	echo $tblReporte;	
	
	$dataSet1="";
	$lblEtiquetas="";
	$colores="";
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		if($dataSet1=="")
		{
			$dataSet1=$arrResultados[$unidadGestion]["total"];
			$colores="'#".$resto["colorAsociado"]."'";
			$lblEtiquetas="'".cv($resto["nombreUnidad"])."'";
		}
		else
		{
			$dataSet1.=",".$arrResultados[$unidadGestion]["total"];
			$colores.=",'#".$resto["colorAsociado"]."'";
			$lblEtiquetas.=",'".cv($resto["nombreUnidad"])."'";
		}
		
	}
	$lblEtiquetas="[".$lblEtiquetas."]";
	$colores="[".$colores."]";
	
	?>
        <div id="container10" style="width: 90%;">
            <canvas id="canvas10"></canvas>
        </div>
        <script>
        

        horizontalBarChartData = {
                                        labels: <?php echo $lblEtiquetas?>,
                                        datasets: 	[
                                                    	{
															  label: 'Unidades de Gestión Judicial',
															  backgroundColor: <?php echo $colores?>,
															  borderColor: <?php echo $colores?>,
															  borderWidth: 1,
															  datalabels: {
																				align: 'end',
																				anchor: 'end'
																			},
															  data: 	[
																		  <?php echo $dataSet1?>
																	  ]
														  }
                                                   
                                        
                                                	]
                            
                                    };
    
          ctx = document.getElementById('canvas10').getContext('2d');
            window.myGrafico = new Chart(ctx, {
                                                        type: 'bar',
                                                        data: horizontalBarChartData,
                                                        plugins: [ChartDataLabels],
                                                        
                                                        options: {
                                                                    responsive: true,
                                                                    
                                                                    legend: {
                                                                                position: 'bottom',
																				display: false
                                                                                
                                                                            },
                                                                    title: {
                                                                                display: true,
                                                                                fontSize:14,
																				padding:40,
                                                                                text: 'Número de carpetas que llegaron a juicio oral'
                                                                            },
                                                                    scales: {
                                                                                xAxes: [
                                                                                            {
                                                                                                display: true,
                                                                                                ticks:	{
                                                                                                            autoSkip: false/*,
                                                                                                            maxRotation: 90,
                                                                                                            minRotation: 90*/
                                                                                                        }
                                                                                            }
                                                                                        ],
                                                                                yAxes: 	[
                                                                                            {
                                                                                                display: true
                                                                                            }
                                                                                        ]
                                                                            }
                                                                }
                                                    }
                                                );
    
        
    
        
        </script>
        <?php
	echo "<div class='SeparadorSeccion'>Número de sentencias absolutorias y condenatorias</div><br>";
	
	$tblReporte='<table class="tblTablaDatos">
					<tr>
						<td width="450">
							<b>UGJ</b>
						</td>
						<td width="150">
							<b>ABSOLUTORIAS</b>
						</td>
						<td width="150">
							<b>CONDENATORIAS</b>
						</td>
					</tr>';
	
	
	$granTotalAbsolutorio=0;
	$granTotalCondenatorio=0;
	
	$arrLegalidad=array();
	
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		
		$totalAbsolutoria=0;
		$totalCondenatoria=0;
		$listaCarpetas=$arrCentroGestion[$unidadGestion]["listadoCarpetas"];
		
		
		$consulta="SELECT COUNT(*) FROM 7007_contenidosCarpetaAdministrativa c,3013_registroResolutivosAudiencia r 
					WHERE carpetaAdministrativa IN(".$listaCarpetas.") and c.tipoContenido=3 AND r.idEvento=
					c.idRegistroContenidoReferencia AND r.tipoResolutivo=92";
		$totalAbsolutoria=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 7007_contenidosCarpetaAdministrativa c,3013_registroResolutivosAudiencia r 
					WHERE carpetaAdministrativa IN(".$listaCarpetas.") and c.tipoContenido=3 AND r.idEvento=
					c.idRegistroContenidoReferencia AND r.tipoResolutivo in(24,93)";
		$totalCondenatoria=$con->obtenerValor($consulta);
		
		$arrLegalidad[$unidadGestion]["totalAbsolutoria"]=$totalAbsolutoria;
		$arrLegalidad[$unidadGestion]["totalCondenatoria"]=$totalCondenatoria;
		
		
		$tblReporte.='	<tr>	
							<td >
								'.$resto["nombreUnidad"].'
							</td>
							<td  align="center">
							'.number_format($totalAbsolutoria).'
							</td>
							<td  align="center">
							'.number_format($totalCondenatoria).'
							</td>
						</tr>
						';
		$granTotalAbsolutorio+=	$totalAbsolutoria;
		$granTotalCondenatorio+=	$totalCondenatoria;		
	}
	
	$tblReporte.='	<tr>	
						<td >
							<b>TOTAL GENERAL</b>
						</td>
						<td  align="center">
						'.number_format($granTotalAbsolutorio).'
						</td>
						<td  align="center">
						'.number_format($granTotalCondenatorio).'
						</td>
					</tr>
					';
	
	$tblReporte.='</table><br><br>';
	
	echo $tblReporte;	
	
	
	
	
	
	$lblEtiquetas="['ABSOLUTORIAS','CONDENATORIAS']";
	$arrDatosDatSet="";
	$arrDataSets="";
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		
		
		
		
		$oDataSet=" {
						label: '".cv($resto["nombreUnidad"])."',
						borderColor: '#".$resto["colorAsociado"]."',
						backgroundColor: color('#".$resto["colorAsociado"]."').alpha(0.7).rgbString(),
						borderWidth: 2,
						fill: false,
						lineTension:0,
						pointBorderWidth:2,
						datalabels: {
										align: 'end',
										anchor: 'end'
									},
						data: 	[
									".$arrLegalidad[$unidadGestion]["totalAbsolutoria"].",".$arrLegalidad[$unidadGestion]["totalCondenatoria"]."
								]
					}";
		
		if($arrDataSets=="")
			$arrDataSets=$oDataSet;
		else
			$arrDataSets.=",".$oDataSet;
		
	}
	
	?>
        <div id="container11" style="width: 90%;">
            <canvas id="canvas11"></canvas>
        </div>
        <script>
        

        horizontalBarChartData = {
                                        labels: <?php echo $lblEtiquetas?>,
                                        datasets: 	[
                                                    	<?php
														echo $arrDataSets;
														?>
                                                   
                                        
                                                	]
                            
                                    };
    
          ctx = document.getElementById('canvas11').getContext('2d');
            window.myGrafico = new Chart(ctx, {
                                                        type: 'bar',
                                                        data: horizontalBarChartData,
                                                        plugins: [ChartDataLabels],
                                                        
                                                        options: {
                                                                    responsive: true,
                                                                    
                                                                    legend: {
                                                                                position: 'bottom',
																				display: false
                                                                                
                                                                            },
                                                                    title: {
                                                                                display: true,
                                                                                fontSize:14,
																				padding:40,
                                                                                text: 'Número de sentencias absolutorias y condenatorias'
                                                                            },
                                                                    scales: {
                                                                                xAxes: [
                                                                                            {
                                                                                                display: true,
                                                                                                ticks:	{
                                                                                                            autoSkip: false/*,
                                                                                                            maxRotation: 90,
                                                                                                            minRotation: 90*/
                                                                                                        }
                                                                                            }
                                                                                        ],
                                                                                yAxes: 	[
                                                                                            {
                                                                                                display: true
                                                                                            }
                                                                                        ]
                                                                            }
                                                                }
                                                    }
                                                );
    
        
    
        
        </script>
        <?php
	echo "<br><br><div class='SeparadorSeccion'>Número de carpetas que se turnan a jueces de ejecución</div><br>";
		
	$tblReporte='<table class="tblTablaDatos">
					<tr>
						<td width="450">
							<b>UGJ</b>
						</td>
						<td width="150">
							<b>NÚMERO</b>
						</td>
						
					</tr>';
	
	
	
	$granTotal=0;
	$arrResultados=array();
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='".$unidadGestion."' AND tipoCarpetaAdministrativa=1";
		$listaCarpetas=$con->obtenerListaValores($consulta,"'");
		if($listaCarpetas=="")
			$listaCarpetas=-1;
		$consulta="	SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativaBase IN(".$listaCarpetas.")
				AND tipoCarpetaAdministrativa=5";
		$listaCarpetasTribunal=$con->obtenerListaValores($consulta,"'");
		if($listaCarpetasTribunal=="")
			$listaCarpetasTribunal=-1;	
		$listaCarpetas.=",".$listaCarpetasTribunal;		
		
		
		$consulta="SELECT COUNT(DISTINCT carpetaAdministrativa) FROM 7006_carpetasAdministrativas c
					WHERE c.fechaCreacion>='".$periodoInicio."' AND c.fechaCreacion<='".$periodoFinal."' 
					AND  carpetaAdministrativaBase in (".$listaCarpetas.") AND tipoCarpetaAdministrativa=6";
		$total=$con->obtenerValor($consulta);
		
		
		$arrResultados[$unidadGestion]["total"]=$total;
		
		
		
		$tblReporte.='	<tr>	
							<td >
								'.$resto["nombreUnidad"].'
							</td>
							<td  align="center">
							'.number_format($total).'
							</td>
							
						</tr>
						';
		$granTotal+=	$total;
			
	}
	
	$tblReporte.='	<tr>	
						<td >
							<b>TOTAL GENERAL</b>
						</td>
						<td  align="center">
						'.number_format($granTotal).'
						</td>
						
					</tr>
					';
	
	$tblReporte.='</table><br><br>';
	
	echo $tblReporte;	
	
	
	
	$dataSet1="";
	$lblEtiquetas="";
	$colores="";
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		if($dataSet1=="")
		{
			$dataSet1=$arrResultados[$unidadGestion]["total"];
			$colores="'#".$resto["colorAsociado"]."'";
			$lblEtiquetas="'".cv($resto["nombreUnidad"])."'";
		}
		else
		{
			$dataSet1.=",".$arrResultados[$unidadGestion]["total"];
			$colores.=",'#".$resto["colorAsociado"]."'";
			$lblEtiquetas.=",'".cv($resto["nombreUnidad"])."'";
		}
		
	}
	$lblEtiquetas="[".$lblEtiquetas."]";
	$colores="[".$colores."]";
	
	?>
        <div id="container12" style="width: 90%;">
            <canvas id="canvas12"></canvas>
        </div>
        <script>
        

        horizontalBarChartData = {
                                        labels: <?php echo $lblEtiquetas?>,
                                        datasets: 	[
                                                    	{
															  label: 'Unidades de Gestión Judicial',
															  backgroundColor: <?php echo $colores?>,
															  borderColor: <?php echo $colores?>,
															  borderWidth: 1,
															  datalabels: {
																				align: 'end',
																				anchor: 'end'
																			},
															  data: 	[
																		  <?php echo $dataSet1?>
																	  ]
														  }
                                                   
                                        
                                                	]
                            
                                    };
    
          ctx = document.getElementById('canvas12').getContext('2d');
            window.myGrafico = new Chart(ctx, {
                                                        type: 'bar',
                                                        data: horizontalBarChartData,
                                                        plugins: [ChartDataLabels],
                                                        
                                                        options: {
                                                                    responsive: true,
                                                                    
                                                                    legend: {
                                                                                position: 'bottom',
																				display: false
                                                                                
                                                                            },
                                                                    title: {
                                                                                display: true,
                                                                                fontSize:14,
																				padding:40,
                                                                                text: 'Número de carpetas que se turnan a jueces de ejecución'
                                                                            },
                                                                    scales: {
                                                                                xAxes: [
                                                                                            {
                                                                                                display: true,
                                                                                                ticks:	{
                                                                                                            autoSkip: false/*,
                                                                                                            maxRotation: 90,
                                                                                                            minRotation: 90*/
                                                                                                        }
                                                                                            }
                                                                                        ],
                                                                                yAxes: 	[
                                                                                            {
                                                                                                display: true
                                                                                            }
                                                                                        ]
                                                                            }
                                                                }
                                                    }
                                                );
    
        
    
        
        </script>
        <?php
	$consulta="SELECT COUNT(*) FROM _46_tablaDinamica s,7006_carpetasAdministrativas c WHERE c.fechaCreacion>='".$periodoInicio."' 
				AND c.fechaCreacion<='".$periodoFinal."  23:59:59' and c.carpetaAdministrativa=s.carpetaAdministrativa 
				and idEstado>1.4 AND tipoAudiencia=91";

	$total=$con->obtenerValor($consulta);
	
	
	echo "<br><br><div class='SeparadorSeccion'>Número de Incompetencias solicitadas</div><br>";
		
	$tblReporte='<table class="tblTablaDatos">
					<tr>
						<td width="450">
							<b>UGJ</b>
						</td>
						<td width="150">
							<b>NÚMERO</b>
						</td>
						
					</tr>';
	
	
	
	$granTotal=0;
	$arrResultados=array();
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		
		
			
		$consulta="SELECT COUNT(DISTINCT s.carpetaAdministrativa) FROM 7006_carpetasAdministrativas c, _46_tablaDinamica s 
					WHERE s.fechaCreacion>='".$periodoInicio."' AND s.fechaCreacion<='".$periodoFinal."' AND  s.carpetaRemitida=c.carpetaAdministrativa 
					AND idEstado>=1.4 AND s.tipoAudiencia=91  AND c.unidadGestion='".$unidadGestion."'";
		$total=$con->obtenerValor($consulta);
		
		
		$arrResultados[$unidadGestion]["total"]=$total;
		
		
		
		$tblReporte.='	<tr>	
							<td >
								'.$resto["nombreUnidad"].'
							</td>
							<td  align="center">
							'.number_format($total).'
							</td>
							
						</tr>
						';
		$granTotal+=	$total;
			
	}
	
	$tblReporte.='	<tr>	
						<td >
							<b>TOTAL GENERAL</b>
						</td>
						<td  align="center">
						'.number_format($granTotal).'
						</td>
						
					</tr>
					';
	
	$tblReporte.='</table><br><br>';
	
	echo $tblReporte;	
	
	
	
	
	
	
	$dataSet1="";
	$lblEtiquetas="";
	$colores="";
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		if($dataSet1=="")
		{
			$dataSet1=$arrResultados[$unidadGestion]["total"];
			$colores="'#".$resto["colorAsociado"]."'";
			$lblEtiquetas="'".cv($resto["nombreUnidad"])."'";
		}
		else
		{
			$dataSet1.=",".$arrResultados[$unidadGestion]["total"];
			$colores.=",'#".$resto["colorAsociado"]."'";
			$lblEtiquetas.=",'".cv($resto["nombreUnidad"])."'";
		}
		
	}
	$lblEtiquetas="[".$lblEtiquetas."]";
	$colores="[".$colores."]";
	
	?>
        <div id="container13" style="width: 90%;">
            <canvas id="canvas13"></canvas>
        </div>
        <script>
        

        horizontalBarChartData = {
                                        labels: <?php echo $lblEtiquetas?>,
                                        datasets: 	[
                                                    	{
															  label: 'Unidades de Gestión Judicial',
															  backgroundColor: <?php echo $colores?>,
															  borderColor: <?php echo $colores?>,
															  borderWidth: 1,
															  datalabels: {
																				align: 'end',
																				anchor: 'end'
																			},
															  data: 	[
																		  <?php echo $dataSet1?>
																	  ]
														  }
                                                   
                                        
                                                	]
                            
                                    };
    
          ctx = document.getElementById('canvas13').getContext('2d');
            window.myGrafico = new Chart(ctx, {
                                                        type: 'bar',
                                                        data: horizontalBarChartData,
                                                        plugins: [ChartDataLabels],
                                                        
                                                        options: {
                                                                    responsive: true,
                                                                    
                                                                    legend: {
                                                                                position: 'bottom',
																				display: false
                                                                                
                                                                            },
                                                                    title: {
                                                                                display: true,
                                                                                fontSize:14,
																				padding:40,
                                                                                text: 'Número de Incompetencias solicitadas'
                                                                            },
                                                                    scales: {
                                                                                xAxes: [
                                                                                            {
                                                                                                display: true,
                                                                                                ticks:	{
                                                                                                            autoSkip: false/*,
                                                                                                            maxRotation: 90,
                                                                                                            minRotation: 90*/
                                                                                                        }
                                                                                            }
                                                                                        ],
                                                                                yAxes: 	[
                                                                                            {
                                                                                                display: true
                                                                                            }
                                                                                        ]
                                                                            }
                                                                }
                                                    }
                                                );
    
        
    
        
        </script>
	<?php
	
	
	
	$consulta="SELECT COUNT(*) FROM _46_tablaDinamica s,7006_carpetasAdministrativas c WHERE c.fechaCreacion>='".$periodoInicio."' 
				AND c.fechaCreacion<='".$periodoFinal."  23:59:59' and c.carpetaAdministrativa=s.carpetaAdministrativa 
				and idEstado>1.4 AND tipoAudiencia=91";

	$total=$con->obtenerValor($consulta);
	
	echo "<br><br><div class='SeparadorSeccion'>Número de Determinaciones del Ministerio Público que agravien a la víctima solicitadas</div><br>";
		
	$tblReporte='<table class="tblTablaDatos">
					<tr>
						<td width="450">
							<b>UGJ</b>
						</td>
						<td width="150">
							<b>NÚMERO</b>
						</td>
						
					</tr>';
	
	
	
	$granTotal=0;
	$arrResultados=array();
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		
		
			
		$consulta="SELECT COUNT(DISTINCT c.carpetaAdministrativa) FROM 7006_carpetasAdministrativas c, _46_tablaDinamica s 
					WHERE c.fechaCreacion>='".$periodoInicio."' AND c.fechaCreacion<='".$periodoFinal."' AND  s.carpetaAdministrativa=c.carpetaAdministrativa 
					AND idEstado>=1.4 AND s.tipoAudiencia=8  AND c.unidadGestion='".$unidadGestion."'";
		$total=$con->obtenerValor($consulta);		
		$arrResultados[$unidadGestion]["total"]=$total;
		
		
		
		$tblReporte.='	<tr>	
							<td >
								'.$resto["nombreUnidad"].'
							</td>
							<td  align="center">
							'.number_format($total).'
							</td>
							
						</tr>
						';
		$granTotal+=	$total;
			
	}
	
	$tblReporte.='	<tr>	
						<td >
							<b>TOTAL GENERAL</b>
						</td>
						<td  align="center">
						'.number_format($granTotal).'
						</td>
						
					</tr>
					';
	
	$tblReporte.='</table><br><br>';
	
	echo $tblReporte;	
	
	
	
	$dataSet1="";
	$lblEtiquetas="";
	$colores="";
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		if($dataSet1=="")
		{
			$dataSet1=$arrResultados[$unidadGestion]["total"];
			$colores="'#".$resto["colorAsociado"]."'";
			$lblEtiquetas="'".cv($resto["nombreUnidad"])."'";
		}
		else
		{
			$dataSet1.=",".$arrResultados[$unidadGestion]["total"];
			$colores.=",'#".$resto["colorAsociado"]."'";
			$lblEtiquetas.=",'".cv($resto["nombreUnidad"])."'";
		}
		
	}
	$lblEtiquetas="[".$lblEtiquetas."]";
	$colores="[".$colores."]";
	
	?>
        <div id="container14" style="width: 90%;">
            <canvas id="canvas14"></canvas>
        </div>
        <script>
        

        horizontalBarChartData = {
                                        labels: <?php echo $lblEtiquetas?>,
                                        datasets: 	[
                                                    	{
															  label: 'Unidades de Gestión Judicial',
															  backgroundColor: <?php echo $colores?>,
															  borderColor: <?php echo $colores?>,
															  borderWidth: 1,
															  datalabels: {
																				align: 'end',
																				anchor: 'end'
																			},
															  data: 	[
																		  <?php echo $dataSet1?>
																	  ]
														  }
                                                   
                                        
                                                	]
                            
                                    };
    
          ctx = document.getElementById('canvas14').getContext('2d');
            window.myGrafico = new Chart(ctx, {
                                                        type: 'bar',
                                                        data: horizontalBarChartData,
                                                        plugins: [ChartDataLabels],
                                                        
                                                        options: {
                                                                    responsive: true,
                                                                    
                                                                    legend: {
                                                                                position: 'bottom',
																				display: false
                                                                                
                                                                            },
                                                                    title: {
                                                                                display: true,
                                                                                fontSize:14,
																				padding:40,
                                                                                text: 'Número de Determinaciones del Ministerio Público que agravien a la víctima solicitadas'
                                                                            },
                                                                    scales: {
                                                                                xAxes: [
                                                                                            {
                                                                                                display: true,
                                                                                                ticks:	{
                                                                                                            autoSkip: false/*,
                                                                                                            maxRotation: 90,
                                                                                                            minRotation: 90*/
                                                                                                        }
                                                                                            }
                                                                                        ],
                                                                                yAxes: 	[
                                                                                            {
                                                                                                display: true
                                                                                            }
                                                                                        ]
                                                                            }
                                                                }
                                                    }
                                                );
    
        
    
        
        </script>
	<?php
	$consulta="SELECT COUNT(*) FROM _46_tablaDinamica s,7006_carpetasAdministrativas c WHERE c.fechaCreacion>='".$periodoInicio."' 
				AND c.fechaCreacion<='".$periodoFinal."  23:59:59' and c.carpetaAdministrativa=s.carpetaAdministrativa 
				and idEstado>1.4 AND tipoAudiencia=91";

	$total=$con->obtenerValor($consulta);
	
	echo "<div class='SeparadorSeccion'>Número de Ordenes de Aprehensión</div><br>";
	
	$tblReporte='<table class="tblTablaDatos">
					<tr>
						<td width="450">
							<b>UGJ</b>
						</td>
						<td width="150">
							<b>NÚMERO</b>
						</td>
						
					</tr>';
	
	
	
	$granTotal=0;
	$arrResultados=array();

	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		
		$listaCarpetas=$arrCentroGestion[$unidadGestion]["listadoGlobalCarpetas"];
			
		$consulta="SELECT COUNT(distinct r.idEvento) FROM 7007_contenidosCarpetaAdministrativa c,3013_registroResolutivosAudiencia r 
					WHERE carpetaAdministrativa IN(".$listaCarpetas.") and c.tipoContenido=3 AND r.idEvento=
					c.idRegistroContenidoReferencia AND r.tipoResolutivo in (7,14,48) and valor='1'";
		$total=$con->obtenerValor($consulta);
		
		
		$arrResultados[$unidadGestion]["total"]=$total;
		
		
		
		$tblReporte.='	<tr>	
							<td >
								'.$resto["nombreUnidad"].'
							</td>
							<td  align="center">
							'.number_format($total).'
							</td>
							
						</tr>
						';
		$granTotal+=	$total;
			
	}
	
	$tblReporte.='	<tr>	
						<td >
							<b>TOTAL GENERAL</b>
						</td>
						<td  align="center">
						'.number_format($granTotal).'
						</td>
						
					</tr>
					';
	
	$tblReporte.='</table><br><br>';
	
	echo $tblReporte;	
	
	
	
	$dataSet1="";
	$lblEtiquetas="";
	$colores="";
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		if($dataSet1=="")
		{
			$dataSet1=$arrResultados[$unidadGestion]["total"];
			$colores="'#".$resto["colorAsociado"]."'";
			$lblEtiquetas="'".cv($resto["nombreUnidad"])."'";
		}
		else
		{
			$dataSet1.=",".$arrResultados[$unidadGestion]["total"];
			$colores.=",'#".$resto["colorAsociado"]."'";
			$lblEtiquetas.=",'".cv($resto["nombreUnidad"])."'";
		}
		
	}
	$lblEtiquetas="[".$lblEtiquetas."]";
	$colores="[".$colores."]";
	
	?>
        <div id="container15" style="width: 90%;">
            <canvas id="canvas15"></canvas>
        </div>
        <script>
        

        horizontalBarChartData = {
                                        labels: <?php echo $lblEtiquetas?>,
                                        datasets: 	[
                                                    	{
															  label: 'Unidades de Gestión Judicial',
															  backgroundColor: <?php echo $colores?>,
															  borderColor: <?php echo $colores?>,
															  borderWidth: 1,
															  datalabels: {
																				align: 'end',
																				anchor: 'end'
																			},
															  data: 	[
																		  <?php echo $dataSet1?>
																	  ]
														  }
                                                   
                                        
                                                	]
                            
                                    };
    
          ctx = document.getElementById('canvas15').getContext('2d');
            window.myGrafico = new Chart(ctx, {
                                                        type: 'bar',
                                                        data: horizontalBarChartData,
                                                        plugins: [ChartDataLabels],
                                                        
                                                        options: {
                                                                    responsive: true,
                                                                    
                                                                    legend: {
                                                                                position: 'bottom',
																				display: false
                                                                                
                                                                            },
                                                                    title: {
                                                                                display: true,
                                                                                fontSize:14,
																				padding:40,
                                                                                text: 'Número de Ordenes de Aprehensión'
                                                                            },
                                                                    scales: {
                                                                                xAxes: [
                                                                                            {
                                                                                                display: true,
                                                                                                ticks:	{
                                                                                                            autoSkip: false/*,
                                                                                                            maxRotation: 90,
                                                                                                            minRotation: 90*/
                                                                                                        }
                                                                                            }
                                                                                        ],
                                                                                yAxes: 	[
                                                                                            {
                                                                                                display: true
                                                                                            }
                                                                                        ]
                                                                            }
                                                                }
                                                    }
                                                );
    
        
    
        
        </script>
	<?php
	echo "<br><br><div class='SeparadorSeccion'>Número de Medidas de Protección</div><br>";
		
	$tblReporte='<table class="tblTablaDatos">
					<tr>
						<td width="450">
							<b>UGJ</b>
						</td>
						<td width="150">
							<b>NÚMERO</b>
						</td>
						
					</tr>';
	
	
	
	$granTotal=0;
	$arrResultados=array();
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		
		
			
		$consulta="SELECT COUNT(DISTINCT c.carpetaAdministrativa) FROM 7006_carpetasAdministrativas c, _46_tablaDinamica s 
					WHERE c.fechaCreacion>='".$periodoInicio."' AND c.fechaCreacion<='".$periodoFinal."' AND  
					s.carpetaAdministrativa=c.carpetaAdministrativa 
					AND idEstado>=1.4 AND s.tipoAudiencia=52  AND c.unidadGestion='".$unidadGestion."'";
		$total=$con->obtenerValor($consulta);		
		$arrResultados[$unidadGestion]["total"]=$total;
		
		
		
		$tblReporte.='	<tr>	
							<td >
								'.$resto["nombreUnidad"].'
							</td>
							<td  align="center">
							'.number_format($total).'
							</td>
							
						</tr>
						';
		$granTotal+=	$total;
			
	}
	
	$tblReporte.='	<tr>	
						<td >
							<b>TOTAL GENERAL</b>
						</td>
						<td  align="center">
						'.number_format($granTotal).'
						</td>
						
					</tr>
					';
	
	$tblReporte.='</table><br><br>';
	
	echo $tblReporte;	
	
	
	
	$dataSet1="";
	$lblEtiquetas="";
	$colores="";
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		if($dataSet1=="")
		{
			$dataSet1=$arrResultados[$unidadGestion]["total"];
			$colores="'#".$resto["colorAsociado"]."'";
			$lblEtiquetas="'".cv($resto["nombreUnidad"])."'";
		}
		else
		{
			$dataSet1.=",".$arrResultados[$unidadGestion]["total"];
			$colores.=",'#".$resto["colorAsociado"]."'";
			$lblEtiquetas.=",'".cv($resto["nombreUnidad"])."'";
		}
		
	}
	$lblEtiquetas="[".$lblEtiquetas."]";
	$colores="[".$colores."]";
	
	?>
        <div id="container16" style="width: 90%;">
            <canvas id="canvas16"></canvas>
        </div>
        <script>
        

        horizontalBarChartData = {
                                        labels: <?php echo $lblEtiquetas?>,
                                        datasets: 	[
                                                    	{
															  label: 'Unidades de Gestión Judicial',
															  backgroundColor: <?php echo $colores?>,
															  borderColor: <?php echo $colores?>,
															  borderWidth: 1,
															  datalabels: {
																				align: 'end',
																				anchor: 'end'
																			},
															  data: 	[
																		  <?php echo $dataSet1?>
																	  ]
														  }
                                                   
                                        
                                                	]
                            
                                    };
    
          ctx = document.getElementById('canvas16').getContext('2d');
            window.myGrafico = new Chart(ctx, {
                                                        type: 'bar',
                                                        data: horizontalBarChartData,
                                                        plugins: [ChartDataLabels],
                                                        
                                                        options: {
                                                                    responsive: true,
                                                                    
                                                                    legend: {
                                                                                position: 'bottom',
																				display: false
                                                                                
                                                                            },
                                                                    title: {
                                                                                display: true,
                                                                                fontSize:14,
																				padding:40,
                                                                                text: 'Número de Medidas de Protección'
                                                                            },
                                                                    scales: {
                                                                                xAxes: [
                                                                                            {
                                                                                                display: true,
                                                                                                ticks:	{
                                                                                                            autoSkip: false/*,
                                                                                                            maxRotation: 90,
                                                                                                            minRotation: 90*/
                                                                                                        }
                                                                                            }
                                                                                        ],
                                                                                yAxes: 	[
                                                                                            {
                                                                                                display: true
                                                                                            }
                                                                                        ]
                                                                            }
                                                                }
                                                    }
                                                );
    
        
    
        
        </script>
	<?php
	$consulta="SELECT COUNT(*) FROM _46_tablaDinamica s,7006_carpetasAdministrativas c WHERE c.fechaCreacion>='".$periodoInicio."' 
				AND c.fechaCreacion<='".$periodoFinal."  23:59:59' and c.carpetaAdministrativa=s.carpetaAdministrativa 
				and idEstado>1.4 AND tipoAudiencia=91";

	$total=$con->obtenerValor($consulta);
	
	echo "<div class='SeparadorSeccion'>Número de Ordenes de Cateo</div><br>";
	
	$tblReporte='<table class="tblTablaDatos">
					<tr>
						<td width="450">
							<b>UGJ</b>
						</td>
						<td width="150">
							<b>NÚMERO</b>
						</td>
						
					</tr>';
	
	
	
	$granTotal=0;
	$arrResultados=array();

	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		
		$listaCarpetas=$arrCentroGestion[$unidadGestion]["listadoGlobalCarpetas"];
			
		$consulta="SELECT COUNT(distinct r.idEvento) FROM 7007_contenidosCarpetaAdministrativa c,3013_registroResolutivosAudiencia r 
					WHERE carpetaAdministrativa IN(".$listaCarpetas.") and c.tipoContenido=3 AND r.idEvento=
					c.idRegistroContenidoReferencia AND r.tipoResolutivo in (47) and valor='1'";
		$total=$con->obtenerValor($consulta);
		
		
		$arrResultados[$unidadGestion]["total"]=$total;
		
		
		
		$tblReporte.='	<tr>	
							<td >
								'.$resto["nombreUnidad"].'
							</td>
							<td  align="center">
							'.number_format($total).'
							</td>
							
						</tr>
						';
		$granTotal+=	$total;
			
	}
	
	$tblReporte.='	<tr>	
						<td >
							<b>TOTAL GENERAL</b>
						</td>
						<td  align="center">
						'.number_format($granTotal).'
						</td>
						
					</tr>
					';
	
	$tblReporte.='</table><br><br>';
	
	echo $tblReporte;	
	
	
	
	$dataSet1="";
	$lblEtiquetas="";
	$colores="";
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		if($dataSet1=="")
		{
			$dataSet1=$arrResultados[$unidadGestion]["total"];
			$colores="'#".$resto["colorAsociado"]."'";
			$lblEtiquetas="'".cv($resto["nombreUnidad"])."'";
		}
		else
		{
			$dataSet1.=",".$arrResultados[$unidadGestion]["total"];
			$colores.=",'#".$resto["colorAsociado"]."'";
			$lblEtiquetas.=",'".cv($resto["nombreUnidad"])."'";
		}
		
	}
	$lblEtiquetas="[".$lblEtiquetas."]";
	$colores="[".$colores."]";
	
	?>
        <div id="container17" style="width: 90%;">
            <canvas id="canvas17"></canvas>
        </div>
        <script>
        

        horizontalBarChartData = {
                                        labels: <?php echo $lblEtiquetas?>,
                                        datasets: 	[
                                                    	{
															  label: 'Unidades de Gestión Judicial',
															  backgroundColor: <?php echo $colores?>,
															  borderColor: <?php echo $colores?>,
															  borderWidth: 1,
															  datalabels: {
																				align: 'end',
																				anchor: 'end'
																			},
															  data: 	[
																		  <?php echo $dataSet1?>
																	  ]
														  }
                                                   
                                        
                                                	]
                            
                                    };
    
          ctx = document.getElementById('canvas17').getContext('2d');
            window.myGrafico = new Chart(ctx, {
                                                        type: 'bar',
                                                        data: horizontalBarChartData,
                                                        plugins: [ChartDataLabels],
                                                        
                                                        options: {
                                                                    responsive: true,
                                                                    
                                                                    legend: {
                                                                                position: 'bottom',
																				display: false
                                                                                
                                                                            },
                                                                    title: {
                                                                                display: true,
                                                                                fontSize:14,
																				padding:40,
                                                                                text: 'Número de Ordenes de Cateo'
                                                                            },
                                                                    scales: {
                                                                                xAxes: [
                                                                                            {
                                                                                                display: true,
                                                                                                ticks:	{
                                                                                                            autoSkip: false/*,
                                                                                                            maxRotation: 90,
                                                                                                            minRotation: 90*/
                                                                                                        }
                                                                                            }
                                                                                        ],
                                                                                yAxes: 	[
                                                                                            {
                                                                                                display: true
                                                                                            }
                                                                                        ]
                                                                            }
                                                                }
                                                    }
                                                );
    
        
    
        
        </script>
        <?php
	echo "<div class='SeparadorSeccion'>Número de Toma de Muestras</div><br>";
	
	$tblReporte='<table class="tblTablaDatos">
					<tr>
						<td width="450">
							<b>UGJ</b>
						</td>
						<td width="150">
							<b>NÚMERO</b>
						</td>
						
					</tr>';
	
	
	
	$granTotal=0;
	$arrResultados=array();

	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		
		$listaCarpetas=$arrCentroGestion[$unidadGestion]["listadoGlobalCarpetas"];
			
		$consulta="SELECT COUNT(distinct r.idEvento) FROM 7007_contenidosCarpetaAdministrativa c,3013_registroResolutivosAudiencia r 
					WHERE carpetaAdministrativa IN(".$listaCarpetas.") and c.tipoContenido=3 AND r.idEvento=
					c.idRegistroContenidoReferencia AND r.tipoResolutivo in (111) and valor='1'";
		$total=$con->obtenerValor($consulta);
		
		
		$arrResultados[$unidadGestion]["total"]=$total;
		
		
		
		$tblReporte.='	<tr>	
							<td >
								'.$resto["nombreUnidad"].'
							</td>
							<td  align="center">
							'.number_format($total).'
							</td>
							
						</tr>
						';
		$granTotal+=	$total;
			
	}
	
	$tblReporte.='	<tr>	
						<td >
							<b>TOTAL GENERAL</b>
						</td>
						<td  align="center">
						'.number_format($granTotal).'
						</td>
						
					</tr>
					';
	
	$tblReporte.='</table><br><br>';
	
	echo $tblReporte;	
	
	
	$dataSet1="";
	$lblEtiquetas="";
	$colores="";
	foreach($arrCentroGestion as $unidadGestion=>$resto)
	{
		if($dataSet1=="")
		{
			$dataSet1=$arrResultados[$unidadGestion]["total"];
			$colores="'#".$resto["colorAsociado"]."'";
			$lblEtiquetas="'".cv($resto["nombreUnidad"])."'";
		}
		else
		{
			$dataSet1.=",".$arrResultados[$unidadGestion]["total"];
			$colores.=",'#".$resto["colorAsociado"]."'";
			$lblEtiquetas.=",'".cv($resto["nombreUnidad"])."'";
		}
		
	}
	$lblEtiquetas="[".$lblEtiquetas."]";
	$colores="[".$colores."]";
	
	?>
        <div id="container18" style="width: 90%;">
            <canvas id="canvas18"></canvas>
        </div>
        <script>
        

        horizontalBarChartData = {
                                        labels: <?php echo $lblEtiquetas?>,
                                        datasets: 	[
                                                    	{
															  label: 'Unidades de Gestión Judicial',
															  backgroundColor: <?php echo $colores?>,
															  borderColor: <?php echo $colores?>,
															  borderWidth: 1,
															  datalabels: {
																				align: 'end',
																				anchor: 'end'
																			},
															  data: 	[
																		  <?php echo $dataSet1?>
																	  ]
														  }
                                                   
                                        
                                                	]
                            
                                    };
    
          ctx = document.getElementById('canvas18').getContext('2d');
            window.myGrafico = new Chart(ctx, {
                                                        type: 'bar',
                                                        data: horizontalBarChartData,
                                                        plugins: [ChartDataLabels],
                                                        
                                                        options: {
                                                                    responsive: true,
                                                                    
                                                                    legend: {
                                                                                position: 'bottom',
																				display: false
                                                                                
                                                                            },
                                                                    title: {
                                                                                display: true,
                                                                                fontSize:14,
																				padding:40,
                                                                                text: 'Número de Toma de Muestras'
                                                                            },
                                                                    scales: {
                                                                                xAxes: [
                                                                                            {
                                                                                                display: true,
                                                                                                ticks:	{
                                                                                                            autoSkip: false/*,
                                                                                                            maxRotation: 90,
                                                                                                            minRotation: 90*/
                                                                                                        }
                                                                                            }
                                                                                        ],
                                                                                yAxes: 	[
                                                                                            {
                                                                                                display: true
                                                                                            }
                                                                                        ]
                                                                            }
                                                                }
                                                    }
                                                );
    
        
    
        
        </script>

	</body>
</html>    