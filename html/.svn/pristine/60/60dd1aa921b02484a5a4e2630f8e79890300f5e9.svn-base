<?php
	session_start();

	include("conexionBD.php");

	$consulta="SELECT min(fechaEstimadaEstado) FROM _1256_tablaDinamica WHERE idEstado=3";
	$minFecha=$con->obtenerValor($consulta);
	$consulta="SELECT max(fechaEstimadaEstado) FROM _1256_tablaDinamica WHERE idEstado=3";
	$maxFecha=$con->obtenerValor($consulta);
	
	$minAnio=date("Y");
	$maxAnio=date("Y");
	if($minAnio!="")
	{
		$minAnio=date("Y",strtotime($minFecha));
		$maxAnio=date("Y",strtotime($maxFecha));
	}
	
	if($maxAnio<date("Y"))
	{
		$maxAnio=date("Y");
	}
	
	$arrAnios="";
	for($anio=$minAnio;$anio<=$maxAnio;$anio++)
	{
		$o="['".$anio."','".$anio."']";
		if($arrAnios=="")
			$arrAnios=$o;
		else
			$arrAnios.=",".$o;
	}
	
	$arrAnios="[".$arrAnios."]";
	

?>
var codigoInstitucionSel='';
var arrAnios=<?php echo $arrAnios ?>;
Ext.onReady(inicializar);

function inicializar()
{
	var cmbTipoPublicacion=crearComboExt('cmbTipoPublicacion',[['1','Estado electr\xf3nico'],['2','Edictos']],0,0,200,{transform:false,ctCls:'comboWrapSIUGJ',cls:'comboSIUGJ',listClass:'listComboSIUGJ'});
	cmbTipoPublicacion.setValue('1');
    cmbTipoPublicacion.on('select',function()
                                    {
                                        gEx('arbolPublicaciones').getRootNode().reload();
                                    }
                        )

	var cmbAnio=crearComboExt('cmbAnio',arrAnios,0,0,140,{transform:false,ctCls:'comboWrapSIUGJ',cls:'comboSIUGJ',listClass:'listComboSIUGJ'});
	cmbAnio.setValue('<?php echo date("Y")?>');
    cmbAnio.on('select',function()
    					{
                        	gEx('arbolPublicaciones').getRootNode().reload();
                        }
    			)



	var oConf=	{
                            idCombo:'cmbDespacho',
                            anchoCombo:850,
                            raiz:'registros',
                            campoDesplegar:'despacho',
                            campoID:'codigoUnidad',
                            funcionBusqueda:19,
                            listClass:"listComboSIUGJ", 
                            cls:"comboSIUGJ",
                            emptyText:'Ingrese el nombre del despacho',
                            ctCls:"comboWrapSIUGJ",
                            paginaProcesamiento:'../modulosEspeciales_SIUGJ/paginasFunciones/funcionesScriptsFormularios.php',
                            confVista:'<tpl for="."><div class="search-item">{despacho}<br></div></tpl>',
                            campos:	[
                                        {name:'despacho'},
                                        {name:'codigoUnidad'}
    
                                    ],
                            funcAntesCarga:function(dSet,combo)
                                        {
                                            codigoInstitucionSel='';                                            
                                            var aValor=combo.getRawValue();
                                            dSet.baseParams.criterio=aValor;

                                            
                                            
                                            
                                        },
                            funcElementoSel:function(combo,registro)
                                        {
                                            codigoInstitucionSel=registro.data.codigoUnidad;
                                            gEx('arbolPublicaciones').getRootNode().reload();
                                            
                                        }  
                        };
                
	var cmbDespacho=crearComboExtAutocompletar(oConf);                	
                
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                			{
                                            	xtype:'panel',
                                                region:'center',
                                                cls:'panelSiugj',
                                                layout:'border',
                                                border:false,
                                                title: 'Publicaciones',
                                            	tbar:	[
                                                            {
                                                                xtype:'tbspacer',
                                                                width:20
                                                            },
                                                            {
                                                                xtype:'label',
                                                                cls:'SIUGJ_Etiqueta',
                                                                html:'Despacho:'
                                                            },
                                                            {
                                                                xtype:'tbspacer',
                                                                width:100
                                                            },
                                                            cmbDespacho
                                                        ],
                                            	items:	[
                                                			{
                                                                xtype:'panel',
                                                                region:'center',
                                                                layout:'border',
                                                                border:false,
                                                                cls:'panelSiugj',
                                                                tbar:	[
                                                                            {
                                                                                xtype:'tbspacer',
                                                                                width:20
                                                                            },
                                                                            {
                                                                                xtype:'label',
                                                                                cls:'SIUGJ_Etiqueta',
                                                                                html:'Tipo de publicaci&oacute;n:'
                                                                            },
                                                                            {
                                                                                xtype:'tbspacer',
                                                                                width:20
                                                                            },
                                                                            cmbTipoPublicacion,
                                                                            {
                                                                                xtype:'tbspacer',
                                                                                width:20
                                                                            },
                                                                            {
                                                                                xtype:'label',
                                                                                cls:'SIUGJ_Etiqueta',
                                                                                html:'A&ntilde;o de publicaci&oacute;n:'
                                                                            },
                                                                            {
                                                                                xtype:'tbspacer',
                                                                                width:20
                                                                            },
                                                                            cmbAnio
                                                                                            
                                                                         ],
                                                                items:	[
                                                                            {
                                                                                region:'west',
                                                                                border:false,
                                                                                width:250,
                                                                                
                                                                                items:	[
                                                                                            crearArbolPublicaciones()
                                                                                        ]
                                                                            } ,
                                                                            {
                                                                                region:'center',
                                                                                border:false,
                                                                                layout:'border',
                                                                                items:	[
                                                                                            crearGridPublicaciones()
                                                                                        ]
                                                                            } 
                                                                        ]
                                                            }
                                                		]
                                            }
                                            
                                            
                                         ]
                            }
                        )   
                        
                        
	cmbDespacho.focus();                        
}



