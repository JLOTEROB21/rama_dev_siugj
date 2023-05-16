<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>
Ext.onReady(inicializar);

function inicializar()
{

	loadScript('../modulosEspeciales_SGJ/Scripts/controlEventos.js.php', function()
    																		{
                                                                            	
                                                                            	var objConf={};
                                                                                objConf.idEvento=gE('idEvento').value;
                                                                                objConf.renderTo='divAudiencia';
                                                                                objConf.permiteModificarTipoAudiencia=false;
                                                                                objConf.permiteModificarHorarioDesarrollo=false;
                                                                                objConf.mostrarDesarrollo=false;
                                                                                objConf.permiteModificarEdificio=false;  
                                                                                objConf.permiteModificarUnidadGestion=false;  
                                                                                objConf.permiteModificarSala=false;  
                                                                                objConf.permiteModificarFecha=false;    
                                                                                objConf.permiteModificarJuez=false;                                                                               
                                                                                objConf.mostrarFechaAudiencia=true;
                                                                                objConf.mostrarTipoAudiencia=true;
                                                                                objConf.mostrarDuracionAudiencia=true;
                                                                                objConf.mostrarSalaAudiencia=true;
                                                                                objConf.mostrarCentroGestion=true;
                                                                                objConf.mostrarEdificio=true;
                                                                                objConf.mostrarJueces=true;
                                                                                objConf.mostrarDuracionDesarrollo=false;
                                                                                objConf.mostrarHorarioDesarrollo=false;
                                                                                objConf.mostrarDocumentoMultimedia=false;
                                                                               
                                                                               
                                                                            	construirTableroEvento(objConf);
                                                                            }
			)   
}