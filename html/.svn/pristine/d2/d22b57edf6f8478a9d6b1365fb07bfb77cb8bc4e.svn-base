<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	function obtenerFiguraJuridicaProcesoJudicial($carpeta,$tipoFiguras,$idCarpeta=-1)
	{
		global $con;	
		$arrSujetosProcesales=array();
		if($tipoFiguras=="")
			return $arrSujetosProcesales;
		
		$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpeta."'";
		if($idCarpeta!=-1)
			$consulta.=" and idCarpeta=".$idCarpeta;
	
		$idActividad=$con->obtenerValor($consulta);
		
		if($idActividad=="")
			$idActividad=-1;
		
		
		$demantante="";
		$consulta="SELECT id__47_tablaDinamica as idRegistro,upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',
					IF(apellidoMaterno IS NULL,'',apellidoMaterno)))  as nombreParticipante,tF.nombreTipo as figuraJuridica
					FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r,_5_tablaDinamica tF WHERE r.idParticipante=p.id__47_tablaDinamica
					AND r.idActividad=".$idActividad." AND r.idFiguraJuridica in(".$tipoFiguras.") and tF.id__5_tablaDinamica=r.idFiguraJuridica 
					ORDER BY nombre,nombre,apellidoMaterno";
		
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			array_push($arrSujetosProcesales,$fila);
		}
		
		
		
		return $arrSujetosProcesales;
		
		
	}
	
	$consulta="SELECT idEtapaProcesal,descripcionEtapa FROM 7009_etapasProcesales ORDER BY descripcionEtapa";
	$arrEtapaProcesal=$con->obtenerFilasArreglo($consulta);
	
	$cA=bD($_GET["cA"]);
	$cJudicial=$cA;
	
	$iC=bD($_GET["iC"]);
	
	
	$consulta="SELECT * FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cA."'";
	if($iC!=-1)
	{
		$consulta.=" and idCarpeta=".$iC;
	}
		
	
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	$codigoUnidadCarpeta=$fRegistro["unidadGestion"];
	
	$consulta="SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='A'";
	$naturalezaDemandante=$con->obtenerListaValores($consulta,"'")	;					
	
	
	$consulta="SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='D'";
	$naturalezaDemandado=$con->obtenerListaValores($consulta,"'")	;					
	
	$arrDemandantes=obtenerFiguraJuridicaProcesoJudicial($cJudicial,$naturalezaDemandante,$iC);
	$arrDemandados=obtenerFiguraJuridicaProcesoJudicial($cJudicial,$naturalezaDemandante,$iC);
	
	$consulta="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$codigoUnidadCarpeta."'";
	$lblDespacho=$con->obtenerValor($consulta);
	$consulta="SELECT nombreTipoProceso FROM _625_tablaDinamica WHERE id__625_tablaDinamica=".$fRegistro["tipoProceso"];
	$tipoProceso=$con->obtenerValor($consulta);

	$lblDemandantes="";
	foreach($arrDemandantes as $d)
	{
		if($lblDemandantes=="")
			$lblDemandantes=$d["nombreParticipante"];
		else
			$lblDemandantes.="<br>.".$d["nombreParticipante"];
	}
	
	$lblDemandados="";
	foreach($arrDemandados as $d)
	{
		if($lblDemandados=="")
			$lblDemandados=$d["nombreParticipante"];
		else
			$lblDemandados.="<br>.".$d["nombreParticipante"];
	}							
	
	
	
	$tblInfoExpediente='<table width="100%">
                                	<tr>
                                    	<td align="center">
                                        	<table>
                                            	<tr height="30">
                                                	<td width="400" align="center">
                                                    <span class="SIUGJ_Etiqueta">
                                                    	Despacho
                                                    </span>
                                                    </td>
                                                    <td width="100">
                                                    </td>
                                                    <td width="400"  align="center"a>
                                                    <span class="SIUGJ_Etiqueta">
                                                    	C&oacute;digo &uacute;nico de proceso
                                                    </span>
                                                    </td>
                                                </tr>
                                                <tr height="30">
                                                	<td width="400" align="center">
                                                    <span class="SIUGJ_ControlEtiqueta">
                                                    	'.$lblDespacho.'
                                                    </span>
                                                    </td>
                                                    <td width="100">
                                                    </td>
                                                    <td width="400"  align="center"a>
                                                    <span class="SIUGJ_ControlEtiqueta">
                                                    	'.$cJudicial.'                                                        
                                                    </span>
                                                    </td>
                                                </tr>
                                                <tr height="30">
                                                	<td width="400" align="center">
                                                    <span class="SIUGJ_Etiqueta">
                                                    	Demandante(s)
                                                    </span>
                                                    </td>
                                                    <td width="100">
                                                    </td>
                                                    <td width="400"  align="center"a>
                                                    <span class="SIUGJ_Etiqueta">
                                                    	Demandado(s)
                                                    </span>
                                                    </td>
                                                </tr>
                                                <tr height="30">
                                                	<td width="400" align="center">
                                                    <span class="SIUGJ_ControlEtiqueta">
                                                    	'.$lblDemandantes.'
                                                    </span>
                                                    </td>
                                                    <td width="100">
                                                    </td>
                                                    <td width="400"  align="center"a>
                                                    <span class="SIUGJ_ControlEtiqueta">
                                                    	<?php
                                                            '.$lblDemandados.'
                                                        ?>	
                                                        
                                                    </span>
                                                    </td>
                                                </tr>
                                                
                                                
                                                <tr height="30">
                                                	<td width="400" align="center">
                                                    <span class="SIUGJ_Etiqueta">
                                                    	Tipo de proceso
                                                    </span>
                                                    </td>
                                                    <td width="100">
                                                    </td>
                                                    <td width="400"  align="center"a>
                                                    <span class="SIUGJ_Etiqueta">
                                                    	Ubicaci&oacute;n del expediente
                                                    </span>
                                                    </td>
                                                </tr>
                                                <tr height="30">
                                                	<td width="400" align="center">
                                                    <span class="SIUGJ_ControlEtiqueta">
                                                    	'.$tipoProceso.'
                                                    </span>
                                                    </td>
                                                    <td width="100">
                                                    </td>
                                                    <td width="400"  align="center"a>
                                                    <span class="SIUGJ_ControlEtiqueta">
                                                    	Despacho
                                                    </span>
                                                    </td>
                                                </tr>
                                                
                                            </table>
                                        </td>
                                    </tr>
                                </table>';
	
