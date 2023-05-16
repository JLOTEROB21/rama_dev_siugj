//Ext.onReady(Iniciar);
var numEjecucion=1;
Ext.onReady(inicializar);
function inicializar()
{
	
	if(numEjecucion==1)
	{
		numEjecucion++;
		var FNac=new Ext.form.DateField
										(
											{
												id:'fecha',
												x:0,
												y:0,
												width:110,
												format:'d/m/Y',
												maxValue: new Date(), 
												renderTo:'FNacim',
												readOnly:true,
												height:150,
												cls:'campoFecha'
											}
										)
		var FNacimiento=gE('FNacimiento');
		FNac.setValue(FNacimiento.value);
		setTimeout(	function()
					{ 
						gE('APaterno').focus(); 
					}, 
					10); 
	}
	
	
}

/*var keyMap = new Ext.KeyMap(document, 
									{
										key: 13, 
										fn: funAceptar,
										scope: this
									}
							);*/

function funAceptar()
{
	Guardar('nuevo');
}

function cargarCombo()
{
	var cmbPrograma=gE('cmbPrograma');
	
	var lblGrado=gE('lblGrado');
		
		if(cmbPrograma.value==4)
			lblGrado.innerHTML="Semestre:"
		else
			lblGrado.innerHTML="Grado:"
			
	function funcTratarRespuesta()
	{
	
		var resp=peticion_http.responseText;	
		var arrResp=resp.split('|');
		if(arrResp[0]=='1' || arrResp[0]==1)
		{
			var arrObjResp=eval(arrResp[1]);

			var cmbGrado=gE('cmbGrado');
			var x;
			var nuevaOpcion;
			limpiarCombo(cmbGrado);
			for(x=0;x<arrObjResp.length;x++)
			{
				objResp=arrObjResp[x];
				nuevaOpcion=document.createElement('option');
				nuevaOpcion.value=objResp.IdGrado;
				nuevaOpcion.text=objResp.Grado+"º";
				cmbGrado.options[cmbGrado.length]=nuevaOpcion;
			}
		}
		else
			alert("Error :"+arrResp[0]);
			
			
	}
	obtenerDatosWeb('../paginasFunciones/procesarNuevoAspirante.php',funcTratarRespuesta, 'POST','funcion=1&objDatos='+cmbPrograma.value);		
}

function Guardar(form)
{	
	
	if (!validarFormularios(form))
	{
		return;
	}
	
	var cmbRelacion=gE('idRelacion');
	var idRelacion=cmbRelacion.options[cmbRelacion.selectedIndex].value;
	if(idRelacion==-1)
	{
		function resp()
		{
			cmbRelacion.focus();
		}
		Ext.MessageBox.alert(lblAplicacion,'Debe indicar su relaci&oacute;n con el nuevo ingreso',resp);
		return;
	}
	
	var APaterno=gE('APaterno');
	var AMaterno=gE('AMaterno');
	var Escuela=gE('Escuela');
	var Nombre=gE('Nombre');
	var FNac=gE('FNac');
	var Sexo=gE('Sexo');
	var CURP=gE('CURP');
	var cmbPrograma=gE('cmbPrograma');
	var cmbGrado=gE('cmbGrado');
	var FNac=gE('fecha');
	var nomPrograma=cmbPrograma.options[cmbPrograma.selectedIndex].text;
	//var dt=new Date(FNac.value);
	var obj='{"APaterno":"'+cv(APaterno.value)+'","AMaterno":"'+cv(AMaterno.value)+'","Nombre":"'+cv(Nombre.value)+'","Sexo":"'+cv(Sexo.value)+'","CURP":"'+cv(CURP.value)+'","cmbPrograma":"'+cv(cmbPrograma.value)+'","FNac":"'+cv(FNac.value)+'","cmbGrado":"'+cv(cmbGrado.value)+'","Escuela":"'+cv(Escuela.value)+'","relacion":"'+idRelacion+'"}';
	function funcTratarRespuesta()
	{	
		var resp=peticion_http.responseText;
		
		var arrResp=resp.split('|');
		if(arrResp[0]=='1' || arrResp[0]==1)
		{
			function miFuncion()
			{
				var idAlumno=arrResp[1];
				parent.parent.GB_hide();
				var obj='[{\"nombre\":\"'+Nombre.value+' '+APaterno.value+' '+AMaterno.value+'\",\"grado\":\"'+cmbGrado.value+'\",\"programa\":\"'+nomPrograma+'\",\"idAlumno\":\"'+idAlumno+'\","idRelacion":"'+idRelacion+'","idRelAlumPers":"'+arrResp[2]+'"}]';
				
				//parent.parent.location.reload();
				parent.parent.agregarNuevoAlumno(obj);
			}
			Ext.MessageBox.alert(lblAplicacion,'Los datos del nuevo nuevo aspirante se han registrado con éxito',miFuncion);
		}
		else
			Ext.MessageBox.alert(lblAplicacion,'Error :'+arrResp[0]);
	}
	obtenerDatosWeb('../paginasFunciones/procesarNuevoAspirante.php',funcTratarRespuesta, 'POST','funcion=2&objDatos='+obj);		
	
}

