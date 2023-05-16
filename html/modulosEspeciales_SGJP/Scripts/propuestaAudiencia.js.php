<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	
	$consulta="SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE idFormulario=".$idFormulario." AND idRegistroSolicitud=".$idRegistro." AND idReferencia=-1 ORDER BY idRegistroEvento";
	$idEvento=$con->obtenerValor($consulta);
	if($idEvento=="")
		$idEvento=-1;
	
?>
var idEvento=<?php echo $idEvento?>;

Ext.onReady(inicializar);


function inicializar()
{
	
    loadScript('../modulosEspeciales_SGJP/Scripts/controlEventos.js.php', function()
    																		{
                                                                            	var objConf={};
                                                                                objConf.idEvento=idEvento;
                                                                                objConf.mostrarInfoSituacion=true;
                                                                                objConf.mostrarIDEvento=true;
                                                                                objConf.renderTo='tblFechaAudiencia';
                                                                                objConf.permiteModificarEdificio=false;  
                                                                                objConf.permiteModificarUnidadGestion=false;  
                                                                                objConf.permiteModificarSala=(gE('sL').value=='0');  
                                                                                objConf.permiteModificarFecha=(gE('sL').value=='0');    
                                                                                objConf.mostrarEspecificacionesEspeciales=true;
                                                                                objConf.mostrarAsignacionAuxiliar=true;
                                                                                <?php
																					if(($_SESSION["idUsr"]==1)||(existeRol("'81_0'"))||(existeRol("'112_0'"))||(existeRol("'69_0'")))
																					{
																						echo "objConf.permiteModificarJuez=true;";
																						echo "objConf.permiteModificarSala=true;";
																						echo "objConf.permiteModificarFecha=true;";
																						echo "objConf.permiteModificarTipoAudiencia=true;";
																						if(((existeRol("'69_0'") ||existeRol("'81_0'")))&&($_SESSION["idUsr"]!=1))
																							echo "objConf.permiteModificarJuez=false;";
																					}
																					else
																					{
																						echo "objConf.permiteModificarJuez=false;";
																					}
																				?>
                                                                                
                                                                                objConf.mostrarFechaAudiencia=true;
                                                                                objConf.mostrarTipoAudiencia=true;
                                                                                objConf.mostrarDuracionAudiencia=true;
                                                                                objConf.mostrarSalaAudiencia=true;
                                                                                objConf.mostrarCentroGestion=true;
                                                                                objConf.mostrarEdificio=true;
                                                                                objConf.mostrarJueces=true;
                                                                                objConf.mostrarDesarrollo=false;
                                                                                objConf.mostrarDuracionDesarrollo=false;
                                                                                objConf.mostrarHorarioDesarrollo=false;
                                                                                objConf.mostrarDocumentoMultimedia=false;
                                                                                
                                                                            	construirTableroEvento(objConf);
                                                                            }
    			);
    
	
}

