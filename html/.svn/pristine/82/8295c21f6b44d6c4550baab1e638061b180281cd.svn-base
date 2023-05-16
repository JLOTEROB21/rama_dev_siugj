<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$fechaActual=date("Y-m-d");
	$diaActual=date("N",strtotime($fechaActual));
	$fechaFinal=7-$diaActual;
	
	$fechaFinal=date("Y-m-d",strtotime("+".$fechaFinal." days",strtotime($fechaActual)));
	
	$consulta="SELECT  id__4_tablaDinamica,tipoAudiencia FROM _4_tablaDinamica";
	$arrAudiencias=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__15_tablaDinamica,nombreSala FROM _15_tablaDinamica";
	$arrSalas=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__15_tablaDinamica, concat(nombreSala, ' [',e.nombreInmueble,']') FROM _15_tablaDinamica s,_1_tablaDinamica e 
			where e.id__1_tablaDinamica=s.idReferencia and id__15_tablaDinamica in(SELECT DISTINCT idSala FROM 7000_eventosAudiencia) 
			order by nombreSala,nombreInmueble";
	$arrSalasBusqueda=$con->obtenerFilasArreglo($consulta);

	$consulta="SELECT id__17_tablaDinamica,nombreUnidad FROM _17_tablaDinamica";
	$arrUnidades=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idSituacion,descripcionSituacion FROM 7011_situacionEventosAudiencia where descripcionSituacion<>''";
	$arrSituacionEvento=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idSituacion,icono,tamano FROM 7011_situacionEventosAudiencia";
	$arrSituaciones=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__1_tablaDinamica,nombreInmueble FROM _1_tablaDinamica";
	$arrEdificios=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT valor,texto FROM 1004_siNo";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__5_tablaDinamica,
	if((SELECT nombreSingular FROM _5_aliasTiposFiguras WHERE idFigura=t.id__5_tablaDinamica AND materia='".$tipoMateria."') is null
			,nombreTipo,(SELECT nombreSingular FROM _5_aliasTiposFiguras WHERE idFigura=t.id__5_tablaDinamica AND materia='".$tipoMateria."')) as nombreTipo 
			FROM _5_tablaDinamica t order by nombreTipo";
	$arrTipoFigura=$con->obtenerFilasArreglo($consulta);
?>
var arrTipoFigura=<?php echo $arrTipoFigura?>;
var arrSiNo=<?php echo $arrSiNo?>;
var arrSalasBusqueda=<?php echo $arrSalasBusqueda?>;
var arrSituacionEvento=<?php echo $arrSituacionEvento?>;
var arrEdificios=<?php echo $arrEdificios?>;
var arrSalas=<?php echo $arrSalas?>;
var arrAudiencias=<?php echo $arrAudiencias?>;
var arrUnidades=<?php echo $arrUnidades?>;
var arrSemaforo=<?php echo $arrSituaciones?>;

Ext.onReady(inicializar);

function inicializar()
{
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
                                                                html:'&nbsp;&nbsp;&nbsp;<b>Unidad de Gesti&oacute;n:</b>&nbsp;<span style="color: #900"><b>'+gE('nombreUnidad').value+'</b></span>&nbsp;&nbsp;'
                                                            },'-',
                                                			{
                                                            	xtype:'label',
                                                                html:'&nbsp;&nbsp;&nbsp;<b>Periodo del:</b>&nbsp;&nbsp;&nbsp;'
                                                            },
                                                            {
                                                            	xtype:'datefield',
                                                                id:'dtePeriodoInicial',
                                                                value:'<?php echo $fechaActual?>',
                                                                listeners:	{
                                                                				select:function()
                                                                                		{
                                                                                        	recargarGridEventos();
                                                                                        }
                                                                                        
                                                                			}
                                                            },'-',
                                                            {
                                                            	xtype:'label',
                                                                html:'&nbsp;&nbsp;&nbsp;<b>Periodo al:</b>&nbsp;&nbsp;&nbsp;'
                                                            },
                                                            {
                                                            	xtype:'datefield',
                                                                id:'dtePeriodoFinal',
                                                                value:'<?php echo $fechaActual?>',
                                                                listeners:	{
                                                                				select:function()
                                                                                		{
                                                                                        	recargarGridEventos();
                                                                                        }
                                                                                        
                                                                			}
                                                            }
                                                		],
                                                items:	[
                                                            crearGridEventos()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}


