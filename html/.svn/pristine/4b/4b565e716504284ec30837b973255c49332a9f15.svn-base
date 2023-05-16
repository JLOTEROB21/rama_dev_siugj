<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
	
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);
	
	if($tipoMateria=="P")
	{
	
		$eventoAudiencia="";
		$iEvento=-1;
		if($idRegistro<>-1)
		{
			$consulta="SELECT resolucionImpugnada,eventoResolucion FROM _487_tablaDinamica WHERE id__487_tablaDinamica=".$idRegistro;
			$fRegistro=$con->obtenerPrimeraFila($consulta);
			$iEvento=$fRegistro[1];
			if($fRegistro[0]==1)
			{
				$consulta="SELECT CONCAT(DATE_FORMAT(horaInicioEvento,'%d/%m/%Y %H:%i'),' ',a.tipoAudiencia) AS audiencia
						 FROM 7000_eventosAudiencia e,_4_tablaDinamica a WHERE e.idRegistroEvento=".$fRegistro[1]."
						 and a.id__4_tablaDinamica=e.tipoAudiencia";
			
				$eventoAudiencia=$con->obtenerValor($consulta);
				
			}
			
		}
		
		$consulta="SELECT id__5_tablaDinamica,nombreTipo FROM _5_tablaDinamica";
		$arrFigurasJuridicas=$con->obtenerFilasArreglo($consulta);
		
		
		$consulta="SELECT id__5_tablaDinamica,nombreTipo FROM _5_tablaDinamica where id__5_tablaDinamica in(1,2,3,4,5,6,10) order by nombreTipo";
		$arrFigurasJuridicasAgregar=$con->obtenerFilasArreglo($consulta);
		
		
		$consulta="SELECT id__33_tablaDinamica,tipoPersona FROM _33_tablaDinamica";
		$arrTiposPersonas=$con->obtenerFilasArreglo($consulta);
		
		
		
		$consulta="SELECT id__47_tablaDinamica,CONCAT(IF(p.nombre IS NULL,'',p.nombre),' ',IF(p.apellidoPaterno IS NULL,'',p.apellidoPaterno)
					,' ',IF(p.apellidoMaterno IS NULL,'',p.apellidoMaterno)) AS nombre,r.figuraJuridica FROM _487_apelantes r,_47_tablaDinamica p 
					WHERE p.id__47_tablaDinamica=r.idApelante and r.idReferencia=".$idRegistro." ORDER BY 
					p.nombre,p.apellidoPaterno,p.apellidoMaterno";
		$arrApelantes=$con->obtenerFilasArreglo($consulta);
		
		
		
		$consulta="SELECT carpetaAdministrativa,idCarpeta FROM 7006_carpetasAdministrativas 
					WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFila($consulta);
	
	
	
	
?>

var idCarpeta='<?php echo  $fRegistro?$fRegistro[1]:1;?>';
var cCarpeta='<?php echo  $fRegistro?$fRegistro[0]:'';?>';

var arrApelantes=<?php echo $arrApelantes?>;
var arrTiposPersonas=<?php echo $arrTiposPersonas?>;
var arrFigurasJuridicasAgregar=<?php echo $arrFigurasJuridicasAgregar ?>;
var arrFigurasJuridicas=<?php echo $arrFigurasJuridicas?>;
var existeAudiencia=false;
var iEvento='<?php echo $iEvento?>';
var arrEventosAudiencias;
var cadenaFuncionValidacion='funcionPrepararGuardado';

