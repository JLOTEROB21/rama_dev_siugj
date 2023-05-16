<?php
	session_start();
	include("configurarIdiomaJS.php");
?>

Ext.onReady(inicializar)

function inicializar()
{
	gE('nombreConf').focus();
}

function enviarFrm(formulario)
{
	if(validarFormularios(formulario))
	{
		var hNumCheckSel=gE('numCheckSeleccionados');
		if(hNumCheckSel.value=='0')
		{
			Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["lblMsgDebeSelRol"]?>');
			return;
		}
		gE(formulario).submit();
	}
}


function checkClick(controlChk)
{
	var hNumCheckSel=gE('numCheckSeleccionados');
	if(controlChk.checked==true)
		hNumCheckSel.value= parseInt(hNumCheckSel.value)+1;
	else
		hNumCheckSel.value= parseInt(hNumCheckSel.value)-1;

}

function configurarGrid()
{
	var idConfiguracion=gE('idConfiguracion').value;
    var idFormulario=gE('idFormulario').value;
	var arrParam=[['idConfiguracion',idConfiguracion],['idFormulario',idFormulario]];
	enviarPagina(arrParam,'../formularios/configurarGrid.php',true);
}

function agregarUsuario()
{
	var comboMiembros=generarComboMiembros();
	var form = new Ext.form.FormPanel(	
										 	{
												baseCls: 'x-plain',
												layout:'absolute',
												defaultType: 'textfield',
												items: 	[
															
															new Ext.form.Label	(
																				 	{
																						x:5,
																						y:10,
																						text:'<?php echo $etj["lblUsuario"]?>:'
																					}
																				),
															comboMiembros
															
														]
											}
										);
	
	ventana= new Ext.Window	(
									{
										title: '<?php echo $etj["lblAplicacion"]?>',
										width: 400,
										height:150,
										minHeight: 100,
										layout: 'fit',
										plain:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										modal:true,
										listeners : {
														show : {
																	buffer : 10,
																	fn : function() 
																	{
																		comboMiembros.focus(true,10);
																	}
																}
													},
										buttons:	[
														{
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler:function()
																	{
																		if(gE('idUsuario').value=='-1')
																		{
																			function funcFocusMiembro()
																			{
																				comboMiembros.focus(false,100);
																			}
																			Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["lblDebeSelUsr"]?>',funcFocusMiembro);
																			return;
																		}
																		
                                                                        
                                                                        
                                                                        var idUsuario=gE('idUsuario').value;
                                                                        var idConfiguracion=gE('idConfiguracion').value;
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                if(arrResp[1]=='2')
                                                                                {
                                                                                    Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["lblErrorUsrExiste"]?>');	
                                                                                }
                                                                                else
                                                                                {
                                                                                	var tblUsuario=gE('tblUsuario');
                                                                                    var filaTR=document.createElement('tr');
                                                                                    filaTR.id='fila_'+idUsuario;
                                                                                    var td1=document.createElement('td');
                                                                                    var td2=document.createElement('td');
                                                                                    td2.valign='top';
                                                                                    var aHref=document.createElement('a');
                                                                                    aHref.href='javascript:removerUsuario('+idUsuario+')';
                                                                                    var img=document.createElement('img');
                                                                                    img.src='../images/cancel_round.png';
                                                                                    img.title='<?php echo $etj["lblRemoverPri"]?>';
                                                                                    img.alt='<?php echo $etj["lblRemoverPri"]?>';
                                                                                    aHref.appendChild(img);
                                                                                    td2.appendChild(aHref);
                                                                                    if(Ext.isIE)
                                                                                    	td1.className='letraFicha';
                                                                                    else
                                                                                    	td1.setAttribute('class','letraFicha');
                                                                                    
                                                                                    var almacen=comboMiembros.getStore();
                                                                                    var nElementos=almacen.getCount();
                                                                                    var x;
                                                                                    var fila;
                                                                                    for(x=0;x<nElementos;x++)
                                                                                    {
                                                                                    	fila=almacen.getAt(x);
                                                                                    	if(fila.get('idUsuario')==idUsuario)
                                                                                        	break;
                                                                                    
                                                                                    }
                                                                                    var nombre=document.createTextNode(fila.get('usuario')+' ('+fila.get('unidad')+','+fila.get('institucion')+')');
                                                                                    td1.appendChild(nombre);
                                                                                    filaTR.appendChild(td1);
                                                                                    filaTR.appendChild(td2);
                                                                                    tblUsuario.appendChild(filaTR);
                                                                                    ventana.close();
                                                                                }
                                                                              
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion='+34+'&idUsuario='+idUsuario+'&idConfiguracion='+idConfiguracion,true);
                                                                    
																		
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
																		ventana.close();
																	}
														}
													]
    								}
								);
    	ventana.show();
}

function generarComboMiembros()
{
	var pPagina=new Ext.data.HttpProxy	(
											{
												url: '../paginasFunciones/funcionesFormulario.php', 
												method:'POST' 
											}
										);
	var lector =new Ext.data.JsonReader	(
											{
												root: 'usuarios',
												totalProperty: 'numUsuarios',
												id:'idUsuario'
											}, 
											[
												{name:'idUsuario',mapping:'idUsuario'},
												{name: 'usuario',mapping:'usuario'},
												{name: 'institucion', mapping: 'institucion'},
                                                {name: 'unidad', mapping: 'unidad'}
											]
										);	
	var parametros=	{
						funcion:'33',
						datosUsuario:''
					}
					
	var ds = new Ext.data.Store	
	(
		{
			proxy:	pPagina,												
			reader: lector,
			baseParams:	parametros
		}
	);
	
	function funcCargarDatos(dSet,opciones)
	{
		var usuario=Ext.getCmp('cmbUsuarios').getValue();
		dSet.baseParams.datosUsuario=cv(usuario);
        gE('idUsuario').value='-1';
		
	}
	ds.on('beforeload',funcCargarDatos);	
	
	var resultTpl = new Ext.XTemplate	(
											'<tpl for="."><div class="search-item">',
												'{usuario}<br /> ({unidad},{institucion})<br>----<br>',
											'</div></tpl>'
										);
	
	var comboMiembros = new Ext.form.ComboBox	
	(
		{
			x:75,
			y:5,
			id:'cmbUsuarios',
			store: ds,
			displayField:'usuario',
			typeAhead: false,
			minChars:1,
			loadingText: 'Buscando...',
			width: 250,
			pageSize:10,
			hideTrigger:false,
			tpl: resultTpl,
			itemSelector: 'div.search-item'
		}
	);
	
	comboMiembros.on('select',funcSeleccionado);
	return comboMiembros;
}

function funcSeleccionado(combo,registro,indice)
{
	var usuario=registro.get('usuario');
    
	Ext.getCmp('cmbUsuarios').setValue(usuario);
    gE('idUsuario').value=registro.get('idUsuario');
   
}

function removerUsuario(idUsuario)
{
	var idConfiguracion=gE('idConfiguracion').value;
    
    
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
                 	var fila=gE('fila_'+idUsuario);
                    fila.parentNode.removeChild(fila); 
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=35&idConfiguracion='+idConfiguracion+'&idUsuario='+idUsuario,true);
        }
    }
    Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["msgConfEliminarUsr"]?>',resp);
}

function regresar()
{
	var idFormulario=gE('idFormulario').value;
	var arrParam=[['idFormulario',idFormulario]];
	enviarPagina(arrParam,'../formularios/tblListadoConfiguracionesGrid.php',true);
}
