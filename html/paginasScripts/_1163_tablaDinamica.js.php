<?php
	session_start();

	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$idFormulario=bD($_GET["iF"]);

	$idRegistro=bD($_GET["iR"]);


	$fechaActual=date("Y-m-d")	;

	$horaActual=date("H:i");

	$idActividad=-1;
	
	if($idRegistro==-1)
		$idActividad=generarIDActividad($idFormulario);
	



?>


var idActividad=<?php echo $idActividad?>;

function inyeccionCodigo()
{
	if(esRegistroFormulario())
    {
    	if(gE('idRegistroG').value=='-1')
            gEN('_idActividadvch')[0].value=idActividad;
        else
            idActividad=gEN('_idActividadvch')[0].value;
            
        
        gEx('grid_15225').getColumnModel().setEditor(1, new Ext.form.DateField ({maxValue:'<?php echo date("Y-m-d")?>'})
        												);    
            
            
    }

	gEx('grid_15225').getColumnModel().setRenderer(0,function(val)
        												{
                                                        	return val;
                                                        }
        												);
                                                        
	                                                        
	
}

