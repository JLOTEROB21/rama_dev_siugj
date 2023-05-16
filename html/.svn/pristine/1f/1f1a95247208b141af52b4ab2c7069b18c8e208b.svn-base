<?php
	session_start();
	include("configurarIdiomaJS.php");
?>

Ext.onReady(inicializar);
var idRegistro;

function inicializar()
{
	if(typeof(funcionInicio)!='undefined')
    	funcionInicio();
}

function enviarPaginaEnlace(configuracion,td,accion)//
{
	var pagina;
	switch(accion)
    {
    	case '<?php echo base64_encode("agregar")?>':
        	pagina=arrParamConfiguraciones[configuracion][0];	
        break;
        case '<?php echo base64_encode("ver")?>':
        	pagina=arrParamConfiguraciones[configuracion][2];
        break;
        case '<?php echo base64_encode("modificar")?>':
        	pagina=arrParamConfiguraciones[configuracion][0];	
        break;
    }
        	
    var arrParam=arrParamConfiguraciones[configuracion][1];
    var arrJs=['eJs','<?php echo base64_encode("window.parent.mostrarMenuDTD()")?>'];
    arrParam.push(arrJs);
    
    var iFrame=gE('iFElementosDTD');
    enviarFormularioDatosV(pagina,arrParam,'POST','iFElementosDTD');
    marcarEnlace('td_'+td);
}

function enviarAsociado(idFormulario,td,accion)//
{
	var hConf;
    var confO
    if(accion=='<?php echo base64_encode("modificar")?>')
    {
   	    hConf=document.getElementsByName('confReferencia')[1];
	    confO=hConf.value;
    	var iFrame=gE('iFElementosDTD');
		var content=iFrame.contentWindow;
    	var confRef=content.document.getElementsByName('confReferencia')[0];
        
    	var nuevaConf=confRef.value;
        
        hConf.value=nuevaConf;
         
    }
	
    var idRegistro=gE('idRegistroAux').value;
	var arrDatos=[['idReferencia',idRegistro],['idFormulario',idFormulario],['idRegistro','-1'],['accion',accion]];
    var arrJs=['eJs','<?php echo base64_encode("window.parent.mostrarMenuDTD()")?>'];
    arrDatos.push(arrJs);
    var iFrame=gE('iFElementosDTD')
    enviarFormularioDatosV('../modeloPerfiles/proxyFormulario.php',arrDatos,'POST','iFElementosDTD');
    marcarEnlace('td_'+td);
    if(accion=='<?php echo base64_encode("modificar")?>')
	    hConf.value=confO;
}

function enviarFichaProyecto(idFormulario,accion2)//
{
	if(idFormulario==undefined)
    	idFormulario=gE('idFormularioAux');
	if(accion2==undefined)
		var accion=gE('accionAux').value;
	else
    	var accion=accion2;    
    var hConf;
    var confO
    if(accion2=='<?php echo base64_encode("modificar")?>')
    {
   	    hConf=document.getElementsByName('confReferencia')[1];
	    confO=hConf.value;
    	var iFrame=gE('iFElementosDTD');
		var content=iFrame.contentWindow;
    	var confRef=content.document.getElementsByName('confReferencia')[0];
        
    	var nuevaConf=confRef.value;
        
        hConf.value=nuevaConf;
         
    }
    var idRegistro=gE('idRegistroAux').value;
   
	var arrDatos=[['idRegistro',idRegistro],['idFormulario',idFormulario],['idReferencia','-1'],['accion',accion],['iFrame','true'],['eJs','<?php echo base64_encode("window.parent.enviarFichaProyecto()")?>']];
    var iFrame=gE('iFElementosDTD')
   	enviarFormularioDatosV('../modeloPerfiles/proxyFormulario.php',arrDatos,'POST','iFElementosDTD');
    marcarEnlace('td_1');
    if(accion2=='<?php echo base64_encode("modificar")?>')
	    hConf.value=confO;
}

function marcarEnlace(id)//
{
	var x;
    x=1;
    while(true)
    {
    	var td=gE('td_'+x);
        if(td==null)
         	return;
            
       	if(id=='td_'+x)
			setClase(td,'letraRoja');				     
        else
            setClase(td,'letraFicha');				     
        x++; 
    }
}

