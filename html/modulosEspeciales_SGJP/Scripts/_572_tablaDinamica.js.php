<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);	
	
	$arrLeyendas[1]="Mes";
	$arrLeyendas[2]="Bimestre";
	$arrLeyendas[3]="Trimestre";
	$arrLeyendas[4]="Cuatrimestre";
	$arrLeyendas[6]="Semestre";
	$arrLeyendas[12]="Anual";	
	
	$arrPosicionOrd[1]="Primer";
	$arrPosicionOrd[2]="Segundo";
	$arrPosicionOrd[3]="Tercer";
	$arrPosicionOrd[4]="Cuarto";
	$arrPosicionOrd[5]="Quinto";
	$arrPosicionOrd[6]="Sexto";
	$arrPosicionOrd[7]="Séptimo";
	$arrPosicionOrd[8]="Octavo";
	$arrPosicionOrd[9]="Noveno";
	$arrPosicionOrd[10]="Décimo";
	$arrPosicionOrd[11]="Décimo primer";
	$arrPosicionOrd[12]="Décimo segundo";
	
	$consulta="SELECT * FROM _572_tablaDinamica WHERE id__572_tablaDinamica=".$idRegistro;

	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	
	
	$recalcularIndicadores=true;
	if($fRegistro["idEstado"]>1)
	{
		$recalcularIndicadores=false;
	}
	
	$consulta="SELECT * FROM 539_calendarioReportesIndicadores WHERE idRegistro=".$fRegistro["idRegistroCalendario"];
	$fCalendario=$con->obtenerPrimeraFilaAsoc($consulta);

	$idRegistroMarcoTeorico=$fCalendario["idReferencia"];
	
	$consulta="SELECT idRegistro FROM 539_calendarioReportesIndicadores WHERE idReferencia=".$idRegistroMarcoTeorico;

	$listaCalendarioInformes=$con->obtenerListaValores($consulta);
	if($listaCalendarioInformes=="")
		$listaCalendarioInformes="-1";

	$frecuenciaMedicion=$fCalendario["periodicidad"];
	

	$mesReporte=($frecuenciaMedicion*$fRegistro["periodoReporte"])-1;
	
	$mesFinal=$arrMesLetra[$mesReporte];

	$mesReporteInicial=$mesReporte-($frecuenciaMedicion-2);

	$mesInicial=$arrMesLetra[$mesReporteInicial-1];
	
	$consulta="SELECT ejercicioFiscal FROM _539_tablaDinamica WHERE id__539_tablaDinamica=".$fCalendario["idReferencia"];
	$cicloFiscal=$con->obtenerValor($consulta);
	$fechaPeriodoInicio=$cicloFiscal."-".str_pad($mesReporteInicial,2,"0",STR_PAD_LEFT)."-01";
	$fechaPeriodoFin=date("Y-m-d",strtotime("-1 days",strtotime("+1 month",strtotime($cicloFiscal."-".str_pad($mesReporte+1,2,"0",STR_PAD_LEFT)."-01"))));

	$lblPeriodo=$arrPosicionOrd[$fRegistro["periodoReporte"]]." ".$arrLeyendas[$frecuenciaMedicion]." (".$mesInicial." - ".$mesFinal.")";
	
	$cadCamposMetas="{name:'idIndicador'},{name:'indicador'},{name:'unidadMedida'},{name: 'absolutoAnual'},{name: 'porcentajeAnual'}";
	$cadColumnasMetas="
							new  Ext.grid.RowNumberer(),
							{
							  header:'Indicador y actividad asociada',
							  width:250,
							  sortable:true,
							  editor:{xtype:'numberfield',allowDecimals:true,allowNegative:'false'},
							  dataIndex:'indicador'
						  },
						  {
							  header:'Unidad de Medida',
							  width:110,
							  sortable:true,
							  editor:{xtype:'numberfield',allowDecimals:true,allowNegative:'false'},
							  dataIndex:'unidadMedida',
							  align:'center'
						  },
						  {
							  header:'Absoluto',
							  width:65,
							  sortable:true,
							  renderer:function(val){return Ext.util.Format.number(val,'0.00');},
							  editor:{xtype:'numberfield',allowDecimals:true,allowNegative:'false'},
							  dataIndex:'absolutoAnual',
							  align:'center'
						  },
						  {
							  header:'Porcentaje',
							  width:70,
							  sortable:true,
							  renderer:function(val){return Ext.util.Format.number(val,'0.00')+'%';},
							  editor:{xtype:'numberfield',allowDecimals:true,allowNegative:'false'},
							  dataIndex:'porcentajeAnual',
							  align:'center'
						  }
						  ";
	
					
	$arrCabeceraMetas=	"{},
						{},
						{},
						{header: 'Anual', colspan: 2, align: 'center'}
						";		
						
	$cadCamposCumplimiento="{name:'idIndicador'},{name:'indicador'},{name:'unidadMedida'},{name:'semaforizacion'},{name: 'absolutoAcumulado'},{name: 'porcentajeAcumulado'}";
	$cadColumnasCumplimiento="
							new  Ext.grid.RowNumberer(),
							{
							  header:'Indicador y actividad asociada',
							  width:250,
							  sortable:true,
							  editor:{xtype:'numberfield',allowDecimals:true,allowNegative:'false'},
							  dataIndex:'indicador'
						  },
						  {
							  header:'Unidad de Medida',
							  width:110,
							  sortable:true,
							  editor:{xtype:'numberfield',allowDecimals:true,allowNegative:'false'},
							  dataIndex:'unidadMedida',
							  align:'center'
						  },
						  {
							  header:'Absoluto',
							  width:65,
							  sortable:true,
							  dataIndex:'absolutoAcumulado',
							  renderer:calcularAbsolutoAcumulado,
							  align:'center'
						  },
						  {
							  header:'Porcentaje',
							  width:70,
							  sortable:true,
							  dataIndex:'porcentajeAcumulado',
							  renderer:calcularPorcentajeAcumulado,
							  align:'center'
						  }
						  ";
					
	$arrCabeceraMetas=	"{},
						{},
						{},
						{header: 'Anual', colspan: 2, align: 'center'}
						";	
	$arrCabeceraCumplimiento=	"{},
						{},
						{},
						{header: 'Resultado<br>alcanzado acumulado', colspan: 2, align: 'center'}
						";														
								
	$totalPeridos=12/$frecuenciaMedicion;
		
	for($x=1;$x<=$totalPeridos;$x++)
	{
		$complementarioEditor="";
		$complementarioEditorPorcentaje="";
		if($x==$fRegistro["periodoReporte"])
		{
			$complementarioEditor="editor:{xtype:'numberfield',allowDecimals:true,allowNegative:'false'},renderer:formatearDesviacion,";
			$complementarioEditorPorcentaje="editor:{xtype:'numberfield',allowDecimals:true,allowNegative:'false'},renderer:formatearDesviacionPorcentaje,";
		}
		else
		{
			if($x>$fRegistro["periodoReporte"])
			{
				$complementarioEditor="renderer:function(val,meta,registro){meta.attr='style=\"color:#777; \"'; return Ext.util.Format.number(val,'0.00');},";
				$complementarioEditorPorcentaje="renderer:function(val,meta,registro){meta.attr='style=\"color:#777; \"'; return Ext.util.Format.number(val,'0.00')+'%';},";
			}
			else
			{
				$complementarioEditor="renderer:formatearDesviacion,";
				$complementarioEditorPorcentaje="renderer:formatearDesviacionPorcentaje,";
			}
		}
		
		$cadCamposMetas.=",{name:'absoluto_".$x."'},{name:'porcentaje_".$x."'}";
		$cadCamposCumplimiento.=",{name:'absoluto_".$x."'},{name:'porcentaje_".$x."'}";
		$cadColumnasMetas.=",
						  {
							  header:'Absoluto',
							  width:65,
							  sortable:true,
							  renderer:function(val){return Ext.util.Format.number(val,'0.00');},
							  dataIndex:'absoluto_".$x."',
							  align:'center'
						  },
						  {
							  header:'Porcentaje',
							  width:70,
							  sortable:true,
							  renderer:function(val){return Ext.util.Format.number(val,'0.00')+'%';},
							  dataIndex:'porcentaje_".$x."',
							  align:'center'
						  }";
		$arrCabeceraMetas.=",{header: '".$arrPosicionOrd[$x]." ".$arrLeyendas[$frecuenciaMedicion]."', colspan: 2, align: 'center'}";
		$arrCabeceraCumplimiento.=",{header: '".$arrPosicionOrd[$x]." ".$arrLeyendas[$frecuenciaMedicion]."', colspan: 2, align: 'center'}";
		$cadColumnasCumplimiento.=",
						  {
							  header:'Absoluto',
							  width:65,
							  sortable:true,
							  ".$complementarioEditor."
							  dataIndex:'absoluto_".$x."',
							  align:'center'
						  },
						  {
							  header:'Porcentaje',
							  width:70,
							  sortable:true,
							  ".$complementarioEditorPorcentaje."
							  dataIndex:'porcentaje_".$x."',
							  align:'center'
						  }";
	}
		
	$arrCabeceraMetas="[".$arrCabeceraMetas."]";
	$arrCabeceraCumplimiento="[".$arrCabeceraCumplimiento."]";
	$anioActual=date("Y");
	
	$arrDatosMetas="";
	$arrDatosCumplimiento="";
	
	$consulta="SELECT i.*,m.id__571_tablaDinamica FROM _550_tablaDinamica i,_571_tablaDinamica m WHERE i.idProcesoPadre=222 AND i.idReferencia=".$idRegistroMarcoTeorico."
				AND m.idReferencia=i.id__550_tablaDinamica AND i.frecuenciaMedicion=".$frecuenciaMedicion.
				" AND m.nombreResponsable= ".$fRegistro["idUsuarioDestinatario"]." ORDER BY i.nombreIndicador";
	$rIndicadores=$con->obtenerFilas($consulta);
	while($filaIndicador=mysql_fetch_assoc($rIndicadores))				
	{

		$idRegistroIndicador=$filaIndicador["id__571_tablaDinamica"];
		
		$consulta="SELECT * FROM _571_gridSemaforizacion WHERE idReferencia=".$idRegistroIndicador;
		$filaSemaforo=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$objSemaforizacion=bE('{"absoluto":[{"color":"007313","valorMinimo":">=0","valorMaximo":"<='.
							$filaSemaforo["vAbsoluto"].'"},{"color":"ADB900","valorMinimo":">'.$filaSemaforo["vAbsoluto"].'","valorMaximo":"<='.
							$filaSemaforo["aAbsoluto"].'"},{"color":"F00","valorMinimo":">'.$filaSemaforo["aAbsoluto"].
							'","valorMaximo":"--"}],"porcentaje":[{"color":"007313","valorMinimo":">=0","valorMaximo":"<='.
							$filaSemaforo["vPorcentaje"].'"},{"color":"ADB900","valorMinimo":">'.$filaSemaforo["vPorcentaje"].'","valorMaximo":"<='.
							$filaSemaforo["aPorcentaje"].'"},{"color":"F00","valorMinimo":">'.$filaSemaforo["aPorcentaje"].
							'","valorMaximo":"--"}]}');
		
		$oDato="['".$filaIndicador["id__550_tablaDinamica"]."','".cv($filaIndicador["nombreIndicador"])."','".cv($filaIndicador["unidadMedida"])."'";
		$oDatoCumplimiento="['".$filaIndicador["id__550_tablaDinamica"]."','".cv($filaIndicador["nombreIndicador"])."','".cv($filaIndicador["unidadMedida"]).
							"','".$objSemaforizacion."'";
		for($x=0;$x<=$totalPeridos;$x++)
		{
			$consulta="SELECT id__572_tablaDinamica FROM _572_tablaDinamica WHERE periodoReporte=".$x.
					" AND idRegistroCalendario IN(".$listaCalendarioInformes.")";
			$idRegistroInforme=$con->obtenerValor($consulta);
			
			
			
			if($idRegistroInforme=="")
				$idRegistroInforme=-1;
				
			$consulta="SELECT valor FROM _571_lineaBaseRegistro WHERE idReferencia=".$idRegistroIndicador.
					" AND anio=0 AND mesValor=".$x." AND tipoValor=0";

			$valorAbsoluto=$con->obtenerValor($consulta);
			$consulta="SELECT valor FROM _571_lineaBaseRegistro WHERE idReferencia=".$idRegistroIndicador.
					" AND anio=0 AND mesValor=".$x." AND tipoValor=1";
			$valorPorcentaje=$con->obtenerValor($consulta);
			
			if($oDato=="")
				$oDato="'".$valorAbsoluto."','".$valorPorcentaje."'";
			else
				$oDato.=",'".$valorAbsoluto."','".$valorPorcentaje."'";
			
			$valorAbsolutoCumplimiento=0;			
			$valorPorcentajeCumplimiento=0;
			
			
			if(($x==$fRegistro["periodoReporte"])&&($filaIndicador["funcionCalculo"]!=-1)&& $recalcularIndicadores)
			{
				$cacheCalculos=NULL;
				$cadParametros='{"idIndicador":"'.$filaIndicador["id__550_tablaDinamica"].'","periodoReporte":"'.$fRegistro["periodoReporte"].
								'","tipoValor":"0","codigoInstitucion":"'.$fRegistro["codigoInstitucion"].
								'","idRegistroReporte":"'.$idRegistro.'","fechaPeriodoInicio":"'.$fechaPeriodoInicio.
								'","fechaPeriodoFin":"'.$fechaPeriodoFin.'","cicloFiscal":"'.$cicloFiscal.'","mesInicio":"'.
								(date("m",strtotime($fechaPeriodoInicio))*1).'","mesFin":"'.(date("m",strtotime($fechaPeriodoFin))*1).'"}';

				$objParametros=json_decode($cadParametros);
				
				$valorAbsolutoCumplimiento=removerComillasLimite(resolverExpresionCalculoPHP($filaIndicador["funcionCalculo"],$objParametros,$cacheCalculos));	
				if($valorAbsolutoCumplimiento=="")
					$valorAbsolutoCumplimiento=0;
				
				$objParametros->tipoValor=1;
				$valorPorcentajeCumplimiento=removerComillasLimite(resolverExpresionCalculoPHP($filaIndicador["funcionCalculo"],$objParametros,$cacheCalculos));	
				if($valorPorcentajeCumplimiento=="")
					$valorPorcentajeCumplimiento=0;
				
				
				$consulta="SELECT idRegistro FROM _572_registroCumplimientoIndicadores WHERE idReferencia=".$idRegistroInforme.
						" and idIndicador=".$filaIndicador["id__550_tablaDinamica"]." and mesValor=".$x." AND tipoValor=0";

				$idRegistroIndicadorReportado=$con->obtenerValor($consulta);
				
				if($idRegistroIndicadorReportado=="")
				{
				
					$consulta="INSERT INTO _572_registroCumplimientoIndicadores(idReferencia,idIndicador,mesValor,tipoValor,valor,calculado)
								VALUES(".$idRegistro.",".$filaIndicador["id__550_tablaDinamica"].",".$fRegistro["periodoReporte"].",0,".
								$valorAbsolutoCumplimiento.",1)";
					$con->ejecutarConsulta($consulta);
				}
				else
				{
					$consulta="UPDATE _572_registroCumplimientoIndicadores SET valor=".$valorAbsolutoCumplimiento." WHERE idRegistro=".$idRegistroIndicadorReportado;
					$con->ejecutarConsulta($consulta);
				}
				
				$consulta="SELECT idRegistro FROM _572_registroCumplimientoIndicadores WHERE idReferencia=".$idRegistroInforme.
						" and idIndicador=".$filaIndicador["id__550_tablaDinamica"]." and mesValor=".$x." AND tipoValor=1";
				$idRegistroIndicadorReportado=$con->obtenerValor($consulta);
				
				if($idRegistroIndicadorReportado=="")
				{
				
					$consulta="INSERT INTO _572_registroCumplimientoIndicadores(idReferencia,idIndicador,mesValor,tipoValor,valor,calculado)
							VALUES(".$idRegistro.",".$filaIndicador["id__550_tablaDinamica"].",".$fRegistro["periodoReporte"].",1,".
							$valorPorcentajeCumplimiento.",1)";	
					$con->ejecutarConsulta($consulta);
				}
				else
				{
					$consulta="UPDATE _572_registroCumplimientoIndicadores SET valor=".$valorPorcentajeCumplimiento." WHERE idRegistro=".$idRegistroIndicadorReportado;
					$con->ejecutarConsulta($consulta);
				}
			}
			else
			{
				if($x>$fRegistro["periodoReporte"])
				{
					$valorAbsolutoCumplimiento=0;
					$valorPorcentajeCumplimiento=0;
				}
				else
				{
				
					$consulta="SELECT valor FROM _572_registroCumplimientoIndicadores WHERE idReferencia=".$idRegistroInforme.
							" and idIndicador=".$filaIndicador["id__550_tablaDinamica"]." and mesValor=".$x." AND tipoValor=0";
	
					$valorAbsolutoCumplimiento=$con->obtenerValor($consulta);
					if($valorAbsolutoCumplimiento=="")
						$valorAbsolutoCumplimiento=0;
						
						
					$consulta="SELECT valor FROM _572_registroCumplimientoIndicadores WHERE idReferencia=".$idRegistroInforme.
						" and idIndicador=".$filaIndicador["id__550_tablaDinamica"]." and mesValor=".$x." AND tipoValor=1";
					$valorPorcentajeCumplimiento=$con->obtenerValor($consulta);	
					if($valorPorcentajeCumplimiento=="")
						$valorPorcentajeCumplimiento=0;		
				}
			
			}
				
			if($oDatoCumplimiento=="")
				$oDatoCumplimiento="'".$valorAbsolutoCumplimiento."','".$valorPorcentajeCumplimiento."'";
			else
				$oDatoCumplimiento.=",'".$valorAbsolutoCumplimiento."','".$valorPorcentajeCumplimiento."'";
		}
		$oDato.="]";
		$oDatoCumplimiento.="]";
		
		if($arrDatosMetas=="")
			$arrDatosMetas=$oDato;
		else
			$arrDatosMetas.=",".$oDato;
			
		if($arrDatosCumplimiento=="")
			$arrDatosCumplimiento=$oDatoCumplimiento;
		else	
			$arrDatosCumplimiento.=",".$oDatoCumplimiento;
			
	}
		
	
	
	$arrDatosMetas="[".$arrDatosMetas."]";
	$arrDatosCumplimiento="[".$arrDatosCumplimiento."]";
	

?>	
var periodoReportado=<?php echo $fRegistro["periodoReporte"]?>;
var idRegistro=<?php echo $idRegistro?>;
var lblPeriodo='<?php echo $lblPeriodo?>';
var totalPeriodos=<?php echo $totalPeridos ?>;
var cadenaFuncionValidacion='prepararGuardado';


var arrDatosMetas=<?php echo $arrDatosMetas?>;
var arrDatosCumplimiento=<?php echo $arrDatosCumplimiento?>;
function inyeccionCodigo()
{
	oE('sticky');
	gE('sp_9325').innerHTML=lblPeriodo;
    
    loadCSS('../Scripts/ux/groupHeader/ColumnHeaderGroup.css',function()
                                                              {
                                                              }
			) 
   
   loadScript('../Scripts/ux/groupHeader/ColumnHeaderGroup.js', function()
                                                                {
                                                                	loadScript('../Scripts/ux/grid/GridSummary.js', function()
                                                                                                                    {
                                                                                                                       
                                                                                                                        crearGridMetas();
                                                                                                                        crearGridCumplimientoMetas();
                                                                                                                    }
                                                                 			)
                                                                }
			) 
	insertCss('.x-grid3-hd-inner {  font-family: Ubuntu, sans-serif;   height: auto !important; text-align:center; min-height:21px;   font-size: 12px;color:#000;}');
	insertCss('.x-grid3-cell-inner {   white-space: normal;height: auto !important; color:#000;}');                                                                           
}	



function crearGridMetas()
{
	var cabecera=	new Ext.ux.grid.ColumnHeaderGroup	(
                                                        	{
                                                            	rows: 	[<?php echo $arrCabeceraMetas?>]
                                                        	}
                                                        )

	var arrColumnas=[<?php echo $cadColumnasMetas?>];
	
    
    var dsDatos=arrDatosMetas;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[<?php echo $cadCamposMetas?>]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
                                                                                      
	      
	var cModelo= new Ext.grid.ColumnModel   	(
												 	arrColumnas
												);
	gE('sp_9372').innerHTML='';
    var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                     	{
                                                        	store:alDatos,
                                                            false:true,
                                                            cm: cModelo,
                                                            id:'gridMetas',
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            renderTo:'sp_9372',
                                                            columnLines : true,
                                                            height:450,
                                                            width:1100,
                                                            plugins:[cabecera]
                                                       }  
                                                    );                                                    
	
    
    tblGrid.on('beforeEdit',function(e)
    						{
                            	
                                	e.cancel=true;
                                
                            }
    			)

	tblGrid.on('afterEdit',function(e)
    						{
                            	
                                if(e.field.indexOf('porcentaje')!=-1)
                                {
                                	if(parseFloat(e.value)>100)
                                    {
                                    	function respAux()
                                        {
                                        	e.record.set(e.field,e.originalValue);
                                            e.grid.startEditing(e.row,e.column);
                                        }
                                    	msgBox('El porcentaje no puede ser mayor a 100%',respAux);
                                    	return;
                                    }
                                }
                            }
    			)                
                                                                                                                                                                      
}

function crearGridCumplimientoMetas()
{
	var cabecera=	new Ext.ux.grid.ColumnHeaderGroup	(
                                                        	{
                                                            	rows: 	[<?php echo $arrCabeceraCumplimiento?>]
                                                        	}
                                                        )

	var arrColumnas=[<?php echo $cadColumnasCumplimiento?>];
	
    
    var dsDatos=arrDatosCumplimiento;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[<?php echo $cadCamposCumplimiento?>]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
                                                                                      
	      
	var cModelo= new Ext.grid.ColumnModel   	(
												 	arrColumnas
												);
	gE('sp_9375').innerHTML='';
    var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                     	{
                                                        	store:alDatos,
                                                            false:true,
                                                            cm: cModelo,
                                                            id:'gridCumplimientoIndicador',
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            renderTo:'sp_9375',
                                                            columnLines : true,
                                                            height:450,
                                                            width:1100,
                                                            clicksToEdit:1,
                                                            plugins:[cabecera]
                                                       }  
                                                    );                                                    
	
    
    tblGrid.on('beforeEdit',function(e)
    						{
                            	<?php
									if($fRegistro["idEstado"]<>1)
										echo "e.cancel=true;";
								?>
                                	
                                
                            }
    			)

	tblGrid.on('afterEdit',function(e)
    						{
                            	
                                if(e.field.indexOf('porcentaje')!=-1)
                                {
                                	if(parseFloat(e.value)>100)
                                    {
                                    	function respAux()
                                        {
                                        	e.record.set(e.field,e.originalValue);
                                            e.grid.startEditing(e.row,e.column);
                                        }
                                    	msgBox('El porcentaje no puede ser mayor a 100%',respAux);
                                    	return;
                                    }
                                }
                                if(e.value=='')
                                {
                                	e.value=0;
                                    e.record.set(e.field,0);
                                }
                                var tipoValor=e.field.indexOf('porcentaje')!=-1?1:0;
                                var cadObj='{"idRegistro":"'+idRegistro+'","idIndicador":"'+e.record.data.idIndicador+'","mesValor":"'+periodoReportado+
                                		'","tipoValor":"'+tipoValor+'","valor":"'+e.value+'","calculado":"0"}';
                                function funcAjax()
                                {
                                    var resp=peticion_http.responseText;
                                    arrResp=resp.split('|');
                                    if(arrResp[0]=='1')
                                    {
                                        
                                    }
                                    else
                                    {
                                    	function respErr()
                                        {
                                        	e.record.set(e.field,e.originalValue);
                                        }
                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0],respErr);
                                    }
                                }
                                obtenerDatosWeb('../paginasFunciones/funcionesPlaneacionEstrategica.php',funcAjax, 'POST','funcion=53&cadObj='+cadObj,true); 
                                
                            }
    			)                
                                                                                                                                                                      
}


