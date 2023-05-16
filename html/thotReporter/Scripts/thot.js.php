<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$query="select nombreEstilo,nombreEstilo from 932_estilos";
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
	$consulta="SELECT idFuncion,nombreFuncion FROM 9033_funcionesScriptsSistema where idCategoria=1 ORDER BY nombreFuncion";
	$arrFuncionesRenderer=$con->obtenerFilasArreglo($consulta);
?>
var arrFuncionesRenderer=<?php echo $arrFuncionesRenderer?>;
Ext.onReady(inicializar);
var nodoSel=null;
var arrParamConfiguraciones;
var g;
var idElementoSel='';
var divCtrlSel=null;
var arrCamposAlmacen;

Ext.override	(Ext.grid.PropertyColumnModel, 
                                            {
                                                renderCell : function(val, meta, r)
                                                {
                                                    var renderer = this.grid.customRenderers[r.get('name')];
                                                    if(renderer)
                                                    {
                                                        return renderer.apply(this, arguments);
                                                    }
                                                    var rv = val;
                                                    if(Ext.isDate(val))
                                                    {
                                                        rv = this.renderDate(val);
                                                    }
                                                    else 
                                                        if(typeof val == 'boolean')
                                                        {
                                                            rv = this.renderBool(val);
                                                        }
                                                    return Ext.util.Format.htmlEncode(rv);
                                                }
                                            }
				);
                
Ext.override	(Ext.grid.PropertyGrid, 
                                        {
                                            initComponent : function()
                                            {
                                                this.customRenderers = this.customRenderers || {};
                                                this.customEditors = this.customEditors || {};
                                                this.lastEditRow = null;
                                                var store = new Ext.grid.PropertyStore(this);
                                                this.propStore = store;
                                                var cm = new Ext.grid.PropertyColumnModel(this, store);
                                                store.store.sort('name', 'ASC');
                                                this.addEvents
                                                (
                                                    'beforepropertychange',
                                                    'propertychange'
                                                );
                                                this.cm = cm;
                                                this.ds = store.store;
                                                Ext.grid.PropertyGrid.superclass.initComponent.call(this);
                                                this.mon(this.selModel, 'beforecellselect', function(sm, rowIndex, colIndex)
                                                                                            {
                                                                                                if(colIndex === 0)
                                                                                                {
                                                                                                    this.startEditing.defer(200, this, [rowIndex, 1]);
                                                                                                    return false;
                                                                                                }
                                                                                            }, 
                                                         this);
                                            },
                                            setProperty: function(property, value)
                                            {
                                                this.propStore.source[property] = value;
                                                var r = this.propStore.store.getById(property);
                                                if(r)
                                                {
                                                    r.set('value', value);
                                                }
                                                else
                                                {
                                                    r = new Ext.grid.PropertyRecord({name: property, value: value}, property);
                                                    this.propStore.store.add(r);
                                                }
                                            },
                                            removeProperty: function(property)
                                            {
                                                delete this.propStore.source[property];
                                                var r = this.propStore.store.getById(property);
                                                if(r)
                                                {
                                                    this.propStore.store.remove(r);
                                                }
                                            }
                                        }
					);

var ctrlDestino=null;

