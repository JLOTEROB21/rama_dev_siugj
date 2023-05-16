<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>
var primeraCargaFrame=true;
var idTareaValidacionReunion=0;
var idTareaInicioReunion=0;

Ext.onReady(inicializar);

function inicializar()
{
	
	var arrAcciones=eval(bD(gE('arrFuncionesEjecutar').value));
    var x;
    for(x=0;x<arrAcciones.length;x++)
    {
    	eval(arrAcciones[x]+';');
    }
    if(gE('txtNombreParticipante'))
    {
    	gE('txtNombreParticipante').focus();
    }
}

function verificarInicioReunion()
{
	revisarInicioReunion();
	idTareaInicioReunion=setInterval(revisarInicioReunion,60000);

}


function revisarInicioReunion()
{
	function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
         	var arrTiempo=   arrResp[1].split('_');
            
            if((arrTiempo[0]=='0')&&(arrTiempo[1]=='0')&&(arrTiempo[2]=='0'))
            {
            	gE('lblStatusReunion').innerHTML="<span style='color:#004409'>LISTO PARA INICIAR</span>";
                clearTimeout(idTareaInicioReunion);
                mostrarBontonIngresar();
            }
            else
            {
            	var lblLeyenda='';
                if(arrTiempo[0]!='0')
                {
                	lblLeyenda=arrTiempo[0]+' '+(arrTiempo[0]=='1'?' d&iacute;a':' d&iacute;as');
                }
                
                if(arrTiempo[1]!='0')
                {
                	var lblHoras=arrTiempo[1]+' '+(arrTiempo[1]=='1'?' hora':' horas');
                    if(lblLeyenda=='')
                    	lblLeyenda=lblHoras;
                    else
                    	lblLeyenda+=', '+lblHoras;
                    
                }
                if(arrTiempo[2]!='0')
                {
                	var lblMinutos=arrTiempo[2]+' '+(arrTiempo[2]=='1'?' minuto':' minutos');
                    if(lblLeyenda=='')
                    	lblLeyenda=lblMinutos;
                    else
                    	lblLeyenda+=', '+lblMinutos;
                }
                
                
                gE('lblStatusReunion').innerHTML="<span style='color:#004409'>POR INICIAR EN: "+lblLeyenda+'</span>';
            }
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_VideoConferenciasPO.php',funcAjax, 'POST','funcion=8&idReunion='+gE('idReunion').value,false);
    
}

function mostrarBontonIngresar()
{
	mE('filaBotonIngresar');
}

function ingresarReunion()
{
	oE('filaError');
    gE('btnIngresar').innerHTML='Ingresar a reuni&oacute;n';
	if(gE('txtNombreParticipante') && (gE('txtNombreParticipante').value.trim()==''))
    {
    	gE('txtNombreParticipante').focus();
        mE('lblLeyendaNombre');
    }
    
    function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');

        if(arrResp[0]=='1')
        {
        	switch(arrResp[1])
            {
            	case '-1':
                	gE('btnIngresar').innerHTML='Reintentar';
                    gE('lblResultadoErr').innerHTML="<b>"+arrResp[2]+'</b>';
                    mE('filaError');
                break;
            	case '0':
                case '1':
                
                	var cadenaParams='';
                    var t;
                    var arrParams=eval(arrResp[3]);
                    
                    var x;
                    
                    for(x=0;x<arrParams.length;x++)
                    {
                    	t=arrParams[x][0]+'='+arrParams[x][1];
                        if(cadenaParams=='')
                        	cadenaParams=t;
                        else
                        	cadenaParams+='&'+t;
                    }
                   
					location.href=arrResp[2]+'?'+cadenaParams;
                	inicializarValidacionStatusReunion();
                break;
            	case '3':
                	gE('lblStatusReunion').innerHTML="<span style='color:#000C44'>FINALIZADA</span>";
                    oE('filaBotonIngresar');
                break;
                case '4':
                	gE('lblStatusReunion').innerHTML="<span style='color:#F00'>CANCELADA</span>";
                    oE('filaBotonIngresar');
                break;
            }
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_VideoConferenciasPO.php',funcAjax, 'POST','funcion=11&noReunion='+gE('numeroReunion').value+
    					'&cveReunion='+gE('passwdReunion').value+'&idReunion='+gE('idReunion').value+'&nombre='+(gE('txtNombreParticipante')?gE('txtNombreParticipante').value:gE('lblNombreParticipante').innerHTML),false);
    

    
    
    
    
}



function nombreKeyPress()
{
	 oE('lblLeyendaNombre');
}


function inicializarValidacionStatusReunion()
{
	idTareaValidacionReunion=setInterval(revisarStatusReunion,60000);
}


function revisarStatusReunion()
{
	function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
         	switch(arrResp[1])
            {
            	case '2': //En Desarrollo
                    $statusReunion="<span style='color:#004409'>EN DESARROLO</span>";
                    mostrarBontonIngresar();
                break;
                case '3': //Conclu&iacute;da
                    $statusReunion="<span style='color:#000C44'>FINALIZADA</span>";
                    oE('filaBotonIngresar');
                    clearTimeout(idTareaValidacionReunion);
                break;
                case '4': //Cancelada
                    $statusReunion="<span style='color:#F00'>CANCELADA</span>";
	                oE('filaBotonIngresar');
                    clearTimeout(idTareaValidacionReunion);
                break;
            }
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_VideoConferenciasPO.php',funcAjax, 'POST','funcion=10&idReunion='+gE('idReunion').value,false);
    
}


