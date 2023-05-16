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
	gE('sp_10728').innerHTML='';
	if(esRegistroFormulario())
    {
    	
       if(gE('idRegistroG').value=='-1')
      {
          
          
          if(gEx('f_sp_fechaSentenciadte'))
          {
         
              gEx('f_sp_fechaSentenciadte').setValue('<?php echo $fechaActual?>');
           
              gEx('f_sp_fechaSentenciadte').fireEvent('change', gEx('f_sp_fechaSentenciadte'), gEx('f_sp_fechaSentenciadte').getValue());
              gEx('f_sp_fechaSentenciadte').fireEvent('select', gEx('f_sp_fechaSentenciadte'));
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
    	obtenerInfoProcesoJudicial(gE('sp_10175').innerHTML);
       
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
            gE('sp_10728').innerHTML= obj.leyenda ;
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',funcAjax, 'POST','funcion=2&cupj='+cupj,true);
    
}
