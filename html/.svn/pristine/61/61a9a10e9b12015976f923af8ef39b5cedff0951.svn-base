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
                                        dayClick: function(date, jsEvent, view) 
                                        			{
                                                    	var fecha=Date.parseDate(date.format('YYYY-MM-DD HH:mm:ss'),'Y-m-d H:i:s');                                                        
                                                        var eventos=$('#calendar').fullCalendar( 'clientEvents' ,'e_'+gE('idEvento').value );
                                                        
                                                       	duracionAudiencia=(eventos[0].end-eventos[0].start+0)/60000;
                                                        if(eventos.length==0)
                                                        {
                                                        	var evento=	{};
                                                            evento.id='';
                                                            evento.title='';
                                                            evento.allDay=false;
                                                            evento.start=fecha;
                                                            evento.end=fecha;
                                                            evento.editable=true;
                                                            evento.color='#900';
                                                            $('#calendar').fullCalendar('renderEvent', evento);                                                            
                                                        }
                                                        else
                                                        {
                                                        	var evento=eventos[0];
                                                            evento.start=date;
                                                            evento.end=fecha.add(Date.MINUTE,duracionAudiencia);
                                                        	$('#calendar').fullCalendar('updateEvent', evento);        
                                                            
                                                            
                                                            
                                                        }
                                                        
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
                                                            msgBox('Ya existe un evento asignado en el horario que pretende proponer',resp);
                                                            return;
                                                        }
														//window.parent.ajustarFechaEvento(event);
                                                
                                                
                                                    },
										eventResize: function(event, delta, revertFunc) 
                                        			{
                                                    	revertFunc();
                                                    	
                                                    
														//window.parent.ajustarFechaEvento(event);
                                                        
                                                        
                                                        
                                                         
                                                    
                                                    },
                                        eventSources: 	[
                                                    		{
                                                            	url:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                                                                type:'POST',
                                                                data:	{
                                                                			idSala:gE('idSala').value,
                                                                            iEvento:gE('idEvento').value,
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