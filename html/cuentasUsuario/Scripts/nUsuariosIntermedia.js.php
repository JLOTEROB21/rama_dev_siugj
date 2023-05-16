<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$consulta="SELECT idPais,nombre FROM 238_paises ORDER BY nombre";
	$arrPaises=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT * FROM 903_variablesSistema WHERE idVariable=1";
	$objConfiguracion=$con->obtenerFilasJSON($consulta);	
	
	$consulta="SELECT id__32_tablaDinamica,tipoIdentificacion,funcionValidacion,funcionAfterSelect,
				maxLongitud,caracteresPermitidos,indicaNacionalidadLocal,contieneFechaExpedicion,muestraTarjetaProfesional FROM _32_tablaDinamica 
				ORDER BY prioridad";
	$arrTipoIdentificacionConfiguracion=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT idTipoTelefono,tipoTelefono FROM 1006_tipoTelefono";
	$arrTelefonos=$con->obtenerFilasArreglo($consulta);
	$fechaActual=date("Y-m-d");
	
?>
var servicioRegistraduriaOff=false;
var objDatos=null;
var arrPaises=<?php echo $arrPaises?>;
var arrHuellas=[];
var arrTelefonos=<?php echo $arrTelefonos?>;
var arrTipoIdentificacionConfiguracion=<?php echo $arrTipoIdentificacionConfiguracion?>;
var arrMinusculas='abcdefghijklmnñopqrstuvwxyz';
var arrMayusculas='ABCDEFGHIJKLMNÑOPQRSTUVWXYZ';
var arrNumeros='0123456789';
var arrEspeciales='!"#$%&()=¿?[]\'+-*/_;@.,;';

var objConfiguracion=eval(<?php echo $objConfiguracion?>)[0];


Ext.onReady(inicializar);

function inicializar()
{
	
	 new Ext.Button (
                            {
                               
                                text:'Guardar',
                                width:140,
                                height:40,
                                cls:'btnSIUGJ',
                                renderTo:'contenedor1',
                                handler:function()
                                        {
                                           GuardarIdentifica('nIdentifica');
                                        }
                                
                            }
                        )
	if(gE('contenedor2'))
    {
    	 new Ext.Button (
                            {
                                
                                cls:'btnSIUGJCancel',
                                text:'Cancelar',
                                width:140,
                                height:42,
                                renderTo:'contenedor2',
                                handler:function()
                                        {
                                        	if(gE('cambioDatosUsrPrimeraVez'))
	                                        	cancelar();
                                        	else
                                            {
                                               function resp(btn)
                                               {
                                                    if(btn=='yes')
                                                        window.parent.cerrarVentanaFancy();
                                               }
                                               msgConfirm('¿Est&aacute; seguro de querer cancelar la operaci&oacute;n?',resp);
											}
                                        }
                                
                            }
                        )
    }   
    
    
	crearCampoFecha('FNac','FNacimiento',null,null,null,{maxValue:'<?php echo $fechaActual?>',ctCls:'campoFechaSIUGJ',width:370});
    if(gE('FExp'))
	    crearCampoFecha('FExp','FExpedicion',null,null,null,{maxValue:'<?php echo $fechaActual?>',ctCls:'campoFechaSIUGJ',width:370});
	
	
	gE('Nombre').focus();
	arrHuellas=eval(gE('arrHuellas').value);
	crearGridHuellasCapturadas();
    
    asignarEvento(gE('tipoIdentificacion'),'change',function(ctrl)
        							{
                                    	var valor=ctrl.options[ctrl.selectedIndex].value;
                                    	var pos=existeValorMatriz(arrTipoIdentificacionConfiguracion,valor);
                                        var fila=arrTipoIdentificacionConfiguracion[pos];
                                        
                                        
                                        if(fila[7]=='1')
                                        {
                                            mE('lblFechaExpedicion');
                                            mE('FExp');	
                                        }
                                        else
                                        {
                                            oE('lblFechaExpedicion');
                                            oE('FExp');	
                                        }
                                        
                                        
                                        gEx('f_FExp').setValue('');
                                        gE('noIdentificacion').value='';
                                        gE('FExpedicion').value='';
                                        if(fila[3]!='')
                                        {
                                            eval(fila[3]+'('+valor+',null);');
                                        }
                                    }
        			);   
             
}


function funcFechaCamb(campo,nuevoV,viejoV)
{
    var f=new  Date(nuevoV);
    gE('FNacimiento').value=f.format('d/m/Y');
}


function bloquearDatosUsuario()
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            recargarPagina();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesRecursosHumanos.php',funcAjax, 'POST','funcion=67&u='+bE(gE('idUsuario').value)+'&s='+bE(1),true);
}

function desBloquearDatosUsuario()
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
         	recargarPagina();   
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesRecursosHumanos.php',funcAjax, 'POST','funcion=67&u='+bE(gE('idUsuario').value)+'&s='+bE(0),true);
}



var keyMap = new Ext.KeyMap(document, 
									{
										key: 13, 
										fn: funValidar,
										scope: this
									}
							);

function funValidar()
{
	var btnGuardar=gE('btnGuardar');
	btnGuardar.click();
	
}


