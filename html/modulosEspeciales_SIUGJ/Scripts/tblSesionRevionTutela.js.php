<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$fechaActual=date("Y-m-d");
	$dia=date("w",strtotime($fechaActual));

	$fechaInicial=date("Y-m-d",strtotime("-".$dia." days",strtotime($fechaActual)));
	
	$idAudiencia=$_GET["iA"];
	
?>

var arrVotaciones=[['0','En Espera de Votaci&oacute;n'],['1','Aprobado'],['2','NO Aprobado'],['3','En Abstenci&oacute;n'],['5','Votaci&oacute;n NO Aperturada']];
var arrSentidoFallo=[['1','Confirma'],['2','Revoca'],['3','Modifica']];
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
                                                cls:'panelSiugj',
                                                tbar:	[
                                                            {
                                                                icon:'../images/icon_tick.gif',
                                                                cls:'x-btn-text-icon',
                                                                id:'btnApertura',
                                                                text:'Aperturar Votaci&oacute;n',
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
                                                                                            msgBox('La operaci&oacute;n ha sido realizada correctamente');
                                                                                            gEx('gTutelasAsignadas').getStore().reload();
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                        }
                                                                                    }
                                                                                    obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',funcAjax, 'POST','funcion=17&idEvento='+gE('idAudiencia').value,true);
                                                                                    
                                                                                }
                                                                            }
                                                                            msgConfirm('Est&aacute; seguro de querer Aperturar la Votaci&oacute;n  a los Magistrados?',resp);
                                                                        }
                                                                
                                                            },
                                                            {
                                                                icon:'../images/lock.png',
                                                                cls:'x-btn-text-icon',
                                                                id:'btnCerrar',
                                                                text:'Cerrar Votaci&oacute;n',
                                                                handler:function()
                                                                        {
                                                                        
                                                                            if(gEx('cmbDictamenFinal').getValue()=='')
                                                                            {
                                                                                function respAux()
                                                                                {
                                                                                    gEx('cmbDictamenFinal').focus();
                                                                                }
                                                                                msgBox('Debe indicar el dict&aacute;men final de la votaci&oacute;n',respAux);
                                                                                return;
                                                                            }
                                                                            var cadObj='{"dictamenFinal":"'+gEx('cmbDictamenFinal').getValue()+'","comentariosAdicionales":"","idEvento":"'+gE('idAudiencia').value+'"}';
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
                                                                                            gEx('gTutelasAsignadas').getStore().reload();
                                                                                            msgBox('La operaci&oacute;n ha sido realizada correctamente');
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                        }
                                                                                    }
                                                                                    obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',funcAjax, 'POST','funcion=18&cadObj='+cadObj,true);
                                                                                    
                                                                                }
                                                                            }
                                                                            msgConfirm('Est&aacute; seguro de querer Finalizar la Votaci&oacute;n de Magistrados?',resp);
                                                                        }
                                                                
                                                            },
                                                            {
                                                                xtype:'label',
                                                                cls:'letraNombreTablero',
                                                                html:'&nbsp;Dict&aacute;men Final:&nbsp;&nbsp;'
                                                            },
                                                            {
                                                                xtype:'label',
                                                                html:'<div id="divDictamenFinal"></div>'
                                                            }
                                                            
                                                            ,
                                                            {
                                                            	xtype:'tbspacer',
                                                                width:5
                                                            },
                                                            {
                                                                
                                                                icon:'../images/arrow_refresh.PNG',
                                                                cls:'x-btn-text-icon',
                                                                handler:function()
                                                                        {
                                                                            actualizarTableroVotacion();
                                                                        }
                                                                
                                                            }
                                                        ], 
                                                items:	[
                                                            crearGridRevisionTutelas()
                                                        ]
                                            }                             
                                           
                                         ]
                            }
                        )  

	setTimeout(actualizarTableroVotacion,300000);
    var cmbDictamenFinal=crearComboExt('cmbDictamenFinal',[['1','Aprobado por Unanimidad'],['2','Aprobado por Mayor\xEDa'],['2','Si Aprobaci\xF3n']],0,0,280,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divDictamenFinal'});

}
    


