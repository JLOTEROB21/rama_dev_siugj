<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$iRef=$_GET["iRef"];
	
	$consulta="SELECT id__17_tablaDinamica,nombreUnidad FROM _17_tablaDinamica u,_17_tiposCarpetasAdministra tC
			WHERE tC.idPadre=u.id__17_tablaDinamica AND tC.idOpcion=5 AND u.tipoMateria=1 ORDER BY u.prioridad";
	$arrTE=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__17_tablaDinamica,nombreUnidad FROM _17_tablaDinamica u,_17_tiposCarpetasAdministra tC
			WHERE tC.idPadre=u.id__17_tablaDinamica AND tC.idOpcion=6 AND u.tipoMateria=1 ORDER BY u.prioridad";
	$arrEjec=$con->obtenerFilasArreglo($consulta);
	
	
	$lblResumen="Sin Carpeta Judicial Asignada";
	$consulta="SELECT i.apellidoMaterno,i.apellidoPaterno,i.nombre,
			(SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE idCarpeta=a.idCarpeta) AS carpetaJudicial,
			(SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=a.idUnidadDestino)  AS unidadDestino,
			tipoAccion
			
			FROM 3250_asignacionIncompetencias a,_47_tablaDinamica i WHERE iFormulario=".$idFormulario." AND iRegistro=".$idRegistro."
			AND i.id__47_tablaDinamica=a.idImputado ORDER BY nombre, apellidoPaterno,apellidoMaterno";
			
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))			
	{
		$resumen=$fila[2]." ".$fila[1]." ".$fila[0]." [".($fila[5]==1?"Nueva carpeta":"Reaperturada")."]: ".$fila[3]." (".$fila[4].")";
		if($lblResumen=="Sin Carpeta Judicial Asignada")
			$lblResumen=$resumen;
		else
			$lblResumen.="<br>".$resumen;
	}
?>
var tCarpeta;
var arrTE=<?php echo $arrTE?>;
var arrEjec=<?php echo $arrEjec?>;
var cadenaFuncionValidacion='prepararGuardado';
var objInfo;

