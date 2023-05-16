<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

Ext.onReady(inicializar);

function inicializar()
{
	
	$('#calendar').fullCalendar(
    								{
										defaultView:'agendaMonth',
                                     	header: 
                                        		{
                            		            	left: '',
                                                    center: 'title',
                                                    right:''
                                    	            
                                    	        },
										
                                        
                                        businessHours: true, // display business hours
                                        editable: true,
                                        loading:function(isLoading,view)
                                        		{
                                                	
                                                },
                                        dayClick: function(date, jsEvent, view) 
                                        			{
                                                    	var fecha=Date.parseDate(date.format('YYYY-MM-DD HH:mm:ss'),'Y-m-d H:i:s');
                                                        
                                                        var eventos=$('#calendar').fullCalendar( 'clientEvents' ,'e_'+gE('idEvento').value );
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
                                                            window.parent.calcularHoraFinal(fecha.format('HH:mm:ss'));
                                                        }
                                                        else
                                                        {
                                                        	window.parent.calcularHoraFinal(fecha.format('H:m:s'));
                                                        }
                                                        
                                                    },

                                        eventDrop: function(event, delta, revertFunc) 
                                        			{
                                                    	
                                                
                                                
                                                    },
										eventResize: function(event, delta, revertFunc) 
                                        			{
                                                    	
                                                        
                                                        
                                                        
                                                         
                                                    
                                                    },
                                        eventSources: 	[
                                                    		{
                                                            	url:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                                                                type:'POST',
                                                                data:	{
                                                                			
                                                                            
                                                                            
                                                                            funcion:16
                                                                		}
                                                            }
                                                		]
                                                
             						 }
                               );
}