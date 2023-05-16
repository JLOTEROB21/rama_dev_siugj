<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

var idEvento=-1;
Ext.onReady(inicializar);

function inicializar()
{

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
                                                    	
                                                       	
                                                        
                                                    }
                                                },
                                        dayClick: function(date, jsEvent, view) 
                                        			{
                                                    	
                                                        
                                                        
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
                                                                			idSala:gE('idSala').value,
                                                                            asignacionJuez:gE('asignacionJuez').value,
                                                                            funcion:189
                                                                		}
                                                            }
                                                		]
                                                
             						 }
                               );
}

