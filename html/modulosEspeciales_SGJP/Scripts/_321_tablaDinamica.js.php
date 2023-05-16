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
    gE('sp_4469').innerHTML='';
    loadScript('../modulosEspeciales_SGJP/Scripts/controlEventos.js.php', function()
    																		{
                                                                            	var objConf={};
                                                                                objConf.idEvento=idEvento;
                                                                                objConf.mostrarCarpetaAsociada=true;
                                                                                objConf.renderTo='sp_4469';
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
    
    
    
}


function afterLoadEvent(objDatosAudiencia)
{

	var horaTermino=Date.parseDate(objDatosAudiencia.horaFin,'Y-m-d H:i:s');
	gEx('f_sp_fechaFinalizaciondte').setValue(horaTermino.format('Y-m-d'));
	gEx('f_sp_fechaFinalizaciondte').fireEvent('change', gEx('f_sp_fechaFinalizaciondte'), gEx('f_sp_fechaFinalizaciondte').getValue());
    gEx('f_sp_horaTerminotme').setValue(horaTermino.format('H:i'));
    gEx('f_sp_horaTerminotme').fireEvent('change', gEx('f_sp_horaTerminotme'), gEx('f_sp_horaTerminotme').getValue());
    gEx('f_sp_horaTerminotme').focus();
    
}