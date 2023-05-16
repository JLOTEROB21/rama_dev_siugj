<?php session_start();
include("conexionBD.php");
include("configurarIdiomaJS.php");
$idFormulario=$_GET["idFormulario"];


$consulta="select p.idProceso,idTipoProceso from 900_formularios f,4001_procesos p where p.idProceso=f.idProceso  and idFormulario=".$idFormulario;
$filaProc=$con->obtenerPrimeraFila($consulta);
$idProceso=$filaProc[0];

$consulta="select ed.complementario,idElementoDTD from 203_elementosDTD ed,900_formularios f where f.idFormulario=ed.idFormulario and f.titulo=3 and ed.idProceso=".$idProceso;
$filaAux=$con->obtenerPrimeraFila($consulta);
$conf=$filaAux[0];
$idElementoDTD=$filaAux[1];



$arrConsulta=explode(",",$conf);

$idPerfil=$arrConsulta[0];
$principal=$arrConsulta[1];
$externoP=$arrConsulta[2];
$singular="Investigador";
if(isset($arrConsulta[3]))
	$singular=$arrConsulta[3];
$plural="Investigadores";
if(isset($arrConsulta[4]))
	$plural=$arrConsulta[4];
$responsable="Responsable";

if(isset($arrConsulta[5]))
	$responsable=$arrConsulta[5];
$ocultarOrden="false";
if(isset($arrConsulta[6]))
	if($arrConsulta[6]==0)
		$ocultarOrden="true";
$ocultarColResp="false";
if(isset($arrConsulta[7]))
	if($arrConsulta[7]==0)
		$ocultarColResp="true";
$mostrarAfiliacion="true";
if(isset($arrConsulta[8]))
	if($arrConsulta[8]==0)
		$mostrarAfiliacion="false";


$consulta="SELECT * FROM 205_infoComplementariaModuloParticipantes WHERE idElementoDTD=".$idElementoDTD;

$filaComp=$con->obtenerPrimeraFila($consulta);
$idFrmEval="-1";
$ocultarEval='true';
if($filaComp[2]==1)
{
	$idFrmEval=$filaComp[3];
	$ocultarEval='false';
}

/*if(existeRol("'57_0'"))
{
	$ocultarEval='true';
}*/

$idProceso=obtenerIdProcesoFormulario($idFormulario);
$consulta="SELECT idElementoDTD FROM 203_elementosDTD WHERE tipoElemento=1 AND idProceso=".$idProceso;
$idElementoDTD=$con->obtenerValor($consulta);
$consulta="SELECT configuracion FROM 205_infoComplementariaModuloParticipantes WHERE idElementoDTD=".$idElementoDTD;

$configuracion=$con->obtenerValor($consulta);
$permitirAgregarUsr=false;
$formatoUsr="concat(i.Paterno,' ',i.Materno,', ',i.Nom)";
$orden="descParticipacion,nombre";
$ordenGrid="{field:'descParticipacion'},{field:'nombreAutor'}";
$ocultarMail='true';
$ocultarTel='true';
$leyendaEval="Evaluar Participante";
$leyendaVerEval="Ver evaluaci&oacute;n";

