<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

var fechaActual='<?php echo date("Y-m-d")?>';

Ext.onReady(inicializar);

function inicializar()
{
	var idAccion=gEN('_idAccionvch')[0].value;
    oE('sp_3201');
    
    if(esRegistroFormulario())
    {
    	oE('div_3203');
    	gE('_causaTerminacionvch').setAttribute('val','');
    
    	gE('_mesesvch').setAttribute('onkeypress','return soloNumero(event,false,false,this)');
    	gE('_diasvch').setAttribute('onkeypress','return soloNumero(event,false,false,this)');
    	
        oE('div_3423');
        oE('div_3708');
        oE('div_3709');
        oE('div_3424');
        oE('div_3430');
        oE('div_3429');
        oE('div_3427');
        oE('div_3428');
        gE('_fechaBasedte').setAttribute('val','');
        gE('_mesesvch').setAttribute('val','');
        gE('_diasvch').setAttribute('val','');
        gE('_fechaCierreInvestigaciondte').setAttribute('val','');
        
        
        setTimeout(function()
        			{
                    	gEx('f_sp_fechaBasedte').setValue(fechaActual);
                        gEx('f_sp_fechaBasedte').fireEvent('select',gEx('f_sp_fechaBasedte'),gEx('f_sp_fechaBasedte').getValue());
						gEx('f_sp_fechaBasedte').fireEvent('change',gEx('f_sp_fechaBasedte'),gEx('f_sp_fechaBasedte').getValue());
                        
                        
                        
                        if(gE('idRegistroG').value=='-1')
                        {
                            gEx('f_sp_fechaCierreInvestigaciondte').setValue(fechaActual);
                            gEx('f_sp_fechaCierreInvestigaciondte').fireEvent('select',gEx('f_sp_fechaBasedte'),gEx('f_sp_fechaBasedte').getValue());
                            gEx('f_sp_fechaCierreInvestigaciondte').fireEvent('change',gEx('f_sp_fechaBasedte'),gEx('f_sp_fechaBasedte').getValue());
						}                        
                        
                        gEx('f_sp_fechaBasedte').on('select',function()
                                                      {
                                                          calcularFechaEstimadaAudiencia();  
                                                      }
                                          )
                       
                       
                       gEx('f_sp_fechaCierreInvestigaciondte').disable();
                        
                    }, 1000);

    
    	switch(idAccion)
        {
        	case '1':
            	mE('sp_3201');
            	mE('div_3203');
		    	gE('_causaTerminacionvch').setAttribute('val','obl');
           	break;
            case '8':
            	gE('_mesesvch').value='0';
				gE('_diasvch').value='0';  
                
                mE('div_3423');
                mE('div_3708');
                mE('div_3709');
                mE('div_3424');
                mE('div_3430');
                mE('div_3429');
                mE('div_3427');
                mE('div_3428');
                
                gE('_fechaBasedte').setAttribute('val','obl');
                gE('_mesesvch').setAttribute('val','obl');
                gE('_diasvch').setAttribute('val','obl');
                gE('_fechaCierreInvestigaciondte').setAttribute('val','obl');
                
                          
           	break;
            default:
            	
            break;
        }
        
        
        asignarEvento(gE('_mesesvch'),'blur',function()
                                                      {
                                                          if(gE('_mesesvch').value=='')
                                                              gE('_mesesvch').value=0;
                                                           calcularFechaEstimadaAudiencia();  
                                                      }
                  )
        
      asignarEvento(gE('_diasvch'),'blur',function()
                                                      {
                                                          if(gE('_diasvch').value=='')
                                                              gE('_diasvch').value=0;
                                                           calcularFechaEstimadaAudiencia();  
                                                      }
                  )
  
  
     
        
        
        
    }
    else
    {
    	switch(idAccion)
        {
        	case '1':
            	mE('sp_3201');
            break;
            default:
            	
                
            break;
        }
    }
}


function calcularFechaEstimadaAudiencia()
{
	var fechaBase=gEx('f_sp_fechaBasedte').getValue();
    var fechaFinal;
    var meses=parseInt(gE('_mesesvch').value);
	var dias=parseInt(gE('_diasvch').value); 
    
    fechaFinal=fechaBase.add(Date.DAY,dias);
    fechaFinal=fechaFinal.add(Date.MONTH,meses);
    gEx('f_sp_fechaCierreInvestigaciondte').setValue(fechaFinal);
    gEx('f_sp_fechaCierreInvestigaciondte').fireEvent('select',gEx('f_sp_fechaCierreInvestigaciondte'),gEx('f_sp_fechaCierreInvestigaciondte').getValue());
    gEx('f_sp_fechaCierreInvestigaciondte').fireEvent('change',gEx('f_sp_fechaCierreInvestigaciondte'),gEx('f_sp_fechaCierreInvestigaciondte').getValue());
}