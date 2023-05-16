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
	
    
    
    gE('sp_10846').innerHTML='';
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
    	obtenerInfoProcesoJudicial(gE('sp_10845').innerHTML);
        
       
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
            gE('sp_10846').innerHTML= obj.leyenda ;
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',funcAjax, 'POST','funcion=25&idFormulario=682&cupj='+cupj,true);
    
}


function abrirExpedienteProcesoJudicial(c)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJ/tableroAudienciaAdministracion.php';
    obj.params=[['cA',(c)],['idCarpetaAdministrativa',-1],['sL','1']];
    obj.titulo='Proceso Judicial: '+bD(c);
    abrirVentanaFancy(obj);
    
}
