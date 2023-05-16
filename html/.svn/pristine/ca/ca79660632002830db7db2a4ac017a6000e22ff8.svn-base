<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT concat('\"',claveUnidad,'\"') as claveUnidad,nombreUnidad FROM _17_tablaDinamica    ORDER BY categoriaDespacho,nombreUnidad";//WHERE esDespacho=1
	$arrDespachos=$con->obtenerFilasArreglo($consulta);
	
?>


var arrMovimientosMostrar=[['-1','Todos'],['1','Conciliados'],['0','NO Conciliados']];
var arrTiposMovimiento=[['1','Dep&oacute;sito'],['2','Pagado a beneficiario'],['3','Prescrito'],['4','Traspasado']];
var arrDespachos=<?php echo $arrDespachos?>;

Ext.onReady(inicializar);

function inicializar()
{
	//arrDespachos.splice(0,0,['0','Cualquiera']);
    var cmbDespacho=crearComboExt('cmbDespacho',arrDespachos,0,0,400,{multiSelect:true,listClass:'listComboSIUGJControl',cls:"comboSIUGJ",fieldClass:"comboSIUGJ",ctCls:"comboWrapSIUGJ"});
    //cmbDespacho.setValue('0');
    cmbDespacho.setValue(bD(gE('listaDespachos').value));
    
    cmbDespacho.on('change',function()
    						{
                            	cargarGridMovimientos();
                            }
    				)
    
    var cmbMostrar1=crearComboExt('cmbMostrar1',arrMovimientosMostrar,0,0,180,{multiSelect:false,listClass:'listComboSIUGJControl',cls:"comboSIUGJ",fieldClass:"comboSIUGJ",ctCls:"comboWrapSIUGJ"});
    cmbMostrar1.setValue('-1');
    var cmbMostrar2=crearComboExt('cmbMostrar2',arrMovimientosMostrar,0,0,180,{multiSelect:false,listClass:'listComboSIUGJControl',cls:"comboSIUGJ",fieldClass:"comboSIUGJ",ctCls:"comboWrapSIUGJ"});
    cmbMostrar2.setValue('-1');
    
    cmbMostrar2.on('select',function(cmb,registro)
    				{
                    	gEx('gridImportados').getStore().reload();
                    }
    				)
                    
	cmbMostrar1.on('select',function(cmb,registro)
    				{
                    	cargarGridMovimientos()
                    }
    				)                    
    var cmbMes=crearComboExt('cmbMes',arrMeses,0,0,180,{listClass:'listComboSIUGJControl',cls:"comboSIUGJ",fieldClass:"comboSIUGJ",ctCls:"comboWrapSIUGJ"});
    cmbMes.setValue(gE('periodo').value);
    cmbMes.on('select',function(cmb,registro)
    					{
                        	var mes=registro.data.id;
                            if(parseInt(mes)<10)
                            {
                            	mes='0'+mes;
                            }
                            gEx('dteFechaInicio').setValue(gEx('dteFechaInicio').getValue().format('Y')+'-'+mes+'-01');
							var fechaFinal=gEx('dteFechaInicio').getValue();
                            fechaFinal=fechaFinal.add(Date.MONTH,1);
                        	fechaFinal=Date.parseDate(fechaFinal.format('Y')+'-'+fechaFinal.format('m')+'-01','Y-m-d');
                            fechaFinal=fechaFinal.add(Date.DAY,-1);
                            gEx('dteFechaFin').setValue(fechaFinal);
                            cargarGridMovimientos()
                        }
    			)
                
	          
                
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                cls:'panelSiugj',
                                                border:false,
                                                region:'center',
                                                tbar:	[
                                                			{
                                                            	xtype:'label',
                                                            	html:'<span class="SIUGJ_Etiqueta">Despacho:</span>&nbsp;&nbsp;'
                                                                
                                                            },
                                                            cmbDespacho,
                                                            {
                                                            	xtype:'tbspacer',
                                                                width:10
                                                            },
                                                            
                                                            {
                                                            	xtype:'label',
                                                            	html:'<span class="SIUGJ_Etiqueta">Mes:</span>&nbsp;&nbsp;'
                                                                
                                                            },
                                                            cmbMes,
                                                             {
                                                            	xtype:'tbspacer',
                                                                width:10
                                                            },
                                                            {
                                                                x:10,
                                                                y:10,
                                                                html:'<span class="SIUGJ_Etiqueta">Periodo del:</span>&nbsp;&nbsp;'
                                                            },
                                                            {
                                                                xtype:'datefield',
                                                                id:'dteFechaInicio',
                                                                listeners:	{
                                                                				change:function()
                                                                                		{
                                                                                        	cargarGridMovimientos();
                                                                                        }
                                                                			},
                                                                value:'<?php echo date("Y-m-d") ?>',
                                                                
                                                            },
                                                            {
                                                                x:10,
                                                                y:10,
                                                                html:'<span class="SIUGJ_Etiqueta">&nbsp;&nbsp;al:&nbsp;&nbsp;</span>'
                                                            },
                                                             {
                                                                xtype:'datefield',
                                                                id:'dteFechaFin',
                                                                listeners:	{
                                                                				change:function()
                                                                                		{
                                                                                        	cargarGridMovimientos();
                                                                                        }
                                                                			},
                                                                value:'<?php echo date("Y-m-d") ?>',
                                                                
                                                            }
                                                            
                                                            
                                                		],
                                                layout:'border',
                                                title: 'Conciliaci&oacute;n bancaria',
                                                items:	[
                                                			{
                                                            	xtype:'panel',
                                                                layout:'border',
                                                                border:false,
                                                                region:'center',
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/page_excel.png',
                                                                                cls:'x-btn-text-icon',
                                                                                height:30,
                                                                                text:'<span class="SIUGJ_Etiqueta">Exportar reporte de conciliaci&oacute;n</span>',
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaReporteConciliacion();
                                                                                            
                                                                                            
                                                                                            
                                                                                        }
                                                                                
                                                                            }
                                                                		],
                                                            	items:	[
                                                                			{
                                                                                xtype:'panel',
                                                                                region:'center', 
                                                                                layout:'border',
                                                                                border:true,
                                                                                title:'Movimientos del periodo' ,   
                                                                                tbar:	[
                                                                                            {
                                                                                            	xtype:'label',
                                                                                                cls:'SIUGJ_Etiqueta',
                                                                                                html:'Mostrar movimientos:&nbsp;&nbsp;&nbsp;'
                                                                                            },
                                                                                            cmbMostrar1
                                                                                        ],                                                           
                                                                                items:	[
                                                                                            crearGridMovimientoPeriodo()
                                                                                        ]
                                                                            },
                                                                            {
                                                                                xtype:'panel',
                                                                                width:'50%',
                                                                                cls:'panelSiugjPrincipal',
                                                                                layout:'border',
                                                                                border:true,
                                                                                title:'Movimientos Importados'   , 
                                                                                region:'east',  
                                                                                tbar:	[
                                                                                             {
                                                                                            	xtype:'label',
                                                                                                cls:'SIUGJ_Etiqueta',
                                                                                                html:'Mostrar movimientos: &nbsp;&nbsp;&nbsp;'
                                                                                            },
                                                                                            cmbMostrar2,
                                                                                            {
                                                                                            	xtype:'tbspacer',
                                                                                                width:10
                                                                                            },
                                                                                            {
                                                                                                icon:'../images/icon_big_tick.gif',
                                                                                                cls:'btnSIUGJCancel',
                                                                                                height:40,
                                                                                                text:'Conciliar Movimientos',
                                                                                                handler:function()
                                                                                                        {
                                                                                                        	var filaImpotado=gEx('gridImportados').getSelectionModel().getSelected();
                                                                                                            var filaMovimiento=gEx('gridMovimientos').getSelectionModel().getSelected();
                                                                                                            
                                                                                                            if(!filaImpotado)
                                                                                                            {
                                                                                                            	msgBox('Debe seleccionar el registro importado a conciliar');
                                                                                                            	return;
                                                                                                            } 
                                                                                                            
                                                                                                            
                                                                                                            if(!filaMovimiento)
                                                                                                            {
                                                                                                            	msgBox('Debe seleccionar el movimiento con el cual se concilia');
                                                                                                            	return;
                                                                                                            } 
                                                                                                            
                                                                                                            if(filaImpotado.data.conciliado=='1')
                                                                                                            {
                                                                                                            	msgBox('El registro importado ya ha sido conciliado anteriormente')
                                                                                                            	return;
                                                                                                            }
                                                                                                            
                                                                                                            if(filaMovimiento.data.conciliado=='1')
                                                                                                            {
                                                                                                            	msgBox('El movimiento con el cual se desea conciliar, ya ha sido conciliado anteriormente')
                                                                                                            	return;
                                                                                                            }
                                                                                                            
                                                                                                            if(filaMovimiento.data.tipoMovimiento!='1')
                                                                                                            {
                                                                                                            	msgBox('El movimiento que desea conciliar NO es de tipo Dep&oacute;sito');
                                                                                                            	return;
                                                                                                            }
                                                                                                            
                                                                                                            mostrarVentanaConciliacion(filaImpotado,filaMovimiento);
                                                                                                        }
                                                                                                
                                                                                            }
                                                                                        ],                                                                
                                                                                items:	[
                                                                                            crearGridMovimientosImportados()
                                                                                        ]
                                                                            }
                                                                		]
                                                            }
                                                            
                                                        ]
                                            }
                                         ]
                            }
                        )   
	dispararEventoSelectCombo('cmbMes');         
    cargarGridRegistros();                     
}

