<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>
var arrSituacion=[['1','Cuenta activa'],['2','Cuenta inactiva'],['100','Cuenta bloqueada']];
Ext.onReady(inicializar);

function inicializar()
{
   
}

function formatearSituacion(val)
{
	return formatearValorRenderer(arrSituacion,val);
}

function nuevoUsuario()
{
	var arrTipoUsuario=[['1','Funcionario p\xFAblico'],['2','Usuario est\xE1ndar']];
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
                                            cls:'panelSiugj',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'label',
                                                            x:10,
                                                            y:10,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Tipo de usuario a agregar:'
                                                        },
                                                        {
                                                        	x:260,
                                                            y:5,
                                                            html:'<div id="divCmbTipoUsuario"></div>'
                                                        }
                                                        ,
                                                        {
                                                        	xtype:'label',
                                                            x:10,
                                                            y:60,
                                                            id:'lblNumeroCC',
                                                            hidden:true,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Ingrese su n&uacute;mero de CC:'
                                                        }	,
                                                        {
                                                        	x:260,
                                                            y:55,
                                                            width:150,
                                                            id:'txtNumeroCC',
                                                            hidden:true,
                                                            xtype:'textfield',
                                                            enableKeyEvents :true,
                                                            listeners:	{
                                                                            keypress:function(txt,e)
                                                                                {

                                                                                    if(e.charCode=='46')
                                                                                    {
                                                                                        e.stopEvent();
                                                                                        return;
                                                                                    }
                                                                                   
                                                                                        
                                                                                      eval('re=/[0-9]/;');
                                                                                      var caracter=String.fromCharCode(e.charCode);
                                                                                      if(!re.test(caracter))
                                                                                      {
                                                                                          e.stopEvent();
                                                                                      }
                                                                                        
                                                                                    
                                                                                    
                                                                                    
                                                                                }
                                                                         },
                                                            cls:'controlSIUGJ'
                                                        }	
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Crear usuario',
										width: 650,
                                        id:'vCrearUsuario',
                                        cls:'msgHistorialSIUGJ',
										height:180,
										layout: 'fit',
										plain:true,
										modal:true,
                                        closable:false,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	var cmbTipoUsuario=crearComboExt('cmbTipoUsuario',arrTipoUsuario,0,0,250,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCmbTipoUsuario'});                        
																	cmbTipoUsuario.on('select',function(cmb,registro)
                                                                    							{
                                                                                                
                                                                                                	if(registro.data.id=='1')
                                                                                                    {
                                                                                                    	gEx('lblNumeroCC').show();
                                                                                                        gEx('txtNumeroCC').show();
                                                                                                        gEx('vCrearUsuario').setHeight(240);
                                                                                                        gEx('txtNumeroCC').focus(false);
                                                                                                        
                                                                                                        
                                                                                                        
                                                                                                        
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                    	gEx('lblNumeroCC').hide();
                                                                                                        gEx('txtNumeroCC').hide();
                                                                                                        gEx('vCrearUsuario').setHeight(180);
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

															handler: function()
																	{
																		var cmbTipoUsuario=gEx('cmbTipoUsuario');
                                                                    	if(cmbTipoUsuario.getValue()=='1')
                                                                        {
                                                                        	if(validarCedulaCiudadania(gEx('txtNumeroCC').getValue(),1))
                                                                            {
                                                                            	function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                        if(arrResp[1]=='1')
                                                                                        {
                                                                                        	var arrParam=[['idUsuario',arrResp[2]]];
    
                                                                                            var obj={};
                                                                                            obj.ancho='100%';
                                                                                            obj.alto='100%';
                                                                                            obj.modal=false;
                                                                                            obj.funcionCerrar=recargarContenedorCentral;
                                                                                            obj.url='../Usuarios/tblInformacionUsuarios.php';
                                                                                            obj.params=arrParam;
                                                                                            abrirVentanaFancySuperior(obj);
                                                                                            ventanaAM.close();
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                        	function respAux()
                                                                                            {
                                                                                            	gEx('txtNumeroCC').focus();
                                                                                            }
                                                                                        	msgBox(arrResp[2],respAux);
                                                                                        }
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',funcAjax, 'POST','funcion=46&cc='+gEx('txtNumeroCC').getValue(),true);
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                        	var arrParam=[['accion','Nuevo'],['cPagina','sFrm=true'],['bandera','0']];
                                                                            var obj={};
                                                                            obj.ancho='100%';
                                                                            obj.alto='100%';
                                                                            obj.modal=false;
                                                                            obj.funcionCerrar=recargarContenedorCentral;
                                                                            obj.url='../Usuarios/nIdentifica.php';
                                                                            obj.params=arrParam;
                                                                            abrirVentanaFancySuperior(obj);
                                                                            ventanaAM.close();
                                                                        }
																	}
														}
														
													]
									}
								);
	ventanaAM.show();	

	
	
}

function abrirEdicionUsuario()
{
	var grid_tblTabla=gEx('grid_tblTabla');
    var registro=grid_tblTabla.getSelectionModel().getSelected();
    if(!registro)
    {
    	msgBox('Debe seleccionar el usuario que desea editar');
    	return;
    }
    
	var arrParam=[['idUsuario',registro.get('idUsuario').replace('<b>','').replace('</b>','')]];
    
    var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.modal=false;
    obj.funcionCerrar=recargarContenedorCentral;
    obj.url='../Usuarios/tblInformacionUsuarios.php';
    obj.params=arrParam;
    abrirVentanaFancySuperior(obj);
    
}


function recargarContenedorCentral()
{
	gEx('grid_tblTabla').getStore().reload();
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
            	gEx('txtNumeroCC').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 3 a 10 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gEx('txtNumeroCC').focus();
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
            	gEx('txtNumeroCC').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (3 a 10 d&iacute;gitos numericos)',resp3);
        	return false;
        }
        return true
    }
}
