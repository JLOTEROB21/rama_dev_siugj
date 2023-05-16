<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica where cmbCategoria=1 order by prioridad";
	$arrUnidades=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__1_tablaDinamica,nombreInmueble FROM _1_tablaDinamica WHERE idEstado=2 order by nombreInmueble";
	$arrEdificios=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idTipoCarpeta,nombreTipoCarpeta FROM 7020_tipoCarpetaAdministrativa WHERE idTipoCarpeta IN(1,5,6) ORDER BY prioridad";
	$arrTipoCarpeta=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT id__4_tablaDinamica,tipoAudiencia FROM _4_tablaDinamica ORDER BY tipoAudiencia";
	$arrTipoAudiencia=$con->obtenerFilasArreglo($consulta);
?>
var arrTipoAudiencia=<?php echo $arrTipoAudiencia?>;
var arrTipoCarpeta=<?php echo $arrTipoCarpeta?>;
var funcionRestoParametros=null;
var arrEdificios=<?php echo $arrEdificios?>;
var arrInformes= [
					['2','Concentrado de eventos de audiencia'],
                    ['29','Calidad eventos de audiencia'],
                    ['3','Reporte de captura de resolutivos por audiencia'],
                    ['24','Reporte de captura de resolutivos'],
                    ['11','Eventos por juez (Sin guardias)'],
                    ['15','Eventos por juez (Incluyendo guardias)'],
                    ['17','Solicitudes recibidas por gravedad de delito por semana'],
                    ['18','Solicitudes recibidas por gravedad de delito por dia'],
                    ['19','Solicitudes recibidas por tipo de delito'],
                    ['20','Promedio de duraci\xF3n de audiencias por juez'],
                    ['38','Promedio de duraci\xF3n de audiencias por juez - audiencia'],
                    //['21','Promedio de duraci\xF3n de audiencias por tipo de delito'],//No se usa
                    ['22','Ranking de duraci\xF3n de audiencias'],
                    //['25','An\xE1lisis de solicitudes por fiscalia'],//No se usa
                    ['26','Indicadores presidencia'],//Pendiente
                    ['28','Total de audiencias/tiempo por Juez'],
                    ['30','Informe de audiencias por Juez/UGJ'],
                    ['31','Informe de desempe\xF1o de juez'],
                    ['32','Informe de incompetencias'],
                    ['33','Informe de imputados medida cautelar: presentaci\xF3 0n'],
                    ['34','Informe UGAS (Carpetas, Audiencias, Sentencias, Apelaciones)'],
                    ['35','Reporte Mujeres'],                    
                    ['36','Informe de Audiencias'],
                    ['37','Informe de Carpetas Judiciales Recibidas']
                  ]
                  
                  //['27','Indicadores UGAS'],
                  
<?php
	if(existeRol("'159_0'"))
	{
?>
	arrInformes= [
					['2','Concentrado de eventos de audiencia'],
                    ['32','Informe de incompetencias'],
                    ['37','Informe de Carpetas Judiciales Recibidas']
                    
                  ]
<?php
	}
	
	if($tipoMateria!="P")
	{
?>
	arrInformes= [
					['36','Informe de Audiencias']
                    
                  ]
<?php		
	}
	
	
	if(existeRol("'172_0'")||existeRol("'210_0'"))
	{
?>		
		arrInformes= [
						['36','Informe de Audiencias']
						
					  ]
<?php
	}
	
?>                  
                  
var arrUnidades=<?php echo $arrUnidades?>;

Ext.onReady(inicializar);

