<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$consulta="select valor,texto from 1004_siNo where idIdioma=".$_SESSION["leng"];
	$arrSiNo=uEJ($con->obtenerFilasArreglo($consulta));
?>

var arrSiNo=<?php echo $arrSiNo?>;
Ext.onReady(inicializar);

function inicializar()
{
	gE('nCategoria').focus();
    
    /*if(gE('tblAccionesIni')!=null)
    {
    	inicializarGridAccionesIni();
        inicializarGridAccionesEscenario();
    }*/
    
}

function validarFrm()
{
	if(validarFormularios('frmEnvio'))
    {
    	gE('frmEnvio').submit();
    }
}

function inicializarGridAccionesIni()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idAccion'},
                                                                {name: 'accionO'},
                                                                {name: 'accionP'},
                                                                {name: 'removible'}
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
															header:'Nombre acci&oacute;n original',
															width:270,
															sortable:true,
															dataIndex:'accionO'
														},
														{
															header:'Nombre acci&oacute;n actual',
															width:270,
															sortable:true,
															dataIndex:'accionP',
                                                            editor:new Ext.form.TextField	(
                                                            								)
														},
                                                        {
															header:'Removible',
															width:100,
															sortable:true,
															dataIndex:'removible',
                                                            renderer:function(val)
                                                            		{
                                                                    	var pos=existeValorMatriz(arrSiNo,val,0);
                                                                        return arrSiNo[pos][1];
                                                                    }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                        	id:'gridInicio',
                                                            title:'Acciones disponibles para la etapa inicial del proceso:',
                                                            store:alDatos,
                                                            frame:true,
                                                            renderTo:'tblAccionesIni',
                                                            cm: cModelo,
                                                            height:200,
                                                            width:750,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	text:'Agregar acci&oacute;n',
                                                                            icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaAgregarAcciones(1);
                                                                                    }
                                                                        },
                                                                        {
                                                                        	text:'Remover acci&oacute;n',
                                                                            icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	var filas=tblGrid.getSelectionModel().getSelections();
                                                                                        if(filas.length==0)
                                                                                        {
                                                                                            msgBox('Debe seleccionar las acciones a remover de la categor&iacute;a del proceso');
                                                                                            return;
                                                                                        }
                                                                                        
                                                                                        
                                                                                        var x;
                                                                                        for(x=0;x<filas.length;x++)
                                                                                        {
                                                                                        	if(filas[x].get('removible')=='0')
                                                                                            {
                                                                                            	msgBox('No se puede eliminar las acciones seleccionadas, ya que al menos una est&aacute; marcada como no removible')
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                        }
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {                                                                                        
                                                                                                var idTipoProceso=gE('idTipoProceso').value;
                                                                                                var listaAcciones=obtenerListadoArregloFilas(filas,'idAccion');
                                                                                                
                                                                                                
                                                                                                function funcAjax()
                                                                                                {
                                                                                                    var resp=peticion_http.responseText;
                                                                                                    arrResp=resp.split('|');
                                                                                                    if(arrResp[0]=='1')
                                                                                                    {
                                                                                                        tblGrid.getStore().remove(filas);
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=165&lista='+listaAcciones+'&idTipoProceso='+idTipoProceso,true);
                                                                                        	}
                                                                                       }
                                                                                       msgConfirm('Est&aacute; seguro de querer remover las acciones seleccionadas?',resp)
                                                                                    }
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	llenarGridAcciones();                                                
    tblGrid.on('afteredit',funcEditChange);
	return 	tblGrid;	

}

function inicializarGridAccionesEscenario()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idAccion'},
                                                                {name: 'accionO'},
                                                                {name: 'accionP'},
                                                                {name: 'removible'}
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
															header:'Nombre acci&oacute;n original',
															width:270,
															sortable:true,
															dataIndex:'accionO'
														},
														{
															header:'Nombre acci&oacute;n actual',
															width:270,
															sortable:true,
															dataIndex:'accionP',
                                                            editor:new Ext.form.TextField	(
                                                            								)
														},
                                                        {
															header:'Removible',
															width:100,
															sortable:true,
															dataIndex:'removible',
                                                            renderer:function(val)
                                                            		{
                                                                    	var pos=existeValorMatriz(arrSiNo,val,0);
                                                                        return arrSiNo[pos][1];
                                                                    }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                        	id:'gridEscenario',
                                                            title:'Acciones disponibles para la configuraci&oacute;n del escenario:',
                                                            store:alDatos,
                                                            frame:true,
                                                            renderTo:'tblAccionesEsc',
                                                            cm: cModelo,
                                                            height:260,
                                                            width:750,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	text:'Agregar acci&oacute;n',
                                                                            icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaAgregarAcciones(2);
                                                                                    }
                                                                        },
                                                                        {
                                                                        	text:'Remover acci&oacute;n',
                                                                            icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	var filas=tblGrid.getSelectionModel().getSelections();
                                                                                        if(filas.length==0)
                                                                                        {
                                                                                            msgBox('Debe seleccionar las acciones a remover de la categor&iacute;a del proceso');
                                                                                            return;
                                                                                        }
                                                                                        var x;
                                                                                        for(x=0;x<filas.length;x++)
                                                                                        {
                                                                                        	if(filas[x].get('removible')=='0')
                                                                                            {
                                                                                            	msgBox('No se puede eliminar las acciones seleccionadas, ya que al menos una est&aacute; marcada como no removible')
                                                                                       			return;
                                                                                            }
                                                                                           
                                                                                        }
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {                                                                                        
                                                                                                var idTipoProceso=gE('idTipoProceso').value;
                                                                                                var listaAcciones=obtenerListadoArregloFilas(filas,'idAccion');
                                                                                                
                                                                                                
                                                                                                function funcAjax()
                                                                                                {
                                                                                                    var resp=peticion_http.responseText;
                                                                                                    arrResp=resp.split('|');
                                                                                                    if(arrResp[0]=='1')
                                                                                                    {
                                                                                                        tblGrid.getStore().remove(filas);
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=165&lista='+listaAcciones+'&idTipoProceso='+idTipoProceso,true);
                                                                                        	}
                                                                                       }
                                                                                       msgConfirm('Est&aacute; seguro de querer remover las acciones seleccionadas?',resp)
                                                                                        
                                                                                    }
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	tblGrid.on('afteredit',funcEditChange);	                                               
	return 	tblGrid;	
}