function mostrarMenuDTD(idReg)//
{
	var actor=gE('actor').value;
	if(typeof(idReg)!='undefined')
    {
    	redireccionarEtapa1(idReg);
    }
    else
   		idRegistro=gE('idRegistroAux').value;
    var idFrm=gE('idFormularioAux').value;
   
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if((arrResp[0]=='1')||(arrResp[0]==1))
        {
        	var divAcciones=gE('divAcciones');
        	divAcciones.innerHTML=arrResp[1];
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=37&idFormulario='+idFrm+'&idRegistro='+idRegistro+'&actor='+actor,true);
}

function someter()//
{
	var idRegistro=gE('idRegistroAux').value;
    var idFormulario=gE('idFormularioAux').value;
    var actor=gE('actor').value;
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
                	var pagPrincipal=gE('pagPrincipal').value;
                	location.href=pagPrincipal;
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=39&idFormulario='+idFormulario+'&idRegistro='+idRegistro+'&actor='+actor,true);

        }
    }
	Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer someter este registro a revisi&oacute;n?',resp);
}

function asignarRevisores()//
{
	var idFormulario=gE('idFormularioAux').value;
	var idRegistro=gE('idRegistroAux').value;
    var idActor=gE('actor').value;
    var cPagina='sFrm=true';
	var arrParam=[['idFormulario',idFormulario],['idRegistro',idRegistro],['cPagina',cPagina],['idActorProcesoEtapa',idActor]];
    enviarFormularioDatos('../modeloProyectos/revisores.php',arrParam,'POST','iFElementosDTD');
}

function redimensionarIframe(iFrame)//
{
	if(iFrame==undefined)
    	iFrame=gE('iFElementosDTD');
    if(Ext.isGecko)
    	var the_height=iFrame.contentWindow.innerHeight+iFrame.contentWindow.scrollMaxY+30;
    else
    	var the_height=iFrame.contentWindow.document.body.scrollHeight;
	
    var content=iFrame.contentWindow;
    var tamano=content.document.getElementById('altoVentana');
    
    iFrame.height=the_height;
    if(tamano!=null)
    {
    	iFrame.height=tamano.value;
    }
    iFrame.scrolling='no';
}

function bloquearElemento(f,r)//
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
                	mostrarMenuDTD();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=78&idFormulario='+f+'&idReferencia='+r,true);
        }
    }
    msgConfirm('Est&aacute; seguro de querer bloquear este elemento para evitar su edici&oacute;n?',resp)
}

function quitarBloqueo(f,r)//
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
                	mostrarMenuDTD();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=79&idFormulario='+f+'&idReferencia='+r,true);
        }
    }
    msgConfirm('Est&aacute; seguro de querer eliminar el bloqueo de edici&oacute;n que tiene este elemento?',resp)
}

function realizarDictamenRevisor(idFrm)//
{
	 var cPagina='sFrm=true';
	var arrParam=[['idFormulario',idFrm],['idRegistro','-1'],['cPagina',cPagina],['eJs','<?php echo base64_encode("window.parent.regresarPagina();")?>']];
    enviarFormularioDatosV("../modeloPerfiles/registroFormulario.php",arrParam,'POST','iFElementosDTD');
}



function verDictamenRevisor(idFrm,idReg)//
{
	var cPagina='sFrm=true';
	var arrParam=[['idFormulario',idFrm],['idRegistro',idReg],['cPagina',cPagina]];
    enviarFormularioDatosV("../modeloPerfiles/verFichaFormulario.php",arrParam,'POST','iFElementosDTD');
}

function realizarDictamenP(idFrm,idRef)
{
	 var cPagina='sFrm=true';
	var arrParam=[['idFormulario',idFrm],['idRegistro','-1'],['idReferencia',idRef],['cPagina',cPagina],['eJs','<?php echo base64_encode("window.parent.mostrarMenuDTD();")?>']];
    enviarFormularioDatosV("../modeloPerfiles/registroFormulario.php",arrParam,'POST','iFElementosDTD');
}

function verDictamenP(idFrm,idReg)
{
	var cPagina='sFrm=true';
	var arrParam=[['idFormulario',idFrm],['idRegistro',idReg],['cPagina',cPagina]];
    enviarFormularioDatosV("../modeloPerfiles/verFichaFormulario.php",arrParam,'POST','iFElementosDTD');
}

function realizarDictamenFinal(idFrm,idRef) //
{
	 var cPagina='sFrm=true';
	var arrParam=[['idFormulario',idFrm],['idRegistro','-1'],['idReferencia',idRef],['cPagina',cPagina],['eJs','<?php echo base64_encode("window.parent.mostrarMenuDTD();")?>']];
    enviarFormularioDatosV("../modeloPerfiles/registroFormulario.php",arrParam,'POST','iFElementosDTD');
}

function verDictamenFinal(idFrm,idReg) //
{
	var cPagina='sFrm=true';
	var arrParam=[['idFormulario',idFrm],['idRegistro',idReg],['cPagina',cPagina]];
    enviarFormularioDatosV("../modeloPerfiles/verFichaFormulario.php",arrParam,'POST','iFElementosDTD');
}

function redireccionarEtapa1(idRegistro) //
{
	gE('registroRecarga').value=idRegistro;
	gE('frmEnvioNuevo').submit();
}

