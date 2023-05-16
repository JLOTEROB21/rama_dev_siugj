<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

var idEvento=-1;
Ext.onReady(inicializar);

function inicializar()
{
	idEvento=gE('idEvento').value;
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
                                                    	
                                                    	var eventos=$('#calendar').fullCalendar( 'clientEvents' ,'e_'+gE('idEvento').value );
                                                       
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
                                                            
                                                            //var registro=$('#calendar').fullCalendar('.', eventos[0]);
                                                           
                                                            
                                                        	
                                                        }
                                                        else
                                                        {
                                                        	var dteFecha=window.parent.gEx('dteFecha');
                                                            var tmeHoraInicio=window.parent.gEx('tmeHoraInicio');
                                                            var tmeHoraFin=window.parent.gEx('tmeHoraFin');
                                                        	if((dteFecha.getValue()!='')&&(tmeHoraFin.getValue()!=''))
                                                            {
                                                                var evento=	{};
                                                                evento.id='e_'+gE('idEvento').value;
                                                                evento.title='';
                                                                evento.allDay=false;
                                                                evento.start=moment(dteFecha.getValue().format('Y-m-d')+' '+tmeHoraInicio.getValue());
                                                                evento.end=moment(dteFecha.getValue().format('Y-m-d')+' '+tmeHoraFin.getValue());
                                                                evento.editable=true;
                                                                evento.color='#900';
                                                                $('#calendar').fullCalendar('renderEvent', evento);
                                                             }
                                                        }
                                                       	
                                                        
                                                    }
                                                },
                                        dayClick: function(date, jsEvent, view) 
                                        			{
                                                    	var fechaInicio=Date.parseDate(date.format('YYYY-MM-DD HH:mm:ss'),'Y-m-d H:i:s');
                                                        var fechaFin=fechaInicio.add(Date.MINUTE,window.parent.lblDuracionAudiencia);
						
                                                        var eventos=$('#calendar').fullCalendar( 'clientEvents' ,'e_'+gE('idEvento').value );
                                                        if(eventos.length==0)
                                                        {
                                                        	var evento=	{};
                                                            evento.id='e_'+gE('idEvento').value;
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
                                                        
                                                        
                                                        
                                                        window.parent.calcularHoraFinal(fechaInicio.format('H:i'));
                                                        
                                                        
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
														window.parent.ajustarFechaEvento(event);
                                                
                                                
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
                                                    
														window.parent.ajustarFechaEvento(event);
                                                        
                                                        
                                                        
                                                         
                                                    
                                                    },
                                        eventSources: 	[
                                                    		{
                                                            	url:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                                                                type:'POST',
                                                                data:	{
                                                                			idSala:gE('idSala').value,
                                                                            iEvento:gE('idEvento').value,
                                                                            idJueces:gE('idJueces').value,
                                                                            iU:gE('idUnidadGestion').value,
                                                                            visualizarAgendaRecursos:gE('visualizarAgendaRecursos').value,
                                                                            lRecursos:gE('lRecursos').value,
                                                                            funcion:16
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



