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


var ctrlDestino=null;

function inicializar()
{
	var idRep=gE('idReporte').value;
	Ext.QuickTips.init();
    var arbolAlmacen=crearArbolAlmacen();
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
                                                                         {
                                                                              id: 'menuDatSet', 
                                                                              layout: 'border',
                                                                              title: '<b>Almacenes de datos</b>',
                                                                              border: false,
                                                                              tbar:	[
                                                                                          {
                                                                                              id:'addDataSet',
                                                                                              icon:'../images/database_add.png',
                                                                                              cls:'x-btn-text-icon',
                                                                                              tooltip:'Crear almac&eacute;n de datos',
                                                                                              disabled:true,
                                                                                              handler:function()
                                                                                                      {
                                                                                                          switch(nodoSel.attributes.tipo)
                                                                                                          {
                                                                                                              case 'ad':
                                                                                                                  mostrarVentanaTablasInvolucradas(true);
                                                                                                              break;
                                                                                                              case 'ca':
                                                                                                                  mostrarVentanaTablasInvolucradas(false);
                                                                                                              break;
                                                                                                              case 'ag':
                                                                                                                  g.mostrarVentanaNuevoAlmacenGrafico();
                                                                                                              break;
                                                                                                          }
                                                                                                          
                                                                                                          
                                                                                                              
                                                                                                      }
                                                                                          },
                                                                                          {
                                                                                              id:'delDataSet',
                                                                                              icon:'../images/database_delete.png',
                                                                                              cls:'x-btn-text-icon',
                                                                                              disabled:true,
                                                                                              tooltip:'Eliminar almac&eacute;n de datos',
                                                                                              handler:function()
                                                                                                      {
                                                                                                          if(nodoSel==null)
                                                                                                          {
                                                                                                              msgBox('Debe seleccionar el almac&eacute;n de datos a eliminar');
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
                                                                                                                          nodoSel.remove();
                                                                                                                          nodoSel=null;
                                                                                                                      }
                                                                                                                      else
                                                                                                                      {
                                                                                                                          msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                                      }
                                                                                                                  }
                                                                                                                  obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=12&idAlmacen='+nodoSel.id,true);
                                          
                                                                                                              }
                                                                                                          }
                                                                                                          msgConfirm('Est&aacute; seguro de querer eliminar el almac&eacute;n de datos seleccionado?',resp)
                                                                                                      }
                                                                                          },
                                                                                          {
                                                                                              id:'linkDataSet',
                                                                                              icon:'../images/database_edit.png',
                                                                                              cls:'x-btn-text-icon',
                                                                                              tooltip:'Modificar origen de datos',
                                                                                              disabled:true,
                                                                                              handler:function()
                                                                                                      {
                                                                                                          switch(nodoSel.attributes.categoria)
                                                                                                          {
                                                                                                              case '2':
                                                                                                                  g.mostrarVentanaDatos(nodoSel.id);
                                                                                                              break;
                                                                                                              default:
                                                                                                                  mostrarVentanaTablasInvolucradasModif(false);
                                                                                                              break;
                                                                                                          }
                                                                                                      }
                                                                                          },'-',
                                                                                          {
                                                                                              id:'modificarNombreAlmacen',
                                                                                              icon:'../images/tag_blue_edit.png',
                                                                                              cls:'x-btn-text-icon',
                                                                                              tooltip:'Modificar nombre del almac&eacute;n',
                                                                                              hidden:true,
                                                                                              handler:function()
                                                                                                      {
                                                                                                          mostrarVentanaModificarNombre();
                                                                                                      }
                                                                                          },   
                                                                                          {
                                                                                              id:'modificarFiltroAlmacen',
                                                                                              icon:'../images/pencil.png',
                                                                                              cls:'x-btn-text-icon',
                                                                                              tooltip:'Modificar filtro de almac&eacute;n',
                                                                                              hidden:true,
                                                                                              handler:function()
                                                                                                      {
                                                                                                          mostrarVentanaModifFiltro();
                                                                                                      }
                                                                                          },                                                            
                                                                                          {
                                                                                              id:'modficarValorParametro',
                                                                                              icon:'../images/building_edit.png',
                                                                                              cls:'x-btn-text-icon',
                                                                                              tooltip:'Modificar valor de par&aacute;metro',
                                                                                              hidden:true,
                                                                                              handler:function()
                                                                                                      {
                                                                                                          mostrarVentanaAsignarParam();
                                                                                                      }
                                                                                          },
                                                                                          {
                                                                                              id:'addCamposProy',
                                                                                              icon:'../images/add.png',
                                                                                              cls:'x-btn-text-icon',
                                                                                              tooltip:'Agregar campos a proyectar',
                                                                                              hidden:true,
                                                                                              handler:function()
                                                                                                      {
                                                                                                          agregarCampoProy();
                                                                                                      }
                                                                                          },
                                                                                          {
                                                                                              id:'delCamposProy',
                                                                                              icon:'../images/delete.png',
                                                                                              cls:'x-btn-text-icon',
                                                                                              tooltip:'Remover campo a proyectar',
                                                                                              hidden:true,
                                                                                              handler:function()
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
                                                                                                                          nodoSel.remove();
                                                                                                                          nodoSel=null;
                                                                                                                      }
                                                                                                                      else
                                                                                                                      {
                                                                                                                          msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                                      }
                                                                                                                  }
                                                                                                                  obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=19&nCampo='+nodoSel.text+'&idDataSet='+nodoSel.attributes.dSetPadre,true);
                                          
                                                                                                              }
                                                                                                          }
                                                                                                          msgConfirm('Est&aacute; seguro de querer remover el campo seleccionado?',resp)
                                                                                                      }
                                                                                          }
                                                                                      ],
                                          
                                                                              items:	[
                                                                                            arbolAlmacen  
                                                                                        ]
                                                                          }
                                                                         
                                                                         
                                                                        
                                                                        
                                                                    ]
                                                        }
                                                    
                                                    
                                                    ]
               							}
                                    );
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

