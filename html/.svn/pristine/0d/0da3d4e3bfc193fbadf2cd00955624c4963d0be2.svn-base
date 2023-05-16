<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT codigoUnidad,unidad,(SELECT email FROM 247_instituciones WHERE idOrganigrama=o.idOrganigrama limit 0,1) as mail FROM 817_organigrama o 
				WHERE instColaboradora=1 and institucion=1 ORDER BY unidad";
	$arrInstituciones=$con->obtenerFilasArreglo($consulta);			

	
	$consulta="select idPais,nombre from 238_paises order by nombre";
	$arrPaises=uEJ($con->obtenerFilasArreglo($consulta));
	$paginaInicioLogin="../principalCensida/inicio.php";
	
	$consulta="SELECT cveEstado,estado FROM 820_estados ORDER BY estado";
	$arrEstados=$con->obtenerFilasArreglo($consulta);
?>


Ext.onReady(inicializar);


var arrEstados=<?php echo $arrEstados?>;

var map = new Ext.KeyMap(document, 
								{
									key: 13, 
									fn: autentificarUsuario,
									scope: this
								}
							);

function inicializar()
{
	selPais(gE('cmbPais'));
    
    
}

function autentificarUsuario()
{
	var login=gE('txtLogin').value;
	var passwd=gE('txtPass').value;
	var param=	'{'+
					'"L":"'+login+'",'+
					'"P":"'+passwd+'"'+
				'}';
	
	obtenerDatosWeb('../paginasFunciones/funciones.php',procResp,'POST','funcion=1&param='+param,true);
	function procResp()
	{
		var resp=peticion_http.responseText;
        if(resp==-100)
        {
             msgBox('No puede accesar al sistema, ya que no cuenta con datos de adscripci&oacute;n');
        }
        else
        {
			var objResp=eval(resp);
            if(objResp!=false)
            {
            	window.parent.location.href="<?php if($paginaInicioLogin=="") echo "../principal/inicio.php"; else echo $paginaInicioLogin;  ?>";
            	//window.parent.recargarPagina();
                window.parent.cerrarVentanaFancy();
                
                
            }
            else
            {
                  mE('filaErrorLogin');
                  gE('txtLogin').focus();
            }        
        }
	}			
}

function recuperarDatosAcceso()
{
	var mail=gE('email');
    if(!validarCorreo(mail.value))
    {
    	function resp1()
        {
            gE('email').focus();
        }
    	msgBox('La direcci&oacute;n de E-mail ingresada no es v&aacute;lida',resp1);
    	return;
    }
 	
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        
        switch(arrResp[0])
        {
        	case '1':
            	function resp3()
                {
                	recargarPaginaV1();
                }
                msgBox('Sus datos de acceso han sido enviados a su cuenta de correo electr&oacute;nico',resp3);
                return;
            break;
            case '2':
            
            	function resp2()
                {
                	gE('email').focus();
                }
                msgBox('La direcci&oacute;n de E-mail ingresada no se encuentra registrada en el sistema',resp2);
                return;
            break;
            default:
            	 msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            break;
        }
    }
    obtenerDatosWeb('../paginasFunciones/funciones.php',funcAjax, 'POST','funcion=7&mail='+mail.value,true);
    
}

function recargarPaginaV1()
{
	location.href='./acceso.php';
}

function mostrarVentanaNuevoRegistro()
{
	oE('tblLogin');
    mE('tblRegistro');
    gE('txtApPaterno').focus();
}

function regresarLogin()
{
	mE('tblLogin');
    oE('tblRegistro');
    oE('pRecuperarcontrasena');
    oE('tblBusquedaOSC');
    gE('txtLogin').focus();
}