function crearGridMovimientoPeriodo()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'carpetaAdministrativa'},
		                                                {name:'codigoUnidad'},
		                                                {name:'fechaMovimiento', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'numeroDeposito'},
                                                        {name: 'abono'},
                                                        {name: 'cargo'},
                                                        {name:'tipoMovimiento'},
                                                        {name:'fechaRegistro', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'conciliado'},
                                                        {name: 'idRegistroConciliado'},
                                                        {name: 'fechaConciliacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'carpetaAdministrativaDestino'},
                                                        {name: 'codigoUnidadDestino'},
                                                        {name:'fechaMovimientoOriginal', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'montoOriginal'},
                                                        {name: 'numeroDepositoOriginal'},
                                                        {name: 'naturalezaAfectacion'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloDepositos.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaMovimiento', direction: 'ASC'},
                                                            groupField: 'fechaMovimiento',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{

                                    	proxy.baseParams.funcion='5';
                                                                             
                                    }
                        )   
       
       
	var paginador=	new Ext.PagingToolbar	(
                                              {
                                                    pageSize: 1000,
                                                    store: alDatos,
                                                    displayInfo: true,
                                                    disabled:false
                                                }
                                             )       
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer({width:40}),
                                                        
                                                        {
                                                            header:'ID',
                                                            width:60,
                                                            sortable:true,
                                                            dataIndex:'idRegistro'
                                                        },
                                                        {
                                                            header:'',
                                                            width:35,
                                                            sortable:true,
                                                            dataIndex:'conciliado',
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val=='1')
                                                                        {
                                                                        	return '<img src="../images/accept_green.png" title="Conciliado" alt="Conciliado">';
                                                                        }
                                                                        else
                                                                        {
                                                                        	return '<img src="../images/cancel_round.png" title="No Conciliado" alt="No Conciliado">';
                                                                        }
                                                                    }
                                                            
                                                        },
                                                        {
                                                            header:'Fecha registro',
                                                            width:180,
                                                            hidden:true,
                                                            sortable:true,
                                                            dataIndex:'fechaRegistro',
                                                            renderer:function(val)
                                                            			{
                                                                        	return val.format('d/m/Y H:i');
                                                                        }
                                                        },
                                                        {
                                                            header:'Fecha movimiento',
                                                            width:180,
                                                            sortable:true,
                                                            dataIndex:'fechaMovimiento',
                                                            renderer:function(val,meta,registro)
                                                            			{
                                                                        	var color='000';
                                                                            var complemetario='';
                                                                            if((registro.data.fechaMovimientoOriginal)&&(val!=registro.data.fechaMovimientoOriginal))
                                                                            {
                                                                                color='900';
                                                                                complemetario='title="Valor original: '+registro.data.fechaMovimientoOriginal.format("d/m/Y")+'" alt="Valor original: '+registro.data.fechaMovimientoOriginal.format("d/m/Y")+'"';
                                                                            }
                                                                        	return '<span style="color:#'+color+'" '+complemetario+'>'+val.format('d/m/Y')+'</span>';
                                                                        }
                                                        },
                                                        
                                                        {
                                                            header:'No. dep&oacute;sito',
                                                            width:180,
                                                            sortable:true,
                                                            dataIndex:'numeroDeposito',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	var color='000';
                                                                        var complemetario='';
                                                                        if((registro.data.numeroDepositoOriginal!='')&&(val!=registro.data.numeroDepositoOriginal))
                                                                        {
                                                                        	color='900';
                                                                            complemetario='title="Valor original: '+registro.data.numeroDepositoOriginal+'" alt="Valor original: '+registro.data.numeroDepositoOriginal+'"';
                                                                        }
                                                                        
                                                                        return '<span style="color:#'+color+'" '+complemetario+' >'+val+'</span>';
                                                                    }
                                                        },
                                                        
                                                        {
                                                            header:'Cargo',
                                                            width:180,
                                                            align:'center',
                                                            sortable:true,
                                                            dataIndex:'cargo',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	if(registro.data.naturalezaAfectacion=='-1')
                                                                        {
                                                                        	var complemetario='';
                                                                        	var color='000';
                                                                            if((registro.data.montoOriginal!='')&&(val!=registro.data.montoOriginal))
                                                                            {
                                                                                color='900';
                                                                                complemetario='title="Valor original: '+Ext.util.Format.usMoney(registro.data.montoOriginal)+
                                                                            		'" alt="Valor original: '+Ext.util.Format.usMoney(registro.data.montoOriginal)+'"';
                                                                            }
                                                                            
                                                                            return '<span style="color:#'+color+'" '+complemetario+'>'+Ext.util.Format.usMoney(val)+'</span>';
                                                                        }
                                                                        else
                                                                        	return Ext.util.Format.usMoney(val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Abono',
                                                            width:180,
                                                            sortable:true,
                                                            align:'center',
                                                            dataIndex:'abono',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	if(registro.data.naturalezaAfectacion=='1')
                                                                        {
                                                                        	var complemetario='';
                                                                        	var color='000';
                                                                            if((registro.data.montoOriginal!='')&&(val!=registro.data.montoOriginal))
                                                                            {
                                                                                color='900';
                                                                                complemetario='title="Valor original: '+Ext.util.Format.usMoney(registro.data.montoOriginal)+
                                                                            		'" alt="Valor original: '+Ext.util.Format.usMoney(registro.data.montoOriginal)+'"';
                                                                            }
                                                                            
                                                                             return '<span style="color:#'+color+'" '+complemetario+'>'+Ext.util.Format.usMoney(val)+'</span>';
                                                                        }
                                                                        else
                                                                        	return Ext.util.Format.usMoney(val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Proceso judicial',
                                                            width:180,
                                                            sortable:true,
                                                            dataIndex:'carpetaAdministrativa'
                                                        },
                                                        {
                                                            header:'Despacho',
                                                            width:300,
                                                            sortable:true,
                                                            dataIndex:'codigoUnidad'
                                                        },
                                                        {
                                                            header:'Tipo movimiento',
                                                            width:200,
                                                            sortable:true,
                                                            dataIndex:'tipoMovimiento',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrTiposMovimiento,val);
                                                                    }
                                                        },
                                                         {
                                                            header:'Proceso judicial trasladado',
                                                            width:235,
                                                            sortable:true,
                                                            dataIndex:'carpetaAdministrativaDestino'
                                                        },
                                                        {
                                                            header:'Despacho al que se traslada',
                                                            width:300,
                                                            sortable:true,
                                                            dataIndex:'codigoUnidadDestino'
                                                        }, 
                                                        {
                                                            header:'Conciliado',
                                                            width:140,
                                                            sortable:true,
                                                            dataIndex:'conciliado',
                                                            renderer:function(val)		
                                                            		{
                                                                    	return val=='1'?'S&iacute;':'No';
                                                                    }
                                                        },
                                                        {
                                                            header:'Fecha conciliaci&oacute;n',
                                                            width:180,
                                                            sortable:true,
                                                            hidden:true,
                                                            dataIndex:'fechaConciliacion',
                                                            renderer:function(val)		
                                                            		{
                                                                    	if(val)
	                                                                    	return val.format('d/m/Y');
                                                                        return '------';
                                                                    }
                                                        }
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridMovimientos',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            cm: cModelo,
                                                            border:false,
                                                            stripeRows :false,
                                                            loadMask:true,
                                                            ddGroup:'gridProcesos',
                                                            draggable :true,
                                                            cls:'gridSiugjPrincipal',
                                                            columnLines : false,
                                                            bbar:[paginador],
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
	tblGrid.getStore().load(	{
    								params:	{
                                    			url:'../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloDepositos.php',
                                                start:0, 
                                                limit:1000
                                                
                                    		}
    							}
                           )      

	tblGrid.on('rowdblclick',function(g,nFila)
    						{
                            	var fila=gEx('gridMovimientos').getStore().getAt(nFila);
                                if(fila.data.conciliado=='1')
                                {
                                	var pos=obtenerPosFila(gEx('gridImportados').getStore(),'idRegistro',fila.data.idRegistroConciliado);
;
                                    if(pos!=-1)
                                    {

                                       gEx('gridImportados').getSelectionModel().selectRow(pos,false);
                                    }
                                }
                            }
    			)

	

    return 	tblGrid;
}



