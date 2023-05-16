<?php session_start();
include("conexionBD.php"); 
include("configurarIdiomaJS.php");
?>

Ext.onReady(inicializar);

function inicializar()
{
	crearCampoFecha('txtFechaNac','hFechaNac');
    generarPassword();
    gE('txtApPaterno').focus();
}

function generarPassword() 
{
	var form='txtPassword';
	var strCaracteresPermitidos = 'A,B,C,D,E,F,G,H,I,J,K,M,N,P,Q,R,S,T,U,V,W,X,Y,Z,1,2,3,4,5,6,7,8,9';
	var strArrayCaracteres = new Array(34);
	strArrayCaracteres = strCaracteresPermitidos.split(',');
	var length = 16, i = 0, j, tmpstr = "";
	do {
		var randscript = -1
		while (randscript < 1 || randscript > strArrayCaracteres.length || isNaN(randscript)) {
			randscript = parseInt(Math.random() * strArrayCaracteres.length)
		}
		j = randscript;
		tmpstr = tmpstr + strArrayCaracteres[j];
		i = i + 1;
	} while (i < length)
	gE('txtPassword').value = tmpstr;
}

function enviarFormulario()
{
	if(validarFormularios('tblFormulario'))
	{
    	var password=gE('txtPassword').value;
        var password2=gE('txtPassword2').value;
        var login=gE('hLogin').value;
        var mail=gE('mail').value;
        if(password!=password2)
        {
        	function funcRespuesta()
            {
            	gE('txtPassword2').focus();
            }
        	
/*        	Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["lblPasswordNo"] ?>',funcRespuesta)
           	return;*/
        }
        
        if(login.trim()=='')
        {
            Ext.MessageBox.alert('Primero debe seleccionar un login');
            return;
        }
        
		var apPaterno=gE('txtApPaterno').value;
		var apMaterno=gE('txtApMaterno').value;
		var nombre=gE('txtNombres').value;
		var prefijo=gE('txtPrefijo').value;
		var nacionalidad=gE('txtNacionalidad').value;
		var fechaNac=gE('hFechaNac').value;
		
		var obj='{"apPaterno":"'+cv(apPaterno)+'","apMaterno":"'+cv(apMaterno)+'","nombre":"'+cv(nombre)+'","prefijo":"'+cv(prefijo)+'","nacionalidad":"'+cv(nacionalidad)+'","fechaNac":"'+cv(fechaNac)+'","login":"'+cv(login)+'","password":"'+cv(password)+'","mail":"'+cv(mail)+'"}';
        obj=obj.replace(/\n/gi, '');
		obj=obj.replace(/\r/gi, '');
        function funcGuardar()
		{
			arrResp=peticion_http.responseText.split('|');
			if(arrResp[0]=='1')
			{
				function funcRespuesta()
				{
					location.href="../principal/inicio.php";
				}	
				Ext.MessageBox.alert(lblAplicacion,'Sus datos han sido registrados exitosamente, en breve recibirá un correo con su contraseña para activar su cuenta e ingresar al sistema',funcRespuesta);
			}
			else
				msgBox('No se ha podido realizar la operación debido al siguiente problema:'+' <br />'+arrResp[0]);
		}
		obtenerDatosWeb("../paginasFunciones/funcionesUsuarios.php",funcGuardar,'POST','funcion=8&'+'param='+obj,true);
	}
}

function cancelarRegistro()
{
	function funcResp(btn)
    {
    	if(btn=='yes')
        {
        	location.href='../principal/inicio.php';
        }
    }
	Ext.MessageBox.confirm(lblAplicacion,'&iquest;Está seguro de querer cancelar el proceso de registro?',funcResp);
}

function generarLogin()
{
	var aPaterno=gE('txtApPaterno');
    var nombre=gE('txtNombres');
    if(nombre.value.trim()=='')
    {
    	function funcResp()
        {
        	nombre.focus();
        }
    	Ext.MessageBox.alert(lblAplicacion,'Primero debe ingresar su nombre',funcResp)
        return;
    }
    
    if(aPaterno.value.trim()=='')
    {
    	function funcResp()
        {
        	aPaterno.focus();
        }
    	Ext.MessageBox.alert(lblAplicacion,'Primero debe ingresar su apellido paterno',funcResp)
        return;
    }
    var msg='El usuario es generado basado en su apellido paterno,materno y nombre, una vez generado las sugerencias de usuario dichos campos se bloquerán. '+
    		'Si usted considera que la información ingresada en los campos descritos anteriormente es correcta presione el boton "Yes", de lo contrario presione el botón "No".&iquest;Desea continuar?';
            
    function funcResp(btn)
    {
    	if(btn=='yes')
        {
        	dE('txtApPaterno');
            dE('txtApMaterno');
            dE('txtNombres');
            var apPaterno=gE('txtApPaterno');
            var apMaterno=gE('txtApMaterno');
            var nombre=gE('txtNombres');
            
            var obj='{"apPaterno":"'+cv(apPaterno.value.trim())+'","apMaterno":"'+cv(apMaterno.value.trim())+'","nombre":"'+cv(nombre.value.trim())+'"}';
            function funcResp()
            {
            	arrResp=peticion_http.responseText.split('|');
                var x=0;
                var contenido='';
                for(x=0;x<arrResp.length;x++)
                {
                	var celdaL=gE('celdaLogin');
                    contenido+='<input type="radio" name="usuario"  onclick=setUsuario(\''+arrResp[x]+'\')>&nbsp;'+arrResp[x]+'<br>';
                    
                }
                celdaL.innerHTML=contenido+'<br>';
                oE('lblEtiqueta');
                
            }
            gE('hLogin').value="";
            obtenerDatosWeb("../paginasFunciones/funcionesUsuarios.php",funcResp,'POST','funcion=7&'+'param='+obj,true);
            
            
            
            
        }
			    	
    }
    Ext.MessageBox.confirm(lblAplicacion,msg,funcResp);
    
}

function setUsuario(usuario)
{
	gE('hLogin').value=usuario;
}
