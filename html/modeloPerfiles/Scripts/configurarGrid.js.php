<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php"); 
	$idConfiguracion=$_GET["idConfiguracion"];
	$idFormulario=$_GET["iF"];
	
	
	$consulta="	select cg.titulo,tamanoColumna as 'tamColumna' 
				from 907_camposGrid cg where cg.idIdioma=".$_SESSION["leng"]." and cg.idConfGrid=".$idConfiguracion." order by cg.orden";
	
	$res=$con->obtenerFilas($consulta);
	$campos="{name: 'idRegistro' }";
	$columnModel='new  Ext.grid.RowNumberer({width:40})';
	$ct=1;
	while($filas=$con->fetchRow($res))
	{
		
		$campos.=",{name: 'campo_".$ct."' }";
		$columnModel.="	,{
							header:'".uEJ($filas[0])."',
							width:".$filas[1].",
							sortable:true,
							dataIndex:'campo_".$ct."',
							align:'left',
							resizable:false
						}";
		
		$ct++;
	}
	
	$consulta="select codigoUnidad,unidad from 817_organigrama where institucion=1 order by unidad";
	$arrInstituciones=$con->obtenerFilasArreglo($consulta);
	
	if($arrInstituciones=="[]")
		$arrInstituciones="[['@instUsuario','".$etj["lblInstUsuario"]."']]";
	else
		$arrInstituciones="[['@instUsuario','".$etj["lblInstUsuario"]."'],".substr($arrInstituciones,1);	
	$consulta="select codigoUnidad,unidad from 817_organigrama where institucion=0 order by unidad";
	$arrUnidades=$con->obtenerFilasArreglo($consulta);
	if($arrUnidades=="[]")
		$arrUnidades="[['@UnidadUsuario','".$etj["lblUnidadUsuario"]."']]";
	else
		$arrUnidades="[['@UnidadUsuario','".$etj["lblUnidadUsuario"]."'],".substr($arrUnidades,1);	
		
	$consulta="select * from (
				
				(
				SELECT idGrupoElemento,concat(nombreCampo,' [',t.tipoElemento,']') as campo,e.tipoElemento,t.tipoValor
				FROM 901_elementosFormulario e,901_tipoElementosFormulario t WHERE idFormulario=".$idFormulario." AND e.tipoElemento 
				IN (2,3,4,5,6,7,8,9,11,14,15,16,17,18,19,22,24,31) and t.idTipoElemento=e.tipoElemento 
				)
				union
				(
					SELECT tipoElemento AS idGrupoElemento,CONCAT(etiquetaUsuario,' (Campo de control)') AS campo,tipoElemento,tipoValor FROM 9017_camposControlFormulario where tipoElemento not in (-14,-15)
				)
				
				
				)as tmp ORDER BY campo	";
	$arrControles=$con->obtenerFilasArreglo($consulta);
	
	$consulta="select * from (
				SELECT idTipoElemento,tipoElemento FROM 901_tipoElementosFormulario
				union
				SELECT tipoElemento as idTipoElemento,'Campo de control' as tipoElemento FROM 9017_camposControlFormulario
				) as tmp ORDER BY idTipoElemento";
	$arrTiposElementos=$con->obtenerFilasArreglo($consulta);	
	
	
	$arrFiltros="{xtype:'tbspacer',width:20}";
	$consulta="SELECT * FROM 907_filtrosGlobalesGrid WHERE idConfiguracionGrid=".$idConfiguracion;
	$rConfiguracion=$con->obtenerFilas($consulta);
	while($fConfiguracion=$con->fetchRow($rConfiguracion))
	{
		$control="";
		switch($fConfiguracion[3])
		{
			case 1://
				$control='crearComboExt("op1_'.$fConfiguracion[2].'",arrCondicionales,0,0,60,{ctCls:"comboWrapSIUGJ",cls:"comboSIUGJ",listClass:"listComboSIUGJControl",valor:"="}),{xtype:"tbspacer",width:5},new Ext.form.NumberField({id:"txt1_'.$fConfiguracion[2].'",width:"40",allowDecimals:true,allowNegative:true,cls:"controlSIUGJ"}),'.
						'{xtype:"tbspacer",width:5},{id:"btnClean_'.$fConfiguracion[2].'_1",icon:"../images/find_remove.png",border:true,width:40,cls:"x-btn-icon btnSiugjSmall",handler:function(btn){}},{xtype:"tbspacer",width:5},{"xtype":"label",html:"<div class=\'letraNombreTablero\'>y</div>"},{xtype:"tbspacer",width:15},crearComboExt("op2_'.$fConfiguracion[2].'",arrCondicionales,0,0,60,{ctCls:"comboWrapSIUGJ",cls:"comboSIUGJ",listClass:"listComboSIUGJControl",valor:"="}),{xtype:"tbspacer",width:5},new Ext.form.NumberField({id:"txt2_'.
							$fConfiguracion[2].'",width:"40",allowDecimals:true,allowNegative:true,cls:"controlSIUGJ"}),{xtype:"tbspacer",width:5},{id:"btnClean_'.$fConfiguracion[2].'_2",icon:"../images/find_remove.png",border:true,width:40,cls:"x-btn-icon btnSiugjSmall",handler:function(btn){}}';
			break;	
			/*case 2:
				$control='new Ext.form.TextField({"id":"txt_'.$fConfiguracion[2].'",width:"'.$fConfiguracion[4].'"})';
			break;*/
			case 3://
				$control='crearComboExt("cmb_'.$fConfiguracion[2].'",[],0,0,'.$fConfiguracion[4].',{ctCls:"comboWrapSIUGJ",cls:"comboSIUGJ",listClass:"listComboSIUGJControl"}),{xtype:"tbspacer",width:5},{id:"btnClean_'.$fConfiguracion[2].'_1",icon:"../images/find_remove.png",border:true,width:40,cls:"x-btn-icon btnSiugjSmall",handler:function(btn){}}';
			break;
			case 4://
				$control='crearComboExt("cmb_'.$fConfiguracion[2].'",[],0,0,'.$fConfiguracion[4].',{ctCls:"comboWrapSIUGJ",cls:"comboSIUGJ",listClass:"listComboSIUGJControl"}),{xtype:"tbspacer",width:5},{id:"btnClean_'.$fConfiguracion[2].'_1",icon:"../images/find_remove.png",border:true,width:40,cls:"x-btn-icon btnSiugjSmall",handler:function(btn){}}';
			break;
			case 5:
				$control='crearComboExt("op1_'.$fConfiguracion[2].'",arrCondicionalesTexto,0,0,120,{ctCls:"comboWrapSIUGJ",cls:"comboSIUGJ",listClass:"listComboSIUGJControl",valor:arrCondicionalesTexto[0][0]}),{xtype:"tbspacer",width:5},new Ext.form.TextField({"id":"txt1_'.$fConfiguracion[2].'",width:"'.$fConfiguracion[4].'",cls:"controlSIUGJ"})
				,{xtype:"tbspacer",width:5},{id:"btnClean_'.$fConfiguracion[2].'_1",icon:"../images/find_remove.png",border:true,width:40,cls:"x-btn-icon btnSiugjSmall",handler:function(btn){}}
						';
			break;	
			case 6://
				$control='crearComboExt("op1_'.$fConfiguracion[2].'",arrCondicionales,0,0,60,{ctCls:"comboWrapSIUGJ",cls:"comboSIUGJ",listClass:"listComboSIUGJControl",valor:"="}),{xtype:"tbspacer",width:5},new Ext.form.DateField({"id":"txt1_'.$fConfiguracion[2].'","ctCls":"campoFechaSIUGJ"}),'.
						'{xtype:"tbspacer",width:5},{id:"btnClean_'.$fConfiguracion[2].'_1",icon:"../images/find_remove.png",border:true,width:40,cls:"x-btn-icon btnSiugjSmall",handler:function(btn){}},{xtype:"tbspacer",width:5},{"xtype":"label",html:"<div class=\'letraNombreTablero\'>y</div>"},{xtype:"tbspacer",width:15},crearComboExt("op2_'.$fConfiguracion[2].'",arrCondicionales,0,0,60,{ctCls:"comboWrapSIUGJ",cls:"comboSIUGJ",listClass:"listComboSIUGJControl",valor:"="}),{xtype:"tbspacer",width:5},new Ext.form.DateField({"id":"txt2_'.
						$fConfiguracion[2].'","ctCls":"campoFechaSIUGJ"}),{xtype:"tbspacer",width:5},{id:"btnClean_'.$fConfiguracion[2].'_2",icon:"../images/find_remove.png",border:true,width:40,cls:"x-btn-icon btnSiugjSmall",handler:function(btn){}}';
				
			break;
			/*case 7:
				$control='new Ext.form.DateField({"id":"txt1_'.$fConfiguracion[2].'"})';
			break;	*/	
		}
		$filtro='{"xtype":"label",html:"<div class=\'letraNombreTablero\'>'.$fConfiguracion[1].':</div>"},{xtype:"tbspacer",width:20},'.$control.',"-"';
		if($arrFiltros=="")
			$arrFiltros=$filtro;
		else
			$arrFiltros.=",".$filtro;
	}
	
	
	$consulta="SELECT idFuncion,nombreFuncion FROM 9033_funcionesScriptsSistema WHERE idCategoria=1";
	$arrFunciones=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT valor,texto FROM 1004_siNo";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
?>	
var arrSiNo=<?php echo $arrSiNo?>;
var arrCampos=[];
var rCampoIndice=crearRegistro(	[
									{name: 'idCampo'},
                                    {name: 'campo'},
                                    {name: 'orden',type:'int'}
								]
                               );
var rCampoTabla=crearRegistro(
								[
									{name: 'idCampo'},
                                    {name: 'campo'}
                                 
								]
							);

var arrFuncionesRenderer=<?php echo $arrFunciones?>;


var arrCondicionales=[['>','>'],['>=','>='],['=','='],['<','<'],['<=','<=']];
var arrCondicionalesTexto=[["like '@valor%'",'Inicia con'],["like '%@valor%'",'Contiene']];


var arrTiposElementos=<?php echo $arrTiposElementos?>;
var arrControles=<?php echo $arrControles?>;
var ventanaAM =null;
var ventanaAC=null;
var ventanaEtiquetas=null;
var idElemento='-1';
var idConfiguracion='-1';

var rgIdiomas = Ext.data.Record.create	
(
	[
			{name: 'idioma'},
			{name: 'idIdioma'},
			{name: 'etiqueta'},
            {name: 'idCamposGrid'}
	  ]
);

