<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

var idTareaValidacionReunion=0;

Ext.onReady(inicializar);

function inicializar()
{
	if(gE('validarEntradaModerador').value=='1')
    {
    	inicializarValidacionIngresoModerador();
        
    }
}


function inicializarValidacionIngresoModerador()
{
	idTareaValidacionReunion=setInterval(revisarIngresoModerador,5000);
}

function revisarIngresoModerador()
{
	function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');

        if(arrResp[0]=='1')
        {
            switch(arrResp[1])
            {
            	case '-1':
                	gE('imgAccion').src='../images/prohibido.png';
                    clearTimeout(idTareaValidacionReunion);
                    gE('lblResultado').innerHTML='<br /><br />'+arrResp[2];
                    if(window.parent.cerrarVentanaFancy)
	                    mE('filaBotonCerrar');
                break;
                case '1':
                
                    var arrParam=eval(arrResp[3]);
                     enviarFormularioDatos(arrResp[2],arrParam,'GET');
                break;
            }
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_VideoConferencias.php',funcAjax, 'POST','funcion=11&noReunion='+gE('noReunion').value+
                        '&cveReunion='+gE('cveReunion').value+'&idReunion='+gE('idReunion').value+'&nombre='+gE('nombre').value,false);
    

    
}

function cerrarVentana()
{
	window.parent.cerrarVentanaFancy();
}

