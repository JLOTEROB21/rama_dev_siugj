<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);
	
	$idActividad=-1;
	if($idRegistro==-1)
		$idActividad=generarIDActividad($idFormulario);
	
	
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
	
	
	$consulta="SELECT idDocumento FROM _483_tablaDinamica WHERE id__483_tablaDinamica=".$idRegistro;
	$idDocumento=$con->obtenerValor($consulta);
	if($idDocumento=="")
		$idDocumento=-1;
?>	
var arrTipoFigura=<?php echo $arrTipoFigura?>;
var arrPartes=<?php echo $arrPartes?>;
var idActividad=<?php echo $idActividad?>;
var idDocumento=<?php echo $idDocumento?>;
function inyeccionCodigo()
{
	gE('sp_7688').innerHTML='';
    if(esRegistroFormulario())
    {
		 loadScript('../modulosEspeciales_SGJP/Scripts/cParticipante.js.php', function()
                                                                            {
                                                                            }
                    )
		loadScript('../Scripts/funcionesAjaxV2.js', function(){});
        
        
        if(gE('idRegistroG').value=='-1')
            gEN('_idActividadvch')[0].value=idActividad;
        else
            idActividad=gEN('_idActividadvch')[0].value;
	}
    else
    {
    	idActividad=gEN('_idActividadvch')[0].value;
    	
    }
    crearGridParticipantes();
    
    if(idDocumento!='-1')
    {
    	crearVisorAcuerdo();
    }
    else
    {
    	oE('div_7687');
        oE('div_7688');
        gE('frameTitulo').style.height='1200px';
        gE('tdContenedor').style.height='1200px';
    }
}	

function crearGridParticipantes()
{
	gE('sp_7667').innerHTML='';
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
                                                                width:300,
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
                                                                width:620,
                                                                height:270,
                                                                renderTo:'sp_7667',
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

function crearVisorAcuerdo()
{
	
	var oVisor=new Ext.ux.IFrameComponent({ 
        
                                                id: 'hSpVisor', 
                                                width:950,
                                                height:400,
                                                hidden:false,
                                                renderTo:'sp_7688',
                                                url: '../paginasFunciones/white.php',
                                                style: 'width:100%;height:100%' 
                                        });
                                        
		gEx('hSpVisor').load	(
                                    {
                                        url:'../visoresGaleriaDocumentos/visorDocumentosWord.php',
                                        params:	{
                                                    iDocumento:(idDocumento),
                                                    cPagina:'sFrm=true'
                                                }
                                    }
                                );   
}
