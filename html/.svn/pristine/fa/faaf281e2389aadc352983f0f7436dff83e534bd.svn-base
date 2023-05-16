<?php session_start();
include("conexionBD.php"); 
include("configurarIdiomaJS.php");
?>

Ext.onReady(inicializar);

function inicializar()
{
	gE('txtMail').focus();
}

function enviarMail()
{
	if(validarFormularios('tblMail'))
	{
		var mail=gE('txtMail').value;
		function funcGuardar()
		{
			var resp=peticion_http.responseText;
			if(resp==-1)
			{
				function funcResp()
				{
					gE('txtMail').focus();
					mE('filaDatosOlvido');
				}
				msgBox('<?php echo $etj["lblAplicacion"] ?>','La cuenta proporcionada, ya existe',funcResp)
			}
			else
			{
				gE('mail').value=mail;
				gE('frmNUsuario').submit();
			}
		}
		obtenerDatosWeb("../paginasFunciones/funcionesPortal.php",funcGuardar,'POST','funcion=73&'+'mail='+mail,true);
		
	}
}


function enviarCorreoCuenta()
{
	function funcResp()
	{
		location.href='../principal/inicio.php';
	}
	msgBox('<?php echo $etj["lblAplicacion"] ?>','',funcResp)
}