function crearGridMovimientosImportados()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'noMovimiento'},
                                                        {name: 'numeroDeposito'},
		                                                {name:'fechaMovimiento', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'valorDeposito'},
                                                        {name: 'comentarios'},
                                                        {name: 'conciliado'},
                                                        {name: 'idRegistroConciliado'},
                                                        {name: 'tipoMovimiento'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloDepositos.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaRegistro', direction: 'ASC'},
                                                            groupField: 'fechaRegistro',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='4';
                                        proxy.baseParams.idImportacion=gE('idImportacion').value;
                                        proxy.baseParams.tipoRegistros=gEx('cmbMostrar2').getValue();
                                        
                                    }
                        )   
       
       
	var paginador=	new Ext.PagingToolbar	(
                                              {
                                                    pageSize: 1000,
                                                    store: alDatos,
                                                    displayInfo: true,
                                                    disabled:false
                                                }
                                             )       
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        
                                                        
                                                        {
                                                            header:'No. Movimiento',
                                                            width:150,
                                                            sortable:true,
                                                            dataIndex:'noMovimiento'
                                                        },
                                                        {
                                                            header:'',
                                                            width:35,
                                                            sortable:true,
                                                            dataIndex:'conciliado',
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val=='1')
                                                                        {
                                                                        	return '<img src="../images/accept_green.png" title="Conciliado" alt="Conciliado">';
                                                                        }
                                                                        else
                                                                        {
                                                                        	return '<img src="../images/cancel_round.png" title="No Conciliado" alt="No Conciliado">';
                                                                        }
                                                                    }
                                                            
                                                        },
                                                        {
                                                            header:'Fecha Movimiento',
                                                            width:180,
                                                            sortable:true,
                                                            dataIndex:'fechaMovimiento',
                                                            renderer:function(val)
                                                            			{
                                                                        	return val.format('d/m/Y');
                                                                        }
                                                        },
                                                        {
                                                            header:'No. dep&oacute;sito',
                                                            width:180,
                                                            sortable:true,
                                                            dataIndex:'numeroDeposito'
                                                        },
                                                        {
                                                            header:'Monto movimiento',
                                                            width:180,
                                                            sortable:true,
                                                            dataIndex:'valorDeposito',
                                                            renderer:'usMoney'
                                                        },
                                                        {
                                                            header:'Tipo movimiento',
                                                            width:180,
                                                            sortable:true,
                                                            dataIndex:'tipoMovimiento',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrTiposMovimiento,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Conciliado',
                                                            width:140,
                                                            sortable:true,
                                                            dataIndex:'conciliado',
                                                            renderer:function(val)
                                                            		{
                                                                    	return val=='1'?'S&iacute;':'No';
                                                                    }
                                                        },
                                                        {
                                                            header:'Comentarios',
                                                            width:400,
                                                            sortable:true,
                                                            dataIndex:'comentarios',
                                                            renderer:mostrarValorDescripcion
                                                        }
                                                        
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridImportados',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            cm: cModelo,
                                                            border:false,
                                                            stripeRows :false,
                                                            loadMask:true,
                                                            enableDragDrop:true,
                                                            ddGroup:'gridProcesos',
                                                            cls:'gridSiugjPrincipal',
                                                            columnLines : false,
                                                            bbar:[paginador],
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
	    

	tblGrid.on('rowdblclick',function(g,nFila)
    						{
                            	var fila=gEx('gridImportados').getStore().getAt(nFila);
                                if(fila.data.conciliado=='1')
                                {
                                	var pos=obtenerPosFila(gEx('gridMovimientos').getStore(),'idRegistro',fila.data.idRegistroConciliado);
;
                                    if(pos!=-1)
                                    {
                                    	var fila2=gEx('gridMovimientos').getStore().getAt(pos);
                                       gEx('gridMovimientos').getSelectionModel().selectRow(pos,false);
                                    }
                                }
                            }
    			)
    return 	tblGrid;
}

