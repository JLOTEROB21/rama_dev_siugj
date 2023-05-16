<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$fechaActual=date("Y-m-d");
	$horaActual=date("H:i");
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	
	
	$consulta="SELECT id__5_tablaDinamica,nombreTipo FROM _5_tablaDinamica where 
			id__5_tablaDinamica in	(2,4,5,6,100) order by nombreTipo";
	$arrTipoFigura=$con->obtenerFilasArreglo($consulta);
	$listParteProcesal="";
	$arrParteProcesal="";
	$arrPartes="";
	$res=$con->obtenerFilas($consulta);
	while($filaFigura=mysql_fetch_row($res))
	{
		if($listParteProcesal=="")
			$listParteProcesal=$filaFigura[0];
		else
			$listParteProcesal.=",".$filaFigura[0];
		$consulta="SELECT idDetalle,etiquetaDetalle FROM _5_gDetallesTipo WHERE idReferencia=".$filaFigura[0];
		$arrDetalles=$con->obtenerFilasArreglo($consulta);
		$consulta="SELECT idOpcion FROM _5_tiposFiguras WHERE idPadre=".$filaFigura[0];
		$listFiguras=$con->obtenerListaValores($consulta);
		$o="['".$filaFigura[0]."','".cv($filaFigura[1])."',".$arrDetalles.",'".$listFiguras."']";
		if($arrParteProcesal=="")
			$arrParteProcesal=$o;
		else
			$arrParteProcesal.=",".$o;
		
		$o="{
				cls:'x-btn-text-icon',
				text:'".$filaFigura[1]."',
				handler:function()
						{
							agregarParticipante(".$filaFigura[0].",'".cv($filaFigura[1])."');
						}
				
			}";
		if($arrPartes=="")
			$arrPartes=$o;
		else			
			$arrPartes.=",".$o;
	}
	
	
	
	
	
	$arrPartes="[".$arrPartes."]";
	$idActividad=-1;
	
	if($idRegistro==-1)
		$idActividad=generarIDActividad($idFormulario);

	$numeracionExpediente="";
	$juzgado=$_SESSION["codigoInstitucion"];
	if($idRegistro!=-1)
	{
		$consulta="SELECT codigoInstitucion FROM _478_tablaDinamica WHERE id__478_tablaDinamica=".$idRegistro;	
		$fRegistro=$con->obtenerPrimeraFila($consulta);
		$juzgado=$fRegistro[0];
		
	}
	$consulta="SELECT claveElemento,nombreElemento FROM 1018_catalogoVarios WHERE tipoElemento=30";
	$arrSufijos=$con->obtenerFilasArreglo($consulta);
?>

var arrSufijos=<?php echo $arrSufijos?>;
var juzgado='<?php echo $juzgado?>';
var existeAudiencia=false;
var anio='<?php echo date("Y")?>';
var arrTipoFigura=[<?php echo $arrParteProcesal?>];
var arrParteProcesal=arrTipoFigura;
var idActividad=<?php echo $idActividad?>;
var cadenaFuncionValidacion='validarExistenciaExpediente';

