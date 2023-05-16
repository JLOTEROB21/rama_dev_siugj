<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>
var arrSituacion=[['1','Cuenta activa'],['2','Cuenta inactiva'],['100','Cuenta bloqueada']];
Ext.onReady(inicializar);

function inicializar()
{
   
}

function formatearSituacion(val)
{
	return formatearValorRenderer(arrSituacion,val);
}

function nuevoUsuario()
{
	
	var arrParam=[['accion','Nuevo'],['cPagina','sFrm=true'],['bandera','0']];
	var obj={};
	obj.ancho='100%';
	obj.alto='100%';
	obj.modal=false;
    obj.funcionCerrar=recargarContenedorCentral;
	obj.url='../Usuarios/nIdentifica.php';
	obj.params=arrParam;
	abrirVentanaFancySuperior(obj);
	
}

function abrirEdicionUsuario()
{
	var grid_tblTabla=gEx('grid_tblTabla');
    var registro=grid_tblTabla.getSelectionModel().getSelected();
    if(!registro)
    {
    	msgBox('Debe seleccionar el usuario que desea editar');
    	return;
    }
    
	var arrParam=[['idUsuario',registro.get('idUsuario').replace('<b>','').replace('</b>','')]];
    
    var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.modal=false;
    obj.funcionCerrar=recargarContenedorCentral;
    obj.url='../Usuarios/tblInformacionUsuarios.php';
    obj.params=arrParam;
    abrirVentanaFancySuperior(obj);
    
}


function recargarContenedorCentral()
{
	gEx('grid_tblTabla').getStore().reload();
}