?>
var tblInfoExpediente='<?php  echo bE($tblInfoExpediente)?>';
var arrEtapaProcesal=<?php echo $arrEtapaProcesal?>; 
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
                                                items:	[
                                                            {
                                                            	xtype:'panel',
                                                                region:'center',
                                                               
                                                                layout:'border',
                                                                tbar:	[
                                                                              {
                                                                                  icon:'../images/elbow-plus-nl.gif', 
                                                                                  width:100,
                                                                                  height:25,  
                                                                                  hidden:true,   
                                                                                  id:'btnMostarCabecera',
                                                                                  cls:'x-btn-text-icon',
                                                                                  text:'Mostrar Cabecera',
                                                                                  handler:function()
                                                                                          {
                                                                                             	gEx('btnMostarCabecera').hide();
                                                                                                gEx('btnOcultarCabecera').show();
                                                                                                gEx('panelCabecera').expand();
                                                                                          }
                                                                              },
                                                                              
                                                                              {
                                                                                  icon:'../images/elbow-minus-nl.gif', 
                                                                                  width:100,
                                                                                  height:25,   
                                                                                  id:'btnOcultarCabecera',  
                                                                                  cls:'x-btn-text-icon',
                                                                                  text:'Ocultar Cabecera',
                                                                                  handler:function()
                                                                                          {
                                                                                           		gEx('btnMostarCabecera').show();  
                                                                                                gEx('btnOcultarCabecera').hide(); 
                                                                                                gEx('panelCabecera').collapse();
                                                                                          }
                                                                              }
                                                                          ],
                                                                items:	[
                                                                			{
                                                                            	xtype:'panel',
                                                                                region:'north',
                                                                                height:240,
                                                                                hideCollapseTool :true,
                                                                                border:false,
                                                                                id:'panelCabecera',
                                                                                collapsible:true,
                                                                                layout:'absolute',
                                                                                
                                                                                
                                                                                items:	[
                                                                                			{
                                                                                                xtype:'label',
                                                                                                x:10,
                                                                                                y:10,
                                                                                                html:bD(tblInfoExpediente)
                                                                                             }
                                                                                		]
                                                                            },
                                                                            {
                                                                            	xtype:'tabpanel',
                                                                                activeTab:0,
                                                                                cls:'tabPanelSIUGJ',
                                                                                region:'center',
                                                                                items:	[
                                                                                			{
                                                                                                xtype:'panel',
                                                                                                region:'center',
                                                                                                layout:'border',
                                                                                                title:'Linea de tiempo',
                                                                                                tbar:	[
                                                                                                			{
                                                                                                                icon:'../images/elbow-plus-nl.gif', 
                                                                                                                width:100,
                                                                                                                height:25,     
                                                                                                                cls:'x-btn-text-icon',
                                                                                                                text:'Expandir todo',
                                                                                                                handler:function()
                                                                                                                        {
                                                                                                                            var x;
                                                                                                                            var totalRegistro=parseInt(gEx('frameTimeLine').getFrameWindow().gE('totalRegistro').value);
                                                                                                                            for(x=1;x<totalRegistro;x++)
                                                                                                                            {
                                                                                                                                gEx('frameTimeLine').getFrameWindow().mostrarDetalle(x,false);
                                                                                                                            }
                                                                                                                            gEx('frameTimeLine').getFrameWindow().timeline.redraw();
                                                                                                                        }
                                                                                                            },
                                                                                                            {
                                                                                                            	xtype:'tbspacer',
                                                                                                                width:15
                                                                                                            },
                                                                                                            {
                                                                                                                icon:'../images/elbow-minus-nl.gif', 
                                                                                                                width:100,
                                                                                                                height:25,     
                                                                                                                cls:'x-btn-text-icon',
                                                                                                                text:'Contraer todo',
                                                                                                                handler:function()
                                                                                                                        {
                                                                                                                            var x;
                                                                                                                            var totalRegistro=parseInt(gEx('frameTimeLine').getFrameWindow().gE('totalRegistro').value);

                                                                                                                            for(x=1;x<totalRegistro;x++)
                                                                                                                            {
                                                                                                                                gEx('frameTimeLine').getFrameWindow().ocultarDetalle(x,false);
                                                                                                                            }
                                                                                                                            gEx('frameTimeLine').getFrameWindow().timeline.redraw();
                                                                                                                        }
                                                                                                            }
                                                                                                		],
                                                                                                border:false,
                                                                                                items:	[
                                                                                                            new Ext.ux.IFrameComponent({ 	
                                
                                                                                                                            id: 'frameTimeLine', 
                                                                                                                            anchor:'100% 100%',
                                                                                                                            region:'center',
                                                                                                                            loadFuncion:function(iFrame)
                                                                                                                                        {
                                                                                                                                        	setTimeout(function(){gEx('frameTimeLine').getFrameWindow().scroll(0,100000);},500);
                                                                                                                                            
                                                                                                                                        },
                
                                                                                                                            url: '../paginasFunciones/white.php',
                                                                                                                            style: 'width:100%;height:100%' 
                                                                                                                    })
                                                                                                        ]
                                                                                            },
                                                                                            {
                                                                                                xtype:'panel',
                                                                                                region:'center',
                                                                                                layout:'border',
                                                                                                title:'Actuaciones del proceso',
                                                                                                border:false,
                                                                                                items:	[
                                                                                                			crearGridActuacionesProceso()
                                                                                                		]
                                                                                             }
                                                                                		]
                                                                            }
                                                                            
                                                                            
                                                                            
                                                                			
                                                                                                   
                                                                
                                                                		]
                                                            },
                                                            {
                                                                xtype:'panel',
                                                                collapsible:true,
                                                                collapsed:true,
                                                                width:380,
                                                                layout:'border',
                                                                region:'west',
                                                                items:	[
                                                                			crearGridEventosTimeLine()
                                                                        ]
                                                            
                                                            } 
                                                        ]
                                            }
                                         ]
                            }
                        )   


	gEx('frameTimeLine').load	(
									{
										url:'../modulosEspeciales_SGJ/historialCarpetaJudicial.php',
										params:	{
													cA:gE('cA').value,
                                                    idCarpeta:gE('idCarpeta').value,
													cPagina:'sFrm=true'
												}
									}
								)
}

