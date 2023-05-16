<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>


function solicitarAudienciaCierreInvestigacion()
{
	var objAjax='{"idEventoReferencia":"'+gE('idEventoAudiencia').value+'","carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+'"}';
    
    
    function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var oResp=eval('['+arrResp[1]+']')[0];
            var arrEspecificaciones=oResp.arrEspecificaciones;
			var cadObj='{"tipoAudiencia":"27","tipoPromovente":"2","especificacionesEspeciales":['+arrEspecificaciones+']}';
            
            
            var obj={};
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[
            				['idFormulario',185],['idRegistro',oResp.idRegistro],['dComp',bE(oResp.dComp)],['actor',bE(oResp.actor)],
            				['idEventoReferencia',gE('idEventoAudiencia').value],['carpetaAdministrativa',gE('carpetaAdministrativa').value],
                            ['oDatosSolicitud',bE(cadObj)]
                        ];
            
            abrirVentanaFancy(obj);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=36&cadObj='+objAjax,false);


	
}

function solicitarAudienciaIntermedia()
{
	var objAjax='{"idEventoReferencia":"'+gE('idEventoAudiencia').value+'","carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+'"}';
    function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var oResp=eval('['+arrResp[1]+']')[0];
            var arrEspecificaciones=oResp.arrEspecificaciones;
			var cadObj='{"tipoAudiencia":"15","tipoPromovente":"2","especificacionesEspeciales":['+arrEspecificaciones+']}';
            
            
            var obj={};
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[
            				['idFormulario',185],['idRegistro',oResp.idRegistro],['dComp',bE(oResp.dComp)],['actor',bE(oResp.actor)],
            				['idEventoReferencia',gE('idEventoAudiencia').value],['carpetaAdministrativa',gE('carpetaAdministrativa').value],
                            ['oDatosSolicitud',bE(cadObj)]
                        ];
            
            abrirVentanaFancy(obj);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=36&cadObj='+objAjax,false);


	
}

function solicitarAudienciaJuicioOral()
{
	var objAjax='{"idEventoReferencia":"'+gE('idEventoAudiencia').value+'","carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+'"}';
    
    
    function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var oResp=eval('['+arrResp[1]+']')[0];
            var arrEspecificaciones=oResp.arrEspecificaciones;
			var cadObj='{"tipoAudiencia":"28","tipoPromovente":"2","especificacionesEspeciales":['+arrEspecificaciones+']}';
                        
            var obj={};
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[
            				['idFormulario',185],['idRegistro',oResp.idRegistro],['dComp',bE(oResp.dComp)],['actor',bE(oResp.actor)],
            				['idEventoReferencia',gE('idEventoAudiencia').value],['carpetaAdministrativa',gE('carpetaAdministrativa').value],
                            ['oDatosSolicitud',bE(cadObj)]
                        ];
            
            abrirVentanaFancy(obj);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=36&cadObj='+objAjax,false);


	
}

function registrarAccion_1()
{
	var idAccion=1;
	var objAjax='{"idAccion":"'+idAccion+'","idEventoReferencia":"'+gE('idEventoAudiencia').value+'","carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+'"}';
    
    
    function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var oResp=eval('['+arrResp[1]+']')[0];
            
			 
            
            var obj={};
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.funcionCerrar=recargarPagina;
            obj.params=[
            				['idFormulario',233],['idRegistro',oResp.idRegistro],['dComp',bE(oResp.dComp)],['actor',bE(oResp.actor)],
            				['idEvento',gE('idEventoAudiencia').value],['carpetaAdministrativa',gE('carpetaAdministrativa').value],
                            ['idAccion',idAccion]
                        ];
            
            abrirVentanaFancy(obj);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=40&cadObj='+objAjax,false);


	
}

function registrarAccion_2()
{
	var idAccion=2;
	var objAjax='{"idAccion":"'+idAccion+'","idEventoReferencia":"'+gE('idEventoAudiencia').value+'","carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+'"}';
    
    
    function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var oResp=eval('['+arrResp[1]+']')[0];
            
			 
            
            var obj={};
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.funcionCerrar=recargarPagina;
            obj.params=[
            				['idFormulario',233],['idRegistro',oResp.idRegistro],['dComp',bE(oResp.dComp)],['actor',bE(oResp.actor)],
            				['idEvento',gE('idEventoAudiencia').value],['carpetaAdministrativa',gE('carpetaAdministrativa').value],
                            ['idAccion',idAccion]
                        ];
            
            abrirVentanaFancy(obj);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=40&cadObj='+objAjax,false);


	
}

function registrarAccion_3()
{
	var idAccion=3;
	var objAjax='{"idAccion":"'+idAccion+'","idEventoReferencia":"'+gE('idEventoAudiencia').value+'","carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+'"}';
    
    
    function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var oResp=eval('['+arrResp[1]+']')[0];
            
			 
            
            var obj={};
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.funcionCerrar=recargarPagina;
            obj.params=[
            				['idFormulario',233],['idRegistro',oResp.idRegistro],['dComp',bE(oResp.dComp)],['actor',bE(oResp.actor)],
            				['idEvento',gE('idEventoAudiencia').value],['carpetaAdministrativa',gE('carpetaAdministrativa').value],
                            ['idAccion',idAccion]
                        ];
            
            abrirVentanaFancy(obj);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=40&cadObj='+objAjax,false);


	
}

