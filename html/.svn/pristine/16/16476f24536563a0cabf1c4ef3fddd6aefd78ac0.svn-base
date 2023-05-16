<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	
	
	$consulta="SELECT carpetaAdministrativa FROM _67_tablaDinamica WHERE id__67_tablaDinamica=".$idRegistro;
	$carpetaAdministrativa=$con->obtenerValor($consulta);
	$consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
	$unidadGestion=$con->obtenerValor($consulta);
	
	$consulta="SELECT id__5_tablaDinamica,nombreTipo FROM _5_tablaDinamica";
	$arrFigurasJuridicas=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT u.idUsuario,u.nombre FROM 807_usuariosVSRoles r,800_usuarios u,801_adscripcion a 
				WHERE idRol=32 AND u.idUsuario=r.idUsuario and a.idUsuario=u.idUsuario and 
				a.Institucion='".$unidadGestion."'  ORDER BY nombre";//

	$arrNotificadores=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__63_tablaDinamica,nombreMedioNotificacion FROM _63_tablaDinamica ORDER BY nombreMedioNotificacion";
	$arrMedioNotificacion=$con->obtenerFilasArreglo($consulta);
	
	
	$arrEtapas="";
	$consulta="SELECT numEtapa,nombreEtapa  FROM 4037_etapas WHERE idProceso=96";
	$resEtapas=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($resEtapas))
	{
		$e="['".$fila[0]."','".removerCerosDerecha($fila[0]).".- ".cv($fila[1])."']";
		if($arrEtapas=="")	
			$arrEtapas=$e;
		else
			$arrEtapas.=",".$e;
	}
		
	$arrEtapas="[".$arrEtapas."]";
	
	$consulta="SELECT claveElemento,nombreElemento FROM 1018_catalogoVarios WHERE tipoElemento=15";
	$arrTiposFiguras=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__10_tablaDinamica,concat('[',t.cveFormato,'] ',t.nombreFormato) FROM _10_tablaDinamica t WHERE id__10_tablaDinamica IN(125,126) order by id__10_tablaDinamica";
	$arrFormatosAbierto=$con->obtenerFilasArreglo($consulta);
	
?>

var idFiguraJuridica=-1;
var arrFormatosAbierto=<?php echo $arrFormatosAbierto?>;
var arrTiposFiguras=<?php echo $arrTiposFiguras?>;
var arrEtapas=<?php echo $arrEtapas?>;
var arrMedioNotificacion=<?php echo $arrMedioNotificacion?>;
var arrNotificadores=<?php echo $arrNotificadores?>;
var arrFigurasJuridicas=<?php echo $arrFigurasJuridicas?>;
var idEvento=-1;

Ext.onReady(inicializar);


function inicializar()
{
	gE('sp_1745').innerHTML='';
	arrFigurasJuridicas.splice(0,0,['0','Otras figuras']);
	idEvento=gEN('_idEventovch')[0].value;
    loadScript('../Scripts/ux/checkColumn.js', function(){});
    if(idEvento!='-1')
    {
        loadScript('../modulosEspeciales_SGJP/Scripts/controlEventos.js.php', function()
                                                                                {
                                                                                    var objConf={};
                                                                                    objConf.idEvento=idEvento;
                                                                                    objConf.renderTo='sp_1745';
                                                                                    objConf.permiteModificarEdificio=false;  
                                                                                    objConf.permiteModificarUnidadGestion=false;  
                                                                                    objConf.permiteModificarSala=false;  
                                                                                    objConf.permiteModificarFecha=false;    
                                                                                    objConf.permiteModificarJuez=false;                                                                               
                                                                                    objConf.mostrarFechaAudiencia=true;
                                                                                    objConf.mostrarTipoAudiencia=true;
                                                                                    objConf.mostrarDuracionAudiencia=true;
                                                                                    objConf.mostrarSalaAudiencia=true;
                                                                                    objConf.mostrarCentroGestion=true;
                                                                                    objConf.mostrarEdificio=true;
                                                                                    objConf.mostrarJueces=true;
                                                                                    objConf.mostrarDesarrollo=false;
                                                                                    objConf.mostrarDuracionDesarrollo=false;
                                                                                    objConf.mostrarHorarioDesarrollo=false;
                                                                                    objConf.mostrarDocumentoMultimedia=false;
                                                                                    construirTableroEvento(objConf);
                                                                                }
                    );
    }
    
    if(!existeFuncionJS('CheckboxCombo'))
    {
        loadScript('../Scripts/ux/checkBoxComboBox/CheckboxComboBox.js', crearGridPersonasNotificacion);
        loadCSS('../Scripts/ux/checkBoxComboBox/CheckboxComboBox.css', function(){});
    }
    else
    	crearGridPersonasNotificacion();
        
        
   	 crearArbolSujetosProcesales();    
        
    
}

