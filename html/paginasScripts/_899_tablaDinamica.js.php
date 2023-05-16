<?php
	session_start();

	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$idFormulario=bD($_GET["iF"]);

	$idRegistro=bD($_GET["iR"]);
	
	$idReferencia=($_GET["iRef"]);
	$idProcesoPadre=bD($_GET["iPP"]);

	$fechaActual=date("Y-m-d")	;

	$horaActual=date("H:i");
	$arrDecretaSentencia="";
	$consulta="SELECT id__624_tablaDinamica,nombreActuacion FROM _624_tablaDinamica WHERE  decretaSentencia=1";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($res))
	{
		$consulta="SELECT id__624_gOpcionesSentencia,etiqueta FROM _624_gOpcionesSentencia WHERE idReferencia=".$fila["id__624_tablaDinamica"];
		$arrOpciones=$con->obtenerFilasArreglo($consulta);
		
		$o="['".$fila["id__624_tablaDinamica"]."','".cv($fila["nombreActuacion"])."',".$arrOpciones."]";
		if($arrDecretaSentencia=="")
			$arrDecretaSentencia=$o;
		else
			$arrDecretaSentencia.=",".$o;
	}
	$arrDecretaSentencia="[".$arrDecretaSentencia."]";
	$consulta="SELECT id__624_tablaDinamica,nombreActuacion FROM _624_tablaDinamica WHERE  generaOrdenProgramacionAudiencia=1";
	$arrOrdenProgramacion=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__624_tablaDinamica,nombreActuacion FROM _624_tablaDinamica WHERE  preguntarDecretaPruebas=1";
	$arrDecretaPruebas=$con->obtenerFilasArreglo($consulta);
	
	
	$errorLLenadoFechaAudiencia="false";
	$errorLLenadoDecretaPruebas="false";
	$errorLLenadoSentencia="false";
	
	
	if($idRegistro!=-1)
	{
		$consulta="SELECT * FROM _899_tablaDinamica WHERE id__899_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="SELECT count(*) FROM _624_tablaDinamica WHERE id__624_tablaDinamica=".$fRegistro["providenciaAplicar"]." and  generaOrdenProgramacionAudiencia=1";
		$numReg=$con->obtenerValor($consulta);
		
		if(($numReg>0) &&($fRegistro["fechaAudiencia"]==""))
		{
			$errorLLenadoFechaAudiencia="true";
		}
		
		
		$consulta="SELECT count(*) FROM _624_tablaDinamica WHERE id__624_tablaDinamica=".$fRegistro["providenciaAplicar"]." and  preguntarDecretaPruebas=1";
		$numReg=$con->obtenerValor($consulta);
		
		if(($numReg>0) &&($fRegistro["decretaPruebas"]==""))
		{
			$errorLLenadoDecretaPruebas="true";
		}
		
		
		$consulta="SELECT count(*) FROM _624_tablaDinamica WHERE id__624_tablaDinamica=".$fRegistro["providenciaAplicar"]." and  decretaSentencia=1";
		$numReg=$con->obtenerValor($consulta);
		
		if(($numReg>0) &&($fRegistro["sentidoFalloSentencia"]==""))
		{
			$errorLLenadoSentencia="true";
		}
	}
	
	
	
?>

var errorLLenadoFechaAudiencia=<?php echo $errorLLenadoFechaAudiencia?>;
var errorLLenadoDecretaPruebas=<?php echo $errorLLenadoDecretaPruebas?>;
var errorLLenadoSentencia=<?php echo $errorLLenadoSentencia?>;

var elemSelOrigen=-1;
var arrDecretaSentencia=<?php echo $arrDecretaSentencia?>;
var arrOrdenProgramacion=<?php echo $arrOrdenProgramacion?>;
var arrDecretaPruebas=<?php echo $arrDecretaPruebas?>;

