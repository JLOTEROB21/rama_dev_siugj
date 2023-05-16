<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$consulta="SELECT claveUnidad,CONCAT('[',claveFolioCarpetas,'] ',nombreUnidad) AS nombreUnidad FROM _17_tablaDinamica";
	$arrUnidadGestion=$con->obtenerFilasArreglo($consulta);
	
	$arrEtapas="";
	$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=89 ORDER BY numEtapa";
	$rEtapas=$con->obtenerFilas($consulta);
	
	while($fEtapas=mysql_fetch_row($rEtapas))
	{
		$o="['".$fEtapas[0]."','".removerCerosDerecha($fEtapas[0]).". ".cv($fEtapas[1])."']";
		if($arrEtapas=="")
			$arrEtapas=$o;
		else
			$arrEtapas.=",".$o;
	}	
	
	$arrEtapas="[".$arrEtapas."]";
	$consulta="SELECT valor,texto FROM 1004_siNo";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	
?>

var arrSituacionAcuerdo=[['1','Activo','0F6B01'],['2','Revocado','F00'],['3','Cumplido','051569']];
var arrTipoCumplimiento=[['1','Inmediato'],['2','Diferido']];
var arrSituacion=<?php echo $arrEtapas?>;
var arrUnidadGestion=<?php echo $arrUnidadGestion?>;
var arrSiNo=<?php echo $arrSiNo?>;
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
                                                tbar:	[
                                                			
                                                            {
                                                            	xtype:'label',
                                                                html:'<span id="lblCriterio">Nombre del imputado:&nbsp;&nbsp;</span>'
                                                            },
                                                            {
                                                            	xtype:'textfield',
                                                                width:300,
                                                                enableKeyEvents:true,
                                                                id:'txtCriterio',
                                                                listeners:	{
                                                                				specialkey:function(field, e)
                                                                                			{
                                                                                            	 if ((e.getKey() == e.ENTER)||(e.getKey() == e.TAB))
                                                                                                 {
                                                                                                 	realizarBusqueda();
                                                                                                 }
                                                                                            }
                                                                				
                                                                			}
                                                            },'-',
                                                            {
                                                                icon:'../images/page_remove.png',
                                                                cls:'x-btn-text-icon',
                                                                text:'Generar informe de NO existencia de acuerdo',
                                                                handler:function()
                                                                        {
                                                                            imprimirDocumento(1);
                                                                        }
                                                                
                                                            },'-',
                                                            {
                                                                icon:'../images/page_accept.png',
                                                                cls:'x-btn-text-icon',
                                                                text:'Generar informe de existencia de acuerdo',
                                                                handler:function()
                                                                        {
                                                                            imprimirDocumento(2);
                                                                        }
                                                                
                                                            }
                                                		],
                                               
                                                items:	[
                                                         	crearGridResultadoBusqueda()   
                                                        ]
                                            }
                                         ]
                            }
                        )
                        
	gEx('txtCriterio').focus(false,500);  
    
    if(gE('autoload').value =='1')
    {
    	gEx('txtCriterio').setValue(gE('name').value);
        realizarBusqueda();
        gEx('txtCriterio').setReadOnly(true);
        
    }
                           
}