function crearGridRevisionTutelas()
{
	
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			
                                                        {name: 'idMagistrado'},
                                                        {name: 'nombreMagistrado'},
                                                        {name: 'votacion'},
                                                        {name: 'comentariosAdicionales'}
                                                                                                                   
		                                                
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
                                                            sortInfo: {field: 'nombreMagistrado', direction: 'ASC'},
                                                            groupField: 'nombreMagistrado',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='16';
                                        proxy.baseParams.iA='<?php echo $idAudiencia?>';
                                    }
                        )   

	
    alDatos.on('load',function(proxy)
    								{
                                    	
                                    	if(proxy.reader.jsonData.situacionVotacion!='5')
                                        {
                                        	gEx('btnApertura').hide();
                                            gEx('btnCerrar').show();
                                        }
                                        else
                                        {
                                        	gEx('btnCerrar').hide();
                                            gEx('btnApertura').show();
                                        }
                                        
                                       
                                    }
                        )  
    
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            
                                                            {
                                                                header:'Nombre del Magistrado',
                                                                width:330,
                                                                sortable:true,
                                                                dataIndex:'nombreMagistrado'
                                                            },
                                                            {
                                                                header:'Votaci&oacute;n',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'votacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrVotaciones,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Comentarios Adicionales',
                                                                width:500,
                                                                sortable:true,
                                                                dataIndex:'comentariosAdicionales',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	meta.attr='style="height:auto;min-height:21px"';
                                                                            return mostrarValorDescripcion(val)
                                                                        }
                                                            }
                                                            
                                                             
                                                            
                                                        ]
                                                    );
                                                    
        tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gTutelasAsignadas',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                border:false,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                cls:'gridSiugjPrincipal',
                                                                columnLines : false,  
                                                                  
                                                                                                                           
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



function mostrarAgregarVentanaTutelas(tblGrid)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridTutelasAgregar()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Tutelas',
										width: 880,
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
																		var filas=gEx('gTutelasAgregar').getSelectionModel().getSelections();
                                                                        var x;
                                                                        var fila;
                                                                        var arrRegistros='';
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	fila=filas[x];
                                                                            
                                                                            if(arrRegistros=='')
                                                                            	arrRegistros=fila.data.idRegistro;
                                                                            else
                                                                            	arrRegistros+=','+fila.data.idRegistro;
                                                                                
                                                                           
                                                                            
                                                                        }
                                                                        
                                                                        if(arrRegistros=='')
                                                                        {
                                                                        	msgBox('Debe selecionar almenos una tutela');
                                                                        	return;
                                                                        }

                                                                        
                                                                        
                                                                        var cadObj='{"idRegistro":"'+gE('idRegistro').value+'","arrRegistros":"'+arrRegistros+'"}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gEx('gTutelasAsignadas').getStore().reload();
                                                                                ventanaAM.close();
                                                                                
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',funcAjax, 'POST','funcion=13&cadObj='+cadObj,true);
                                                                        
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


function crearGridTutelasAgregar()
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
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='10';
                                        proxy.baseParams.fechaInicio=gEx('dtePeriodoInicial').getValue().format('Y-m-d');
                                        proxy.baseParams.fechaFin=gEx('dtePeriodoFinal').getValue().format('Y-m-d');
                                    }
                        )   

	var chkRow=new Ext.grid.CheckboxSelectionModel();
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            chkRow,
                                                            {
                                                                header:'Fecha de Creaci&oacute;n',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'fechaCreacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i');
                                                                        }
                                                            },
                                                            {
                                                                header:'Folio de Registro',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'folioRegistro'
                                                            },
                                                            {
                                                                header:'Folio Corte Consticional',
                                                                width:170,
                                                                sortable:true,
                                                                dataIndex:'folioCorteConstitucional'
                                                            },
                                                            {
                                                                header:'C&oacute;digo &Uacute;nico de Proceso',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa'
                                                            },
                                                            {
                                                                header:'Despacho que Env&iacute;a',
                                                                width:550,
                                                                sortable:true,
                                                                dataIndex:'despachoEnvio'
                                                            }
                                                             
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gTutelasAgregar',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                sm:chkRow,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true, 
                                                                tbar:	[
                                                                            {
                                                                                xtype:'label',
                                                                                html:'&nbsp;&nbsp;&nbsp;<b>Periodo del:</b>&nbsp;&nbsp;&nbsp;'
                                                                            },
                                                                            {
                                                                                xtype:'datefield',
                                                                                id:'dtePeriodoInicial',
                                                                                value:'<?php echo $fechaInicial?>',
                                                                                listeners:	{
                                                                                                select:function()
                                                                                                        {
                                                                                                            gEx('gTutelasAgregar').getStore().reload();
                                                                                                        }
                                                                                                        
                                                                                            }
                                                                            },'-',
                                                                            {
                                                                                xtype:'label',
                                                                                html:'&nbsp;&nbsp;&nbsp;<b>al:</b>&nbsp;&nbsp;&nbsp;'
                                                                            },
                                                                            {
                                                                                xtype:'datefield',
                                                                                id:'dtePeriodoFinal',
                                                                                value:'<?php echo $fechaActual?>',
                                                                                listeners:	{
                                                                                                select:function()
                                                                                                        {
                                                                                                            gEx('gTutelasAgregar').getStore().reload();
                                                                                                        }
                                                                                                        
                                                                                            }
                                                                            }
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
        return 	tblGrid;	
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
            window.parent.parent.abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',funcAjax, 'POST','funcion=15&rolIngreso=175_0&iR='+bD(iR),true);
}


function actualizarTableroVotacion()
{
	gEx('gTutelasAsignadas').getStore().reload();
}
