<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

var carpetaAdministrativa;
Ext.onReady(inicializar);

function inicializar()
{
	carpetaAdministrativa=-1;
    
    
   var oConf=	{
                            idCombo:'cmbCarpetaJudicial',
                            anchoCombo:350,
                            raiz:'registros',
                            campoDesplegar:'carpetaAdministrativa',
                            campoID:'carpetaAdministrativa',
                            funcionBusqueda:47,
                            //listClass:"listComboSIUGJ", 
                            //cls:"comboSIUGJBusqueda",
                            //height:30,
                            emptyText:'Buscar Proceso Judicial',
                            //fieldClass:"comboSIUGJBusqueda",
                            //ctCls:"comboWrapSIUGJBusqueda",
                            paginaProcesamiento:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                            confVista:'<tpl for="."><div class="search-item">{carpetaAdministrativa}<br></div></tpl>',
                            campos:	[
                                        {name:'carpetaAdministrativa'},
                                        {name:'idCarpeta'}
    
                                    ],
                            funcAntesCarga:function(dSet,combo)
                                        {
                                            carpetaAdministrativa=-1;
                                            idCarpeta=-1;
                                            var aValor=combo.getRawValue();
                                            dSet.baseParams.criterio=aValor;
                                            dSet.baseParams.uG='';
                                            
                                            
                                            
                                        },
                            funcElementoSel:function(combo,registro)
                                        {
                                            carpetaAdministrativa=registro.data.carpetaAdministrativa;
                                            idCarpeta=registro.data.idCarpeta;
                                            cargarEventosExpediente(carpetaAdministrativa);
                                           
                                            
                                            
                                        }  
                        };

		var carpetaJudicial=crearComboExtAutocompletar(oConf);
    
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b>Eventos</b></span>',
                                                tbar:	[
                                                         	{
                                                            	
                                                                html:'<b>Proceso Judicial:</b>&nbsp;&nbsp;'
                                                            } ,
                                                            carpetaJudicial  ,'-',
                                                            {
                                                              icon:'../images/arrow_refresh.PNG',
                                                              cls:'x-btn-text-icon',
                                                              text:'Recargar Eventos',
                                                              handler:function()
                                                                      {
                                                                          gEx('gEventosExpediente').getStore().reload();
                                                                      }
                                                              
                                                          }
                                                        ],
                                               items:	[
                                               				crearGridEventosProcesosJudiciales()
                                               			]
                                            }
                                         ]
                            }
                        )   
}


