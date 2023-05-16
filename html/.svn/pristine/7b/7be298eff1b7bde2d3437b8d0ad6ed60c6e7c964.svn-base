<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	
	
?>

var idEvento=-1;




function inyeccionCodigo()
{
	idEvento=gEN('_iEventovch')[0].value;
    gE('sp_1972').innerHTML='';
    
    if(gEN('_idPersonavch')[0].value=='0')
    {
    	gE('sp_1968').innerHTML='General';
    }
    
    if(gEN('_tipoFiguravch')[0].value=='0')
    {
    	gE('sp_1969').innerHTML='General';
    }
    if((idEvento!='')&&(idEvento!='-1'))
    {
    
    
        loadScript('../modulosEspeciales_SGJP/Scripts/controlEventos.js.php', function()
                                                                                {
                                                                                    var objConf={};
                                                                                    objConf.idEvento=idEvento;
                                                                                    objConf.renderTo='sp_1972';
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
   
   
}