function inicializar()
{
	arrEdificios.splice(0,0,['0','Todos']);	
	var cmbUnidadGestion=crearComboExt('cmbUnidadGestion',arrUnidades,0,0,250);
    var cmbUnidadGestionMultiSelect=crearComboExt('cmbUnidadGestionMultiSelect',arrUnidades,0,0,250,{multiSelect:true});
    cmbUnidadGestionMultiSelect.hide();
    var cmbEdificio=crearComboExt('cmbEdificio',arrEdificios,0,0,250);
    cmbEdificio.hide();
    var cmbTipoInforme=crearComboExt('cmbTipoInforme',arrInformes,0,0,290);

    cmbTipoInforme.on('select',tipoReporteChange);
    var cmbTipoAudienciaMultiSelect=crearComboExt('cmbTipoAudienciaMultiSelect',arrTipoAudiencia,0,0,350,{multiSelect:true});
    cmbTipoAudienciaMultiSelect.hide();
    
    var cmbTipoAudiencia=crearComboExt('cmbTipoAudiencia',arrTipoAudiencia,0,0,350);
    cmbTipoAudiencia.hide();
    
    
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                tbar:	[
                                                			{
                                                            	xtype:'label',
                                                                html:'<b>&nbsp;&nbsp;&nbsp;Tipo de informe:&nbsp;&nbsp;&nbsp;</b>'
                                                            },
                                                            cmbTipoInforme,'-',
                                                			{
                                                            	xtype:'label',
                                                                html:'<b>&nbsp;&nbsp;&nbsp;Periodo del:&nbsp;&nbsp;&nbsp;</b>'
                                                            },
                                                            {
                                                            	xtype:'datefield',
                                                                id:'dtrFechaInicio',
                                                                value:'<?php echo date("Y-m-d")?>',
                                                                listeners:	{
                                                                				//select:cargarReporte
                                                                			}
                                                            },
                                                            {
                                                            	xtype:'label',
                                                                html:'<b>&nbsp;&nbsp;&nbsp;al:&nbsp;&nbsp;&nbsp;</b>'
                                                            },
                                                            {
                                                            	xtype:'datefield',
                                                                id:'dtrFechaFin',
                                                                value:'<?php echo date("Y-m-d")?>',
                                                                listeners:	{
                                                                				//select:cargarReporte
                                                                			}
                                                            },
                                                			{
                                                            	xtype:'label',
                                                                id:'lblUnidadGestion',
                                                                html:'<b>&nbsp;&nbsp;&nbsp;Unidad de gesti&oacute;n:&nbsp;&nbsp;&nbsp;</b>'
                                                            },
                                                            cmbUnidadGestionMultiSelect,
                                                            cmbUnidadGestion,
                                                            {
                                                            	xtype:'label',
                                                                hidden:true,
                                                                id:'lblEdificio',
                                                                html:'<b>&nbsp;&nbsp;&nbsp;Edificio:&nbsp;&nbsp;&nbsp;</b>'
                                                            },
                                                            cmbEdificio
                                                            ,'-',
                                                            {
                                                                icon:'../images/icon_big_tick.gif',
                                                                cls:'x-btn-text-icon',
                                                                text:'Generar',
                                                                handler:function()
                                                                        {
                                                                        	if((!cmbUnidadGestion.disabled)&&(cmbUnidadGestion.isVisible()))
                                                                            {
                                                                            	if(cmbUnidadGestion.getValue()=='')
                                                                                {
                                                                                	msgBox('Debe seleccionar la unidad de gesti&oacute;n de la cual desea obtener el reporte');
                                                                                    return;
                                                                                }
                                                                            }
                                                                            
                                                                            if(gEx('cmbTipoAudienciaMultiSelect').isVisible())
                                                                            {
                                                                            	if(gEx('cmbTipoAudienciaMultiSelect').getValue()=='')
                                                                                {
                                                                                	msgBox('Debe seleccionar el tipo de audiencia a considerar en el reporte');
                                                                                    return;
                                                                                }
                                                                            }
                                                                            
                                                                            if(gEx('cmbTipoAudiencia').isVisible())
                                                                            {
                                                                            	if(gEx('cmbTipoAudiencia').getValue()=='')
                                                                                {
                                                                                	msgBox('Debe seleccionar el tipo de audiencia a considerar en el reporte');
                                                                                    return;
                                                                                }
                                                                            }
                                                                            
                                                                            
                                                                            
                                                                            if(funcionRestoParametros==null)
	                                                                            cargarReporte();
                                                                            else
                                                                            	funcionRestoParametros();
                                                                        }
                                                                
                                                            }
                                                		],
                                                items:	[
                                                
                                                			{
                                                            	region:'center',
                                                                layout:'border',
                                                                border:false,
                                                                tbar:	[
                                                                			{
                                                                                xtype:'label',
                                                                                id:'lblTipoAudiencia',
                                                                                hidden:true,
                                                                                html:'<b>&nbsp;&nbsp;&nbsp;Tipo de audiencia:&nbsp;&nbsp;&nbsp;</b>'
                                                                            },
                                                                            cmbTipoAudienciaMultiSelect,cmbTipoAudiencia,'-'
                                                                		],
                                                                items:	[
                                                                			new Ext.ux.IFrameComponent({ 
                
                                                                                                              id: 'frameContenidoHijo', 
                                                                                                              anchor:'100% 100%',
                                                                                                              region:'center',
                                                                                                              loadFuncion:function(iFrame)
                                                                                                                          {
                                                                                                                              
                                                                                                                          },
                    
                                                                                                              url: '../paginasFunciones/white.php',
                                                                                                              style: 'width:100%;height:100%' 
                                                                                                      })
                                                                		]
                                                            }
                                                            
                                                        ]
                                            }
                                         ]
                            }
                        )
                        
	
    //cmbUnidadGestion.on('select',cargarReporte);
    
    
                           
}