function inyeccionCodigo()
{

    if(esRegistroFormulario())
    {
    	 
    	gE('sp_fechaAudienciadte').style='width:180px';
    	asignarEvento(gE('_providenciaAplicarvch'),'change',function(cmb)
        							{
                                    	oE('div_13512');
                                        oE('div_13375');
                                        oE('div_14348');
                                        gE('_fechaAudienciadte').setAttribute('val','');
                                        if(gE('idRegistroG').value=='-1')
      									{
                                            gE('_fechaAudienciadte').setAttribute('val','');
                                            gE('_fechaAudienciadte').value='';
                                            gE('_sentidoFalloSentenciavch').value='0';
                                            gE('_sentidoFalloSentenciavch').setAttribute('val','');
										}                                    
                                    	var tipoActuacion=cmb.options[cmb.selectedIndex].value;
                                        var pos=existeValorMatriz(arrDecretaSentencia,tipoActuacion);
                                       	if(pos!=-1)
                                        {
                                        	llenarCombo(gE('_sentidoFalloSentenciavch'),arrDecretaSentencia[pos][2]);
                                            selElemCombo(gE('_sentidoFalloSentenciavch'),elemSelOrigen);
                                        	mE('div_13375');
                                            mE('div_14348');
                                            gE('_sentidoFalloSentenciavch').setAttribute('val','obl');
                                            
                                        }
                                        else
                                        {
                                        	oE('div_13375');
                                            oE('div_14348');
                                            gE('_sentidoFalloSentenciavch').setAttribute('val','');
                                        }
                                        if(existeValorMatriz(arrOrdenProgramacion,tipoActuacion)!=-1)
                                        {
                                            mE('div_13512');
                                            mE('div_14347');
                                            gE('_fechaAudienciadte').setAttribute('val','obl');
                                            
                                        }
                                        else
                                        {
                                        	oE('div_13512');
                                            oE('div_14347');
                                            gE('_fechaAudienciadte').setAttribute('val','');
                                        }
                                        
                                        if(existeValorMatriz(arrDecretaPruebas,tipoActuacion)!=-1)
                                        {
                                            mE('div_14337');
                                            mE('div_14338');
                                            gE('_decretaPruebasvch').setAttribute('val','obl');
                                            
                                        }
                                        else
                                        {
                                        	oE('div_14337');
                                            oE('div_14338');
                                            gE('_decretaPruebasvch').setAttribute('val','');
                                            
                                        }
                                        
                                        
                                    }
        			); 
    	asignarEvento(gE('_sentidoFalloSentenciavch'),'change',function(cmb)
        							{
                                    	elemSelOrigen=cmb.options[cmb.selectedIndex].value;
                                    }
                     )
    		
    	if(gE('idRegistroG').value!='-1')
        {
        	elemSelOrigen=gE('_sentidoFalloSentenciavch').options[gE('_sentidoFalloSentenciavch').selectedIndex].value;
            lanzarEvento(gE('_providenciaAplicarvch'),'change');
             
             
                    
        }
    }
    else
    {
    	oE('div_13375');
        oE('div_14348');
        oE('div_14347');
        oE('div_13512');
        oE('div_14337');
        oE('div_19735');

        if(existeValorMatriz(arrDecretaSentencia,gE('sp_12817').innerHTML,1)!=-1)
        {
        	mE('div_13375');
            mE('div_14348');
        }
        if(existeValorMatriz(arrOrdenProgramacion,gE('sp_12817').innerHTML,1)!=-1)
        {
        	mE('div_14347');
            mE('div_13512');
           

        }
        
        if(existeValorMatriz(arrDecretaPruebas,gE('sp_12817').innerHTML,1)!=-1)
        {
        	mE('div_14337');
            mE('div_19735');
            

        }
        
        
        gE('sp_15884').innerHTML='';
        gE('sp_15885').innerHTML='';
        gE('sp_15886').innerHTML='';
        
        if(errorLLenadoFechaAudiencia)
        {
        	gE('sp_15884').innerHTML='<a href="javascript:editRegistro()" style="color:#F00"><img src="../principalPortal/imagesSIUGJ/error.png" width="20" height="20"  /> Debe indicar la fecha de la audiencia a programar</a>';
        }
        
        
        if(errorLLenadoDecretaPruebas)
        {
        	gE('sp_15886').innerHTML='<a href="javascript:editRegistro()" style="color:#F00"><img src="../principalPortal/imagesSIUGJ/error.png" width="20" height="20"  /> Debe indicar si se decreta pruebas</a>';
        }
        
        if(errorLLenadoSentencia)
        {
        	gE('sp_15885').innerHTML='<a href="javascript:editRegistro()" style="color:#F00"><img src="../principalPortal/imagesSIUGJ/error.png" width="20" height="20"  /> Debe indicar el sentido de la sentencia/fallo</a>';
        }
        
        
    }
}


function editRegistro()
{
	modificarRegistro(gE('idRegistroG').value);
}

