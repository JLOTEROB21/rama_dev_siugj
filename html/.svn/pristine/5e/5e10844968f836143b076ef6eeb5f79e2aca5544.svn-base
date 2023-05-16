<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT id__406_tablaDinamica,pena,concat(tipoEntrada,'_',pSustitutivo) FROM _406_tablaDinamica WHERE categoria<>2 ORDER BY pena";
	$arrPenas=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT id__406_tablaDinamica,pena,CONCAT(tipoEntrada,'_',pSustitutivo),p.idPadre FROM _406_tablaDinamica s,_406_sustitutivos p 
				WHERE categoria=2 AND p.idOpcion=s.id__406_tablaDinamica  ORDER BY p.idPadre,id__406_tablaDinamica";
	$arrSustitutivo=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT clave,nombre FROM _2_tablaDinamica   ORDER BY situacion,nombre";
	$arrCentrosDetencion=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT valor,texto FROM 1004_siNo";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);
	$cadComp=($_GET["pComp"]);
	$oComp=NULL;
	$esActualizacionCarpeta=false;
	if($cadComp!="")
	{
		$oComp=json_decode(bD($cadComp));
		if(isset($oComp->esActualizacionCarpeta))
			$esActualizacionCarpeta=true;
	}
	
	$idImputado=-1;
	if($idRegistro!=-1)
	{
		$consulta="SELECT sentenciado FROM _405_tablaDinamica WHERE id__405_tablaDinamica=".$idRegistro;	
		$idImputado=$con->obtenerValor($consulta);
		
		
		
		
		
	}
	else
	{
		if($oComp)
		{
			
			if(isset($oComp->sentenciado))
				$idImputado=$oComp->sentenciado;
		}
		
		
		
	}
	
	
	
	
	
	$consulta="SELECT  idActividad FROM _385_tablaDinamica WHERE id__385_tablaDinamica=".$idReferencia;
	$idActividadBase=$con->obtenerValor($consulta);
	
	$idActividad=-1;
	if($idRegistro==-1)
		$idActividad=generarIDActividad($idFormulario);
	
		
	
	
	$consulta="SELECT sentenciado FROM _405_tablaDinamica WHERE idReferencia=".$idReferencia." AND id__405_tablaDinamica<>".$idRegistro;
	$arrSentenciados=$con->obtenerFilasArreglo($consulta);

	$consulta="SELECT clave,nombre FROM _2_tablaDinamica  ORDER BY nombre";
	$arrReclusorios=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT idRegistro,anios,meses,dias,lugarDetencion,especifique FROM _405_computoPrisionCumplida WHERE iFormulario=405 AND idRegistro=".$idRegistro;
	$arrComputoCumplido=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT id__35_denominacionDelito,denominacionDelito FROM _35_denominacionDelito ORDER BY denominacionDelito";
	$arrDelitos=$con->obtenerFilasArreglo($consulta);

	$arrTipoPenas="";
	$consulta="SELECT id__406_tablaDinamica,pena,tipoEntrada FROM _406_tablaDinamica WHERE categoria IN(1,3) ORDER BY orden";
	$resPenas=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($resPenas))
	{
		$consulta="SELECT id__406_gridSubDetalle,subdetalle FROM _406_gridSubDetalle WHERE idReferencia= ".$fila[0];
		$arrDetalle=$con->obtenerFilasArreglo($consulta);
		
		$consulta="SELECT id__406_tablaDinamica,pena FROM _406_sustitutivos d,_406_tablaDinamica s WHERE d.idPadre=".$fila[0]." 
					AND id__406_tablaDinamica=d.idOpcion";
		$arrSustitutivoPena=$con->obtenerFilasArreglo($consulta);
		$o="['".$fila[0]."','".cv($fila[1])."','".$fila[2]."',".$arrDetalle.",".$arrSustitutivoPena."]";
		if($arrTipoPenas=="")
			$arrTipoPenas=$o;
		else
			$arrTipoPenas.=",".$o;
	}

	$arrTipoMedidas="";
	$consulta="SELECT id__406_tablaDinamica,pena,tipoEntrada FROM _406_tablaDinamica WHERE categoria IN(4,5) ORDER BY orden";
	$resPenas=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($resPenas))
	{
		$consulta="SELECT id__406_gridSubDetalle,subdetalle FROM _406_gridSubDetalle WHERE idReferencia= ".$fila[0];
		$arrDetalle=$con->obtenerFilasArreglo($consulta);
		
		$consulta="SELECT id__406_tablaDinamica,pena FROM _406_sustitutivos d,_406_tablaDinamica s WHERE d.idPadre=".$fila[0]." 
					AND id__406_tablaDinamica=d.idOpcion";
		$arrSustitutivoPena=$con->obtenerFilasArreglo($consulta);
		
		$o="['".$fila[0]."','".cv($fila[1])."','".$fila[2]."',".$arrDetalle.",".$arrSustitutivoPena."]";
		if($arrTipoMedidas=="")
			$arrTipoMedidas=$o;
		else
			$arrTipoMedidas.=",".$o;
	}
	
	$arrTipoConsecuencias="";
	$consulta="SELECT id__406_tablaDinamica,pena,tipoEntrada FROM _406_tablaDinamica WHERE categoria=6 ORDER BY orden";
	$resPenas=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($resPenas))
	{
		$consulta="SELECT id__406_gridSubDetalle,subdetalle FROM _406_gridSubDetalle WHERE idReferencia= ".$fila[0];
		$arrDetalle=$con->obtenerFilasArreglo($consulta);
		
		$consulta="SELECT id__406_tablaDinamica,pena FROM _406_sustitutivos d,_406_tablaDinamica s WHERE d.idPadre=".$fila[0]." 
					AND id__406_tablaDinamica=d.idOpcion";
		$arrSustitutivoPena=$con->obtenerFilasArreglo($consulta);
		
		$o="['".$fila[0]."','".cv($fila[1])."','".$fila[2]."',".$arrDetalle.",".$arrSustitutivoPena."]";
		if($arrTipoConsecuencias=="")
			$arrTipoConsecuencias=$o;
		else
			$arrTipoConsecuencias.=",".$o;
	}

	$consulta="SELECT id__406_gridSubDetalle,subdetalle FROM _406_gridSubDetalle";
	$arrDetallesPena=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__406_gridSubDetalle,subdetalle FROM _406_gridSubDetalle WHERE idReferencia=10";
	$arrDecomisoValores=$con->obtenerFilasArreglo($consulta);
	
?>
var esActualizacionCarpeta=<?php echo $esActualizacionCarpeta?"true":"false "?>;
var arrDetallesPena=<?php echo $arrDetallesPena?>;
var arrTipoPenas=[['1','Pena',[<?php echo $arrTipoPenas?>]],['2','Medida de seguridad',[<?php echo $arrTipoMedidas?>]],['3','Consecuencia accesoria',[<?php echo $arrTipoConsecuencias?>]]];
var diasMes=30;
var capturado=false;
var arrAniosComputo=[];
var arrMesesComputo=[];
var arrDiasComputo=[];
var idActividad=<?php echo $idActividad?>;
var arrSiNo=<?php echo $arrSiNo?>;
var arrCentrosDetencion=<?php echo $arrCentrosDetencion?>;
var arrPenas=<?php echo $arrPenas?>;
var arrSustitutivo=<?php echo $arrSustitutivo?>;
var arrSiNoIndeterminado=[['0','No'],['1','S\xED']];
var idImputado=<?php echo $idImputado?>;
var arrReclusorios=<?php echo $arrReclusorios?>;
var arrComputoCumplido=<?php echo $arrComputoCumplido?>;
var arrSentenciados=<?php echo $arrSentenciados?>;
var arrDelitos=<?php echo $arrDelitos?>;
var idActividadBase=<?php echo $idActividadBase?>;
var arrDecomisoValores=<?php echo $arrDecomisoValores?>;
var cadenaFuncionValidacion='funcionValidarGuardado';

function inyeccionCodigo()
{

	loadScript('../Scripts/ux/checkColumn.js',function(){});
	loadScript('../modulosEspeciales_SGJP/Scripts/cComputo.js.php',function(){});
	arrReclusorios.splice(0,0,['0','Otro']);                                                                   
    gE('sp_5985').innerHTML='';
    crearGridSentencia();
	if(!esRegistroFormulario())
    {
    	idActividad=gEN('_idActividadvch')[0].value;
    }
    else
    {
    	
    	if(gE('idRegistroG').value=='-1')
        {
            gEN('_idActividadvch')[0].value=idActividad;
            gEN('_idActividadEjecucionvch')[0].value=idActividadBase;
        }
        else
            idActividad=gEN('_idActividadvch')[0].value;
            
        asignarEvento(gE('_sentenciadovch'),'change',function(cmb)
        											{
                                                    	var obj={};
                                                        obj.idParticipante=cmb.options[cmb.selectedIndex].value;
                                                        obj.renderTo='sp_6476';
                                                        obj.permiteEditar=true;
                                                        construirTableroDireccion(obj);
                                                    }
                     )
           
    	var _sentenciadovch=gE('_sentenciadovch');
    	var sSelecionado='-1';
    	var aSentenciados=[];
   		for(x=0;x<_sentenciadovch.options.length;x++) 
   		{
   			if(_sentenciadovch.options[x].selected)
   				sSelecionado=_sentenciadovch.options[x].value;
   			if(existeValorMatriz(arrSentenciados,_sentenciadovch.options[x].value)==-1)
   				aSentenciados.push([_sentenciadovch.options[x].value,_sentenciadovch.options[x].text]);
   		}
        
        if((sSelecionado==-1)&&(idImputado!=-1))
        {
        	sSelecionado=idImputado;
        }
        
    	llenarCombo(_sentenciadovch,aSentenciados,false);
    	selElemCombo(_sentenciadovch,sSelecionado);
    }
    
    gE('sp_6476').innerHTML='';
	
    
	loadScript('../modulosEspeciales_SGJP/Scripts/cDireccionContacto.js.php?iF=<?php echo $idFormulario?>&iR='+idActividad, function()
    																		{
                                                                            	
                                                                            	var obj={};
                                                                                obj.idParticipante=idImputado;
                                                                                obj.renderTo='sp_6476';
                                                                                obj.permiteEditar=esRegistroFormulario();
                                                                                construirTableroDireccion(obj);
                                                                            }
				)

    var x;
    for(x=0;x<=100;x++)
    {
    	arrAniosComputo.push([x,x]);
    }
	var cmbAnios=crearComboExt('cmbAnios',arrAniosComputo,10,20,110);
    cmbAnios.setValue(0);
    
    for(x=0;x<=11;x++)
    {
    	arrMesesComputo.push([x,x]);
    }
    
    var cmbMeses=crearComboExt('cmbMeses',arrMesesComputo,130,20,110);
    cmbMeses.setValue(0);
    for(x=0;x<=364;x++)
    {
    	arrDiasComputo.push([x,x]);
    }
    
    var cmbDias=crearComboExt('cmbDias',arrDiasComputo,250,20,80);
    cmbDias.setValue(0);
    
    var arrMesesRevision=[];
    for(x=0;x<=11;x++)
    {
    	arrMesesRevision.push([x,x]);
    }
    
    /*new Ext.form.FieldSet	(
                                {
                            
                                    title:'C&oacute;mputo de prisi&oacute;n cumplida',
                                    renderTo:'sp_6513',
                                    layout:'absolute',
                                    width:850,
                                    height:290,
                                    items:	[
                                                
                                                
                                                
                                            ]
                                }
							)
*/
	
   
    
   var cmbEditorPena=crearComboExt('cmbEditorPena',[],0,0);
    
   gEx('grid_6709').getColumnModel().setRenderer(0,funcionPenaRenderer);
   gEx('grid_6709').getColumnModel().config[0].setEditor(cmbEditorPena);
    
   setTimeout(	function()
    			{
                	gEx('grid_6709').getView().refresh();
                },1000
    		)
    		
    		
	   		
    
}

