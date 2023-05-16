<?php
session_start();
include("configurarIdiomaJS.php");
include("conexionBD.php");

$consulta="select idPais,nombre from 238_paises order by nombre";
$arrPaises=uEJ($con->obtenerFilasArreglo($consulta));

?>

Ext.onReady(inicializarCombos);
var idForm;
var idReg;
function inicializarCombos()
{
	gE('txtApPaterno').focus();
	idForm=gE('idFormulario').value;
    idReg=gE('idRegistro').value;
	var pPagina=new Ext.data.HttpProxy	(
											{
												url: '../paginasFunciones/funcionesProyectos.php', 
												method:'POST' 
											}
										);
	var lector =new Ext.data.JsonReader	(
											{
												root: 'inst',
												totalProperty: 'numInst',
												id:'idInst'
											}, 
											[
												{name: 'desc', mapping: 'desc'},
												{name: 'idInst', mapping: 'idInst'},
												{name: 'nomInst', mapping: 'nomInst'},
                                                {name: 'codigoUnidad', mapping: 'codigoUnidad'}
												
											]
										);	

	var parametros=	{
						funcion:'27',
						nomInst:''
					}
	
	
	inicializarAfiliacion(pPagina,lector,parametros);
	
}

function limpiarControles()
{
	gE('txtApPaterno').value='';
	gE('txtApMaterno').value='';
	gE('txtNombres').value='';
    gE('txtMail').value='';
    var combo=gE('cmbTelefono');
    limpiarCombo(combo);
	limpiarDatosOrganizacion();
	ocultarFilasDatosOrg();
	Ext.getCmp('cmbInstitucion').setValue('');
	gE('txtApPaterno').focus();
	
}

function agregarAutor()
{
	if(validar())
	{
    	var apPaterno=gE('txtApPaterno').value;
        var apMaterno=gE('txtApMaterno').value;
        var nombre=gE('txtNombres').value;
        var telefonos=recoletarValoresCombo('cmbTelefono');
        var mail=gE('txtMail').value;
        var codInstitucion=gE('codInstitucion').value;
        var codDepto=codInstitucion;
        var actor=gE('idActor').value;
        var estado=gE('estado').value;
        var versionRegistro=gE('versionRegistro').value;
        var nDiv=1;
        var cmbDiv;
        var idActor=gE('idActor').value;
        while(true)
        {
            cmbDiv=gE('cmbDiv_'+nDiv);
            if((cmbDiv==null)||(cmbDiv.selectedIndex==0))
                break;
            codDepto=cmbDiv.options[cmbDiv.selectedIndex].value;
            nDiv++;                    	
        }
        var datosAutor='{"idActor":"'+idActor+'","versionRegistro":"'+versionRegistro+'","idFormulario":"'+idForm+'","idRegistro":"'+idReg+'","apPaterno":"'+cv(apPaterno)+'","apMaterno":"'+cv(apMaterno)+'","nombres":"'+cv(nombre)+'","telefonos":"'+cv(telefonos)+'","email":"'+cv(mail)+'","codInstitucion":"'+cv(codInstitucion)+'","codDepto":"'+cv(codDepto)+'"}';
		function funcGuardar()
		{
        	var arrResp=peticion_http.responseText.split("|");
			if((arrResp[0]=='1')||(arrResp[0]==1))
			{
            	function resp()
                {
                	function respAgregar(btn)
                    {
                    	limpiarControles();
                    	if(btn=='no')
                        {
                        	//regresarPagina();
                            window.parent.tb_remove();
                        }
                    }
                	Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"]?>','El revisor ha sido agregado satisfactoriamente, desea continuar registrando nuevos revisores?',respAgregar);
                }
				Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','La operaci&oacute;n ha sido realizada correctamente',resp);
			}
			else
				msgBox('<?php echo $etj["errOperacion"].' '?>'+arrResp[0]);
		}
		obtenerDatosWeb("../paginasFunciones/funcionesProyectos.php",funcGuardar,'POST','funcion=83&'+'datosAutor='+datosAutor+'&actor='+actor+'&estado='+estado,true);//33
	}
}

