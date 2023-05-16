<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$fechaActual=date("Y-m-d");
	$diaActual=date("N",strtotime($fechaActual));
	$fechaFinal=7-$diaActual;
	
	$fechaFinal=date("Y-m-d",strtotime("+".$fechaFinal." days",strtotime($fechaActual)));
	
	$consulta="SELECT  id__4_tablaDinamica,tipoAudiencia FROM _4_tablaDinamica";
	$arrAudiencias=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__15_tablaDinamica,nombreSala FROM _15_tablaDinamica";
	$arrSalas=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__15_tablaDinamica, concat(nombreSala, ' [',e.nombreInmueble,']') FROM _15_tablaDinamica s,_1_tablaDinamica e 
			where e.id__1_tablaDinamica=s.idReferencia and id__15_tablaDinamica in(SELECT DISTINCT idSala FROM 7000_eventosAudiencia) 
			order by nombreSala,nombreInmueble";
	$arrSalasBusqueda=$con->obtenerFilasArreglo($consulta);

	$consulta="SELECT id__17_tablaDinamica,nombreUnidad FROM _17_tablaDinamica";
	$arrUnidades=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idSituacion,descripcionSituacion FROM 7011_situacionEventosAudiencia where descripcionSituacion<>''";
	$arrSituacionEvento=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idSituacion,icono,tamano FROM 7011_situacionEventosAudiencia";
	$arrSituaciones=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__1_tablaDinamica,nombreInmueble FROM _1_tablaDinamica";
	$arrEdificios=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__477_tablaDinamica,tipoJuicio FROM _477_tablaDinamica";
	$arrTipoJuicio=$con->obtenerFilasArreglo($consulta);
?>

var arrTipoJuicio=<?php echo $arrTipoJuicio?>;
var arrSalasBusqueda=<?php echo $arrSalasBusqueda?>;
var arrSituacionEvento=<?php echo $arrSituacionEvento?>;
var arrEdificios=<?php echo $arrEdificios?>;
var arrSalas=<?php echo $arrSalas?>;
var arrAudiencias=<?php echo $arrAudiencias?>;
var arrUnidades=<?php echo $arrUnidades?>;
var arrSemaforo=<?php echo $arrSituaciones?>;

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
                                                                html:'&nbsp;&nbsp;&nbsp;<b>Juzgado:</b>&nbsp;<span style="color: #900"><b>'+gE('nombreUnidad').value+'</b></span>&nbsp;&nbsp;'
                                                            },'-',
                                                			{
                                                            	xtype:'label',
                                                                html:'&nbsp;&nbsp;&nbsp;<b>Periodo del:</b>&nbsp;&nbsp;&nbsp;'
                                                            },
                                                            {
                                                            	xtype:'datefield',
                                                                id:'dtePeriodoInicial',
                                                                value:'<?php echo $fechaActual?>',
                                                                listeners:	{
                                                                				select:function()
                                                                                		{
                                                                                        	recargarGridEventos();
                                                                                        }
                                                                                        
                                                                			}
                                                            },'-',
                                                            {
                                                            	xtype:'label',
                                                                html:'&nbsp;&nbsp;&nbsp;<b>Periodo al:</b>&nbsp;&nbsp;&nbsp;'
                                                            },
                                                            {
                                                            	xtype:'datefield',
                                                                id:'dtePeriodoFinal',
                                                                value:'<?php echo $fechaActual?>',
                                                                listeners:	{
                                                                				select:function()
                                                                                		{
                                                                                        	recargarGridEventos();
                                                                                        }
                                                                                        
                                                                			}
                                                            }
                                                            
                                                            <?php
																if(($tipoMateria=="C")&&(existeRol("'1_0'")))
																{
															?>
                                                            ,'-',
                                                            {
                                                                icon:'../images/pencil.png',
                                                                cls:'x-btn-text-icon',
                                                                text:'Marcar audiencias como...',
                                                                menu: 	[
                                                                			{
                                                                                icon:'../images/bullet-green.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Confirmada',
                                                                                handler:function()
                                                                                        {
                                                                                        	actualizarSituacionAudiencia(1);
                                                                                       	}
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/bullet-blue.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Finalizada',
                                                                                handler:function()
                                                                                        {
                                                                                        	actualizarSituacionAudiencia(2);
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/bullet-black.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Cancelada',
                                                                                handler:function()
                                                                                        {
                                                                                        	actualizarSituacionAudiencia(3);
                                                                                        }
                                                                                
                                                                            }
                                                                		]
                                                             }
                                                                <?php
															}
																?>
                                                                
                                                            
                                                		],
                                                items:	[
                                                            crearGridEventos()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}