function crearGridEventosTimeLine()
{
	
     var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                                        {name: 'idEvento'},
                                                        {name: 'fechaEvento', type:'date',dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'etapaProcesal'},
                                                        {name: 'leyenda'}
                                                    ],
                                            root:'registros'
                                            
                                        }
                                      );
    
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            sortInfo: {field: 'fechaEvento', direction: 'ASC'},
                                                            groupField: 'etapaProcesal',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 

    //alDatos.loadData(dsDatos);
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:55}),
														{
															header:'Fecha Evento',
															width:280,
															sortable:true,
															dataIndex:'fechaEvento',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	return '<span style="color:#900; font-size:11px"><b>'+val.format('d/m/Y H:i')+' hrs.</b></span><br />'+registro.data.leyenda;
                                                                    }
														},
														{
															header:'Etapa Procesal',
															width:450,
															sortable:true,
															dataIndex:'etapaProcesal',
                                                            renderer:function(val)
                                                            		{
                                                                    	return '<span style="color:#900">'+formatearValorRenderer(arrEtapaProcesal,val)+'</span>';
                                                                    }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gIndiceEventos',
                                                            store:alDatos,
                                                            frame:false,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :false,                                                            
                                                            columnLines : false,
                                                            region:'center',
                                                            cls:'gridSiugjPrincipal',
                                                            view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :true,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: true,
                                                                                                    startCollapsed:false
                                                                                                })
                                                        }
                                                    );
	
    
    tblGrid.getSelectionModel().on('rowselect',function(sm,nFila,registro)
                                                {
                                                	
                                                    gEx('frameTimeLine').getFrameWindow().seleccionarEvento(registro.data.idEvento);
                                                }
                                                
                                    )
    return 	tblGrid;
}