if($configuracion!="")
{
	$configuracion=json_decode($configuracion);
	
	if(isset($configuracion->leyendaEval))
		$leyendaEval=$configuracion->leyendaEval;

	if(isset($configuracion->leyendaVerEval))
		$leyendaVerEval=$configuracion->leyendaVerEval;
	
	switch($configuracion->formatoUsuario)
	{
		case "1":
			$formatoUsr="concat(i.Nom,' ',i.Paterno,' ',i.Materno)";
		break;
		case "2":
			$formatoUsr="concat(i.Paterno,' ',i.Materno,', ',i.Nom)";
		break;
	}
	switch($configuracion->ordenUsuario)
	{
		case "1":
			$orden="i.Nom";
			$ordenGrid="{field:'nombre'}";
		break;
		case "2":
			$orden="i.Paterno";
			$ordenGrid="{field:'paterno'}";
		break;
		case "3":
			$orden="i.Materno";
			$ordenGrid="{field:'materno'}";
		break;
		case "4":
			$orden="e.descParticipacion,i.Nom";
			$ordenGrid="{field:'descParticipacion'},{field:'nombre'}";
		break;
		case "5":
			$orden="e.descParticipacion,i.Paterno";
			$ordenGrid="{field:'descParticipacion'},{field:'paterno'}";
		break;
		case "6":
			$orden="e.descParticipacion,i.Materno";
			$ordenGrid="{field:'descParticipacion'},{field:'materno'}";
		break;
	}
	
	if(isset($configuracion->mostrarMail)&&($configuracion->mostrarMail==1))
		$ocultarMail='false';
	if(isset($configuracion->mostrarTel)&&($configuracion->mostrarTel==1))
		$ocultarTel='false';		
	
	
}
$arrAutores="";
if($idFrmEval!="-1")
{
	$consulta="select id_246_autoresVSProyecto,".$formatoUsr." as nombre,a.orden,if(responsable=1,true,false) as responsable,
				claveParticipacion,(select id__".$idFrmEval."_tablaDinamica from _".$idFrmEval."_tablaDinamica where idReferencia=a.id_246_autoresVSProyecto limit 0,1) as evaluacion,
				a.idUsuario,i.Paterno,i.Materno,i.Nom,e.descParticipacion,
				(SELECT GROUP_CONCAT(mail) FROM 805_mails WHERE idUsuario=a.idUsuario)	AS mail,
				(SELECT GROUP_CONCAT(Numero) FROM 804_telefonos WHERE idUsuario=a.idUsuario) AS telefonos
				from 246_autoresVSProyecto a,802_identifica i,953_elementosPerfilesParticipacionAutor e 
				where i.idUsuario=a.idUsuario and a.idFormulario=".$idFormulario." and a.idReferencia=".$_GET["idRegistro"]." and e.idElementoPerfilAutor=a.claveParticipacion
				order by ".$orden;
	
				
				
}
else
{
	$consulta="select id_246_autoresVSProyecto,".$formatoUsr." as nombre,a.orden,if(responsable=1,true,false) as responsable,
				claveParticipacion,'' as evaluacion,a.idUsuario,i.Paterno,i.Materno,i.Nom,e.descParticipacion,
				(SELECT GROUP_CONCAT(mail) FROM 805_mails WHERE idUsuario=a.idUsuario)	AS mail,
				(SELECT GROUP_CONCAT(Numero) FROM 804_telefonos WHERE idUsuario=a.idUsuario) AS telefonos  
				from 246_autoresVSProyecto a,802_identifica i,953_elementosPerfilesParticipacionAutor e 
				where i.idUsuario=a.idUsuario and a.idFormulario=".$idFormulario." and a.idReferencia=".$_GET["idRegistro"]." and e.idElementoPerfilAutor=a.claveParticipacion 
				order by ".$orden;

}



$resAutores=$con->obtenerFilas($consulta);				
while($fila=mysql_fetch_row($resAutores))
{
	$obj="";
	foreach($fila as $campo)
	{
		if($obj=="")
			$obj="'".$campo."'";
		else
			$obj.=",'".$campo."'";
	}
	
	if($mostrarAfiliacion=='true')
	{
		$obj.=",'".obtenerAfiliacion($fila[6])."'";
	}
	
	if($arrAutores=="")
		$arrAutores="[".$obj."]";
	else
		$arrAutores.=",[".$obj."]";
}

$arrAutores="[".$arrAutores."]";

$consulta="select idElementoPerfilAutor,descParticipacion from 953_elementosPerfilesParticipacionAutor where idPerfilAutor=".$idPerfil;
$arrParticipacion=uEJ($con->obtenerFilasArreglo($consulta));


?>
Ext.form.TriggerField.override	(
                                    {
                                        afterRender: function() 
                                        			{
                                             			Ext.form.TriggerField.superclass.afterRender.call(this);
                                        			}
                                    }
                               	);

var arrParticipacion=<?php echo $arrParticipacion?>;

var idForm;
var idReg;
var mostrarAfil=<?php echo $mostrarAfiliacion?>;

Ext.onReady(inicializarCombos);
var numIni=1;
var ocultarBtnDel=false;