function recargarGridEventos()
{
	gEx('dEventos').getStore().reload();
    return;

	gEx('dEventos').getStore().load	(
    									{
                                        	url:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                                            params:	{
                                            			funcion:'48',
                                                        uG:gE('uGestion').value,
                                                        fechaInicio:dtePeriodoInicial.getValue().format('Y-m-d'),
                                                        fechaFin:dtePeriodoFinal.getValue().format('Y-m-d')
                                            		}
                                        }
    								)
}

function crearGridEventos()
{

	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idEvento'},
                                                        {name: 'carpetaAdministrativa'},
		                                                {name: 'fechaEvento', type:'date', dateFormat:'Y-m-d'},
		                                                {name: 'horaInicial', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                               	{name: 'horaFinal', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'tipoAudiencia'},
                                                        {name: 'sala'},
                                                        {name: 'unidadGestion'},
                                                        {name: 'situacion'},
                                                        {name: 'juez'}  ,
                                                        {name: 'horaInicialReal', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                               	{name: 'horaFinalReal', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'urlMultimedia'},
                                                        {name: 'tImputados' } ,
                                                        {name: 'iFormulario' }, 
                                                        {name: 'iRegistro' },
                                                        {name: 'iFormularioSituacion'},                                                     
                                                        {name: 'iRegistroSituacion'} ,
                                                        {name: 'urlCanal'},
                                                        {name: 'notificacionMAJO'},
                                                        {name: 'mensajeMAJO'},
                                                        {name: 'delitos'} ,
                                                        {name: 'edificio'}, 
                                                        {name: 'carpetaInvestigacion'},        
                                                        {name: 'imputado'} ,
                                                        {name: 'victima'},
                                                        {name: 'conRecursosAdicionales'},
                                                        {name: 'recursosAdicionales'},
                                                        {name: 'notificacionCabina'},
                                                        {name: 'mensajeCabina'},
                                                        {name: 'audienciaVirtual'},
                                                        {name: 'participantesConfirmados'},
                                                        {name: 'urlAudiencia'}                                                                                    
                                                                                                    
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                                                                                                  timeout: (1000*600)

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaEvento', direction: 'ASC'},
                                                            groupField: 'fechaEvento',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	var dtePeriodoInicial=gEx('dtePeriodoInicial');
                                        var dtePeriodoFinal=gEx('dtePeriodoFinal');
                                    	proxy.baseParams.funcion='48';
                                        proxy.baseParams.audienciasVirtuales=1;
                                        proxy.baseParams.uG=gE('uGestion').value;
                                        proxy.baseParams.fechaInicio=dtePeriodoInicial.getValue().format('Y-m-d');
                                        proxy.baseParams.fechaFin=dtePeriodoFinal.getValue().format('Y-m-d');
                                    }
                        )   
       
       
       var filters = new Ext.ux.grid.GridFilters	(
                                                        {
                                                            filters:	[
                                                            				{
                                                                            	type:'string',
                                                                                dataIndex:'carpetaAdministrativa'
                                                                            },
                                                                            {
                                                                            	type:'list',
                                                                                dataIndex:'situacion',
                                                                                options:arrSituacionEvento,
                                                                                phpMode:true
                                                                            },
                                                                            {
                                                                            	type:'date',
                                                                                dataIndex:'fechaEvento'
                                                                            },
                                                                            {
                                                                            	type:'list',
                                                                                dataIndex:'tipoAudiencia',
                                                                                options:arrAudiencias,
                                                                                phpMode:true
                                                                            },
                                                                            {
                                                                            	type:'list',
                                                                                dataIndex:'sala',
                                                                                options:arrSalasBusqueda,
                                                                                phpMode:true
                                                                            },
                                                                            {
                                                                            	type:'list',
                                                                                dataIndex:'edificio',
                                                                                options:arrEdificios,
                                                                                phpMode:true
                                                                            },
                                                                            {
                                                                            	type:'string',
                                                                                dataIndex:'juez'
                                                                            },
                                                                            {
                                                                            	type:'list',
                                                                                options:arrSiNo,
                                                                                phpMode:true,
                                                                                dataIndex:'conRecursosAdicionales'
                                                                            }
                                                                            
                                                            			]
                                                        }
                                                    );  
       
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                             {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                hidden:true,
                                                                dataIndex:'idEvento',
                                                                css:'text-align:center;vertical-align:middle !important;',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	
	                                                                            return '<a href="javascript:ingresarAdministracionAudiencia(\''+bE(val)+'\',\''+bE(registro.data.carpetaAdministrativa)+'\')"><img src="../images/report_user.png" width="16" height="16" alt="Administraci&oacute;n audiencia" title="Administraci&oacute;n audiencia"><a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'ID Evento',
                                                                width:70,
                                                                sortable:true,
                                                                dataIndex:'idEvento'
                                                                
                                                            },
                                                            
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                css:'text-align:center;vertical-align:middle !important;',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var icono='';
                                                                            meta.attr='style="padding: 0px !important;"';
                                                                        	icono=formatearValorRenderer(arrSemaforo,val);    
                                                                            var tamano=formatearValorRenderer(arrSemaforo,val,2);                                                                            
                                                                            return '<img src="'+icono+'" width="'+tamano+'" height="'+tamano+'" title="'+formatearValorRenderer(arrSituacionEvento,val)+'" alt="'+formatearValorRenderer(arrSituacionEvento,val)+'">';
                                                                        	
                                                                        }
                                                            },
                                                             {
                                                                header:'Situaci&oacute;n audiencia',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrSituacionEvento,val));
                                                                        }
                                                            },
                                                            {
                                                                header:'Participantes<br />confirmados',
                                                                width:100,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'participantesConfirmados',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var color='900';
                                                                            var arrValores=val.split('/');
                                                                            if(arrValores[0]==arrValores[1])
                                                                            {
                                                                            	color='004E10';
                                                                            }
                                                                        	return '<a href="javascript:mostrarConfirmacionAudiencia(\''+bE(registro.data.idEvento)+'\')"><span style="color:#'+color+'; font-weight:bold">'+val+'</span></a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Carpeta judicial',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa'
                                                            },
                                                            {
                                                                header:'Fecha de<br />la audiencia',
                                                                width:110,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'fechaEvento',
                                                                renderer:function(val)
                                                                	{
                                                                    	return val.format('d/m/Y');
                                                                    }
                                                            },
                                                            {
                                                                header:'Hora programada de audiencia',
                                                                width:280,
                                                                sortable:true,
                                                                dataIndex:'horaInicial',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	var comp='';
                                                                        if(val.format('d')!=registro.data.horaFinal.format('d'))
                                                                        {
                                                                        	comp=' del '+registro.data.horaFinal.format('d/m/Y');
                                                                        }

                                                                    	return 'De las '+val.format('H:i')+' hrs. a las '+registro.data.horaFinal.format('H:i')+' hrs.'+comp
                                                                    }
                                                            },
                                                            <?php 
															if(existeRol("'1_0'")||existeRol("'112_0'"))
															{
															?>
                                                            {
                                                                header:'URL de audiencia',
                                                                width:280,
                                                                sortable:true,
                                                                dataIndex:'urlAudiencia',
                                                                editor:{xtype:'textfield'},
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	return val;
                                                                    }
                                                            },
                                                            {
                                                                header:'URL de Video Grabaci&oacute;n',
                                                                width:280,
                                                                sortable:true,
                                                                dataIndex:'urlMultimedia',
                                                                editor:{xtype:'textfield'},
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	return val;
                                                                    }
                                                            }
                                                            ,
                                                            <?php
															}
															?>
                                                            {
                                                                header:'Hora de realizaci&oacute;n de audiencia',
                                                                width:280,
                                                                sortable:true,
                                                                dataIndex:'horaInicialReal',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	if(!val)
                                                                        {
                                                                        	return '(Datos no disponibles)';
                                                                        }
                                                                    	var comp='';
                                                                        if(val.format('d')!=registro.data.horaFinalReal.format('d'))
                                                                        {
                                                                        	comp=' del '+registro.data.horaFinalReal.format('d/m/Y');
                                                                        }

                                                                    	return 'De las '+val.format('H:i')+' hrs. a las '+registro.data.horaFinalReal.format('H:i')+' hrs.'+comp
                                                                    }
                                                            },
                                                            {
                                                                header:'Tipo de audiencia',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'tipoAudiencia',
                                                                renderer:function(val)
                                                                		{
                                                                        
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrAudiencias,val));
                                                                        }
                                                            },
                                                            {
                                                                header:'Edificio',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'edificio',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var lblSala=mostrarValorDescripcion(formatearValorRenderer(arrEdificios,val));
                                                                            
                                                                            
                                                                            
                                                                        	return lblSala;
                                                                        }
                                                            },
                                                            {
                                                                header:'Sala',
                                                                width:110,
                                                                sortable:true,
                                                                dataIndex:'sala',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var lblSala=mostrarValorDescripcion(formatearValorRenderer(arrSalas,val));
                                                                            
                                                                            
                                                                            
                                                                        	return lblSala;
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Juez',
                                                                width:320,
                                                                sortable:true,
                                                                dataIndex:'juez'
                                                            },
                                                            {
                                                                header:'Unidad de gesti&oacute;n',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'unidadGestion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrUnidades,val));
                                                                        }
                                                            },
                                                            {
                                                            	header:'Total imputados',
                                                                width:120,
                                                                sortable:true,
                                                                dataIndex:'tImputados'
                                                            },
                                                            {
                                                            	header:'Imputados',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'imputado',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                            	header:'V&iacute;ctimas',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'victima',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                            	header:'Delitos',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'delitos',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                            	header:'Carpeta de investigaci&oacute;n',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'carpetaInvestigacion',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                           
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                            {
                                                                id:'dEventos',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                clicksToEdit:1,
                                                                columnLines : true,      
                                                                plugins:	[filters],
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :true,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        
        
        tblGrid.on('afteredit',function(e)
        						{
                                	function funcAjax()
                                    {
                                        var resp=peticion_http.responseText;
                                        arrResp=resp.split('|');
                                        if(arrResp[0]=='1')
                                        {
                                            
                                        }
                                        else
                                        {
                                        	function resp()
                                            {
                                            	e.record.set(e.field,e.originalValue);
                                            }
                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0],resp);
                                        }
                                    }
                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=317&idEvento='+e.record.data.idEvento+'&campo='+e.field+'&valor='+e.value,true);	
                                }
        			)
        
        return 	tblGrid;

}