function crearGridPersonasNotificacion()
{

	var objConf={};
    objConf.multiSelect=true;
    							
	var cmbMedioNotificacion=crearComboExt('cmbMedioNotificacion',arrMedioNotificacion,0,0,0,objConf);
	gE('sp_1747').innerHTML='';    
	var cmdNotificador=crearComboExt('cmdNotificador',arrNotificadores);
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idRegistro'},
		                                                {name: 'actor'},
		                                                {name: 'fechaAsignacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'idFiguraJuridica'},
                                                        {name: 'notificadorAsignado'},
                                                        {name: 'personaNotificar'},
                                                        {name: 'situacionRegistro'},
                                                        {name: 'tipoDocumento'},
                                                        {name: 'tipoFigura'},
                                                        {name: 'folioRegistro'}
                                                        
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
                                                            sortInfo: {field: 'folioRegistro', direction: 'ASC'},
                                                            groupField: 'folioRegistro',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='27';
                                        proxy.baseParams.idRegistro=gE('idRegistroG').value;
                                        proxy.baseParams.iFormularioSolicitud=gE('idFormulario').value;
                                        proxy.baseParams.idRegistroSolicitud=gE('idRegistroG').value;

                                    }
                        )   
       
	      
       
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            
                                                            
                                                            {
                                                                header:'Folio de registro',
                                                                width:120,
                                                                sortable:true,
                                                                dataIndex:'folioRegistro',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Registrado el',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'fechaAsignacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i');
                                                                        }
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n de la notificaci&oacute;n',
                                                                width:580,
                                                                css:'text-align:right;',
                                                                sortable:true,
                                                                dataIndex:'situacionRegistro',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'',
                                                                width:40,
                                                                sortable:true,
                                                                dataIndex:'idRegistro',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return '<a href="javascript:abrirDocumentacion(\''+bE(val)+'\',\''+bE(registro.data.actor)+'\')"><img src="../images/right1.png" /></a>'
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                            {
                                                                id:'gFigurasJuridicas',
                                                                store:alDatos,
                                                                renderTo:'sp_1747',
                                                                frame:false,
                                                                cm: cModelo,
                                                                clicksToEdit:2,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                width:940,
                                                                height:350,
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Crear orden de citaci&oacute;n / notificaci&oacute;n',
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaOrdenNotificacion()
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
                                                                                                    startCollapsed:false,
                                                                                                    enableRowBody:true,
						                                                                            getRowClass : formatearFila
                                                                                                })
                                                            }
                                                        );
	 
    tblGrid.on('beforeedit',function(e)
    						{
                            	if(e.record.data.idRegistroOrden!='-1')
                                	e.cancel=true;
                            }
    			)                                                    	
                                                        
    return 	tblGrid;	
	
}

function enviarNotificador(nFila)
{
	var fila=gEx('gFigurasJuridicas').getStore().getAt(bD(nFila));
    
    if(fila.data.notificadorAsignado=='')
    {
    	function resp1()
        {
        	gEx('gFigurasJuridicas').startEditing(bD(nFila),3);
        }
    	msgBox('Debe indicar el notificador a asignar',resp1);
    	return;
    }
    
    if(fila.data.medioNotificacion=='')
    {
    	function resp2()
        {
        	gEx('gFigurasJuridicas').startEditing(bD(nFila),4);
        }
    	msgBox('Debe indicar el medio de notificaci&oacute;n',resp2);
    	return;
    }
    
    var arrMedioNotificacion='';
    
    var arrMedioNotificacion=fila.data.medioNotificacion;
    
    var cadObj='{"carpetaAdministrativa":"'+gEN('_carpetaAdministrativavch')[0].value+'","idEvento":"'+gEN('_idEventovch')[0].value+
    			'","idPersona":"'+fila.data.idPersona+'","idFigura":"'+fila.data.figuraJuridica+'","idNotificador":"'+fila.data.notificadorAsignado+
                '","medioNotificacion":"'+arrMedioNotificacion+'","idFormulario":"'+gE('idFormulario').value+'","idRegistro":"'+gE('idRegistroG').value+'"}';
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            gEx('gFigurasJuridicas').getStore().reload();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=28&cadObj='+cadObj,true);
    
}

