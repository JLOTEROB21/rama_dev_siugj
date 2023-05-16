<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$fechaActual=date("Y-m-d");
	$dia=date("w",strtotime($fechaActual));

	$fechaInicial=date("Y-m-d",strtotime("-".$dia." days",strtotime($fechaActual)));
	
	
	$arrSituacion="";
	$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=283 ORDER BY numEtapa";
	$resEtapas=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($resEtapas))
	{
		$o="[".$fila[0].",'".removerCerosDerecha($fila[0]).".- ".$fila[1]."']";
		if($arrSituacion=="")
			$arrSituacion=$o;
		else
			$arrSituacion.=",".$o;
	}
	$arrSituacion="[".$arrSituacion."]";
?>


var arrSituacion=<?php echo $arrSituacion?>;
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
                                                items:	[
                                                            crearGridTutelas()
                                                        ]
                                            }                             
                                           
                                         ]
                            }
                        )  
}


function crearGridTutelas()
{
	var tblGrid=null;
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'idFormulario'},
                                                        {name:'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'folioRegistro'},
                                                        {name:'carpetaAdministrativa'},
                                                        {name:'despachoEnvio'},
                                                        {name:'cuentaFicha'},
                                                        {name:'folioCorteConstitucional'} ,
                                                        {name:'idEstado'},
                                                        {name: 'candidato'}                                                        
		                                                
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaCreacion', direction: 'ASC'},
                                                            groupField: 'fechaCreacion',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='10';
                                        proxy.baseParams.iRef=gE('idRegistro').value;
                                    }
                        )   

	
    alDatos.on('load',function(proxy)
    								{
                                    	
                                    }
                        )   
	var chkRow=new Ext.grid.CheckboxSelectionModel({width:30});
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:30}),
                                                            chkRow,
                                                            {
                                                                header:'Fecha de Creaci&oacute;n',
                                                                width:190,
                                                                sortable:true,
                                                                dataIndex:'fechaCreacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i');
                                                                        }
                                                            },
                                                            {
                                                                header:'Folio de Registro',
                                                                width:160,
                                                                sortable:true,
                                                                dataIndex:'folioRegistro',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return '<a href="javascript:abrirTutela(\''+bE(registro.data.idFormulario)+'\',\''+bE(registro.data.idRegistro)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Folio Corte Constitucional',
                                                                width:240,
                                                                sortable:true,
                                                                dataIndex:'folioCorteConstitucional'
                                                            },
                                                            {
                                                                header:'C&oacute;digo &Uacute;nico de Proceso',
                                                                width:240,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa'
                                                            },
                                                            {
                                                                header:'Despacho que Env&iacute;a',
                                                                width:550,
                                                                sortable:true,
                                                                dataIndex:'despachoEnvio'
                                                            },
                                                            {
                                                                header:'Estudio Conclu&iacute;do',
                                                                width:170,
                                                                sortable:true,
                                                                dataIndex:'idEstado',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(parseInt(val)!=5)
                                                                            	return '<img src="../images/cancel_round.png" title="Estudio NO Conlu&iacute;do" alt="Estudio NO Conlu&iacute;do">&nbsp&nbsp;No';
                                                                        	else
                                                                            	return '<img src="../images/accept_green.png" title="Estudio Conlu&iacute;do" alt="Estudio Conlu&iacute;do">&nbsp&nbsp;S&iacute;';
                                                                            
                                                                        }
                                                            },
                                                            {
                                                                header:'Candidato a Selecci&oacute;n',
                                                                width:210,
                                                                sortable:true,
                                                                dataIndex:'candidato',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(parseInt(val)==1)
                                                                            	return '<span style="color:#030; font-weight:bold">S&iacute;';
                                                                        	else
                                                                            	return '<span style="color:#900; font-weight:bold">No';
                                                                            
                                                                        }
                                                            }
                                                             
                                                            
                                                        ]
                                                    );
                                                    
	var objConf=	{
                        id:'gTutelasAsignadas',
                        store:alDatos,
                        region:'center',
                        frame:false,
                        cm: cModelo,
                        sm:chkRow,
                        cls:'gridSiugjPrincipal',
                        border:false,
                        stripeRows :false,
                        loadMask:true,
                        columnLines : false,     
                        view:new Ext.grid.GroupingView({
                                                            forceFit:false,
                                                            showGroupName: false,
                                                            enableGrouping :false,
                                                            enableNoGroups:false,
                                                            enableGroupingMenu:false,
                                                            hideGroupedColumn: false,
                                                            startCollapsed:false
                                                        })
                    }  ;
    
    if(gE('sL').value=='0')
    {
    	objConf.tbar=	[
        					
                          {
                              icon:'../images/add.png',
                              cls:'x-btn-text-icon',
                              text:'Agregar Tutela',
                              hidden:gE('sL').value=='1',
                              handler:function()
                                      {
                                          mostrarAgregarVentanaTutelas(tblGrid);
                                      }
                              
                          },'-',
                          {
                              icon:'../images/delete.png',
                              cls:'x-btn-text-icon',
                               hidden:gE('sL').value=='1',
                              text:'Remover Tutela',
                              handler:function()
                                      {
                                          var filas=tblGrid.getSelectionModel().getSelections();
                                          if(filas.length==0)
                                          {
                                              msgBox('Debe seleccionar almenos una tutela a remover');
                                              return;
                                          }
                      
                                          var x;
                                          var fila;
                                          var arrRegistros='';
                                          for(x=0;x<filas.length;x++)
                                          {
                                              fila=filas[x];
                                              
                                              if(arrRegistros=='')
                                                  arrRegistros=fila.data.idRegistro;
                                              else
                                                  arrRegistros+=','+fila.data.idRegistro;
                                                  
                                             
                                              
                                          }
                                          
                                          
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
                                                         
                                                          tblGrid.getStore().reload();
                                                          
                                                      }
                                                      else
                                                      {
                                                          msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                      }
    
                                                  }
                                                  obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',funcAjax, 'POST','funcion=14&arrRegistros='+arrRegistros,true);
                                              }
                                              
                                          }
                                          msgConfirm('Est&aacute; seguro de querer remover las tutelas seleccionadas',resp)
                                          
                                          
                                          
                                      }
                              
                          }
                                    
                                
        				]
    }
    														                                                  
                                                    
                                                    
        tblGrid=	new Ext.grid.GridPanel	(objConf);
        return 	tblGrid;	
}



