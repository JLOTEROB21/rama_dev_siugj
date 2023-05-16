<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);

	$nombreTabla=obtenerNombreTabla($idFormulario);
	$tipoProceso=0;
	if($con->existeCampo("tipoProceso",$nombreTabla))
	{
		$consulta="SELECT tipoProceso FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$tipoProceso=$con->obtenerValor($consulta);
	}
	
	
	
	
	if($idFormulario==717)
	{
		$tipoProceso=6;
	}


	$consulta="SELECT id__1250_tablaDinamica FROM _1250_tablaDinamica WHERE idReferencia=".$tipoProceso;
	$idConfiguracion=$con->obtenerValor($consulta);
	$tipoFigura="2,4,5,6";
	
	if($idConfiguracion=="")
	{
		if(($idFormulario==717)||($idFormulario==847))
		{
			$tipoFigura="7,8,10";
		}
		if(($idFormulario==1004)||($idFormulario==1009)||($idFormulario==1010))
			$tipoFigura="2,4,6";		
	}
	else
	{
		$consulta="SELECT figuraJuridica FROM _1250_gridSujetosProcesales WHERE idReferencia=".$idConfiguracion." AND duranteRegistro=1";
		$tipoFigura=$con->obtenerListaValores($consulta);
		if($tipoFigura=="")
			$tipoFigura=-1;
	}
	
	
	$lblLeyendaAdd="Agregar Sujeto Procesal";
	$lblLeyendaDel="Remover Sujeto Procesal";
	
	if($idFormulario==1163)
	{
		$tipoFigura="13,14";	
		$lblLeyendaAdd="Agregar Parte Interesada";
		$lblLeyendaDel="Remover Parte Interesada";
		
	}
	if($idFormulario==1162)
	{
		$tipoFigura="15";	
		$lblLeyendaAdd="Agregar Parte Interesada";
		$lblLeyendaDel="Remover Parte Interesada";	
	}
	$consulta="SELECT id__5_tablaDinamica,nombreTipo,naturalezaFigura  FROM _5_tablaDinamica where 
			id__5_tablaDinamica in	(".$tipoFigura.") order by prioridad,nombreTipo";
					
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
		$o="['".$filaFigura[0]."','".cv($filaFigura[1])."',".$arrDetalles.",'".$listFiguras."','".$filaFigura[2]."']";
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
	
	
	
	
	$arrTipoIdentificacion="[]";
	if($idFormulario==1009)
	{
		$consulta="SELECT id__32_tablaDinamica,UPPER(tipoIdentificacion) FROM _32_tablaDinamica WHERE id__32_tablaDinamica NOT IN(19,9999,13) ORDER BY tipoIdentificacion";
		$arrTipoIdentificacion=$con->obtenerFilasArreglo($consulta);
	}
	
	
?>

var tipoProceso=<?php echo $tipoProceso ?>;

var arrTipoFigura=<?php echo $arrTipoFigura?>;
var idActividad=-1;

Ext.onReady(inicializar);

