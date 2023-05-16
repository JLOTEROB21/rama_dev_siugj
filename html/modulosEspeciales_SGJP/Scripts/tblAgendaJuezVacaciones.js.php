<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT id__19_tablaDinamica,tipoIncidencia FROM _19_tablaDinamica where id__19_tablaDinamica<>3";
	$arrTiposIncidencia=$con->obtenerFilasArreglo($consulta);
	
?>
var cadObjIncidencia='';
var uploadControl;

var arrTiposIncidencia=<?php echo $arrTiposIncidencia?>;
var dragged_event;
Ext.onReady(inicializar);

function inicializar()
{
	$('#calendar').fullCalendar(
    								{
										defaultView:'month',
                                        allDayDefault:true,
                                     	header: 
                                        		{
                                                	left: '',
                            		            	center: '',
                                                    right:'month'
                                    	        },
										
                                        businessHours: true, // display business hours
                                        editable: true,
                                        selectable: true,
                                        defaultDate: '<?php echo date("Y-m-d")?>',
										contentHeight:'auto',
                                        loading:function(isLoading,view)
                                        		{
                                                	if(!isLoading)
                                                    {
                                                    	
                                                       	
                                                        
                                                    }
                                                },
                                                
                                        dayClick: function(date, jsEvent, view) 
                                        			{
                                                    	//mostrarVentanaAsignarJuez(1,null,date,date);
                                                    },
                                        
                                        select: function(start, end) 
                                        			{
                                                        mostrarVentanaAsignarJuez(1,null,start,end)
                                                        
                                                    },
                                        eventRender: function(event, element) 
                                                			{
																
                                                              	element.bind('dblclick', function(e) 
                                                              							{
                                                                                        	
                                                                                            
							                                                              }
                                                                           );        
                                                            },
                                        
                                        eventSources: 	[
                                                    		{
                                                            	url:'../paginasFunciones/funcionesPanelCalendario.php',
                                                                type:'POST',
                                                                data:	{
                                                                            funcion:6,
                                                                            uG:gE('idUnidadGestion').value
                                                                		}
                                                            }
                                                		]
                                                
             						 }
					);
    
    
}