function prepararGuardado()
{
	return true;
}

function formatearDesviacion(val,meta,registro,numFila,numColumna)
{
	var color="000";
 	var pos=obtenerPosFila(gEx('gridMetas').getStore(),'idIndicador',registro.data.idIndicador)   ;
    var fila=gEx('gridMetas').getStore().getAt(pos);
    
    
    var nomColumna=gEx('gridCumplimientoIndicador').getColumnModel().getDataIndex(numColumna);
    
    
    var valor=fila.get(nomColumna);
    var diferencia=valor-val;
    if(diferencia<0)
    	diferencia=0;
     
    var tipoValor=nomColumna.indexOf('porcentaje')!=-1?'1':'0';
    
    var objSemaforo=eval('['+bD(registro.data.semaforizacion)+']')[0];
    var oReferencia=tipoValor=='0'?objSemaforo.absoluto:objSemaforo.porcentaje;
    
    var x;
    var condicion='';
    var cumpleCondicion;
    for(x=0;x<oReferencia.length;x++)
    {
		condicion='(diferencia'+oReferencia[x].valorMinimo+')';
        if(oReferencia[x].valorMaximo!='--')
        	condicion+='&&(diferencia'+oReferencia[x].valorMaximo+')';
         
        eval('cumpleCondicion=('+condicion+');') ;
        
        if(cumpleCondicion)   
        {
        	color=oReferencia[x].color;
	        break;
         }
		 
    }
    
    
    
    
	return '<span style="color:#'+color+'">'+Ext.util.Format.number(val,'0.00')+'</span>';
}

