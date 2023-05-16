<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
		
?>





function inyeccionCodigo()
{
	if(gE('_citatorioEsperaNotificadorvch'))
		gE('_citatorioEsperaNotificadorvch').setAttribute('val','');
    oE('div_2295');
    oE('div_2296');
    if(gE('_fechaProximaDiligenciadte'))
	   	gE('_fechaProximaDiligenciadte').setAttribute('val','');
    
    if(gE('_horaProximaDiligenciatme'))
    	gE('_horaProximaDiligenciatme').setAttribute('val','');
       
    if(gE('opt_sinoNotificovch_1'))
    {
        asignarEvento(gE('opt_sinoNotificovch_1'),'click',function()
                                                            {
                                                                gE('_citatorioEsperaNotificadorvch').setAttribute('val','');
                                                                oE('div_2295');
                                                                oE('div_2296');
                                                                gE('_citatorioEsperaNotificadorvch').value='0';
                                                                gEx('sp_fechaProximaDiligenciadte').setValue('');
                                                                gE('_fechaProximaDiligenciadte').value='';
                                                                gEx('sp_horaProximaDiligenciatme').setValue('');
                                                                gE('_horaProximaDiligenciatme').value='';
                                                            }
                        );                     
                      
    }
    
    if(gE('opt_sinoNotificovch_0'))
    {                 
        asignarEvento(gE('opt_sinoNotificovch_0'),'click',function()
                                                            {
                                                                var tipoNotificacion=gE('_medioNotificacionvch').options[gE('_medioNotificacionvch').selectedIndex].value;
                                                                
                                                                if(tipoNotificacion=='')
                                                                {
                                                                    gE('_citatorioEsperaNotificadorvch').setAttribute('val','obl');
                                                                    mE('div_2295');
                                                                    mE('div_2296');
                                                                }
                                                                
                                                            }
                        );                     
  	}                                          
    
    if(!esRegistroFormulario())
    {
    	if(gE('sp_2296').innerHTML=='No')
        {
        	oE('sp_2297');
            oE('sp_2299');
        }
    }
    
  
}