function registrarAccion_4()
{
	var idAccion=4;
	var objAjax='{"idAccion":"'+idAccion+'","idEventoReferencia":"'+gE('idEventoAudiencia').value+'","carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+'"}';
    
    
    function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var oResp=eval('['+arrResp[1]+']')[0];
            
			 
            
            var obj={};
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.funcionCerrar=recargarPagina;
            obj.params=[
            				['idFormulario',233],['idRegistro',oResp.idRegistro],['dComp',bE(oResp.dComp)],['actor',bE(oResp.actor)],
            				['idEvento',gE('idEventoAudiencia').value],['carpetaAdministrativa',gE('carpetaAdministrativa').value],
                            ['idAccion',idAccion]
                        ];
            
            abrirVentanaFancy(obj);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=40&cadObj='+objAjax,false);


	
}

function registrarAccion_5()
{
	var idAccion=5;
	var objAjax='{"idAccion":"'+idAccion+'","idEventoReferencia":"'+gE('idEventoAudiencia').value+'","carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+'"}';
    
    
    function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var oResp=eval('['+arrResp[1]+']')[0];
            
			 
            
            var obj={};
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.funcionCerrar=recargarPagina;
            obj.params=[
            				['idFormulario',233],['idRegistro',oResp.idRegistro],['dComp',bE(oResp.dComp)],['actor',bE(oResp.actor)],
            				['idEvento',gE('idEventoAudiencia').value],['carpetaAdministrativa',gE('carpetaAdministrativa').value],
                            ['idAccion',idAccion]
                        ];
            
            abrirVentanaFancy(obj);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=40&cadObj='+objAjax,false);


	
}

function registrarAccion_6()
{
	var idAccion=6;
	var objAjax='{"idAccion":"'+idAccion+'","idEventoReferencia":"'+gE('idEventoAudiencia').value+'","carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+'"}';
    
    
    function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var oResp=eval('['+arrResp[1]+']')[0];
            
			 
            
            var obj={};
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.funcionCerrar=recargarPagina;
            obj.params=[
            				['idFormulario',233],['idRegistro',oResp.idRegistro],['dComp',bE(oResp.dComp)],['actor',bE(oResp.actor)],
            				['idEvento',gE('idEventoAudiencia').value],['carpetaAdministrativa',gE('carpetaAdministrativa').value],
                            ['idAccion',idAccion]
                        ];
            
            abrirVentanaFancy(obj);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=40&cadObj='+objAjax,false);


	
}

function registrarAccion_7()
{
	var idAccion=7;
	var objAjax='{"idAccion":"'+idAccion+'","idEventoReferencia":"'+gE('idEventoAudiencia').value+'","carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+'"}';
    
    
    function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var oResp=eval('['+arrResp[1]+']')[0];
            
			 
            
            var obj={};
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.funcionCerrar=recargarPagina;
            obj.params=[
            				['idFormulario',233],['idRegistro',oResp.idRegistro],['dComp',bE(oResp.dComp)],['actor',bE(oResp.actor)],
            				['idEvento',gE('idEventoAudiencia').value],['carpetaAdministrativa',gE('carpetaAdministrativa').value],
                            ['idAccion',idAccion]
                        ];
            
            abrirVentanaFancy(obj);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=40&cadObj='+objAjax,false);


	
}

function registrarAccion_8()
{
	var idAccion=8;
	var objAjax='{"idAccion":"'+idAccion+'","idEventoReferencia":"'+gE('idEventoAudiencia').value+'","carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+'"}';
    
    
    function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var oResp=eval('['+arrResp[1]+']')[0];
            
			 
            
            var obj={};
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.funcionCerrar=recargarPagina;
            obj.params=[
            				['idFormulario',233],['idRegistro',oResp.idRegistro],['dComp',bE(oResp.dComp)],['actor',bE(oResp.actor)],
            				['idEvento',gE('idEventoAudiencia').value],['carpetaAdministrativa',gE('carpetaAdministrativa').value],
                            ['idAccion',idAccion]
                        ];
            
            abrirVentanaFancy(obj);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=40&cadObj='+objAjax,false);


	
}

function solicitarAudiencia()
{
	var objAjax='{"idEventoReferencia":"'+gE('idEventoAudiencia').value+'","carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+'"}';
    
    
    function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var oResp=eval('['+arrResp[1]+']')[0];
            var arrEspecificaciones=oResp.arrEspecificaciones;
			var cadObj='';//{"tipoAudiencia":"0","tipoPromovente":"2","especificacionesEspeciales":['+arrEspecificaciones+']}
            
            
            var obj={};
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[
            				['idFormulario',185],['idRegistro',-1],['dComp',bE('agregar')],['actor',bE(177)],
            				['idEventoReferencia',gE('idEventoAudiencia').value],['carpetaAdministrativa',gE('carpetaAdministrativa').value],
                            ['oDatosSolicitud',bE(cadObj)]
                        ];
            
            abrirVentanaFancy(obj);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=36&cadObj='+objAjax,false);


	
}