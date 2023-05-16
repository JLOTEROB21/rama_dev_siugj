<?php
	session_start();

	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$idFormulario=bD($_GET["iF"]);

	$idRegistro=bD($_GET["iR"]);

	$idRef=($_GET["iRef"]);

	$fechaActual=date("Y-m-d")	;

	$horaActual=date("H:i");

	$consulta="SELECT carpetaAdministrativa FROM _1162_tablaDinamica WHERE id__1162_tablaDinamica=".$idRef;
	$carpetaAdministrativa=$con->obtenerValor($consulta);
	
	$consulta="SELECT idFormulario,idRegistro FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
	$fRegistroCarpeta=$con->obtenerPrimeraFIlaAsoc($consulta);
	
	$cuantia="";

	switch($fRegistroCarpeta["idFormulario"])
	{
		case 1163:
			$consulta="SELECT cuantia FROM _1163_tablaDinamica WHERE id__1163_tablaDinamica=".$fRegistroCarpeta["idRegistro"];
			$cuantia=$con->obtenerValor($consulta);	
		break;
		case 1204:
		
			$consulta="SELECT montoCostes FROM _1204_tablaDinamica WHERE id__1204_tablaDinamica=".$fRegistroCarpeta["idRegistro"];
			$cuantia=$con->obtenerValor($consulta);	
		break;
	}
	
	



?>
var cadenaFuncionValidacion='validarSumaDeposito';
var cuantia=<?php echo $cuantia?>;


arrFuncionesValidacionEdit.funcionValidacionGrid_15515=function(grid,obj)
														{
                                                        	console.log(obj);
                                                        }
				

function inyeccionCodigo()
{
	
	
}

function beforeEdit_15515(rowEdit,fila)
{
	gEx('editor_porcentaje').on('change',function(ctrl,nuevoValor,viejoValor)
    									{
                                        	gEx('editor_montoAsignacion').setValue(cuantia*(nuevoValor/100));
                                        }
    						)
    gEx('editor_montoAsignacion').on('change',function(ctrl,nuevoValor,viejoValor)
    									{
                                        	var pocentaje=(nuevoValor*100)/cuantia;
                                        	gEx('editor_porcentaje').setValue(pocentaje);
                                        }
                                     )
}


function funcEditorValidaCampoGrid_15515(rowEdit,obj,registro,nFila)
{
	
    
    var grid=gEx('grid_15515');
    var x;
    var fila;
    var porcentajeTotal=parseFloat(obj.porcentaje);
    for(x=0;x<grid.getStore().getCount();x++)
    {
    	fila=grid.getStore().getAt(x);
        if(fila.id!=registro.id)
        {
        	if(fila.data.idBenficiario==obj.idBenficiario)
            {
            	msgBox('El beneficiario ya ha sido agregado anteriormente');
            	return false;
            }
            porcentajeTotal+=fila.data.porcentaje;
        }
        
        
    }
    if(porcentajeTotal>100)
    {
    	msgBox('La suma total del porcentaje no puede exceder a 100%');
    	return false;
    }
    
    return true;
    
    
    
}


function validarSumaDeposito()
{
	var x;
    var fila;
    var grid=gEx('grid_15515');
    var sumaTotal=0;
    for(x=0;x<grid.getStore().getCount();x++)
    {
    	fila=grid.getStore().getAt(x);
        sumaTotal+=parseFloat(fila.data.porcentaje);
        
        
    }

    if(sumaTotal!=100)
    {
    	msgBox('La suma total del porcentaje debe ser igual a 100%');
    	return false;
    }
    
    return true;
}