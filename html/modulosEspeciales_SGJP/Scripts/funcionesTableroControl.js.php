<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

function mostrarVentanaTareasDelegadas(iA)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											frame:false,
											defaultType: 'label',
											items: 	[
                                            			crearGridTareaAsignada(iA)
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Tarea turnada a...',
										width: 920,
										height:450,
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
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		
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

function crearGridTareaAsignada(iA)
{
	var raiz=new  Ext.tree.AsyncTreeNode	(
                                                      {
                                                          id:'-1',
                                                          text:'Raiz',
                                                          draggable:false,
                                                          expanded :true
                                                      }
                                              	)
                                        
	var cargadorArbol=new Ext.tree.TreeLoader(
													{
														baseParams:{
																		funcion:'10',
																		idActividad:bD(iA)
																	},
														dataUrl:'../paginasFunciones/funcionesTblFormularios.php',
														uiProviders:	{
																			'col': Ext.ux.tree.ColumnNodeUI
																		}
													}	


											 )		                                        


	var organigrama = new Ext.ux.tree.TreeGrid	(
														{
															id:'tTareaTurnada',
															region:'center',
															useArrows:true,
															autoScroll:false,
															animate:true,
															enableDD:true,
															border:true,
															frame:false,
															containerScroll: true,
															root:raiz,
															enableSort:false,
															loader: cargadorArbol,
															rootVisible:false,
															draggable:false,
															columns:[

																		{
																			header:'Usuario asignado',
																			width:400,
																			dataIndex:'usuariosAsignado'
																		},
																		{	
																			header:'Fecha de asignaci&oacute;n',
																			width:130,
																			align:'center',
																			dataIndex:'fechaAsignacion'
																		},
																		

																		{
																			header:'Fecha de visualizaci&oacute;n',
																			width:130,
																			align:'center',
																			dataIndex:'fechaVisualizacion'
																		},
																		{
																			header:'Atendi&oacute;',
																			width:70,
																			align:'center',
																			dataIndex:'atendio'
																		},
																		{
																			header:'Fecha de atenci&oacute;n',
																			width:130,
																			align:'center',
																			dataIndex:'fechaAtencion'
																		}
																	 ],
															 listeners: 	{
																				'render': 	function(tp)
																							{

																							 }
																				}


														}
												);
	return organigrama;												
												
		
}


function mostrarVentanaAperturaDocumento(o,iA,iT)
{
	var anchoVentana=(obtenerDimensionesNavegador()[1]*0.8);
	var altoVentana=(obtenerDimensionesNavegador()[0]*0.8);
	var o=eval('['+bD(o)+']')[0];
	
	var objConf={
					tipoDocumento:o.tipoDocumento,
					idRegistroFormato:o.idRegistroFormato,
					idFormulario:o.idFormulario,
					idRegistro: o.idRegistro,
					rol:o.actorAccesoProceso,
                    ancho:anchoVentana,
                    alto:altoVentana,
					functionAfterSignDocument:function()
								{
									function funcAjax()
									{
										var resp=peticion_http.responseText;
										arrResp=resp.split('|');
										if(arrResp[0]=='1')
										{
											mostrarTableroNotificaciones(iT);
											
										}
										else
										{
											msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
										}
									}
									obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=152&iT='+bD(iT)+'&iA='+bD(iA),true);
									
								},
					functionAfterValidate:function()
								{
									function funcAjax()
									{
										var resp=peticion_http.responseText;
										arrResp=resp.split('|');
										if(arrResp[0]=='1')
										{
											mostrarTableroNotificaciones(iT);
											
										}
										else
										{
											msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
										}
									}
									obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=152&iT='+bD(iT)+'&iA='+bD(iA),true);
									
								},
					functionAfterTurn:function()
								{
									function funcAjax()
									{
										var resp=peticion_http.responseText;
										arrResp=resp.split('|');
										if(arrResp[0]=='1')
										{
											mostrarTableroNotificaciones(iT);
										}
										else
										{
											msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
										}
									}
									obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=152&iT='+bD(iT)+'&iA='+bD(iA),true);
								},
                  	functionAfterLoadDocument:function()
                                              {
                                                  setTimeout(function()
                                                              {
                                                                  var body = CKEDITOR.instances.txtDocumento.editable().$;
                                                                  
                                                                  var value = (anchoVentana*100)/960;
                                                                  

                                                                  body.style.MozTransformOrigin = "top left";
                                                                  body.style.MozTransform = "scale(" + (value/100)  + ")";

                                                                  body.style.WebkitTransformOrigin = "top left";
                                                                  body.style.WebkitTransform = "scale(" + (value/100)  + ")";

                                                                  body.style.OTransformOrigin = "top left";
                                                                  body.style.OTransform = "scale(" + (value/100)  + ")";

                                                                  body.style.TransformOrigin = "top left";
                                                                  body.style.Transform = "scale(" + (value/100)  + ")";
                                                                  // IE
                                                                  body.style.zoom = value/100;
                                                              
                                                                  
                                                              },200
                                                          )
                                                  

                                                  
                                              }

				};
	registrarVisualizacionNotificacionTablero(iA,iT);				
	mostrarVentanaGeneracionDocumentos(objConf);
}

function registrarVisualizacionNotificacionTablero(iR,iT,funcionAccion)
{
	function funcAjax3(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	if(gEx('gridRegistros'))
            {
                 var pos=obtenerPosFila(gEx('gridRegistros').getStore(),'idRegistro',iR);
                 var fila=gEx('gridRegistros').getStore().getAt(pos);  
                 fila.set('fechaVisualizacion',arrResp[1]);  
                 if(funcionAccion)
                    funcionAccion();   
			}
        }
        
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesFormulario.php',funcAjax3, 'POST','funcion=240&iN='+iR+'&iT='+iT,false);
}

function mostrarVentanaDocumentoAutorizado(o,iA,iT)
{
	var o=eval('['+bD(o)+']')[0];
	if(o.idDocumentoFinal=='')
    {
    	function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                visualizarDocumentoFinalizado(arrResp[1],o);
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=220&iRF='+o.idRegistroFormato,true);
    }
    else
		visualizarDocumentoFinalizado(o.idDocumentoFinal,o);
	
	
}


function visualizarDocumentoFinalizado(iD,oComp)
{
	
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrNombre=arrResp[2].split('.');
            extension=arrNombre[arrNombre.length-1];
            
            var oProcesoComp={idFormulario:oComp.idFormulario,idRegistro:oComp.idRegistro, actor:arrResp[3]};
            
            mostrarVisorDocumentoProcesoV2(extension,arrResp[1],oProcesoComp);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=219&iF='+oComp.idFormulario+
    				'&iR='+oComp.idRegistro+'&r='+oComp.actorAccesoProceso+'&iD='+iD,true);
}