function tipoReporteChange()
{
	funcionRestoParametros=null;
	var pos=existeValorMatriz(arrUnidades,'0');
    if(pos!=-1)
		arrUnidades.splice(pos,1);
    gEx('cmbUnidadGestion').getStore().loadData(arrUnidades);
    
    gEx('cmbUnidadGestionMultiSelect').hide();
	var cmbTipoInforme=gEx('cmbTipoInforme');
    gEx('cmbUnidadGestion').show();
    gEx('lblUnidadGestion').show();
    gEx('lblEdificio').hide();
    gEx('cmbEdificio').hide();
    gEx('lblTipoAudiencia').hide();
    gEx('cmbTipoAudienciaMultiSelect').hide();
    gEx('cmbTipoAudiencia').hide();
    var oParams={};
    switch(cmbTipoInforme.getValue())
    {
    	case '1':
        case '2':	
        
        case '17':
        case '18':
        case '19':
        
        case '21':
        
        case '23':
        case '24':
        case '25':
        case '26':
        case '27':
        case '29':
        case '30':
        case '31':
   	 	case '32':
       	case '33':
        case '34':

        case '35':
       	case '38':
        	gEx('cmbUnidadGestion').disable();
            gEx('cmbUnidadGestion').setValue('');
            
        break;
        case '22':
        	gEx('cmbUnidadGestion').disable();
            gEx('cmbUnidadGestion').setValue('');
            gEx('lblTipoAudiencia').show();
    		gEx('cmbTipoAudiencia').show();
        break;
        case '20':
        	gEx('cmbUnidadGestionMultiSelect').show();
            gEx('cmbUnidadGestion').hide();
            gEx('lblTipoAudiencia').show();
    		gEx('cmbTipoAudienciaMultiSelect').show();
        break;
        case '11':
        case '15':
        case '3':
        case '28':
        	gEx('cmbUnidadGestion').enable();
        break;    
       
       case '36':
        	gEx('cmbUnidadGestion').disable();
            gEx('cmbUnidadGestion').setValue('');
            gEx('cmbUnidadGestion').hide();
            gEx('lblUnidadGestion').hide();
            gEx('lblEdificio').show();
    		gEx('cmbEdificio').show();
        break;
        case '37':
        	arrUnidades.splice(0,0,['0','Todos']);
            gEx('cmbUnidadGestion').getStore().loadData(arrUnidades);	
			gEx('cmbUnidadGestion').setValue('0');
            gEx('cmbUnidadGestion').enable();
            funcionRestoParametros=mostrarVentanaTipoCarpeta;
        break;	
        default:
        	
        break;
        
    }
}


