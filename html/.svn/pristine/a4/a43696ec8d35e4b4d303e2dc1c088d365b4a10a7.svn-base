<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$fechaActual=date("Y-m-d");
	$dia=date("w",strtotime($fechaActual));

	$fechaInicial=date("Y-m-d",strtotime("-".$dia." days",strtotime($fechaActual)));
	
	
	$arrSituacion="";
	$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=283 ORDER BY numEtapa";
	$resEtapas=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($resEtapas))
	{
		$o="[".$fila[0].",'".removerCerosDerecha($fila[0]).".- ".$fila[1]."']";
		if($arrSituacion=="")
			$arrSituacion=$o;
		else
			$arrSituacion.=",".$o;
	}
	$arrSituacion="[".$arrSituacion."]";
?>


var arrSituacion=<?php echo $arrSituacion?>;
Ext.onReady(inicializar);

function inicializar()
{
   new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                			{
                                                xtype:'tabpanel',
                                                region:'center',
                                                cls:'tabPanelSIUGJ',
                                                activeTab:0,
                                                items:	[
                                                			
                                                             {
                                                                xtype:'panel',
                                                                region:'center',
                                                                layout:'border',
                                                                cls:'panelSiugj',
                                                                title: 'Tutelas Recibidas',
                                                                tbar:	[
                                                                            {
                                                                                xtype:'label',
                                                                                cls:'controlSIUGJ',
                                                                                html:'&nbsp;&nbsp;&nbsp;Periodo del:&nbsp;&nbsp;&nbsp;'
                                                                            },
                                                                            {
                                                                            	xtype:'label',
                                                                                html:'<div id="spFechaInicio" style="width:140px"></div>'
                                                                            }
                                                                            
                                                                            ,
                                                                            {
                                                                                xtype:'label',
                                                                                cls:'controlSIUGJ',
                                                                                html:'&nbsp;&nbsp;&nbsp;al:&nbsp;&nbsp;&nbsp;'
                                                                            },
                                                                            {
                                                                            	xtype:'label',
                                                                                html:'<div id="spFechaFin" style="width:140px"></div>'
                                                                            }
                                                                            
                                                                        ],
                                                                items:	[
                                                                            crearGridTutelas()
                                                                        ]
                                                            },
                                                            {
                                                                xtype:'panel',
                                                                region:'center',
                                                                layout:'border',
                                                                cls:'panelSiugj',
                                                                title: 'Paquetes de Tutela',
                                                                items:	[
                                                                            crearGridPaquetesTutelas()
                                                                        ]
                                                            }
                                                        ]
											}                                
                                           
                                         ]
                            }
                        )  

	
    new Ext.form.DateField (
    							{
                                 
                                  id:'dtePeriodoInicial',
                                  renderTo:'spFechaInicio',
                                  ctCls:'campoFechaSIUGJ',
                                  width:130,
                                  value:'<?php echo $fechaInicial?>',
                                  listeners:	{
                                                  select:function()
                                                          {
                                                              gEx('gTutelas').getStore().reload();
                                                          }
                                                          
                                              }
                              }
                           )

	new Ext.form.DateField (

								{
                                    
                                    id:'dtePeriodoFinal',
                                    renderTo:'spFechaFin',
                                    ctCls:'campoFechaSIUGJ',
                                  	width:130,
                                    value:'<?php echo $fechaActual?>',
                                    listeners:	{
                                                    select:function()
                                                            {
                                                                gEx('gTutelas').getStore().reload();
                                                            }
                                                            
                                                }
                                }
                             )

}





function crearGridTutelas()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'idFormulario'},
                                                        {name:'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'folioRegistro'},
                                                        {name:'carpetaAdministrativa'},
                                                        {name:'despachoEnvio'},
                                                        {name: 'cuentaFicha'},
                                                        {name:'folioCorteConstitucional'}                                                        
		                                                
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaCreacion', direction: 'ASC'},
                                                            groupField: 'fechaCreacion',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='10';
                                        proxy.baseParams.fechaInicio=gEx('dtePeriodoInicial').getValue().format('Y-m-d');
                                        proxy.baseParams.fechaFin=gEx('dtePeriodoFinal').getValue().format('Y-m-d');
                                    }
                        )   

	var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            chkRow,
                                                            {
                                                                header:'Fecha de Creaci&oacute;n',
                                                                width:190,
                                                                sortable:true,
                                                                dataIndex:'fechaCreacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i');
                                                                        }
                                                            },
                                                            {
                                                                header:'Folio de Registro',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'folioRegistro',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return '<a href="javascript:abrirTutela(\''+bE(registro.data.idFormulario)+'\',\''+bE(registro.data.idRegistro)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Folio Corte Constitucional',
                                                                width:230,
                                                                sortable:true,
                                                                dataIndex:'folioCorteConstitucional'
                                                            },
                                                            {
                                                                header:'C&oacute;digo &Uacute;nico de Proceso',
                                                                width:280,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa'
                                                            },
                                                            {
                                                                header:'Ficha Esquem&aacute;tica',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'cuentaFicha',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val=='0')
                                                                            	return '<img src="../images/cancel_round.png" title="Sin Ficha Esquem&aacute;tica" alt="Sin Ficha Esquem&aacute;tica">&nbsp&nbsp;Sin Ficha';
                                                                        	else
                                                                            	return '<img src="../images/accept_green.png" title="Con Ficha Esquem&aacute;tica" alt="Con Ficha Esquem&aacute;tica">&nbsp&nbsp;Con Ficha';
                                                                            
                                                                        }
                                                            },
                                                            {
                                                                header:'Despacho que Env&iacute;a',
                                                                width:700,
                                                                sortable:true,
                                                                dataIndex:'despachoEnvio'
                                                            }
                                                            
                                                             
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gTutelas',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                sm:chkRow,
                                                                stripeRows :false,
                                                                loadMask:true,
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


