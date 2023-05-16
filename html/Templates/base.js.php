<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

function funcAjax()
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
obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=',true);


/////////////////////////

function crearGridEtapas()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'numEtapa'},
                                                                    {name: 'nombreEtapa'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'No. Etapa',
															width:150,
															sortable:true,
															dataIndex:'numEtapa'
														},
														{
															header:'Etapa',
															width:300,
															sortable:true,
															dataIndex:'nombreEtapa'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            
                                                            columnLines : true,
                                                            height:260,
                                                            width:650,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar Documento',
                                                                            handler:function()
                                                                            		{
                                                                                    	
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover Documento',
                                                                            handler:function()
                                                                            		{
                                                                                    	
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;		
}


///////////////

function agregarEtapa()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
                                            cls:'panelSiugj',
											defaultType: 'label',
											items: 	[
                                            			
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: '',
										width: 500,
										height:450,
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
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
																		
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
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

/////////////////////////

function nuevo()
{
	var arrParam=[['id','<?php echo base64_encode('-1')?>']];
    enviarFormularioDatos('../contabilidad/tiposCuenta.php',arrParam);
}

function modificar(id)
{
	var arrParam=[['id',id]];
    enviarFormularioDatos('../contabilidad/tiposCuenta.php',arrParam);

}

function eliminar(id)
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
                	var fila=gE('fila_'+Base64.decode(id));
                    fila.parentNode.removeChild(fila);
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=&id='+id,true);
            
        }
    }
    msgConfirm('Est&aacute; seguro de querer eliminar el elemento seleccionado?',resp);
}


//
Ext.onReady(inicializar);

function inicializar()
{
	gE('_tituloTipovch').focus();
}

function validarFrm(frm)
{
	if(validarFormularios(frm))
    	gE(frm).submit();
}

///Estructura grid dinamico
<?php
							$consulta="SELECT a.idAlmacen,a.nombreAlmacen,a.descripcion,u.Nombre,fechaCreacion FROM 9030_almacenes a,800_usuarios u WHERE u.idUsuario=a.idUsuarioCreacion";
							$configuracion='{
												"inicializar":1,
												"confBotones":	[
																	{
																		"tipo":"A",
																		"leyenda":"Agregar",
																		"paginaEnvio":"../almacen/almacen.php",
																		"nParamID":"idAlmacen"
																	},
																	{
																		"tipo":"-"
																	},
																	{
																		"tipo":"M",
																		"leyenda":"Modificar",
																		"paginaEnvio":"../almacen/almacen.php",
																		"nParamID":"idAlmacen"
																	},
																	{
																		"tipo":"V",
																		"leyenda":"Ver ficha",
																		"paginaEnvio":"../almacen/almacen.php",
																		"nParamID":"idAlmacen"
																	},
																	{
																		"tipo":"E",
																		"leyenda":"Remover modalidad",
																		"nParamID":"idModalidad",
																		"tablaDel":"9030_almacenes",
																		"msgError":"la modalidad",
																		"tablaRef":	"'.bE('[{"tabla":"4513_instanciaPlanEstudio","campo":"idModalidad"}]').'"
																					
																	},
																	{
																		"tipo":"C",
																		"leyenda":"Obtener versi&oacute;n impresa",
																		"icono":"../images/printer.png",
																		"cuerpoFuncion":"msgBox(\'No se ha configurado un formato para documento de salida\');"
																	}
																],
												"confCampos":	[
																	{
																		"oculto":"1",
																		"campoID":"1",
																		"campo":"idAlmacen"
																	},
																	{
																		"titulo":"Nombre almacén",
																		"alineacion":"I",
																		"ancho":"150",
																		"campo":"nombreAlmacen",
																		"campoOrden":"1",
																		"direccionOrden":"ASC"	//DESC	
																	},
																	{
																		"titulo":"Descripción",
																		"alineacion":"I",
																		"ancho":"300",
																		"campo":"descripcion"	
																	}
																	,
																	{
																		"titulo":"Responsable creación",
																		"alineacion":"I",
																		"ancho":"220",
																		"campo":"Nombre"	
																	}
																	,
																	{
																		"titulo":"Fecha creación",
																		"alineacion":"I",
																		"ancho":"120",
																		"formato":"fecha",
																		"campo":"fechaCreacion"		
																	}
																]
											}';
																		
							$funTabla=crearGridDinamico($consulta,$configuracion,"tblTabla",870);
							echo $funTabla;
