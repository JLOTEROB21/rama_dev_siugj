<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$query="select idEstilo,nombreEstilo from 932_estilos order by nombreEstilo";
	$arrEstilos=uEJ($con->obtenerFilasArreglo($query));
	$res5=$con->obtenerFilas("select idIdioma,idioma,imagen from 8002_idiomas");
	$columnas="";
	$arrIdiomas="";
	$ct=0;
	$campoGrid="";
	$arrCamposGrid="";
	$arrLblRender="";
	while($fila5=mysql_fetch_row($res5))
	{
		$filaIdioma='{"idIdioma":"'.$fila5[0].'","idioma":"'.$fila5[1].'","imagen":"'.$fila5[2].'"}';
		if($arrIdiomas=="")
			$arrIdiomas=$filaIdioma;
		else
			$arrIdiomas.=",".$filaIdioma;
		$campoGrid='etiqueta_'.$fila5[0].':""';	
		$arrCamposGrid.=",".$campoGrid;
		$arrLblRender=",etiqueta_".$fila5[0].":'<img src=\"../images/banderas/".$fila5[2]."\">&nbsp;&nbsp;Etiqueta'";
		$ct++;
		
	}
	echo "var arrIdiomas=[".uE($arrIdiomas)."];
	var nIdiomas=".$ct.";";
	$consulta="select idValorSesion,descripcionValor,valorReemplazo from 8003_valoresSesion where tipo=1 order by descripcionValor ";
	$arrValorSesion=uEJ($con->obtenerFilasArreglo($consulta));
	$consulta="select idValorSesion,descripcionValor,valorReemplazo from 8003_valoresSesion where tipo=2 order by descripcionValor ";
	$arrValorSistema=uEJ($con->obtenerFilasArreglo($consulta));
	
	$consulta="SELECT idEscalaCalificacion,nombreEscala FROM 4032_escalasCalificacion ORDER BY nombreEscala";
	$arrEscala=$con->obtenerFilasArreglo($consulta);
	
	
?>

var arrTipoCuestionario=[['0','Cuestionario est\xE1ndar'],['1','Cuestionario de evaluaci\xF3n']];
Ext.onReady(inicializar);
var nodoSel=null;
var nodoSelPreguntas=null;
var arrParamConfiguraciones;
var g;
var idElementoSel='';
var divCtrlSel=null;
var arrCamposAlmacen;
var arrEstilos=<?php echo $arrEstilos?>;
var arrEscala=<?php echo $arrEscala?>;
var arrAlmacenDatos=[];
var arrPonderacionHijos=[['0','Manual'],['1','Equitativa']];


var regRespuesta=null;

var ctrlDestino=null;

function inicializar()
{
	var idRep=gE('idReporte').value;
	Ext.QuickTips.init();
    var obj={};
    
    obj.permitirRegistroParametro=true;
    altura=obtenerDimensionesNavegador()[1];
    obj.alto=altura;
    obj.idReferencia=gE('idReporte').value;
    obj.tDataSet=6;
    obj.region='center';
    obj.collapsible=false;
    obj.title='<b>Almacenes de datos</b>';
    obj.tituloConcepto='el formulario';
    obj.mConsultaAux='0';
    
    var arbolAlmacen=crearArbolAlmacen(obj);
	var pagRegresar=gE('pagRegresar').value;    
    var nUsuario=gE('nUsuario').value;
    var arbolPreguntas=crearArbolPreguntas()
    var tb=new Ext.Toolbar	(
    							{
									region: 'north',
                                    height:28,
                                    border:false,
                                    items:	[
                                    			{
                                                	xtype:'spacer',
                                                    width:15
                                                },
                                                {
                                                	xtype:'label',
                                                	html:'<table><tr><td><a href="'+pagRegresar+'"><img src="../images/flechaizq.gif" /></a></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<span class="letraExt"><b>Bienvenido: </b>&nbsp;'+nUsuario+' </span></td></tr></table></a>'
                                                    
                                                },
                                                {
                                                	xtype:'spacer',
                                                    width:15
                                                }
                                                
                                            ]
                                }
    						);
    
    var viewport = new Ext.Viewport(
    									{
                                            layout: 'border',
                                            region:'center',
                                            items: [
                                                        tb,
                                                    	{
                                                            layout:'border',
                                                            xtype:'panel',
                                                            items:	[
                                                                        {
                                                                            border:false,	
                                                                            tbar:	[
                                                                                        {
                                                                                            xtype:'tbspacer',
                                                                                            width:10
                                                                                        },'-',
                                                                                        {
                                                                                            icon:'../images/formularios/paintbrush.png',
                                                                                            tooltip:'Crear estilo',
                                                                                            cls:'x-btn-text-icon',
                                                                                            text:'Crear estilo',
                                                                                            handler:function()
                                                                                                    {
                                                                                                        mostrarVentanaEstilos();
                                                                                                    }
                                                                                        },'-',
                                                                                        
                                                                                    ],
                                                                            region:'center',
                                                                            id:'tblCenter',
                                                                            title:'',
                                                                            autoScroll: true,
                                                                            xtype:'iframepanel',
                                                                            deferredRender: false,
                                                                            loadMask:	{
                                                                                            msg:'Cargando'
                                                                                        },
                                                                            autoLoad:	{
                                                                                            url:'../thotCuestionarios/cuestionarioModel.php',
                                                                                            scripts:true,
                                                                                            params:	{
                                                                                                        cPagina:'sFrm=true',
                                                                                                        idCuestionario:idRep,
                                                                                                        vistaDiseno:1
                                                                                                        
                                                                                                    }
                                                                                        }
                                                                        }
                                                                    ],
                                                            region:'center'
                                                        },    
                                                        {
                                                            layout: 'accordion',
                                                            id: 'layout-browser',
                                                            region:'west',
                                                            border: true,
                                                            split:true,
                                                            width: 255,
                                                            layoutConfig: 	{
                                                            					animate:true
                                                            				},
                                                            collapsible:false,
                                                            items: 	[
                                                                        {
                                                                            layout: 'border',
                                                                            id: 'layout-browser',
                                                                            border: false,
                                                                            title:'<b>Vista esquema</b>',
                                                                            items: 	[
                                                                                         arbolPreguntas
                                                                                     ]
                                                                         },
                                                                         arbolAlmacen
                                                                         
                                                                         
                                                                        
                                                                        
                                                                    ]
                                                        }
                                                    
                                                    
                                                    ]
               							}
                                    );
                                    
	regRespuesta=crearRegistro	(
                                        [
                                            {name: 'idRespuesta'},
                                            {name: 'etiqueta'},
                                            {name: 'respuestaCorrecta'}
                                        ]
                                    )                                    
                                    
}

function formatearAlmacen(val)
{
	var arrAlmacen=gEx('cmbAlmacenGraf').getStore();
    var pos=obtenerPosFila(arrAlmacen,'id',val);
    if(pos!='-1')
	    return arrAlmacen.getAt(pos).get('nombre');
    else
    	return '';
}

