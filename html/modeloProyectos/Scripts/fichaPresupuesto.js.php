<?php session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	if(isset($_GET["idFormulario"]))
		$idFormulario=$_GET["idFormulario"];
	else
		$idFormulario="-1";
		
	if(isset($_GET["idRegistro"]))
		$idRegistro=$_GET["idRegistro"];
	else
		$idRegistro="-1";	
		
		
	if(isset($_GET["idProceso"]))
		$idProceso=$_GET["idProceso"];
	else
		$idProceso="-1";	
		
	$consulta="select idPais,nombre from 238_paises order by nombre";
	$arrPaises=uEJ($con->obtenerFilasArreglo($consulta));
	$consulta="select codigoCompleto,tituloCentroC from 506_centrosCosto order by tituloCentroC";
	$arrCentroC=uEJ($con->obtenerFilasArreglo($consulta));
	$consulta="select id_650_zonas,NombreZona from 650_zonas order by NombreZona";
	$arrZonas=uEJ($con->obtenerFilasArreglo($consulta));
	$consulta="select idEstado,estado from  654_estadoTabulacion order by estado";
	$arrStatus=uEJ($con->obtenerFilasArreglo($consulta));	
	
	$consultaPatrocinadores="SELECT codUnidad,unidad FROM 817_organigrama o, 9036_patrocinadoresProyectos p WHERE codUnidad=codigoUnidad AND idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
	$arregloPatrocinadores=$con->obtenerFilasArreglo($consultaPatrocinadores);
		
	//$idFormulario=$_POST["idFormulario"];
	//$idProceso=$_POST["idProceso"];
	//$idRegistro=$_POST["idRegistro"];
		
		$consultaObG="SELECT distinct objGasto,tituloObj FROM 507_objetosGasto o,9035_objetosGastoPresupuesto op WHERE idProceso=".$idProceso." AND o.codigoObj=op.objGasto" ;
		$res=$con->obtenerFilas($consultaObG);
		$nObjetos=$con->filasAfectadas;
		$consultaP="SELECT distinct codUnidad,unidad FROM 817_organigrama o, 9036_patrocinadoresProyectos WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." AND codUnidad=codigoUnidad";
		$res1=$con->obtenerFilas($consultaP);
		$noFilas=$con->filasAfectadas;
		$aregloCabeceras="";
		$arregloName="";
		$ct1=0;
		$arrCodigosUnidad="";
		while($fila12=mysql_fetch_row($res1))
		{
			if($arrCodigosUnidad=="")
				$arrCodigosUnidad="'".$fila12[0]."'";
			else
				$arrCodigosUnidad.=",'".$fila12[0]."'";
			$objCbc="
					{
						header:'".$fila12[1]."',
						width:150,
						sortable:true,
						dataIndex:'".$fila12[0]."_".$ct1."',
						renderer:'usMoney'
					}
			";
			
			if($aregloCabeceras=="")
				$aregloCabeceras=','.$objCbc;
			else
				$aregloCabeceras.=",".$objCbc;
				
			$objName="{name: '".$fila12[0]."_".$ct1."'}";
			if($arregloName=="")
				$arregloName=",".$objName;
			else	
				$arregloName.=",".$objName;
			$ct1++;
		}
		
		$arrCodigosUnidad='['.$arrCodigosUnidad.']';
		$arregloDatos="";
		$arregloCodigos="";
		if($nObjetos>0)
		{
			mysql_data_seek($res,0);	
		}
		while($fila=mysql_fetch_row($res))
		{
			$ct=0;
			if($noFilas>0)
			{
				mysql_data_seek($res1,0);
			}
			$objC="";
			while($fila1=mysql_fetch_row($res1))
			{
				$consultaP="SELECT cantidad FROM 9037_presupuestoRegistro WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." AND objGasto=".$fila[0]." AND patrocinador=".$fila1[0];
				$valor=$con->obtenerValor($consultaP);
				
				if($valor=="")
					$valor=0;
				
					if($objC=="")
						$objC=",'".$valor."'";
					else	
						$objC.=",'".$valor."'";
				
				$ct++;
			}
			
			$objP="['".$fila[0]."','".$fila[1]."'".$objC."]";
			if($arregloCodigos=="")
				$arregloCodigos=$objP;
			else
				$arregloCodigos.=",".$objP;
		}
		$arregloCodigos='['.$arregloCodigos.']';
