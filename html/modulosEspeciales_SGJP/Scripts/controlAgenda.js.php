<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT id__1_tablaDinamica,nombreInmueble FROM _1_tablaDinamica WHERE idEstado=2 ORDER BY nombreInmueble";
	$arrEdificios=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__77_tablaDinamica,motivoModificacion FROM _77_tablaDinamica WHERE situacion=1 ORDER BY motivoModificacion";
	$arrMotivoCambioSala=$con->obtenerFilasArreglo($consulta);	
	
	$consulta="SELECT id__22_tablaDinamica,motivoCambio FROM _22_tablaDinamica WHERE situacion=1 ORDER BY motivoCambio";
	$arrMotivoCambioJuez=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__24_tablaDinamica,motivoModificacion FROM _24_tablaDinamica WHERE situacion=1 ORDER BY motivoModificacion";
	$arrMotivoCambioFecha=$con->obtenerFilasArreglo($consulta);	
	$fechaActual=date("Y-m-d");
?>
var tipoMateria='<?php echo $tipoMateria ?>';
var arrMotivoCambioJuez=<?php echo $arrMotivoCambioJuez?>;
var arrMotivoCambioSala=<?php echo $arrMotivoCambioSala?>;
var arrMotivoCambioFecha=<?php echo $arrMotivoCambioFecha?>;
var arrEdificios=<?php echo $arrEdificios?>;