function inicializarCombos()
{
	
	idForm=gE('idFormulario').value;
    idReg=gE('idRegistro').value;
    var txtApPaterno=gE('txtApPaterno');
	if(txtApPaterno!=null)
    {
        var pPagina=new Ext.data.HttpProxy	(
                                                {
                                                    url: '../paginasFunciones/funcionesProyectos.php', 
                                                    method:'POST' 
                                                }
                                            );
                                            
        var lector =new Ext.data.JsonReader	(
                                                {
                                                    root: 'autores',
                                                    totalProperty: 'numAutores',
                                                    id:'idAutor'
                                                }, 
                                                [
                                                    {name:'idAutor',mapping:'idAutor'},
                                                    {name: 'apPat', mapping: 'apPat'},
                                                    {name: 'apMat', mapping: 'apMat'},
                                                    {name: 'nombres', mapping: 'nombres'},
                                                    {name:	'fichaOrg',mapping:'fichaOrg'}
                                                ]
                                            );	
        var parametros=	{
                            funcion:'23',
                            idFormulario:idForm,
                            idRegistro:idReg,
                            datosAutor:''
                        }
    
    
            generarComboApPaterno(pPagina,lector,parametros);
            generarComboApMaterno(pPagina,lector,parametros);
            generarComboNombres(pPagina,lector,parametros);	
            Ext.getCmp('cmbApPaterno').focus(true,10);
       	}
        else
        	ocultarBtnDel=true;
        crearGridAutores();
		
  
		
}

function generarComboApPaterno(pPagina,lector,parametros)
{
	var ds = new Ext.data.Store	(
                                    {
                                        proxy:	pPagina,												
                                        reader: lector,
                                        baseParams:	parametros
                                    }
                                );
	
	function funcCargarDatos(dSet,opciones)
    {
        var apPaterno=Ext.getCmp('cmbApPaterno').getValue();
        var apMaterno=Ext.getCmp('cmbApMaterno').getValue();
        var nombres=Ext.getCmp('cmbNombres').getValue();
        var lblAfil= gE('lblAfiliacion');
        if(lblAfil!=null)
	       	lblAfil.innerHTML='';
        oE('btnAgregarAutor');
        var datos='{"apPaterno":"'+cv(apPaterno)+'","apMaterno":"'+cv(apMaterno)+'","nombres":"'+cv(nombres)+'"}';
        dSet.setBaseParam('datosAutor',datos);
        //dSet.baseParams.datosAutor=datos;
        
    }
	ds.on('beforeload',funcCargarDatos);	
	var ficha='';
    if(mostrarAfil)	
    	ficha='{fichaOrg}';
	var resultTpl = new Ext.XTemplate	(
											'<tpl for="."><div class="search-item">',
												'<b>{apPat}</b> {apMat}, {nombres}<br>'+ficha+'<br>',
											'</div></tpl>'
										);
	
	var buscarApPaterno = new Ext.form.ComboBox	
	(
		{
			x:8,
			id:'cmbApPaterno',
			store: ds,
			displayField:'nombreC',
			typeAhead: false,
			minChars:1,
			loadingText: 'Buscando...',
			width: 250,
			pageSize:10,
			hideTrigger:true,
			tpl: resultTpl,
			applyTo: 'txtApPaterno',
			itemSelector: 'div.search-item'
		}
	);
	
	buscarApPaterno.on('select',funcSeleccionado);

}

function generarComboApMaterno(pPagina,lector,parametros)
{
	var ds = new Ext.data.Store	
	(
		{
			proxy:	pPagina,												
			reader: lector,
			baseParams:	parametros
		}
	);
	
   function funcCargarDatos(dSet,opciones)
    {
        var apPaterno=Ext.getCmp('cmbApPaterno').getValue();
        var apMaterno=Ext.getCmp('cmbApMaterno').getValue();
        var nombres=Ext.getCmp('cmbNombres').getValue();
        var lblAfil= gE('lblAfiliacion');
        if(lblAfil!=null)
	       	lblAfil.innerHTML='';
        oE('btnAgregarAutor');
        dSet.baseParams.datosAutor='{"apPaterno":"'+cv(apPaterno)+'","apMaterno":"'+cv(apMaterno)+'","nombres":"'+cv(nombres)+'"}';
    }

	ds.on('beforeload',funcCargarDatos);	
	var ficha='';
    if(mostrarAfil)	
    	ficha='{fichaOrg}';

	var resultTpl = new Ext.XTemplate	(
											'<tpl for="."><div class="search-item">',
												'{apPat} <b>{apMat}</b>, {nombres}<br>'+ficha+'<br />',
											'</div></tpl>'
										);

	var buscarApMaterno = new Ext.form.ComboBox	
	(
		{
			x:8,
			id:'cmbApMaterno',
			store: ds,
			displayField:'nombreC',
			typeAhead: false,
			minChars:1,
			loadingText: 'Buscando...',
			width: 250,
			pageSize:10,
			hideTrigger:true,
			tpl: resultTpl,
			applyTo: 'txtApMaterno',
			itemSelector: 'div.search-item'
		}
	);
	buscarApMaterno.on('select',funcSeleccionado);
}

