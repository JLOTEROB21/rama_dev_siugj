<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT DISTINCT anio,anio FROM 7004_seriesUnidadesGestion ORDER BY anio ASC";
	$arrCiclosCarpeta=$con->obtenerFilasArreglo($consulta);
	$anio=date("Y");
	
	$consulta="SELECT idRegistro,descripcion FROM 7014_situacionCarpetaAdministrativa";
	$arrSituacionCarpeta=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idEtapaProcesal,descripcionEtapa FROM 7009_etapasProcesales";
	$arrEtapaProcesal=$con->obtenerFilasArreglo($consulta);
	$arrRolesUgas[0]="1_0";
	$arrRolesUgas[1]="90_0";
	$arrRolesUgas[2]="112_0";
	$comp=" and claveUnidad='".$_SESSION["codigoInstitucion"]."'";
	$comp2=" c.unidadGestion='".$_SESSION["codigoInstitucion"]."' and ";
	foreach($arrRolesUgas as $idRol=>$rol)
	{
		if(existeRol("'".$rol."'"))
		{
			$comp="";
			$comp2="";
			break;
		}
	}
	
	$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica WHERE cmbCategoria in(1,2) ".$comp." ORDER BY prioridad";
	if($tipoMateria=="C")
	{
		$consulta="SELECT claveUnidad,if(tituloJuzgadoAnterior is null,nombreUnidad,(concat(nombreUnidad,'/',tituloJuzgadoAnterior))) FROM _17_tablaDinamica 
					WHERE cmbCategoria in(1,2) and claveUnidad<5000 ".$comp." ORDER BY prioridad";
		
	}
	
	if($tipoMateria=="PT")
	{
		$consulta="SELECT claveUnidad,if(tituloJuzgadoAnterior is null,nombreUnidad,(concat(nombreUnidad,'/',tituloJuzgadoAnterior))) FROM _17_tablaDinamica 
					WHERE cmbCategoria in(1,2) and claveUnidad>=5000 ".$comp." ORDER BY prioridad";
		
	}

	$arrUnidadesGestion=$con->obtenerFilasArreglo($consulta);
	$consulta=" SELECT DISTINCT t.idTipoCarpeta,nombreTipoCarpeta  FROM 7006_carpetasAdministrativas c,7020_tipoCarpetaAdministrativa t 
				 WHERE ".$comp2." c.tipoCarpetaAdministrativa=t.idTipoCarpeta order by prioridad";
	$arrTiposCarpetas=$con->obtenerFilasArreglo($consulta);
	
	$tCarpertaDefault=$con->obtenerValor($consulta);
	
	$consulta="SELECT id__477_tablaDinamica,tipoJuicio FROM _477_tablaDinamica";
	$arrTiposJuicio=$con->obtenerFilasArreglo($consulta);

	$consulta="SELECT valor,contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=7773";
	$arrTipoRegistro=$con->obtenerFilasArreglo($consulta);
?>