?>		

var arrCodigosUnidad=<?php echo $arrCodigosUnidad?>;
Ext.onReady(inicializar);

function inicializar()
{
    crearGrid();
}


function crearGrid()
{
	//var arregloDatos=[];
    //arregloDatos=obtenerDatos();
    //if(arregloDatos=="")
    //{
    	//return;
    //}
    //arregloDatos=arregloDatos.split('_');
    
    var dsDatos=<?php echo $arregloCodigos ?>;
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'codObjetoGasto'},
                                                                {name: 'etObjetoGasto'}
                                                                <?php
																echo $arregloName
																?>
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														
														{
															header:'Rubro',
															width:150,
															sortable:true,
															dataIndex:'etObjetoGasto'
														}
                                                        <?php
															echo $aregloCabeceras
														?>

													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            title:'Presupuesto',
                                                            frame:true,
                                                            renderTo:'gridPresupuesto',
                                                            cm: cModelo,
                                                            height:460,
                                                            width:750
                                                            
                                                        }
                                                    );
	tblGrid.on('afteredit',funcEditado)                                                  
	return 	tblGrid;		
}

function funcEditado(e)
{
	//alert(e.record.get('codObjetoGasto')+'_'+arrCodigosUnidad[e.column-3]+'_'+e.value);
    
    var codObjG=e.record.get('codObjetoGasto');
    var idPatrocinador=arrCodigosUnidad[e.column-3];
    var valor=e.value;
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax, 'POST','funcion=49&idFornulario='+<?php echo $idFormulario?>+'&idRegistro='+<?php echo $idRegistro?>+'&valor='+valor+'&codObjG='+codObjG+'&idPatrocinador='+idPatrocinador,true);
}

var arrParticipacion=[];