function mostrarVentanaOrdenNotificacion()
{
	var cmbTipoFigura=crearComboExt('cmbTipoFigura',arrTiposFiguras,220,5,200);    
    cmbTipoFigura.on('select',function(cmb,registro)			
                                {
                                    
                                    function funcAjax()
                                    {
                                        var resp=peticion_http.responseText;
                                        arrResp=resp.split('|');
                                        if(arrResp[0]=='1')
                                        {
                                        	var arrDatos=eval(arrResp[1]);
                                            cmbDestinatario.setValue('');
                                            gEx('cmbDocumentoEntregar').setValue('');
                                            gEx('cmbDocumentoEntregar').getStore().removeAll();
                                            gEx('gridMediosNotificacion').getStore().removeAll();
                                            
                                            cmbDestinatario.getStore().loadData(arrDatos);
                                            cmbDestinatario.arrDatos=arrDatos;
                                        }
                                        else
                                        {
                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                        }
                                    }
                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=31&tF='+
                                    					registro.data.id+'&cA='+gEN('_carpetaAdministrativavch')[0].value+'&iR='+gE('idRegistroG').value,true);
                                    
                                    
                                }
    				)
    
    
    var cmbNotificador=crearComboExt('cmbNotificador',arrNotificadores,520,130,300);
    
    var cmbDestinatario=crearComboExt('cmbDestinatario',[],220,35,600);
    cmbDestinatario.on('select',function(cmb,registro)	
    							{
                                	var cmbDestinatario=gEx('cmbDestinatario');
                                   	var cmbDocumentoEntregar=gEx('cmbDocumentoEntregar');
                                	var idDestinatario=registro.data.id;
                                    var pos=existeValorMatriz(cmbDestinatario.arrDatos,idDestinatario);
                                    var arrDocumentos=cmbDestinatario.arrDatos[pos][3];
                                    idFiguraJuridica=cmbDestinatario.arrDatos[pos][5];
                                    
                                    
                                    
                                    if(gE('sp_2122').innerHTML=='Citación')
                                    {
                                    	if(existeValorMatriz(arrDocumentos,arrFormatosAbierto[0][0])==-1)
	                                       	arrDocumentos.splice(arrDocumentos.length,0,arrFormatosAbierto[0]);
                                    }
                                    else
                                    {
                                    	if(existeValorMatriz(arrDocumentos,arrFormatosAbierto[1][0])==-1)
                                        	arrDocumentos.splice(arrDocumentos.length,0,arrFormatosAbierto[1]);
                                    }
                                    if(existeValorMatriz(arrDocumentos,'0')==-1)
	                                    arrDocumentos.splice(arrDocumentos.length,0,['0','Documento adjunto de la solicitud']);    
                                    cmbDocumentoEntregar.setValue('');    
                                    cmbDocumentoEntregar.getStore().loadData(arrDocumentos);
                                    if(arrDocumentos.length==3)
                                    	cmbDocumentoEntregar.setValue(arrDocumentos[0][0]);
                                    gEx('gridMediosNotificacion').getStore().loadData(cmbDestinatario.arrDatos[pos][4]);
                                    
                                }
    				)
    var cmbDocumentoEntregar=crearComboExt('cmbDocumentoEntregar',[],220,65,600);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            xtype:'label',
                                                            html:'Tipo de figura a citar / notificar:'
                                                        },
                                                        cmbTipoFigura,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Citaci&oacute;n / Notificaci&oacute;n dirigida a:'
                                                        },
                                                        cmbDestinatario,
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'Documento a entregar:'
                                                        },
                                                        cmbDocumentoEntregar,
                                                        {
                                                        	xtype:'fieldset',
                                                            title:'Medios de noficaci&oacute;n',
                                                        	x:10,
                                                            y:100,
                                                            width:470,
                                                            height:250,
                                                            layout:'absolute',
                                                            items:	[
                                                            			crearGridFormaNotificacion()
                                                            		]
                                                        },
                                                        {
                                                        	x:520,
                                                            y:100,
                                                        	xtype:'label',
                                                            html:'Notificador a asignar:'
                                                        },
                                                        cmbNotificador

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Orden de citaci&oacute;n',
										width: 880,
										height:440,
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
																		if(cmbTipoFigura.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	cmbTipoFigura.focus();
                                                                            }
                                                                            msgBox('Debe indicar el tipo de figura a citar / notificar',resp1);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(cmbDestinatario.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbDestinatario.focus();
                                                                            }
                                                                            msgBox('Debe indicar el destinatario de la citaci&oacute;n / notificaci&oacute;n',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(cmbDocumentoEntregar.getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	cmbDocumentoEntregar.focus();
                                                                            }
                                                                            msgBox('Debe indicar el documento a entregar',resp3);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(cmbNotificador.getValue()=='')
                                                                        {
                                                                        	function resp4()
                                                                            {
                                                                            	cmbNotificador.focus();
                                                                            }
                                                                            msgBox('Debe indicar el notificador a asignar',resp4);
                                                                            return;
                                                                        }
                                                                        
                                                                        var arrMediosNotificacion='';
                                                                        var x;
                                                                        var fila;
                                                                        for(x=0;x<gEx('gridMediosNotificacion').getStore().getCount();x++)
                                                                        {
                                                                        	fila=gEx('gridMediosNotificacion').getStore().getAt(x);
                                                                            if(fila.data.notificacionSelecionada)
                                                                            {
                                                                            	if(arrMediosNotificacion=='')
                                                                                	arrMediosNotificacion=fila.data.idMedioNotificacion;
                                                                                else
                                                                                	arrMediosNotificacion+=','+fila.data.idMedioNotificacion;
                                                                                	
                                                                            }
                                                                        }
                                                                        
                                                                        if(arrMediosNotificacion=='')
                                                                        	arrMediosNotificacion=-1;
                                                                        
                                                                        var cadObj='{"idNotificador":"'+cmbNotificador.getValue()+'","figuraJuridica":"'+idFiguraJuridica+'","tipoFigura":"'+cmbTipoFigura.getValue()+'","destinatario":"'+cmbDestinatario.getValue()+
                                                                        			'","documento":"'+cmbDocumentoEntregar.getValue()+'","arrMediosNotificacion":"'+
                                                                                    arrMediosNotificacion+'","iFormulario":"'+gE('idFormulario').value+'","iRegistro":"'+gE('idRegistroG').value+
                                                                                    '","idEvento":"'+gEN('_idEventovch')[0].value+'"}';
                                                                       
                                                                       
                                                                       	function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gFigurasJuridicas').getStore().reload();
                                                                                
                                                                                
                                                                                var obj={};
                                                                                obj.ancho='100%';
                                                                                obj.alto='100%';
                                                                                obj.url='../modeloPerfiles/vistaDTDv3.php';
                                                                                obj.params=[['idFormulario','72'],['idRegistro',arrResp[1]],['actor',bE(arrResp[2])],['dComp',bE('auto')]];
                                                                                abrirVentanaFancy(obj);
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=28&cadObj='+cadObj,true);
                                                                       
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

function crearGridFormaNotificacion()
{
	var checkColumn = new Ext.grid.CheckColumn	(
	 												{
													   header: 'Seleccionar',
													   dataIndex: 'notificacionSelecionada',
													   width: 100
													}
												); 
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idMedioNotificacion'},
                                                                    {name: 'medioNotificacion'},
                                                                    {name: 'notificacionSelecionada'}
                                                                    
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	
														{
															header:'Medio de notificaci&oacute;n',
															width:220,
															sortable:true,
															dataIndex:'medioNotificacion'
														},
														checkColumn
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            x:10,
                                                            y:10,
                                                            id:'gridMediosNotificacion',
                                                            width:400,
                                                            height:200,
                                                            store:alDatos,
                                                            frame:false,
                                                            cm: cModelo,
                                                            plugins:[checkColumn],
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true
                                                           
                                                        }
                                                    );
	return 	tblGrid;		
}