function inicializar()
{
	arrParametrosObjeto=eval(gE('param').value);

	var valorAncho=gE('ancho').value;
    var valorAlto=gE('alto').value;
    var idRep=gE('idReporte').value;
	Ext.QuickTips.init();
    
    var obj={};
    obj.permitirRegistroParametro=true;
    altura=obtenerDimensionesNavegador()[1];
    obj.alto=altura;
    obj.idReferencia=idRep;
    obj.tDataSet=1;
    obj.region='east';
    obj.collapsible=true;
    obj.title='Almacenes de datos';
    obj.tituloConcepto='el reporte';
    obj.funcLoad=actualizarAlmacenesGraficos;
    var gridPropiedades=inicializarGrid();     
    var arbolAlmacen=crearArbolAlmacen(obj);
	var pagRegresar=gE('pagRegresar').value;    
    var nUsuario=gE('nUsuario').value;
    var tb=new Ext.Toolbar	(
    							{
									region: 'north',
                                    height:28,
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
                                            items: [
                                                        tb,
                                                        {
                                                            layout: 'border',
                                                            id: 'layout-browser',
                                                            region:'west',
                                                            border: true,
                                                            split:true,
                                                            margins: '2 0 5 5',
                                                            width: 255,
                                                            collapsible:true,
                                                            hideCollapseTool :false,
                                                            layoutConfig:{
                                                                            animate:true
                                                                        },
                                                            title:'',
                                                            items: 	[
                                                                        {
                                                                              layout: 'border',
                                                                              id: 'layout-browser',
                                                                              region:'center',
                                                                              border: true,
                                                                              split:true,
                                                                              items: 	[
                                                                                          {
                                                                                              layout:'absolute',
                                                                                              xtype:'form',
                                                                                              title: 'Propiedades del grid',
                                                                                              region: 'north',
                                                                                              height: 175,
                                                                                              bodyStyle:'background-color:#DFE8F6;border-color:#DFE8F6',
                                                                                              items:	[
                                                                                                          {
                                                                                                              x:15,
                                                                                                              y:15,
                                                                                                              html:'Ancho:',
                                                                                                              bodyStyle:'background-color:#DFE8F6;border-color:#DFE8F6'
                                                                                                          },
                                                                                                          {
                                                                                                              id:'txtAncho',
                                                                                                              xtype:'numberfield',
                                                                                                              width:55,
                                                                                                              x:75,
                                                                                                              y:12,
                                                                                                              value:valorAncho,
                                                                                                              listeners:	{
                                                                                                                              change:function(ctrl,valor)
                                                                                                                                      {
                                                                                                                                          g.setAncho(valor);
                                                                                                                                      }
                                                                                                                          }
                                                                                                          },
                                                                                                          {
                                                                                                              xtype:'label',
                                                                                                              x:140,
                                                                                                              y:15,
                                                                                                              html:'px'
                                                                                                          },
                                                                                                          {
                                                                                                              x:15,
                                                                                                              y:45,
                                                                                                              html:'Alto:',
                                                                                                              bodyStyle:'background-color:#DFE8F6;border-color:#DFE8F6'
                                                                                                          },
                                                                                                          {
                                                                                                              id:'txtAlto',
                                                                                                              xtype:'numberfield',
                                                                                                              width:55,
                                                                                                              x:75,
                                                                                                              y:42,
                                                                                                              value:valorAlto,
                                                                                                              listeners:	{
                                                                                                                              change:function(ctrl,valor)
                                                                                                                                      {
                                                                                                                                          g.setAlto(valor);
                                                                                                                                      
                                                                                                                                      }
                                                                                                                          }
                                                                                                          },
                                                                                                           {
                                                                                                              xtype:'label',
                                                                                                              x:140,
                                                                                                              y:45,
                                                                                                              html:'px'
                                                                                                          },
                                                                                                          {
                                                                                                              xtype:'label',
                                                                                                              x:10,
                                                                                                              y:80,
                                                                                                              html:'<a href="javascript:verParametrosReporte()"><img src="../images/database_connect.png" />&nbsp;Par&aacute;metros del reporte</a>'
                                                                                                          },
                                                                                                          {
                                                                                                              xtype:'label',
                                                                                                              x:10,
                                                                                                              y:110,
                                                                                                              html:'<a href="javascript:obtenerUrlReporte()"><img src="../images/link.png" />&nbsp;Obtener URL del reporte</a>'
                                                                                                          }
                                                                                                      ]
                                                                                              
                                      
                                      
                                                                                          },
                                                                                          gridPropiedades
                                                                                      ]
                                                                          }
                                                                    ]
                                                        }
                                                        ,
                                                        arbolAlmacen,
                                                        /*{
                                                            layout: 'border',
                                                            id: 'layout-browser2',
                                                            region:'east',
                                                            border: true,
                                                            split:true,
                                                            margins: '2 0 5 5',
                                                            width: 255,
                                                            collapsible:true,
                                                            hideCollapseTool :false,
                                                            layoutConfig:{
                                                                            animate:true
                                                                        },
                                                            title:'',
                                                            items: 	[
                                                            			
                                                                        {
                                                                            region: 'center',
                                                                            id: 'menuDatSet', 
                                                                            title: '<b>Almacenes de datos</b>',
                                                                            border: false,
                                                                            split:true,
                                                                            width: 250,
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
                                                        },*/
                                                            
                                                        {
                                                            tbar:	[
                                                                        {
                                                                            xtype:'tbspacer',
                                                                            width:20
                                                                        },
                                                                        {
                                                                            icon:'../images/formularios/font_add.png',
                                                                            tooltip:'Insertar etiqueta',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                                    {
                                                                                        g.mostrarVentanaInsertarEtiqueta();
                                                                                    }
                                                                        },'-',
                                                                        {
                                                                            icon:'../images/formularios/font_go.png',
                                                                            tooltip:'Insertar etiqueta con vinculaci&oacute;n a almac&eacute;n',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                                      {
                                                                                            ctrlDestino	=divCtrlSel;
                                                                                            mostrarVentanaVinculacionCampoEspecial(); 
                                                                                      }
                                                                        },'-',
                                                                        {
                                                                            icon:'../images/formularios/paintbrush.png',
                                                                            tooltip:'Crear estilo',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                                    {
                                                                                        g.mostrarVentanaEstilos();
                                                                                    }
                                                                        },'-',
                                                                        {
                                                                            icon:'../images/formularios/image.png',
                                                                            tooltip:'Insertar imagen',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                                    {
                                                                                        g.mostrarVentanaImagenes();
                                                                                    }
                                                                        },'-',
                                                                        {
                                                                            icon:'../images/formularios/chart_pie.png',
                                                                            tooltip:'Gr&aacute;fico',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                                    {
                                                                                        mostrarVentanaGrafico();
                                                                                    }
                                                                        },'-',
                                                                        {
                                                                            icon:'../images/formularios/chart_pie.png',
                                                                            tooltip:'L&iacute;nea',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:true,
                                                                            handler:function()
                                                                                    {
                                                                                        g.dibujarLinea=true;
                                                                                    }
                                                                        },
                                                                         {
                                                                            icon:'../images/page_white_gear.png',
                                                                            tooltip:'Cat&aacute;logo de funciones/C&aacute;lculos',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                                    {
                                                                                     	asignarFuncionNuevoConceptoInyeccion=function(registro,ventana){ventana.close()};
                                                                                        mostrarVentanaExpresion(function(registro,ventana){ventana.close()},true);   
                                                                                    }
                                                                        }
                                                                        ,'-',
                                                                        {
                                                                            icon:'../images/table_row_insert.png',
                                                                            text:'Insertar...',
                                                                            cls:'x-btn-text-icon',
                                                                            menu: 	[
                                                                                        {
                                                                                            text:'Secci&oacute;n repetible',
                                                                                            handler:function()
                                                                                                    {
                                                                                                        g.insertarSeccionSepetible();
                                                                                                    }
                                                                                        }
                                                                                        
                                                                                    ]
                                                                        },'-',
                                                                        {
                                                                            id:'btnAgregarCampoEspecial',
                                                                            icon:'../images/table_row_insert.png',
                                                                            text:'Insertar campo de secci&oacute;n...',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:true,
                                                                            menu: 	[
                                                                                        
                                                                                        {
                                                                                            text:'Contador de registros',
                                                                                            handler:function()
                                                                                                    {
                                                                                                        ctrlDestino	=divCtrlSel;
                                                                                                        var idReporte=gE('idReporte').value;
                                                                                                        var tElemento=27;
                                                                                                        ctrlDestino	=divCtrlSel;
                                                                                                        objFinal='{"idPadre":"@idPadre","idReporte":"'+idReporte+'","pregunta":[],"tipoElemento":"'+tElemento+'","obligatorio":"0","posX":"@posX","posY":"@posY"}';
                                                                                                        g.objControl=objFinal;
                                                                                                    }
                                                                                        }
                                                                                    ]
                                                                        },
                                                                        '-',
                                                                        {
                                                                            icon:'../images/cancel_round.png',
                                                                            tooltip:'Eliminar elemento',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:true,
                                                                            id:'btnDelElemento',
                                                                            handler:function()	
                                                                                    {
                                                                                        g.eliminarElemento(bE(idElementoSel));
                                                                                    }
                                                                        },
                                                                        {
                                                                            
                                                                            icon:'../images/database_add.png',
                                                                            tooltip:'Almac&eacute;n de datos...',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:true,
                                                                            id:'btnDataSet',
                                                                            handler:function()	
                                                                                    {
                                                                                        var divSel=g.gE('div_'+idElementoSel);
                                                                                        if(divSel.getAttribute('almacenVinculado')=='0')
                                                                                            vincularAlmacenDatos(bE(idElementoSel));
                                                                                        else
                                                                                            administrarAlmacenDatos(bE(idElementoSel));
                                                                                        
                                                                                    }
                                                                        }
                                                                        
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
                                                                            url:'../thotReporter/thotGrid.php',
                                                                            scripts:true,
                                                                            params:	{
                                                                                        cPagina:'sFrm=true',
                                                                                        idReporte:idRep,
                                                                                        anchoGrid:valorAncho,
                                                                                        altoGrid:valorAlto
                                                                                    }
                                                                        }
                                                        }
                                        			]
                                        }
									);
}

