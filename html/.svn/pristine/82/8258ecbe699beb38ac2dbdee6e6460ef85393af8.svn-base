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
	else
	{
		$consulta="SELECT idActividadCarpetaAmparo FROM _346_tablaDinamica WHERE id__346_tablaDinamica=".$idRegistro;
		$idActividad=$con->obtenerValor($consulta);
	}
	$consulta="SELECT id__5_tablaDinamica,nombreTipo FROM _5_tablaDinamica where 
			id__5_tablaDinamica in	(2,4,5,6,100,9) order by nombreTipo";
	$arrTipoFigura=$con->obtenerFilasArreglo($consulta);	
	
	
	$consulta="SELECT id__5_tablaDinamica,nombreTipo FROM _5_tablaDinamica  order by nombreTipo";
	$arrTipoFiguraGral=$con->obtenerFilasArreglo($consulta);		

		
		
?>
var arrTipoFiguraGral=<?php echo $arrTipoFiguraGral?>;

var idActividadAmparo=<?php echo $idActividad?>;
var arrTipoFigura=<?php echo $arrTipoFigura?>;
var ignorarOtroQuejo=false;
var cadenaFuncionValidacion='funcionPrepararGuardado';

function inyeccionCodigo()
{
	loadScript('../modulosEspeciales_SGJP/Scripts/cParticipante.js.php', function()
    																		{
                                                                            }
					)
   	loadScript('../Scripts/funcionesAjaxV2.js', function(){});
	
	if(esRegistroFormulario())
    {
    	var neunCJF=gEN('_neunCJFvch')[0].value;
        
 		var arrJueces=eval(gE('lista_juecesAmparoarr').value);        
        var pos=0;    	
        for(pos=0;pos<arrJueces.length;pos++)
        {
        	if((neunCJF!='')&&(neunCJF!='N/E'))
            {
            	gE('opt_juecesAmparoarr_'+arrJueces[pos][0]).disabled=true;
                gE('_juecesAmparoarr').name='';
            }
        	asignarEvento(gE('opt_juecesAmparoarr_'+arrJueces[pos][0]),'click',function(chk)
            										{
                                                    	juezCheck(chk);
                                                    }
            			)
        }
    
    
    	setTimeout	(	function()
                        {
                            asignarEvento(gE('_categoriaAmparovch'),'change',function(chk)
                                                                                        {
                                                                                            switch(chk.options[chk.selectedIndex].value)
                                                                                            {
                                                                                                case '1':
                                                                                                    
                                                                                                    oE('div_7629');
                                                                                                    gEx('ext__carpetaAdministrativavch').enable();
                                                                                                    gEx('ext__carpetaAdministrativavch').show();
                                                                                                    mE('div_7365');
                                                                                                    gE('_carpetaAdministrativavch').setAttribute('val','obl');
                                                                                                    mE('div_5105');
                                                                                                    mE('div_5104');
                                                                                                    mE('div_5220');
                                                                                                    mE('div_7260');
                                                                                                    mE('div_7259');
                                                                                                    
                                                                                                    
                                                                                                    mE('div_5220');
                                                                                                    
                                                                                                    
                                                                                                    
                                                                                                                                                                                              
                                                                                                    oE('div_5214');
                                                                                                    oE('div_5215');
                                                                                                    oE('div_5216');
                                                                                                    oE('div_5217');
                                                                                                    oE('div_5218');
                                                                                                    oE('div_5219');
                                                                                                    
                                                                                                    mE('div_7263');
                                                                                                    mE('div_7910');
                                                                                                    
                                                                                                    oE('div_5220');
                                                                                                    
                                                                                                    
                                                                                                break;    
                                                                                                case '2':
    
    
                                                                                                    oE('div_7629');;
                                                                                                    
                                                                                                    
                                                                                                    gEx('ext__carpetaAdministrativavch').disable();
                                                                                                    oE('div_5105');
                                                                                                    gEx('ext__carpetaAdministrativavch').setValue('');
                                                                                                    gE('_carpetaAdministrativavch').value='';
                                                                                                    gE('_carpetaAdministrativavch').setAttribute('val','');
                                                                                                    oE('div_5104');
                                                                                                    
                                                                                                    
                                                                                                    oE('div_7260');
                                                                                                    oE('div_5220');
                                                                                                    oE('div_7259');

                                                                                                    
                                                                                                    mE('div_5214');
                                                                                                    mE('div_5215');
                                                                                                    mE('div_5216');
                                                                                                    mE('div_5217');
                                                                                                    mE('div_5218');
                                                                                                    mE('div_5219');
                                                                                                    
                                                                                                    oE('div_7263');
                                                                                                    
                                                                                                    oE('div_7365');
                                                                                                    
                                                                                                    
                                                                                                    oE('div_7910');
                                                                                                    oE('div_7911');
                                                                                                    
                                                                                                    
                                                                                                    
                                                                                                    
                                                                                                    
                                                                                                break;
                                                                                            }
                                                                                            
                                                                                        }
                                                                        ); 
                         
							
                         
                            if(gE('idRegistroG').value=='-1')
                            {

                                 gEN('_idActividadCarpetaAmparovch')[0].value=idActividadAmparo;
                                 gEx('f_sp_fechaRecepciondte').setValue('<?php echo $fechaActual?>');
                                 
                                 gEx('f_sp_fechaRecepciondte').fireEvent('change', gEx('f_sp_fechaRecepciondte'), gEx('f_sp_fechaRecepciondte').getValue());
                                 gEx('f_sp_fechaRecepciondte').fireEvent('select', gEx('f_sp_fechaRecepciondte'));
                                 
                                 gEx('f_sp_horaRecepciontme').setValue('<?php echo $horaActual?>');
                                 gEx('f_sp_horaRecepciontme').fireEvent('change', gEx('f_sp_horaRecepciontme'), gEx('f_sp_horaRecepciontme').getValue());
                                 
	                           	 var categoriaAmparovch=gE('_categoriaAmparovch');
                                 var pos;
                                 for(pos=0;pos<categoriaAmparovch.options.length;pos++)
                                 {
                                 	if(categoriaAmparovch.options[pos].value=='0')
                                    {
                                    	categoriaAmparovch.options[pos]=null;
                                        break;
                                    }
                                 }
                            }
                            else
                            {
                            	idActividadAmparo=gEN('_idActividadCarpetaAmparovch')[0].value;
                                ignorarOtroQuejo=true;
                            }

                            
                            lanzarEvento('opt_otroQuejosoarr_1','click',gE('opt_otroQuejosoarr_1')); 
                            lanzarEvento('_categoriaAmparovch','change',gE('_categoriaAmparovch'));
                        
                        },1000
                	)
    
    
    	
    
    	
    }
    else
    {
        if((!gEN('sp_4822')[0]) || (gEN('sp_4822')[0].innerHTML==''))
        {
        	oE('div_4823');
            oE('div_4824');
            oE('div_4825');
         	oE('div_5094');   
        }
        
        if((!gEN('sp_4826')[0]) || (gEN('sp_4826')[0].innerHTML==''))
        {
        	oE('div_4827');
            oE('div_4828');
            oE('div_4829');
         	oE('div_5103');   
        }
        
        oE('div_5220');
        
        
        
        if((gE('sp_7262').innerHTML!='Amparo cierto')||
        ((gEN('sp_5220').length>0)&&(gEN('sp_5220')[0].innerHTML=='Otro')))
        {
        	
        	oE('div_7259');
            oE('div_7263');

            
            oE('div_5104');

            oE('div_5105');
            oE('div_7629');
            
            mE('div_5217');
            mE('div_5218');
            mE('div_5219');
        }
        else
        {
        	
        	oE('div_5217');
            oE('div_5218');
            oE('div_5219');
           
            mE('div_7259');
            mE('div_7263');

        }
        
        
        if(gE('sp_7262').innerHTML=='Amparo cierto')
        {
        	mE('div_5104');

            mE('div_5105');
            oE('div_7629');
        }
        
        oE('div_5140');
        oE('div_5141');
    	oE('div_7910');
        

        if(gEN('sp_7910').length>0 && (gEN('sp_7910')[0].innerHTML=='Otro'))
        {
        	oE('div_7629');
        }
        else
        {
        	oE('div_7911');
        }
        
        
        
    }
    
    
    if(gE('sp_8235'))
    {
    	gE('sp_8235').innerHTML='';
    }
    else
    {
    	gE('sp_8230').innerHTML='';
    }
    
    crearGridParticipantes();
   
}

  


