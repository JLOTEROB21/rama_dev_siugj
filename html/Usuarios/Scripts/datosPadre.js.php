<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>
Ext.onReady(inicializar);

function inicializar()
{
	var combo=gE('cmbEdoCivil');
    seleccionarSituacionFamiliar(combo);
    var idSituacion=combo.options[combo.selectedIndex].value;
    if(idSituacion!='-1')
	    viveConyugeSel(gE('cmbViveConyuge'));
}

var pPagina=new Ext.data.HttpProxy	(
										 	{
												url:'../paginasFunciones/funcionesUsuarios.php',
												method:'POST'
											}
										 );
var lector=new Ext.data.JsonReader 	(
										 	{
												root:'personas',
												totalProperty:'num',
												id:'idUsuario'
											},
											[
											 	{name:'idUsuario', mapping:'idUsuario'},
												{name:'Paterno', mapping:'Paterno'},
												{name:'Materno', mapping:'Materno'},
												{name:'Nom', mapping:'Nom'},
												{name:'Nombre', mapping:'Nombre'},
												{name:'Status', mapping:'Status'},
                                                {name:'idUsuario',mapping:'idUsuario'}
											]
										);

var alRelaciones=	new Ext.data.SimpleStore(
											{
												fields:	[
															{name: 'idRelacion'},
															{name: 'Persona'},
															{name: 'Relacion'}
														]
											}
										);

function seleccionarSituacionFamiliar(cmbCombo)
{
	var cmbSitActual=cmbCombo;
	var valor=cmbSitActual.options[cmbSitActual.selectedIndex].value;
    
    if(valor=='-1')
    {
    	oE('filaEspecifique');
        oE('filaNombreC');
        oE('filaViveCon');
    }
	var arrVal=valor.split('_');
	if(arrVal[0]==6)
	{
		mE('filaEspecifique');			
		gE('txtEspecifique').focus();
	}
	else
		oE('filaEspecifique');
      
	if(arrVal[1]==1)
	{
		mE('filaNombreC');
        if(gE('idPadre').value!='-1')
			mE('filaViveCon');
	}
	else
	{
		oE('filaNombreC');
        oE('filaViveCon');
		
	}
}

function mostrarVentanaAgregar(tblPersonas)
{
	gE('cBusquedaP').value='1';
	gE('idPadre').value='-1';
	
	var parametros2=	{
							funcion:'22',
							criterio:'',
                            idUsuario:'-1'
						};
	
	var comboPapa=inicializarCmbPadre(pPagina,lector,parametros2);

	var form = new Ext.form.FormPanel(	
										 	{
												baseCls: 'x-plain',
												layout:'absolute',
												defaultType: 'textfield',
												items: 	[
														 	new Ext.form.Label	(
																				 	{
																						x:5,
																						y:40,
																						text:'Persona: '
																					}
																				)
															,
															comboPapa,
															new Ext.form.Radio	(
																					{
																						x:5,
																						y:5,
																						id:'rdoPaterno',
																						boxLabel:'Ap. Paterno',
																						checked:true,
																						value:1
																						
																					}
																				),
															new Ext.form.Radio	(
																					{
																						x:135,
																						y:5,
																						id:'rdoMaterno',
																						boxLabel:'Ap. Materno',
																						value:2
																					}
																				),
															new Ext.form.Radio	(
																					{
																						x:265,
																						y:5,
																						id:'rdoNombre',
																						boxLabel:'Nombre',
																						value:3
																					}
																				)
															
														]
											}
										);
	
	ventana = new Ext.Window	(
									{
										title: lblAplicacion,
										width: 450,
										height:180,
										minWidth: 280,
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
																		comboPapa.focus();
																	}
																}
													},
										buttons:	[
														{
															text: 'Aceptar',
															handler:function()
																	{
                                                                    
																		if(gE('idPadre').value=='-1')
                                                                        {	
                                                                        	msgBox('El usuario seleccionado no es v&aacute;lido');
                                                                            return;
                                                                        }
                                                                        mE('filaViveCon');
																		viveConyugeSel(gE('cmbViveConyuge'));
                                                                        var spAccion=gE('spAccion');
                                                                        spAccion.innerHTML='<a href="javascript:removerConyuge()"><img src="../images/delete.png" alt="Remover conyuge" title="Remover conyuge"/></a>';
                                                                        ventana.close();
																		
																	}
														},
														{
															text: 'Cancelar',
															handler:function()
																	{
																		ventana.close();
																	}
														}
													]
    								}
								);

	var rdoPaterno=Ext.getCmp('rdoPaterno');
	var rdoMaterno=Ext.getCmp('rdoMaterno');
	var rdoNombre=Ext.getCmp('rdoNombre');
	rdoPaterno.on('check',cambiarRadioSel);									
	rdoMaterno.on('check',cambiarRadioSel);									
	rdoNombre.on('check',cambiarRadioSel);							
    ventana.show();
}