function beforeEdit_6709(rowEdit,fila)
{
	
    var arrEditor=[];
    var gSentencia=gEx('gSentencia');
    var registro;
    var x;
    var penaDetalle;
    for(x=0;x<gSentencia.getStore().getCount();x++)
    {
       	penaDetalle='';
        var registro=gSentencia.getStore().getAt(x);
        
        var oDetalle='';
        var objDetalle=registro.data.objDetalle;
        var lblDetallePena='';
        
        if(objDetalle!='')
        {
            oDetalle=eval('['+objDetalle+']')[0];
            if(oDetalle.monto)
            {
                lblDetallePena='Monto: ';
                lblDetallesPenaValor=Ext.util.Format.usMoney(oDetalle.monto);
            }
            else
            {
                lblDetallePena='Duraci\xF3n de la pena: ';
                lblDetallesPenaValor=oDetalle.anios+' a\xF1os, '+oDetalle.meses+' meses, '+oDetalle.dias+' dias';                
                lblDetallePena+=lblDetallesPenaValor;
            }
            
            lblDetallePena=', '+lblDetallePena;
        }
        
        if(registro.data.detallePena!='-1')
        	penaDetalle='<br> ('+formatearValorRenderer(arrDetallesPena,registro.data.detallePena)+' )';
        
        
        lblPena=formatearValorRenderer(arrPenas,registro.data.idPena)+penaDetalle+lblDetallePena+', Delitos: '+registro.data.delitos;
        arrEditor.push([registro.data.idRegistro,lblPena]);   
    }
    
    
    gEx('cmbEditorPena').getStore().loadData(arrEditor);
}

function crearGridSentencia()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'idPena'},
		                                                {name:'idActividad'},
		                                                {name: 'objDetalle'},
                                                        {name: 'centroDetencion'},
                                                        {name: 'detallesAdicionales'},
                                                        {name: 'permiteSustitutivos'},
                                                        {name: 'datosSustitutivos'},
                                                        {name: 'delitos'},
                                                        {name: 'tipoPena'},
                                                        {name: 'detallePena'},
                                                        {name: 'arrComputoPrisionPreventiva'},
                                                        {name: 'fechaInicio'},
                                                        {name: 'fechaFin'},
                                                        {name: 'abonoPrisionPunitiva'}
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
                                                            sortInfo: {field: 'idPena', direction: 'ASC'},
                                                            groupField: 'idPena',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='114';
                                        proxy.baseParams.idActividad=idActividad;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                                                                                      
                                                            {
                                                                header:'',
                                                                width:1200,
                                                                sortable:true,
                                                                dataIndex:'idPena',
                                                                renderer:function(val)
                                                                		{
                                                                        	return '';
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gSentencia',
                                                                store:alDatos,
                                                                width:860,
                                                                height:300,
                                                                renderTo:'sp_5985',
                                                                frame:false,
                                                                border:true,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true, 
                                                                tbar:	[
                                                                            {
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Agregar pena',
                                                                                hidden:!esRegistroFormulario(),
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaPena();
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Modificar pena',
                                                                                hidden:!esRegistroFormulario(),
                                                                                handler:function()
                                                                                        {
                                                                                        	var fila=gEx('gSentencia').getSelectionModel().getSelected();
                                                                                           
                                                                                           	if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la pena que desea modificar');
                                                                                            	return;
                                                                                            }
                                                                                            mostrarVentanaPena(fila);
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:!esRegistroFormulario(),
                                                                                text:'Remover pena',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=gEx('gSentencia').getSelectionModel().getSelected();
                                                                                           
                                                                                           	if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la pena que desea remover');
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
                                                                                                            gEx('gSentencia').getStore().remove(fila);
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=115&idRegistro='+fila.data.idRegistro,true);
                                                                                                }
																							}
                                                                                            msgConfirm('Est&aacute; seguro de querer remover la pena seleccionada?',resp);
                                                                                            
                                                                                            
                                                                                        }
                                                                                
                                                                            }
                                                                            
                                                                        ] ,                                                              
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :false,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    enableRowBody:true,
                                                                                                    getRowClass:formatearFilaSentencia,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
	return 	tblGrid;	
}

