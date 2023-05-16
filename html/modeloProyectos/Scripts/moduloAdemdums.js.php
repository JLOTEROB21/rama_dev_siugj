<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$idFormulario=base64_decode($_GET["iF"]);
	$idReferencia=base64_decode($_GET["iR"]);
	$consulta="select id_981_ademdums,idFormularioAd,idReferenciaAd from 981_ademdums a where a.idFormulario=".$idFormulario." and a.idReferencia=".$idReferencia;

	$res=$con->obtenerFilas($consulta);	
	$arrAdemdums="";
	while($fila=mysql_fetch_row($res))
	{
		$consulta="select f.nombreTabla,p.nombre from 900_formularios f,4001_procesos p where p.idProceso=f.idProceso and f.idFormulario=".$fila[1];
		$filaProc=$con->obtenerPrimeraFila($consulta);
		$nTabla=$filaProc[0];
		$tipo=$filaProc[1];
		$consulta="select * from ".$nTabla." where id_".$nTabla."=".$fila[2];
		$filaProy=$con->obtenerPrimeraFila($consulta);
		$nProy=$filaProy[9];
		if($arrAdemdums=='')
			$arrAdemdums="['".$fila[0]."','".$nProy."','".$tipo."']";
		else
			$arrAdemdums.=",['".$fila[0]."','".$nProy."','".$tipo."']";
		
	}
	$arrAdemdums="[".uEJ($arrAdemdums)."]";
	
	$consulta="select idProceso,nombre from 4001_procesos where idTipoProceso=3 order by nombre";
	$arrProcesos=uEJ($con->obtenerFilasArreglo($consulta));
	
?>
Ext.onReady(inicializar);

var registroAd=Ext.data.Record.create	(
											[
												{name: 'idAdemdum'},
												{name: 'nombreObjeto'},
                                                {name: 'tipo'}
											]
										)


function inicializar()
{
	dsDatos=<?php echo $arrAdemdums?>;
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idAdemdum'},
                                                                {name: 'nombreObjeto'},
                                                                {name: 'tipo'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	chkRow=new Ext.grid.CheckboxSelectionModel();

	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Ademdum de',
															width:250,
															sortable:true,
															dataIndex:'nombreObjeto'
														},
                                                        {
															header:'Tipo proyecto',
															width:250,
															sortable:true,
															dataIndex:'tipo'
														}
													]
												);
	                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridAdemdums',
                                                            store:alDatos,
                                                            frame:true,
                                                            cm: cModelo,
                                                            height:300,
                                                            width:600,
                                                            sm:chkRow,
                                                            renderTo:'tblAdemdums',
                                                            tbar:	[
                                                            			{
                                                                        	text:'Agregar ademdum',
                                                                            icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                             			{
                                                                                        	agregarNuevo();
                                                                                        }
                                                                        },
                                                            			{
                                                                        	text:'Remover ademdum',
                                                                            icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	var filas=tblGrid.getSelectionModel().getSelections();
                                                                                        if(filas.length==0)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar al menos un elemento a remover');
                                                                                            return;
                                                                                        }
                                                                                        
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                        
                                                                                                var listaAd='';
                                                                                                var x;
                                                                                                for(x=0;x<filas.length;x++)
                                                                                                {
                                                                                                    if(listaAd=='')
                                                                                                        listaAd=filas[x].get('idAdemdum');
                                                                                                    else
                                                                                                        listaAd+=','+filas[x].get('idAdemdum');
                                                                                                } 
                                                                                        	
                                                                                                function funcAjax()
                                                                                                {
                                                                                                    var resp=peticion_http.responseText;
                                                                                                    arrResp=resp.split('|');
                                                                                                    if(arrResp[0]=='1')
                                                                                                    {
                                                                                                        tblGrid.getStore().remove(filas);
                                                                                                        if(typeof(funcAgregar)!='undefined')
                                                                                                        	funcAgregar();
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=103&listaAd='+listaAd,true);
																							}
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover los ademdums seleccionados?',resp);
                                                                                        
                                                                                        
                                                                                        
                                                                                    }
                                                                        }
                                                            		]
                                                        }
                                                    );
                                                    
}

function agregarNuevo()
{
	var idFormulario=gE('idFormulario').value;
    var idReferencia=gE('idReferencia').value;
    var arrTipoProceso=<?php echo $arrProcesos?>; 
    var cmbTipoProceso=crearComboExt('cmbTipoProceso',arrTipoProceso,130,5,250);
    cmbTipoProceso.on('select',tipoProcesoChange)
    var cmbProyecto=crearComboExt('cmbProyecto',[],130,40,250);
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Tipo de proyecto:'
                                                        },
														cmbTipoProceso,
                                                        {
                                                        	x:10,
                                                            y:45,
                                                            html:'Proyecto:'
                                                        },
														cmbProyecto,

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar ademdum',
										width: 440,
										height:180,
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
																		if(cmbProyecto.getValue()=='')
                                                                        {
                                                                        	function respProy()
                                                                            {
                                                                            	cmbProyecto.focus();
                                                                            }
                                                                        	msgBox('Debe seleccionar el proyecto con el cual se vinculara como ademdum',respProy);
                                                                        	return;
                                                                        }
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	var registro=new registroAd	(
                                                                                								{
                                                                                                                    idAdemdum:arrResp[1],
                                                                                                                    nombreObjeto:cmbProyecto.getRawValue(),
                                                                                                                    tipo:cmbTipoProceso.getRawValue()
																												}
                                                                                                                
                                                                                							)
																				Ext.getCmp('gridAdemdums').getStore().add(registro);    
                                                                                ventanaAM.close();                                    
                                                                                if(typeof(funcAgregar)!='undefined')
                                                                                	funcAgregar();                                                                    
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=102&idFormulario='+idFormulario+'&idReferencia='+idReferencia+'&idProceso='+cmbTipoProceso.getValue()+'&idReferenciaAd='+cmbProyecto.getValue(),true);

                                                                        
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

function tipoProcesoChange(combo,registro)
{
	var idFormulario=gE('idFormulario').value;
    var idReferencia=gE('idReferencia').value;
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrProy=eval(arrResp[1]);
            Ext.getCmp('cmbProyecto').getStore().loadData(arrProy);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=101&idFormulario='+idFormulario+'&idReferencia='+idReferencia+'&idProceso='+registro.get('id'),true);

}