<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	
	$fechaActual=date("Y-m-d");
	$horaActual=date("H:i");
	$anioActual=date("Y");
	$consulta="SELECT MAX(noOficio) FROM _534_tablaDinamica WHERE codigoInstitucion='".$_SESSION["codigoInstitucion"]."' AND anio='".$anioActual."'";
	$noOficio=$con->obtenerValor($consulta);
	if($noOficio=="")
		$noOficio=0;
	$noOficio++;
?>
var pasaValidacionOficio=false;
var noOficio='<?php echo $noOficio?>';
var cadObjBusqueda='';
var fechaActual='<?php echo $fechaActual?>';
var horaActual='<?php echo $horaActual ?>';

function inyeccionCodigo()
{

	if(esRegistroFormulario())
    {
    	
        
        if(gE('idRegistroG').value=='-1')
        {
            gEx('f_sp_fechaOficiodte').setValue(fechaActual);        
            gEx('f_sp_fechaOficiodte').fireEvent('change', gEx('f_sp_fechaOficiodte'), gEx('f_sp_fechaOficiodte').getValue());
            gEx('f_sp_fechaEntregadte').setValue(fechaActual);
            gEx('f_sp_fechaEntregadte').fireEvent('change', gEx('f_sp_fechaEntregadte'), gEx('f_sp_fechaEntregadte').getValue());
            gE('_noOficioint').value=noOficio;
            
        }
        
       asignarEvento(gE('_noOficioint'),'change',buscarNoOficio);

    }
    else
    {
    	if(gE('sp_9071').innerHTML=='No')
        {
        	oE('div_9072');
            oE('div_9073');
        }
        
        
	}
    
    
    
    
    
    
	
}  


function buscarNoOficio()
{
	var cadObj='{"idRegistro":"'+gE('idRegistroG').value+'","folio":"'+gE('_noOficioint').value+'","anio":"<?php echo $anioActual?>"}';
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var aCoincidencias=eval(arrResp[1]);
        	if(aCoincidencias.length>0)
            {
            	mostrarVentanaCoincidenciaOficio(aCoincidencias);
            	
        	}
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Juzgados.php',funcAjax, 'POST','funcion=13&cadObj='+cadObj,true);
    
}


function mostrarVentanaCoincidenciaOficio(arrRegistros)
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
                                                            html:'Se ha detectado que el folio ingresado ya ha sido registrado anteriormente, a continuación se listan las coincidencias encontradas:'
                                                        },
                                                        crearGridFoliosEncontrados(arrRegistros),
                                                        {
                                                        	x:10,
                                                            y:320,
                                                            html:'Desea continuar usando el folio a pesar de esto?'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Folio de oficio encontrado',
										width: 800,
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
															
															text: 'S&iacute;',                                                            
															handler: function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															text: 'No',
															handler:function()
																	{
                                                                    	gE('_noOficioint').value='';
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	
}


function crearGridFoliosEncontrados(arrRegistros)
{
	var dsDatos=arrRegistros;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idRegistro'},
                                                                    {name: 'dirigidoA'},
                                                                    {name: 'fechaOficio',format:'date', dateFormat:'Y-m-d'},
                                                                    {name: 'noOficio'},
                                                                    {name: 'asunto'},
                                                                    {name: 'carpetaAdministrativa'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'No. Expediente',
															width:120,
															sortable:true,
															dataIndex:'carpetaAdministrativa'
														},
														{
															header:'No. Oficio',
															width:120,
															sortable:true,
															dataIndex:'noOficio'
														},
														{
															header:'Fecha de Oficio',
															width:120,
															sortable:true,
															dataIndex:'fechaOficio',
                                                            renderer:function(val)
                                                            		{
                                                                    	return val.format('d/m/Y');
                                                                    }
														},
														{
															header:'Dirigido a',
															width:400,
															sortable:true,
															dataIndex:'dirigidoA',
                                                            renderer:mostrarValorDescripcion
														},
														{
															header:'Asunto',
															width:350,
															sortable:true,
															dataIndex:'asunto',
                                                            renderer:mostrarValorDescripcion
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
                                                            columnLines : true,
                                                            height:260,
                                                            width:750,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;	
}