function mostrarVentanaDocumentoAutorizadoRespuestaMedidas(o,iA,iT)
{
	var o=eval('['+bD(o)+']')[0];
    o.iActividad=bD(iA);
    o.iTablero=bD(iT);
	if(o.idDocumentoFinal=='')
    {
    	function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                visualizarDocumentoFinalizadoRespuestaMedidas(arrResp[1],o);
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=220&iRF='+o.idRegistroFormato,true);
    }
    else
		visualizarDocumentoFinalizadoRespuestaMedidas(o.idDocumentoFinal,o);
	
	
}


function visualizarDocumentoFinalizadoRespuestaMedidas(iD,oComp)
{
	
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrNombre=arrResp[2].split('.');
            extension=arrNombre[arrNombre.length-1];
            
            var oProcesoComp={idFormulario:oComp.idFormulario,idRegistro:oComp.idRegistro, actor:arrResp[3]};
            
            
            var obj={};
            obj.url='../visoresGaleriaDocumentos/visorDocumentosMedidasCautelares.php';
            obj.ancho='100%';
            obj.alto='100%';
            obj.params=	[['iD',bE('iD_'+arrResp[1])],['cPagina','sFrm=true']];
            
            
            if(oProcesoComp)
            {
                var cadObj='';
                var o;
                for(var propiedad in oComp)
                {
                    o='"'+propiedad+'":"'+oComp[propiedad]+'"';
                    if(cadObj=='')
                        cadObj=o;
                    else
                        cadObj+=','+o;
                }
                
                cadObj='{'+cadObj+'}';
                
                obj.params.push(['oComp',bE(cadObj)]);
            }
            abrirVentanaFancy(obj);
            
            
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=219&iF='+oComp.idFormulario+
    				'&iR='+oComp.idRegistro+'&r='+oComp.actorAccesoProceso+'&iD='+iD,true);
}
