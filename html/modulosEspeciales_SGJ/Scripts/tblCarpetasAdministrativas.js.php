<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT DISTINCT anio,anio FROM 7004_seriesUnidadesGestion ORDER BY anio ASC";
	$arrCiclosCarpeta=$con->obtenerFilasArreglo($consulta);
	$anio=date("Y");
	
	$consulta="SELECT idRegistro,descripcion FROM 7014_situacionCarpetaAdministrativa";
	$arrSituacionCarpeta=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$_SESSION["codigoInstitucion"]."'";
	$arrUnidadesGestion=$con->obtenerFilasArreglo($consulta);
	if(existeRol("'52_0'"))
	{
		$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica WHERE esDespacho=1 order by nombreUnidad";
		$arrUnidadesGestion=$con->obtenerFilasArreglo($consulta);
	}
	$consulta=" SELECT DISTINCT t.idTipoCarpeta,nombreTipoCarpeta  FROM 7006_carpetasAdministrativas c,7020_tipoCarpetaAdministrativa t 
				 WHERE  c.tipoCarpetaAdministrativa=t.idTipoCarpeta and c.unidadGestion='".$_SESSION["codigoInstitucion"]."' order by prioridad";

	if(existeRol("'52_0'"))
	{
		$consulta="SELECT DISTINCT idTipoCarpeta,nombreTipoCarpeta  FROM 7020_tipoCarpetaAdministrativa t  order by prioridad";

	}
	$arrTiposCarpetas=$con->obtenerFilasArreglo($consulta);	
	$tCarpertaDefault=$con->obtenerValor($consulta);
	
	$arrRolesSL=array();

	$consulta="SELECT id__625_tablaDinamica,nombreTipoProceso FROM _625_tablaDinamica";
	$arrTipoProceso=$con->obtenerFilasArreglo($consulta);
		
	$consulta="SELECT cveEstado,estado FROM 820_estados";
	$arrEstados=$con->obtenerFilasArreglo($consulta);	
	
	$consulta="SELECT cveMunicipio,municipio FROM 821_municipios";
	$arrMuicipios=$con->obtenerFilasArreglo($consulta);		
		
?>

var arrEstados=<?php echo $arrEstados?>;
var arrMuicipios=<?php echo $arrMuicipios?>;

var arrTipoProceso=<?php echo $arrTipoProceso?>;
var tCarpertaDefault='<?php echo $tCarpertaDefault ?>';
var arrTiposCarpetas=<?php echo $arrTiposCarpetas?>;
var arrUnidadesGestion=<?php echo $arrUnidadesGestion?>;
var arrSituacionCarpeta=<?php echo $arrSituacionCarpeta ?>;
var anio='<?php echo $anio ?>';
var arrCiclosCarpeta=<?php echo $arrCiclosCarpeta?>;
Ext.onReady(inicializar);

