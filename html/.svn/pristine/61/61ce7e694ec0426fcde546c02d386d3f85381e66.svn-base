<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idRef=($_GET["iRef"]);
	$consulta="SELECT  fechaEvento,idRegistroEvento,idSala FROM 7000_eventosAudiencia WHERE idFormulario=46 AND idRegistroSolicitud=".$idRef;
	$fReferencia=$con->obtenerPrimeraFila($consulta);
	$idEvento=$fReferencia[1];
	$fechaActual=date("Y-m-d");
?>

var cadenaFuncionValidacion='prepararGuardado';

var idEvento=<?php echo $idEvento?>;


function inyeccionCodigo()
{
	loadScript('../modulosEspeciales_SGJP/Scripts/controlEventos.js.php', function()
    																		{
                                                                            	var objConf={};
                                                                                objConf.idEvento=idEvento;
                                                                                objConf.renderTo='sp_1382';
                                                                                objConf.permiteModificarEdificio=false;  
                                                                                objConf.permiteModificarUnidadGestion=false;  
                                                                                objConf.permiteModificarSala=false;  
                                                                                objConf.permiteModificarFecha=false;    
                                                                                objConf.permiteModificarJuez=false;                                                                               
                                                                                objConf.mostrarFechaAudiencia=true;
                                                                                objConf.mostrarTipoAudiencia=true;
                                                                                objConf.mostrarDuracionAudiencia=true;
                                                                                objConf.mostrarSalaAudiencia=true;
                                                                                objConf.mostrarCentroGestion=true;
                                                                                objConf.mostrarEdificio=true;
                                                                                objConf.mostrarJueces=true;
                                                                                objConf.mostrarDesarrollo=false;
                                                                                objConf.mostrarDuracionDesarrollo=false;
                                                                                objConf.mostrarHorarioDesarrollo=false;
                                                                                objConf.mostrarDocumentoMultimedia=false;
                                                                            	construirTableroEvento(objConf);
                                                                            }
    			);
	gE('sp_1346').innerHTML='';
	new Ext.Button (
                      {
                          icon:'../images/pencil.png',
                          cls:'x-btn-text-icon',
                          text:'Sugerir fecha de audiencia',
                          width:200,
                          height:25,
                          renderTo:'sp_1346',
                          handler:function()
                                  {
                                      mostrarVentanaPropuestaAudiencia();
                                  }
                          
                      }
                  )                

	asignarEvento(gE('_dictamenFinalvch'),'change',function(cmb)
    												{
                                                    	if(cmb.options.selectedIndex==1)
                                                        {
                                                        	('_horaInicioPropuestavch').value='';
                                                            gE('_horaFinalPropuestavch').value='';
                                                            gE('_dteFechaAudienciadte').value='';
                                                            gEx('f_sp_dteFechaAudienciadte').setValue('');
                                                        }
                                                    
                                                    }
                  )
                  
    
    
}


function mostrarVentanaPropuestaAudiencia()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
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
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Registrar propuesta de fecha de audiencia',
										width: 900,
										height:450,
										layout: 'fit',
                                        tbar:	[
                                        			{
                                                    	xtype:'label',
                                                        html:'Fecha del evento:&nbsp;&nbsp;'
                                                    },
                                        			{
                                                    	xtype:'datefield',
                                                        id:'dteFechaEvento',
                                                        minValue:'<?php echo $fechaActual?>',
                                                        value:'<?php echo $fReferencia[0]?>',
                                                        listeners:	{
                                                        				select:function()
                                                                        		{
                                                                                	cargarDatosAgenda();
                                                                                }
                                                        			}
                                                        
                                                    }
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
                                                        html:'<table><tr><td><div style="width:15px; height:15px; background-color:#E56A4B; border-style:solid; border-width:1px; border-color:#000"></div></td><td> Eventos de juez</td></tr></table>'
                                                    },'-',
                                                    {
                                                        xtype:'label',
                                                        html:'<table><tr><td><div style="width:15px; height:15px; background-color:#3D00CA; border-style:solid; border-width:1px; border-color:#000"></div></td><td> No disponibilidad de juez</td></tr></table>'
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
																		var calendario=gEx('frameContenido').getFrameWindow();	    
                                                                        if(calendario.$)
                                                                        {
                                                                            var evento=calendario.$('#calendar').fullCalendar( 'clientEvents' ,'e_'+idEventoAudiencia )[0];       
                                                                            if(calendario.existeTraslape(evento))
                                                                            {
                                                                                msgBox('Ya existe un evento asignado en el horario que pretende proponer');
                                                                                return false;
                                                                            }
                                                                            
                                                                            if(calendario.seEncuentraFueraLimites(evento))
                                                                            {
                                                                                msgBox('La audiencia se encuentra fuera de los l&iacute;mites m&aacute;ximos de atenci&oacute;n');
                                                                                return false;
                                                                            }
                                                                            
                                                                            
                                                                            gEx('f_sp_dteFechaAudienciadte').setValue(evento.start.format('YYYY-MM-DD'));
                                                                            gE('_horaInicioPropuestavch').value=evento.start.format('HH:mm:SS')
                                                                            gE('_horaFinalPropuestavch').value=evento.end.format('HH:mm:SS')
                                                                            ventanaAM.close();
                                                                            
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
    
    gEx('frameContenido').load	(
    								{
                                    	url:'../modulosEspeciales_SGJP/calendarioEventosPropuestaFecha.php',
                                        params:	{
                                        			idSala:'<?php echo $fReferencia[2]?>',
                                                    iEvento:'<?php echo $fReferencia[1]?>',
                                                    fechaBase: '<?php echo $fReferencia[0]?>'
                                        		}
                                    }	
    							);
    
    	
}

function cargarDatosAgenda()
{
	gEx('frameContenido').load	(
    								{
                                    	url:'../modulosEspeciales_SGJP/calendarioEventosPropuestaFecha.php',
                                        params:	{
                                        			idSala:'<?php echo $fReferencia[2]?>',
                                                    iEvento:'<?php echo $fReferencia[1]?>',
                                                    fechaBase: gEx('dteFechaEvento').getValue().format('Y-m-d')
                                        			
                                        		}
                                    }
    							)
}

function prepararGuardado()
{
	
	if(gE('_horaInicioPropuestavch').value!='')
    {
        gE('_horaInicioPropuestavch').disabled=false;
        gE('_horaFinalPropuestavch').disabled=false;
        gE('_dteFechaAudienciadte').value=gEx('f_sp_dteFechaAudienciadte').getValue().format('d/m/Y');
	}
    else
    {
    	if(gE('_dictamenFinalvch').selectedIndex==2)
        {
        	if(gE('_dteFechaAudienciadte').value=='')
            {
            	msgBox('Debe ingresar la fecha propuesta de audiencia');
                return false;
            }
            
        }
    }    
    
    
    
    return true;
}