function crearArbolPublicaciones()
{
	var raiz=new  Ext.tree.AsyncTreeNode(
											{
												id:'-1',
												text:'Raiz',
												draggable:false,
												expanded :false,
												cls:'-1'
											}
										)
										
	var cargadorArbol=new Ext.tree.TreeLoader(
                                                {
                                                    baseParams:{
                                                                    funcion:'15'
                                                                },
                                                    dataUrl:'../modulosEspeciales_SIUGJ/paginasFunciones/funcionesScriptsFormularios.php'
                                                }
                                            )		
										
	
    cargadorArbol.on('beforeload',function(proxy,raiz)
    						{
                            	proxy.baseParams.anio=gEx('cmbAnio').getValue();
                            	proxy.baseParams.codigoInstitucion=codigoInstitucionSel;
                            	proxy.baseParams.tipoPublicacion=gEx('cmbTipoPublicacion').getValue();
                            }
    				)
    
    cargadorArbol.on('load',function(l,raiz)
    						{
								setTimeout(function()
                                {    
                                	var nodoID= ('m_'+('<?php echo date("Y")?>'==gEx('cmbAnio').getValue()?'<?php echo date('m')*1?>':'1')) ;  
                                	var nodoCarpetaSel=buscarNodoID(gEx('arbolPublicaciones').getRootNode(),nodoID);                                                                                               								
                                    nodoCarpetaSel.select();
                                    nodoClick(nodoCarpetaSel);
                                },500
                              )
                            }
    				)
    											
										
	var arbolPublicaciones=new Ext.tree.TreePanel	(
                                                            {
                                                                
                                                                id:'arbolPublicaciones',
                                                                region:'center',
                                                                useArrows:true,
                                                                animate:true,
                                                                width:300,
                                                                containerScroll: true,
                                                                autoScroll:true,
                                                                border:false,
                                                                root:raiz,
                                                                loader: cargadorArbol,
                                                                rootVisible:false
                                                            }
                                                        )
         
         
                                                    
	arbolPublicaciones.on('click',nodoClick);	                                                    
                                                    
	return  arbolPublicaciones;
        
       
}

function nodoClick(nodo)
{
	nodoSel=nodo;
    gEx('gridPublicaciones').getStore().load	(
    												{
                                                    	url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesScriptsFormularios.php',
                                                        params:	{
                                                        			funcion:'18',
                                                                    anio:gEx('cmbAnio').getValue(),
                                                                    mes:nodoSel.id.replace('m_',''),
                                                                    tipoPublicacion:gEx('cmbTipoPublicacion').getValue(),
                                                                    codigoInstitucion:codigoInstitucionSel
                                                        		}
                                                    }
    											);
    
	
}


function crearGridPublicaciones()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'noEstado'},
                                                        {name: 'idDocumento'},
                                                        {name: 'totalProvidencias'},
		                                                {name:'fechaEstado', type:'date',dateFormat:'Y-m-d'}
                                                        
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesScriptsFormularios.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaEstado', direction: 'ASC'},
                                                            groupField: 'fechaEstado',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='18';
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [

                                                            {
                                                                header:'',
                                                                width:120,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'idDocumento',
                                                                renderer:function(val)
                                                                		{
                                                                        	return '<a href="javascript:mostrarPublicacion(\''+bE(val)+'\')"><img src="../imagenesDocumentos/16/file_extension_pdf.png" /> Ver</a>'
                                                                        }
                                                            },
                                                            {
                                                                header:'No. de estado',
                                                                width:150,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'noEstado'
                                                            },
                                                            {
                                                                header:'Fecha de estado',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'fechaEstado',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y');
                                                                        }
                                                            },
                                                            {
                                                                header:'Total providencias',
                                                                width:180,
                                                                sortable:true,
                                                                align:'center',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	
                                                                        	
                                                                            return val;
                                                                        },
                                                                dataIndex:'totalProvidencias'
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridPublicaciones',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                cls:'gridSiugjPrincipal',
                                                                columnLines : false,                                                                
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :true,
                                                                                                    enableNoGroups:true,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: true,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;	
}


function mostrarPublicacion(iP)
{

    mostrarVisorDocumentoProceso('pdf',bD(iP));
}