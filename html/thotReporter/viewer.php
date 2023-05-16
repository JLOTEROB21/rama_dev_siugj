
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Stimulsoft Reports.JS Viewer</title>

	<!-- Office2013 style -->
	<link href="css/stimulsoft.viewer.office2013.whiteblue.css" rel="stylesheet">

	<!-- Stimulsoft Reports.JS -->
	<script src="scripts/stimulsoft.reports.src.js" type="text/javascript"></script>

	<!-- Stimulsoft JS Viewer -->
	<script src="scripts/stimulsoft.viewer.src.js" type="text/javascript"></script>

	<script type="text/javascript">
		Stimulsoft.StiOptions.WebServer.url = "stimulsoft/adapters/handler.php";
		Stimulsoft.Base.StiLicense.Key = "6vJhGtLLLz2GNviWmUTrhSqnOItdDwjBylQzQcAOiHl7YlQBeEnYDc5zgyMRBT2NfOYid4K+cpwCXvSq5vXaVXK2ra5wkZEwq97DlScdEqe2t00bpvTedPJcDg8Yq6HWUDWTetSmZZWH81Xel+kbCIBzNuQlugivW+UI+Jhr0Upywvhk2A8YT5s8+tWCF5rmJwrrKMGmB1f1jiGH8AmhJaBnEtFwALyejjzMChWxRl2xE6jX1p8DsMHoIZ9xdbL+lk1T8nvHsorTBwk3zKprBiqYcVDbuBSaqpNThyEZyiVS0sAxNzSfC3cgEQsxB504+nGx0OM9DDMCbtad8rFL2iftbyuyp/k98KF5B+PUvHLCZwi6gVmTLy+qvNEH4yDnC3/Udc6QdYJZKGSlF685vdvvnB9tNeg5em/agGN4M9HDXRsdpQ79qQaX2a4CbJ2XLMdkYnNtWMDJGUs/gqfkfLowmE7cIN5JYvwT2DGZZSuUhZNa8mYYEROyKfQiXVK7M8npr//dkVkuPwEGvY1+0ZcvKcgaBC2B9VqFce9m1bbYYojRoYsabw9gjg7wVjTP";
		var options = new Stimulsoft.Viewer.StiViewerOptions();
		options.toolbar.showAboutButton =false;
		options.appearance.fullScreenMode = true;
		options.toolbar.showButtonCaptions = true;
        options.appearance.showTooltipsHelp = false;
		Stimulsoft.Base.Localization.StiLocalization.addLocalizationFile("localization/es.xml",false,"es");
		Stimulsoft.Base.Localization.StiLocalization.cultureName="es";
		options.toolbar.showSendEmailButton = true;

		var viewer = new Stimulsoft.Viewer.StiViewer(options, "StiViewer", false);

		// Load and show report
		var report = new Stimulsoft.Report.StiReport();
		report.loadFile("reports/NuevoReporte.mrt");
		viewer.report = report;

		function onLoad() {
			viewer.renderHtml("viewerContent");
		}
	</script>
	</head>
<body onload="onLoad();">
	<div id="viewerContent"></div>
</body>
</html>
