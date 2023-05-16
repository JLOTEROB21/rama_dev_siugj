<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	if($tipoMateria=="SC")
		return;
	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);
	
	$consulta="SELECT carpetaAmparo,fechaRecepcion,horaRecepcion FROM _346_tablaDinamica WHERE id__346_tablaDinamica=".$idReferencia;
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	$cAmparo=$fRegistro[0];
?>

var cAmparo='<?php echo $cAmparo?>';

function inyeccionCodigo()
{
	if(!esRegistroFormulario())
    {
    	var fechaPlazo=Date.parseDate(Ext.util.Format.stripTags(gE('_[lblDiaHoraPlazoInforme]vch').innerHTML),'Y-m-d H:i:s');
        if(fechaPlazo)
		    gE('_[lblDiaHoraPlazoInforme]vch').innerHTML=fechaPlazo.format('d/m/Y H:i');
    	if((gE('sp_8242').innerHTML.indexOf('1.-')!=-1)||(gE('sp_8242').innerHTML.indexOf('2.-')!=-1))
        {
        	oE('div_8243')
            oE('div_8244');
        }
        else
        {
        	oE('div_8245');
            oE('div_8246');
            oE('div_8248');
            oE('div_8247');
            oE('div_8257');
            if((gE('sp_8242').innerHTML.indexOf('3.-')==-1)&&(gE('sp_8242').innerHTML.indexOf('14.-')==-1))
            {
            	oE('div_8243')
            	oE('div_8244');
            }
            
        }
        var lblFecha=Ext.util.Format.stripTags(gE('_[lblDiaHoraPlazoInforme]vch').innerHTML);

        gE('_[lblDiaHoraPlazoInforme]vch').innerHTML=Date.parseDate(lblFecha,'Y-m-d H:i:s').format('d/m/Y H:i');
    }
    else
    {
    	asignarEvento(gE('_tipoPromocionvch'),'change',function()
                                                        {
                                                            var valor=gE('_tipoPromocionvch').options[gE('_tipoPromocionvch').selectedIndex].value;
                                                            switch(valor)
                                                            {
                                                            	case '1':
                                                                case '2':                                                                
                                                                	gE('_diasPlazoint').value=0;
                                                                    gE('_horasint').value=0;                                                                
                                                                	gEx('f_sp_fechaBaseInformedte').setValue('<?php echo $fRegistro[1]?>');
                                                                    gEx('f_sp_fechaBaseInformedte').fireEvent('change', gEx('f_sp_fechaBaseInformedte'), gEx('f_sp_fechaBaseInformedte').getValue());
                                                                    
                                                                   
                                                                    gEx('f_sp_horaBaseInformetme').setValue('<?php echo $fRegistro[2]?>');
                                                                    gEx('f_sp_horaBaseInformetme').fireEvent('change', gEx('f_sp_horaBaseInformetme'), gEx('f_sp_horaBaseInformetme').getValue());
                                                                	calcularFechaPlazo();
                                                                break;
                                                            }
                                                            
                                                        }
        			);  
        
        asignarEvento(gE('_diasPlazoint'),'change',calcularFechaPlazo);
        asignarEvento(gE('_horasint'),'change',calcularFechaPlazo);
        gEx('f_sp_fechaBaseInformedte').on('select',calcularFechaPlazo);
        gEx('f_sp_horaBaseInformetme').on('select',calcularFechaPlazo);
	
    	if(gE('idRegistroG').value=='-1')
        {
        
        }
        else
        {
            gE('_lblDiaHoraPlazoInformevch').innerHTML=Date.parseDate(Ext.util.Format.stripTags(gE('_lblDiaHoraPlazoInformevch').innerHTML),'Y-m-d H:i:s').format('d/m/Y H:i');
            calcularFechaPlazo();
        }
    
    }
	
}


function calcularFechaPlazo()
{
	if(gEx('f_sp_fechaBaseInformedte').getValue()=='')
    	return ;
        
       
	var fecha=Date.parseDate(gEx('f_sp_fechaBaseInformedte').getValue().format('Y-m-d')+' '+gEx('f_sp_horaBaseInformetme').getValue(),'Y-m-d H:i:s');
    if(!fecha)
    	fecha=Date.parseDate(gEx('f_sp_fechaBaseInformedte').getValue().format('Y-m-d')+' '+gEx('f_sp_horaBaseInformetme').getValue(),'Y-m-d H:i');
    fecha=fecha.add(Date.DAY,gE('_diasPlazoint').value==''?0:parseInt(gE('_diasPlazoint').value));
	fecha=fecha.add(Date.HOUR,gE('_horasint').value==''?0:parseInt(gE('_horasint').value));    
    gE('_lblDiaHoraPlazoInformevch').innerHTML=fecha.format('d/m/Y H:i');
    gEN('_lblDiaHoraPlazoInformevch')[0].value=fecha.format('Y-m-d H:i:s');
}