function inicializarAfiliacion(pPagina,lector,parametros)
{
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
		var nomInst=Ext.getCmp('cmbInstitucion').getValue();
		dSet.baseParams.nomInst=nomInst;
       	limpiarDatosOrganizacion();
		ocultarFilasDatosOrg();
		
	}
	ds.on('beforeload',funcCargarDatos);	
	
	
	var resultTpl = new Ext.XTemplate	(
											'<tpl for="."><div class="search-item"><b>{nomInst}</b><br />----------<br />{desc}</div></tpl>'
										);


	if(Ext.isIE)
	{
		var buscarNombres = new Ext.form.ComboBox	
		(
			{
				id:'cmbInstitucion',
				store: ds,
				displayField:'nomInst',
				typeAhead: false,
				minChars:1,
				loadingText: 'Buscando...',
				width: 400,
				pageSize:10,
				hideTrigger: true,
				tpl: resultTpl,
				applyTo: 'txtInstitucion',
				itemSelector: 'div.search-item'
			}
		);
	}
	else
	{
		var buscarNombres = new Ext.form.ComboBox	
		(
			{
				id:'cmbInstitucion',
				store: ds,
				displayField:'nomInst',
				typeAhead: false,
				minChars:1,
				loadingText: 'Buscando...',
				width: 400,
				pageSize:10,
				hideTrigger: true,
				tpl: resultTpl,
				applyTo: 'txtInstitucion',
				itemSelector: 'div.search-item'
			}
		);
	}
	
	
	
	buscarNombres.on('select',funcSeleccionado);
}

function funcSeleccionado(combo,registro)
{
	Ext.getCmp('cmbInstitucion').setValue(registro.get('nomInst'));
    gE('idInstitucion').value=registro.get('idInst');
    gE('codInstitucion').value=registro.get('codigoUnidad');
	gE('lblDatosC').innerHTML=registro.get('desc');
    oE('filaRegistro');

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrOpciones=eval(arrResp[1]);
            var cmbDiv_1=gE('cmbDiv_1');
            rellenarCombo(cmbDiv_1,arrOpciones,true);
            cmbDiv_1.options[0].text='Ninguno';
        	mostrarFilasDatosOrganizaciones();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=28&codUnidad='+registro.get('codigoUnidad'),true);
}

function mostrarFilasDatosOrganizaciones()
{
	oE('filaRegistro');
	mE('filaDatosC');
	mE('filaDiv1');

}

function limpiarDatosOrganizacion()
{
	gE('idInstitucion').value='';
    gE('lblDatosC').innerHTML='';
    gE('codInstitucion').value='';
    ocultarFilasDatosOrg();
    eliminarFilasDepto(2);
}

function ocultarFilasDatosOrg()
{
	oE('filaDatosC');
	oE('filaDiv1');
    mE('filaRegistro');
}

function nuevaOrgClick()
{
	var txtBtnAgregar=gE('btnAgregarOrg').value;
	if(txtBtnAgregar=='Nuevo...')
	{
		Ext.getCmp('cmbOrganizacion').setValue('');
		limpiarDatosOrganizacion();
		mostrarFilasDatosOrganizaciones(true);
		gE('btnAgregarOrg').value='Cancelar';
		gE('idEstado').value='1';
		Ext.getCmp('cmbOrganizacion').setVisible(false);
		var txtOrg=gE('txtOrganizacionEdit');
		mE('txtOrganizacionEdit');
		txtOrg.focus();
		txtOrg.value='';
	}
	else
	{
		Ext.getCmp('cmbOrganizacion').setValue('');
		limpiarDatosOrganizacion();
		ocultarFilasDatosOrg();
		Ext.getCmp('cmbOrganizacion').focus(true,10);
		gE('btnAgregarOrg').value='Nuevo...';
		gE('idEstado').value='0';
		Ext.getCmp('cmbOrganizacion').setVisible(true);
		oE('txtOrganizacionEdit');
	}
}

