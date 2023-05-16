<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT DISTINCT anio,anio FROM 7004_seriesUnidadesGestion ORDER BY anio ASC";
	$arrCiclosCarpeta=$con->obtenerFilasArreglo($consulta);
	$anio=date("Y");
	
	$consulta="SELECT idRegistro,descripcion FROM 7014_situacionCarpetaAdministrativa";
	$arrSituacionCarpeta=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idEtapaProcesal,descripcionEtapa FROM 7009_etapasProcesales where idEtapaProcesal<>7";
	$arrEtapaProcesal=$con->obtenerFilasArreglo($consulta);
	$arrRolesUgas[0]="1_0";
	$arrRolesUgas[1]="90_0";
	$arrRolesUgas[2]="112_0";
	$comp="";
	$comp2="";
	
	$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica WHERE cmbCategoria in(1,2) ".$comp." ORDER BY prioridad";

	$arrUnidadesGestion=$con->obtenerFilasArreglo($consulta);
	$consulta=" SELECT DISTINCT t.idTipoCarpeta,nombreTipoCarpeta  FROM 7006_carpetasAdministrativas c,7020_tipoCarpetaAdministrativa t 
				 WHERE ".$comp2." c.tipoCarpetaAdministrativa=t.idTipoCarpeta and t.idTipoCarpeta in(1,5,6) order by prioridad";
	$arrTiposCarpetas=$con->obtenerFilasArreglo($consulta);
	
	$tCarpertaDefault=$con->obtenerValor($consulta);
	
?>

var tCarpertaDefault='<?php echo $tCarpertaDefault ?>';
var arrTiposCarpetas=<?php echo $arrTiposCarpetas?>;
var arrUnidadesGestion=<?php echo $arrUnidadesGestion?>;
var arrEtapaProcesal=<?php echo $arrEtapaProcesal ?>;
var arrSituacionCarpeta=<?php echo $arrSituacionCarpeta ?>;
var anio='<?php echo $anio ?>';
var arrCiclosCarpeta=<?php echo $arrCiclosCarpeta?>;
Ext.onReady(inicializar);

function inicializar()
{
	var cmbUnidadGestion=crearComboExt('cmbUnidadGestion',arrUnidadesGestion,0,0,400);
    cmbUnidadGestion.setValue(arrUnidadesGestion[0][0]);
    
    var cmbTipoCarpeta=crearComboExt('cmbTipoCarpeta',arrTiposCarpetas,0,0,250);
    cmbTipoCarpeta.setValue(tCarpertaDefault);
    
    cmbUnidadGestion.on('select',recargarGrid);
    cmbTipoCarpeta.on('select',function(cmb,registro)
    							{
                                	
                                	recargarGrid();
                                }
    				);
    
    
	new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                tbar:	[
                                                			{
                                                                xtype:'label',
                                                                html:'<b>Unidad de Gesti&oacute;n Judicial:</b>&nbsp;&nbsp;&nbsp;'
                                                            },cmbUnidadGestion,
                                                            '-',
                                                            {
                                                            
                                                                xtype:'label',
                                                                html:'<b>Tipo de carpeta:</b>&nbsp;&nbsp;&nbsp;'
                                                            },
                                                            cmbTipoCarpeta
                                                           
                                                		],
                                                items:	[
                                                            crearGridCarpetasAdministrativas()
                                                        ]
                                            }
                                         ]
                            }
                        )   

	
}