var rColumna= Ext.data.Record.create	(
											[
                                            	{name: 'idGrupoCampo'},
												{name: 'etFormulario'},
												{name: 'titulo'},
												{name: 'tamColumna'},
                                                {name: 'alineacion'},
                                                {name: 'orden'},
                                                {name: 'funcionRenderer'}
                                            ]
										)

Ext.onReady(inicializar);
var tipoProceso;
var formPrincipal;
function inicializar()
{
	arrFuncionesRenderer.splice(0,0,['0','Ninguno']);
	idConfiguracion=gE('idConfiguracion').value;
    tipoProceso=parseInt(gE('tipoProceso').value);
    formPrincipal=gE('formPrincipal').value;
   	crearTablaRegistros();
   
   
    
    
}

function cambiarColor(val)
{
	 return '<img src="../images/banderas/'+val+'" />';
}

function configurarGrid()
{
	mostrarVentanaConfiguracion();

}

function mostrarVentanaConfiguracion()
{
	
	var tEntradas=[['ASC','<?php echo $etj["lblAscendente"]?>'],['DESC','<?php echo $etj["lblDescendente"]?>']];
	var tblGrid=crearGridConfiguracion();
   
    var formPrincipal=gE('formPrincipal').value;
    
    var form = new Ext.form.FormPanel(	
												{
													baseCls: 'x-plain',
													layout:'absolute',
													defaultType: 'label',
													items: 	[
																tblGrid,
                                                                {
                                                                	id:'lblAgrupar',
                                                                	x:10,
                                                                    y:310,
                                                                    cls:'SIUGJ_Etiqueta',
                                                                    text:'Agrupar por:'
                                                                },
                                                                {
                                                                	x:220,
                                                                    y:305,
                                                                    html:'<div id="divComboAgrupar"></div>'
                                                                },
                                                                {
                                                                	id:'lblOrdenar',
                                                                	x:10,
                                                                    cls:'SIUGJ_Etiqueta',
                                                                    y:360,
                                                                    text:'<?php echo $etj["lblOrdernarPor"]?>:'
                                                                },
                                                                {
                                                                	x:220,
                                                                    y:355,
                                                                    html:'<div id="divComboOrden"></div>'
                                                                },
                                                                {
                                                                	x:580,
                                                                    y:355,
                                                                    html:'<div id="divComboOrdenSentido"></div>'
                                                                },

                                                                {
                                                                	id:'lblRegPagina',
                                                                	x:10,
                                                                    y:410,
                                                                    cls:'SIUGJ_Etiqueta',
                                                                    text:'<?php  echo $etj["lblRegPag"]?>:'
                                                                },
                                                                {
                                                                	xtype:'numberfield',
                                                                    x:220,
                                                                    y:405,
                                                                    cls:'controlSIUGJ',
                                                                    id:'txtNumRegPag',
                                                                    allowDecimals:false,
                                                                    width:80
                                                                }
															]
												}
											);
                                            
	gEx('txtNumRegPag').on('change',cambiarNumRegPaginas);                                            
                                            
	ventanaAM = new Ext.Window(
									{
										title: '<?php echo $etj["lblConfGrid"]?>',
										width: 900,
										height:550,
										minWidth: 690,
										minHeight: 520,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
																	 	var comboOrden=crearComboExt('idCmbOrden',tEntradas,0,0,250,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboOrdenSentido'});                        
                                                                        comboOrden.on('select',cambiarOrden);
                                                                        var dsDatos=gEx('gridConfiguracion').getStore();
                                                                        var comboCampos=crearComboExt('idCmbCampos',[],0,0,350,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboOrden'});                        
                                                                        comboCampos.on('select',cambiarCampoOrden);
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        var arrAgrupacion=[['0','No agrupar']];
                                                                        var comboAgrupacion=crearComboExt('cmbAgrupacion',arrAgrupacion,0,0,450,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboAgrupar'});
                                                                        comboAgrupacion.setValue('0');
																		comboAgrupacion.on('select',cambiarCampoAgrupacion);
																		if((tipoProceso>1)&&(formPrincipal=='1'))
                                                                        {
                                                                            comboAgrupacion.hide();
                                                                            gEx('lblAgrupar').hide();
                                                                        }
                                                                        cargarDatosConfiguracion(dsDatos);
                                                                       
                                                                		
                                                                
                                                                }
															}
												},
										buttons:	[
														{
                                                        	id:'btnAceptarConf',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler:function()
																	{
                                                                    	var comboCampos=gEx('idCmbCampos');
                                                                    	if((comboCampos.getValue()=='')&&(tblGrid.getStore().getCount()>0))
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	comboCampos.focus();
                                                                            }
                                                                            msgConfirm('<?php echo $etj["lblDebeSelCampoO"]?>',resp);
                                                                        	return;
                                                                        }	
                                                                    
																		destruirVentanas();
																	}
														}
													]
									}
								);

	ventanaAM.show();    
}