function crearArbolPreguntas()
{
	var iR=gE('idReporte').value;
	var cargadorArbol=new Ext.tree.TreeLoader(
												{
													baseParams:{
																	funcion:'44',
                                                                    idConsulta:iR
																},
													dataUrl:'../paginasFunciones/funcionesThot.php'
												}
											)	
	
	cargadorArbol.on('beforeload',function(proxy)
    								{
                                    	nodoSelPreguntas=null;
                                        gEx('addSeccion').disable();
                                        gEx('addCampoTexto').disable();
                                        gEx('addPregunta').disable();
                                        gEx('addModificarPregunta').disable();
                                        gEx('removerPregunta').disable();
                                        gEx('addParrafo').disable();
                                        if(gEx('tblCenter')!=null)
                                        {
                                            gEx('tblCenter').load(	{
                                                                        url:'../thotCuestionarios/cuestionarioModel.php',
                                                                        scripts:true,
                                                                        params:	{
                                                                                    cPagina:'sFrm=true',
                                                                                    idCuestionario:iR
                                                                                    
                                                                                }
                                                                    }
                                                                 )
                                       }
                                    }
    				)
    

    var raiz=new  Ext.tree.AsyncTreeNode	(
                                                  {
                                                      id:'-1',
                                                      text:'DTD',
                                                      draggable:false,
                                                      expanded :true
                                                  }
                                            )

	panelArbol=new Ext.tree.TreePanel	(
                                              {
                                              	  id:'arbolPreguntas',
                                                  useArrows:true,
                                                  autoScroll:true,
                                                  animate:false,
                                                  enableDD:true,
                                                  border:false,
                                                  frame:false,
                                                  tbar:	[
                                                  
                                                  			{
                                                                icon:'../images/addMenu.gif',
                                                                cls:'x-btn-text-icon',
                                                                id:'addSeccion',
                                                                disabled:true,
                                                                tooltip:'Agregar secci&oacute;n',
                                                                handler:function()
                                                                        {
                                                                            mostrarVentanaAgregarSeccion(-1,nodoSelPreguntas.attributes.codigoUnidad);
                                                                        }
                                                                
                                                            },'-',
                                                            {
                                                                icon:'../images/formularios/textfield_add.png',
                                                                cls:'x-btn-text-icon',
                                                                id:'addCampoTexto',
                                                                disabled:true,
                                                                tooltip:'Agregar campo de texto',
                                                                handler:function()
                                                                        {
                                                                            mostrarVentanaAgregarCampoTexto(-1,nodoSelPreguntas.attributes.codigoUnidad);
                                                                        }
                                                                
                                                            },'-',
                                                            {
                                                                icon:'../images/font_add.png',
                                                                cls:'x-btn-text-icon',
                                                                id:'addParrafo',
                                                                disabled:true,
                                                                tooltip:'Agregar p&aacute;rrafo',
                                                                handler:function()
                                                                        {
                                                                            mostrarVentanaAgregarParrafo(-1,nodoSelPreguntas.attributes.codigoUnidad);
                                                                        }
                                                                
                                                            },'-',
                                                            
                                                           
                                                            {
                                                                icon:'../images/agregaOpcion.gif',
                                                                cls:'x-btn-text-icon',
                                                                id:'addPregunta',
                                                                disabled:true,
                                                                tooltip:'Agregar pregunta',
                                                                handler:function()
                                                                        {
                                                                            mostrarVentanaAgregarPregunta(-1,nodoSelPreguntas.attributes.codigoUnidad);
                                                                        }
                                                                
                                                            },'-',
                                                            {
                                                                icon:'../images/pencil.png',
                                                                cls:'x-btn-text-icon',
                                                                id:'addModificarPregunta',
                                                                disabled:true,
                                                                tooltip:'Modificar pregunta/Secci&oacute;n',
                                                                handler:function()
                                                                        {
                                                                            switch(nodoSelPreguntas.attributes.tipoElemento)
                                                                            {
                                                                            	case '0':
                                                                                	modificarCuestionario();
                                                                                break;
                                                                            	case '1':
                                                                                	mostrarVentanaAgregarSeccion(nodoSelPreguntas.attributes.idElemento,nodoSelPreguntas.parentNode.attributes.codigoUnidad);
                                                                                break;
                                                                                case '2':
                                                                                	mostrarVentanaAgregarParrafo(nodoSelPreguntas.attributes.idElemento,nodoSelPreguntas.parentNode.attributes.codigoUnidad);
                                                                                break;
                                                                                case '3':
                                                                                	mostrarVentanaAgregarPregunta(nodoSelPreguntas.attributes.idElemento,nodoSelPreguntas.parentNode.attributes.codigoUnidad);
                                                                                break;
                                                                                case '4':
                                                                                	mostrarVentanaAgregarCampoTexto(nodoSelPreguntas.attributes.idElemento,nodoSelPreguntas.parentNode.attributes.codigoUnidad);
                                                                                break;
                                                                            }
                                                                        }
                                                                
                                                            },'-',
                                                            {
                                                                icon:'../images/delete.png',
                                                                cls:'x-btn-text-icon',
                                                                id:'removerPregunta',
                                                                disabled:true,
                                                                tooltip:'Remover pregunta/Secci&oacute;n',
                                                                handler:function()
                                                                        {
                                                                           if(nodoSelPreguntas==null) 
                                                                           {
	                                                                           	msgBox('Debe seleccionar el elemento que desea remover');
                                                                                return;
                                                                           }
                                                                           
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
                                                                                        	gEx('arbolPreguntas').getRootNode().reload();
			                                                                                gEx('arbolPreguntas').expandAll();
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                        }
                                                                                    }
                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=47&idElemento='+nodoSelPreguntas.attributes.idElemento,true);
                                                                                }
                                                                           }
                                                                           msgConfirm('Est&aacute; seguro de querer remover el elemento seleccionado?',resp)
                                                                        }
                                                                
                                                            }
                                                  		],
                                                  height:570,
                                                  region:'center',
                                                  containerScroll:true,
                                                  root:raiz,
                                                  rootVisible:false,
												  loader: cargadorArbol
                                                                                                
                                               }
                                          );      
    panelArbol.expandAll();
    panelArbol.on('click',funcClickArbolPreguntas);
    return panelArbol;
}

function funcClickArbolPreguntas(nodo)
{
	nodoSelPreguntas=nodo;
    gEx('addCampoTexto').disable();
    gEx('addSeccion').disable();
    gEx('addPregunta').disable();
    gEx('addModificarPregunta').disable();
    gEx('removerPregunta').disable();
    gEx('addParrafo').disable();
    switch(nodoSelPreguntas.attributes.tipoElemento)
    {
    	case '0':
    	case '1':
        	 gEx('addCampoTexto').enable();
        	 gEx('addSeccion').enable();
             gEx('addPregunta').enable();
             gEx('addParrafo').enable();
        case '2':
        case '3':
        case '4':
        	 gEx('addModificarPregunta').enable();
             gEx('removerPregunta').enable();
             if(nodoSelPreguntas.attributes.tipoElemento=='0')
             {
	             gEx('removerPregunta').disable();
             }
        break;
    }
}

var arrOrigenesDatos=[['1','Almac\xE9n de datos'],['2','Consulta auxiliar']];

function funcTipoEntradaChange2(combo,registro)
{
	var txtValorConstante=gEx('txtValorConstante');
    txtValorConstante.hide();
    var cmbValor=gEx('cmbValor');
    cmbValor.hide();
    
	switch(registro.get('id'))
    {
    	case '1':
        	txtValorConstante.show();
        break;
        case '2':
        	cmbValor.getStore().loadData(arrParametrosRep);
        	cmbValor.show();
        break;
        case '3':
        	cmbValor.getStore().loadData(arrValorSesion);
        	cmbValor.show();
        break;
        case '4':
        	cmbValor.getStore().loadData(arrValorSistema);
        	cmbValor.show();
        break;
        case '7':
        	var arrConsultaAux=new Array();
            var arbolDataSet=gEx('arbolDataSet');
            var raiz=arbolDataSet.getRootNode();
            var nodoConsulta=raiz.childNodes[1];
            var x;
            var obj;
            for(x=0;x<nodoConsulta.childNodes.length;x++)
            {
            	
                    obj=new Array();
                    obj[0]=nodoConsulta.childNodes[x].id;
                    obj[1]='Consulta: '+nodoConsulta.childNodes[x].text;
                    arrConsultaAux.push(obj);
                
           	}
        	cmbValor.getStore().loadData(arrConsultaAux);
        	cmbValor.show();
        break;
        case '8':
        	cmbValor.getStore().loadData(arrCamposAlmacen);
        	cmbValor.show();
        break;
        
    }
}

