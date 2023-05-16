<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

Ext.onReady(inicializar);

function inicializar()
{
	
}

function agregarSesion(f)
{
	var hInicio=new Date().clearTime();
    hInicio.setHours(0);
    hInicio.setMinutes(0);
    var hFin=new Date().clearTime();
    hFin.setHours(23);
    hFin.setMinutes(59);
	var horas=generarIntervaloHoras(hInicio,hFin,15);
	var cmbHoraInicio=crearComboExt(cmbHoraInicio,horas,130,40);
    cmbHoraInicio.setValue('12:00');
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	id:'lblFecha',
                                                        	x:10,
                                                            y:10,
                                                            html:'Fecha de la sesi&oacute;n:'
                                                        },
														{
                                                        	x:130,
                                                            y:10,
                                                            html:'<font color="red">'+f+'</font>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:45,
                                                            html:'Hora de inicio:'
                                                        },
                                                        cmbHoraInicio,
                                                        {
                                                        	x:10,
                                                            y:80,
                                                            html:'Horas dedicadas:'
                                                        },
                                                        {
                                                        	x:130,
                                                            y:75,
                                                            xtype:'numberfield',
                                                            allowDecimals:false,
                                                            id:'txtHoras',
                                                            width:50
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar sesi&oacute;n de trabajo',
										width: 400,
										height:200,
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
                                                                         var hInicio=cmbHoraInicio.getValue();
                                                                         if(hInicio=='')
                                                                         {
                                                                         	function resp()
                                                                            {
                                                                            	cmbHoraInicio.focus();
                                                                            }
                                                                            
                                                                         	msgBox('Debe seleccionar la hora de inicio de la actividad',resp)
                                                                         	return;
                                                                         }		
                                                                         
                                                                         var hDedicadas=Ext.getCmp('txtHoras').getValue();
                                                                         if(hDedicadas=='')
                                                                         	hDedicadas='0';
                                                                         hDedicadas=parseInt(hDedicadas);
                                                                         if(hDedicadas<1)
                                                                         {
                                                                         
                                                                         	function respH()
                                                                            {
                                                                            	Ext.getCmp('txtHoras').focus();
                                                                            }
                                                                            
                                                                         	msgBox('El n&uacute;mero de horas ingresado es inv&aacute;lido',respH)
                                                                         	return;
                                                                        }
                                                                        
                                                                        var horasLibres=parseInt(gE('horasLibres').value);
                                                                        if(hDedicadas>horasLibres)
                                                                        {
                                                                        	function respH()
                                                                            {
                                                                            	Ext.getCmp('txtHoras').focus();
                                                                            }
                                                                         	msgBox('El n&uacute;mero de horas ingresado no puede ser mayor al n&uacute;mero de horas sin planeaci&oacute;n el cual es de: '+horasLibres,respH);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        var obj='{"hInicio":"'+hInicio+'","duracion":"'+hDedicadas+'","idActividad":"'+gE('idActividad').value+'","idUsuario":"'+gE('idUsuario').value+'","fecha":"'+f+'"}';        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	ventanaAM.close();
                                                                            	recargarPagina();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=90&obj='+obj,true);
                                                                        
                                                                        
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

function removerSesion(s,s2)
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
                	/*var fila=gE('fila_'+s2);
                    fila.parentNode.removeChild(fila);
                    var horasSp=gE('horas_'+s2);
                    var hRestantes=parseFloat(gE('lblHorasTotal').innerHTML)-parseFloat(horasSp.innerHTML);
                    gE('lblHorasTotal').innerHTML=hRestantes;*/
                    recargarPagina();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=91&idSesion='+s,true);
        }
    }
    msgConfirm('Est&aacute; seguro de querer remover la sesi&oacute;n de trabajo seleccionada?',resp);
}