function mostrarAgregarVentanaTutelas(tblGrid)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
                                            
											items: 	[
                                            			{
                                                        	xtype:'panel',
                                                            cls:'panelSiugj',
                                                            region:'center',
                                                            border:false,
                                                            layout:'border',
                                                            tbar:	[
                                                                        {
                                                                            xtype:'label',
                                                                            cls:'SIUGJ_ControlEtiqueta',
                                                                            html:'&nbsp;&nbsp;&nbsp;<b>Periodo del:</b>&nbsp;&nbsp;&nbsp;'
                                                                        },
                                                                        {
                                                                            xtype:'label',
                                                                            html:'<div id="divDtePeriodoInicial" style="width:150px"></div>'
                                                                        },
                                                                        {
                                                                            xtype:'label',
                                                                             cls:'SIUGJ_ControlEtiqueta',
                                                                            html:'&nbsp;&nbsp;&nbsp;<b>al:</b>&nbsp;&nbsp;&nbsp;'
                                                                        },
                                                                        {
                                                                            xtype:'label',
                                                                            html:'<div id="divDtePeriodoFinal" style="width:150px"></div>'
                                                                        }
                                                                        
                                                                    ],  
                                                            items:	[
                                                            			crearGridTutelasAgregar()
                                                            		]
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Tutelas',
										width: 950,
										height:450,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
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
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
                                                            
															handler: function()
																	{
																		var filas=gEx('gTutelasAgregar').getSelectionModel().getSelections();
                                                                        var x;
                                                                        var fila;
                                                                        var arrRegistros='';
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	fila=filas[x];
                                                                            
                                                                            if(arrRegistros=='')
                                                                            	arrRegistros=fila.data.idRegistro;
                                                                            else
                                                                            	arrRegistros+=','+fila.data.idRegistro;
                                                                                
                                                                           
                                                                            
                                                                        }
                                                                        
                                                                        if(arrRegistros=='')
                                                                        {
                                                                        	msgBox('Debe selecionar almenos una tutela');
                                                                        	return;
                                                                        }

                                                                        
                                                                        
                                                                        var cadObj='{"idRegistro":"'+gE('idRegistro').value+'","arrRegistros":"'+arrRegistros+'"}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	tblGrid.getStore().reload();
                                                                                ventanaAM.close();
                                                                                
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',funcAjax, 'POST','funcion=13&cadObj='+cadObj,true);
                                                                        
																	}
														}
														
													]
									}
								);
	ventanaAM.show();
    
    new Ext.form.DateField(	
                            {
                                      xtype:'datefield',
                                      id:'dtePeriodoInicial',
                                      ctCls:'campoFechaSIUGJ',
                                      renderTo:'divDtePeriodoInicial',
                                      value:'<?php echo $fechaInicial?>',
                                      listeners:	{
                                                      select:function()
                                                              {
                                                                  gEx('gTutelasAgregar').getStore().reload();
                                                              }
                                                              
                                                  }
                                  
                                
                            }
                         )
    

	 new Ext.form.DateField(	
    
                            {
                                      xtype:'datefield',
                                      id:'dtePeriodoFinal',
                                      renderTo:'divDtePeriodoFinal',
                                      ctCls:'campoFechaSIUGJ',
                                      value:'<?php echo date("Y-m-d")?>',
                                      listeners:{
                                                      select:function()
                                                              {
                                                                  gEx('gTutelasAgregar').getStore().reload();
                                                              }
                                                              
                                                  }
                                  
                                
                            }
                         )
                         
                         
	                     

}


