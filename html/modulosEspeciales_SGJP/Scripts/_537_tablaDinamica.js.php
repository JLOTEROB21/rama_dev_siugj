<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);
	
	$fechaActual=date("Y-m-d");
	$horaActual=date("H:i");
	
	$consulta="SELECT idCarpetaAdministrativa FROM _536_tablaDinamica WHERE id__536_tablaDinamica=".$idReferencia;
	$idCarpetaAdministrativa=$con->obtenerValor($consulta);
?>
var idCarpetaAdministrativa=<?php echo $idCarpetaAdministrativa?>;
var cadObjBusqueda='';
var fechaActual='<?php echo $fechaActual?>';
var horaActual='<?php echo $horaActual ?>';

function inyeccionCodigo()
{

	if(esRegistroFormulario())
    {
    	
        
        if(gE('idRegistroG').value=='-1')
        {
            gEx('f_sp_fechaPeritajedte').setValue(fechaActual);
        
            gEx('f_sp_fechaPeritajedte').fireEvent('change', gEx('f_sp_fechaPeritajedte'), gEx('f_sp_fechaPeritajedte').getValue());
    
            
            
            
                        
                        
			                                 
            
        }
        
        
        gEN('_idCarpetaAdministrativavch')[0].value=idCarpetaAdministrativa; 
         
         
         
         
		
         

    }
    else
    {
    	
        
	}
    
    
    
    
    
    
	
}  

