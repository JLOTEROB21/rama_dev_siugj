<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
?>
var selEvento=-1;
var arrEventosMarcados=[];

var minutosDesplazamiento=0;
var dragged_event;
Ext.onReady(inicializar);

function inicializar()
{
	
    
    $('#calendar').fullCalendar(
    								{
										defaultView:'agendaDay',
                                     	header: 
                                        		{
                                                	left: '',
                            		            	right:'month,agendaWeek,agendaDay'
                                    	        },
										scrollTime:'<?php echo date("H:i:s")?>',
                                        contentHeight:'auto',
                                        defaultDate: '<?php echo date("Y-m-d")?>',
                                        businessHours: true, 
                                        editable: true,
                                        loading:function(isLoading,view)
                                        		{
                                                	if(!isLoading)
                                                    {
                                                    	marcarEventosSelecionados(selEvento);
                                                            selEvento=-1;
                                                    	
                                                       	
                                                        
                                                    }
                                                },
                                        
                                        
                                        eventRender: function(event, element) 
                                                			{
																
                                                              	element.bind('dblclick', function(e) 
                                                              							{
                                                                                        	var arrID=event.id.split('_');
                                                                                            mostrarDatosEventoAudiencia(arrID[1]);
                                                                                            
							                                                              }
                                                                           );        
                                                            },
                                        
                                        eventSources: 	[
                                                    		{
                                                            	url:'../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',
                                                                type:'POST',
                                                                data:	{
                                                                			tipoVista:1,
                                                                            idReferencia:gE('idUsr').value,
                                                                            funcion:21
                                                                            
                                                                            
                                                                		}
                                                            }
                                                		]
                                                
             						 }
					);
    
    
    
	new Ext.Button (
    
						{
                            icon:'../principalPortal/imagesSIUGJ/impresoraWhite.png',
                            cls:'x-btn-text-icon',
                            text:'&nbsp;&nbsp;&nbsp;&nbsp;Imprimir',
                            renderTo:'divImprimir',
                            width:140,
                            height:45,
                            cls:'btnSIUGJ',
                            handler:function()
                                    {
                                     	print();   
                                    }
                            
                        }   
                   	)
                    
                    
	new Ext.Button (
    
						{
                            icon:'../principalPortal/imagesSIUGJ/lupaBusqueda.png',
                            cls:'x-btn-text-icon',
                            text:'&nbsp;&nbsp;&nbsp;&nbsp;Buscar audiencia',
                            renderTo:'divBuscar',
                            width:140,
                            height:47,
                            cls:'btnSIUGJCancel',
                            handler:function()
                                    {
                                     	window.parent.mostrarVentanaBuscarEvento();
                                    }
                            
                        }   
                   	)  

}


function mostrarDatosEventoAudiencia(iE)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJ/pDatosAudiencia.php';
    obj.params=[['idEvento',iE],['cPagina','sFrm=true']];
    window.parent.parent.abrirVentanaFancy(obj);
}




function selectEvento(iE,f)
{
	selEvento=iE;
	$('#calendar').fullCalendar( 'changeView', 'agendaDay');
    $('#calendar').fullCalendar( 'gotoDate', Date.parseDate(f,'Y-m-d H:i:s').format('Y-m-d'));
    
}



function marcarEventosSelecionados(e)
{
	desmarcarEventosSelecionados();
	var arrEventos=e.split(',');
    var x;
    var y;
    var evento;
    var oEstilo;
    var oEstilo2;
    var arrEstilos;
    var oAtributo;
    var strAtributo;
    var arrAtributos='';
    var nuevoEstilo='';
    for(x=0;x<arrEventos.length;x++)
    {
    	oEstilo2={};
    	evento=gE('frame_'+arrEventos[x]);
        if(!evento)
        	continue;
      	arrEstilos=evento.getAttribute('style').split(';');
        for(y=0;y<arrEstilos.length;y++)
        {
        	if(arrEstilos[y]!='')
            {
                oAtributo=arrEstilos[y].split(':');
                strAtributo='"'+oAtributo[0].trim()+'":"'+cv(oAtributo[1].trim(),false,true)+'",';
                arrAtributos+=strAtributo;
			}            
        }
        
        oEstilo=eval('[{'+arrAtributos.replace(',}','}')+'}]')[0];
        
        arrEventosMarcados.push([arrEventos[x],oEstilo,evento]);
        
        for(campo in oEstilo)
    	{
        	oEstilo2[campo]=oEstilo[campo];
    	}
        
        oEstilo2['border-width']='4px  !important';
        oEstilo2['border-color']='#0009FF  !important';
        nuevoEstilo='';
        for(campo in oEstilo2)
    	{
        	nuevoEstilo+=campo+':'+oEstilo2[campo]+';';
    	}
        
        evento.setAttribute('style',nuevoEstilo);
        
        
    }
}

function desmarcarEventosSelecionados()
{
	var x;
    var y;
    var oEvento;
    
    for(x=0;x<arrEventosMarcados.length;x++)
    {
    	oEvento=arrEventosMarcados[x];
        nuevoEstilo='';
        for(campo in oEvento[1])
    	{
        	nuevoEstilo+=campo+':'+oEvento[1][campo]+';';
    	}
        
        oEvento[2].setAttribute('style',nuevoEstilo);
    }
    arrEventosMarcados=[];
}
