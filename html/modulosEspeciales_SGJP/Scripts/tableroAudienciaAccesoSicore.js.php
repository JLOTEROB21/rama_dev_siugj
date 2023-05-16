<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT idEtapaProcesal,descripcionEtapa,orden FROM 7009_etapasProcesales ORDER BY orden";
	$arrEtapasProcesales=$con->obtenerFilasArreglo($consulta);
	
	
	
	$idPerfilEvento=bD($_GET["iP"]);
	$idEvento=bD($_GET["iE"]);
	$carpetaAdministrativa=bD($_GET["cA"]);
	
	
	
	$consulta="SELECT idSituacion,descripcionSituacion FROM 7011_situacionEventosAudiencia";
	$arrSituacionEvento=$con->obtenerFilasArreglo($consulta);
	
	
	



$consulta="select urlMultimedia,idSala from 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
$fDatosEvento=$con->obtenerPrimeraFila($consulta);
$urlMultimedia=$fDatosEvento[0];

$consulta="SELECT canalVideo FROM _15_tablaDinamica WHERE id__15_tablaDinamica=".($fDatosEvento[1]==""?-1:$fDatosEvento[1]);
$canal=$con->obtenerValor($consulta);
$idSala=$fDatosEvento[1];

$consulta="SELECT id__5_tablaDinamica,nombreTipo FROM _5_tablaDinamica";
$arrParticipantes=$con->obtenerFilasArreglo($consulta);

?>
var iSala='<?php echo $idSala?>';
var canalSala='<?php echo $canal?>';
var urlMultimedia='<?php echo $urlMultimedia?>';
var arrEtapasProcesales=<?php echo $arrEtapasProcesales?>;
var arrParticipantes=<?php echo $arrParticipantes?>;
Ext.onReady(inicializar);

function inicializar()
{
	var arrPaneles=[];
    arrPaneles.push	(
        					{
                                xtype:'panel',
                                title:'Datos de la audiencia',
                                layout:'border',
                                border:false,
                                items:	[
                                            new Ext.ux.IFrameComponent({ 

                                                            id: 'frameContenidoAudiencia', 
                                                            region:'center',
                                                            anchor:'100% 100%',
                                                            url: '../paginasFunciones/white.php',
                                                            style: 'width:100%;height:100%',
                                                            loadFuncion: function(el)
                                                                        {
                                                                            
                                                                           
                                                                        }  
                                                    })
                                        ]
                            }
        				);
    
    if((urlMultimedia!='')||(canalSala!=''))
    {
        arrPaneles.push	(
                                {
                                    xtype:'panel',
                                    layout:'border',
                                    title:urlMultimedia!=''?'Videograbaci&oacute;n de la audiencia':'Audiencia en vivo',
                                    listeners:	{
                                                    activate:function(p)
                                                            {
                                                                if(!p.visualizado)
                                                                {
                                                                    p.visualizado=true;
                                                                    if(urlMultimedia!='')
                                                                    {
                                                                        gEx('frameContenidoGrabacion').load	(
                                                                                                                {
                                                                                                                    url:'../modulosEspeciales_SGJP/visorGrabacionAudiencia.php',
                                                                                                                    params:	{
                                                                                                                                cPagina:'sFrm=true',
                                                                                                                                autoPlay:0,
                                                                                                                                idEvento:bE(gE('idEventoAudiencia').value)
                                                                                                                            }
                                                                                                                }
                                                                                                            )  
                                                                	}
                                                                    else
                                                                    {
                                                                        gEx('frameContenidoGrabacion').load	(
                                                                                                                {
                                                                                                                    url:'../modulosEspeciales_SGJP/visorStreamSalaAudiencia.php',
                                                                                                                    params:	{
                                                                                                                                cPagina:'sFrm=true',
                                                                                                                                idSala:iSala
                                                                                                                            }
                                                                                                                }
                                                                                                            )  

                                                                    }
                                                                }
                                                            }
                                                },
                                    
                                    border:false,
                                    items:	[
                                                new Ext.ux.IFrameComponent({ 
    
                                                                id: 'frameContenidoGrabacion', 
                                                                region:'center',
                                                                anchor:'100% 100%',
                                                                url: '../paginasFunciones/white.php',
                                                                style: 'width:100%;height:100%',
                                                                loadFuncion: function(el)
                                                                            {
                                                                                
                                                                               
                                                                            }  
                                                        })
                                            ]
                                }
                            );
        
        
        
        arrPaneles[1].visualizado=false;
    }
    
    
	Ext.QuickTips.init();
    var vista=new Ext.Viewport(	{
                                layout: 'border',
                                listeners:	{
                                                show : {
                                                            buffer : 3000,
                                                            fn : function() 
                                                            {
                                                               
                                                                vista.doLayout();
                                                            }
                                                        }
                                             },
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                title:'Carpeta Administrativa [<span style="color:#900"><b>'+gE('carpetaAdministrativa').value+'</b></span>], '+
                                                                                		'Etapa procesal: <span style="color:#900"><b>'+bD(gE('etapaProcesal').value)+'</b></span>, '+
                                                                                        'Situaci&oacute;n carpeta: <span style="color:#900"><b>'+bD(gE('situacionCarpeta').value)+'</b></span>',
                                                items:	[	
                                                
                                                			crearGridAccesoPartes(),
                                                            {
                                                            	xtype:'tabpanel',
                                                                activeTab:0,
                                                                id:'tPanelCarpetas',
                                                                
                                                                region:'center',                                                                
                                                                items:	[
                                                                			arrPaneles              
                                                                		]
                                                                
                                                            }
                                                        ]
                                            }
                                         ]
                            }
                        )  
    
    var x;
    for(x=0;x<3;x++)
    {
    	if(x!=1)
	    	gEx('tPanelCarpetas').setActiveTab(x);
    }    
    gEx('tPanelCarpetas').setActiveTab(0);
     gEx('frameContenidoAudiencia').load	(
                                        {
                                            url:'../modulosEspeciales_SGJP/pDatosAudiencia.php',
                                            params:	{
                                                        cPagina:'sFrm=true',
                                                        autoPlay:0,
                                                        sL:1,
                                                        idEvento:bE(gE('idEventoAudiencia').value)
                                                    }
                                        }
                                    )
    
                          
                         
    
    
    if(gEx('frameContenido'))                   
    {
        gEx('frameContenido').load	(
                                        {
                                            url:'../modulosEspeciales_SGJP/datosAudienciaTablero.php',
                                            params:	{
                                                        cPagina:'sFrm=true',
                                                        idEvento:gE('idEventoAudiencia').value
                                                    }
                                        }
                                    )                        
                         
	}
    
    gEx('txtCodigoAcceso').ultimaBusqueda='';
	gEx('txtCodigoAcceso').focus(false,500);
}