function cargarReporte(arrParams)
{

    var cmbTipoInforme=gEx('cmbTipoInforme');
    var oParams={};
  
    switch(cmbTipoInforme.getValue())
    {
    	case '1':
        	urlLiga='../modulosEspeciales_SGJP/tblInformeAudienciasV2.php';
        	
            if((gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
            }
        break;
        case '2':
        	urlLiga='../modulosEspeciales_SGJP/tblReporteAudienciasV2.php';
        	
            if((gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
            }
        break;
        case '3':
        	urlLiga='../modulosEspeciales_SGJP/tblReporteCapturaResolutivosAudienciaExcel.php';
        	
            if((gEx('cmbUnidadGestion').getValue()=='')||(gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
                oParams.unidadGestion=gEx('cmbUnidadGestion').getValue();
            }
        break;
        
        case '11':
        case '15':
        case '28':
        	urlLiga='../modulosEspeciales_SGJP/tblGraficaEventos.php';
            if((gEx('cmbUnidadGestion').getValue()=='')||(gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	oParams.unidadMedida=11;
                oParams.unidadGestion=gEx('cmbUnidadGestion').getValue();
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
            }
        break;
        
        case '17':
        case '18':
        case '19':
        	
        	
            if((gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	urlLiga='../modulosEspeciales_SGJP/tblGraficaEventos.php';
            	oParams.unidadMedida=parseInt(cmbTipoInforme.getValue()-10);
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
            }
        
        break;
        case '20':
        	
        	if((gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	urlLiga='../modulosEspeciales_SGJP/tblGraficasJueces.php';
            	
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.unidadGestion=gEx('cmbUnidadGestionMultiSelect').getValue();
                oParams.tiposAudiencia=gEx('cmbTipoAudienciaMultiSelect').getValue();
                
                
                oParams.cPagina='sFrm=true';
            }
        break;
        case '21':
        	if((gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	urlLiga='../modulosEspeciales_SGJP/tblGraficasJuecesDelito.php';
            	
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
            }
        break;
        case '22':
        	if((gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	urlLiga='../modulosEspeciales_SGJP/tblGraficasRankingJuez.php';
            	
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.tipoAudiencia=gEx('cmbTipoAudiencia').getValue();;
                oParams.cPagina='sFrm=true';
            }
        break;
        case '23':
        	if((gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	urlLiga='../modulosEspeciales_SGJP/tblGraficasRankingJuez.php';
            	
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.tipoAudiencia=26;
                oParams.cPagina='sFrm=true';
            }
            
           
        break;
        case '24':
        	if((gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	urlLiga='../modulosEspeciales_SGJP/tblReporteCapturaResolutivos.php';
            	
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.tipoAudiencia=26;
                oParams.cPagina='sFrm=true';
            }
            
            
        break;
        case '25':
        	if((gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	urlLiga='../modulosEspeciales_SGJP/tbGraficasFiscaliaV2.php';
            	
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
            }
            
            
        break;
        case '26':
        	if((gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	urlLiga='../modulosEspeciales_SGJP/tblInformePresidencia.php';
            	
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
            }
            
            
        break;
        case '27':
        	if((gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	urlLiga='../modulosEspeciales_SGJP/tblInformeOficial.php';
            	
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
            }
            
            
        break;
        case '29':
        	if((gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	urlLiga='../modulosEspeciales_SGJP/tblInformeIncidenciasEventos.php';
            	
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
            }
            
            
        break;
        case '30':
        	if((gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	urlLiga='../modulosEspeciales_SGJP/informeAudienciasJuecesPorUGA.php';
            	
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
            }
        break;
        case '31':
        	if((gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	urlLiga='../modulosEspeciales_SGJP/tblInformeDesempenioJuez.php';
            	
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
            }
        break;
        case '32':
        	if((gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	urlLiga='../modulosEspeciales_SGJP/tblInformeIncompetencias.php';
            	
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
            }
        break;
        case '33':
        	if((gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	urlLiga='../modulosEspeciales_SGJP/tblInformePresentacionMedida.php';
            	
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
            }
        break;
        case '34':
        	if((gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	urlLiga='../modulosEspeciales_SGJP/tblReporteCarpetas.php';
            	
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
            }
        break;

        case '35':
        	if((gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	urlLiga='../modulosEspeciales_SGJP/tblInformeMujeres.php';
            	
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
            }
        break;

        case '36':
        
        	if(gEx('cmbEdificio').getValue()=='')
            {
            	msgBox('Debe indicar el edificio cuyo reporte desea obtener')
            	return;
            }
        
        	if((gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	urlLiga='../modulosEspeciales_SGJP/generarInformeAudiencias.php';
            	
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
                oParams.idEdificio=gEx('cmbEdificio').getValue();
            }
        break;
        case '37':
        	urlLiga='../modulosEspeciales_SGJP/generarInformeCarpetas.php';
            if((gEx('cmbUnidadGestion').getValue()=='')||(gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	
                oParams.unidadGestion=gEx('cmbUnidadGestion').getValue();
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
            }
        break;
		case '38':
        	if((gEx('dtrFechaInicio').getValue()=='')||(gEx('dtrFechaFin').getValue()==''))
            {
            	urlLiga='../paginasFunciones/white.php';
            }
            else
            {
            	urlLiga='../modulosEspeciales_SGJP/generarInformeJuecesAudiencias.php';
            	
                oParams.fechaInicio=gEx('dtrFechaInicio').getValue().format("Y-m-d");
                oParams.fechaFin=gEx('dtrFechaFin').getValue().format("Y-m-d");
                oParams.cPagina='sFrm=true';
            }
            
            
        break;
        default:
        	urlLiga='../paginasFunciones/white.php';
        break;
        
    }
    
    if(arrParams)
    {
    	var tmp;
    	for(tmp=0;tmp<arrParams.length;tmp++)
        {
        	oParams[arrParams[tmp][0]]=arrParams[tmp][1];
        }
    }
    
    gEx('frameContenidoHijo').load	(
    									{
                                        	url:urlLiga,
                                            params:oParams
                                        }
    								)
    
    
}

function mostrarVentanaTipoCarpeta()
{
	var cmbTipoCarpeta=crearComboExt('cmbTipoCarpeta',arrTipoCarpeta,320,5,250);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Indique el tipo de carpeta a considerar en el informe:'
                                                        },
                                                        cmbTipoCarpeta
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Informe de Carpetas Judiciales Recibidas',
										width: 700,
                                        y:40,
										height:120,
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		if(cmbTipoCarpeta.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbTipoCarpeta.focus();
                                                                            }
                                                                            msgBox('Debe indicar el tipo de carpeta a considerar en el informe',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        cargarReporte([['tCarpeta',cmbTipoCarpeta.getValue()]]);
                                                                        ventanaAM.close();
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	
}