?>
							<table>
                            	<tr>
                                <td align="left">
                        		<span id='tblTabla'></span>
                                </td>
                            </table>							
                            
                            
//////////////////
	<?php
    if($idAlmacen==-1)
    {
    ?>
    <input type="hidden" name="_idUsuarioCreacionvch" value="<?php echo $_SESSION["idUsr"]?>" />
    <input type="hidden" name="_fechaCreaciondte" value="<?php echo date('d/m/Y')?>" />
    <input type="hidden" name="pagRedireccion" value="../almacen/almacen.php"/>
    <input type='hidden' name='reemplazarIDSesion' value="<?php echo $nConfiguracion ?>">
    <input type="hidden" name="sentenciaReemplazo" value='"idAlmacen":"-1"' />
    <input type="hidden" name="valorReemplazo" value='"idAlmacen":"idRegPadre"' />
     <input type="hidden" name="valorPost" value="" />
     <input type="hidden" name="paramPost" value='[{"nombreP":"configuracion","valorP":"<?php echo $nConfiguracion ?>"}]' />
    <?php
    }
    else
    {
    ?>
        <input type="hidden" name="pagRedireccion" value="../almacen/tblAlmacenes.php"/>	
        <input type="hidden" name="paramPost" value='[{"nombreP":"configuracion","valorP":"<?php echo $nConfRegresar?>"}]' />
    <?php
    }
    ?>
    <input type="hidden" name="tabla" value="9030_almacenes" />
    <input type="hidden" name="id" value="<?php echo $idAlmacen?>" />
    <input type="hidden" name="campoId" value="idAlmacen" />                            
    
    
    
   
   ////
  
//


 function crearGrid()
   {
       
       var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idPedido'},
		                                                {name: 'txtRazonSocial2'},
		                                                {name:'folioPedido'},
		                                                {name:'fechaRecepcion', type:'date'},
                                                        {name: 'diferencia', type:'int'},
                                                        {name: 'num_Factura'},
                                                        {name: 'fecha_entrada',type:'date'},
                                                        {name: 'Nombre'},
                                                        {name: 'observaciones'},
                                                        {name:'num_entrega'},
                                                        {name:'cond_pago'},
                                                        {name: 'txtRFC'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesAlmacen.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaRecepcion', direction: 'ASC'},
                                                            groupField: 'fechaRecepcion',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='87';
                                        proxy.baseParams.idAlmacen=gE('idAlmacen').value;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            
                                                            {
                                                                header:'Dict&aacute;men / Resultado',
                                                                width:550,
                                                                sortable:true,
                                                                dataIndex:'dictamen',
                                                                renderer:formatearDictamen
                                                            },
                                                            {
                                                                header:'Fecha comentario',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'fechaComentario',
                                                                renderer:formatearfechaColor
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridComentarios',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :false,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: true,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;	
	}

	function removerCategoriaObjetoGasto()
	{
		global $con;
		$idCategoria=$_POST["idCategoria"];

		$res=esEliminable("9101_CatalogoProducto","idProducto",$idCategoria);
		if($res=="")
		{
			eliminarElemento("9101_CatalogoProducto","idProducto",$idCategoria);
		}
		else
			return $res;
	}    
//
<script type="text/javascript" src="../Scripts/jquery.min.js"></script>
<link rel="stylesheet" href="../Scripts/fancyBox/fancybox/jquery.fancybox-1.3.4.css"  type="text/css" media="screen" />
<script type="text/javascript" src="../Scripts/fancyBox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    
<script type="text/javascript" src="../Scripts/base64.js"></script>
<script type="text/javascript" src="../Scripts/menus/js/jqsimplemenu.js"></script>
 
 <style>
	#main_content, .p15, #example_content 
	{
		padding:0px !important;
	}
</style>

//
$_POST["cPagina"]="sFrm=true";
$ctPOST=sizeof(array_values($_POST))



function funcAjax()
{
    var resp=peticion_http.responseText;
    arrResp=resp.split('|');
    if(arrResp[0]=='1')
    {
        gEx('cmbCampoTabla').reset();
        gEx('cmbCampoTabla').getStore().loadData(eval(arrResp[1]));
    }
    else
    {
        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
    }
}
obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=50&t='+bE(fila.get('nomTablaOriginal')),true);


$_POST["cPagina"]="sFrm=true";
	$ctPOST=1;
    
    
    
Ext.onReady(inicializar);

function inicializar()
{
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b></b></span>',
                                                items:	[
                                                            
                                                        ]
                                            }
                                         ]
                            }
                        )   
}