function actualizarSituacionAudiencia(s)
{
	var lblSituacion='';
   
    switch(s)
    {
    	case 1:
        	lblSituacion='Confirmadas';
           
        break;
        case 2:
        	lblSituacion='Finalizadas';
            
        break;
        case 3:
        	lblSituacion='Canceladas';
             
        break;
    }
	var fila=gEx('dEventos').getSelectionModel().getSelections();
    if(fila.length==0)
    {
        msgBox('Debe seleccionar la audiencia cuya situaci&oacute;n desea cambiar');
        return;
    }
    
    
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            width:550,
                                                            height:60,
                                                            id:'txtComentariosAdicionales',
                                                            xtype:'textarea'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Marcar audiencias como '+lblSituacion,
										width: 600,
										height:200,
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
                                                                	gEx('txtComentariosAdicionales').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		function resp(btn)
                                                                        {
                                                                            if(btn=='yes')
                                                                            {
                                                                                var lAudiencias='';
                                                                                var x;
                                                                                for(x=0;x<fila.length;x++)
                                                                                {
                                                                                    if(lAudiencias=='')
                                                                                        lAudiencias=fila[x].data.idEvento;
                                                                                    else
                                                                                        lAudiencias+=','+fila[x].data.idEvento;
                                                                                }
                                                                                
                                                                                function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                        gEx('dEventos').getStore().reload();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Juzgados.php',funcAjax, 'POST','funcion=8&lAudiencias='+lAudiencias+'&s='+s+'&c='+cv(gEx('txtComentariosAdicionales').getValue()),true);
                                                                            }
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer marcar las audiencias como <b>'+lblSituacion+'</b>?',resp);
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

function recargarGridEventos()
{
	gEx('dEventos').getStore().reload();
    
}

function crearGridEventos()
{

	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idEvento'},
                                                        {name: 'carpetaAdministrativa'},
                                                        {name: 'idCarpeta'},
		                                                {name: 'fechaEvento', type:'date', dateFormat:'Y-m-d'},
		                                                {name: 'horaInicial', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                               	{name: 'horaFinal', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'tipoAudiencia'},
                                                        {name: 'sala'},
                                                        {name: 'unidadGestion'},
                                                        {name: 'situacion'},
                                                        {name: 'juez'}  ,
                                                        {name: 'horaInicialReal', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                               	{name: 'horaFinalReal', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'urlMultimedia'},
                                                        {name: 'iFormulario' }, 
                                                        {name: 'iRegistro' },
                                                        {name: 'iFormularioSituacion'},                                                     
                                                        {name: 'iRegistroSituacion'} ,
                                                        {name: 'urlCanal'},
                                                        {name: 'notificacionMAJO'},
                                                        {name: 'mensajeMAJO'},                                                       
                                                        {name: 'edificio'}, 
                                                        {name: 'actores'},        
                                                        {name: 'demandados'} ,
                                                        {name: 'tipoJuicio'}  ,
                                                        {name: 'secretario'},
                                                        {name: 'otroTipoAudiencia'},
                                                        {name: 'notificacionMail'},
                                                        {name: 'mensajeMail'}                                                                                  
                                                                                                    
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
                                                            sortInfo: {field: 'fechaEvento', direction: 'ASC'},
                                                            groupField: 'fechaEvento',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	var dtePeriodoInicial=gEx('dtePeriodoInicial');
                                        var dtePeriodoFinal=gEx('dtePeriodoFinal');
                                    	proxy.baseParams.funcion='3';
                                        proxy.baseParams.uG=gE('uGestion').value;
                                        proxy.baseParams.fechaInicio=dtePeriodoInicial.getValue().format('Y-m-d');
                                        proxy.baseParams.fechaFin=dtePeriodoFinal.getValue().format('Y-m-d');
                                    }
                        )   
       
       
       var filters = new Ext.ux.grid.GridFilters	(
                                                        {
                                                            filters:	[
                                                            				{
                                                                            	type:'string',
                                                                                dataIndex:'idEvento'
                                                                            },
                                                            				{
                                                                            	type:'string',
                                                                                dataIndex:'carpetaAdministrativa'
                                                                            },
                                                                            {
                                                                            	type:'list',
                                                                                dataIndex:'situacion',
                                                                                options:arrSituacionEvento,
                                                                                phpMode:true
                                                                            },
                                                                            {
                                                                            	type:'date',
                                                                                dataIndex:'fechaEvento'
                                                                            },
                                                                            {
                                                                            	type:'list',
                                                                                dataIndex:'tipoAudiencia',
                                                                                options:arrAudiencias,
                                                                                phpMode:true
                                                                            },
                                                                            {
                                                                            	type:'list',
                                                                                dataIndex:'sala',
                                                                                options:arrSalasBusqueda,
                                                                                phpMode:true
                                                                            },
                                                                            {
                                                                            	type:'list',
                                                                                dataIndex:'edificio',
                                                                                options:arrEdificios,
                                                                                phpMode:true
                                                                            },
                                                                            {
                                                                            	type:'string',
                                                                                dataIndex:'juez'
                                                                            }
                                                            			]
                                                        }
                                                    );  
       
       var chkRow=new Ext.grid.CheckboxSelectionModel({checkOnly :false});
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            chkRow,
                                                            {
                                                                header:'ID Evento',
                                                                width:70,
                                                                sortable:true,
                                                                dataIndex:'idEvento'
                                                                
                                                            },
                                                            
                                                            
                                                            <?php
															if((existeRol("'69_0'"))||(existeRol("'1_0'"))||(existeRol("'107_0'"))||existeRol("'112_0'")||existeRol("'81_0'"))

															{
															?>
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'idEvento',
                                                                css:'text-align:center;vertical-align:middle !important;',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	//if(registro.data.situacion=='1')
	                                                                            return '<a href="javascript:registrarSolicitudAudiencia(\''+bE(val)+'\',\''+bE(registro.data.carpetaAdministrativa)+'\',\''+bE(registro.data.idCarpeta)+'\')"><img src="../images/book_edit.png" width="14" height="14" alt="Generar nueva audiencia" title="Generar nueva audiencia"><a>';
                                                                        }
                                                            },
                                                            <?php
															}
															?>
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                css:'text-align:center;vertical-align:middle !important;',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var icono='';
                                                                            meta.attr='style="padding: 0px !important;"';
                                                                        	icono=formatearValorRenderer(arrSemaforo,val);    
                                                                            var tamano=formatearValorRenderer(arrSemaforo,val,2);                                                                            
                                                                            return '<img src="'+icono+'" width="'+tamano+'" height="'+tamano+'" title="'+formatearValorRenderer(arrSituacionEvento,val)+'" alt="'+formatearValorRenderer(arrSituacionEvento,val)+'">';
                                                                        	
                                                                        }
                                                            },
                                                             {
                                                                header:'Situaci&oacute;n audiencia',
                                                                width:170,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrSituacionEvento,val));
                                                                        }
                                                            },
                                                            {
                                                                header:'',
                                                                width:60,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                css:'text-align:left;vertical-align:middle !important;',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	
                                                                            var comp2='';
                                                                            
                                                                            <?php
																			if($tipoMateria!="SC")
																			{
																			?>
                                                                           	switch(val)
                                                                            {
                                                                            	case '4':
                                                                                	if(registro.data.urlCanal!='')
                                                                                		comp2='<a href="javascript:abrirVentanaSala(\''+bE(registro.data.sala)+'\')"><img src="../images/film_go.png" title="Visualizar audiencia" alt="Visualizar audiencia" /></a>'
                                                                                break;
                                                                                case '2':
                                                                                	if(registro.data.urlMultimedia!='')
                                                                                		comp2='<a href="javascript:abrirVideoGrabacion(\''+bE(registro.data.idEvento)+'\')"><img src="../images/control_play_blue.png" title="Visualizar grabaci&oacute;n" alt="Visualizar grabaci&oacute;n" /></a>'
                                                                              	break;
                                                                            }
                                                                            <?php
																			}
																			?>
                                                                            var comp='';
                                                                            if(registro.data.iRegistroSituacion!='-1')
                                                                            {
                                                                            	comp='<a href="javascript:abrirFormatoRegistro(\''+bE(registro.data.iFormularioSituacion)+'\',\''+
                                                                                		bE(registro.data.iRegistroSituacion)+'\')"><img src="../images/magnifier.png" title="Ver detalles..."'+
                                                                                        ' alt="Ver detalles..."></a> ';
                                                                            	if(comp2!='')
                                                                                	comp='&nbsp;&nbsp;'+comp;
                                                                            }
                                                                            
                                                                        	return comp2+ comp;
                                                                        	
                                                                        }
                                                            },
                                                            {
                                                                header:'Causa Penal',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa'
                                                            },
                                                            
                                                            {
                                                                header:'Fecha audiencia',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'fechaEvento',
                                                                renderer:function(val)
                                                                	{
                                                                    	return val.format('d/m/Y');
                                                                    }
                                                            },
                                                            {
                                                                header:'Hora programada de audiencia',
                                                                width:280,
                                                                sortable:true,
                                                                dataIndex:'horaInicial',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	var comp='';
                                                                        if(val.format('d')!=registro.data.horaFinal.format('d'))
                                                                        {
                                                                        	comp=' del '+registro.data.horaFinal.format('d/m/Y');
                                                                        }

                                                                    	return 'De las '+val.format('H:i')+' hrs. a las '+registro.data.horaFinal.format('H:i')+' hrs.'+comp
                                                                    }
                                                            },