function generarComboNombres(pPagina,lector,parametros)
{
	var ds = new Ext.data.Store	
	(
		{
			proxy:	pPagina,												
			reader: lector,
			baseParams:	parametros
		}
	);
    
	
	function funcCargarDatos(dSet,opciones)
    {
        var apPaterno=Ext.getCmp('cmbApPaterno').getValue();
        var apMaterno=Ext.getCmp('cmbApMaterno').getValue();
        var nombres=Ext.getCmp('cmbNombres').getValue();
        var lblAfil= gE('lblAfiliacion');
        if(lblAfil!=null)
	       	lblAfil.innerHTML='';
        oE('btnAgregarAutor');
        dSet.baseParams.datosAutor='{"apPaterno":"'+cv(apPaterno)+'","apMaterno":"'+cv(apMaterno)+'","nombres":"'+cv(nombres)+'"}';
    }
	ds.on('beforeload',funcCargarDatos);	
	
	var ficha='';
    if(mostrarAfil)	
    	ficha='{fichaOrg}';

	var resultTpl = new Ext.XTemplate	(
											'<tpl for="."><div class="search-item">',
												'{apPat} {apMat}, <b>{nombres}</b><br>'+ficha+'<br />',
											'</div></tpl>'
										);

	var buscarNombres = new Ext.form.ComboBox	
	(
		{
			x:8,
			id:'cmbNombres',
			store: ds,
			displayField:'nombreC',
			typeAhead: false,
			minChars:1,
			loadingText: 'Buscando...',
			width: 250,
			pageSize:10,
			hideTrigger:true,
			tpl: resultTpl,
			applyTo: 'txtNombres',
			itemSelector: 'div.search-item'
		}
	);
	buscarNombres.on('select',funcSeleccionado);
}

function funcSeleccionado(combo,registro)
{
    var apPaterno=registro.get('apPat');
    var apMaterno=registro.get('apMat');
    var nombres=registro.get('nombres');
    mE('btnAgregarAutor');
    Ext.getCmp('cmbApPaterno').setValue(apPaterno);
    Ext.getCmp('cmbApMaterno').setValue(apMaterno);
    Ext.getCmp('cmbNombres').setValue(nombres);
    Ext.getCmp('cmbNombres').focus(false,100);
    gE('institucionSel').value=registro.get('fichaOrg');
    
    
    var lblAfil= gE('lblAfiliacion');
        if(lblAfil!=null)
	       	lblAfil.innerHTML=registro.get('fichaOrg');;
    gE('hIdAutor').value=registro.get('idAutor');
}

var registroAutor =Ext.data.Record.create	(
                                                [
                                                    {name: 'idAutor'},
                                                    {name: 'nombreAutor'},
                                                    {name: 'orden'},
                                                    {name: 'responsable'},
                                                    {name: 'paterno'},
                                                    {name: 'materno'},
                                                    {name: 'nombre'},
                                                    {name: 'descParticipacion'},
                                                    {name: 'mail'},
                                                    {name: 'telefono'},
                                                    {name: 'institucion'}
                                                ]
                                            )

