Ext.onReady(Inicializar);
function Inicializar()
{
	inicializarCombos();
	
}

function ponerCBusqueda(cBusqueda)
{
	gE('cBusqueda').value=cBusqueda;
	gEx('cmbNombre').reset();
	gEx('cmbNombre').setValue('');
	gEx('cmbNombre').focus();
}

function inicializarCombos()
{
	var pPagina=new Ext.data.HttpProxy	(
										 	{
												url:'procesarbUsuario.php',
												method:'POST'
											}
										 );
	var lector=new Ext.data.JsonReader 	(
										 	{
												root:'personas',
												totalProperty:'num',
												id:'idUsuario'
											},
											[
											 	{name:'idUsuario', mapping:'idUsuario'},
												{name:'Paterno', mapping:'Paterno'},
												{name:'Materno', mapping:'Materno'},
												{name:'Nom', mapping:'Nom'},
												{name:'Nombre', mapping:'Nombre'},
												{name:'Status', mapping:'Status'}
											]
										);
	var parametros=	{
						funcion:'1',
						criterio:''
					};
	inicializarCmbNombre(pPagina,lector,parametros);
}

function inicializarCmbNombre(pagina,lector, parametros)
{
	var ds=new Ext.data.Store	(
								 	{
										proxy:pagina,
										reader:lector,
										baseParams:parametros
									}
								 );
	
	function cargarDatos(dSet)
	{
		var aNombre=Ext.getCmp('cmbNombre').getValue();
		dSet.baseParams.criterio=aNombre;
		dSet.baseParams.campoBusqueda=gE('cBusqueda').value;
	}
	
	ds.on('beforeload',cargarDatos);
	
	var resultTpl=new Ext.XTemplate	(
									 	'<tpl for="."><div class="search-item">',
											'[<b>Empleado:</b> {idUsuario}]&nbsp;{Paterno}&nbsp;{Materno}&nbsp;{Nom}&nbsp;<b><br>[{Status}]</b><br>---<br>',
										'</div></tpl>'
									 )
	
	var comboNombre= new Ext.form.ComboBox	(
												 	{
														id:'cmbNombre',
														store:ds,
														displayField:'Nombre',
														typeAhead:false,
														minChars:1,
														loadingText:'Procesando, por favor espere...',
														width:500,
														pageSize:10,
														hideTrigger:true,
														tpl:resultTpl,
														applyTo:'Nombre',
														itemSelector:'div.search-item',
														listWidth :490
													}
												 );
	function funcElemSeleccionado(combo,registro)
	{	
		var arrParam=[['idUsuario',registro.get('idUsuario').replace('<b>','').replace('</b>','')]];
		//enviarFormularioDatos('nIdentifica.php',arrParam);
		var obj={};
		obj.ancho='100%';
		obj.alto='100%';
		obj.modal=true;
		obj.url='../Usuarios/tblInformacionUsuarios.php';
		obj.params=arrParam;
		window.parent.abrirVentanaFancy(obj);
		combo.setRawValue('');
		
	}
	
	comboNombre.on('select',funcElemSeleccionado);	
}

function nuevoUsuario()
{
	
	var arrParam=[['accion','Nuevo'],['cPagina','sFrm=true'],['bandera','0']];
	//enviarFormularioDatos('nIdentifica.php',arrParam);
	var obj={};
	obj.ancho='100%';
	obj.alto='100%';
	obj.modal=true;
	obj.url='../Usuarios/nIdentifica.php';
	obj.params=arrParam;
	window.parent.abrirVentanaFancy(obj);
	
}