function inyeccionCodigo()
{
	if(esRegistroFormulario())
    {
    	loadScript('../modulosEspeciales_SGJP/Scripts/cParticipante.js.php', function()
    																		{
                                                                            }
					)
    	loadScript('../Scripts/funcionesAjaxV2.js', function(){});
        if(gE('idRegistroG').value=='-1')
        {
            gEN('_idActividadvch')[0].value=idActividad;
            var _juezvch=gE('_juezvch');
            if(_juezvch.options.length==2)
            	_juezvch.selectedIndex=1;
            
            selElemCombo(gE('_anioExpedientevch'),anio);
            
            if(gEx('f_sp_fechaRecepciondte'))
            {
             	gEx('f_sp_fechaRecepciondte').setValue('<?php echo $fechaActual?>');
             
             	gEx('f_sp_fechaRecepciondte').fireEvent('change', gEx('f_sp_fechaRecepciondte'), gEx('f_sp_fechaRecepciondte').getValue());
             	gEx('f_sp_fechaRecepciondte').fireEvent('select', gEx('f_sp_fechaRecepciondte'));
             }
             if(gEx('f_sp_horaRecepciontme'))
             {
	             gEx('f_sp_horaRecepciontme').setValue('<?php echo $horaActual?>');
             	gEx('f_sp_horaRecepciontme').fireEvent('change', gEx('f_sp_horaRecepciontme'), gEx('f_sp_horaRecepciontme').getValue());
             }
            
        }
        else
        {
            idActividad=gEN('_idActividadvch')[0].value;
            
         }  
         
         
         for(x=0;x<gE('_anioExpedientevch').options.length;x++)
         {
         	if(parseInt(gE('_anioExpedientevch').options[x].value)>parseInt(anio))
            {
            	gE('_anioExpedientevch').options[x]=null;
            	x--;
            }
         }
          
		gE('_noExpedienteint').setAttribute('maxlength',4);          
        if(gE('sp_7558').innerHTML=='En trámite')
        {
			<?php 
				if(existeRol("'151_0'"))
				{
					echo "oE('sp_7552');";
					echo "oE('sp_7553');";
					echo "oE('div_7562');";
					echo "gE('_juezvch').setAttribute('val','');";
					echo "oE('div_7563');";
					echo "gE('_secretariovch').setAttribute('val','');";
				}
			?>            
        }   
        
        
        asignarEvento(gE('_noExpedienteint'),'change',function()
                                                    {
                                                        validarExpediente();
                                                    }
                                    );                     
                        
         asignarEvento(gE('_anioExpedientevch'),'change',function()
                                                    {
                                                        validarExpediente();
                                                    }
                                    );   
         
         
         
         asignarEvento(gE('opt_tipoExpedientevch_1'),'click',function()
                                                    {
                                                       gE('sp_7547').innerHTML='Registro de Expediente';
                                                       gE('sp_7554').innerHTML='No. de Expediente:';
                                                       
                                                       
                                                    }
                                    );   
        
        asignarEvento(gE('opt_tipoExpedientevch_2'),'click',function()
                                                    {
                                                     	gE('sp_7547').innerHTML='Registro de Exhorto';   
                                                        gE('sp_7554').innerHTML='No. de Exhorto:';
                                                    }
                                    ); 
         
	}
    else
    {
    	idActividad=gEN('_idActividadvch')[0].value;
        if(gE('sp_7562').innerHTML=='')
        	gE('sp_7562').innerHTML='<span class="TSJDF_Control">POR DESIGNAR</span>';
         if(gE('sp_7563') && gE('sp_7563').innerHTML=='')
        	gE('sp_7563').innerHTML='<span class="TSJDF_Control">POR DESIGNAR</span>';
            
            
    	
	}
    
    if(gE('sp_7569'))
	    gE('sp_7569').innerHTML='';
    
    
    
	crearGridParticipantes();
}  

function validarExpediente()
{
	var noExpediente=gE('_noExpedienteint').value;
    var anioExpediente=gE('_anioExpedientevch').options[gE('_anioExpedientevch').selectedIndex].value;
    oE('div_7584');
    function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrRegistros=eval(arrResp[1]);
        	if(arrRegistros.length=='0')
            {
            	
                existeAudiencia=false;
                
            }
            else
            {
            
            	mostrarVentanaCoincidenciasExpediente(arrRegistros,arrResp[2]);
            	existeAudiencia=false;
               
           	}
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_Juzgados.php',funcAjax, 'POST','funcion=5&iR='+gE('idRegistroG').value+'&j='+juzgado+'&nE='+noExpediente+'&anio='+anioExpediente,true);
}


function mostrarVentanaCoincidenciasExpediente(arrDatos,noExpediente)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'<b>Se han encontrado los siguientes Expedientes que pudieran ser el mismo que el que intenta registrar:</b>'
                                                        },
                                                        crearGridCoincidenciasExpediente(arrDatos)
                                                        <?php
														if($tipoMateria=="SC")
														{
														?>
                                                        ,
                                                        {
                                                        	x:10,
                                                            y:340,
                                                            html:'<b>Desea continuar registrado el Expediente a pesar de lo anterior (Se asignar&aacute; un sufijo de diferenciaci&oacute;n)?</b>'
                                                        }
                                                        <?php
														}
														?>
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Posibles Expedientes repetidos',
										width: 700,
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
                                        				<?php
														if($tipoMateria=="SC")
														{
														?>
														{
															
															text: 'S&iacute;',                                                            
															handler: function()
																	{
                                                                    	
                                                                    	mE('div_7584');
                                                                        gE('sp_7584').innerHTML='<span style="color">'+formatearValorRenderer(arrSufijos,noExpediente)+'</span>'
																		ventanaAM.close();
																	}
														},
														{
															text: 'No',
															handler:function()
																	{
                                                                    	oE('div_7584');
                                                                    	gE('_noExpedienteint').value='';
																		ventanaAM.close();
																	}
														}
                                                        <?php
														}
														else
														{
														?>
                                                        {
															
															text: 'Aceptar',                                                            
															handler: function()
																	{
                                                                    	
                                                                    	oE('div_7584');
                                                                    	gE('_noExpedienteint').value='';
																		ventanaAM.close();
																	}
														}
                                                        <?php
														}
														?>
													]
									}
								);
	ventanaAM.show();	
}