function cambiarCampoAgrupacion(combo,registro,indice)
{
	var txtNumReg=gEx('txtNumRegPag');
    if(indice!=0)
        txtNumReg.disable();
    else
        txtNumReg.enable();
	function funcResp()
    {
        arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
        {
        	
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesTblFormularios.php',funcResp, 'POST','funcion=5&idConfiguracion='+idConfiguracion+'&campoAgrupacion='+registro.get('id'),true);
}

function cambiarOrden(combo,registro,indice)
{
	function funcResp()
    {
        arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
        {
        	
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesTblFormularios.php',funcResp, 'POST','funcion=2&idConfiguracion='+idConfiguracion+'&orden='+registro.get('id'),true);
}

function cambiarCampoOrden(combo,registro,indice)
{
	function funcResp()
    {
        arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
        {
        	
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesTblFormularios.php',funcResp, 'POST','funcion=3&idConfiguracion='+idConfiguracion+'&campoOrden='+registro.data.id,true);
}

function cambiarNumRegPaginas(campo,nValor,vValor)
{
	gEx('btnAceptarConf').disable();
	function funcResp()
    {
        arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
        {
       		gEx('btnAceptarConf').enable();
        }
        else
        {
        	function funcResp()
            {
        		gEx('btnAceptarConf').enable();
            }
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0],funcResp);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesTblFormularios.php',funcResp, 'POST','funcion=4&idConfiguracion='+idConfiguracion+'&numReg='+nValor,true);
}




function crearGridConfiguracion()
{
	dsNameDTD=[];
    var ocultoCampo=false;
    if(tipoProceso)
    	ocultoCampo=true;
	alNameDTD=	new Ext.data.SimpleStore(
    											{
    												fields:	[
    															{name: 'idGrupoCampo'},
																{name: 'etFormulario'},
																{name: 'titulo'},
																{name: 'tamColumna'},
                                                                {name: 'alineacion'},
                                                                {name: 'orden', type:'int'},
                                                                {name: 'funcionRenderer'}
    														]
    											}
    										);

    
	var cmGrid= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:40}),
														{
															header:'<?php echo $etj["lblEtFormulario"] ?>',
															width:250,
															sortable:true,
															dataIndex:'etFormulario'
														},
														{
															header:'<?php echo $etj["lblTituloC"] ?>',
															width:230,
															sortable:true,
															dataIndex:'titulo'
														},
                                                        {
															header:'<?php echo $etj["lblTamCol"] ?>',
															width:120,
															sortable:true,
															dataIndex:'tamColumna',
                                                            hidden:ocultoCampo
														},
                                                         {
															header:'<?php echo $etj["lblAlineacion"] ?>',
															width:190,
															sortable:true,
															dataIndex:'alineacion'
														},
                                                         {
															header:'Orden',
															width:90,
															sortable:true,
															dataIndex:'orden'
														},
                                                         {
															header:'Funci&oacute;n renderer',
															width:300,
															sortable:true,
															dataIndex:'funcionRenderer',
                                                            renderer:function(val)
                                                            		{
                                                                    	return mostrarValorDescripcion(formatearValorRenderer(arrFuncionesRenderer,val));
                                                                    }
														}
													]
												);
	var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                        	id:'gridConfiguracion',
                                                            store:alNameDTD,
                                                            frame:false,
                                                            border:true,
                                                            y:0,
                                                            cls:'gridSiugjPrincipal',
                                                            stripeRows :false,
                                                            columnLines : false,
                                                            cm: cmGrid,
                                                            height:290,
                                                            width:850,
                                                            tbar:	[
                                                            				{
                                                                            	text:'<?php echo $etj["lblAddColum"] ?>',
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                handler:function()
                                                                                		{
                                                                                        	mostrarVentanaAgregarCampo();
                                                                                        }	
                                                                            },
                                                                            {
                                                                            	xtype:'tbspacer',
                                                                                width:10
                                                                            },
                                                                            {
                                                                            	text:'<?php echo $etj["lblModColum"] ?>',
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                handler:function()
                                                                                		{
                                                                                        	var sm=tblGrid.getSelectionModel();
                                                                                            var filaSel=sm.getSelected();
                                                                                            if(filaSel==null)
                                                                                            {
                                                                                                msgBox('<?php echo $etj["msgDebeSelElem"]?>');
                                                                                                return;
                                                                                            }
                                                                                            mostrarVentanaConfiguracionCampo(filaSel,1);
                                                                                            

                                                                                            
                                                                                        	
                                                                                        }	
                                                                            },
                                                                            {
                                                                            	xtype:'tbspacer',
                                                                                width:10
                                                                            },
                                                                            {
                                                                            	text:'<?php echo $etj["lblDelColum"] ?>',
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                handler:function()
                                                                                		{
                                                                                        	var sm=tblGrid.getSelectionModel();
                                                                                            var filaSel=sm.getSelected();
                                                                                            if(filaSel==null)
                                                                                            {
                                                                                                msgBox('<?php echo $etj["msgDebeSelElem"]?>');
                                                                                                return;
                                                                                            }
                                                                                            var idGrupoCampo=filaSel.get('idGrupoCampo');
                                                                                            function resp(btn)
                                                                                            {
                                                                                            	if(btn=='yes')
                                                                                                {
                                                                                                	function funcAjax(peticion_http)
                                                                                                    {
                                                                                                        var resp=peticion_http.responseText;
                                                                                                        arrResp=resp.split('|');
                                                                                                        if(arrResp[0]=='1')
                                                                                                        {
                                                                                                            cmbAgrupacion=gEx('cmbAgrupacion');
                                                                                                            var dSetAgrupacion=cmbAgrupacion.getStore();
                                                                                                            var pos=obtenerPosFila(dSetAgrupacion,'id',filaSel.get('etFormulario'));
                                                                                                            dSetAgrupacion.removeAt(pos);
                                                                                                            tblGrid.getStore().remove(filaSel);
                                                                                                            
                                                                                                            var fila;
                                                                                                            var x;
                                                                                                            for(x=0;x<tblGrid.getStore().getCount();x++)
                                                                                                            {
                                                                                                                fila=tblGrid.getStore().getAt(x);
                                                                                                                fila.set('orden',(x+1));
                                                                                                            }
                                                                                                            
                                                                                                            
                                                                                                            if(arrResp[1]=='1')
                                                                                                            {
                                                                                                                cmbAgrupacion.setValue('0');
                                                                                                            }
                                                                                                            generarTabla();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWebV2('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=7&idGrupoCampo='+idGrupoCampo,true);
                                                                                                
                                                                                                
                                                                                                }
                                                                                            	
                                                                                            }
                                                                                            msgConfirm('<?php echo $etj["msgConfirmDel"] ?>',resp);
                                                                                        }	
                                                                            }
                                                            		]
                                                            
                                                        }
                                                    );
											
	return 	tblGrid;									
}

function cargarDatosConfiguracion(almacen,ventanaAM)
{
	var arrCampos=[];
	function funcResp()
    {
        arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
        {
        	var datos=eval(arrResp[1]);
            var arrConf=eval(arrResp[2]);
            
            var arrCamposTabla=eval(arrResp[3]);
            
            var fila;
            confGrid=arrConf[0];
            gEx('txtNumRegPag').setValue(confGrid.numReg);
            gEx('idCmbOrden').setValue(confGrid.direccion);
            
            
            almacen.loadData(datos);
            
            almacen.sort('orden','ASC');
            var cmbAgrupacion=gEx('cmbAgrupacion');
            var almacenCmb=cmbAgrupacion.getStore();
            var rCmb;
            for(z=0;z<almacen.getCount();z++)
            {
            	fila=almacen.getAt(z);
            	rCmb=new regCombo(
                					{
                                    	id:almacen.getAt(z).get('etFormulario'),
                                        nombre:almacen.getAt(z).get('titulo')
                                    }
                                 )
           		almacenCmb.add(rCmb); 
                arrCampos.push([fila.data.etFormulario,fila.data.titulo]);
            }
            gEx('cmbAgrupacion').setValue(confGrid.campoAgrupacion);
           	gEx('idCmbCampos').getStore().loadData(arrCamposTabla);
            gEx('idCmbCampos').setValue(confGrid.campo);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=4&idConfiguracion='+idConfiguracion,true);
}

function mostrarVentanaAgregarCampo()
{
	var tblGrid=crearGridAgregarC();
	var form = new Ext.form.FormPanel(	
												{
													baseCls: 'x-plain',
													layout:'absolute',
													defaultType: 'textfield',
													items: 	[
																{
                                                                	xtype:'label',
                                                                    y:15,
                                                                    x:10,
                                                                    cls:'SIUGJ_Etiqueta',
                                                                    html:'<?php echo $etj["lblSelCampoA"]?>:'
                                                                },
                                                                tblGrid
															]
												}
											);
	ventanaAC = new Ext.Window(
									{
										title: '<?php echo $etj["lblAddColum"]?>',
										width: 940,
										height:470,
										minWidth: 690,
										minHeight: 520,
										layout: 'fit',
										plain:true,
                                        cls:'msgHistorialSIUGJ',
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
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAC.close();
																	}
														},
                                                        {
															id:'btnAceptar',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															text: '<?php echo $etj["lblSiguiente"]?> >>',
															listeners:	{
																			click:function()
																				{
                                                                                
                                                                                	var selModel=tblGrid.getSelectionModel();
                                                                                    var filaSel=selModel.getSelected();
                                                                                    
                                                                                    if(filaSel!=null)
                                                                                    {
                                                                                        ventanaAC.hide();
                                                                                        mostrarVentanaConfiguracionCampo(filaSel,0);
                                                                                        
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                    	 msgBox('<?php echo $etj["msgDebeSelElem"]?>')
                                                                                    }
																				}
																		}
														}
													]
									}
								);
	 cargarDatosAgregarC(alNameCampos,ventanaAC);                                
	                               
}

function crearGridAgregarC()
{
	dsNameCampos=[];
	alNameCampos=	new Ext.data.SimpleStore(
    											{
    												fields:	[
    															{name: 'idGrupoElemento'},
																{name: 'campo'},
                                                                {name: 'tipoCampo'},
                                                                {name: 'funcionRenderer'}
                                                                
    														]
    											}
    										);

   
	var cmGrid= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:50}),
														{
															header:'<?php echo $etj["lblCampo"] ?>',
															width:230,
															sortable:true,
															dataIndex:'campo'
														},
                                                        {
															header:'Tipo de campo',
															width:420,
															sortable:true,
															dataIndex:'tipoCampo',
                                                            renderer:function(val)
                                                            		{
                                                                    	
                                                                    	return mostrarValorDescripcion(formatearValorRenderer(arrTiposElementos,val));
                                                                    }
                                                            
														},
                                                        {
															header:'Funci&oacute;n renderer',
															width:350,
															sortable:true,
															dataIndex:'funcionRenderer',
                                                            renderer:function(val)
                                                            		{
                                                                    	return mostrarValorDescripcion(formatearValorRenderer(arrFuncionesRenderer,val));
                                                                    }
														}
													]
												);
	var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            store:alNameCampos,
                                                            y:60,
                                                            stripeRows :false,
                                                            frame:false,
                                                            border:true,
                                                            cls:'gridSiugjPrincipal',
                                                            columnLines : false,
                                                            cm: cmGrid,
                                                            height:300,
                                                            width:910
                                                        }
                                                    );
											
	return 	tblGrid;									
}

