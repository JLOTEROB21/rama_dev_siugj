<?php
require_once '../stimulsoft/helper.php';
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
	<title>Stimulsoft Reports.PHP - Viewer</title>
	<style>html, body { font-family: sans-serif; }</style>

	<!-- Office2013 White-Teal style -->
	<link href="../css/stimulsoft.viewer.office2013.whiteblue.css" rel="stylesheet">

	<!-- Stimulsoft Reports.JS -->
	<script src="../scripts/stimulsoft.reports.src.js" type="text/javascript"></script>
	
	<!-- Stimulsoft Dashboards.JS -->
	<!-- <script src="../scripts/stimulsoft.dashboards.js" type="text/javascript"></script>  -->
	
	<!-- Stimulsoft JS Viewer -->
	<script src="../scripts/stimulsoft.viewer.src.js" type="text/javascript"></script>
	
	<?php
		// Add JavaScript helpers and init options to work with the PHP server
		// You can change the handler file and timeout if required
		StiHelper::init('handlerlatis.php', 30);
	?>
	

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
Stimulsoft.Base.StiLicense.key = "6vJhGtLLLz2GNviWmUTrhSqnOItdDwjBylQzQcAOiHmgkBxjU0/UmAjZbab0bLsWj2KKQ1f2h2zVQgROa923/J9aga" + 
"lcVnGg+nc1D5EeJo2HbKA2gEtCNP1pehPSy8G2ctYYmeZGyYMb+h5TJxkcjMmZxSMvsnptsiE5D9l1poNO8vJpc58v" + 
"Pf9NBDcAxhmdWUAgFU3vGPYO/WhpOzoBpdplAgurmxCeB5gXDlFZla/9iPOlHgfLKNzGZ+aVv1OkSeuzGqPjNVUvBL" + 
"oSuCqhEnKqWr7MHmtHoVAqjda2vsrUEnCpKidQPanTeWodnY96ask+VehI4xI/GPFvD5UeaCdm2sW550Ex9x2NumT/" + 
"ZGY7Dsdg4XuapPzxJ9vrAqdmib5S9FmeW+DZnHwkhKi/3SccdPhbhOWw/CntjnlDWzGz9jqiy7rxe6kLhxgrQP37rm" + 
"yLWmMRoYTRk/j6Nh0j1jtvf4VSQTo97uB3l7GUk2IjDpWOtkQD4jQh6m7bccdK8+kYCIIRZ2Wi1Hr2Jfqohy1D/WBh" + 
"xWOtFroLhG+SJ100PwjepP7KtKmB+J+KPoVz";

var options = new Stimulsoft.Viewer.StiViewerOptions();
		options.toolbar.showSendEmailButton = true;
		options.toolbar.displayMode = Stimulsoft.Viewer.StiToolbarDisplayMode.Separated;
		options.appearance.fullScreenMode = true;
		options.appearance.scrollbarsMode = true;		
		options.height = "600px"; // Height for non-fullscreen mode

		
	StiOptions.WebServer.encryptData = false;
    Stimulsoft.Base.Localization.StiLocalization.setLocalizationFile("../localization/es.xml");
    function findGetParameter(parameterName) {
        var result = null,
            tmp = [];
        location.search
            .substr(1)
            .split("&")
            .forEach(function (item) {
            tmp = item.split("=");
            if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
            });
        return result;
    }


var report = new Stimulsoft.Report.StiReport();

report.loadFile("../reports/"+findGetParameter("nomreporte"))
console.log(report);
console.log(report.savePackedToString());
console.log(report.saveToJsonString());
		var newwindow= window.open('', 'TheWindowCode', 'width=700, height=1200');
		
		content = '<html><TITLE>Codigo fuente del reporte</TITLE><body><pre><code>' + report.savePackedToString() + ''
       newwindow.document.write(content);
    

    function onLoad() {		
			
		}



</script>
</head>
<body>
	<div id="viewerContent"></div>
</body>
</html>