function GuardarIdentifica(form)
{
	if (!validarFormularios(form))
	{
		return;
	}
	else
	{
		if(!validarTipoDocumentoIdentificacion())
        {
        	return;
		}
        
        var cmbTipoIdentificacion=gE('tipoIdentificacion');
	  	var tipoIdentificacion=cmbTipoIdentificacion?cmbTipoIdentificacion.options[cmbTipoIdentificacion.selectedIndex].value:gE('lblTipoIdentificacion').value;
        
        if(cmbTipoIdentificacion)
        {
            function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                    if((tipoIdentificacion=='4')&& cmbTipoIdentificacion)
                    {
                        function funcAjax()
                        {
                            var resp=peticion_http.responseText;
                            arrResp=resp.split('|');
                            if(arrResp[0]=='1')
                            {
                                var resp1=bD(arrResp[2]);
                    
                                objDatos=eval('['+resp1+']')[0];

                                if((objDatos.esInfoWS=='1')&&(objDatos.conInformacion=='1'))
                                {
                                    
                                    if((objDatos.situacionCedula!=0)&&(objDatos.situacionCedula!=1)&&(objDatos.situacionCedula!=12)&&(objDatos.situacionCedula!=14))
                                    {
                                        msgBox('El documento de identificaci&oacute;n no est&aacute; vigente')
                                        return false;
                                    }
                                    
                                    
                                    
                                }
                                else
                                {
          
                                    if(objDatos.situacionCedula=='-1')
                                    {
                                        
                                        msgBox('El tipo y n&uacute;mero de documento no son v&aacute;lidos, por favor revise los datos ingresados');
                                        return false;
                                    }
                                    else
                                    {
                                        if(objDatos.situacionCedula=='-1001')
                                        {
                                            servicioRegistraduriaOff=true;
                                            //msgBox('No se pudo establecer conexión con la registradur&iacute;a');
                                        }
                                    }
                                    
                                }
                            
                            
                                if((objDatos)&&(!servicioRegistraduriaOff))
                                {
                                    
                                
                                    if(quitarAcentos(gE('Nombre').value).toUpperCase()!=quitarAcentos(objDatos.datosParticipante.nombre).toUpperCase())
                                    {
                                        errorRegistraduria=true;
                                        leyenda='El primer nombre no coincide con registradur&iacute;a';
                                        function resp1()
                                        {
                                            control=gE('Nombre');
                                            control.focus();
                                        }
                                        msgBox(leyenda,resp1)
                                        return;
                                    }
                                    
                                    
                                    if(quitarAcentos(gE('Apat').value).toUpperCase()!=quitarAcentos(objDatos.datosParticipante.apellidoPaterno).toUpperCase())
                                    {
                                        errorRegistraduria=true;
                                        leyenda='El primer apellido no coincide con registradur&iacute;a';
                                        function resp2()
                                        {
                                            control=gE('Apat');
                                            control.focus();
                                        }
                                        msgBox(leyenda,resp2)
                                        return;
                                    }
                                    
                                    
                                    if(quitarAcentos(gE('Amat').value).toUpperCase()!=quitarAcentos(objDatos.datosParticipante.apellidoMaterno).toUpperCase())
                                    {
                                        errorRegistraduria=true;
                                        leyenda='El segundo apellido no coincide con registradur&iacute;a';
                                        function resp3()
                                        {
                                            control=gE('Amat');
                                            control.focus();
                                        }
                                        msgBox(leyenda,resp3)
                                        return;
                                    }
                                    
                                    var dFechaExp=gEx('f_FExp').getValue().format('Y-m-d');
                                    if(dFechaExp!=objDatos.datosParticipante.fechaIdentificacion)
                                    {
                                        errorRegistraduria=true;
                                        leyenda='La fecha de expedición del documento no coincide con registradur&iacute;a';
                                        function resp4()
                                        {
                                            control=gEx('dteFechaExp');
                                            control.focus();
                                        }
                                        msgBox(leyenda,resp4)
                                        return;
                                    }
                                    
                                }
                                
                            
                            
                                continuarGuardadoDatos(form);
                            
                            }
                            else
                            {
                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                            }
                        }
                        obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloRegistroPartes.php',funcAjax, 'POST','funcion=2&tB='+tipoIdentificacion+'&vB='+gE('noIdentificacion').value+'&iF=0&tipoEntidad=0',true);
                    
                    }
                    else
                    {
                        continuarGuardadoDatos(form);
                        
                    }
                    
                    
                }
                else
                {
                    if(arrResp[0]=='3')
                    {
                        msgBox('Ya existe una persona registrada con esta identificaci&oacute;n');
                    }
                    else
                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',funcAjax,
                            'POST','funcion=36&iU=<?php echo $_SESSION["idUsr"]?>&tIdentificacion='+tipoIdentificacion+
                            '&noIdentificacion='+cv(gE('noIdentificacion').value),true);
        
       	}
        else
        {
        	continuarGuardadoDatos(form)
        }
        
	}
}