function mostrarVentanaPena(filaPena)
{
	var cmbCentroDetencion=crearComboExt('cmbCentroDetencion',arrCentrosDetencion,330,0,380);
    cmbCentroDetencion.hide();
	
   	var cmbTipoPena=crearComboExt('cmbTipoPena',arrTipoPenas,130,10,300);
   	cmbTipoPena.on('select',function(cmb,registro)
  							{
  								gEx('cmbPena').setValue('');
  								dispararEventoSelectCombo('cmbPena');
  								gEx('cmbPena').getStore().loadData(registro.data.valorComp);
  							}
   				)
   	
   	
   	var cmbPena=crearComboExt('cmbPena',arrPenas,130,40,500);
    
    cmbPena.on('select',function(cmb,registro)
    					{
                       		
                        	var arrComplementario=[];
                        	arrComplementario.push(registro.data.valorComp);
							arrComplementario.push(registro.data.valorComp3);
                        	gEx('cmbDetallePena').hide();
                        	gEx('cmbDetallePena').setValue('');
                        	gEx('boxDecomiso').hide();
                           
                        	if(registro.data.valorComp2.length>0)
                        	{
                            	if(registro.data.id=='10')
                                {
                                	gEx('boxDecomiso').show();
                                }
                                else
                                {
                                	gEx('cmbDetallePena').getStore().loadData(registro.data.valorComp2);
                        			gEx('cmbDetallePena').show();
                                }
                        		
                                
                                
                                
                        	}
                        	
                        	switch(arrComplementario[0])
                            {
                            	case '2'://Monto
                                	gE('spMulta').innerHTML='Monto:';
                                    gEx('txtMonto').show();
                                    gEx('fsPeriodoPena').hide();
                                    gEx('txtAnios').setValue(0);
                                    gEx('txtMeses').setValue(0);
                                    gEx('txtDias').setValue(0);
                                    gEx('tabPanelPena').hideTabStripItem('pAbonoPrision');
                                    gEx('tabPanelPena').hideTabStripItem('pAbonoPrisionPunitiva');
                                break;
                                case '5'://Periodo
                                	gE('spMulta').innerHTML='Periodo:';
                                    gEx('fsPeriodoPena').show();
                                    gEx('txtMonto').hide();
                                    gEx('tabPanelPena').unhideTabStripItem('pAbonoPrision');                                    
                                    gEx('tabPanelPena').unhideTabStripItem('pAbonoPrisionPunitiva');
                                break;
                                default:
                                	gE('spMulta').innerHTML='';
                                    gEx('fsPeriodoPena').hide();
                                    gEx('txtMonto').hide();
                                    gEx('tabPanelPena').hideTabStripItem('pAbonoPrision');
                                    gEx('tabPanelPena').hideTabStripItem('pAbonoPrisionPunitiva');
                                break;
                                
                                
                            }
                            
                            if(arrComplementario[1].length>0)
                            {
                            	gEx('tabPanelPena').unhideTabStripItem('pSustitutivoPena');
                            }
                            else
                            {
                            	gEx('tabPanelPena').hideTabStripItem('pSustitutivoPena');
                            }
                            
                            if(registro.data.id=='1')
                            {
                            	gEx('lblCentroD').show();
                                gEx('cmbCentroDetencion').show();
                                
                            }
                            else
                            {
                            	gEx('lblCentroD').hide();
                                gEx('cmbCentroDetencion').hide();
                            }
                            
                        }
    			)    
    
    var cmbDetallePena=crearComboExt('cmbDetallePena',[],130,70,500);
    
    cmbDetallePena.on('select',function(cmb,registro)
    							{
                                	gE('spMulta').innerHTML='';
                                    gEx('txtMonto').hide();
                                    gEx('txtMonto').setValue('');
                                	switch(registro.data.id)
                                    {
                                        case '8'://Multa
                                        case '10'://Sanción economica
                                            gE('spMulta').innerHTML='Monto:';
                                            gEx('txtMonto').show();
                                            
                                        break;
                                        
                                            
                                        
                                        
                                        
                                    }
                                }
    				)
    
    
    var cmbSiNoSustitutivo=crearComboExt('cmbSiNoSustitutivo',arrSiNo,250,10,110);
    cmbDetallePena.hide();
    cmbSiNoSustitutivo.setValue('0');
   
    cmbSiNoSustitutivo.on('select',function(cmb,registro)
    							{
                                	if(registro.data.id=='1')
                                    {
                                    	gEx('gSustitutivo').enable();
                                        
                                    }
                                    else
                                    {
                                    	gEx('gSustitutivo').disable();
                                        gEx('gSustitutivo').getStore().removeAll();
                                        
                                        
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
                                                        	xtype:'tabpanel',
                                                            activeTab:3,
                                                            id:'tabPanelPena',
                                                            baseCls: 'x-plain',
                                                            listeners:	{
                                                           					tabchange:function(ctrl,p)
                                                           								{
                                                           									switch(p.id)
                                                           									{
                                                           										case 'pAbonoPrision':
                                                           											calcularTotalComputoPrisionPreventiva();
                                                                                                break;
                                                                                                case 'pAbonoPrisionPunitiva':
                                                           											calcularPenaCumplir();
                                                                                                break;
                                                           									}
                                                           								}
                                                            			},
                                                            height:350,
                                                            items:	[
                                                            			{
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            baseCls: 'x-plain',
                                                                            defaultType: 'label',
                                                                            title:'Datos generales',
                                                                            items:	[
                                                                                      	{
                                                                                            x:10,
                                                                                            y:15,
                                                                                            html:'Tipo de pena:'
                                                                                        },
                                                                                        cmbTipoPena,
                                                                                       	{
                                                                                            x:10,
                                                                                            y:45,
                                                                                            html:'Pena impuesta:'
                                                                                        },
                                                                                        cmbPena,
                                                                                        cmbDetallePena,
                                                                                        {
                                                                                        	x:130,
                                                                                            y:70,
                                                                                            hidden:true,
                                                                                            id:'boxDecomiso',
                                                                                            width:600,
                                                                                            itemCls: 'x-check-group-alt',
                                                                                            xtype: 'checkboxgroup',
                                                                                            items:	[
                                                                                            			{boxLabel: arrDecomisoValores[0][1], value: arrDecomisoValores[0][0],id:'chk_'+arrDecomisoValores[0][0]},
                                                                                                        {boxLabel: arrDecomisoValores[1][1], value: arrDecomisoValores[1][0],id:'chk_'+arrDecomisoValores[1][0]},
                                                                                                        {boxLabel: arrDecomisoValores[2][1], value: arrDecomisoValores[2][0],id:'chk_'+arrDecomisoValores[2][0]}
                                                                                            		]
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:150,
                                                                                            html:'Indique los delitos por los cuales se impone al pena:'
                                                                                        },
                                                                                        crearGridDelitosPena(filaPena),
                                                                                        
                                                                                        {
                                                                                            x:10,
                                                                                            y:105,
                                                                                            html:'<span id="spMulta"></span>'
                                                                                        },
                                                                                        {
                                                                                            x:130,
                                                                                            y:100,
                                                                                            
                                                                                            allowDecimals:true,
                                                                                            allowNegative:false,
                                                                                            xtype:'numberfield',
                                                                                            width:120,
                                                                                            hidden:true,
                                                                                            id:'txtMonto'
                                                                                        },
                                                                                        {
                                                                                            xtype:'fieldset',
                                                                                            width:800,
                                                                                            hidden:true,
                                                                                            id:'fsPeriodoPena',
                                                                                            height:100,
                                                                                            x:50,
                                                                                            y:90,
                                                                                            border:false,
                                                                                            layout:'absolute',
                                                                                            items:	[
                                                                                                        {
                                                                                                            x:10,
                                                                                                            y:0,
                                                                                                            xtype:'numberfield',
                                                                                                            allowDecimals:false,
                                                                                                            alowNegative:false,
                                                                                                            width:40,
                                                                                                            value:0,
                                                                                                            listeners:	{
                                                                                                            				change:calcularPenaCumplir
                                                                                                            			},	
                                                                                                            id:'txtAnios'
                                                                                                        },
                                                                                                        {
                                                                                                            xtype:'label',
                                                                                                            html:'A&ntilde;os',
                                                                                                            x:15,
                                                                                                            y:25
                                                                                                        },
                                                                                                        {
                                                                                                            x:60,
                                                                                                            y:0,
                                                                                                            xtype:'numberfield',
                                                                                                            width:40,
                                                                                                            allowDecimals:false,
                                                                                                            alowNegative:false,
                                                                                                            value:0,
                                                                                                            listeners:	{
                                                                                                            				change:calcularPenaCumplir
                                                                                                            			},
                                                                                                            id:'txtMeses'
                                                                                                        },
                                                                                                        {
                                                                                                            xtype:'label',
                                                                                                            html:'Meses',
                                                                                                            x:65,
                                                                                                            y:25
                                                                                                        },
                                                                                                        {
                                                                                                            x:110,
                                                                                                            y:0,
                                                                                                            xtype:'numberfield',
                                                                                                            width:40,
                                                                                                            value:0,
                                                                                                            listeners:	{
                                                                                                            				change:calcularPenaCumplir
                                                                                                            			},
                                                                                                            allowDecimals:false,
                                                                                                            alowNegative:false,
                                                                                                            id:'txtDias'
                                                                                                        },
                                                                                                        {
                                                                                                            xtype:'label',
                                                                                                            html:'D&iacute;as',
                                                                                                            x:115,
                                                                                                            y:25
                                                                                                        },
                                                                                                         {
                                                                                                            xtype:'label',
                                                                                                            html:'Centro de detenci&oacute;n actual:',
                                                                                                            x:170,
                                                                                                            id:'lblCentroD',
                                                                                                            hidden:true,
                                                                                                            y:5
                                                                                                        },
                                                                                                        cmbCentroDetencion
                                                                                                    ]
                                                                                        } 
                                                                                        
                                                                            		]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            baseCls: 'x-plain',
                                                                            defaultType: 'label',
                                                                            id:'pAbonoPrision',
                                                                            title:'Abono de prisi&oacute;n preventiva',
                                                                            items:	[
                                                                           				crearGridComputoPrisionPreventiva(),
																						{
																							x:10,
																							y:220,
																							xtype:'label',
																							html:'<span class="TSJDF_Etiqueta">Total de abono de prisi&oacute;n preventiva:</span>'
																						},
																						 {
																							x:260,
																							y:220,
																							xtype:'label',
																							html:'<span id="lblTotalComputo" class="TSJDF_Control"></span>'
																						},
                                                                           				{
																							x:10,
																							y:250,
                                                                                            hidden:esActualizacionCarpeta,
																							xtype:'label',
																							html:'<span class="TSJDF_Etiqueta">Total de sentencia por cumplir:</span>'
																						},
																						 {
																							x:260,
																							y:245,
                                                                                            hidden:esActualizacionCarpeta,
																							xtype:'label',
																							html:'<span id="lblTotalSentenciaCumplir" class="TSJDF_Control"></span>'
																						}
                                                                            		]
                                                                        },
                                                                        <?php
																		if($esActualizacionCarpeta)
																		{
																		?>
                                                                        {
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            baseCls: 'x-plain',
                                                                            defaultType: 'label',
                                                                            id:'pAbonoPrisionPunitiva',
                                                                            title:'Calculo finalizaci&oacute;n de sentencia',
                                                                            items:	[
                                                                            			{
                                                                                            x:10,
                                                                                            y:20,
                                                                                            xtype:'label',
                                                                                            html:'<span class="TSJDF_Etiqueta">Duraci&oacute;n pena:</span>'
                                                                                        },
                                                                                         {
                                                                                            x:260,
                                                                                            y:20,
                                                                                            xtype:'label',
                                                                                            html:'<span id="lblDuracionPenaAct" class="TSJDF_Control"></span>'
                                                                                        },	
                                                                                        {
                                                                                            x:10,
                                                                                            y:50,
                                                                                            xtype:'label',
                                                                                            html:'<span class="TSJDF_Etiqueta">Total de abono de prisión preventiva:</span>'
                                                                                        },
                                                                                         {
                                                                                            x:260,
                                                                                            y:50,
                                                                                            xtype:'label',
                                                                                            html:'<span id="lblTotalAbonoPrisionPreventivaAct" class="TSJDF_Control"></span>'
                                                                                        },
                                                                           				{
                                                                                              xtype:'fieldset',
                                                                                              width:650,                                                                                              
                                                                                              id:'fsAbonoPrisionPunitiva',
                                                                                              height:80,
                                                                                              title:'Abono prisi&oacute;n punitiva',
                                                                                              x:10,

                                                                                              y:80,
                                                                                              layout:'absolute',
                                                                                              items:	[
                                                                                              				
                                                                                                          {
                                                                                                              x:10,
                                                                                                              y:0,
                                                                                                              xtype:'numberfield',
                                                                                                              allowDecimals:false,
                                                                                                              alowNegative:false,
                                                                                                              width:40,
                                                                                                              value:0,                                                                                                             
                                                                                                              listeners:	{
                                                                                                                              change:calcularPenaCumplir
                                                                                                                          },
                                                                                                              id:'txtAniosPunitiva'
                                                                                                          },
                                                                                                          {
                                                                                                              xtype:'label',
                                                                                                              html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">A&ntilde;os</span>',
                                                                                                              x:15,
                                                                                                              y:25
                                                                                                          },
                                                                                                          {
                                                                                                              x:60,
                                                                                                              y:0,
                                                                                                              xtype:'numberfield',
                                                                                                              width:40,
                                                                                                              
                                                                                                              listeners:	{
                                                                                                                              change:calcularPenaCumplir
                                                                                                                          },
                                                                                                              allowDecimals:false,
                                                                                                              alowNegative:false,
                                                                                                              value:0,
                                                            
                                                                                                              id:'txtMesesPunitiva'
                                                                                                          },
                                                                                                          {
                                                                                                              xtype:'label',
                                                                                                              html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">Meses</span>',
                                                                                                              x:65,
                                                                                                              y:25
                                                                                                          },
                                                                                                          {
                                                                                                              x:110,
                                                                                                              y:0,
                                                                                                              xtype:'numberfield',
                                                                                                              width:40,
                                                                                                              value:0,
                                                                                                              
                                                                                                              listeners:	{
                                                                                                                              change:calcularPenaCumplir
                                                                                                                          },
                                                                                                              allowDecimals:false,
                                                                                                              alowNegative:false,
                                                                                                              id:'txtDiasPunitiva'
                                                                                                          },
                                                                                                          {
                                                                                                              xtype:'label',
                                                                                                              html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">D&iacute;as</span>',
                                                                                                              x:115,
                                                                                                              y:25
                                                                                                          }
                                                                                                          
                                                                                                      	]
                                                                                          } ,
                                                                                          {
                                                                                            x:10,
                                                                                            y:180,
                                                                                            xtype:'label',
                                                                                            html:'<span class="TSJDF_Etiqueta">Total de sentencia por cumplir:</span>'
                                                                                        },
                                                                                         {
                                                                                            x:240,
                                                                                            y:180,
                                                                                            xtype:'label',
                                                                                            html:'<span id="lblTotalSentenciaCumplirAct" class="TSJDF_Control"></span>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:210,
                                                                                            xtype:'label',
                                                                                            html:'<span class="TSJDF_Etiqueta">Fecha de inicio de pena:</span>'
                                                                                        },
                                                                                        {
                                                                                        	xtype:'datefield',
                                                                                            id:'dteFechaInicioPenaAct',
                                                                                            x:240,
                                                                                            
                                                                                            listeners:	{
                                                                                            				select:calcularPenaCumplir
                                                                                            			},
                                                                                            y:205
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:240,
                                                                                            xtype:'label',
                                                                                            html:'<span class="TSJDF_Etiqueta">Fecha de compurga:</span>'
                                                                                        },
                                                                                        {
                                                                                        	xtype:'datefield',
                                                                                            id:'dteFechaConpurgaPenaAct',
                                                                                            x:240,
                                                                                            disabled:true,
                                                                                            y:235
                                                                                        }
                                                                            		]
                                                                        },
                                                                        <?php
																		}
																		?>
                                                                        {
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            baseCls: 'x-plain',
                                                                            defaultType: 'label',
                                                                            id:'pSustitutivoPena',
                                                                            title:'Sustitutivos de pena',
                                                                            items:	[
                                                                                       	  {
                                                                                            x:10,
                                                                                            y:15,
                                                                                            id:'lblSustitutivo',
                                                                                            html:'Se concede alg&uacute;n sustitutivo de la pena?:'
                                                                                        },
                                                                                        cmbSiNoSustitutivo,
                                                                                        crearGridSustitutivo()                                                 
                                                                                        
                                                                                        
                                                                            		]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            baseCls: 'x-plain',
                                                                            defaultType: 'label',
                                                                            id:'pDetalles',
                                                                            title:'Detalles adicionales',
                                                                            items:	[
                                                                           				{
                                                                                            x:10,
                                                                                            y:10,
                                                                                            xtype:'textarea',
                                                                                            width:750,
                                                                                            height:300,
                                                                                            id:'txtDetalles'
                                                                                        }
                                                                            		]
                                                                         }
                                                            		]
                                                        }
                                                        
                                                        
                                                        
                                                        
                                            			
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: !filaPena?'Registrar pena':'Modificar pena',
										width: 800,
										height:435,
										layout: 'fit',
										plain:true,
										modal:true,
                                        id:'wPena',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
																	gEx('tabPanelPena').setActiveTab(0);
																	
																	
																	
																	if(filaPena)
																	{

																		cmbTipoPena.setValue(filaPena.data.tipoPena);
																		dispararEventoSelectCombo('cmbTipoPena');
																		cmbPena.setValue(filaPena.data.idPena);
																		dispararEventoSelectCombo('cmbPena');
																		if(filaPena.data.detallePena!='-1')
																			cmbDetallePena.setValue(filaPena.data.detallePena);

																		cmbCentroDetencion.setValue(filaPena.data.centroDetencion);
																		if(filaPena.data.objDetalle!='')
																		{
																			var objDetalle=eval('['+filaPena.data.objDetalle+']')[0];
																			if(objDetalle.monto)
																			{
																				gEx('txtMonto').setValue(objDetalle.monto);
																			}
																			
                                                                            if(objDetalle.anios)
                                                                            {
                                                                                gEx('txtAnios').setValue(objDetalle.anios);
                                                                                gEx('txtMeses').setValue(objDetalle.meses);
                                                                                gEx('txtDias').setValue(objDetalle.dias);
                                                                            }
                                                                                
																			if(objDetalle.tiposObjetos)
                                                                            {
                                                                                var arrTiposObjetos=objDetalle.tiposObjetos.split(',');
                                                                             	var a=0;
                                                                                for(a=0;a<arrTiposObjetos.length;a++)
	                                                                                gEx('chk_'+arrTiposObjetos[a]).setValue(true);   
                                                                                
                                                                            }


																		}
																		
                                                                        					




																		gEx('txtDetalles').setValue(escaparBR(filaPena.data.detallesAdicionales.trim(),true));
																		cmbSiNoSustitutivo.setValue(filaPena.data.permiteSustitutivos);
																		cmbSiNoSustitutivo.fireEvent('select',cmbSiNoSustitutivo,cmbSiNoSustitutivo.getStore().getAt(obtenerPosFila(cmbSiNoSustitutivo.getStore(),'id',filaPena.data.permiteSustitutivos)));
																		var x;
																		var regSustitutivo=crearRegistro	(
																												[
																													{name: 'idSustitutivo'},
																													{name: 'acogeSustitutivo'},
																													{name: 'detallesAdicionales'},
																													{name: 'montoSustitutivo'},
																													{name: 'periodoSustitutivo'}
																												]	
																											)
																		var rSustitutivo;
																		var fSustitutivo;
																		for(x=0;x<filaPena.data.datosSustitutivos.length;x++)
																		{
																			fSustitutivo=filaPena.data.datosSustitutivos[x];
																			rSustitutivo=new regSustitutivo	(
																												{
																													idSustitutivo:fSustitutivo.idSustitutivo,
																													acogeSustitutivo:fSustitutivo.acogeSustitutivo,
																													detallesAdicionales:fSustitutivo.detallesAdicionales,
																													montoSustitutivo:fSustitutivo.montoSustitutivo,
																													periodoSustitutivo:fSustitutivo.periodoSustitutivo
																												}
																											)

																			gEx('gSustitutivo').getStore().add(rSustitutivo);
																		}

																		var regComputo=crearRegistro	(
																												[
																													{name: 'idComputo'},
																													{name: 'anos'},
																													{name: 'meses'},
																													{name: 'dias'},
																													{name: 'lugarDetencion'},
																													{name: 'especifique'}
																												]	
																											)
																		var filaAbono;
																		for(x=0;x<filaPena.data.arrComputoPrisionPreventiva.length;x++)
																		{
																			filaAbono=	filaPena.data.arrComputoPrisionPreventiva[x];
																			var r=new regComputo(filaAbono)
																			gEx('gridComputo').getStore().add(r);

																		}
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        if(gEx('dteFechaInicioPenaAct'))
                                                                        {
                                                                        	
                                                                        	gEx('dteFechaInicioPenaAct').setValue(filaPena.data.fechaInicio);
                                                                            gEx('dteFechaConpurgaPenaAct').setValue(filaPena.data.fechaFin);
                                                                            var aPrisionPunitiva=filaPena.data.abonoPrisionPunitiva.split('_');
                                                                            gEx('txtAniosPunitiva').setValue(aPrisionPunitiva[0]);
                                                                            gEx('txtMesesPunitiva').setValue(aPrisionPunitiva[1]);
                                                                            gEx('txtDiasPunitiva').setValue(aPrisionPunitiva[2]);
                                                                        }

																	}
																	
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',                                                            
															handler: function()
																	{
                                                                   		var cmbTipoPena=gEx('cmbTipoPena');
                                                                    	var cmbPena=gEx('cmbPena');
                                                                       	var cmbDetallePena=gEx('cmbDetallePena');
                                                                       	
                                                                        var txtAnios=gEx('txtAnios');
                                                                        var txtMeses=gEx('txtMeses');
                                                                        var txtDias=gEx('txtDias');
                                                                        var txtMonto=gEx('txtMonto');
                                                                        var cmbCentroDetencion=gEx('cmbCentroDetencion');
                                                                        var cmbSiNoSustitutivo=gEx('cmbSiNoSustitutivo');
                                                                        
                                                                        var datosSustitutivos='';
                                                                        
                                                                        if(cmbTipoPena.getValue()=='')
                                                                        {
                                                                        	function resp01()
                                                                            {
                                                                            	cmbTipoPena.focus();
                                                                            }
                                                                            msgBox('Debe indicar el tipo de pena impuesto',resp01);
                                                                            gEx('tabPanelPena').setActiveTab(0);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(cmbDetallePena.isVisible() && cmbDetallePena.getValue()=='')
                                                                        {
                                                                        	function resp02()
                                                                            {
                                                                            	cmbDetallePena.focus();
                                                                            }
                                                                            msgBox('Debe indicar especificar el detalle de la pena impuesta',resp02);
                                                                            gEx('tabPanelPena').setActiveTab(0);
                                                                        	return;
                                                                        }
                                                                        
																		if(cmbPena.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	cmbPena.focus();
                                                                            }
                                                                            msgBox('Debe indicar la pena impuesta',resp1);
                                                                            gEx('tabPanelPena').setActiveTab(0);
                                                                        	return;
                                                                        }
                                                                        var pos=obtenerPosFila(gEx('cmbPena').getStore(),'id',cmbPena.getValue());
                                                                        var registro=gEx('cmbPena').getStore().getAt(pos);
                                                                        
                                                                        var arrComplementario=registro.data.valorComp.split('_');
                                                                        var objDetalle='{}';
                                                                        switch(arrComplementario[0])
                                                                        {
                                                                            case '2'://Monto
                                                                                if((txtMonto.getValue()=='')||(txtMonto.getValue()<=0))
                                                                                {
                                                                                    function resp2()
                                                                                    {
                                                                                        txtMonto.focus();
                                                                                    }
                                                                                    msgBox('Debe indicar el monto impuesto',resp2);
                                                                                    gEx('tabPanelPena').setActiveTab(0);
                                                                                    return;
                                                                                }
                                                                                
                                                                                objDetalle='{"monto":"'+txtMonto.getValue()+'"}';
                                                                                
                                                                            break;
                                                                            case '5'://Periodo
                                                                                if(((txtAnios.getValue()=='')||(txtAnios.getValue()<=0))&&((txtMeses.getValue()=='')||(txtMeses.getValue()<=0))&&((txtDias.getValue()=='')||(txtDias.getValue()<=0)))
                                                                                {
                                                                                	function resp3()
                                                                                    {
                                                                                        txtAnios.focus();
                                                                                    }
                                                                                    msgBox('Debe indicar el periodo de duraci&oacute;n de la pena impuesta',resp3);
                                                                                    gEx('tabPanelPena').setActiveTab(0);
                                                                                    return;
                                                                                }
                                                                                
                                                                                objDetalle='{"anios":"'+(gEx('txtAnios').getValue()==''?0:gEx('txtAnios').getValue())+'","meses":"'+
                                                                                			(gEx('txtMeses').getValue()==''?0:gEx('txtMeses').getValue())+'","dias":"'+
                                                                                            (gEx('txtDias').getValue()==''?0:gEx('txtDias').getValue())+'"}';
                                                                            break;
                                                                        }
                                                                        
                                                                        if(cmbPena.getValue()=='1')
                                                                        {
                                                                        	if(cmbCentroDetencion.getValue()=='')
                                                                            {
                                                                                function resp4()
                                                                                {
                                                                                    cmbCentroDetencion.focus();
                                                                                }
                                                                                msgBox('Debe indicar el centro de detenci&oacute;n en el cual se encuentra actualmente el sentenciado',resp4);
                                                                                gEx('tabPanelPena').setActiveTab(0);
                                                                                return;
                                                                            }
                                                                        }
                                                                        
                                                                        
                                                                        if(cmbPena.getValue()=='10')
                                                                        {
                                                                        	if(gEx('txtDetalles').getValue().trim()=='')
                                                                            {
                                                                                function resp400()
                                                                                {
                                                                                    gEx('txtDetalles').focus();
                                                                                }
                                                                                msgBox('Debe describir los objetos decomisados',resp400);
                                                                                gEx('tabPanelPena').setActiveTab('pDetalles');
                                                                                return;
                                                                            }
                                                                            var lblTiposObjetos='';
                                                                            var aObjetos=gEx('boxDecomiso').getValue();
                                                                            
                                                                            if(aObjetos.length==0)
                                                                            {
                                                                                function resp450()
                                                                                {
                                                                                    
                                                                                }
                                                                                msgBox('Debe indicar el tipo de decomiso realizado',resp450);
                                                                                gEx('tabPanelPena').setActiveTab(0);
                                                                                return;
                                                                            }
                                                                            var c=0;
                                                                            for(c=0;c<aObjetos.length;c++)
                                                                            {
                                                                            	if(lblTiposObjetos=='')
                                                                                	lblTiposObjetos=aObjetos[c].value;
                                                                                else
                                                                                	lblTiposObjetos+=","+aObjetos[c].value;
                                                                                
                                                                            }
                                                                            objDetalle='{"tiposObjetos":"'+lblTiposObjetos+'"}';
                                                                            
                                                                        }
                                                                        
                                                                        
                                                                         if((cmbDetallePena.isVisible()) &&(txtMonto.isVisible()) &&(txtMonto.getValue()==''))
                                                                         {
                                                                              function resp200()
                                                                              {
                                                                                  txtMonto.focus();
                                                                              }
                                                                              msgBox('Debe indicar el monto impuesto',resp200);
                                                                              gEx('tabPanelPena').setActiveTab(0);
                                                                              return;
                                                                         }
                                                                         else
                                                                         {
                                                                         	if((cmbDetallePena.isVisible()) &&(txtMonto.isVisible()))
                                                                            {
                                                                            	objDetalle='{"monto":"'+txtMonto.getValue()+'"}';
                                                                            }
                                                                         }
                                                                        
                                                                        if(cmbSiNoSustitutivo.getValue()=='1')
                                                                        {
                                                                        	if(gEx('gSustitutivo').getStore().getCount()==0)
                                                                            {
                                                                            
                                                                            	msgBox('Almenos debe ingresar un sustitutivo de la pena');
                                                                               	gEx('tabPanelPena').setActiveTab('pSustitutivoPena');
                                                                            	return;
                                                                            }
                                                                        }
                                                                        
                                                                        var x;
                                                                        var filaSustitutivo;
                                                                        var o;
                                                                        for(x=0;x<gEx('gSustitutivo').getStore().getCount();x++)
                                                                        {
                                                                        	filaSustitutivo=gEx('gSustitutivo').getStore().getAt(x);
                                                                            o='{"idSustitutivo":"'+filaSustitutivo.data.idSustitutivo+'","acogeSustitutivo":"'+filaSustitutivo.data.acogeSustitutivo+
                                                                            	'","detallesAdicionales":"'+cv(filaSustitutivo.data.detallesAdicionales)+'","montoSustitutivo":"'+
                                                                                filaSustitutivo.data.montoSustitutivo+'","periodoSustitutivo":"'+filaSustitutivo.data.periodoSustitutivo+'"}';
                                                                        	if(datosSustitutivos=='')
                                                                            	datosSustitutivos=o;
                                                                            else
                                                                            	datosSustitutivos+=','+o;
                                                                        }
                                                                        
                                                                        
                                                                        var idRegistro=-1;
                                                                        if(filaPena)
                                                                        	idRegistro=filaPena.data.idRegistro;
                                                                        else
                                                                        {
                                                                        	pos=obtenerPosFila(gEx('gSentencia').getStore(),'id',cmbPena.getValue());
                                                                            if(pos!=-1)
                                                                            {
                                                                            	msgBox('La pena seleccionada ya ha sido registrada previamente');
                                                                            	return;
                                                                            }
                                                                        }
                                                                        
                                                                        var arrDelitos='';
                                                                        var fila;
                                                                        for(x=0;x<gEx('gDelitos').getStore().getCount();x++)
                                                                        {
                                                                        	fila=gEx('gDelitos').getStore().getAt(x);
                                                                            if(fila.data.incluido)
                                                                            {
                                                                            	if(arrDelitos=='')
                                                                                	arrDelitos=fila.data.idDelito;
                                                                                else
                                                                                	arrDelitos+=','+fila.data.idDelito;
                                                                            }
                                                                            
                                                                            
                                                                        }
                                                                        
                                                                        if(arrDelitos=='')
                                                                        {
                                                                        	msgBox('Almenos debe seleccionar un delito por el cual se impone la pena');
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        var arrAbonoPrisionPreventiva='';
                                                                        var fila;
                                                                        var gridComputo=gEx('gridComputo');
                                                                        for(x=0;x<gridComputo.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gridComputo.getStore().getAt(x);
                                                                        	oAbono='{"anos":"'+fila.data.anos+'","meses":"'+fila.data.meses+
                                                                        		'","dias":"'+fila.data.dias+'","lugarDetencion":"'+cv(fila.data.lugarDetencion)+
                                                                        		'","especifique":"'+fila.data.especifique+'"}';
                                                                        	if(arrAbonoPrisionPreventiva=='')
                                                                        		arrAbonoPrisionPreventiva=oAbono;
                                                                        	else
                                                                        		arrAbonoPrisionPreventiva+=','+oAbono;
                                                                        	
                                                                        	
                                                                        }
                                                                        
                                                                        
                                                                        var valComp='';
                                                                        if((esActualizacionCarpeta)&&(gEx('pAbonoPrisionPunitiva').isVisible()))
                                                                        {
                                                                        	var lblAbonoPrision=(gEx('txtAniosPunitiva').getValue()==''?'0':gEx('txtAniosPunitiva').getValue()+'');
                                                                            lblAbonoPrision+='_'+(gEx('txtMesesPunitiva').getValue()==''?'0':gEx('txtMesesPunitiva').getValue());
                                                                            lblAbonoPrision+='_'+(gEx('txtDiasPunitiva').getValue()==''?'0':gEx('txtDiasPunitiva').getValue());
                                                                            
                                                                            
                                                                            if(gEx('dteFechaInicioPenaAct').getValue()=='')
                                                                            {
                                                                            	msgBox('Debe ingresar la fecha de inicio de la pena');
                                                                                gEx('tabPanelPena').setActiveTab('pAbonoPrisionPunitiva');
                                                                            	return;
                                                                            }
                                                                            
                                                                           
                                                                            
                                                                        	valComp=',"abonoPrisionPunitiva":"'+lblAbonoPrision+'","fechaInicio":"'+gEx('dteFechaInicioPenaAct').getValue().format('Y-m-d')+
                                                                            		'","fechaTermino":"'+gEx('dteFechaConpurgaPenaAct').getValue().format('Y-m-d')+'"';
                                                                        }
                                                                        var obj='{"idRegistro":"'+idRegistro+'","idActividad":"'+idActividad+'","idPena":"'+cmbPena.getValue()+'","objDetalle":'+objDetalle+
                                                                        		',"centroDetencion":"'+(cmbCentroDetencion.getValue()==''?-1:cmbCentroDetencion.getValue())+
                                                                                '","detallesAdicionales":"'+cv((gEx('txtDetalles') && gEx('txtDetalles').getValue())?gEx('txtDetalles').getValue():'')+'","permiteSustitutivo":"'+
                                                                                cmbSiNoSustitutivo.getValue()+'","datosSustitutivos":['+datosSustitutivos+'],"arrDelitos":"'+arrDelitos+
                                                                                '","arrAbonoPrisionPreventiva":['+arrAbonoPrisionPreventiva+'],"tipoPena":"'+cmbTipoPena.getValue()+
                                                                                '","detallePena":"'+(cmbDetallePena.isVisible()?cmbDetallePena.getValue():-1)+'"'+valComp+'}';
                                                                        
                                                                        
                                                                        
                                                                        <?php
																		if($_SESSION["idUsr"]==1)
																		{
																			?>
																			/*alert(obj);
																			return;*/
                                                                            <?php
																		}
																		?>        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gSentencia').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=113&cadObj='+obj,true);
                                                                        
                                                                        
                                                                        
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
   	gEx('tabPanelPena').hideTabStripItem('pAbonoPrision');
    gEx('tabPanelPena').hideTabStripItem('pAbonoPrisionPunitiva');
    gEx('tabPanelPena').hideTabStripItem('pSustitutivoPena');
    
    
    
}

function formatearFilaSentencia(registro, numFila, rp, ds)
{
	var aPena=[];
	var penaDetalle='';
	var lblDetallePena='';
    var lblDetallesPenaValor='';
    var oDetalle='';
    var objDetalle=registro.data.objDetalle;
    var periodoPena=false;
    if(objDetalle!='')
    {
    	oDetalle=eval('['+objDetalle+']')[0];
        if(oDetalle.monto)
        {
        	lblDetallePena='Monto: ';
            lblDetallesPenaValor=Ext.util.Format.usMoney(oDetalle.monto);
        }
        
        if(oDetalle.tiposObjetos)
        {
        	lblDetallePena='Tipo de decomiso: ';
            
            var arrTiposObjetos=oDetalle.tiposObjetos.split(',');
            var a=0;
            for(a=0;a<arrTiposObjetos.length;a++)
            {
            	if(lblDetallesPenaValor=='')
                {
                	lblDetallesPenaValor=formatearValorRenderer(arrDecomisoValores,arrTiposObjetos[a]);
                }
                else
                	lblDetallesPenaValor+=', '+formatearValorRenderer(arrDecomisoValores,arrTiposObjetos[a]);
            }   
               
            
        }
        
        
        if(oDetalle.anios)
        {
        	periodoPena=true;
        	lblDetallePena='Duraci&oacute;n de la pena: ';
            lblDetallesPenaValor=oDetalle.anios+' a&ntilde;os, '+oDetalle.meses+' meses, '+oDetalle.dias+' dias';
            aPena[0]=parseInt(oDetalle.anios);
            aPena[1]=parseInt(oDetalle.meses);
            aPena[2]=parseInt(oDetalle.dias);
            
            if(registro.data.idPena=='1')
            	lblDetallesPenaValor+='. <span class="TSJDF_Etiqueta">Centro de detenci&oacute;n: </span>'+formatearValorRenderer(arrCentrosDetencion,registro.data.centroDetencion);
            
            
        }
    }
    
    if(registro.data.detallePena!='-1')
    {
    	penaDetalle='<br>( '+formatearValorRenderer(arrDetallesPena,registro.data.detallePena)+' )';
    }
    
	var lblTable	='<table>'+
                        '<tr height="21">'+
                            '<td width="130" valign="top"><span class="TSJDF_Etiqueta">Pena impuesta:</span></td><td valign="top"><span class="TSJDF_Control">'+formatearValorRenderer(arrPenas,registro.data.idPena)+penaDetalle+'</span></td>'+
                        '</tr>';
                        
	
                       
                        
   	lblTable+=          '<tr height="21">'+
                            '<td width="130" valign="top"><span class="TSJDF_Etiqueta">Delitos:</span></td><td valign="top"><span class="TSJDF_Control">'+registro.data.delitos+'</span></td>'+
                        '</tr>'
                        ;
	
    
    
    if(lblDetallePena!='')
    { 
    	lblTable+=                   
                    '<tr height="21">'+
                        '<td width="130" valign="top"><span class="TSJDF_Etiqueta">'+lblDetallePena+'</span></td><td valign="top"><span class="TSJDF_Control">'+lblDetallesPenaValor+'</span></td>'+
                    '</tr>';
		if(periodoPena)
		{
		
			var totalAbono=[];
			var tAbono=[];
			totalAbono[0]=0;
			totalAbono[1]=0;
			totalAbono[2]=0;
			var x;
			var filaC;
			for(x=0;x<registro.data.arrComputoPrisionPreventiva.length;x++)
			{
				filaC=registro.data.arrComputoPrisionPreventiva[x];
				tAbono=[];
				tAbono[0]=parseInt(filaC.anos);
				tAbono[1]=parseInt(filaC.meses);
				tAbono[2]=parseInt(filaC.dias);
				totalAbono=sumarComputo(totalAbono,tAbono);
			}
			
			var diferencia=restarComputo(aPena,totalAbono);
			var lblFilaPrisionPunitiva='';
            
            if(registro.data.abonoPrisionPunitiva!='')
            {
            	var aPrisionPunitiva=registro.data.abonoPrisionPunitiva.split('_');
                lblFilaPrisionPunitiva=	'<tr height="21">'+
                                            '<td width="130" valign="top"><span class="TSJDF_Etiqueta">Abono de prisi&oacute;n punitiva:</span></td><td valign="top"><span class="TSJDF_Control">'+convertirLeyendaComputo(aPrisionPunitiva)+'</span></td>'+
                                        '</tr>';
                                        
             	diferencia=restarComputo(diferencia,aPrisionPunitiva);                           
            }
            
			lblTable+=''+
			'<tr height="21">'+
				'<td width="130" valign="top"><span class="TSJDF_Etiqueta">Abono de prisi&oacute;n preventiva:</span></td><td valign="top"><span class="TSJDF_Control">'+convertirLeyendaComputo(totalAbono)+'</span></td>'+
			'</tr>'+lblFilaPrisionPunitiva+
			'<tr height="21">'+
				'<td width="130" valign="top"><span class="TSJDF_Etiqueta">Pena por cumplir:</span></td><td valign="top"><span class="TSJDF_Control">'+convertirLeyendaComputo(diferencia)+'</span></td>'+
			'</tr>'; 
            
                            
			if(registro.data.fechaInicio!='')
            {
            	lblTable+=''+
                        '<tr height="21">'+
                            '<td width="130" valign="top"><span class="TSJDF_Etiqueta">Fecha de inicio de pena:</span></td><td valign="top"><span class="TSJDF_Control">'+Date.parseDate(registro.data.fechaInicio,'Y-m-d').format('d/m/Y')+'</span></td>'+
                        '</tr>'+
                        '<tr height="21">'+
                            '<td width="130" valign="top"><span class="TSJDF_Etiqueta">Fecha de compurga:</span></td><td valign="top"><span class="TSJDF_Control">'+Date.parseDate(registro.data.fechaFin,'Y-m-d').format('d/m/Y')+'</span></td>'+
                        '</tr>'; 
            }
		}                    
	} 
    
    lblTable+=                   
                '<tr height="21">'+
                    '<td width="130" valign="top"><span class="TSJDF_Etiqueta">Detalles adicionales:</span></td><td valign="top"><span class="TSJDF_Control">'+(registro.data.detallesAdicionales.trim()==''?'(Sin detalles)':escaparBR(registro.data.detallesAdicionales.trim(),true))+'</span></td>'+
                '</tr>'+
                '<tr height="21">'+
                    '<td width="265" valign="top"><span class="TSJDF_Etiqueta">Se permite algún sustitutivo de la pena?:</span></td><td valign="top"><span class="TSJDF_Control">'+formatearValorRenderer(arrSiNo,registro.data.permiteSustitutivos)+'</span></td>'+
                '</tr>';
    
    
    if(registro.data.permiteSustitutivos=='1')
    {
    	var x;
        var r;
        lblTable+='<tr><td colspan="2"><b><span class="TSJDF_Etiqueta">Sustitutivos concedidos:</span></b></td></tr>'+
        			'<tr><td colspan="2">'+
                    	'<table width="880"><tr><td width="200"><span style="font-size:11px; color:#900; font-weight:bold">Sustitutivo</span></td>'+
                        '<td width="200"> <span style="font-size:11px; color:#900; font-weight:bold">Descripci&oacute;n</span></td>'+
                        '<td width="80"> <span style="font-size:11px; color:#900; font-weight:bold">Se acoge</span></td>'+
                        '<td width="400"> <span style="font-size:11px; color:#900; font-weight:bold">Detalles adicionales</span></td><tr>';
        for(x=0;x<registro.data.datosSustitutivos.length;x++)
        {
        	
        	r=registro.data.datosSustitutivos[x];
            var lblDetalle='';
            if(r.montoSustitutivo!='')
            	lblDetalle='<b>Monto:</b> '+Ext.util.Format.usMoney(r.montoSustitutivo);
                
            if(r.periodoSustitutivo!='') 
            {
            	var arrPeriodo=r.periodoSustitutivo.split('|');
                lblDetalle='<b>Periodo:</b> '+arrPeriodo[0]+' a&ntilde;os, '+arrPeriodo[1]+' meses, '+arrPeriodo[2]+' dias';
            }   
                
            lblTable+='<tr><td><span style="font-size:11px; color:#444;">'+formatearValorRenderer(arrSustitutivo,r.idSustitutivo)+
            			'</span></td><td><span style="font-size:11px; color:#444;">'+lblDetalle+'</span></td><td><span style="font-size:11px; color:#444;">'+
                        formatearValorRenderer(arrSiNoIndeterminado,r.acogeSustitutivo)+
            			'</span></td><td><span style="font-size:11px; color:#444;">'+(r.detallesAdicionales.trim()==''?'(Sin detalles)':r.detallesAdicionales.trim())+'</span></td></tr>';
        }
    	lblTable+='</table></td></tr>';
    	
    }
    
    lblTable+=	'</table><br><br>';
    
    rp.body=lblTable;	
}

function crearGridComputoPrisionPreventiva()
{
	var dsDatos=arrComputoCumplido;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idComputo'},
                                                                    {name: 'anos'},
                                                                    {name: 'meses'},
                                                                    {name: 'dias'},
                                                                    {name: 'lugarDetencion'},
                                                                    {name: 'especifique'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
    var cmbAniosGrid=crearComboExt('cmbAniosGrid',arrAniosComputo,0,0);
    var cmbMesesGrid=crearComboExt('cmbMesesGrid',arrMesesComputo,0,0);
    var cmbDiasGrid=crearComboExt('cmbDiasGrid',arrDiasComputo,0,0);
    var cmbCentroReclusion=crearComboExt('cmbCentroReclusion',arrReclusorios,190,55,350);
    
    cmbCentroReclusion.on('select',function(cmb,registro)
    								{
                                    	if(registro.data.id=='0')
                                        {
                                        	gEx('txtEspecifique').enable();
                                            gEx('txtEspecifique').focus(false,10);
                                            
                                        }
                                        else
                                        {
                                        	gEx('txtEspecifique').disable();
                                            gEx('txtEspecifique').setValue('');
                                        }
                                    }
    					)
    
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	
														chkRow,
														{
															header:'A&ntilde;os',
															width:45,
															sortable:true,
                                                            editor:cmbAniosGrid,
															dataIndex:'anos'
														},
														{
															header:'Meses',
															width:45,
															sortable:true,
                                                            editor:cmbMesesGrid,
															dataIndex:'meses'
														},
                                                        {
															header:'D&iacute;as',
															width:45,
															sortable:true,
                                                            editor:cmbDiasGrid,
															dataIndex:'dias'
														},
                                                        {
															header:'Centro de detenci&oacute;n',
															width:390,
															sortable:true,
                                                            editor:cmbCentroReclusion,
															dataIndex:'lugarDetencion',
                                                            renderer:function(val)
                                                            			{
                                                                        	return formatearValorRenderer(arrReclusorios,val);
                                                                        }
														},
                                                        {
															header:'Otro: Especifique',
															width:320,
															sortable:true,
                                                            editor:{xtype:'textfield',id:'txtEspecifique',disabled:true},
															dataIndex:'especifique',
                                                            renderer:function(val)
                                                            			{
                                                                        	return mostrarValorDescripcion(val);
                                                                        }
														}
													]
												);
    
     var editorFila=new Ext.ux.grid.RowEditor	(
                                                        {
                                                            id:'editorFila',
                                                            saveText: 'Guardar',
                                                            cancelText:'Cancelar',
                                                            clicksToEdit:2
                                                        }
                                                    );
    
    
    editorFila.on('beforeedit',funcEditorFilaBeforeEdicion)
    editorFila.on('validateedit',funcEditorValidaEdicion);
    editorFila.on('canceledit',funcEditorCancelEdicion);
	editorFila.on('afteredit',function(){calcularTotalComputoPrisionPreventiva();calcularPenaCumplir();}) ;                                               
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridComputo',
                                                            store:alDatos,
                                                            frame:false,
                                                            border:true,
                                                            y:10,
                                                            x:10,
                                                            plugins:[editorFila],
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            columnLines : true,
                                                            height:190,
                                                            width:750,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	id:'btnAgregar',
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:!esRegistroFormulario(),
                                                                            text:'Agregar c&oacute;mputo',
                                                                            handler:function()
                                                                            		{
                                                                                       	var tblGrid=gEx('gridComputo');
                                                                                        var editorFila=gEx('editorFila');
                                                                                        var registroGrid=crearRegistro(	[
                                                                                        									{name: 'idComputo'},
                                                                                                                            {name: 'anos'},
                                                                                                                            {name: 'meses'},
                                                                                                                            {name: 'dias'},
                                                                                                                            {name: 'lugarDetencion'},
                                                                                                                            {name: 'especifique'}
                                                                                        								]);
                                                                                        
                                                      
                                                                                        
                                                                                        var nReg=new registroGrid	(
                                                                                                                        {
                                                                                                                        	idComputo:0,
                                                                                                                            anos:0,
                                                                                                                            meses:0,
                                                                                                                            dias:0,
                                                                                                                            lugarDetencion:'',
                                                                                                                            especifique:''
                                                                                                                        }
                                                                                                                    )
                                                                                        
                                                                                        editorFila.stopEditing();
                                                                                        tblGrid.getStore().add(nReg);
                                                                                        tblGrid.nuevoRegistro=true;
                                                                                        editorFila.startEditing(tblGrid.getStore().getCount()-1);	
                                                                                        Ext.getCmp('btnAgregar').disable();
                                                                                        Ext.getCmp('btnRemover').disable();	
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	id:'btnRemover',
                                                                            hidden:!esRegistroFormulario(),
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover c&oacute;mputo',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el c&oacute;mputo de prisi&oacute;n preventiva que desea remover');
                                                                                            return;
                                                                                            
                                                                                        }
                                                                                    	function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	tblGrid.getStore().remove(fila)
                                                                                                calcularTotalComputoPrisionPreventiva();
                                                                                                calcularPenaCumplir();
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el c&oacute;mputo de prisi&oacute;n preventiva seleccionado?',resp);
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );

	
	 tblGrid.on('beforeedit',function(e)
    						{
                            	e.cancel=!esRegistroFormulario();
                            }
    			);
	return tblGrid;

}