function cargarDatosAgregarC(almacen,ventanaAC)
{
	var idFormulario=gE('idFormulario').value;
	function funcResp()
    {
        arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
        {
        	var datos=eval(arrResp[1]);
            almacen.loadData(datos);
            ventanaAC.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=5&idConfiguracion='+idConfiguracion+'&idFormulario='+idFormulario,true);
}

function mostrarVentanaConfiguracionCampo(filaSel,accion)
{
	var tEntradas=[['1','<?php echo $etj["lblIzquierda"]?>'],['2','<?php echo $etj["lblDerecha"]?>'],['3','<?php echo $etj["lblCentrado"]?>'],['4','<?php echo $etj["lblJustificado"]?>']];
	
	lblBtnAceptar='<?php echo $etj["lblFinalizar"] ?>';
	function obtenerIdiomas()
	{
		var resp=eval(peticion_http.responseText);
		var tblGrid=crearGridElemento(resp);
        
        
        var arrOrden=[];
        
        var nElem=0;
        for(nElem=1;nElem<=gEx('gridConfiguracion').getStore().getCount();nElem++)
        {
        	arrOrden.push([nElem,nElem]);
        }
        if(accion=='0')
        {
        	arrOrden.push([arrOrden.length+1,arrOrden.length+1]);
        }
		
        
        
		var form = new Ext.form.FormPanel(	
												{
													baseCls: 'x-plain',
													layout:'absolute',
													defaultType: 'textfield',
													items: 	[
																tblGrid,
                                                                {
                                                                	id:'lblAncho',
                                                                	x:10,
                                                                    y:210,
                                                                	xtype:'label',
                                                                    cls:'SIUGJ_Etiqueta',
                                                                    html:'<?php echo $etj["lblAnchoCol"]?>: *'
                                                                },
                                                                {
                                                                	id:'txtAncho',
                                                                	x:220,
                                                                    y:205,
                                                                    cls:'controlSIUGJ',
                                                                    xtype:'numberfield',
                                                                    allowdecimals:false,
                                                                    value:'150',
                                                                    width:80
                                                                },
                                                                {
                                                                	x:10,
                                                                    y:260,
                                                                	xtype:'label',
                                                                    cls:'SIUGJ_Etiqueta',
                                                                    html:'<?php echo $etj["lblAlineacion"]?>: *'
                                                                },
                                                                {
                                                                	x:220,
                                                                    y:255,
                                                                    xtype:'label',
                                                                    html:'<div id="cmbComboAlineacion"></div>'
                                                                },
                                                                {
                                                                	x:510,
                                                                    y:260,
                                                                    cls:'SIUGJ_Etiqueta',
                                                                    xtype:'label',
                                                                    html:'Orden:'
                                                                },
                                                                {
                                                                	x:590,
                                                                    y:255,
                                                                    xtype:'label',
                                                                    html:'<div id="cmbComboOrden"></div>'
                                                                },
                                                                 {
                                                                	x:10,
                                                                    y:310,
                                                                    xtype:'label',
                                                                    cls:'SIUGJ_Etiqueta',
                                                                    html:'Funcion renderer:'
                                                                },
                                                                {
                                                                	x:220,
                                                                    y:305,
                                                                    xtype:'label',
                                                                    html:'<div id="cmbComboRenderer"></div>'
                                                                },
                                                                {
                                                                	x:10,
                                                                    y:360,
                                                                    xtype:'label',
                                                                    cls:'SIUGJ_Etiqueta',
                                                                    html:'Campo visible:'
                                                                },
                                                                {
                                                                	x:220,
                                                                    y:355,
                                                                    xtype:'label',
                                                                    html:'<div id="cmbComboVisible"></div>'
                                                                }
															]
												}
											);
		
		ventanaEtiquetas = new Ext.Window(
											{
												title: accion=='0'?'Agregar columna':'Modificar columna',
												width: 750,
												height:510,
												minWidth: 300,
												minHeight: 100,
												layout: 'fit',
												plain:true,
												modal:true,
                                                cls:'msgHistorialSIUGJ',
												bodyStyle:'padding:5px;',
												buttonAlign:'center',
												items: form,
												listeners : {
															show : {
																		buffer : 10,
																		fn : function() 
																		{
																			pIdioma=obtenerPosFila(alNameDTD,'idIdioma',gE('hLeng').value);
																			if(pIdioma!=-1)
																			{
																				tblGrid.startEditing(pIdioma,1);
																			}
                                                                            
                                                                            var comboAlineacion=crearComboExt('idCmbAlineacion',tEntradas,0,0,250,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'cmbComboAlineacion'});
                                                                            var cmbOrden=crearComboExt('cmbOrden',arrOrden,0,0,110,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'cmbComboOrden'});
																			var cmbRenderer=crearComboExt('cmbRenderer',arrFuncionesRenderer,0,0,470,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'cmbComboRenderer'});
                                                                        	var cmbCampoVisible=crearComboExt('cmbCampoVisible',arrSiNo,0,0,110,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'cmbComboVisible'});
																	        cmbCampoVisible.setValue('1');
                                                                        
                                                                        	if(accion==0)
                                                                            {
                                                                                
                                                                                gEx('cmbOrden').setValue(gEx('gridConfiguracion').getStore().getCount()+1);
                                                                                gEx('cmbRenderer').setValue(filaSel.data.funcionRenderer);
                                                                                
                                                                                
                                                                            }
                                                                            else
                                                                            {
                                                                                gEx('cmbOrden').setValue(filaSel.data.orden);
                                                                                gEx('cmbRenderer').setValue(filaSel.data.funcionRenderer);
                                                                                llenarDatosConfCampo(filaSel.get('idGrupoCampo'),ventanaEtiquetas);
                                                                            }
                                                                        
                                                                        
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
                                                                            	ventanaEtiquetas.close();
//																				destruirVentanas();
                                                                                
																			}
																},
                                                                {
																	id:'btnAceptar',
                                                                    
                                                                    cls:'btnSIUGJ',
			                                                        width:140,
																	text: lblBtnAceptar,
																	listeners:	{
																					click:function()
																						{
																							if(validarGridConf(tblGrid))
																							{
                                                                                            	if(accion==0)
                                                                                                {
                                                                                                    var idCampo=filaSel.get('idGrupoElemento');
                                                                                                    var etCampo=filaSel.get('campo');
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                	var idCampo=filaSel.get('idGrupoCampo');
                                                                                                	var etCampo=filaSel.get('etFormulario');
                                                                                                }
                                                                                                var anchoCol=gEx('txtAncho').getValue();
                                                                                                
                                                                                                if(anchoCol=='')
                                                                                                {
                                                                                                	function resp()
                                                                                                    {
                                                                                                    	gEx('txtAncho').focus();
                                                                                                    }
                                                                                                     msgBox('<?php echo $etj["lblValInv"] ?>',resp);
                                                                                                	return;
                                                                                                }
                                                                                                
                                                                                                var idAlineacion=gEx('idCmbAlineacion').getValue();
                                                                                                if(idAlineacion=='')
                                                                                                {
                                                                                                	function respAl()
                                                                                                    {
                                                                                                    	gEx('idCmbAlineacion').focus();
                                                                                                    }
                                                                                                    msgBox('Debe seleccionar la alineaci&oacute;n del elemento',respAl);
                                                                                                    return;
                                                                                                }
                                                                                                
                                                                                                

                                                                                                
                                                                                                var idIdioma=gE('hLeng').value;
                                                                                                var filaIdioma=obtenerFilaIdioma(tblGrid.getStore(),idIdioma);
                                                                                                var tCampo=filaIdioma.get('etiqueta');
                                                                                                var arrEtiqueta=obtenerValoresVentanaTitulo();
                                                                                                var objCampo='{"funcionRenderer":"'+gEx('cmbRenderer').getValue()+'","orden":"'+gEx('cmbOrden').getValue()+
                                                                                                			'","idCampo":"'+idCampo+'","etCampo":"'+etCampo+'","anchoCol":"'+anchoCol+
                                                                                                            '","tituloCampo":'+arrEtiqueta+',"accion":"'+accion+'","idAlineacion":"'+idAlineacion+
                                                                                                            '","idConfiguracion":"'+idConfiguracion+'","visible":"'+gEx('cmbCampoVisible').getValue()+'"}';
                                                                                                var txtAlineacion=gEx('idCmbAlineacion').getRawValue();
                                                                                                
                                                                                                var gridConfiguracion=gEx('gridConfiguracion');
                                                                                                
                                                                                                function resp()
                                                                                                {
                                                                                                	var arrResp=peticion_http.responseText.split('|');
                                                                                                    if(arrResp[0]=='1')
                                                                                                    {
                                                                                                        if(idElemento=='-1')
                                                                                                        {
                                                                                                        
                                                                                                        	if(accion==0)
                                                                                                            {
                                                                                                                var nFila=new rColumna	(
                                                                                                                                            {
                                                                                                                                                idGrupoCampo:arrResp[1],
                                                                                                                                                etFormulario:etCampo,
                                                                                                                                                titulo:tCampo,
                                                                                                                                                tamColumna:anchoCol,
                                                                                                                                                alineacion:txtAlineacion,
                                                                                                                                                orden:parseInt(gEx('cmbOrden').getValue()),
                                                                                                                                                funcionRenderer:gEx('cmbRenderer').getValue()
                                                                                                                                            }
                                                                                                                                        )
                                                                                                                                        
                                                                                                                
                                                                                                                var nAux=0;
                                                                                                                var fAux;
                                                                                                                for(nAux=0;nAux<gridConfiguracion.getStore().getCount();nAux++)                        
                                                                                                                {
                                                                                                                	fAux=gridConfiguracion.getStore().getAt(nAux);
                                                                                                                    if(parseInt(fAux.data.orden)>=parseInt(gEx('cmbOrden').getValue()))
                                                                                                                    {
                                                                                                                    	fAux.set('orden',parseInt(fAux.data.orden+1));
                                                                                                                    }
                                                                                                                }
                                                                                                                                        
                                                                                                                gEx('gridConfiguracion').getStore().add(nFila);
                                                                                                                var almacenCmb=gEx('cmbAgrupacion').getStore();
                                                                                                                rCmb=new regCombo(
                                                                                                                                    {
                                                                                                                                        id:etCampo,
                                                                                                                                        nombre:tCampo
                                                                                                                                    }
                                                                                                                                 )
                                                                                                                almacenCmb.add(rCmb); 
                                                                                                                
                                                                                                                
                                                                                                            }
                                                                                                            else
                                                                                                            {
                                                                                                            	filaSel.set('titulo',tCampo);
                                                                                                                filaSel.set('tamColumna',anchoCol);
                                                                                                                filaSel.set('alineacion',txtAlineacion);
                                                                                                                filaSel.set('funcionRenderer',gEx('cmbRenderer').getValue());
                                                                                                                var nAux=0;
                                                                                                                var fAux;
                                                                                                                
                                                                                                                if(parseInt(filaSel.data.orden)!=parseInt(gEx('cmbOrden').getValue()))
                                                                                                                {
                                                                                                                	if(parseInt(filaSel.data.orden)>parseInt(gEx('cmbOrden').getValue()))
                                                                                                                    {
                                                                                                                        for(nAux=0;nAux<gridConfiguracion.getStore().getCount();nAux++)                        
                                                                                                                        {
                                                                                                                            fAux=gridConfiguracion.getStore().getAt(nAux);
                                                                                                                            if((parseInt(fAux.data.orden)>=parseInt(gEx('cmbOrden').getValue()))&&(parseInt(fAux.data.orden)<parseInt(filaSel.data.orden)))
                                                                                                                            {
                                                                                                                                fAux.set('orden',parseInt(fAux.data.orden+1));
                                                                                                                            }
                                                                                                                        }
                                                                                                                    }
                                                                                                                    else
                                                                                                                    {
                                                                                                                    	for(nAux=0;nAux<gridConfiguracion.getStore().getCount();nAux++)                        
                                                                                                                        {
                                                                                                                            fAux=gridConfiguracion.getStore().getAt(nAux);
                                                                                                                           	if((parseInt(fAux.data.orden)>=parseInt(filaSel.data.orden))&&(parseInt(fAux.data.orden)<=parseInt(gEx('cmbOrden').getValue())))
                                                                                                                            {
                                                                                                                                fAux.set('orden',parseInt(fAux.data.orden-1));
                                                                                                                            }
                                                                                                                        }
                                                                                                                    }
																												}                                                                                                                
                                                                                                                
                                                                                                                filaSel.set('orden',parseInt(gEx('cmbOrden').getValue()));
                                                                                                                cmbAgrupacion=gEx('cmbAgrupacion');
                                                                                                                var dSetAgrupacion=cmbAgrupacion.getStore();
                                                                                                                var pos=obtenerPosFila(dSetAgrupacion,'id',filaSel.get('etFormulario'));
                                                                                                                
                                                                                                                var filaAgrupacion=dSetAgrupacion.getAt(pos);
                                                                                                                filaAgrupacion.set('nombre',tCampo);
                                                                                                            }
                                                                                                            
                                                                                                            gridConfiguracion.getStore().sort('orden','ASC');
                                                                                                            
                                                                                                            ventanaEtiquetas.close();
                                                                                                            generarTabla();
                                                                                                        }
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',resp, 'POST','funcion=6&objCampo='+objCampo,true);
																							}
																						}
																				}
																}
															]
											}
										);
                                        
                                        
        ventanaEtiquetas.show();                        
		
		
	}
	obtenerDatosWeb('../paginasFunciones/funciones.php',obtenerIdiomas, 'POST','funcion=4',true);
}

function validarGridConf(tblGrid)
{
	var res=validarCampos(tblGrid);
	switch(res)
	{
		case 0: //Sin problemas
			return true;	
		break;
		case 1: //Algun campo obligatorio del idioma original no fue ingresado
		
			function funcAceptar()
			{
				tblGrid.startEditing(filaError,celdaError);
				return false;
			}
			msgBox('<?php echo $etj["msgErrorCeldaVacia"] ?>',funcAceptar);
			
		break;
		case 2: //Algun campo obligatorio de idioma NO original fue ingresado
			function funcConfirmacion(btn)
			{
				if(btn=='yes')
				{
					var dSet=tblGrid.getStore();
					var fIdioma=obtenerFilaIdioma(dSet,gE('hLeng').value);
					var cModelo=tblGrid.getColumnModel();
					var campo='';
					var valor='';
					var col;
					for(col=0;col<cModelo.getColumnCount();col++)
					{
						campo=cModelo.getDataIndex(col);
						valor=fIdioma.get(campo);
						if(valor!='')
						{
							rellenarValoresVacios(dSet,campo,'['+valor+']');
						}
					}
					
					
					
					gEx('btnAceptar').fireEvent('click');
				}
				else
					return false;
			}
			msgConfirm('<?php echo $etj["msgErrorOpcionV"] ?>', funcConfirmacion);
		break;
	}
}

