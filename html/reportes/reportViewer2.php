<?php
require_once '../thotReporter/stimulsoft/helper.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>


	<link href="../thotReporter/css/stimulsoft.viewer.office2013.whiteblue.css" rel="stylesheet">
	<script src="../thotReporter/Scripts/stimulsoft.reports.src.js" type="text/javascript"></script>
	<script src="../thotReporter/Scripts/stimulsoft.viewer.src.js" type="text/javascript"></script>
    <?php
		
		StiHelper::init('../thotReporter/stimulsoft/adapters/handler.php', 30);
		
		$idReporte=-1;
		if(isset($_POST["iR"]))
		{
			$idReporte=$_POST["iR"];
		}
		
		$dispararEventos=1;
		if(isset($_POST["dispararEventos"]))
		{
			$dispararEventos=$_POST["dispararEventos"];
		}
		
		
		
		$DB_Host_ENV=getenv("DB_Host");
		$DB_User_ENV=getenv("DB_User");
		$DB_Passwd_ENV=getenv("DB_Passwd");
		$DB_DATABASE_ENV=getenv("DB_DATABASE");
		if($DB_Host_ENV=="")
		{
			$DB_Host_ENV="majo.c626bqrgu9tk.us-east-1.rds.amazonaws.com:3306";
			$DB_User_ENV="wytmlvuhbiob";
			$DB_Passwd_ENV="l1nkt1c2021";
			$DB_DATABASE_ENV="SIUGJ_DBRelease3_1";
			
		}

		
	?>
    
    <script type="text/javascript">

	Stimulsoft.Base.StiLicense.key =	"6vJhGtLLLz2GNviWmUTrhSqnOItdDwjBylQzQcAOiHmgkBxjU0/UmAjZbab0bLsWj2KKQ1f2h2zVQgROa923/J9aga" + 
										"lcVnGg+nc1D5EeJo2HbKA2gEtCNP1pehPSy8G2ctYYmeZGyYMb+h5TJxkcjMmZxSMvsnptsiE5D9l1poNO8vJpc58v" + 
										"Pf9NBDcAxhmdWUAgFU3vGPYO/WhpOzoBpdplAgurmxCeB5gXDlFZla/9iPOlHgfLKNzGZ+aVv1OkSeuzGqPjNVUvBL" + 
										"oSuCqhEnKqWr7MHmtHoVAqjda2vsrUEnCpKidQPanTeWodnY96ask+VehI4xI/GPFvD5UeaCdm2sW550Ex9x2NumT/" + 
										"ZGY7Dsdg4XuapPzxJ9vrAqdmib5S9FmeW+DZnHwkhKi/3SccdPhbhOWw/CntjnlDWzGz9jqiy7rxe6kLhxgrQP37rm" + 
										"yLWmMRoYTRk/j6Nh0j1jtvf4VSQTo97uB3l7GUk2IjDpWOtkQD4jQh6m7bccdK8+kYCIIRZ2Wi1Hr2Jfqohy1D/WBh" + 
										"xWOtFroLhG+SJ100PwjepP7KtKmB+J+KPoVz";
	
    Stimulsoft.Base.Localization.StiLocalization.setLocalizationFile("es.xml");
	
	var report = new Stimulsoft.Report.StiReport();

	report.loadFile("../reportes/formulario2021_<?php echo $idReporte ?>.mrt");
	<?php
	if($DB_Host_ENV!="")
	{
	?>
	if(report.dictionary.databases.getByName("Conexión"))
	{
		
		report.dictionary.databases.getByName("Conexión").connectionString="Server=<?php echo $DB_Host_ENV?>; Database=<?php echo $DB_DATABASE_ENV?>;UserId=<?php echo $DB_User_ENV?>; Pwd=<?php echo $DB_Passwd_ENV?>;";
	}
	if(report.dictionary.databases.getByName("Conexión_SIUGJ"))
	{
		
		report.dictionary.databases.getByName("Conexión_SIUGJ").connectionString="Server=<?php echo $DB_Host_ENV?>; Database=<?php echo $DB_DATABASE_ENV?>;UserId=<?php echo $DB_User_ENV?>; Pwd=<?php echo $DB_Passwd_ENV?>;";
	}
<?php
	}
	?>
	var options = new Stimulsoft.Viewer.StiViewerOptions();
	options.appearance.htmlRenderMode = Stimulsoft.Report.Export.StiHtmlExportMode.Div;	
	options.appearance.scrollbarsMode = true;
	options.appearance.showTooltips = false;
	options.toolbar.showPrintButton = true;
	options.toolbar.showDesignButton = false;
	options.toolbar.showAboutButton = false;
	options.exports.showExportToPdf = true;
	options.exports.ShowExportToWord2007 = true;
	options.appearance.fullScreenMode = true;
	options.toolbar.showOpenButton=false;
	options.toolbar.showOpenButton=true;
	
	var viewer = new Stimulsoft.Viewer.StiViewer(options);
	
	viewer.onEndProcessData=function(event)
							{
								<?php
								if($dispararEventos==1)
								{
									echo "window.parent.analisisAlertaReporte(event.result.columns,event.result.rows);";
								}
								?>
								

							}
		
	var userButton = viewer.jsObject.SmallButton("userButton", "Compartir...", "emptyImage");
	userButton.image.src = "../images/user_go.png";
	userButton.action = function () { window.parent.compartirReporte(); }
	var toolbarTable = viewer.jsObject.controls.toolbar.firstChild.firstChild;
	var buttonsTable = toolbarTable.rows[0].firstChild.firstChild;
	var userButtonCell = buttonsTable.rows[0].insertCell(0);
	userButtonCell.className = "stiJsViewerClearAllStyles";
	userButtonCell.appendChild(userButton);
	
	
	viewer.report = report;	
										
		
									
	</script>
   	

</head>

<body>
</body>
</html>