function inyeccionCodigo()
{
	gE('_lbl7738').innerHTML='';
    
	loadScript('../Scripts/funcionesAjaxV2.js', function()
                                                        {
                                                            
                                                        }
                        );

	
	if(esRegistroFormulario())
    {
    
    	setTimeout	(	function()
                        {
            
                           	gEx('ext__carpetaJudicialApeladavch').on('select',function(cmb,registro)
                           													{
                                                                            	function funcAjax(peticion_http)
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                        arrEventosAudiencias=eval(arrResp[1]);
                                                                                        llenarCombo(gE('_eventoResolucionvch'),arrEventosAudiencias,true);
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_Alzada.php',funcAjax, 'POST','funcion=1&cA='+registro.data.id,true);
                                                                            }
                           											)
                                                                        
                          
                          	asignarEvento(gE('_eventoResolucionvch'),'change',function(cmb)
                          													{
                                                                            	var valor=cmb.options[cmb.selectedIndex].value;
                                                                                
                                                                                var pos=existeValorMatriz(arrEventosAudiencias,valor);
                                                                                
                                                                                var juez=arrEventosAudiencias[pos][2];
                                                                                selElemCombo(gE('_juezResolucionvch'),juez);
                                                                            }
                                    	)
                         
                          	
                            
                            asignarEvento(gE('_carpetaAdministrativavch'),'change',function()
                                                    {
                                                        validarExpediente();
                                                    }
                                    );                     
                        
                          	asignarEvento(gE('_tribunalAlzadavch'),'change',function()
                                                                        {
                                                                            validarExpediente();
                                                                        }
                                                        ); 
                            
                        
                            if(gE('idRegistroG').value=='-1')
                            {
                                 /*gEx('f_sp_fechaRecepciondte').setValue('<?php echo $fechaActual?>');
                                 
                                 gEx('f_sp_fechaRecepciondte').fireEvent('change', gEx('f_sp_fechaRecepciondte'), gEx('f_sp_fechaRecepciondte').getValue());
                                 gEx('f_sp_fechaRecepciondte').fireEvent('select', gEx('f_sp_fechaRecepciondte'));
                                 
                                 gEx('f_sp_horaRepepciontme').setValue('<?php echo $horaActual?>');
                                 gEx('f_sp_horaRepepciontme').fireEvent('change', gEx('f_sp_horaRepepciontme'), gEx('f_sp_horaRepepciontme').getValue());
                                 */
                                 limpiarCombo(gE('_eventoResolucionvch'));
                                 
                                
                            }
                            else
                            {
                            	if(gE('opt_resolucionImpugnadavch_1').checked)
                                {
                                	
                                	function funcAjax(peticion_http)
                                    {
                                        var resp=peticion_http.responseText;
                                        arrResp=resp.split('|');
                                        if(arrResp[0]=='1')
                                        {
                                            arrEventosAudiencias=eval(arrResp[1]);
                                            llenarCombo(gE('_eventoResolucionvch'),arrEventosAudiencias,true);
                                            
                                            selElemCombo(gE('_eventoResolucionvch'),iEvento);
                                        }
                                        else
                                        {
                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                        }
                                    }
                                    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_Alzada.php',funcAjax, 'POST','funcion=1&cA='+gE('_carpetaJudicialApeladavch').value,true);
                                }
                            }
                           
                            
                        
                        },1000
                	)
    
    
    	
    
    	
    }
    else
    {
    	gE('sp_7669').innerHTML='<?php echo cv($eventoAudiencia)?>';
        if(gE('sp_7655').innerHTML=='Emitida en audiencia')
        {
        	mE('div_7669');
            oE('div_7660');
        }
        else
        {
        	oE('div_7669');
            mE('div_7660');
        }
    }

    crearGridApelantes();
   
}

  


function funcionPrepararGuardado()
{
	var fila;
    var gApelante=gEx('gApelante');
    var x;
    var o;
    var arrApelantes='';
    
    for(x=0;x<gApelante.getStore().getCount();x++)
    {
    	fila=gApelante.getStore().getAt(x);
        o='{"idApelante":"'+fila.data.idApelante+'","figuraJuridica":"'+fila.data.figuraJuridica+'"}';
        
        if(arrApelantes=='')
        	arrApelantes=o;
        else
        	arrApelantes+=','+o;
        
    }
    
    var objRegistro='{"arrApelantes":['+arrApelantes+']}';

	var id=gE('idRegistroG').value;
                        
	if(id=='-1')
    {
        gE('funcPHPEjecutarNuevo').value=bE('registrarApelantes(@idRegPadre,\''+bE(objRegistro)+'\')');
    }
    else
    {
        gE('funcPHPEjecutarModif').value=bE('registrarApelantes('+id+',\''+bE(objRegistro)+'\')');
    }
    
    
    
	return true;                
    
}