function validarCampos(tblGrid)		
{
	var idIdioma=gE('hLeng').value;
	var dSet=tblGrid.getStore();
	var fila=obtenerFilaIdioma(dSet,idIdioma);
	
	if(fila!=null)
	{
		var cModelo=tblGrid.getColumnModel();
		var tituloColumna='';
		var campo;
		var valor;
		var posFila=obtenerPosFila(dSet,'idIdioma',idIdioma);
		var arrCampos='';
		
		for(x=0;x<cModelo.getColumnCount();x++)
		{
			tituloColumna=cModelo.getColumnHeader(x);
			if(tituloColumna.indexOf('*')>=0)
			{
				
				campo=cModelo.getDataIndex(x);
				valor=fila.get(campo);
				if(arrCampos=='')
					arrCampos=campo;
				else
					arrCampos+='|'+campo;
				if(valor.trim()=='')
				{
					filaError=posFila;
					celdaError=x;
					return 1;	
				}
			}
		}
		aCampo=arrCampos.split('|');
		for(x=0;x<dSet.getCount();x++)
		{
			if(x!=posFila)
			{
				fila=dSet.getAt(x);
				for(y=0;y<aCampo.length;y++)
				{
					valor=fila.get(aCampo[y]);
					if(valor.trim()=='')
					{
						filaError=posFila;
						celdaError=x;
						return 2;
					}
				}
			}
		}
	}
	return 0;
}

function crearGridElemento(datos)
{
	tituloElemento='<?php echo $etj["lblTituloC"] ?>';

	var dsNameDTD= 	[];					
    alNameDTD=		new Ext.data.SimpleStore(
    											{
    												fields:	[
    															{name: 'idioma'},
																{name: 'idIdioma'},
																{name: 'etiqueta'},
                                                                {name: 'idCamposGrid'}
    														]
    											}
    										);
    alNameDTD.loadData(dsNameDTD);
	llenarDatos(datos);
	
	var cmFrmDTD= new Ext.grid.ColumnModel   	(
												 	[
													 	{
															header:'<?php echo $etj["lblLenguaje"]?>',
															width:140,
                                                            align:'center',
															dataIndex:'idioma',
															renderer: cambiarColor
														},
														{
															header:tituloElemento+' *',
															width:600,
															dataIndex:'etiqueta',
															editor: new Ext.form.TextField   (
																									{
																									   style: 'text-align:left',
                                                                                                       cls:'controlSIUGJ'
																									}
																								)
														}
													]
												);
											
	tblFrmDTD=	new Ext.grid.EditorGridPanel	(
                                                    {
                                                    	id:'gridEtiquetas',
                                                        store:alNameDTD,
                                                        frame:false,
                                                        stripeRows :false,
                                                        border:true,    
                                                        cls:'gridSiugjPrincipal',
                                                        columnLines : false,
                                                        clicksToEdit: 1,
                                                        cm: cmFrmDTD,
                                                        height:190,
                                                        width:720
                                                    }
							                    );
	
	return tblFrmDTD;	
}	

function llenarDatos(datos)
{
	for (x=0;x<datos.length;x++)
	{
		
		var FilaRegistro = new rgIdiomas(
                                            {
                                                    idioma:datos[x].imagen,
                                                    idIdioma: datos[x].idIdioma,
                                                    etiqueta: '',
                                                    idCamposGrid:-1
                                               }
                                          );
                                                  
        alNameDTD.add(FilaRegistro); 
	}
}

function destruirVentanas()
{
	if(ventanaAM!=null)
    {
    	ventanaAM.close();
        ventanaAM.destroy();
        ventanaAM=null;
    }	
    
    if(ventanaAC!=null)
    {
    	ventanaAC.close();
        ventanaAC.destroy();
        ventanaAC=null;
    }	
    
    if(ventanaEtiquetas!=null)
    {
    	ventanaEtiquetas.close();
        ventanaEtiquetas.destroy();
        ventanaEtiquetas=null;
    }
    
}

function obtenerValoresVentanaTitulo()
{
	var dsGrid=gEx('gridEtiquetas').getStore();
    var fila;
	var idIdioma;
	var etiqueta;
    var idCamposGrid;
   
	var arrObj="";
	var obj;
	var x;
    var arrEtiqueta;
    for(x=0;x<dsGrid.getCount();x++)
	{
		fila=dsGrid.getAt(x);
		idIdioma=fila.get('idIdioma');
		etiqueta=fila.get('etiqueta');
        idCamposGrid=fila.get('idCamposGrid');
        
		obj='{"idIdioma":"'+idIdioma+'","etiqueta":"'+cv(etiqueta)+'","idCamposGrid":'+idCamposGrid+'}';
		if(arrObj=="")
			arrObj=obj;
		else
			arrObj+=','+obj;
	}
    arrEtiqueta='['+arrObj+']';

	return arrEtiqueta;
}

function generarTabla()
{
	var almacen=gEx('gridConfiguracion').getStore();
    var x=0;
    var numFilas=almacen.getCount();
    var filas;
    var columnas='';
    camposJava=new Array();
    columnasJava=new Array();
    var formPrincipal=gE('formPrincipal').value;
    columnasJava[0]=new  Ext.grid.RowNumberer({width:40});
    camposJava[0]={name: 'idRegistro' };
    for(x=0;x<numFilas;x++)
    {
        filas=almacen.getAt(x);
        numCampo=x+1;
        camposJava[numCampo]={name:'campo_'+numCampo};
        
        columnasJava[numCampo]={								
                                    header:filas.get('titulo'),
                                    width:parseInt(filas.get('tamColumna')),
                                    sortable:true,
                                    dataIndex:'campo_'+numCampo,
                                    align:'left',
                                    resizable:false
                                };
    }
    var tblRegistro=gE('tblRegistros');
    var tblContenedor=tblRegistro.parentNode;
    tblContenedor.removeChild(tblRegistro);

    var nuevoTbl=document.createElement('div');
    nuevoTbl.id='tblRegistros';
    tblContenedor.appendChild(nuevoTbl);
    crearTablaRegistros();
	
    

}

function llenarDatosConfCampo(idGrupoCampo)
{
	function resp()
    {
    	var arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
        {
        	var resp=eval(arrResp[1]);
            var obj=resp[0];
            var tamCol=obj.tamColumna;
            var arrTitulos=obj.arrTitulos;
            var idAlineacion=obj.idAlineacion;
            gEx('cmbCampoVisible').setValue(obj.visible);
            
            gEx('txtAncho').setValue(tamCol);
            gEx('gridEtiquetas').getStore().loadData(arrTitulos);
            gEx('idCmbAlineacion').setValue(idAlineacion);
           	ventanaEtiquetas.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
	obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',resp, 'POST','funcion=8&idGrupoCampo='+idGrupoCampo,true);
}

var camposJava=new Array( <?php echo $campos; ?>);

var columnasJava=new Array(<?php echo $columnModel; ?>);

function crearTablaRegistros()
{
	
	var datos=[['','','']];
	var dsTablaRegistros= new Ext.data.SimpleStore	(
                                                        {
                                                            fields:camposJava
                                                                    
                                                        }
                                                    );
	
    dsTablaRegistros.loadData(datos);
	
    var modelColumn= new Ext.grid.ColumnModel   	(
												 		columnasJava
													);



	
	var gridRegistros=	new Ext.grid.GridPanel	(
                                                  {
                                                  	  
                                                      store:dsTablaRegistros,
                                                      frame:false,
                                                      border:false,
                                                      cm: modelColumn,
                                                      stripeRows :false,
                                                      region:'center',
                                                      columnLines : false,
                                                      cls:'gridSiugjPrincipal',
                                                      disableSelection:true,
                                                      tbar:	[
                                                      			
                                                      			{
                                                                	id:'btnAgregarLabel1',
                                                                	icon:'../principalPortal/imagesSIUGJ/add.png',
                                                                	text:bD(gE('btnAgregarLabel').value),
                                                                    handler:function()
                                                                    		{
                                                                            	mostrarVentanaEditarBotonAccion(1);
                                                                            }
                                                                    
                                                                },
                                                                {
                                                                	xtype:'tbspacer',
                                                                    width:10
                                                                },
                                                                {
                                                                	id:'btnVerLabel1',
                                                                	icon:'../images/book_open.png',
                                                                	text:bD(gE('btnVerLabel').value),
                                                                    handler:function()
                                                                    		{
                                                                            	mostrarVentanaEditarBotonAccion(2);
                                                                            }
                                                                    
                                                                },
                                                                {
                                                                	xtype:'tbspacer',
                                                                    width:10
                                                                },
                                                      			{
                                                                	id:'btnModificarLabel1',
                                                                	icon:'../images/pencil.png',
                                                                	text:bD(gE('btnModificarLabel').value),
                                                                    handler:function()
                                                                    		{
                                                                            	mostrarVentanaEditarBotonAccion(3);
                                                                            }
                                                                    
                                                                },
                                                                {
                                                                	xtype:'tbspacer',
                                                                    width:10
                                                                },
                                                                {
                                                                	id:'btnEliminarLabel1',
                                                                	icon:'../principalPortal/imagesSIUGJ/delete.png',
                                                                	text:bD(gE('btnEliminarLabel').value),
                                                                    handler:function()
                                                                    		{
                                                                            	mostrarVentanaEditarBotonAccion(4);
                                                                            }
                                                                }
                                                      		],
                                                      
                                                      bbar: new Ext.PagingToolbar	(
                                                                                      {
                                                                                            pageSize: 2,
                                                                                            store: dsTablaRegistros,
                                                                                            displayInfo: true,
                                                                                            displayMsg: '{0} - {1} of {2}',
                                                                                            emptyMsg: "No vac�o",
                                                                                            disabled:true
                                                                                    	}
                                                                                     )

                                                  }
                                              );
                                              
	new Ext.Panel	(
    					{
                        	xtype:'panel',
                            border:true,
                            height:480,
                            width:(obtenerDimensionesNavegador()[1]*0.9),
                            renderTo:'tblRegistros',
                            layout:'border',
                            items:	[
                            			{
                                            
                                             layout:'border',
                                             border:true,
                                             cls:'panelSiugj',
                                             region:'center',
                                             tbar:	[
                                                        {
                                                            icon:'../images/salir.gif',
                                                            cls:'x-btn-text-icon',
                                                            text:'Salir',
                                                            handler:function()
                                                                    {
                                                                        regresarPagina()
                                                                    }
                                                            
                                                        },
                                                        {
                                                            xtype:'tbspacer',
                                                            width:10
                                                        },
                                                        {
                                                            icon:'../images/page_white_gear.png',
                                                            cls:'x-btn-text-icon',
                                                            text:'Reconfigurar listado de registros',
                                                            handler:function()
                                                                    {
                                                                        configurarGrid()
                                                                    }
                                                            
                                                        },
                                                        {
                                                            xtype:'tbspacer',
                                                            width:10
                                                        },
                                                        {
                                                            icon:'../images/filtro.png',
                                                            cls:'x-btn-text-icon',
                                                            text:'Admon. de filtros globales',
                                                            handler:function()
                                                                    {
                                                                        mostrarVentanaAdmonFiltros();
                                                                    }
                                                            
                                                        },
                                                        {
                                                            xtype:'tbspacer',
                                                            width:10
                                                        },
                                                        {
                                                            icon:'../images/database_table.png',
                                                            cls:'x-btn-text-icon',
                                                            text:'Admon. de &iacute;ndices',
                                                            handler:function()
                                                                    {
                                                                        mostrarVentanaIndices();
                                                                    }
                                                            
                                                        }    
                                                    ],
                                             items:	[
                                                        new Ext.Panel	(
                                                                            {
                                                                                region:'center',
                                                                                layout:'border',	
                                                                                border:true,
                                                                                cls:'panelSiugjWrap',
                                                                                <?php
                                                                                    if($arrFiltros!="{xtype:'tbspacer',width:20}")
                                                                                    {
                                                                                 ?>
                                                                                 tbar:	[
                                                                                            <?php echo $arrFiltros?>
                                                                                        ],
                                                                                 <?php
                                                                                    }
                                                                                 ?>
                                                                            
                                                                                items:	[
                                                                                            gridRegistros
                                                                                        ]
                                                                                
                                                                            }
                                                                        )
                                                    ]
                                             
                                             
                                            
                                        }
                            		]
                        }
    				)                                              
                                              
	                                            
}

///

function mostrarVentanaIndices()
{
	var gridIndices=crearGridIndices();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
														gridIndices

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Administraci&oacute;n de &iacute;ndices',
										width: 700,
										height:450,
										layout: 'fit',
										plain:true,
										modal:true,
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

function crearGridIndices()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			
		                                                {name: 'etiqueta'},
		                                                {name:'camposAsociadosLbl'},
                                                        {name:'camposAsociadosID'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesFormulario.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'etiqueta', direction: 'ASC'},
                                                            groupField: 'etiqueta',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='212';
                                        proxy.baseParams.idFormulario=<?php echo $idFormulario?>;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            
                                                            {
                                                                header:'&Iacute;ndice',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'etiqueta',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            
                                                            
                                                            
                                                            {
                                                                header:'Campos asociados',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'camposAsociadosLbl',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gIndices',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                border:true,
                                                                cls:'gridSiugjPrincipal',
                                                                region:'center',
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Crear &iacute;ndice',
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaIndice();
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                            	xtype:'tbspacer',
                                                                                width:10
                                                                            },
                                                                            {
                                                                            
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Modificar &iacute;ndice',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=tblGrid.getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el &iacute;ndice que desea modificar');
                                                                                            	return;
                                                                                            }
                                                                                            mostrarVentanaIndice(fila);
                                                                                            
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                            	xtype:'tbspacer',
                                                                                width:10
                                                                            },
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover &iacute;ndice',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=tblGrid.getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el &iacute;ndice que desea remover');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            
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
                                                                                                            tblGrid.getStore().remove(fila);
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=213&idFormulario=<?php echo $idFormulario?>&indice='+fila.data.etiqueta,true);
                                                                                                    
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('&iquest;Est&aacute; seguro de querer remover el &iacute;ndice <b>'+fila.data.etiqueta+'</b>?',resp);
                                                                                            
                                                                                            
                                                                                        }
                                                                                
                                                                            }
                                                                		],
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
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


