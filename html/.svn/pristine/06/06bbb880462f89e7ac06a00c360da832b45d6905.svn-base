<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT DISTINCT anio,anio FROM 7004_seriesUnidadesGestion ORDER BY anio ASC";
	$arrCiclosCarpeta=$con->obtenerFilasArreglo($consulta);
	$anio=date("Y");
	
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

	$arrUnidadesGestion=$con->obtenerFilasArreglo($consulta);
	$consulta=" SELECT DISTINCT t.idTipoCarpeta,nombreTipoCarpeta  FROM 7006_carpetasAdministrativas c,7020_tipoCarpetaAdministrativa t 
				 WHERE ".$comp2." c.tipoCarpetaAdministrativa=t.idTipoCarpeta order by prioridad";
	$arrTiposCarpetas=$con->obtenerFilasArreglo($consulta);
	
	$tCarpertaDefault=$con->obtenerValor($consulta);
?>

var tCarpertaDefault='<?php echo $tCarpertaDefault ?>';
var arrTiposCarpetas=<?php echo $arrTiposCarpetas?>;
var arrUnidadesGestion=<?php echo $arrUnidadesGestion?>;
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
                                	ajustarColumna(registro.data.id);
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
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b>Actas m&iacute;nimas/Transcripciones</b></span>',
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
                                                            crearGridTranscripciones()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}

function crearGridTranscripciones()
{

	
	var cmbAnio=crearComboExt('cmbAnio',arrCiclosCarpeta,0,0,120);
    
    cmbAnio.setValue(anio);
    cmbAnio.on('select',recargarGrid);
    
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'carpetaAdministrativa'},
		                                                {name: 'tAudiencias'},
		                                                {name: 'tActasRegistrada'},
		                                                {name: 'tActasFirmadas'},
                                                        {name: 'tActasPorFirmar'},
                                                        {name: 'tActasSinRegistro'},
                                                        {name: 'tTranscripcionesRegistrada'},
                                                        {name: 'tTranscripcionesFirmadas'},
                                                        {name: 'tTranscripcionesPendienteEntregaJuez'},
		                                                {name: 'tTranscripcionesPendientePorJuez'},
                                                        {name: 'tTranscripcionesSinRegistro'},
                                                        {name: 'tAudienciasSinTranscripcion'},
                                                        {name: 'tTranscripcionesSinResolucion'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 

	 var filters = new Ext.ux.grid.GridFilters	(
                                                        {
                                                            filters:	[
                                                            				{
                                                                            	type:'string',
                                                                                dataIndex:'carpetaAdministrativa'
                                                                            }
                                                            			]
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
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='200';
                                        proxy.baseParams.uG=gEx('cmbUnidadGestion').getValue();
                                        proxy.baseParams.anio=cmbAnio.getValue();
                                        proxy.baseParams.tC=gEx('cmbTipoCarpeta').getValue();
                                    }
                        )   

	var summary = new Ext.ux.grid.GridSummary();
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:35}),
                                                            
                                                            {
                                                                header:'Carpeta Judicial',
                                                                width:170,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa'
                                                            },
                                                            {
                                                                header:'Total audiencias<br />realizadas',
                                                                width:100,
                                                                sortable:true,
                                                                align:'center',
                                                                summaryType:'sum',
                                                                dataIndex:'tAudiencias'
                                                            },
                                                            {
                                                                header:'Total actas<br />registradas',
                                                                width:100,
                                                                sortable:true,
                                                                align:'center',
                                                                summaryType:'sum',
                                                                dataIndex:'tActasRegistrada'
                                                            },
                                                            {
                                                                header:'Total actas<br />firmadas',
                                                                width:100,
                                                                sortable:true,
                                                                align:'center',
                                                                summaryType:'sum',
                                                                dataIndex:'tActasFirmadas'
                                                            },
                                                            {
                                                                header:'Total actas<br />en revisi&oacute;n',
                                                                width:100,
                                                                sortable:true,
                                                                align:'center',
                                                                summaryType:'sum',
                                                                dataIndex:'tActasPorFirmar'
                                                            },
                                                            {
                                                                header:'Total actas<br />sin registro',
                                                                width:100,
                                                                sortable:true,
                                                                align:'center',
                                                                summaryType:'sum',
                                                                dataIndex:'tActasSinRegistro'
                                                            },
                                                            {
                                                                header:'Total transcripciones<br />registradas',
                                                                width:130,
                                                                sortable:true,
                                                                align:'center',
                                                                summaryType:'sum',
                                                                dataIndex:'tTranscripcionesRegistrada'
                                                            },
                                                            {
                                                                header:'Total NO aplica<br />transcripci&oacute;n',
                                                                width:130,
                                                                sortable:true,
                                                                align:'center',
                                                                summaryType:'sum',
                                                                dataIndex:'tAudienciasSinTranscripcion'
                                                            },
                                                            {
                                                                header:'Total transcripciones<br />firmadas',
                                                                width:130,
                                                                sortable:true,
                                                                align:'center',
                                                                summaryType:'sum',
                                                                dataIndex:'tTranscripcionesFirmadas'
                                                            },
                                                            {
                                                                header:'Total transcripciones<br />pendientes de <br />entregar a juez',
                                                                width:130,
                                                                sortable:true,
                                                                align:'center',
                                                                summaryType:'sum',
                                                                dataIndex:'tTranscripcionesPendienteEntregaJuez'
                                                            },
                                                            {
                                                                header:'Total transcripciones<br />pendientes de <br />entregar por el juez',
                                                                width:130,
                                                                sortable:true,
                                                                align:'center',
                                                                summaryType:'sum',
                                                                dataIndex:'tTranscripcionesPendientePorJuez'
                                                            },
                                                             {
                                                                header:'Total transcripciones<br />NO aplica<br />resoluci&oacute;n',
                                                                width:130,
                                                                sortable:true,
                                                                align:'center',
                                                                summaryType:'sum',
                                                                dataIndex:'tTranscripcionesSinResolucion'
                                                            },
                                                            {
                                                                header:'Total transcripciones<br />sin registro',
                                                                width:130,
                                                                sortable:true,
                                                                align:'center',
                                                                summaryType:'sum',
                                                                dataIndex:'tTranscripcionesSinRegistro'
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gActasMinimas',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                plugins:[filters,summary],
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
        return 	tblGrid;	
}


function recargarGrid()
{
	gEx('gActasMinimas').getStore().reload();
}