function crearGridResultadoBusqueda()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idAcuerdo'},
		                                                {name: 'tipoCumplimiento'},
		                                                {name: 'resumenAcuerdo'},
		                                                {name: 'fechaExtinsion', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'acuerdoAprobado'},
                                                        {name: 'carpetaAdministrativa'},
                                                        {name: 'documentos'},
                                                        {name: 'comentariosAdicionales'},
                                                        {name: 'delito'},
                                                        {name: 'imputado'},
                                                        {name: 'victimas'},
                                                        {name: 'situacionActual'},
                                                        {name: 'historialModificacionAcuerdo'},
                                                        {name: 'historialSituacionAcuerdo'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                              reader: lector,
                                              proxy : new Ext.data.HttpProxy	(

                                                                                {

                                                                                    url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                                                                                    timeout:300000

                                                                                }

                                                                            ),
                                              sortInfo: {field: 'carpetaAdministrativa', direction: 'ASC'},
                                              groupField: 'carpetaAdministrativa',
                                              remoteGroup:false,
                                              remoteSort: false,
                                              autoLoad:gE('autoload').value==1?true:false
                                              
                                          }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='103';
                                        
                                    }
                        )   
       
       
    var chkRow=new Ext.grid.CheckboxSelectionModel();
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                    	chkRow,
                                                        new  Ext.grid.RowNumberer({width:30}),
                                                        
                                                      {
                                                          header:'Imputado',
                                                          width:300,
                                                          sortable:true,
                                                          dataIndex:'imputado',
                                                          renderer:function(val)
                                                                  {
                                                                      return val;
                                                                  }
                                                      },
                                                        {
                                                            header:'Carpeta judicial',
                                                            width:160,
                                                            sortable:true,
                                                            dataIndex:'carpetaAdministrativa',
                                                            renderer:function(val,meta,registro)
                                                            			{
                                                                        	return val;
                                                                        }
                                                        },
                                                         {
                                                          header:'Hecho delictivo',
                                                          width:300,
                                                          hidden:true,
                                                          sortable:true,
                                                          dataIndex:'delito',
                                                          renderer:function(val)
                                                                  {
                                                                      return val;
                                                                  }
                                                      },
                                                        {
                                                            header:'Tipo de cumplimiento',
                                                            width:140,
                                                            sortable:true,
                                                            dataIndex:'tipoCumplimiento',
                                                            renderer:function(val)
                                                            			{
                                                                        	return formatearValorRenderer(arrTipoCumplimiento,val);
                                                                        }
                                                        },
                                                       	{
                                                          header:'Acuerdo aprobado',
                                                          width:120,
                                                          sortable:true,
                                                          dataIndex:'acuerdoAprobado',
                                                          renderer:function(val)
                                                                  {
                                                                      return formatearValorRenderer(arrSiNo,val);
                                                                  }
                                                      	},
                                                      	{
                                                          header:'Fecha de extinci&oacute;n de<br>la acci&oacute;n penal',
                                                          width:200,
                                                          sortable:true,
                                                          dataIndex:'fechaExtinsion',
                                                          renderer:function(val,meta,registro)
                                                                  {
                                                                  		var comp='';
                                                                        if(registro.data.historialModificacionAcuerdo!='0')
                                                                        {
                                                                            comp='<a href="javascript:verHistorialCambiosAcuerdo(\''+bE(registro.data.idAcuerdo)+'\')"><img width=\'14\' height=\'14\' src=\'../images/report.png\' title=\'Ver historial\' alt=\'Ver historial\'></a>&nbsp;&nbsp;';
                                                                        }
                                                                        if(val)
                                                                            return comp+val.format('d/m/Y');
                                                                  		
                                                                  }
                                                      },
                                                      {
                                                          header:'Situaci&oacute;n actual',
                                                          width:140,
                                                          sortable:true,
                                                          dataIndex:'situacionActual',
                                                          renderer:function(val,meta,registro)
                                                                  {
                                                                      var comp='';
                                                                      if(registro.data.historialSituacionAcuerdo!='0')
                                                                      {
                                                                          comp='<a href="javascript:verHistorialSituacionAcuerdo(\''+bE(registro.data.idAcuerdo)+'\')"><img width=\'14\' height=\'14\' src=\'../images/report.png\' title=\'Ver historial\' alt=\'Ver historial\'></a>&nbsp;&nbsp;';
                                                                      }
                                                                      var pos=existeValorMatriz(arrSituacionAcuerdo,val);
                                                                      var leyenda=arrSituacionAcuerdo[pos][1];
                                                                      
                                                                      leyenda='<span style="color:#'+arrSituacionAcuerdo[pos][2]+'; font-weight:bold">'+leyenda+'</span>';
                                                                      
                                                                      return comp+leyenda;
                                                                  }
                                                      }
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridResultadoBusqueda',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            columnLines : true,  
                                                            sm:chkRow,                                                          
                                                            view:new Ext.grid.GroupingView({
                                                                                                forceFit:false,
                                                                                                showGroupName: false,
                                                                                                enableGrouping :false,
                                                                                                enableNoGroups:false,
                                                                                                enableGroupingMenu:false,
                                                                                                hideGroupedColumn: false,
                                                                                                startCollapsed:false,
                                                                                                enableRowBody:true,
                                                                            					getRowClass : formatearFila
                                                                                            })
                                                        }
                                                    );
	
    chkRow.on('rowselect',function(sm,nFila,registro)
    						{
                            	if(sm.getSelections().length==1)
                                {
                                	gEx('txtCriterio').setValue(registro.data.imputado);
                                }
                            }
    		)                                                    
    return 	tblGrid;	
}