function funcionPrepararGuardado()
{
	if(gEx('gParticipantes').getStore().getCount()==0)
    {
    	msgBox('Debe ingresar almenos una persona Quejosa');
    	return false;
    }
	return true;                
    
}

function agregarParticipante()
{

	var iFiguraJuridica=gE('_figuraJuridicavch').options[gE('_figuraJuridicavch').selectedIndex].value;
    var cAdministrativa=gE('_carpetaAdministrativavch').value;

    var iActividad=-1;
    iActividad=gE('sp_7366').innerHTML;
    if(iActividad=='')
    	iActividad=-1;
    
    
    
    
    if(iFiguraJuridica=='-1')
    {
    	msgBox('Debe indicar el tipo de figura jur&iacute;dica a agregar');
    	return;
    }
    
    if(iActividad=='-1')
    {
    	msgBox('Debe indicar la carpeta judicial al cual pertenece el apelante a agregar');
    	return;
    }
    
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.modal=true;
    obj.url='../modeloPerfiles/registroFormularioV2.php';
    
    obj.params=[
    				['accionCancelar','window.parent.accionCancelada()'],
                    ['cPagina','sFrm=true'],
                    ['pM','1'],
                    ['pE','1'],
                    ['actor','MTAx'],
                    ['idFormulario','47'],
                    ['idReferencia','-1'],
                    ['idRegistro','-1'],
                    ['figuraJuridica',iFiguraJuridica],
                    ['idActividad',iActividad],
                    ['funcPHPEjecutarNuevo',bE('participanteAgregado(idRegPadre)')]
               ];
    abrirVentanaFancy(obj);
}


             
              
