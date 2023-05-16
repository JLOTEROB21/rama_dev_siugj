<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$iF=bD($_GET["iF"]);
	$iR=bD($_GET["iR"]);
	
	$consulta="SELECT uGASDestino,inmuebleDestino FROM _466_tablaDinamica WHERE id__466_tablaDinamica='".$iR."'";
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	$uGASDestino=$fRegistro[0];
	$inmuebleDestino=$fRegistro[1];
	if(($uGASDestino=="")||($uGASDestino=="N/E"))
		$uGASDestino=-1;
	$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica IN(".$uGASDestino.")  order by prioridad";
	$nombreUgas=$con->obtenerListaValores($consulta);
?>
var inmuebleDestino='<?php echo $inmuebleDestino?>';

var nombreUgas='<?php echo $nombreUgas?>';
Ext.onReady(inicializar);

function inicializar()
{
	if(esRegistroFormulario())
    {
    	
    	if(gE('idRegistroG').value=='-1')
        {
        	limpiarCombo(gE('_inmuebleDestinovch'));
            gE('sp_9628').innerHTML='(Por definir)';
        }
    	var fechaLimite='<?php echo date("Y-m-d",strtotime("-20 days",strtotime(date("Y-m-d"))))?>';
    	
        gEN('_fechaLimiteEnviovch')[0].value=fechaLimite;
        gE('_fechaLimiteEnviovch').innerHTML=fechaLimite;
        
         asignarEvento('_tipoCarpetaJudicialvch','change',function()
        													{
                                                            	determinarTipoUGADestino();
                                                            }
                      )
        
        asignarEvento('opt_tipoAsignacionvch_2','click',function()
        													{
                                                            	determinarTipoUGADestino();
                                                                gE('sp_7423').innerHTML='Inmueble destino:';
                                                            }
                      )
                      
		asignarEvento('opt_tipoAsignacionvch_1','click',function()
        													{
                                                            	
                                                                gE('sp_7423').innerHTML='Unidad de Gestión Destino:';
                                                            }
                      )                      
        
    	asignarEvento('opt_tipoUnidadDestinovch_1','change',function()
        													{
                                                            	determinarInmueblesDestinoUGADestino();
                                                            }
                      )
                      
		asignarEvento('opt_tipoUnidadDestinovch_5','change',function()
        													{
                                                            	determinarInmueblesDestinoUGADestino();
                                                            }
                      )
		
        asignarEvento('opt_tipoUnidadDestinovch_6','change',function()
        													{
                                                            	determinarInmueblesDestinoUGADestino();
                                                            }
                      )                                            
    	
        asignarEvento('_inmuebleDestinovch','change',function()
        													{
                                                            	determinarUGASDestinoInmueble();
                                                            }
                      )  
    
    
    }
    else
    {
    	if(gE('sp_9621').innerHTML=='Por balanceo según inmueble')
        {
        	oE('div_7424');
            //oE('div_9624');
            gE('sp_7423').innerHTML='Inmueble destino:';
        }
        else
        {
        	oE('div_9625');
            oE('div_9628');
            oE('div_9623');
            oE('div_9622');
        }
        if(gE('sp_7437').innerHTML=='N/E')
        {
        	oE('div_7437');
        }
        else
        {
        	oE('div_7422');
        }
        
        gE('sp_9628').innerHTML=nombreUgas;
    }
    
    
}

function determinarTipoUGADestino()
{
	if(gE('_tipoAsignacionvch').value=='2')
    {
        //if(gE('_tipoUnidadDestinovch').value=='')
        {
            var _tipoCarpetaJudicialvch=gE('_tipoCarpetaJudicialvch');
            var opcionSel=_tipoCarpetaJudicialvch.options[_tipoCarpetaJudicialvch.selectedIndex].value;
            
            switch(opcionSel)
            {
                case '1':
                	
                	gE('opt_tipoUnidadDestinovch_1').checked=true;
                    selOpcion(gE('opt_tipoUnidadDestinovch_1'));
                    gE('opt_tipoUnidadDestinovch_5').disabled=true;
                    gE('opt_tipoUnidadDestinovch_6').disabled=true;
                   	determinarInmueblesDestinoUGADestino();
                break;
                case '2':
                	gE('opt_tipoUnidadDestinovch_1').disabled=false;
                    gE('opt_tipoUnidadDestinovch_5').disabled=true;
                    gE('opt_tipoUnidadDestinovch_6').disabled=false;
                    gE('opt_tipoUnidadDestinovch_1').checked=false;
                    gE('opt_tipoUnidadDestinovch_5').checked=false;
                    gE('opt_tipoUnidadDestinovch_6').checked=false;
                    llenarCombo(gE('_inmuebleDestinovch'),[],true);
                break;
                case '5':
                	gE('opt_tipoUnidadDestinovch_5').checked=true;
                    selOpcion(gE('opt_tipoUnidadDestinovch_5'));
                    gE('opt_tipoUnidadDestinovch_1').disabled=true;
                    gE('opt_tipoUnidadDestinovch_6').disabled=true;
                    determinarInmueblesDestinoUGADestino();
                break;
                case '6':
                case '9':
                	gE('opt_tipoUnidadDestinovch_6').checked=true;
                    selOpcion(gE('opt_tipoUnidadDestinovch_6'));
                    gE('opt_tipoUnidadDestinovch_1').disabled=true;
                    gE('opt_tipoUnidadDestinovch_5').disabled=true;
					determinarInmueblesDestinoUGADestino();
                
                break;
            }
            
    	}
	}
}

function determinarInmueblesDestinoUGADestino()
{
	var unidadGestion=gE('_unidadGestionvch');
    iUO=unidadGestion.options[unidadGestion.selectedIndex].value;
    
    
	 gE('sp_9628').innerHTML='(Por definir)';
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            llenarCombo(gE('_inmuebleDestinovch'),eval(arrResp[1]),true);
            if(inmuebleDestino!='')
            {
            	selElemCombo(gE('_inmuebleDestinovch'),inmuebleDestino);
                determinarUGASDestinoInmueble();
            }
            inmuebleDestino='';
           
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_formulariosDinamicos.php',funcAjax, 'POST','funcion=2&iUO='+iUO+'&tipoUnidad='+gE('_tipoUnidadDestinovch').value,true);
}

function determinarUGASDestinoInmueble()
{
	var _inmuebleDestinovch=gE('_inmuebleDestinovch');
    
    
    var inmueble=_inmuebleDestinovch.options[_inmuebleDestinovch.selectedIndex].value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            gE('sp_9628').innerHTML=arrResp[1];
            gEN('_uGASDestinovch')[0].value=arrResp[2];
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_formulariosDinamicos.php',funcAjax, 'POST','funcion=3&inmueble='+inmueble+'&tipoUnidad='+gE('_tipoUnidadDestinovch').value,true);
}