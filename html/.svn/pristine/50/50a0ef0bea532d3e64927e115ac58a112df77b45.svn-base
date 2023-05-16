<?php
	session_start();

	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");

	$fechaLimite=date("d/m/Y",strtotime("+3 days",strtotime(date("Y-m-d"))));



?>



function inyeccionCodigo()
{
    if(esRegistroFormulario())
    {
		if(gE('idRegistroG').value=='-1')
      	{
        	gEx('f_sp_fechaRecepciondte').setValue('<?php echo $fechaActual?>');
           
            gEx('f_sp_fechaRecepciondte').fireEvent('change', gEx('f_sp_fechaRecepciondte'), gEx('f_sp_fechaRecepciondte').getValue());
            gEx('f_sp_fechaRecepciondte').fireEvent('select', gEx('f_sp_fechaRecepciondte'));
            
            
            gEx('f_sp_horaRecepciontme').setValue('<?php echo $horaActual?>');
           
            gEx('f_sp_horaRecepciontme').fireEvent('change', gEx('f_sp_horaRecepciontme'), gEx('f_sp_horaRecepciontme').getValue());
            gEx('f_sp_horaRecepciontme').fireEvent('select', gEx('f_sp_horaRecepciontme'));
		}    	             
                      
        
       
        
    }
    else
    {
    	//gE('sp_12903').innerHTML='<div style="height:28px; border-width:1px; border-style:solid; border-color:#DDD; width:350px; vertical-align:middle; background-color:#E1FFF0"><table><tr><td><img src="../images/accepted_48.png" width="20" height="20" /></td><td>&nbsp;&nbsp;Dentro de los T&eacute;rminos Permitidos (<?php echo $fechaLimite?>)</td></tr></table></div>';
    	//gE('sp_12903').innerHTML='<div style="height:28px; border-width:1px; border-style:solid; border-color:#DDD; width:350px; vertical-align:middle; background-color:#FFCECE"><table><tr><td><img src="../images/cancel_48.png" width="20" height="20" /></td><td>&nbsp;&nbsp;Fuera de los T&eacute;rminos Permitidos (29/09/2021)</td></tr></table></div>';
    }
}