/*
function crearArbolAlmacen()
{
	var iR=gE('idReporte').value;
	var cargadorArbol=new Ext.tree.TreeLoader(
												{
													baseParams:{
																	funcion:'7',
                                                                    idReporte:iR,
                                                                    tipoDataSet:6
																},
													dataUrl:'../paginasFunciones/funcionesThot.php'
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
                                              	  id:'arbolDataSet',
                                                  useArrows:true,
                                                  autoScroll:true,
                                                  animate:false,
                                                  enableDD:true,
                                                  height:570,
                                                  region:'center',
                                                  containerScroll:true,
                                                  root:raiz,
                                                  border:false,
                                                  rootVisible:false,
												  loader: cargadorArbol
                                                                                                
                                               }
                                          );      
    panelArbol.on('click',funcClickArbol);
    return panelArbol;
}

function funcClickArbol(nodo)
{
	nodoSel=nodo;
    gEx('addDataSet').disable();
    gEx('delDataSet').disable();
    gEx('linkDataSet').disable();
    gEx('modficarValorParametro').hide();
    gEx('addCamposProy').hide();
    gEx('delCamposProy').hide();
    gEx('modificarFiltroAlmacen').hide();
    gEx('modificarNombreAlmacen').hide();
    switch(nodoSel.attributes.tipo)
    {
    	case 'p':
        	gEx('modficarValorParametro').show();
        break;
        case 'cc':
        	gEx('addCamposProy').show();
        break;
        case 'c':
            gEx('delCamposProy').show();
        break;
        case 't':
        	if(nodoSel.attributes.categoria!='2')
	        	gEx('modificarFiltroAlmacen').show();
            gEx('delDataSet').enable();
            gEx('linkDataSet').enable();
            gEx('modificarNombreAlmacen').show();
        break;
        case 'ad':
        	gEx('addDataSet').enable();
        break;
        case 'ca':
        	gEx('addDataSet').enable();
        break;
        case 'ct':
        	
        break;
        case 'ag':
        	gEx('addDataSet').enable();
        break;
    }
}*/

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

