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
?>
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
                                                cls:'panelSiugj',
                                                layout:'border',
                                                tbar:	[	
                                                			{
                                                            	xtype:"tbspacer",
                                                                width:15
                                                            },
                                                			{
                                                            	xtype:'label',
                                                                
                                                                html:'<div class="letraNombreTableroNegro">Despacho:</div>&nbsp;&nbsp;<div style="color:#1A3E9A !important" class="letraNombreTableroNegro">'+gE('nombreUnidad').value+'</div>'
                                                            },
                                                            {
                                                                xtype:"tbspacer",
                                                                width:15
                                                            },
                                                            {
                                                                xtype:'label',
                                                                
                                                                html:'<div class="letraNombreTableroNegro">Periodo del:</div>'
                                                            },
                                                            {
                                                                xtype:"tbspacer",
                                                                width:15
                                                            },
                                                            {
                                                                xtype:'label',
                                                                html:'<div id="spFechaInicio" style="width:140px"></div>'
                                                            },
                                                            {
                                                                xtype:"tbspacer",
                                                                width:15
                                                            },
                                                            {
                                                                xtype:'label',
                                                                html:'<div class="letraNombreTableroNegro">al:</div>'
                                                            },
                                                            {
                                                                xtype:"tbspacer",
                                                                width:15
                                                            },
                                                            {
                                                                xtype:'label',
                                                                html:'<div id="spFechaFin" style="width:140px"></div>'
                                                            }
                                                            
                                                            
                                                           
                                                                
                                                		],
                                                items:	[
                                                            crearGridEventos()
                                                        ]
                                            }
                                         ]
                            }
                        )   
                        


	new Ext.form.DateField	(
                                {
                                    
                                
                                    xtype:'datefield',
                                    id:'dtePeriodoInicial',
                                    ctCls:'campoFechaSIUGJ',
                                    renderTo:'spFechaInicio',
                                    width:130,
                                    value:'<?php echo $fechaActual?>',
                                    listeners:	{
                                                    select:function()
                                                            {
                                                                recargarGridEventos();
                                                            }
                                                            
                                                }
                                
                                }
                            )
                            
                            
	new Ext.form.DateField	(
                                {
                                    xtype:'datefield',
                                    id:'dtePeriodoFinal',
                                    ctCls:'campoFechaSIUGJ',
                                    renderTo:'spFechaFin',
                                    width:130,
                                    value:'<?php echo $fechaActual?>',
                                    listeners:	{
                                                    select:function()
                                                            {
                                                                recargarGridEventos();
                                                            }
                                                            
                                                }
                                }
                            )                            
                            
	recargarGridEventos();                                                                        	
}