function crearGridPaquetesTutelas()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'idFormulario'},
                                                        {name:'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'folioRegistro'},
                                                        {name:'totalTutelas'},
                                                        {name:'despachoAsignado'},
                                                        {name:'situacionActual'}                                                        
		                                                
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaCreacion', direction: 'ASC'},
                                                            groupField: 'fechaCreacion',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='12';
                                        proxy.baseParams.fechaInicio=gEx('dtePeriodoInicial').getValue().format('Y-m-d');
                                        proxy.baseParams.fechaFin=gEx('dtePeriodoFinal').getValue().format('Y-m-d');
                                    }
                        )   

	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true,width:40});
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            chkRow,
                                                            {
                                                                header:'Fecha de Creaci&oacute;n',
                                                                width:190,
                                                                sortable:true,
                                                                dataIndex:'fechaCreacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i');
                                                                        }
                                                            },
                                                            {
                                                                header:'Folio de Registro',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'folioRegistro',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return '<a href="javascript:abrirRegistro(\''+bE(registro.data.idRegistro)+'\')">'+val+'</a>';	
                                                                        }
                                                            },
                                                             {
                                                                header:'Total de Tutelas',
                                                                width:160,
                                                                sortable:true,
                                                                dataIndex:'totalTutelas'
                                                            },
                                                            {
                                                                header:'Despacho de Pre Selecci&oacute;n Asignado',
                                                                width:700,
                                                                sortable:true,
                                                                dataIndex:'despachoAsignado',
                                                                renderer:function(val)		
                                                                		{
                                                                        	return val==''?'Por Asignar':val;
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Situaci&oacute;n Actual',
                                                                width:500,
                                                                sortable:true,
                                                                dataIndex:'situacionActual',
                                                                renderer:function(val)
                                                                			{
                                                                            	return formatearValorRenderer(arrSituacion,val);
                                                                            }
                                                            }
                                                             
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gPaqueteTutelas',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                sm:chkRow,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                cls:'gridSiugjPrincipal',
                                                                columnLines : false,  
                                                                tbar:	[
                                                                            {
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Crear Paquete',
                                                                                handler:function()
                                                                                        {
                                                                                              function funcAjax()
                                                                                              {
                                                                                                  var resp=peticion_http.responseText;
                                                                                                  arrResp=resp.split('|');
                                                                                                  if(arrResp[0]=='1')
                                                                                                  {
                                                                                                      var obj={};    
                                                                                                      obj.ancho='100%';
                                                                                                      obj.alto='100%';
                                                                                                      obj.modal=true;
                                                                                                      obj.url='../modeloPerfiles/vistaDTDv3.php';
                                                                                                      obj.funcionCerrar=function()
                                                                                                      					{
                                                                                                                        	recargarContenedorCentral();
                                                                                                                        };
                                                                                                      obj.params=[['idFormulario',990],['idRegistro',arrResp[1]],['idReferencia',-1],
                                                                                                              ['dComp',arrResp[2]],['actor',arrResp[3]]];
                                                                                                      abrirVentanaFancySuperior(obj);
                                                                                                  }
                                                                                                  else
                                                                                                  {
                                                                                                      msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                  }
                                                                                              }
                                                                                              obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',funcAjax, 'POST','funcion=11&iR=-1',true);
                                                                                           
                                                                                           
                                                                                          
                                                                                        }
                                                                                
                                                                            }
                                                                            
                                                                           
                                                                            
                                                                        ] ,                                                             
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


function recargarContenedorCentral()
{
	gEx('gTutelas').getStore().reload();
    gEx('gPaqueteTutelas').getStore().reload();
}


function abrirRegistro(iR)
{
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
            obj.modal=true;
            obj.funcionCerrar=function()
                              {
                                  recargarContenedorCentral();
                              };
            obj.params=[['idFormulario',990],['idRegistro',arrResp[1]],['idReferencia',-1],
                    ['dComp',arrResp[2]],['actor',arrResp[3]]];
            abrirVentanaFancySuperior(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',funcAjax, 'POST','funcion=11&iR='+bD(iR),true);
}


function abrirTutela(iF,iR)
{
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
            obj.modal=true;
            obj.funcionCerrar=function()
                              {
                                  gEx('gTutelasAsignadas').getStore().reload();
                              };
            obj.params=[['idFormulario',bD(iF)],['idRegistro',arrResp[1]],['idReferencia',-1],
                    ['dComp',arrResp[2]],['actor',arrResp[3]]];
            abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',funcAjax, 'POST','funcion=15&iR='+bD(iR),true);
}