function agregarInstitucion()
{
	var arrPaises=<?php echo $arrPaises?>;
	var cmbPais=crearComboExt('cmbPaisI',arrPaises,490,35,140);
    cmbPais.setValue('146');
    cmbPais.on('select',function(cmb,registro)
    					{
                        	if(registro.data.id=='146')
                            {
                            	gEx('cmbEstadoI').show();
                                gEx('txtEstadoI').hide();
                            }
                            else
                            {
                            	gEx('cmbEstadoI').hide();
                                gEx('txtEstadoI').show();
                            }
                        }
    			)
    var cmbEstadoI=crearComboExt('cmbEstadoI',arrEstados,120,65,180);
    
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
                                                        	html:'<span style="color:#000">Instituci&oacute;n:<font color="red">*</font></span>'
                                                        }
                                                        ,
                                                        {
                                                        	x:120,
                                                            y:10,
                                                            id:'txtInstitucionNueva',
                                                            xtype:'textfield',
                                                            width:480
                                                        },
                                                       
                                                        {
                                                        	xtype:'fieldset',
                                                            x:5,
                                                            y:45,
                                                            width:670,
                                                            height:130,
                                                            layout:'absolute',
                                                            title:'Direcci&oacute;n de la instituci&oacute;n',
                                                            items:	[
                                                            			{
                                                                        	xtype:'label',
                                                                            x:10,
                                                                            y:10,
                                                                            html:'<span style="color:#000">Calle:<font color="red"></font></span>'
                                                                        },
                                                                        {
                                                                        	xtype:'textfield',
                                                                            width:180,
                                                                            x:70,
                                                                            y:5,
                                                                            id:'txtCalleI'
                                                                        },
                                                                        {
                                                                        	xtype:'label',
                                                                            x:280,
                                                                            y:10,
                                                                            html:'<span style="color:#000">No. Int:<font color="red"></font></span>'
                                                                        },
                                                                        {
                                                                        	xtype:'textfield',
                                                                            width:80,
                                                                            x:330,
                                                                            y:5,
                                                                            id:'txtNoIntI'
                                                                        },
                                                                        {
                                                                        	xtype:'label',
                                                                            x:440,
                                                                            y:10,
                                                                            html:'<span style="color:#000">No. Ext:<font color="red"></font></span>'
                                                                        },
                                                                        {
                                                                        	xtype:'textfield',
                                                                            width:80,
                                                                            x:490,
                                                                            y:5,
                                                                            id:'txtNoExtI'
                                                                        },
                                                                        {
                                                                        	xtype:'label',
                                                                            x:10,
                                                                            y:40,
                                                                            html:'<span style="color:#000">Colonia:<font color="red"></font></span>'
                                                                        },
                                                                        {
                                                                        	xtype:'textfield',
                                                                            width:180,
                                                                            x:70,
                                                                            y:35,
                                                                            id:'txtColoniaI'
                                                                        },
                                                                        {
                                                                        	xtype:'label',
                                                                            x:280,
                                                                            y:40,
                                                                            html:'<span style="color:#000">CP:<font color="red"></font></span>'
                                                                        },
                                                                        {
                                                                        	xtype:'textfield',
                                                                            width:80,
                                                                            x:330,
                                                                            y:35,
                                                                            id:'txtCPI'
                                                                        },
                                                                        {
                                                                        	xtype:'label',
                                                                            x:440,
                                                                            y:40,
                                                                            html:'<span style="color:#000">Pa&iacute;s:<font color="red"></font></span>'
                                                                        },
                                                                        cmbPais,
                                                                        {
                                                                        	xtype:'label',
                                                                            x:10,
                                                                            y:70,
                                                                            html:'<span style="color:#000">Estado/provincia:</span>'
                                                                        },
                                                                         {
                                                                        	xtype:'textfield',
                                                                            width:180,
                                                                            x:120,
                                                                            y:65,
                                                                            hidden:true,
                                                                            id:'txtEstadoI'
                                                                        },
                                                                        cmbEstadoI,
                                                                        {
                                                                        	xtype:'label',
                                                                            x:330,
                                                                            y:70,
                                                                            html:'<span style="color:#000">Municipio:</span>'
                                                                        },
                                                                        {
                                                                        	xtype:'textfield',
                                                                            width:180,
                                                                            x:420,
                                                                            y:65,
                                                                            id:'txtMunicipioI'
                                                                        }
                                                            		]
                                                        }
                                                        
                                                        
                                                        
                                                        

													]
										}
									)
	var ventana=new Ext.Window(
							   		{
										title:'Agregar Instituci&oacute;n',
										width:700,
										height:260,
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
                                                            
                                                            	var txtInstitucion=gEx('txtInstitucionNueva');
                                                                
                                                                
                                                                if(txtInstitucion.getValue()=='')
                                                                {
                                                                	function resp()
                                                                    {
                                                                    	txtInstitucion.focus();
                                                                    }
                                                                    msgBox('Debe indicar el nombre de la instituci&oacute;n',resp);
                                                                    return;
                                                                }
                                                                
                                                               
                                                                
                                                                
                                                                var txtCalleI=gEx('txtCalleI');
                                                                var txtNoIntI=gEx('txtNoIntI');
                                                                var txtNoExtI=gEx('txtNoExtI');
                                                                var txtColoniaI=gEx('txtColoniaI');
                                                                var txtCPI=gEx('txtCPI');
                                                                var cmbPais=gEx('cmbPaisI');
                                                                var txtEstadoI=gEx('txtEstadoI');
                                                                var cmbEstadoI=gEx('cmbEstadoI');
                                                                var txtMunicipioI=gEx('txtMunicipioI');
                                                                
                                                                var objIns='{"calle":"'+cv(txtCalleI.getValue())+'","noInt":"'+cv(txtNoIntI.getValue())+'","noExt":"'+cv(txtNoExtI.getValue())+
                                                                			'","colonia":"'+cv(gEx('txtColoniaI').getValue())+'","cp":"'+cv(txtCPI.getValue())+'","pais":"'+cmbPais.getValue()+'","estado":"'+cmbEstadoI.getValue()+
                                                                            '","municipio":"'+cv(txtMunicipioI.getValue())+'"}';
																var objParam='{"codigoUPadre":"0001","nombre":"'+cv(txtInstitucion.getValue())+'","descripcion":"","institucion":"1","objInst":'+objIns+'}';
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
        	var objDatos=eval('['+arrResp[1]+']')[0];
        	rellenarCombo(gE('cmbInstitucion'),objDatos.arrInstituciones);
            selElemCombo(gE('cmbInstitucion'),objDatos.idInstitucion);
        	ventana.close();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SMSP.php',funcAjax, 'POST','funcion=1&param='+objInst,true);
}


function registrarCuenta()
{

	var sexo=0;
    
	var txtPrefijo=gE('txtPrefijo').value;
	var txtApPaterno=gE('txtApPaterno').value;
    var txtApMaterno=gE('txtApMaterno').value;
    var txtNombre=gE('txtNombre').value;
    var cmbInstitucion=gE('cmbInstitucion');
    var txtDepartamento=gE('txtDepartamento').value;

	var txtCalle=gE('txtCalle').value;
    var txtNoInt=gE('txtNoInt').value;
    var txtNoExt=gE('txtNoExt').value;
    var txtColonia=gE('txtColonia').value;
    var txtCP=gE('txtCP').value;
    var txtMunicipio=gE('txtMunicipio').value;

	var txtMail=gE('txtMail');
    var txtMail2=gE('txtMail2');
    var txtMailAlterno=gE('txtMailAlterno');
    
    var txtContrasena=gE('txtContrasena');
    var txtContrasena2=gE('txtContrasena2');
    
    var cmbEstado=gE('cmbEstado');
    var txtEstado=gE('txtEstado');
    
    var cmbPais=gE('cmbPais');
    
    var sexo=0;
    if(gE('sexoF').checked)
        sexo=1;
    
    
    
	if(validarFormularios('frmEnvio'))
    {
    	if(txtMail.value!=txtMail2.value)	
        {
        	function resp()
            {
            	txtMail2.focus();
            }
            msgBox('El E-mail ingresado NO coincide',resp);
            return;
        }
        
        if(txtContrasena.value!=txtContrasena2.value)	
        {
        	function resp2()
            {
            	txtContrasena2.focus();
            }
            msgBox('La contrase&ntilde;a ingresada NO coincide',resp2);
            return;
        }
        
        var estado='';
        if(cmbPais.value=='146')
        {
        	if(cmbEstado.selectedIndex==0)
            {
            	function resp3()
                {
                    cmbEstado.focus();
                }
                msgBox('Debe indicar el estado de corresponencia',resp3);
                return;
            }
            
            
            estado=cmbEstado.options[cmbEstado.selectedIndex].value;
            
        }
        else
        {
        	if(txtEstado.value=='')
            {
            	function resp4()
                {
                    txtEstado.focus();
                }
                msgBox('Debe indicar el estado/provincia de corresponencia',resp4);
                return;
            }
            
            estado=txtEstado.value;
        }
        
        if(!validarCorreo(txtMail.value))
        {
        	function resp5()
            {
                txtMail.focus();
            }
            msgBox('La direcci&oacute;n de E-mail ingresada No es v&aacute;lida',resp5);
            return;
        }
        
        if((txtMailAlterno.value!='')&&(validarCorreo(txtMailAlterno.value)))
        {
        	function resp6()
            {
                txtMail.focus();
            }
            msgBox('La direcci&oacute;n de E-mail alterna ingresada No es v&aacute;lida',resp6);
            return;
        }
        
        
        var cadObj='{"titulo":"'+cv(txtPrefijo)+'","apPaterno":"'+cv(txtApPaterno)+'","txtApMaterno":"'+cv(txtApMaterno)+'","nombre":"'+cv(txtNombre)+'","sexo":"'+sexo+'","institucion":"'+
        			cmbInstitucion.options[cmbInstitucion.selectedIndex].value+'","departamento":"'+cv(txtDepartamento)+'","calle":"'+cv(txtCalle)+'","noInt":"'+cv(txtNoInt)+'","noExt":"'+cv(txtNoExt)+
                    '","colonia":"'+cv(txtColonia)+'","cp":"'+cv(txtCP)+'","pais":"'+cmbPais.options[cmbPais.selectedIndex].value+'","estado":"'+cv(estado)+'","municipio":"'+cv(txtMunicipio)+
                    '","email":"'+cv(txtMail.value)+'","emailAlterno":"'+cv(txtMailAlterno.value)+'","passwd":"'+cv(txtContrasena.value)+'"}';
        
    	function funcGuardar()
        {
            var arrResp=peticion_http.responseText.split("|");
            if(arrResp[0]=='1')
            {
            	if(arrResp[1]=='2')
                {
                	msgBox('La direcci&oacute;n de E-mail ingresada ya ha sido registrada previamente');
                	return;
                }
            
                function respMail()
                {
                 	location.href='../principalPortal/inicio.php';   
                }
                msgBox('Su cuenta ha sido registrada de manera exitosa, en breve recibir&aacute; un correo electr&oacute;nico con sus datos de acceso',respMail);   
                return;
            }
            else
                msgBox('<?php echo $etj["errOperacion"].' '?>'+arrResp[0]);
        }
        obtenerDatosWeb("../paginasFunciones/funcionesModulosEspeciales_SMSP.php",funcGuardar,'POST','funcion=2&'+'cadObj='+cadObj,true);
	}
}


function validar()
{
	
}



function selPais(cmb)
{
	var val=cmb.options[cmb.selectedIndex].value;
    if(val=='146')	
    {
    	oE('txtEstado');
        mE('cmbEstado');
    }
    else
    {
    	oE('cmbEstado');
        mE('txtEstado');
    }
}
