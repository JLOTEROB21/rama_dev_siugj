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

	if(esRegistroFormulario())
    {
    	asignarEvento(gE('opt_realizoAudienciavch_1'),'click',function(control)
                                                                        {
                                                                          	if(control.checked)
                                                                            {	
                                                                            	gEx('f_sp_fechaAudienciadte').setValue(oAudiencia.fechaEvento);
             
                                                                                gEx('f_sp_fechaAudienciadte').fireEvent('change', gEx('f_sp_fechaAudienciadte'), gEx('f_sp_fechaAudienciadte').getValue());
                                                                                gEx('f_sp_fechaAudienciadte').fireEvent('select', gEx('f_sp_fechaAudienciadte'));
                                                                            
                                                                            
                                                                            	gEx('f_sp_cmbHoraInicioAudienciatme').setValue(Date.parseDate(oAudiencia.horaInicio,'Y-m-d H:i:s').format('H:i'));
             																	gEx('f_sp_cmbHoraInicioAudienciatme').fireEvent('change', gEx('f_sp_cmbHoraInicioAudienciatme'), gEx('f_sp_cmbHoraInicioAudienciatme').getValue());
                                                                                
                                                                                gEx('f_sp_cmbHoraFinAudienciatme').setValue(Date.parseDate(oAudiencia.horaFin,'Y-m-d H:i:s').format('H:i'));
             																	gEx('f_sp_cmbHoraFinAudienciatme').fireEvent('change', gEx('f_sp_cmbHoraFinAudienciatme'), gEx('f_sp_cmbHoraFinAudienciatme').getValue());
                                                                            }
                                                                        }
                                                        ); 
    }
    else
    {
    	if(gE('sp_10758').innerHTML!='Si')
        {
        	oE('div_10757');
            oE('div_10759');
            oE('div_10760');
            oE('div_10761');
            oE('div_10762');
        }
        
        if(gE('sp_10755').innerHTML!='Aplazar Audiencia')
        {
        	oE('div_10756');
        	oE('div_10757');
            oE('div_10758');
            oE('div_10759');
            oE('div_10760');
            oE('div_10761');
            oE('div_10762');
        }
    }
    
	

	idEvento=gEN('_idEventovch')[0].value;
    gE('sp_4485').innerHTML='';
    loadScript('../modulosEspeciales_SGJ/Scripts/controlEventos.js.php', function()
    																		{
                                                                            	var objConf={};
                                                                                objConf.idEvento=idEvento;
                                                                                objConf.mostrarCarpetaAsociada=true;
                                                                                objConf.renderTo='sp_4485';
                                                                                objConf.permiteModificarEdificio=false;  
                                                                                objConf.permiteModificarUnidadGestion=false;  
                                                                                objConf.permiteModificarSala=false;  
                                                                                objConf.permiteModificarFecha=false;    
                                                                                objConf.permiteModificarJuez=false;                                                                               
                                                                                objConf.mostrarFechaAudiencia=true;
                                                                                objConf.mostrarTipoAudiencia=true;
                                                                                objConf.mostrarDuracionAudiencia=true;
                                                                                objConf.mostrarSalaAudiencia=false;
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


function afterLoadEvent(objDatosAudiencia)
{
	oAudiencia=objDatosAudiencia;
	tablaReemplazo=gE('sp_4485').innerHTML.replace('No. Expediente','Proceso Judicial');
    tablaReemplazo=tablaReemplazo.replace('Juzgado','Despacho');
    tablaReemplazo=tablaReemplazo.replace('Edificio sede','Sede');
   	
    gE('sp_4485').innerHTML=tablaReemplazo;
}