function cambiarRadioSel(chk, valor)
{
	if(valor==true)
	{
		var rdoPaterno=Ext.getCmp('rdoPaterno');
		var rdoMaterno=Ext.getCmp('rdoMaterno');
		var rdoNom=Ext.getCmp('rdoNombre');
		if(rdoPaterno.id!=chk.id)
			rdoPaterno.setValue(false);
		if(rdoMaterno.id!=chk.id)
			rdoMaterno.setValue(false);
		if(rdoNom.id!=chk.id)
			rdoNom.setValue(false);
		gE('cBusquedaP').value=chk.value;
	}
}

function inicializarCmbPadre(pagina,lector, parametros2)
{
	var ds=new Ext.data.Store	(
								 	{
										proxy:pagina,
										reader:lector,
										baseParams:parametros2
									}
								 );
	
	function cargarDatos(dSet)
	{
		gE('idPadre').value='-1';
		var aNombre=Ext.getCmp('cmbNombrePadre').getValue();
		dSet.baseParams.criterio=aNombre;
		dSet.baseParams.campoBusqueda=gE('cBusquedaP').value;
        dSet.baseParams.idUsuario=gE('idUsuario').value;
	}
	
	ds.on('beforeload',cargarDatos);

	var resultTpl=new Ext.XTemplate	(
									 	'<tpl for="."><div class="search-item">',
											'{Paterno}&nbsp;{Materno}&nbsp;{Nom}&nbsp;<br>---<br>',
										'</div></tpl>'
									 );
	
	var comboNombre= new Ext.form.ComboBox	(
												 	{
														x:70,
														y:35,
														id:'cmbNombrePadre',
														store:ds,
														displayField:'Nombre',
														typeAhead:false,
														minChars:1,
														loadingText:'Procesando, por favor espere...',
														width:300,
														pageSize:10,
														hideTrigger:true,
														tpl:resultTpl,
														itemSelector:'div.search-item',
														listWidth :300
													}
												 );

	function funcElemSeleccionado(combo,registro)
	{	
		gE('idPadre').value=registro.get('idUsuario');	
        gE('lblConyuge').innerHTML=registro.get('Nombre');
	
	}
	
	comboNombre.on('select',funcElemSeleccionado);	
	return comboNombre;
}