function mostrarVentanaAgregarSeccion(idSeccion,codigoPadre)
{
	var valProcentajeMax=-1;
	var lblVentana='Agregar secci&oacute;n';
    var nElementos=1;
    if(idSeccion!=-1)
    {
    	lblVentana='Modificar secci&oacute;n';
        nElementos=nodoSelPreguntas.parentNode.childNodes.length;
    }
    else
    {
    	nElementos=nodoSelPreguntas.childNodes.length+1;
    }
    var arrOrden=new Array();
    var x;
    
    for(x=1;x<=nElementos;x++)
    {
    	arrOrden.push([x,x]);
    }
	var cmbOrden=crearComboExt('cmbOrden',arrOrden,180,155,120);
    var objConf={confVista:'<tpl for="."><div class="search-item"><span class="{nombre}">{nombre}</span></div></tpl>'};
    var cmbClase=crearComboExt('cmbClase',arrEstilos,180,185,250,objConf);
    var cmbPonderacionHijos=crearComboExt('cmbPonderacionHijos',arrPonderacionHijos,180,245,180);
    cmbPonderacionHijos.setValue('0');
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Prefijo secci&oacute;n:'
                                                        },
                                                        {
                                                        	x:110,
                                                            y:5,
                                                            xtype:'textfield',
                                                            width:80,
                                                            id:'txtPrefijo'
                                                        },
                                                        
														{
                                                        	x:10,
                                                            y:40,
                                                            html:'Ingrese el texto de la secci&oacute;n a agregar:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:65,
                                                            width:450,
                                                            height:80,
                                                            xtype:'textfield',
                                                            xtype:'textarea',
                                                            id:'txtTitulo'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:160,
                                                            html:'Orden de presentaci&oacute;n:'
                                                        },
                                                        cmbOrden,
                                                        {
                                                        	x:10,
                                                            y:190,
                                                            html:'Clase a aplicar al p&aacute;rrafo:'
                                                        },
                                                        cmbClase,
                                                        {
                                                        	x:10,
                                                            y:220,
                                                            html:'Valor de la secci&oacute;n (%):'
                                                        },
                                                        {
                                                        	x:180,
                                                            y:215,
                                                            id:'txtValorSeccion',
                                                            xtype:'numberfield',
                                                            width:60,
                                                            allowNegative:false,
                                                            allowDecimals:true
                                                        },
                                                        {
                                                        	x:260,
                                                            y:220,
                                                            id:'lblMaxPorc',
                                                            html:''
                                                        },
                                                        {
                                                        	x:10,
                                                            y:250,
                                                            html:'Ponderaci&oacute;n de elementos hijos:'
                                                        },
                                                        cmbPonderacionHijos

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: lblVentana,
										width: 500,
										height:380,
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
                                                                    	gEx('txtPrefijo').focus(false,500);
                                                                    }
                                                                }
                                                    },
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var txtPrefijo=gEx('txtPrefijo');
                                                                        var txtTitulo=gEx('txtTitulo');
                                                                        
                                                                        if(txtTitulo.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtTitulo.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el t&iacute;tulo de la secci&oacute;n',resp)
                                                                        	return;
                                                                        }
                                                                        if(cmbOrden.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe indicar el orden que ocupar&aacute; la secci&oacute;n');
                                                                        	return;
                                                                        }
                                                                        if(cmbClase.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe indicar la clase a aplicar al texto de la secci&oacute;n');
                                                                        	return;
                                                                        }
                                                                        var txtValorSeccion=gEx('txtValorSeccion');
                                                                        if(txtValorSeccion.getRawValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	txtValorSeccion.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el valor de la secci&oacute;n de la secci&oacute;n',resp2)
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(valProcentajeMax!=-1)
                                                                        {
                                                                        	if(txtValorSeccion.getValue()>valProcentajeMax)
                                                                            {
                                                                            	function resp10()
                                                                                {
                                                                                	txtValorSeccion.focus();
                                                                                }
                                                                                msgBox('No puede exceder el porcentaje m&aacute;ximo permitido para esta pregunta (<b>'+valProcentajeMax+'%</b>)',resp10);
                                                                            	return;
                                                                            }
                                                                        }
                                                                        
                                                                        var cadObj='{"ponderacionElementos":"'+cmbPonderacionHijos.getValue()+'","tipoElemento":"1","idElemento":"'+idSeccion+'","codigoPadre":"'+codigoPadre+'","prefijo":"'+cv(txtPrefijo.getValue())+'","texto":"'+cv(txtTitulo.getValue())+
                                                                        			'","orden":"'+cmbOrden.getValue()+'","clase":"'+cmbClase.getValue()+
                                                                                    '","valorSeccion":"'+txtValorSeccion.getValue()+'"}';
                                                                       
                                                                       function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('arbolPreguntas').getRootNode().reload();
                                                                                gEx('arbolPreguntas').expandAll();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=46&cadObj='+cadObj,true);
                                                                       
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
	if(idSeccion!=-1)
    {
    	gEx('txtPrefijo').setValue(nodoSelPreguntas.attributes.prefijo);
        gEx('txtTitulo').setValue(nodoSelPreguntas.attributes.titulo);
        cmbOrden.setValue(nodoSelPreguntas.attributes.orden);
        cmbClase.setValue(nodoSelPreguntas.attributes.clase);
        gEx('txtValorSeccion').setValue(nodoSelPreguntas.attributes.valorSeccion);
        cmbPonderacionHijos.setValue(nodoSelPreguntas.attributes.ponderacionElementosHijos);
        if(nodoSelPreguntas.parentNode.attributes.ponderacionElementosHijos=='1')
		{
        	gEx('txtValorSeccion').setValue(0);
            gEx('txtValorSeccion').disable();
           
        }
        else
        {
        	var porcentajeTotal=obtenerPorcentajeTotalElemento(nodoSelPreguntas.parentNode);
            porcentajeTotal-=parseFloat(nodoSelPreguntas.attributes.valorSeccion);
            valProcentajeMax=100-porcentajeTotal;
            gEx('lblMaxPorc').setText('<span style="color:#000" >(M&aacute;x. '+valProcentajeMax+'%)</span>',false);
      	}
        if(nodoSelPreguntas.childNodes.length>0)                                
        {
            cmbPonderacionHijos.disable();
        }
    }  
	else
    {
    	cmbOrden.setValue(arrOrden[arrOrden.length-1][0]);
    	if(nodoSelPreguntas.attributes.ponderacionElementosHijos=='1')
		{
        	gEx('txtValorSeccion').setValue(0);
            gEx('txtValorSeccion').disable();
        }
        else
        {
        	var porcentajeTotal=obtenerPorcentajeTotalElemento(nodoSelPreguntas);
            
            valProcentajeMax=100-porcentajeTotal;
            gEx('lblMaxPorc').setText('<span style="color:#000" >(M&aacute;x. '+valProcentajeMax+'%)</span>',false);
        }
    }
	ventanaAM.show();	
}