function formatearFila(record, rowIndex, p, ds) 
{
	
        
    
        
    p.body = '<div style="margin-left: 30px;margin-right: 3em;text-align:left"><br><br>'+
    		 '<table width="800">'+
             '<tr>'+
             	'<td width="180"><span class="TSJDF_Etiqueta">Notificar a:</span>'+
                '</td>'+
                '<td width="620"><span class="TSJDF_Control">'+record.data.personaNotificar+'</span>'+
                '</td>'+
             '</tr>'+
             '<tr>'+
             	'<td><span class="TSJDF_Etiqueta">Figura Jur&iacute;dica:</span>'+
                '</td>'+
                '<td><span class="TSJDF_Control">'+((record.data.idFiguraJuridica=='0')?record.data.tipoFigura:formatearValorRenderer(arrFigurasJuridicas,record.data.idFiguraJuridica))+'</span>'+
                '</td>'+
             '</tr>'+
             '<tr>'+
             	'<td><span class="TSJDF_Etiqueta">Documento a entregar:</span>'+
                '</td>'+
                '<td><span class="TSJDF_Control">'+record.data.tipoDocumento+'</span>'+
                '</td>'+
             '</tr>'+
             '<tr>'+
             	'<td><span class="TSJDF_Etiqueta">Notificador asignado:</span>'+
                '</td>'+
                '<td><span class="TSJDF_Control">'+record.data.notificadorAsignado+'</span>'+
                '</td>'+
             '</tr>'+
             '</table><br><br>'+	
    		  '</div>';
    return 'x-grid3-row-expanded';
}

