<?php session_start();
	include("configurarIdiomaJS.php"); 
?>
function obtenerGrados(combo)
{
	var idPrograma=combo.options[combo.selectedIndex].value;
	var comboDestino=gE('idGrado');
    var ciclo=gE('ciclo').value;
	function funcAjax()
	{
		var resp=peticion_http.responseText;
		arrResp=resp.split('|');
		if(arrResp[0]=='1')
		{
        	var arrOpciones=eval(arrResp[1]);
			rellenarCombo(comboDestino,arrOpciones,true);
		}
		else
		{
			msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
		}
	}
	obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=11&idPrograma='+idPrograma+'&ciclo='+ciclo,true);
}

function obtenerGrupos(combo)
{
	var idGrado=combo.options[combo.selectedIndex].value;
	var comboDestino=gE('idGrupo');
    var ciclo=gE('ciclo').value;
	function funcAjax()
	{
		var resp=peticion_http.responseText;
		arrResp=resp.split('|');
		if(arrResp[0]=='1')
		{
        	
        	var arrOpciones=eval(arrResp[1]);
			rellenarCombo(comboDestino,arrOpciones,true);
		}
		else
		{
			msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
		}
	}
	obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=12&idGrado='+idGrado+'&ciclo='+ciclo,true);
}


function validarFrm(form)
{
	if(validarFormularios(form))
    {
    	gE(form).submit();
    }
}

function regresar(usr)
{
	var arrParam=[['idUsuario',usr]];
	enviarFormularioDatos('intermediaMostrar.php',arrParam);	
}

function mostrarFichaMedica(idUsr)
{
	TB_show(lblAplicacion,'../Usuarios/fichaMedica.php?idAlumno='+idUsr+'&TB_iframe=true&height=550&width=840',"");

}

function recargar()
{
	var arrParam=[['idUsuario',usr]];
	enviarFormularioDatos('datosAlumnos.php',arrParam);	

}