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
                                                cls:'panelSiugj',
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
                                                        {name: 'estado6'},
                                                        {name: 'existeInsistencia'},
                                                         {name: 'seleccionada'},
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
	var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
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
                                                                width:180,
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
                                                                width:280,
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
                                                            } ,
                                                            {
                                                                header:'Existe Insistencia',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'existeInsistencia',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(parseInt(val)==0)
                                                                            	return '<img src="../images/cancel_round.png" title="No Existe Insistencia" alt="No Existe Insistencia">&nbsp&nbsp;No';
                                                                        	else
                                                                            	return '<img src="../images/accept_green.png" title="Existe Insistencia" alt="Existe Insistencia">&nbsp&nbsp;S&iacute;';
                                                                            
                                                                        }
                                                            }
                                                            
                                                            ,
                                                            {
                                                                header:'Estudio Conclu&iacute;do',
                                                                width:170,
                                                                sortable:true,
                                                                dataIndex:'estado6',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(parseInt(val)!=6)
                                                                            	return '<img src="../images/cancel_round.png" title="Estudio NO Conlu&iacute;do" alt="Estudio NO Conlu&iacute;do">&nbsp&nbsp;No';
                                                                        	else
                                                                            	return '<img src="../images/accept_green.png" title="Estudio Conlu&iacute;do" alt="Estudio Conlu&iacute;do">&nbsp&nbsp;S&iacute;';
                                                                            
                                                                        }
                                                            },

                                                            {
                                                                header:'Tutela Seleccionada',
                                                                width:210,
                                                                sortable:true,
                                                                dataIndex:'seleccionada',
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
                                                    
        tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gTutelasAsignadas',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                sm:chkRow,
                                                                border:false,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                columnLines : false,
                                                                cls:'gridSiugjPrincipal',     
                                                                                                                           
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



function mostrarAgregarVentanaTutelas(tblGrid)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridTutelasAgregar()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Tutelas',
										width: 880,
										height:450,
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

	var chkRow=new Ext.grid.CheckboxSelectionModel();
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            chkRow,
                                                            {
                                                                header:'Fecha de Creaci&oacute;n',
                                                                width:140,
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
                                                                width:170,
                                                                sortable:true,
                                                                dataIndex:'folioCorteConstitucional'
                                                            },
                                                            {
                                                                header:'C&oacute;digo &Uacute;nico de Proceso',
                                                                width:200,
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
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true, 
                                                                tbar:	[
                                                                            {
                                                                                xtype:'label',
                                                                                html:'&nbsp;&nbsp;&nbsp;<b>Periodo del:</b>&nbsp;&nbsp;&nbsp;'
                                                                            },
                                                                            {
                                                                                xtype:'datefield',
                                                                                id:'dtePeriodoInicial',
                                                                                value:'<?php echo $fechaInicial?>',
                                                                                listeners:	{
                                                                                                select:function()
                                                                                                        {
                                                                                                            gEx('gTutelasAgregar').getStore().reload();
                                                                                                        }
                                                                                                        
                                                                                            }
                                                                            },'-',
                                                                            {
                                                                                xtype:'label',
                                                                                html:'&nbsp;&nbsp;&nbsp;<b>al:</b>&nbsp;&nbsp;&nbsp;'
                                                                            },
                                                                            {
                                                                                xtype:'datefield',
                                                                                id:'dtePeriodoFinal',
                                                                                value:'<?php echo $fechaActual?>',
                                                                                listeners:	{
                                                                                                select:function()
                                                                                                        {
                                                                                                            gEx('gTutelasAgregar').getStore().reload();
                                                                                                        }
                                                                                                        
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
            window.parent.parent.abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',funcAjax, 'POST','funcion=15&rolIngreso=175_0&iR='+bD(iR),true);
}