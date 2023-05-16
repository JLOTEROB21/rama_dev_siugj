<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	 
	$idConfiguracion=bD($_GET["iT"]);
	
	$consulta="SELECT tiempoActualizacion,registrosPagina,visibleBarraNotificaciones,horasAlertaPreventiva,permiteDelegarTareas 
			FROM  9060_tablerosControl WHERE idTableroControl=".$idConfiguracion;
	$fConfiguracion=$con->obtenerPrimeraFila($consulta);
	$permiteDelegarTareas=$fConfiguracion[4];
	
	$consulta="	select cg.etiquetaCampo,tamanoColumna as 'tamColumna' 
				from 9061_camposTableroControl cg where idTableroControl=".$idConfiguracion." order by cg.orden";
	
	$res=$con->obtenerFilas($consulta);
	$campos="{name: 'idRegistro' }";
	//$columnModel='new  Ext.grid.RowNumberer({width:40})';
	
	$columnModel="new  Ext.grid.RowNumberer({width:60}),
												{
													header:'ID Tarea',
													width:90,
													sortable:true,
													dataIndex:'idRegistro',
													align:'center',
													resizable:true
												},
												{
													header:'',
													width:50,
													sortable:true,
													dataIndex:'idNotificacionBase',
													align:'center',	
													hidden:".( $permiteDelegarTareas==0?"true":"false").",
													resizable:false
												},
												{
													header:'',
													width:30,
													sortable:true,
													dataIndex:'nTurnados',
													align:'center',	
													hidden:".( $permiteDelegarTareas==0?"true":"false").",
													resizable:false
												},
												{
													header:'',
													width:40,
													sortable:true,
													dataIndex:'statusNotificacion',
													align:'center',						
													resizable:false
												},
												{
													header:'',
													width:40,
													sortable:true,
													dataIndex:'permiteAbrirProceso',
													align:'center',						
													resizable:false
												}
												";
	
	
	
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
	
	
	
	
	
	$arrFiltros="";
	$consulta="SELECT * FROM 9065_filtrosGlobalesTableroControl WHERE idTableroControl=".$idConfiguracion;
	$rConfiguracion=$con->obtenerFilas($consulta);
	while($fConfiguracion=$con->fetchRow($rConfiguracion))
	{
		$control="";
		switch($fConfiguracion[3])
		{
			case 1://  Rango de valores numericos
				
				$control='crearComboExt("op1_'.$fConfiguracion[2].'",arrCondicionales,0,0,40,{valor:"="}),new Ext.form.NumberField({id:"filtro1_'.
							$fConfiguracion[2].'",width:"40",allowDecimals:true,allowNegative:true, enableKeyEvents:true,cls:"controlSIUGJ"}),'.
						'{width:10,xtype:"tbspacer"},{ hidden:true, id:"btnClean_'.$fConfiguracion[2].'_1",width:40,height:30,ctCls:"botonEliminarFiltro",icon:"../principalPortal/imagesSIUGJ/deleteFilter.png",border:true,cls:"x-btn-icon"},{"xtype":"label",html:"&nbsp;&nbsp;<span style=\"color:#000\"><b>y</b></span>&nbsp;&nbsp;"},crearComboExt("op2_'.$fConfiguracion[2].'",arrCondicionales,0,0,40,{valor:"="}),new Ext.form.NumberField({id:"filtro2_'.
							$fConfiguracion[2].'",width:"40",allowDecimals:true,allowNegative:true,value:"", enableKeyEvents:true,cls:"controlSIUGJ"}),{width:10,xtype:"tbspacer"},{hidden:true, id:"btnClean_'.$fConfiguracion[2].'_2",width:40,height:30,ctCls:"botonEliminarFiltro",icon:"../principalPortal/imagesSIUGJ/deleteFilter.png",border:true,cls:"x-btn-icon"}';
				
				
			
			break;	
			case 3:// Lista de valores selección única (Textos)
			case 4:// Lista de valores selección multiple (Textos)	
				$control='crearComboExt("filtro1_'.$fConfiguracion[2].'",[],0,0,'.$fConfiguracion[4].',{listClass:"listComboSIUGJ", cls:"comboSIUGJ",fieldClass:"comboSIUGJ",ctCls:"comboWrapSIUGJ", height:30}),{width:10,xtype:"tbspacer"},{hidden:true, id:"btnClean_'.$fConfiguracion[2].'_1",width:40,height:30,ctCls:"botonEliminarFiltro",icon:"../principalPortal/imagesSIUGJ/deleteFilter.png",border:true,cls:"x-btn-icon"}';
				
			break;
			case 5: //Escritura de valor (Textos)
				$control='crearComboExt("op1_'.$fConfiguracion[2].'",arrCondicionalesTexto,0,0,80,{valor:arrCondicionalesTexto[0][0]}),new Ext.form.TextField({"id":"filtro1_'.$fConfiguracion[2].'",width:"'.$fConfiguracion[4].'",'.
						' enableKeyEvents:true,cls:"controlSIUGJ"}),{width:10,xtype:"tbspacer"},{id:"btnClean_'.$fConfiguracion[2].'_1",hidden:true, width:40,height:30,ctCls:"botonEliminarFiltro",icon:"../principalPortal/imagesSIUGJ/deleteFilter.png",border:true,cls:"x-btn-icon"}';
				
				
			break;	
			case 6://Rango de valores fechas
				
				$control='crearComboExt("op1_'.$fConfiguracion[2].'",arrCondicionales,0,0,40,{valor:"="}),new Ext.form.DateField({"id":"filtro1_'.$fConfiguracion[2].'"})'.
						',{width:10,xtype:"tbspacer"},{hidden:true,  id:"btnClean_'.$fConfiguracion[2].'_1",width:40,height:30,ctCls:"botonEliminarFiltro",icon:"../principalPortal/imagesSIUGJ/deleteFilter.png",border:true,cls:"x-btn-icon"},{"xtype":"label",html:"&nbsp;&nbsp;<span style=\"color:#000\"><b>y</b></span>&nbsp;&nbsp;"},crearComboExt("op2_'.$fConfiguracion[2].'",arrCondicionales,0,0,40,{valor:"="}),new Ext.form.DateField({"id":"filtro2_'.
						$fConfiguracion[2].'"}),{width:10,xtype:"tbspacer"},{hidden:true, id:"btnClean_'.$fConfiguracion[2].'_2",width:40,height:30,ctCls:"botonEliminarFiltro",icon:"../principalPortal/imagesSIUGJ/deleteFilter.png",border:true,cls:"x-btn-icon"}';
				
			break;
			case 7://Rango de valores hora
				
			
				$control='crearComboExt("op1_'.$fConfiguracion[2].'",arrCondicionales,0,0,40,{valor:"="}),crearComboExt("filtro1_'.$fConfiguracion[2].'",[],0,0,120,{valor:""}),'.
						',{width:10,xtype:"tbspacer"},{hidden:true, id:"btnClean_'.$fConfiguracion[2].'_1",width:40,height:30,ctCls:"botonEliminarFiltro",icon:"../principalPortal/imagesSIUGJ/deleteFilter.png",border:true,cls:"x-btn-icon"},{"xtype":"label",html:"&nbsp;&nbsp;<span style=\"color:#000\"><b>y</b></span>&nbsp;&nbsp;"},
						crearComboExt("op2_'.$fConfiguracion[2].'",arrCondicionales,0,0,40,{valor:"="}),crearComboExt("filtro2_'.$fConfiguracion[2].'",[],0,0,120,{valor:""}),{width:10,xtype:"tbspacer"},{hidden:true, id:"btnClean_'.$fConfiguracion[2].'_2",width:40,height:30,ctCls:"botonEliminarFiltro",icon:"../principalPortal/imagesSIUGJ/deleteFilter.png",border:true,cls:"x-btn-icon"}';
				
			
			break;
			case 8://Rango de valores fecha hora
				$control='crearComboExt("op1_'.$fConfiguracion[2].'",arrCondicionales,0,0,40,{valor:"="}),new Ext.form.DateField({"id":"filtro1_'.$fConfiguracion[2].'",value:""})'.
						',crearComboExt("filtro1Aux_'.$fConfiguracion[2].'",[],0,0,120,{valor:""}),{width:10,xtype:"tbspacer"},{hidden:true, id:"btnClean_'.$fConfiguracion[2].'_1",width:40,height:30,ctCls:"botonEliminarFiltro",icon:"../principalPortal/imagesSIUGJ/deleteFilter.png",border:true,cls:"x-btn-icon"},{"xtype":"label",html:"&nbsp;&nbsp;<span style=\"color:#000\"><b>y</b></span>&nbsp;&nbsp;"},crearComboExt("op2_'.$fConfiguracion[2].'",arrCondicionales,0,0,40,{valor:"="}),new Ext.form.DateField({"id":"filtro2_'.
						$fConfiguracion[2].'",value:""}),crearComboExt("filtro2Aux_'.$fConfiguracion[2].'",[],0,0,120,{valor:""}),
						{width:10,xtype:"tbspacer"},{hidden:true, id:"btnClean_'.$fConfiguracion[2].'_2", 0 width:40,height:30,ctCls:"botonEliminarFiltro",icon:"../principalPortal/imagesSIUGJ/deleteFilter.png",border:true,cls:"x-btn-icon"}';
								
				
			break;
			
		}
		$filtro='{"xtype":"label", "html":"<div class=\'letraNombreTablero\'>'.$fConfiguracion[1].':</div>"},{xtype:"tbspacer", width:30},'.$control;//,"-"'
		
		
		if($arrFiltros=="")
			$arrFiltros=$filtro;
		else
			$arrFiltros.=",".$filtro;
	}
	
	
	$consulta="SELECT idFuncion,nombreFuncion FROM 9033_funcionesScriptsSistema WHERE idCategoria=1";
	$arrFunciones=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT valor,texto FROM 1004_siNo";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT tipoDatoServidor,nombreTipoDato FROM 9063_tiposValoresDato";
	$arrTipoCampo=$con->obtenerFilasArreglo($consulta);
	
	$nombreTabla="9060_tableroControl_".$idConfiguracion;
	$consulta="SELECT COLUMN_NAME,COLUMN_NAME ,DATA_TYPE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='".$con->bdActual."' AND TABLE_NAME='".$nombreTabla."' order by COLUMN_NAME";
						
	$arrCamposTableroControl=$con->obtenerFilasArreglo($consulta);						
						
	