function recargarGrids()
{
	if(gEx('gActuacionDigital'))
    	gEx('gActuacionDigital').getStore().reload();
        
}

function regresar1Pagina()
{
	recargarGrids();
}

function regresar2Pagina()
{
	recargarGrids();
	
}

function recargarContenedorCentral()
{
	recargarGrids();

    
}

function regresar1PaginaContenedor()
{
	recargarGrids();


}

function regresarPagina2Contenedor()
{
	recargarGrids();


}

function regresarContenedorCentral()
{
	recargarGrids();

}


function crearGridAccesoPartes()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'cveUsuario'},
		                                                {name: 'nombre'},
		                                                {name:'situacion'},
                                                        {name:'participacion'},
                                                        {name: 'comentariosAdicionales'},
                                                        {name: 'idRegistro'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_SICORE.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'participacion', direction: 'ASC'},
                                                            groupField: 'participacion',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='100';
                                        proxy.baseParams.idEvento=gE('idEventoAudiencia').value;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	switch(val)
                                                                            {
                                                                            	case '0':
                                                                                	return '<img src="../images/cancel_round.png" title="Acceso cancelado, motivo: '+
                                                                                    cv(registro.data.comentariosAdicionales)+'" alt="Acceso cancelado, motivo: '+
                                                                                    cv(registro.data.comentariosAdicionales)+'">';
                                                                                break;
                                                                                case '1':
                                                                                	return '<img src="../images/control_pause.png" title="Acceso en espera de confirmaci&oacute;n" alt="Acceso en espera de confirmaci&oacute;n">';
                                                                                break;
                                                                                case '2':
                                                                                	return '<img src="../images/accept_green.png" title="Acceso confirmado" alt="Acceso confirmado">';
                                                                                break;
                                                                                
                                                                            }
                                                                        }
                                                            },
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	switch(val)
                                                                            {
                                                                            	case '0':
                                                                                	return '<a href="javascript:activarAcceso(\''+bE(registro.data.idRegistro)+'\')"><img src="../images/accept_green.png" title="Activar acceso" alt="Activar acceso"></a>';
                                                                                break;
                                                                                case '1':
                                                                                	return '<a href="javascript:reintentarActivacionAcceso(\''+bE(registro.data.idRegistro)+'\')"><img src="../images/arrow_refresh.PNG" title="Reintentar activaci&oacute;n de acceso" alt="Reintentar activaci&oacute;n de acceso"></a>';
                                                                                break;
                                                                                case '2':
                                                                                	return '<a href="javascript:cancelarAccesoAcceso(\''+bE(registro.data.idRegistro)+'\')"><img src="../images/cancel_round.png" title="Cancelar acceso" alt="Cancelar acceso"></a>';
                                                                                break;
                                                                                
                                                                            }
                                                                        }
                                                            },
                                                            {
                                                                header:'Nombre',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'nombre',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return mostrarValorDescripcion('('+registro.data.cveUsuario+') '+val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Participáci&oacute;n',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'participacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrParticipantes,val);
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gAccesos',
                                                                store:alDatos,
                                                                width:350,
                                                                region:'east',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,   
                                                                tbar:	[
                                                                			{
                                                                            	xtype:'label',
                                                                                html:'<b>Codigo de usuario:</b>&nbsp;&nbsp;&nbsp;'
                                                                            },
                                                                            {
                                                                                xtype:'textfield',
                                                                                id:'txtCodigoAcceso',
                                                                                width:150,
                                                                                enableKeyEvents:true,
                                                                                listeners:	{
                                                                                                keypress:function(txt,e)
                                                                                                    {
                                                                                                    	
                                                                                                        if(e.charCode=='13')
                                                                                                        {
                                                                                                            if(txt.ultimaBusqueda.trim()!=txt.getValue().trim())
                                                                                                            {
                                                                                                            	
                                                                                                                registrarCodigoAcceso(txt.getValue());
                                                                                                            }
                                                                                                        }
                                                                                                    },
                                                                                                blur:function(txt)
                                                                                                    {
                                                                                                        
                                                                                                        if(txt.ultimaBusqueda.trim()!=txt.getValue().trim())
                                                                                                        {
                                                                                                            registrarCodigoAcceso(txt.getValue());
                                                                                                        }
                                                                                                        
                                                                                                    }
                                                                                            }
                                                                            },
                                                                		],                                                             
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :false,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
                                                        
	                                                        
        return 	tblGrid;	
}