function mostrarModificacionUnidadGestion(leyenda)
{
	var cmbEdificios=crearComboExt('cmbEdificios',arrEdificios,180,15,300);
    cmbEdificios.on('select',function(cmb,registro)
    							{
                                	function respAux(peticion_http)
                                    {
                                    	var resp=peticion_http.responseText;
                                        arrResp=resp.split('|');
                                        if(arrResp[0]=='1')
                                        {
                                            var arrDatos=eval(arrResp[1]);
                                            gEx('cmbUnidadGestion').setValue('');
                                			gEx('cmbUnidadGestion').getStore().loadData(arrDatos);
                                        }
                                        else
                                        {
                                            msgBox('Ha ocurrido un el siguiente error en el servidor que impide la realizaci&oacute;n de la actividad:'+' <br />'+arrResp[0]);
                                        }
                                    }
                                	obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',respAux, 'POST','funcion=4&idEdificio='+registro.data.id,true);
                                }
    					)



                        
    var cmbUnidadGestion=crearComboExt('cmbUnidadGestion',[],180,45,300);
    
	var cmbMotivoCambio=crearComboExt('cmbMotivoCambio',arrMotivoCambioSala,180,75,370);
	
                      
    
    
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                            x:20,
                                                            y:20,
                                                            xtype:'label',
                                                            html:'<span style="font-size:12px;font-family: Arial;font: 10px "Segoe UI", Arial, Helvetica, sans-serif;">Edificio: <span style="color:#F00">*</span></span>'
                                                        },
                                                        cmbEdificios,
                                                        {
                                                            x:20,
                                                            y:50,
                                                            xtype:'label',
                                                            html:'<span style="font-size:12px;font-family: Arial;font: 10px "Segoe UI", Arial, Helvetica, sans-serif;">Unidad de Gesti&oacute;n: <span style="color:#F00">*</span></span>'
                                                        },
                                                        cmbUnidadGestion,
                                                        
                                                        {
                                                            x:20,
                                                            y:80,
                                                            xtype:'label',
                                                            html:'<span style="font-size:12px;font-family: Arial;font: 10px "Segoe UI", Arial, Helvetica, sans-serif;">Motivo del cambio: <span style="color:#F00">*</span></span>'
                                                        },
                                                        cmbMotivoCambio,
                                                        {
                                                            x:20,
                                                            y:110,
                                                            xtype:'label',
                                                            html:'<span style="font-size:12px;font-family: Arial;font: 10px "Segoe UI", Arial, Helvetica, sans-serif;">Detalle del cambio:<span style="color:#F00"></span></span>'
                                                        },
                                                        {
                                                        	x:20,
                                                            y:140,
                                                            width:550,
                                                            height:60,
                                                            xtype:'textarea',
                                                           	id:'txtComentarios'
                                                        }
                                                        

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: leyenda,
										width: 620,
										height:300,
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
                                                            text:'Aceptar',
                                                            handler:function()
                                                                    {
                                                                        if(gEx('cmbUnidadGestion').getValue()=='')
                                                                        {
                                                                            function resp()
                                                                            {
                                                                                gEx('cmbUnidadGestion').focus();
                                                                                
                                                                            }
                                                                            msgBox('Debe indicar la unidad de Gesti&oacute;n a asignar',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        if(cmbMotivoCambio.getValue()=='')
                                                                        {
                                                                            function resp2()
                                                                            {
                                                                                cmbMotivoCambio.focus();
                                                                                
                                                                            }
                                                                            msgBox('Debe indicar del motivo del cambio',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        if((cmbEdificios.getValue()==objDatosAudiencia.idEdificio)&&(cmbUnidadGestion.getValue()==objDatosAudiencia.idUnidadGestion))
                                                                        {
                                                                        	
                                                                            msgBox('Debe realizar almenos un cambio en el evento');
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        var cadObj='{"idEvento":"'+idEventoAudiencia+'","idEdificio":"'+cmbEdificios.getValue()+'","idUnidadGestion":"'+gEx('cmbUnidadGestion').getValue()+
                                                                        			'","motivoCambio":"'+cmbMotivoCambio.getValue()+'","comentariosAdicionales":"'+cv(gEx('txtComentarios').getValue())+'"}';
                                                                        
                                                                        
                                                                        
                                                                        function respConf(btn)
                                                                        {
                                                                            if(btn=='yes')
                                                                            {
                                                                                function respAuxFinal(peticion_http)
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                        
                                                                                        function respFinalCambio()
                                                                                        {
                                                                                             consultarDatosEvento(objConfiguracionTablero);
                                                                                             ventanaAM.close();  
                                                                                        }                                                                                 
                                                                                        msgBox('La operaci&oacute;n ha sido realizada exitosamente',respFinalCambio);
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                      msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',respAuxFinal, 'POST','funcion=12&cadObj='+cadObj,true);
                                                                            }
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer registrar la modificaci&oacute;n del evento',respConf);
                                                                        
                                                                        
                                                                        
                                                                    }
                                                            
                                                        },
                                                        {
                                                           	text:'Cancelar',
                                                            handler:function()
                                                                    {
                                                                        ventanaAM.close();  
                                                                    }
                                                            
                                                        }
													]
									}
								);
	ventanaAM.show();
    
                      
	cmbEdificios.setValue(objDatosAudiencia.idEdificio)  ;
    
    if(!objConfiguracionTablero.permiteModificarEdificio)
    {
    	cmbEdificios.disable();
    }         
    
    
    function respAux2(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var arrDatos=eval(arrResp[1]);
            gEx('cmbUnidadGestion').setValue('');
            gEx('cmbUnidadGestion').getStore().loadData(arrDatos);
            gEx('cmbUnidadGestion').setValue(objDatosAudiencia.idUnidadGestion);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',respAux2, 'POST','funcion=4&idEdificio='+objDatosAudiencia.idEdificio,true);
              
                      
}

function mostrarModificacionJuez(iJ)
{
	var pJuez=obtenerPosObjeto(objDatosAudiencia.jueces,'idRegistroEventoJuez',bD(iJ));
    var oJuez=objDatosAudiencia.jueces[pJuez];
    var cmbJueces=crearComboExt('cmbJueces',[],190,45,350);
	//var cmbMotivoCambio=crearComboExt('cmbMotivoCambio',arrMotivoCambioJuez,180,105,370);
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                            x:20,
                                                            y:20,
                                                            xtype:'label',
                                                            html:'<span style="font-size:12px;font-family: Arial;font: 10px "Segoe UI", Arial, Helvetica, sans-serif;">'+(tipoMateria=='SCC'?'Magistrado actual asignado:':'Juez actual asignado:') +'<span style="color:#F00">*</span></span>'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            width:480,
                                                            readOnly:true,
                                                            x:190,
                                                            y:15,
                                                            value:oJuez.nombreJuez
                                                        },
                                                        {
                                                            x:20,
                                                            y:50,
                                                            xtype:'label',
                                                            html:'<span style="font-size:12px;font-family: Arial;font: 10px "Segoe UI", Arial, Helvetica, sans-serif;">'+(tipoMateria=='SCC'?'Magistrado a asignar:':'Juez a asignar:') +'<span style="color:#F00">*</span></span>'
                                                        },
                                                        cmbJueces,
                                                        {
                                                        	x:470,
                                                            y:75,
                                                            id:'chkJuecesDisponibilidad',
                                                            checked:true,
                                                            xtype:'checkbox',
                                                            boxLabel:(tipoMateria=='SCC'?'Mostrar magistrados con disponibilidad':'Mostrar jueces con disponibilidad'),
                                                            listeners:	{
                                                            				check:obtenerJuecesCambio
                                                            			}
                                                        },
                                                        {
                                                            x:20,
                                                            y:100,
                                                            hidden:true,
                                                            xtype:'label',
                                                            html:'<span style="font-size:12px;font-family: Arial;font: 10px "Segoe UI", Arial, Helvetica, sans-serif;">Motivo del cambio: <span style="color:#F00">*</span></span>'
                                                        },
                                                        //cmbMotivoCambio,
                                                        {
                                                            x:20,
                                                            y:100,
                                                            xtype:'label',
                                                            html:'<span style="font-size:12px;font-family: Arial;font: 10px "Segoe UI", Arial, Helvetica, sans-serif;">Motivo del cambio:<span style="color:#F00"></span></span>'
                                                        },
                                                        {
                                                        	x:20,
                                                            y:130,
                                                            width:660,
                                                            height:60,
                                                            xtype:'textarea',
                                                           	id:'txtComentarios'
                                                        }
                                                        

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Modificar '+(tipoMateria=='SCC'?'Magistrado':'Juez'),
										width: 720,
										height:280,
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
                                                                	gEx('txtComentarios').focus(false,500);
																}
															}
												},
										buttons:	[
														{
                                                            text:'Aceptar',
                                                            handler:function()
                                                                    {
                                                                        if(cmbJueces.getValue()=='')
                                                                        {
                                                                            function resp()
                                                                            {
                                                                                cmbJueces.focus();
                                                                                
                                                                            }
                                                                            msgBox('Debe indicar el juez a asignar',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        /*if(cmbMotivoCambio.getValue()=='')
                                                                        {
                                                                            function resp2()
                                                                            {
                                                                                cmbMotivoCambio.focus();
                                                                                
                                                                            }
                                                                            msgBox('Debe indicar del motivo del cambio',resp2);
                                                                            return;
                                                                        }*/
                                                                        
                                                                        
                                                                        if(gEx('txtComentarios').getValue()=='')
                                                                        {
                                                                            function resp2()
                                                                            {
                                                                                gEx('txtComentarios')
                                                                                
                                                                            }
                                                                            msgBox('Debe indicar del motivo del cambio',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        var cadObj='{"idEvento":"'+idEventoAudiencia+'","idRegistroJuez":"'+oJuez.idRegistroEventoJuez+'","idJuezOriginal":"'+oJuez.idJuez+
                                                                        			'","idJuezCambio":"'+cmbJueces.getValue()+
                                                                        			'","motivoCambio":"-1","comentariosAdicionales":"'+cv(gEx('txtComentarios').getValue())+'"}';
                                                                        
                                                                        
                                                                        function respConf(btn)
                                                                        {
                                                                            if(btn=='yes')
                                                                            {
                                                                                function respAuxFinal(peticion_http)
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                        
                                                                                        function respFinalCambioJuez()
                                                                                        {
                                                                                             consultarDatosEvento(objConfiguracionTablero);
                                                                                             ventanaAM.close();  
                                                                                        }                                                                                 
                                                                                        msgBox('La operaci&oacute;n ha sido realizada exitosamente',respFinalCambioJuez);
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                      msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',respAuxFinal, 'POST','funcion=14&cadObj='+cadObj,true);
                                                                            }
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer registrar la modificaci&oacute;n del juez',respConf);
                                                                        
                                                                        
                                                                    }
                                                            
                                                        },
                                                        {
                                                           	text:'Cancelar',
                                                            handler:function()
                                                                    {
                                                                        ventanaAM.close();  
                                                                    }
                                                            
                                                        }
													]
									}
								);
	ventanaAM.show();
    
                      
	
    
    obtenerJuecesCambio()
              
         
}

function obtenerJuecesCambio()
{
	function respAux2(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var arrDatos=eval(arrResp[1]);
            gEx('cmbJueces').setValue('');
            gEx('cmbJueces').getStore().loadData(arrDatos);
           
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',respAux2, 'POST','funcion=13&mostrarTodosJueces='+((gEx('chkJuecesDisponibilidad').getValue())?0:1)+'&iE='+bE(idEventoAudiencia)+'&iUG='+bE(objDatosAudiencia.idUnidadGestion),true);
}

function mostrarModificacionEvento()
{
	var cmbSalas=crearComboExt('cmbSalas',[],0,0,220);
    cmbSalas.on('select',function(cmb,registro)
    					{
    						cargarDatosAgenda();                    
                        }
    			)
    

    var cmbEdificio=crearComboExt('cmbEdificio',arrEdificios,0,0,300);
    

    cmbEdificio.setValue(objDatosAudiencia.idEdificio);
    cmbEdificio.on('select',function(cmb,registro)
    					{

                        		if(registro.data.id=='100')
                                {
                                	gEx('cmbSalas').setValue('');
                                    gEx('cmbSalas').disable();
                                    cargarDatosAgenda();
                                    return;
                                }
                                else
                                {
                                	gEx('cmbSalas').enable();
                                
                                }
    						    function respAux22(peticion_http)
                                {
                                    var resp=peticion_http.responseText;
                                    arrResp=resp.split('|');
                                    if(arrResp[0]=='1')
                                    {
                                        var arrDatos=eval(arrResp[1]);
                                        gEx('cmbSalas').setValue('');
                                        gEx('cmbSalas').getStore().loadData(arrDatos);
                                        
                                        
                                        
                                        var pos=obtenerPosFila(gEx('cmbSalas').getStore(),'id',objDatosAudiencia.idSala);
                                        if(pos!=-1)
	                                        cmbSalas.setValue(objDatosAudiencia.idSala);
                                        else
                                        {
                                        	if(arrDatos.length>0)
	                                        	cmbSalas.setValue(arrDatos[0][0]);
                                        }
                                        cargarDatosAgenda();
                                        
                                        
                                       
                                    }
                                    else
                                    {
                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                    }
                                }
                                obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',respAux22, 'POST',
                                				'funcion=5&idUnidadGestion='+objDatosAudiencia.idUnidadGestion+'&idEdificio='+
                                                registro.data.id+'&tipoAudiencia='+objDatosAudiencia.idTipoAudiencia+'&carpetaAdministrativa='+
                                                objDatosAudiencia.carpetaJudicial+'&fechaAudiencia='+gEx('txtFechaEvento').getValue().format('Y-m-d'),false);                  
                        }
    			)
    
    var horaInicio=Date.parseDate('<?php echo $fechaActual?> 00:00:00','Y-m-d H:i:s');
    var horaFin=Date.parseDate('<?php echo $fechaActual?> 23:50:00','Y-m-d H:i:s');
    
    var arrTiempo=generarIntervaloHoras(horaInicio,horaFin,1,'H:i:s','H:i \\hr\\s.');
    
    var cmbHoraInicio=crearComboExt('cmbHoraInicio',arrTiempo,0,0,90);
    
    cmbHoraInicio.setValue(Date.parseDate(objDatosAudiencia.horaInicio,'Y-m-d H:i:s').format('H:i:s'));
    cmbHoraInicio.on('select',function(cmb,registro)
    						{
                            	calcularHoraFinal(registro.data.id);
                                
                                
                            }
    				)
                    
    var cmbHoraTermino=crearComboExt('cmbHoraTermino',arrTiempo,0,0,90);
    cmbHoraTermino.setValue(Date.parseDate(objDatosAudiencia.horaFin,'Y-m-d H:i:s').format('H:i:s'));
    
    cmbHoraTermino.on('select',function(cmb,registro)
    						{
                            	calcularTiempoEstimado()
                                
                            }
    				)
    
    
    var cmbMotivoCambio=crearComboExt('cmbMotivoCambio',arrMotivoCambioFecha,0,0,150);
    
   	var cmbAsignacioJuez=crearComboExt('cmbAsignacioJuez',[['0','Mantener asignaci\xF3n'],['1','Asignar juez disponible']],0,0,170);
    cmbAsignacioJuez.setValue('0');
    cmbAsignacioJuez.on('select',cargarDatosAgenda);
    if(tipoMateria!='P')
    {
    	cmbAsignacioJuez.hide();
    }
    
    
	var ventanaAM = new Ext.Window(
									{
										title: 'Modificar fecha/sala de evento',
										width: 980,
                                        id:'vModificacionFechaSala',
										height:400,
										layout: 'fit',
										plain:true,
										modal:true,
                                        tbar:	[
                                        			{
                                                        xtype:'label',
                                                        html:'Fecha a asignar:&nbsp;&nbsp;'
                                                    },
                                                    {
                                                        xtype:'datefield',
                                                        id:'txtFechaEvento',
                                                        //minValue:'<?php echo $fechaActual?>',
                                                        listeners:	{
                                                        				select:function()
                                                                        		{
                                                                                	cargarDatosAgenda();
                                                                                }
                                                        			},
                                                        value:objDatosAudiencia.fechaEvento
                                                    },'-',
                                                    {
                                                        xtype:'label',
                                                        html:'&nbsp;&nbsp;De &nbsp;&nbsp;'
                                                    },
                                                    cmbHoraInicio,
                                                    {
                                                        xtype:'label',
                                                        html:'&nbsp;&nbsp; a &nbsp;&nbsp;'
                                                    },
                                                    cmbHoraTermino,
                                                    {
                                                        html:'<span id="lblFechaHoraFin"></span>&nbsp;&nbsp;(Duraci&oacute;n estimada:&nbsp;&nbsp;<span id="lblDuracionEstimada"></span> minutos)'
                                                    },'-',
                                                    {
                                                    	xtype:'label',
                                                        hidden:(tipoMateria!='P'),
                                                        html:'&nbsp;&nbsp;Asignaci&oacute;n de juez:&nbsp;&nbsp;'
                                                    },
                                                    cmbAsignacioJuez
                                        		],
										buttonAlign:'center',
										items: 	[
                                                    {
                                                        xtype:'panel',
                                                        baseCls: 'x-plain',
                                                        layout:'absolute',
                                                        defaultType: 'label',
                                                        border:false,
                                                        tbar:	[
                                                        			{
                                                                        xtype:'label',
                                                                        html:'&nbsp;&nbsp;Edificio:&nbsp;&nbsp;'
                                                                    },
                                                                    cmbEdificio,'-',
                                                                    {
                                                                        xtype:'label',
                                                                        html:'&nbsp;&nbsp;Sala de audiencia:&nbsp;&nbsp;'
                                                                    },
                                                                    cmbSalas,'-',
                                                                    {
                                                                        xtype:'label',
                                                                        html:'&nbsp;&nbsp;Motivo del cambio:&nbsp;&nbsp;'
                                                                    },
                                                                    cmbMotivoCambio
                                                                    
                                                               ],
                                                        bbar:	[
                                                        			{
                                                                    	xtype:'label',
                                                                        html:'<table><tr><td><div style="width:15px; height:15px; background-color:#900; border-style:solid; border-width:1px; border-color:#000"></div></td><td> Evento a modificar</td></tr></table>'
                                                                    },'-',
                                                                    {
                                                                    	xtype:'label',
                                                                        html:'<table><tr><td><div style="width:15px; height:15px; background-color:#030; border-style:solid; border-width:1px; border-color:#000"></div></td><td> Eventos de la sala</td></tr></table>'
                                                                    },'-',
                                                                    {
                                                                    	xtype:'label',
                                                                        html:'<table><tr><td><div style="width:15px; height:15px; background-color:#E56A4B; border-style:solid; border-width:1px; border-color:#000"></div></td><td> Eventos de '+(tipoMateria=='SCC'?'magistrado':'juez')+'</td></tr></table>'
                                                                    },'-',
                                                                    {
                                                                    	xtype:'label',
                                                                        html:'<table><tr><td><div style="width:15px; height:15px; background-color:#3D00CA; border-style:solid; border-width:1px; border-color:#000"></div></td><td> No disponibilidad de '+(tipoMateria=='SCC'?'magistrado':'juez')+'</td></tr></table>'
                                                                    },'-',
                                                                    {
                                                                    	xtype:'label',
                                                                        html:'<table><tr><td><div style="width:15px; height:15px; background-color:#B55381; border-style:solid; border-width:1px; border-color:#000"></div></td><td> No disponibilidad de sala</td></tr></table>'
                                                                    },
                                                                    '-',
                                                                    {
                                                                    	xtype:'label',
                                                                        html:'<table><tr><td><div style="width:15px; height:15px; background-color:#000; border-style:solid; border-width:1px; border-color:#000"></div></td><td> Fuera del l&iacute;mite m&aacute;ximo de atenci&oacute;n</td></tr></table>'
                                                                    }
                                                                    
                                                        		],
                                                        items:	[
                                                        			new Ext.ux.IFrameComponent({ 
                
                                                                                                            id: 'frameContenido', 
                                                                                                            anchor:'100% 100%',
                                                                                                            loadFuncion:function(iFrame)
                                                                                                            			{
                                                                                                                        	
                                                                                                                        },

                                                                                                            url: '../paginasFunciones/white.php',
                                                                                                            style: 'width:100%;height:100%' 
                                                                                                    })
                                                                ]
                                                    }
                                        		],
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
																		if(cumpleValidacion())
                                                                        {
                                                                        	mostrarVentanaComentarios();
                                                                        }
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
    calcularTiempoEstimado();
     
    if(objDatosAudiencia.idEdificio!='100')
    {
        function respAux2(peticion_http)
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                var arrDatos=eval(arrResp[1]);
                gEx('cmbSalas').setValue('');
                gEx('cmbSalas').getStore().loadData(arrDatos);
                
                cmbSalas.setValue(objDatosAudiencia.idSala);
                
                cargarDatosAgenda();
                
                
               
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',respAux2, 'POST','funcion=5&idUnidadGestion='+
                            objDatosAudiencia.idUnidadGestion+'&idEdificio='+objDatosAudiencia.idEdificio+
                            '&tipoAudiencia='+objDatosAudiencia.idTipoAudiencia+'&carpetaAdministrativa='+objDatosAudiencia.carpetaJudicial
                            +'&fechaAudiencia='+gEx('txtFechaEvento').getValue().format('Y-m-d'),false);
        
   }
   else
   {
   		gEx('cmbSalas').setValue('');
        gEx('cmbSalas').disable();
        cargarDatosAgenda();
        return;
   } 
    
}

function cargarDatosAgenda()
{
	gEx('frameContenido').load	(
    								{
                                    	url:'../modulosEspeciales_SGJP/calendarioEventosModificacionFecha.php',
                                        params:	{
                                        			idSala:gEx('cmbEdificio').getValue()=='100'?-1:gEx('cmbSalas').getValue(),
                                                    iEvento: idEventoAudiencia,
                                                    asignacionJuez:gEx('cmbAsignacioJuez').getValue(),
                                                    fechaBase: gEx('txtFechaEvento').getValue().format('Y-m-d')
                                        			
                                        		}
                                    }
    							)
}

function calcularTiempoEstimado()
{
	var horaInicio=Date.parseDate(gEx('txtFechaEvento').getValue().format('Y-m-d')+' '+gEx('cmbHoraInicio').getValue(),'Y-m-d H:i:s');
    var fechaFin=gEx('txtFechaEvento').getValue().format('Y-m-d');
    
    if(gE('lblFechaHoraFin').innerHTML!='')
    {
    	fechaFin=Date.parseDate(gE('lblFechaHoraFin').innerHTML.replace('&nbsp;&nbsp;Del ',''),'d/m/Y').format('Y-m-d');
    }
    
    var horaFin=Date.parseDate(fechaFin+' '+gEx('cmbHoraTermino').getValue(),'Y-m-d H:i:s');
	var duracionEstimada=((horaFin-horaInicio+0)/60000);
    gE('lblDuracionEstimada').innerHTML=duracionEstimada;
    ajustarEvento();
}

function calcularHoraFinal(horaInicial)
{
	var duracionOriginal=Math.abs(parseInt(gE('lblDuracionEstimada').innerHTML));
    
	var fechaInicio=gEx('txtFechaEvento').getValue().format('Y-m-d');
    fechaInicio+=' '+horaInicial;
    
    var dteFechaInicio=Date.parseDate(fechaInicio,'Y-m-d H:i:s');
   
    var dteFechaFin=dteFechaInicio.add(Date.MINUTE,duracionOriginal);
    
    
	gEx('cmbHoraTermino').setValue(dteFechaFin.format('H:i:s')); 
    
    gEx('cmbHoraInicio').setValue(dteFechaInicio.format('H:i:s')); 
    if(dteFechaInicio.format('Y-m-d')!=dteFechaFin.format('Y-m-d'))
    {
    	gE('lblFechaHoraFin').innerHTML='&nbsp;&nbsp;Del '+dteFechaFin.format('d/m/Y');
    }
    else
    	gE('lblFechaHoraFin').innerHTML='';
       
    calcularTiempoEstimado();
    
       
}

function cumpleValidacion()
{
	var txtFechaEvento=gEx('txtFechaEvento');
    var cmbHoraInicio=gEx('cmbHoraInicio');
	var cmbHoraTermino=gEx('cmbHoraTermino');
    var cmbSalas=gEx('cmbSalas');
    var cmbMotivoCambio=gEx('cmbMotivoCambio');
    
    if(txtFechaEvento.getValue()=='')
    {
    	function resp1()
        {
        	txtFechaEvento.focus();
        }
        msgBox('Debe indicar la nueva fecha del evento',resp1);
        return false;
    }
    
    if(txtFechaEvento.getValue()=='')
    {
    	function resp2()
        {
        	cmbHoraInicio.focus();
        }
        msgBox('Debe indicar la hora de inicio del evento',resp2);
        return false;
    }
    
    if(txtFechaEvento.getValue()=='')
    {
    	function resp3()
        {
        	cmbHoraTermino.focus();
        }
        msgBox('Debe indicar la hora de t&eacute;rmino del evento',resp3);
        return false;
    }
    
    if(gEx('cmbEdificio').getValue()!='100')
    {
        if(cmbSalas.getValue()=='')
        {
            function resp4()
            {
                cmbSalas.focus();
            }
            msgBox('Debe indicar la sala en donde se llevar&aacute; acabo la audiencia del evento',resp4);
            return false;
        }
	}
    
        
    if(cmbMotivoCambio.getValue()=='')
    {
    	function resp5()
        {
        	cmbMotivoCambio.focus();
        }
        msgBox('Debe indicar el motivo de la modificaci&oacute;n del evento',resp5);
        return false;
    }   
    
    var lblHoraInicio=txtFechaEvento.getValue().format('Y-m-d')+' '+cmbHoraInicio.getValue();
                                                                        
    var lblHoraFin=txtFechaEvento.getValue().format('Y-m-d');
    
    if(gE('lblFechaHoraFin').innerHTML!='')
    {
      lblHoraFin=Date.parseDate(gE('lblFechaHoraFin').innerHTML.replace('&nbsp;&nbsp;Del ',''),'d/m/Y').format('Y-m-d');
    }
    lblHoraFin+=' '+cmbHoraTermino.getValue();
    
    
    if(Date.parseDate(lblHoraInicio,'Y-m-d H:i:s')>Date.parseDate(lblHoraFin,'Y-m-d H:i:s'))
    {
      
      	function resp6()
        {
        	cmbHoraInicio.focus();
        }
        msgBox('La hora de inicio del evento NO puede ser mayor que hora de t&eacute;rmino',resp6);
        return false;
    }
    
    var calendario=gEx('frameContenido').getFrameWindow();	
    
    if(calendario.$)
    {
    	
    	
        var evento=calendario.$('#calendar').fullCalendar( 'clientEvents' ,'e_'+idEventoAudiencia )[0];       
        if(calendario.existeTraslape(evento))
        {
        	msgBox('Ya existe un evento asignado en el horario que pretende programar');
          	
            return false;
        }
        

        if(calendario.seEncuentraFueraLimites(evento))
        {
        	msgBox('La audiencia se encuentra fuera de los l&iacute;mites m&aacute;ximos de atenci&oacute;n');
            return false;
        }
        
        
    }

	return true;
}

function mostrarVentanaComentarios()
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
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            xtype:'textarea',
                                                            width:500,
                                                            id:'txtComentarios',
                                                            height:60
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Modificar Fecha/Sala de audiencia',
										width: 550,
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
                                                                	gEx('txtComentarios').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',                                                            
															handler: function()
																	{
                                                                    
                                                                    	var txtFechaEvento=gEx('txtFechaEvento');
                                                                        var cmbHoraInicio=gEx('cmbHoraInicio');
                                                                        var cmbHoraTermino=gEx('cmbHoraTermino');
                                                                        var cmbSalas=gEx('cmbSalas');
                                                                        var cmbMotivoCambio=gEx('cmbMotivoCambio');
																		var txtComentarios=gEx('txtComentarios');
                                                                        
                                                                        var lblHoraInicio=txtFechaEvento.getValue().format('Y-m-d')+' '+cmbHoraInicio.getValue();
                                                                        
                                                                        var lblHoraFin=txtFechaEvento.getValue().format('Y-m-d');
                                                                        
                                                                        if(gE('lblFechaHoraFin').innerHTML!='')
                                                                        {
                                                                        	lblHoraFin=Date.parseDate(gE('lblFechaHoraFin').innerHTML.replace('&nbsp;&nbsp;Del ',''),'d/m/Y').format('Y-m-d');
                                                                        }
                                                                        lblHoraFin+=' '+cmbHoraTermino.getValue();
                                                                        
                                                                       
                                                                        
                                                                        var cadObj='{"asignacionJuez":"'+gEx('cmbAsignacioJuez').getValue()+'","idEvento":"'+idEventoAudiencia+'","idMotivoCambio":"'+cmbMotivoCambio.getValue()+
                                                                                    '","comentariosAdicionales":"'+cv(txtComentarios.getValue())+'","fechaEvento":"'+txtFechaEvento.getValue().format('Y-m-d')+
                                                                                    '","horaInicio":"'+lblHoraInicio+'","horaFin":"'+lblHoraFin+'","idSala":"'+(gEx('cmbEdificio').getValue()=='100'?'-100':cmbSalas.getValue())+
                                                                                    '","idEdificio":"'+gEx('cmbEdificio').getValue()+'"}';
                                                                        
                                                                        function respConf(btn)
                                                                        {
                                                                        	if(btn=='yes')
                                                                            {
                                                                            	function respAuxFinal(peticion_http)
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                        
                                                                                        function respFinalCambioFecha()
                                                                                        {
                                                                                             consultarDatosEvento(objConfiguracionTablero);
                                                                                             ventanaAM.close();  
                                                                                             gEx('vModificacionFechaSala').close();
                                                                                        }                                                                                 
                                                                                        msgBox('La operaci&oacute;n ha sido realizada exitosamente',respFinalCambioFecha);
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                    	if(arrResp[0]=='3')
                                                                                        {
                                                                                        	 function respFinalCambioFecha2()
                                                                                            {
                                                                                            	ventanaAM.close();  
                                                                                                cargarDatosAgenda();   
                                                                                            }                                                                                 
                                                                                            msgBox('<br>La sala seleccionada ya no se encuentra disponible',respFinalCambioFecha2);
                                                                                        }
                                                                                        else
                                                                                      		msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[1]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',respAuxFinal, 'POST','funcion=15&cadObj='+cadObj,true);
                                                                            }
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer registrar la modificaci&oacute;n del evento',respConf);
                                                                        
                                                                        
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

function ajustarEvento()
{
	var calendario=gEx('frameContenido').getFrameWindow();	
    var horaInicio=Date.parseDate(gEx('txtFechaEvento').getValue().format('Y-m-d')+' '+gEx('cmbHoraInicio').getValue(),'Y-m-d H:i:s');
    var fechaFin=gEx('txtFechaEvento').getValue().format('Y-m-d');
    
    if(gE('lblFechaHoraFin').innerHTML!='')
    {
    	fechaFin=Date.parseDate(gE('lblFechaHoraFin').innerHTML.replace('&nbsp;&nbsp;Del ',''),'d/m/Y').format('Y-m-d');
    }
    
    var horaFin=Date.parseDate(fechaFin+' '+gEx('cmbHoraTermino').getValue(),'Y-m-d H:i:s');
    if(calendario.$)
    {
        var evento=calendario.$('#calendar').fullCalendar( 'clientEvents' ,'e_'+idEventoAudiencia )[0];
        
        var horaInicioAnterior=evento.start;
        var horaFinAnterior=evento.end;
        
        evento.start=moment(horaInicio);
        evento.end=moment(horaFin);
        if(calendario.existeTraslape(evento))
        {
        	
        	function resp22()
            {
            	evento.start=Date.parseDate(moment(horaInicioAnterior).format("YYYY-MM-DD HH:mm:ss"),'Y-m-d H:i:s');
		        evento.end=Date.parseDate(moment(horaFinAnterior).format("YYYY-MM-DD HH:mm:ss"),'Y-m-d H:i:s');
                var fechaEvento=evento.start.format('Y-m-d');
                
             	gEx('txtFechaEvento').setValue(fechaEvento);
                gEx('cmbHoraInicio').setValue(evento.start.format('H:i:s'));
                gEx('cmbHoraTermino').setValue(evento.end.format('H:i:s'));
                var registro=calendario.$('#calendar').fullCalendar('updateEvent', evento);
                //calcularHoraFinal(evento.start.format('H:i:s'));
                
                   
            }
            msgBox('Ya existe un evento asignado en el horario que pretende programar',resp22);
            return;
        }
        evento.start=horaInicio;
        evento.end=horaFin;
        var registro=calendario.$('#calendar').fullCalendar('updateEvent', evento);
	}
   
}

function ajustarFechaEvento(evento)
{
	
	gEx('txtFechaEvento').setValue(evento.start.format('YYYY-MM-DD'));
    gEx('cmbHoraInicio').setValue(evento.start.format('HH:mm:ss'));    
    gEx('cmbHoraTermino').setValue(evento.end.format('HH:mm:ss'));
    gE('lblFechaHoraFin').innerHTML='';
    calcularTiempoEstimado();
    
    

}

function mostrarVentanaFinalizarPorAcuerdo(iE)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var obj={};    
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[['idFormulario',322],['idRegistro',arrResp[1]],['idEvento',iE],
            			['dComp',arrResp[2]],['actor',arrResp[3]]];
            window.parent.abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=58&iFormulario=322&iE='+iE,true);
}

function mostrarVentanaCancelarAudiencia(iE)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var obj={};    
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[['idFormulario',323],['idRegistro',arrResp[1]],['idEvento',iE],
            			['dComp',arrResp[2]],['actor',arrResp[3]]];
            window.parent.abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=58&iFormulario=323&iE='+iE,true);
}