var tipoMateria='<?php echo $tipoMateria?>';
var arrTipoRegistro=<?php echo $arrTipoRegistro?>;
var arrTiposJuicio=<?php echo $arrTiposJuicio?>;
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
	var cmbUnidadGestion=crearComboExt('cmbUnidadGestion',arrUnidadesGestion,0,0,480);
    cmbUnidadGestion.setValue(arrUnidadesGestion[0][0]);
    arrTiposCarpetas.splice(0,0,['0','Cualquiera']);
    var cmbTipoCarpeta=crearComboExt('cmbTipoCarpeta',arrTiposCarpetas,0,0,250);
    cmbTipoCarpeta.setValue('0');
    
    cmbUnidadGestion.on('select',recargarGrid);
    cmbTipoCarpeta.on('select',recargarGrid);
    
    
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
                                                                html:'<b>Juzgado:</b>&nbsp;&nbsp;&nbsp;'
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
                                               			{name: 'carpetaAdministrativa'},
                                                        {name: 'idCarpetaAdministrativa'},
                                                        {name: 'tipoExpediente'},
		                                                {name: 'situacion'},
                                                        {name: 'accionesCarpeta'},
                                                        {name: 'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'actores'},
														{name: 'demandados'},
                                                        {name: 'tipoJuicio'},
                                                        {name: 'juez'},
                                                        {name: 'tipoAccion'},
                                                        {name: 'secretaria'}
                                                        
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                              reader: lector,
                                              proxy : new Ext.data.HttpProxy	(
                                                                                    {
                                                                                        url: '../paginasFunciones/funcionesModulosEspeciales_Juzgados.php'
                                                                                    }
                                                                                ),
                                              sortInfo: {field: 'carpetaAdministrativa', direction: 'ASC'},
                                              groupField: 'carpetaAdministrativa',
                                              remoteGroup:false,
                                              remoteSort: true,
                                              autoLoad:true                                              
                                          }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	
                                        
                                            
                                    	proxy.baseParams.funcion='2';
                                        proxy.baseParams.uG=gEx('cmbUnidadGestion').getValue();
                                        proxy.baseParams.anio=cmbAnio.getValue();
                                        proxy.baseParams.tC=gEx('cmbTipoCarpeta').getValue();
                                        
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
                                                                header:'',
                                                                width:60,
                                                                sortable:true,
                                                                dataIndex:'accionesCarpeta',
                                                                renderer:function(val)
                                                                			{
                                                                            	return val
                                                                            }
                                                            },
                                                            {
                                                                header:'Expediente',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa',
                                                                renderer:function(val,meta,registro)
                                                                			{
                                                                            	return '<a href="javascript:abrirPanelAdministracionCarpeta(\''+bE(val)+'\',\''+bE(registro.data.idCarpetaAdministrativa)+'\')">'+val+'</a>';
                                                                            }
                                                            },
                                                            {
                                                                header:'Tipo de Registro',
                                                                width:150,
                                                                hidden:tipoMateria!='SC',
                                                                sortable:true,
                                                                dataIndex:'tipoExpediente',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	
                                                                    	return formatearValorRenderer(arrTipoRegistro,val);
                                                                    }
                                                            },
                                                            {
                                                                header:'Tipo de Juicio',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'tipoJuicio',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	
                                                                    	return formatearValorRenderer(arrTiposJuicio,val);
                                                                    }
                                                            },
                                                            {
                                                                header:'Tipo de acci&oacute;n',
                                                                width:130,
                                                                sortable:true,
                                                                hidden:tipoMateria!='SC',
                                                                dataIndex:'tipoAccion',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	
                                                                    	return val;
                                                                    }
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
                                                           
                                                            
                                                            
                                                            {
                                                                header:'Juez',
                                                                width:250,
                                                                hidden:true,
                                                                sortable:true,
                                                                dataIndex:'juez',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	return val;
                                                                    }
                                                            },
                                                            
                                                            {
                                                                header:'Actor',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'actores',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	
                                                                    	return val;
                                                                    }
                                                            },
                                                            {
                                                                header:'Demandado',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'demandados',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	
                                                                    	return val;
                                                                    }
                                                            },
                                                            {
                                                                header:'Secretar&iacute;a asignada',
                                                                width:130,
                                                                hidden:tipoMateria!='SC',
                                                                sortable:true,
                                                                dataIndex:'secretaria',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	
                                                                    	return val;
                                                                    }
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n expediente',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                renderer:function(val)
                                                                	{
                                                                    	return formatearValorRenderer(arrSituacionCarpeta,val);
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
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :false,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        
        
        tblGrid.getSelectionModel().on('rowselect',function(sm,nFila,registro)
        											{
                                                    	if(gEx('btnIncompetencia'))
                                                            gEx('btnIncompetencia').disable();
                
                                                        if(gEx('btnUnidadGestion'))
                                                            gEx('btnUnidadGestion').disable();
				
                										if(gEx('btnUnidadGestionZT'))
                                                            gEx('btnUnidadGestionZT').disable();
                
                
                                                        if(gEx('btnTribunalEnjuiciamiento'))
                                                            gEx('btnTribunalEnjuiciamiento').disable();
                                                            
                                                        if(gEx('btnEjecucion'))    
                                                            gEx('btnEjecucion').disable();
                                                    	if(parseFloat(registro.data.situacion)==1)	
                                                        {                                                     	
                                                            
                                                        	switch(registro.data.etapaProcesal)
                                                            {
                                                            	case '1':
                                                                case '2':
                                                                case '3':
                                                                case '4':
                                                                	if(gEx('btnIncompetencia'))
	                                                                	gEx('btnIncompetencia').enable();
                                                                        
                                                                   	if(gEx('btnUnidadGestion'))
	                                                                    gEx('btnUnidadGestion').enable();
                                                                    
                                                                    if(gEx('btnUnidadGestionZT'))
	                                                                    gEx('btnUnidadGestionZT').enable(); 
                                                                     
                                                                    if(gEx('btnTribunalEnjuiciamiento'))
	                                                                    gEx('btnTribunalEnjuiciamiento').enable();
                                                                        
                                                                    if(gEx('btnEjecucion'))    
	                                                                    gEx('btnEjecucion').enable();
                                                                break;
                                                                case '5':
                                                                	 if(gEx('btnTribunalEnjuiciamiento'))
                                                            			gEx('btnTribunalEnjuiciamiento').enable();
                                                                	if(gEx('btnEjecucion'))
	                                                                	gEx('btnEjecucion').enable();
                                                                    /*if(gEx('btnIncompetencia'))
	                                                                	gEx('btnIncompetencia').enable();*/
                                                                break;
                                                                case '6':
                                                                	
                                                                break;
                                                                
                                                            }
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


function abrirPanelAdministracionCarpeta(cA,iC)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/tableroAudienciaAdministracion.php';
    obj.params=[['cA',cA],['idCarpetaAdministrativa',bD(iC)]];
    //obj.titulo='Carpeta Judicial: '+bD(cA);
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