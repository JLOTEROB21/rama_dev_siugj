<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$iF=bD($_GET["iF"]);
	$iR=bD($_GET["iR"]);
	
	$consulta="SELECT eventoAudiencia FROM _297_tablaDinamica WHERE  id__297_tablaDinamica=".$iR;	
	$idEvento=$con->obtenerValor($consulta);
	if($idEvento=="")
		$idEvento=-1;
	
?>

var idEvento=<?php echo $idEvento?>;

Ext.onReady(inicializar);

function inicializar()
{
	gE('sp_4702').innerHTML='';
	if(esRegistroFormulario())
    {
    	loadScript	('../modulosEspeciales_SGJP/Scripts/controlEventos.js.php', function()
    																		{
                                                                            	
                                                                            }
					);
    	asignarEvento(gE('_eventoAudienciavch'),'change',function(cmb)
                                                {
                                                	var valor=cmb.options[cmb.selectedIndex].value;
                                                	if(valor=='-1')
                                                    {
                                                    	gE('sp_4702').innerHTML='';
                                                        return;
                                                    }
                                                    
                                                    var objConf={};
                                                    objConf.idEvento=valor;
                                                    objConf.mostrarInfoSituacion=true;
                                                    objConf.renderTo='sp_4702';
                                                    objConf.permiteModificarEdificio=false;  
                                                    objConf.permiteModificarUnidadGestion=false;  
                                                    objConf.permiteModificarSala=false;  
                                                    objConf.permiteModificarFecha=false;
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
                                                    
                                                    var arrFecha=cmb.options[cmb.selectedIndex].text.split(' ');
                                                    
                                                    gEx('f_sp_dteFechadte').setValue(Date.parseDate(arrFecha[0],'d/m/Y').format('Y-m-d'));
                                                    gEx('f_sp_dteFechadte').fireEvent('change', gEx('f_sp_dteFechadte'), gEx('f_sp_dteFechadte').getValue());
                                                    gEx('f_sp_horaLibertadtme').setValue(Date.parseDate(arrFecha[1],'H:i:s').format('H:i'));
                                                    gEx('f_sp_horaLibertadtme').fireEvent('change', gEx('f_sp_horaLibertadtme'), gEx('f_sp_horaLibertadtme').getValue());
                                                }
        			);  
    	
    }
    else
    {
    
    	if(idEvento=='-1')
        	return;
    	loadScript	('../modulosEspeciales_SGJP/Scripts/controlEventos.js.php', function()
    																		{
                                                                            	var objConf={};
                                                                                objConf.idEvento=idEvento;
                                                                                objConf.mostrarInfoSituacion=true;
                                                                                objConf.renderTo='sp_4702';
                                                                                objConf.permiteModificarEdificio=false;  
                                                                                objConf.permiteModificarUnidadGestion=false;  
                                                                                objConf.permiteModificarSala=false;  
                                                                                objConf.permiteModificarFecha=false;        
                                                                                
                                                                                
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
}            