function formatearFila(record, rowIndex, p, ds)
{
	var comp='';
    switch(parseFloat(record.get('situacion')))
    {
    	case 0:
        	comp='filaEnEsperaConfirmacion';
        break;
        case 1:
        	comp='filaConfirmada';
        break;
        case 2:
        	comp='filaTerminada';
        break;
        case 3:
        	comp='filaCancelada';
        break;    
    }
	return 'x-grid3-row-expanded '+comp;
}


function registrarSolicitudAudiencia(iE,cA)
{
	
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var obj={};    
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[['idEventoReferencia',bD(iE)],['carpetaAdministrativa',bD(cA)],['idFormulario',185],['idRegistro',arrResp[1]],['idReferencia',-1],
            		['dComp',arrResp[2]],['actor',arrResp[3]]];
            window.parent.abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=52&iE='+bD(iE),true);
}

function recargarContenedorCentral()
{
	
}

function abrirFormatoRegistro(iF,iR)
{

	var obj={};    
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=[['idFormulario',bD(iF)],['idRegistro',bD(iR)],
                ['dComp',bE('auto')],['actor',bE(0)]];
    abrirVentanaFancySuperior(obj);
}

function reenviarMAJO(iE)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            gEx('dEventos').getStore().reload();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=83&iE='+bD(iE),true);
}