function agregarParticipante()
{

	var iFiguraJuridica=gE('_figuraJuridicavch').options[gE('_figuraJuridicavch').selectedIndex].value;
    var cAdministrativa=gE('_carpetaJudicialApeladavch').value;
    var iActividad=-1;
    iActividad=gE('sp_7664').innerHTML;
    if(iActividad=='')
    	iActividad=-1;
    
    
    
    
    if(iFiguraJuridica=='-1')
    {
    	msgBox('Debe indicar el tipo de figura jur&iacute;dica a agregar');
    	return;
    }
    
    if(cAdministrativa=='-1')
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


function participanteAgregado(iParticipante,nombre)
{
	
	var opt=cE('option');
    opt.value=iParticipante;
    opt.text=nombre;
	gE('_nombreApelantevch').options[gE('_nombreApelantevch').options.length]=opt;
    gE('_nombreApelantevch').selectedIndex=gE('_nombreApelantevch').options.length-1;
    cerrarVentanaFancy();
    
}              
              
function funcionValidarGuardado()
{
	return !existeAudiencia;

}      

function accionCancelada()
{
	
    cerrarVentanaFancy();
}   


function validarExpediente()
{
	var cA=gE('_carpetaAdministrativavch').value;
    var tribunal=gE('_tribunalAlzadavch').options[gE('_tribunalAlzadavch').selectedIndex].value;
    
    function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        
        	if(arrResp[1]=='0')
            {
            	oE('div_7670');
                existeAudiencia=false;
            }
            else
            {
            	existeAudiencia=true;
                mE('div_7670');
                switch(arrResp[1])
                {
                 	case '1':
                    	gE('sp_7670').innerHTML='El No. de Expediente ha sido registrado previamente !!!';
                    break;
                    case '2':
                    	gE('sp_7670').innerHTML='El No. de Expediente ya se encuentra registrado en otro registro de expediente!!!';
                    break;  
                    
                }
           	}
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_Alzada.php',funcAjax, 'POST','funcion=5&iR='+gE('idRegistroG').value+'&t='+tribunal+'&cA='+cA,true);

    
    
}

function crearGridApelantes()
{
	var dsDatos=arrApelantes;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                        			{name: 'idApelante'},
                                                                    {name: 'apelante'},                                                                    
                                                                    {name: 'figuraJuridica'}
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
															header:'Apelante',
															width:400,
															sortable:true,
															dataIndex:'apelante',
                                                            renderer:mostrarValorDescripcion
														},
														{
															header:'Figura Jur&iacute;dica',
															width:200,
															sortable:true,
															dataIndex:'figuraJuridica',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrFigurasJuridicas,val);
                                                                    }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:false,
                                                            id:'gApelante',
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            renderTo:'_lbl7738',                                                            
                                                            columnLines : true,
                                                            height:260,
                                                            width:700,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar apelante',
                                                                            hidden:!esRegistroFormulario(),
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaAgregarApelante();
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:!esRegistroFormulario(),
                                                                            text:'Remover apelante',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gApelante').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el apelante que desea remover');
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        function respAux(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
	                                                                                        	gEx('gApelante').getStore().remove(fila);
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover al apelante seleccionado?',respAux);
                                                                                        
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;
}

