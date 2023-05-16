<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

function inyeccionCodigo()
{
	limpiarCombo(gE('_Grupovch'));
    limpiarCombo(gE('_tInicialvch'));
    limpiarCombo(gE('_tFinalvch'));
	asignarEvento('_Cursovch','change',selCurso);
}


function selCurso()
{
	var cmbCurso=gE('_Cursovch');
    var idCurso=cmbCurso.options[cmbCurso.selectedIndex].value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var arrGrupos=eval(arrResp[1]);
            llenarCombo(gE('_Grupovch'),arrGrupos,true);
            var arrSesiones=eval(arrResp[2]);
            llenarCombo(gE('_tInicialvch'),arrSesiones,true);
            llenarCombo(gE('_tFinalvch'),arrSesiones,true);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Galileo.php',funcAjax, 'POST','funcion=5&idCurso='+idCurso,true);

}