function funcEditorFilaBeforeEdicion(rowEdit,fila)
{
	if(!esRegistroFormulario())
    	return false;
	var idGrid='gridComputo';
	var grid=Ext.getCmp(idGrid);
    grid.copiaRegistro=grid.getStore().getAt(fila).copy();
    grid.registroEdit=grid.getStore().getAt(fila);
	if((grid.soloLectura)&&(!grid.nuevoRegistro))
		return false;
}

function funcEditorValidaEdicion(rowEdit,obj,registro,nFila)
{
	var idGrid='gridComputo';
	var grid=Ext.getCmp(idGrid);
	var cm=grid.getColumnModel();
	var nColumnas=cm.getColumnCount(false);
    if(capturado)
    {
    	return false;
    }
    capturado=true;
	var x;
	var total=parseInt(obj.anos)+parseInt(obj.meses)+parseInt(obj.dias);
    if(total==0)
    {
    	 msgBox('Debe indicar el tiempo que el imputado cumpli&oacute; prisi&oacute;n preventiva');
         capturado=false;
         return false;
    }
    else
	{
        if(obj.lugarDetencion=='')
        {
            msgBox('Debe indicar el centro de detenci&oacute;n en el cual el imputado cumpli&oacute; la prisi&oacute;n');
            capturado=false;
            return false;
        }
   	}
    Ext.getCmp('btnRemover').enable();
	Ext.getCmp('btnAgregar').enable();
    grid.nuevoRegistro=false;
    capturado=false;
    calcularTotalComputoPrisionPreventiva();
    calcularPenaCumplir();
    return true;
}

