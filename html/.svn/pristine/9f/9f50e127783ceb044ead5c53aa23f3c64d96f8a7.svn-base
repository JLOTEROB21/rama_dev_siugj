<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$iF=bD($_GET["iF"]);
	$iR=bD($_GET["iR"]);
	
	$consulta="SELECT eventoAudiencia FROM _294_tablaDinamica WHERE  id__294_tablaDinamica=".$iR;	
	$idEvento=$con->obtenerValor($consulta);
	if($idEvento=="")
		$idEvento=-1;
	
?>


var idEvento=<?php echo $idEvento?>;


            
Ext.onReady(inicializar);

function inicializar()
{
	gE('sp_4727').innerHTML='';
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
                                                    	gE('sp_4727').innerHTML='';
                                                        return;
                                                    }
                                                    
                                                    var objConf={};
                                                    objConf.idEvento=valor;
                                                    objConf.mostrarInfoSituacion=true;
                                                    objConf.renderTo='sp_4727';
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
    else
    {
    
    	if(idEvento=='-1')
        	return;
    	loadScript	('../modulosEspeciales_SGJP/Scripts/controlEventos.js.php', function()
    																		{
                                                                            	var objConf={};
                                                                                objConf.idEvento=idEvento;
                                                                                objConf.mostrarInfoSituacion=true;
                                                                                objConf.renderTo='sp_4727';
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