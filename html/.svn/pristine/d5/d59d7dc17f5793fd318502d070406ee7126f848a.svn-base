<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>


//var cadenaFuncionValidacion='funcionValidaPrueba';

function inyeccionCodigo()
{
    asignarEvento('_cmbGruposvch','change',funcionObtenerSesiones);
    gEx('f_sp_fechaSesiondte').on('select',function()
    										{
                                            	limpiarCombo(gE('_cmbGruposvch'));
                                                llenarCombo(gE('_cmbGruposvch'),[],true);
											    limpiarCombo(gE('_cmbFechaSesionvch'));
                                                llenarCombo(gE('_cmbFechaSesionvch'),[],true);
                                                gEx('ext__cmbDocentevch').reset();
                                            }
                                            
    								)
                                    
	if(gE('idRegistroG').value!='-1')                                    
    {
    	obtenerSesiones(gE('_cmbDocentevch').value);

    }
}

/*function funcionValidaPrueba()
{
	
	return false;
}*/

function funcionAntesCargaInyeccion(id)
{

	var fecha=gEx('f_sp_fechaSesiondte');
    if(fecha.getValue()=='')
    {
    	msgBox('Debe indicar la fecha de la sesi&oacute;n que desea marcar como falta colectiva');
     	gEx(id).setValue(''); 
        gEx(id).reset();   
        
    	return false;
    }
	limpiarCombo(gE('_cmbGruposvch'));
    llenarCombo(gE('_cmbGruposvch'),[],true);
    limpiarCombo(gE('_cmbFechaSesionvch'));
    llenarCombo(gE('_cmbFechaSesionvch'),[],true);
}

function funcionSeleccionInyeccion(combo,registro)
{
    obtenerSesiones(registro.get('id'));
}

function funcionObtenerSesiones(combo)
{
	var idGrupo=combo.options[combo.selectedIndex].value;
    var fecha=gEx('f_sp_fechaSesiondte');
    if(fecha.getValue()=='')
    {
    	msgBox('Debe indicar la fecha de la sesi&oacute;n que desea marcar como falta colectiva');
     	return;
    }
    
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var arrDatos=eval(arrResp[1]);
            llenarCombo(gE('_cmbFechaSesionvch'),arrDatos,true);
            
            selElemCombo(gE('_cmbFechaSesionvch'),arrResp[2]);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_UGM_2.php',funcAjax, 'POST','funcion=2&idRegistro='+gE('idRegistroG').value+'&fecha='+gEx('f_sp_fechaSesiondte').getValue().format('Y-m-d')+'&idGrupo='+idGrupo,true);
}


function obtenerSesiones(idRegistro)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var arrDatos=eval(arrResp[1]);
            llenarCombo(gE('_cmbGruposvch'),arrDatos,true);

            selElemCombo(gE('_cmbGruposvch'),arrResp[2]);
			if(gE('idRegistroG').value!='-1')          
            {
            	funcionObtenerSesiones(gE('_cmbGruposvch'));
            }
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_UGM_2.php',funcAjax, 'POST','funcion=1&idRegistro='+gE('idRegistroG').value+'&fecha='+gEx('f_sp_fechaSesiondte').getValue().format('Y-m-d')+'&idUsuario='+idRegistro,true);
}