function funcEditorCancelEdicion(rowEdit,cancelado)
{

	var idGrid='gridComputo';
	var grid=Ext.getCmp(idGrid);
	if(grid.nuevoRegistro)
    {
		grid.getStore().removeAt(grid.getStore().getCount()-1);
        grid.nuevoRegistro=false;
        Ext.getCmp('btnRemover').enable();
	    Ext.getCmp('btnAgregar').enable();
        return;
    }
	Ext.getCmp('btnRemover').enable();
    Ext.getCmp('btnAgregar').enable();
    var copiaRegistro=grid.copiaRegistro;
    
    var x=0;
    var arrCampos=grid.getStore().fields;
    var filaDestino=grid.registroEdit;

    for(x=0;x<arrCampos.items.length;x++)
    {
    	filaDestino.set(arrCampos.items[x].name,copiaRegistro.get(arrCampos.items[x].name));

    }
	
    
	grid.nuevoRegistro=false;
	
}

function calcularTotalComputoPrisionPreventiva()
{
	var gridComputo=gEx('gridComputo');
    var x;
    var fila;
    var arrComputo=[];
    
    arrComputo[0]=0;
    arrComputo[1]=0;
    arrComputo[2]=0;
    
    var arrValor2=[];

    arrValor2[0]=0;
    arrValor2[1]=0;
    arrValor2[2]=0;
    
    for(x=0;x<gridComputo.getStore().getCount();x++)
    {
    	fila=gridComputo.getStore().getAt(x);
        
        arrValor2[0]=fila.data.anos;
        arrValor2[1]=fila.data.meses;
        arrValor2[2]=fila.data.dias;
        arrComputo=sumarComputo(arrComputo,arrValor2);
        
    }
    var arrResultado=[];
    arrResultado[0]=arrComputo;
    arrResultado[1]=convertirLeyendaComputo(arrComputo);
    
    var txtAnios=gEx('txtAnios');
	var txtMeses=gEx('txtMeses');
	var txtDias=gEx('txtDias');
    
    var arrSentencia=[];
    arrSentencia[0]=txtAnios.getValue()==''?0:parseInt(txtAnios.getValue());
    arrSentencia[1]=txtMeses.getValue()==''?0:parseInt(txtMeses.getValue());
    arrSentencia[2]=txtDias.getValue()==''?0:parseInt(txtDias.getValue());
    
    if(gE('lblTotalComputo'))
	    gE('lblTotalComputo').innerHTML= arrResultado[1];  
    
    var restoSentencia=restarComputo(arrSentencia,arrResultado[0]);
    if(gE('lblTotalSentenciaCumplir'))
	    gE('lblTotalSentenciaCumplir').innerHTML=convertirLeyendaComputo(restoSentencia);
    return arrResultado;
}