function funcionValidarGuardado()
{
	var categoriaAmparo=gE('_categoriaAmparovch').options[gE('_categoriaAmparovch').selectedIndex].value;
    if(categoriaAmparo!='2')
    {
    	var totalJueces=0;
        var arrJueces=eval(gE('lista_juecesAmparoarr').value);
        
        var pos=0;
    	
        for(pos=0;pos<arrJueces.length;pos++)
        {
        	if(gE('opt_juecesAmparoarr_'+arrJueces[pos][0]).checked)
            {
            	totalJueces++;
            }
        }  
        
        
        if(totalJueces>1)
        {
        	msgBox('S&oacute;lo puede seleccionar m&aacute;s de un juez cuando el tipo de amparo es <b>Transitorio</b>');
        	return false;
        }
        
        
    }
    
    return true;
}      

function accionCancelada()
{
	
    cerrarVentanaFancy();
}   

function juezCheck(chk)
{
	var categoriaAmparo=gE('_categoriaAmparovch').options[gE('_categoriaAmparovch').selectedIndex].value;

	if((chk.checked)&&(categoriaAmparo!='2'))
    {
 		var arrJueces=eval(gE('lista_juecesAmparoarr').value);
        
        var pos=0;
    	
        for(pos=0;pos<arrJueces.length;pos++)
        {
        	gE('opt_juecesAmparoarr_'+arrJueces[pos][0]).checked=false;
        }  
        
        chk.checked=true; 	
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
                                        proxy.baseParams.idActividad=idActividadAmparo;
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
                                                                header:'Nombre del Quejoso',
                                                                width:450,
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
                                                                        	return formatearValorRenderer(arrTipoFiguraGral,val);
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gParticipantes',
                                                                store:alDatos,
                                                                width:800,
                                                                height:280,
                                                                renderTo:'sp_8235',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,  
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Agregar Quejoso',
                                                                                hidden:!esRegistroFormulario(),
                                                                                handler:function()
                                                                                        {
                                                                                        	var categoriaAmparo=gE('_categoriaAmparovch').options[gE('_categoriaAmparovch').selectedIndex].value;
                                                                                            
                                                                                        
                                                                                            mostrarVentanaAgregarQuejoso();
                                                                                        }
                                                                                
                                                                            },
                                                                			'-',
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover Quejoso',
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
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=8&figuraJuridica='+fila.data.figura+
                                                                                                    			'&idRegistro='+fila.data.idRegistro+'&idActividad='+idActividadAmparo,true);
                                                                                                    
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