function validar()
{
	var nombre=gE('txtNombres').value;
	if(trim(nombre)=='')
	{
		function funcAceptar()
		{
			gE('txtNombres').focus();
			
		}
		Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','El nombre del revisor es obligatorio',funcAceptar);
		return false;
	}
	
	var mail=gE('txtMail').value;
	if(!validarCorreo(mail))
	{
		function funcAceptar()
		{
			gE('txtMail').focus();
			
		}
		Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','La direcci&oacute;n de correo ingresada es inv&aacute;lida',funcAceptar);
		return false;
	}
    
    var codInstitucion=gE('codInstitucion');
    if(codInstitucion.value=='')
    {
    	function funcAceptar()
		{
			Ext.getCmp('cmbInstitucion').focus();
			
		}
		Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','La instituci&oacute;n seleccionada no es v&aacute;lida',funcAceptar);
		return false;
    }
	return true;
}

var tipoTel;

function solicitarTel()
{
	tipoTel='0';
	var form=new Ext.form.FormPanel(
										{
											baseCls: 'x-plain',
											layout:'absolute',
											disabled:false,
											items:
													[
                                                    	new Ext.form.Label(
																		   		{
																					x:5,
																					y:20,
																					html: 'C&oacute;digo de &aacute;rea:'
																				}
																		   ),
                                                       	 new Ext.form.NumberField
														(
															{
																x:100,
                                                                y:15,
                                                                width:40,
                                                                height:20,
                                                                id:'txtCodArea',
                                                                allowDecimals:false,
                                                                allowNegative:false,
                                                                value:52,
                                                                maxLength:3
															}
														),   
                                                    
													 	new Ext.form.Label(
																		   		{
																					x:5,
																					y:43,
																					html: 'Lada/Tel&eacute;fono:'
																				}
																		   ),
                                                        
                                                        new Ext.form.NumberField
														(
															{
                                                                x:100,
                                                                y:38,
                                                                width:40,
                                                                height:20,
                                                                id:'txtLada',
                                                                maxLengthText:'La lada debe contener solo 3 números',
                                                                maxLength:3,
                                                                allowDecimals:false,
                                                                allowNegative:false
															}
														),     
                                                        
                                                        new Ext.form.NumberField
														(
															{
																x:150,
                                                                y:38,
                                                                width:100,
                                                                height:20,
                                                                id:'txtTelefono',
                                                                allowDecimals:false,
                                                                allowNegative:false
															}
														),                   
                                                                           
                                                                      
                                                                           
														new Ext.form.Label(
																		   		{
																					x:5,
																					y:66,
																					html: 'Extensi&oacute;n:'
																				}
																		   ),
                                                      	new Ext.form.NumberField
														(
															{
                                                                x:100,
                                                                y:61,
                                                                width:100,
                                                                height:20,
                                                                id:'txtExtensiones',
                                                                allowDecimals:false,
                                                                allowNegative:false
															}
														),
														
														new Ext.form.Label(
																		   		{
																					x:5,
																					y:90,
																					text: 'Tipo:'
																				}
																		   ),
														new Ext.form.Radio
														(
															{
                                                                x:100,
                                                                y:85,
                                                                checked:true,
                                                                boxLabel:'Tel.',
                                                                allowBlank :true,
                                                                value:'0',
                                                                id:'Tel'
															}
														),
														new Ext.form.Radio
														(
															{
                                                                x:150,
                                                                y:85,
                                                                checked:false,
                                                                boxLabel:'Celular',
                                                                allowBlank :true,
                                                                value:'1',
                                                                id:'Movil'
															}
														),
														new Ext.form.Radio
														(
															{
                                                                x:220,
                                                                y:85,
                                                                checked:false,
                                                                boxLabel:'Fax',
                                                                allowBlank :true,
                                                                value:'2',
                                                                id:'Fax'
															}
														)
													]
										}
									)
	var ventana=new Ext.Window(
							   		{
										title:'Agregar N&uacute;mero Telef&oacute;nico',
										width:300,
										height:190,
										layout:'fit',
										buttonAlign:'center',
										items:[form],
										modal:true,
										plain:true,
										listeners:
											{
												show:
												{
													buffer:10,fn:function()
															{
																Ext.getCmp('txtLada').focus(false,100);
															}
												}
											},
										buttons:
												[
												 	{
														text:'Aceptar',
														handler:function ()
															{
                                                            	var codArea=Ext.getCmp('txtCodArea').getValue();
																var tel=Ext.getCmp('txtTelefono').getValue();
																var exten=Ext.getCmp('txtExtensiones').getValue();
																var lada=Ext.getCmp('txtLada').getValue();
                                                                if(codArea.length==0)
                                                                {
                                                                	function enfocarCodArea()
                                                                    {
                                                                    	Ext.getCmp('txtCodArea').focus();
                                                                    }
                                                                	msgBox('El c&oacute;digo de &aacute;rea ingresado no es v&aacute;lido',enfocarCodArea);
                                                                    return;
                                                                }
                                                                
                                                                if(tel.length==0)
                                                                {
                                                                	function enfocarTelefono()
                                                                    {
                                                                    	Ext.getCmp('txtTelefono').focus();
                                                                    }
                                                                	msgBox('El n&uacute;mero de tel&eacute;fono ingresado no es v&aacute;lido',enfocarTelefono);
                                                                    return;
                                                                }
                                                                
                                                                if(lada.length==0)
                                                                {
                                                                	function enfocarLada()
                                                                    {
                                                                    	Ext.getCmp('txtLada').focus();
                                                                    }
                                                                	msgBox('El n&uacute;mero Lada ingresado no es v&aacute;lido',enfocarLada);
                                                                    return;
                                                                }
                                                                
                                                                var opcion;
                                                                
                                                                opcion=cE('option');
                                                                opcion.value=tipoTel+'_'+codArea+'_'+lada+'_'+tel+'_'+exten;
                                                                var extens='Ext.: '+exten;
                                                                
                                                                switch(tipoTel)
                                                                {
                                                                    case "0":
                                                                        tipoTel='Tel\xE9fono';
                                                                    break;
                                                                    case "1":
                                                                        tipoTel='Celular';
                                                                    break;
                                                                    case "2":
                                                                        tipoTel='Fax';
                                                                    break;
                                                                }
                                                                
                                                                if (exten!="")
                                                                    opcion.text='['+tipoTel+'] ('+codArea+') '+lada+"-"+tel + " ("+extens+")";
                                                                else
                                                                    opcion.text='['+tipoTel+'] ('+codArea+') '+lada+"-"+tel+" ()";

                                                               var cmbTelefono=gE('cmbTelefono');
                                                               var resp=existeValor(cmbTelefono,opcion.value);
                                                               if(resp==-1)
                                                               {
                                                               		cmbTelefono.options[cmbTelefono.options.length]=opcion;
                                                               }
                                                               ventana.close();
	
															}
													},
													{
														text:'Cancelar',
														handler:function ()
															{
																ventana.close();
																
															}
													}
												 ]
									}
							   )
	
	var tel=Ext.getCmp('Tel');
	var fax=Ext.getCmp('Fax');
	var movil=Ext.getCmp('Movil');
	tel.on('check',radioCheck);
	fax.on('check',radioCheck);
	movil.on('check',radioCheck);
	ventana.show();
	
}