<?php
															if((existeRol("'69_0'"))||(existeRol("'1_0'"))||existeRol("'112_0'")||existeRol("'107_0'"))
															{
															?>
                                                            {
                                                                header:'Notificacion MAJO',
                                                                width:120,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'notificacionMAJO',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	var comp='';
                                                                        var icono='';
                                                                    	if(val=='1')
                                                                        {
                                                                        	icono='icon_big_tick.gif';
                                                                            registro.data.mensajeMAJO='Enviado MAJO con &eacute;xito';
                                                                        }
                                                                        else
                                                                        {
                                                                        	if(val=='')
                                                                            {
                                                                            	icono='icon_info.gif';
                                                                                registro.data.mensajeMAJO='Sin registro en bit&aacute;cora';

                                                                            }
                                                                            else
                                                                        		icono='cross.png';
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        return '<a href="javascript:reenviarMAJO(\''+bE(registro.data.idEvento)+'\')"><img src="../images/arrow_refresh.PNG" title="Reenviar a MAJO" alt="Reenviar a MAJO"/></a>&nbsp;&nbsp;<img src="../images/'+icono+
                                                                        	'" title="'+cv(registro.data.mensajeMAJO,true,true)+'" alt="'+cv(registro.data.mensajeMAJO,true,true)+'" />'+comp;
                                                                    }
                                                            },
                                                            <?php
															}
															?>
                                                           {
                                                                header:'Notificacion Mail',
                                                                width:150,
                                                                align:'center',
                                                                
                                                                sortable:true,
                                                                dataIndex:'notificacionMail',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	if((parseInt(registro.data.situacion)!=1)&&(parseInt(registro.data.situacion)!=3))
                                                                        {
                                                                        	return '----';
                                                                        }
                                                                    	
                                                                    	var comp='';
                                                                        var icono='';
                                                                    	if(val=='1')
                                                                        {
                                                                        	icono='icon_big_tick.gif';
                                                                            registro.data.mensajeMAJO='E-mail de notificaci&oacute;n enviado con &eacute;xito';
                                                                        }
                                                                        else
                                                                        {
                                                                        	if(val=='')
                                                                            {
                                                                            	icono='icon_info.gif';
                                                                                registro.data.mensajeMAJO='Sin registro en bit&aacute;cora';

                                                                            }
                                                                            else
                                                                        		icono='cross.png';
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        return '<a href="javascript:reenviarNotificacionMail(\''+bE(registro.data.idEvento)+'\')"><img src="../images/arrow_refresh.PNG" title="Reenviar Notificación Mail" alt="Reenviar Notificación Mail"/></a>&nbsp;&nbsp;<img src="../images/'+icono+
                                                                        	'" title="'+cv(registro.data.mensajeMail,true,true)+'" alt="'+cv(registro.data.mensajeMail,true,true)+'" />'+comp;
                                                                    }
                                                            },
                                                            {
                                                                header:'Tipo de audiencia',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'tipoAudiencia',
                                                                renderer:function(val,meta,registro)
                                                                		{	
                                                                        	
                                                                        	var comp='';
                                                                            if(registro.data.otroTipoAudiencia.trim()!='')
                                                                            	comp=': '+registro.data.otroTipoAudiencia;
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrAudiencias,val))+comp;
                                                                        }
                                                            },
                                                            <?php
															if($tipoMateria!="SC")
															{
															?>
                                                            {
                                                                header:'Edificio',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'edificio',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var lblSala=mostrarValorDescripcion(formatearValorRenderer(arrEdificios,val));
                                                                            
                                                                            
                                                                            
                                                                        	return lblSala;
                                                                        }
                                                            },
                                                            {
                                                                header:'Sala',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'sala',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var lblSala=mostrarValorDescripcion(formatearValorRenderer(arrSalas,val));
                                                                            
                                                                            
                                                                            
                                                                        	return lblSala;
                                                                        }
                                                            },
                                                            {
                                                                header:'Streaming sala',
                                                                width:100,
                                                                sortable:true,
                                                                hidden:true,
                                                                dataIndex:'urlCanal',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if(val!="")
                                                                        		return '<a href="javascript:abrirVentanaSala(\''+bE(registro.data.sala)+'\')"><img src="../images/cam.png" title="Visualizar sala" alt="Visualizar sala" /> <span style="font-size:10px; text-decoration:none; color:#900">Visualizar</span></a>'
                                                                        }
                                                                
                                                            },
                                                            <?php
															}
															?>
                                                            {
                                                                header:'Juez',
                                                                width:320,
                                                                sortable:true,
                                                                dataIndex:'juez'
                                                            },
                                                            
                                                            {
                                                                header:'Juzgado',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'unidadGestion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrUnidades,val));
                                                                        }
                                                            },
                                                            
                                                            {
                                                            	header:'V&iacute;ctima',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'actores',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                            	header:'Imputado',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'demandados',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                           
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'dEventos',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                sm:chkRow,
                                                                columnLines : true,      
                                                                plugins:	[filters],
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :true,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;

}