function cargarEventosIncide(arrEventos)
{
	var objDatos={};
    objDatos.numReg=arrEventos.length;
    objDatos.registros=arrEventos;
    
	gEx('gIndiceEventos').getStore().loadData(objDatos);
}

function crearGridActuacionesProceso()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name:'fechaActuacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'actuacion'},
                                                        {name: 'anotacion'},
                                                        {name: 'fechaInicia', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'fechaTermino', type:'date', dateFormat:'Y-m-d H:i:s'}

                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesTimeLine.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaActuacion', direction: 'ASC'},
                                                            groupField: 'fechaActuacion',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='1';
                                        proxy.baseParams.cA='<?php echo bE($cA)?>';
                                        proxy.baseParams.iC='<?php echo bE($iC)?>';
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:55}),
                                                            
                                                            {
                                                                header:'Fecha de actuaci&oacute;n',
                                                                width:180,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'fechaActuacion',
                                                                renderer:formatearCampoFechaActuacion
                                                            },
                                                            {
                                                                header:'Actuaci&oacute;n',
                                                                width:420,
                                                                sortable:true,
                                                                dataIndex:'actuacion'
                                                            },
                                                            {
                                                                header:'Anotaci&oacute;n',
                                                                width:420,
                                                                sortable:true,
                                                                dataIndex:'anotacion'
                                                            },
                                                             {
                                                                header:'Fecha inicia t&eacute;rmino',
                                                                width:140,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'fechaActuacion',
                                                                renderer:formatearCampoFechaActuacion
                                                            },
                                                             {
                                                                header:'Fecha finaliza t&eacute;rmino',
                                                                width:140,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'fechaActuacion',
                                                                renderer:formatearCampoFechaActuacion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gActuacionesProceso',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                border:false,
                                                                columnLines : false,
                                                                cls:'gridSiugjPrincipal',
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
        return 	tblGrid;	
}

function formatearCampoFechaActuacion(val)
{
	if(val)
    {
    	return val.format('d')+' '+arrMeses[parseInt(val.format('m'))-1][1].substr(0,3)+' '+val.format('Y');
    }
}