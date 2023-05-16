<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);	
	
?>
var ultimoJuez=-1;
var juezNodisponible=false;
var fechaActual='<?php echo date("Y-m-d")?>';
var cadenaFuncionValidacion='prepararGuardado';

function inyeccionCodigo()
{
	if(esRegistroFormulario())
    {
    	if(gE('idRegistroG').value!='-1')
        {
        	if(gEx('f_sp_fechaBaseAudienciadte').getValue()!='')
            {
            	fechaActual=gEx('f_sp_fechaBaseAudienciadte').getValue().format('Y-m-d');
            }
            
            if(gE('_juezAsignarvch'))
            {
            	
            	if((gE('_juezAsignarvch').value!=-1)&&(gE('_juezAsignarvch').value!=''))
                	ultimoJuez=gE('_juezAsignarvch').value;
                else
	                ultimoJuez='-1';
                
            }
            
        }
    	
        if(gE('_juezAsignarvch'))
        {
            asignarEvento(gE('_juezAsignarvch'),'change',function()
                                                            {
                                                            	ultimoJuez=gE('_juezAsignarvch').options[gE('_juezAsignarvch').selectedIndex].value;
                                                                var fechaFinal=gEx('f_sp_fechaEstimadaAudienciadte').getValue();
                                                                validarDisponibilidadJuez(fechaFinal.format('Y-m-d'));
                                                            }
                         )
        } 
        asignarEvento(gE('_tipoAudienciavch'),'change',function(cmb)
                                                            {
                                                                var opcion=cmb.options[cmb.selectedIndex].value;
                                                                switch(opcion)
                                                                {
                                                                	case '23':
                                                                    case '211':
                                                                    case '219':
                                                                    	mE('div_2655');
                                                                        mE('div_2659');
                                                                        gE('_otroTipoAudiencavch').setAttribute('val','');
                                                                        
                                                                    break;
                                                                    default:
                                                                    	oE('div_2655');
                                                                        oE('div_2659');
                                                                        gE('_otroTipoAudiencavch').setAttribute('val','');
                                                                    break;
                                                                }
                                                            }
                         )
        
                 
        gE('_mesesAudienciaint').value=0;
        gE('_diasAudienciaint').value=0;
        gEx('f_sp_fechaBaseAudienciadte').setValue(fechaActual);
        gEx('f_sp_fechaBaseAudienciadte').fireEvent('select',gEx('f_sp_fechaBaseAudienciadte'),gEx('f_sp_fechaBaseAudienciadte').getValue());
        gEx('f_sp_fechaBaseAudienciadte').fireEvent('change',gEx('f_sp_fechaBaseAudienciadte'),gEx('f_sp_fechaBaseAudienciadte').getValue());
        
        asignarEvento(gE('opt_tipoDiasvch_1'),'click',function()
                                                        {
                                                            calcularFechaEstimadaAudiencia();  
                                                        }
                    )
        
        asignarEvento(gE('opt_tipoDiasvch_2'),'click',function()
                                                        {
                                                            calcularFechaEstimadaAudiencia();  
                                                        }
                    )
                    
        asignarEvento(gE('opt_parametrosFechaMinimavch_1'),'click',function()
                                                        {
                                                            gE('_mesesAudienciaint').value=0;
                                                            gE('_diasAudienciaint').value=0;
                                                            
                                                            
                                                            gEx('f_sp_fechaBaseAudienciadte').setValue(fechaActual);
                                                            gEx('f_sp_fechaBaseAudienciadte').fireEvent('select',gEx('f_sp_fechaBaseAudienciadte'),gEx('f_sp_fechaBaseAudienciadte').getValue());
                                                            gEx('f_sp_fechaBaseAudienciadte').fireEvent('change',gEx('f_sp_fechaBaseAudienciadte'),gEx('f_sp_fechaBaseAudienciadte').getValue());
                                                           	calcularFechaEstimadaAudiencia();
                                                            var fechaFinal=gEx('f_sp_fechaEstimadaAudienciadte').getValue();  
                                                            if(gE('_juezAsignarvch'))
                                                            {
                                                                gE('_juezAsignarvch').disabled=false;
                                                                
                                                                obtenerJuecesConocimiento();
															}                                                            
                                                            
                                                        	
                                                            
                                                        }
                    )
      	
        asignarEvento(gE('opt_parametrosFechaMinimavch_0'),'click',function()
                                                        {
                                                        	if(gE('_juezAsignarvch'))
                                                            {
                                                            	gE('_juezAsignarvch').disabled=true;
                                                           		selElemCombo(gE('_juezAsignarvch'),'0');
                                                            }
                                                            
                                                        }
                    )
        
        
        asignarEvento(gE('_mesesAudienciaint'),'blur',function()
                                                        {
                                                            if(gE('_mesesAudienciaint').value=='')
                                                                gE('_mesesAudienciaint').value=0;
                                                             calcularFechaEstimadaAudiencia();  
                                                        }
                    )
          
        asignarEvento(gE('_diasAudienciaint'),'blur',function()
                                                        {
                                                            if(gE('_diasAudienciaint').value=='')
                                                                gE('_diasAudienciaint').value=0;
                                                             calcularFechaEstimadaAudiencia();  
                                                        }
                    )
    
    
        gEx('f_sp_fechaBaseAudienciadte').on('select',function()
                                                        {
                                                            calcularFechaEstimadaAudiencia();  
                                                        }
                                            )
        
        if(gE('idRegistroG').value=='-1')
        {
        	if(gE('_juezAsignarvch'))
	        	selElemCombo(gE('_juezAsignarvch'),'0');
            
		}
        else
        {
        	if(gE('opt_parametrosFechaMinimavch_1').checked)
            {
            	gEx('f_sp_fechaBaseAudienciadte').enable();
                 var fechaFinal=gEx('f_sp_fechaEstimadaAudienciadte').getValue();
            	if(gE('_juezAsignarvch'))
                {
                	gE('_juezAsignarvch').disabled=false;
               
                	validarDisponibilidadJuez(fechaFinal.format('Y-m-d'));
                }
            }
            else
            {
            	if(gE('_juezAsignarvch'))
            	gE('_juezAsignarvch').disabled=true;
            }
            if(gE('_juezAsignarvch'))
            {
                var juezSeleccionado=gE('_juezAsignarvch').options[gE('_juezAsignarvch').selectedIndex].value;
                
                if(juezSeleccionado=='-1')
                    selElemCombo(gE('_juezAsignarvch'),'0');
            }
        }
        
        
        lanzarEvento(gE('_tipoAudienciavch'),'change');
        
        
        if(gE('idRegistroG').value!='-1')
        {
        	
            
            if(gE('_juezAsignarvch')&& (gE('opt_parametrosFechaMinimavch_1').checked))
            {
            	obtenerJuecesConocimiento();
                
            }
            
        }
        
    }
    else
    {
    	
    	
        
        if(gE('sp_2688').innerHTML=='No')
        {
        	oE('div_2676');
            oE('div_2678');
            oE('div_2679');
            oE('div_2681');
            oE('div_2677');
            oE('div_2680');
            oE('div_2682');
            oE('div_2689');
            oE('div_2690');
            oE('div_7586');
        }
        
        if(gE('sp_2656').innerHTML.indexOf('(23)')==-1)
        {
        	oE('div_2655');	
        }
        
        if(gE('sp_7742') && gE('sp_7742').innerHTML=='')
        {
        	gE('sp_7742').innerHTML='<span class="TSJDF_Control">Aleatorio</span>';
        }
        
    }
}

