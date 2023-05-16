<?php session_start();
	include("conexionBD.php");

	$consultaDepartamento="SELECT cveEstado,estado FROM 820_estados ORDER BY estado";
	$arrDepartamento=$con->obtenerFilasArreglo($consultaDepartamento);

	$consultaMunicipio="SELECT cveMunicipio,municipio FROM 821_municipios ORDER BY municipio";
	$arrMunicipio=$con->obtenerFilasArreglo($consultaMunicipio);
	
	$esUsuarioLogueado=false;
	if(isset($_SESSION["idUsr"]) &&($_SESSION["idUsr"]!="")&&($_SESSION["idUsr"]!=-1))
	{
		$esUsuarioLogueado=true;
	}

?>

var esUsuarioLogueado=<?php echo $esUsuarioLogueado?"true":"false" ?>;
var arrDepartamento=<?php echo $arrDepartamento?>;
var arrMunicipio=<?php echo $arrMunicipio?>;

var arrBienEmbargado=[['1','Inmueble'],['2','Automotor'],['5','Establecimiento de comercio'],['1,2,5','Cualquiera']];
var arrSituacion=[['8','Remates activos'],['10','Remates terminados'],['8,10','Todos']];

Ext.onReady(inicializar);

function inicializar()
{
	var gridInformacion=crearGridInformacion();
    var regDepto=null;
    var regMunicipio=null;
	new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                border:false,
                                                layout:'border',
                                                items:	[
                                                
                                                			{
                                                            	xtype:'panel',
                                                                layout:'absolute',
                                                                height:200,
                                                                defaultType: 'label',
                                                                border:false,
                                                                cls:'panelSiugj',
                                                                title:'<span style="font-size:30px">Remate de bienes</span>',
                                                                region:'north',
                                                                items:	[
                                                                			{
                                                                                x:10,
                                                                                y:10,
                                                                                cls:'SIUGJ_Etiqueta',
                                                                                html:'Categor&iacute;a:'
                                                                            },
                                                                            {
                                                                                x:150,
                                                                                y:5,
                                                                                html:'<div id="divComboCategoria">'
                                                                            },
                                                                            {
                                                                                id:'lblFechaRemate',
                                                                                x:580,
                                                                                y:10,
                                                                                 cls:'SIUGJ_Etiqueta',
                                                                                html:'Fecha de remate:'
                                                                            },
                                                                            {
                                                                                x:750,
                                                                                y:5,
                                                                                html:'<div id="divFechaRemate" style="width:150px">'
                                                                            },
                                                                            
                                                                            {
                                                                                id:'lblDepartamento',
                                                                                x:10,
                                                                                y:60,
                                                                               	cls:'SIUGJ_Etiqueta',
                                                                                html:'Departamento:'
                                                                            },
                                                                            {
                                                                                x:150,
                                                                                y:55,
                                                                                html:'<div id="divComboDepartamento">'
                                                                            },
                                                                            
                                                                            {
                                                                                id:'lblMunicipio',
                                                                                x:580,
                                                                                y:60,
                                                                                cls:'SIUGJ_Etiqueta',
                                                                                html:'Municipio:'
                                                                            },
                                                                            {
                                                                                x:750,
                                                                                y:55,
                                                                                html:'<div id="divComboMunicipio">'
                                                                            },
                                                                            
                                                                            {
                                                                                x:10,
                                                                                y:105,
                                                                                cls:'SIUGJ_Etiqueta',
                                                                                html:'Situación:'
                                                                            },                                                      
                                                                            {
                                                                                x:150,
                                                                                y:100,
                                                                                html:'<div id="divComboSituacion">'
                                                                            },
                                                                            {
                                                                                x:580,
                                                                                y:105,
                                                                                cls:'SIUGJ_Etiqueta',
                                                                                html:'Aval&uacute;o desde'
                                                                            
                                                                            },
                                                                            {
                                                                                x:750,
                                                                                y:100,
                                                                                hidden:false,
                                                                                width:120,                    
                                                                                id:'txtImporteInicial',
                                                                                html:'<input class="SIUGJ_Control" type="text" class="btnEvento" style="width:150px; height:20px; font-size:14px; text-align:right" id="importeInicial" value="" onkeypress="return soloNumero(event,true,false,this)" onblur="validarImporte(this)" />'
                                                                            },
                                                                            {
                                                                                x:920,
                                                                                y:105,
                                                                                cls:'SIUGJ_Etiqueta',
                                                                                html:'Hasta'
                                                                            },
                                                                            {
                                                                                x:990,
                                                                                y:100,
                                                                                hidden:false,
                                                                                width:120,
                                                                                id:'txtImporteFinal',
                                                                                html:'<input class="SIUGJ_Control"  type="text" class="btnEvento" style="width:150px; height:20px; font-size:14px; text-align:right" id="importeFinal" value="" onkeypress="return soloNumero(event,true,false,this)" onblur="validarImporte(this)" />'
                                                                            }
                                                                		]
                                                            },
                                                            gridInformacion
                                                
                                                
                                                            
                                                            
                                                        ]
                                            }
                                         ]
                            }
                        )   

	var cmbBienSolicitado=crearComboExt('cmbBienSolicitado',arrBienEmbargado,0,0,350,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboCategoria'});
    
    cmbBienSolicitado.on('select',function()
                                            {
                                            	obtenerInfomacionFiltro();
                                            }
    					);
	cmbBienSolicitado.setValue('1,2,5');
    
    
    var cmbSituacion=crearComboExt('cmbSituacion',arrSituacion,0,0,200,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboSituacion'});
    
    cmbSituacion.setValue('8,10');
    
    cmbSituacion.on('select',function()
                                        {
                                            obtenerInfomacionFiltro();
                                        }
   					 );
    
    new Ext.form.DateField	(    {
                                      x:0,
                                      y:0,
                                      ctCls:'campoFechaSIUGJ',
                                      xtype:'datefield',
                                      renderTo:'divFechaRemate',
                                      id:'dteFechaRemate',
                                      listeners:{
                                                  	select:function(ctrl,value)
                                                          	{
                                                              //var valorFecha=value.format('Y-m-d');
                                                                  obtenerInfomacionFiltro();
                                                              }
                                                  
                                                  }
                                  }
                             )
    
    
    
    var oConfDepa=	{
                        idCombo:'cmbDepartamento',
                        anchoCombo:350,
                        campoDesplegar:'estado',
                        campoID:'cveEstado',
                        funcionBusqueda:1,
                        raiz:'registros',
                        nRegistros:'numReg',
                        posX:0,
                        posY:0,
                        ctCls:'campoComboWrapSIUGJAutocompletar',
		                listClass:'listComboSIUGJ',
                        renderTo:'divComboDepartamento',
                        paginaProcesamiento:'../modulosEspeciales_SIUGJ/paginasFunciones/funcionesBienes.php',
                        confVista:	'<tpl for="."><div class="search-item"><table><tr><td width="380">{estado}</td><td width="50"></td></tr></table></div></tpl>',
                        campos:	[
                                    {name:'cveEstado'},
                                    {name:'estado'},
                                ],
                        funcAntesCarga:function(dSet,combo)
                                    {
                                        regDepto=null;
                                        
                                        dSet.baseParams.valorBusqueda=gEx('cmbDepartamento').getRawValue();
                                    },
                        funcElementoSel:function(combo,registro)
                                    {
                                    	regDepto=registro;
                                    	obtenerInfomacionFiltro();
                                    }  
    			};
    
	var cmbDepartamento=crearComboExtAutocompletar(oConfDepa);
    
    
    
    var oConfMuni=	{
                        idCombo:'cmbMunicipio',
                        anchoCombo:350,
                        campoDesplegar:'municipio',
                        campoID:'cveMunicipio',
                        funcionBusqueda:2,
                        raiz:'registros',
                        nRegistros:'numReg',
                        renderTo:'divComboMunicipio',
                        posX:0,
                        posY:0,
                        ctCls:'campoComboWrapSIUGJAutocompletar',
	                  	listClass:'listComboSIUGJ',
                        paginaProcesamiento:'../modulosEspeciales_SIUGJ/paginasFunciones/funcionesBienes.php',
                        confVista:	'<tpl for="."><div class="search-item"><table><tr><td width="380">{municipio}</td><td width="50"></td></tr></table></div></tpl>',
                        campos:	[
                                    {name:'cveMunicipio'},
                                    {name:'municipio'}
                                ],
                        funcAntesCarga:function(dSet,combo)
                                    {
                                        regMunicipio=null;
                                        dSet.baseParams.cveEstado=regDepto?regDepto.data.cveEstado:'';
                                        dSet.baseParams.valorBusqueda=gEx('cmbMunicipio').getRawValue();
                                    },
                        funcElementoSel:function(combo,registro)
                                    {
                                    	regMunicipio=registro;
                                        obtenerInfomacionFiltro();
                                    }  
    			};
    
	var cmbMunicipio=crearComboExtAutocompletar(oConfMuni);
    obtenerInfomacionFiltro();
}


function crearGridInformacion()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
 	                                              		{name:'idRegistro'},
                                                        {name:'numCaso'},
                                                        {name: 'codigoUnico'},
                                                        {name: 'bienSolicitado'},
                                                        {name: 'cveDepartamento'},
                                                        {name: 'cveMunicipio'},
                                                        {name: 'evaluo'},
                                                        {name:'fechaRemate'},
                                                        {name:'descripcion'},
                                                        {name: 'situacion'},
                                                        {name: 'postulado'},
                                                        {name: 'idArchivoImagen'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {
                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesBienes.php'
                                                                                              }
                                                                                          ),
                                                            sortInfo: {field: 'idRegistro', direction: 'ASC'},
                                                            groupField: 'idRegistro',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:false
                                                        }) 
                                                        
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='3';
                                        //proxy.baseParams.bienSolicitado=gEx('cmbBienSolicitado').getValue();
                                    }
                        )
                        
	var tamPagina=100;
    var paginador=	new Ext.PagingToolbar	(
                                                {
                                                      pageSize: tamPagina,
                                                      store: alDatos,
                                                      displayInfo: true,
                                                      disabled:false
                                                  }
                                               )
                                               
	var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});                                                
                                                
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer({width:40}),
                                                        <?php
														if($esUsuarioLogueado)
														{
														?>
                                                        {
                                                            header:'Postular',
                                                            width:110,
                                                            align:'center',
                                                            sortable:true,
                                                            dataIndex:'idRegistro',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	if(registro.data.postulado=='0')
	                                                                    	return '<a href="javascript:registrarPropuestaPostulacion(\''+bE(val)+'\')"><img src="../images/pencil.png" title="Registrar propuesta para remate" alt="Registrar propuesta para remate"/> Registrar</a>'
										                                return '<a href="javascript:registrarPropuestaPostulacion(\''+bE(val)+'\')"><img src="../images/icon_big_tick.gif" title="Postulado para remate" alt="Postulado para remate"/> Postulado</a>'                                            
                                                                    }
                                                        },
														<?php
														}
                                                        ?>
                                                         {
                                                            header:'',
                                                            width:120,
                                                            sortable:true,
                                                            dataIndex:'idArchivoImagen',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	meta.attr='style="min-height: 21px;white-space: normal;line-height: 20px !important;height: auto"';
                                                                        if(val!='')
	                                                                    	return '<img src="../paginasFunciones/obtenerArchivos.php?id='+bE(val)+'" style="width: 100px; height: 100px;">';
                                                                         return '<img src="../images/imgNoDisponible.jpg" style="width: 100px; height: 100px;">';   
                                                                            
                                                                    
                                                                    }
                                                        },
                                                        {
                                                            header:'Clave',
                                                            width:100,
                                                            sortable:true,
                                                            dataIndex:'numCaso'
                                                        },
                                                        {
                                                            header:'Categor&iacute;a',
                                                            width:250,
                                                            align:'center',
                                                            sortable:true,
                                                            dataIndex:'bienSolicitado',
                                                            renderer:function(val)
                                                                    {
                                                                        return formatearValorRenderer(arrBienEmbargado,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Departamento',
                                                            width:180,
                                                            align:'center',
                                                            sortable:true,
                                                            dataIndex:'cveDepartamento',
                                                            renderer:function(val)
                                                                    {
                                                                    	if(val==' ')
                                                                        	return ' '
                                                                        return formatearValorRenderer(arrDepartamento,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Municipio',
                                                            width:180,
                                                            align:'center',
                                                            sortable:true,
                                                            dataIndex:'cveMunicipio',
                                                            renderer:function(val)
                                                                    {
                                                                    	if(val==' ')
                                                                        	return ' '
                                                                        return formatearValorRenderer(arrMunicipio,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Aval&uacute;o',
                                                            width:160 ,
                                                            align:'right',
                                                            sortable:true,
                                                            dataIndex:'evaluo',
                                                            renderer:'usMoney'
                                                        },
                                                        {
                                                            header:'Fecha de remate',
                                                            width:180,
                                                            align:'center',
                                                            sortable:true,
                                                            dataIndex:'fechaRemate',
                                                            renderer:function(val)
                                                                    {
                                                                        return val;
                                                                    }
                                                        },
                                                        {
                                                            header:'Descripción del bien',
                                                            width:300,
                                                            sortable:true,
                                                            dataIndex:'descripcion',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	meta.attr='style="min-height: 21px;white-space: normal;line-height: 20px !important;height: auto"';
                                                                        return val;
                                                                    }
                                                        }
                                                    ]
                                                );
                                                
   var tblGrids=new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridInformacion',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            border:false,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            cls:'gridSiugjPrincipal',
                                                            columnLines : false,
                                                            bbar:[paginador],
                                                            tbar:	[
                                                                        {
                                                                            icon:'../images/page_white_edit.png',
                                                                            cls:'x-btn-text-icon',
                                                                            disabled:false,
                                                                            id:'btnCompra',
                                                                            text:'Limpiar filtros',
                                                                            handler:function()
                                                                            {
                                                                                limpiarCampos();
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
                                                    
		                                                                                                                                                  
                                
	return 	tblGrids;                                                                                                                                                                                              
}

function obtenerInfomacionFiltro()
{
	gEx('gridInformacion').getStore().load	(
    										{
                                            	url:'../modulosEspeciales_SIUGJ/paginasFunciones/funcionesBienes.php',
                                                params:	{
                                                			funcion:4,
                                                            bienSolicitado:gEx('cmbBienSolicitado').getValue(),
                                                            cveDepartamento:gEx('cmbDepartamento').getValue(),
                                                            cveMunicipio:gEx('cmbMunicipio').getValue(),
                                                   			situacion:gEx('cmbSituacion').getValue(),
                                                            fechaRemate:gEx('dteFechaRemate').getValue(),
                                                            importeInicial:gE('importeInicial').value,
                                                            importeFinal:gE('importeFinal').value
                                                		}
                                            }
    									)
}

function limpiarCampos()
{
	gEx('cmbBienSolicitado').setValue('1,2,5');
    gEx('dteFechaRemate').setValue('');
    gEx('cmbDepartamento').setValue('');
    gEx('cmbMunicipio').setValue('');
    gEx('cmbSituacion').setValue('8,10');
    gE('importeInicial').value='';
    gE('importeFinal').value='';
    
    obtenerInfomacionFiltro();
}

function validarImporte()
{
	

	obtenerInfomacionFiltro();
    
    
}


function registrarPropuestaPostulacion(idBien)
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
            obj.params=[['idFormulario',1225],['idRegistro',arrResp[1]],['idReferencia',-1],
            		['dComp',arrResp[2]],['actor',arrResp[3]]];
            abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesBienes.php',funcAjax, 'POST','funcion=5&idBien='+bD(idBien),true);
 
}


function recargarContenedorCentral()
{
	obtenerInfomacionFiltro();
}