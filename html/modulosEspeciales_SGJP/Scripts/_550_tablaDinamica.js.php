<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);
		
?>	

function inyeccionCodigo()
{
	
	if(esRegistroFormulario())
    {
    	asignarEvento(gE('opt_nivelMIRvch_1'),'click',function()
                                        {
                                           gE('sp_9277').innerHTML='Fin con el cual se asocia:';
                                        }
                        );
		
        asignarEvento(gE('opt_nivelMIRvch_2'),'click',function()
                                        {
                                           gE('sp_9277').innerHTML='Fin con el cual se asocia:';
                                        }
                        );     
		asignarEvento(gE('opt_nivelMIRvch_4'),'click',function()
                                        {
                                           gE('sp_9277').innerHTML='Componente con el cual se asocia:';
                                        }
                        );  
		
        asignarEvento(gE('opt_nivelMIRvch_4'),'click',function()
                                        {
                                           gE('sp_9277').innerHTML='Componente con el cual se asocia:';
                                        }
                        );                                                                     
    }
    else
    {
    	switch(gE('sp_8464').innerHTML)
        {
        	case 'Fin':
        	case 'Fin/Propósito':
            	oE('div_9278');
                oE('div_9283');
                oE('div_9284');
            break;
            case 'Componente':
            	oE('div_9282');                
                oE('div_9284');
               	oE('div_9278'); 
            break;
        	case 'Actividad':
            	oE('div_9282');                
                
            break;
            case 'Propósito':
            	oE('div_9278');
                oE('div_9282');
                oE('div_9283');
                oE('div_9277');
                oE('div_9284');
            break;
        }
    }
    
    
     gEx('grid_8482').getColumnModel().setRenderer(0,function(val,meta,registro)
                                            {
                                            	meta.attr='style="min-height:21px; height:auto;white-space:normal;"';
                                                return mostrarValorDescripcion(val);
                                            }
    								);
                                    
	gEx('grid_8484').getColumnModel().setRenderer(0,function(val,meta,registro)
                                            {
                                            	meta.attr='style="min-height:21px; height:auto;white-space:normal;"';
                                                return mostrarValorDescripcion(val);
                                            }
    								);                                    
    
    
    gEx('grid_9281').getColumnModel().setRenderer(0,function(val,meta,registro)
                                            {
                                            	meta.attr='style="min-height:21px; height:auto;white-space:normal;"';
                                                return mostrarValorDescripcion(val);
                                            }
    								); 
	 gEx('grid_9281').getColumnModel().setRenderer(1,function(val,meta,registro)
                                            {
                                            	meta.attr='style="min-height:21px; height:auto;white-space:normal;"';
                                                return mostrarValorDescripcion(val);
                                            }
    								); 
	 gEx('grid_9281').getColumnModel().setRenderer(2,function(val,meta,registro)
                                            {
                                            	meta.attr='style="min-height:21px; height:auto;white-space:normal;"';
                                                return mostrarValorDescripcion(val);
                                            }
    								);                                         
}	
