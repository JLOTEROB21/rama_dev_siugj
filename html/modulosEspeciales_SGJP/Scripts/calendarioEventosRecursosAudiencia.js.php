<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

var idRegistroRecurso=-1;
Ext.onReady(inicializar);

function inicializar()
{
	idRegistroRecurso=gE('idRegistroRecurso').value;
	$('#calendar').fullCalendar(
    								{
										defaultView:'agendaDay',
                                     	header: 
                                        		{
                            		            	left: '',
                                                    center: 'title',
                                                    right:''
                                    	            
                                    	        },
										
                                        defaultDate: gE('fechaBase').value,
                                        businessHours: true, // display business hours
                                        editable: true,
                                        loading:function(isLoading,view)
                                        		{
                                                	if(!isLoading)
                                                    {
                                                    	
                                                    	var eventos=$('#calendar').fullCalendar( 'clientEvents' ,'e_'+gE('idRegistroRecurso').value );
                                                       
                                                        if(eventos.length>0)
                                                        {
                                                        	
                                                        	var fechaInicial=eventos[0].start.format('YYYY-MM-DD HH:mm:ss');
                                                            var dteFechaInicial=Date.parseDate(fechaInicial,'Y-m-d H:i:s');
                                                            var fechaFinal=eventos[0].end.format('YYYY-MM-DD HH:mm:ss');
                                                            var dteFechaFinal=Date.parseDate(fechaFinal,'Y-m-d H:i:s');
                                                            
                                                            var diferenciaDias=0;
                                                            var fInicial=dteFechaInicial.format("Y-m-d");
                                                            
                                                            var fFinal=dteFechaFinal.format("Y-m-d");
                                                            diferenciaDias=obtenerDiasDiferencia(fInicial,fFinal)-1;
                                                            
                                                            eventos[0].start=Date.parseDate(gE('fechaBase').value+' '+dteFechaInicial.format('H:i:s'),'Y-m-d H:i:s');
                                                            eventos[0].end=Date.parseDate(gE('fechaBase').value+' '+dteFechaFinal.format('H:i:s'),'Y-m-d H:i:s');
                                                            
                                                            eventos[0].end.add(Date.DAY,parseInt(diferenciaDias));
                                                            
                                                        	
                                                        }
                                                        else
                                                        {
                                                        	var dteFecha=window.parent.gEx('dteHoraInicial').getValue().format('Y-m-d');
                                                            var dteFechaFinal=window.parent.gEx('dteHoraFinal').getValue().format('Y-m-d');
                                                            var tmeHoraInicio=window.parent.gEx('cmbHoraInicial');
                                                            var tmeHoraFin=window.parent.gEx('cmbHoraFinal');
                                                        	if((dteFecha!='')&&(tmeHoraFin.getValue()!=''))
                                                            {
                                                                var evento=	{};
                                                                evento.id='e_'+gE('idRegistroRecurso').value;
                                                                evento.title='Recurso a reservar';
                                                                evento.allDay=false;
                                                                evento.start=moment(dteFecha+' '+tmeHoraInicio.getValue());
                                                                evento.end=moment(dteFechaFinal+' '+tmeHoraFin.getValue());
                                                                evento.editable=true;
                                                                evento.color='#E16A02';
                                                                $('#calendar').fullCalendar('renderEvent', evento);
                                                             }
                                                        }
                                                       	window.parent.gEx('btnAceptarRecursos').enable();
                                                        
                                                    }
                                                },
                                        dayClick: function(date, jsEvent, view) 
                                        			{
                                                    	var fechaInicio=Date.parseDate(date.format('YYYY-MM-DD HH:mm:ss'),'Y-m-d H:i:s');
                                                        
                                                        var fechaFin=fechaInicio.add(Date.MINUTE,window.parent.lblDuracionRecursoAudiencia);
						
                                                        var eventos=$('#calendar').fullCalendar( 'clientEvents' ,'e_'+gE('idRegistroRecurso').value );
                                                        if(eventos.length==0)
                                                        {
                                                        	var evento=	{};
                                                            evento.id='e_'+gE('idRegistroRecurso').value;
                                                            evento.title='';
                                                            evento.allDay=false;
                                                            evento.start=moment(fechaInicio.format('Y-m-d H:i:s'));
                                                            evento.end=moment(fechaFin.format('Y-m-d H:i:s'));
                                                            evento.editable=true;
                                                            evento.color='#900';
                                                            
                                                            
                                                            
                                                            
                                                           
                                                        }
                                                        else
                                                        {
                                                        	var evento=	eventos[0];
                                                            
                                                            evento.start=moment(fechaInicio.format('Y-m-d H:i:s'));
                                                            evento.end=moment(fechaFin.format('Y-m-d H:i:s'));
                                                            
                                                            
                                                            
                                                            
                                                            
                                                        }
                                                       
                                                       	var traslape=existeTraslape(evento);
                                                        if(traslape)
                                                        {
                                                            function resp()
                                                            {
                                                                
                                                                revertFunc();
                                                            }
                                                            msgBox('Ya existe un evento asignado en el horario que pretende programar',resp);
                                                            return;
                                                        }
                                                        $('#calendar').fullCalendar(eventos.length==0?'renderEvent':'updateEvent', evento);
                                                        
                                                        
                                                        
                                                        window.parent.calcularHoraFinalRecursoAudiencia(fechaInicio.format('H:i'));
                                                        
                                                        
                                                    },

                                        eventDrop: function(event, delta, revertFunc) 
                                        			{
                                                    	
                                                    	var traslape=existeTraslape(event);
														if(traslape)
                                                        {
                                                        	function resp()
                                                            {
                                                            	
                                                            	revertFunc();
                                                            }
                                                            msgBox('Ya existe un evento asignado en el horario que pretende programar',resp);
                                                            return;
                                                        }
														window.parent.ajustarFechaRecursoAudiencia(event);
                                                
                                                
                                                    },
										eventResize: function(event, delta, revertFunc) 
                                        			{
                                                    	
                                                    	var traslape=existeTraslape(event);
                                                    	if(traslape)
                                                        {
                                                        	function resp2()
                                                            {
                                                            	
                                                            	revertFunc();
                                                            }
                                                            msgBox('Ya existe un evento asignado en el horario que pretende programar',resp2);
                                                            return;
                                                        }
                                                    
														window.parent.ajustarFechaRecursoAudiencia(event);
                                                        
                                                        
                                                        
                                                         
                                                    
                                                    },
                                        eventSources: 	[
                                                    		{
                                                            	url:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                                                                type:'POST',
                                                                data:	{
                                                                			tipoRecurso:gE('tipoRecurso').value,
                                                                            idRecurso:gE('idRecurso').value,
                                                                            fechaBase:gE('fechaBase').value,
                                                                            idRegistroRecurso:gE('idRegistroRecurso').value,
                                                                            idEvento:gE('idEvento').value,
                                                                            idUnidadGestion:gE('idUnidadGestion').value,
                                                                            funcion:303
                                                                		}
                                                            }
                                                		]
                                                
             						 }
                               );
}

function existeTraslape(evento)
{

	

	var arrEventos=$('#calendar').fullCalendar( 'clientEvents');
    
    var ev;
    var x;
   	
    for(x=0;x<arrEventos.length;x++)
    {
    	ev=arrEventos[x];
        if((ev.id!=evento.id)&&(ev.rendering!='background')&&(ev.id!='limiteAtencion'))
        {
        	
            if(colisionaTiempo(evento.start.format('YYYY-MM-DD HH:mm:ss'),evento.end.format('YYYY-MM-DD HH:mm:ss'),
    	         ev.start.format('YYYY-MM-DD HH:mm:ss'),ev.end.format('YYYY-MM-DD HH:mm:ss'),false,'Y-m-d H:i:s'))
	        {
               		
                 
                return true;
            }
		}        
        
    }
    return false;
}

function seEncuentraFueraLimites(evento)
{
	return false;
	var arrEventos=$('#calendar').fullCalendar( 'clientEvents','limiteAtencion');
    if(arrEventos.length>0)
    {
    	if(evento.start>=arrEventos[0].start)
        {
        	return true;
        }
    }
    return false;
}



