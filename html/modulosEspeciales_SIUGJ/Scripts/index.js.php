<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
?>
const IDIOMAS_PREFERIDOS = ["es-MX", "es-US", "es-ES", "es_US", "es_ES"];


var habilitarLupa=false;

Ext.onReady(inicializar);

function inicializar()
{

	habilitarLupa=gE('mostrarLupa').value=='1';
    
	var arrDimensiones=obtenerDimensionesNavegador();
    
    if(window.location.href!=window.parent.location.href)
    {
    	obtenerVentanaPadre(window,location.href);  
	}
    
   	if(gE('totalPublicaciones').value!='0')
    {
        $('#carousel').infiniteCarousel	(
                                            {
                                                imagePath:'../Scripts/infiniteCarousel/images/',
                                                autoPilot :true
                                            }
                                        );       
	}
    
    if(habilitarLupa)
    {
    	showLupa();
	}
        
    
   	cargaVocesTTL();
    
    if(gE('altoContraste').value=='0')
    {
        new Ext.Button (
                            {
                                icon:'../principalPortal/imagesSIUGJ/lupaBarra.png',
                                width:40,
                                height:40,
                                cls:'btnSIUGJCancel',
                                id:'btnGuardarForm',
                                renderTo:'btn1',
                                handler:function()
                                        {
                                            habilitarLupaSitio();
                                        }
                                
                            }
                        )
        new Ext.Button (
                            {
                                icon:'../principalPortal/imagesSIUGJ/brilloContraste.png',
                                width:40,
                                height:40,
                                cls:'btnSIUGJCancel',
                                id:'btnGuardarForm',
                                renderTo:'btn2',
                                handler:function()
                                        {
                                         	cambiarContraste();   
                                        }
                                
                            }
                        )
    
        new Ext.Button (
                            {
                                icon:'../principalPortal/imagesSIUGJ/altavoz.png',
                                cls:'btnSIUGJCancel',
                                width:40,
                                height:40,
                                id:'btnGuardarForm',
                                renderTo:'btn3',
                                handler:function()
                                        {
                                            getSelectedText();
                                        }
                                
                            }
                        )                    
	}
    else
    {
    	new Ext.Button (
                            {
                                icon:'../principalPortal/imagesSIUGJ/lupaBarra_0.png',
                                width:36,
                                height:36,
                                cls:'btnSIUGJ',
                                id:'btnGuardarForm',
                                renderTo:'btn1',
                                handler:function()
                                        {
                                            habilitarLupaSitio();
                                        }
                                
                            }
                        )
        new Ext.Button (
                            {
                                icon:'../principalPortal/imagesSIUGJ/brilloContraste_0.png',
                                width:36,
                                height:36,
                                cls:'btnSIUGJ',
                                id:'btnGuardarForm',
                                renderTo:'btn2',
                                handler:function()
                                        {
                                            cambiarContraste();   
                                        }
                                
                            }
                        )
    
        new Ext.Button (
                            {
                                icon:'../principalPortal/imagesSIUGJ/altavoz_0.png',
                                cls:'btnSIUGJ',
                                width:36,
                                height:36,
                                id:'btnGuardarForm',
                                renderTo:'btn3',
                                handler:function()
                                        {
                                            getSelectedText();
                                        }
                                
                            }
                        ) 
    }
    
    
}

var idLupa;
function showLupa()
{
	mE('magnify_glass');
    $(".magnify").jfMagnify();
    idLupa=setInterval(function(){refrescarMagnify();},2000);
    window.scrollTo(0, 0);

}


function ocultaLupa()
{
	oE('magnify_glass');
    clearInterval(idLupa);
    $(".magnify").data("jfMagnify").destroy();

}

function refrescarMagnify()
{
	$(".magnify").data("jfMagnify").updateZone();

}

var vocesDisponibles=[];
var vozDefault=null;
function cargaVocesTTL()
{
	if (!'speechSynthesis' in window) 
      	return alert("Lo siento, tu navegador no soporta esta tecnología");
    
   	
    const cargarVoces = () => {
                                if (vocesDisponibles.length > 0) 
                                {
                                  
                                  return;
                                }
                                vocesDisponibles = speechSynthesis.getVoices();
                                var a;
                                var encontrado=false;
                                var x;
                                for(a=0;a<IDIOMAS_PREFERIDOS.length;a++)
                                {
                                    for(x=0;x<vocesDisponibles.length;x++)
                                    {
                                    	
                                    	if(IDIOMAS_PREFERIDOS[a]==vocesDisponibles[x].lang)
                                        {
                                        	vozDefault=vocesDisponibles[x];
                                        	encontrado=true;
                                        }  
                                        if(encontrado)
                                        	break;  
                                    }
                                    if(encontrado)
                                        break;
								}  
                                if(!encontrado)
                                {
                                	vozDefault=vocesDisponibles[0];
                                }                              
                              };
  
  
  	cargarVoces();

    if ('onvoiceschanged' in speechSynthesis) 
    {
      speechSynthesis.onvoiceschanged = function () 
      {
        cargarVoces();
      };
    }
}