function abrirVentanaSala(iS,iE)
{
	var obj={};    
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/visorStreamSalaAudiencia.php';
    obj.params=[['idSala',iS],['cPagina','sFrm=true']]
    
    if(typeof(iE)!='undefined')
    	obj.params.push(['idEvento',(iE)]);
    abrirVentanaFancySuperior(obj);
}

function abrirVideoGrabacion(idEventoAudiencia)
{
	var obj={};    
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/visorGrabacionAudiencia.php';
    obj.params=[['idEvento',idEventoAudiencia],['cPagina','sFrm=true']]
    abrirVentanaFancySuperior(obj);
}


function ingresarAdministracionAudiencia(iA,cA)
{
	var obj={};    
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/tableroAudienciaAccesoSicore.php';
    obj.params=[['idEventoAudiencia',bD(iA)],['cPagina','sFrm=true']]
    abrirVentanaFancySuperior(obj);
}

function reenviarCabina(iE)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            gEx('gridAudiencias').getStore().reload();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=306&iE='+bD(iE),true);
}

function mostrarConfirmacionAudiencia(iE)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridParticipantesConfirmados(iE)
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Participantes confirmados',
										width: 750,
										height:380,
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

function crearGridParticipantesConfirmados(iE)
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idParticipante'},
		                                                {name: 'nombreParticipante'},
                                                        {name: 'figuraJuridica'},
		                                                {name:'codigoAcceso'},
		                                                {name:'fechaCreacionCodigo', type:'date', dateFormat: 'Y-m-d H:i:s'},
                                                        {name:'identificacion'},
                                                        {name:'nombreIdentificacion'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'nombreParticipante', direction: 'ASC'},
                                                            groupField: 'figuraJuridica',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='316';
                                        proxy.baseParams.idEvento=bD(iE);
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'identificacion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if(val!='')
	                                                                        	return '<a href="javascript:visualizarDocumentoAdjunto(\''+bE(registro.data.nombreIdentificacion)+'\',\''+bE(registro.data.identificacion)+'\')"><img src="../images/vcard.png"  title="Ver identificaci&oacute;n" alt="Ver identificaci&oacute;n" /></a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Figura Jur&iacute;dica',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'figuraJuridica',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrTipoFigura,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Participante',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'nombreParticipante'
                                                            },
                                                           	{
                                                                header:'C&oacute;digo de Acceso',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'codigoAcceso'
                                                            },
                                                            {
                                                                header:'Fecha de Creaci&oacute;n',
                                                                width:120,
                                                                sortable:true,
                                                                dataIndex:'fechaCreacionCodigo',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val)
	                                                                        	return val.format('d/m/Y H:i');
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridParticipantesCodigos',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :true,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: true,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;
}




function visualizarDocumentoAdjunto(ext,iD)
{
	var nombreDocumento=bD(ext);
	var arrExtension=nombreDocumento.split('.');
    ext=arrExtension[arrExtension.length-1];
    
	if(window.parent.parent)
		window.parent.parent.mostrarVisorDocumentoProceso(ext,bD(iD));
	else
        if(window.parent)
            window.parent.mostrarVisorDocumentoProceso(ext,bD(iD));
        else
            mostrarVisorDocumentoProceso(ext,bD(iD));
}