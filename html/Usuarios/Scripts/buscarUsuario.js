Ext.onReady(Inicializar);
function Inicializar()
{
	inicializarCombos();
	Ext.getCmp('cmbNombre').focus(true,10);
}

function ponerCBusqueda(cBusqueda)
{
	gE('cBusqueda').value=cBusqueda;
}

function inicializarCombos()
{
	var pPagina=new Ext.data.HttpProxy	(
										 	{
												url:'../Usuarios/procesarbUsuario.php',
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
												{name:'Status', mapping:'Status'},
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
											'{Paterno}&nbsp;{Materno}&nbsp;{Nom}&nbsp;<b>[{Status}]</b><br>---<br>',
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
														listWidth :300,
														listWidth :490
													}
												 );
	function funcElemSeleccionado(combo,registro)
	{	
		//document.location.href="intermediaMostrar.php?idUsuario="+registro.get('idUsuario');
		var sC=gE('soloContenido').value;
		if((sC=='0')||(sC==''))
			var arrParam=[['idUsuario',Base64.encode(registro.get('idUsuario'))]];
		else
			var arrParam=[['idUsuario',Base64.encode(registro.get('idUsuario'))],['cPagina','sFrm=true|mR1=true']];
		
		enviarFormularioDatos('../Usuarios/vista.php',arrParam);
	}
	
	comboNombre.on('select',funcElemSeleccionado);	
}