function continuarGuardadoDatos(form)
{
	gE('validado').value=(servicioRegistraduriaOff?0:1);
	var cmbTelefonos=gE('cmbTelefono');
    var cadTelefono='';
    var x;
    for(x=0;x<cmbTelefonos.options.length;x++)
    {
        if(cadTelefono=='')
            cadTelefono=cmbTelefonos.options[x].value;
        else
            cadTelefono+=','+cmbTelefonos.options[x].value;
        
    }
    gE('telefonos').value=cadTelefono;
    
    var cmbMail=gE('cmbMail');
    var cadMail='';
    var x;
    for(x=0;x<cmbMail.options.length;x++)
    {
        if(cadMail=='')
            cadMail=cmbMail.options[x].value;
        else
            cadMail+=','+cmbMail.options[x].value;
        
    }
    gE('correos').value=cadMail;
    
    
    
    var pwd1=gE('Contrasena');
    var pwd2=gE('Contrasena2');
    if(pwd1.value!=pwd2.value)
    {
        keyMap.disable();
        function ponerFoco()
        {
            pwd1.focus();
            keyMap.enable();
        }
        msgBox('Las contrase&ntilde;as introducidas son diferentes',ponerFoco);
        return;
    }
    
    
    if(pwd1.value.length<parseInt(objConfiguracion.logitudMinimaContrasena))
    {
        function respAux3()
        {
            pwd1.focus();
        }
        msgBox('La longitud de la contrase&ntilde;a debe ser de almenos '+(parseInt(objConfiguracion.logitudMinimaContrasena)==1?'1 caracter':(objConfiguracion.logitudMinimaContrasena+' caracteres')),respAux3);
        return;
    }
    
    if(pwd1.value.length>parseInt(objConfiguracion.logitudMaximaContrasena))
    {
        function respAux4()
        {
            pwd1.focus();
        }
        msgBox('La longitud de la contrase&ntilde;a excede el m&aacute;ximo permitido ('+(parseInt(objConfiguracion.logitudMaximaContrasena)==1?'1 caracter':(objConfiguracion.logitudMaximaContrasena+' caracteres')+')'),respAux4);
        return;
    }
    
   
    
    if(parseInt(objConfiguracion.minLetrasMinusculas)>0)
    {
        var totaLetras=contarOcurrenciasCaraceteresCadena(arrMinusculas,pwd1.value);
        if(totaLetras<parseInt(objConfiguracion.minLetrasMinusculas))
        {
            function respAux5()
            {
                pwd1.focus();
            }
            msgBox('La contrase&ntilde;a debe contener almenos '+(parseInt(objConfiguracion.minLetrasMinusculas)==1?'1 letra min&uacute;scula':(objConfiguracion.minLetrasMinusculas+' letras min&uacute;sculas')),respAux5);
            return;
        }
    }
    
    
    
    if(parseInt(objConfiguracion.minLetrasMayusculas)>0)
    {
        var totaLetras=contarOcurrenciasCaraceteresCadena(arrMayusculas,pwd1.value);
        if(totaLetras<parseInt(objConfiguracion.minLetrasMayusculas))
        {
            function respAux50()
            {
                pwd1.focus();
            }
            msgBox('La contrase&ntilde;a debe contener almenos '+(parseInt(objConfiguracion.minLetrasMayusculas)==1?'1 letra may&uacute;scula':(objConfiguracion.minLetrasMayusculas+' letras may&uacute;sculas')),respAux50);
            return;
        }
    }
     
    
    if(parseInt(objConfiguracion.minCaracteresNumericos)>0)
    {
        var totaLetras=contarOcurrenciasCaraceteresCadena(arrNumeros,pwd1.value);
        if(totaLetras<parseInt(objConfiguracion.minCaracteresNumericos))
        {
            function respAux7()
            {
                pwd1.focus();
            }
            msgBox('La contrase&ntilde;a debe contener almenos '+(parseInt(objConfiguracion.minCaracteresNumericos)==1?'1 caracter num&eacute;rico':(objConfiguracion.minCaracteresNumericos+' caracteres num&eacute;ricos')),respAux7);
            return;
        }
    }
    
    if(parseInt(objConfiguracion.minCaracteresEspeciales)>0)
    {
        var totaLetras=contarOcurrenciasCaraceteresCadena(arrEspeciales,pwd1.value);
        if(totaLetras<parseInt(objConfiguracion.minCaracteresEspeciales))
        {
            function respAux8()
            {
                pwd1.focus();
            }
            msgBox('La contrase&ntilde;a debe contener almenos '+(parseInt(objConfiguracion.minCaracteresEspeciales)==1?'1 caracter especial':(objConfiguracion.minCaracteresEspeciales+' caracteres especiales')),respAux8);
            return;
        }
    }
    
    
    if(gE('idUsuario').value=='-1')
    {
        function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                var formulario=gE(form);
                
                
                var obj=eval('['+arrResp[1]+']')[0];
                if(obj.resp=='0')
                    formulario.submit();
                else
                {
                    switch(obj.resp)
                    {
                        case '1':
                            msgBox('No se ha podido crear el nuevo usuario debido a la siguiente situaci&oacute;n: <br>'+obj.msg);
                            return;
                        break;
                        case '2':
                            function respAux(btn)
                            {
                              if(btn=='yes')
                              {
                                  formulario.submit();
                              }
                            }
                            msgConfirm('Se ha detectado que existe un usuario registrado bajo el nombre ingresado, desea agregar al nuevo usuario a pesar de lo anterior?',respAux);
                        break;
                    }
                }
            }
            else
            {
                msgBox('No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema:'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=30&tI='+(tipoIdentificacion.options[tipoIdentificacion.selectedIndex].value)+
                        '&nI='+gE('noIdentificacion').value+'&apPaterno='+cv(gE('Apat').value)+'&apMaterno='+cv(gE('Amat').value)+'&nombre='+cv(gE('Nombre').value)+'&rfc=&curp=&idUsuario='+gE('idUsuario').value,true);

    }
    else
    {
        gE(form).submit();
    }
}



function solicitarMail(IdUsuario,tipoMail)
{
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
                                                                                    cls:'SIUGJ_Etiqueta',
																					text: 'Correo Electrónico:'
																				}
																		   ),
														
														new Ext.form.TextField
														(
																			   {
															x:200,
															y:15,
															width:350,
															cls:'controlSIUGJ',
															id:'txtMail'
														}
														),
														new Ext.form.Checkbox
														(
															{
															x:5,
															y:55,
                                                            ctCls:'controlSIUGJ',
															//autoShow:true,
															checked:true,
															boxLabel:'Notificarme a este correo',
															allowBlank :true,
															value:'1',
															id:'Notificar'
															}
														)
													]
										}
									)
	var ventana=new Ext.Window(
							   		{
										title:'Agregar Correo Electrónico',
										width:600,
										height:200,
                                        cls:'msgHistorialSIUGJ',
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
																var m=Ext.getCmp('txtMail');
																m.focus(true,10);
															}
												}
											},
										buttons:
												[
												 	{
														text:'Cancelar',
                                                        cls:'btnSIUGJCancel',
                                                        width:140,
														handler:function ()
															{
																ventana.close();
																hK();
															}
													},
                                                    {
														text:'Aceptar',
                                                        cls:'btnSIUGJ',
                                                        width:140,
														handler:function ()
															{
																var m=Ext.getCmp('txtMail').getValue();
																var checado=Ext.getCmp('Notificar').checked;
																if(checado)
																	Notifica=1;
																else
																	Notifica=0;
																guardarMail(m,Notifica,IdUsuario,tipoMail,ventana);
															}
													}
												 ]
									}
							   )
	ventana.show();
	dK();
}//Solicitar Mail//Solicta Mail