function mostrarVentanaAgregarCampoTexto(idPregunta,codigoPadre)
{
	var valProcentajeMax=-1;
	var arrSiNo=[['0','No'],['1','Si']];
    var nElementos=1;
	var lblVentana='Agregar pregunta campo de texto';
    if(idPregunta!=-1)
    {
    	lblVentana='Modificar campo de texto';
         nElementos=nodoSelPreguntas.parentNode.childNodes.length;
   	}
    else
    {
        nElementos=nodoSelPreguntas.childNodes.length+1;
    }
    var arrOrden=new Array();
    var x;
    
    for(x=1;x<=nElementos;x++)
    {
    	arrOrden.push([x,x]);
    }
	var cmbOrden=crearComboExt('cmbOrden',arrOrden,180,155,120);
    
    var objConf={confVista:'<tpl for="."><div class="search-item"><span class="{nombre}">{nombre}</span></div></tpl>'};
    
    var cmbClase=crearComboExt('cmbClase',arrEstilos,180,185,250,objConf);
	
    var cmbClasePregunta=crearComboExt('cmbClasePregunta',arrEstilos,180,245,250,objConf);
    
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Prefijo pregunta:'
                                                        },
                                                        {
                                                        	x:110,
                                                            y:5,
                                                            xtype:'textfield',
                                                            width:80,
                                                            id:'txtPrefijo'
                                                        },
                                                        
														{
                                                        	x:10,
                                                            y:40,
                                                            html:'Ingrese el texto de la pregunta a agregar:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:65,
                                                            width:450,
                                                            height:80,
                                                            xtype:'textfield',
                                                            xtype:'textarea',
                                                            id:'txtTitulo'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:160,
                                                            html:'Orden de aparici&oacute;n:'
                                                        },
                                                        cmbOrden,
                                                        {
                                                        	x:10,
                                                            y:190,
                                                            html:'Clase a aplicar a la pregunta:'
                                                        },
                                                        cmbClase,
                                                        {
                                                        	x:10,
                                                            y:220,
                                                            html:'Valor de la pregunta (%):'
                                                        },
                                                        {
                                                        	x:180,
                                                            y:215,
                                                            id:'txtValorSeccion',
                                                            xtype:'numberfield',
                                                            width:60,
                                                            allowNegative:false,
                                                            allowDecimals:true
                                                        },
                                                        {
                                                        	x:260,
                                                            y:220,
                                                            id:'lblMaxPorc',
                                                            html:''
                                                        },
                                                        
                                                        {
                                                        	x:10,
                                                            y:250,
                                                            html:'Clase a aplicar a la respuesta:'
                                                        },
                                                        cmbClasePregunta
                                                        

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: lblVentana,
										width: 500,
										height:400,
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
                                                                    	gEx('txtPrefijo').focus(false,500);
                                                                    }
                                                                }
                                                    },
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var txtPrefijo=gEx('txtPrefijo');
                                                                        var txtTitulo=gEx('txtTitulo');
                                                                        
                                                                        if(txtTitulo.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtTitulo.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el t&iacute;tulo de la secci&oacute;n',resp)
                                                                        	return;
                                                                        }
                                                                        if(cmbOrden.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe indicar el orden que ocupar&aacute; la pregunta');
                                                                        	return;
                                                                        }
                                                                        if(cmbClase.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe indicar la clase a aplicar al texto de la pregunta');
                                                                        	return;
                                                                        }
                                                                        var txtValorSeccion=gEx('txtValorSeccion');
                                                                        if(txtValorSeccion.getRawValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	txtValorSeccion.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el valor de la secci&oacute;n de la secci&oacute;n',resp2)
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(valProcentajeMax!=-1)
                                                                        {
                                                                        	if(txtValorSeccion.getValue()>valProcentajeMax)
                                                                            {
                                                                            	function resp10()
                                                                                {
                                                                                	txtValorSeccion.focus();
                                                                                }
                                                                                msgBox('No puede exceder el porcentaje m&aacute;ximo permitido para esta pregunta (<b>'+valProcentajeMax+'%</b>)',resp10);
                                                                            	return;
                                                                            }
                                                                        }
                                                                       
                                                                        
                                                                        
                                                                        
                                                                        var cadObj='{"campoEtiqueta":"","campoID":"","campoValor":"","tRespuesta":"0","idReferenciaResp":"0","claseRespuesta":"'+cmbClasePregunta.getValue()+
                                                                                	'","presentaRespuesta":"0","valorNoaplica":"0","tipoElemento":"4","idElemento":"'+idPregunta+'","codigoPadre":"'+
                                                                                    codigoPadre+'","prefijo":"'+cv(txtPrefijo.getValue())+'","texto":"'+cv(txtTitulo.getValue())+'","orden":"'+
                                                                                    cmbOrden.getValue()+'","clase":"'+cmbClase.getValue()+'","valorSeccion":"'+txtValorSeccion.getValue()+'"}';
                                                                       
                                                                       function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('arbolPreguntas').getRootNode().reload();
                                                                                gEx('arbolPreguntas').expandAll();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=46&cadObj='+cadObj,true);
                                                                       
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
	if(idPregunta!=-1)
    {
    	gEx('txtPrefijo').setValue(nodoSelPreguntas.attributes.prefijo);
        gEx('txtTitulo').setValue(nodoSelPreguntas.attributes.titulo);
        cmbOrden.setValue(nodoSelPreguntas.attributes.orden);
        cmbClase.setValue(nodoSelPreguntas.attributes.clase);
        gEx('txtValorSeccion').setValue(nodoSelPreguntas.attributes.valorSeccion);
        
        
        
        
        cmbClasePregunta.setValue(nodoSelPreguntas.attributes.claseRespuesta);
        
        if(nodoSelPreguntas.parentNode.attributes.ponderacionElementosHijos=='1')
		{
        	gEx('txtValorSeccion').setValue(0);
            gEx('txtValorSeccion').disable();
        }
        else
        {
        	var porcentajeTotal=obtenerPorcentajeTotalElemento(nodoSelPreguntas.parentNode);
            porcentajeTotal-=parseFloat(nodoSelPreguntas.attributes.valorSeccion);
            valProcentajeMax=100-porcentajeTotal;
            gEx('lblMaxPorc').setText('<span style="color:#000" >(M&aacute;x. '+valProcentajeMax+'%)</span>',false);
      	}
        
    }  
    else
    {
    	cmbOrden.setValue(arrOrden[arrOrden.length-1][0]);
    	if(nodoSelPreguntas.attributes.ponderacionElementosHijos=='1')
		{
        	gEx('txtValorSeccion').setValue(0);
            gEx('txtValorSeccion').disable();
        }
        else
        {
        	var porcentajeTotal=obtenerPorcentajeTotalElemento(nodoSelPreguntas);
            
            valProcentajeMax=100-porcentajeTotal;
            gEx('lblMaxPorc').setText('<span style="color:#000" >(M&aacute;x. '+valProcentajeMax+'%)</span>',false);
        }
    }                              
	ventanaAM.show();	
}