function funcionPrepararGuardado()
{
	
    var x;
    var fila;
    var o;
   	var arrComputoCumplido='';
    
   
    var x;
    for(x=0;x<gEx('gridComputo').getStore().getCount();x++)
    {
    	fila=gEx('gridComputo').getStore().getAt(x);
        o='{"anos":"'+(fila.data.anos==''?0:fila.data.anos)+'","meses":"'+(fila.data.meses==''?0:fila.data.meses)+
        	'","dias":"'+(fila.data.dias==''?0:fila.data.dias)+'","lugarDetencion":"'+fila.data.lugarDetencion+
            '","especifique":"'+cv(fila.data.especifique)+'"}';
        
    	if(arrComputoCumplido=='')
        	arrComputoCumplido=o;
        else
        	arrComputoCumplido+=','+o;
    
    }
    
    
    
    var objRegistro='{"arrComputo":['+arrComputoCumplido+']}';

	var id=gE('idRegistroG').value;
                        
	if(id=='-1')
    {
        gE('funcPHPEjecutarNuevo').value=bE('registrarComputoPrisionCumplida(@idRegPadre,\''+bE(objRegistro)+'\')');
    }
    else
    {
        gE('funcPHPEjecutarModif').value=bE('registrarComputoPrisionCumplida('+id+',\''+bE(objRegistro)+'\')');
    }
                        

    return true;                
    
}