function crearGridAutores()
{
	var alAutores=	new Ext.data.SimpleStore(
										{
											fields:	[
														{name: 'idAutor'},
														{name: 'nombreAutor'},
                                                        {name: 'orden'},
														{name: 'responsable'},
                                                        {name: 'participacion'},
                                                        {name: 'evaluacion'},
                                                        {name: 'idUsuario'},
                                                        {name: 'paterno'},
                                                        {name: 'materno'},
                                                        {name: 'nombre'},
                                                        {name :'descParticipacion'},
                                                        {name: 'mail'},
                                                        {name: 'telefono'},
                                                        {name: 'institucion'}
													]
										}
									);

	var arrPosiciones=new Array();
	var dsAutores=<?php echo $arrAutores ?>;

	var cmbParticipacion=crearComboExt('cmbParticipacion',arrParticipacion);
    var x;
    var objPosicion;
    for(x=1;x<=dsAutores.length;x++)
    {
    	objPosicion=new Array();
        objPosicion[0]=x;
        objPosicion[1]=x;
    	arrPosiciones.push(objPosicion);
    }
    
    
	var cmbOrden=crearComboExt('cmbOrden',arrPosiciones);

	alAutores.loadData(dsAutores);	
	var checkColumn = new Ext.grid.CheckColumn	(
	 												{
													   header: '<?php echo $responsable ?>',
													   dataIndex: 'responsable',
													   width: 120,
                                                       hidden:<?php echo  $ocultarColResp?>
													}
												);
	var cmAutores= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:30}),
                                                         {
                                                        	header:'Usuario',
															width:100,
															sortable:true,
															dataIndex:'idUsuario'
                                                            
                                                        },
														{
															header:'<?php echo $singular?>',
															width:220,
															sortable:true,
															dataIndex:'nombreAutor',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	return '<a href="javascript:verUsrNuevaPagina(\''+bE(registro.get('idUsuario'))+'\')">'+val+'</a>';
                                                                    }
														},
                                                        {
                                                        	header:'Participaci&oacute;n',
															width:150,
															sortable:true,
															dataIndex:'participacion',
                                                            editor:cmbParticipacion,
                                                            renderer:formatearParticipacion
                                                        },
                                                        
														{
															header:'Orden Participaci&oacute;n',
															width:120,
															sortable:true,
															dataIndex:'orden',
                                                            editor:cmbOrden,
                                                            hidden:<?php  echo $ocultarOrden?>
														},
                                                        {
															header:'Evaluaci&oacute;n',
															width:180,
															sortable:true,
															dataIndex:'evaluacion',
                                                            hidden:<?php  echo $ocultarEval?>,
                                                            renderer:function(val,meta,registro,fila)
                                                            		{
                                                                    	if(val=='')
                                                                        	return '<a href="javascript:evaluar(\''+bE(registro.get('idAutor'))+'\',\''+bE(fila)+'\')"><img src="../images/pencil.png" height="13" width="13" /><?php echo $leyendaEval?></a>';
                                                                        else
                                                                        	return '<a href="javascript:verEvaluacion(\''+bE(val)+'\',\''+bE(registro.get('idAutor'))+'\')"><img src="../images/magnifier.png" height="13" width="13" /><?php echo $leyendaVerEval?></a>';
                                                                    
                                                                    }
														},
                                                        checkColumn,
                                                        {
															header:'Instituci&oacute;n',
															width:350,
															sortable:true,
															dataIndex:'institucion',
                                                            hidden:!<?php echo $mostrarAfiliacion?>,
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	return val.replace(/<br><b>/,'').replace(/<\/b>/,'');
                                                                    }
														},
                                                        {
                                                        	header:'E-mail',
															width:180,
															sortable:true,
															dataIndex:'mail',
                                                            hidden:<?php echo $ocultarMail?>
                                                            
                                                        },
                                                        {
                                                        	header:'Tel&eacute;fonos:',
															width:200,
															sortable:true,
															dataIndex:'telefono',
                                                            hidden:<?php echo $ocultarTel?>
                                                            
                                                        }
                                                       
												
													]
												);
														
	autores=	new Ext.grid.EditorGridPanel	(
													{
														id:'autores',
                                                        store:alAutores,
                                                        frame:true,
                                                        cm: cmAutores,
                                                        height:500,
                                                        width:850,
														plugins:checkColumn,
												        clicksToEdit:1,
														renderTo:'divAutores',
														tbar:[
																{
																	text:'Remover <?php echo $singular ?>',
                                                                    icon:'../images/cancel_round.png',
                                                                    cls:'x-btn-text-icon',
                                                                    hidden:ocultarBtnDel,
																	handler:function()
																			{
																				var autores=Ext.getCmp('autores');
																				var celda=autores.getSelectionModel().getSelectedCell();
																				if(celda!=null)
																				{
																					fila=autores.getStore().getAt(celda[0]);
																					function funcConfirmDel(btn)
																					{
																						if(btn=="yes")
																						{
                                                                                        	<?php
																							if(!$ocultarColResp)
																							{
																							?>
                                                                                                if(fila.get('responsable'))
                                                                                                {
                                                                                                    msgBox('No se puede remover al <?php echo $singular ?> seleccionado ya que &eacute;ste cuenta con el papel de <?php echo $responsable?> del registro, si desea remover dicho <?php echo $singular ?> primero debe transferir dicha responsabilidad a otra persona')
                                                                                                }
                                                                                                else
                                                                                                    quitarAutor(fila,alAutores);
                                                                                            <?php
																							}
																							else
																								echo "quitarAutor(fila,alAutores)";
                                                                                            ?>
                                                                                            
																						}
																					}
																					Ext.Msg.confirm('<?php echo $etj["lblAplicacion"] ?>','Est&aacute; seguro de querer remover el <?php echo $singular ?> seleccionado?',funcConfirmDel);
																					
																				}
																				else
																				{
																					msgBox('Primero debe seleccionar al <?php echo $singular?> a remover');
																				}																			}

																}
															 ]
															
															
													}
					
    											);
	autores.on('afteredit',funcEditar);
    autores.on('beforeedit',funcAntesEditar);
}

