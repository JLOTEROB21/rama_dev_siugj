<?php session_start();
	include("configurarIdiomaJS.php");
?>
var editor;
var idDoc=null;
function regresar()
{
    gE('frmRegresar').submit();
}

Ext.onReady(inicializar);

function inicializar()
{
	var div = document.getElementById("textArea");
    var fck = new FCKeditor("myFCKeditor",'100%',220);
    fck.Config["CustomConfigurationsPath"] = "../fckconfig2.js" 
    div.innerHTML = fck.CreateHtml();
    div=document.getElementById("txtPieIzq");
    fck = new FCKeditor("editorPieIzq",'100%',150);
    fck.Config["CustomConfigurationsPath"] = "../fckconfig2.js" 
    div.innerHTML = fck.CreateHtml();
    div=document.getElementById("txtPieDer");
    fck = new FCKeditor("editorPieDer",'100%',150);
    fck.Config["CustomConfigurationsPath"] = "../fckconfig2.js" 
    div.innerHTML = fck.CreateHtml();
}

function FCKeditor_OnComplete( editorInstance )
{
	var nEditor=editorInstance.Name;
    switch(nEditor)
    {
    	case 'myFCKeditor':
        	editorInstance.SetData(bD(contenido));
        break;
        case 'editorPieIzq':
        	editorInstance.SetData(bD(pieIzq));
        break;
        case 'editorPieDer':
        	editorInstance.SetData(bD(pieDer));
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
    editor = FCKeditorAPI.GetInstance('editorPieIzq') ;
    gE('valorPieIzq').value=editor.GetXHTML(true);
    editor = FCKeditorAPI.GetInstance('editorPieDer') ;
    gE('valorPieDer').value=editor.GetXHTML(true);
    
    gE('frmEnvio').submit();
}

function mostrarVentanaImg()
{
	var conf=  	{
                    url:'../media/get-images.php',
                    width:815,
                    height:480,
                    verTiposImg:'3',
                    guardarTipoImg:3
                }
	showVentanaImagen(conf);                
}

function cambiarDisplay(id) 
{
    if (!document.getElementById) 
        return false;
    fila = document.getElementById(id);
    if (fila.style.display != "none") 
        fila.style.display = "none"; 
    else 
        fila.style.display = "";
}

function vaciarCampos()
{
	gE('up').value='';
  	gE('colorBoton').value = 'FFFFFF';
}

function restaurar()
{
	function resp(btn)
    {
    	if(btn=='yes')
        	location.href='defaultE.php';
    }
    Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; segura de querer restaurar los valores predeterminados',resp);
}


function mostrarColor(combo)
{
	if(combo.checked)
    {
    	oE('divImagen');
        mE('divColor');
    }
}

function mostrarImagen(combo)
{
	if(combo.checked)
    {
        oE('divColor');
        mE('divImagen');
    }
}