<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
?>

var oComp=null;
Ext.onReady(inicializar);

function inicializar()
{
	var oDocumento=eval('['+bD(gE('datosDocumento').value)+']')[0];   
    
   	oComp=bD(gE('oComp').value);

    if(oComp!='')
    {
    	oComp=eval('['+oComp+']')[0];
    }
    else
    {
    	oComp={};
    }
    
  	var arrBar=null;
    if(gE('ocultarBarraSuperior').value=='0')
    {
    	arrBar=		[
                      {
                          xtype:'label',
                          html:'<b>Documento: </b><span title="'+oDocumento.nombreArchivo+'" alt="'+oDocumento.nombreArchivo+'">'+
                          		(oDocumento.nombreArchivo.length>40?oDocumento.nombreArchivo.substr(0,37)+'...':oDocumento.nombreArchivo)+'<span>'
                      },'-',
                      {
                          xtype:'label',
                          html:'<b>Tama&ntilde;o: </b>'+bytesToSize(parseInt(oDocumento.tamano),0)
                      },'-',
                      {
                          xtype:'label',
                          html:'<b>Formato: </b>'+oDocumento.extension.toUpperCase()
                      },'-',
                      {
                          xtype:'label',
                          html:'<b>Fecha de registro: </b>'+Date.parseDate(oDocumento.fechaCreacion,'Y-m-d H:i:s').format('d/m/Y H:i')+' hrs.'
                      },'-',
                      {
                          xtype:'label',
                          hidden:oDocumento.subidoPor=='[]',
                          html:'<b>Subido por: </b>'+oDocumento.subidoPor
                      },'-',
                      {
                          icon:'../images/download.png',
                          cls:'x-btn-text-icon',
                          text:'Descargar documento',
                          handler:function()
                                  {
                                      location.href=oDocumento.urlContenido+'?id='+bE('documento_'+gE('iDocumento').value)+'&nombreArchivo='+oDocumento.nombreArchivo;
                                  }
                          
                      },'-',
                      {
                          icon:'../images/magnifier.png',
                          cls:'x-btn-text-icon',
                          hidden:((!oComp.idFormulario) || (oComp.idFormulario=='-1')) ,
                          text:'Ver proceso asociado...',
                          handler:function()
                                  {
                                      var oParam=[['idFormulario',oComp.idFormulario],['idRegistro',oComp.idRegistro],['dComp',bE('auto')],['actor',bE(oComp.actor)]];
                                      enviarFormularioDatos('<?php echo $visorExpedienteProcesos?>',oParam);
                                  }
                          
                      },'-',
                      {
                          icon:'../images/user_go.png',
                          cls:'x-btn-text-icon',
                          <?php echo (existeRol("'155_0'") || existeRol("'191_0'"))?"":"hidden:true,";?>
                          text:'Delegar tarea',
                          handler:function()
                                  {
                                      mostrarVentanaAsignarTarea()
                                  }
                          
                      }
                      
                      
                  ];
    }
    
    var objConf={};
    objConf.confGrid={};
    objConf.confGrid.region='center';
    objConf.idFormulario=gE('categoriaDocumento').value=='52'?-5:'-6';
    objConf.idRegistro=gE('iRegistroMedidaCautelar').value;
    objConf.carpetaAdministrativa=gE('carpetaAdministrativa').value;
    objConf.idCarpetaJudicialBase=-1;
    objConf.expandidoFormatos=true;
    objConf.mostrarGridProgramacionAlerta=false;
    objConf.functionAfterSignDocument=function()
    									{
                                        	marcarTareaAtendida(oComp.iTablero,oComp.iActividad);
                                        }
    objConf.parametrosFuncionesLlenado=	[
    										['iC',gE('idCarpetaAdministrativa').value],
                                            ['c',gE('carpetaAdministrativa').value],
                                            ['iDocumento',gE('iDocumento').value]
                                            
    									];
    
    
    objConf.permitePDFDirecto=true;
    objConf.funcionAfterLoadPDF=registrarPDFRespuesta;
    
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                tbar:	arrBar,
                                                items:	[
                                                			{
                                                            	xtype:'panel',
                                                                height:220,
                                                                region:'south',
                                                                layout:'border',
                                                                title:'Respuestas enviadas',
                                                                collapsible:true,
                                                                items:	[
                                                                			
                                                                			crear_CGridGeneracionDocumentos(objConf)
                                                                            	
                                                                		]
                                                                
                                                            },
                                                            new Ext.ux.IFrameComponent({ 
  
                                                                                              id: 'frameContenido', 
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
                        ) 
	
    var parametros={};
	var urlViewer='../visoresGaleriaDocumentos/';                        
	var pos=existeValorMatriz(arrVisores,oDocumento.extension.toLowerCase());                        
	if(pos==-1)                        
    {
    	urlViewer+='noViewer.php';
    }
    else
    {

    	urlViewer+=arrVisores[pos][1];
        parametros={urlDoc:bE(oDocumento.urlContenido+'?id='+bE('documento_'+gE('iDocumento').value)+'&nombreArchivo='+oDocumento.nombreArchivo)}
     }                   
	gEx('frameContenido').load	(
    
    								{
    									url:urlViewer,
                                        params:parametros	
                                     }
    							)                        
                          
}


function registrarPDFRespuesta(idArchivo,nombreArchivo)
{
    var cadObj='{"tipoDocumento":"'+(gE('categoriaDocumento').value=='52'?'506':'520')+'","idArchivo":"'+idArchivo+
    			'","nombreArchivo":"'+nombreArchivo+'","idFormulario":"'+(gE('categoriaDocumento').value=='52'?-5:'-6')+
                '","idRegistro":"'+gE('iRegistroMedidaCautelar').value+'"}';
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            gEx('gDocumentosCGrid').getStore().reload();
            marcarTareaAtendida(oComp.iTablero,oComp.iActividad);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_cGeneracionDocumentosGrid.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true);
}

function mostrarVentanaAsignarTarea()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Seleccione al usuario al cual desea asignar la tarea:'
                                                        },
                                            			creaGridDelegarTarea()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Delegar tarea',
										width: 800,
										height:420,
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
                                                                    	
                                                                    	var fila=gEx('gTareas').getSelectionModel().getSelected();
                                                                        if(!fila)
                                                                        {
                                                                        	msgBox('Debe seleccionar la persona a la cual desea asignar la tarea');
                                                                        	return;
                                                                        }
																		function resp(btn)
                                                                        {
                                                                            if(btn=='yes')
                                                                            {
                                                                                var x;
                                                                                var f;
                                                                                var actividadesDelegadas=oComp.iActividad;
                                                                                
                                                                                var cadObj='{"idTablero":"'+oComp.iTablero+'","lblEtiqueta":"'+cv(fila.data.nombre)+'","idUsuario":"'+fila.data.idUsuario+'","actividadesDelegadas":['+actividadesDelegadas+']}';
                                                                            
                                                                                function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                    	window.parent.mostrarTableroNotificaciones(bE(oComp.iTablero));
                                                                                    	gEx('gTareas').getStore().reload();
                                                                                    	function respAux()
                                                                                        {
                                                                                        
                                                                                        	ventanaAM.close();
                                                                                        }
                                                                                        msgBox('La actividad ha sido asignada correctamente a <b>'+fila.data.nombre+'</b>',respAux);
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=243&cadObj='+cadObj,true);
                                                                            }
                                                                            
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer delegar la actividad a:<br><br><b>'+fila.data.nombre+'</b>?',resp);
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

function creaGridDelegarTarea()
{
	var filters = new Ext.ux.grid.GridFilters	(
    												{
                                                    	filters:	[ 
                                                        				{type: 'string', dataIndex: 'nombre'}
                                                                    ]
                                                    }
                                                );   
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idUsuario'},
		                                                {name: 'nombre'},
		                                                {name:'tareasAsignadas'},
		                                                {name: 'tareasAtendidas'},
                                                        {name: 'tareasPorAtender'},
                                                        {name: 'asignado'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_MedidasCautelares.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'nombre', direction: 'ASC'},
                                                            groupField: 'nombre',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='2';
                                        proxy.baseParams.iT=oComp.iTablero;
                                        proxy.baseParams.cD=gE('categoriaDocumento').value;

                                    }
                        )   

	var chkRow=new Ext.grid.CheckboxSelectionModel({sigleSelect:true});       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:30}),
                                                            chkRow,
                                                             {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'asignado',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val=='1')
                                                                            	return '<img src="../images/accept_green.png" title="Asignado" alt="Asignado" width="14" height="14">';
                                                                        }
                                                            },
                                                            {
                                                                header:'Nombre',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'nombre'
                                                            },
                                                            {
                                                                header:'Tareas asignadas',
                                                                width:130,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'tareasAsignadas',
                                                                renderer:function(val)
                                                                			{
                                                                            	return Ext.util.Format.number(val,'0,000');
                                                                            }
                                                            },
                                                            {
                                                                header:'Tareas atendidas',
                                                                width:130,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'tareasAtendidas',
                                                                renderer:function(val)
                                                                			{
                                                                            	return Ext.util.Format.number(val,'0,000');
                                                                            }
                                                            },
                                                            {
                                                                header:'Tareas por atender',
                                                                width:130,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'tareasPorAtender',
                                                                renderer:function(val)
                                                                			{
                                                                            	return Ext.util.Format.number(val,'0,000');
                                                                            }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gTareas',
                                                                store:alDatos,
                                                                x:10,
                                                                y:40,
                                                                sm:chkRow,
                                                                width:800,
                                                                height:300,
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                plugins:[filters],
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

