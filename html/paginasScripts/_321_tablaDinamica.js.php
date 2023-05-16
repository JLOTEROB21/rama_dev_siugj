<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	

	
?>
var idEvento=-1;
var oAudiencia=null;
Ext.onReady(inicializar);


function inicializar()
{
	idEvento=gEN('_idEventovch')[0].value;
    gE('sp_4469').innerHTML='';
    loadScript('../modulosEspeciales_SGJ/Scripts/controlEventos.js.php', function()
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
	oAudiencia=objDatosAudiencia;
	tablaReemplazo=gE('sp_4469').innerHTML.replace('No. Expediente','Proceso Judicial');
    tablaReemplazo=tablaReemplazo.replace('Juzgado','Despacho');
    tablaReemplazo=tablaReemplazo.replace('Edificio sede','Sede');
   	
    gE('sp_4469').innerHTML=tablaReemplazo;
    
    
    gEx('f_sp_fechaFinalizaciondte').setValue(oAudiencia.fechaEvento);
             
    gEx('f_sp_fechaFinalizaciondte').fireEvent('change', gEx('f_sp_fechaFinalizaciondte'), gEx('f_sp_fechaFinalizaciondte').getValue());
    gEx('f_sp_fechaFinalizaciondte').fireEvent('select', gEx('f_sp_fechaFinalizaciondte'));


    gEx('f_sp_cmbHoraInicioAudienciatme').setValue(Date.parseDate(oAudiencia.horaInicio,'Y-m-d H:i:s').format('H:i'));
    gEx('f_sp_cmbHoraInicioAudienciatme').fireEvent('change', gEx('f_sp_cmbHoraInicioAudienciatme'), gEx('f_sp_cmbHoraInicioAudienciatme').getValue());
    
    gEx('f_sp_cmbHoraFinAudienciatme').setValue(Date.parseDate(oAudiencia.horaFin,'Y-m-d H:i:s').format('H:i'));
    gEx('f_sp_cmbHoraFinAudienciatme').fireEvent('change', gEx('f_sp_cmbHoraFinAudienciatme'), gEx('f_sp_cmbHoraFinAudienciatme').getValue());
}
    
