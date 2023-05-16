<?php
	session_start();

	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$idFormulario=bD($_GET["iF"]);

	$idRegistro=bD($_GET["iR"]);
	
	$idReferencia=($_GET["iRef"]);


	$fechaActual=date("Y-m-d")	;

	$horaActual=date("H:i");

	
	$consulta="SELECT id__857_tablaDinamica,CONCAT('(',cveMedida,') ',medidaCautelar) AS medidaCautelar FROM _857_tablaDinamica WHERE tipoMedida=4 ORDER BY id__857_tablaDinamica";
	$arrImpedimentoOrdinario=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__857_tablaDinamica,CONCAT('(',cveMedida,') ',medidaCautelar) AS medidaCautelar FROM _857_tablaDinamica WHERE tipoMedida=8 ORDER BY id__857_tablaDinamica";
	$arrImpedimentoTutela=$con->obtenerFilasArreglo($consulta);


	$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso(696,$idReferencia);
	$consulta="SELECT tipoProceso FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
	$tipoCarpetaAdministrativa=$con->obtenerValor($consulta);
	
	$arrMotivoImpedimento=$arrImpedimentoOrdinario;
	if($tipoCarpetaAdministrativa==6)
	{
		$arrMotivoImpedimento=$arrImpedimentoTutela;
	}
?>

var arrMotivoImpedimento=<?php echo $arrMotivoImpedimento?>;


function inyeccionCodigo()
{

    if(esRegistroFormulario())
    {
    
    	
        
        
    	                
        if(gE('idRegistroG').value=='-1')
        {
        	
            if(gEx('f_sp_fechaRecepciondte')) 
            {
             	gEx('f_sp_fechaRecepciondte').setValue('<?php echo $fechaActual?>');
             	gEx('f_sp_fechaRecepciondte').fireEvent('change', gEx('f_sp_fechaRecepciondte'), gEx('f_sp_fechaRecepciondte').getValue());

             	gEx('f_sp_fechaRecepciondte').fireEvent('select', gEx('f_sp_fechaRecepciondte'));
             }

             if(gEx('f_sp_horaRecepciontme'))
             {
	         	gEx('f_sp_horaRecepciontme').setValue('<?php echo $horaActual?>');
             	gEx('f_sp_horaRecepciontme').fireEvent('change', gEx('f_sp_horaRecepciontme'), gEx('f_sp_horaRecepciontme').getValue());
             }   
            
            llenarCombo(gE('_causalImpedimentovch'),arrMotivoImpedimento,true);
             
                  	
        }
        else
        {
        	var optionSel=gE('_causalImpedimentovch').options[gE('_causalImpedimentovch').selectedIndex].value;
            llenarCombo(gE('_causalImpedimentovch'),arrMotivoImpedimento,true);
            selElemCombo(gE('_causalImpedimentovch'),optionSel);
        }
        
        
        
    }
    else
    {
    	
    }
}

