<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);
	
	$juezDefaultDestino='';
	$consulta="SELECT carpetaAmparo,categoriaAmparo FROM _346_tablaDinamica WHERE id__346_tablaDinamica=".$idReferencia;
	$fAmparoBase=$con->obtenerPrimeraFila($consulta);
	$cAmparo=$fAmparoBase[0];
	$categoriaAmparo=$fAmparoBase[1];
	if($categoriaAmparo==1) //Cierto
	{
		$consulta="SELECT idOpcion FROM _346_juecesAmparo WHERE idPadre=".$idReferencia;
		$juezDefaultDestino=$con->obtenerValor($consulta);
	}
	else
	{
		$consulta="SELECT juezConoce,existeJuezConoce FROM _537_tablaDinamica WHERE idReferencia=".$idReferencia;
		$fDatosJuez=$con->obtenerPrimeraFila($consulta);
		if($fDatosJuez[1]==1)
		{
			$juezDefaultDestino=$fDatosJuez[0];
		}
	}
	
	
	
?>

var juezDefaultDestino='<?php echo $juezDefaultDestino?>';
var cAmparo='<?php echo $cAmparo?>';

function inyeccionCodigo()
{
	if(!esRegistroFormulario())
    {
    	if((gE('sp_7351').innerHTML.indexOf('1.-')!=-1)||(gE('sp_7351').innerHTML.indexOf('2.-')!=-1))
        {
        	oE('div_7352')
            oE('div_7353');
        }
        else
        {
        	oE('div_7357');
            oE('div_7358');
            oE('div_7356');
            oE('div_7362');
            if((gE('sp_7351').innerHTML.indexOf('3.-')==-1)&&(gE('sp_7351').innerHTML.indexOf('14.-')==-1))
            {
            	oE('div_7352')
            	oE('div_7353');
            }
            
        }
        var lblFecha=Ext.util.Format.stripTags(gE('_[lblDiaHoraPlazoInforme]vch').innerHTML);

        gE('_[lblDiaHoraPlazoInforme]vch').innerHTML=Date.parseDate(lblFecha,'Y-m-d H:i:s').format('d/m/Y H:i');
    }
    else
    {
    	if(cAmparo!='')
        {
           gEx('ext__carpetaAdministrativavch').setValue(cAmparo);
           gEx('ext__carpetaAdministrativavch').disable();
           gE('_carpetaAdministrativavch').value=cAmparo;
        }
        
        
        var arrJueces=eval(gE('lista_juezReferidoarr').value);        
        var pos=0;    	
        for(pos=0;pos<arrJueces.length;pos++)
        {
        	asignarEvento(gE('opt_juezReferidoarr_'+arrJueces[pos][0]),'click',function(chk)
            										{
                                                    	juezCheck(chk);
                                                    }
            			)
        }
        
        asignarEvento(gE('_tipoPromocionvch'),'change',function()
                                                        {
                                                            var valor=gE('_tipoPromocionvch').options[gE('_tipoPromocionvch').selectedIndex].value;
                                                            switch(valor)
                                                            {
                                                            	case '1':
                                                                case '2':                                                                
                                                                	gE('_diasPlazoint').value=0;
                                                                    gE('_horasint').value=0;                                                                
                                                                	gEx('f_sp_fechaBaseInformedte').setValue(gEx('f_sp_fechaRecepciondte').getValue());
                                                                    gEx('f_sp_fechaBaseInformedte').fireEvent('change', gEx('f_sp_fechaBaseInformedte'), gEx('f_sp_fechaBaseInformedte').getValue());
                                                                    
                                                                   
                                                                    gEx('f_sp_horaBaseInformetme').setValue(gEx('f_sp_horaRecepciontme').getValue());
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
        	if(juezDefaultDestino!='')
	        	gE('opt_juezReferidoarr_'+juezDefaultDestino).checked=true;
            gEx('f_sp_fechaRecepciondte').setValue('<?php echo $fechaActual?>');
            gEx('f_sp_fechaRecepciondte').fireEvent('change', gEx('f_sp_fechaRecepciondte'), gEx('f_sp_fechaRecepciondte').getValue());
            
           
            gEx('f_sp_horaRecepciontme').setValue('<?php echo $horaActual?>');
            gEx('f_sp_horaRecepciontme').fireEvent('change', gEx('f_sp_horaRecepciontme'), gEx('f_sp_horaRecepciontme').getValue());
        }
        else
        {
            
            calcularFechaPlazo();
        }
    
    }
	
}


function calcularFechaPlazo()
{
	if(gEx('f_sp_fechaBaseInformedte').getValue()=='')
    	return ;
	var fecha=Date.parseDate(gEx('f_sp_fechaBaseInformedte').getValue().format('Y-m-d')+' '+gEx('f_sp_horaBaseInformetme').getValue(),'Y-m-d H:i');
    fecha=fecha.add(Date.DAY,gE('_diasPlazoint').value==''?0:parseInt(gE('_diasPlazoint').value));
	fecha=fecha.add(Date.HOUR,gE('_horasint').value==''?0:parseInt(gE('_horasint').value));    
    gE('_lblDiaHoraPlazoInformevch').innerHTML=fecha.format('d/m/Y H:i');
    gEN('_lblDiaHoraPlazoInformevch')[0].value=fecha.format('Y-m-d H:i:s');
}


function juezCheck(chk)
{
	var arrJueces=eval(gE('lista_juezReferidoarr').value);
        
    var pos=0;
    	
    for(pos=0;pos<arrJueces.length;pos++)
    {
        gE('opt_juezReferidoarr_'+arrJueces[pos][0]).checked=false;
    }  
    
    chk.checked=true; 	
    
}