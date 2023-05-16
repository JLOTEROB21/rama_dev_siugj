<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
	
	$iF=$_GET["iF"];
	$iR=bD($_GET["iR"]);
	$iRef=$_GET["iRef"];
	
	$consulta="SELECT fechaRequerido,dteHoraRequerido FROM _293_tablaDinamica WHERE id__293_tablaDinamica=".$iRef;
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	$fRequerido=$fRegistro[0]." ".$fRegistro[1];
	$lblFRequerido=date("d/m/Y H:i:s",strtotime($fRequerido));
?>


var fRequerido='<?php echo $fRequerido?>';
var lblFRequerido='<?php echo $lblFRequerido?>';



function inyeccionCodigo()
{
	if(esRegistroFormulario())
    {
         gEx('f_sp_fechaRecepciondte').setValue('<?php echo $fechaActual?>');
         
         gEx('f_sp_fechaRecepciondte').fireEvent('change', gEx('f_sp_fechaRecepciondte'), gEx('f_sp_fechaRecepciondte').getValue());

         
         gEx('f_sp_fechaRecepciondte').on('change',calcularDiferencia);
         
         gEx('f_sp_horaRecepciontme').setValue('<?php echo $horaActual?>');
         gEx('f_sp_horaRecepciontme').fireEvent('change', gEx('f_sp_horaRecepciontme'), gEx('f_sp_horaRecepciontme').getValue());
         
         gEx('f_sp_horaRecepciontme').on('change',calcularDiferencia);
       	 <?php
		 if($iR==-1)
		 	echo "calcularDiferencia();";
		 ?>
         
        
	}
    else
    {
    	if((gE('sp_5061').innerHTML=='Sí')||(gE('sp_5061').innerHTML=='Si'))
        {
        	
        }
        else
        {
        	oE('div_5062');
            oE('div_5063');
            oE('div_5064');
        }
    }
    
    gE('sp_7152').innerHTML=lblFRequerido;
}

function calcularDiferencia()
{
	var dteFechaRequerida=Date.parseDate(fRequerido,'Y-m-d H:i:s');
    var lblFechaRecepcion=gEx('f_sp_fechaRecepciondte').getValue().format('Y-m-d')+' '+gEx('f_sp_horaRecepciontme').getValue();
    
  	var dteFechaRecepcion=Date.parseDate(lblFechaRecepcion,'Y-m-d H:i'); 

   
    var minutos= Math.round((dteFechaRequerida-dteFechaRecepcion)/60000);
    gE('_diferenciavch').innerHTML=minutos;
    gEN('_diferenciavch')[0].value=minutos;
    
    if(minutos>0)
    {
    	gE('opt_existeRetrasovch_0').checked=true;
        lanzarEvento('opt_existeRetrasovch_0','click',gE('opt_existeRetrasovch_0'));
    }
    else
    {
    	gE('opt_existeRetrasovch_1').checked=true;
        lanzarEvento('opt_existeRetrasovch_1','click',gE('opt_existeRetrasovch_1'));
    }
    
}

