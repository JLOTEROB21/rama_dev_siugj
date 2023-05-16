<?php
	session_start();

	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$idFormulario=bD($_GET["iF"]);

	$idRegistro=bD($_GET["iR"]);


	$fechaActual=date("Y-m-d")	;

	$horaActual=date("H:i");

	$idActividad=-1;
	
	if($idRegistro==-1)
		$idActividad=generarIDActividad($idFormulario);

	$salarioMinimo=obtenerSalarioMinimo_SIUGJ(date("Y-m-d"));
	if($salarioMinimo=="")
		$salarioMinimo=0;
?>

var smdProceso=20;
var cadenaFuncionValidacion='validaRadicacion';
var salarioMinimo=parseFloat(normalizarValor('<?php echo $salarioMinimo?>'));
var idActividad=<?php echo $idActividad?>;

function inyeccionCodigo()
{
	gE('sp_11305').innerHTML='';
    if(esRegistroFormulario())
    {
    
    	asignarEvento(gE('_tipoProcesovch'),'change',function(cmb)
        							{
                                    	var opcion=cmb.options[cmb.selectedIndex].value;
                                        
                                        
                                        switch(opcion)
                                        {
                                        	case '20':
                                            	mE('div_14750');
                                                gE('sp_14750').innerHTML='Los procesos ordinarios laborales de única instancia, son aquellos que no exceden de 20 SMMLV';
                                            break;
                                            case '1':
                                            	mE('div_14750');
                                                gE('sp_14750').innerHTML='Los procesos ordinarios laborales de primera instancia, son aquellos que exceden de 20 SMMLV';
                                            break;
                                            default:
                                            	oE('div_14750');
                                            break;
                                        }
                                        
                                       
                                        
                                        if((opcion=='5')||(opcion=='17'))
                                        {
                                        	oE('div_11057');
                                            oE('div_11086');
                                            oE('div_11305');
                                            gE('_cuantiaProcesoflo').setAttribute('val','');
                                        }
                                        else
                                        {
                                        	mE('div_11057');
                                            mE('div_11086');
                                            mE('div_11305');
                                            gE('_cuantiaProcesoflo').setAttribute('val','obl|flo');
                                        }
                                    }
        			);
    
    	asignarEvento(gE('_cuantiaProcesoflo'),'blur',function()
        							{
                                    	convertirCuantiaLetra();
                                    }
        			);                     
                        
        if(gE('idRegistroG').value=='-1')
        {
            if(gEx('f_sp_fechadeRecepciondte')) 
            {
             	gEx('f_sp_fechadeRecepciondte').setValue('<?php echo $fechaActual?>');
             	gEx('f_sp_fechadeRecepciondte').fireEvent('change', gEx('f_sp_fechadeRecepciondte'), gEx('f_sp_fechadeRecepciondte').getValue());

             	gEx('f_sp_fechadeRecepciondte').fireEvent('select', gEx('f_sp_fechadeRecepciondte'));
             }

             if(gEx('f_sp_horadeRecepciontme'))
             {
	            gEx('f_sp_horadeRecepciontme').setValue('<?php echo $horaActual?>');
             	gEx('f_sp_horadeRecepciontme').fireEvent('change', gEx('f_sp_horadeRecepciontme'), gEx('f_sp_horadeRecepciontme').getValue());
             }   
             
             
                  	
        }
        else
        {
        	var opcion=gE('_tipoProcesovch').options[gE('_tipoProcesovch').selectedIndex].value;

        	if(opcion=='20')
            {
                mE('div_14750');
               	gE('sp_14750').innerHTML='Los procesos ordinarios laborales de única instancia, son aquellos que no exceden de 20 SMMLV';
            }
            
            if(opcion=='1')
            {
                mE('div_14750');
                gE('sp_14750').innerHTML='Los procesos ordinarios laborales de primera instancia, son aquellos que exceden de 20 SMMLV';
            }
        	convertirCuantiaLetra();
        }
        
        if(gE('idRegistroG').value=='-1')
            gEN('_idActividadvch')[0].value=idActividad;
        else
            idActividad=gEN('_idActividadvch')[0].value;
        
    	<?php
		if(existeRol("'23_0'"))
		{
		?>
            gEx('f_sp_fechadeRecepciondte').disable();
            gEx('f_sp_horadeRecepciontme').disable();
    	<?php
		}
		?>
    }
    else
    {
    	if(gE('sp_11080').innerHTML=='Fuero Sindical')
        {
        	oE('div_11057');
            oE('div_11086');
            oE('div_11305');
        }
    	convertirCuantiaLetra();	
    }
}

function convertirCuantiaLetra()
{
	var valor=(gE('_cuantiaProcesoflo') && gE('_cuantiaProcesoflo').value)?gE('_cuantiaProcesoflo').value:gE('_cuantiaProcesoflo').innerHTML;
    var montoTotal=parseFloat(normalizarValor(valor));
	var arMonto=valor.split('.');
	var parteDecimal=0;
    
    valor=arMonto[0];
    
    if(arMonto.length>1)
    {
    	parteDecimal=parseInt(arMonto[1]);
    }
    
    if(parteDecimal<10)
    {
    	parteDecimal='0'+parteDecimal;
    }
    
    var leyenda='('+covertirNumLetras(parseFloat(normalizarValor(valor)))+' PESOS'+(parseFloat(parteDecimal)>0?' CON '+parteDecimal+' CENTAVOS':'')+')';


    if(montoTotal % 1000000==0)
    {

    	leyenda=leyenda.replace(' PESOS',' DE PESOS');
    }
    
    
	gE('sp_11305').innerHTML=leyenda;
}


function validaRadicacion()
{

	var opcion=gE('_tipoProcesovch').options[gE('_tipoProcesovch').selectedIndex].value;

	if(opcion=='20')
    {
        var montoLimite=smdProceso*salarioMinimo;
        var montoRegistrado=gE('_cuantiaProcesoflo').value;
        if(montoRegistrado=='')
            montoRegistrado=0;
        
        montoRegistrado=parseFloat(normalizarValor(montoRegistrado));
       
        if(montoRegistrado>montoLimite)
        {
            function resp()
            {
                gEx('_cuantiaProcesoflo').focus();
            }
            msgBox('La cuant&iacute;a registrada ('+gE('_cuantiaProcesoflo').value+
                    ')  NO puede exceder el monto establedido por el tipo de proceso: '+smdProceso+
                    ' SMMLV ('+Ext.util.Format.usMoney(montoLimite)+')',resp)
            return false;
        }
    }
    
    if(opcion=='1')
    {
        var montoLimite=smdProceso*salarioMinimo;
        var montoRegistrado=gE('_cuantiaProcesoflo').value;
        if(montoRegistrado=='')
            montoRegistrado=0;
        
        montoRegistrado=parseFloat(normalizarValor(montoRegistrado));
       
        if(montoRegistrado<=montoLimite)
        {
            function resp()
            {
                gEx('_cuantiaProcesoflo').focus();
            }
            msgBox('La cuant&iacute;a registrada ('+gE('_cuantiaProcesoflo').value+
                    ')  debe ser mayor o igual a el monto establedido por el tipo de proceso: '+smdProceso+
                    ' SMMLV ('+Ext.util.Format.usMoney(montoLimite)+')',resp)
            return false;
        }
    }
    return true;
    
    
    

}