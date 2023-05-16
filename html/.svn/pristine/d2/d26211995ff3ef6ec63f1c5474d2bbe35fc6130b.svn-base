<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

/*function obtenerPosX(idObj)
{
  var curleft = 0;
  var obj=gE(idObj);
  if(obj.offsetParent)
      while(1)
      {
        curleft += obj.offsetLeft;
        if(!obj.offsetParent)
          break;
        obj = obj.offsetParent;
      }
  else if(obj.x)
      curleft += obj.x;
  return curleft;
}

function obtenerPosY(idObj)
{
  var curtop = 0;
  var obj=gE(idObj);
  if(obj.offsetParent)
      while(1)
      {
        curtop += obj.offsetTop;
        if(!obj.offsetParent)
          break;
        obj = obj.offsetParent;
      }
  else if(obj.y)
      curtop += obj.y;
  return curtop;
}

function calibrarPosicion(id)
{
	var elMovimiento=gE(id);
    elMovimiento.style.left=(parseInt(elMovimiento.style.left)+posDivX)+'px';
    elMovimiento.style.top=(parseInt(elMovimiento.style.top)+posDivY)+'px';
}*/

function FCKeditor_OnComplete( editorInstance )
{
	Ext.ux.FCKeditorMgr.register(editorInstance.Name , editorInstance);
	if(typeof(ctrlEnfocar)!='undefined')
    {
        var div=gE(ctrlEnfocar);
        var controlI=div.getAttribute('controlInterno');
        var arrControlI=controlI.split('_');
        
        if(editorInstance.Name=='_'+arrControlI[1])
        {
            editorInstance.Focus();
        }
	}    
}

function verEnlaceFormularioLink(fA,e,p)
{
	
	var arrDatos=eval(bD(p));
   	var pagina=bD(e);
    var parametros='';
    var x;
    for (x=0;x<arrDatos.length;x++)
    {
        if(parametros=='')
            parametros=arrDatos[x][0]+'='+arrDatos[x][1];
        else
            parametros+='&'+arrDatos[x][0]+'='+arrDatos[x][1];
    }
    if(pagina.indexOf('?')==-1)
        pagina=pagina+'?';
    if(parametros!='')
    {
        if(pagina.indexOf('?')==-1)
            parametros='?'+parametros;
        else
            parametros='&'+parametros;
    }
    
	if(bD(fA)=='1')
    {
        window.open(pagina+parametros,"vAuxiliar", "toolbar=no,directories=no,menubar=no,status=no,scrollbars=yes,fullscreen=yes");

    }
    else
    {
        var paginaFinal='';
        if(parametros!='')
	        paginaFinal=pagina+parametros+'&TB_iframe=true&height=480&width=700';
        else
        	paginaFinal=pagina+'TB_iframe=true&height=480&width=700';
		alert(paginaFinal);
    	tb_show(lblAplicacion,paginaFinal,"","scrolling=no");
    }
}

