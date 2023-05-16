<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	
	$fechaActual=date("Y-m-d");
	$horaActual=date("H:i");
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
							mostrarVentanaAgregarParticipante(".$filaFigura[0].",'".cv($filaFigura[1])."');
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

	$consulta="SELECT id__35_denominacionDelito,denominacionDelito FROM _35_denominacionDelito ORDER BY denominacionDelito";
	$arrDelitos=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT id__34_tablaDinamica,tituloDelito FROM _34_tablaDinamica";
	$arrTitulos=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__35_tablaDinamica,capituloDelito FROM _35_tablaDinamica";
	$arrCapitulos=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__35_denominacionDelito,denominacionDelito FROM _35_denominacionDelito";
	$arrDenominacion=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT id__62_clasificacion,nombreModalidad FROM _62_clasificacion";
	$arrClasificacion=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__41_tablaDinamica,formaComision FROM _41_tablaDinamica";
	$arrFormaComision=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__42_tablaDinamica,modalidadDelito FROM _42_tablaDinamica";
	$arrModalidadDelito=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__43_tablaDinamica,gradoRealizacion FROM _43_tablaDinamica";
	$arrGrado=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__17_tablaDinamica,nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=50";
	$arrUnidadesAdulto=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT id__17_tablaDinamica,nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=49";
	$arrUnidadesAdolescentes=$con->obtenerFilasArreglo($consulta);
	
?>
var arrUnidadesAdolescentes=<?php echo $arrUnidadesAdolescentes?>;
var arrUnidadesAdulto=<?php echo $arrUnidadesAdulto?>;
var arrDelitos=<?php echo $arrDelitos?>;
var fechaActual='<?php echo $fechaActual?>';
var horaActual='<?php echo $horaActual ?>';
var arrTipoFigura=[<?php echo $arrParteProcesal?>];
var arrParteProcesal=arrTipoFigura;
var idActividad=<?php echo $idActividad?>;


var arrTitulos=<?php echo $arrTitulos?>;
var arrCapitulos=<?php echo $arrCapitulos?>;
var arrDenominacion=<?php echo $arrDenominacion?>;
var arrClasificacion=<?php echo $arrClasificacion?>;
var arrFormaComision=<?php echo $arrFormaComision?>;
var arrModalidadDelito=<?php echo $arrModalidadDelito?>;
var arrGrado=<?php echo $arrGrado?>;
var cadenaFuncionValidacion='funcionValidarGuardado';


