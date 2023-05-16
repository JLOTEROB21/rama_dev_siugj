<?php session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

var p=window.parent;

Ext.onReady(inicializar);

function inicializar()
{
	crearGridComitesAsociados();
}

function crearGridComitesAsociados()
{
	var dsDatos=eval(bD(gE('arrDatosComite').value));
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idComiteReg'},
                                                                    {name: 'comite'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'<?php echo $lblComiteS?> asignado(a)',
															width:300,
															sortable:true,
															dataIndex:'comite'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                        	id:'gridComites',
                                                            renderTo:'tblComitesEvaluacion',
                                                            store:alDatos,
                                                            frame:true,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:400,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
																			text:'Agregar <?php $lblComiteS?>',
                                                                            icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	ventanaComiteDisponibles();
                                                                                    }
                                                                        },
                                                                        {
																			text:'Remover <?php $lblComiteS?>',
                                                                            icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	var filaSel=tblGrid.getSelectionModel().getSelections();
                                                                                        if(filaSel.length==0)
                                                                                        {
                                                                                            msgBox('Al menos debe seleccionar un elemento a remover');
                                                                                            return;
                                                                                        }
                                                                                        
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                                var cadComites=obtenerListadoArregloFilas(filaSel,'idComiteReg');
                                                                                                function funcAjax()
                                                                                                {
                                                                                                    var resp=peticion_http.responseText;
                                                                                                    arrResp=resp.split('|');
                                                                                                    if(arrResp[0]=='1')
                                                                                                    {
                                                                                                        tblGrid.getStore().remove(filaSel);
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=190&cadComites='+cadComites,true);
                                                                                    		}
                                                                                        }    
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el elemento seleccionado?',resp);
                                                                                    }
                                                                        }
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;	
}

function ventanaComiteDisponibles()
{
	var idEtapaRef=bD(gE('etapaRef').value);
    
    var gridComitesDisponibles=crearGridComiteDisponibles();
    
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'<?php echo $lblComiteP?> disponibles:'
                                                            
                                                        },
                                                        gridComitesDisponibles
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Asociar <?php echo $lblComiteS?> de evaluaci&oacute;n',
										width: 440,
										height:390,
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
                                                                    	var filaSel=gridComitesDisponibles.getSelectionModel().getSelections();
                                                                        
                                                                        if(filaSel.length==0)
                                                                        {
                                                                        	msgBox('Al menos debe seleccionar un elemento a asignar');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var cadComites=obtenerListadoArregloFilas(filaSel,'idComite');
                                                                        var idFormulario=bD(gE('idFormulario').value);
                                                                        var idRegistro=bD(gE('idRegistro').value);
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	var arrDatos=eval(arrResp[1]);
                                                                                gEx('gridComites').getStore().loadData(arrDatos);
                                                                            	ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=189&idFormulario='+idFormulario+'&idRegistro='+idRegistro+'&cadComites='+cadComites,true);
                                                                        
                                                                        
                                                                        
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
	llenarComitesDiponibles(ventanaAM,gridComitesDisponibles.getStore());
}

function crearGridComiteDisponibles()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idComite'},
                                                                    {name: 'comite'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'<?php echo $lblComiteS?>',
															width:300,
															sortable:true,
															dataIndex:'comite'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                        	
                                                           	x:10,
                                                            y:40,
                                                            store:alDatos,
                                                            frame:true,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:400,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;	
}

function llenarComitesDiponibles(ventana,almacen)
{
	var idEtapaRef=bD(gE('etapaRef').value);
    var idProceso=gE('idProceso').value;
    var idFormulario=bD(gE('idFormulario').value);
    var idRegistro=bD(gE('idRegistro').value);
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {	
        	var arrDatos=eval(arrResp[1]);
            almacen.loadData(arrDatos);
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=188&idFormulario='+idFormulario+'&idRegistro='+idRegistro+'&etapa='+idEtapaRef+'&idProceso='+idProceso,true);
    
    
	
}

function enviarRevision(e)
{
	var nComites=gEx('gridComites').getStore().getCount();
    if(nComites==0)
    {
    	msgBox('Al menos debe asignar un(a) <?php echo $lblComiteS?> de evaluaci&oacute;n ');
        return;
    }
    
	function resp(btn)
    {
    	if(btn=='yes')
	    	p.enviarAEtapa(bD(e));
    }
    msgConfirm('Est&aacute; seguro de querer someter a revisi&oacute;n por parte de los(as) <?php echo $lblComiteP ?> de evaluaci&oacute;n?',resp);
}