function mostrarVentanaAgregarApelante()
{

	var iActividad=gE('sp_7664').innerHTML;
    if(iActividad=='')
    {
    	function resp2()
        {
        	gEx('ext__carpetaJudicialApeladavch').focus();
        }
        msgBox('Debe seleccionar la Carpeta Judicial donde se apela la resoluci&oacute;n',resp2);
        return;
    }
	var cmbApelante=crearComboExt('cmbApelante',[],120,35,350);
    var cmbFiguraJuridicaAgregar=crearComboExt('cmbFiguraJuridicaAgregar',arrFigurasJuridicasAgregar,120,5,250);
    
    cmbFiguraJuridicaAgregar.on('select',function(cmb,registro)
    									{
                                        	function funcAjax()
                                            {
                                                var resp=peticion_http.responseText;
                                                arrResp=resp.split('|');
                                                if(arrResp[0]=='1')
                                                {
                                                    var arrDatos=eval('['+arrResp[1]+']')[0];
                                                    gEx('cmbApelante').setValue('');
                                                    gEx('cmbApelante').getStore().loadData(arrDatos);
                                                    
                                                    
                                                }
                                                else
                                                {
                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                }
                                            }
                                            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Alzada.php',funcAjax, 'POST','funcion=8&iA='+iActividad+'&fJ='+registro.data.id,true);
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
                                                            html:'Figura Jur&iacute;dica:'
                                                        },
                                                        cmbFiguraJuridicaAgregar,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Apelante:'
                                                        },
                                                        cmbApelante,
                                                        {
                                                        	x:480,
                                                            y:38,
                                                            html:'<a href="javascript:registrarApelante(\''+bE(iActividad)+'\')"><img src="../images/add.png" title="Agregar apelante" alt="Agregar apelante" /></a>'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar apelante',
										width: 550,
										height:150,
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
                                                                	cmbFiguraJuridicaAgregar.focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var reg=crearRegistro	(
                                                                        							[
                                                                                                    	{name: 'apelante'},
                                                                                                        {name: 'idApelante'},
									                                                                    {name: 'figuraJuridica'}
                                                                                                    ]
                                                                        						)
																	
                                                                    	if(cmbApelante.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	cmbApelante.focus();
                                                                            }
                                                                            msgBox('Debe indicar el apelante que desea agregar');
                                                                        	return;
                                                                        }
                                                                    
                                                                    	var r=new reg	(
                                                                        					{
                                                                                            	apelante:cmbApelante.getRawValue(),
                                                                                                idApelante:cmbApelante.getValue(),
                                                                                                figuraJuridica:cmbFiguraJuridicaAgregar.getValue()
                                                                                            }
                                                                        				)
                                                                    
                                                                    	var gApelante=gEx('gApelante');
                                                                    	var pos=obtenerPosFila(gApelante.getStore(),'idApelante',cmbApelante.getValue());
                                                                        if(pos==-1)
                                                                        {
                                                                        	gEx('gApelante').getStore().add(r);
                                                                        	
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
	ventanaAM.show();
}

function registrarApelante(iA)
{
	var cmbFiguraJuridicaAgregar=gEx('cmbFiguraJuridicaAgregar');
    
    
    if(cmbFiguraJuridicaAgregar.getValue()=='')
    {
    	msgBox('Debe inidcar la figura jur&iacute;dica que obstenta el apelante a agregar');
    	return;
    }
    
    
    var cmbTipoPersona=crearComboExt('cmbTipoPersona',arrTiposPersonas,120,35,140);
    cmbTipoPersona.setValue('1');
    cmbTipoPersona.on('select',function(cmb,registro)
    							{
                                	var txtApPaterno=gEx('txtApPaterno');
                                    var txtApMaterno=gEx('txtApMaterno');
                                    var txtNombre=gEx('txtNombre');
                                    var lblApPaterno=gEx('lblApPaterno');
                                    var lblApMaterno=gEx('lblApMaterno');
                                    var lblNombre=gEx('lblNombre');
                                    var txtRazonSocial=gEx('txtRazonSocial');
                                    var lblRazon=gEx('lblRazon');
                                    
                                	if(registro.data.id=='1')
                                    {
                                    	txtApPaterno.show();
                                        txtApMaterno.show();
                                        txtNombre.show();
                                        lblApPaterno.show();
                                        lblApMaterno.show();
                                        lblNombre.show();
                                        txtRazonSocial.hide();
                                        lblRazon.hide();
                                        txtNombre.focus(false,500);
                                        
                                    }
                                    else
                                    {
                                    	txtApPaterno.hide();
                                        txtApMaterno.hide();
                                        txtNombre.hide();
                                        lblApPaterno.hide();
                                        lblApMaterno.hide();
                                        lblNombre.hide();
                                        txtRazonSocial.show();
                                        lblRazon.show();
                                        txtRazonSocial.focus(false,500);
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
                                                            html:'Figura Jur&iacute;dica:'
                                                        },
                                                        {
                                                        	x:120,
                                                            y:10,
                                                            html:'<span style="color: #900; font-weight:bold">'+gEx('cmbFiguraJuridicaAgregar').getRawValue()+'</span>'
                                                        },
                                                        
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Tipo de persona:'
                                                        },
                                                        cmbTipoPersona,
                                                        {
                                                        	xtype:'textfield',
                                                            width:150,
                                                            x:10,
                                                            y:70,
                                                            id:'txtNombre'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            width:425,
                                                            x:10,
                                                            y:70,
                                                            id:'txtRazonSocial'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:95,
                                                            id:'lblRazon',
                                                            html:'<span >Raz&oacute;n social</span>'
                                                        },
                                                        {
                                                        	x:65,
                                                            y:95,
                                                            id:'lblNombre',
                                                            html:'<span >Nombre</span>'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            width:120,
                                                            x:170,
                                                            y:70,
                                                            id:'txtApPaterno'
                                                        },
                                                        {
                                                        	x:205,
                                                            y:95,
                                                            id:'lblApPaterno',
                                                            html:'<span >Ap. Paterno</span>'
                                                        }
                                                        ,
                                                        {
                                                        	xtype:'textfield',
                                                            width:120,
                                                            x:300,
                                                            y:70,
                                                            id:'txtApMaterno'
                                                        },
                                                         {
                                                        	x:335,
                                                            y:95,
                                                            id:'lblApMaterno',
                                                            html:'<span >Ap. Materno</span>'
                                                        }
                                                        
                                                        
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Registrar apelante',
										width: 470,
										height:200,
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
                                                                	//gEx('cmbTipoPersona').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
                                                                    	var txtApPaterno=gEx('txtApPaterno');
                                                                        var txtApMaterno=gEx('txtApMaterno');
                                                                        var txtNombre=gEx('txtNombre');
                                                                        var nombreAgregar='';
                                                                        var txtRazonSocial=gEx('txtRazonSocial');
                                                                        var cmbTipoPersona=gEx('cmbTipoPersona');
                                                                        
                                                                        var cadObj='';
                                                                        
                                                                        if(cmbTipoPersona.getValue()=='1')
                                                                        {
                                                                        	if(txtNombre.getValue()=='')
                                                                            {
                                                                            	function resp1()
                                                                                {
                                                                                	txtNombre.focus();
                                                                                }
                                                                            	msgBox('Debe ingresar el nombre del apelante a agregar ',resp1);
                                                                            	return;
                                                                            }
                                                                            
                                                                            
                                                                            if(txtApPaterno.getValue()=='')
                                                                            {
                                                                            	function resp2()
                                                                                {
                                                                                	txtApPaterno.focus();
                                                                                }
                                                                            	msgBox('Debe ingresar el apellido parterno del apelante a agregar ',resp2);
                                                                            	return;
                                                                            }
                                                                            
                                                                            nombreAgregar=txtNombre.getValue()+' '+txtApPaterno.getValue()+' '+txtApMaterno.getValue();
                                                                            cadObj='{"idActividad":"'+bD(iA)+'","tipoFigura":"'+cmbFiguraJuridicaAgregar.getValue()+
                                                                            		'","tipoPersona":"'+cmbTipoPersona.getValue()+'","nombre":"'+cv(txtNombre.getValue())+
                                                                            		'","apPaterno":"'+cv(txtApPaterno.getValue())+'","apMaterno":"'+cv(txtApMaterno.getValue())+'"}';
                                                                            
                                                                        }
                                                                        else
                                                                        {
                                                                        	if(txtRazonSocial.getValue()=='')
                                                                            {
                                                                            	function resp3()
                                                                                {
                                                                                	txtRazonSocial.focus();
                                                                                }
                                                                            	msgBox('Debe ingresar la raz&oacute;n social del apelante a agregar ',resp3);
                                                                            	return;
                                                                            }
                                                                            nombreAgregar=txtRazonSocial.getValue();
                                                                            cadObj='{"idActividad":"'+bD(iA)+'","tipoFigura":"'+cmbFiguraJuridicaAgregar.getValue()+
                                                                            		'","tipoPersona":"'+cmbTipoPersona.getValue()+'","nombre":"'+cv(txtRazonSocial.getValue())+
                                                                            		'","apPaterno":"","apMaterno":""}';
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                var reg=crearRegistro	(
                                                                                							[
                                                                                                                  {name:'id'},
                                                                                                                  {name:'nombre'},
                                                                                                                  {name:'valorComp'},
                                                                                                                  {name:'valorComp2'},
                                                                                                                  {name:'valorComp3'},
                                                                                                                  {name:'valorComp4'}
                                                                                                                  
                                                                                                              ]
                                                                                						)
                                                                            
                                                                            	var r=new reg (
                                                                                					{
                                                                                                    	id:arrResp[1],
                                                                                                        nombre:nombreAgregar
                                                                                                    }
                                                                                				)
                                                                            	gEx('cmbApelante').getStore().add(r);
                                                                                gEx('cmbApelante').setValue(arrResp[1]);
                                                                            	ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Alzada.php',funcAjax, 'POST','funcion=9&cadObj='+cadObj,true);
                                                                        
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
    dispararEventoSelectCombo('cmbTipoPersona');
    
}


function abrirCarpetaAdministrativa()
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/tableroAudienciaAdministracion.php';
    obj.params=[['cA',bE(cCarpeta)],['idCarpetaAdministrativa',idCarpeta],['sL',1]];
    window.parent.abrirVentanaFancy(obj);
}

<?php
	}
	else
	{
	?>
var oVisor;

function inyeccionCodigo()
{
		if(gE('sp_7739').innerHTML=='')
        	gE('sp_7739').innerHTML='--/--/----';
        else
        	gE('sp_7739').innerHTML=formatearCampoFormularioFecha(gE('sp_7739').innerHTML);
            
        if(gE('sp_7740').innerHTML=='')
        	gE('sp_7740').innerHTML='--/--/----';
        else
        	gE('sp_7740').innerHTML=formatearCampoFormularioFecha(gE('sp_7740').innerHTML);
            
            
    	gE('sp_7737').innerHTML='';
        oVisor=new Ext.ux.IFrameComponent({ 
        
                                                id: 'hSpVisor', 
                                                width:950,
                                                height:400,
                                                hidden:false,
                                                renderTo:'sp_7737',
                                                url: '../paginasFunciones/white.php',
                                                style: 'width:100%;height:100%' 
                                        });
                                        
		gEx('hSpVisor').load	(
                                    {
                                        url:'../visoresGaleriaDocumentos/visorDocumentosWord.php',
                                        params:	{
                                                    iDocumento:gEN('_idAcuerdovch')[0].value,
                                                    cPagina:'sFrm=true'
                                                }
                                    }
                                );                                        
                                        
}                                        
    <?php
		
		
	}
?>