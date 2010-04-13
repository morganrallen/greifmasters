<?xml version="1.0"?>
<xsl:stylesheet 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	version="1.0"
>
	<xsl:output doctype-public="html" />

	<xsl:template match="/">
		<html>
			<head>
				<title>Greifmasters Tournament Management<xsl:value-of select="/page/data" /></title>

				<link rel="stylesheet" type="text/css" href="/greifmasters/css/main.css" />
				<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

				<script src="/greifmasters/javascripts/prototype.js" type="text/javascript"></script>
				<script src="/greifmasters/javascripts/jquery-1.4.1.min.js" type="text/javascript"></script>
				<script src="/greifmasters/javascripts/scriptaculous.js" type="text/javascript"></script>
				<script src="/greifmasters/javascripts/display.js" type="text/javascript"></script>
				<script src="/greifmasters/javascripts/time.js" type="text/javascript"></script>
				<script>jQuery.noConflict();</script>
				<?php if (isset($header)){echo $header;}?>
			</head>

			<body>
				<audio id="horn" src="/greifmasters/horn.wav" autobuffer="true">No audio</audio>
				<div id="pageframe">
					<div id="nav">
						<div class="navBox">
							<div class="navHeading">Tournaments</div>
							<div class="margin_left">
								<a href="/greifmasters/admin/list_tournaments/ong">ongoing</a><br />
								<a href="/greifmasters/admin/list_tournaments/upc">upcoming</a><br />
								<a href="/greifmasters/admin/list_tournaments">all</a><br />
							</div>
						</div>

						<div class="navBox">
							<div class="navHeading">Teams</div>
							<a href="teams/create">Create new team</a><br />
							<a href="teams">Show teams</a>
						</div>
						
						<div class="navBox">
							<div class="navHeading">Courts</div>
							<a href="/greifmasters/admin/courts/create">Create new court</a><br />
							<a href="/greifmasters/admin/courts">Show courts</a>
						</div>
						
						<div class="navBox">
							<div class="navHeading">Settings</div>
							<a href="/greifmasters/admin/test_code">test_code.php</a><br />
							<a href="/greifmasters/admin/setup">Setup</a>
						</div>

						<div class="navBox">
							<div class="navHeading">Controls</div>
							<a href="/greifmasters/session_destroy.php">destroy session</a><br />
							<a href="/greifmasters/admin/settings">Settings</a><br />
							<a href="/greifmasters/admin/setup">Setup</a><br />
							<a href="/greifmasters/admin/logout">Logout</a>
						</div>
					</div> <!-- #navBoxesContainer -->
					<div id="content">
						<xsl:copy-of select="/page/ob-content" />
					</div>
					<div id="footer">Greifmasters Tournament Software 0.1</div>
				</div> <!-- #pageframe -->
			</body>
		</html>
	</xsl:template>	
</xsl:stylesheet>
