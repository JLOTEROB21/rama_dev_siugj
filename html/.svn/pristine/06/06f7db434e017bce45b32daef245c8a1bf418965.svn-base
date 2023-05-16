<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	
	$esRegistroAdolescentes=esRegistroAdolescentes($idFormulario,$idRegistro);
	
	$consulta="SELECT id__5_tablaDinamica,nombreTipo FROM _5_tablaDinamica";
	if($esRegistroAdolescentes==1)
		$consulta="SELECT id__5_tablaDinamica,if(id__5_tablaDinamica=4,'Menor',nombreTipo) as nombreTipo FROM _5_tablaDinamica";
	$arrTipoFigura=$con->obtenerFilasArreglo($consulta);
	
	$idActividad=-1;
	$consulta="SELECT id__33_tablaDinamica,tipoPersona FROM _33_tablaDinamica";
	$arrTipoPersona=$con->obtenerFilasArreglo($consulta);
	if($idRegistro==-1)
		$idActividad=generarIDActividad($idFormulario);


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
	
	$consulta="SELECT claveElemento,nombreElemento FROM 1018_catalogoVarios WHERE tipoElemento=13";
	$arrTipoDefensor=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT valor,texto FROM 1004_siNo";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	
	
	
	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
	
	
	$consulta="SELECT id__5_tablaDinamica,nombreTipo FROM _5_tablaDinamica where 
			id__5_tablaDinamica in	(2,4,5,6,100) order by nombreTipo";
			
	if($esRegistroAdolescentes==1)
		$consulta="SELECT id__5_tablaDinamica,if(id__5_tablaDinamica=4,'Menor',nombreTipo) as nombreTipo  FROM _5_tablaDinamica where 
			id__5_tablaDinamica in	(2,4,5,6,100,12) order by nombreTipo";
					
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
	
	$consulta="SELECT id__35_denominacionDelito,denominacionDelito FROM _35_denominacionDelito ORDER BY denominacionDelito";
	$arrDelitos=$con->obtenerFilasArreglo($consulta);
?>

var arrDelitos=<?php echo $arrDelitos?>;
var esRegistroAdolescentes=<?php echo $esRegistroAdolescentes?>;
var arrSiNo=<?php echo $arrSiNo?>;
var arrTipoDefensor=<?php echo $arrTipoDefensor?>;
var idActividad=<?php echo $idActividad?>;
var arrTipoFigura=<?php echo $arrTipoFigura?>;
var arrTipoPersona=<?php echo $arrTipoPersona?>;

var arrTitulos=<?php echo $arrTitulos?>;
var arrCapitulos=<?php echo $arrCapitulos?>;
var arrDenominacion=<?php echo $arrDenominacion?>;
var arrClasificacion=<?php echo $arrClasificacion?>;
var arrFormaComision=<?php echo $arrFormaComision?>;
var arrModalidadDelito=<?php echo $arrModalidadDelito?>;
var arrGrado=<?php echo $arrGrado?>;


/*var cadenaFuncionValidacion='';*/

function inyeccionCodigo()
{
	if(esRegistroFormulario())
    {
    	gE('sticky').style='z-index:998';
        loadScript('../modulosEspeciales_SGJP/Scripts/cParticipante.js.php', function()
                                                                            {
                                                                            }
                    )
        loadScript('../Scripts/funcionesAjaxV2.js', function(){});
        
        loadCSS('../Scripts/classNotify/jquery.classynotty.css', function(){});
        loadScript('../Scripts/classNotify/jquery.classynotty.js', function(){});
        if(gE('idRegistroG').value=='-1')
            gEN('_idActividadvch')[0].value=idActividad;
        else
            idActividad=gEN('_idActividadvch')[0].value;
            
        if(gE('idRegistroG').value=='-1')
        {
        	switch(esRegistroAdolescentes)
            {
                case 1:
                    
                    gE('opt_materiaDestinovch_2').checked=true;
                    selOpcion(gE('opt_materiaDestinovch_2'));
                break;
                case 0:
                    
                    gE('opt_materiaDestinovch_1').checked=true;
					selOpcion(gE('opt_materiaDestinovch_1'));
                break;
                
                
            }
            
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
            
        if(gEN('_carpetaRemitidavch')[0]    .value=='')
        {
	         oE('div_4185');
             oE('div_4186');
        }
        
        oE('div_791');
        oE('div_1142');
        oE('div_983');
        oE('div_1173');
        
	}
    else
    {
    	idActividad=gEN('_idActividadvch')[0].value;
        if(gE('sp_4186').innerHTML=='')
        {
            oE('div_4185');
        }
    
        if(!gE('divTexto_8987')||(gE('divTexto_8987').innerHTML==''))
        {
            oE('div_8986');
        }
    }
    	
    
    gE('sp_1081').innerHTML='';
    
    


    crearGridParticipantes();
    
	
    crearGridDelitos(); 

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
                                                                height:350,
                                                                renderTo:'sp_1081',
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
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=8&idActividad='+idActividad+'&figuraJuridica='+fila.data.figura+'&idRegistro='+fila.data.idRegistro,true);
                                                                                                    
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


function crearGridDelitos()
{
	gE('sp_1125').innerHTML='';
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
                                                                renderTo:'sp_1125',
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
                                                                        gEx('grid_8207').getStore().add(r);
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

function recargarGridDelitos()
{
	gEx('gDelitos').getStore().reload();
}