function radioCheck(chk,valor)
{
	if(valor==true)
	{
		var tel=Ext.getCmp('Tel');
		var fax=Ext.getCmp('Fax');
		var movil=Ext.getCmp('Movil');
		tipoTel=chk.value;
		if(tel.id!=chk.id)
			tel.setValue(false);
		if(fax.id!=chk.id)
			fax.setValue(false);
		if(movil.id!=chk.id)
			movil.setValue(false);
	}
	
}

function eliminarTelefono()
{
	var cmbTelefono;
	cmbTelefono=gE('cmbTelefono');
	if(cmbTelefono.selectedIndex==-1)
	{
		msgBox('Debe seleccionar el n&uacute;mero telef&oacute;nico a eliminar');
		return;
	}
	function resp(btn)
	{
		if(btn=='yes')
		{
			cmbTelefono.options[cmbTelefono.selectedIndex]=null;
		}
	}
	Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"]?>','Est&aacute; seguro de querer eliminar el n&uacute;mero telef&oacute;nico seleccionado?',resp);
	
}

function agregarInstitucion()
{

	var arrPaises=<?php echo $arrPaises?>;
	var cmbPais=crearComboExt('cmbPais',arrPaises,85,130);
    cmbPais.setValue('146');
	var form=new Ext.form.FormPanel(
										{
											baseCls: 'x-plain',
											layout:'absolute',
											disabled:false,
                                            defaultType:'label',
											items:
													[
                                                    	{
                                                        	x:10,
                                                            y:15,
                                                        	html:'Instituci&oacute;n:<font color="red">*</font>'
                                                        }
                                                        ,
                                                        {
                                                        	x:85,
                                                            y:10,
                                                            id:'txtInstitucionNueva',
                                                            xtype:'textfield',
                                                            width:280
                                                        },
                                                        {
                                                        	x:10,
                                                            y:45,
                                                        	html:'CP.:'
                                                        },
                                                        {
                                                        	x:85,
                                                            y:40,
                                                            id:'txtCp',
                                                            xtype:'numberfield',
                                                            width:80,
                                                            allowDecimals:false,
                                                            allowNegative:false
                                                        },
                                                        {
                                                        	x:10,
                                                            y:75,
                                                        	html:'Ciudad:<font color="red">*</font>'
                                                        },
                                                        {
                                                        	x:85,
                                                            y:70,
                                                            id:'txtCiudad',
                                                            xtype:'textfield',
                                                            width:200
                                                        },
                                                        {
                                                        	x:10,
                                                            y:105,
                                                        	html:'Estado:<font color="red">*</font>'
                                                        },
                                                        {
                                                        	x:85,
                                                            y:100,
                                                            id:'txtEstado',
                                                            xtype:'textfield',
                                                            width:200
                                                        },
                                                        {
                                                        	x:10,
                                                            y:135,
                                                        	html:'Pa&iacute;s:<font color="red">*</font>'
                                                        }
                                                        ,
                                                        cmbPais

													]
										}
									)
	var ventana=new Ext.Window(
							   		{
										title:'Agregar Instituci&oacute;n',
										width:400,
										height:240,
										layout:'fit',
										buttonAlign:'center',
										items:[form],
										modal:true,
										plain:true,
										listeners:
											{
												show:
												{
													buffer:10,fn:function()
															{
																Ext.getCmp('txtInstitucionNueva').focus(false,100);
															}
												}
											},
										buttons:
												[
												 	{
														text:'Aceptar',
														handler:function ()
															{
                                                            
                                                            	var txtInstitucion=Ext.getCmp('txtInstitucionNueva');
                                                                var txtCp=Ext.getCmp('txtCp');
                                                                var txtCiudad=Ext.getCmp('txtCiudad');
                                                                var txtEstado=Ext.getCmp('txtEstado');
                                                                if(txtInstitucion.getValue()=='')
                                                                {
                                                                	function resp()
                                                                    {
                                                                    	txtInstitucion.focus();
                                                                    }
                                                                	msgBox("El campo de institución es obligatorio",resp);
                                                                    return;
                                                                }
                                                                
                                                                if(txtCiudad.getValue()=='')
                                                                {
                                                                	function resp()
                                                                    {
                                                                    	txtCiudad.focus();
                                                                    }
                                                                	msgBox("El campo de ciudad es obligatorio",resp);
                                                                    return;
                                                                }
                                                                
                                                                if(txtEstado.getValue()=='')
                                                                {
                                                                	function resp()
                                                                    {
                                                                    	txtEstado.focus();
                                                                    }
                                                                	msgBox("El campo de estado es obligatorio",resp);
                                                                    return;
                                                                }
                                                                var objIns='{"ciudad":"'+cv(txtCiudad.getValue())+'","estado":"'+cv(txtEstado.getValue())+'","idPais":"'+cmbPais.getValue()+'","cp":"'+cv(txtCp.getValue())+'"}';
																var objParam='{"codigoUPadre":"0000100002","nombre":"'+cv(txtInstitucion.getValue())+'","descripcion":"","institucion":"1","objInst":'+objIns+'}';
                                                                guardarInstitucion(objParam,ventana);                                                                
															}
													},
													{
														text:'Cancelar',
														handler:function ()
															{
																ventana.close();
																
															}
													}
												 ]
									}
							   )
	ventana.show();                               
}