var arrCatecoriaColumna=[['1','Movimientos del periodo en despacho'],['2','Movimientos Importados']];
function mostrarVentanaReporteConciliacion()
{	
	
	var arrColumnas=[];
    //arrColumnas.push(['A','No de Movimiento','1']);
    //arrColumnas.push(['B','Proceso Judicial','1']);
    //arrColumnas.push(['C','Despacho','1']);
    arrColumnas.push(['D','No Depósito','1']);
    arrColumnas.push(['E','Fecha movimiento','1']);
    arrColumnas.push(['F','Cargo','1']);
    arrColumnas.push(['G','Abono','1']);
    arrColumnas.push(['H','Tipo Movimiento','1']);
    arrColumnas.push(['I','Consolidado','1']);
    arrColumnas.push(['J','No. de Movimiento','2']);
    arrColumnas.push(['K','Fecha movimiento','2']);
    arrColumnas.push(['L','Monto movimiento','2']);
    arrColumnas.push(['M','Tipo movimiento','2']);
    arrColumnas.push(['N','Consolidado','2']);
    arrColumnas.push(['O','Comentarios','2']);
    
    
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
                                            cls:'panelSiugj',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:15,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Seleccione los campos que desea proyectar en el reporte:'
                                                        },
                                                        crearGridCamposReporte(arrColumnas)
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Generar reporte de conciliaci&oacute;n ',
										width: 700,
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
                                                                    	var arrColumnas='';
																		var filas=gEx('gridCampos').getSelectionModel().getSelections();
                                                                        var x;
                                                                        var o;
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Debe selecionar almenos un campo a proyectar en el informe');
                                                                        	return;
                                                                        }
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	o='{"columna":"'+filas[x].data.columna+'","campo":"'+filas[x].data.campo+'"}';
                                                                        	if(arrColumnas=='')
                                                                            	arrColumnas=o;
                                                                            else
                                                                            	arrColumnas+=','+o;
                                                                        }
                                                                        
                                                                        
                                                                        var cadObj='{"despachos":"'+bE(gEx('cmbDespacho').getValue())+'","periodo":"'+gEx('cmbMes').getValue()+
                                                                        			'","fechaInicio":"'+gEx('dteFechaInicio').getValue().format('Y-m-d')+
                                                                                    '","fechaFin":"'+gEx('dteFechaFin').getValue().format('Y-m-d')+
                                                                                    '","arrColumas":['+arrColumnas+'],"idImportacion":"'+gE('idImportacion').value+'"}';
																	
                                                                    	var aParams=[['cadObj',bE(cadObj)]];
                                                                        enviarFormularioDatosV('../reportes/generarConciliacionBancaria.php',aParams,'POST');
                                                                        ventanaAM.close();
                                                                    
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