//

function regresar1Pagina()
{
	if(!ignorarRecarga)
		recargarPagina();
}

function regresar2Pagina()
{
	if(!ignorarRecarga)
		recargarPagina();
}

function recargarContenedorCentral()
{
	if(!ignorarRecarga)
		recargarPagina();
    
}

function regresar1PaginaContenedor()
{
	if(!ignorarRecarga)
		recargarPagina();
}

function regresarPagina2Contenedor()
{
	if(!ignorarRecarga)
		recargarPagina();
}

function regresarContenedorCentral()
{
	if(!ignorarRecarga)
		recargarPagina();
}


//

        var editorFila=new Ext.ux.grid.RowEditor	(
                                                        {
                                                            id:'editorFila',
                                                            saveText: 'Guardar',
                                                            cancelText:'Cancelar',
                                                            clicksToEdit:2
                                                        }
                                                    );
                                                   
        editorFila.on('beforeedit',funcEditorFilaBeforeEdicion)
        editorFila.on('validateedit',funcEditorValidaEdicion);
        editorFila.on('canceledit',funcEditorCancelEdicion);


function funcEditorFilaBeforeEdicion(rowEdit,fila)
{
	if(gE('sL').value=='1')
    	return false;
	var idGrid='gridDocumentos';
	var grid=Ext.getCmp(idGrid);
    grid.copiaRegistro=grid.getStore().getAt(fila).copy();
    grid.registroEdit=grid.getStore().getAt(fila);
	if((grid.soloLectura)&&(!grid.nuevoRegistro))
		return false;
}

function funcEditorValidaEdicion(rowEdit,obj,registro,nFila)
{
	var idGrid='gridDocumentos';
	var grid=Ext.getCmp(idGrid);
	var cm=grid.getColumnModel();
	var nColumnas=cm.getColumnCount(false);
    if(capturado)
    {
    	return;
    }
    capturado=true;
	var x;
	var editor;
	var dataIndex;
	var valor;
	for(x=0;x<nColumnas;x++)
	{
		if(cm.getColumnHeader(x).indexOf('*')!=-1)
		{
			dataIndex=cm.getDataIndex(x);
			valor=(eval('obj.'+dataIndex));
			if(valor=='')
			{
				function funcResp()
				{
					var ctrl=gEx('editor_'+dataIndex);
					ctrl.focus();
				}
				msgBox('La columna "'+cm.getColumnHeader(x).replace('*','')+'" no puede ser vac&iacute;a',funcResp);
				return false;
			}
		}	
	}
   
   	var idOperacion=registro.get('idOperacion');
    var cadObj='{"cI":"<?php echo bE($_SESSION["codigoInstitucion"])?>","idOperacion":"'+idOperacion+'","fechaOperacion":"'+
    			obj.fechaOperacion.format('Y-m-d')+'","montoOperacion":"'+obj.montoOperacion+'","tipoOperacion":"'+obj.tipoOperacion+'","concepto":"'+obj.concepto+'","comentarios":"'+obj.comentarios+'"}';
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            if(Ext.getCmp('btnRemover')!=null)
                Ext.getCmp('btnRemover').enable();	
            if(Ext.getCmp('btnAgregar')!=null)            
                Ext.getCmp('btnAgregar').enable();
            grid.nuevoRegistro=false;
            capturado=false;
            registro.set('idOperacion',arrResp[1]);
            if(idOperacion=='-1')
	            registro.set('fechaCreacion',Date.parseDate(arrResp[2],'Y-m-d H:i:s'));

            recalcularSaldo();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosProcesos.php',funcAjax, 'POST','funcion=21&cadObj='+cadObj,true);
}

function funcEditorCancelEdicion(rowEdit,cancelado)
{

	var idGrid='gridDocumentos';
	var grid=Ext.getCmp(idGrid);
	if(grid.nuevoRegistro)
		grid.getStore().removeAt(0);
	Ext.getCmp('btnRemover').enable();
    Ext.getCmp('btnAgregar').enable();
    var copiaRegistro=grid.copiaRegistro;
    
    var x=0;
    var arrCampos=grid.getStore().fields;
    var filaDestino=grid.registroEdit;

    for(x=0;x<arrCampos.items.length;x++)
    {
    	filaDestino.set(arrCampos.items[x].name,copiaRegistro.get(arrCampos.items[x].name));

    }

    
	grid.nuevoRegistro=false;
	
}