function guardarDatosPadre()
{
	var cmbEdoCivil=gE('cmbEdoCivil');
    var idEdoCivil=cmbEdoCivil.options[cmbEdoCivil.selectedIndex].value;
    if(idEdoCivil=='-1')
    {
    	msgBox('Debe indicar el estado civil');
    	return;
    }
    var arrVal=idEdoCivil.split('_');
    var especifique='';
    if(arrVal[0]=='6')
    {
    	especifique=gE('txtEspecifique').value;
    }
    var cmbVivePareja=gE('cmbViveConyuge');
    var vivePareja=cmbVivePareja.options[cmbVivePareja.selectedIndex].value;
    var idPadre=gE('idPadre').value;
    var idUsuario=gE('idUsuario').value;
    if((idPadre!='-1')&&(vivePareja=='-1'))
    {
    	function resp()
        {
        	cmbVivePareja.focus();
        }
    	msgBox('Debe indicar si la persona vive con su pareja o no',resp);
        return;
    }
    
    var arrDireccion=document.getElementsByName('direccion');
    var idDireccion='-1';
    if(arrDireccion.length>0)
    {
    	var x;
        for(x=0;x<arrDireccion.length;x++)
        {
        	if(arrDireccion[x].checked)
            	idDireccion=arrDireccion[x].value;
        }
        if(idDireccion=='-1')
        {
        	msgBox('Debe seleccionar la direcci&oacute;n que comparte');
            return;
        }
    }
    else
    {
    	idDireccion=gE('idDireccion').value;
    }
    
   var obj='{"idUsuario":"'+idUsuario+'","idConyuge":"'+idPadre+'","vivePareja":"'+vivePareja+'","edoCivil":"'+arrVal[0]+'","especifique":"'+cv(especifique)+'","idDireccionC":"'+idDireccion+'"}';
   function respGuardar(btn)
   {
   		if(btn=='yes')
        {
           function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                	var lblDireccion=gE('direccion_'+idDireccion);
                    if(lblDireccion!=null)
                    {
                        var direccion=lblDireccion.innerHTML;
                        gE('spDireccion').innerHTML='<span class="letraFicha">'+direccion+'</span>';
                    }
                    msgBox('Los datos han sido actualizados correctamente');
                    return;
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=23&obj='+obj,true);
    	}
    }
    msgConfirm('Est&aacute; seguro de querer guardar los cambios realizados?',respGuardar);
}

function removerConyuge()
{
	var idUsuario=gE('idUsuario').value;
	function resp(btn)
    {
    	gE('lblConyuge').innerHTML='No especificado';
        oE('filaViveCon');
        gE('idPadre').value='-1';
        var spAccion=gE('spAccion');
        spAccion.innerHTML='<a href="javascript:mostrarVentanaAgregar()"><img src="../images/users.png" alt="Seleccionar conyuge" title="Seleccionar conyuge"/></a>';
        var cmbViveConyuge=gE('cmbViveConyuge');
        cmbViveConyuge.selectedIndex=0;
        viveConyugeSel(cmbViveConyuge);
    }
    msgConfirm('Est&aacute; seguro de querer remover al conyuge?',resp);
}

function viveConyugeSel(combo)
{
	var valor=combo.options[combo.selectedIndex].value;
    if(valor=='1')
    {
    	mE('filaDireccionC');
        var idUsuario1=gE('idUsuario').value;
        var idUsuario2=gE('idPadre').value;
        function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
            	var arrDir=eval(arrResp[1]);
                var contenidoDir;
                if(arrDir.length==1)
                {
	            	contenidoDir='<label class="letraFicha">'+arrDir[0][0]+'</label>';
                    gE('idDireccion').value=arrDir[0][1];
                }
                else
                {
                	var x;
                    contenidoDir='';
                    for(x=0;x<arrDir.length;x++)
                    {
                    	contenidoDir+='<input type="radio" name="direccion" value="'+arrDir[x][1]+'">&nbsp;'+'<label class="letraFicha" id="direccion_'+arrDir[x][1]+'">'+arrDir[x][0]+' ('+arrDir[x][2]+')</label><br><br>';
                    }
                }
                gE('spDireccion').innerHTML=contenidoDir;
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=25&idUsuario1='+idUsuario1+'&idUsuario2='+idUsuario2,true);
	}  
    else
    {
    	oE('filaDireccionC');
        gE('spDireccion').innerHTML='';
        gE('idDireccion').value='-1';
    }      
}

