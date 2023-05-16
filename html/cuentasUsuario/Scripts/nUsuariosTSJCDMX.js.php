<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT * FROM 903_variablesSistema WHERE idVariable=1";
	$objConfiguracion=$con->obtenerFilasJSON($consulta);									
	
?>

var arrMinusculas='abcdefghijklmnñopqrstuvwxyz';
var arrMayusculas='ABCDEFGHIJKLMNÑOPQRSTUVWXYZ';
var arrNumeros='0123456789';
var arrEspeciales='!"#$%&()=¿?[]\'+-*/_;@.,;';

var objConfiguracion=eval(<?php echo $objConfiguracion?>)[0];

var keyMap = new Ext.KeyMap(document, 
									{
										key: 13, 
										fn: guardarUsuario,
										scope: this
									}
							);


var keyMap2 = new Ext.KeyMap(document, 
									{
										key: 27, 
										fn: cancelar,
										scope: this
									}
							);

Ext.onReady(Inicializar);

function Inicializar()
{
	
	gE('Contrasena').focus();
}

function guardarUsuario(form)
{
	
    var pwd1=gE('Contrasena');
    if(pwd1.value=='')
    {
        msgBox('Debe ingresar la contrase&ntilde;a');
        return;
    }
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            if(arrResp[1]=='1')
            {
                msgBox('La contrase&ntilde;a es insegura<br />(Diccionario de contrase&ntilde;as restringidas)');

            }
            else
            {
            	var pwd2=gE('Contrasena2');
                if(pwd1.value!=pwd2.value)
                {
                    function ponerFoco()
                    {
                        pwd1.focus();
                    }
                    msgBox('Las contrase&ntilde;as introducidas son diferentes',ponerFoco);
                    return;
                }
                
                if(pwd1.value==bD(gE('versionSistema').value))
                {
                    function resp2()
                    {
                        gE('pwd1').focus();
                    }
                    msgBox('Por seguridad es necesario que cambie sus contrase&ntilde;a de acceso',resp2);
                    return;
                }
                
                if(pwd1.value.length<parseInt(objConfiguracion.logitudMinimaContrasena))
                {
                    function respAux3()
                    {
                        pwd1.focus();
                    }
                    msgBox('La longitud de la contrase&ntilde;a debe ser de almenos '+(parseInt(objConfiguracion.logitudMinimaContrasena)==1?'1 caracter':(objConfiguracion.logitudMinimaContrasena+' caracteres')),respAux3);
                    return;
                }
                
                if(pwd1.value.length>parseInt(objConfiguracion.logitudMaximaContrasena))
                {
                    function respAux4()
                    {
                        pwd1.focus();
                    }
                    msgBox('La longitud de la contrase&ntilde;a excede el m&aacute;ximo permitido ('+(parseInt(objConfiguracion.logitudMaximaContrasena)==1?'1 caracter':(objConfiguracion.logitudMaximaContrasena+' caracteres')+')'),respAux4);
                    return;
                }
                
               
                
                if(parseInt(objConfiguracion.minLetrasMinusculas)>0)
                {
                    var totaLetras=contarOcurrenciasCaraceteresCadena(arrMinusculas,pwd1.value);
                    if(totaLetras<parseInt(objConfiguracion.minLetrasMinusculas))
                    {
                        function respAux5()
                        {
                            pwd1.focus();
                        }
                        msgBox('La contrase&ntilde;a debe contener almenos '+(parseInt(objConfiguracion.minLetrasMinusculas)==1?'1 letra min&uacute;scula':(objConfiguracion.minLetrasMinusculas+' letras min&uacute;sculas')),respAux5);
                        return;
                    }
                }
                
                
                
                if(parseInt(objConfiguracion.minLetrasMayusculas)>0)
                {
                    var totaLetras=contarOcurrenciasCaraceteresCadena(arrMayusculas,pwd1.value);
                    if(totaLetras<parseInt(objConfiguracion.minLetrasMayusculas))
                    {
                        function respAux50()
                        {
                            pwd1.focus();
                        }
                        msgBox('La contrase&ntilde;a debe contener almenos '+(parseInt(objConfiguracion.minLetrasMayusculas)==1?'1 letra may&uacute;scula':(objConfiguracion.minLetrasMayusculas+' letras may&uacute;sculas')),respAux50);
                        return;
                    }
                }
                 
                
                if(parseInt(objConfiguracion.minCaracteresNumericos)>0)
                {
                    var totaLetras=contarOcurrenciasCaraceteresCadena(arrNumeros,pwd1.value);
                    if(totaLetras<parseInt(objConfiguracion.minCaracteresNumericos))
                    {
                        function respAux7()
                        {
                            pwd1.focus();
                        }
                        msgBox('La contrase&ntilde;a debe contener almenos '+(parseInt(objConfiguracion.minCaracteresNumericos)==1?'1 caracter num&eacute;rico':(objConfiguracion.minCaracteresNumericos+' caracteres num&eacute;ricos')),respAux7);
                        return;
                    }
                }
                
                if(parseInt(objConfiguracion.minCaracteresEspeciales)>0)
                {
                    var totaLetras=contarOcurrenciasCaraceteresCadena(arrEspeciales,pwd1.value);
                    if(totaLetras<parseInt(objConfiguracion.minCaracteresEspeciales))
                    {
                        function respAux8()
                        {
                            pwd1.focus();
                        }
                        msgBox('La contrase&ntilde;a debe contener almenos '+(parseInt(objConfiguracion.minCaracteresEspeciales)==1?'1 caracter especial':(objConfiguracion.minCaracteresEspeciales+' caracteres especiales')),respAux8);
                        return;
                    }
                }
                
                
               
                var x;
                
                
                
                if (!validarFormularios(form))
                {
                    return;
                }
                else
                {
                    var formulario=gE(form);
                    gE('pContrasena').value=AES_Encrypt(gE('Contrasena').value);
                    
                    formulario.submit();
                }
            }
               
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funciones.php',funcAjax, 'POST','funcion=14&pwd='+pwd1.value,true);
    
	
	
}

function cancelar()
{
	function resp(btn)
	{
		if(btn=='yes')
		{
			cerrarSesion();	
		}
	}
	msgConfirm('Est&aacute; seguro de querer cancelar la actualizaci&oacute;n de su cuenta?',resp)
}


function cerrarSesionPrincipal()
{
	function procResp()
	{
    	
		document.location.href="<?php echo $paginaCierreLogin?>";		
        
	}
	obtenerDatosWebV2('../paginasFunciones/funciones.php',procResp,'POST','funcion=2',true);
	
}

function contarOcurrenciasCaraceteresCadena(arrBase,frase)
{
	var contar=0;
	for (var i = 0; i < arrBase.length; i++) 
    {
     	for (var x = 0; x < frase.length; x++) 
        {

     		if(arrBase[i]==frase[x])
            {
    			contar++;
         	}
    	}
 	}
    
    return contar;
 }