function crearGridTutelasAgregar()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'idFormulario'},
                                                        {name:'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'folioRegistro'},
                                                        {name:'carpetaAdministrativa'},
                                                        {name:'despachoEnvio'},
                                                        {name:'folioCorteConstitucional'}                                                        
		                                                
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaCreacion', direction: 'ASC'},
                                                            groupField: 'fechaCreacion',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='10';
                                        proxy.baseParams.fechaInicio=gEx('dtePeriodoInicial').getValue().format('Y-m-d');
                                        proxy.baseParams.fechaFin=gEx('dtePeriodoFinal').getValue().format('Y-m-d');
                                    }
                        )   

	var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            chkRow,
                                                            {
                                                                header:'Fecha de Creaci&oacute;n',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'fechaCreacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i');
                                                                        }
                                                            },
                                                            {
                                                                header:'Folio de Registro',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'folioRegistro'
                                                            },
                                                            {
                                                                header:'Folio Corte Consticional',
                                                                width:210,
                                                                sortable:true,
                                                                dataIndex:'folioCorteConstitucional'
                                                            },
                                                            {
                                                                header:'C&oacute;digo &Uacute;nico de Proceso',
                                                                width:240,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa'
                                                            },
                                                            {
                                                                header:'Despacho que Env&iacute;a',
                                                                width:550,
                                                                sortable:true,
                                                                dataIndex:'despachoEnvio'
                                                            }
                                                             
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gTutelasAgregar',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                sm:chkRow,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                cls:'gridSiugjPrincipal',
                                                                columnLines : false, 
                                                                border:false,                                                             
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


function abrirTutela(iF,iR)
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
            obj.modal=true;
            obj.funcionCerrar=function()
                              {
                                  gEx('gTutelasAsignadas').getStore().reload();
                              };
            obj.params=[['idFormulario',bD(iF)],['idRegistro',arrResp[1]],['idReferencia',-1],
                    ['dComp',arrResp[2]],['actor',arrResp[3]]];
            window.parent.abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',funcAjax, 'POST','funcion=15&iR='+bD(iR),true);
}

