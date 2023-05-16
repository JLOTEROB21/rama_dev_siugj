<?php
	session_start();

	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$idFormulario=bD($_GET["iF"]);

	$idRegistro=bD($_GET["iR"]);


	$fechaActual=date("Y-m-d")	;

	$horaActual=date("H:i");

	$idActividad=-1;
	
	if($idRegistro==-1)
		$idActividad=generarIDActividad($idFormulario);



?>




var idActividad='<?php echo $idActividad?>';

if(typeof(arrFuncionesValidacionEdit)=='undefined')
	arrFuncionesValidacionEdit={};

function inyeccionCodigo()
{
	if(esRegistroFormulario())
    {
    
    	  
                        
        if(gE('idRegistroG').value=='-1')
        {
            if(gEx('f_sp_fechaRecepcionRegistroTuteladte')) 
            {
             	gEx('f_sp_fechaRecepcionRegistroTuteladte').setValue('<?php echo $fechaActual?>');
             	gEx('f_sp_fechaRecepcionRegistroTuteladte').fireEvent('change', gEx('f_sp_fechaRecepcionRegistroTuteladte'), gEx('f_sp_fechaRecepcionRegistroTuteladte').getValue());

             	gEx('f_sp_fechaRecepcionRegistroTuteladte').fireEvent('select', gEx('f_sp_fechaRecepcionRegistroTuteladte'));
             }

             if(gEx('f_sp_horaRecepcionRegistroTutelatme'))
             {
	             gEx('f_sp_horaRecepcionRegistroTutelatme').setValue('<?php echo $horaActual?>');

             	gEx('f_sp_horaRecepcionRegistroTutelatme').fireEvent('change', gEx('f_sp_horaRecepcionRegistroTutelatme'), gEx('f_sp_horaRecepcionRegistroTutelatme').getValue());
             }   
             
             
                  	
        }
      
        <?php if(existeRol("'23_0'"))
			{
		?>
        		gEx('f_sp_fechaRecepcionRegistroTuteladte').disable();
                gEx('f_sp_horaRecepcionRegistroTutelatme').disable();
                
        <?php
			}
		
		?>
        
        
        
        if(gE('idRegistroG').value=='-1')
        {
            gEN('_idActividadvch')[0].value=idActividad;
        }
        else
            idActividad=gEN('_idActividadvch')[0].value;
        
    
    	arrFuncionesValidacionEdit.funcionValidacionGrid_12550=function(grid,obj)
                                                        {

                                                        	var fila;
                                                            var x;
                                                            for(x=0;x<grid.getStore().getCount();x++)
                                                            {
                                                            	fila=grid.getStore().getAt(x);
                                                                if(fila.data.derechoVulnerableRegistroTutela==obj.derechoVulnerableRegistroTutela)
                                                                {
                                                                	msgBox('El derecho vulnerado ya ha sido agregado anteriormente');
                                                                	return false;
                                                                }

                                                            }
                                                            return true;
                                                        }
    
    }
    else
    {
    	
    }
    
    
}






