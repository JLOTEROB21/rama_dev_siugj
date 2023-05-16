<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	
	$fechaActual=date("Y-m-d")	;
	
	$horaActual=$fechaActual." ".date("H:00:00");
	$horaFinal=date("Y-m-d H:i:s",strtotime("+ 1 hour",strtotime($horaActual)));
	
	$consulta="SELECT fechaCita,horaInicialCita,horaFinalCita FROM _662_tablaDinamica WHERE id__662_tablaDinamica=".$idRegistro;
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	
?>

var cadenaFuncionValidacion='validarSolicitud';
var fechaCita='<?php echo $fRegistro["fechaCita"]?>';
var horaInicialCita='<?php echo $fRegistro["horaInicialCita"]?>';
var horaFinalCita='<?php echo $fRegistro["horaFinalCita"]?>';

var horaActualTmp='<?php echo $horaActual ?>';
var horaFinalTmp='<?php echo $horaFinal ?>';

function inyeccionCodigo()
{
	loadScript("../Scripts/fullcalendar/lib/moment.min.js",function(){});
	if(esRegistroFormulario())
    {
    	
      if(gE('idRegistroG').value!='-1')
      {
      	var hIni=Date.parseDate(horaInicialCita,'H:i:s');
        var hFin=Date.parseDate(horaFinalCita,'H:i:s');
      	gE('sp_10645').innerHTML=hIni.format('H:i')+' hrs. - '+hFin.format('H:i')+' hrs.';
      }
    
        
	}
    else
    {
    	var hIni=Date.parseDate(horaInicialCita,'H:i:s');
        var hFin=Date.parseDate(horaFinalCita,'H:i:s');
      	gE('sp_10645').innerHTML=hIni.format('H:i')+' hrs. - '+hFin.format('H:i')+' hrs.';
       
    }

}


