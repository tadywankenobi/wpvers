<?php 
// Get current version of WordPress from WordPress API

	$APIurl = 'http://api.wordpress.org/core/version-check/1.7/';
	$APIjson = file_get_contents($APIurl);
	$wpAPI = json_decode($APIjson);

	$currVer = $wpAPI->offers[0]->current;

	//Test upcoming version labels
	//$currVer = "3.8";

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta description="untitled" />
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Microsoft. Delete if not applicable -->
	<meta http-equiv="cleartype" content="on">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<title>Wordpress Directories &amp; Versions</title>

	<style>
	/* I hate putting styles here, but it's handy for single file use */
	html {font-size:62.5%;font-family:sans-serif;color:#444;}
	.container {margin:0 auto;width:960px;}
	table {width:100%;border-collapse: collapse;border:solid 1px #888;}
	th, td {border-collapse: collapse;border:solid 1px #888;padding:5px;font-size:1.2em;}
	th {background:#888;color:#fff;}
	th:first-child {text-align:left;}
	td:last-child {text-align:center;}
	tr:nth-child(even) {background:#eef;}
	.green, .amber, .red {font-weight:bold;}
	.green {background:#cfc;}
	.current {color:#080;}
	.amber {background:#EDB721;}
	.red {background:#f00;color:#fff;}
	</style>
	
</head>

<body>
	
	<header>
		<div class="container">
			<h1>Wordpress Installs &amp; Versions (Current Version <?php echo $currVer; ?>)</h1>
		</div>
	</header>

	<div class="container">

		<table>
			<thead>
				<th>Directory</th>
				<th>Version</th>
			</thead>
			<tbody>
	<?php

	// Path to search. The * is a wildcard. Make sure to double slash Windows paths. i.e. all wordpress installs in the D:\wwwroot folder:
	// D:\wwwroot\*\wp-includes\version.php
	// provided as:
	// D:\\wwwroot\\*\\wp-includes\\version.php

	// $list = glob("D:\\wwwroot\\*\\wp-includes\\version.php"); // Windows
	$list = glob('/Users/Path/to/sites/*/wp-includes/version.php'); //UNIX

	$dirs = array();

	foreach($list as $item){
		if(file_exists($item)) {
			include $item;

			/* 	Talked about using version_compare, but not sure it will give me the 
				flexibility I want in the "if" sections below
			*/

			// Change the site version number and current version into a usable number: 3.7.1 -> 3.71
			$verChk = explode('.',$wp_version);
			$ver = (int) $verChk[0].'.'.(int) $verChk[1].(int) $verChk[2];

			$currChk = explode('.',$currVer);
			$cverInt = (int) $currChk[0].'.'.(int) $currChk[1].(int) $currChk[2];
			
			//Check for actual current version or if it's this gen (e.g. 3.7.1 or all the 3.7 family)
			if($ver == $cverInt){
				$class = "green";
			}
			if($wp_version === $currVer){
				$class .= " current";
			}

			// Set amber alert to anything lower than current version
			if($ver < $cverInt){
				$class="amber";
			}

			// Set red alert to anything two versions older than current version
			if($ver < ($cverInt-0.15)){
				$class="red";
			}

			//$site = substr($item,11,-24);
			$site = substr($item,0,-24);

			echo '<tr><td>'.$site.'</td><td class="'.$class.'"">'.$wp_version.'</td></tr>'."\r\n";

		}	
	}

	?>

			</tbody>
		</table>

	</div>

	<footer>
		<div class="container"></div>
	</footer>

</body>

</script>