function inicializar()
{
	<?php
	if($arrTipoIdentificacion!="[]")
	{
	?>
		arrTipoIdentificacionCP=<?php echo $arrTipoIdentificacion?>;
	<?php
	}
	?>
    idActividad=gE('idActividad').value;
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                items:	[
                                                            crearGridParticipantes()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}

function crearGridParticipantes()
{

	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idParticipante'},
		                                                {name: 'nombreParticipante'},
                                                        {name: 'nombre'},
                                                        {name: 'primerApellido'},
                                                        {name: 'segundoApellido'},
                                                        {name: 'direccion'},
		                                                {name:'figura'},
		                                                {name:'relacion'},
                                                        {name:'idRegistro'},
                                                        {name: 'permiteEditar'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: './paginasFunciones/funcionesModuloRegistroPartes.php'

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
                                                                 menuDisabled :true,
                                                                dataIndex:'idRegistro',
                                                                align:'center',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if((gE('sL').value=='1')||(registro.data.permiteEditar=='0'))
                                                                            	return;
                                                                        	return '<a href="javascript:editarParte(\''+bE(registro.data.figura)+'\',\''+bE(val)+'\')"><img src="../images/pencil.png" title="Editar parte" alt="Editar parte"></a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Nombre/Raz&oacute;n Social',
                                                                width:480,
                                                                sortable:true,
                                                                dataIndex:'nombre',
                                                                 menuDisabled :true,
                                                                renderer:function(val,meta,registro)
                                                                				{
                                                                                	meta.attr='style="white-space:normal";';
                                                                                    return mostrarValorDescripcion(val);
                                                                                }
                                                            },
                                                            {
                                                                header:'Primer Apellido',
                                                                width:200,
                                                                 menuDisabled :true,
                                                                sortable:true,
                                                                dataIndex:'primerApellido',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Segundo Apellido',
                                                                width:200,
                                                                 menuDisabled :true,
                                                                sortable:true,
                                                                dataIndex:'segundoApellido',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Calidad',
                                                                width:220,
                                                                 menuDisabled :true,
                                                                sortable:true,
                                                                dataIndex:'figura',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrTipoFigura,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Relacionado con',
                                                                width:400,
                                                                 menuDisabled :true,
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
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                border:false,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                cls:'gridSiugjSeccion',
                                                                columnLines : true,  
                                                                tbar:	[
                                                                			{
                                                                                icon:'../principalPortal/imagesSIUGJ/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:gE('sL').value=='1',
                                                                                text:'<?php echo $lblLeyendaAdd ?>',
                                                                                height:50,
                                                                                menu:	<?php echo $arrPartes?>
                                                                                
                                                                            },
                                                                            {
                                                                                icon:'../principalPortal/imagesSIUGJ/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'<?php echo $lblLeyendaDel ?>',
                                                                                height:50,
                                                                                hidden:gE('sL').value=='1',
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
                                                                                                            recargarGridParticipantes();
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
                                                                                                    enableRowBody:true,
			                                                                                        getRowClass:formatearFilaDireccion,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;
}

function agregarParticipante(f,parte)
{
	var objConf={};

    objConf.idActividad=idActividad;
    objConf.idCarpeta=-1;
    objConf.afterRegister=recargarGridParticipantes;
   	objConf.ocultaCURP=true;
    objConf.ocultaCedula=true;
    objConf.ocultaRFC=true;
    objConf.ocultaAlias=true;
    
	agregarParticipanteVentana(f,parte,objConf)
}

function recargarGridParticipantes()
{
	 if((window.parent)&&(window.parent.recargarMenuDTD))
    {
        window.parent.recargarMenuDTD();
    }
	gEx('gParticipantes').getStore().reload();
}

function editarParte(f,iR)
{
	var objConf={};
    objConf.idActividad=idActividad;
    objConf.idCarpeta=-1;
    objConf.afterRegister=recargarGridParticipantes;
    objConf.idParticipante=bD(iR);
    objConf.ocultaCURP=true;
    objConf.ocultaCedula=true;
    objConf.ocultaRFC=true;
    objConf.ocultaAlias=true;
    var pos=existeValorMatriz(arrTipoFigura,bD(f));
    var parte=arrTipoFigura[pos][1];
	agregarParticipanteVentana(bD(f),parte,objConf,true)
  
}


function formatearFilaDireccion(registro,numFila, rp, ds)
{
	
    
	var lblTable	='<br /><table>'+
                        '<tr height="21">'+
                            '<td width="30"></td><td width="130" valign="top" align="left"><span class="etiquetaSIUGDatosContacto">Datos de Contacto:</span></td></tr><tr><td></td><td valign="top" width="450" valign="top"><span class="etiquetaSIUGJContacto">'+(registro.data.direccion.trim()==''?'(Sin Datos de Contacto)':registro.data.direccion.trim())+'</span></td>'+
                        '</tr>';
	
    
    lblTable+=	'</table><br>';
    
    rp.body=lblTable;	
}