function mostrarVentanaVinculacionCampoEspecial()
{
	var cmbOrigenDatosCampo=crearComboExt('cmbOrigenDatosCampo',arrOrigenesDatos,340,5);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Ingrese el origen del cual obtendr&aacute; el valor el campo especial:'
                                                        },
                                                        cmbOrigenDatosCampo
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Vincular campo especial',
										width: 600,
										height:125,
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
																		if(cmbOrigenDatosCampo.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar el origen de datos del cual el campo especial obtendr&aacute; su valor');
                                                                        	return;
                                                                        }
                                                                        
                                                                        switch(cmbOrigenDatosCampo.getValue())
                                                                        {
                                                                        	case '1':
                                                                            case '2':
                                                                            	mostrarVentanaSeleccionOrigenDato(cmbOrigenDatosCampo.getValue());
                                                                                ventanaAM.close();
                                                                            break;
                                                                        }
                                                                        
                                                                        	
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

function mostrarVentanaSeleccionOrigenDato(tipo)
{
	var lblTipo='Seleccione el almac&eacute;n de datos que desea vincular al campo especial';
	if(tipo=='2')
    	lblTipo='Seleccione la consulta auxiliar que desea vincular al campo especial';
    
    var gridOrigenes=crearGridOrigenesDatos();
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:lblTipo
                                                        },
                                                        gridOrigenes
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Selecci&oacute;n de origen de datos',
										width: 400,
										height:390,
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
																	 	var filaSel=gridOrigenes.getSelectionModel().getSelected();
                                                                     	if(filaSel==null)
                                                                        {
                                                                        	msgBox('Debe seleccionar el almac&eacute;n de datos con el cual se vincular&aacute; el campo especial');

                                                                            return;
                                                                        }
                                                                        var idAlmacen=filaSel.get('idAlmacen');
                                                                        ventanaAM.close();
                                                                        if(tipo=='1')
                                                                        	mostrarVentanaCamposAlmacen(idAlmacen,tipo,filaSel.get('camposProy'));
                                                                        else
                                                                        {
                                                                        	validarVinculacionAlmacen(idAlmacen,tipo,eval(filaSel.get('camposProy'))[0][0]);
                                                                        }
                                                                        ventanaAM.close();
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
                                
	llenarGridAlmacen(gridOrigenes,tipo,ventanaAM);                                

}

function crearGridOrigenesDatos(tipo)
{
	var lblTitulo='Almac&eacute;n de datos';
    if(tipo=='2')
    	lblTitulo='Consulta auxiliar';
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idAlmacen'},
                                                                    {name: 'nombre'},
                                                                    {name: 'camposProy'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:lblTitulo,
															width:250,
															sortable:true,
															dataIndex:'nombre'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridOrigenDatos',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:350,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;	
	
}

function llenarGridAlmacen(grid,tipo,ventana)
{
	var arrOrigenesDatos=[];
    var camposProy='';
	var arbolDataSet=gEx('arbolDataSet');
    var nodoRaiz=arbolDataSet.getRootNode();
    var nodoOrigen;
	if(tipo=='1')
    	nodoOrigen=obtenerHijosNodoArbol(nodoRaiz)[0];
    else
    	nodoOrigen=obtenerHijosNodoArbol(nodoRaiz)[2];

	var x;
    var obj
    var y;
    var camposProy='';
    var nodoAlmacen;
    var nodoCampos;
    var arrHijosOrigen=obtenerHijosNodoArbol(nodoOrigen);
    for(x=0;x<arrHijosOrigen.length;x++)
    {
    	camposProy='';
    	obj=new Array();
        nodoAlmacen=arrHijosOrigen[x];
        obj[0]=nodoAlmacen.id;
        obj[1]=nodoAlmacen.attributes.nombreDataSet;
        
        var nodoCampos=obtenerHijosNodoArbol(nodoAlmacen)[0];
        var arrNodosCamposProy=obtenerHijosNodoArbol(nodoCampos);
        var nCampoProy;
        for(y=0;y<arrNodosCamposProy.length;y++)
        {
        	if(arrNodosCamposProy[y].attributes!=undefined)
	        	nCampoProy=arrNodosCamposProy[y].attributes.nCampo;
            else
            	nCampoProy=arrNodosCamposProy[y].nCampo;    
        	
            cadObj="['"+nCampoProy+"','"+arrNodosCamposProy[y].text+"']";
            
        	if(camposProy=='')
            	camposProy=cadObj;
            else
            	camposProy+=','+cadObj;
            
        }
        
        obj[2]='['+camposProy+']';
        arrOrigenesDatos.push(obj);
    }        
     gEx('gridOrigenDatos').getStore().loadData(arrOrigenesDatos); 
     ventana.show();
}

function mostrarVentanaCamposAlmacen(idAlmacen,tipo,campoProy)
{
	var gridCamposProy=crearGridCamposProy();
    gridCamposProy.getStore().loadData(eval(campoProy));
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Seleccione el campo que desea proyectar en el control a agregar:'
                                                        },
                                                        gridCamposProy

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Selecci&oacute;n de campo a proyectar',
										width: 390,
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
																		var filaSel=gridCamposProy.getSelectionModel().getSelected();
                                                                        if(filaSel==null)
                                                                        {
                                                                        	msgBox('Debe seleccionar el campo a proyectar en el control a agregar');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var campoProy=filaSel.get('nCampoO');
                                                                        ventanaAM.close();
                                                                        validarVinculacionAlmacen(idAlmacen,tipo,campoProy);
                                                                        
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

function crearGridCamposProy()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'nCampoO'},
                                                                {name: 'nCampo'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Campo',
															width:250,
															sortable:true,
															dataIndex:'nCampo'
														}													
                                                   ]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:360,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;	
}