function mostrarVentanaAgregarQuejoso()
{
	var cmbFiguraJuridica=crearComboExt('cmbFiguraJuridica',arrTipoFigura,130,5,300);
    cmbFiguraJuridica.on('select',function(cmb,registro)
    								{
                                    	function funcAjax()
                                        {
                                            var resp=peticion_http.responseText;
                                            arrResp=resp.split('|');
                                            if(arrResp[0]=='1')
                                            {
                                                cmbQuejoso.setValue('');
                                                cmbQuejoso.getStore().loadData(eval(arrResp[1]));
                                            }
                                            else
                                            {
                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                            }
                                        }
                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=118&fJ='+registro.data.id+
                                        '&iA='+idActividadAmparo+','+(gE('sp_7366').innerHTML==''?-1:gE('sp_7366').innerHTML),true);
                                    }
    					)
    
    var cmbQuejoso=crearComboExt('cmbQuejoso',[],130,35,300);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Figura Juridica:'
                                                        },
                                                        cmbFiguraJuridica,
                                                        {
                                                        	x:440,
                                                            y:8,
                                                            html:'<a href="javascript:mostrarVentanaAgregarParticipante()"><img src="../images/add.png" title="Agregar Quejoso" title="Agregar Quejoso"></a>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Quejoso:'
                                                        },
                                                        cmbQuejoso
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Quejoso',
                                        id:'vAddQuejoso',
										width: 500,
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
																		if(cmbQuejoso.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbQuejoso.focus();
                                                                            }
                                                                            msgBox('Debe indicar el nombre del quejoso',resp);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        var cadObj='{"idActividad":"'+idActividadAmparo+'","tipoFigura":"'+gEx('cmbFiguraJuridica').getValue()+
                                                                        			'","idParticipante":"'+cmbQuejoso.getValue()+'"}'
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	recargarGridParticipantes();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=223&cadObj='+cadObj,true);
                                                                        
                                                                        
                                                                        
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

function mostrarVentanaAgregarParticipante()
{
	if(gEx('cmbFiguraJuridica').getValue()=='')
    {
    	function resp()
        {
        	gEx('cmbFiguraJuridica').focus();
        }
    	msgBox('Debe seleccionar la figura jur&iacute;dica del quejoso',resp);
    	return;
    }
	agregarParticipante(gEx('cmbFiguraJuridica').getValue(),gEx('cmbFiguraJuridica').getRawValue());
}

function agregarParticipante(f,parte)
{
	var objConf={};
    objConf.ocultaIdentificacion=true;
    objConf.ocultaCURP=true;
    objConf.ocultaRFC=true;
    objConf.ocultaCedula=true;
    objConf.ocultaEdoCivil=true;
    objConf.ocultaFechaNacimiento=true;
    objConf.ocultaEdad=true;
    objConf.idActividad=idActividadAmparo;
    objConf.idCarpeta=-1;
    objConf.afterRegister=function()
    						{
                            	gEx('vAddQuejoso').close();
                                recargarGridParticipantes();
                            }

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
    objConf.idActividad=idActividadAmparo;
    objConf.idCarpeta=-1;
    objConf.afterRegister=recargarGridParticipantes;
    objConf.idParticipante=bD(iR);
    var pos=existeValorMatriz(arrTipoFiguraGral,bD(f));
    var parte=arrTipoFiguraGral[pos][1];
	agregarParticipanteVentana(bD(f),parte,objConf)
  
}