function eliminarTelefono(Tipo)
{
	var Telefono;
	if (Tipo==0)
		Telefono=gE('cmbTelefono');
	else
		Telefono=gE('cmbTelefonoAds');
	if(Telefono.selectedIndex==-1)
	{
		msgBox('Por favor seleccione un Tel&eacute;fono');
		return;
	}
	function resp(btn)
	{
		if(btn=='yes')
		{
			if(gE('idUsuario').value!='-1')
			{
				Telefono.options[Telefono.selectedIndex]=null;
			}
			else
			{
				Telefono.options[Telefono.selectedIndex]=null;
			}
		}
	}
	msgConfirm('Est&aacute; seguro de querer eliminar este tel&eacute;fono?',resp);
	
}//Eliminar tel

function guardarMail(valor,Notificar,IdUsuario,tipoMail,ventana)
{
	var mail=gE('txtMail');
	if(valor=='')
	{
		function funcOk()
		{
			mail.focus(true,10);
		}
		Ext.MessageBox.alert(lblAplicacion,'El campo mail es obligatorio',funcOk);
		return;
	}
	if(!validarCorreo(valor))
	{
		function funcOk()
		{
			mail.focus(true,10);
		}
		Ext.MessageBox.alert(lblAplicacion,'La direcci&oacute;n de correo ingresada no es v&aacute;lida',funcOk);
		return;
	}
	
	var Mail;
	if (tipoMail==0)
		Mail=gE('cmbMail');
	else
		Mail=gE('cmbMailAds');
	
	var IdMail=Mail;
	var x;
	var nuevaOpcion;
	var cadMail=valor+'/'+tipoMail+'/'+Notificar;
	nuevaOpcion=document.createElement('option');
	nuevaOpcion.value=cadMail;
	nuevaOpcion.text=valor;
	Mail.options[Mail.length]=nuevaOpcion;
	ventana.close();
	hK();
}

function eliminarMail(tipoMail)
{
	if (tipoMail==0)
		Mail=gE('cmbMail');
	else
		Mail=gE('cmbMailAds');
			
	if(Mail.selectedIndex==-1)
	{
		Ext.MessageBox.alert(lblAplicacion,'Por favor seleccione un Correo');
		return;
	}
	function resp(btn)
	{
		if(btn=='yes')
		{
			Mail.options[Mail.selectedIndex]=null;
		}
	}
	Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar Est&aacute; cuenta de correo?',resp);
}//Eliminar Mail

//function regresar(usr)
//{
//	var arrParam=[['idUsuario',usr]];
//	enviarFormularioDatos('intermediaMostrar.php',arrParam);	
//}


function paisNacChange(combo)
{
	var valor=combo.options[combo.selectedIndex].value;
	if(valor=='146')
	{
		oE('ciudadNac');
		oE('estNac');
		gE('ciudadNac').value='';
		gE('estNac').value='';
		mE('cmbEstadoNac');
		mE('cmbCiudadNac');
	}
	else
	{
		mE('ciudadNac');
		mE('estNac');
		oE('cmbEstadoNac');
		oE('cmbCiudadNac');
		gE('cmbEstadoNac').selectedIndex=0;
		limpiarCombo(gE('cmbCiudadNac'));
		var opcion=cE('option');
		opcion.value='-1';
		opcion.text='Seleccione';
		var cmbCiudadNac=gE('cmbCiudadNac');
		cmbCiudadNac.options[0]=opcion;
		cmbCiudadNac.selectedIndex=0;
	}
}

function paisResidenciaChange(combo)
{
	return;
	/*var valor=combo.options[combo.selectedIndex].value;
	if(valor=='146')
	{
		oE('Ciudad');
		oE('Estado');
		gE('Ciudad').value='';
		gE('Estado').value='';
		mE('cmbEstado');
		mE('cmbCiudad');
	}
	else
	{
		mE('Ciudad');
		mE('Estado');
		oE('cmbEstado');
		oE('cmbCiudad');
		gE('cmbEstado').selectedIndex=0;
		limpiarCombo(gE('cmbCiudad'));
		var opcion=cE('option');
		opcion.value='-1';
		opcion.text='Seleccione';
		var cmbCiudadNac=gE('cmbCiudad');
		cmbCiudadNac.options[0]=opcion;
		cmbCiudadNac.selectedIndex=0;
	}*/
}

function estadoNacSel(combo)
{
	var valor=combo.options[combo.selectedIndex].value;
	function funcAjax()
	{
		var resp=peticion_http.responseText;
		arrResp=resp.split('|');
		if(arrResp[0]=='1')
		{
			var arrCiudades=eval(arrResp[1]);
			llenarCombo(gE('cmbCiudadNac'),arrCiudades);
		}
		else
		{
			msgBox('No se ha podido llevar cabo la operaci&oacute;n debido al siguiente problema:<br />'+arrResp[0]);
		}
	}
	obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=29&cveEstado='+valor,true);

}

function estadoSel(combo)
{
	var valor=combo.options[combo.selectedIndex].value;
	function funcAjax()
	{
		var resp=peticion_http.responseText;
		arrResp=resp.split('|');
		if(arrResp[0]=='1')
		{
			var arrCiudades=eval(arrResp[1]);
			llenarCombo(gE('cmbCiudad'),arrCiudades);
		}
		else
		{
			msgBox('No se ha podido llevar cabo la operaci&oacute;n debido al siguiente problema:<br />'+arrResp[0]);
		}
	}
	obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=29&cveEstado='+valor,true);

}




function getUsuarioActivo()
{
	return gE('idUsuario').value+'|@|1';
}

function notificarHuellaCapturada()
{
	cargarDatosHuellas();	
}


function cargarDatosHuellas()
{
	var gridHuellas=gEx('gridHuellas');
    gridHuellas.getStore().load	(
    								{
                                    	funcion:65,
                                        idUsuario:gE('idUsuario').value,
                                        tipoUsuario:1
                                    }
    							)
	
}