function agendarCita()
{
	
	var hMinima='08:00';
	var hMaxima='23:00';
	var arrHInicial=hMinima.split(':');	
	var arrHFinal=hMaxima.split(':');
	var horaInicial=new Date(2010,5,10,parseInt(arrHInicial[0]),parseInt(arrHInicial[1]));
	var horaFinal=new Date(2010,5,10,parseInt(arrHFinal[0]),parseInt(arrHFinal[1]));
	var arrHoras=generarIntervaloHoras(horaInicial,horaFinal,10);

	var hInicio=Date.parseDate(horaActualTmp,'Y-m-d H:i:s');
    var hFin=Date.parseDate(horaFinalTmp,'Y-m-d H:i:s');
    
    if(gEN('_fechaCitavch')[0].value!='N/E')
    {
    	var hI=gEN('_fechaCitavch')[0].value+' '+gEN('_horaInicialCitavch')[0].value;
        var hFin=gEN('_fechaCitavch')[0].value+' '+gEN('_horaFinalCitavch')[0].value;
    	hInicio=Date.parseDate(hI,'Y-m-d H:i:s');
    	hFin=Date.parseDate(hFin,'Y-m-d H:i:s');
    }

                                                                        
    
    
    
	var cmbHoraInicio=crearComboExt('cmbHoraInicio',arrHoras,260,5,90);
    cmbHoraInicio.setValue(hInicio.format('H:i'));
	cmbHoraInicio.on('change',ajustarEventoFecha);
    cmbHoraInicio.disable();
    var cmbHoraFin=crearComboExt('cmbHoraFin',arrHoras,400,5,90);
    cmbHoraFin.disable();
    cmbHoraFin.setValue(hFin.format('H:i'));
    cmbHoraFin.on('change',ajustarEventoFecha);
	
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
                                            bbar:	[
                                            			{
                                                        	xtype:'label',
                                                        	html:'<table><tr><td><div style="height:15px; width:20px; background-color:#900"></div></td><td>&nbsp;&nbsp;Cita Solicitada&nbsp;&nbsp;</td>'+
                                                            		'<td><div style="height:15px; width:20px; background-color:#030"></div></td><td>&nbsp;&nbsp;Cita Agendada&nbsp;&nbsp;</td>'+
                                                                    '<td><div style="height:15px; width:20px; background-color:#006"></div></td><td>&nbsp;&nbsp;Cita Por Confirmar (Reservada)</td></tr</table>'
                                                        }
                                            		],
											items: 	[
                                            			 {
                                                              x:10,
                                                              y:10,
                                                              html:'Horario Solicitado:'
                                                          },
                                                          {
                                                              x:150,
                                                              y:5,
                                                              disabled:true,
                                                              value:hInicio.format('Y-m-d'),
                                                              xtype:'datefield',
                                                              id:'fechaInicio',
                                                              listeners:	{
                                                                              change:ajustarEventoFecha
                                                                          }
                                                          },
                                                          cmbHoraInicio,
                                                          {
                                                              x:370,
                                                              y:10,
                                                              html:' a ',
                                                              xtype:'label'
                                                          },
                                                          cmbHoraFin,
                                                          {
                                                              x:500,
                                                              y:5,
                                                              value:hFin.format('Y-m-d'),
                                                              xtype:'datefield',
                                                              hidden:true,
                                                              id:'fechaFin',
                                                              listeners:	{
                                                                              change:ajustarEventoFecha
                                                                          }
                                                          },
                                            
                                            			{
                                                        	xtype:'panel',
                                                            x:10,
                                                            y:30,
                                                            width:950,
                                                            height:360,
                                                            layout:'border',
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                            			new Ext.ux.IFrameComponent({ 

                                                                                                        id: 'frameAgenda', 
                                                                                                        anchor:'950px 350px',
                                                                                                        region:'center',
                                                                                                        loadFuncion:function(iFrame)
                                                                                                                    {
                                                                                                                        autofitIframe(iFrame);
                                                                                                                    },
                
                                                                                                        url: '../paginasFunciones/white.php',
                                                                                                        style: 'width:950px;height:350px' 
                                                                                                })	
                                                            		]
                                                        }
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Asignar Cita',
										width: 980,
										height:520,
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
                                                                	/*if((nodo.attributes.idAsignacion!='-1')&&(nodo.attributes.idAsignacion!='0'))
                                                                    {
                                                                        cmbRecusoAsignacion.setValue(nodo.attributes.idAsignacion);
                                                                        dispararEventoSelectCombo('cmbRecusoAsignacion');
                                                                    }*/
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',                                                            
															handler: function()
																	{
                                                                    	gEN('_fechaCitavch')[0].value=gEx('fechaInicio').getValue().format('Y-m-d');
                                                                        gE('sp_10644').innerHTML=gEx('fechaInicio').getValue().format('d/m/Y');
                                                                        gEN('_horaInicialCitavch')[0].value=gEx('cmbHoraInicio').getValue()+":00";
                                                                        gE('sp_10645').innerHTML=gEx('cmbHoraInicio').getValue()+' hrs. - '+gEx('cmbHoraFin').getValue()+' hrs. ';
                                                                        gEN('_horaFinalCitavch')[0].value=gEx('cmbHoraFin').getValue()+":00";
                                                                        
                                                                        var fIni=Date.parseDate(gEx('fechaInicio').getValue().format('Y-m-d')+' '+gEx('cmbHoraInicio').getValue()+":00",'Y-m-d H:i:s');
                                                                        var fFIn=Date.parseDate(gEx('fechaInicio').getValue().format('Y-m-d')+' '+gEx('cmbHoraFin').getValue()+":00",'Y-m-d H:i:s');
                                                                        var diferencia=(fFIn-fIni)/1000/60;
                                                                        gEN('_duracionCitavch')[0].value=diferencia;
                                                                        gE('sp_10646').innerHTML=gEN('_duracionCitavch')[0].value;
                                                                        
                                                                        ventanaAM.close();
                                                                        
                                                                        
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
     
     mostrarAgendaRecurso(1,1,gE('idRegistroG').value);
                             
	/*function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
            cmbRecusoAsignacion.getStore().loadData(arrDatos);
            
            ventanaAM.show();
           
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../modulosEspeciales_FOX/paginasFunciones/funcionesModulosEspeciales_FOX.php',funcAjax, 'POST','funcion=58&iC='+nodo.attributes.idRecurso,true);     */                           
                                
	
}

function ajustarFechaEvento(fInicio,fFin)
{
	var fechaInicio=Date.parseDate(fInicio.format('YYYY-MM-DD HH:mm:ss'),'Y-m-d H:i:s');
    var fechaFin=Date.parseDate(fFin.format('YYYY-MM-DD HH:mm:ss'),'Y-m-d H:i:s');
	gEx('fechaInicio').setValue(fechaInicio.format('Y-m-d'));
    gEx('cmbHoraInicio').setValue(fechaInicio.format('H:i'));
    gEx('fechaFin').setValue(fechaFin.format('Y-m-d'));
    gEx('cmbHoraFin').setValue(fechaFin.format('H:i'));
}


function mostrarAgendaRecurso(tRecurso,iRecurso,idRegistro)
{
	gEx('frameAgenda').load	(
    							{
                                	url:'../modulosEspeciales_SGJ/tblAgendaRecursosAsignacionHora.php',
                                    params:	{
                                    			tipoRecurso:tRecurso,
                                                idRecurso:iRecurso,
                                                idRegistroIgnorar:idRegistro,
                                                cPagina:'sFrm=true',
                                                fechaBase:gEx('fechaInicio').getValue().format('Y-m-d')
                                    		}
                                }
    						)

}

function ajustarEventoFecha(ctrl,nValor,vValor)
{
	var evento={};
    
    evento.id='e_'+gE('idRegistroG').value;
    evento.start=moment(gEx('fechaInicio').getValue().format('Y-m-d')+' '+gEx('cmbHoraInicio').getValue());
    evento.end=moment(gEx('fechaInicio').getValue().format('Y-m-d')+' '+gEx('cmbHoraFin').getValue());
    if(evento.start>evento.end)
    {
    	function resp2()
        {
            ctrl.setValue(vValor);
            
        }
        msgBox('La hora de inicio de uso del recurso no puede ser mayor que la hora de t&eacute;rmino',resp2);
        return;
    	
    }
    var traslape=gEx('frameAgenda').getFrameWindow().existeTraslapeCambioHorario(evento);
    if(traslape)
    {
        function resp()
        {
            ctrl.setValue(vValor);
            
        }
        msgBox('Ya existe un evento asignado en el horario que pretende asignar',resp);
        return;
    }
    
    gEx('frameAgenda').getFrameWindow().cambiarHorarioEvento(evento);
    
    
}

function validarSolicitud()
{
	if(gEN('_fechaCitavch')[0].value=='N/E')
    {
    	msgBox('Debe indicar la fecha de cita que solicita');
    	return false;
    }
    
    return true;
}