function mostrarVentanaIndice(fila)
{
	var gridCamposIndices=crearGridCamposIndice();
    var gridCamposTabla=crearGridCamposTabla();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:15,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Nombre Indice:'
                                                        },
                                                        {
                                                        	x:180,
                                                            y:10,
                                                            xtype:'textfield',
                                                            cls:'controlSIUGJ',
                                                            value:(fila?fila.data.etiqueta:''),
                                                            id:'txtNombreIndice',
                                                            maskRe :/[0-9a-zA-Z]/,
                                                            width:350
                                                        },
                                                        {
                                                        	x:478,
                                                            y:135,
                                                            border:false,
                                                            xtype:'panel',
                                                            width:40,
                                                            layout:'absolute',
                                                            height:95,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                            			{
                                                                        	xtype:'button',
                                                                            width:40,
                                                                            height:40,
                                                                            x:0,
                                                                            y:0,
                                                                            cls:'btnSIUGJCancel',
                                                                            icon:'../images/less_than.png',                                                                            
                                                                            handler:function()
                                                                            		{
                                                                                    	var gridCamposTabla=gEx('gridCamposTabla');
                                                                                        var gridCamposIndices=gEx('gridCamposIndices');
                                                                                    	var filas=gridCamposTabla.getSelectionModel().getSelections();
                                                                                        var x;
                                                                                        var f;
                                                                                        var nRegistros=gridCamposIndices.getStore().getCount()+1;
                                                                                        var r;
                                                                                        for(x=0;x<filas.length;x++)
                                                                                        {
                                                                                        	f=filas[x];
                                                                                        	r=new rCampoIndice	(
                                                                                            						{
                                                                                                                    	idCampo:f.data.idCampo,
                                                                                                                        campo:f.data.campo,
                                                                                                                        orden:nRegistros
                                                                                                                    }		
                                                                                            					)
                                                                                            gEx('gridCamposIndices').getStore().add(r);
                                                                                        	nRegistros++;
                                                                                        }
                                                                                        
                                                                                        
                                                                                        gridCamposIndices.getStore().sort('orden','ASC');
                                                                                        
                                                                                        gridCamposTabla.getStore().remove(filas);
                                                                                        
                                                                                        
                                                                                    }
                                                                        },
                                                                        {
                                                                        	xtype:'button',
                                                                            width:40,
                                                                            height:40,
                                                                            x:0,
                                                                            y:55,
                                                                            cls:'btnSIUGJCancel',
                                                                            icon:'../images/greater_than.png',
                                                                            
                                                                            handler:function()
                                                                            		{
                                                                                    	var gridCamposIndices=gEx('gridCamposIndices');
                                                                                    	var filas=gridCamposIndices.getSelectionModel().getSelections();
                                                                                        
                                                                                        var x;
                                                                                        var f;
                                                                                        var r;
                                                                                        for(x=0;x<filas.length;x++)
                                                                                        {
                                                                                        	f=filas[x];
                                                                                        	r=new rCampoTabla	(
                                                                                            						{
                                                                                                                    	idCampo:f.data.idCampo,
                                                                                                                        campo:f.data.campo
                                                                                                                    }		
                                                                                            					)
                                                                                            gEx('gridCamposTabla').getStore().add(r);
                                                                                        	
                                                                                        }
                                                                                        
                                                                                        gridCamposIndices.getStore().remove(filas);
                                                                                        for(x=0;x<gridCamposIndices.getStore().getCount();x++)                                                                                               
                                                                                        {
                                                                                            f=gridCamposIndices.getStore().getAt(x);
                                                                                            f.set('orden',(x+1));
                                                                                        }
                                                                                    	
                                                                                    	gEx('gridCamposIndices').getStore().sort('orden','ASC');
                                                                                    
                                                                                    }
                                                                        }
                                                            		]
                                                        
                                                        },
                                                        gridCamposIndices,
                                                        gridCamposTabla

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: fila?'Modificar &iacute;ndice':'Crear &iacute;ndice',
										width: 980,
										height:450,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	gEx('txtNombreIndice').setValue((fila?fila.data.etiqueta:'idx_<?php echo $idFormulario?>_'+generarNumeroAleatorio(1,10000)));
                                                                	gEx('txtNombreIndice').focus(false,500);
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
                                                                    	var txtNombreIndice=gEx('txtNombreIndice');
                                                                        
                                                                        if(txtNombreIndice.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtNombreIndice.focus();
                                                                            }
                                                                            msgBox('Debe indicar el nombre del &iacute;ndice',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        var idIndice=(fila?fila.data.idIndice:-1);
                                                                        var gIndices=gEx('gIndices').getStore();
                                                                        
                                                                        
                                                                        
																		if(gridCamposIndices.getStore().getCount()==0)
                                                                        {
                                                                        	msgBox('Almenos debe indicar un campo sobre el cual ser&aacute; creado el &iacute;ndice')
                                                                        	return;
                                                                        }
                                                                        
                                                                        var listaCampos='';
                                                                        var x;
                                                                        var f;
                                                                        for(x=0;x<gridCamposIndices.getStore().getCount();x++)
                                                                        {
                                                                        	f=gridCamposIndices.getStore().getAt(x);
                                                                            
                                                                            if(listaCampos=='')
                                                                            	listaCampos=f.data.idCampo;
                                                                            else
                                                                            	listaCampos+=','+f.data.idCampo;
                                                                            
                                                                        }
                                                                        
                                                                        var cadObj='{"idFormulario":"<?php echo $idFormulario?>","nombreIndice":"'+(fila?fila.data.etiqueta:'')+'","nombre":"'+cv(txtNombreIndice.getValue())+'","campos":"'+listaCampos+'"}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gIndices').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=211&cadObj='+cadObj,true);
                                                                        
                                                                        
                                                                        
																	}
														}
														
													]
									}
								);
	ventanaAM.show();
    
    
    	
    var arrCamposIndice=[];
    var arrCamposDiponibles=[];
    
    var x;
    var pos;
    
    if(fila)
    {
        var aCamposIndice=fila.data.camposAsociadosID.split(',');
       	
       	for(x=0;x<aCamposIndice.length;x++) 
        {
        	pos=existeValorMatriz(arrControles,aCamposIndice[x]);
            
            if(pos==-1)
            {
            	arrCamposIndice.push([aCamposIndice[x],aCamposIndice[x],(x+1)]);
            }
            else
            {
            	arrCamposIndice.push([arrControles[pos][0],arrControles[pos][1],(x+1)]);
            }

       	}
       
    }


	var aControlesAux=[['id__<?php echo $idFormulario?>_tablaDinamica','id__<?php echo $idFormulario?>_tablaDinamica']];
	for(x=0;x<arrControles.length;x++)
    {
    	aControlesAux.push([arrControles[x][0],arrControles[x][1]]);
    }
    for(x=0;x<aControlesAux.length;x++)
    {
    	pos=existeValorMatriz(arrCamposIndice,aControlesAux[x][0]);
        if(pos==-1)
	    	arrCamposDiponibles.push([aControlesAux[x][0],aControlesAux[x][1]]);
    }
    
    gridCamposTabla.getStore().loadData(arrCamposDiponibles);
    gEx('gridCamposIndices').getStore().loadData(arrCamposIndice);
}