function inyeccionCodigo()
{
	gE('sp_8977').innerHTML='<?php echo $lblResumen?>';
	if(esRegistroFormulario())
    {
    	tCarpeta=gE('sp_8985').innerHTML;
        var x;
        var valor;
        if(tCarpeta==5)
        {
        	mE('div_9432');
            oE('div_8984');
            gE('_unidadDestinoEjecucionvch').setAttribute('val','');
            
        }
        else
        {
        	oE('div_9432');
            mE('div_8984');
            gE('_unidadDestinoTribunalEnjuiciamientovch').setAttribute('val','');            
        }
        
        if(gE('idRegistroG').value=='-1')
        {
            var arrImputados=eval(gE('lista_imputadosRemitearr').value);
            if(arrImputados.length==1)
            {
                gE('opt_imputadosRemitearr_'+arrImputados[0][0]).checked=true;
                
                lanzarEvento('opt_imputadosRemitearr_'+arrImputados[0][0],'click',gE('opt_imputadosRemitearr_'+arrImputados[0][0]));
            }
        }
        asignarEvento('_motivoIncompetenciavch','change',function(cmb)
        													{
                                                            	if(tCarpeta==5)
                                                                {
																	gE('_unidadDestinoTribunalEnjuiciamientovch').selectedIndex=0;
                                                                }
                                                                else
                                                                {
                                                                	gE('_unidadDestinoEjecucionvch').selectedIndex=0;
                                                                }
                                                            	gE('_lugarInternamientovch').selectedIndex=0;
                                                            	var valor=gE('_motivoIncompetenciavch').options[gE('_motivoIncompetenciavch').selectedIndex].value;
                                                                switch(parseInt(valor))
                                                                {
                                                                	case 1:
                                                                    	gE('opt_privadoLibertadvch_1').checked=true;
                                                                        dE('opt_privadoLibertadvch_1');
                                                                        dE('opt_privadoLibertadvch_0');
                                                                        lanzarEvento('opt_privadoLibertadvch_1','click');
                                                                        
                                                                        
                                                                    break;
                                                                    case 2:
                                                                    	gE('opt_privadoLibertadvch_0').checked=true;
                                                                        dE('opt_privadoLibertadvch_1');
                                                                        dE('opt_privadoLibertadvch_0');
                                                                        lanzarEvento('opt_privadoLibertadvch_0','click');
                                                                        
                                                                        
                                                                    break;
                                                                    default:
                                                                    	hE('opt_privadoLibertadvch_1');
                                                                        hE('opt_privadoLibertadvch_0');
                                                                        gE('opt_privadoLibertadvch_0').checked=false;
                                                                        gE('opt_privadoLibertadvch_1').checked=false;
                                                                        
                                                                        
                                                                    break;

                                                                }
                                                                
                                                               
                                                            }
        			)
        
         asignarEvento('_lugarInternamientovch','change',function(cmb)
        													{
                                                            	definirEdificioDestino();
                                                            }
        			)
        
        asignarEvento('opt_privadoLibertadvch_0','click',function(cmb)
        													{
                                                            	var motivoIncompetencia=parseInt(gE('_motivoIncompetenciavch').options[gE('_motivoIncompetenciavch').selectedIndex].value);
                                                            	if(tCarpeta==5)
                                                                {
																	selElemCombo(gE('_unidadDestinoTribunalEnjuiciamientovch'),'4');
                                                                    dE('_unidadDestinoTribunalEnjuiciamientovch');
                                                                    if((motivoIncompetencia==5)||(motivoIncompetencia==4))
                                                                    {
                                                                        hE('_unidadDestinoTribunalEnjuiciamientovch'); 
                                                                    }
                                                                }
                                                                else
                                                                {
                                                            		selElemCombo(gE('_unidadDestinoEjecucionvch'),'36');
                                                                    dE('_unidadDestinoEjecucionvch');
                                                                    if((motivoIncompetencia==5)||(motivoIncompetencia==4))
                                                                    {
                                                                        hE('_unidadDestinoEjecucionvch'); 
                                                                    }
        														}
                                                                
                                                                
                                                               
                                                                
                                                            }
        			)
      	
        asignarEvento('opt_privadoLibertadvch_1','click',function(cmb)
        													{
                                                            	if(tCarpeta==5)
	                                                            	selElemCombo(gE('_unidadDestinoTribunalEnjuiciamientovch'),'-1');
                                                                else
                                                                	selElemCombo(gE('_unidadDestinoEjecucionvch'),'-1');
                                                            	var motivoIncompetencia=parseInt(gE('_motivoIncompetenciavch').options[gE('_motivoIncompetenciavch').selectedIndex].value);
                                                            	if((motivoIncompetencia==5)||(motivoIncompetencia==4))
                                                                {
                                                                	if(tCarpeta==5)
                                                                	{
	                                                            		hE('_unidadDestinoTribunalEnjuiciamientovch'); 
                                                                    }
                                                                    else
                                                                    {
                                                                    	hE('_unidadDestinoEjecucionvch'); 
                                                                    }
                                                                }
                                                                
                                                            	
                                                                
                                                               
                                                            }
        			) 
        
        var pos=0
        for(pos=0;pos<controlesOcultos.length;pos++)
        {
            if(controlesOcultos[pos]=='_privadoLibertadvch')
            {
                controlesOcultos[pos]='';
            }
        }
   	} 
    else
    {
    	if(gE('sp_8967').innerHTML!='Si')
        {
        	oE('div_8968');
            oE('div_8969');
        }
    }
}

function definirEdificioDestino()
{
	determinarReclusorioDestino();
    
}