function abrirRegistroSolicitud(iF,iR)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=	[
                    ['idRegistro',bD(iR)],
                    ['idFormulario',bD(iF)],
                    ['dComp',bE('auto')],
                    ['acto',bE('0')]
                ]
                
    if(window.parent)             
        window.parent.abrirVentanaFancy(obj);
    else
        window.parent.abrirVentanaFancy(obj);
}

function formatearFila(record, rowIndex, p, ds) 
{
	var lblDocumentosAcuerdo='<br />(Sin documentos asociados)';
    var o;
   if(record.data.documentos.length>0)
   {
   		lblDocumentosAcuerdo='';
   		for(x=0;x<record.data.documentos.length;x++)
        {
        	var arExtension=record.data.documentos[x][1].split('.');
        	o='<a href="javascript:mostrarVisorDocumentoProceso(\''+arExtension[arExtension.length-1]+'\','+record.data.documentos[x][0]+')">'+record.data.documentos[x][1]+' ('+bytesToSize(parseInt(record.data.documentos[x][2]),0)+')</a>';
            if(lblDocumentosAcuerdo=='')
            	lblDocumentosAcuerdo=o;
            else
            	lblDocumentosAcuerdo+='<br>'+o;
        }
   }
    
	var xf = Ext.util.Format;
    p.body = '<br><br><table width="100%">'+(record.data.delito!=''?'<tr><td width="30"></td><td><b>Delito</b><br><br />'+record.data.delito+'<br><br /></td></tr>':'')+'<tr><td width="30"></td><td><b>V&iacute;ctimas</b><br><br />'+record.data.victimas+'<br><br /></td></tr>'+
    		'<tr><td width="30"></td><td><b>Resumen del acuerdo</b><br><br>'+(record.data.resumenAcuerdo.trim()==''?'(Sin resumen)':record.data.resumenAcuerdo)+
    		'</td></tr><tr><td width="30"></td><td><br><b>Comentarios adicionales</b><br><br>'+(record.data.comentariosAdicionales.trim()==''?'(Sin comentarios)':record.data.comentariosAdicionales)+
            '</td></tr><tr><td width="30"></td><td><br><b>Documentos del acuerdo</b><br><br>'+lblDocumentosAcuerdo+'<br></td></tr></table><br><br>';
    return 'x-grid3-row-expanded';
}

function mostrarVisorDocumentoProceso(extension,idDocumento,registro)
{
	var obj={};
    obj.url='../visoresGaleriaDocumentos/visorDocumentosGeneral.php';
    obj.ancho='100%';
    obj.alto='100%';
    obj.params=	[['iD',bE('iD_'+idDocumento)],['cPagina','sFrm=true']];
    abrirVentanaFancy(obj);
	
}


function realizarBusqueda()
{
	gEx('gridResultadoBusqueda').getStore().removeAll();    
    
    if(gEx('txtCriterio').getValue()!='')
    {
        gEx('gridResultadoBusqueda').getStore().load	(
                                                            	{
                                                                	url:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                                                                    params:	{
                                                                                funcion:103,
                                                                                
                                                                                valor:gEx('txtCriterio').getValue()
                                                                            }
                                                            	}
  	                                                      )
	}                                                          
}

var primeraCargaFrame=true;
function frameLoad(iFrame)
{
    if(!primeraCargaFrame)
    {
        setTimeout(
                        function()
                        {
                            iFrame.contentWindow.print()
                        }, 10
                   );
        
        
    }
    else
        primeraCargaFrame=false;
    
}

function imprimirDocumento(tipoAdocumento)
{
	var listaAcuerdos=-1;      
    var gridResultadoBusqueda=gEx('gridResultadoBusqueda');
    var x;
    var fila;
    var filas=gridResultadoBusqueda.getSelectionModel().getSelections();
    for(x=0;x<filas.length;x++)
    {
    	fila=filas[x];
        if(listaAcuerdos==-1)
        	listaAcuerdos=fila.data.idAcuerdo;
        else
        	listaAcuerdos+=','+fila.data.idAcuerdo;
    }
    
    if((tipoAdocumento==2)&&(listaAcuerdos==-1))
    {
    	msgBox('Debe seleccionar almenos un acuerdo en el cual participa el imputado en cuesti&oacute;n');
    	return;
    }
    
    var iFrame=document.getElementById('frameEnvio');
    if(iFrame)
    {
        iFrame.parentNode.removeChild(iFrame);
    }
    
    primeraCargaFrame=false;
    iFrame=document.createElement('iFrame');
    iFrame.name='frameEnvio';
    iFrame.id='frameEnvio';
    //iFrame.style='display:none';
    iFrame.style='width:1px; height:1px;';
    document.body.appendChild(iFrame);
    asignarEvento(iFrame,'load',frameLoad);

    iFrame.src='../modulosEspeciales_SGJP/generarInformeAcuerdoReparatorio.php?tipoInfome='+tipoAdocumento+'&nombre='+gEx('txtCriterio').getValue()+'&listaAcuerdos='+listaAcuerdos;
}

