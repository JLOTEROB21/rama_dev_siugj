<?php session_start();
include("conexionBD.php"); 
include("configurarIdiomaJS.php");
$idFormulario=bD($_GET["idFormulario"]);
$consulta="select idProceso from 900_formularios where idFormulario=".$idFormulario;
$idProceso=$con->obtenerValor($consulta);
$consulta="select idEtapa,nombreEtapa,numEtapa from 4037_etapas where idProceso=".$idProceso." order by numEtapa";
$resEtapa=$con->obtenerFilas($consulta);
$arrEtapas="";
while($filaEtapa=mysql_fetch_row($resEtapa))
{
	$objEtapa="['".$filaEtapa[0]."','".removerCerosDerecha($filaEtapa[2]).".- ".$filaEtapa[1]."']";
	if($arrEtapas=="")
		$arrEtapas=$objEtapa;
	else
		$arrEtapas.=",".$objEtapa;
}
$arrEtapas="[".$arrEtapas."]";

$aEtapas=substr($arrEtapas,1);
echo "var arrEtapas=[['-1','No enviar a etapa'],".($aEtapas).";";
?>

function mostrarVentanaDisparadorCmbRadio()
{
	var gridElementos=crearGridElementosCombo();

	var form = new Ext.form.FormPanel(	
												{
													baseCls: 'x-plain',
													layout:'absolute',
													defaultType: 'textfield',
													items: [gridElementos]
												}
											);

	
	var ventanaDisparador = new Ext.Window(
											{
												title: 'Ingresar disparador',
												width: 500,
												height:340,
												minWidth: 300,
												minHeight: 100,
												layout: 'fit',
												plain:true,
												modal:true,
												bodyStyle:'padding:5px;',
												buttonAlign:'center',
												items: form,
												buttons:	[
																{
																	id:'btnAceptar',
																	text: '<?php echo $etj["lblBtnAceptar"] ?>',
																	listeners:	{
																					click:function()
																						{
																							ventanaDisparador.close();
																							
																						}
																				}
																}
															]
											}
										);

	cargarValoresCombo(gridElementos.getStore(),h.idControlSel,ventanaDisparador);		
}

function cargarValoresCombo(dataSet,idGrupoElemento,ventana)
{
	
    function funcResp()
    {
        arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
        {
        	dataSet.loadData(eval(arrResp[1]));   
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=19&idGrupoElemento='+idGrupoElemento,true);
	ventana.show();
}

function crearGridElementosCombo()
{
	
	var dsNameDTD= 	[];					
    var alNameDTD=		new Ext.data.SimpleStore(
    											{
    												fields:	[
                                                    			{name: 'idGrupoElemento'},
    															{name: 'idValorOpcion'},
                                                                {name: 'valorOpcion'},
																{name: 'etapa'}
    														]
    											}
    										);
    alNameDTD.loadData(dsNameDTD);
	
	var comboEtapas=crearComboEtapas();
    
    
	var colM= new Ext.grid.ColumnModel   	(
												 	[
													 	{
															header:'Valor opci&oacute;n',
															width:150,
															dataIndex:'valorOpcion'
														},
														{
															header:'Enviar a etapa',
															width:300,
															dataIndex:'etapa',
                                                            editor:comboEtapas,
                                                            renderer:renderizarEtapa
														}
													]
												);
											
	eGrid=	new Ext.grid.EditorGridPanel	(
                                                    {
                                                    	id:'gridEtapas',
                                                        store:alNameDTD,
                                                        frame:true,
                                                        clicksToEdit: 1,
                                                        cm: colM,
                                                        height:250,
                                                        width:470
                                                    }
							                    );
	
    eGrid.on('afteredit',funcCambio);
    
	return eGrid;	
}	

function funcCambio(e)
{
	var obj='{"idGrupoElemento":"'+e.record.get('idGrupoElemento')+'","idFormulario":"'+idFormulario+'","idEtapa":"'+e.value+'","idValor":"'+e.record.get('idValorOpcion')+'"}';
	
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
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=20&param='+obj,true);
}

function crearComboEtapas(id)
{
	var idCombo='idComboEtapas';
    if(id!=undefined)
    	idCombo=id;
	
	var dsDatos= new Ext.data.SimpleStore	(
													{
														fields:	[
																	{name:'id'},
																	{name:'tipo'}
																]
													}
												);
	dsDatos.loadData(arrEtapas);
	var comboEtapas=document.createElement('select');
	var cmbEtapas=new Ext.form.ComboBox	(
													{
														id:idCombo,
														mode:'local',
														emptyText:'Elija una opci\xF3n',
														store:dsDatos,
														displayField:'tipo',
														valueField:'id',
														transform:comboEtapas,
														editable:false,
														typeAhead: true,
														triggerAction: 'all',
														lazyRender:true,
                                                        width:120
													}
												)
	return cmbEtapas;	
}

function renderizarEtapa(valor)
{

	var x;
    for(x=0;x<arrEtapas.length;x++)
    {
    	if(arrEtapas[x][0]==valor)
        {
        	return arrEtapas[x][1];
        }
    }
	return '-1';
}
