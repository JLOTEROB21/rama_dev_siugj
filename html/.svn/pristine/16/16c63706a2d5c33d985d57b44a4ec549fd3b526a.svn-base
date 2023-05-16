<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

function agregarNuevoPerfil()
{
	var arrParam=[['idPerfil','-1']];
    enviarFormularioDatos('../modeloProyectos/configuracionesModuloAutores.php',arrParam);
}

function modificarPerfil(idPerfil)
{
	var arrParam=[['idPerfil',idPerfil]];
    enviarFormularioDatos('../modeloProyectos/configuracionesModuloAutores.php',arrParam);
}

function eliminarPerfil(idPerfil)
{
	function resp(btn)
    {
    	if(btn=='yes')
        {
        	function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                	var fila=gE('fila_'+idPerfil);
                    fila.parentNode.removeChild(fila);
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=66&idPerfil='+idPerfil,true);
        }
    }
    msgConfirm('Esta seguro de querer eliminar este perfil?',resp)
    
}