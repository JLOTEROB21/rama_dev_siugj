<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
?>

var opcionSel='1';

Ext.onReady(inicializar);

function inicializar()
{
	
}			



function autenticar()
{
	var txtUsuario=gE('txtUsuario');
    var txtPasswd=gE('txtPasswd');
    var l='';
    var p='';
    

    if((txtUsuario.value.trim()=='')||(txtPasswd.value.trim()==''))
    {
    	mE('lblErr1');
        txtUsuario.focus();
        return;
    }    
    
    <?php
	if(isset($Enable_AES_Ecrypt)&&($Enable_AES_Ecrypt==true))
	{
	?>
		l=AES_Encrypt(txtUsuario.value.trim());
		p=AES_Encrypt(txtPasswd.value.trim());
	<?php        
	}
	else
	{
	?>
		l=bE(txtUsuario.value.trim());
		p=bE(txtPasswd.value.trim());
	<?php        
	}
	?>
    
    function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
         	if( arrResp[1] =='0')
            {
            	mE('lblErr1');
                txtUsuario.focus();
            }
            else
            {
            	location.href='../principalPortal/inicio.php';
            }
        }
        else
        {
            msgBox('No se ha podido realizar la operaci&oacute;n debido al siguiente problema: '+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funciones.php',funcAjax, 'POST','funcion=8&l='+l+'&p='+p,true);
    
    
    
    
}

function ocultarError(evt)
{
	oE('lblErr1');
    var key= evt.which;
	if(Ext.isIE)
		key=evt.keyCode;
        
    if(key==13)
    {
    	autenticar();
    }
}

function mostrarPantallaRegistro()
{
	var obj={};
    obj.ancho='100%';
    obj.alto='90%';
    obj.url='../registroUsuario/registroUsuarioSIGUE.php';
    abrirVentanaFancy(obj);
}

function mostrarPantallaRecuperar()
{
	var obj={};
    obj.ancho=710;
    obj.alto=425;
    obj.url='../principal/recuperarDatosAccesoTSJCDMX.php';
    abrirVentanaFancy(obj);
}

function abrirPantallaVideoGrabacion()
{
	var obj={};
    obj.ancho=980;
    obj.alto=360;
    obj.url='../modulosEspeciales_SICORE/frmAccesoVideoGrabacion.php';
    obj.params=[['cPagina','sFrm=true']];
    abrirVentanaFancy(obj);
}