function guardarInstitucion(objInst,ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	Ext.getCmp('cmbInstitucion').setRawValue(Ext.getCmp('txtInstitucionNueva').getValue());
        	gE('idInstitucion').value=arrResp[1];
            gE('codInstitucion').value=arrResp[2];
            
            cmbPais=Ext.getCmp('cmbPais');
            var txtCp=Ext.getCmp('txtCp');
            var txtCiudad=Ext.getCmp('txtCiudad');
            var txtEstado=Ext.getCmp('txtEstado');
			var tCP=txtCp.getValue();
            if(tCP!='')
            	tCP='CP. '+tCP;
            var datosC=txtCiudad.getValue()+', '+txtEstado.getValue()+', '+cmbPais.getRawValue()+'. '+tCP;
            gE('lblDatosC').innerHTML=datosC;
            oE('filaRegistro');
            mE('filaDatosC');
            mE('filaDiv1');
            var cmbDiv_1=gE('cmbDiv_1');
            var arrOpciones=[['-1','Ninguno']];
            rellenarCombo(cmbDiv_1,arrOpciones);
        	ventana.close();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=22&param='+objInst,true);
}

function agregarDepto(nDiv)
{
	if(nDiv==1)
    	codigoUnidad=gE('codInstitucion').value;
    else
    {
    	var combo=gE('cmbDiv_'+(nDiv-1));
    	codigoUnidad=combo.options[combo.selectedIndex].value;
    }
    
    
    var form=new Ext.form.FormPanel(
										{
											baseCls: 'x-plain',
											layout:'absolute',
											disabled:false,
                                            defaultType:'label',
											items:
													[
                                                    	{
                                                        	x:10,
                                                            y:15,
                                                        	html:'Departamento:<font color="red">*</font>'
                                                        }
                                                        ,
                                                        {
                                                        	x:120,
                                                            y:10,
                                                            id:'txtDepartamento',
                                                            xtype:'textfield',
                                                            width:280
                                                        }

													]
										}
									)
	var ventana=new Ext.Window(
							   		{
										title:'Agregar Departamento',
										width:430,
										height:140,
										layout:'fit',
										buttonAlign:'center',
										items:[form],
										modal:true,
										plain:true,
										listeners:
											{
												show:
												{
													buffer:10,fn:function()
															{
																Ext.getCmp('txtDepartamento').focus(false,100);
															}
												}
											},
										buttons:
												[
												 	{
														text:'Aceptar',
														handler:function ()
															{
                                                            
                                                            	var txtDepartamento=Ext.getCmp('txtDepartamento');
                                                                if(txtDepartamento.getValue()=='')
                                                                {
                                                                	function resp()
                                                                    {
                                                                    	txtDepartamento.focus();
                                                                    }
                                                                	msgBox("El campo de departamento es obligatorio",resp);
                                                                    return;
                                                                }
                                                                var obj='{"codigoUPadre":"'+codigoUnidad+'","nombre":"'+cv(txtDepartamento.getValue())+'","descripcion":"","institucion":"0"}'
                                                                guardarDepartamento(obj,nDiv,txtDepartamento.getValue(),ventana);
                                                               	 
                                                                                                                         
															}
													},
													{
														text:'Cancelar',
														handler:function ()
															{
																ventana.close();
																
															}
													}
												 ]
									}
							   )
	ventana.show();  
    
    
}

