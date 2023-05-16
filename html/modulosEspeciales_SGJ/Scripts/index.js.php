<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
?>

Ext.onReady(inicializar);

function inicializar()
{


	var arrDimensiones=obtenerDimensionesNavegador();
    
    if(window.location.href!=window.parent.location.href)
    {
    	obtenerVentanaPadre(window,location.href);  
	}
    
    new Ext.ux.IFrameComponent({ 

                                    id: 'frameContenidoPrincipal', 
                                    anchor:'100% 100%',
                                    border:false,
                                    renderTo:'areaCentralTrabajo',
                                    loadFuncion:function(iFrame)
                                                {
                                                    
                                                    
                                                    autofitIframe(iFrame,
                                                                    function()
                                                                    {
                                                                        //$(".magnify").jfMagnify();
                                                                     });
                                                    
                                                },

                                    url: '../paginasFunciones/white.php',
                                    style: 'width:100%;height:700px' 
                            })

    

	mostrarPantallaInicio();
    
}

function obtenerVentanaPadre(ventana,ultimaPagina)
{
	
    if((ventana.parent)&&(ventana.parent.location.href!=ultimaPagina))
	    obtenerVentanaPadre(ventana.parent,ventana.location.href)
	else
    {
    	ventana.parent.location.href='<?php echo $paginaInicioLogin?>';
    }

}

function autenticar()
{
	var txtUsuario=gE('txtUsuario');
    var txtPasswd=gE('txtPasswd');
    var dominio=gE('txtDominio');
    
    if(dominio)
    {
    	if((dominio.value.trim()=='')||(dominio.value.trim()==''))
        {
            mE('lblErr2');
            oE('lblErr1');
            dominio.focus();
            return;
        } 
    }
    
    var l='';
    var p='';
    var d='';
   

    if((txtUsuario.value.trim()=='')||(txtPasswd.value.trim()==''))
    {
    	mE('lblErr1');
        oE('lblErr2');
        txtUsuario.focus();
        return;
    }    
    
    <?php
	if(isset($Enable_AES_Ecrypt)&&($Enable_AES_Ecrypt==true))
	{
	?>
		l=AES_Encrypt(txtUsuario.value.trim());
		p=AES_Encrypt(txtPasswd.value.trim());
        if(dominio)
	        d=AES_Encrypt(dominio.value.trim());
	<?php        
	}
	else
	{
	?>
		l=bE(txtUsuario.value.trim());
		p=bE(txtPasswd.value.trim());
        if(dominio)
	        d=bE(dominio.value.trim());
	<?php        
	}
	?>
    
    function funcAjax(peticion_http)
    {
    	var rutaRedireccion='../principalPortal/inicio.php';
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
         	if( arrResp[1] =='0')
            {
            	gE('lblErr1').innerHTML='Usuario / Contraseña incorrecta';
            	mE('lblErr1');
                txtUsuario.focus();
            }
            else
            {
            	if( arrResp[1] =='1')
	            	location.href=rutaRedireccion;
               else
               {
	               if(arrResp[1] =='2')
                   {
                   		var iU=arrResp[2];
                        var txtUsuario=gE('txtUsuario');
                        var txtPasswd=gE('txtPasswd');
                        var dominio=gE('txtDominio');
                        txtUsuario.value='';
                        txtPasswd.value='';
                        if(dominio)
	                        dominio.value='';
                        
                        mostrarVentana2FA(iU,rutaRedireccion);
                        
                   }
                   else
                   {
                   		if( arrResp[1] =='3')
                        {
                        	gE('lblErr1').innerHTML='Cuenta Bloqueada';
                            mE('lblErr1');
                            txtUsuario.focus();
                        }
                        else
                        {
                        	if( arrResp[1] =='4')
                            {
                                gE('lblErr1').innerHTML='Cuenta Inactiva';
                                mE('lblErr1');
                                txtUsuario.focus();
                            }
                        }
                   }
               }
            }
        }
        else
        {
            msgBox('No se ha podido realizar la operaci&oacute;n debido al siguiente problema: '+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funciones.php',funcAjax, 'POST','funcion=8&d='+d+'&l='+l+'&p='+p,true);
    
    
    
    
}

function ocultarError(evt)
{
	oE('lblErr1');
    oE('lblErr2');
    var key= evt.which;
	if(Ext.isIE)
		key=evt.keyCode;
        
    if(key==13)
    {
    	autenticar();
    }
}

function mostrarPantallaRegistro()
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJ/registroUsuario.php';
    abrirVentanaFancy(obj);
}

function mostrarPantallaRecuperar()
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
                                                            xtype:'label',
                                                            html:'<span class="SIUGJ_Etiqueta"><b>Ingrese la dirección de correo electrónico con la cual se registr&oacute;: <span style="color:#F00">*</span></b></span>'
                                                        },
                                            			{
                                                            x:10,
                                                            y:50,
                                                            xtype:'label',
                                                            html:'<span class="SIUGJ_Etiqueta"><b>Correo Electr&oacute;nico: <span style="color:#F00">*</span></b></span>'
                                                        },
                                                        {
                                                            x:200,
                                                            y:50,
                                                            xtype:'textfield',
                                                            width:320,
                                                            id:'email'
                                                        },
                                                        {
                                                            xtype:'button',
                                                            x:550,
                                                            y:45,
                                                            height:30,
                                                            width:140,
                                                            id:'btnAceptar',
                                                            disabled:false,
                                                            
                                                            text:'Recuperar',
                                                            cls:'btnSIUGJ',
                                                            width:160,
                                                            handler:function()
                                                                  {
                                                                    recuperarDatosAcceso();
                                                                  }
                                                         }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'vRecuperar',
										title: 'Recuperar Contrase&ntilde;a',
										width: 800,
										height:180,
                                        cls:'msgHistorialSIUGJ',
										layout: 'fit',
										plain:true,
                                        closable:false,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	gEx('email').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:160,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	

	

	/*var obj={};
    obj.ancho='100%';
    obj.alto='90%';
    obj.url='../modulosEspeciales_SGJ/recuperarDatosAcceso.php';
    abrirVentanaFancy(obj);*/
}


