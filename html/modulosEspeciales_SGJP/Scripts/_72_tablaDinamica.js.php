<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
?>



var idEvento=-1;


function inyeccionCodigo()
{
	idEvento=gEN('_idEventovch')[0].value;
    var _idFiguraJuridicavch=gEN('_idFiguraJuridicavch')[0].value;
    
    if(_idFiguraJuridicavch=='0')
    {
    	mE('sp_2263');
        oE('sp_1801');
        oE('div_1315');
    }
    else
    {
    	mE('sp_1801');
    	oE('sp_2263');
    }
    gE('sp_1803').innerHTML='';
    if((idEvento!='-1')&&(idEvento!=''))
    {
        loadScript('../modulosEspeciales_SGJP/Scripts/controlEventos.js.php', function()
                                                                                {
                                                                                    var objConf={};
                                                                                    objConf.idEvento=idEvento;
                                                                                    objConf.renderTo='sp_1803';
                                                                                    objConf.permiteModificarEdificio=false;  
                                                                                    objConf.permiteModificarUnidadGestion=false;  
                                                                                    objConf.permiteModificarSala=false;  
                                                                                    objConf.permiteModificarFecha=false;    
                                                                                    objConf.permiteModificarJuez=false;                                                                               
                                                                                    objConf.mostrarFechaAudiencia=true;
                                                                                    objConf.mostrarTipoAudiencia=true;
                                                                                    objConf.mostrarDuracionAudiencia=true;
                                                                                    objConf.mostrarSalaAudiencia=true;
                                                                                    objConf.mostrarCentroGestion=true;
                                                                                    objConf.mostrarEdificio=true;
                                                                                    objConf.mostrarJueces=false;
                                                                                    objConf.mostrarDesarrollo=false;
                                                                                    objConf.mostrarDuracionDesarrollo=false;
                                                                                    objConf.mostrarHorarioDesarrollo=false;
                                                                                    objConf.mostrarDocumentoMultimedia=false;
                                                                                    construirTableroEvento(objConf);
                                                                                }
                    );
        
	
	}  
    
    crearArbolSujetosProcesales();  
}


function crearArbolSujetosProcesales()
{
	var raiz=new  Ext.tree.AsyncTreeNode(
											{
												id:'-1',
												text:'Raiz',
												draggable:false,
												expanded :false,
												cls:'-1'
											}
										)
                                        
										
	var cargadorArbol=new Ext.tree.TreeLoader(
                                                {
                                                    baseParams:{
                                                                    funcion:'17',
                                                                    iE:bE(-1),
                                                                    sV:bE(1),
                                                                    cA:bE(gEN('_carpetaAdministrativavch')[0].value)
                                                                },
                                                    dataUrl:'../paginasFunciones/funcionesModulosEspeciales_SGP.php'
                                                }
                                            )		
										
											
	cargadorArbol.on('load',function(c)
    						{
                            	//gEx('btnAcuerdosReparatorios').hide();
                            }
    				)										
                    
	gE('sp_5265').innerHTML='';                    
                    
	var arbolSujetosJuridicos=new Ext.tree.TreePanel	(
                                                            {
                                                                id:'arbolSujetos',
                                                                useArrows:true,
                                                                animate:true,
                                                                enableDD:false,
                                                                ddScroll:true,
                                                                width:250,
                                                                border:true,
                                                                height:300,      
                                                                containerScroll: true,
                                                                autoScroll:true,                                                                
                                                                root:raiz,
                                                                renderTo:'sp_5265',
                                                                loader: cargadorArbol,
                                                                rootVisible:false
                                                                
                                                            }
                                                        )
         
         
                                                    
	arbolSujetosJuridicos.on('dblclick',funcClickSujeto);	                                                    
	
   
	//return  arbolSujetosJuridicos;
}



function funcClickSujeto(nodo, evento)
{
	if(nodo.attributes.tipo!='0')
    {
    	var arrId=nodo.id.split('_');
        
        var obj={};
        var params=[['idRegistro',arrId[1]],['idFormulario',47],['dComp',bE('auto')],['actor',bE('0')]];
        obj.ancho='90%';
        obj.alto='95%';
        obj.url='../modeloPerfiles/vistaDTDv3.php';
        obj.params=params;
        obj.modal=true;
        abrirVentanaFancy(obj);
        
        /*function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                mostrarVentanaRegistroCedulaIdentificacion(arrResp[1],-1,gE('idEventoAudiencia').value,arrId[1],arrResp[2],arrResp[3]);
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=87&iU='+arrId[1]+'&iE='+gE('idEventoAudiencia').value,true);*/
        
        
        
        
        
    }
}