function inicializar()
{
	var cmbUnidadGestion=crearComboExt('cmbUnidadGestion',arrUnidadesGestion,0,0,800,{listClass:"listComboSIUGJ", cls:"comboSIUGJ",fieldClass:"comboSIUGJ",ctCls:"comboWrapSIUGJ"});
    cmbUnidadGestion.setValue(arrUnidadesGestion[0][0]);
    
    var cmbTipoCarpeta=crearComboExt('cmbTipoCarpeta',arrTiposCarpetas,0,0,400,{listClass:"listComboSIUGJ", cls:"comboSIUGJ",fieldClass:"comboSIUGJ",ctCls:"comboWrapSIUGJ"});
    cmbTipoCarpeta.setValue(tCarpertaDefault);
    
    cmbUnidadGestion.on('select',recargarGrid);
    cmbTipoCarpeta.on('select',function(cmb,registro)
    							{
                                	recargarGrid();
                                }
    				);
    
    var cmbAnio=crearComboExt('cmbAnio',arrCiclosCarpeta,0,0,120,{listClass:"listComboSIUGJ", cls:"comboSIUGJ",fieldClass:"comboSIUGJ",ctCls:"comboWrapSIUGJ"});
    
    cmbAnio.setValue(anio);
    cmbAnio.on('select',recargarGrid);
    
	new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                border:false,
                                                cls:'panelSiugj',
                                                title:'Administraci&oacute;n de Procesos Judiciales',
                                                tbar:	[
                                                			{
                                                            	xtype:'tbspacer',
                                                                width:15
                                                            },
                                                			{
                                                                xtype:'label',
                                                                cls:'letraNombreTablero',
                                                                html:'<b>Despacho:</b>&nbsp;&nbsp;&nbsp;'
                                                            },
                                                            {
                                                            	xtype:'tbspacer',
                                                                width:65
                                                            },
                                                            cmbUnidadGestion
                                                            
                                                            
                                                           
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
                                                                                width:15
                                                                            },
                                                                            {
                                                                            
                                                                                xtype:'label',
                                                                                cls:'letraNombreTablero',
                                                                                html:'<b>Tipo de expediente:</b>&nbsp;&nbsp;&nbsp;'
                                                                            },
                                                                            cmbTipoCarpeta,
                                                                            {
                                                                                xtype:'tbspacer',
                                                                                width:15
                                                                            },
                                                                            {
                                                                                xtype:'label',
                                                                                cls:'letraNombreTablero',
                                                                                html:'<b>A&ntilde;o:</b>&nbsp;&nbsp;&nbsp;'
                                                                            },
                                                                            cmbAnio
                                                                			 
                                                                            
                                                                            
                                                                		],
                                                                items:	[
                                                                			crearGridCarpetasAdministrativas()
                                                                		]
                                                            }
                                                            
                                                        ]
                                            }
                                         ]
                            }
                        )   


}

