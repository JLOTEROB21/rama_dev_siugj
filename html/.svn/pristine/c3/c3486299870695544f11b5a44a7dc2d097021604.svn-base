<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$fechaActual=date("Y-m-d");
	$horaActual=date("H:i");
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);
	
	$consulta="SELECT id__5_tablaDinamica,nombreTipo FROM _5_tablaDinamica where 
			id__5_tablaDinamica in	(105) order by nombreTipo";

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
	
	$consulta="SELECT idActividad FROM _509_tablaDinamica WHERE id__509_tablaDinamica=".$idReferencia;

	$idActividad=$con->obtenerValor($consulta);

?>

var arrTipoFigura=[<?php echo $arrParteProcesal?>];
var idActividad=<?php echo $idActividad?>;


function inyeccionCodigo()
{
	if(esRegistroFormulario())
    {
    	loadScript('../modulosEspeciales_SGJP/Scripts/cParticipante.js.php', function()
    																		{
                                                                            }
					)
    	loadScript('../Scripts/funcionesAjaxV2.js', function(){});
        
         
	}
    else
    {
    	if(gE('sp_8265').innerHTML!='Fianza')
        {
        	oE('div_8267');
            oE('div_8268');
        }
        else
        {
        	if(gE('sp_8265').innerHTML=='Billete de BANSEFI')
            {
            	gE('div_7990').innerHTML=	'<table>'+
    											'<tbody><tr>'+
													'<td valign="top"></td>'+
                    								'<td><div class="TSJDF_Control"><span>BASEFI</span></div></td>'+
													'<td></td>'+
                    							'</tr>'+
    											'</tbody></table>';
            }
        

        }
        
    }
    
    gE('sp_7996').innerHTML='';
	crearGridParticipantes();
}  

function validarExpediente()
{
	var noExpediente=gE('_noExpedienteint').value;
    var anioExpediente=gE('_anioExpedientevch').options[gE('_anioExpedientevch').selectedIndex].value;
    
    function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        
        	if(arrResp[1]=='0')
            {
            	oE('div_7584');
                existeAudiencia=false;
            }
            else
            {
            	existeAudiencia=true;
                mE('div_7584');
                switch(arrResp[1])
                {
                 	case '1':
                    	gE('sp_7584').innerHTML='El No. de Expediente ha sido registrado previamente !!!';
                    break;
                    case '2':
                    	gE('sp_7584').innerHTML='El No. de Expediente ya se encuentra registrado en otro registro de expediente!!!';
                    break;  
                    
                }
           	}
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_Juzgados.php',funcAjax, 'POST','funcion=5&iR='+gE('idRegistroG').value+'&j='+juzgado+'&nE='+noExpediente+'&anio='+anioExpediente,true);
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
                                                                header:'Nombre del beneficiario',
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
                                                                hidden:true,
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
                                                                renderTo:'sp_7996',
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
                                                                                text:'Agregar...',
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

function validarExistenciaExpediente()
{
	if(existeAudiencia)
    {
    	msgBox('El No. de Expediente ha sido registrado previamente !!!');
    	return false;
    }
    return true;
}