function crearGridCamposIndice()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                        			{name: 'idCampo'},
                                                                    {name: 'campo'},
                                                                    {name: 'orden',type:'int'}
                                                                    
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	
														chkRow,
														{
															header:'Campo',
															width:310,
															sortable:true,
															dataIndex:'campo',
                                                            renderer:mostrarValorDescripcion
														},
														{
															header:'Orden',
															width:80,
															sortable:true,
															dataIndex:'orden'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridCamposIndices',
                                                            store:alDatos,
                                                            frame:false,
                                                            border:true,
                                                            y:55,
                                                            x:10,
                                                            title:'Campos del &iacute;ndice',
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :false,
                                                            columnLines : false,
                                                            height:280,
                                                            width:460,
                                                            cls:'gridSiugjPrincipal',
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	xtype:'label',
                                                                            html:'<div class="letraNombreTablero">Modificar orden:</div>'
                                                                        },
                                                                        {
                                                                        	xtype:'tbspacer',
                                                                            width:10
                                                                        },
                                                                        {
                                                                        	icon:'../images/up.png',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el campo cuyo orden desea modificar');
                                                                                        	return;
                                                                                        }
                                                                                        if(fila.data.orden>1)
                                                                                        {
                                                                                        	var filaAux=tblGrid.getStore().getAt(fila.data.orden-2);
                                                                                            fila.data.orden-=1;
                                                                                            filaAux.data.orden+=1;
                                                                                            tblGrid.getStore().sort('orden','ASC');
                                                                                        }
                                                                                    	
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	xtype:'tbspacer',
                                                                            width:10
                                                                        },
                                                                        {
                                                                        	icon:'../images/down.png',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el campo cuyo orden desea modificar');
                                                                                        	return;
                                                                                        }
                                                                                        if(fila.data.orden<tblGrid.getStore().getCount())
                                                                                        {
                                                                                        	var filaAux=tblGrid.getStore().getAt(fila.data.orden);
                                                                                            fila.data.orden+=1;
                                                                                            filaAux.data.orden-=1;
                                                                                            tblGrid.getStore().sort('orden','ASC');
                                                                                        }
                                                                                    	
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;	
}

function crearGridCamposTabla()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                        			{name: 'idCampo'},
                                                                    {name: 'campo'}
                                                                    
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	
														chkRow,
														{
															header:'Campo',
															width:340,
															sortable:true,
															dataIndex:'campo',
                                                            renderer:mostrarValorDescripcion
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridCamposTabla',
                                                            store:alDatos,
                                                            title:'Campos del formulario',
                                                            y:55,
                                                            x:520,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :false,
                                                            frame:false,
                                                            border:true,
                                                            cls:'gridSiugjPrincipal',
                                                            columnLines : false,
                                                            height:280,
                                                            width:430,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;
}

function mostrarVentanaEditarBotonAccion(a)
{
	var titulo='';
    var idEtiqueta='';
	switch(a)
    {
    	case 1:
        	idEtiqueta='btnAgregarLabel';
        break;
        case 2:
        	idEtiqueta='btnVerLabel';
        break;
        case 3:
        	idEtiqueta='btnModificarLabel';
        break;
        case 4:
        	idEtiqueta='btnEliminarLabel';
        break;
    }

	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:15,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Etiqueta:'
                                                        },
                                                        {
                                                        	x:140,
                                                            y:10,
                                                            width:380,
                                                            xtype:'textfield',
                                                            id:'txtEtiqueta',
                                                            cls:'controlSIUGJ',
                                                            value:bD(gE(idEtiqueta).value)
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Modificar bot&oacute;n de acci&oacute;n',
										width: 550,
										height:170,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	gEx('txtEtiqueta').focus(false,500);
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
                                                                    	var txtEtiqueta=gEx('txtEtiqueta');
                                                                        if(txtEtiqueta.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtEtiqueta.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar la etiqueta del bot&oacute;n',resp)
                                                                        	return;
                                                                        }
																		function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                             	gE(idEtiqueta).value=bE(txtEtiqueta.getValue());   
                                                                                gEx(idEtiqueta+'1').setText(txtEtiqueta.getValue());
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=207&c='+idEtiqueta+'&v='+cv(txtEtiqueta.getValue())+'&iC='+gE('idConfiguracion').value,true);
                                                                        
																	}
														}
													]
									}
								);
	ventanaAM.show();	
}

function regresar()
{
	var idFormulario=gE('idFormulario').value;
    var idProceso=gE('idProceso').value;
    var arrParam=[['idFormulario',idFormulario],['idProceso',idProceso]];
	enviarFormularioDatos('../modeloPerfiles/formularios.php',arrParam);
}


function mostrarVentanaAdmonFiltros()
{
	var gridFiltrosGlobales=crearGridFiltrosGlobales();
	var form = new Ext.form.FormPanel(	
    
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
														gridFiltrosGlobales

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'vFiltro',
										title: 'Administraci&oacute;n de Filtros Globales',
										width: 850,
										height:400,
										layout: 'fit',
										plain:true,
										modal:true,
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
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	
}

function crearGridFiltrosGlobales()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idFiltro'},
		                                                {name: 'etiqueta'},
		                                                {name:'campoAsociado'},
		                                                {name:'tamano'},
                                                        {name:'tipo'},
                                                        {name: 'funcionOrigenOpciones'},
                                                        {name: 'lblFuncionOrigen'},
                                                        {name: 'funcionValorDefault'},
                                                        {name: 'lblFuncionDefault'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                reader: lector,
                                                proxy : new Ext.data.HttpProxy	(

                                                                                  {

                                                                                      url: '../paginasFunciones/funcionesFormulario.php'

                                                                                  }

                                                                              ),
                                                sortInfo: {field: 'idFiltro', direction: 'ASC'},
                                                groupField: 'etiqueta',
                                                remoteGroup:false,
                                                remoteSort: false,
                                                autoLoad:true
                                                
                                            }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='209';
                                        proxy.baseParams.iConf='<?php echo $idConfiguracion?>';
                                        
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            {
                                                                header:'Etiqueta',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'etiqueta'
                                                                
                                                            },
                                                            {
                                                                header:'Campo asociado',
                                                                width:220,
                                                                sortable:true,
                                                                css:'text-align:right;',
                                                                dataIndex:'campoAsociado',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrControles,val));
                                                                        }
                                                            },
                                                            {
                                                                header:'Tama&ntilde;o',
                                                                width:100,
                                                                sortable:true,
                                                                dataIndex:'tamano'
                                                            },
                                                            {
                                                                header:'Tipo campo',
                                                                width:220,
                                                                 css:'text-align:right;',
                                                                sortable:true,
                                                                dataIndex:'tipo',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrTiposElementos,val));
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gFiltros',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                border:true,
                                                                cm: cModelo,
                                                                stripeRows :false,
                                                                cls:'gridSiugjPrincipal',
                                                                loadMask:true,
                                                                columnLines : false,
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Agregar filtro',
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaConfiguracionFiltro();
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                            	xtype:'tbspacer',
                                                                                width:10
                                                                            },
                                                                            {
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Modificar filtro',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=tblGrid.getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el filtro que desea modificar');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                             mostrarVentanaConfiguracionFiltro(fila);
                                                                                        }
                                                                                
                                                                            },
                                                                            
                                                                            {
                                                                            	xtype:'tbspacer',
                                                                                width:10
                                                                            },
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover filtro',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=tblGrid.getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el filtro que desea remover');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            
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
                                                                                                        	gEx('vFiltro').close();
                                                                                                            recargarPagina();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=210&idFiltro='+fila.data.idFiltro,true);
                                                                                                    
                                                                                                    
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('&iquest;Est&aacute; seguro de querer remover el filtro seleccionado?',resp);
                                                                                            
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

