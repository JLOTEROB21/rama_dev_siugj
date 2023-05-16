<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT idRegistro,tipoTarea,scriptEjecucion,paginaEjecucion FROM 9077_tiposTareasProgramadas";
	$arrTareas=$con->obtenerFilasArreglo($consulta);
	
	$fechaActual=date("Y-m-d");
	
	
	if(existeRol("'112_0'"))
	{
		$consulta="SELECT idRegistro,tipoTarea,scriptEjecucion,paginaEjecucion FROM 9077_tiposTareasProgramadas
					where idRegistro in(2,8)";
		$arrTareas=$con->obtenerFilasArreglo($consulta);
	}
	

?>
var arrSituacionTarea=[['1','Terminado','077315'],['2','Con errores','F00'],['0','Inconcluso','AAA']];
var arrTareas=<?php echo $arrTareas?>;
Ext.onReady(inicializar);

function inicializar()
{
	var cmbTipoTarea=crearComboExt('cmbTipoTarea',arrTareas,0,0,300);
    cmbTipoTarea.on('select',function(cmb,registro)
    						{
                            	gEx('btnEjecutarTarea').disable();
                            	recargarGridEventos();
                                if(registro.data.valorComp!='')
                                {
                                	gEx('btnEjecutarTarea').enable();
                                }
                            }
    				);
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b>Tareas Ejecutadas</b></span>',
                                                tbar:	[	
                                                			{
                                                            	xtype:'label',
                                                                html:'&nbsp;&nbsp;&nbsp;<b>Tipo de Tarea:</b>&nbsp;&nbsp;&nbsp;'
                                                            },
                                                            cmbTipoTarea,
                                                            {
                                                                icon:'../images/cog.png',
                                                                cls:'x-btn-text-icon',
                                                                disabled:true,
                                                                id:'btnEjecutarTarea',
                                                                text:'Ejecutar Tarea...',
                                                                handler:function()
                                                                        {
                                                                            var pos= existeValorMatriz(arrTareas,cmbTipoTarea.getValue());
                                                                            var pagina=arrTareas[pos][3];
                                                                           	
                                                                            var obj={};
                                                                            obj.ancho='90%';
                                                                            obj.alto='90%';
                                                                            obj.url='../tareasProgramadas/'+pagina;
                                                                            obj.params=[['mE',1],['fechaInicio',gEx('dtePeriodoInicial').getValue().format('Y-m-d')],['fechaFin',gEx('dtePeriodoFinal').getValue().format('Y-m-d')]];
                                                                            obj.funcionCerrar=function()
                                                                            					{
                                                                                                	gEx('gTareas').getStore().reload();
                                                                                                }
                                                                            abrirVentanaFancy(obj);
                                                                            
                                                                        }
                                                                
                                                            },
                                                            '-',
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
                                                            },'-',
                                                            {
                                                                  icon:'../images/arrow_refresh.PNG',
                                                                  cls:'x-btn-text-icon',
                                                                  text:'Recargar',
                                                                  handler:function()
                                                                          {
                                                                              recargarGridEventos()
                                                                          }
                                                                  
                                                              }
                                                		],
                                                items:	[
                                                            crearGridRegistroTareasProgramadas()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}

function crearGridRegistroTareasProgramadas()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idTarea'},
		                                                {name: 'tipoTarea'},
		                                                {name:'fechaEjecucion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'resultado'},
                                                        {name:'fechaTerminoEjecucion', type:'date', dateFormat:'Y-m-d H:i:s'},
														{name: 'comentariosAdicionales'},
                                                        {name: 'totalRegistrosInvolucrados'},
                                                        {name: 'totalRegistrosAtendidos'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_TareasProgramadas.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaEjecucion', direction: 'ASC'},
                                                            groupField: 'fechaEjecucion',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='1';
                                        
                                    }
                        )   
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer({width:30}),
                                                        
                                                        {
                                                            header:'Tipo tarea',
                                                            width:300,
                                                            sortable:true,
                                                            dataIndex:'tipoTarea',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrTareas,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Hora Inicio',
                                                            width:120,
                                                            sortable:true,
                                                            dataIndex:'fechaEjecucion',
                                                            renderer:function(val)
                                                            			{
                                                                        	return val.format('d/m/Y H:i:s');
                                                                        }
                                                        },
                                                         {
                                                            header:'Situaci&oacute;n tarea',
                                                            width:180,
                                                            align:'center',
                                                            sortable:true,
                                                            dataIndex:'resultado',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrSituacionTarea,val,1,false,true);
                                                                    }
                                                        },
                                                        {
                                                            header:'Hora T&eacute;rmino',
                                                            width:120,
                                                            sortable:true,
                                                            dataIndex:'fechaTerminoEjecucion',
                                                            renderer:function(val)
                                                            			{
                                                                        	if(val)
	                                                                        	return val.format('d/m/Y H:i:s');
                                                                             return '--/--/---- --:--:--';
                                                                        }
                                                        },
                                                        {
                                                            header:'# Elementos<br />Involucrados',
                                                            width:110,
                                                            align:'center',
                                                            sortable:true,
                                                            dataIndex:'totalRegistrosInvolucrados',
                                                            renderer:function(val)
                                                            		{
                                                                    	return val;
                                                                    }
                                                        },
                                                        {
                                                            header:'# Elementos<br />Atendidos',
                                                            width:110,
                                                            align:'center',
                                                            sortable:true,
                                                            dataIndex:'totalRegistrosAtendidos',
                                                            renderer:function(val)
                                                            		{
                                                                    	return val;
                                                                    }
                                                        }
                                                        
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gTareas',
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
                                                                                                enableGrouping :false,
                                                                                                enableNoGroups:false,
                                                                                                enableGroupingMenu:false,
                                                                                                hideGroupedColumn: false,
                                                                                                startCollapsed:false
                                                                                            })
                                                        }
                                                    );
    return 	tblGrid;	
}

function recargarGridEventos()
{
	gEx('gTareas').getStore().load	(
    									{
                                        	url: '../paginasFunciones/funcionesModulosEspeciales_TareasProgramadas.php',
                                            params:	{
                                            			funcion:'1',
                                                        tipoTarea:gEx('cmbTipoTarea').getValue(),
                                                        fechaInicio:gEx('dtePeriodoInicial').getValue().format('Y-m-d'),
                                                        fechaFin:gEx('dtePeriodoFinal').getValue().format('Y-m-d')
                                            		}
                                        }
    								);
}