function recargarGridEventos()
{
	gEx('dEventos').getStore().reload();
    
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
                                                        {name: 'urlVideoConferencia'},
                                                        {name: 'conRecursosAdicionales'},
                                                        {name: 'recursosAdicionales'},
                                                        {name: 'notificacionCabina'},
                                                        {name: 'mensajeCabina'},
                                                        {name: 'audienciaVirtual'}                                                                                    
                                                                                                    
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
       
        var chkRow=new Ext.grid.CheckboxSelectionModel({checkOnly :false,width:40});
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            chkRow,
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
                                                                width:140,
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
                                                                width:210,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrSituacionEvento,val));
                                                                        }
                                                            },
                                                            {
                                                                header:'',
                                                                width:60,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                css:'text-align:left;vertical-align:middle !important;',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	
                                                                            var comp2='';
                                                                            
                                                                            
                                                                           	switch(val)
                                                                            {
	                                                                            case '1':
    	                                                                        case '4':
                                                                            	case '5':
                                                                                	if(registro.data.urlVideoConferencia!='')
                                                                                		comp2='<a href="javascript:abrirVideoConferencia(\''+bE(registro.data.urlVideoConferencia)+'\')"><img src="../images/user_go.png" title="Ingresar a Audiencia" alt="Ingresar a Audiencia" /></a>'
                                                                                break;
                                                                                case '2':
                                                                                	if(registro.data.urlMultimedia!='')
                                                                                    {
                                                                                    	if(registro.data.urlMultimedia.indexOf('sharepoint')==-1)
	                                                                                		comp2='<a href="javascript:abrirVideoGrabacion(\''+bE(registro.data.idEvento)+'\')"><img src="../images/control_play_blue.png" title="Visualizar grabaci&oacute;n" alt="Visualizar grabaci&oacute;n" /></a>'
                                                                              			else
                                                                                        	comp2='<a href="javascript:abrirVideoGrabacionTeams(\''+bE(registro.data.urlMultimedia)+'\')"><img src="../images/control_play_blue.png" title="Visualizar grabaci&oacute;n" alt="Visualizar grabaci&oacute;n" /></a>'
                                                                                	}
                                                                                break;
                                                                            }
                                                                            
                                                                            var comp='';
                                                                            if(registro.data.iRegistroSituacion!='-1')
                                                                            {
                                                                            	comp='<a href="javascript:abrirFormatoRegistro(\''+bE(registro.data.iFormularioSituacion)+'\',\''+
                                                                                		bE(registro.data.iRegistroSituacion)+'\')"><img src="../images/magnifier.png" title="Ver detalles..."'+
                                                                                        ' alt="Ver detalles..."></a> ';
                                                                            	if(comp2!='')
                                                                                	comp='&nbsp;&nbsp;'+comp;
                                                                            }
                                                                            
                                                                        	return comp2+comp;
                                                                        	
                                                                        }
                                                            },
                                                            {
                                                                header:'Proceso Judicial',
                                                                width:240,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa'
                                                            },
                                                            {
                                                                header:'Fecha de la audiencia',
                                                                width:210,
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
                                                                header:'Sede',
                                                                width:380,
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
                                                                width:280,
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
                                                                header:'URL Video Conferencia',
                                                                width:900,
                                                                align:'left',
                                                                sortable:true,
                                                                dataIndex:'urlVideoConferencia',
                                                                css:'text-align:left;vertical-align:middle !important;',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if(registro.data.urlVideoConferencia!='')
	                                                                        	return '<a href="javascript:abrirVideoConferencia(\''+bE(val)+'\')">'+mostrarValorDescripcion(val)+'</a>';
                                                                        }
                                                            }
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'dEventos',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                border:false,
                                                                cm: cModelo,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                sm:chkRow,
                                                                cls:'gridSiugjPrincipal',
                                                                columnLines : false,      
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
    obj.modal=true;
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
    obj.modal=true;
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
            gEx('dEventos').getStore().reload();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=306&iE='+bD(iE),true);
}

function actualizarSituacionAudiencia(s)
{
	var lblSituacion='';
   
    switch(s)
    {
    	case 1:
        	lblSituacion='Confirmadas';
           
        break;
        case 2:
        	lblSituacion='Finalizadas';
            
        break;
        case 3:
        	lblSituacion='Canceladas';
             
        break;
    }
	var fila=gEx('dEventos').getSelectionModel().getSelections();
    if(fila.length==0)
    {
        msgBox('Debe seleccionar la audiencia cuya situaci&oacute;n desea cambiar');
        return;
    }
    
    
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            width:550,
                                                            height:60,
                                                            id:'txtComentariosAdicionales',
                                                            xtype:'textarea'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Marcar audiencias como '+lblSituacion,
										width: 600,
										height:200,
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
                                                                	gEx('txtComentariosAdicionales').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		function resp(btn)
                                                                        {
                                                                            if(btn=='yes')
                                                                            {
                                                                                var lAudiencias='';
                                                                                var x;
                                                                                for(x=0;x<fila.length;x++)
                                                                                {
                                                                                    if(lAudiencias=='')
                                                                                        lAudiencias=fila[x].data.idEvento;
                                                                                    else
                                                                                        lAudiencias+=','+fila[x].data.idEvento;
                                                                                }
                                                                                
                                                                                function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                        gEx('dEventos').getStore().reload();
                                                                                        ventanaAM.close();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Juzgados.php',funcAjax, 'POST','funcion=8&lAudiencias='+lAudiencias+'&s='+s+'&c='+cv(gEx('txtComentariosAdicionales').getValue()),true);
                                                                            }
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer marcar las audiencias como <b>'+lblSituacion+'</b>?',resp);
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

function recargarGridEventos()
{
	gEx('dEventos').getStore().reload();
    
}

function abrirVideoGrabacionTeams(url)
{
	var winFeatures = 'screenX=0,screenY=0,top=0,left=0,scrollbars,width=100,height=100';
    var winName = 'window';
    var win = window.open(bD(url),winName, winFeatures); 
    var extraWidth = win.screen.availWidth - win.outerWidth;
    var extraHeight = win.screen.availHeight - win.outerHeight;
    win.resizeBy(extraWidth, extraHeight);
    
    var timer = setInterval(function() { 
                                            if(win.closed) 
                                            {
                                                clearInterval(timer);
                                                
                                            }
                                        }, 1000);
    
    return win;
}

function abrirVideoConferencia(url)
{
	window.open(bD(url), '_blank');

}