function verHistorialSituacionAcuerdo(iA)
{
	mostrarBitacoraSituacionObjeto('2',bD(iA),arrSituacionAcuerdo,'Historial de Situaci&oacute;n de Acuerdo');
}


function verHistorialCambiosAcuerdo(iA)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridHistorialAcuerdo(iA)
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Historial cambios',
										width: 650,
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


function crearGridHistorialAcuerdo(iA)
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
                                                        {name:'fechaOperacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'fechaExtinsionAnterior', type:'date', dateFormat:'Y-m-d'},
		                                                {name:'responsable'},
                                                        {name: 'comentariosAdicionales'}
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
                                                            sortInfo: {field: 'fechaOperacion', direction: 'DESC'},
                                                            groupField: 'fechaOperacion',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='231';
                                        proxy.baseParams.idAcuerdo=bD(iA);

                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'Fecha',
                                                                width:200,
                                                                sortable:true,
                                                                align:'left',
                                                                dataIndex:'fechaOperacion',
                                                                renderer:function(val)
                                                                		{
                                                                        
                                                                        	return formatoTitulo(val.format('d')+' de '+arrMeses[parseInt(val.format('m'))-1][1]+' de '+val.format('Y')+'<br>('+val.format('H:i:s')+' hrs.)');
                                                                        }
                                                            },                                                                                                                      
                                                            {
                                                                header:'Responsable',
                                                                width:350,
                                                                sortable:true,
                                                                align:'right',
                                                                dataIndex:'responsable',
                                                                renderer:formatoTitulo3
                                                            }
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                    {
                                                        id:'gridHistorialAcuerdo',
                                                        store:alDatos,
                                                       	region:'center',
                                                        
                                                        height:600,
                                                        frame:false,
                                                        border:true,
                                                        cm: cModelo,
                                                        columnLines : false,
                                                        stripeRows :true,
                                                        loadMask:true,
                                                                                                                        
                                                        view:new Ext.grid.GroupingView({
                                                                                            forceFit:false,
                                                                                            showGroupName: false,
                                                                                            enableGrouping :false,
                                                                                            enableNoGroups:false,
                                                                                            enableGroupingMenu:false,
                                                                                            hideGroupedColumn: false,
                                                                                            startCollapsed:false,
                                                                                            enableRowBody:true,
                                                                                            getRowClass : formatearFilaHistorial
                                                                                        })
                                                    }
                                                );
        return 	tblGrid;	
}


function formatoTitulo3(val)
{
	return '<div style="font-size:11px; height:45px; color:#040033; word-wrap: break-word;white-space: normal;"><img src="../images/user_gray.png">'+(val)+'</div>';
}


function formatearFilaHistorial(record, rowIndex, p, ds)
{
	var xf = Ext.util.Format;
    p.body = 	'<BR><table width="100%"><tr><td width="30"></td><td width="200"><span style="color: #001C02"><b>Fecha de extinci&oacute;n de la acci&oacute;n penal:</b></span><br><br><span style="color: #3B3C3B"></td><td width="300">'+record.data.fechaExtinsionAnterior.format('d/m/Y')+'</td></tr>'+
    			'<tr><td></td><td conspan="2"><span style="color: #001C02"><b>Comentarios adicionales:</b></span><br><br><span style="color: #3B3C3B">' + ((record.data.comentariosAdicionales.trim()=="")?"(Sin comentarios)":record.data.comentariosAdicionales) + '</span></td></tr></table><br><br><br>';
    return 'x-grid3-row-expanded';
}

function formatoTitulo(val)
{
	return '<span style="font-size:11px; color:#040033">'+val+'</span>';
}

function formatoTitulo2(val)
{
	return '<div style="font-size:11px; color:#040033;; height:45px; word-wrap: break-word;white-space: normal; ">'+val+'</div>';
}