function inyeccionCodigo()
{
	arrDelitos.push(['0','OTRO']);    
    if(esRegistroFormulario())
    {
    	loadScript('../modulosEspeciales_SGJP/Scripts/cParticipante.js.php', function()
                                                                            {
                                                                            }
                    )
                    
		loadScript('../Scripts/funcionesAjaxV2.js', function(){});
        
        
        gEx('ext__carpetaJudicialOrigenvch').on('select',function(cmb,registro)
        												{
                                                        	
                                                        }
        									)
        
        
        asignarEvento(gE('opt_materiaDestinovch_1'),'click',function(rdo)
         												{
                                                        	
                                                        	dispararEventoImputadoLibertad();
                                                            limpiarCombo(gE('_unidadGestionReceptoravch'));
                                                            llenarCombo(gE('_unidadGestionReceptoravch'),arrUnidadesAdulto,false);
                                                            
                                                            if(gE('opt_tipoUnidadDestinovch_5').checked)
                                                            {
                                                            	
                                                            	lanzarEvento(gE('opt_tipoUnidadDestinovch_5'),'click',gE('opt_tipoUnidadDestinovch_5'));
                                                            }
                                                            
                                                            if(gE('opt_tipoUnidadDestinovch_6').checked)
                                                            {
                                                            	lanzarEvento(gE('opt_tipoUnidadDestinovch_6'),'click',gE('opt_tipoUnidadDestinovch_6'));
                                                            }
                                                            
                                                            if(gE('opt_tipoUnidadDestinovch_12').checked)
                                                            {
                                                            	lanzarEvento(gE('opt_tipoUnidadDestinovch_12'),'click',gE('opt_tipoUnidadDestinovch_12'));
                                                            }
                                                        }
                       ) 
        
        asignarEvento(gE('opt_materiaDestinovch_2'),'click',function(rdo)
         												{
                                                        	
                                                        	dispararEventoImputadoLibertad();
                                                            limpiarCombo(gE('_unidadGestionReceptoravch'));
                                                            llenarCombo(gE('_unidadGestionReceptoravch'),arrUnidadesAdolescentes,false);
                                                            
                                                             if(gE('opt_tipoUnidadDestinovch_5').checked)
                                                            {
                                                            	
                                                            	lanzarEvento(gE('opt_tipoUnidadDestinovch_5'),'click',gE('opt_tipoUnidadDestinovch_5'));
                                                            }
                                                            
                                                            if(gE('opt_tipoUnidadDestinovch_6').checked)
                                                            {
                                                            	
                                                            	lanzarEvento(gE('opt_tipoUnidadDestinovch_6'),'click',gE('opt_tipoUnidadDestinovch_6'));
                                                            }
                                                            
                                                            if(gE('opt_tipoUnidadDestinovch_12').checked)
                                                            {
                                                            	
                                                            	lanzarEvento(gE('opt_tipoUnidadDestinovch_12'),'click',gE('opt_tipoUnidadDestinovch_12'));
                                                            }
                                                            
                                                        }
                       ) 
                
        asignarEvento(gE('opt_tipoExpedientevch_1'),'click',function(rdo)
         												{
                                                        	gE('sp_8511').innerHTML='En tr&aacute;mite';                                                        	
                                                            gEx('gDelitos').disable();
                                                        }
                       ) 
        
        asignarEvento(gE('opt_tipoExpedientevch_2'),'click',function(rdo)
         												{
                                                        	gE('sp_8511').innerHTML='En tr&aacute;mite';
                                                        	
                                                            gEx('gDelitos').enable();
                                                        }
                       ) 
        
        asignarEvento(gE('opt_tipoUnidadDestinovch_5'),'click',function(rdo)
         												{
                                                        	if((gE('opt_imputadoPrivadoLibertadvch_1').checked)||(gE('opt_imputadoPrivadoLibertadvch_2').checked))
                                                            {
                                                                gE('sp_8502').innerHTML='Tribunal de Enjuiciamiento receptor:';
                                                                mE('div_8504');
                                                                oE('div_8505');
                                                                gE('_unidadEjecucionReceptoravch').setAttribute('val','');
                                                                oE('div_8655');
                                                                gE('_unidadGestionReceptoravch').setAttribute('val','');
                                                            }
                                                            
                                                        }
                       )      
                       
		asignarEvento(gE('opt_tipoUnidadDestinovch_6'),'click',function(rdo)
         												{
                                                        	if((gE('opt_imputadoPrivadoLibertadvch_1').checked)||(gE('opt_imputadoPrivadoLibertadvch_2').checked))
                                                            {
                                                                gE('sp_8502').innerHTML='Unidad de Ejecuci&oacute;n receptora:';
                                                                oE('div_8504');
                                                                gE('_tribunalReceptorvch').setAttribute('val','');
                                                                oE('div_8655');
                                                                gE('_unidadGestionReceptoravch').setAttribute('val','');
                                                                mE('div_8505');
                                                            }
                                                        }                       
                       )
       
       	asignarEvento(gE('opt_tipoUnidadDestinovch_12'),'click',function(rdo)
         												{
                                                        	if((gE('opt_imputadoPrivadoLibertadvch_1').checked)||(gE('opt_imputadoPrivadoLibertadvch_2').checked))
                                                            {
                                                            	
                                                                gE('sp_8502').innerHTML='Unidad de Gesti&oacute;n receptora:';
                                                                oE('div_8504');
                                                                gE('_tribunalReceptorvch').setAttribute('val','');
                                                                oE('div_8505');
                                                                gE('_unidadEjecucionReceptoravch').setAttribute('val','');
                                                                mE('div_8655');
                                                            }
                                                        }                       
                       )
       
        asignarEvento(gE('opt_imputadoPrivadoLibertadvch_1'),'click',function(rdo)
         												{
                                                        	selElemCombo(gE('_unidadEjecucionReceptoravch'),'-1');
                                                            selElemCombo(gE('_tribunalReceptorvch'),'-1');
                                                            
                                                            if(gE('opt_materiaDestinovch_2').checked)
                                                            {
                                                            	selElemCombo(gE('_unidadEjecucionReceptoravch'),'4');
                                                            	selElemCombo(gE('_tribunalReceptorvch'),'5');
                                                            }
                                                           
                                                            if(gE('opt_tipoUnidadDestinovch_5').checked)
                                                            {
                                                            	oE('div_8505');
                                                                gE('_unidadEjecucionReceptoravch').setAttribute('val','');
                                                                oE('div_8655')
                                                                gE('_unidadGestionReceptoravch').setAttribute('val','');
                                                                mE('div_8504')
                                                                gE('_tribunalReceptorvch').setAttribute('val','obl');
                                                                
                                                            }
                                                            else
                                                            {
                                                            	if(gE('opt_tipoUnidadDestinovch_6').checked)
                                                            	{
                                                                    oE('div_8504')
                                                                    gE('_tribunalReceptorvch').setAttribute('val','');
                                                                    mE('div_8505');
                                                                	gE('_unidadEjecucionReceptoravch').setAttribute('val','obl');
                                                                    oE('div_8655')
                                                                	gE('_unidadGestionReceptoravch').setAttribute('val','');
                                                                }
                                                                else
                                                                	if(gE('opt_tipoUnidadDestinovch_12').checked)
                                                            		{
                                                                    	oE('div_8505');
                                                                		gE('_unidadEjecucionReceptoravch').setAttribute('val','');
                                                                        oE('div_8504')
                                                                    	gE('_tribunalReceptorvch').setAttribute('val','');
                                                                        mE('div_8655')
                                                                    	gE('_unidadGestionReceptoravch').setAttribute('val','obl');
                                                                    }
                                                            }
                                                        }                       
                       )
        
        asignarEvento(gE('opt_imputadoPrivadoLibertadvch_2'),'click',function(rdo)
         												{
                                                        	selElemCombo(gE('_unidadEjecucionReceptoravch'),'3');
                                                            selElemCombo(gE('_tribunalReceptorvch'),'4');
                                                            
                                                            if(gE('opt_materiaDestinovch_2').checked)
                                                            {
                                                            	selElemCombo(gE('_unidadEjecucionReceptoravch'),'4');
                                                            	selElemCombo(gE('_tribunalReceptorvch'),'5');
                                                            }
                                                            
                                                            if(gE('opt_tipoUnidadDestinovch_5').checked)
                                                            {
                                                            	oE('div_8505');
                                                                gE('_unidadEjecucionReceptoravch').setAttribute('val','');
                                                                oE('div_8655')
                                                                gE('_unidadGestionReceptoravch').setAttribute('val','');
                                                                mE('div_8504')
                                                                gE('_tribunalReceptorvch').setAttribute('val','obl');
                                                                
                                                            }
                                                            else
                                                            {
                                                            	if(gE('opt_tipoUnidadDestinovch_6').checked)
                                                            	{
                                                                    oE('div_8504')
                                                                    gE('_tribunalReceptorvch').setAttribute('val','');
                                                                    mE('div_8505');
                                                                	gE('_unidadEjecucionReceptoravch').setAttribute('val','obl');
                                                                    oE('div_8655')
                                                                	gE('_unidadGestionReceptoravch').setAttribute('val','');
                                                                }
                                                                else
                                                                	if(gE('opt_tipoUnidadDestinovch_12').checked)
                                                            		{
                                                                    	oE('div_8505');
                                                                		gE('_unidadEjecucionReceptoravch').setAttribute('val','');
                                                                        oE('div_8504')
                                                                    	gE('_tribunalReceptorvch').setAttribute('val','');
                                                                        mE('div_8655')
                                                                    	gE('_unidadGestionReceptoravch').setAttribute('val','obl');
                                                                    }
                                                                    else
                                                                    {
                                                                    	oE('div_8502');
                                                                    	oE('div_8505');
                                                                		gE('_unidadEjecucionReceptoravch').setAttribute('val','');
                                                                        oE('div_8504')
                                                                    	gE('_tribunalReceptorvch').setAttribute('val','');
                                                                        oE('div_8655')
                                                                    	gE('_unidadGestionReceptoravch').setAttribute('val','');
                                                                    }
                                                            }
                                                        }                       
                       )
                
        asignarEvento(gE('_lugarInternamientovch'),'change',function(cmb)
         												{
                                                        	selElemCombo(gE('_unidadEjecucionReceptoravch'),'-1');
                                                            selElemCombo(gE('_tribunalReceptorvch'),'-1');
                                                        	var opt=gE('_lugarInternamientovch').options[gE('_lugarInternamientovch').selectedIndex].value;
                                                        	switch(opt)
                                                            {
                                                            	case '00020001'://Reclusorio Norte
                                                                	selElemCombo(gE('_unidadEjecucionReceptoravch'),'1');
                                                            		selElemCombo(gE('_tribunalReceptorvch'),'1');
                                                                break;
                                                                case '00020002': //Reclusorio oriente
                                                                	selElemCombo(gE('_unidadEjecucionReceptoravch'),'2');
                                                            		selElemCombo(gE('_tribunalReceptorvch'),'3');
                                                                break;
                                                                case '00020004':
                                                                case '00020003': //Reclusorio sur
                                                                	selElemCombo(gE('_unidadEjecucionReceptoravch'),'2');
                                                            		selElemCombo(gE('_tribunalReceptorvch'),'2');
                                                                break;
                                                                case '00020008': //Santa martha
                                                                	selElemCombo(gE('_unidadEjecucionReceptoravch'),'2');
                                                            		selElemCombo(gE('_tribunalReceptorvch'),'2');
                                                                break;
                                                            }
                                                        }                       
                       )
        
        if(gE('idRegistroG').value=='-1')
        { 
            gEx('f_sp_fechaRecepciondte').setValue(fechaActual);
            
            gEx('f_sp_fechaRecepciondte').fireEvent('change', gEx('f_sp_fechaRecepciondte'), gEx('f_sp_fechaRecepciondte').getValue());
    
            
            gEx('f_sp_horaRecepciontme').setValue(horaActual);
            gEx('f_sp_horaRecepciontme').fireEvent('change', gEx('f_sp_horaRecepciontme'), gEx('f_sp_horaRecepciontme').getValue());
            gEN('_idActividadvch')[0].value=idActividad;
        }
        else
        {
        	idActividad=gEN('_idActividadvch')[0].value;
            
            if(gE('opt_tipoUnidadDestinovch_5').checked)
            {
            	oE('div_8505');
            }
            else
            {
            	oE('div_8504');
            }
            
            if(gE('opt_tipoUnidadDestinovch_5').checked)
            {
                
                lanzarEvento(gE('opt_tipoUnidadDestinovch_5'),'click',gE('opt_tipoUnidadDestinovch_5'));
            }
            else
            {
                if(gE('opt_tipoUnidadDestinovch_6').checked)
                {
                   lanzarEvento(gE('opt_tipoUnidadDestinovch_6'),'click',gE('opt_tipoUnidadDestinovch_6'));
                }
                else
                    if(gE('opt_tipoUnidadDestinovch_12').checked)
                    {
                        lanzarEvento(gE('opt_tipoUnidadDestinovch_12'),'click',gE('opt_tipoUnidadDestinovch_12'));
                    }
            }
            
            
        }
    }
    else
    {
    	idActividad=gEN('_idActividadvch')[0].value;
        
        if(gE('sp_8323').innerHTML=='No')
        {
        	oE('div_8500');
        }
        
        
        
        switch(gE('sp_8322').innerHTML)
        {
	        case 'Tribunal de Enjuiciamiento':
            	gE('sp_8502').innerHTML='Tribunal de Enjuiciamiento receptor:';
                oE('div_8655');
                oE('div_8505');
            break;
            case 'Unidad de Ejecución':
            	gE('sp_8502').innerHTML='Unidad de Ejecuci&oacute;n receptora:';
                oE('div_8655');
                oE('div_8504');
            break;
            case 'Unidad de Gestión Judicial':
            	gE('sp_8502').innerHTML='Unidad de Gesti&oacute;n receptora:';
                 oE('div_8505');
                 oE('div_8504');
            break;
        }
        
        
        if(gE('sp_8303').innerHTML=='Expediente de Juzgado Tradicional')
        {
        	oE('div_8511');
        }
        else
        {
        	oE('div_8316');
        }
        
        
    }
    
    
    gE('sp_8306').innerHTML='';
    
    
    
	crearGridParticipantes();
    crearGridDelitos();
    
    if(gE('opt_tipoExpedientevch_1'))
    {
        if(gE('opt_tipoExpedientevch_1').checked)
        {
            gEx('gDelitos').disable();
        }
	}    
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
                                                                width:500,
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
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gParticipantes',
                                                                store:alDatos,
                                                                width:900,
                                                                height:250,
                                                                renderTo:'sp_8306',
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

function mostrarVentanaDelito()
{
	var cmbDelito=crearComboExt('cmbDelito',arrDelitos,150,5,450);
    cmbDelito.on('select',function(cmb,registro)
    					{
                        	if(registro.data.id=='0')
                            {
                                gEx('lblEspecifique').show();
                                gEx('txtEspecifique').show();
                            }
                            else
                            {
                            	gEx('lblEspecifique').hide();
                                gEx('txtEspecifique').hide();
                                gEx('txtEspecifique').setValue('');
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
                                                            html:'Delito:'
                                                        },
                                                        cmbDelito,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            hidden:true,
                                                            id:'lblEspecifique',
                                                            html:'Especifique:'
                                                        },
                                                        {
                                                        	x:150,
                                                            y:35,
                                                            xtype:'textfield',
                                                            width:400,
                                                            hidden:true,
                                                            id:'txtEspecifique'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar delito',
										width: 650,
										height:160,
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
																		if(cmbDelito.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbDelito.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar el delito a agregar',resp)
                                                                        	return;
                                                                        }	
                                                                        
                                                                        var reg=crearRegistro	(			
                                                                        							[
                                                                                                    	{name: 'idRegistro'},
                                                                                                        {name: 'idReferencia'},
                                                                                                        {name:'delito', type:'string'},
                                                                                                        {name:'otroDelito', type:'string'}
                                                                                                    ]
                                                                        						)
																		var r=new reg	(
                                                                        					{
                                                                                            	idRegistro:-1,
                                                                                                idReferencia:-1,
                                                                                                delito:cmbDelito.getValue(),
                                                                                                otroDelito:gEx('txtEspecifique').getValue()
                                                                                            }
                                                                        				)                                                                                                
                                                                        gEx('grid_8212').getStore().add(r);
                                                                        ventanaAM.close();
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

function mostrarVentanaAgregarParticipante(iFigura,lblFigura)
{
	if(gE('opt_tipoExpedientevch_2').checked)
    {
    	agregarParticipante(iFigura,lblFigura);
    	return;
    }
    else
    {
    	if(gE('sp_8513').innerHTML=='')
        {
        	function resp()
            {
            	gEx('ext__carpetaJudicialOrigenvch').focus();
            }
        	msgBox('Debe indicar la Carpeta Judicial origen',resp);
        	return;
        }
    }
    
    var cmdNombreParte=crearComboExt('cmdNombreParte',[],150,5,350);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Nombre a agregar:'
                                                        },
                                                        cmdNombreParte,
                                                        {
                                                        	x:530,
                                                            y:10,
                                                            html:'<a href="javascript:addParticipante(\''+bE(iFigura)+'\',\''+bE(lblFigura)+'\')"><img src="../images/add.png" title="Agregar participante" alt="Agregar participante"/></a>'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar '+lblFigura,
										width: 650,
										height:130,
                                        id:'vAgregarParticipante',
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
																		var participante=cmdNombreParte.getValue();
                                                                        if(participante=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	participante.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar la perosna que desea agregar',resp);
                                                                        	return;
                                                                        }
                                                                        var gParticipantes=gEx('gParticipantes');
                                                                        var pos=obtenerPosFila(gParticipantes.getStore(),'idParticipante',participante);
                                                                        if(pos==-1)
                                                                        {
                                                                        	var cadObj='{"idActividad":"'+idActividad+'","idParticipante":"'+participante+'","tipoFigura":"'+iFigura+'"}';
                                                                        
                                                                        	function funcAjax()
                                                                            {
                                                                                var resp=peticion_http.responseText;
                                                                                arrResp=resp.split('|');
                                                                                if(arrResp[0]=='1')
                                                                                {
                                                                                    gParticipantes.getStore().reload();
                                                                                    ventanaAM.close();
                                                                                }
                                                                                else
                                                                                {
                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                }
                                                                            }
                                                                            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=223&cadObj='+cadObj,true);
                                                                       }                                                                         
                                                                       ventanaAM.close();
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

	obtenerPartesCarpeta(iFigura,ventanaAM);

}

function obtenerPartesCarpeta(iFigura,ventanaAM)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	gEx('cmdNombreParte').getStore().loadData(eval(arrResp[1]));
            ventanaAM.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=118&fJ='+iFigura+'&situacion=1&iA='+gE('sp_8513').innerHTML,true);
}

function addParticipante(iP,et)
{
	gEx('vAgregarParticipante').close();
	agregarParticipante(bD(iP),bD(et));
}


function crearGridDelitos()
{
	gE('sp_8514').innerHTML='';
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'tipoDelito'},
                                                        {name: 'capitulo'},
		                                                {name: 'denominacion'},
		                                                {name: 'modalidadDelito'},
                                                        {name: 'calificativo'},
                                                        {name: 'gradoRealizacion'},
                                                        {name: 'imputableA'}
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
                                                            sortInfo: {field: 'tipoDelito', direction: 'ASC'},
                                                            groupField: 'tipoDelito',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='9';
                                        proxy.baseParams.idActividad=idActividad;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            
                                                            {
                                                                header:'T&iacute;tulo de delito',
                                                                width:200,
                                                                sortable:true,
                                                                hidden:true,
                                                                dataIndex:'tipoDelito',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrTitulos,val));
                                                                        }
                                                            },
                                                            {
                                                                header:'Cap&iacute;tulo',
                                                                width:200,
                                                                sortable:true,
                                                                hidden:true,
                                                                dataIndex:'capitulo',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrCapitulos,val));
                                                                        }
                                                            },
                                                            {
                                                                header:'Delito',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'denominacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrDenominacion,val));
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Modalidad',
                                                                width:250,
                                                                sortable:true,
                                                                //hidden:true,
                                                                dataIndex:'modalidadDelito',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrClasificacion,val));
                                                                        }
                                                            },
                                                            {
                                                                header:'Calificativo',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'calificativo',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrModalidadDelito,val));
                                                                        }
                                                            },
                                                            {
                                                                header:'Grado de realizaci&oacute;n',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'gradoRealizacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrGrado,val));
                                                                        }
                                                            },
                                                            {
                                                                header:'Imputable a',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'imputableA',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gDelitos',
                                                                store:alDatos,
                                                                width:1050,
                                                                height:240,
                                                                renderTo:'sp_8514',
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
                                                                                text:'Agregar delito',
                                                                                handler:function()
                                                                                        {
                                                                                            var obj={};
                                                                                            var params=[['idActividad',idActividad],['idReferencia',-1],['idRegistro',-1],['idFormulario',61],['dComp','YWdyZWdhcg=='],['actor','MTEx']];
                                                                                            obj.ancho='90%';
                                                                                            obj.alto='95%';
                                                                                            obj.url='../modeloPerfiles/vistaDTDv3.php';
                                                                                            obj.params=params;
                                                                                            obj.titulo='Agregar delito';
																			                obj.modal=true;
                                                                                            window.parent.abrirVentanaFancy(obj);
                                                                                            
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:!esRegistroFormulario(),
                                                                                text:'Editar delito',
                                                                                handler:function()
                                                                                        {
                                                                                        	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                            
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el delito que desea modificar');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            var obj={};
                                                                                            var params=[['idRegistro',fila.data.idRegistro],['idFormulario',61],['dComp',bE('auto')],['actor',bE('257')]];
                                                                                            obj.ancho='90%';
                                                                                            obj.alto='95%';
                                                                                            obj.url='../modeloPerfiles/vistaDTDv3.php';
                                                                                            obj.params=params;
                                                                                            obj.titulo='Editar delito';
																			                obj.modal=true;
                                                                                            window.parent.abrirVentanaFancy(obj);
                                                                                            
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:!esRegistroFormulario(),
                                                                                text:'Remover delito',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=tblGrid.getSelectionModel().getSelected();
                                                                                            
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el delito que desea remover');
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
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=10&idRegistro='+fila.data.idRegistro,true);
                                                                                                    
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('¿Est&aacute; seguro de querer remover el delito seleccionado?',resp);
                                                                                            
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

function recargarGridDelitos()
{
	gEx('gDelitos').getStore().reload();
}


function dispararEventoImputadoLibertad()
{
	if(gE('opt_imputadoPrivadoLibertadvch_1').checked)
    {
    	lanzarEvento(gE('opt_imputadoPrivadoLibertadvch_1'),'click',gE('opt_imputadoPrivadoLibertadvch_1'));
    }
    else
    {
    	lanzarEvento(gE('opt_imputadoPrivadoLibertadvch_2'),'click',gE('opt_imputadoPrivadoLibertadvch_2'));
    }
}

function funcionValidarGuardado()
{
	var gParticipantes=gEx('gParticipantes');
    if(gParticipantes.getStore().getCount()==0)
    {
    	msgBox('Debe ingresar almenos una parte jur&iacute;dica del expediente');
    	return false;
    }	
	return true;
}