function mostrarVentanaConfiguracionFiltro(fila)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:15,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Etiqueta del filtro:'
                                                        },
                                                        {
                                                        	x:190,
                                                            y:10,
                                                            cls:'controlSIUGJ',
                                                            xtype:'textfield',
                                                            id:'txtEtiqueta',
                                                            width:300
                                                        },
                                                        {
                                                        	x:10,
                                                            y:65,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Campo asociado:'
                                                        },
                                                        {
                                                        	x:190,
                                                            y:60,
                                                            html:'<div id="comboCampoAsociado"></div>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:120,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Tipo de filtro:'
                                                        },
                                                        {
                                                        	x:190,
                                                            y:115,
                                                            html:'<div id="comboCampoTipoFiltro"></div>'
                                                        },
                                                        {
                                                        	x:530,
                                                            y:120,
                                                            id:'lblTamano',
                                                            cls:'SIUGJ_Etiqueta',
                                                            hidden:true,
                                                            html:'Tama&ntilde;o del control:'
                                                        },
                                                        {
                                                        	x:725,
                                                            y:115,
                                                            cls:'controlSIUGJ',
                                                            xtype:'numberfield',
                                                            id:'txtTamano',
                                                            hidden:true,
                                                            allowDecimals:false,
                                                            allowNegative:false,
                                                            width:60,
                                                            value:200
                                                        },
                                                        {
                                                        	x:10,
                                                            y:170,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Funci&oacute;n origen opciones:'
                                                        },
                                                        {
                                                        	x:250,
                                                            y:165,
                                                            width:440,
                                                            cls:'controlSIUGJ',
                                                            xtype:'textfield',
                                                            id:'txtOrigenOpciones',
                                                            readOnly:true
                                                        },
                                                        {
                                                        	x:700,
                                                            y:167,
                                                            html:'<a href="javascript:definirFuncionOrigenValores()"><img src="../images/pencil.png" title="Agregar funci&oacute;n" alt="Agregar funci&oacute;n"></a>&nbsp;&nbsp;<a href="javascript:removerFuncion(1)"><img src="../images/delete.png" title="Remover funci&oacute;n" alt="Remover funci&oacute;n"></a>'
                                                        },
                                                        
                                                        {
                                                        	x:10,
                                                            y:220,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Funci&oacute;n valor default:'
                                                        },
                                                        {
                                                        	x:250,
                                                            y:215,
                                                            width:440,
                                                            cls:'controlSIUGJ',
                                                             xtype:'textfield',
                                                            id:'txtValorDefault',
                                                            readOnly:true
                                                        },
                                                        {
                                                        	x:700,
                                                            y:217,
                                                            html:'<a href="javascript:definirValorDefault()"><img src="../images/pencil.png" title="Agregar funci&oacute;n" alt="Agregar funci&oacute;n"></a>&nbsp;&nbsp;<a href="javascript:removerFuncion(2)"><img src="../images/delete.png" title="Remover funci&oacute;n" alt="Remover funci&oacute;n"></a>'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: fila?'Modificar filtro':'Agregar filtro',
										width: 820,
										height:360,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	gEx('txtEtiqueta').focus(false,500);
                                                                    
                                                                    var cmbCampoAsocido=crearComboExt('cmbCampoAsocido',arrControles,0,0,595,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'comboCampoAsociado'});
    
                                                                    cmbCampoAsocido.on('select',function(cmb,registro)
                                                                                                {
                                                                                                    gEx('lblTamano').hide();
                                                                                                    gEx('txtTamano').hide();
                                                                                                    var arrValores=[];
                                                                                                    
                                                                                                    var pos=existeValorMatriz(arrControles,registro.data.id);
                                                                                                    var f=arrControles[pos];
                                                                                                    
                                                                                                    var aTipo=obtenerValoresTipoFiltro(f[3]);
                                                                                                    cmbTipoFiltro.setValue('');
                                                                                                    cmbTipoFiltro.getStore().loadData(aTipo);
                                                                                                    if(aTipo.length=='1')
                                                                                                    {
                                                                                                        cmbTipoFiltro.setValue(aTipo[0][0]);
                                                                                                    }
                                                                                                }
                                                                                        )
                                                                    
                                                                    
                                                                    var cmbTipoFiltro=crearComboExt('cmbTipoFiltro',[],0,0,325,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'comboCampoTipoFiltro'});
                                                                    cmbTipoFiltro.on('select',function(cmb,registro)
                                                                                                {
                                                                                                    if((registro.data.id=='1')||(registro.data.id=='6'))
                                                                                                    {
                                                                                                        gEx('lblTamano').hide();
                                                                                                        gEx('txtTamano').hide();
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        gEx('lblTamano').show();
                                                                                                        gEx('txtTamano').show();
                                                                                                    }
                                                                                                }
                                                                                    )
																
                                                                
                                                                	if(fila)
                                                                    {
                                                                        var txtEtiqueta=gEx('txtEtiqueta');
                                                                        txtEtiqueta.setValue(fila.data.etiqueta);
                                                                        var txtTamano=gEx('txtTamano');
                                                                        txtTamano.setValue(fila.data.tamano);
                                                                        var txtOrigenOpciones=gEx('txtOrigenOpciones');
                                                                        txtOrigenOpciones.setValue(fila.data.lblFuncionOrigen);
                                                                        txtOrigenOpciones.idConsulta=fila.data.funcionOrigenOpciones;
                                                                        
                                                                        var txtValorDefault=gEx('txtValorDefault');
                                                                        txtValorDefault.setValue(fila.data.lblFuncionDefault);
                                                                        txtValorDefault.idConsulta=fila.data.funcionValorDefault;
                                                                        
                                                                        cmbCampoAsocido.setValue(fila.data.campoAsociado);
                                                                        dispararEventoSelectCombo('cmbCampoAsocido');
                                                                        
                                                                        
                                                                        cmbTipoFiltro.setValue(fila.data.tipo);
                                                                        dispararEventoSelectCombo('cmbTipoFiltro');
                                                                    }
                                                                
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
                                                                    	var txtEtiqueta=gEx('txtEtiqueta');
                                                                        var txtTamano=gEx('txtTamano');
                                                                        var txtOrigenOpciones=gEx('txtOrigenOpciones');
                                                                        var txtValorDefault=gEx('txtValorDefault');
                                                                        var cmbCampoAsocido=gEx('cmbCampoAsocido');
                                                                        var cmbTipoFiltro=gEx('cmbTipoFiltro');
                                                                        if(txtEtiqueta.getValue()=='')
                                                                        {
                                                                        	
                                                                            function resp()
                                                                            {
                                                                            	txtEtiqueta.focus();
                                                                            }
                                                                            msgBox('Debe especificar la etiqueta del filtro',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(cmbCampoAsocido.getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	cmbCampoAsocido.focus();
                                                                            }
                                                                            msgBox('Debe especificar el campo con el cual ser&aacute; asociado el filtro',resp3);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(cmbTipoFiltro.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbTipoFiltro.focus();
                                                                            }
                                                                            msgBox('Debe especificar el tipo de filtro a aplicar',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(cmbTipoFiltro.getValue()!='1')
                                                                        {
                                                                        	 if(txtTamano.getValue()=='')
                                                                            {
                                                                                function resp4()
                                                                                {
                                                                                    txtTamano.focus();
                                                                                }
                                                                                msgBox('Debe especificar el tama&ntilde;o del control de filtro',resp4);
                                                                                return;
                                                                            }
                                                                        
                                                                        }
                                                                        
                                                                        var idFuncionOrigenOpciones=-1;
                                                                        if(txtOrigenOpciones.idConsulta)
                                                                        	idFuncionOrigenOpciones=txtOrigenOpciones.idConsulta;
                                                                        
                                                                        var idFuncionOrigenDefault=-1;
                                                                        if(txtValorDefault.idConsulta)
                                                                        	idFuncionOrigenDefault=txtValorDefault.idConsulta;
                                                                        var idFiltro=-1;
                                                                        if(fila)
                                                                        	idFiltro=fila.data.idFiltro;
                                                                            
																		var cadObj='{"idConfiguracionGrid":"<?php echo $idConfiguracion?>","idFiltro":"'+idFiltro+'","etiqueta":"'+cv(gEx('txtEtiqueta').getValue())+'","campo":"'+cmbCampoAsocido.getValue()+'","tipoFiltro":"'+cmbTipoFiltro.getValue()+
                                                                        			'","tamano":"'+txtTamano.getValue()+'","idFuncionOrigenOpciones":"'+idFuncionOrigenOpciones+'","idFuncionOrigenDefault":"'+idFuncionOrigenDefault+'"}';
                                                                        
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                ventanaAM.close();
                                                                                recargarPagina();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=208&cadObj='+cadObj,true);
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        
																	}
														}
														
													]
									}
								);
	ventanaAM.show();
    
    
    	
}

function definirFuncionOrigenValores()
{
	asignarFuncionNuevoConceptoInyeccion=function(idConsulta,nombre)
                                            {
                                            	gEx('txtOrigenOpciones').setValue(nombre);
                                                gEx('txtOrigenOpciones').idConsulta=idConsulta;
                                               
                                                 gEx('vAgregarExp').close();
                                                 
                                                 var idAux=gEx('cmbTipoFiltro').getValue();
        
                                                 
                                                 dispararEventoSelectCombo('cmbCampoAsocido');
                                                 var pos=obtenerPosFila(gEx('cmbTipoFiltro').getStore(),'id',idAux);
                                                 if(pos!=-1)
	                                                 gEx('cmbTipoFiltro').setValue(idAux);
                                                
                                            }
	mostrarVentanaExpresion(function(fila,ventana)
    						{
                            	gEx('txtOrigenOpciones').setValue(fila.data.nombreConsulta);
                                gEx('txtOrigenOpciones').idConsulta=fila.data.idConsulta;
                            	ventana.close();
                                var idAux=gEx('cmbTipoFiltro').getValue();
        
                                                 
                               dispararEventoSelectCombo('cmbCampoAsocido');
                               var pos=obtenerPosFila(gEx('cmbTipoFiltro').getStore(),'id',idAux);
                               if(pos!=-1)
                                   gEx('cmbTipoFiltro').setValue(idAux);
                                

                            }
    						,
    						true);
}

function definirValorDefault()
{
	asignarFuncionNuevoConceptoInyeccion=function(idConsulta,nombre)
                                            {
                                            	gEx('txtValorDefault').setValue(nombre);
                                                gEx('txtValorDefault').idConsulta=idConsulta;
                                               
                                                gEx('vAgregarExp').close();
                                                
                                            }
	mostrarVentanaExpresion(function(fila,ventana)
    						{
                            	gEx('txtValorDefault').setValue(fila.data.nombreConsulta);
                                gEx('txtValorDefault').idConsulta=fila.data.idConsulta;
                            	ventana.close();

                            }
    						,
    						true);
}

function removerFuncion(t)
{
	if(t=='1')
    {
    	gEx('txtOrigenOpciones').setValue('');
       	gEx('txtOrigenOpciones').idConsulta=-1;
        var idAux=gEx('cmbTipoFiltro').getValue();
        dispararEventoSelectCombo('cmbCampoAsocido');
        gEx('cmbTipoFiltro').setValue(idAux);
    }
    else
    {
    	gEx('txtValorDefault').setValue('');
        gEx('txtValorDefault').idConsulta=-1;
    }
}

function obtenerValoresTipoFiltro(tValor)
{
	var arrTipos=[];
    
    if((!gEx('txtOrigenOpciones').idConsulta)||(gEx('txtOrigenOpciones').idConsulta=='-1'))
    {
        switch(tValor)//1 numerico,2 fecha,3 texto, 4 lista  
        {
            case '1':
            	arrTipos.push(['1','Rango de valores']);
            break;
            case '2':
                arrTipos.push(['6','Rango de valores']);
                
            break;
            case '3':
                arrTipos.push(['5','Escritura de valor']);  
            break;
            case '4':
                arrTipos.push(['5','Escritura de valor']);  
                arrTipos.push(['3','Lista de valores selecci\xF3n \xFAnica']);  
                arrTipos.push(['4','Lista de valores selecci\xF3n m\xFAltiple']);  
            break;
        }
  	}
    else
    {
    	 arrTipos.push(['3','Lista de valores selecci\xF3n \xFAnica']);  
         arrTipos.push(['4','Lista de valores selecci\xF3n m\xFAltiple']);  
    }      
    return arrTipos;
}