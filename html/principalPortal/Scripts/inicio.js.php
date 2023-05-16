<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>
var carpetaAdministrativa=-1;
var autoScroll=0;
Ext.onReady(inicializar);

function inicializar()
{
	if(gE('lblCarpetaJudicial'))
    {
        var oConf=	{
                            idCombo:'cmbCarpetaJudicial',
                            anchoCombo:500,
                            renderTo:'lblCarpetaJudicial',
                            raiz:'registros',
                            campoDesplegar:'carpetaAdministrativa',
                            campoID:'carpetaAdministrativa',
                            funcionBusqueda:47,
                            listClass:"listComboSIUGJ", 
                            cls:"comboSIUGJBusqueda",
                            height:30,
                            emptyText:'Buscar Proceso Judicial',
                            fieldClass:"comboSIUGJBusqueda",
                            ctCls:"comboWrapSIUGJBusqueda",
                            paginaProcesamiento:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                            confVista:'<tpl for="."><div class="search-item">{carpetaAdministrativa}<br></div></tpl>',
                            campos:	[
                                        {name:'carpetaAdministrativa'},
                                        {name:'idCarpeta'}
    
                                    ],
                            funcAntesCarga:function(dSet,combo)
                                        {
                                            carpetaAdministrativa=-1;
                                            idCarpeta=-1;
                                            var aValor=combo.getRawValue();
                                            dSet.baseParams.criterio=aValor;
                                            dSet.baseParams.uG='<?php echo existeRol("'1_0'")?"":$_SESSION["codigoInstitucion"]?>';
                                            
                                            
                                            
                                        },
                            funcElementoSel:function(combo,registro)
                                        {
                                            carpetaAdministrativa=registro.data.carpetaAdministrativa;
                                            idCarpeta=registro.data.idCarpeta;
                                            
                                            var obj={};
                                            obj.ancho='100%';
                                            obj.alto='100%';
                                            obj.url='../modulosEspeciales_SGJ/tableroAudienciaAdministracion.php';
                                            obj.params=[['cA',bE(carpetaAdministrativa)],['idCarpetaAdministrativa',-1]];
                                            obj.titulo='Carpeta Judicial: '+(carpetaAdministrativa);
                                            window.parent.abrirVentanaFancy(obj);
                                            
                                            
                                        }  
                        };

		var carpetaJudicial=crearComboExtAutocompletar(oConf);
	
	}
	dispararAnalisisAlertas();
	var contenido=new Ext.Panel	(
                                    {	
                                        width:'100%',
                                        border:false,
                                        activeTab: 0,
                                        renderTo:'tblTabla',
                                        items:	[
                                        
                                                    new Ext.ux.IFrameComponent({ 

                                                                                        id: 'frameContenido', 
                                                                                        anchor:'100% 100%',
                                                                                        border:false,
                                                                                        loadFuncion:function(iFrame)
                                                                                                    {
                                                                                                    	
                                                                                                        
                                                                                                        autofitIframe(iFrame,
                                                                                                        				function()
                                                                                                                        {
                                                                                                                        	/*setTimeout(function()
                                                                                                                            {
                                                                                                                                if(autoScroll>0)
                                                                                                                                	window.scrollTo(0,autoScroll);
                                                                                                                                
                                                                                                                            },500);*/
                                                                                                                         });
                                                                                                        
                                                                                                    },

                                                                                        url: '../paginasFunciones/white.php',
                                                                                        style: 'width:100%;height:700px' 
                                                                                })
                                        
                                                    
                                                     
                                                ]		
                                    }
                            )
                            
                            
	$('.cabeceraMenu').collapsible(
    						 	{
                            	   	animate: true,
                                    contentOpen:0
                                }
                            );	 
                            
	

	inicializarTablero('tblNotificacionesBar');
                            
	
    
	<?php
	
	$consulta="SELECT DISTINCT idTableroControl FROM 9064_rolesTableroControl WHERE rol IN(".$_SESSION["idRol"].")";
	$listaTableros=$con->obtenerListaValores($consulta);
	if($listaTableros!="")
	{
	?>
    	mostrarTableroNotificaciones(bE(arrTableros[0].idTableroControl));
    <?php	
	}
	?>
	
    <?php

	if(existeRol("'23_0'"))
	{
		?>
        gEx('frameContenido').load({url:'../modulosEspeciales_SGJ/tblAdministracionExpedientesAutorizados.php',params:{cPagina:'sFrm=true'}});
      <?php
		
	}
	
	
	
	
	?>
    
}

function cerrarSesionPrincipal()
{
	function resp(btn)
    {
    	if(btn=='yes')
        {
            function procResp()
            {
                
                document.location.href="<?php echo $paginaCierreLogin?>";		
                
            }
            obtenerDatosWebV2('../paginasFunciones/funciones.php',procResp,'POST','funcion=2',true);
		}
	}
    msgConfirm('¿Est&aacute; seguro de querer cerrar la sesi&oacute;n?',resp);	
}

function regresar1Pagina()
{

	if((gEx('frameContenido'))&&( gEx('frameContenido').getFrameWindow().regresar1Pagina))
		gEx('frameContenido').getFrameWindow().regresar1Pagina();
    else
		recargarPagina();
}

function regresar2Pagina()
{

	if((gEx('frameContenido'))&&( gEx('frameContenido').getFrameWindow().regresar2Pagina))
		gEx('frameContenido').getFrameWindow().regresar2Pagina();
    else
		recargarPagina();
	
}

function recargarContenedorCentral()
{

	if((gEx('frameContenido'))&&( gEx('frameContenido').getFrameWindow().recargarContenedorCentral))
		gEx('frameContenido').getFrameWindow().recargarContenedorCentral();
    else
		recargarPagina();

    
}

function regresar1PaginaContenedor()
{

	if((gEx('frameContenido'))&&( gEx('frameContenido').getFrameWindow().regresar1PaginaContenedor))
		gEx('frameContenido').getFrameWindow().regresar1PaginaContenedor();
    else
		recargarPagina();


}

function regresarPagina2Contenedor()
{

	if((gEx('frameContenido'))&&( gEx('frameContenido').getFrameWindow().regresarPagina2Contenedor))
		gEx('frameContenido').getFrameWindow().regresarPagina2Contenedor();
    else
		recargarPagina();


}

function regresarContenedorCentral()
{

	if((gEx('frameContenido'))&&( gEx('frameContenido').getFrameWindow().recargarPagina))
    {
		gEx('frameContenido').getFrameWindow().recargarPagina();
        //alert('1');
    }
    else
    {
		recargarPagina();
		//alert('2');
    }

}

function recargarOrdenesNotificacion()
{

	if((gEx('frameContenido'))&&( gEx('frameContenido').getFrameWindow().recargarOrdenesNotificacion))
		gEx('frameContenido').getFrameWindow().recargarOrdenesNotificacion();

}

function generarTarjetaAcceso()
{
	
    enviarFormularioDatos('../modulosEspeciales_SICORE/generarCarnetAcceso.php',[],'POST','framePrincipal');
}

var primeraCargaFramePrincipal=true;

function frameLoadPrincipal(iFrame)
{
	if(!primeraCargaFramePrincipal)
    {
    	iFrame.contentWindow.print();
    }
    else
    	primeraCargaFramePrincipal=false;
	
}



function abrirDatosAccesoCuenta()
{
	var arrParam=[['idUsuario','<?php echo $_SESSION["idUsr"]?>'],['vCU','1']];
    
    var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.modal=false;
    obj.url='../Usuarios/tblInformacionUsuarios.php';
    obj.params=arrParam;
    window.parent.abrirVentanaFancy(obj);
    
}


