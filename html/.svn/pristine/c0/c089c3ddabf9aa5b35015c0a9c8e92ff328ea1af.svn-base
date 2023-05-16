<?php
	session_start();

	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$idFormulario=bD($_GET["iF"]);

	$idRegistro=bD($_GET["iR"]);
	
	$consulta="SELECT imagenPrincipal,imagenResumen FROM _1030_tablaDinamica WHERE id__1030_tablaDinamica=".$idRegistro;
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	
	
?>

function inyeccionCodigo()
{
	gE('sp_14098').innerHTML='<div id="divImgResumen" style="width:320px; height:240px; border-style:solid; border-width:1px; border-color: #1A3E9A;border-radius: 10px !important;"></div>';
    gE('sp_14102').innerHTML='<div id="divImgPrincipal" style="width:760px; height:310px; border-style:solid; border-width:1px; border-color: #1A3E9A;border-radius: 10px !important;"></div>';
    if(esRegistroFormulario())
    {
    	
        
        
		if(gE('idRegistroG').value=='-1')
      	{
        	gE('_responsablePublicacionmem').value='<?php echo $_SESSION["nombreUsr"]?>';
             asignarEvento(gE('imagenResumen'),'change',function(evt)
                                                            {
                                                                var ctrl = evt.target || window.event.srcElement;
                                                                let reader = new FileReader();
                                                
                                                                  reader.readAsDataURL(ctrl.files[0]);
                                                                
                                                                  reader.onload = function()
                                                                                  {
                                                                                        let preview = document.getElementById('divImgResumen'),
                                                                                         image = document.createElement('img');
                                                                                    
                                                                                        image.src = reader.result;
                                                                                        image.width='310';
                                                                                        image.height='230';
                                                                                        image.style='padding:5px;';
                                                                                        preview.innerHTML = '';
                                                                                        preview.append(image);
                                                                                  };
                                                            }
                            );  
            
            
            
            
             asignarEvento(gE('imagenPrincipal'),'change',function(evt)
                                                            {
                                                                var ctrl = evt.target || window.event.srcElement;
                                                                let reader = new FileReader();
                                                        
                                                                reader.readAsDataURL(ctrl.files[0]);
                                                                
                                                                reader.onload = function()
                                                                                  {
                                                                                        let preview = document.getElementById('divImgPrincipal'),
                                                                                        image = document.createElement('img');
                                                                                    
                                                                                        image.src = reader.result;
                                                                                        image.width='750';
                                                                                        image.height='300';
                                                                                        image.style='padding:5px;';
                                                                                        preview.innerHTML = '';
                                                                                        preview.append(image);
                                                                                  };
                                                            }
                            );  
    
    
    	}
        else
        {
        	let preview = document.getElementById('divImgResumen'),
            image = document.createElement('img');
        	image.src = '../paginasFunciones/obtenerDocumentoEditorArchivos.php?id='+bE('documento_'+gE('_imagenResumenfil').value);
            image.width='310';
            image.height='230';
            image.style='padding:5px;';
            preview.innerHTML = '';
            preview.append(image);
            
            
            preview = document.getElementById('divImgPrincipal'),
            image = document.createElement('img');
        
            image.src = '../paginasFunciones/obtenerDocumentoEditorArchivos.php?id='+bE('documento_'+gE('_imagenPrincipalfil').value);
            image.width='750';
            image.height='300';
            image.style='padding:5px;';
            preview.innerHTML = '';
            preview.append(image);
        }
    	
    
    
    	
    }
    else
    {
    	let preview = document.getElementById('divImgResumen'),
        image = document.createElement('img');
        image.src = '../paginasFunciones/obtenerDocumentoEditorArchivos.php?id='+bE('documento_<?php echo $fRegistro["imagenResumen"]?>');
        image.width='310';
        image.height='230';
        image.style='padding:5px;';
        preview.innerHTML = '';
        preview.append(image);
        
        
        preview = document.getElementById('divImgPrincipal'),
        image = document.createElement('img');
    
        image.src = '../paginasFunciones/obtenerDocumentoEditorArchivos.php?id='+bE('documento_<?php echo $fRegistro["imagenPrincipal"]?>');
        image.width='750';
        image.height='300';
        image.style='padding:5px;';
        preview.innerHTML = '';
        preview.append(image);
    }
    
}


function funcion_contenidoPublicacionvch_ready(evt)
{
	if(esRegistroFormulario())
    {
    	if(gE('idRegistroG').value=='-1')
      	{
    		evt.editor.setData('<div class="cwjdsjcs_not_editable"><p class="letraContenidoPublicacion">[Ingrese Contenido]</p></div>');
		}
    }
}