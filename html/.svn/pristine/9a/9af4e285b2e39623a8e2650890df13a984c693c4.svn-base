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
										
                                     	header: 
                                        		{
                            		                left: 'prev,next today',
                                                    center: 'title',
                                    	            right: 'agendaDay'
                                    	        },

                                        defaultDate: '<?php echo date("Y-m-d")?>',
                                        defaultView: 'agendaDay',
                                        businessHours: true, // display business hours
                                        editable: true,
                                        eventSources: 	[
                                                    		{
                                                            	url:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                                                                type:'POST',
                                                                data:	{
                                                                			idJuez:gE('idJuez').value,
                                                                            funcion:39
                                                                		}
                                                            }
                                                		]
                                                
             						 }
                               );

}