function crearGridCarpetasAdministrativas()
{
	var cmbAnio=crearComboExt('cmbAnio',arrCiclosCarpeta,0,0,120);
    
    cmbAnio.setValue(anio);
    cmbAnio.on('select',recargarGrid);
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                            			{name: 'idCarpeta'},
                                               			{name: 'carpetaAdministrativa'},
		                                                {name: 'situacion'},
                                                        {name: 'carpetaBase'},
                                                        {name: 'etapaProcesal'},
                                                        {name: 'victimas'},
                                                        {name: 'imputados'},
                                                        {name: 'delitos'},
                                                        {name: 'carpetaInvestigacion'},
                                                        {name: 'carpetasDerivadas'},
                                                        {name: 'carpetaOralidad'},
                                                        {name: 'carpetaEjecucion'},
                                                        {name: 'fechaAcusacion'},
                                                        {name: 'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'cierreInvestigacion', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'fechaVinculacion', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'fechaAcusacion', type:'date', dateFormat:'Y-m-d H:i:s'}
                                                        
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                              reader: lector,
                                              proxy : new Ext.data.HttpProxy	(
                                                                                    {
                                                                                        url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'
                                                                                        
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
                                    	
                                        
                                          
                                            
                                    	proxy.baseParams.funcion='218';
                                        proxy.baseParams.uG=gEx('cmbUnidadGestion').getValue();
                                        proxy.baseParams.anio=cmbAnio.getValue();
                                        proxy.baseParams.tC=gEx('cmbTipoCarpeta').getValue();
                                        
                                    }
                        )   
       
       
       
	var paginador=	new Ext.PagingToolbar	(
                                              {
                                                    pageSize: 100,
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
                                                                                dataIndex:'etapaProcesal',
                                                                                options:arrEtapaProcesal,
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
       
       var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});       
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            chkRow,
                                                            
                                                            {
                                                                header:'Carpeta Judicial',
                                                                width:170,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa',
                                                                renderer:function(val)
                                                                			{
                                                                            	return '<a href="javascript:abrirPanelAdministracionCarpeta(\''+bE(val)+'\')">'+val+'</a>';
                                                                            }
                                                            },
                                                            {
                                                                header:'Carpeta Origen',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'carpetaBase',
                                                                renderer:function(val)
                                                                			{
                                                                            	return val;
                                                                            }
                                                            },
                                                            {
                                                                header:'Carpetas derivadas',
                                                                width:210,
                                                                sortable:true,
                                                                dataIndex:'carpetasDerivadas',
                                                                renderer:mostrarValorDescripcion
                                                            },                                                       
                                                            {
                                                                header:'Fecha creaci&oacute;n',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'fechaCreacion',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	if(val)
                                                                        	return val.format('d/m/Y H:i:s');
                                                                    }
                                                            },
                                                           /* {
                                                                header:'Time Line',
                                                                width:70,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	if(val.indexOf('-EX')==-1)
                                                                        {
                                                                        	return '<a href="javascript:visualizarTimeLine(\''+bE(val)+'\')"><img src="../images/magnifier.png" /> Ver</a>';
                                                                        }
                                                                    }
                                                            }, */
                                                            {
                                                                header:'Etapa procesal',
                                                                width:230,
                                                                sortable:true,
                                                                dataIndex:'etapaProcesal',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	return formatearValorRenderer(arrEtapaProcesal,val);
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
                                                                header:'Carpeta de Investigaci&oacute;n',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'carpetaInvestigacion',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	return val;
                                                                    }
                                                            },
                                                            {
                                                                header:'Carpeta de Tribunal de Enjuiciamiento',
                                                                width:230,
                                                                sortable:true,
                                                                dataIndex:'carpetaOralidad',
                                                                renderer:function(val)
                                                                		{
                                                                        	var arrCarpetas=val.split(',');
                                                                            var carpetas='';
                                                                            var x;
                                                                            var l;
                                                                            for(x=0;x<arrCarpetas.length;x++)
                                                                            {
                                                                            	l='<a href="javascript:abrirPanelAdministracionCarpeta(\''+bE(arrCarpetas[x])+'\')">'+arrCarpetas[x]+'</a>';
                                                                                if(carpetas=='')
                                                                                	carpetas=l;
                                                                                else
                                                                                	carpetas+=', '+l;
                                                                            }
                                                                            return carpetas;
                                                                        }
                                                            },
                                                            {
                                                                header:'Carpeta de Ejecuci&oacute;n',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'carpetaEjecucion',
                                                                renderer:function(val)
                                                                		{
                                                                        	var arrCarpetas=val.split(',');
                                                                            var carpetas='';
                                                                            var x;
                                                                            var l;
                                                                            for(x=0;x<arrCarpetas.length;x++)
                                                                            {
                                                                            	l='<a href="javascript:abrirPanelAdministracionCarpeta(\''+bE(arrCarpetas[x])+'\')">'+arrCarpetas[x]+'</a>';
                                                                                if(carpetas=='')
                                                                                	carpetas=l;
                                                                                else
                                                                                	carpetas+=', '+l;
                                                                            }
                                                                            return carpetas;
                                                                        }
                                                            },
                                                            {
                                                                header:'Imputados',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'imputados',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	
                                                                    	return val;
                                                                    }
                                                            },
                                                            {
                                                                header:'V&iacute;ctimas',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'victimas',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	
                                                                    	return val;
                                                                    }
                                                            },
                                                            {
                                                                header:'Delitos',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'delitos',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	
                                                                    	return mostrarValorDescripcion(val);
                                                                    }
                                                            },
                                                            {
                                                                header:'Cierre de investigaci&oacute;n',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'cierreInvestigacion',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	if(val && val.format)
                                                                        	return val.format('d/m/Y')
                                                                    	return val;
                                                                    }
                                                            },
                                                             {
                                                                header:'Fecha de acusaci&oacute;n',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'fechaAcusacion',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	if(val && val.format)
                                                                        	return val.format('d/m/Y')
                                                                    	return val;
                                                                    }
                                                            },
                                                            {
                                                                header:'Fecha de vinculaci&oacute;n<br />a proceso',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'fechaVinculacion',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	if(val && val.format)
	                                                                    	return val.format('d/m/Y');
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
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                columnLines : true,      
                                                                plugins:	[filters],
                                                                tbar:	[
                                                                			 {
                                                                                xtype:'label',
                                                                                html:'<b>A&ntilde;o:</b>&nbsp;&nbsp;&nbsp;'
                                                                            },
                                                                            cmbAnio,'-'
                                                                            
                                                                		],
                                                                view:new Ext.ux.grid.BufferView({
                                                                                                    // custom row height
                                                                                                    rowHeight: 29,
                                                                                                    // render rows as they come into viewable area.
                                                                                                    scrollDelay: false
                                                                                                })
                                                            }
                                                        );
        
        
        tblGrid.getSelectionModel().on('rowselect',function(sm,nFila,registro)
        											{
                                                    	
                                                    }
        								)
        
       tblGrid.getSelectionModel().on('rowdeselect',function(sm,nFila,registro)
        											{
                                                    	
                                                    }
                                      )
       

	tblGrid.getStore().load(	{
    								params:	{
                                    			url:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                                                start:0, 
                                                limit:100
                                                
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

function registrarRemisionCarpetaJudicial()
{
	var dCarpetas=gEx('dCarpetas');
    var fila=dCarpetas.getSelectionModel().getSelected();
    
    if(!fila)
    {
    	msgBox('Debe seleccionar la carpeta judicial sobre la cual desea realizar la operaci&oacute;n');
    	return;
    }
    
    var carpetaAdministrativa=fila.data.carpetaAdministrativa;
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var obj={};    
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[['carpetaAdministrativa',carpetaAdministrativa],['idFormulario',307],['idRegistro',arrResp[1]],['idReferencia',-1],
            		['dComp',arrResp[2]],['actor',arrResp[3]]];
            window.parent.abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=51&cA='+carpetaAdministrativa,true);
}

function registrarRemisionCarpetaJudicialUnidadGestion()
{
	var dCarpetas=gEx('dCarpetas');
    var fila=dCarpetas.getSelectionModel().getSelected();
    
    if(!fila)
    {
    	msgBox('Debe seleccionar la carpeta judicial sobre la cual desea realizar la operaci&oacute;n');
    	return;
    }
    
    var carpetaAdministrativa=fila.data.carpetaAdministrativa;
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var obj={};    
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[['carpetaAdministrativa',carpetaAdministrativa],['idFormulario',329],['idRegistro',arrResp[1]],['idReferencia',-1],
            		['dComp',arrResp[2]],['actor',arrResp[3]]];
            window.parent.abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=70&cA='+carpetaAdministrativa,true);
}


function registrarRemisionCarpetaTribunal()
{
	var dCarpetas=gEx('dCarpetas');
    var fila=dCarpetas.getSelectionModel().getSelected();
    
    if(!fila)
    {
    	msgBox('Debe seleccionar la carpeta judicial sobre la cual desea realizar la operaci&oacute;n');
    	return;
    }
    
    var carpetaAdministrativa=fila.data.carpetaAdministrativa;
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var obj={};    
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[['carpetaAdministrativa',carpetaAdministrativa],['idFormulario',320],['idRegistro',arrResp[1]],['idReferencia',-1],
            		['dComp',arrResp[2]],['actor',arrResp[3]]];
            window.parent.abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=72&cA='+carpetaAdministrativa,true);
}

function registrarRemisionCarpetaEjecucion()
{
	var dCarpetas=gEx('dCarpetas');
    var fila=dCarpetas.getSelectionModel().getSelected();
    
    if(!fila)
    {
    	msgBox('Debe seleccionar la carpeta judicial sobre la cual desea realizar la operaci&oacute;n');
    	return;
    }
    
    var carpetaAdministrativa=fila.data.carpetaAdministrativa;
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var obj={};    
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[['carpetaAdministrativa',carpetaAdministrativa],['idFormulario',316],['idRegistro',arrResp[1]],['idReferencia',-1],
            		['dComp',arrResp[2]],['actor',arrResp[3]]];
            window.parent.abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=73&cA='+carpetaAdministrativa,true);
}

function registrarRemisionCarpetaEjecucionV2()
{
	var dCarpetas=gEx('dCarpetas');
    var fila=dCarpetas.getSelectionModel().getSelected();
    
    if(!fila)
    {
    	msgBox('Debe seleccionar la carpeta judicial sobre la cual desea realizar la operaci&oacute;n');
    	return;
    }
    
    var carpetaAdministrativa=fila.data.carpetaAdministrativa;
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var obj={};    
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[['carpetaAdministrativa',carpetaAdministrativa],['idFormulario',385],['idRegistro',arrResp[1]],['idReferencia',-1],
            		['dComp',arrResp[2]],['actor',arrResp[3]]];
            window.parent.abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=112&cA='+carpetaAdministrativa,true);
}


function abrirPanelAdministracionCarpeta(cA)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/tableroAudienciaAdministracionMedidasCautelares.php';
    obj.params=[['cA',cA]];
    obj.titulo='Carpeta Judicial: '+bD(cA);
    window.parent.abrirVentanaFancy(obj);
    
}

function visualizarTimeLine(cA)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.openEffect='fade';
    obj.url='../modulosEspeciales_SGJP/historialCarpetaJudicial.php';
    obj.params=[['cA',cA],['cPagina','sFrm=true']];
    obj.titulo='Time Line, Carpeta Judicial: '+bD(cA);
    window.parent.abrirVentanaFancy(obj);
}

function registrarRemisionCarpetaJudicialUnidadGestionZonaTerritorial()
{
	var dCarpetas=gEx('dCarpetas');
    var fila=dCarpetas.getSelectionModel().getSelected();
    
    if(!fila)
    {
    	msgBox('Debe seleccionar la carpeta judicial sobre la cual desea realizar la operaci&oacute;n');
    	return;
    }
    
    var carpetaAdministrativa=fila.data.carpetaAdministrativa;
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var obj={};    
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[['carpetaAdministrativa',carpetaAdministrativa],['idFormulario',382],['idRegistro',arrResp[1]],['idReferencia',-1],
            		['dComp',arrResp[2]],['actor',arrResp[3]]];
            window.parent.abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=70&iFormulario=382&cA='+carpetaAdministrativa,true);
}


function abrirDatosEnvioEjecucion(iR)
{
	var obj={};    
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=[['idFormulario',385],['idRegistro',bD(iR)],['idReferencia',-1],
            ['dComp',bE('auto')],['actor',bE(0)]];
    window.parent.abrirVentanaFancy(obj);
}

function registrarRemisionCarpetaEjecucionPP()
{
	var dCarpetas=gEx('dCarpetas');
    var fila=dCarpetas.getSelectionModel().getSelected();
    
    if(!fila)
    {
    	msgBox('Debe seleccionar la carpeta judicial sobre la cual desea realizar la operaci&oacute;n');
    	return;
    }
    
    var carpetaAdministrativa=fila.data.carpetaAdministrativa;
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var obj={};    
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[['carpetaAdministrativa',carpetaAdministrativa],['idFormulario',491],['idRegistro',arrResp[1]],['idReferencia',-1],
            		['dComp',arrResp[2]],['actor',arrResp[3]],['idUnidadOrigen',arrResp[4]]];
            window.parent.abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=199&cA='+carpetaAdministrativa,true);
}
