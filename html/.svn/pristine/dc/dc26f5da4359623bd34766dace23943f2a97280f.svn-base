<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	

	
?>

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
    if(pagina.toUpperCase().indexOf('JAVASCRIPT')!=-1)
    {
    	arrDatos=pagina.split(':');
        eval(arrDatos[1]);
    	return;
    }
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
    switch(bD(fA))
    {
    	case '1':
        	window.open(pagina+parametros,"vAuxiliar", "toolbar=no,directories=no,menubar=no,status=no,scrollbars=yes,fullscreen=yes");
        break;
        case '2':
        	var paginaFinal='';
            if(parametros!='')
                paginaFinal=pagina+parametros;
            else
                paginaFinal=pagina;
            paginaFinal=paginaFinal.replace('?&','?');
            $.fancybox({
                        'href'				: paginaFinal,
                        'width'				: 800,
                        'height'			: 480,
                        'autoScale'			: false,
                        'transitionIn'		: 'none',
                        'transitionOut'		: 'none',
                        'type'				: 'iframe',
                        'modal':false,
                        'showCloseButton'	:true,
                        'enableEscapeButton':true,
                        'showNavArrows':true
                        
                    });	
            
            
        break;
        case '3':
			
        	enviarFormularioDatos(pagina,arrDatos);
        break;
    }
	
}


function verComentariosUsuarios()
{
	var idReferencia=gE('idReferencia').value;
    var idActor=bD(window.parent.gE('actor').value);
    var combo=gE('_cmbCandivch');
    var idUsuario=combo.options[combo.selectedIndex].value;
    if(idUsuario=='-1')
    {
    	msgBox('Debe seleccionar el usuario cuyos comentarios desea observar');
        return;
    }
    
	$.fancybox({
    			'href'				: '../reportes/comentariosEvalCandidato.php?cPagina=sFrm=true&idReferencia='+idReferencia+'&idActor='+idActor+'&idUsuario='+idUsuario,
				'title'    			: 'Comentarios sobre el candidato',			
				'width'				: 600,
				'height'			: 300,
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe',
                'modal':false
			});	
}


function habilitarCampoTiempoSL(campo,formato,fechaInicial)
{

	var origen=1;
	if(fechaInicial==null)
    {
    	fechaInicial=new Date();
        fechaInicial=fechaInicial.format('Y-m-d H:i:s');
        origen=2;
    }
      
	var oCampo=gE(campo);
    var fechaActual=Date.parseDate(fechaInicial,'Y-m-d H:i:s');


	
    
    
    
    oCampo.setAttribute('valorTiempo',fechaActual.format('Y-m-d H:i:s'));
    if(oCampo.getAttribute('funcRenderer')=='')
	    oCampo.value=fechaActual.format(formato);
    else
    {
    	var renderer=oCampo.getAttribute('funcRenderer');
    	eval('oCampo.value='+renderer+'(fechaActual.format(formato));');
    }
    
    
   
    
    var IDIntervalo;
    var cadObj="IDIntervalo=setInterval	(	function()"+
                                            "{"+
                                                "var fechaActual;"+
                                                "var oCampo=gE('"+campo+"');"+
                                                "if(origen==1)"+
                                                "{"+
                                                "    fechaActual=Date.parseDate(oCampo.getAttribute('valorTiempo'),'Y-m-d H:i:s').add(Date.SECOND,1);"+
                                                "}"+
                                                "else"+
                                                "    fechaActual=new Date();"+
                                                "oCampo.setAttribute('valorTiempo',fechaActual.format('Y-m-d H:i:s'));"+
                                                "oCampo.value=fechaActual.format(formato);"+
                                            "},"+
                                            "1000"+
                                      ");";
    eval(cadObj);
    
	oCampo.setAttribute('IDIntervalo',IDIntervalo);                    
}