function agregarInstitucion()
{
    
	var dsRelaciones= new Ext.data.SimpleStore	(
													{
														fields:	[
																	{name:'codigoUnidad'},
																	{name:'unidad'}
																]
													}
												)

	
	var cmbRel=document.createElement('select');
	
	var parametros2=	{
							funcion:'50',
							criterio:''
						};
	
	var comboPapa=inicializarCmbPadre(parametros2);



	var form = new Ext.form.FormPanel(	
										 	{
												baseCls: 'x-plain',
												layout:'absolute',
												defaultType: 'textfield',
												items: 	[
														 	new Ext.form.Label	(
																				 	{
																						x:5,
																						y:20,
																						text:'Institución: '
																					}
																				)
															,
															comboPapa,
                                                             new Ext.form.Label	(
                                                                                    {
																						x:5,
																						y:50,
																						html:'Para agregar una institucion de click <a href="javascript:agregarInstitucion2(1)"><font color="#FF0000">AQUI</font></a>'
																					}
                                                                                )  
														]
											}
										);
	
	var ventana = new Ext.Window	(
									{
										title: lblAplicacion,
										width: 450,
										height:150,
										minWidth: 280,
										minHeight: 100,
										layout: 'fit',
										plain:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										modal:true,
										listeners : {
														show : {
																	buffer : 500,
																	fn : function() 
																	{
																		comboPapa.focus();
																	}
																}
													},
										buttons:	[
														{
															text: 'Aceptar',
															handler:function()
																	{
																		var codigoUnidad=gE('codigoUnidad').value;
                                                                       
                                                                        if(codigoUnidad=='')
                                                                        {
                                                                        	function respUsr()
                                                                            {
                                                                            	comboPapa.focus();
                                                                            }
                                                                        	msgBox('Debe seleccionar la instituci&oacute;n a agregar',respUsr);
                                                                            return;
                                                                        }
                                                                        
                                                                        //var codUnidad=gE('codigoUnidad').value;
                                                                        var idFormulario=<?php echo $idFormulario?>;
                                                                        var idReferencia=<?php echo $idRegistro?>;
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText.split('|');
                                                                            if(resp[0]=='1')
                                                                            {
                                                                                
                                                                                recargarPagina();
                                                                            }
                                                                            else
                                                                            {
                                                                                Ext.MessageBox.alert(lblAplicacion,'No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema: <br>'+resp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax, 'POST','funcion=51&codigoUnidad='+codigoUnidad+'&idFormulario='+idFormulario+'&idReferencia='+idReferencia,true)
                                                                    }
                                                                    
														},
														{
															text: 'Cancelar',
															handler:function()
																	{
																		ventana.close();
																	}
														}
													]
    								}
								);

	//var rdoPaterno=Ext.getCmp('rdoPaterno');
//	var rdoMaterno=Ext.getCmp('rdoMaterno');
//	var rdoNombre=Ext.getCmp('rdoNombre');
//	rdoPaterno.on('check',cambiarRadioSel);									
//	rdoMaterno.on('check',cambiarRadioSel);									
//	rdoNombre.on('check',cambiarRadioSel);							
    ventana.show();
}

function inicializarCmbPadre(parametros2)
{

	var pPagina=new Ext.data.HttpProxy	(
										 	{
												url:'../paginasFunciones/funcionesContabilidad.php',
												method:'POST'
											}
										 );
	var lector=new Ext.data.JsonReader 	(
										 	{
												root:'instuciones',
												totalProperty:'num',
												id:'codigoUnidad'
											},
											[
											 	{name:'codigoUnidad', mapping:'codigoUnidad'},
												{name:'unidad', mapping:'unidad'},
											]
										);

	var ds=new Ext.data.Store	(
								 	{
										proxy:pPagina,
										reader:lector,
										baseParams:parametros2
									}
								 );
	
	function cargarDatos(dSet)
	{
		gE('codigoUnidad').value='-1';
		var aNombre=Ext.getCmp('cmbNombrePadre').getValue();
		dSet.baseParams.criterio=aNombre;
        dSet.baseParams.idFormulario=<?php echo $idFormulario?>;
        dSet.baseParams.idReferencia=<?php echo $idRegistro?>;
	}
	
	ds.on('beforeload',cargarDatos);

	var resultTpl=new Ext.XTemplate	(
									 	'<tpl for="."><div class="search-item">',
											'{unidad}&nbsp;<br>---<br>',
										'</div></tpl>'
									 );
	
	var comboNombre= new Ext.form.ComboBox	(
												 	{
														x:75,
														y:15,
														id:'cmbNombrePadre',
														store:ds,
														displayField:'unidad',
														typeAhead:false,
														minChars:1,
														loadingText:'Procesando, por favor espere...',
														width:340,
                                                        listWidth :320,
														pageSize:10,
														hideTrigger:true,
														tpl:resultTpl,
														itemSelector:'div.search-item'
														
													}
												 );
	
    function funcElemSeleccionado(combo,registro)
	{	
		var codigoUnidad=registro.get('codigoUnidad');
		gE('codigoUnidad').value=codigoUnidad;
    }
	comboNombre.on('select',funcElemSeleccionado);	
	return comboNombre;
}


function agregarInstitucion2(tipoUnidad,accion)
{
	var idOrganigrama="-1";
	var arrCentrosC=<?php echo $arrCentroC?>;
	var arrPaises=<?php echo $arrPaises?>;
    var arrUnidades=[['1','Departamento'],['2','Instituci\u00F3n']];
	var cmbPais=crearComboExt('cmbPais',arrPaises,110,270);
    cmbPais.setWidth(220);
    cmbPais.minListWidth=220;
    cmbPais.setValue('146');
	var cmbCentroCosto=crearComboExt('cmbCentroCosto',arrCentrosC,150,315,260);
    var controlTelefono='<table  border="0" cellspacing="1" cellpadding="1">'+
                        '<tr><td  >&nbsp;<select name="cmbTelefonoInst" id="cmbTelefonoInst" size="5" style="width:240px"></select><input type="hidden" name="telefonos" id="telefonos" value="" />'+
                        '</td><td width="5"  align="left">&nbsp;</td><td width="19"><table><tr><td>'+
                        '<a href="javaScript:solicitarTel(\'cmbTelefonoInst\')"><img src="../images/icon_big_tick.gif" alt="Agregar" height="15" title="Agregar Teléfono" border="0"/></a>'+
                        '</td></tr><tr><td>'+
                        '<a href="javaScript:eliminarTelefono(\'cmbTelefonoInst\')"><img src="../images/cancel_round.png" alt="Eliminar" title="Eliminar Teléfono" border="0"/></a>'+
                        '</td></tr></table><br /></td></tr></table>';
                        
	var controlTelefonoD='<table  border="0" cellspacing="1" cellpadding="1">'+
                        '<tr><td  >&nbsp;<select name="cmbTelefonoDepto" id="cmbTelefonoDepto" size="5" style="width:240px"></select><input type="hidden" name="telefonos" id="telefonos" value="" />'+
                        '</td><td width="5"  align="left">&nbsp;</td><td width="19"><table><tr><td>'+
                        '<a href="javaScript:solicitarTel(\'cmbTelefonoDepto\')"><img src="../images/icon_big_tick.gif" alt="Agregar" height="15" title="Agregar Teléfono" border="0"/></a>'+
                        '</td></tr><tr><td>'+
                        '<a href="javaScript:eliminarTelefono(\'cmbTelefonoDepto\')"><img src="../images/cancel_round.png" alt="Eliminar" title="Eliminar Teléfono" border="0"/></a>'+
                        '</td></tr></table><br /></td></tr></table>';                        
    
    var txtCod;
    var codigoPadre='';
    var longCod=4;
    var ancho=80;
    if(tipoUnidad==0)
    {
    	txtCod='txtCodigoDepto';
        if(accion==undefined)
	        codigoPadre=nodoSel.attributes.codigoU;
        else
        	codigoPadre=nodoSel.attributes.unidadPadre;
        if((nodoSel.attributes.institucion=='1')||((accion!=undefined)&&(nodoSel.parentNode.attributes.institucion=='1')))
        {
        	longCod=2;
            ancho=30;
        }
    }
    else
    {
    	txtCod='txtCodigoInst';
    }
    
    var panelUnidad=new Ext.Panel(
    								{
                                    	id:'panelUnidad',
                                    	x:10,
                                        y:10,
                                        
										layout:'absolute',
                                        width:415,
                                        height:380,
                                        hidden:true,
                                        baseCls: 'x-plain',
                                    	items:[
                                        		
                                        		{
                                                      x:10,
                                                      y:10,
                                                      baseCls: 'x-plain',
                                                      html:'C&oacute;digo depto/&Aacute;rea:'
                                                  },
                                                  {
                                                  	  id:'txtCodigoDepto',
                                                      x:150,
                                                      xtype:'textfield',
                                                      width:100,
                                                      y:5
                                                  },
                                                  {
                                                	x:10,
                                                    y:40,
                                                    html:'Clave departamental/&Aacute;rea:',
                                                    baseCls: 'x-plain'
                                                },
                                                {
                                                	  id:'txtClaveDep',
                                                      x:150,
                                                      xtype:'textfield',
                                                      width:100,
                                                      y:35
                                                  },
                                                  {
                                                      x:10,
                                                      y:70,
                                                      baseCls: 'x-plain',
                                                      html:'&Aacute;rea/Depto:<font color="red">*</font>'
                                                  },
                                                  {
                                                      x:150,
                                                      y:65,
                                                      id:'txtDeptoNuevo',
                                                      xtype:'textfield',
                                                      width:230
                                                  },
                                                  {
	                                               	  x:10,
                                                      y:100,
                                                      baseCls: 'x-plain',
                                                      html:'Descripci&oacute;n:'
                                                  },
                                                  {
                                                  	x:150,
                                                    y:95,
                                                    xtype:'textarea',
                                                    id:'txtDescripcionDepto',
                                                    width:240,
                                                    height:100
                                                  },
                                                  {
                                                  	x:10,
                                                    y:210,
                                                    baseCls: 'x-plain',
                                                    html:'Tel&eacute;fono:'
                                                  },
                                                  {
                                                  	x:150,
                                                    y:200,
                                                    baseCls: 'x-plain',
                                                    html:controlTelefonoD
                                                  },
                                                  {
                                                  	x:10,
                                                    y:320,
                                                    baseCls: 'x-plain',
                                                    html:'Cento de costo:'
                                                  },
                                                  cmbCentroCosto
                                               ]
                                      }
                                   )
    
    var panelInst=new Ext.Panel(
    								{
                                    	id:'panelInst',
                                    	x:10,
                                        y:10,
                                        baseCls: 'x-plain',
										layout:'absolute',
                                        width:385,
                                        height:380,
                                        hidden:true,
                                    	items:[
                                        		//{
//                                                      x:10,
//                                                      y:10,
//                                                      baseCls: 'x-plain',
//                                                      html:'C&oacute;digo:'
//                                                  },
                                                 // {
//                                                      x:110,
//                                                      id:'txtCodigoInst',
//                                                      xtype:'textfield',
//                                                      maxLength:4,
//                                                      width:80,
//                                                      y:5
//                                                  },
                                                  {
                                                      x:10,
                                                      y:40,
                                                      baseCls: 'x-plain',
                                                      html:'Instituci&oacute;n:<font color="red">*</font>'
                                                  },
                                                  {
                                                      x:110,
                                                      y:35,
                                                      id:'txtInstitucionNueva',
                                                      xtype:'textfield',
                                                      width:230
                                                  },
                                                  {
	                                               	  x:10,
                                                      y:70,
                                                      baseCls: 'x-plain',
                                                      html:'Descripci&oacute;n:'
                                                  },
                                                  {
                                                  	x:110,
                                                    y:65,
                                                    xtype:'textarea',
                                                    width:240,
                                                    height:100,
                                                    id:'txtDescripcion'
                                                  },
                                                  {
                                                      x:10,
                                                      y:185,
                                                      html:'CP.:',
                                                      baseCls: 'x-plain'
                                                  },
                                                  {
                                                      x:110,
                                                      y:180,
                                                      id:'txtCp',
                                                      xtype:'numberfield',
                                                      width:80,
                                                      allowDecimals:false,
                                                      allowNegative:false
                                                  }
                                                  ,
                                                  {
                                                      x:10,
                                                      y:215,
                                                      baseCls: 'x-plain',
                                                      html:'Ciudad:<font color="red">*</font>'
                                                  },
                                                  {
                                                      x:110,
                                                      y:210,
                                                      id:'txtCiudad',
                                                      xtype:'textfield',
                                                      width:200
                                                  },
                                                  {
                                                      x:10,
                                                      y:245,
                                                      baseCls: 'x-plain',
                                                      html:'Estado:<font color="red">*</font>'
                                                  },
                                                  {
                                                      x:110,
                                                      y:240,
                                                      id:'txtEstado',
                                                      xtype:'textfield',
                                                      width:200
                                                  },
                                                  {
                                                      x:10,
                                                      y:275,
                                                      baseCls: 'x-plain',
                                                      html:'Pa&iacute;s:<font color="red">*</font>'
                                                  }
                                                  ,
                                                  cmbPais,
                                                  {
                                                  	x:10,
                                                    y:305,
                                                    baseCls: 'x-plain',
                                                    html:'Tel&eacute;fono:'
                                                  },
                                                  {
                                                  	x:110,
                                                    y:300,
                                                    baseCls: 'x-plain',
                                                    html:controlTelefono
                                                  }
                                              ]
                                    }
                                )
    
    
	var form=new Ext.form.FormPanel(
										{
											baseCls: 'x-plain',
											layout:'absolute',
											disabled:false,
                                            defaultType:'label',
											items:	[
                                            			
                                            			panelInst,
                                                        panelUnidad
                                                   ]
										}
									)
	var ventana=new Ext.Window(
							   		{
										title:'Agregar &Aacute;rea/Departamento',
										width:500,
										height:550,
										layout:'fit',
										buttonAlign:'center',
										items:[form],
										modal:true,
										plain:true,
										listeners:
											{
												show:
												{
													buffer:10,
                                                    fn:function()
														{
																Ext.getCmp(txtCod).focus(false,500);
														}
												}
											},
										buttons:
												[
												 	{
														text:'Aceptar',
														handler:function ()
															{
                                                            	if(accion!=undefined)
                                                                {
                                                                	idOrganigrama=nodoSel.id;
                                                                }
                                                            	if(tipoUnidad==1)
                                                                {
                                                                	var codUnidad='';//Ext.getCmp(txtCod).getValue();
/*                                                                   // if(codUnidad=='')
//                                                                    {
//                                                                        function resp()
//                                                                        {
//                                                                            Ext.getCmp(txtCod).focus();
//                                                                        }
//                                                                        msgBox('Debe ingresar el c&oacute;digo de la instituci&oacute;n',resp);
//                                                                    }
*/                                                                    
                                                                    /*if(codUnidad.length>longCod)
                                                                    {
                                                                    	 function resp2()
                                                                        {
                                                                            Ext.getCmp(txtCod).focus();
                                                                        }
                                                                        msgBox('La longitud del c&oacute;digo es de '+longCod+' caracteres',resp2);
                                                                    }*/
                                                                    
                                                            		var telefonos=recoletarValoresCombo('cmbTelefonoInst');
                                                                    var txtInstitucion=Ext.getCmp('txtInstitucionNueva');
                                                                    var txtCp=Ext.getCmp('txtCp');
                                                                    var txtCiudad=Ext.getCmp('txtCiudad');
                                                                    var txtEstado=Ext.getCmp('txtEstado');
                                                                    if(txtInstitucion.getValue()=='')
                                                                    {
                                                                        function resp()
                                                                        {
                                                                            txtInstitucion.focus();
                                                                        }
                                                                        msgBox("El campo de instituci&oacute;n es obligatorio",resp);
                                                                        return;
                                                                    }
                                                                    if(txtCiudad.getValue()=='')
                                                                    {
                                                                        function resp()
                                                                        {
                                                                            txtCiudad.focus();
                                                                        }
                                                                        msgBox("El campo de ciudad es obligatorio",resp);
                                                                        return;
                                                                    }
                                                                    if(txtEstado.getValue()=='')
                                                                    {
                                                                        function resp()
                                                                        {
                                                                            txtEstado.focus();
                                                                        }
                                                                        msgBox("El campo de estado es obligatorio",resp);
                                                                        return;
                                                                    }
                                                                    var descripcion=Ext.getCmp('txtDescripcion').getValue();
                                                                   	var objIns='{"ciudad":"'+cv(txtCiudad.getValue())+'","estado":"'+cv(txtEstado.getValue())+'","idPais":"'+cmbPais.getValue()+'","cp":"'+txtCp.getValue()+'"}';
                                                                    var objParam='{"idOrganigrama":"'+idOrganigrama+'","codUnidad":"'+codUnidad+'","codigoUPadre":"","nombre":"'+cv(txtInstitucion.getValue())+'","descripcion":"'+descripcion+'","institucion":"1","objInst":'+objIns+',"telefonos":"'+telefonos+'"}';
                                                                    guardarInstitucion(objParam,ventana);    
                                                            	}  
                                                                else
                                                                {
                                                                	var txtClaveDep=gEx('txtClaveDep').getValue();
                                                                	var codUnidad=Ext.getCmp(txtCod).getValue();
                                                                    /*if(codUnidad=='')
                                                                    {
                                                                        function resp()
                                                                        {
                                                                            Ext.getCmp(txtCod).focus();
                                                                        }
                                                                        msgBox('Debe ingresar el c&oacute;digo del &aacute;rea',resp);
                                                                    }
                                                                    
                                                                    if(codUnidad.length>longCod)
                                                                    {
                                                                    	 function resp2()
                                                                        {
                                                                            Ext.getCmp(txtCod).focus();
                                                                        }
                                                                        msgBox('La longitud del c&oacute;digo es de '+longCod+' caracteres',resp2);
                                                                    }*/
                                                                	var telefonos=recoletarValoresCombo('cmbTelefonoDepto');
                                                                	var depto=Ext.getCmp('txtDeptoNuevo').getValue();
                                                                    var descripcion=Ext.getCmp('txtDescripcionDepto').getValue();
                                                                    var objParam='{"txtClaveDep":"'+txtClaveDep+'","longCod":"'+longCod+'","idOrganigrama":"'+idOrganigrama+'","codUnidad":"'+codUnidad+'","codigoUPadre":"'+codigoPadre+'","nombre":"'+cv(depto)+'","descripcion":"'+descripcion+'","institucion":"0"'+',"telefonos":"'+telefonos+'","CC":"'+cmbCentroCosto.getValue()+'"}';
                                                                    guardarDepartamento(objParam,ventana);
                                                                }
                                                                                                                          
															}
													},
													{
														text:'Cancelar',
														handler:function ()
															{
																ventana.close();
																
															}
													}
												 ]
									}
							   )
	if(tipoUnidad==0)
    {
        Ext.getCmp('panelUnidad').show();
        Ext.getCmp('panelInst').hide();
        ventana.setSize(480,440);
    }
    else
    {
        Ext.getCmp('panelInst').show();    
        Ext.getCmp('panelUnidad').hide();
        ventana.setSize(420,490);
	}                               
                               
	if(accion!=undefined)
    	llenarDatosUnidad(ventana,nodoSel);
    else
    {                               
		ventana.show();   
                 
    }
}


function guardarInstitucion(objInst,ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var idFormulario=<?php echo $idFormulario?>;
            var idReferencia=<?php echo $idRegistro?>;
            var codigoUnidad=arrResp[2];
            function funcAjax2()
            {
                var resp=peticion_http.responseText.split('|');
                if(resp[0]=='1')
                {
                    
                    recargarPagina();
                }
                else
                {
                    Ext.MessageBox.alert(lblAplicacion,'No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema: <br>'+resp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax2, 'POST','funcion=51&codigoUnidad='+codigoUnidad+'&idFormulario='+idFormulario+'&idReferencia='+idReferencia,true)
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax, 'POST','funcion=52&param='+objInst,true);
}


function eliminarInstitucion()
{
    var tablaMaterial=crearTablaMaterial();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'textfield',
											items: 	[ 
                                            			tablaMaterial
                                                        
													]
										}
									);


	var ventana = new Ext.Window(
									{
										title: 'Remover Instituci&oacute;n',
										width: 600,
										height:450,
										minWidth: 300,
										minHeight: 100,
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
															id:'btnAceptar',
															text: 'Aceptar',
															listeners:	{
																			click:function()
																				{
																					var tblMaestros=Ext.getCmp('tblMaestros');
                                                                                    var modeloSel=tblMaestros.getSelectionModel();
                                                                                    var fila=modeloSel.getSelections();
                                                                                    var tamano=fila.length;
                                                                                    
                                                                                    
                                                                                    if(tamano==0)
                                                                                    {
                                                                                    	msgBox('Debe seleccionar una instituci&oacute;n');
                                                                                        return;
                                                                                    }
                                                                                    
                                                                                    
                                                                                   var cadena=''; 
                                                                                   for(x=0;x< tamano;x++)
                                                                                   {
                                                                                   		var codUnidad=fila[x].get('codUnidad');
                                                                                   		
                                                                                        if(cadena!='')
                                                                                            cadena+=','+codUnidad;
                                                                                        else
                                                                                            cadena=codUnidad;
                                                                                        
                                                                                   }
                                                                                   
                                                                                    var idFormulario=<?php echo $idFormulario?>;
            																		var idReferencia=<?php echo $idRegistro?>;
                                                                                    function respPregunta(btn)
                                                                                    {
                                                                                        if(btn=='yes')
                                                                                        {
                                                                                            function funcAjax2()
                                                                                            {
                                                                                                var resp=peticion_http.responseText.split('|');
                                                                                                if(resp[0]=='1')
                                                                                                {
                                                                                                    
                                                                                                    recargarPagina();
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    Ext.MessageBox.alert(lblAplicacion,'No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema: <br>'+resp[0]);
                                                                                                }
                                                                                            }
                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax2, 'POST','funcion=53&cadena='+cadena+'&idFormulario='+idFormulario+'&idReferencia='+idReferencia,true)
                                                                                        }
                                                                                    }
                                                                                    Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"]?>','Est&aacute; seguro de querer eliminar estos registros',respPregunta)        
																				}
																		}
														},
														{
															text: 'Cancelar',
															handler:function()
																	{
																		ventana.close();
																	}
														}
													]
									}
								);
		ventana.show();
}

function crearTablaMaterial()
{
	var arrDatos=<?php echo $arregloPatrocinadores?>;
    
    var dSetMaestros= new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    
                                                                    {name:'codUnidad'},
                                                                    {name:'unidad'}
                                                                ]
                                                    }
                                                 )
    
	dSetMaestros.loadData(arrDatos);	
	var columnaCheck=new Ext.grid.CheckboxSelectionModel();	
	var cmMaestros= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            columnaCheck,
                                                            {
                                                                header:'Instituci&oacute;n',
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'unidad'
    
                                                            }
                                                        ]
                                                    );
											
												
	tblMaestros=	new Ext.grid.GridPanel	(
                                                    {
                                                    	x:10,
                                                        y:10,
														id:'tblMaestros',
                                                        store:dSetMaestros,
                                                        frame:true,
                                                        cm: cmMaestros,
                                                        sm:columnaCheck,
                                                        height:350,
                                                        width:550
															
													}
					
    											);
	return tblMaestros;
}