function crearGridCarpetasAdministrativas()
{
	
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'carpetaAdministrativa'},
		                                                {name: 'situacion'},                                                        
                                                        {name: 'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'demandados'},
                                                        {name: 'demandantes'},
                                                        {name: 'idCarpetaAdministrativa'},
                                                        {name: 'tituloProceso'},
                                                        {name: 'tipoProceso'},
                                                        {name: 'departamento'},
                                                        {name: 'municipio'},
                                                        {name: 'idFormulario'},
                                                        {name: 'idRegistro'}
                                                        
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                              reader: lector,
                                              proxy : new Ext.data.HttpProxy	(
                                                                                    {
                                                                                        url: '../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php'
                                                                                        
                                                                                    }
                                                                                ),
                                              sortInfo: {field: 'carpetaAdministrativa', direction: 'ASC'},
                                              groupField: 'carpetaAdministrativa',
                                              remoteGroup:false,
                                              remoteSort: true,
                                              autoLoad:false                                              
                                          }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	
                                        proxy.baseParams.funcion='3';
                                        proxy.baseParams.uG=gEx('cmbUnidadGestion').getValue();
                                        proxy.baseParams.anio=gEx('cmbAnio').getValue();
                                        proxy.baseParams.tC=gEx('cmbTipoCarpeta').getValue();
                                        
                                    }
                        )   
       
       
       
	var paginador=	new Ext.PagingToolbar	(
                                              {
                                                    pageSize: 200,
                                                    id:'paginadorGrid',
                                                    store: alDatos,
                                                    displayInfo: true,
                                                    disabled:false
                                                }
                                             )            
       
       var filters = new Ext.ux.grid.GridFilters	(
                                                        {
                                                            filters:	[
                                                            				{
                                                                            	type:'string',
                                                                                dataIndex:'carpetaAdministrativa'
                                                                            },
                                                                           {
                                                                            	type:'list',
                                                                                dataIndex:'tipoProceso',
                                                                                options:arrTipoProceso,
                                                                                phpMode:true
                                                                            },
                                                                           
                                                                            
                                                                            {
                                                                            	type:'list',
                                                                                dataIndex:'situacion',
                                                                                options:arrSituacionCarpeta,
                                                                                phpMode:true
                                                                            }
                                                            			]
                                                        }
                                                    );         
       
       var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:false,width:40});       
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:50,idGridPaginacion:'paginadorGrid'}),
                                                            chkRow,
                                                            
                                                            
                                                            
                                                            {
                                                                header:'C&oacute;digo &Uacute;nico de Proceso',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa',
                                                                renderer:function(val,meta,registro)
                                                                			{
                                                                            	return '<a href="javascript:abrirPanelAdministracionCarpeta(\''+bE(val)+'\',\''+bE(registro.data.situacion=='1'?'0':1)+'\')">'+val+'</a>';
                                                                            }
                                                            },
                                                           
                                                            {
                                                                header:'Fecha Creaci&oacute;n',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'fechaCreacion',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	if(val)
                                                                        	return val.format('d/m/Y H:i:s');
                                                                    }
                                                            },
                                                           
                                                            {
                                                                header:'L&iacute;nea de Tiempo',
                                                                width:160,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	if(val.indexOf('-EX')==-1)
                                                                        {
                                                                        	return '<a href="javascript:visualizarTimeLine(\''+bE(val)+'\')"><img src="../principalPortal/imagesSIUGJ/magnifier.png" /> Ver</a>';
                                                                        }
                                                                    }
                                                            },                                                           
                                                            
                                                            {
                                                                header:'Situaci&oacute;n carpeta',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                renderer:function(val)
                                                                	{
                                                                    	return formatearValorRenderer(arrSituacionCarpeta,val);
                                                                    }
                                                            },
                                                           {
                                                                header:'T&iacute;tulo del Proceso',
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'tituloProceso',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	
                                                                    	return val;
                                                                    }
                                                            },
                                                            {
                                                                header:'Tipo de Proceso',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'tipoProceso',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	
                                                                    	return formatearValorRenderer(arrTipoProceso,val);
                                                                    }
                                                            },
                                                            {
                                                                header:'Demandado',
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'demandados',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	
                                                                    	return val;
                                                                    }
                                                            },
                                                            {
                                                                header:'Demandante',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'demandantes',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	
                                                                    	return val;
                                                                    }
                                                            },
                                                            {
                                                                header:'Departamento',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'departamento',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	
                                                                    	return formatearValorRenderer(arrEstados,val);
                                                                    }
                                                            },
                                                            {
                                                                header:'Municipio',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'municipio',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	
                                                                    	return formatearValorRenderer(arrMuicipios,val);
                                                                        
                                                                        
                                                                    }
                                                            }
                                                           
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'dCarpetas',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                bbar:[paginador],
                                                                sm:chkRow,
                                                                cls:'gridSiugjPrincipal',
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                columnLines : false,      
                                                                plugins:	[filters]

                                                                
                                                               
                                                            }
                                                        );
        
        
       
       

	tblGrid.getStore().load(	{
    								params:	{
                                    			url:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                                                start:0, 
                                                limit:200
                                                
                                    		}
    							}
                           )       
        return 	tblGrid;
}


function recargarContenedorCentral()
{
	recargarGrid();
}

function recargarGrid()
{
	gEx('dCarpetas').getStore().reload();
}



function abrirPanelAdministracionCarpeta(cA,sL)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJ/tableroAudienciaAdministracion.php';
    obj.params=[['cA',cA],['sL',bD(sL)]];
    <?php

    foreach($arrRolesSL as $idRol=>$rol)
	{
		if(existeRol("'".$rol."'"))
		{
			echo "obj.params.push(['sL',1]);";
        }
    }
	?>
    window.parent.abrirVentanaFancy(obj);
    
}

function visualizarTimeLine(cA)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.openEffect='fade';
    obj.url='../modulosEspeciales_SGJ/frameHistorialCarpetaJudicial.php';
    obj.params=[['cA',cA],['cPagina','sFrm=true']];
    obj.titulo='L&iacute;nea de Tiempo, Proceso Judicial: '+bD(cA);
    window.parent.abrirVentanaFancy(obj);
}


function abrirProcesoOrigen(iF,iR)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=[['idFormulario',bD(iF)],['idRegistro',bD(iR)],['actor',bE(0)],['dComp',bE('auto')]];
    window.parent.abrirVentanaFancy(obj);
    
    
}
