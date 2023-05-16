<?php session_start();
	include("configurarIdiomaJS.php");
?>
var editor;
var idDoc=null;
function regresar()
{
	/*gE('frmRegresar').action='adminConvoca.php';
    gE('frmRegresar').submit();*/
    
    document.location.href='adminConvoca.php';
}

Ext.onReady(inicializar);

function inicializar()
{
	var div = document.getElementById("textArea");
    var fck = new FCKeditor("myFCKeditor",'100%',420);
    //fck.Config["CustomConfigurationsPath"] = "../fckconfig2.js" 
    div.innerHTML = fck.CreateHtml();
    crearCampoFecha('txtFechaIni','hFechaIni');
   	crearCampoFecha('txtFechaFin','hFechaFin');
    crearCampoFecha('txtFechaIniIns','hFechaIniIns');
   	crearCampoFecha('txtFechaFinIns','hFechaFinIns');
    crearCampoFecha('txtFechaIniPre','hFechaIniPre');
   	crearCampoFecha('txtFechaFinPre','hFechaFinPre');
    

}

function FCKeditor_OnComplete( editorInstance )
{
	var nEditor=editorInstance.Name;
    switch(nEditor)
    {
    	case 'myFCKeditor':
        	editorInstance.SetData(contenido);
        break;
    }
	
}


function inserta(datos)
{
	var editor = FCKeditorAPI.GetInstance('myFCKeditor') ;
	editor.InsertHtml(datos);
} 

function guardar()
{
	var editor = FCKeditorAPI.GetInstance('myFCKeditor') ;
    gE('valorContenido').value=editor.GetXHTML(true);
    gE('frmEnvio').submit();
}

function mostrarVentanaImg()
{
	var conf=  	{
                    url:'../media/get-images.php',
                    width:815,
                    height:480,
                    verTiposImg:'1',
                    guardarTipoImg:1
                }
	showVentanaImagen(conf);                
}

function vaciarCampos()
{
	gE('up').value='';
  	gE('colorBoton').value = 'FFFFFF';
}


function mostrarImagen(combo)
{
	if(combo.checked)
    {
        oE('divColor');
        mE('divImagen');
    }
}