function crearGridHuellasCapturadas()
{
	  var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idTipoHuella'},
		                                                {name: 'registrado'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesRecursosHumanos.php'

                                                                                              }

                                                                                          ),
                                                            
                                                            groupField: 'idTipoHuella',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='65';
                                        proxy.baseParams.idUsuario=gE('idUsuario').value;
                                        proxy.baseParams.tipoUsuario=1;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            {
                                                                header:'Descripci&oacute;n',
                                                                width:170,
                                                                sortable:false,
                                                                dataIndex:'idTipoHuella',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrHuellas,val);
                                                                        
                                                                        }
                                                                
                                                            },
                                                            {
                                                                header:'Registrado',
                                                                width:140,
                                                                sortable:false,
                                                                dataIndex:'registrado',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val=='0')
                                                                            	return '<img src="../images/cross.png" width="14" height="14" /> NO Registrado';
                                                                            
                                                                            return '<img src="../images/icon_big_tick.gif" width="14" height="14" /> Registrado';
                                                                            
                                                                        
                                                                        }
                                                                
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridHuellas',
                                                                store:alDatos,
                                                                width:400,
                                                                height:300,
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                renderTo:'tblHuellas',
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


function removerFoto(iU)
{
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
					oE('btnRemoveFoto');
					gE('imgFoto').src='verFoto.php?Id='+bD(iU)+'&rand='+generarNumeroAleatorio(1000,9999);
					window.parent.gE('imgUsr').src='verFoto.php?Id='+bD(iU)+'&rand='+generarNumeroAleatorio(1000,9999);
				}
				else
				{
					msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=104&iU='+bD(iU),true);
		}
	}
	msgConfirm('Est&aacute; seguro de querer remover la foto del usuario?',resp);

}

function deshabilitarNumeroIdentificacion(tipoIdentificacion,registro)
{
	oE('noIdentificacion');
    gE('noIdentificacion').value='';
    oE('lblNoIdentificacion');

}

function habilitarNumeroIdentificacion(tipoIdentificacion,registro)
{
	mE('noIdentificacion');
    gE('noIdentificacion').value='';
    mE('lblNoIdentificacion');
    
    

    
    
    
    
}



function noIdenticacionBlur(txt)
{

    if(txt.value=='')
        return;
    if(validarNoIdentificacion(1))
    {  
        
    }
}


function noIdenticacionKeyPress(evt)
{
	var key= evt.which;
	if(Ext.isIE)
		key=evt.keyCode;

    var txt=gE('noIdentificacion');

    if(key=='46')
    {
        detenerEvento(evt);
        return;
    }
    if(key=='13')
    {
        if(txt.value=='')
            return;
        
        if(validarNoIdentificacion(1))
        {   
            
        }
    }
    var tipoIdentificacion=gE('tipoIdentificacion').options[gE('tipoIdentificacion').selectedIndex].value;
    
    var posDocumento=existeValorMatriz(arrTipoIdentificacionConfiguracion,tipoIdentificacion);
    var filaDocumento=arrTipoIdentificacionConfiguracion[posDocumento];
    
    if(filaDocumento[4]!='')
    {
        if((txt.value.length+1)>parseInt(filaDocumento[4]))
        {
        	return false;
        	
        }
    }
    if(filaDocumento[5]!='')
    {
        var re =null;
        
        eval('re=/['+filaDocumento[5]+']/;');
        var caracter=String.fromCharCode(key);
        if(!re.test(caracter))
        {
            return false;
        }
        
    }
    
}



function validarNoIdentificacion(tipoValidacion)
{
	var valor=gE('noIdentificacion').value;
 	var tipoIdentificacion=gE('tipoIdentificacion').options[gE('tipoIdentificacion').selectedIndex].value;
    var pos=existeValorMatriz(arrTipoIdentificacionConfiguracion,tipoIdentificacion);
    if(pos!=-1)
    {
    	var fila=arrTipoIdentificacionConfiguracion[pos];
        
        if(fila[2]!='')
        {
            var respuesta;
            eval('respuesta='+fila[2]+'(\''+valor+'\','+tipoValidacion+');');
            return respuesta;
        }
        return true;
        
    }
}


function validarCarnetDiplomatico(valor,tipoValidacion)
{
	var re=/[0-9A-Za-z]{11,11}$/;
	if(tipoValidacion==1)
    {
    	
        if(valor.length!=11)
        {
        	function resp()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 11 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (11 caracteres)',resp2);
        	return false;
        }
        return true;
        
    }
    else
    {
    	if(!re.test(valor))
        {
        	function resp3()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (11 caracteres)',resp3);
        	return false;
        }
        return true
    }
}

function validarCedulaCiudadania(valor,tipoValidacion)
{
	var re=/[0-9]{3,10}$/;
	if(tipoValidacion==1)
    {
    	
        if((valor.length<3)||(valor.length>10))
        {
        	function resp()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 3 a 10 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (3 a 10 d&iacute;gitos numericos)',resp2);
        	return false;
        }
        return true;
        
    }
    else
    {
    	if(!re.test(valor))
        {
        	function resp3()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (3 a 10 d&iacute;gitos numericos)',resp3);
        	return false;
        }
        return true
    }
}

function validarCedulaExtranjeria(valor,tipoValidacion)
{
	var re=/[0-9]{6,6}$/;
	if(tipoValidacion==1)
    {
    	
        if(valor.length!=6)
        {
        	function resp()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 6 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (6 d&iacute;gitos numericos)',resp2);
        	return false;
        }
        return true;
        
    }
    else
    {
    	if(!re.test(valor))
        {
        	function resp3()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (6 d&iacute;gitos numericos)',resp3);
        	return false;
        }
        return true
    }
}


