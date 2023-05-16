<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

function actualizarEntregaCopias()
{

    window.parent.regresar1Pagina();
	window.parent.gEx('tblCenter').reload();
    
}

