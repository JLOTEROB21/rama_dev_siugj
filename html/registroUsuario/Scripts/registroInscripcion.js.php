<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="select idPais,nombre from 238_paises order by nombre";
	$arrPaises=uEJ($con->obtenerFilasArreglo($consulta));
?>

Ext.onReady(inicializar);

function inicializar()
{
	gE('txtApPaterno').focus();
	crearCampoFecha('dteFechaNac','hFechaNac');
   
}

function agregarAutor()
{
	var apPaterno=gE('txtApPaterno');
    var apMaterno=gE('txtApMaterno');
    var nombre=gE('txtNombre');
    var fNacimiento=gEx('f_dteFechaNac');
    if(apPaterno.value.trim()=='')
    {
    	function resp10()
        {
        	apPaterno.focus();
        }
        msgBox('Debe ingresar su apellido paterno',resp10);
        return;
    }
    
    if(nombre.value.trim()=='')
    {
    	function resp11()
        {
        	nombre.focus();
        }
        msgBox('Debe ingresar su nombre',resp11);
        return;
    }
    
    if(fNacimiento.getValue()=='')
    {
    	function resp12()
        {
        	fNacimiento.focus();
        }
        msgBox('Debe ingresar su fecha de nacimiento',resp12);
        return;
    }
    
    
	var mail=gE('txtMail').value;
    var mail2=gE('txtMail2').value;
	if(!validarCorreo(mail))
	{
		function funcAceptar2()
		{
			gE('txtMail').focus();
			
		}
		Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','La direcci&oacute;n de correo electr&oacute;nico ingresada no es v&aacute;lida',funcAceptar2);
		return;
	}

	if(mail!=mail2)
    {
    	function respMail()
        {
        	gE('txtMail').focus();
        }
    	msgBox('Las direcciones de correo electr&oacute;nico ingresadas no coinciden',respMail);
    	return;
    }

	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
                var idProceso=gE('idProceso').value;
                var sexo=0;
                if(gE('sexoF').checked)
                	sexo=1;
                var objOferta='{"idInstancia":"'+gE('idInstancia').value+'","idCiclo":"'+gE('idCiclo').value+'","idPeriodo":"'+gE('idPeriodo').value+'"}';
                var datosAutor='{"sexo":"'+sexo+'","idProceso":"'+idProceso+'","apPaterno":"'+cv(apPaterno.value)+'","apMaterno":"'+cv(apMaterno.value)+'","nombres":"'+cv(nombre.value)+'","email":"'+cv(mail)+
                			'","fechaNacimiento":"'+fNacimiento.getValue().format("Y-m-d")+'","telCasa":"'+gE('txtTelefono').value+'","telMovil":"'+gE('txtTelefonoMovil').value+'","objDatosOfertaEducativa":'+objOferta+'}';
                function funcGuardar()
                {
                    var arrResp=peticion_http.responseText.split("|");
                    if(arrResp[0]=='1')
                    {
                    	function respMail()
                        {
                        	if(window.parent.cerrarVentanaFancy!=undefined)
                            {
                            	window.parent.cerrarVentanaFancy();

                            }
                            else
                            {
                            	location.href='../principal/inicio.php';
                            }
                        }
                     	msgBox('Su cuenta ha sido registrada de manera exitosa, en breve recibir&aacute; un correo electr&oacute;nico con sus datos de acceso',respMail);   
                        return;
                    }
                    else
                        msgBox('<?php echo $etj["errOperacion"].' '?>'+arrResp[0]);
                }
                obtenerDatosWeb("../paginasFunciones/funcionesProyectos.php",funcGuardar,'POST','funcion=194&'+'datosAutor='+datosAutor,true);//33
            
        }
        else
        {
        	if(arrResp[0]==2)
            {
            	msgBox('La direcci&oacute;n de correo electr&oacute;nico ingresada ya ha sido registrada previamente. <br /><br />Si ya se registr&oacute; anteriormente puede recuperar sus datos seleccionando la opción <b>Recuperar contraseña</b> en la secci&oacute;n "<b>Ingresar</b>"');
            }
            else
            	msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=192&mail='+cv(mail),true);
}


function nivelAcademicoSel(cmb)
{
	var valor=cmb.options[cmb.selectedIndex].value;
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var cmbCarrera=gE('cmbCarrera');
            var arrDatos=eval(arrResp[1]);
            llenarCombo(cmbCarrera,arrDatos,true);
            
            var cmbPlantel=gE('cmbPlantel');
            llenarCombo(cmbPlantel,[],true);
            var cmbModalidad=gE('cmbModalidad');
            llenarCombo(cmbModalidad,[],true);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesPlanteles.php',funcAjax, 'POST','funcion=70&idNivel='+valor,true);

}

function carreraSel(cmb)
{
	var valor=cmb.options[cmb.selectedIndex].value;
	var cmbNivel=gE('cmbNivel');
	var idNivel=cmbNivel.options[cmbNivel.selectedIndex].value;
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var cmbModalidad=gE('cmbModalidad');
            var arrDatos=eval(arrResp[1]);
            llenarCombo(cmbModalidad,arrDatos,true);
            var cmbPlantel=gE('cmbPlantel');
            llenarCombo(cmbPlantel,[],true);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesPlanteles.php',funcAjax, 'POST','funcion=71&idNivel='+idNivel+'&carrera='+valor,true);
}

function modalidadSel(cmb)
{
	var valor=cmb.options[cmb.selectedIndex].value;
	var cmbNivel=gE('cmbNivel');
	var idNivel=cmbNivel.options[cmbNivel.selectedIndex].value;
    var cmbCarrera=gE('cmbCarrera');
    var carrera=cmbCarrera.options[cmbCarrera.selectedIndex].value;
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var cmbPlantel=gE('cmbPlantel');
            var arrDatos=eval(arrResp[1]);
            llenarCombo(cmbPlantel,arrDatos,true);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesPlanteles.php',funcAjax, 'POST','funcion=72&idNivel='+idNivel+'&carrera='+carrera+'&idModalidad='+valor,true);
}