function crearGridEventosProcesosJudiciales()
{
	var arrSituacionActual=[['1','Activo'],['2','Atendido/Cumplido'],['3','Vencido/Incumplido'],['5','Suspendido']];
	var arrTiposRegistro=[['2','Actuaci&oacute;n'],['3','Cambio de Etapa Procesal'],['4','T&eacute;rmino Procesal'],['5','Temporizador'],['6','Notificaci&oacute;n']];
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name:'fechaRegistro', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'fechaMaximaAtencion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'iFormulario'},
                                                        {name: 'iRegistro'},
                                                        {name: 'tipoRegistro'},
                                                        {name: 'lblEtiquetaRegistro'},
                                                        {name: 'situacionActual'},
                                                        {name:'detalleComplementario'},
                                                        {name:'idUsuarioAsignacion'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaRegistro', direction: 'ASC'},
                                                            groupField: 'fechaRegistro',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	gEx('btnCumplido').disable();
                                        gEx('btnInCumplido').disable();
                                        gEx('btnArranque').disable();
                                    	proxy.baseParams.funcion='31';
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'iFormulario',
                                                                renderer:function(val,meta,registro)
                                                                        {
                                                                            return '<a href="javascript:abrirProcesoOrigen(\''+bE(val)+'\',\''+bE(registro.data.iRegistro)+'\')"><img src="../images/magnifier.png" title="Abrir proceso origen" alt="Abrir proceso origen" /></a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Fecha de Registro',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'fechaRegistro',
                                                                renderer:function(val)
                                                                			{
                                                                            	return val.format('d/m/Y H:i');
                                                                            }
                                                            },
                                                            {
                                                                header:'Tipo de Registro',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'tipoRegistro',
                                                                renderer:function(val)
                                                                			{
                                                                            	return formatearValorRenderer(arrTiposRegistro,val)
                                                                            }
                                                            },
                                                            {
                                                                header:'Etiqueta',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'lblEtiquetaRegistro',
                                                                renderer:function(val)
                                                                			{
                                                                            	return mostrarValorDescripcion(val);
                                                                            }
                                                            },
                                                            {
                                                                header:'Complementario',
                                                                width:500,
                                                                sortable:true,
                                                                dataIndex:'detalleComplementario',
                                                                renderer:function(val)
                                                                			{
                                                                            	return mostrarValorDescripcion(val);
                                                                            }
                                                            },
                                                            {
                                                                header:'Usuario Asignado',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'idUsuarioAsignacion',
                                                                renderer:function(val)
                                                                			{
                                                                            	return mostrarValorDescripcion(val);
                                                                            }
                                                            },
                                                            {
                                                                header:'Fecha de M&aacute;x. de Atenci&oacute;n',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'fechaMaximaAtencion',
                                                                renderer:function(val)
                                                                			{
                                                                            	if(val)
	                                                                            	return val.format('d/m/Y H:i');
                                                                            }
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n Actual',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'situacionActual',
                                                                renderer:function(val)
                                                                			{
                                                                            	return formatearValorRenderer(arrSituacionActual,val);
                                                                            }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gEventosExpediente',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                tbar:	[
                                                                			{
                                                                            	id:'btnArranque',
                                                                                icon:'../images/process_accept.png',
                                                                                cls:'x-btn-text-icon',
                                                                                disabled:true,
                                                                                text:'Ejecutar Arranque',
                                                                                handler:function()
                                                                                        {
                                                                                        	var fila=gEx('gEventosExpediente').getSelectionModel().getSelected();
                                                                                            function resp(btn)
                                                                                            {
                                                                                            	if(btn=='yes')
                                                                                                {
                                                                                                	function funcAjax()
                                                                                                    {
                                                                                                        var resp=peticion_http.responseText;
                                                                                                        arrResp=resp.split('|');
                                                                                                        if(arrResp[0]=='1')
                                                                                                        {
                                                                                                            gEx('gEventosExpediente').getStore().reload();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',funcAjax, 'POST','funcion=32&iFormulario='+fila.data.iFormulario+'&iRegistro='+fila.data.iRegistro+'&idRegistro='+fila.data.idRegistro+'&situacion=1',true);
                                                                                                    
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer ejecutar el arranque del elemento seleccionado?',resp);
                                                                                        }
                                                                            
                                                                            },'-',
                                                                			{
                                                                            	id:'btnCumplido',
                                                                                icon:'../images/icon_big_tick.gif',
                                                                                cls:'x-btn-text-icon',
                                                                                disabled:true,
                                                                                text:'Marcar como Atendido/Cumplido',
                                                                                handler:function()
                                                                                        {
                                                                                        	var fila=gEx('gEventosExpediente').getSelectionModel().getSelected();
                                                                                            function resp(btn)
                                                                                            {
                                                                                            	if(btn=='yes')
                                                                                                {
                                                                                                	function funcAjax()
                                                                                                    {
                                                                                                        var resp=peticion_http.responseText;
                                                                                                        arrResp=resp.split('|');
                                                                                                        if(arrResp[0]=='1')
                                                                                                        {
                                                                                                            gEx('gEventosExpediente').getStore().reload();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',funcAjax, 'POST','funcion=32&iFormulario='+fila.data.iFormulario+'&iRegistro='+fila.data.iRegistro+'&idRegistro='+fila.data.idRegistro+'&situacion=2',true);
                                                                                                    
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer marcar el elemento como Atendido/Cumplido?',resp);
                                                                                        }
                                                                            
                                                                            },'-',
                                                                            {
                                                                            	id:'btnInCumplido',
                                                                                icon:'../images/cross.png',
                                                                                cls:'x-btn-text-icon',
                                                                                disabled:true,
                                                                                text:'Marcar como Vencido/Incumplido',
                                                                                handler:function()
                                                                                        {
                                                                                        	var fila=gEx('gEventosExpediente').getSelectionModel().getSelected();
                                                                                            function resp(btn)
                                                                                            {
                                                                                            	if(btn=='yes')
                                                                                                {
                                                                                                	function funcAjax()
                                                                                                    {
                                                                                                        var resp=peticion_http.responseText;
                                                                                                        arrResp=resp.split('|');
                                                                                                        if(arrResp[0]=='1')
                                                                                                        {
                                                                                                            gEx('gEventosExpediente').getStore().reload();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',funcAjax, 'POST','funcion=32&iFormulario='+fila.data.iFormulario+'&iRegistro='+fila.data.iRegistro+'&idRegistro='+fila.data.idRegistro+'&situacion=3',true);
                                                                                                    
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer marcar el elemento como Vencido/Incumplido?',resp);
                                                                                           
                                                                                        
                                                                                        }
                                                                                
                                                                            }
                                                                		],
                                                                
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :false,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );

		gEx('gEventosExpediente').getSelectionModel().on('rowselect',function(sm,rowIndex,registros)
        															{
                                                                    	gEx('btnCumplido').disable();
                                                                        gEx('btnInCumplido').disable();
                                                                        gEx('btnArranque').disable();
                                                                        switch(registros.data.tipoRegistro)
                                                                        {
                                                                        	case '4':
                                                                            	gEx('btnCumplido').enable();
                                                                                gEx('btnArranque').enable();
                                                                        		gEx('btnInCumplido').enable();
                                                                            break;
                                                                            case '5':
                                                                            	 gEx('btnArranque').enable();
                                                                            	gEx('btnInCumplido').enable();
                                                                            break;
                                                                        }
                                                                	}
                                                        )				
		
        
        gEx('gEventosExpediente').getSelectionModel().on('rowdeselect',function(sm,rowIndex,registros)
        															{
                                                                    	gEx('btnCumplido').disable();
                                                                        gEx('btnInCumplido').disable();
                                                                        gEx('btnArranque').disable();
                                                                	}
                                                        )
        return 	tblGrid;	
}

function cargarEventosExpediente(cAdministrativa)
{
	gEx('gEventosExpediente').getStore().load	(
    												{
                                                    	url:'../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',
                                                        params: {
                                                        			carpetaAdministrativa:cAdministrativa
                                                        		}
                                                    }
    											);
}

function abrirProcesoOrigen(iF,iR)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=[['idFormulario',bD(iF)],['idRegistro',bD(iR)],['actor',bE(0)],['dComp',bE('auto')]];
    abrirVentanaFancySuperior(obj);
    
    
}