function mostrarVentanaAsignarJuez(accion,evento,inicio,fin)
{
	var fInicio=inicio.format('YYYY-MM-DD');
    var lblFechaFin=fin.format('YYYY-MM-DD');
    var fechaFin=Date.parseDate(lblFechaFin,'Y-m-d');
    var fFin=fechaFin.add(Date.DAY,-1).format('Y-m-d');

	var tabla='<div><input type="text" id="txtFileName" disabled="true" style="border: solid 1px; background-color: #FFFFFF; width: 290px" /></div><div class="flash" id="fsUploadProgress">'+ 
					'</div><input type="hidden" name="hidFileID" id="hidFileID" value="" /> ';  

	var cObj={

                    upload_url: "../modulosEspeciales_SGJP/procesarComprobante.php", //lquevedor
                    file_post_name: "archivoEnvio",
     
                    // Flash file settings
                    file_size_limit : '100 MB',
                    file_types : '*.*',			// or you could use something like: "*.doc;*.wpd;*.pdf",
                    file_types_description : "Todos los archivos",
                    file_upload_limit : 0,
                    file_queue_limit : 1,
     
                   
                    upload_success_handler : subidaCorrecta,
                    
                    
                }
    

	if(inicio==fin)
    {
    	fFin=fin.format('YYYY-MM-DD');
    }
	
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            
                                            			{
                                                        	x:10,
                                                            y:20,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Periodo del :'
                                                            
                                                        },
                                                        {	
                                                        	x:170,
                                                            y:15,
                                                            html:'<div id="divFechaInicio" style="width:140px"></div>'
                                                        },
                                                        
                                                        {
                                                        	x:320,
                                                            y:20,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:' al '
                                                            
                                                        },
                                                        {	
                                                        	x:350,
                                                            y:15,
                                                            html:'<div id="divFechaFinal" style="width:140px"></div>'
                                                        },
                                                       
                                                        
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Juez a asignar:'
                                                        },
                                                        {	
                                                        	x:170,
                                                            y:65,
                                                            html:'<div id="divJuez"></div>'
                                                        },
                                                         {
                                                        	x:10,
                                                            y:120,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Documento complementario:'
                                                        },
                                            			 
                                                         {
                                                            x:280,
                                                            y:120,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:	'<table width="290"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr><tr id="filaAvance" style="display:none"><td align="right"><span style="font-size:11px" class="SIUGJ_Etiqueta">Porcentaje de avance:</span> <span style="font-size:11px" id="porcentajeAvance" class="SIUGJ_Etiqueta"> 0%</span></td></tr></table>'
                                                        },
                                                       
                                                        {
                                                            x:580,
                                                            y:118,
                                                            id:'btnUploadFile',
                                                            width:120,
                                                            icon:'../images/add.png',
                                                            
                                                            xtype:'button',
                                                            cls:'btnSIUGJCancel',
                                                            text:'Seleccionar',
                                                            handler:function()
                                                                    {
                                                                        $('#containerUploader').click();
                                                                    }
                                                        },
                                                        {
                                                            x:185,
                                                            y:10,
                                                            hidden:true,
                                                            html:	'<div id="containerUploader"></div>'
                                                        },
                                                        
                                                        {
                                                            x:290,
                                                            y:0,
                                                            xtype:'hidden',
                                                            id:'idArchivo'

                                                        },
                                                        {
                                                            x:290,
                                                            y:0,
                                                            xtype:'hidden',
                                                            id:'nombreArchivo'
                                                        } ,
                                                        {
                                                        	x:10,
                                                            y:170,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:200,
                                                            width:710,
                                                            height:80,
                                                            cls:'controlSIUGJ',
                                                            xtype:'textarea',
                                                            id:'txtComentariosAdicionales'
                                                        }
                                            
														
                                                       
                                                        

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Registro de periodo vacacional',
										width: 750,
										height:390,
										layout: 'fit',
										plain:true,
                                        id:'vIncidencia',
										modal:true,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	var arrJueces=eval(''+bD(gE('arrJueces').value)+'');
																	var cmbJuez=crearComboExt('cmbJuez',arrJueces,0,0,550,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divJuez'});
																
                                                                	new Ext.form.DateField (	{
                                                                                                        renderTo:'divFechaInicio',
                                                                                                        width:130,
                                                                                                        ctCls:'campoFechaSIUGJ',
                                                                                                        id:'fechaInicial',
                                                                                                        xtype:'datefield',
                                                                                                        value:fInicio
                                                                                                    }
                                                                                             )
                                                                
                                                                	
                                                               
                                                               		
                                                               
                                                               		new Ext.form.DateField (	{
                                                                                                        renderTo:'divFechaFinal',
                                                                                                        width:130,
                                                                                                        ctCls:'campoFechaSIUGJ',
                                                                                                        id:'fechaFinal',
                                                                                                        xtype:'datefield',
                                                                                                        value:fFin
                                                                                                    }
                                                                                             )
                                                               
                                                               		
                                                                    crearControlUploadHTML5(cObj);
                                                                    
                                                                    
																}
															}
												},
										buttons:	[
                                        				{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
																		var fechaInicial=gEx('fechaInicial');
                                                                        var fechaFinal=gEx('fechaFinal');
                                                                        var cmbJuez=gEx('cmbJuez');
                                                                        
                                                                        if(fechaInicial.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	fechaInicial.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la fecha inicial del periodo',resp1);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(fechaFinal.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	fechaFinal.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la fecha inicial del periodo',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(fechaInicial.getValue()>fechaFinal.getValue())
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	fechaFinal.focus();
                                                                            }
                                                                        	msgBox('La fecha inicial del periodo no puede ser mayor que la fecha final',resp3);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(cmbJuez.getValue()=='')
                                                                        {
                                                                        	function resp4()
                                                                            {
                                                                            	cmbJuez.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el juez a asignar',resp4);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                       
                                                                        
                                                                        cadObjIncidencia='{"tipoIncidencia":"3","tipoEvento":"3","fechaInicio":"'+fechaInicial.getValue().format('Y-m-d')+
                                                                        				'","fechaFin":"'+fechaFinal.getValue().format('Y-m-d')+
                                                                        			'","idJuez":"'+cmbJuez.getValue()+'","comentarios":"'+cv(gEx('txtComentariosAdicionales').getValue())+
                                                                                    '","idArchivo":"-1","nombreArchivo":"-1"}';
                                                                        
                                                                       
                                                                        if(uploadControl.files.length==0)
                                                                        {
                                                                          	guardarIncidencia(cadObjIncidencia,ventanaAM);
                                                                        }
                                                                        else
                                                                        {
                                                                        	uploadControl.start();
                                                                        }
                                                                        

                                                                        
                                                                        
																	}
														}
														
													]
									}
								);
	ventanaAM.show();	
}