function funcEditChange(e)
{
	if(e.value=='')
    {
    	function resp()
    	{  
    		e.record.set('accionP',e.originalValue);
        }
        msgBox('El valor ingresado no es v&aacute;lido',resp)
        return;
    }
    var idTipoProceso=gE('idTipoProceso').value;
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=166&idAccion='+e.record.get('idAccion')+'&tProceso='+idTipoProceso+'&valor='+cv(e.value),true);
    

}
function llenarGridAcciones(ign) //1= Inicio;2= Escenario
{
	var idTipoProceso=gE('idTipoProceso').value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
           	gEx('gridInicio').getStore().loadData(arrDatos);
            if(ign==undefined)
	            llenarGridAcciones2();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=162&tA=1&tProceso='+idTipoProceso,true);
}

function llenarGridAcciones2() //1= Inicio;2= Escenario
{
	var idTipoProceso=gE('idTipoProceso').value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
           	gEx('gridEscenario').getStore().loadData(arrDatos);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=162&tA=2&tProceso='+idTipoProceso,true);
}

function mostrarVentanaAgregarAcciones(tA)
{
	var gridAcciones=crearGridAcciones();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
	                                                        html:'Seleccione las acciones a agregar a la categor&iacute;a del proceso:'
                                                        },
                                                        gridAcciones

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar acci&oacute;n',
										width: 500,
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
                                                                    	
																		var filas=gridAcciones.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar las acciones a agregar a la categor&iacute;a del proceso');
                                                                        	return;
                                                                        }
                                                                        var idTipoProceso=gE('idTipoProceso').value;
                                                                        var listaAcciones=obtenerListadoArregloFilas(filas,'idAccion');
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	if(tA==1)
	                                                                            	llenarGridAcciones(false);
                                                                                else
                                                                                	llenarGridAcciones2();
                                                                            	ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=164&lista='+listaAcciones+'&idTipoProceso='+idTipoProceso,true);
                                                                        
                                                                        
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

    obtenerAccionesDisponibles(gridAcciones,tA,ventanaAM);
}

function crearGridAcciones()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idAccion'},
                                                                    {name: 'accion'}
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
															header:'Acci&oacute;n',
															width:335,
															sortable:true,
															dataIndex:'accion'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridAccionesDisp',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:450,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;		

}

function obtenerAccionesDisponibles(gridAcciones,tA,ventanaAM)
{
	var idTipoProceso=gE('idTipoProceso').value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
            gridAcciones.getStore().loadData(arrDatos);
            ventanaAM.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=163&tA='+tA+'&tProceso='+idTipoProceso,true);
}