function abrirDocumentacion(iR,a)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=[['idFormulario','72'],['idRegistro',bD(iR)],['actor',a],['dComp',bE('auto')]];
    abrirVentanaFancy(obj);
    ventanaAM.close();	
}

function recargarContenedorCentral()
{
	gEx('gFigurasJuridicas').getStore().reload();
}

function crearArbolSujetosProcesales()
{
	var raiz=new  Ext.tree.AsyncTreeNode(
											{
												id:'-1',
												text:'Raiz',
												draggable:false,
												expanded :false,
												cls:'-1'
											}
										)
                                        
										
	var cargadorArbol=new Ext.tree.TreeLoader(
                                                {
                                                    baseParams:{
                                                                    funcion:'17',
                                                                    iE:bE(-1),
                                                                    sV:bE(1),
                                                                    cA:bE(gEN('_carpetaAdministrativavch')[0].value)
                                                                },
                                                    dataUrl:'../paginasFunciones/funcionesModulosEspeciales_SGP.php'
                                                }
                                            )		
										
											
	cargadorArbol.on('load',function(c)
    						{
                            	//gEx('btnAcuerdosReparatorios').hide();
                            }
    				)										
                    
	gE('sp_5264').innerHTML='';                    
                    
	var arbolSujetosJuridicos=new Ext.tree.TreePanel	(
                                                            {
                                                                id:'arbolSujetos',
                                                                useArrows:true,
                                                                animate:true,
                                                                enableDD:false,
                                                                ddScroll:true,
                                                                width:250,
                                                                border:true,
                                                                height:450,      
                                                                containerScroll: true,
                                                                autoScroll:true,                                                                
                                                                root:raiz,
                                                                renderTo:'sp_5264',
                                                                loader: cargadorArbol,
                                                                rootVisible:false
                                                                
                                                            }
                                                        )
         
         
                                                    
	arbolSujetosJuridicos.on('dblclick',funcClickSujeto);	                                                    
	
   
	//return  arbolSujetosJuridicos;
}



function funcClickSujeto(nodo, evento)
{
	if(nodo.attributes.tipo!='0')
    {
    	var arrId=nodo.id.split('_');
        
        var obj={};
        var params=[['idRegistro',arrId[1]],['idFormulario',47],['dComp',bE('auto')],['actor',bE('0')]];
        obj.ancho='90%';
        obj.alto='95%';
        obj.url='../modeloPerfiles/vistaDTDv3.php';
        obj.params=params;
        obj.modal=true;
        abrirVentanaFancy(obj);
        
        /*function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                mostrarVentanaRegistroCedulaIdentificacion(arrResp[1],-1,gE('idEventoAudiencia').value,arrId[1],arrResp[2],arrResp[3]);
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=87&iU='+arrId[1]+'&iE='+gE('idEventoAudiencia').value,true);*/
        
        
        
        
        
    }
}