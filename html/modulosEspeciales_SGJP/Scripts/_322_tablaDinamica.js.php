<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	

	
?>
var idEvento=-1;

Ext.onReady(inicializar);


function inicializar()
{
	idEvento=gEN('_idEventovch')[0].value;
    gE('sp_4473').innerHTML='';
    loadScript('../modulosEspeciales_SGJP/Scripts/controlEventos.js.php', function()
    																		{
                                                                            	var objConf={};
                                                                                objConf.idEvento=idEvento;
                                                                                objConf.mostrarCarpetaAsociada=true;
                                                                                objConf.renderTo='sp_4473';
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
                                                                                objConf.mostrarDesarrollo=false;
                                                                                objConf.mostrarDuracionDesarrollo=false;
                                                                                objConf.mostrarHorarioDesarrollo=false;
                                                                                objConf.mostrarDocumentoMultimedia=false;
                                                                            	construirTableroEvento(objConf);
                                                                            }
    			);
    
    gE('_comentariosAdicionalesmem').focus();
    
}