function mostrarVentanaAgregarPregunta(idPregunta,codigoPadre)
{
	
	var valProcentajeMax=-1;
	var arrSiNo=[['0','No'],['1','Si']];
    var nElementos=1;
	var arrOpciones=[['0','Escala de evaluaci\xF3n'],['1','Valores de almac\xE9n de datos'],['2','Valores ingresados manualmente']];
    var arrPresentaOpc=[['0','Un combo'],['1','Un listado de opciones tipo radio'],['2','Un listado de opciones tipo checkbox'],['3','Un listado de opciones ordenables numericamente'],['4','Un listado de opciones ordenables alfab\xE9ticamente']];
	var lblVentana='Agregar pregunta';
    if(idPregunta!=-1)
    {
    	lblVentana='Modificar pregunta';
         nElementos=nodoSelPreguntas.parentNode.childNodes.length;
   	}
    else
    {
        nElementos=nodoSelPreguntas.childNodes.length+1;
    }
    var arrOrden=new Array();
    var x;
    
    for(x=1;x<=nElementos;x++)
    {
    	arrOrden.push([x,x]);
    }
	var cmbOrden=crearComboExt('cmbOrden',arrOrden,180,155,120);
    if(gE('tipoCuestionario').value=='1')
    {
    	//cmbOrden.hide();
    }
    var objConf={confVista:'<tpl for="."><div class="search-item"><span class="{nombre}">{nombre}</span></div></tpl>'};
    var cmbClase=crearComboExt('cmbClase',arrEstilos,180,185,250,objConf);
    
    if(idPregunta==-1)
    {
    	cmbClase.setValue(gE('clasePregunta').value);
    }
    
	var cmbValorRespuesta=crearComboExt('cmbValorRespuesta',arrOpciones,180,245,250);
    cmbValorRespuesta.on('select',function(cmb,registro)
    								{
                                    	gEx('lblEscala').show();
                                        gEx('cmbEscala').show();
                                    	gEx('cmbEscala').setValue('');
                                        switch(registro.get('id'))
                                        {
                                        	case '0':
                                            	gEx('cmbEscala').getStore().loadData(arrEscala);
                                                gEx('lblEscala').setText('Escala de evaluaci&oacute;n:',false);
                                                gEx('lblCampoRespuesta').hide();
                                                gEx('lblCampoID').hide();
                                                gEx('lblCampoValor').hide();
                                                gEx('cmbCampoEtiqueta').reset();
                                                gEx('cmbCampoID').reset();
                                                gEx('cmbCampoValor').reset();
                                                gEx('cmbCampoEtiqueta').hide();
                                                gEx('cmbCampoID').hide();
                                                gEx('cmbCampoValor').hide();
                                                
                                                gEx('btnAgregarOpt').hide();
							                    gEx('btnRemoverOpt').hide();
                                                
                                            break;
                                            case '1':
                                            	gEx('btnAgregarOpt').hide();
							                    gEx('btnRemoverOpt').hide();
                                            	arrAlmacenDatos=obtenerAlmacenesDatosDisponibles(1);
                                                gEx('cmbEscala').getStore().loadData(arrAlmacenDatos);
                                                gEx('lblEscala').setText('Almac&eacute;n de datos',false);
                                                gEx('lblCampoRespuesta').show();
                                                gEx('lblCampoID').show();
                                                gEx('lblCampoValor').show();
                                                gEx('cmbCampoEtiqueta').show();
                                                gEx('cmbCampoID').show();
                                                gEx('cmbCampoValor').show();
                                            break;
                                            case '2':
                                            	gEx('btnAgregarOpt').show();
							                    gEx('btnRemoverOpt').show();
                                            	gEx('cmbEscala').getStore().removeAll();
                                                gEx('lblEscala').hide();
                                                gEx('cmbEscala').hide();
                                                gEx('lblCampoRespuesta').hide();
                                                gEx('lblCampoID').hide();
                                                gEx('lblCampoValor').hide();
                                                gEx('cmbCampoEtiqueta').reset();
                                                gEx('cmbCampoID').reset();
                                                gEx('cmbCampoValor').reset();
                                                gEx('cmbCampoEtiqueta').hide();
                                                gEx('cmbCampoID').hide();
                                                gEx('cmbCampoValor').hide();
                                                obtenerValoresRespuesta('2',registro.data.id,idPregunta);
                                            break;
                                        }
                                    	
                                    }
    					)
    
    
    cmbValorRespuesta.setValue('0');
    var cmbEscala=crearComboExt('cmbEscala',arrEscala,180,275,250);
    cmbEscala.on('select',function(cmb,registro)
    						{
                            	if(cmbValorRespuesta.getValue()!='0')
                                {
                                	var arrCampos=obtenerCamposDisponibles(registro.get('id'),true);
                                    gEx('cmbCampoEtiqueta').getStore().loadData(arrCampos);
									gEx('cmbCampoID').getStore().loadData(arrCampos);
                                   	gEx('cmbCampoValor').getStore().loadData(arrCampos);
                                }
                                
                                
                                switch(gEx('cmbValorRespuesta').getValue())
                                {
                                	case '0':	

                                    	obtenerValoresRespuesta(gEx('cmbValorRespuesta').getValue(),registro.data.id,idPregunta);
                                    break;
                                }
                                
                                
                                
                            }
    			)
    var cmbCampoEtiqueta=crearComboExt('cmbCampoEtiqueta',[],180,305,250);
    cmbCampoEtiqueta.hide();
    
    var cmbCampoID=crearComboExt('cmbCampoID',[],180,335,250);
    cmbCampoID.hide();
    cmbCampoID.on('select',function(cmb,registro)
    						{
                            	if(gEx('cmbCampoValor').getValue()=='')
                                	gEx('cmbCampoValor').setValue(registro.data.id);
                            	obtenerValoresRespuesta(gEx('cmbValorRespuesta').getValue(),gEx('cmbEscala').getValue(),idPregunta);
                            }
    			)
    var cmbCampoValor=crearComboExt('cmbCampoValor',[],180,365,250);
    cmbCampoValor.hide();
    cmbCampoValor.on('select',function(cmb,registro)
    						{
                            	obtenerValoresRespuesta(gEx('cmbValorRespuesta').getValue(),gEx('cmbEscala').getValue(),idPregunta);
                            }
    			)
    
  	var cmbOpciones=crearComboExt('cmbOpciones',arrPresentaOpc,180,395,350);
    cmbOpciones.setValue('0');
    cmbOpciones.on('select',function(cmb,registro)
    						{
                            	gEx('gRespuesta').getView().refresh();

                            }
    				)
    if((idPregunta==-1)&&(gE('tipoRespuesta').value!=''))
    {
    	cmbOpciones.setValue(gE('tipoRespuesta').value);
    }
    
    var cmbClasePregunta=crearComboExt('cmbClasePregunta',arrEstilos,180,425,250,objConf);
    
    if(idPregunta==-1)
    {
    	cmbClasePregunta.setValue(gE('claseRespuesta').value);
    }
    
    var cmbSiNo=crearComboExt('cmbSiNo',arrSiNo,180,455,150);
    cmbSiNo.setValue('0');
    
    
    var cmbCategoriaPregunta=crearComboExt('cmbCategoriaPregunta',eval(bD(gE('arrEscalaPreguntas').value)),160,15,300);
    
    
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
                                            
											items: 	[
                                            			{
                                                        	id:'tPanelPregunta',
                                                        	xtype:'tabpanel',
                                                            baseCls: 'x-plain',
                                                            activeTab:1,
                                                            height:510,
                                                            items:	[
                                                            			{
                                                                            layout:'absolute',
                                                                            baseCls: 'x-plain',
                                                                            defaultType: 'label',
                                                                            title:'Configuraci&oacute;n general',
                                                                            items:	[
                                                                                        {
                                                                                            x:10,
                                                                                            y:10,
                                                                                            //hidden:(gE('tipoCuestionario').value=='1'),
                                                                                            html:'Prefijo pregunta:'
                                                                                        },
                                                                                        {
                                                                                            x:110,
                                                                                            y:5,
                                                                                            xtype:'textfield',
                                                                                            width:80,
                                                                                            //hidden:(gE('tipoCuestionario').value=='1'),
                                                                                            id:'txtPrefijo'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:10,
                                                                                            y:40,
                                                                                            html:'Ingrese el texto de la pregunta a agregar:'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:65,
                                                                                            width:600,
                                                                                            height:80,
                                                                                            xtype:'textfield',
                                                                                            xtype:'textarea',
                                                                                            id:'txtTitulo'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:160,
                                                                                            //hidden:(gE('tipoCuestionario').value=='1'),
                                                                                            html:'Orden de aparici&oacute;n:'
                                                                                        },
                                                                                        cmbOrden,
                                                                                        {
                                                                                            x:10,
                                                                                            y:190,
                                                                                            html:'Clase a aplicar a la pregunta:'
                                                                                        },
                                                                                        cmbClase,
                                                                                        {
                                                                                            x:10,
                                                                                            y:220,
                                                                                            html:'Valor de la pregunta (%):'
                                                                                        },
                                                                                        {
                                                                                            x:180,
                                                                                            y:215,
                                                                                            id:'txtValorSeccion',
                                                                                            xtype:'numberfield',
                                                                                            width:60,
                                                                                            allowNegative:false,
                                                                                            allowDecimals:true
                                                                                        },
                                                                                        {
                                                                                            x:260,
                                                                                            y:220,
                                                                                            id:'lblMaxPorc',
                                                                                            html:''
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:250,
                                                                                            html:'Obtener respuestas de:'
                                                                                        },
                                                                                        cmbValorRespuesta,
                                                                                        {
                                                                                            x:10,
                                                                                            y:280,
                                                                                            id:'lblEscala',
                                                                                            html:'Escala de evaluaci&oacute;n:'
                                                                                        },
                                                                                        cmbEscala,
                                                                                        {
                                                                                            x:10,
                                                                                            y:310,
                                                                                            id:'lblCampoRespuesta',
                                                                                            hidden:true,
                                                                                            html:'Campo texto de respuesta:'
                                                                                        },
                                                                                        cmbCampoEtiqueta,
                                                                                        {
                                                                                            x:10,
                                                                                            y:340,
                                                                                            id:'lblCampoID',
                                                                                            hidden:true,
                                                                                            html:'Campo ID de respuesta:'
                                                                                        },
                                                                                        cmbCampoID,
                                                                                         {
                                                                                            x:10,
                                                                                            y:370,
                                                                                            id:'lblCampoValor',
                                                                                            hidden:true,
                                                                                            html:'Campo valor de respuesta:'
                                                                                        },
                                                                                        cmbCampoValor,
                                                                                         {
                                                                                            x:10,
                                                                                            y:400,
                                                                                            html:'Presentar respuestas en:'
                                                                                        },
                                                                                        cmbOpciones,
                                                                                        {
                                                                                            x:10,
                                                                                            y:430,
                                                                                            html:'Clase a aplicar a la respuesta:'
                                                                                        },
                                                                                        cmbClasePregunta,
                                                                                        {
                                                                                            x:10,
                                                                                            y:460,
                                                                                            hidden:(gE('tipoCuestionario').value=='1'),
                                                                                            html:'Incluir respuesta "No Aplica":'
                                                                                        },
                                                                                        cmbSiNo
                                                                                    ]
                                                                        },
                                                                        {
                                                                            layout:'absolute',
                                                                            baseCls: 'x-plain',
                                                                            defaultType: 'label',
                                                                            title:'Configuraci&oacute;n de respuestas',
                                                                            items:	[
                                                                            			{
                                                                                        	x:10,
                                                                                            y:20,
                                                                                            html:'Categoría de la pregunta:'
                                                                                        },
                                                                                        cmbCategoriaPregunta,
                                                                                        
                                                                                     	crearGridRespuestasPregunta()   
                                                                                    ]
                                                                        }
                                                            		]
                                                        }
                                            			

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: lblVentana,
										width: 650,
										height:590,
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
                                                                    	gEx('tPanelPregunta').setActiveTab(0);
                                                                        gEx('txtPrefijo').focus(false,500);
                                                                        
                                                                    }
                                                                }
                                                    },
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var txtPrefijo=gEx('txtPrefijo');
                                                                        var txtTitulo=gEx('txtTitulo');
                                                                        
                                                                        if(txtTitulo.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtTitulo.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el t&iacute;tulo de la secci&oacute;n',resp)
                                                                        	return;
                                                                        }
                                                                        if(cmbOrden.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe indicar el orden que ocupar&aacute; la pregunta');
                                                                        	return;
                                                                        }
                                                                        if(cmbClase.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe indicar la clase a aplicar al texto de la pregunta');
                                                                        	return;
                                                                        }
                                                                        var txtValorSeccion=gEx('txtValorSeccion');
                                                                        if(txtValorSeccion.getRawValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	txtValorSeccion.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el valor de la secci&oacute;n de la secci&oacute;n',resp2)
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(valProcentajeMax!=-1)
                                                                        {
                                                                        	if(txtValorSeccion.getValue()>valProcentajeMax)
                                                                            {
                                                                            	function resp10()
                                                                                {
                                                                                	txtValorSeccion.focus();
                                                                                }
                                                                                msgBox('No puede exceder el porcentaje m&aacute;ximo permitido para esta pregunta (<b>'+valProcentajeMax+'%</b>)',resp10);
                                                                            	return;
                                                                            }
                                                                        }
                                                                        var lblEscala='';
                                                                        if(cmbEscala.getValue()=='')
                                                                        {
                                                                        	var mostrarError=false;
                                                                        	switch(cmbValorRespuesta.getValue())
                                                                            {
                                                                            	case '0':
                                                                                	lblEscala='Debe indicar la escala de evaluci&oacute;n a utilizar en esta pregunta';
                                                                                    mostrarError=true;
                                                                                break;
                                                                                case '1':
                                                                                	lblEscala='Debe indicar el almac&eacute;n de datos a utilizar en esta pregunta';
                                                                                    mostrarError=true;
                                                                                break;
                                                                               
                                                                                
                                                                            }
                                                                        
                                                                        	if(mostrarError)
                                                                            {
                                                                                msgBox(lblEscala)
                                                                                return;
                                                                            }
                                                                        }
                                                                        
                                                                        if(cmbValorRespuesta.getValue()=='1')
                                                                        {
                                                                        	if(cmbCampoEtiqueta.getValue()=='')
                                                                            {
                                                                                msgBox('Debe indicar el campo que ser&aacute; utilizado como etiqueta de la respuesta');
                                                                                return;
                                                                            }
                                                                            if(cmbCampoID.getValue()=='')
                                                                            {
                                                                                msgBox('Debe indicar el campo que ser&aacute; utilizado como identificador &uacute;nico de la respuesta');
                                                                                return;
                                                                            }
                                                                            if(cmbCampoValor.getValue()=='')
                                                                            {
                                                                                msgBox('Debe indicar el campo que ser&aacute; utilizado como valor de la respuesta');
                                                                                return;
                                                                            }
                                                                        }
                                                                        
                                                                        if(cmbClasePregunta.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe indicar la clase a aplicar al texto de las repuestas de la pregunta');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var datosComp='';
                                                                        if(gE('tipoCuestionario').value=='1')
                                                                        {
                                                                        	if(cmbCategoriaPregunta.getValue()=='')
                                                                            {
                                                                            	function resp200()
                                                                                {
                                                                                	cmbCategoriaPregunta.focus();
                                                                                }
                                                                                msgBox('Debe ingresar la categor&iacute;a de la pregunta',resp200)
                                                                                return;
                                                                            }
                                                                        
                                                                        	/*var arrResp='';
                                                                            var x;
                                                                            var gRespuesta=gEx('gRespuesta');
                                                                            var fila;
                                                                            for(x=0;x<gRespuesta.getStore().getCount();x++)
                                                                            {
                                                                            	fila=gRespuesta.getStore().getAt(x);
                                                                                
                                                                                
                                                                                
                                                                                
                                                                            }*/
                                                                            
                                                                        
                                                                        	datosComp='"categoriaPregunta":"'+cmbCategoriaPregunta.getValue()+'","arrRespuestas":['+arrResp+']';
                                                                        }
                                                                        
                                                                        var cadObj='{'+datosComp+'"campoEtiqueta":"'+cmbCampoEtiqueta.getValue()+'","campoID":"'+cmbCampoID.getValue()+'","campoValor":"'+cmbCampoValor.getValue()+
                                                                        		'","tRespuesta":"'+cmbValorRespuesta.getValue()+'","idReferenciaResp":"'+cmbEscala.getValue()+
                                                                        			'","claseRespuesta":"'+cmbClasePregunta.getValue()+'","presentaRespuesta":"'+cmbOpciones.getValue()+
                                                                                    '","valorNoaplica":"'+cmbSiNo.getValue()+'","tipoElemento":"3","idElemento":"'+idPregunta+'","codigoPadre":"'+
                                                                                    codigoPadre+'","prefijo":"'+cv(txtPrefijo.getValue())+'","texto":"'+cv(txtTitulo.getValue())+'","orden":"'+
                                                                                    cmbOrden.getValue()+'","clase":"'+cmbClase.getValue()+'","valorSeccion":"'+txtValorSeccion.getValue()+'"}';
                                                                       
                                                                       
                                                                       
                                                                       
                                                                       function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('arbolPreguntas').getRootNode().reload();
                                                                                gEx('arbolPreguntas').expandAll();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=46&cadObj='+cadObj,true);
                                                                       
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
                                
                                
	                           ;
	if(idPregunta!=-1)
    {
    	
    	gEx('txtPrefijo').setValue(nodoSelPreguntas.attributes.prefijo);
        gEx('txtTitulo').setValue(nodoSelPreguntas.attributes.titulo);
        cmbOrden.setValue(nodoSelPreguntas.attributes.orden);
        cmbClase.setValue(nodoSelPreguntas.attributes.clase);
        gEx('txtValorSeccion').setValue(nodoSelPreguntas.attributes.valorSeccion);
        cmbValorRespuesta.setValue(nodoSelPreguntas.attributes.tipoRespuesta);
        if(nodoSelPreguntas.attributes.tipoRespuesta=='0')
        {
        	gEx('cmbEscala').getStore().loadData(arrEscala);
            gEx('lblEscala').setText('Escala de evaluaci&oacute;n:',false);
        }
        else
        {
        	gEx('cmbEscala').getStore().loadData(arrAlmacenDatos);
			gEx('lblEscala').setText('Almac&eacute;n de datos',false);
        }
        
        
        if(cmbValorRespuesta.getValue()=='1')
        {
        	
            var almacenesD=obtenerAlmacenesDatosDS();
            
            gEx('cmbEscala').getStore().loadData(almacenesD);
            gEx('lblEscala').setText('Almac&eacute;n de datos',false);
            gEx('lblCampoRespuesta').show();
            gEx('lblCampoID').show();
            gEx('lblCampoValor').show();
            gEx('cmbCampoEtiqueta').show();
            gEx('cmbCampoID').show();
            gEx('cmbCampoValor').show();
            var arrCampos=obtenerCamposAlmacenDatos(nodoSelPreguntas.attributes.idReferenciaRespuesta);
            gEx('cmbCampoEtiqueta').getStore().loadData(arrCampos);
            gEx('cmbCampoID').getStore().loadData(arrCampos);
            gEx('cmbCampoValor').getStore().loadData(arrCampos);
        	cmbCampoEtiqueta.setValue(nodoSelPreguntas.attributes.campoTextoRespuesta);
            cmbCampoID.setValue(nodoSelPreguntas.attributes.campoIdRespuesta);
            cmbCampoValor.setValue(nodoSelPreguntas.attributes.campoValorRespuesta);
        }
        cmbEscala.setValue(nodoSelPreguntas.attributes.idReferenciaRespuesta);
        
        cmbOpciones.setValue(nodoSelPreguntas.attributes.presentarRespuesta);
        cmbClasePregunta.setValue(nodoSelPreguntas.attributes.claseRespuesta);
        cmbSiNo.setValue(nodoSelPreguntas.attributes.incluirValorNoAplica);
        if(nodoSelPreguntas.parentNode.attributes.ponderacionElementosHijos=='1')
		{
        	gEx('txtValorSeccion').setValue(0);
            gEx('txtValorSeccion').disable();
        }
        else
        {
        	var porcentajeTotal=obtenerPorcentajeTotalElemento(nodoSelPreguntas.parentNode);
            porcentajeTotal-=parseFloat(nodoSelPreguntas.attributes.valorSeccion);
            valProcentajeMax=100-porcentajeTotal;
            gEx('lblMaxPorc').setText('<span style="color:#000" >(M&aacute;x. '+valProcentajeMax+'%)</span>',false);
      	}
        
    }  
    else
    {
    	cmbOrden.setValue(arrOrden[arrOrden.length-1][0]);
    	if(nodoSelPreguntas.attributes.ponderacionElementosHijos=='1')
		{
        	gEx('txtValorSeccion').setValue(0);
            gEx('txtValorSeccion').disable();
        }
        else
        {
        	var porcentajeTotal=obtenerPorcentajeTotalElemento(nodoSelPreguntas);
            
            valProcentajeMax=100-porcentajeTotal;
            gEx('lblMaxPorc').setText('<span style="color:#000" >(M&aacute;x. '+valProcentajeMax+'%)</span>',false);
        }
    }                              
	ventanaAM.show();	
    
    if(gE('tipoCuestionario').value=='1')
    {
    	cmbSiNo.hide();

    }
    else
    {
    	gEx('tPanelPregunta').hideTabStripItem(1);
    }
    
    dispararEventoSelectCombo('cmbValorRespuesta');
}

function mostrarVentanaAgregarParrafo(idSeccion,codigoPadre)
{
	var valProcentajeMax=-1;
	var lblVentana='Agregar p&aacute;rrafo';
    var nElementos=1;
    if(idSeccion!=-1)
    {
    	lblVentana='Modificar p&aacute;rrafo';
        nElementos=nodoSelPreguntas.parentNode.childNodes.length;
    }
    else
    {
    	nElementos=nodoSelPreguntas.childNodes.length+1;
    }
    var arrOrden=new Array();
    var x;
    
    for(x=1;x<=nElementos;x++)
    {
    	arrOrden.push([x,x]);
    }
	var cmbOrden=crearComboExt('cmbOrden',arrOrden,180,130,120);
    var objConf={confVista:'<tpl for="."><div class="search-item"><span class="{nombre}">{nombre}</span></div></tpl>'};
    var cmbClase=crearComboExt('cmbClase',arrEstilos,180,160,250,objConf);
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Ingrese el texto del p&aacute;rrafo a agregar:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            width:450,
                                                            height:80,
                                                            xtype:'textfield',
                                                            xtype:'textarea',
                                                            id:'txtTitulo'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:135,
                                                            html:'Orden de presentaci&oacute;n:'
                                                        },
                                                        cmbOrden,
                                                        {
                                                        	x:10,
                                                            y:165,
                                                            html:'Clase a aplicar al p&aacute;rrafo:'
                                                        },
                                                        cmbClase

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: lblVentana,
										width: 500,
										height:310,
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
                                                                    	gEx('txtTitulo').focus(false,500);
                                                                    }
                                                                }
                                                    },
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		
                                                                        var txtTitulo=gEx('txtTitulo');
                                                                        
                                                                        if(txtTitulo.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtTitulo.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el t&iacute;tulo de la secci&oacute;n',resp)
                                                                        	return;
                                                                        }
                                                                        if(cmbOrden.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe indicar el orden que ocupar&aacute; la secci&oacute;n');
                                                                        	return;
                                                                        }
                                                                        if(cmbClase.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe indicar la clase a aplicar al texto de la secci&oacute;n');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var cadObj='{"valorSeccion":"0","tipoElemento":"2","idElemento":"'+idSeccion+'","codigoPadre":"'+codigoPadre+'","prefijo":"","texto":"'+cv(txtTitulo.getValue())+
                                                                        			'","orden":"'+cmbOrden.getValue()+'","clase":"'+cmbClase.getValue()+
                                                                                    '"}';
                                                                       
                                                                       function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('arbolPreguntas').getRootNode().reload();
                                                                                gEx('arbolPreguntas').expandAll();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=46&cadObj='+cadObj,true);
                                                                       
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
	if(idSeccion!=-1)
    {
    	
        gEx('txtTitulo').setValue(nodoSelPreguntas.attributes.titulo);
        cmbOrden.setValue(nodoSelPreguntas.attributes.orden);
        cmbClase.setValue(nodoSelPreguntas.attributes.clase);
        
    }  
	else
    {
    	cmbOrden.setValue(arrOrden[arrOrden.length-1][0]);
    	
    }
	ventanaAM.show();	
}

function modificarCuestionario()
{
	var arrSiNo=[['0','No'],['1','Si']];
	var cmbPonderacionElementos=crearComboExt('cmbPonderacionElementos',arrPonderacionHijos,190,160,210);
    cmbPonderacionElementos.setValue(nodoSelPreguntas.attributes.ponderacionElementosHijos);
    var cmbEscala=crearComboExt('cmbEscala',arrEscala,190,190,210);
    cmbEscala.setValue(nodoSelPreguntas.attributes.escalaEval);
    var cmbSiNo=crearComboExt('cmbSiNo',arrSiNo,190,220,150);
    cmbSiNo.setValue(nodoSelPreguntas.attributes.comentariosFinales);
	var cmbSiNoPuntaje=crearComboExt('cmbSiNoPuntaje',arrSiNo,190,250,150);
    cmbSiNoPuntaje.setValue(nodoSelPreguntas.attributes.mostrarPuntajeObtenido);
    
    var cmbTipoCuestionario=crearComboExt('cmbTipoCuestionario',arrTipoCuestionario,190,280,210);
    cmbTipoCuestionario.setValue(nodoSelPreguntas.attributes.tipoCuestionario);
    
    var cmbCategoriaRespuestas=crearComboExt('cmbCategoriaRespuestas',arrEscala,230,310,210);
    
    
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Nombre del cuestionario:'
                                                        },
                                                        {
                                                        	id:'txtNombre',
                                                        	xtype:'textfield',
                                                            x:165,
                                                            y:5,
                                                            value:nodoSelPreguntas.attributes.nombreCuestionario,
                                                            width:350
                                                        },
                                            			{
                                                        	x:10,
                                                            y:40,
                                                            html:'T&iacute;tulo del cuestionario:'
                                                        },
                                                        {
                                                        	id:'txtTitulo',
                                                        	xtype:'textfield',
                                                            x:165,
                                                            y:35,
                                                            value:nodoSelPreguntas.attributes.titulo,
                                                            width:350
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'Descripci&oacute;n:'
                                                        },
                                                        {
                                                        	x:165,
                                                            y:65,
                                                            xtype:'textarea',
                                                            width:550,
                                                            height:80,
                                                            value:nodoSelPreguntas.attributes.descripcion,
                                                            id:'txtDescripcion'
                                                        },
                                                         {
                                                        	x:10,
                                                            y:165,
                                                            html:'Ponderaci&oacute;n de elementos hijos:'
                                                        },
                                                        cmbPonderacionElementos,
                                                        {
                                                        	x:10,
                                                            y:195,
                                                            html:'Escala de evaluaci&oacute;n final:'
                                                        },
                                                        cmbEscala,
                                                        {
                                                        	x:10,
                                                            y:225,
                                                            html:'Solicitar comentarios finales:'
                                                        },
                                                        cmbSiNo,
                                                        {
                                                        	x:10,
                                                            y:255,
                                                            html:'¿Mostrar puntaje obtenido?:'
                                                        },
                                                        cmbSiNoPuntaje,
                                                        {
                                                        	x:10,
                                                            y:285,
                                                            html:'Tipo de cuestionario:'
                                                        },
                                                        cmbTipoCuestionario,
                                                        {
                                                        	x:10,
                                                            y:315,
                                                            id:'lblNivelDificultad',
                                                            hidden:true,
                                                            html:'Escala de categorizaci&oacute;n de respuestas:'
                                                        },
                                                        cmbCategoriaRespuestas
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Modificar datos de cuestionario',
										width: 780,
										height:430,
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
                                                                	gEx('txtNombre').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var txtNombre=gEx('txtNombre');
                                                                        if(txtNombre.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtNombre.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el nombre del reporte',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        var titulo=gEx('txtTitulo');
                                                                        if(titulo.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	titulo.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el t&iacute;tulo del reporte',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                       if(cmbPonderacionElementos.getValue()=='')
                                                                       {
                                                                       		function resp3()
                                                                            {
                                                                            	cmbPonderacionElementos.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el tipo de ponderaci&oacute;n que tendr&aacute;n los elementos hijos de este cuestionario',resp3);
                                                                            return;
                                                                       }
                                                                       
                                                                       if(cmbEscala.getValue()=='')
                                                                       {
                                                                       		function resp4()
                                                                            {
                                                                            	cmbEscala.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la escala de evaluaci&oacute;n que definir&aacute; el resultado final de este cuestionario',resp4);
                                                                            return;
                                                                       }
                                                                       
                                                                       if(cmbTipoCuestionario.getValue()=='')
                                                                       {
                                                                       		function resp5()
                                                                            {
                                                                            	cmbTipoCuestionario.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el tipo de cuestionario a crear',resp5);
                                                                            return;
                                                                       }
                                                                       
                                                                       var idEscalaCategoriaPreguntas=0;
                                                                       
                                                                       if(cmbTipoCuestionario.getValue()=='1')
                                                                       {
                                                                       		if(gEx('cmbCategoriaRespuestas').getValue()=='')
                                                                            {
                                                                            	function resp6()
                                                                                {
                                                                                    cmbCategoriaRespuestas.focus();
                                                                                }
                                                                                msgBox('Debe indicar la escala de ctegorizaci&oacute;n de respuestas',resp6);
                                                                                return;
                                                                            }
                                                                            else
                                                                            	idEscalaCategoriaPreguntas=gEx('cmbCategoriaRespuestas').getValue();
                                                                       }
                                                                       
                                                                       
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gEx('arbolPreguntas').getRootNode().reload();
                                                                                gEx('arbolPreguntas').expandAll();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=45&idEscalaCategoriaPreguntas='+idEscalaCategoriaPreguntas+'&tipoCuestionario='+cmbTipoCuestionario.getValue()+
                                                                        				'&ponderacionHijos='+cmbPonderacionElementos.getValue()+'&escala='+cmbEscala.getValue()+'&solicitaComentarios='+cmbSiNo.getValue()+
                                                                                        '&nombre='+cv(txtNombre.getValue())+'&idCuestionario='+gE('idReporte').value+'&titulo='+cv(titulo.getValue())+
                                                                        				'&descripcion='+cv(gEx('txtDescripcion').getValue())+'&mostrarPuntaje='+cmbSiNoPuntaje.getValue(),true);
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
	if(nodoSelPreguntas.childNodes.length>0)                                
    {
    	cmbPonderacionElementos.disable();
    }
	ventanaAM.show();	
    
    if(nodoSelPreguntas.attributes.tipoCuestionario!='1')
	    cmbCategoriaRespuestas.hide();
    else
    {
    	gEx('lblNivelDificultad').show();
    	cmbCategoriaRespuestas.setValue(nodoSelPreguntas.attributes.categoriaRespuestas);
    }
}

function obtenerPorcentajeTotalElemento(nodo)
{
	var x;
    var total=0;
    for(x=0;x<nodo.childNodes.length;x++)
    {
    	
    	total+=parseFloat(nodo.childNodes[x].attributes.valorSeccion);
    }
    return total;
}

function crearGridRespuestasPregunta()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idRespuesta'},
                                                                    {name: 'etiqueta'},
                                                                    {name: 'respuestaCorrecta'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({checkOnly:true,singleSelect:true });
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	chkRow,
														{
															header:'Respuesta',
															width:450,
															sortable:false,
                                                            menuDisabled :true,
                                                            editor:	{xtype:'textfield'},
															dataIndex:'etiqueta'
														},
														{
															header:'Respuesta<br>correcta',
                                                            align:'center',
															width:80,
															sortable:false,
                                                            menuDisabled :true,
															dataIndex:'respuestaCorrecta',
                                                            renderer:function(val,meta,registro,nFila)
                                                            		{
                                                                    	switch(gEx('cmbOpciones').getValue())
                                                                        {
                                                                        	case '0':
                                                                            case '1':
                                                                            	return '<input onclick="radioRespCheck(this)" type="radio" name="rRespuesta" id="r_'+registro.data.idRespuesta+'_'+nFila+'" '+((val=='1')?'checked="checked"':'')+'>';
                                                                            break;
                                                                            case '2':
                                                                            	return '<input onclick="checkBoxRespCheck(this)" type="checkbox" name="rRespuesta" id="r_'+registro.data.idRespuesta+'_'+nFila+'" '+((val=='1')?'checked="checked"':'')+'>';
                                                                            break;
                                                                            case '3':
                                                                            	return '<input  onclick="txtBoxClick(this)"   type="text" name="rRespuesta" id="r_'+registro.data.idRespuesta+'_'+nFila+'" value="'+val+
                                                                                		'" size="4" onkeydown="textBoxKeyDownNumerico(this,event)" onkeypress="return soloNumero(event,false,false,this)" onkeyup="textBoxKeyUpNumerico(this,event)">';
                                                                            break;
                                                                            case '4':
                                                                            	return '<input onclick="txtBoxClick(this)"  type="text" name="rRespuesta" id="r_'+registro.data.idRespuesta+'_'+nFila+
                                                                                		'" onkeydown="textBoxKeyDownCaracter(this,event)" maxlength="1" size="2" value="'+val+
                                                                                        '" onkeypress="return soloLetrasOrden(event)" onkeyup="textBoxKeyUpCaracter(this,event)">';
                                                                            break;
                                                                        }
                                                                    }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gRespuesta',
                                                            store:alDatos,
                                                            frame:false,
                                                            x:10,
                                                            y:50,
                                                            clicksToEdit:1,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            height:260,
                                                            width:600,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	id:'btnAgregarOpt',
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar respuesta',
                                                                            handler:function()
                                                                            		{
														                                var r=  new regRespuesta	(
                                                                                        								{
                                                                                                                        	idRespuesta:-1,
                                                                                                                            etiqueta:'',
                                                                                                                            respuestaCorrecta:''
                                                                                                                        }
                                                                                        							)                                                  		
                                                                                                                    
                                                                                                                    
                                                                                                                    
                                                                                     	gEx('gRespuesta').getStore().add(r);  
                                                                                        gEx('gRespuesta').startEditing(0,gEx('gRespuesta').getStore().getCount()-1);
                                                                                                                     
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	id:'btnRemoverOpt',
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover respuesta',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gRespuesta').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar la respuesta que desee remover');
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	gEx('gRespuesta').getStore().remove(fila);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover la pregunta seleccionada?',resp);
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
                                                    
	tblGrid.on('beforeedit',function(e)
    						{
                            	if(gEx('cmbValorRespuesta').getValue()!='2')
                                {
                                	e.cancel=true;
                                }
                            }
    			)                                                    
                                                    
	return 	tblGrid;	
}

function obtenerValoresRespuesta(tipo,id,iP)
{

	if(gE('tipoCuestionario').value=='0')
    {
    	return;
    }

    var cadObj='{"idCuestionario":"'+gE('idReporte').value+'","idPregunta":"'+iP+'","tipo":"'+tipo+'","idValor":"'+id+'"';
    if(tipo=='1')
    {
    	cadObj+=',"idAlmacen":"'+gEx('cmbEscala').getValue()+'","campoEtiqueta":"'+gEx('cmbCampoEtiqueta').getValue()+'","idRespuesta":"'+gEx('cmbCampoID').getValue()+'"';
    }
    cadObj+='}';
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
         	var arrValores=eval(arrResp[1]);   
            gEx('gRespuesta').getStore().loadData(arrValores);
            
            
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=57&cadObj='+cadObj,true);
    
    
}

function radioRespCheck(ctrl)
{
	var arrDatos=ctrl.id.split('_');
    var iRespuesta=arrDatos[1];
    var gRespuesta=gEx('gRespuesta');
    var pos=obtenerPosFila(gRespuesta.getStore(),'idRespuesta',iRespuesta);
    
    var fila=gRespuesta.getStore().getAt(pos);
    var f;
    var x;
    for(x=0;x<gRespuesta.getStore().getCount();x++)
    {
    	f=gRespuesta.getStore().getAt(x);
        f.data.respuestaCorrecta='';
    }
    console.log(fila);
    fila.data.respuestaCorrecta='1';
        console.log(fila);
    
}

function checkBoxRespCheck(ctrl)
{
	var arrDatos=ctrl.id.split('_');
    var iRespuesta=arrDatos[1];
    var gRespuesta=gEx('gRespuesta');
    var pos=obtenerPosFila(gRespuesta.getStore(),'idRespuesta',iRespuesta);
    
    var fila=gRespuesta.getStore().getAt(pos);
    if(ctrl.checked)
	    fila.data.respuestaCorrecta='1';
    else
    	fila.data.respuestaCorrecta='';
}

function txtBoxClick(ctrl)
{
	ctrl.focus();
}

function soloLetrasOrden(evt)
{
	var key = nav4 ? evt.which : evt.keyCode;
	var res;

	res= ((key <= 13)||((key>=65) &&(key<=90))||((key>=97) &&(key<=122)));
	return res;	
}

function textBoxKeyUpNumerico(ctrl,evt)
{
	var key = nav4 ? evt.which : evt.keyCode;
}

function textBoxKeyUpCaracter(ctrl,evt)
{
	var key = nav4 ? evt.which : evt.keyCode;

   	ctrl.value=ctrl.value.toUpperCase();
}

function textBoxKeyDownNumerico(ctrl,evt)
{
	var key = nav4 ? evt.which : evt.keyCode;
	if(key==9)
    	enfocarSiguienteCtrl(ctrl);
}

function textBoxKeyDownCaracter(ctrl,evt)
{
	var key = nav4 ? evt.which : evt.keyCode;
    if(key==9)
    	enfocarSiguienteCtrl(ctrl);
}

function enfocarSiguienteCtrl(ctrl)
{
	var arrDatos=ctrl.id.split('_');
    var fila=gEx('gRespuesta').getStore().getAt(arrDatos[2]);
    
    if((parseInt(arrDatos[2])+1)<gEx('gRespuesta').getStore().getCount())
    {
    
    	fila=gEx('gRespuesta').getStore().getAt(parseInt(arrDatos[2])+1);
        setTimeout(
        				function()
                        {
                        	gE('r_'+fila.data.idRespuesta+'_'+(parseInt(arrDatos[2])+1)).focus();
                        },300
        		)	
       	
    }
    
    
    
}
