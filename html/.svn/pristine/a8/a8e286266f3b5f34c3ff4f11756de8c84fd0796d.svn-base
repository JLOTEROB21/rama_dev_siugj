Ext.onReady(Iniciar);
function Iniciar()
{
	var FNac=new Ext.form.DateField
									(
										{
											id:'fecha',
											x:0,
											y:0,
											width:110,
											format:'d/m/Y',
											renderTo:'FNac',
											readOnly:true,
											height:150,
											cls:'campoFecha'
										}
									)
	var FNacimiento=gE('FNacimiento');
	FNac.setValue(FNacimiento.value);
	gE('Apat').focus();
}

var keyMap = new Ext.KeyMap(document, 
									{
										key: 13, 
										fn: funValidar,
										scope: this
									}
							);

function funValidar()
{
	var btnAccion=gE('btnGuardar');
	btnAccion.click();
}



function guardarDatos(IdAl)
{
	
	if(validarFormularios('nuevo'))
	{
		var Apat=gE('Apat');
		var Amat=gE('Amat');
		var Nombre=gE('Nombre');
		var FNacimiento=gE('FNacimiento');
		var cmbGenero=gE('cmbGenero');
		var CURP=gE('CURP');
		var cmbPrograma=gE('cmbPrograma');
		var cmbGrado=gE('cmbGrado');
		//var cmbGrupo=gE('cmbGrupo');
		
		
		var obj='{"Apat":"'+Apat.value+'","Amat":"'+Amat.value+'","Nombre":"'+Nombre.value+'","FNacimiento":"'+FNacimiento.value+'","cmbGenero":"'+cmbGenero.value+'","CURP":"'+CURP.value+'","cmbPrograma":"'+cmbPrograma.value+'","cmbGrado":"'+cmbGrado.value+'","IdAlumno":"'+IdAl+'"}';
		
		function funcTratarRespuesta()
		{
			var resp=peticion_http.responseText;
			var arrResp=resp.split('|');
			if(arrResp[0]=='1' || arrResp[0]==1)
			{
				keyMap.disable();
				function miFuncion()
				{
					document.location.href="datosAlumnosSolicitudes.php";
				}
				Ext.MessageBox.alert(lblAplicacion,'Los datos del alumno han sido actualizados satisfactoriamente.',miFuncion)
			}
		}
		obtenerDatosWeb('procesarDatosAlumno.php',funcTratarRespuesta, 'POST','funcion=1&objDatos='+obj);	
	}
}

function cargarCombo()
{
	var cmbPrograma=gE('cmbPrograma');
	
	var lblGrado=gE('lblGrado');
		
		if(cmbPrograma.value==4)
			lblGrado.innerHTML="Semestre:";
		else
			lblGrado.innerHTML="Grado:";
			
	function funcTratarRespuesta()
	{
		var resp=peticion_http.responseText;	
		var arrResp=resp.split('|');
		if(arrResp[0]=='1' || arrResp[0]==1)
		{
			//Grados
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
				nuevaOpcion.text=objResp.Grado;
				cmbGrado.options[cmbGrado.length]=nuevaOpcion;
			}
			
			//Grupos
			var arrObjResp=eval(arrResp[2]);

			var cmbGrupo=gE('cmbGrupo');
			var x;
			var nuevaOpcion;
			limpiarCombo(cmbGrupo);
			for(x=0;x<arrObjResp.length;x++)
			{
				objResp=arrObjResp[x];
				nuevaOpcion=document.createElement('option');
				nuevaOpcion.value=objResp.IdGupo;
				nuevaOpcion.text=objResp.Grupo;
				cmbGrupo.options[cmbGrupo.length]=nuevaOpcion;
			}
		}
		else
			alert("Error :"+arrResp[0]);
			
			
	}
	obtenerDatosWeb('procesarDatosAlumno.php',funcTratarRespuesta, 'POST','funcion=2&objDatos='+cmbPrograma.value);		
}