function validarCetificadoNacimientoVivo(valor,tipoValidacion)
{
	var re=/[0-9]{9,9}$/;
	if(tipoValidacion==1)
    {
    	
        if(valor.length!=9)
        {
        	function resp()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 9 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (9 d&iacute;gitos numericos)',resp2);
        	return false;
        }
        return true;
        
    }
    else
    {
    	if(!re.test(valor))
        {
        	function resp3()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (9 d&iacute;gitos numericos)',resp3);
        	return false;
        }
        return true
    }
}

function validarDocumentoExtranjero(valor,tipoValidacion)
{
	var re=/[0-9A-Za-z]{16,16}$/;
	if(tipoValidacion==1)
    {
    	
        if(valor.length!=16)
        {
        	function resp()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 16 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (16 caracteres)',resp2);
        	return false;
        }
        return true;
        
    }
    else
    {
    	if(!re.test(valor))
        {
        	function resp3()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (16 caracteres)',resp3);
        	return false;
        }
        return true
    }
}

function validarPasaporte(valor,tipoValidacion)
{
	var re=/[0-9A-Za-z]{6,16}$/;
	if(tipoValidacion==1)
    {
        if((valor.length<6)||(valor.length>16))
        {
        	function resp()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 6 a 16 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (6 a 16 caracteres)',resp2);
        	return false;
        }
        return true;
        
    }
    else
    {
    	if(!re.test(valor))
        {
        	function resp3()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (6 a 16 caracteres)',resp3);
        	return false;
        }
        return true
    }
}

function validarPermisoEspecialPermanencia(valor,tipoValidacion)
{
	var re=/[0-9]{15,15}$/;
	if(tipoValidacion==1)
    {
    	
        if(valor.length!=15)
        {
        	function resp()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 15 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (15 d&iacute;gitos numericos)',resp2);
        	return false;
        }
        return true;
        
    }
    else
    {
    	if(!re.test(valor))
        {
        	function resp3()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (15 d&iacute;gitos numericos)',resp3);
        	return false;
        }
        return true
    }
}

function validaRegistroCivilNacimiento(valor,tipoValidacion)
{
	var re=/[0-9]{11,11}$/;
	if(tipoValidacion==1)
    {
    	
        if(valor.length!=11)
        {
        	function resp()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 11 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (11 d&iacute;gitos numericos)',resp2);
        	return false;
        }
        return true;
        
    }
    else
    {
    	if(!re.test(valor))
        {
        	function resp3()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (11 d&iacute;gitos numericos)',resp3);
        	return false;
        }
        return true
    }
}

function validarSalvoConducto(valor,tipoValidacion)
{
	var re=/[0-9A-Za-z]{9,9}$/;
	if(tipoValidacion==1)
    {
    	
        if(valor.length!=9)
        {
        	function resp()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 9 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (9 caracteres)',resp2);
        	return false;
        }
        return true;
        
    }
    else
    {
    	if(!re.test(valor))
        {
        	function resp3()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (9 caracteres)',resp3);
        	return false;
        }
        return true
    }
}

function validarTarjetaIdentidad(valor,tipoValidacion)
{

	var re=/[0-9]{11,11}$/;
	if(tipoValidacion==1)
    {
    	
        if(valor.length!=11)
        {
        	function resp()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 11 digitos',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (11 d&iacute;gitos)',resp2);
        	return false;
        }
        return true;
        
    }
    else
    {
    	if(!re.test(valor))
        {
        	function resp3()
            {
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (11 d&iacute;gitos numericos)',resp3);
        	return false;
        }
        return true
    }
}


function validarNIT(valor,tipoValidacion)
{
	var re=/[0-9]{4,15}$/;
	if(tipoValidacion==1)
    {
    	
        if((valor.length<4)||(valor.length>15))
        {
        	function resp()
            {
            	gEx('txtNIT').focus();
            }
            msgBox('El N&uacute;mero de Identificaci&oacute;n Tributaria (NIT) debe ser de entre 4 y 15 digitos',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gEx('txtNIT').focus();
            }
            msgBox('El N&uacute;mero de Identificaci&oacute;n Tributaria (NIT) ingresado no cumple el formato permitido (Entre 4 y 15 d&iacute;gitos)',resp2);
        	return false;
        }
        return true;
        
    }
    else
    {
    	if(!re.test(valor))
        {
        	function resp3()
            {
            	gEx('txtNIT').focus();
            }
            msgBox('El N&uacute;mero de Identificaci&oacute;n Tributaria (NIT) ingresado no cumple el formato permitido (15 d&iacute;gitos numericos)',resp3);
        	return false;
        }
        return true
    }
}


function validarTipoDocumentoIdentificacion()
{
	if(!gE('tipoIdentificacion'))
    {
    
    	var fechaLimiteNacimiento=Date.parseDate(gE('lblFechaNacimiento').innerHTML,'d/m/Y').add(Date.DAY,-1);
        
        if(gE('lblTipoIdentificacion').value=='4')
        {
            fechaLimiteNacimiento=gEx('f_FExp').getValue().add(Date.YEAR,-18);
            
            
        }
        
        if(gEx('f_FNac').getValue()>fechaLimiteNacimiento)
        {
            function respAuxFecha()
            {
                gEx('f_FNac').focus();
            }
            msgBox('La fecha de nacimiento no puede ser mayor a '+fechaLimiteNacimiento.format('d/m/Y'),respAuxFecha);
            return false;
        }
    
    
    	return true;
    }

	var noIdentificacion=gE('noIdentificacion');
    var cmbTipoIdentificacion=gE('tipoIdentificacion');
  	var tipoIdentificacion=cmbTipoIdentificacion.options[cmbTipoIdentificacion.selectedIndex].value;
    if(cmbTipoIdentificacion.selectedIndex==0)
    {
        function respAux100()
        {
            cmbTipoIdentificacion.focus();
        }
        msgBox('Debe seleccionar el tipo de identificaci&oacute;n a presentar',respAux100);
        return false;
    }
    
    
    if((isVisible('noIdentificacion'))&&(noIdentificacion.value==''))
    {
        function respAux101()
        {
            noIdentificacion.focus();
        }
        msgBox('Debe ingresar el n&uacute;mero de identificacion a presentar',respAux101);
        return false;
    }
    
   
    
    
    if((isVisible('FExp')) && (gEx('f_FExp').getValue()==''))
    {
        function respAux()
        {
            gEx('f_FExp').focus();
        }
        msgBox('Debe ingresar la fecha de expedici&oacute;n del documento de identificacion',respAux);
        return false;
        
    }
  	
    
    var fechaLimiteNacimiento=gEx('f_FExp').getValue().add(Date.DAY,-1);
        
  	if(tipoIdentificacion=='4')
    {
    	fechaLimiteNacimiento=gEx('f_FExp').getValue().add(Date.YEAR,-18);
        
        
    }
    
    if(gEx('f_FNac').getValue()>fechaLimiteNacimiento)
    {
    	function respAuxFecha()
        {
        	gEx('f_FNac').focus();
        }
        msgBox('La fecha de nacimiento no puede ser mayor a '+fechaLimiteNacimiento.format('d/m/Y'),respAuxFecha);
    	return false;
    }
  
  
	return true;
    
}

