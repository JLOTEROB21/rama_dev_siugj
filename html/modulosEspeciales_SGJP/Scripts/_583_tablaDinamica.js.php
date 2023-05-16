<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);
	
	
	$consulta="SELECT salaPenalSugerida,existeAntecedenteSala FROM _451_tablaDinamica WHERE id__451_tablaDinamica=".$idReferencia;
	$filaInformacionUGA=$con->obtenerPrimeraFila($consulta);
	
	$salaPenalSugerida=$filaInformacionUGA[0];
	
	$consulta="SELECT salaPenal,comentariosAdicionales,antecedenteSala FROM _581_tablaDinamica WHERE idReferencia=".$idReferencia;

	$filaSalaPenalSugeridaRespDEGJ=$con->obtenerPrimeraFila($consulta);
	$salaPenalSugerida1=$filaSalaPenalSugeridaRespDEGJ[0];
	
	$consulta="SELECT salaPenal,comentariosAdicionales,antecedenteSala FROM _582_tablaDinamica WHERE idReferencia=".$idReferencia;
	$filaSalaPenalSugerida2=$con->obtenerPrimeraFila($consulta);
	$salaPenalSugerida2=$filaSalaPenalSugerida2[0];
	
	$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica WHERE cmbCategoria=3 ";
	$arrSalasPenales=$con->obtenerFilasArreglo($consulta);
?>	

var antecedenteSala582='<?php echo $filaSalaPenalSugerida2[2]?>';
var antecedenteSala581='<?php echo $filaSalaPenalSugeridaRespDEGJ[2]?>';
var antecedenteSalaUGA='<?php echo $filaInformacionUGA[1]?>';

var arrSalasPenales=<?php echo $arrSalasPenales?>;
var salaPenalSugerida='<?php echo $salaPenalSugerida?>';
var salaPenalSugerida1='<?php echo $salaPenalSugerida1?>';
var salaPenalSugerida2='<?php echo $salaPenalSugerida2?>';

var comentariosRespDEGJ='<?php echo $filaSalaPenalSugerida2[1]?>';
var comentariosSubdirDEGJ='<?php echo $filaSalaPenalSugerida2[1]?>';
function inyeccionCodigo()
{
	     
	if(esRegistroFormulario())
    {
    	if(gE('idRegistroG').value=='-1')
        {
        	
                                 
                        
        	selElemCombo(gE('_salaPenalvch'),salaPenalSugerida);
            
           
            
            if(salaPenalSugerida1!='')
    		{
            	selElemCombo(gE('_salaPenalvch'),salaPenalSugerida1);
                gE('opt_antecedenteSalavch_'+antecedenteSala581).checked=true;
            	selOpcion(gE('opt_antecedenteSalavch_'+antecedenteSala581));
            }
            if(salaPenalSugerida2!='')
    		{
            	selElemCombo(gE('_salaPenalvch'),salaPenalSugerida2);
                gE('opt_antecedenteSalavch_'+antecedenteSala582).checked=true;
	            selOpcion(gE('opt_antecedenteSalavch_'+antecedenteSala582));
            }
            
            
            
            
        }
    }
    
    gE('sp_9502').innerHTML='<b>Sala penal sugerida por SIGJ:</b> '+formatearValorRenderer(arrSalasPenales,salaPenalSugerida)+	
    			(antecedenteSalaUGA=='0'?'':(' (Indicado por UGJ, existe antecedente)'));
    if(salaPenalSugerida1!='')
    {
    	var comp=''
		if(comentariosRespDEGJ!='')
        {
        	comp=' <img src="../images/icon_comment.gif" title="'+escaparBR(comentariosRespDEGJ,true)+'" alt="'+escaparBR(comentariosRespDEGJ,true)+'">';
        }		
		
    	gE('sp_9502').innerHTML+='<br><b>Sala penal sugerida por Sub. de Control:</b> '+formatearValorRenderer(arrSalasPenales,salaPenalSugerida1)+
         (salaPenalSugerida1==salaPenalSugerida?'':(' (Indicado por Subdir.'+(antecedenteSala581=='1'?', existe antecedente)':')')))+comp;
    }
    
    if(salaPenalSugerida2!='')
    {
    	var comp=''
		if(comentariosSubdirDEGJ!='')
        {
        	comp=' <img src="../images/icon_comment.gif" title="'+escaparBR(comentariosSubdirDEGJ,true)+'" alt="'+escaparBR(comentariosSubdirDEGJ,true)+'">';
        }		
		
    	gE('sp_9502').innerHTML+='<br><b>Sala penal sugerida por Dir. de Unidad de G.:</b> '+formatearValorRenderer(arrSalasPenales,salaPenalSugerida2)+
        (salaPenalSugerida1==salaPenalSugerida2?'':(' (Indicado por Dir.'+(antecedenteSala582=='1'?', existe antecedente)':')')))+comp;
    }

}	