function crearGridCamposReporte(arrRegistros)
{
	var dsDatos=arrRegistros;
    var lector=	new Ext.data.ArrayReader	(
                                                    {
                                                        fields:	[
                                                                    {name: 'columna'},
                                                                    {name: 'campo'},
                                                                    {name: 'categoria'}
                                                                ]
                                                    }
                                                );

	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,

                                                            sortInfo: {field: 'categoria', direction: 'ASC'},
                                                            groupField: 'categoria',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:40}),
														chkRow,
														{
															header:'Campo',
															width:300,
															sortable:true,
															dataIndex:'campo'
														},
                                                        {
															header:'Categor&iacute;a',
															width:300,
															sortable:true,
															dataIndex:'categoria',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrCatecoriaColumna,val);
                                                                    }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:false,
                                                            y:40,
                                                            x:10,
                                                            id:'gridCampos',
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :false,
                                                            cls:'gridSiugjPrincipal',
                                                            columnLines : false,
                                                            height:260,
                                                            width:650,
                                                            view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :true,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: true,
                                                                                                    startCollapsed:false
                                                                                                }),
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;	
}

function cargarGridRegistros()
{
	gEx('gridImportados').getStore().load(	{
                                                params:	{
                                                            url:'../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloDepositos.php',
                                                            start:0, 
                                                            limit:1000
                                                            
                                                        }
                                            }
                                       )  

	cargarGridMovimientos();
	
}


