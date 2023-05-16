<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	
	$fechaActual=date("Y-m-d")	;
	
	$horaActual=date("H:i");
?>



function inyeccionCodigo()
{
	
    
    
    gE('sp_10482').innerHTML='';
    if(esRegistroFormulario())
    {
    	
       if(gE('idRegistroG').value=='-1')
      {
          
          
          if(gEx('f_sp_fechaActuaciondte'))
          {
         
              gEx('f_sp_fechaActuaciondte').setValue('<?php echo $fechaActual?>');
           
              gEx('f_sp_fechaActuaciondte').fireEvent('change', gEx('f_sp_fechaActuaciondte'), gEx('f_sp_fechaActuaciondte').getValue());
              gEx('f_sp_fechaActuaciondte').fireEvent('select', gEx('f_sp_fechaActuaciondte'));
           }
           
           if(gEx('f_sp_horaActuaciontme'))
           {

              gEx('f_sp_horaActuaciontme').setValue('<?php echo $horaActual?>');
              gEx('f_sp_horaActuaciontme').fireEvent('change', gEx('f_sp_horaActuaciontme'), gEx('f_sp_horaActuaciontme').getValue());
           }
          
      } 
       
      gEx('ext__carpetaAdministrativavch').on('select',function(cmb,registro)
      												{
                                                    	obtenerInfoProcesoJudicial(registro.data.id);
                                                    }
      										) 
    
        
	}
    else
    {
    	obtenerInfoProcesoJudicial(gE('sp_10076').innerHTML);
       
    }
    	
    
  
	


}


function obtenerInfoProcesoJudicial(cupj)
{
	function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
         	var obj=eval('['+arrResp[1]+']')[0];  
            gE('sp_10482').innerHTML= obj.leyenda ;
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',funcAjax, 'POST','funcion=2&cupj='+cupj,true);
    
}