?>

var arrTiposFiltro=[['1','Rango de valores'],['3','Lista de valores selecci\xF3n \xFAnica'],['4','Lista de valores selecci\xF3n m\xFAltiple'],['5','Escritura de valor'],['6','Rango de valores'],['7','Rango de valores'],['8','Rango de valores']];
var arrCamposTableroControl=<?php echo $arrCamposTableroControl?>;
var arrDireccion=[['ASC','Ascendente'],['DESC','Descendente']];
var arrAlineacion=[['1','Izquierda'],['2','Derecha'],['3','Centrado'],['4','Justificado']];
var capturado=false;
var arrTipoCampo=<?php echo $arrTipoCampo?>;
var arrSiNo=<?php echo $arrSiNo?>;
var idConfiguracion=<?php echo $idConfiguracion?>;
var camposJava=new Array( <?php echo $campos; ?>);

var columnasJava=new Array(<?php echo $columnModel; ?>);

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


var ventanaAM =null;
var ventanaAC=null;
var ventanaEtiquetas=null;
var idElemento='-1';


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

function inicializar()
{
	arrFuncionesRenderer.splice(0,0,['0','Ninguno']);
	crearGridRoles();
    if(gE('idTableroControl').value!='-1')
	    crearTablaRegistros();
}

function crearGridRoles()
{
	var dsDatos=eval(bD(gE('arrRoles').value));
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idRol'},
                                                                    {name: 'etiqueraRol'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	
														{
															header:'Rol',
															width:350,
															sortable:true,
															dataIndex:'etiqueraRol'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gRoles',
                                                            store:alDatos,
                                                            frame:false,
                                                            cm: cModelo,
                                                            border:true,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :false,
                                                            columnLines : false,
                                                            height:300,
                                                            width:450,
                                                            cls:'gridSiugjPrincipal',
                                                            renderTo:'tblRoles',
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar Rol',
                                                                            handler:function()
                                                                            		{
                                                                                    	agregarRol()
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	xtype:'tbspacer',
                                                                            width:10
                                                                        },
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover Rol',
                                                                            handler:function()
                                                                            		{
                                                                                    	
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el rol que desea remover');
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        tblGrid.getStore().remove(fila);
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;	
}

function agregarRol()
{
	<?php
		$consulta="select concat(idRol,'_',extensionRol),nombreGrupo from 8001_roles where idIdioma=".$_SESSION["leng"]." and situacion=1 order by nombreGrupo";
		$arrRoles=uEJ($con->obtenerFilasArreglo($consulta));
	?>
   var arrRoles=<?php echo $arrRoles?>;
	
	var form=new Ext.form.FormPanel(
										{
											baseCls: 'x-plain',
											layout:'absolute',
											disabled:false,
											items:
													[
													 	{
                                                        	id:'lblRol',
                                                            x:10,
                                                            y:15,
                                                            cls:'SIUGJ_Etiqueta',
                                                            xtype:'label',
                                                            html:'Rol:'
                                                        },
                                                        {
                                                        	x:140,
                                                            y:10,
                                                            xtype:'label',
                                                            html:'<div id="divComboRol"></div>'
                                                        },
                                                        {
                                                        	id:'lblExtension',
                                                        	x:10,
                                                            y:65,
                                                            cls:'SIUGJ_Etiqueta',
                                                            xtype:'label',
                                                            html:'Extensi&oacute;n:',
                                                            hidden:true
                                                        },
                                                        {
                                                        	x:140,
                                                            y:60,
                                                            id:'lblDivComboExtension',
                                                            xtype:'label',
                                                            html:'<div id="divComboExtensionRol" style="width:350px"></div>'
                                                        }
													]
										}
									)
	var ventana=new Ext.Window(
							   		{
										title:'Agregar rol',
										width:550,
										height:180,
										layout:'fit',
                                        cls:'msgHistorialSIUGJ',
										buttonAlign:'center',
										items:[form],
										modal:true,
										plain:true,
										listeners:
											{
												show:
												{
													buffer:10,fn:function()
															{
                                                            	var cmbRoles=crearComboExt('cmbRoles',arrRoles,0,0,350,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboRol'});
                                                                function rolSeleccionado(combo,registro,indice)
                                                                {
                                                                    cmbExtensiones.reset();
                                                                    var idRegistro=registro.get('id');
                                                                    var arrId=idRegistro.split('_');
                                                                    if(arrId[1]!=0)
                                                                    {
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                var arrExtensiones=eval(arrResp[1]);
                                                                                cmbExtensiones.getStore().loadData(arrExtensiones);                
                                                                                cmbExtensiones.show();
                                                                                Ext.getCmp('lblExtension').show();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=20&extension='+arrId[1],true);
                                                                    }
                                                                    else
                                                                    {
                                                                        cmbExtensiones.hide();
                                                                        Ext.getCmp('lblExtension').hide();
                                                                    }
                                                                }
                                                                cmbRoles.on('select',rolSeleccionado);
																
                                                                var cmbExtensiones=crearComboExt('cmbExtensiones',[],0,0,340,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboExtensionRol'});
                                                                cmbExtensiones.hide();
                                                            	gEx('lblDivComboExtension').hide();
                                                            }
												}
											},
										buttons:
												[
                                                	{
														text:'Cancelar',
                                                       	cls:'btnSIUGJCancel',
                                                        width:140,
														handler:function ()
															{
																ventana.close();
															}
													},
												 	{
														text:'Aceptar',
                                                        cls:'btnSIUGJ',
                                                        width:140,
														handler:function ()
															{
                                                            	var cmbRoles=gEx('cmbRoles');
                                                                var cmbExtensiones=gEx('cmbExtensiones');
                                                            	var rol=cmbRoles.getValue();
                                                                var arrId=rol.split('_');
                                                                var extension='0';
                                                                if(arrId[1]!=0)
                                                                	extension=cmbExtensiones.getValue();	
                                                                if(extension=='')
                                                                {
                                                                	function resp()
                                                                    {
                                                                    	cmbExtensiones.focus();
                                                                    }
                                                                	msgBox('Debe seleccionar una extensi&oacute;n del rol',resp);
                                                                    return;
                                                                }
                                                               
                                                                var codigoRol=arrId[0]+'_'+extension;
                                                                var pos=obtenerPosFila(gEx('gRoles').getStore(),'idRol',codigoRol);
                                                                if(pos==-1)
                                                                {
                                                                
                                                                	var reg=crearRegistro(	[
                                                                    							{name: 'idRol'},
							                                                                    {name: 'etiqueraRol'}
                                                                                             ]
                                                                                          );
                                                                    
                                                                    
                                                                    var txtExtension=cmbRoles.getRawValue();
                                                                    if(extension!='0')
                                                                    {
                                                                    	txtExtension=' ('+cmbExtensiones.getRawValue()+')';
                                                                    }
                                                                    var r=new reg	(
                                                                    					{
                                                                                            idRol:codigoRol,
                                                                                            etiqueraRol:txtExtension
                                                                                        }
                                                                    				)                            
                                                                	gEx('gRoles').getStore().add(r);
                                                                
                                                                	
                                                                }
                                                               
                                                                ventana.close();
															}
													}
													
												 ]
									}
							   )
	ventana.show();
}

function prepararAntesGuardar()
{
	if(validarFormularios('frmEnvio'))
    {
    	
    	var objArr='';
        
        var x=0;
        var gRoles=gEx('gRoles');
        var fila;
        var o;
        for(x=0;x<gRoles.getStore().getCount();x++)
        {
        	fila=gRoles.getStore().getAt(x);
            o='{"idRol":"'+fila.data.idRol+'"}';
            
            if(objArr=='')
            	objArr=o;
            else
            	objArr+=','+o;
            
            
        }
        objArr='['+objArr+']';
    	if(gE('idTableroControl').value=='-1')
        {
        	gE('funcPHPEjecutarNuevo').value=bE('asociarRolesTableroControl(@idRegPadre,\''+bE(objArr)+'\')');
        }
        else
        {
        	gE('funcPHPEjecutarModif').value=bE('asociarRolesTableroControl('+gE('idTableroControl').value+',\''+bE(objArr)+'\')');
        }
        gE('frmEnvio').submit();
        
    }
    	
        
         
}

function crearTablaRegistros()
{
	
	var datos=[['','','']];
	var dsTablaRegistros= new Ext.data.SimpleStore	(
                                                        {
                                                            fields:camposJava
                                                                    
                                                        }
                                                    );
	
    dsTablaRegistros.loadData(datos);
    
    
    var expander = new Ext.ux.grid.RowExpander({
                                                    column:3,
                                                    width:40,
                                                    expandOnEnter:false,
                                                    expandOnDblClick:false,
                                                    tpl : new Ext.Template(
                                                        '<table width="100%" >'+
                                                        '<tr><td  style="padding:10px">{contenidoMensaje}</td></tr>'+
                                                        '</table>'
                                                    )
                                                }); 	 


	expander.on('expand',function(exp,registro)
    						{
                            	if(registro.data.fechaVisualizacion=='')
                                {
                                	registrarVisualizacionNotificacion(registro.data.idRegistro);
                                }
                            }
    			)

	columnasJava.splice(1,0,expander);
    
    
	var chkRow=new Ext.grid.CheckboxSelectionModel({checkOnly :true, width:40}); 
    columnasJava.splice(2,0,chkRow); 
    var modelColumn= new Ext.grid.ColumnModel   	(
												 		columnasJava
													);



	
	var gridRegistros=	new Ext.grid.GridPanel	(
                                                  {
                                                  	  
                                                      store:dsTablaRegistros,
                                                      frame:false,
                                                      border:false,
                                                      cm: modelColumn,
                                                      region:'center',
                                                      stripeRows :false,
                                                      columnLines : false,
                                                      cls:'gridSiugjPrincipal',
                                                      trackMouseOver:false,
                                                      disableSelection:true,
                                                      loadMask: true,
                                                      sm:chkRow,
                                                      plugins:[expander],
                                                      bbar: new Ext.PagingToolbar	(
                                                                                      {
                                                                                            pageSize: 2,
                                                                                            store: dsTablaRegistros,
                                                                                            displayInfo: true,
                                                                                            displayMsg: '{0} - {1} of {2}',
                                                                                            emptyMsg: "No vacío",
                                                                                            disabled:true
                                                                                    	}
                                                                                     )

                                                  }
                                              );
                                              
                                              
															                                            
                                              

	
    
                                              
	new Ext.Panel	(
    					{
                        	 height:480,
                             width:'100%',
                             layout:'border',
                             border:true,
                             cls:'panelSiugjWrap panelSiugjBorder',
                             renderTo:'tblRegistros',
                             tbar:	[
                             			
                             			{
                                            icon:'../images/page_white_gear.png',
                                            cls:'x-btn-text-icon',
                                            text:'Configurar campos del tablero de control',
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
                                            text:'&nbsp;&nbsp;Admon. de Filtros Globales',
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
                                            text:'&nbsp;&nbsp;Admon. de &Iacute;ndices',
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
                                                                border:false,
                                                                cls:'panelSiugj',
                                                            	<?php
																	if($arrFiltros!="")
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
    				)                                              
                                              
	                                            
}

function configurarGrid()
{
	mostrarVentanaConfiguracion();
}

function mostrarVentanaConfiguracion()
{
	var tblGrid=crearGridConfiguracion();
    
    
    
    var form = new Ext.form.FormPanel(	
												{
													baseCls: 'x-plain',
													layout:'absolute',
													defaultType: 'label',
													items: 	[
																tblGrid,
                                                                
                                                               
                                                                {
                                                                	id:'lblRegPagina',
                                                                	x:10,
                                                                    y:260,
                                                                    cls:'SIUGJ_Etiqueta',
                                                                    html:'Registros por p&aacute;gina:'
                                                                },
                                                                {
                                                                	xtype:'numberfield',
                                                                    x:230,
                                                                    y:255,
                                                                    cls:'controlSIUGJ',
                                                                    id:'txtNumRegPag',
                                                                    allowDecimals:false,
                                                                    width:80
                                                                },
                                                                crearGridOrdenTablero()
															]
												}
											);
                                            
	Ext.getCmp('txtNumRegPag').on('change',cambiarNumRegPaginas);                                            
                                            
	ventanaAM = new Ext.Window(
									{
										title: 'Configuraci&oacute;n de tablero de control',
										width: 950,
										height:580,
										minWidth: 690,
										minHeight: 520,
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
                                        cls:'msgHistorialSIUGJ',
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
                                                        	id:'btnAceptarConf',
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
                                                                    
                                                                    	ventanaAM.close();
																	}
														}
													]
									}
								);
    
	cargarDatosConfiguracion(alNameDTD,ventanaAM);
}

function crearGridConfiguracion()
{
	dsNameDTD=[];
    
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
															header:'Campo',
															width:180,
															sortable:true,
															dataIndex:'etFormulario'
														},
														{
															header:'T&iacute;tulo de la columna',
															width:200,
															sortable:true,
															dataIndex:'titulo'
														},
                                                        
                                                         {
															header:'Alineaci&oacute;n de valores',
															width:210,
															sortable:true,
															dataIndex:'alineacion',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrAlineacion,val);
                                                                    }
														},
                                                         {
															header:'Orden',
															width:80,
															sortable:true,
															dataIndex:'orden'
														},
                                                         {
															header:'Funci&oacute;n renderer',
															width:220,
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
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            cm: cmGrid,
                                                            height:240,
                                                            width:920,
                                                            cls:'gridSiugjPrincipal',
                                                            tbar:	[
                                                            				{
                                                                            	text:'Agregar columna',
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
                                                                            	text:'Modificar columna',
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                handler:function()
                                                                                		{
                                                                                        	var sm=tblGrid.getSelectionModel();
                                                                                            var filaSel=sm.getSelected();
                                                                                            if(filaSel==null)
                                                                                            {
                                                                                                msgBox('Debe seleccionar la columna a modificar');
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
                                                                            	text:'Eliminar columna',
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                handler:function()
                                                                                		{
                                                                                        	var sm=tblGrid.getSelectionModel();
                                                                                            var filaSel=sm.getSelected();
                                                                                            if(filaSel==null)
                                                                                            {
                                                                                                msgBox('Debe seleccionar la columna a remover');
                                                                                                return;
                                                                                            }
                                                                                            var etFormulario=filaSel.get('etFormulario');
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
                                                                                                            tblGrid.getStore().remove(filaSel);
                                                                                                        	generarTabla();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=218&idConfiguracion='+idConfiguracion+'&etCampo='+etFormulario,true);   

                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer eliminar la columna seleccionada?',resp);
                                                                                        }	
                                                                            },
                                                                            {
                                                                              	xtype:'tbspacer',
                                                                                width:10
                                                                              },
                                                                            {
                                                                            	text:'Adm&oacute;n de campos',
                                                                                icon:'../images/database_table.png',
                                                                                cls:'x-btn-text-icon',
                                                                                handler:function()
                                                                                		{
                                                                                        	mostrarVentanaAdministracionCamposTablero();
                                                                                        }	
                                                                            }
                                                            		]
                                                            
                                                        }
                                                    );
											
	return 	tblGrid;									
}

function cargarDatosConfiguracion(almacen,ventanaAM)
{

	function funcResp()
    {
        arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
        {
        	var datos=eval(arrResp[1]);
            
            almacen.loadData(datos);
            almacen.sort('orden','ASC');
            gEx('txtNumRegPag').setValue(arrResp[2]);
            if(ventanaAM)
	            ventanaAM.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=214&idConfiguracion='+idConfiguracion,true);
}

function cambiarNumRegPaginas(campo,nValor,vValor)
{
	if((nValor=='')||(nValor=='0'))
    {
    	function resp()
        {
        	campo.focus();
        }
    	msgBox('El valor ingresado NO es v&aacute;lido',resp);
    	return;
    }
	function funcResp()
    {
        arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
        {
       		
        }
        else
        {
        	
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0],funcResp);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=222&idConfiguracion='+idConfiguracion+'&numReg='+nValor,true);
}

function crearComboCampos()
{
	var dsDatos=Ext.getCmp('gridConfiguracion').getStore();
	var comboDatos=document.createElement('select');
	var cmbDatos=new Ext.form.ComboBox	(
													{
														x:150,
														y:380,
														id:'idCmbCampos',
														mode:'local',
														store:dsDatos,
														displayField:'titulo',
														valueField:'etFormulario',
														transform:comboDatos,
														editable:false,
														typeAhead: true,
														triggerAction: 'all',
														lazyRender:true,
														minListWidth:200
													}
												)
	return cmbDatos;	
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
                                                                    html:'Elija el campo a agregar:'
                                                                },
                                                                tblGrid
															]
												}
											);
	ventanaAC = new Ext.Window(
									{
										title: 'Agregar columna',
										width: 690,
										height:360,
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
															text: 'Siguiente >>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
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
                                                                                    	msgBox('Debe elegir el campo a agregar')
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
													 	new  Ext.grid.RowNumberer({width:40}),
														{
															header:'Campo',
															width:250,
															sortable:true,
															dataIndex:'campo'
														},
                                                        {
															header:'Tipo de campo',
															width:300,
															sortable:true,
															dataIndex:'tipoCampo',
                                                            renderer:mostrarValorDescripcion
                                                            		
                                                            
														},
                                                        {
															header:'Funci&oacute;n renderer',
															width:200,
                                                            hidden:true,
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
                                                            y:45,
                                                            stripeRows :false,
                                                            frame:false,
                                                            border:true,
                                                            cls:'gridSiugjPrincipal',
                                                            columnLines : false,
                                                            cm: cmGrid,
                                                            height:200,
                                                            width:650
                                                        }
                                                    );
											
	return 	tblGrid;									
}

function cargarDatosAgregarC(almacen,ventanaAC)
{
	
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
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=215&idConfiguracion='+idConfiguracion,true);
}

function mostrarVentanaConfiguracionCampo(filaSel,accion)
{

	
	lblBtnAceptar='Finalizar';
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
                                                                	x:10,
                                                                    y:170,
                                                                    cls:'SIUGJ_Etiqueta',
                                                                    xtype:'label',
                                                                    html:'Orden:'
                                                                },
                                                                {
                                                                	x:120,
                                                                    y:165,
                                                                    xtype:'label',
                                                                    html:'<div id="divCmbOrden"></div>'
                                                                },
                                                                
                                                                {
                                                                	id:'lblAncho',
                                                                	x:360,
                                                                    y:170,
                                                                    cls:'SIUGJ_Etiqueta',
                                                                	xtype:'label',
                                                                    html:'Ancho de la columna:<font style="color: #F00 	!important;">*</font>'
                                                                },
                                                                {
                                                                	id:'txtAncho',
                                                                	x:560,
                                                                    y:165,
                                                                    cls:'controlSIUGJ',
                                                                    xtype:'numberfield',
                                                                    allowdecimals:false,
                                                                    value:'150',
                                                                    width:80
                                                                },
                                                                {
                                                                	x:10,
                                                                    y:220,
                                                                	xtype:'label',
                                                                    cls:'SIUGJ_Etiqueta',
                                                                    html:'Alineaci&oacute;n de valores:<font color="red">*</font>'
                                                                },
                                                                {
                                                                	x:230,
                                                                    y:215,
                                                                    xtype:'label',
                                                                    html:'<div id="divCmbAlineacionValores"></div>'
                                                                },
                                                                
                                                                 {
                                                                	x:10,
                                                                    y:270,
                                                                    xtype:'label',
                                                                    cls:'SIUGJ_Etiqueta',
                                                                    html:'Funcion renderer:'
                                                                },
                                                                {
                                                                	x:230,
                                                                    y:265,
                                                                    xtype:'label',
                                                                    html:'<div id="divCmbFuncionRenderer"></div>'
                                                                },
                                                                
                                                                {
                                                                	x:10,
                                                                    y:320,
                                                                    cls:'SIUGJ_Etiqueta',
                                                                    xtype:'label',
                                                                    html:'Visible:'
                                                                },
                                                                {
                                                                	x:120,
                                                                    y:315,
                                                                    xtype:'label',
                                                                    html:'<div id="divCmbVisible"></div>'
                                                                }
															]
												}
											);
		
		ventanaEtiquetas = new Ext.Window(
											{
												title: 'Configuraci&oacute;n de la columna',
												width: 750,
												height:480,
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
                                                                            
                                                                             var cmbOrden=crearComboExt('cmbOrden',arrOrden,0,0,180,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCmbOrden'});
                                                                             var comboAlineacion=crearComboExt('idCmbAlineacion',arrAlineacion,0,0,180,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCmbAlineacionValores'});
        																	 var cmbRenderer=crearComboExt('cmbRenderer',arrFuncionesRenderer,0,0,450,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCmbFuncionRenderer'});
																			 var cmbVisible=crearComboExt('cmbVisible',arrSiNo,0,0,140,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCmbVisible'});
    																		 cmbVisible.setValue('1');
                                                                             
                                                                             if(accion==0)
                                                                            {
                                                                            
                                                                            
                                                                            
                                                                                
                                                                                cmbOrden.setValue(gEx('gridConfiguracion').getStore().getCount()+1);
                                                                                cmbRenderer.setValue(filaSel.data.funcionRenderer);
                                                                                
                                                                                
                                                                            }
                                                                            else
                                                                            {
                                                                                cmbOrden.setValue(filaSel.data.orden);
                                                                                cmbRenderer.setValue(filaSel.data.funcionRenderer);
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
                                                                                            
                                                                                            	var cmbOrden=gEx('cmbOrden');
                                                                                                var comboAlineacion=gEx('comboAlineacion');
                                                                                                var cmbRenderer=gEx('cmbRenderer');
                                                                                                var cmbVisible=gEx('cmbVisible');
                                                                                            
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
                                                                                                var anchoCol=Ext.getCmp('txtAncho').getValue();
                                                                                                
                                                                                                if(anchoCol=='')
                                                                                                {
                                                                                                	function resp()
                                                                                                    {
                                                                                                    	Ext.getCmp('txtAncho').focus();
                                                                                                    }
                                                                                                    msgBox('El valor ingresado no es v&aacute;lido',resp);
                                                                                                	return;
                                                                                                }
                                                                                                
                                                                                                var idAlineacion=Ext.getCmp('idCmbAlineacion').getValue();
                                                                                                if(idAlineacion=='')
                                                                                                {
                                                                                                	function respAl()
                                                                                                    {
                                                                                                    	Ext.getCmp('idCmbAlineacion').focus();
                                                                                                    }
                                                                                                    msgBox('Debe seleccionar la alineaci&oacute;n del elemento',respAl);
                                                                                                    return;
                                                                                                }
                                                                                                
                                                                                                var idIdioma=gE('hLeng').value;
                                                                                                var filaIdioma=obtenerFilaIdioma(tblGrid.getStore(),idIdioma);
                                                                                                var tCampo=filaIdioma.get('etiqueta');
                                                                                                var arrEtiqueta=obtenerValoresVentanaTitulo();
                                                                                                var objCampo='{"visible":"'+cmbVisible.getValue()+'","funcionRenderer":"'+cmbRenderer.getValue()+'","orden":"'+cmbOrden.getValue()+'","idCampo":"'+idCampo+'","etCampo":"'+etCampo+'","anchoCol":"'+anchoCol+'","tituloCampo":'+arrEtiqueta+',"accion":"'+accion+'","idAlineacion":"'+idAlineacion+'","idConfiguracion":"'+idConfiguracion+'"}';
                                                                                                var txtAlineacion=Ext.getCmp('idCmbAlineacion').getRawValue();
                                                                                                
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
                                                                                                                                                orden:parseInt(cmbOrden.getValue()),
                                                                                                                                                funcionRenderer:cmbRenderer.getValue()
                                                                                                                                            }
                                                                                                                                        )
                                                                                                                                        
                                                                                                                
                                                                                                                var nAux=0;
                                                                                                                var fAux;
                                                                                                                for(nAux=0;nAux<gridConfiguracion.getStore().getCount();nAux++)                        
                                                                                                                {
                                                                                                                	fAux=gridConfiguracion.getStore().getAt(nAux);
                                                                                                                    if(parseInt(fAux.data.orden)>=parseInt(cmbOrden.getValue()))
                                                                                                                    {
                                                                                                                    	fAux.set('orden',parseInt(fAux.data.orden+1));
                                                                                                                    }
                                                                                                                }
                                                                                                                                        
                                                                                                                Ext.getCmp('gridConfiguracion').getStore().add(nFila);
                                                                                                                
                                                                                                                
                                                                                                                
                                                                                                            }
                                                                                                            else
                                                                                                            {
                                                                                                            	filaSel.set('titulo',tCampo);
                                                                                                                filaSel.set('tamColumna',anchoCol);
                                                                                                                filaSel.set('alineacion',txtAlineacion);
                                                                                                                filaSel.set('funcionRenderer',cmbRenderer.getValue());
                                                                                                                var nAux=0;
                                                                                                                var fAux;
                                                                                                                
                                                                                                                if(parseInt(filaSel.data.orden)!=parseInt(cmbOrden.getValue()))
                                                                                                                {
                                                                                                                	if(parseInt(filaSel.data.orden)>parseInt(cmbOrden.getValue()))
                                                                                                                    {
                                                                                                                        for(nAux=0;nAux<gridConfiguracion.getStore().getCount();nAux++)                        
                                                                                                                        {
                                                                                                                            fAux=gridConfiguracion.getStore().getAt(nAux);
                                                                                                                            if((parseInt(fAux.data.orden)>=parseInt(cmbOrden.getValue()))&&(parseInt(fAux.data.orden)<parseInt(filaSel.data.orden)))
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
                                                                                                                           	if((parseInt(fAux.data.orden)>=parseInt(filaSel.data.orden))&&(parseInt(fAux.data.orden)<=parseInt(cmbOrden.getValue())))
                                                                                                                            {
                                                                                                                                fAux.set('orden',parseInt(fAux.data.orden-1));
                                                                                                                            }
                                                                                                                        }
                                                                                                                    }
																												}                                                                                                                
                                                                                                                
                                                                                                                filaSel.set('orden',parseInt(cmbOrden.getValue()));
                                                                                                               
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
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',resp, 'POST','funcion=216&objCampo='+objCampo,true);
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

function crearGridElemento(datos)
{
	tituloElemento='T&iacute;tulo de la columna';

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
															header:'Lenguaje',
															width:100,
															dataIndex:'idioma',
															renderer: cambiarColor
														},
														{
															header:tituloElemento+' <span style="color:#F00">*</span>',
															width:500,
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
                                                        cls:'gridSiugjPrincipal',
                                                        stripeRows :false,
                                                        border:true,    
                                                        columnLines : false,
                                                        clicksToEdit: 1,
                                                        cm: cmFrmDTD,
                                                        height:150,
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

function cambiarColor(val)
{
	 return '<img src="../images/banderas/'+val+'" />';
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
			msgBox('El contenido de esta celda no puede estar vac&iacute;o',funcAceptar);
			
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
					
					
					
					Ext.getCmp('btnAceptar').fireEvent('click');
				}
				else
					return false;
			}
			msgConfirm('Algunos campos obligatorios no han sido especificados en todos los idiomas desea continuar', funcConfirmacion);
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

function obtenerValoresVentanaTitulo()
{
	var dsGrid=Ext.getCmp('gridEtiquetas').getStore();
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
        
		obj='{"idIdioma":"'+idIdioma+'","etiqueta":"'+cv(etiqueta)+'","idCamposGrid":""}';
		if(arrObj=="")
			arrObj=obj;
		else
			arrObj+=','+obj;
	}
    arrEtiqueta='['+arrObj+']';

	return arrEtiqueta;
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
            
            Ext.getCmp('txtAncho').setValue(tamCol);
            Ext.getCmp('gridEtiquetas').getStore().loadData(arrTitulos);
            Ext.getCmp('idCmbAlineacion').setValue(idAlineacion);
            
            
            gEx('cmbOrden').setValue(obj.orden);
            gEx('cmbRenderer').setValue(obj.funcionRenderer);
            gEx('cmbVisible').setValue(obj.visible);
                                                                 
            
            
           	
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
	obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',resp, 'POST','funcion=217&campo='+idGrupoCampo,true);
}

function generarTabla()
{
	var almacen=Ext.getCmp('gridConfiguracion').getStore();
    var x=0;
    var numFilas=almacen.getCount();
    var filas;
    var columnas='';
    camposJava=new Array();
    columnasJava=new Array();
    
        columnasJava[0]=new  Ext.grid.RowNumberer();
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
        if(tblRegistro)
	        tblRegistro.parentNode.removeChild(tblRegistro);
        var tblContenedor=gE('tblConfiguracionGrid');
        var nuevoTbl=document.createElement('div');
        nuevoTbl.id='tblRegistros';
        tblContenedor.appendChild(nuevoTbl);
        crearTablaRegistros();
	
    

}


function mostrarVentanaAdministracionCamposTablero()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
														
														crearGridCamposTableroControl()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Administraci&oacute;n de campos del tablero de control',
										width: 800,
										height:420,
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
                                                            cls:'btnSIUGJCancel',
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

function crearGridCamposTableroControl()
{


	var cmbComboTipoCampo=crearComboExt('cmbComboTipoCampo',arrTipoCampo,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                            			{name:'nombreCampoOriginal'},
                                               			{name:'nombreCampo'},
		                                                {name: 'tipoCampo'},
		                                                {name:'eliminable'}
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
                                                            sortInfo: {field: 'nombreCampo', direction: 'ASC'},
                                                            groupField: 'nombreCampo',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	
    alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='219';
                                        proxy.baseParams.idConfiguracion=idConfiguracion;
                                        
                                        gEx('btnDelCampo').enable();
                                        
                                    }
                        )   


	var editorFila=new Ext.ux.grid.RowEditor	(
                                                        {
                                                            id:'editorFila',
                                                            saveText: 'Guardar',
                                                            cancelText:'Cancelar',
                                                            minButtonWidth:140,
                                                            clicksToEdit:2
                                                        }
                                                    );
                                                   
    editorFila.on('beforeedit',funcEditorFilaBeforeEdicion)
    editorFila.on('validateedit',funcEditorValidaEdicion);
    editorFila.on('canceledit',funcEditorCancelEdicion);

	
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer({width:40}),
                                                       
                                                        {
                                                            header:'Campo <span style="color:#F00">*</span>',
                                                            width:280,
                                                            sortable:true,
                                                            dataIndex:'nombreCampo',
                                                            editor:	{
                                                            			xtype:'textfield',
                                                                        cls:'controlSIUGJ',
                                                                        enableKeyEvents :true,
                                                            			maskRe:/^[_a-zA-Z0-9]$/
                                                            		}
                                                        },
                                                        {
                                                            header:'Tipo de campo <span style="color:#F00">*</span>',
                                                            width:160,
                                                            sortable:true,
                                                            dataIndex:'tipoCampo',
                                                            editor:cmbComboTipoCampo,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrTipoCampo,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Eliminable/Modificable',
                                                            width:240,
                                                            align:'center',
                                                            sortable:true,
                                                            dataIndex:'eliminable',
                                                            renderer:function(val)
                                                            			{
                                                                        	if(val=='1')
                                                                            	return '<img src="../images/icon_big_tick.gif" width="14" height="14">';
                                                                            return '<img src="../images/cross.png" width="14" height="14">'
                                                                        }
                                                        }
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gAmonCamposTablero',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            cm: cModelo,
                                                            stripeRows :false,
                                                            loadMask:true,
                                                            cls:'gridSiugjPrincipal',
                                                            plugins:[editorFila],
                                                            columnLines : false,
                                                            tbar:	[
                                                                        {
                                                                        	id:'btnAddCampo',
                                                                            icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Crear campo',
                                                                            handler:function()
                                                                                    {
                                                                                        var reg=crearRegistro	(
                                                                                        							[
                                                                                                                    	{name: 'nombreCampoOriginal'},
                                                                                                                    	{name:'nombreCampo'},
                                                                                                                        {name: 'tipoCampo'},
                                                                                                                        {name:'eliminable'}
                                                                                                                    ]
                                                                                        						)
                                                                                    
                                                                                    	var r=new reg	(
                                                                                        					{
                                                                                                            	nombreCampoOriginal:'',
                                                                                                                nombreCampo:'',
                                                                                                                tipoCampo:'',
                                                                                                                eliminable:'1'
                                                                                                            }
                                                                                        				)
                                                                                                        
                                                                                                        
                                                                                    	var editorFila=gEx('editorFila');   
                                                                                        
                                                                                        
                                                                                         editorFila.stopEditing();
                                                                                         tblGrid.getStore().add(r);
                                                                                         tblGrid.nuevoRegistro=true;
                                                                                         editorFila.startEditing(tblGrid.getStore().getCount()-1);	
                                                                                         			                 
                                                                                    
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	xtype:'tbspacer',
                                                                            width:10
                                                                        },                                                                        
                                                                        {
                                                                        	id:'btnDelCampo',
                                                                            icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Eliminar campo',
                                                                            handler:function()
                                                                                    {
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	var fila=tblGrid.getStore().getAt(tblGrid.getSelectionModel().getSelectedCell()[0]);
                                                            
                                                                                            	var cadObj='{"idConfiguracion":"'+idConfiguracion+'","nombreCampo":"'+fila.data.nombreCampo+'"}';
   
                                                                                                function funcAjax()
                                                                                                {
                                                                                                    var resp=peticion_http.responseText;
                                                                                                    arrResp=resp.split('|');
                                                                                                    if(arrResp[0]=='1')
                                                                                                    {
                                                                                                    	cargarDatosConfiguracion(gEx('gridConfiguracion').getStore());
                                                                                                        gEx('gOrdenTableroControl').getStore().reload();

                                                                                                        gEx('gAmonCamposTablero').getStore().reload();
                                                                                                                    
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=221&cadObj='+cadObj,true);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer eliminar el campo seleccionado?',resp);
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
                                                    
	tblGrid.getSelectionModel().on('cellselect',function(sm,nFila,col)
    													{
                                                        	var fila=tblGrid.getStore().getAt(nFila);
                                                            
                                                            if(fila.data.eliminable=='1')
                                                            {
                                                            	gEx('btnDelCampo').enable();
                                                            }
                                                            else
                                                            	gEx('btnDelCampo').disable();
                                                            
                                                            
                                                        }
    								)                                                    
                                                    
    return 	tblGrid;	        
   
}

function funcEditorFilaBeforeEdicion(rowEdit,fila)
{
	capturado=false;
	Ext.getCmp('btnAddCampo').disable();
    Ext.getCmp('btnDelCampo').disable();	
	var idGrid='gAmonCamposTablero';
	var grid=Ext.getCmp(idGrid);
    grid.copiaRegistro=grid.getStore().getAt(fila).copy();
    grid.registroEdit=grid.getStore().getAt(fila);
	if((grid.soloLectura)&&(!grid.nuevoRegistro))
		return false;
}

function funcEditorValidaEdicion(rowEdit,obj,registro,nFila)
{
	if(capturado)
    	return true;
	var idGrid='gAmonCamposTablero';
	var grid=Ext.getCmp(idGrid);
	var cm=grid.getColumnModel();
	var nColumnas=cm.getColumnCount(false);
    
	var x;
	var editor;
	var dataIndex;
	var valor;
	for(x=0;x<nColumnas;x++)
	{
		if(cm.getColumnHeader(x).indexOf('*')!=-1)
		{
			dataIndex=cm.getDataIndex(x);
			valor=(eval('obj.'+dataIndex));
			if(valor=='')
			{
				function funcResp()
				{
					var ctrl=gEx('editor_'+dataIndex);
					ctrl.focus();
				}
				msgBox('La columna "'+cm.getColumnHeader(x).replace('*','')+'" no puede ser vac&iacute;a',funcResp);
				return false;
			}
		}	
	}
   capturado=true;
   	var cadObj='{"idConfiguracion":"'+idConfiguracion+'","nombreCampoOriginal":"'+registro.data.nombreCampoOriginal+'","nombreCampo":"'+obj.nombreCampo+'","tipoCampo":"'+obj.tipoCampo+'"}';
   
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	if(arrResp[1]=='1')
            {
                if(Ext.getCmp('btnDelCampo')!=null)
                    Ext.getCmp('btnDelCampo').enable();	
                if(Ext.getCmp('btnAddCampo')!=null)            
                    Ext.getCmp('btnAddCampo').enable();
                grid.nuevoRegistro=false;
                
			}
            else
            {
            	
                msgBox('El nombre del campo ya a sido registrado previamente');
            }
            gEx('gAmonCamposTablero').getStore().reload();
            if(registro.data.nombreCampoOriginal!='')
            {
	            cargarDatosConfiguracion(gEx('gridConfiguracion').getStore());
                gEx('gOrdenTableroControl').getStore().reload();
            }
                        
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=220&cadObj='+cadObj,true);
}

function funcEditorCancelEdicion(rowEdit,cancelado)
{

	var idGrid='gAmonCamposTablero';
	var grid=Ext.getCmp(idGrid);
	if(grid.nuevoRegistro)
		grid.getStore().removeAt(grid.getStore().getCount()-1);
	Ext.getCmp('btnDelCampo').enable();
    Ext.getCmp('btnAddCampo').enable();

    var copiaRegistro=grid.copiaRegistro;
    
    var x=0;
    var arrCampos=grid.getStore().fields;
    var filaDestino=grid.registroEdit;

    for(x=0;x<arrCampos.items.length;x++)
    {
    	filaDestino.set(arrCampos.items[x].name,copiaRegistro.get(arrCampos.items[x].name));

    }

    
	grid.nuevoRegistro=false;
	
}

function crearGridOrdenTablero()
{

	var cmbDireccion=crearComboExt('cmbDireccion',arrDireccion,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
    var cmbCampoOrden=crearComboExt('cmbCampoOrden',arrCamposTableroControl,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});

	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'campo'},
		                                                {name:'direccion'}
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
                                                            sortInfo: {field: 'idRegistro', direction: 'ASC'},
                                                            groupField: 'idRegistro',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='223';
                                        proxy.baseParams.idConfiguracion=idConfiguracion;
                                    }
                        )   
      
      
    alDatos.on('load',function(proxy)
    								{
                                    	arrCamposTableroControl=proxy.reader.jsonData.camposTableroControl;
                                        
                                    }
                        )    
       
       
	var editorFila=new Ext.ux.grid.RowEditor	(
                                                        {
                                                            id:'editorFilaOrden',
                                                            saveText: 'Guardar',
                                                            cancelText:'Cancelar',
                                                            minButtonWidth:140,
                                                            clicksToEdit:2
                                                        }
                                                    );
                                                   
    editorFila.on('beforeedit',funcEditorFilaBeforeEdicionOrden)
    editorFila.on('validateedit',funcEditorValidaEdicionOrden);
    editorFila.on('canceledit',funcEditorCancelEdicionOrden);       
       
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            
                                                            
                                                            {
                                                                header:'Campo orden <span style="color:#F00">*</span>',
                                                                width:340,
                                                                sortable:true,
                                                                dataIndex:'campo',
                                                                editor:cmbCampoOrden,
                                                                renderer:function(val)	
                                                                		{
                                                                        	return val;
                                                                        }
                                                            },
                                                            {
                                                                header:'Direcci&oacute;n <span style="color:#F00">*</span>',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'direccion',
                                                                editor:cmbDireccion,
                                                                renderer:function(val)	
                                                                		{
                                                                        	return formatearValorRenderer(arrDireccion,val);
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                            {
                                                                id:'gOrdenTableroControl',
                                                                store:alDatos,
                                                                x:330,
                                                                y:250,
                                                                cls:'gridSiugjPrincipal',
                                                                width:560,
                                                                height:200,
                                                                frame:false,
                                                                clicksToEdit:2,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                plugins:[editorFila],
                                                                columnLines : true,
                                                               	tbar:	[
                                                                              {
                                                                              	  id:'btnAddOrden',
                                                                                  icon:'../images/add.png',
                                                                                  cls:'x-btn-text-icon',
                                                                                  text:'Agregar campo',
                                                                                  handler:function()
                                                                                          {
                                                                                                var reg=crearRegistro	(
                                                                                                                            [
                                                                                                                                {name:'idRegistro'},
                                                                                                                                {name: 'campo'},
                                                                                                                                {name:'direccion'}
                                                                                                                            ]
                                                                                                                        )   
                                                                                              
                                                                                                var r=new reg	(
                                                                                                                    {
                                                                                                                        idRegistro:-1,
                                                                                                                        campo:'',
                                                                                                                        direccion:'ASC'
                                                                                                                    }	
                                                                                                                )
                                                                                                            
                                                                                                 
                                                                                                 
                                                                                                 
                                                                                                 var editorFila=gEx('editorFilaOrden');   
                                                                                        
                                                                                        
                                                                                                 editorFila.stopEditing();
                                                                                                 tblGrid.getStore().add(r);
                                                                                                 tblGrid.nuevoRegistro=true;
                                                                                                 editorFila.startEditing(tblGrid.getStore().getCount()-1);	
                                                                                                            
                                                                                                            
                                                                                          
                                                                                          }
                                                                                  
                                                                              },
                                                                              {
                                                                              	xtype:'tbspacer',
                                                                                width:10
                                                                              },
                                                                              {
                                                                              	  id:'btnDelOrden',
                                                                                  icon:'../images/delete.png',
                                                                                  cls:'x-btn-text-icon',
                                                                                  text:'Remover campo',
                                                                                  handler:function()
                                                                                          {
                                                                                              function resp(btn)
                                                                                              {
                                                                                                    if(btn=='yes')
                                                                                                    {
                                                                                                    	var fila=tblGrid.getStore().getAt(tblGrid.getSelectionModel().getSelectedCell()[0]);
                                                            
                                                                                                        var cadObj='{"idConfiguracion":"'+idConfiguracion+'","idRegistro":"'+fila.data.idRegistro+'"}';
           
                                                                                                        function funcAjax()
                                                                                                        {
                                                                                                            var resp=peticion_http.responseText;
                                                                                                            arrResp=resp.split('|');
                                                                                                            if(arrResp[0]=='1')
                                                                                                            {
                                                                                                               
                                                                                                                gEx('gOrdenTableroControl').getStore().reload();
        
                                                                                                               
                                                                                                                            
                                                                                                            }
                                                                                                            else
                                                                                                            {
                                                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                            }
                                                                                                        }
                                                                                                        obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=225&cadObj='+cadObj,true);
                                                                                                    }
                                                                                              }
                                                                                              msgConfirm('Est&aacute; seguro de querer remover el campo seleccionado?',resp);
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

function funcEditorFilaBeforeEdicionOrden(rowEdit,fila)
{
	capturado=false;
    gEx('cmbCampoOrden').getStore().loadData(arrCamposTableroControl);
	Ext.getCmp('btnAddOrden').disable();
    Ext.getCmp('btnDelOrden').disable();	
	var idGrid='gOrdenTableroControl';
	var grid=Ext.getCmp(idGrid);
    grid.copiaRegistro=grid.getStore().getAt(fila).copy();
    grid.registroEdit=grid.getStore().getAt(fila);
	if((grid.soloLectura)&&(!grid.nuevoRegistro))
		return false;
}

function funcEditorValidaEdicionOrden(rowEdit,obj,registro,nFila)
{
	if(capturado)
    	return true;
	var idGrid='gOrdenTableroControl';
	var grid=Ext.getCmp(idGrid);
	var cm=grid.getColumnModel();
	var nColumnas=cm.getColumnCount(false);
    
	var x;
	var editor;
	var dataIndex;
	var valor;
	for(x=0;x<nColumnas;x++)
	{
		if(cm.getColumnHeader(x).indexOf('*')!=-1)
		{
			dataIndex=cm.getDataIndex(x);
			valor=(eval('obj.'+dataIndex));
			if(valor=='')
			{
				function funcResp()
				{
					var ctrl=gEx('editor_'+dataIndex);
					ctrl.focus();
				}
				msgBox('La columna "'+cm.getColumnHeader(x).replace('*','')+'" no puede ser vac&iacute;a',funcResp);
				return false;
			}
		}	
	}
   	capturado=true;
   	var cadObj='{"idConfiguracion":"'+idConfiguracion+'","idRegistro":"'+registro.data.idRegistro+'","nombreCampo":"'+obj.campo+'","orden":"'+obj.direccion+'"}';
   
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	
            if(Ext.getCmp('btnDelOrden')!=null)
                Ext.getCmp('btnDelOrden').enable();	
            if(Ext.getCmp('btnAddOrden')!=null)            
                Ext.getCmp('btnAddOrden').enable();
            grid.nuevoRegistro=false;
                
			
            gEx('gOrdenTableroControl').getStore().reload();
            
                        
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=224&cadObj='+cadObj,true);
}

function funcEditorCancelEdicionOrden(rowEdit,cancelado)
{

	var idGrid='gOrdenTableroControl';
	var grid=Ext.getCmp(idGrid);
	if(grid.nuevoRegistro)
		grid.getStore().removeAt(grid.getStore().getCount()-1);
	Ext.getCmp('btnDelOrden').enable();
    Ext.getCmp('btnAddOrden').enable();

    var copiaRegistro=grid.copiaRegistro;
    
    var x=0;
    var arrCampos=grid.getStore().fields;
    var filaDestino=grid.registroEdit;

    for(x=0;x<arrCampos.items.length;x++)
    {
    	filaDestino.set(arrCampos.items[x].name,copiaRegistro.get(arrCampos.items[x].name));

    }

    
	grid.nuevoRegistro=false;
	
}

//
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
										width: 900,
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
                                                            cls:'btnSIUGJCancel',
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
                                    	proxy.baseParams.funcion='227';
                                        proxy.baseParams.idConfiguracion=idConfiguracion;
                                       
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            
                                                            {
                                                                header:'&Iacute;ndice',
                                                                width:260,
                                                                sortable:true,
                                                                dataIndex:'etiqueta',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            
                                                            
                                                            
                                                            {
                                                                header:'Campos asociados',
                                                                width:540,
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
                                                                stripeRows :false,
                                                                columnLines : false,
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
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=228&idConfiguracion='+idConfiguracion+'&indice='+fila.data.etiqueta,true);
                                                                                                    
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover el &iacute;ndice <b>'+fila.data.etiqueta+'</b>',resp);
                                                                                            
                                                                                            
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
                                        cls:'msgHistorialSIUGJ',
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
                                                                	gEx('txtNombreIndice').setValue((fila?fila.data.etiqueta:'idx_'+generarNumeroAleatorio(1,10000)));
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
                                                                        
                                                                        var cadObj='{"idConfiguracion":"'+idConfiguracion+'","nombreIndice":"'+(fila?fila.data.etiqueta:'')+'","nombre":"'+cv(txtNombreIndice.getValue())+'","campos":"'+listaCampos+'"}';
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
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=226&cadObj='+cadObj,true);
                                                                        
                                                                        
                                                                        
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
        	pos=existeValorMatriz(arrCamposTableroControl,aCamposIndice[x]);
            
            if(pos==-1)
            {
            	arrCamposIndice.push([aCamposIndice[x],aCamposIndice[x],(x+1)]);
            }
            else
            {
            	arrCamposIndice.push([arrCamposTableroControl[pos][0],arrCamposTableroControl[pos][1],(x+1)]);
            }

       	}
       
    }
    gridCamposTabla.getStore().loadData(arrCamposTableroControl);
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
															dataIndex:'campo'
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
                                                            stripeRows :true,
                                                            columnLines : true,
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


//
function mostrarVentanaAdmonFiltros()
{
	var gridFiltrosGlobales=crearGridFiltrosGlobales();
	var form = new Ext.form.FormPanel(	
    
										{
											baseCls: 'x-plain',
											layout:'absolute',
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
										width: 800,
										height:400,
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
                                    	proxy.baseParams.funcion='230';
                                        proxy.baseParams.iC=idConfiguracion;
                                        
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            {
                                                                header:'Etiqueta',
                                                                width:230,
                                                                sortable:true,
                                                                dataIndex:'etiqueta'
                                                                
                                                            },
                                                            {
                                                                header:'Campo asociado',
                                                                width:200,
                                                                sortable:true,
                                                                css:'text-align:left;',
                                                                dataIndex:'campoAsociado',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val;
                                                                        }
                                                            },
                                                            {
                                                                header:'Tama&ntilde;o',
                                                                width:100,
                                                                sortable:true,
                                                                dataIndex:'tamano'
                                                            },
                                                            {
                                                                header:'Tipo filtro',
                                                                width:150,
                                                                 css:'text-align:left;',
                                                                sortable:true,
                                                                dataIndex:'tipo',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrTiposFiltro,val));
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
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                width:750,
                                                                x:10,
                                                                y:20,
                                                                height:280,
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Agregar filtro',
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaConfiguracionFiltro();
                                                                                        }
                                                                                
                                                                            },'-',
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
                                                                            
                                                                            '-',
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
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=231&idFiltro='+fila.data.idFiltro,true);
                                                                                                    
                                                                                                    
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover el filtro seleccionado?',resp);
                                                                                            
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
	var cmbTipoFiltro=crearComboExt('cmbTipoFiltro',[],150,65,270);
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
    
    
	var cmbCampoAsocido=crearComboExt('cmbCampoAsocido',arrCamposTableroControl,150,35,250);
    
    cmbCampoAsocido.on('select',function(cmb,registro)
    							{
                                	gEx('lblTamano').hide();
                                    gEx('txtTamano').hide();
                                	var arrValores=[];
                                    
                                	
                                    var aTipo=obtenerValoresTipoFiltro(registro.data.valorComp);
                                    cmbTipoFiltro.setValue('');
                                    cmbTipoFiltro.getStore().loadData(aTipo);
                                    if(aTipo.length=='1')
                                    {
                                    	cmbTipoFiltro.setValue(aTipo[0][0]);
                                    }
                                }
    					)
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Etiqueta del filtro:'
                                                        },
                                                        {
                                                        	x:150,
                                                            y:5,
                                                            xtype:'textfield',
                                                            id:'txtEtiqueta',
                                                            width:300
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Campo asociado:'
                                                        },
                                                        cmbCampoAsocido,
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'Tipo de filtro:'
                                                        },
                                                        cmbTipoFiltro,
                                                        {
                                                        	x:440,
                                                            y:70,
                                                            id:'lblTamano',
                                                            hidden:true,
                                                            html:'Tama&ntilde;o del control:'
                                                        },
                                                        {
                                                        	x:560,
                                                            y:65,
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
                                                            y:100,
                                                            html:'Funci&oacute;n origen opciones:'
                                                        },
                                                        {
                                                        	x:150,
                                                            y:95,
                                                            width:320,
                                                             xtype:'textfield',
                                                            id:'txtOrigenOpciones',
                                                            readOnly:true
                                                        },
                                                        {
                                                        	x:480,
                                                            y:100,
                                                            html:'<a href="javascript:definirFuncionOrigenValores()"><img src="../images/pencil.png" title="Agregar funci&oacute;n" alt="Agregar funci&oacute;n"></a>&nbsp;&nbsp;<a href="javascript:removerFuncion(1)"><img src="../images/delete.png" title="Remover funci&oacute;n" alt="Remover funci&oacute;n"></a>'
                                                        },
                                                        
                                                        {
                                                        	x:10,
                                                            y:130,
                                                            html:'Funci&oacute;n valor default:'
                                                        },
                                                        {
                                                        	x:150,
                                                            y:125,
                                                            width:320,
                                                             xtype:'textfield',
                                                            id:'txtValorDefault',
                                                            readOnly:true
                                                        },
                                                        {
                                                        	x:480,
                                                            y:130,
                                                            html:'<a href="javascript:definirValorDefault()"><img src="../images/pencil.png" title="Agregar funci&oacute;n" alt="Agregar funci&oacute;n"></a>&nbsp;&nbsp;<a href="javascript:removerFuncion(2)"><img src="../images/delete.png" title="Remover funci&oacute;n" alt="Remover funci&oacute;n"></a>'
                                                        },

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: fila?'Modificar filtro':'Agregar filtro',
										width: 670,
										height:250,
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
                                                                	gEx('txtEtiqueta').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
                                                                    	var txtEtiqueta=gEx('txtEtiqueta');
                                                                        var txtTamano=gEx('txtTamano');
                                                                        var txtOrigenOpciones=gEx('txtOrigenOpciones');
                                                                        var txtValorDefault=gEx('txtValorDefault');
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
                                                                            
																		var cadObj='{"idConfiguracion":"'+idConfiguracion+'","idFiltro":"'+idFiltro+'","etiqueta":"'+cv(gEx('txtEtiqueta').getValue())+'","campo":"'+cmbCampoAsocido.getValue()+'","tipoFiltro":"'+cmbTipoFiltro.getValue()+
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
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=229&cadObj='+cadObj,true);
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        
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
            case 'decimal':
            case 'int':
            	arrTipos.push(['1','Rango de valores']);
            break;
            case 'date':
                arrTipos.push(['6','Rango de valores']);
                
            break;
            case 'datetime':
            	arrTipos.push(['6','Rango de valores (S\xF3lo fecha)']);
                arrTipos.push(['7','Rango de valores (Fecha y hora)']);
                
            break;
            case 'time':
                arrTipos.push(['8','Rango de valores']);
                
            break;
            case 'varchar':
            case 'text':
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