function cargarGridMovimientos()
{
	gEx('gridMovimientos').getStore().load(	{
                                                params:	{
                                                            url:'../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloDepositos.php',
                                                            start:0, 
                                                            limit:1000,
                                                            codigoUnidad:gEx('cmbDespacho').getValue(),
                                                            idImportacion:gE('idImportacion').value,
                                                            tipoRegistros:gEx('cmbMostrar1').getValue(),
                                                            fechaInicio:gEx('dteFechaInicio').getValue().format('Y-m-d'),
                                                            fechaFin:gEx('dteFechaFin').getValue().format('Y-m-d')
                                                            
                                                        }
                                            }
                                       ) 
}


function mostrarVentanaConciliacion(filaImportado,filaMovimiento)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
                                            cls:'panelSiugj',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Movimiento importado'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:50,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Fecha movimiento'
                                                        },
                                                        
                                                        {
                                                        	x:210,
                                                            y:50,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'No. dep&oacute;sito'
                                                        },
                                                        {
                                                        	x:410,
                                                            y:50,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Monto movimiento'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:80,
                                                            cls:'SIUGJ_ControlEtiqueta',
                                                            html:filaImportado.data.fechaMovimiento.format('d/m/Y')
                                                        },
                                                        
                                                        {
                                                        	x:210,
                                                            y:80,
                                                            cls:'SIUGJ_ControlEtiqueta',
                                                            html:filaImportado.data.numeroDeposito
                                                        },
                                                        {
                                                        	x:410,
                                                            y:80,
                                                            cls:'SIUGJ_ControlEtiqueta',
                                                            html:'Monto movimiento',
                                                            html:Ext.util.Format.usMoney(filaImportado.data.valorDeposito)
                                                        },
                                                        {
                                                        	x:10,
                                                            y:150,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Conciliar con'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:190,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Fecha movimiento'
                                                        },
                                                        
                                                        {
                                                        	x:210,
                                                            y:190,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'No. dep&oacute;sito'
                                                        },
                                                        {
                                                        	x:410,
                                                            y:190,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Monto movimiento'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:220,
                                                            cls:'SIUGJ_ControlEtiqueta',
                                                            html:filaMovimiento.data.fechaMovimiento.format('d/m/Y')
                                                        },
                                                        
                                                        {
                                                        	x:210,
                                                            y:220,
                                                            cls:'SIUGJ_ControlEtiqueta',
                                                            html:filaMovimiento.data.numeroDeposito
                                                        },
                                                        {
                                                        	x:410,
                                                            y:220,
                                                            cls:'SIUGJ_ControlEtiqueta',
                                                            html:'Monto movimiento',
                                                            html:Ext.util.Format.usMoney(filaMovimiento.data.naturalezaAfectacion=='1'?filaMovimiento.data.abono:filaMovimiento.data.cargo)
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Conciliaci&oacute;n de movimientos',
										width: 650,
										height:400,
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
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
																		function resp(btn)
                                                                        {
                                                                        	if(btn=='yes')
                                                                            {
                                                                            	var cadObj='{"idRegistroImportado":"'+filaImportado.data.idRegistro+
                                                                                			'","idMovimiento":"'+filaMovimiento.data.idRegistro+'"}';
                                                                                            
                                                                                function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                        filaImportado.set('idRegistroConciliado',filaMovimiento.data.idRegistro);
                                                                                        filaImportado.set('conciliado','1');
                                                                                        
                                                                                        
                                                                                        filaMovimiento.set('idRegistroConciliado',filaImportado.data.idRegistro);
                                                                                        filaMovimiento.set('conciliado','1');
                                                                                        
                                                                                        filaMovimiento.set('numeroDepositoOriginal',filaMovimiento.data.numeroDeposito);
                                                                                        filaMovimiento.set('montoOriginal',filaMovimiento.data.naturalezaAfectacion=='1'?filaMovimiento.data.abono:filaMovimiento.data.cargo);
                                                                                        filaMovimiento.set('fechaMovimientoOriginal',filaMovimiento.data.fechaMovimiento);
                                                                                        
                                                                                        
                                                                                        filaMovimiento.set('numeroDeposito',filaImportado.data.numeroDeposito);
                                                                                        filaMovimiento.set('fechaMovimiento',filaImportado.data.fechaMovimiento);
                                                                                        filaMovimiento.set((filaMovimiento.data.naturalezaAfectacion=='1'?'abono':'cargo'),filaImportado.data.valorDeposito);
                                                                                        
                                                                                       	ventanaAM.close();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloDepositos.php',funcAjax, 'POST','funcion=6&cadObj='+cadObj,true);
                                                                                            
                                                                                            
                                                                            }
                                                                        }
                                                                        msgConfirm('¿Est&aacute; seguro de querer conciliar los movimientos seleccionados?',resp)
																	}
														}
													]
									}
								);
	ventanaAM.show();	
}