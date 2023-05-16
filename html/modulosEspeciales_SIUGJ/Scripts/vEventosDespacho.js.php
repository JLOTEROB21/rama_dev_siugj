<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
?>
mostrarAllDay=true;
Ext.onReady(inicializar);

function inicializar()
{
	$('#calendar').fullCalendar(
    								{
										defaultView:'agendaWeek',
                                        allDayDefault:true,
                                     	header: 
                                        		{
                                                	left: '',
                            		            	center: '',
                                                    right:'agendaWeek,agendaDay'
                                    	        },
										
                                        businessHours: true, // display business hours
                                        editable: true,
                                        defaultDate: '<?php echo date("Y-m-d")?>',
										contentHeight:'auto',
                                        loading:function(isLoading,view)
                                        		{
                                                	if(!isLoading)
                                                    {
                                                    	
                                                       	
                                                        
                                                    }
                                                },
                                        
                                        eventClick: function(calEvent, jsEvent, view) 
                                        			{
                                                    	abrirProcesoJudicial(bE(calEvent.carpetaAdministrativa));
                                                    },
                                        eventRender: function(event, element) 
                                                			{
																
                                                              	element.bind('dblclick', function(e) 
                                                              							{
                                                                                        	
                                                                                            
							                                                              }
                                                                           );        
                                                            },
                                        
                                        eventSources: 	[
                                                    		{
                                                            	url:'../paginasFunciones/funcionesModulosEspeciales_MacroProcesos.php',
                                                                type:'POST',
                                                                data:	{
                                                                            funcion:30
                                                                		}
                                                            }
                                                		]
                                                
             						 }
					);
    
}

function abrirProcesoJudicial(cA)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJ/tableroAudienciaAdministracion.php';
    obj.params=[['cA',(cA)],['idCarpetaAdministrativa',-1]];
    obj.titulo='Proceso Judicial: '+bD(cA);
    
    abrirVentanaFancySuperior(obj)

}