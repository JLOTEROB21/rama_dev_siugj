<?php
include("conexionBD.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../css/hayas.css.php" media="screen" />
<link rel="stylesheet" type="text/css" href="../estilos/estilos.css" media="screen" />
<!--[if IE 8]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE8.css" media="screen" /><![endif]-->
<!--[if IE 7]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE7.css" media="screen" /><![endif]-->
<!--[if IE 6]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE6.css" media="screen" /><![endif]-->
<!--[if IE]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE8.css" media="screen" /><![endif]-->

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SIGUE</title>
</head>

<body>
	<table width="100%">
    <tr>
    	<td align="center">
            <table width="100%" >
                <tr>
                    <td align="left"  style="padding-left:60px; padding-top:20px">
                        <img src="../principalPortal/imagesInstitucionales/header.png" width="100%" >
                    </td>  
                </tr>
                <tr>
                    <td align="center"><br />
                        <table width="800">
                            <tr>
                                <td>
                    <?php
        
                    $cta=bD(obtenerValorParametro("cta",bE("idUsuario:-1")));
                    
                    $arrCta=explode(':',$cta);
                    $idUsuario=$arrCta[1]; 
                    $consulta="select cuentaActiva from 800_usuarios where idUsuario=".$idUsuario;
        
                    $estado=$con->obtenerValor($consulta);
                    $redireccion=$paginaCierreLogin;
        
                    
                    if($estado=="")
                    {
                ?>
                    <fieldset class="frameHijo"><legend><b>La cuenta no existe</b></legend>
                        <table width="100%">
                            <tr>
                                <td width="145">
                                    <img src="../images/prohibido.png" />
                                </td>
                                <td><span class="letraRoja"><font style="font-size:13px">La cuenta que esta intentando activar no se encuentra registrada en el sistema</font></span><span class="corpo8"><br />
                                <br />
                                </span>
                                    <span class="letraFicha"><font style="font-size:12px"><b>
                                    En breve será redireccionado a la pagina principal</b>
                                    </font>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                    
                <?php
                        
                    }
                    else
                        if($estado=="-1")
                        {
                ?>
                        <fieldset class="frameHijo"><legend><b>Cuenta activa</b></legend>
                            <table width="100%">
                                <tr>
                                    <td width="145">
                                        <img src="../images/info.png" />
                                    </td>
                                    <td><span class="letraRoja"><font style="font-size:13px">La cuenta ya ha sido activada anteriormente</font></span><span class="corpo8"><br />
                                    <br />
                                    </span>
                                        <span class="letraFicha"><font style="font-size:12px"><b>
                                        En breve será redireccionado a la pagina de autentificación para que inicie una sesión en el sistema</b>
                                        </font>
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                        
                <?php
                        }
                        
                        else
                        {
                                $x=0;
                                $query[$x]="begin";
                                $x++;
                                $query[$x]="update 800_usuarios set cuentaActiva=1 where idUsuario=".$idUsuario;
                                $x++;
                                $query[$x]="commit";
                                if($con->ejecutarBloque($query))
                                {
                ?>
                            <fieldset class="frameHijo"><legend><b>Activación exitosa</b></legend>
                            <table width="100%">
                                <tr>
                                    <td width="145">
                                        <img src="../images/accept.png" />
                                    </td>
                                    <td><span class="letraRoja"><font style="font-size:13px">Su cuenta ha sido activada con éxito</font></span><span class="corpo8"><br />
                                    <br />
                                    </span>
                                        <span class="letraFicha"><font style="font-size:12px"><b>
                                        En breve será redireccionado a la pagina de autentificación para que inicie una sesión en el sistema</b>
                                        </font>
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                        
                <?php
                                    
                                }
                        }
                ?>
                                <META HTTP-EQUIV="Refresh" CONTENT="5; URL=<?php echo $redireccion?>">
                                </td>
                            </tr>
                        </table>
                    
                    </td>
                </tr>
            </table>                
		</td>
    </tr>
   </table>
</body>
</html>