function crearGridCoincidenciasExpediente(dsDatos)
{


    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name:'noFolio'},
                                                                    {name: 'mensaje'},
                                                                    {name:'idFormulario'},
                                                                    {name: 'idRegistro'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
                                                        {
                                                        	header:'',
															width:30,
															sortable:true,
															dataIndex:'idFormulario',
                                                            renderer:function(val,meta,registro)
                                                                        {
                                                                        	return '<a href="javascript:abrirFormularioAsociado(\''+bE(val)+'\',\''+bE(registro.data.idRegistro)+'\')"><img src="../images/magnifier.png" title="Ver registro" alt="Ver registro"/></a>';
                                                                        }
                                                        },
														{
															header:'',
															width:600,
															sortable:true,
															dataIndex:'mensaje',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	meta.attr='style="min-height:21px;height:auto;white-space: normal;';
                                                                    	return mostrarValorDescripcion(val);
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
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            id:'gCoincidenciasRegistro',
                                                            columnLines : true,
                                                            height:280,
                                                            width:650
                                                        }
                                                    );
	return 	tblGrid;	
    
}

function crearGridParticipantes()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idParticipante'},
		                                                {name: 'nombreParticipante'},
		                                                {name:'figura'},
		                                                {name:'relacion'},
                                                        {name:'idRegistro'}
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
                                                            sortInfo: {field: 'figura', direction: 'ASC'},
                                                            groupField: 'figura',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='1';
                                        proxy.baseParams.idActividad=idActividad;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'idRegistro',
                                                                align:'center',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if(!esRegistroFormulario())
                                                                            	return;
                                                                        	return '<a href="javascript:editarParte(\''+bE(registro.data.figura)+'\',\''+bE(val)+'\')"><img src="../images/pencil.png" title="Editar parte" alt="Editar parte"></a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Nombre de la parte',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'nombreParticipante',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Calidad',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'figura',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrTipoFigura,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Relacionado con:',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'relacion',
                                                                renderer:function(val,meta,registro)
                                                                		{	
                                                                        	meta.attr='style="height:auto !important;line-height:21px;"';
                                                                        	return mostrarValorDescripcion(val);
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gParticipantes',
                                                                store:alDatos,
                                                                width:900,
                                                                height:280,
                                                                renderTo:'sp_7569',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,  
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:!esRegistroFormulario(),
                                                                                text:'Agregar parte...',
                                                                                menu:	<?php echo $arrPartes?>
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover parte',
                                                                                hidden:!esRegistroFormulario(),
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=tblGrid.getSelectionModel().getSelected();
                                                                                            
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la parte que desea remover');
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
                                                                                                            tblGrid.getStore().reload();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=8&figuraJuridica='+fila.data.figura+'&idRegistro='+fila.data.idRegistro,true);
                                                                                                    
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('¿Est&aacute; seguro de querer remover la parte seleccionada?',resp);
                                                                                        }
                                                                                
                                                                            }
                                                                		],                                                              
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :true,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: true,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;
}


function agregarParticipante(f,parte)
{
	var objConf={};
    objConf.ocultaIdentificacion=true;
    objConf.idActividad=idActividad;
    objConf.idCarpeta=-1;
    objConf.ocultaCURP=true;
    objConf.ocultaRFC=true;
    objConf.afterRegister=recargarGridParticipantes;
	agregarParticipanteVentana(f,parte,objConf)
	
}   

function recargarGridParticipantes()
{
	gEx('gParticipantes').getStore().reload();
}


function editarParte(f,iR)
{
	var objConf={};
    objConf.ocultaIdentificacion=true;
    objConf.idActividad=idActividad;
    objConf.idCarpeta=-1;
    objConf.afterRegister=recargarGridParticipantes;
    objConf.idParticipante=bD(iR);
    var pos=existeValorMatriz(arrTipoFigura,bD(f));
    var parte=arrTipoFigura[pos][1];
	agregarParticipanteVentana(bD(f),parte,objConf)
  
}

function validarExistenciaExpediente()
{
	if(existeAudiencia)
    {
    	msgBox('El No. de Expediente ha sido registrado previamente !!!');
    	return false;
    }
    return true;
}

function abrirFormularioAsociado(iF,iR)
{
	window.parent.abrirFormularioProcesoFancy((iF),(iR),bE(0))
}