function crearGridSustitutivo()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idSustitutivo'},
                                                                    {name: 'acogeSustitutivo'},
                                                                    {name: 'detallesAdicionales'},
                                                                    {name: 'montoSustitutivo'},
                                                                    {name: 'periodoSustitutivo'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	
														chkRow,
														{
															header:'Sustitutivo',
															width:330,
															sortable:true,
															dataIndex:'idSustitutivo',
                                                            renderer:function(val)
                                                            		{
                                                                    	return mostrarValorDescripcion(formatearValorRenderer(arrSustitutivo,val));
                                                                    }
														},
                                                        {
															header:'',
															width:200,
															sortable:true,
															dataIndex:'idSustitutivo',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	if(registro.data.montoSustitutivo!='')
                                                                        {
                                                                        	return '<b>Monto: </b> '+Ext.util.Format.usMoney(registro.data.montoSustitutivo);
                                                                        }
                                                                        if(registro.data.periodoSustitutivo!='')
                                                                        {
                                                                        	var arrPeriodo=registro.data.periodoSustitutivo.split('|');
                                                                            
                                                                        	return mostrarValorDescripcion('<b>Periodo: </b> '+arrPeriodo[0]+' a&ntilde;os, '+arrPeriodo[1]+' meses, '+arrPeriodo[2]+' dias');
                                                                        }
                                                                        
                                                                    	return '';
                                                                    }
														},
														{
															header:'Se acoge al sustitutivo',
															width:140,
															sortable:true,
															dataIndex:'acogeSustitutivo',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrSiNo,val);
                                                                    }
														}/*,
                                                        {
															header:'Detalles adicionales',
															width:400,
															sortable:true,
                                                            renderer:mostrarValorDescripcion,
															dataIndex:'detallesAdicionales'
														}*/
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gSustitutivo',
                                                            store:alDatos,
                                                            frame:false,
                                                            x:10,
                                                            y:45,
                                                            disabled:true,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            height:280,
                                                            width:750,
                                                            sm:chkRow,
                                                            view: new Ext.grid.GridView({
                                                                                            enableRowBody:true,
                                                                                            getRowClass:formatearFilaSustitutivo,
                                                                                        }),
                                                            
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar sustitutivo',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaAgregarSustitutivo();
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover sustitutivo',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gSustitutivo').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el sustitutivo que desea remover');
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	gEx('gSustitutivo').getStore().remove(fila);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el sustitutivo seleccionado?',resp);
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;	
}