function getSelectedText()
{
	var textoSeleccionado='';
    if (window.getSelection) 
    {  
        var range = window.getSelection ();
        textoSeleccionado=range.toString ();
    } 
    else 
    {
        if (document.selection.createRange) 
        { 
            var range = document.selection.createRange();
            textoSeleccionado=range.text;
        }
    }
    
    if(textoSeleccionado=='')
    	textoSeleccionado='Primero debe seleccionar un texto';
    
    let mensaje = new SpeechSynthesisUtterance();
    mensaje.voice = vozDefault;
    mensaje.rate = 1;
    mensaje.text = textoSeleccionado;
    mensaje.pitch = 1;
    speechSynthesis.speak(mensaje); 

    
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
		l=AES_Encrypt(bE(txtUsuario.value.trim()));
		p=AES_Encrypt(bE(txtPasswd.value.trim()));
        if(dominio)
	        d=AES_Encrypt(bE(dominio.value.trim()));
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
        return;
    }
    if(event.target.id=='')
    {
    	gE(event.target.name).value=event.target.value+String.fromCharCode(key);
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
                                                            y:45,
                                                            xtype:'textfield',
                                                            width:320,
                                                            height:45,
                                                            cls:'controlSIUGJ',
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
										height:210,
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
                                                            cls:'btnSIUGJCancel               ',
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
	var obj={};
    obj.ancho='100%';
    obj.alto='90%';
    obj.url='https://soporte.siugj.com';
    abrirVentanaFancy(obj);

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
                                                            y:15,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Ingrese el C&oacute;digo de Acceso:'
                                                        },
                                                        {
                                                        	x:280,
                                                            y:10,
                                                            cls:'controlSIUGJ',
                                                            id:'txtCodigoAcceso',
                                                            xtype:'textfield',
                                                            width:110,
                                                            enableKeyEvents :true,
                                                            listeners:	{
                                                                            keypress:function(txt,e)
                                                                                {
                                                                                	if((txt.getValue().length+1)>6)
                                                                                    {
                                                                                        e.stopEvent();
                                                                                    }
                                                                                }
                                                                         },
                                                                               
                                                            autoCreate:{tag: 'input', type: 'text', style:'height:30px;',  autocomplete: 'off'}
                                                        },
                                                        {
                                                        	x:90,
                                                            y:65,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'<a href="javascript:reenviarCodigoAcceso(\''+bE(iU)+'\')">Reenviar C&oacute;digo de Acceso</a>'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'C&oacute;digo de Acceso',
										width: 500,
										height:200,
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
                                        cls:'msgHistorialSIUGJ',
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
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.params=[['cPagina','sFrm=true']];
    obj.url='../modulosEspeciales_SIUGJ/registroUsuario.php';
    abrirVentanaFancy(obj);
    
	
}


function mostrarPantallaInicio()
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.params=[['cPagina','sFrm=true']];
    obj.url='../principalPortal/portalInicio.php';
    abrirVentanaFancy(obj);
	
}


function mostrarPantallaValidarDocumento()
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.params=[['cPagina','sFrm=true']];
    obj.url='../gestorDocumental/validaDocumentos.php';
    abrirVentanaFancy(obj);
	
}


function mostrarPantallaAudiencias()
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.params=[['cPagina','sFrm=true']];
    obj.url='../reportes/frmReporteSalaCalendario.php';
    abrirVentanaFancy(obj);

}

function mostrarPantallaRemates()
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.params=[['cPagina','sFrm=true']];
    obj.url='../modulosEspeciales_SIUGJ/tblBienes.php';
    abrirVentanaFancy(obj);
}

function mostrarPantallaPublicaciones()
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.params=[['cPagina','sFrm=true']];
    obj.url='../modulosEspeciales_SIUGJ/tblPublicacionesGenerales.php';
    abrirVentanaFancy(obj);
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


function habilitarLupaSitio()
{
	gE('mostrarLupa').value=(gE('mostrarLupa').value=='1'?'0':'1');
	function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	if(gE('mostrarLupa').value=='0')
            	ocultaLupa();
            else
	            showLupa();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funciones.php',funcAjax, 'POST','funcion=15&tipoValor=1&valor='+gE('mostrarLupa').value,true);
}


function cambiarContraste()
{
	function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            location.reload();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funciones.php',funcAjax, 'POST','funcion=15&tipoValor=2&valor='+(gE('altoContraste').value=='1'?'0':'1'),true);
}