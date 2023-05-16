<?php
	session_start();

	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$idFormulario=bD($_GET["iF"]);

	$idRegistro=bD($_GET["iR"]);


	$fechaActual=date("Y-m-d")	;

	$horaActual=date("H:i");




?>



function inyeccionCodigo()
{
	gE('sp_11353').innerHTML='';
    if(esRegistroFormulario())
    {
    	             
        asignarEvento(gE('_montoRegistroPagoflo'),'blur',function()
        							{
                                    	convertirMontoPagoLetra();
                                    }
        			);                   
        if(gE('idRegistroG').value=='-1')
        {
            if(gEx('f_sp_fechaRegistroPagodte')) 
            {
             	gEx('f_sp_fechaRegistroPagodte').setValue('<?php echo $fechaActual?>');
             	gEx('f_sp_fechaRegistroPagodte').fireEvent('change', gEx('f_sp_fechaRegistroPagodte'), gEx('f_sp_fechaRegistroPagodte').getValue());

             	gEx('f_sp_fechaRegistroPagodte').fireEvent('select', gEx('f_sp_fechaRegistroPagodte'));
             }

                  	
        }
        else
        {
        	convertirMontoPagoLetra();
        }
        
    }
    else
    {
    	convertirMontoPagoLetra();	
    }
}



function convertirMontoPagoLetra()
{
	var valor=(gE('_montoRegistroPagoflo') && gE('_montoRegistroPagoflo').value)?gE('_montoRegistroPagoflo').value:gE('_montoRegistroPagoflo').innerHTML;
	var arMonto=valor.split('.');
	var parteDecimal=0;
    
    
    if(arMonto.length>1)
    {
    	parteDecimal=parseInt(arMonto[1]);
    }
    
    if(parteDecimal<10)
    {
    	parteDecimal='0'+parteDecimal;
    }
    
	gE('sp_11353').innerHTML='('+covertirNumLetras(parseFloat(normalizarValor(valor)))+' '+parteDecimal+'/100 PESOS)';
}