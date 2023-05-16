<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	
?>

var tipoMateria='<?php echo $tipoMateria ?>';
var idEvento=-1;

Ext.onReady(inicializar);


function inicializar()
{
	idEvento=gE('iEvento').value;
    loadScript('../modulosEspeciales_SGJP/Scripts/controlEventos.js.php', function()
    																		{
                                                                            	var objConf={};
                                                                                objConf.idEvento=idEvento;
                                                                                objConf.renderTo='tblFechaAudiencia';
                                                                                objConf.mostrarInfoSituacion=true;
                                                                                objConf.mostrarIDEvento=true;
                                                                                objConf.permiteModificarEdificio=false;  
                                                                                objConf.permiteModificarUnidadGestion=false;  
                                                                                objConf.permiteModificarSala=false;  
                                                                                objConf.permiteModificarFecha=false;  
                                                                                objConf.mostrarEspecificacionesEspeciales=false; 
                                                                                objConf.mostrarAsignacionAuxiliar=false; 
                                                                                if(gE('sL').value=='0')
                                                                                {
                                                                                	objConf.permiteModificarJuez=true;
                                                                                	objConf.permiteModificarSala=true;
                                                                                	objConf.permiteModificarFecha=true;
                                                                                	objConf.permiteModificarTipoAudiencia=true;
                                                                                    objConf.permiteModificarRecurso=<?php echo $tipoMateria=="P"?"true":"false"?>;
                                                                                }
                                                                                else
                                                                                {
                                                                                	objConf.permiteModificarJuez=false;
                                                                                    objConf.permiteModificarRecurso=<?php echo $tipoMateria=="P"?"true":"false"?>;
                                                                                }
                                                                                	
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
                                                                                if(tipoMateria!='P')
                                                                                {
                                                                                	objConf.mostrarEspecificacionesEspeciales=false; 
                                                                                    objConf.mostrarAsignacionAuxiliar=false; 
                                                                                }
                                                                            	construirTableroEvento(objConf);
                                                                                
                                                                            }
    			);
    
	
    
  
    
}