function guardarIncidencia(cadObj,ventanaAM)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            recargarPagina();
            ventanaAM.close();
            
        }
        else
        {
           
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesPanelCalendario.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true);
                                                                        
                                                                        
}


function subidaCorrecta(file, serverData) 
{


    file.id = "singlefile";	// This makes it so FileProgress only makes a single UI element, instead of one for each file
    var arrDatos=serverData.split('|');

    if ( arrDatos[0]!='1') 
    {

    } 
    else 
    {
        
        gEx("idArchivo").setValue(arrDatos[1]);
        gEx("nombreArchivo").setValue(arrDatos[2]);
       	if(gE('txtFileName'))
	        gE('txtFileName').value=arrDatos[2];
        
       
      cadObjIncidencia=cadObjIncidencia.replace('"idArchivo":"-1","nombreArchivo":"-1"','"idArchivo":"'+arrDatos[1]+'","nombreArchivo":"'+arrDatos[2]+'"');
        
      guardarIncidencia(cadObjIncidencia,gEx('vIncidencia'));
        
        
    }
		
	
}

function removerAsignacion(iE)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:20,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Motivo por el cual desea remover el periodo vacacional:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:50,
                                                            cls:'controlSIUGJ',
                                                            id:'txtMotivo',
                                                            xtype:'textarea',
                                                            width:600,
                                                            height:80
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Remover periodo vacacional',
										width: 650,
										height:240,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
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
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
                                                        {
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
																		var txtMotivo=gEx('txtMotivo');	
                                                                        if(txtMotivo.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtMotivo.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el motivo por el cual desea remover la incidencia del juez',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        function respQuestion(btn)
                                                                        {
                                                                        	if(btn=='yes')
                                                                            {
                                                                            	function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                    	ventanaAM.close();
                                                                                        recargarPagina();
                                                                                        
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesPanelCalendario.php',funcAjax, 'POST','funcion=3&tipo=3&motivo='+cv(txtMotivo.getValue())+'&idAsignacion='+bD(iE),true);
                                                                                
                                                                            
                                                                            }
                                                                        }
                                                                        msgConfirm('¿Est&aacute; seguro de querer remover la incidencia del juez?',respQuestion);
                                                                        
                                                                        
                                                                        
																	}
														}
													]
									}
								);
	ventanaAM.show();
}


function mostrarVentanaIncidencias(id)
{
	var evento=scheduler.getEvent(id);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'<b>Periodo vacacional:</b>'
                                                        },
                                                        {
                                                        	x:180,
                                                            y:10,
                                                            html:' Del '+evento.start_date.format('d/m/Y')+' al '+evento.end_date.format('d/m/Y')
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'<b>Juez:</b>'
                                                        },
                                                        {
                                                        	x:180,
                                                            y:40,
                                                            html:Ext.util.Format.stripTags(evento.text)
                                                        },
                                                        
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'<b>Comentarios adicionales:</b>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            width:570,
                                                            height:80,
                                                            readOnly:true,
                                                            xtype:'textarea',
                                                            value:evento.comentarios.replace(/<br \/>/gi,'\r\n')
                                                        }		

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Datos del periodo vacacional',
										width: 620,
										height:280,
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