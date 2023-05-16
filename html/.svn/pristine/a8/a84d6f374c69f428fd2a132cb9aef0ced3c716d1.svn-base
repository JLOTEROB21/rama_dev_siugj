<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
?>


function inyeccionCodigo()
{
	if(esRegistroFormulario())
    {
    	
        asignarEvento(gE('opt_tipoValorvch_1'),'click',function()
                                        {
                                           gE('sp_9122').innerHTML='Instituci&oacute;n Financiera:';
                                        }
                        );
        
        asignarEvento(gE('opt_tipoValorvch_2'),'click',function()
                                        {
                                            gE('sp_9122').innerHTML='Nombre de la afianzadora:';
                                        }
                        );
                        
       	asignarEvento(gE('opt_tipoValorvch_3'),'click',function()
                                        {
                                            gE('sp_9122').innerHTML='';
                                        }
                        );                 
        
    	if(gE('idRegistroG').value=='-1')
        {
        	if(gEx('f_sp_fechaRecepciondte'))
            {
             	gEx('f_sp_fechaRecepciondte').setValue('<?php echo $fechaActual?>');
             
             	gEx('f_sp_fechaRecepciondte').fireEvent('change', gEx('f_sp_fechaRecepciondte'), gEx('f_sp_fechaRecepciondte').getValue());
             	gEx('f_sp_fechaRecepciondte').fireEvent('select', gEx('f_sp_fechaRecepciondte'));
             }
             if(gEx('f_sp_horaRecepciontme'))
             {
	             gEx('f_sp_horaRecepciontme').setValue('<?php echo $horaActual?>');
             	gEx('f_sp_horaRecepciontme').fireEvent('change', gEx('f_sp_horaRecepciontme'), gEx('f_sp_horaRecepciontme').getValue());
             }
         }
	}
    else
    {
    	if(gE('sp_9131').innerHTML=='Billete de depósito')
        {
        	 gE('sp_9122').innerHTML='Instituci&oacute;n Financiera:';
        }
        else
        {
            if(gE('sp_9131').innerHTML=='Fianza')
            {
                 gE('sp_9122').innerHTML='Nombre de la afianzadora:';
            }
            else
            {
            	oE('div_9122');
                oE('div_9137');
            }
        }
                
        if(gE('sp_9141').innerHTML=='No')
        {
        	oE('div_9142');
            oE('div_9144');
            oE('div_9143');
            oE('div_9145');
        }
    }
}

