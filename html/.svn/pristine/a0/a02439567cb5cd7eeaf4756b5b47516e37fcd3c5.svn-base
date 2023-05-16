<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>


Ext.onReady(inicializar);

function inicializar()
{
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                border:false,
                                                layout:'border',
                                                items:	[
                                                             new Ext.ux.IFrameComponent({ 

                                                                                        id: 'frameContenido', 
                                                                                        anchor:'100% 100%',
                                                                                        border:false,
                                                                                        region:'center',
                                                                                        loadFuncion:function(iFrame)
                                                                                                    {
                                                                                                    	
                                                                                                        
                                                                                                        
                                                                                                        
                                                                                                    },

                                                                                        url: '../paginasFunciones/white.php',
                                                                                        style: 'width:100%;height:100%' 
                                                                                })
                                                        ]
                                            }
                                         ]
                            }
                        )   
                        
                        
	gEx('frameContenido').load({url:'../reportes/reportViewer2.php',params:{dispararEventos:gE('dispararEventos').value,cPagina:'sFrm=true',iR:gE('iR').value}});                        
}


function compartirReporte()
{
	var idUsuario=-1;
	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
                                            cls:'panelSiugj',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Indique el usuario con el cual se compartir&aacute; el reporte'
                                                        },
                                                        {
                                                        	xtype:'label',
                                                            x:10,
                                                            y:50,
                                                            id:'lblDivAsignaTarea',
                                                            html:'<div id="divUsuarioAsigna" style="width:475px"></div>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:110,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Comentarios adicionales'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:140,
                                                            width:600,
                                                            height:90,
                                                            cls:'SIUGJ_ControlEtiqueta',
                                                            xtype:'textarea',
                                                            id:'txtComentariosAdicionales'
                                                            
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Compartir reporte',
										width: 650,
										height:400,
										layout: 'fit',
										plain:true,
										modal:true,
                                        closable:false,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	 var oConf=	{
                                                                                    idCombo:'cmbUsuarioResponsable',
                                                                                    anchoCombo:450,
                                                                                    posX:0,
                                                                                    posY:0,
                                                                                    raiz:'registros',
                                                                                    campoDesplegar:'nombreUsuario',
                                                                                    campoID:'idRegistro',
                                                                                    funcionBusqueda:5,
                                                                                    renderTo:'divUsuarioAsigna',
                                                                                    ctCls:'campoComboWrapSIUGJAutocompletar',
                                                                                    listClass:'listComboSIUGJ',
                                                                                    paginaProcesamiento:'../paginasFunciones/funcionesProcesos.php',
                                                                                    confVista:'<tpl for="."><div class="search-item">[{idUsuario}] {nombreUsuario}<br>{adscripcion}<br>----</div></tpl>',
                                                                                    campos:	[
                                                                                                {name:'idUsuario'},
                                                                                                {name:'nombreUsuario'},
                                                                                                {name: 'adscripcion'}
                                                                  
                                                                                            ],
                                                                                    funcAntesCarga:function(dSet,combo)
                                                                                                {
                                                                                                    idUsuario=-1;
                                                                                                    var aValor=combo.getRawValue();
                                                                                                    dSet.baseParams.criterio=aValor;
                                                                                                    
                                                                                                                                          
                                                                                                    
                                                                                                },
                                                                                    funcElementoSel:function(combo,registro)
                                                                                                {
                                                                                                    idUsuario=registro.data.idUsuario;
                                                                                                    
                                                                                                }  
                                                                                };
                                                                                
                                                                                
                                                                		var cmbUsuarioResponsable=crearComboExtAutocompletar(oConf); 
                                                                        
                                                                        
                                                                        cmbUsuarioResponsable.focus(false,500);                
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
																		if(idUsuario==-1)
                                                                        {
                                                                        	msgBox('Debe seleccionar el usuario con el cual se compartira el reporte');
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        var cadObj='{"idUsuarioDestinatario":"'+idUsuario+'","idReporte":"'+gE('iR').value+
                                                                        			'","comentariosAdicionales":"'+(gEx('txtComentariosAdicionales').getValue())+'"}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                function resp()
                                                                                {
                                                                                	ventanaAM.close();
                                                                                }
                                                                                msgBox('Se ha compartido el reporte',resp);
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',funcAjax, 'POST','funcion=36&cadObj='+cadObj,true);

                                                                        
                                                                        
																	}
														}
														
													]
									}
								);
	ventanaAM.show();
}



function analisisAlertaReporte(campos,almacen)
{
	var arrDisparadores=eval(bD(gE('arrDisparadores').value));
    
    var arrRegistrosCumplen=[];
    var posColumna=0;
    var filaDisparador;
    var posDisparador=0;
    var posRegistros=0;
    var registro;
    var resultado;
    for(posDisparador=0;posDisparador<arrDisparadores.length;posDisparador++)
    {
    	arrRegistrosCumplen=[];
    	filaDisparador=arrDisparadores[posDisparador];
        posColumna=existeValorArreglo(campos,filaDisparador[0]);

        for(posRegistros=0;posRegistros<almacen.length;posRegistros++)
        {
        	registro=almacen[posRegistros];
            resultado=false;
            eval('resultado=registro[posColumna]'+filaDisparador[1]+'filaDisparador[2];');
            if(resultado)
            {
            	arrRegistrosCumplen.push(registro);
            }
            
        }
        
        if(arrRegistrosCumplen.length>0)
        {
    		var arrRegistros=convertirArregloRegistrosJSON(campos,arrRegistrosCumplen);    
            
            var cadObj='{"idDisparador":"'+filaDisparador[4]+'","idFuncion":"'+filaDisparador[3]+'","idReporte":"'+gE('iR').value+'","arrRegistros":"'+bE(arrRegistros)+'"}';
            
            
            function funcAjax(peticion_http)
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                    
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWebV2('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesScriptsFormularios.php',funcAjax, 'POST','funcion=5&cadObj='+cadObj,false);

            
            
        }
        
    }
}

function convertirArregloRegistrosJSON(campos,arrRegistrosCumplen)
{
	var arrObj='';
    var obj;
    
    var x;
    var z;
    var fila;
    for(x=0;x<arrRegistrosCumplen.length;x++)
    {
    	obj='';
    	fila=arrRegistrosCumplen[x];
    	for(z=0;z<campos.length;z++)
        {

        	if(obj=='')
            	obj='"'+campos[z]+'":"'+cv(fila[z]==null?'':fila[z],false,true)+'"';
            else
        		obj+=',"'+campos[z]+'":"'+cv(fila[z]==null?'':fila[z],false,true)+'"';
        }
        obj='{'+obj+'}';
        
        if(arrObj=='')
        	arrObj=obj;
        else
        	arrObj+=','+obj;
        
        
    }
    
    var cadObj='['+arrObj+']';
    
   	return cadObj;
    
}