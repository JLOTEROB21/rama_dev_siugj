<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

var cadenaFuncionValidacion='validarFechaPeriodo';

function validarFechaPeriodo()
{
	var fInicio =gEx('f_sp_periodoIniciodte');
    var fFin =gEx('f_sp_periodoFindte');

	if(fInicio.getValue()>fFin.getValue())
    {
    	function resp()
        {
        	fInicio.focus();
        }
        
    	msgBox('El periodo de asignaci&oacute;n de inicio NO puede ser mayor que el periodo de t&eacute;rmino',resp);
    	return false;
    }
    
    return true;
}