function funcEditar(e)
{
	var idRef=gE('idRegistro').value;
    var idFrm=gE('idFormulario').value;
    
	if(e.field=='orden')
    {
	
    	function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
            	if(e.value>e.originalValue)
                {
                	var x;
                    for(x=0;x<autores.getStore().getCount();x++)
                    {
                    	fila=autores.getStore().getAt(x);
                    	if(e.record.get('idAutor')!=fila.get('idAutor'))
                        {
                        	var vFila=parseInt(fila.get('orden'));
                            if((vFila>parseInt(e.originalValue))&&(vFila<=parseInt(e.value)))
                            	fila.set('orden',vFila-1);
                        }
                    }
                }
                else
                {
                	var x;
                    for(x=0;x<autores.getStore().getCount();x++)
                    {
                    	fila=autores.getStore().getAt(x);
                    	if(e.record.get('idAutor')!=fila.get('idAutor'))
                        {
                        	var vFila=parseInt(fila.get('orden'));
                            if((vFila>=parseInt(e.value))&&(vFila<parseInt(e.originalValue)))
                            	fila.set('orden',vFila+1);
                        }
                    }
                }
                
                autores.getStore().sort('orden','ASC');
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=26&idAutor='+e.record.get('idAutor')+'&nValor='+e.value+'&vValor='+e.originalValue+'&idFormulario='+idForm+'&idRegistro='+idReg,true);
        	
    }
    
    if(e.field=='participacion')
    {
    	function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=77&idFormulario='+idFrm+'&idReferencia='+idRef+'&idUsuario='+e.record.get('idAutor')+'&participacion='+cv(e.value),true);
    }
    
    if(e.field=='responsable')
	{
		if(e.value)
		{
        	var alAutores=e.grid.getStore();
			var ct=alAutores.getCount();
			var x;
			var filaAutores;
			var pAc=-1;
			filaRef=e.record;
			for(x=0;x<ct;x++)
			{
				filaAutores=alAutores.getAt(x);
				if((filaAutores.get('responsable')==true)&&(filaAutores.get('idAutor')!=filaRef.get('idAutor')))
				{
					pAc=x;
					break;
				}
			}
			if(	pAc!=-1)
			{		
				var filaAc=alAutores.getAt(pAc);
				function funcRespuesta(btn)
				{
					if(btn=='yes')
					{
						filaAutores.set('responsable',false);
						e.grid.getView().refresh();
						asignarAutorResponsable(filaRef.get('idAutor'));
					}
					else
					{
						filaRef.set('responsable',false);
						e.grid.getView().refresh();
											
					}
				}		
				var msgYaExiste='El papel de <?php echo $responsable?> s&oacute;lo puede ser asignado a una persona, actualmente est&aacute; asignado a "@autor", desea que dicho rol sea reasignado a "@autor2"';
				msgYaExiste=msgYaExiste.replace(/@autor/,filaAc.get('nombreAutor'));
				msgYaExiste=msgYaExiste.replace(/@autor2/,filaRef.get('nombreAutor'));
				Ext.MessageBox.confirm('<?php echo $etj['lblAplicacion']?>',msgYaExiste,funcRespuesta);
			}
			else
			{
				asignarAutorResponsable(filaRef.get('idAutor'));
			}
		}
		else
		{
			/*filaRef=e.record;
			function funcRespuesta(btn)
			{
				if(btn=='yes')
					asignarAutorResponsable('-1');
				else
				{
					filaRef.set('responsable',true);
					e.grid.getView().refresh();
				}
			}		
			var msgYaExiste='Con esta acci&oacute;n, dejara sin <?php echo $responsable?> al registro. <br><b>Nota:</b> Recuerde que mientras no cuente con un <?php echo $responsable?> asignado, su registro no podr&aacute; ser sometido a revisi&oacute;n. Desea continuar?';
			Ext.MessageBox.confirm('<?php echo $etj['lblAplicacion']?>',msgYaExiste,funcRespuesta);*/
		}
	}
}



