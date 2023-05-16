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
       
    
    
    }
    else
    {
    	
        //gE('sp_10777').innerHTML='<a href="javascript:abrirExpedienteProcesoJudicial(\''+bE(gE('sp_10777').innerHTML)+'\')">'+gE('sp_10777').innerHTML+'</a>'
       
    }
    	
    
  
	


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
