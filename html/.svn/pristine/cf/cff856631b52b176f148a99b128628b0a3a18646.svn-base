<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$consulta="SELECT codigoUnidad,unidad,(SELECT email FROM 247_instituciones WHERE idOrganigrama=o.idOrganigrama limit 0,1) as mail FROM 817_organigrama o 
				WHERE instColaboradora=1 and institucion=1 ORDER BY unidad";
	$arrInstituciones=$con->obtenerFilasArreglo($consulta);				
	
?>
Ext.onReady(inicializar);

function inicializar()
{

	var arrInstituciones=<?php echo $arrInstituciones?>;
	var obj={renderTo:'cmbOrganizacion',
    		confVista:'<tpl for="."><div class="search-item">{nombre}<br><span class="letraRojaSubrayada8">Email: </span>{valorComp}<br>-----</div></tpl>'
    		};
	crearComboExt('cmbInstituciones',arrInstituciones,0,0,550,obj);
}


function recuperarDatosAccesoOSC()
{
	var cmbInstituciones=gEx('cmbInstituciones');
    if(cmbInstituciones.getValue()=="")
    {
    	msgBox('Debe seleccionar la instituci&oacute;n cuyos datos de acceso desea obtener');
    	return;
    }
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	function respFinal()
            {
            	window.parent.cerrarVentanaFancy();
            }
            msgBox('Los datos de acceso han sido enviados a la cuenta de correo asociada a la instituci&oacute;n',respFinal);
            

        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesEspeciales.php',funcAjax, 'POST','funcion=19&idInstitucion='+cmbInstituciones.getValue(),true);

    
}