function asignarAutorResponsable(idAutor)
{
	var idFormulario=gE('idFormulario').value;
    var idReferencia=gE('idRegistro').value;
	function funcAjax()
	{
		var resp=peticion_http.responseText.split('|');
		if(resp[0]!="1")
		{
			 msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+resp[0]);
		}
	}
	obtenerDatosWeb("../paginasFunciones/funcionesProyectos.php",funcAjax,'POST','funcion=106&idAutor='+idAutor+'&idFormulario='+idFormulario+'&idReferencia='+idReferencia,true);
}

function funcAntesEditar(e)
{
	/*if(e.field=='participacion')
    {
		var participa=e.value;
        
        if(participa==cvePrincipal)
        {
        
            var almacen=Ext.getCmp('autores').getStore();
            var pos=obtenerPosFila(almacen,'participacion',participa);
            if(pos!=-1)
            {
            	e.cancel=true;
                msgBox('No se ha podido asignar la participaci&oacute;n seleccionada debido a que &eacute;sta ya esta siendo ocupada por otra persona');
                return;
            }
        }
	
    }*/
    if(e.field=='responsable')
    {
    	if(e.value)
        	e.cancel=true;
    }
}

function formatearParticipacion(val)
{
	var pos=existeValorMatriz(arrParticipacion,val);
	if(pos!=-1)
    	return arrParticipacion[pos][1];
    else
    	return val;
}

var cvePrincipal='<?php echo $principal?>';

function agregarAutor()
{
    var idAutor=gE('hIdAutor').value;
    var idAut=idAutor;
    var nOrden=Ext.getCmp('autores').getStore().getCount();
    nOrden++;
    var cParticipacion=gE('cParticipacion');
    var participa=cParticipacion.options[cParticipacion.selectedIndex].value;
    var dParticipacion=cParticipacion.options[cParticipacion.selectedIndex].text;
    var almacen=Ext.getCmp('autores').getStore();
    if(participa==cvePrincipal)
    {
    	
        var pos=obtenerPosFila(almacen,'participacion',participa);
    	if(pos!=-1)
        {
        	 msgBox('No se ha podido asignar la participaci&oacute;n seleccionada debido a que &eacute;sta ya esta siendo ocupada por otra persona');
            return;
        }
    }
	
    
    var x;
    var fila;
    for(x=0;x<almacen.getCount();x++)
    {
    	fila=almacen.getAt(x);
        if((fila.get('participacion')==participa)&&(fila.get('idUsuario')==idAutor))
        {
        	msgBox('La persona seleccionada ya ha sido agragada anteriormente con la participaci&oacute;n elegida');
            return;
        }
    }
    
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
	        var apPaterno=Ext.getCmp('cmbApPaterno').getRawValue();
            var apMaterno=Ext.getCmp('cmbApMaterno').getRawValue();
            var nombre=Ext.getCmp('cmbNombres').getRawValue();
        	var nNombre=nombre;
			var  nAutor=apPaterno+' '+apMaterno+', '+ nombre;       	
        
        	var nAutor=new registroAutor	(		
                                                {
                                                    idAutor:arrResp[1],
                                                    nombreAutor: nAutor,
                                                    orden:nOrden,
                                                    participacion:participa,
                                                    evaluacion:'',
                                                    idUsuario:idAutor,
                                                    paterno:apPaterno,
                                                    materno:apMaterno,
                                                    nombre:nNombre,
                                                    descParticipacion:dParticipacion,
                                                    institucion:gE('institucionSel').value
                                                }
                                            );
			Ext.getCmp('autores').getStore().add(nAutor);  
            var orden=[<?php echo $ordenGrid?>];                                      
            Ext.getCmp('autores').getStore().sort(orden);
            var cmbOrden=Ext.getCmp('cmbOrden');
            var filaOrden=new registroSimple(
            									{
                                                	'id':nOrden,
                                                    'nombre':nOrden
                                                }
                                            )
            
            cmbOrden.getStore().add(filaOrden);                            
            if(typeof(funcAgregar)!='undefined')
						funcAgregar();                       
        	limpiarControles();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=24&idAutor='+idAutor+'&idFormulario='+idForm+'&idRegistro='+idReg+'&orden='+nOrden+'&participa='+participa,true);
}

