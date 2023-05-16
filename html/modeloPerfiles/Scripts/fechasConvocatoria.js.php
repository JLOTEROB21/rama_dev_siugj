<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$idFormulario=$_GET["idFormulario"];
	$idProceso=obtenerIdProcesoFormulario($idFormulario);
	$consulta="SELECT configuracion FROM 203_configuracionModuloDTD WHERE idModulo=11 AND idProceso=".$idProceso;
	$cadConf=$con->obtenerValor($consulta);
	$listTiposPermitidos="";
	if($cadConf=="")
	{
		$cadConf='{"fPublicacion":"1","fRegistro":"1","fEvaluacion":"1","solCiclo":"1"}';
	}
	
	$conf=json_decode($cadConf);
	
	
?>

Ext.onReady(inicializar);

function inicializar()
{	
    var fechaMinima='';
    var fechaMaxima='';
    
    crearCampoFecha('publicacionI','fechaIpublicacion');
	crearCampoFecha('publicacionF','fechaFpublicacion');
    <?php
		if($conf->fRegistro)
		{
	?>
    crearCampoFecha('registroI','fechaIregistro');
	crearCampoFecha('registroF','fechaFregistro');
    <?php
		}
		if($conf->fEvaluacion)
		{
	?>
    
    crearCampoFecha('evaluacionI','fechaIevaluacion');
	crearCampoFecha('evaluacionF','fechaFevaluacion');
    <?php
		}
	?>
}

function guardar()
{
    var idFormulario=gE('idFormulario').value;
    var idRegistro=gE('idRegistro').value;
    
    var fIniP=gEx('f_publicacionI').getValue();
    var fFinP=gEx('f_publicacionF').getValue();
    var ciclo=0;
    if(fFinP< fIniP)
    {
    	Ext.MessageBox.alert(lblAplicacion,'La fecha de termino de publicaci&oacute;n de convocatoria no puede ser menor a la fecha de inicio de publicaci&oacute;n de convocatoria');
        return;
    }
    <?php
		if($conf->fRegistro)
		{
	?>
            var fIniR=gEx('f_registroI').getValue();
            var fFinR=gEx('f_registroF').getValue();
            
            if(fFinR< fIniR)
            {
                Ext.MessageBox.alert(lblAplicacion,'La fecha de termino de registro no puede ser menor a la fecha de inicio de registro');
                return;
            }
            
            if(fIniR< fIniP)
            {
                Ext.MessageBox.alert(lblAplicacion,'La fecha de inicio de registro no puede ser menor a la fecha de inicio de publicaci&oacute;n');
                return;
            }
    <?php
		}
		else
		{
	?>
			var fIniR='NULL';
		    var fFinR='NULL';
	<?php            
		}
	?>
    <?php
		if($conf->fEvaluacion)
		{
	?>
            var fIniE=gEx('f_evaluacionI').getValue();
            var fFinE=gEx('f_evaluacionF').getValue();
            
            if(fIniE > fFinE)
            {
                Ext.MessageBox.alert(lblAplicacion,'La fecha de termino de evaluaci&oacute;n no puede ser menor a la fecha de inicio de evaluaci&oacute;n');
                return;
            }
            
            if(fIniE< fIniR)
            {
                Ext.MessageBox.alert(lblAplicacion,'la fecha de inicio de evaluacion no puede ser menor a la fecha de inicio de registro');
                return;
            }
	<?php
		}
		else
		{
	?>
    		var fIniE='NULL';
            var fFinE='NULL';
    <?php	
		}
	?>            
    
    
    
    fIniP=gEx('f_publicacionI').getValue().format('Y-m-d');
    fFinP=gEx('f_publicacionF').getValue().format('Y-m-d');
     <?php
		if($conf->fRegistro)
		{
	?>
            fIniR=gEx('f_registroI').getValue().format('Y-m-d');
            fFinR=gEx('f_registroF').getValue().format('Y-m-d');
	<?php
		}
	
		if($conf->fEvaluacion)
		{
	?>
            fIniE=gEx('f_evaluacionI').getValue().format('Y-m-d');
            fFinE=gEx('f_evaluacionF').getValue().format('Y-m-d');
    <?php
		}
	?>
    
    <?php
    if($conf->solCiclo==1)
	{
		?>
		ciclo=gE('ciclo').options[gE('ciclo').selectedIndex].value;
	<?php        
	}
	?>
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	function funcResp()
            {
            	if(typeof(funcAgregar)!='undefined')
                	funcAgregar();
            }
			msgBox('Los datos han sido guardados satisfactoriamente',funcResp);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=310&ciclo='+ciclo+'&fIniP='+fIniP+
    																						 '&fFinP='+fFinP+
                                                                                             '&fIniR='+fIniR+
                                                                                             '&fFinR='+fFinR+
                                                                                             '&fIniE='+fIniE+
                                                                                             '&fFinE='+fFinE+
                                                                                             '&idFormulario='+idFormulario+
                                                                                             '&idRegistro='+idRegistro,true);
}