function inicializarGrid()
{
	var fuente={};
    var cmbFuncionRenderer=crearComboExt('cmbFuncionRenderer',arrFuncionesRenderer);
    
    var arrAlmacenesGraf=eval(bD(gE('almacenesGraficos').value));
   
    var cmbAlmacenGraf=crearComboExt('cmbAlmacenGraf',arrAlmacenesGraf);
    var ctrlColor=new Ext.grid.GridEditor(new Ext.form.ColorField(	{
                                                                        id: 'color'
                                                                    }
                                                                 )
                                         );
    var txtNombre=new Ext.form.TextField	(	
                                                {
                                                    id:'txtNombre',
                                                    maskRe:/^[a-zA-Z0-9]$/
                                                }
                                            )      
	var arrEstilos=<?php echo $arrEstilos?>;          
    var objConfEstilo={};
    objConfEstilo.confVista='<tpl for="."><div class="search-item"><span class="{nombre}">{nombre}</span></div></tpl>';                                                     
	var cmbEstilos=crearComboExt('cmbEstilos',arrEstilos,0,0,0,objConfEstilo);              
    var cmbTipoGrafico=crearComboExt('cmbTipoGrafico',arrGraficos);
	var propsGrid = 	new Ext.grid.PropertyGrid	(
                                                        {
                                                        	region:'center',
                                                            id:'GridPropiedades',
                                                            width: 220,
                                                            autoHeight: true,
                                                            title:'Propiedades del control',
                                                            source: fuente,
                                                            tbar:	[
                                                            			/*{
                                                                            icon:'../images/cancel_round.png',
                                                                            tooltip:'Eliminar elemento',
                                                                            text:'Eliminar elemento',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:true,
                                                                            id:'btnDelElemento',
                                                                            handler:function()	
                                                                                    {
                                                                                        h.eliminarElemento(idElementoSel);
                                                                                    }
                                                                        },*/
                                                            			{
                                                                        	id:'btnModificarConElemento',
                                                                        	text:'Propiedades avanzadas',
                                                                            icon:'../images/pencil.png',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:true,
                                                                            handler:function()
                                                                            		{
                                                                                    	switch(tipoControl)
                                                                                        {
                                                                                        	case '31':
                                                                                            	
                                                                                            	mostrarVentanaPropiedadesGrafico();
                                                                                            break;	
                                                                                        }
                                                                                    }
                                                                        }
                                                                        
                                                            		],
                                                            customEditors: {
                                                            					'funcionRenderer':new Ext.grid.GridEditor(cmbFuncionRenderer),
                                                                                'nombre':new Ext.grid.GridEditor(txtNombre),
                                                                                'estilo':new Ext.grid.GridEditor(cmbEstilos),
                                                                                'colorFondo':ctrlColor,
                                                                                'colorFondo1':ctrlColor,
                                                                                'colorFondo2':ctrlColor,
                                                                                'almacenGraf':new Ext.grid.GridEditor(cmbAlmacenGraf),
                                                                                'tipoGrafico':new Ext.grid.GridEditor(cmbTipoGrafico)
                                                                            },
                                                            customRenderers:
                                                                            {
                                                                            	funcionRenderer:formatearFuncionRenderer,
                                                                            	almacenGraf:formatearAlmacen,
                                                                                tipoGrafico:function(val)
                                                                                			{
                                                                                            	return formatearValorRenderer(arrGraficos,val);
                                                                                            }
                                                                            },                
                                                            propertyNames:	{
                                                            					funcionRenderer:'Funci&oacute;n renderer',
                                                                            	etiqueta:'Etiqueta',
                                                                                nombre:'Nombre',
                                                                                estilo:'Estilo',
                                                                                alto:'Alto',
                                                                                ancho:'Ancho',
                                                                                colorFondo:'Color de fondo',
                                                                                colorFondo1:'Color de fondo 1',
                                                                                colorFondo2:'Color de fondo 2',
                                                                                intervalo:'Incremento',
                                                                                vInicial:'Valor inicial',
                                                                                titulo:'T&iacute;tulo',
                                                                                almacenGraf:'Almac&eacute;n vinculado',
                                                                                tamTitulo:'Tam. letra t&iacute;tulo',
                                                                                tamFuente:'Tam. letra fuente',
                                                                                tamLeyenda:'Tam. letra leyenda',
                                                                                radioGrafico:'Tam. Radio',
                                                                                tipoGrafico:'Tipo de gr&aacute;fico'
                                                                                <?php 
                                                                                    echo $arrLblRender;
                                                                                ?>
                                                                            },
                                                            viewConfig : 
                                                                            {
                                                                                forceFit: true,
                                                                                scrollOffset: 2 
                                                                            }
                                                            

                                                        }
                                                    );
    var colM=propsGrid.getColumnModel();                                                
    var nomCol=colM.getColumnId(1);
    var col=colM.getColumnById(nomCol);
    colM.setColumnHeader(1,'Valor');
    colM.setColumnHeader(0,'Propiedad');
    propsGrid.on('beforeedit',validarEdicion);
    propsGrid.on('afteredit',regCambiado);            
    return propsGrid
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

function establecerFuenteVacia()
{
	var fuente={};
    gEx('btnModificarConElemento').hide();
    var gridPropiedades=Ext.getCmp('GridPropiedades');
    gridPropiedades.setSource(fuente);
    gridPropiedades.getView().refresh();
    gEx('btnDelElemento').hide();
    gEx('btnDataSet').hide();
	idElementoSel='';
}

function establecerFuente(idControl)
{
	var fuente={};
    gEx('btnModificarConElemento').hide();
    var div=g.gE(idControl);
    divCtrlSel=div;
    var arrDatosDiv=idControl.split('_');
    idElementoSel=arrDatosDiv[1];
    var gridPropiedades=Ext.getCmp('GridPropiedades');
    gEx('btnDataSet').hide();
    gEx('btnDelElemento').show();
    var nomControl=div.getAttribute('controlInterno');
	var vOrden=div.getAttribute('orden');
    arrNomControl=nomControl.split('_');
    tipoControl=arrNomControl[2];
    if(tipoControl=='25')
    	gEx('btnDataSet').show();
	var ctrlNombre=arrNomControl[1].substr(0,arrNomControl[1].length-3); 
    var ctrl=g.gE('_'+arrNomControl[1]);
    var x=parseInt(div.style.left.substr(0,div.style.left.length-2))-g.posDivX;
    var y=parseInt(div.style.top.substr(0,div.style.top.length-2))-g.posDivY;
    var obl=0;
    var tControl=parseInt(tipoControl);
	var vVisible='1';
    var aVisible=div.getAttribute('visible');
    if(aVisible!=null)
    	vVisible=aVisible;
    var vHabilitado='1';
    var aHabilitado=div.getAttribute('habilitado');
    if(aHabilitado!=null)
    	vHabilitado=aHabilitado;
    var cFondo=div.getAttribute('colorFondo1');
    if(cFondo==null)
	   	cFondo='';
    gEx('btnAgregarCampoEspecial').hide();
    
    switch(tipoControl)
    {
    	case '1':  //etiqueta
            var ct=0;
            var arrCampos=',';
            var valorEt='';
            var lblEt=g.gE('_lbl'+g.idControlSel);
            var ancho=lblEt.style.width;
            ancho=ancho.replace('px','');
            for(ct=0;ct<g.nIdiomas;ct++)
            {
            	valorEt=g.gE('td_'+g.idControlSel+'_'+g.arrIdiomas[ct].idIdioma).value;
            	arrCampos+='"etiqueta_'+g.arrIdiomas[ct].idIdioma+'":"'+valorEt+'"';
            }
            var estilo=obtenerClase(ctrl);
            var idFuncionRenderer='';
            if((lblEt.getAttribute('funcRenderer')!=null)&&(lblEt.getAttribute('funcRenderer')!=''))
                idFuncionRenderer=lblEt.getAttribute('funcRenderer');
            var txtObj='[{"X":"'+x+'","Y":"'+y+'"'+arrCampos+',"estilo":"'+estilo+'","ancho":"'+ancho+'","colorFondo":"'+cFondo+'","funcionRenderer":"'+idFuncionRenderer+'"}]';
        	fuente=	eval(txtObj)[0];
        break;
    	case '23':
        	var txtAncho;
            var txtAlto;
            var imagen=g.gE('_'+ctrlNombre+'img');
            txtAncho=imagen.width;
            txtAlto=imagen.height;
            fuente=	{
                        nombre:ctrlNombre,
                        X:x,
                        Y:y,
                        ancho:txtAncho,
                        alto:txtAlto,
                        colorFondo:cFondo
                    }
        break;
        case '25':
        	gEx('btnAgregarCampoEspecial').show();
			var cFondo2=div.getAttribute('colorFondo2');
            txtAlto=g.gE('filaPrincipal_'+g.idControlSel).style.height.replace('px','');
            txtAncho=g.gE('_secc'+g.idControlSel).style.width.replace('px','');
            fuente=	{
                        Y:y,
                        X:x,
                        alto:txtAlto,
                        colorFondo1:cFondo,
                        colorFondo2:cFondo2,
                        ancho:txtAncho
                    }
        break;
        case '26':
        	var lblEt=g.gE('_lbl'+g.idControlSel);
            var txtAncho=lblEt.style.width;
            txtAncho=txtAncho.replace('px','');
            var txtAlto=lblEt.style.height;
            txtAlto=txtAlto.replace('px','');
	        var estiloCtrl=obtenerClase(ctrl);
        	fuente=	{
                        X:x,
                        Y:y,
                        ancho:txtAncho,
                        estilo:estiloCtrl,
                        colorFondo:cFondo,
                        alto:txtAlto
                    }
        break;
        case '27':
			var lblEt=g.gE('_lbl'+g.idControlSel);
        	var estiloCtrl=obtenerClase(ctrl);
            var txtAlto=lblEt.style.height;
            txtAlto=txtAlto.replace('px','');
            var txtAncho=lblEt.style.width;
            txtAncho=txtAncho.replace('px','');
            var vIni=ctrl.getAttribute('vInicial');
            var vIncremento=ctrl.getAttribute('vIncremento');
        	fuente=	{
            			X:x,
                        Y:y,
                        colorFondo:cFondo,
                        estilo:estiloCtrl,
                        ancho:txtAncho,
                        alto:txtAlto,
                        intervalo:vIncremento,
                        vInicial:vIni
                    }
        break;
        case '28':
        	var lblEt=g.gE('_lbl'+g.idControlSel);
            var txtAncho=lblEt.style.width;
            txtAncho=txtAncho.replace('px','');
            var txtAlto=lblEt.style.height;
            txtAlto=txtAlto.replace('px','');
	        var estiloCtrl=obtenerClase(ctrl);
            var idFuncionRenderer='';
            if((lblEt.getAttribute('funcRenderer')!=null)&&(lblEt.getAttribute('funcRenderer')!=''))
                idFuncionRenderer=lblEt.getAttribute('funcRenderer');
        	fuente=	{
                        X:x,
                        Y:y,
                        ancho:txtAncho,
                        estilo:estiloCtrl,
                        colorFondo:cFondo,
                        alto:txtAlto,
                        funcionRenderer:idFuncionRenderer
                    }
        break;
        case '31':
        	var txtAncho;
            var txtAlto;
            gEx('btnModificarConElemento').show();
            var tabla=g.gE('_Grafico'+g.idControlSel);
            var tituloGrafica=tabla.getAttribute('titulo');
            txtAncho=tabla.style.width.replace('px','');
            txtAlto=tabla.style.height.replace('px','');
            idAlmacenGraf=tabla.getAttribute('idAlmacen');
            var tTitulo=tabla.getAttribute('tamanoTitulo');
            var tFuente=tabla.getAttribute('tamanoFuente');
            var tLeyenda=tabla.getAttribute('tamanoLeyenda');
            var tGrafico=tabla.getAttribute('tipoGrafico');
            var propiedadesGrafico=bD(tabla.getAttribute('propiedadesGrafico'));
            
            var objGraf;
            if(propiedadesGrafico=='')
            	propiedadesGrafico='{}';
			if(propiedadesGrafico.indexOf('{')!=-1)
            {
            	objGraf=eval('['+propiedadesGrafico+']')[0];
            }
            fuente=	{
                        X:x,
                        Y:y,
                        ancho:txtAncho,
                        alto:txtAlto,
                        titulo:tituloGrafica,
                        almacenGraf:idAlmacenGraf,
                        tipoGrafico:tGrafico
                        
                    }
			
        break;
    }    
    gridPropiedades.setSource(fuente);
    gridPropiedades.getView().refresh();
    var datos=gridPropiedades.getStore();
    var posX=obtenerPosFila(datos,'name','X');
    var posY=obtenerPosFila(datos,'name','Y');
    if(posX>-1)
      	g.filaX=datos.getAt(posX);
    else
    	g.filaX=null;
  	if(posY>-1)
    	g.filaY=datos.getAt(posY);
    else
        g.filaY=null;
}

function formatearFuncionRenderer(valor)
{
	return formatearValorRenderer(arrFuncionesRenderer,valor);
}

function validarEdicion(e)
{
	if((e.record.id=='formula')||(e.record.id=='enlace'))
    	e.cancel=true;
}

function regCambiado(registro)
{
	var campo=registro.record.get('name');
	var valor=registro.value;
    var idControl=g.idControlSel;
    var accion=-1;
    var idIdioma='-1';
    var idDivSel=g.idDivSel;
	
   	switch(campo)
    {
    	case 'titulo':
    	case 'nombre': //1
        	accion=1;
        break;
        case 'ancho': //4
        	accion=4;
        break;
        case 'alto': //6
        	accion=6;
        break;
        case 'X':
        	accion=11;  //11
        break;
        case 'Y':
        	accion=12;	//12
        break;
        case 'intervalo':
        	accion=23;
        break;
       case 'estilo':
        	accion=29;
        break;
        case 'colorFondo':
        	accion=30;
        break;
        case 'colorFondo1':
        	accion=31;
        break;
        case 'colorFondo2':
        	accion=32;
        break;
        case 'vInicial':
        	accion=33;
        break;
        case 'almacenGraf':
        	accion=34;
        break;
        case 'tamTitulo':
        	accion=35;
        break;
        case 'tamFuente':
        	accion=36;
        break;
        case 'tamLeyenda':
        	accion=37;
        break;
        case 'radioGrafico':
        	accion=38;
            var tabla=g.gE('_Grafico'+g.idControlSel);
            var cadenaObj=bD(tabla.getAttribute('propiedadesGrafico'));
            valor=bE(setAtributoCadJson(cadenaObj,'pieRadio',valor));
        break;
        case 'tipoGrafico':
        	accion=39;
        break;
        case 'funcionRenderer':
        	accion=40;
        break;
        default:
            if(campo.indexOf('etiqueta')>-1)
            {
            	accion=2;
                var arrEt=campo.split('_');
                idIdioma=arrEt[1];
            }
        break;
    }
    
    function funcResp()
    {
        arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
        {
            switch(campo)
            {
            	case 'funcionRenderer':
                	var div=g.gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var ctrl=g.gE('_'+arrNomAnt[1]);
                    ctrl.setAttribute('funcRenderer',valor);
                break;
            	case 'almacenGraf':
                	g.gE('_Grafico'+idControl).setAttribute('idAlmacen',valor);
                break;
            	case 'titulo':
                   	g.gE('_Grafico'+idControl).setAttribute('titulo',valor);
                    g.gE('_Grafico'+idControl).setAttribute('propiedadesGrafico',arrResp[2]);
                    g.gE('_Grafico'+idControl).innerHTML='<label>Gr&aacute;fico: '+valor+'</label>';
                break;
                case 'nombre':
                    var nControl=generarNomControl(valor,tipoControl);
                    var div=gE(idDivSel);
                    var nomAnterior=div.getAttribute('controlInterno');
                    var arrNomAnt=nomAnterior.split('_');
                    div.setAttribute('controlInterno',nControl+'_'+tipoControl);
                    var control=g.gE('_'+arrNomAnt[1]);
                    var nombreControl='_'+arrNomAnt[1];
                    control.id=nControl;
                break;
                case 'ancho':
                    var div=g.gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var ctrl=g.gE('_'+arrNomAnt[1]);
                    
                    switch(parseInt(tipoControl))
                    {
                    	case 23:
                        	ctrl.width=valor;
						break;
                        case 25:
                        	
                        	g.gE('_secc'+idControl).style.width=valor+'px';
                        break;
                        case 31:
                        	g.gE('_Grafico'+idControl).style.width=valor+'px';
                        break;
                        default:
                        	ctrl.style.width=valor+'px';
                            ctrl.style.overflow='hidden';
                            ctrl.style.display='inline-block';
                        break;
                    }
                break;
                case 'alto':
                	var div=g.gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var ctrl=g.gE('_'+arrNomAnt[1]);
                    switch(tipoControl)
                    {
                    	case '23':
                        	ctrl.height=valor;
                        break;
                        case '25':
                        	var  filaPrincipal=g.gE('filaPrincipal_'+idControl);
                            filaPrincipal.style.height=valor+'px';
                        break;
                        case '26':
                        case '27':
                        case '28':
                        	g.gE('_lbl'+idControl).style.height=valor+'px';
                        break;
                        case '31':
                        	g.gE('_Grafico'+idControl).style.height=valor+'px';
                        break;
                    }
                    
                break;
                case 'X':
                    var div=g.gE(idDivSel);
                    div.style.left=parseInt(valor)+parseInt(g.posDivX)+'px';
                    
                    
                    
                    switch(tipoControl)
                    {
                    	case '25':
                        	g.ultimaPosX=parseInt(valor);
		                    g.ultimaPosY=parseInt(div.style.top);
        	            	g.actualizarPosicionElemento();
                        break;
                    }
                break;
                case 'Y':
                	var div=g.gE(idDivSel);
                    div.style.top=parseInt(valor)+parseInt(g.posDivY)+'px';
                break;
                case 'estilo':
                	var div=g.gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var ctrl=g.gE('_'+arrNomAnt[1]);
                    setClase(ctrl,valor);
                break;
                case 'colorFondo':
                case 'colorFondo1':
                	var div=g.gE(idDivSel);
                    div.setAttribute('colorFondo1',valor);
                    div.style.backgroundColor=valor;
                break;
                case 'colorFondo2':
                	var div=g.gE(idDivSel);
                	div.setAttribute('colorFondo2',valor);
                break;
                case 'intervalo':
                	var div=g.gE(idDivSel);
                	var nControl=div.getAttribute('controlInterno');
                	var arrNomAnt=nControl.split('_');
                	var ctrl=g.gE('_lbl'+arrNomAnt[1]);
                    ctrl.setAttribute('vIncremento',valor);
                break;
                 case 'vInicial':
                 	var div=g.gE(idDivSel);
                 	var nControl=div.getAttribute('controlInterno');
                 	var arrNomAnt=nControl.split('_');
                	var ctrl=g.gE('_'+arrNomAnt[1]);
                    ctrl.setAttribute('vInicial',valor);
                break;
                case 'tamTitulo':
                	g.gE('_Grafico'+idControl).setAttribute('tamanoTitulo',valor);
                break;
                case 'tamFuente':
                	g.gE('_Grafico'+idControl).setAttribute('tamanoFuente',valor);
                break;
                case 'tamLeyenda':
                	g.gE('_Grafico'+idControl).setAttribute('tamanoLeyenda',valor);
                break;
                case 'radioGrafico':
                	g.gE('_Grafico'+idControl).setAttribute('propiedadesGrafico',valor);
                break;
                case 'tipoGrafico':
                		g.gE('_Grafico'+idControl).setAttribute('tipoGrafico',valor);
                        g.gE('_Grafico'+idControl).setAttribute('propiedadesGrafico',arrResp[1]);
                        g.gE('_Grafico'+idControl).setAttribute('objPropiedadesGrafico',arrResp[2]);
                break;
                default:
                    if(campo.indexOf('etiqueta')>-1)
                    {
                    	var idIdiomaPag=g.gE('hLeng').value;
                        if(idIdioma==idIdiomaPag)
                        {
                        	g.gE('_lbl'+idControl).innerHTML=valor;
                            g.gE('td_'+idControl+'_'+idIdioma).value=valor;
                        }
                    }
                break;
            }
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcResp, 'POST','funcion=4&accion='+accion+'&idControl='+idControl+'&valor='+cv(''+valor)+'&idIdioma='+idIdioma,true);
}

function generarNomControl(nombre,tipoControl)
{
	var nomControl='_'+nombre;
	switch(parseInt(tipoControl))
    {
    	case 2: //pregunta cerrada-Opciones Manuales
			sufijo="vch";
		break;					
		case 3: //pregunta cerrada-Opciones intervalo
			sufijo="vch";
		break;
		case 4: //pregunta cerrada-Opciones tabla
			sufijo="vch";
		break;
		case 5: //Texto Corto
			sufijo="vch";
		break;
		case 6: //Número entero
			sufijo="int";
		break;
		case 7: //Número decimal
			sufijo="flo";
		
		break;
		case 8: //Fecha
			sufijo="dte";
		break;
		case 9://Texto Largo 
			sufijo="mem";
		
		break;
		case 10: //Texto Enriquecido
			sufijo="vch";
		break;
		case 11: //Correo Electrónico
			sufijo="vch";
		break;
		case 12: //Archivo
			sufijo="fil";
		break;
        case 14: //pregunta cerrada-Opciones Manuales
			sufijo="vch";
		break;					
		case 15: //pregunta cerrada-Opciones intervalo
			sufijo="vch";
		break;
		case 16: //pregunta cerrada-Opciones tabla
			sufijo="vch";
		break;
        case 17: //pregunta cerrada-Opciones Manuales
			sufijo="arr";
		break;					
		case 18: //pregunta cerrada-Opciones intervalo
			sufijo="arr";
		break;
		case 19: //pregunta cerrada-Opciones tabla
			sufijo="arr";
		break;
        case 20:
        	sufijo="vch";
        break;
        case 21:
        	sufijo="vch";
        break;
        case 22:
        	sufijo='flo';
        break;
        case 23:
        	sufijo='img';
        break;
        case 24:
        	sufijo='flo';
        break;
        case 26:
        	sufijo='vch';
        break;
        
    
    }
    return nomControl+sufijo;
}

function obtenerUrlReporte()
{
	var cadParametros='';
    var arrParam=eval(gE('param').value);
    var x;
    for(x=0;x<arrParam.length;x++)
    {
    	if(cadParametros=='')
        	cadParametros='&'+arrParam[x][1]+'=<VALOR PAR\xc1METRO>';
        else
        	cadParametros+='&'+arrParam[x][1]+'=<VALOR PAR\xc1METRO>';
    }
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														/*{
                                                        	x:10,
                                                            y:10,
                                                            html:'Url del reporte (Sin marco):'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:35,
                                                            xtype:'textfield',
                                                            id:'txtUrl',
                                                            width:450,
                                                            readOnly:true,
                                                            value:'<?php echo $urlSitio?>/thotReporter/thotVisor.php?r='+bE(gE('idReporte').value)+'&cPagina=sFrm=true'+cadParametros
                                                        },*/
                                                        {
                                                        	x:10,
                                                            y:10,
                                                            html:'Url del reporte:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            xtype:'textarea',
                                                            height:80,
                                                            id:'txtUrl2',
                                                            width:450,
                                                            readOnly:true,
                                                            value:'<?php echo $urlSitio?>/thotReporter/thotVisor.php?r='+bE(gE('idReporte').value)+cadParametros
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Url del reporte',
										width: 500,
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
																}
															}
												},
										buttons:	[
														
														{
															text: 'Aceptar',
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

/*function crearArbolAlmacenEliminar()
{
	var iR=gE('idReporte').value;
	var cargadorArbol=new Ext.tree.TreeLoader(
												{
													baseParams:{
																	funcion:'7',
                                                                    idReporte:iR
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
                                                  containerScroll:true,
                                                  root:raiz,
                                                  rootVisible:false,
												  loader: cargadorArbol
                                                                                                
                                               }
                                          );      
    //panelArbol.expandAll();
    panelArbol.on('click',funcClickArbol);
    return panelArbol;
}*/

/*function funcClickArbol(nodo)
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

function verParametrosReporte()
{
	var gridParametrosReporte=crearGridParametros();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gridParametrosReporte

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Par&aacute;metros del reporte',
										width: 600,
										height:350,
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
															text: 'Aceptar',
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

function crearGridParametros()
{
	var dsDatos=eval(gE('param').value);
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idParametro'},
                                                                {name: 'parametro'},
                                                                {name: 'descripcion'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														
														{
															header:'Par&aacute;metro',
															width:150,
															sortable:true,
															dataIndex:'parametro'
														},
														{
															header:'Descripci&oacute;n',
															width:300,
															sortable:true,
															dataIndex:'descripcion'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridParametros',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:10,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:550,
                                                            
                                                            tbar:	[
                                                            			{
                                                                        	text:'Agregar par&aacute;metro',
                                                                            icon:'../images/add.png',
			                                                                cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVAgrergaParam(-1);
                                                                                    }
                                                                        },
                                                                        {
                                                                        	text:'Modificar par&aacute;metro',
                                                                            icon:'../images/pencil.png',
			                                                                cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el par&aacute;metro que desea modificar');
                                                                                            return;
                                                                                        }
                                                                                    	mostrarVAgrergaParam(fila.get('idParametro'),fila);
                                                                                    }
                                                                        },
                                                                        {
                                                                        	text:'Remover par&aacute;metro',
                                                                            icon:'../images/delete.png',
			                                                                cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el par&aacute;metro que desea eliminar');
                                                                                            return;
                                                                                        }	
                                                                                        var iP=fila.get('idParametro');
                                                                                        var idReporte=gE('idReporte').value;
                                                                                        function respDel(btn)
                                                                                        {
                                                                                            function funcAjax()
                                                                                            {
                                                                                                var resp=peticion_http.responseText;
                                                                                                arrResp=resp.split('|');
                                                                                                if(arrResp[0]=='1')
                                                                                                {
                                                                                                    var arrDatos=arrResp[1];
                                                                                                    gE('param').value=arrDatos;
                                                                                                    gEx('gridParametros').getStore().loadData(eval(arrDatos));
                                                                                                    
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                }
                                                                                            }
                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=11&idReporte='+idReporte+'&idParametro='+iP,true);
                                                                            
                                                                        
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer eliminar el par&aacute;metro seleccionado?',respDel)
                                                                                    }
                                                                        }
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;
}

function mostrarVAgrergaParam(iP,fila)
{

	var textParam='';
    var textDesc='';
    if(iP!='-1')
    {
    	textParam=fila.get('parametro');
        textDesc=fila.get('descripcion');
    }
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                        	html:'Par&aacute;metro:'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            x:100,
                                                            y:5,
                                                            width:300,
                                                            id:'txtParametro',
                                                            value:textParam
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                        	html:'Descripci&oacute;n:'
                                                        },
                                                        {
                                                        	xtype:'textarea',
                                                            x:100,
                                                            y:35,
                                                            width:300,
                                                            height:100,
                                                            id:'txtDescripcion',
                                                            value:textDesc
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Registrar par&aacute;metro del reporte',
										width: 500,
										height:250,
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
                                                                	gEx('txtParametro').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var txtParametro=gEx('txtParametro');
                                                                        if(txtParametro.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtParametro.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el nombre del par&aacute;metro',resp)
                                                                        }
                                                                        var txtDescripcion=gEx('txtDescripcion').getValue();
                                                                        var idReporte=gE('idReporte').value;
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	var arrDatos=arrResp[1];
                                                                                gE('param').value=arrDatos;
                                                                                gEx('gridParametros').getStore().loadData(eval(arrDatos));
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=10&idReporte='+idReporte+'&nombre='+cv(txtParametro.getValue())+'&descripcion='+cv(txtDescripcion)+'&idParametro='+iP,true);
                                                                        
                                                                    
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

var arrValorSesion=<?php echo $arrValorSesion ?>;
var arrValorSistema=<?php echo $arrValorSistema ?>;    
var arrParametrosRep;
function mostrarVentanaAsignarParam()
{
	arrParametrosObjeto=eval(gE('param').value);
    arrParametrosRep=arrParametrosObjeto;
    var arrTipoEntrada=[['7','Consulta auxiliar'],['1','Valor Constante'],['2','Valor de par\xE1metro de reporte'],['3','Valor de sesi\xF3n'],['4','Valor de sistema']];
    var cmbTipoValor=crearComboExt('cmbTipoValor',arrTipoEntrada,140,5);
    cmbTipoValor.on('select',funcTipoEntradaChange);
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
                                                                        var almacen=nodoSel.attributes.dSetPadre;
                                                                        var param=nodoSel.attributes.nParametro;
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	if(tipo=='1')
	                                                                            	nodoSel.setText(nodoSel.attributes.nParametro+' (<b>Valor:</b> '+valorUsr+')');
                                                                                else
                                                                                	nodoSel.setText(nodoSel.attributes.nParametro+' (<b>Valor:</b> ['+valorUsr+'])');
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=16&valor='+valor+'&valorUsr='+valorUsr+'&parametro='+bE(param)+'&tipo='+tipo+'&almacen='+almacen,true);

                                                                    	
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

function funcTipoEntradaChange(combo,registro)
{
	var txtValorConstante=gEx('txtValorConstante');
    txtValorConstante.hide();
    var cmbValor=gEx('cmbValor');
    cmbValor.hide();
    var datosNodo=nodoSel.id.split('_');
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
            	if(datosNodo[1]!=nodoConsulta.childNodes[x].id)
                {
                    obj=new Array();
                    obj[0]=nodoConsulta.childNodes[x].id;
                    obj[1]='Consulta: '+nodoConsulta.childNodes[x].text;
                    arrConsultaAux.push(obj);
                }
           	}
        	cmbValor.getStore().loadData(arrConsultaAux);
        	cmbValor.show();
        break;
        
    }
}

var arrOrigenesDatos=[['1','Almac\xE9n de datos'],['2','Consulta auxiliar'],['3','Valor de par\xE1metro'],['4','Valor de funci\xF3n/C\xE1lculo']];

function mostrarVentanaVinculacionCampoEspecial()
{
	var cmbOrigenDatosCampo=crearComboExt('cmbOrigenDatosCampo',arrOrigenesDatos,240,5);
    var cmbParametros=crearComboExt('cmbParametros',arrParametrosObjeto,240,35,250);
    cmbParametros.hide();
    cmbOrigenDatosCampo.on('select',function(cmb,registro)
    								{
                                    	gEx('txtFuncion').hide();
                                        gEx('lblMostrarReferenciaCE').hide();
                                        gEx('vVincularCampo').setHeight(130);
                                        gEx('lblValor').hide();
                                        cmbParametros.hide();
                                        switch(registro.get('id'))
                                        {
                                        	case '1':
                                            break;
                                            case '2':
                                            break;
                                            case '3':
		                                        gEx('vVincularCampo').setHeight(160);
                                                gEx('lblValor').setText('Valor de par&aacute;metro a asignar:',false);
                                                gEx('lblValor').show();
                                                cmbParametros.show();
                                            break;
                                            case '4':
                                            	gEx('txtFuncion').show();
		                                        gEx('lblMostrarReferenciaCE').show();
                                                gEx('lblValor').setText('indique lLa funci&oacute;n a utilizar:',false);
                                            	gEx('vVincularCampo').setHeight(160);
                                                gEx('lblValor').show();
                                            break;
                                        }
                                        	
                                    }
    						)
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Origen del cual obtendr&aacute; el valor el campo:'
                                                        },
                                                        cmbOrigenDatosCampo,
                                                        {
                                                        	x:10,
                                                            hidden:true,
                                                            y:40,
                                                            id:'lblValor',
                                                            type:'label',
                                                            html:'Valor de par&aacute;metro a asignar:'
                                                        },
                                                        cmbParametros,
                                                        {
                                                        	x:240,
                                                            y:35,
                                                            xtype:'textfield',
                                                            readOnly:true,
                                                            hidden:true,
                                                            width:250,
                                                            id:'txtFuncion'
                                                        },
                                                        {
                                                        	xtype:'label',
                                                            y:35,
                                                            x:505,
                                                            hidden:true,
                                                            id:'lblMostrarReferenciaCE',
                                                            html:'<a href="javascript:mostrarVentanaReferenciaCampoEspecial()"><img src="../images/pencil.png"></a>'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'vVincularCampo',
										title: 'Vincular campo especial',
										width: 600,
										height:130,
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
                                                                                
                                                                            break;
                                                                            case '3':
                                                                            	var cmbParametros=gEx('cmbParametros');
                                                                                if(cmbParametros.getValue()=='')
                                                                                {
                                                                                	msgBox('Debe seleccionar el par&aacute;metro a asignar como valor del campo');
                                                                                    return;
                                                                                }
                                                                            	objFinal='{"valor":"'+cmbParametros.getRawValue()+'","valorUsr":"Parámetro: '+cmbParametros.getRawValue()+'","idPadre":"@idPadre","idReporte":"'+idReporte.value+'","pregunta":[],"tipoElemento":"28","obligatorio":"0","posX":"@posX","posY":"@posY","tipo":"3"}';
															                	g.objControl=objFinal;
                                                                            break;
                                                                            case '4':
                                                                            	var txtFuncion=gEx('txtFuncion');
                                                                                if(txtFuncion.getValue()=='')
                                                                                {
                                                                                	msgBox('Debe indicar la funci&oacute;n que ser&aacute; utilizado como origen del valor del campo');
                                                                                    return;
                                                                                }
                                                                            	objFinal='{"valor":"'+txtFuncion.idFuncion+'","valorUsr":"Función: '+cv(txtFuncion.getValue())+'","idPadre":"@idPadre","idReporte":"'+idReporte.value+'","pregunta":[],"tipoElemento":"28","obligatorio":"0","posX":"@posX","posY":"@posY","tipo":"4"}';
															                	g.objControl=objFinal;
                                                                            break;
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

function validarVinculacionAlmacen(idAlmacen,tipo,campoProy)
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

function mostrarVentanaAsignarParametro(datos,idAlmacen,tipo,campoProy)
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

function crearGridAsignaParametro(idAlmacen)
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

function asignarValorParametroAlmacen(iAlmacen,parametro,nFila)
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

function mostrarVentanaGrafico()
{
	var arrOrigenDatos=obtenerAlmacenesDatosDisponibles('3');
	var cmbTipoGrafico=crearComboExt('cmbTipoGrafico',arrGraficos,140,30);
    var cmbOrigenDatos=crearComboExt('cmbOrigenDatos',arrOrigenDatos,140,120);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														
                                                        {
                                                        	x:10,
                                                            y:35,
                                                            html:'Tipo de gr&aacute;fico:'
                                                        },
                                                        cmbTipoGrafico,
                                                        {
                                                        	x:10,
                                                            y:65,
                                                            html:'T&iacute;tulo de la gr&aacute;fica:'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            x:140,
                                                            y:60,
                                                            id:'txtTitulo',
                                                            width:350
                                                        }
                                                        ,
                                                        {
                                                        	x:10,
                                                            y:95,
                                                            html:'Ancho de la gr&aacute;fica:'
                                                        },
                                                        {
                                                        	xtype:'numberfield',
                                                            x:140,
                                                            y:90,
                                                            id:'txtAncho',
                                                            allowDecimals:false,
                                                            allowNegative:false,
                                                            value:600,
                                                            width:50
                                                        },
                                                        {
                                                        	x:240,
                                                            y:95,
                                                            html:'Alto de la gr&aacute;fica:'
                                                        },
                                                        {
                                                        	xtype:'numberfield',
                                                            allowDecimals:false,
                                                            allowNegative:false,
                                                            value:400,
                                                            x:350,
                                                            y:90,
                                                            id:'txtAlto',
                                                            width:50
                                                        },
                                                        {
                                                        	x:10,
                                                            y:125,
                                                            html:'Origen de datos:'
                                                        },
                                                        cmbOrigenDatos
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Insertar gr&aacute;fica',
										width: 550,
										height:250,
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
																		if(cmbTipoGrafico.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbTipoGrafico.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el tipo de gr&aacute;fica que desea insertar',resp);
                                                                            return;
                                                                        } 
                                                                        
                                                                        var txtTitulo=gEx('txtTitulo');
                                                                        var txtAncho=gEx('txtAncho');
                                                                        if(txtAncho.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	txtAncho.focus();
                                                                            }
                                                                        	msgBox('El valor del ancho ingresado de la gr&aacute;fica no es v&aacute;lido',resp2);
                                                                            return;
                                                                        }
                                                                        var txtAlto=gEx('txtAlto');
                                                                        if(txtAlto.getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	txtAlto.focus();
                                                                            }
                                                                        	msgBox('El valor del alto ingresado de la gr&aacute;fica no es v&aacute;lido',resp3);
                                                                            return;
                                                                        }
                                                                        var cmbOrigenDatos=gEx('cmbOrigenDatos');
                                                                        if(cmbOrigenDatos.getValue()=='')
                                                                        {
                                                                        	function resp4()
                                                                            {
                                                                            	cmbOrigenDatos.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el origen de datos con el cual se vincular&aacute; el gr&aacute;fico',resp4);
                                                                            return;
                                                                        }
                                                                       
                                                                        var tipoGrafica=cmbTipoGrafico.getValue();
                                                                        var pos=existeValorMatriz(arrGraficos,tipoGrafica)
                                                                        var categoriaGraf=arrGraficos[pos][2];
                                                                       	g.objControl='{"idAlmacen":"'+cmbOrigenDatos.getValue()+'","idPadre":"@idPadre","idReporte":"'+idReferencia+'","pregunta":null,"tipoElemento":"31","nomCampo":"","obligatorio":"0","posX":"@posX","posY":"@posY","tituloGrafico":"'+cv(txtTitulo.getValue())+'","tipoGrafico":"'+cmbTipoGrafico.getValue()+'","confCampo":{"ancho":"'+txtAncho.getValue()+'","alto":"'+txtAlto.getValue()+'"}}';
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
	ventanaAM.show();

}

function actualizarAlmacenesGraficos()
{
	gEx('cmbAlmacenGraf').getStore().loadData(obtenerAlmacenesDatosDisponibles('3'));
}

function mostrarVentanaPropiedadesGrafico()
{
	var tdGrafico=g.gE('_Grafico'+idElementoSel);
    var objConf=bD(tdGrafico.getAttribute('objPropiedadesGrafico'));
    var oConf='';
	if(objConf!='')
    {
    	oConf=eval('['+objConf+']')[0];
    }
    else
    	oConf={};

	var objConfValores=bD(tdGrafico.getAttribute('propiedadesGrafico'));

	var oConfValores={};
    if(objConfValores!='')
    	oConfValores=eval('['+objConfValores+']')[0];

	var objConf={};
    objConf.id='gPropiedades';
    objConf.x=10;
    objConf.y=20;
    objConf.ancho=380;
    objConf.alto=350;
    objConf.frame=true;
    objConf.border=true;
    objConf.afterEdit=function(e)
    					{
                        	var def=obtenerDefinicionAtributo(e.grid,e.record.data.name);
                            switch(def.tipo)
                            {
                            	case '32':
                                	e.record.set('value',normalizarValorRGB(e.value.replace("#","")));
                                break;
                            }

                        }

    var gPropiedades=crearGridPropiedades(objConf);
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gPropiedades

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Propiedades del gr&aacute;fico',
										width: 410,
										height:440,
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
																		var cadObj=obtenerValoresGrid(gPropiedades,2);
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	tdGrafico.setAttribute('propiedadesGrafico',bE(cadObj));
                                                                                establecerFuente(divCtrlSel.id);
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=56&cadObj='+cadObj+'&idGrafico='+idElementoSel,true);

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
    generarOrigenDatos(gPropiedades,oConf,oConfValores);         
}

function mostrarVentanaReferenciaCampoEspecial()
{
	asignarFuncionNuevoConceptoInyeccion=function(idConsulta,nombre)
                                            {
                                                var iConsulta=idConsulta;
                                                var r=new registroConcepto	(
                                                                                {
                                                                                    idConsulta:iConsulta,
                                                                                    nombreConsulta:nombre,
                                                                                    nombreCategoria:'',
                                                                                    descripcion:'',
                                                                                    valorRetorno:'',
                                                                                    parametros:''
                                                                                }
                                                                            )
                                                                            
                                                conceptoSeleccionadoCampoEspecial(r, gEx('vAgregarExp'));	
                                            }
    	mostrarVentanaExpresion(conceptoSeleccionadoCampoEspecial,true);
}

function conceptoSeleccionadoCampoEspecial(fila,ventana)
{
	gEx('txtFuncion').setValue(fila.get('nombreConsulta'));
    gEx('txtFuncion').idFuncion=fila.get('idConsulta');
    ventana.close();
}