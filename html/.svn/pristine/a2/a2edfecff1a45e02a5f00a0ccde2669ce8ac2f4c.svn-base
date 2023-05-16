<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);
	
	$consulta="SELECT salaPenalSugerida,existeAntecedenteSala,carpetaAdministrativa FROM _451_tablaDinamica WHERE id__451_tablaDinamica=".$idReferencia;
	$filaRegistroBase=$con->obtenerPrimeraFila($consulta);
	$salaPenalSugerida=$filaRegistroBase[0];
	$cAdministrativa=$filaRegistroBase[2];
	
	$consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cAdministrativa."'";
	$codigoInstitucion=$con->obtenerValor($consulta);
	
	$arrSalas="";
	$o="['".$filaRegistroBase[0]."','".$filaRegistroBase[1]."','Sala penal sugerida por SIGJ','','".($filaRegistroBase[1]==1?" (Indicado por UGJ, existe antecedente)":"")."']";
	if($arrSalas=="")
		$arrSalas=$o;
	else
		$arrSalas.=",".$o;
	$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica WHERE cmbCategoria=3 ";
	$arrSalasPenales=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT salaPenal,comentariosAdicionales,antecedenteSala FROM _618_tablaDinamica WHERE idReferencia=".$idReferencia;
	$filaSalaPenalSugeridaAuxiliar=$con->obtenerPrimeraFila($consulta);
	if($filaSalaPenalSugeridaAuxiliar)
	{
		
		$o="['".$filaSalaPenalSugeridaAuxiliar[0]."','".$filaSalaPenalSugeridaAuxiliar[2]."','Sala penal sugerida por Auxiliar JUD de Control','".cv($filaSalaPenalSugeridaAuxiliar[1])."','".($filaSalaPenalSugeridaAuxiliar[2]==1?" (Existe antecedente)":"")."']";
		if($arrSalas=="")
			$arrSalas=$o;
		else
			$arrSalas.=",".$o;
	}
	
	
	$consulta="SELECT salaPenal,comentariosAdicionales,antecedenteSala FROM _617_tablaDinamica WHERE idReferencia=".$idReferencia;
	$filaSalaPenalSugeridaJUDControl=$con->obtenerPrimeraFila($consulta);
	if($filaSalaPenalSugeridaJUDControl)
	{
		
		$o="['".$filaSalaPenalSugeridaJUDControl[0]."','".$filaSalaPenalSugeridaJUDControl[2]."','Sala penal sugerida por JUD de Control','".cv($filaSalaPenalSugeridaJUDControl[1])."','".($filaSalaPenalSugeridaJUDControl[2]==1?" (Existe antecedente)":"")."']";
		if($arrSalas=="")
			$arrSalas=$o;
		else
			$arrSalas.=",".$o;
	}
	
	$consulta="SELECT tipoMateria FROM _17_tablaDinamica WHERE claveUnidad='".$codigoInstitucion."'";
	$tMateria=$con->obtenerValor($consulta);
	
	
	$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica WHERE cmbCategoria=3 AND tipoMateria=".$tMateria." ORDER BY prioridad";
	$arrSalasPermitidas=$con->obtenerFilasArreglo($consulta);
	
?>	
var arrSalasPermitidas=<?php echo $arrSalasPermitidas?>;
var arrExisteAntecedente=[<?php echo $arrSalas?>];
var arrSalasPenales=<?php echo $arrSalasPenales?>;

function inyeccionCodigo()
{
	var lblEtiqueta="";
    var x;
    var e;
    var fila;
    for(x=0;x<arrExisteAntecedente.length;x++)
    {
    	fila=arrExisteAntecedente[x];
    	comp=''
		if(fila[3]!='')
        {
        	comp=' <img src="../images/icon_comment.gif" title="'+escaparBR(fila[3],true)+'" alt="'+escaparBR(fila[3],true)+'">';
        }
        
    	e='<b>'+fila[2]+':</b> '+formatearValorRenderer(arrSalasPenales,fila[0])+fila[4]+comp;
    	if(lblEtiqueta=='')
        	lblEtiqueta=e;
        else	
        	lblEtiqueta+='<br>'+e;				
    }    
	if(esRegistroFormulario())
    {
    	if(gE('idRegistroG').value=='-1')
        {
        	                 
                        
        	selElemCombo(gE('_salaPenalvch'),fila[0]);
            
            
            gE('opt_antecedenteSalavch_'+fila[1]).checked=true;
            selOpcion(gE('opt_antecedenteSalavch_'+fila[1]));
        }
        
        
        var _salaAntecedentevch=gE('_salaPenalvch');
        var x;
        for(x=0;x<_salaAntecedentevch.options.length;x++)
        {
        	if(_salaAntecedentevch.options[x].value!='-1')
            {
                if(existeValorMatriz(arrSalasPermitidas,_salaAntecedentevch.options[x].value)==-1)
                {
                    _salaAntecedentevch.options[x]=null;
                    x--;
                }
			}
        }
    }
    gE('sp_9500').innerHTML=lblEtiqueta;
    

}	
