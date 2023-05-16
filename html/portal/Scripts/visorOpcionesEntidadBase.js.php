<?php session_start();
	include("configurarIdiomaJS.php");
?>

Ext.onReady(inicializar);

function inicializar()
{

	$('#container').masonry({
      itemSelector: '.cBox',
      columnWidth:250
    });	
}