function validarVinculacionAlmacen(idAlmacen,tipo,campoProy) //--
{
	var arrDiv=['-1','-1'];
    if(divCtrlSel!=null)
    	arrDiv=divCtrlSel.id.split('_');
    var idReporte=gE('idReporte').value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	if(arrResp[1]=='')
            {
            	objFinal='{"campoProy":"'+campoProy+'","idPadre":"@idPadre","idReporte":"'+idReporte+'","pregunta":[],"tipoElemento":"28","obligatorio":"0","posX":"@posX","posY":"@posY","tipo":"'+tipo+'","idAlmacen":"'+idAlmacen+'"}';
                g.objControl=objFinal;	
            }
            else
            {
            
            	var arrParam=eval(arrResp[1]);
                arrCamposAlmacen=eval(arrResp[2]);
                if(arrParam.length>0)
	             	mostrarVentanaAsignarParametro(arrParam,idAlmacen,tipo,campoProy); 
                else
                {
                	objFinal='{"campoProy":"'+campoProy+'","idPadre":"@idPadre","idReporte":"'+idReporte+'","pregunta":[],"tipoElemento":"28","obligatorio":"0","posX":"@posX","posY":"@posY","tipo":"'+tipo+'","idAlmacen":"'+idAlmacen+'"}';
                	g.objControl=objFinal;
                }
            }
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=25&idAlmacen='+idAlmacen+'&idAlmacenPadre='+arrDiv[1],true);
}

function mostrarVentanaAsignarParametro(datos,idAlmacen,tipo,campoProy) //--
{
	var idReporte=gE('idReporte').value;
	var gridParam=crearGridAsignaParametro(idAlmacen);
    gridParam.getStore().loadData(datos)
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Indique los valores que se asignar&aacute;n a los siguientes par&aacute;metros:'
                                                        },
                                                        gridParam
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Asignaci&oacute;n de valor a par&aacute;metros',
										width: 500,
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
															handler:function()
																	{
                                                                    	objFinal='{"campoProy":"'+campoProy+'","idPadre":"@idPadre","idReporte":"'+idReporte+'","pregunta":[],"tipoElemento":"28","obligatorio":"0","posX":"@posX","posY":"@posY","tipo":"'+tipo+'","idAlmacen":"'+idAlmacen+'"}';
                														g.objControl=objFinal;
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();
}