function mostrarVentanaAgregarSustitutivo()
{
	var aSustitutivo=[];
	
	var cmbTipoPena=gEx('cmbPena');
	var x;
	
	for(x=0;x<arrSustitutivo.length;x++)
	{
		if(arrSustitutivo[x][3]==cmbTipoPena.getValue())
		{
			aSustitutivo.push([arrSustitutivo[x][0],arrSustitutivo[x][1],arrSustitutivo[x][2]]);
		}
	}
	
	var cmbSustitutivo=crearComboExt('cmbSustitutivo',aSustitutivo,130,0,350);
    cmbSustitutivo.on('select',function(cmb,registro)
    								{
                                    	var arrComplementario=registro.data.valorComp.split('_');
                                        switch(arrComplementario[0])
                                        {
                                            case '2'://Monto
                                                gE('lblMontoSustitutivo').innerHTML='Monto:';
                                                gEx('txtMontoSustitutivo').show();
                                                gEx('fsPeriodoSustitutivo').hide();
                                                gEx('txtAniosSustitutivos').setValue(0);
                                                gEx('txtMesesSustitutivos').setValue(0);
                                                gEx('txtDiasSustitutivos').setValue(0);
                                            break;
                                            case '5'://Periodo
                                                gE('lblMontoSustitutivo').innerHTML='Periodo:';
                                                gEx('fsPeriodoSustitutivo').show();
                                                gEx('txtMontoSustitutivo').hide();
                                            break;
                                            default:
                                                gE('lblMontoSustitutivo').innerHTML='';
                                                gEx('fsPeriodoSustitutivo').hide();
                                                gEx('txtMontoSustitutivo').hide();
                                            break;
                                            
                                            
                                        }
                                    }
    					)
                        
    
    
    var cmbAcogeSustitutivo=crearComboExt('cmbAcogeSustitutivo',arrSiNoIndeterminado,150,80,120);
   
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                            x:10,
                                                            y:5,
                                                            xtype:'label',
                                                            html:'Sustitutivo:'
                                                            
                                                        },
                                                        cmbSustitutivo,
                                                        {
                                                            x:10,
                                                            y:35,
                                                            xtype:'label',
                                                            
                                                            id:'lblMontoSustitutivo',
                                                            html:'<span id="spMultaSustitutivo"></span>'
                                                        },
                                                        {
                                                            x:130,
                                                            y:30,
                                                            hidden:true,
                                                            allowDecimals:true,
                                                            allowNegative:false,
                                                            xtype:'numberfield',
                                                            width:120,
                                                            id:'txtMontoSustitutivo'
                                                        },
                                                        {
                                                            xtype:'fieldset',
                                                            width:200,
                                                            height:60,
                                                            x:110,
                                                            y:20,
                                                            hidden:true,
                                                            id:'fsPeriodoSustitutivo',
                                                            border:false,
                                                            layout:'absolute',
                                                            items:	[
                                                                        {
                                                                            x:10,
                                                                            y:0,
                                                                            xtype:'numberfield',
                                                                            allowDecimals:false,
                                                                            alowNegative:false,
                                                                            width:40,
                                                                            value:0,
                                                                            id:'txtAniosSustitutivos'
                                                                        },
                                                                        {
                                                                            xtype:'label',
                                                                            html:'A&ntilde;os',
                                                                            x:15,
                                                                            y:25
                                                                        },
                                                                        {
                                                                            x:70,
                                                                            y:0,
                                                                            xtype:'numberfield',
                                                                            width:40,
                                                                            allowDecimals:false,
                                                                            alowNegative:false,
                                                                            value:0,
                                                                            id:'txtMesesSustitutivos'
                                                                        },
                                                                        {
                                                                            xtype:'label',
                                                                            html:'Meses',
                                                                            x:75,
                                                                            y:25
                                                                        },
                                                                        {
                                                                            x:130,
                                                                            y:0,
                                                                            xtype:'numberfield',
                                                                            width:40,
                                                                            value:0,
                                                                            allowDecimals:false,
                                                                            alowNegative:false,
                                                                            id:'txtDiasSustitutivos'
                                                                        },
                                                                        {
                                                                            xtype:'label',
                                                                            html:'D&iacute;as',
                                                                            x:135,
                                                                            y:25
                                                                        }
                                                                         
                                                                    ]
                                                        },
                                                        
                                                        {
                                                            x:10,
                                                            y:85,
                                                            xtype:'label',
                                                            html:'Se acoge al sustitutivo?:'
                                                        },
                                                        cmbAcogeSustitutivo,
                                                        {
                                                            x:10,
                                                            y:115,
                                                            xtype:'label',
                                                            html:'Detalles adicionales:'
                                                        },
                                                        {
                                                            x:150,
                                                            y:110,
                                                            xtype:'textarea',
                                                            width:500,
                                                            height:50,
                                                            id:'txtDetallesSustitutivo'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar sustitutivo',
										width: 700,
										height:250,
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
																		var cmbSustitutivo=gEx('cmbSustitutivo');
                                                                        var txtMontoSustitutivo=gEx('txtMontoSustitutivo');
                                                                        var txtAniosSustitutivos=gEx('txtAniosSustitutivos');
                                                                        var txtMesesSustitutivos=gEx('txtMesesSustitutivos');
                                                                        var txtDiasSustitutivos=gEx('txtDiasSustitutivos');
                                                                        
                                                                        
                                                                        if(cmbSustitutivo.getValue()=='')
                                                                        {
                                                                            function resp5()
                                                                            {
                                                                                cmbSustitutivo.focus();
                                                                            }
                                                                            msgBox('Debe indicar el sustitutivo de la pena impuesta',resp5);
                                                                            return;
                                                                        }
                                                                                                                                                    
                                                                        pos=obtenerPosFila(gEx('cmbSustitutivo').getStore(),'id',cmbSustitutivo.getValue());
                                                                        registro=gEx('cmbSustitutivo').getStore().getAt(pos);
                                                                        arrComplementario=registro.data.valorComp.split('_');
                                                                        datosSustitutivos='{"sustitutivo":"'+cmbSustitutivo.getValue()+'"';
                                                                        
                                                                        
                                                                        var oSustitutivo={};
                                                                        oSustitutivo.idSustitutivo=cmbSustitutivo.getValue();
                                                                        oSustitutivo.montoSustitutivo='';
                                                                        oSustitutivo.periodoSustitutivo='';
                                                                        switch(arrComplementario[0])
                                                                        {
                                                                            case '2'://Monto
                                                                                if((txtMontoSustitutivo.getValue()=='')||(txtMontoSustitutivo.getValue()<=0))
                                                                                {
                                                                                    function resp6()
                                                                                    {
                                                                                        txtMontoSustitutivo.focus();
                                                                                    }
                                                                                    msgBox('Debe indicar el monto impuesto como sustitutivo',resp6);
                                                                                    return;
                                                                                }
                                                                                oSustitutivo.montoSustitutivo=txtMontoSustitutivo.getValue();
                                                                                
                                                                            break;
                                                                            case '5'://Periodo
                                                                                if(((txtAniosSustitutivos.getValue()=='')||(txtAniosSustitutivos.getValue()<=0))&&((txtMesesSustitutivos.getValue()=='')||(txtMesesSustitutivos.getValue()<=0))&&((txtDiasSustitutivos.getValue()=='')||(txtDiasSustitutivos.getValue()<=0)))
                                                                                {
                                                                                    function resp7()
                                                                                    {
                                                                                        txtAniosSustitutivos.focus();
                                                                                    }
                                                                                    msgBox('Debe indicar el periodo de duraci&oacute;n del sustitutivo impuesto',resp7);
                                                                                    return;
                                                                                }
                                                                                
                                                                                oSustitutivo.periodoSustitutivo=(txtAniosSustitutivos.getValue()==''?0:txtAniosSustitutivos.getValue())+'|'+
                                                                                								(txtMesesSustitutivos.getValue()==''?0:txtMesesSustitutivos.getValue())+'|'+
                                                                                            					(txtDiasSustitutivos.getValue()==''?0:txtDiasSustitutivos.getValue());
                                                                                
                                                                            break;
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        if(cmbAcogeSustitutivo.getValue()=='')
                                                                        {
                                                                            function resp8()
                                                                            {
                                                                                cmbAcogeSustitutivo.focus();
                                                                            }
                                                                            msgBox('Debe indicar si el setenciado se acoge al sustitutivo',resp8);
                                                                            return;
                                                                        }
                                                                        oSustitutivo.acogeSustitutivo=cmbAcogeSustitutivo.getValue();
                                                                        oSustitutivo.detallesAdicionales=gEx('txtDetallesSustitutivo').getValue();
                                                                        
                                                                        
                                                                        var pos=obtenerPosFila(gEx('gSustitutivo').getStore(),'idSustitutivo',oSustitutivo.idSustitutivo);
                                                                        if(pos!=-1)
                                                                        {
                                                                        	msgBox('El sustitutivo ya ha sido agregado anteriormente');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var reg=crearRegistro	(	[
                                                                        
                                                                                                        {name: 'idSustitutivo'},
                                                                                                        {name: 'acogeSustitutivo'},
                                                                                                        {name: 'detallesAdicionales'},
                                                                                                        {name: 'montoSustitutivo'},
                                                                                                        {name: 'periodoSustitutivo'}
                                                                                                     ]
                                                                                                 )
                                                                                                 
                                                                                                 
                                                                       	var r= new reg(oSustitutivo);
                                                                        
                                                                        if(oSustitutivo.acogeSustitutivo=='1')
                                                                        {
                                                                        	var x;
                                                                            var f;
                                                                            for(x=0;x<gEx('gSustitutivo').getStore().getCount();x++)
                                                                            {
                                                                            	f=gEx('gSustitutivo').getStore().getAt(x);
                                                                                f.set('acogeSustitutivo','0');
                                                                            }
                                                                        }
                                                                        
                                                                        
                                                                        gEx('gSustitutivo').getStore().add(r);  
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

function crearGridDelitosPena(filaPena)
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idDelito'},
		                                                {name: 'lblDelito'},
                                                        {name: 'incluido'},
                                                        {name: 'eliminable'}
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
                                                            sortInfo: {field: 'lblDelito', direction: 'ASC'},
                                                            groupField: 'lblDelito',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	gEx('btnDelDelitoPena').hide();
                                        
                                        var idRegistro=-1;
                                        if(filaPena)
                                            idRegistro=filaPena.data.idRegistro;
                                        
                                    	proxy.baseParams.funcion='133';
                                        proxy.baseParams.idReferencia=gE('idReferencia').value;
                                        proxy.baseParams.iA=idActividad;
                                        proxy.baseParams.iP=idRegistro;
                                        proxy.baseParams.esActualizacion=esActualizacionCarpeta?1:0;
                                        
                                    }
                        )   
    
    
    var checkColumn = new Ext.grid.CheckColumn	(
	 												{
													   header: '',
													   dataIndex: 'incluido',
													   width: 50
													}
												);
      
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        
                                                        checkColumn,
                                                        {
                                                            header:'Delito',
                                                            width:650,
                                                            sortable:true,
                                                            dataIndex:'lblDelito'
                                                        }
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gDelitos',
                                                            store:alDatos,
                                                            x:10,
                                                            y:175,
                                                            width:750,
                                                            height:150,
                                                            frame:false,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            columnLines : true,
                                                            plugins:	[
                                                            				checkColumn
                                                            			],  
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar delito',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaAgregarDelito();
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            id:'btnDelDelitoPena',
                                                                            text:'Remover delito',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gDelitos').getSelectionModel().getSelected();
                                                                                        
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el delito que desea remover');
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                    	function resp(btn)
                                                                                        {
                                                                                        	function funcAjax()
                                                                                            {
                                                                                                var resp=peticion_http.responseText;
                                                                                                arrResp=resp.split('|');
                                                                                                if(arrResp[0]=='1')
                                                                                                {
                                                                                                    gEx('gDelitos').getStore().reload();
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                }
                                                                                            }
                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=135&iA='+idActividad+'&iD='+fila.data.idDelito,true);
                                                                                            
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el delito seleccionado?',resp);
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
    
    tblGrid.getSelectionModel().on('rowselect',function(sm,nFila,registro)
                                            {
                                                gEx('btnDelDelitoPena').hide();
                                                if(registro.data.eliminable=='1')
                                                {
                                                    gEx('btnDelDelitoPena').show();
                                                }
                                            }
                                )
    
    return 	tblGrid;
}

function formatearFilaSustitutivo(registro,numFila, rp, ds)
{
	
    
	var lblTable	='<table>'+
                        '<tr height="21">'+
                            '<td width="20"></td><td width="130" valign="top"><span class="TSJDF_Etiqueta">Detalles adicionales:</span></td><td valign="top" width="450" valign="top"><span class="TSJDF_Control">'+(registro.data.detallesAdicionales.trim()==''?'(Sin detalles adicionales)':registro.data.detallesAdicionales.trim())+'</span></td>'+
                        '</tr>';
	
    
    lblTable+=	'</table><br>';
    
    rp.body=lblTable;	
}

function mostrarVentanaAgregarDelito()
{
    var cmbDelitoAgregar=crearComboExt('cmbDelitoAgregar',arrDelitos,140,5,400);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Delito a agregar:'
                                                        },
                                                        cmbDelitoAgregar
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar delito',
										width: 600,
										height:120,
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
																		var delito=cmbDelitoAgregar.getValue();
                                                                        
                                                                        if(delito=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                        		cmbDelitoAgregar.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar el delito que desea agregar',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        var pos=obtenerPosFila(gEx('gDelitos').getStore(),'idDelito',delito);
                                                                        if(pos!=-1)
                                                                        {
                                                                        	ventanaAM.close();
                                                                            return;
                                                                        }
                                                                        
                                                                     	function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gEx('gDelitos').getStore().reload();
                                                                             	ventanaAM.close();   
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=134&iA='+idActividad+'&iD='+delito,true);
                                                                           
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

function funcionPenaRenderer(val,meta,registro)
{
	meta.attr ='style="height:auto; white-space:normal; line-height:18px ";';
	var pos=obtenerPosFila(gEx('gSentencia').getStore(),'idRegistro',val);
    if(pos==-1)
    	return '';
    var fila=gEx('gSentencia').getStore().getAt(pos);
    
    var oDetalle='';
    var objDetalle=fila.data.objDetalle;
    var lblDetallePena='';
    
    if(objDetalle!='')
    {
    	oDetalle=eval('['+objDetalle+']')[0];
        if(oDetalle.monto)
        {
        	lblDetallePena='Monto: ';
            lblDetallesPenaValor=Ext.util.Format.usMoney(oDetalle.monto);
        }
        else
        {
        	lblDetallePena='Duraci&oacute;n de la pena: ';
            lblDetallesPenaValor=oDetalle.anios+' a&ntilde;os, '+oDetalle.meses+' meses, '+oDetalle.dias+' dias';
            
            
            
        }
        
        lblDetallePena+=' '+lblDetallesPenaValor;
    }  
    var penaDetalle='';
    if(fila.data.detallePena!='-1')
        penaDetalle='<br> ('+formatearValorRenderer(arrDetallesPena,fila.data.detallePena)+' )';
        	
    lblDetallePena='<b>'+formatearValorRenderer(arrPenas,fila.data.idPena)+'</b>'+penaDetalle+', '+lblDetallePena+'<br><b>Delitos:</b> '+fila.data.delitos;
    return lblDetallePena;
    
    
}

function funcionValidarGuardado()
{
	if(gEx('gSentencia').getStore().getCount()==0)
    {
    	msgBox('Almenos debe registrar una pena como parte de la sentencia');
    	return false;
    }
    
    if(gE('opt_concedeSuspensionvch_1').checked)
    {
    	if(parseFloat(normalizarValor(gE('_montoGarantiaflo').value))<=0)
        {
        	function respAux()
            {
            	gE('_montoGarantiaflo').focus();
            }
        	msgBox('Debe ingresar el monto de la garant&iacute;a para aplicar la SUSPENSI&Oacute;N CONDICIONAL DE LA EJECUCI&Oacute;N DE LA PENA',respAux);
    		return false;
        }
        
        if(gEx('grid_6709').getStore().getCount()==0)
        {
        	msgBox('Indique las penas que son consideradas en la SUSPENSI&Oacute;N CONDICIONAL');
    		return false;
        }

    }
    
    
	return true;
}

function agregarParticipante()
{
	
    
    colapsarPanel();
	var obj={};
    
    obj.ancho='100%';
    obj.alto='100%';
    obj.modal=true;
    obj.url='../modeloPerfiles/registroFormularioV2.php';
    obj.funcionCerrar=function()
    				{
                    	restaurarPanel();
                    }
    obj.params=[
    				['accionCancelar','window.parent.accionCancelada()'],
                    ['cPagina','sFrm=true'],
                    ['pM','1'],
                    ['pE','1'],
                    ['actor','MTAx'],
                    ['idFormulario','47'],
                    ['idReferencia','-1'],
                    ['idRegistro','-1'],
                    ['figuraJuridica','4'],
                    ['idActividad',idActividadBase],
                    ['funcPHPEjecutarNuevo',bE('participanteAgregado(idRegPadre)')]
               ];
    abrirVentanaFancy(obj);
}

function colapsarPanel()
{
	window.parent.gEx('panelListadoRegistros').setHeight(1);
    window.parent.gEx('vContenedor').doLayout();
}

function restaurarPanel()
{
	window.parent.gEx('panelListadoRegistros').setHeight(220);
    window.parent.gEx('vContenedor').doLayout();
}

function participanteAgregado(iParticipante,nombre)
{
	restaurarPanel();
	var opt=cE('option');
    opt.value=iParticipante;
    opt.text=nombre;
	gE('_sentenciadovch').options[gE('_sentenciadovch').options.length]=opt;
    gE('_sentenciadovch').selectedIndex=gE('_sentenciadovch').options.length-1;
    lanzarEvento(gE('_sentenciadovch'),'change',gE('_sentenciadovch'));
}              
              
function funcionValidarGuardado()
{
	/*if(gE('lblEstado').innerHTML=='')
    {
    	msgBox('Debe ingresar la &uacute;ltima direcci&oacute;n de contacto');
    	return false;
    }*/
    
    return true;
}      

function accionCancelada()
{
	restaurarPanel();
    cerrarVentanaFancy();
}    

function calcularPenaCumplir()
{
	if(gEx('dteFechaConpurgaPenaAct'))
    {
        var resultado=obtenerDatosPena();
        
        if(gEx('dteFechaInicioPenaAct').getValue()!='')
        {
            var fechaTermino=gEx('dteFechaInicioPenaAct').getValue().add(Date.DAY,resultado[2]);
            fechaTermino=fechaTermino.add(Date.MONTH,resultado[1]);
            fechaTermino=fechaTermino.add(Date.YEAR,resultado[0]);
            gEx('dteFechaConpurgaPenaAct').setValue(fechaTermino);
        }
	}
}

function obtenerDatosPena()
{
	var arrAbono=calcularTotalComputoPrisionPreventiva();
	var arrPena=[];
    arrPena[0]=gEx('txtAnios').getValue()==''?0:gEx('txtAnios').getValue();
    arrPena[1]=gEx('txtMeses').getValue()==''?0:gEx('txtMeses').getValue();
    arrPena[2]=gEx('txtDias').getValue()==''?0:gEx('txtDias').getValue();
    var arrAbonoPrisionPreventiva=arrAbono[0];
    if(gE('lblDuracionPenaAct'))
    {
        gE('lblDuracionPenaAct').innerHTML=convertirLeyendaComputo(arrPena);
        gE('lblTotalAbonoPrisionPreventivaAct').innerHTML=arrAbono[1]; 
    }
    var arrPunitiva=[];
    arrPunitiva[0]=gEx('txtAniosPunitiva').getValue()==''?0:gEx('txtAniosPunitiva').getValue();
    arrPunitiva[1]=gEx('txtMesesPunitiva').getValue()==''?0:gEx('txtMesesPunitiva').getValue();
    arrPunitiva[2]=gEx('txtDiasPunitiva').getValue()==''?0:gEx('txtDiasPunitiva').getValue();
    
    
    var resultado=restarComputo(arrPena,arrAbonoPrisionPreventiva);
    
    resultado=restarComputo(resultado,arrPunitiva);
    if(gE('lblDuracionPenaAct'))
	    gE('lblTotalSentenciaCumplirAct').innerHTML=convertirLeyendaComputo(resultado);
    return   resultado; 	
}