function registrarCodigoAcceso(cveAcceso)
{
	if(cveAcceso.trim()=='')
    {
    	return;
    }
    
    
	var pos=obtenerPosFila(gEx('gAccesos').getStore(),'cveUsuario',cveAcceso.trim());
    if(pos!=-1)
    {
    	function resp()
        {
        	var txtCodigoAcceso=gEx('txtCodigoAcceso');
            txtCodigoAcceso.setValue('');
            txtCodigoAcceso.focus();
        }
    	msgBox('El c&oacute;digo de usuario ingresado, ya ha sido registrado previamente',resp);
    	return;
    }
	
	gEx('txtCodigoAcceso').ultimaBusqueda=cveAcceso.trim();

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            if(arrResp[1]=='0')
            {
                function resp2()
                {
                    var txtCodigoAcceso=gEx('txtCodigoAcceso');
                    txtCodigoAcceso.focus();
                }
                msgBox('La clave de acceso ingresada NO es v&aacute;lida',resp2);
            }
            else
            {
                gEx('gAccesos').getStore().reload();
                var txtCodigoAcceso=gEx('txtCodigoAcceso');
                txtCodigoAcceso.setValue('');
                txtCodigoAcceso.focus();
            }
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SICORE.php',funcAjax, 'POST','funcion=101&idEvento='+gE('idEventoAudiencia').value+'&cveUsuario='+cveAcceso.trim(),true);
}


function activarAcceso(iR)
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
                    gEx('gAccesos').getStore().reload();
                    
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SICORE.php',funcAjax, 'POST','funcion=102&iA='+
                            bD(iR)+'&situacion=2&comentarios=',true);	
		}
	}
    msgConfirm('Est&aacute; seguro de querer activar el acceso a la audiencia?',resp);
}

function cancelarAccesoAcceso(iR)
{

	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Ingrese el motivo de la cancelaci&oacute;n:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            xtype:'textarea',
                                                            width:500,
                                                            height:80,
                                                            id:'txtMotivo'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Cancelar acceso',
										width: 550,
										height:220,
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	gEx('txtMotivo').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                    	var txtMotivo=gEx('txtMotivo');
                                                                        
                                                                        if(txtMotivo.getValue()=='')
                                                                        {
                                                                            function resp()
                                                                            {
                                                                                txtMotivo.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el motivo de la cancelaci&oacute;n',resp);
                                                                            return;
                                                                        }
                                                                          
                                                                        
                                                                        
																		function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gEx('gAccesos').getStore().reload();
                                                                               	ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SICORE.php',funcAjax, 'POST','funcion=102&iA='+
                                                                        				bD(iR)+'&situacion=0&comentarios='+cv(gEx('txtMotivo').getValue()),true);	
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	
    
    

	    
}

function reintentarActivacionAcceso(iR)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            gEx('gAccesos').getStore().reload();
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SICORE.php',funcAjax, 'POST','funcion=103&iA='+bD(iR),true);	
}