function guardarDepartamento(obj,nDiv,txtDepartamento,ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var combo=gE('cmbDiv_'+nDiv);
            var opcion=cE('option');
            opcion.value=arrResp[2];
            opcion.text=txtDepartamento;
            combo.options[combo.options.length]=opcion;
            combo.selectedIndex=combo.options.length-1;
        	ventana.close();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=22&param='+obj,true);
}

function comboDivisionCambio(combo)
{
	var idCombo=combo.id;
    var arrIdCom=idCombo.split('_');
    var nDiv=parseInt(arrIdCom[1]);
	if(combo.selectedIndex>0)
    {
    	var comboDestino=gE('cmbDiv_'+(nDiv+1));
        eliminarFilasDepto(nDiv+2);
        if(comboDestino==null)
	        subArea(nDiv);	
        comboDestino=gE('cmbDiv_'+(nDiv+1));
    	
        var codUnidad=combo.options[combo.selectedIndex].value;
        function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
            	var arrDatos=eval(arrResp[1]);
            	llenarCombo(comboDestino,arrDatos,true);
		        comboDestino.options[0].text='Ninguno';
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=28&codUnidad='+codUnidad,true);
    }
    else
	  	eliminarFilasDepto(nDiv+1);
}

function subArea(nArea)
{
	var tabla=gE('tablaInstitucion');
    var fila=cE('tr');
    fila.id='filaDiv'+(nArea+1);
    var td1=cE('td');
    td1.setAttribute('height','23');
	setClase(td1,'letraFicha');
    td1.innerHTML='División / Depto. / Área '+(nArea+1)+':';
    var select=cE('select');
    select.id='cmbDiv_'+(nArea+1);
    asignarEvento(select,'change',comboDivisionCambio);
    var td2=cE('td');
    var espacio = document.createTextNode("\u00a0");
    td2.appendChild(espacio);
    espacio = document.createTextNode("\u00a0");
    td2.appendChild(espacio);
    td2.appendChild(select);
    espacio = document.createTextNode("\u00a0");
    td2.appendChild(espacio);
    espacio = document.createTextNode("\u00a0");
    td2.appendChild(espacio);
    var ref=cE('a');
    ref.href='javascript:agregarDepto('+(nArea+1)+')';
    var img=cE('img');
    
    img.src='../images/book_add.jpg';
    img.height='16';
    img.width='16';
    img.title='Registrar nueva División / Depto. / Área';
    img.alt='Registrar nueva División / Depto. / Área';
    ref.appendChild(img);
    td2.appendChild(ref);
    
    fila.appendChild(td1);
    fila.appendChild(td2);
    tabla.appendChild(fila);
}

function eliminarFilasDepto(nDiv)
{
	if(nDiv>1)
    {
    	var posDiv=nDiv;
    	var fila;
    	while(true)
        {
        	fila=gE('filaDiv'+posDiv);
            if(fila==null)
            	return;
            fila.parentNode.removeChild(fila);    
                
            posDiv++;
        }
    }
}