function crearGridAsignaParametro(idAlmacen) //--
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idParametro'},
                                                                    {name: 'parametro'},
                                                                    {name: 'asigna'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														{
															header:'Par&aacute;metro',
															width:170,
															sortable:true,
															dataIndex:'parametro'
														},
                                                        {
															header:'Valor',
															width:200,
															dataIndex:'asigna',
                                                            renderer:function(val,metaData,registro,nFila)
                                                            		{
                                                                    	return val+'<a href="javascript:asignarValorParametroAlmacen(\''+bE(idAlmacen)+'\',\''+bE(registro.get('parametro'))+'\',\''+bE(nFila)+'\')">&nbsp;&nbsp;<img src="../images/pencil.png" width="13" height="13" alt="Modificar valor del par&aacute;metro" title="Modificar valor del par&aacute;metro"></a>';
                                                                    }
														}

													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridAsignaParametros',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:460,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;	
	
}

function asignarValorParametroAlmacen(iAlmacen,parametro,nFila) //--
{
	arrParametrosRep=eval(gE('param').value);
    var arrTipoEntrada=[['7','Consulta auxiliar'],['8','Valor de almac\xE9n padre'],['1','Valor Constante'],['2','Valor de par\xE1metro de reporte'],['3','Valor de sesi\xF3n'],['4','Valor de sistema']];
    var cmbTipoValor=crearComboExt('cmbTipoValor',arrTipoEntrada,140,5);
    cmbTipoValor.on('select',funcTipoEntradaChange2);
    var cmbValor=crearComboExt('cmbValor',[],140,35);
    cmbValor.setWidth(250);
    cmbValor.hide();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Tipo de valor a asignar:'
                                                        },
                                                        cmbTipoValor,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Valor a asignar:'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                        	id:'txtValorConstante',
                                                            x:140,
                                                            y:35
                                                        },
                                                        cmbValor
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Asignar valor a par&aacute;metro',
										width: 430,
										height:150,
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
																		if(cmbTipoValor.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar el tipo de entrada al que pertenece el valor a asignar');
                                                                        	return;
                                                                        }
                                                                        var valorUsr;
                                                                        var valor;
                                                                        switch(cmbTipoValor.getValue())
                                                                        {
                                                                        	case '1':
                                                                            	valor=gEx('txtValorConstante').getValue();
                                                                                valorUsr=valor;
                                                                            break;
                                                                            default:
                                                                            	if(cmbValor.getValue()=='')
                                                                                {
                                                                                	msgBox('Debe seleccionar el valor que desea asignar');
                                                                                	return;
                                                                                }
                                                                                valor=cmbValor.getValue();
                                                                                valorUsr=cmbValor.getRawValue();
                                                                            break;
                                                                        }                                                                        
                                                                        var tipo=cmbTipoValor.getValue();
                                                                        var almacen=iAlmacen;
                                                                        var param=parametro;
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            
                                                                            	var fila=gEx('gridAsignaParametros').getStore().getAt(bD(nFila));
                                                                            	if(tipo=='1')
	                                                                            	fila.set('asigna',''+valorUsr);
                                                                                else
                                                                                	fila.set('asigna','['+valorUsr+']');
                                                                                gEx('arbolDataSet').getRootNode().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=16&valor='+valor+'&valorUsr='+valorUsr+'&parametro='+param+'&tipo='+tipo+'&almacen='+bD(almacen),true);
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
    var arrPresentaOpc=[['0','Un combo'],['1','Un listado de opciones tipo radio'],['2','Un listado de opciones tipo checkbox'],['3','Un listado de opciones con numeraci\xF3n']];
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
    var objConf={confVista:'<tpl for="."><div class="search-item"><span class="{nombre}">{nombre}</span></div></tpl>'};
    var cmbClase=crearComboExt('cmbClase',arrEstilos,180,185,250,objConf);
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
                                            break;
                                            case '1':
                                            	arrAlmacenDatos=obtenerAlmacenesDatosDS();
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
                                	var arrCampos=obtenerCamposAlmacenDatos(registro.get('id'));
                                    gEx('cmbCampoEtiqueta').getStore().loadData(arrCampos);
									gEx('cmbCampoID').getStore().loadData(arrCampos);
                                   	gEx('cmbCampoValor').getStore().loadData(arrCampos);
                                }
                                
                                
                                switch(gEx('cmbValorRespuesta').getValue())
                                {
                                	case '0':	
                                    case '2':
                                    	obtenerValoresRespuesta(0,registro.data.id);
                                    break;
                                }
                                
                                
                                
                            }
    			)
    var cmbCampoEtiqueta=crearComboExt('cmbCampoEtiqueta',[],180,305,250);
    cmbCampoEtiqueta.hide();
    var cmbCampoID=crearComboExt('cmbCampoID',[],180,335,250);
    cmbCampoID.hide();
    var cmbCampoValor=crearComboExt('cmbCampoValor',[],180,365,250);
    cmbCampoValor.hide();
  	var cmbOpciones=crearComboExt('cmbOpciones',arrPresentaOpc,180,395,250);
    cmbOpciones.setValue('0');
    var cmbClasePregunta=crearComboExt('cmbClasePregunta',arrEstilos,180,425,250,objConf);
    var cmbSiNo=crearComboExt('cmbSiNo',arrSiNo,180,455,150);
    cmbSiNo.setValue('0');
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
                                                                                            width:600,
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
                                                                                            html:'Clase a aplicar a la pregunta:'
                                                                                        },
                                                                                        cmbClasePregunta,
                                                                                        {
                                                                                            x:10,
                                                                                            y:460,
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
                                                                        	if(cmbValorRespuesta.getValue()=='1')
                                                                            	lblEscala='Debe indicar la escala de evaluci&oacute;n a utilizar en esta pregunta';
                                                                            else
                                                                            	lblEscala='Debe indicar el almac&eacute;n de datos a utilizar en esta pregunta';	
                                                                        	msgBox(lblEscala)
                                                                        	return;
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
                                                                        var cadObj='{"campoEtiqueta":"'+cmbCampoEtiqueta.getValue()+'","campoID":"'+cmbCampoID.getValue()+'","campoValor":"'+cmbCampoValor.getValue()+
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
                                                        cmbTipoCuestionario
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
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=45&tipoCuestionario='+cmbTipoCuestionario.getValue()+
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

function obtenerAlmacenesDatosDS()  //--
{

	var arbolDataSet=gEx('arbolDataSet');
    var nodoAlmacenes=arbolDataSet.getRootNode().childNodes[0];
    
    var arrAlmacenDatos=new Array();
    var x;
    var n;
    for(x=0;x<nodoAlmacenes.childNodes.length;x++)
    {
        n=nodoAlmacenes.childNodes[x];
        arrAlmacenDatos.push([n.id,n.attributes.nombreDataSet]);
    }	
    return arrAlmacenDatos;
}

function obtenerCamposAlmacenDatos(idAlmacen) //--
{
	var arrCampos=new Array();
	var arbolDataSet=gEx('arbolDataSet');
    var nodoAlmacenes=arbolDataSet.getRootNode().childNodes[0];
   	var x;
    var ct;
    var n;
    var nAux;
    var hijosAlmacen;
    var hijosCamposProy;
    for(x=0;x<nodoAlmacenes.childNodes.length;x++)
    {
        n=nodoAlmacenes.childNodes[x];
        if(n.id==idAlmacen)
        {
        	hijosAlmacen=obtenerHijosNodoArbol(n);
            hijosCamposProy=obtenerHijosNodoArbol(hijosAlmacen[0]);
            for(ct=0;ct<hijosCamposProy.length;ct++)
            {
            	nAux=hijosCamposProy[ct];
                if(nAux.nCampo!=undefined)
	                arrCampos.push([nAux.nCampo,nAux.text]);
                else
                	arrCampos.push([nAux.attributes.nCampo,nAux.text]);
            }
        }
    }	

    return arrCampos;
}

function crearGridRespuestasPregunta()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'respuesta'},
                                                                    {name: 'valor'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	chkRow,
														{
															header:'Respuesta',
															width:350,
															sortable:true,
															dataIndex:'respuesta'
														},
														{
															header:'Respuesta correcta',
															width:200,
															sortable:true,
															dataIndex:'valor'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:false,
                                                            x:10,
                                                            y:10,
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
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar respuesta',
                                                                            handler:function()
                                                                            		{
                                                                                    	
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover respuesta',
                                                                            handler:function()
                                                                            		{
                                                                                    	
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;	
}