function formatearFila(record, rowIndex, p, ds)
{
	var comp='';
    switch(parseFloat(record.get('situacion')))
    {
    	case 0:
        	comp='filaEnEsperaConfirmacion';
        break;
        case 1:
        	comp='filaConfirmada';
        break;
        case 2:
        	comp='filaTerminada';
        break;
        case 3:
        	comp='filaCancelada';
        break;    
    }
	return 'x-grid3-row-expanded '+comp;
}


function registrarSolicitudAudiencia(iE,cA,iC)
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
            obj.params=[['idEventoReferencia',bD(iE)],['carpetaAdministrativa',bD(cA)],['idFormulario',185],['idRegistro',arrResp[1]],['idReferencia',-1],
            		['dComp',arrResp[2]],['actor',arrResp[3]],['idCarpetaAdministrativa',bD(iC)]];
            window.parent.abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=52&iE='+bD(iE),true);
}

function recargarContenedorCentral()
{
	
}

function abrirFormatoRegistro(iF,iR)
{

	var obj={};    
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=[['idFormulario',bD(iF)],['idRegistro',bD(iR)],
                ['dComp',bE('auto')],['actor',bE(0)]];
    abrirVentanaFancySuperior(obj);
}

function reenviarMAJO(iE)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            gEx('dEventos').getStore().reload();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=83&iE='+bD(iE),true);
}

function abrirVentanaSala(iS)
{
	var obj={};    
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/visorStreamSalaAudiencia.php';
    obj.params=[['idSala',iS],['cPagina','sFrm=true']]
    abrirVentanaFancySuperior(obj);
}

function abrirVideoGrabacion(idEventoAudiencia)
{
	var obj={};    
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/visorGrabacionAudiencia.php';
    obj.params=[['idEvento',idEventoAudiencia],['cPagina','sFrm=true']]
    abrirVentanaFancySuperior(obj);
}

function reenviarNotificacionMail(iE)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            gEx('gridAudiencias').getStore().reload();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=311&iE='+bD(iE),true);
}