function determinarReclusorioDestino()
{

	if(gE('opt_privadoLibertadvch_1').checked)
    {
       
        var valor=gE('_lugarInternamientovch').options[gE('_lugarInternamientovch').selectedIndex].value;
        if(tCarpeta==5)
        {
        	hE('_unidadDestinoTribunalEnjuiciamientovch');
            switch(valor)
            {
                case '00020008': //Centro Femenil de Reinserción Social (Santa Martha)
                    selElemCombo(gE('_unidadDestinoTribunalEnjuiciamientovch'),'3');
                    dE('_unidadDestinoTribunalEnjuiciamientovch');
                break;
                case '00020005':
                case '00020001': //Reclusorio Preventivo Varonil Norte
                    selElemCombo(gE('_unidadDestinoTribunalEnjuiciamientovch'),'1');
                    dE('_unidadDestinoTribunalEnjuiciamientovch');
                break;
                case '00020006':
                case '00020002': //Reclusorio Preventivo Varonil Oriente
                    selElemCombo(gE('_unidadDestinoTribunalEnjuiciamientovch'),'2');
                    dE('_unidadDestinoTribunalEnjuiciamientovch');
                break;
                case '00020004': 
                case '00020003': //Reclusorio Preventivo Varonil Sur
                    selElemCombo(gE('_unidadDestinoTribunalEnjuiciamientovch'),'3');
                    dE('_unidadDestinoTribunalEnjuiciamientovch');
                    
                break;
                default:
                    selElemCombo(gE('_unidadDestinoTribunalEnjuiciamientovch'),'-1');
                break;
            }
		}
        else
        {
        	hE('_unidadDestinoEjecucionvch');
        	switch(valor)
            {
                case '00020008': //Centro Femenil de Reinserción Social (Santa Martha)
                    selElemCombo(gE('_unidadDestinoEjecucionvch'),'53');
                    dE('_unidadDestinoEjecucionvch');
                break;
                case '00020005':
                case '00020001': //Reclusorio Preventivo Varonil Norte
                    selElemCombo(gE('_unidadDestinoEjecucionvch'),'51');
                    dE('_unidadDestinoEjecucionvch');
                break;
                 case '00020006':
                case '00020002': //Reclusorio Preventivo Varonil Oriente
                    selElemCombo(gE('_unidadDestinoEjecucionvch'),'53');
                    dE('_unidadDestinoEjecucionvch');
                break;
                case '00020003': //Reclusorio Preventivo Varonil Sur
                    selElemCombo(gE('_unidadDestinoEjecucionvch'),'53');
                    dE('_unidadDestinoEjecucionvch');
                    
                break;
                default:
                    selElemCombo(gE('_unidadDestinoEjecucionvch'),'-1');
                break;
            }
        }
            
        
    }
    else
    {
    	if(tCarpeta==5)
        {
        	selElemCombo(gE('_unidadDestinoTribunalEnjuiciamientovch'),'4');
       	 	dE('_unidadDestinoTribunalEnjuiciamientovch');
        }
        else
        {
        	selElemCombo(gE('_unidadDestinoEjecucionvch'),'36');
	        dE('_unidadDestinoEjecucionvch');
        }
    	
    }
    var motivoIncompetencia=parseInt(gE('_motivoIncompetenciavch').options[gE('_motivoIncompetenciavch').selectedIndex].value);
    if((motivoIncompetencia==5)||(motivoIncompetencia==4))
    {
    	if(tCarpeta==5)
	    	hE('_unidadDestinoTribunalEnjuiciamientovch');
        else
        	hE('_unidadDestinoEjecucionvch');
    }
    	
}


function prepararGuardado()
{
	if(tCarpeta==6)
		hE('_unidadDestinoEjecucionvch');
    else
   		hE('_unidadDestinoTribunalEnjuiciamientovch');	
	
    var pos=0
    for(pos=0;pos<controlesOcultos.length;pos++)
    {
        if(controlesOcultos[pos]=='_privadoLibertadvch')
        {
            controlesOcultos[pos]='';
        }
    }

    return true;
}