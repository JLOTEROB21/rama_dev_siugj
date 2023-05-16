<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$fechaActual=date("Y-m-d")	;
	
	
	
?>





function inyeccionCodigo()
{
	if(esRegistroFormulario())
    {
		gEx('f_sp_fechaSentenciadte').setValue('<?php echo $fechaActual?>');
        gEx('f_sp_fechaSentenciadte').fireEvent('change', gEx('f_sp_fechaSentenciadte'), gEx('f_sp_fechaSentenciadte').getValue());
        gEx('f_sp_fechaSentenciadte').fireEvent('select', gEx('f_sp_fechaSentenciadte'));
	}
   
}  