function mostrarPantallaSoporte()
{
	mostrarVentanaDuda();
}



function mostrarVentana2FA(iU,pR)
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
                                                            html:'Ingrese el C&oacute;digo de Acceso:'
                                                        },
                                                        {
                                                        	x:180,
                                                            y:5,
                                                            id:'txtCodigoAcceso',
                                                            xtype:'textfield',
                                                            width:110
                                                        },
                                                        {
                                                        	x:90,
                                                            y:40,
                                                            html:'<a href="javascript:reenviarCodigoAcceso(\''+bE(iU)+'\')">Reenviar C&oacute;digo de Acceso</a>'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'C&oacute;digo de Acceso',
										width: 350,
										height:140,
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
                                                                	gEx('txtCodigoAcceso').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',                                                            
															handler: function()
																	{
                                                                    
                                                                    	if(gEx('txtCodigoAcceso').getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	gEx('txtCodigoAcceso').focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el C&oacute;digo de Acceso',resp)
                                                                        	return;
                                                                        }
                                                                    
																		function funcAjax(peticion_http)
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                if( arrResp[1] =='0')
                                                                                {
                                                                                    function resp2()
                                                                                    {
                                                                                        gEx('txtCodigoAcceso').focus();
                                                                                    }
                                                                                    msgBox('El C&oacute;digo de Acceso ingresado es Incorrecto',resp2)
                                                                                    return;
                                                                                }
                                                                                else
                                                                                {
                                                                                	location.href=(pR);
                                                                                    ventanaAM.close();
                                                                                  
                                                                                }
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWebV2('../paginasFunciones/funciones.php',funcAjax, 'POST','funcion=13&cA='+bE(gEx('txtCodigoAcceso').getValue())+'&iU='+bE(iU),true);
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

function reenviarCodigoAcceso(iU)
{
	function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            msgBox('El C&oacute;digo de Acceso ha sido Enviado de Nuevo');
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funciones.php',funcAjax, 'POST','funcion=12&iU='+iU,true);
    

}

function mostrarPantallaRegistroIndex()
{
	gEx('frameContenidoPrincipal').load	(
    										{
                                            	url:'../modulosEspeciales_SIUGJ/registroUsuario.php',
                                                params:		{
                                                				cPagina:'sFrm=true'
                                                			}
                                            }
    									);
}


function mostrarPantallaInicio()
{
	gEx('frameContenidoPrincipal').load	(
    										{
                                            	url:'../principalPortal/portalInicio.php',
                                                params:		{
                                                				cPagina:'sFrm=true'
                                                			}
                                            }
    									);
}


function mostrarPantallaValidarDocumento()
{
	gEx('frameContenidoPrincipal').load	(
    										{
                                            	url:'../gestorDocumental/validaDocumentos.php',
                                                params:		{
                                                				cPagina:'sFrm=true'
                                                			}
                                            }
    									);
}


function mostrarPantallaAudiencias()
{
	gEx('frameContenidoPrincipal').load	(
    										{
                                            	url:'../reportes/tblReporteSalasCalendario.php',
                                                params:		{
                                                				cPagina:'sFrm=true'
                                                			}
                                            }
    									);
}

function mostrarPantallaRemates()
{
	gEx('frameContenidoPrincipal').load	(
    										{
                                            	url:'../modulosEspeciales_SIUGJ/tblBienes.php',
                                                params:		{
                                                				cPagina:'sFrm=true'
                                                			}
                                            }
    									);
}

function recuperarDatosAcceso()
{
	var mail=gEx('email');
    if(!validarCorreo(mail.getValue()))
    {
    	function resp1()
        {
            gEx('email').focus();
        }
    	msgBox('La direcci&oacute;n de correo electr&oacute;nico ingresada no es v&aacute;lida',resp1);
    	return;
    }
 	
    function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        
        switch(arrResp[0])
        {
        	case '1':
            	function resp3()
                {
                	gEx('vRecuperar').close();
                }
                msgBox('Sus datos de acceso han sido enviados a la cuenta de correo electr&oacute;nico registrada',resp3);
                return;
            break;
            /*case '2':
            
            	function resp2()
                {
                	gEx('email').focus();
                }
                msgBox('La direcci&oacute;n de correo electr&oacute;nico ingresada no se encuentra registrada en el sistema',resp2);
                return;
            break;*/
            default:
            	 msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            break;
        }
    }
    obtenerDatosWebV2('../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',funcAjax, 'POST','funcion=7&mail='+mail.getValue(),true);
    
}