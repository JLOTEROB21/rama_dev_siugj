<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	
	$fechaActual=date("Y-m-d");
	
	
?>

var fechaActual='<?php echo $fechaActual?>';
function inyeccionCodigo()
{

	if(esRegistroFormulario())
    {
       var x;
        for(x=1;x<7;x++)
        {
        	asignarEvento(gE('opt_tipoDocumentovch_'+x),'click',function(opt)
        							{
                                    	var lblTipoResolucion='';
                                    	switch(opt.value)
                                        {
                                        	case '1':
                                            	lblTipoResolucion='acuerdo';
                                            break;
                                            case '2':
                                            	lblTipoResolucion='audiencia';
                                            break;
                                            case '3':
                                            	lblTipoResolucion='sentencia';
                                            break;
                                            case '4':
                                            	lblTipoResolucion='sentencia interlocutoria';
                                            break;
                                            case '5':
                                            	lblTipoResolucion='sentencia definitiva';
                                            break;
                                            case '6':
                                            	lblTipoResolucion='-1';
                                            break;
                                        }
                                        
	                                    selElemCombo(gE('_tipoResolucionvch'),lblTipoResolucion);
                                    }
        			);      
        	
        }
         
        if(gE('idRegistroG').value=='-1')
        {
        	gEN('_idCarpetaAdministrativavch')[0].value=gEN('_iExpedientevch')[0].value;
        	
        }
         
         gEx('ext__idCarpetaAdministrativavch').disable();
		
         

    }
    else
    {
    	
        
	}
    
    
    
    
    
    
	
}  