function mostrarVentanaAgregarCelular()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
                                            cls:'panelSiugj',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:20,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Tipo'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:60,
                                                            html:'<div id="divCmbTipo"></div>'
                                                        },
                                                        {
                                                        	x:300,
                                                            y:20,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Pa&iacute;s'
                                                        },
                                                        {
                                                        	x:300,
                                                            y:60,
                                                            html:'<div id="divCmbPais"></div>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:120,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'N&uacute;mero'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:160,
                                                            width:280,
                                                            xtype:'textfield',
                                                            cls:'controlSIUGJ',
                                                            id:'txtNumero',
                                                            enableKeyEvents:true,
                                                            maskRe:/^[0-9]$/,
                                                            listeners:	{
                                                                            keypress:function(ctrl,e)
                                                                                    {
                                                                                        if(ctrl.getValue().length==10)
                                                                                        {
                                                                                            e.stopEvent();
                                                                                        }
                                                                                    }
                                                                        }
                                                        },
                                                        {
                                                        	x:300,
                                                            y:120,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Extensi&oacute;n'
                                                            
                                                        },
                                                        {
                                                        	x:300,
                                                            y:160,
                                                            width:280,
                                                            xtype:'textfield',
                                                            cls:'controlSIUGJ',
                                                            id:'txtExtension',
                                                            enableKeyEvents:true,
                                                            maskRe:/^[0-9]$/,
                                                            listeners:	{
                                                                            keypress:function(ctrl,e)
                                                                                    {
                                                                                        if(ctrl.getValue().length==6)
                                                                                        {
                                                                                            e.stopEvent();
                                                                                        }
                                                                                    }
                                                                        }
                                                        },
                                                        {
                                                        	x:60,
                                                            y:230,
                                                            hidden:true,
                                                            id:'lblIngreseCodigo',
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Ingrese el código de validación enviado al celular registrado'
                                                        },
                                                        {
                                                        	x:85,
                                                            y:270,
                                                            width:280,
                                                            hidden:true,
                                                            xtype:'textfield',
                                                            cls:'controlSIUGJ',
                                                            id:'txtCodigoValidacion',
                                                            enableKeyEvents:true,
                                                            maskRe:/^[0-9]$/,
                                                            listeners:	{
                                                                            keypress:function(ctrl,e)
                                                                                    {
                                                                                        if(ctrl.getValue().length==6)
                                                                                        {
                                                                                            e.stopEvent();
                                                                                        }
                                                                                    }
                                                                        }
                                                        },
                                                        {
                                                              icon:'../images/arrow_refresh.PNG',
                                                              cls:'btnSIUGJCancel',
                                                              xtype:'button',
                                                              x:380,
                                                              y:265,
                                                              hidden:true,
                                                              id:'btnReenviar',
                                                              text:'Reenviar c&oacute;digo',
                                                              handler:function()
                                                                      {
                                                                          enviarSMSCelular	(
                                                                          						function()
                                                                                                {
                                                                                                	
                                                                                                    
                                                                                                    function respAux()
                                                                                                    {
                                                                                                    	gEx('btnReenviar').disable();
                                                                                                    	gEx('txtCodigoValidacion').focus();
                                                                                                    }
                                                                                                    msgBox('Se ha reenviado un nuevo c&oacute;digo de verificaci&oacute;n al n&uacute;mero registrado',respAux);
                                                                                                    
                                                                                                }
                                                                          					);
                                                                      }
                                                          
                                                      	}
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar tel&eacute;fono',
										width: 650,
										height:350,
										layout: 'fit',
										plain:true,
										modal:true,
                                        closable:false,
                                        id:'vAddCelular',
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	var cmbPais=crearComboExt('cmbPaisV',arrPaises,0,0,280,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCmbPais'});
																	cmbPais.setValue('52');
                                                                    var cmbTipoTelefono=crearComboExt('cmbTipoTelefonoV',arrTelefonos,0,0,280,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCmbTipo'});
																	cmbTipoTelefono.on('select',function(cmb,registro)
                                                                    							{
                                                                                                	if(registro.data.id=='2')
                                                                                                    {
                                                                                                    	gEx('txtExtension').setValue('');
                                                                                                    	gEx('txtExtension').disable();
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                    	gEx('txtExtension').enable();
                                                                                                    }
                                                                                                }
                                                                    					)
                                                                
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
                                                            id:'btnAceptarTelefono',
															handler: function()
																	{
                                                                    	var cmbPaisV=gEx('cmbPaisV');
                                                                        if(cmbPaisV.getValue()=='')
                                                                        {
                                                                        	function resp10()
                                                                            {
                                                                            	cmbPaisV.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el pa&iacute;s al cual pertenece el n&uacute;mero tel&eacute;fonico a agregar',resp10);
                                                                        	return;
                                                                        }
                                                                        
																		var cmbTipoTelefono=gEx('cmbTipoTelefonoV');
                                                                        if(cmbTipoTelefono.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbTipoTelefono.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el tipo de tel&eacute;fono a agregar',resp);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var txtNumero=gEx('txtNumero');
                                                                        if(txtNumero.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	txtNumero.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el n&uacute;mero de tel&eacute;fono a agregar',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var txtNumero=gEx('txtNumero');
                                                                        if(txtNumero.getValue().length!=10)
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	txtNumero.focus();
                                                                            }
                                                                        	msgBox('El n&uacute;mero de tel&eacute;fono a agregar debe ser de 10 d&iacute;gitos',resp3);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(cmbTipoTelefono.getValue()=='1')
                                                                        {
                                                                        	var txtTelefono=gEx('txtNumero');
																			var txtExtension=gEx('txtExtension');
																			
																			var tTelefono=gEx('cmbTipoTelefonoV').getRawValue();
																			
																			var idTelefono=gEx('cmbPaisV').getValue()+'_'+txtTelefono.getValue()+'_'+txtExtension.getValue()+'_'+gEx('cmbTipoTelefonoV').getValue()+'_0';
																			var lblPais=gEx('cmbPaisV').getRawValue()
																			var etiqueta='('+tTelefono+') '+txtTelefono.getValue()+(gEx('txtExtension').getValue()==''?'':' Ext. '+gEx('txtExtension').getValue())+' ('+lblPais+')';
																			var nuevaOpcion;
																			nuevaOpcion=document.createElement('option');
																			
																			
																			var hTelefonos=gE('telefonos');
																			nuevaOpcion.value=idTelefono;
																			nuevaOpcion.text=etiqueta;
																			var Telefono=gE('cmbTelefono');
																			Telefono.options[Telefono.length]=nuevaOpcion;
																			ventanaAM.close();
                                                                        }
                                                                        else
                                                                        {
                                                                        
                                                                        
                                                                            enviarSMSCelular(	function()
                                                                                                {
                                                                                                    gEx('btnAceptarTelefono').hide();
                                                                                                    gEx('btnValidarTelefono').show();
                                                                                                    gEx('lblIngreseCodigo').show();
                                                                                                    gEx('txtCodigoValidacion').show();
                                                                                                    gEx('vAddCelular').setHeight(440);
                                                                                                    gEx('btnReenviar').show();
                                                                                                    function respAux()
                                                                                                    {
                                                                                                    	 gEx('txtCodigoValidacion').focus();
                                                                                                    }
                                                                                                    msgBox('Se ha enviado un c&oacute;digo de verificaci&oacute;n al n&uacute;mero registrado',respAux);
                                                                                                }
                                                                                            );
                                                                        }
																	}
														},
                                                        {
															
															text: 'Validar',
                                                            cls:'btnSIUGJ',
                                                            width:140,
                                                            hidden:true,
                                                            id:'btnValidarTelefono',
															handler: function()
																	{
																		function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                switch(arrResp[1])
                                                                                {
                                                                                	case '0':
                                                                                    	msgBox('El c&oacute;digo de verificaci&oacute;n ha expirado, se ha enviado uno nuevo para su validaci&oacute;n');
                                                                                    break;
                                                                                    case '1':
                                                                                    	
                                                                                   		var txtTelefono=gEx('txtNumero');
                                                                                        var txtExtension=gEx('txtExtension');
                                                                                        
                                                                                        var tTelefono=gEx('cmbTipoTelefonoV').getRawValue();
                                                                                        
                                                                                        var idTelefono=gEx('cmbPaisV').getValue()+'_'+txtTelefono.getValue()+'_'+txtExtension.getValue()+'_'+gEx('cmbTipoTelefonoV').getValue()+'_1';
						                                                                var lblPais=gEx('cmbPaisV').getRawValue()
                                                                                        var etiqueta='('+tTelefono+') '+txtTelefono.getValue()+(gEx('txtExtension').getValue()==''?'':' Ext. '+gEx('txtExtension').getValue())+' ('+lblPais+')';
                                                                                        var nuevaOpcion;
                                                                                        nuevaOpcion=document.createElement('option');
                                                                                        
                                                                                        
                                                                                        var hTelefonos=gE('telefonos');
                                                                                        nuevaOpcion.value=idTelefono;
                                                                                        nuevaOpcion.text=etiqueta;
                                                                                        var Telefono=gE('cmbTelefono');
                                                                                        Telefono.options[Telefono.length]=nuevaOpcion;
                                                                                        ventanaAM.close();
                                                                                        
                                                                                        
                                                                                        
                                                                                    break;
                                                                                    case '2':
                                                                                    	msgBox('El c&oacute;digo de verificaci&oacute;n ingresado no es v&aacute;lido');
                                                                                    	
                                                                                    break;
                                                                                }
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',funcAjax, 'POST','funcion=39&codigo='+gEx('txtCodigoValidacion').getValue()+'&numeroCelular='+gEx('txtNumero').getValue(),true);
                                                                        
																	}
														}
														
													]
									}
								);
	ventanaAM.show();	
}

function enviarSMSCelular(afterSend)
{

	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
	        if(afterSend)
	            afterSend();
        }
        else
        {
        	if(arrResp[0]=='4')
        	{
            	msgBox('No se pudo establecer conexión con el proveedor de env&iacute;os de mensaje (SMS)');
            }
            else
	            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',funcAjax, 'POST','funcion=38&p='+gEx('cmbPaisV').getValue()+'&numeroCelular='+gEx('txtNumero').getValue(),true);


	
}

function cancelar()
{
	function resp(btn)
	{
		if(btn=='yes')
		{
			cerrarSesion();	
		}
	}
	msgConfirm('¿Est&aacute; seguro de querer cancelar la actualizaci&oacute;n de su cuenta?',resp)
}

function cambiarMayusculasTexto(txt)
{
	txt.value=txt.value.toUpperCase();
}