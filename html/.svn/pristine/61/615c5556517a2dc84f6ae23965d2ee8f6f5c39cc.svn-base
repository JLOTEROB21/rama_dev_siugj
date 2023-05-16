<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);
	
	$consulta="SELECT codigoInstitucion,numeracionExpediente,tiposAsuntosRecibidos FROM _478_tablaDinamica WHERE id__478_tablaDinamica=".$idReferencia;	
	$fRegistro=$con->obtenerPrimeraFila($consulta);

	$juzgado=$fRegistro[0];
	$numeracionExpediente=$fRegistro[1];
	$idMagistrado=-1;
	$nombreMagistrado='';
	$consulta="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$fRegistro[0]."'";
	$idJuzgado=$con->obtenerValor($consulta);
	
	$consulta="SELECT claveElemento,nombreElemento FROM 1018_catalogoVarios WHERE tipoElemento=30";
	$arrSufijos=$con->obtenerFilasArreglo($consulta);
	
	$prefijo="";
	switch($fRegistro[2])
	{
		case 1://Controversia Constitucional
			$prefijo="CC";
		break;
		case 2://Acción de Inconstitucionalidad
			$prefijo="AI";
		break;
		case 3://Acción por Omisión Legislativa
			$prefijo="OL";
		break;
		case 4://Acción de Cumplimiento en Contra de las Personas Titulares de los Poderes Públicos, los Organismos Autónomos y las Alcaldías
			$prefijo="AC";
		break;
		case 5://Impugnación de Resoluciones Definitivas Dictadas por Jueces de Tutela
			$prefijo="";
		break;
		case 6://Impugnación que se Presenta en el Desarrollo del Procedimiento de Referendum para Declarar la Procedencia, Periodicidad y Validez de Éste
			$prefijo="R";
		break;
		case 7://Revisión de Jueces de Tutela
			$prefijo="IJT";
		break;
		case 8://Acción Consultiva Solicitada
			$prefijo="FC";
		break;
		case 9://Acción Efectiva de Derechos Humanos
			$prefijo="AE";
		break;
		case 10://PROTECCIÓN DERECHOS PUEBLOS INDÍGENAS
			$prefijo="PO";
		break;
	}
	
?>
var prefijo='<?php echo $prefijo?>';
var numeracionExpediente='<?php echo $numeracionExpediente?>';
var arrSufijos=<?php echo $arrSufijos?>;

var existeAudiencia=false;
var anio='<?php echo date("Y")?>';
var juzgado='<?php echo $juzgado?>';
var cadenaFuncionValidacion='validarExistenciaExpediente';
function inyeccionCodigo()
{
	gE('sp_9066').innerHTML=prefijo;
	if(esRegistroFormulario())
    {
    	if(gE('idRegistroG').value=='-1')
        {
        	
        	selElemCombo(gE('_anioExpedientevch'),anio);
        }
        else
        {
        	if((numeracionExpediente!='')&&(parseInt(numeracionExpediente)>1))
            {
            	mE('div_9020');
               	gE('sp_9020').innerHTML='<span class="TSJDF_Control">'+formatearValorRenderer(arrSufijos,numeracionExpediente)+'</span>'
            }
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
    }
    else
    {
    	oE('div_9012');
    	var folio=rellenarCadena(gE('_noExpedienteint').innerHTML,4,'0',-1);
    	gE('_noExpedienteint').innerHTML=folio;
        if(parseInt(gE('sp_9012').innerHTML)>1)
        {
        	gE('sp_9020').innerHTML=formatearValorRenderer(arrSufijos,gE('sp_9012').innerHTML);
        }
        else
        {
        	gE('sp_9020').innerHTML='';
        }
    }
   
}

function validarExpediente()
{
	var noExpediente=gE('_noExpedienteint').value;
    var anioExpediente=gE('_anioExpedientevch').options[gE('_anioExpedientevch').selectedIndex].value;
    oE('div_9020');
    oE('div_9021');
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
                gEN('_numeracionExpedientevch')[0].value=1;
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
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_Juzgados.php',funcAjax, 'POST','funcion=5&iR=<?php echo $idReferencia?>&j='+juzgado+'&prefijo='+(prefijo+gE('_noAccionint').value)+'&nE='+noExpediente+'&anio='+anioExpediente,true);
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
                                                        crearGridCoincidenciasExpediente(arrDatos),
                                                        {
                                                        	x:10,
                                                            y:340,
                                                            html:'<b>Desea continuar registrado el Expediente a pesar de lo anterior (Se asignar&aacute; un sufijo de diferenciaci&oacute;n)?</b>'
                                                        }
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
														{
															
															text: 'S&iacute;',                                                            
															handler: function()
																	{
                                                                    	gEN('_numeracionExpedientevch')[0].value=noExpediente;
                                                                    	mE('div_9020');
                                                                        gE('div_9020').innerHTML='<span class="TSJDF_Control">'+formatearValorRenderer(arrSufijos,noExpediente)+'</span>'
																		ventanaAM.close();
																	}
														},
														{
															text: 'No',
															handler:function()
																	{
                                                                    	oE('div_9020');
                                                                    	gE('_noExpedienteint').value='';
																		ventanaAM.close();
																	}
														}
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



  