function formatearDesviacionPorcentaje(val,meta,registro,numFila,numColumna)
{
	var color="000";
 	var pos=obtenerPosFila(gEx('gridMetas').getStore(),'idIndicador',registro.data.idIndicador)   ;
    var fila=gEx('gridMetas').getStore().getAt(pos);
    
    
    var nomColumna=gEx('gridCumplimientoIndicador').getColumnModel().getDataIndex(numColumna);
    
    
    var valor=fila.get(nomColumna);
    var diferencia=valor-val;
    if(diferencia<0)
    	diferencia=0;
     
    var tipoValor=nomColumna.indexOf('porcentaje')!=-1?'1':'0';
    
    var objSemaforo=eval('['+bD(registro.data.semaforizacion)+']')[0];
    var oReferencia=tipoValor=='0'?objSemaforo.absoluto:objSemaforo.porcentaje;
    
    var x;
    var condicion='';
    var cumpleCondicion;
    for(x=0;x<oReferencia.length;x++)
    {
		condicion='(diferencia'+oReferencia[x].valorMinimo+')';
        if(oReferencia[x].valorMaximo!='--')
        	condicion+='&&(diferencia'+oReferencia[x].valorMaximo+')';
         
        eval('cumpleCondicion=('+condicion+');') ;
        
        if(cumpleCondicion)   
        {
        	color=oReferencia[x].color;
	        break;
         }
		 
    }
    
    
    
    
	return '<span style="color:#'+color+'">'+Ext.util.Format.number(val,'0.00')+'%</span>';
}

function calcularAbsolutoAcumulado(val,meta,registro)
{
	var total=0;
    for(x=1;x<=totalPeriodos;x++)
    {
    	total+=parseFloat(registro.get('absoluto_'+x));
    }
    return Ext.util.Format.number(total,'0.00');
}

function calcularPorcentajeAcumulado(val,meta,registro)
{
	var total=0;
    for(x=1;x<=totalPeriodos;x++)
    {
    	total+=parseFloat(registro.get('porcentaje_'+x));
    }
   return Ext.util.Format.number(total,'0.00')+'%';
}