function prepararGuardado()
{
	
    if(juezNodisponible)
    {
    	msgBox('El juez NO cuenta con disponibilidad en la fecha estimada de audiencia');
    	return false;
    }   
       
	gE('_tipoAudienciavch').disabled=false; 
    
    return true;
}

function calcularFechaEstimadaAudiencia()
{
	var fechaBase=gEx('f_sp_fechaBaseAudienciadte').getValue();
    var fechaFinal;
    var meses=parseInt(gE('_mesesAudienciaint').value==''?0:gE('_mesesAudienciaint').value);
	var dias=parseInt(gE('_diasAudienciaint').value==''?0:gE('_diasAudienciaint').value); 
    
    
    
    <?php
		if($tipoMateria=="P")
		{
			
	?>
    	fechaFinal=fechaBase.add(Date.DAY,dias);
   		fechaFinal=fechaFinal.add(Date.MONTH,meses);
    	asentarFecha(fechaFinal);
    <?php
		}
		else
		{
	?>
    
    if((dias+meses)==0)
    {
    	fechaFinal=fechaBase;
    	asentarFecha(fechaFinal);
   	}
	else
    {
    	function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                asentarFecha(arrResp[1]);
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=191&tD='+gE('_tipoDiasvch').value+'&fB='+fechaBase.format('Y-m-d')+'&d='+dias+'&m='+meses,true);
    }
    <?php
		}
	?>
       
    
}

function asentarFecha(fechaFinal)
{
	
	gEx('f_sp_fechaEstimadaAudienciadte').setValue(fechaFinal);
    gEx('f_sp_fechaEstimadaAudienciadte').fireEvent('select',gEx('f_sp_fechaEstimadaAudienciadte'),gEx('f_sp_fechaEstimadaAudienciadte').getValue());
    gEx('f_sp_fechaEstimadaAudienciadte').fireEvent('change',gEx('f_sp_fechaEstimadaAudienciadte'),gEx('f_sp_fechaEstimadaAudienciadte').getValue());
    obtenerJuecesConocimiento();
//    validarDisponibilidadJuez(fechaFinal);
    
}

function validarDisponibilidadJuez(fechaFinal)
{
	var juezSeleccionado=gE('_juezAsignarvch').options[gE('_juezAsignarvch').selectedIndex].value;
    
    if(juezSeleccionado!='0')
    {
    	function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                switch(arrResp[1])
                {
                	case '1':
                    	juezNodisponible=false;
                        gE('sp_7744').innerHTML='El juez se encontrar&aacute; como Juez de Tr&aacute;mite en la fecha estimada de audiencia';
                        mE('div_7744');
                    break;
                    case '2':
                    	juezNodisponible=true;
                        gE('sp_7744').innerHTML='El juez NO cuenta con disponibilidad en la fecha estimada de audiencia';
                        mE('div_7744');
                    break;
                    default:
                    	juezNodisponible=false;
                    	oE('div_7744');
                    break;
                }
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=193&idJuez='+juezSeleccionado+'&fecha='+fechaFinal,true);
    }
    else
    	juezNodisponible=false;
}

function obtenerJuecesConocimiento()
{
	var fechaAudiencia=gEx('f_sp_fechaEstimadaAudienciadte').getValue().format('Y-m-d');
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrJueces=eval(arrResp[1]);
            arrJueces.splice(0,0,['0','Aletatorio']);
            if(arrResp[2]=='-1')
                arrResp[2]='0';
            
          

            llenarCombo(gE('_juezAsignarvch'),arrJueces,true);
            if(ultimoJuez==-1)
	            selElemCombo(gE('_juezAsignarvch'),arrResp[2]);
            else
            	selElemCombo(gE('_juezAsignarvch'),ultimoJuez);
            
            validarDisponibilidadJuez(fechaAudiencia);
              
            
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=192&fechaAudiencia='+
    				fechaAudiencia+'&cJudicial='+gEN('_carpetaAdministrativavch')[0].value,true);
}