function limpiarControles()
{
	var lblAfil=gE('lblAfiliacion');
    if(lblAfil!=null)
		lblAfil.innerHTML='';
	gE('hIdAutor').value='';
	Ext.getCmp('cmbApPaterno').setValue('');
	Ext.getCmp('cmbApMaterno').setValue('');
	Ext.getCmp('cmbNombres').setValue('');
	Ext.getCmp('cmbApPaterno').focus(true,10);
	oE('btnAgregarAutor');
}

function quitarAutor(fila,alAutores)
{
	var orden=fila.get('orden');
	function funcEliminar()
	{
		var resp=peticion_http.responseText.split('|');
		if((resp[0]=='1')||(resp[0]==1))
		{
			alAutores.remove(fila);	
            var x;
            
            for(x=0;x<autores.getStore().getCount();x++)
            {
                filaAct=autores.getStore().getAt(x);
                var vFila=parseInt(filaAct.get('orden'));
                if(vFila>parseInt(orden))
                	filaAct.set('orden',vFila-1);
            }
            var cmbOrden=Ext.getCmp('cmbOrden');
            cmbOrden.getStore().removeAt(cmbOrden.getStore().getCount()-1);
            if(typeof(funcAgregar)!='undefined')
				funcAgregar();     
		}
		else
		{
			msgBox('<?php echo $etj["msgError2"]?>'+' <br />'+resp[0]);
		}
	}
	obtenerDatosWeb("../paginasFunciones/funcionesProyectos.php",funcEliminar,'POST','funcion=25&idAutor='+fila.get('idAutor')+'&idFormulario='+idForm+'&idRegistro='+idReg+'&orden='+orden,true);
}

function registrarNuevoAutor()
{
    var cPagina=gE('cPagina').value;
    var arrParam;
    if(cPagina=='')
    {
        tb_show(lblAplicacion,'../modeloProyectos/agregarAutores.php?idFormulario='+bE(idForm)+'&idRegistro='+bE(idReg)+'&TB_iframe=true&height=530&width=900',"","scrolling=yes",recargarPaginaAutores);
    }
    else
    {
        tb_show(lblAplicacion,'../modeloProyectos/agregarAutores.php?cPagina='+cPagina+'&idFormulario='+bE(idForm)+'&idRegistro='+bE(idReg)+'&TB_iframe=true&height=530&width=900',"","scrolling=yes",recargarPaginaAutores);
    
    }
}

function recargarPaginaAutores(cerrarThick)
{
	recargarPagina();
}

function asignarValor(fila,valor)
{
	gEx('autores').getStore().getAt(fila).set('evaluacion',valor);
}

function evaluar(idUsuario,fila)
{
    var arrDatos=[['idFormulario','<?php echo $idFrmEval?>'],['idRegistro','-1'],['idReferencia',bD(idUsuario)],['cPagina','sFrm=true'],['accionCancelar','window.close()'],['eJs',bE('window.opener.asignarValor('+bD(fila)+',@idRegistro);window.close();return;')]];//
    window.open('',"vAuxiliar", "toolbar=no,directories=no,menubar=no,status=no,scrollbars=yes,fullscreen=yes");
    enviarFormularioDatos('../modeloPerfiles/registroFormulario.php',arrDatos,'POST','vAuxiliar');	
}

function verEvaluacion(iE,iU)
{
	var arrDatos=[['idFormulario','<?php echo $idFrmEval?>'],['idRegistro',bD(iE)],['cPagina','sFrm=true'],['idReferencia',bD(iU)]];
    window.open('',"vAuxiliar", "toolbar=no,directories=no,menubar=no,status=no,scrollbars=yes,fullscreen=yes");
    enviarFormularioDatos('../modeloPerfiles/verFichaFormulario.php',arrDatos,'POST','vAuxiliar');	
}