<!DOCTYPE html>
<html>
<head>
	<title>Gallery generator</title>
	<meta charset="UTF-8" />
	<meta lang="en" />
	<style>
		body {
			font-family: sans-serif;
		}
		label {
			font-weight: bold;
		}
	</style>
</head>
<body>
	<?php if (!isset($_POST['action'])) { ?>
	<h1>Generate a MediaWiki gallery from a Wikimedia Commons category</h1>

	<form action="index.php" method="post">
		<label for="catname">Category name without category:</label>
		<input  id="catname" type="text" name = "catname">
		<br />
			
		<label for="mode">Mode</label>
		<select id="mode" name="mode">
			<option value="traditional">Traditional</option>
			<option value="nolines">No lines</option>
			<option value="packed">Packed</option>
			<option value="packed-overlay">Packed overlay</option>
			<option value="packed-hover">Packed Over</option>
			<option value="slideshow">slideshow</option>
		</select>

		<h3>Options</h3>
		
		<label for="caption">Caption</label>
		<input id="caption" type="text" name="caption" />
		<br />
		<label for="widths">Widths</label>
		<input id="widths" type="text" name="widths" />
		<br />
		<label for="heights">Heights</label>
		<input id="heights" type="text" name="heights" />
		<br/>
		<label for="perrow">Images per row</label>
		<input id="perrow" type="text" name="perrow" />
		
		<br/>
		<label for="showfilename">Show file names as captions?</label>
		<input id="showfilename" type="checkbox" name="showfilename" />
		
		<br/>
		<label for="showthumbnails">Show thumbnails for slideshow mode?</label>
		<input id="showthumbnails" type="checkbox" name="showthumbnails" />

		<br />
		<input type="submit" id="submit" />
		<input type="hidden" name="action" value="gallery">
	</form>
	<?php } ?>



<div id="gallery">
<pre>
<?php
		require 'boz-mw/autoload.php';
		echo("\n");
		if ($_POST['action'] == "gallery") {
			$wiki = \wm\Commons::instance();
			$queries =
				$wiki->createQuery( [
					'action'  => 'query',
					'list'    => 'categorymembers',
					'cmtitle' => 'Category:' . $_POST['catname'],
				] );
				
				$options = [];
				
				array_push($options, 'mode=' . $_POST['mode']);

				if ($_POST['caption'] != "") {
					array_push($options, 'caption="' . $_POST['caption'] . '"'); 
				}
				
				if ($_POST['widths'] != "") {
					array_push($options, 'widths=' . $_POST['widths'] . 'px');
				}				
				
				if ($_POST['heights'] != "") {
					array_push($options, 'heights=' . $_POST['heights'] . 'px');
				}				
				
				if ($_POST['perrow'] != "") {
					array_push($options, 'perrow=' . $_POST['perrow']);
				}				
				
				if (isset($_POST['showfilename'])) {
					array_push($options, 'showfilename=yes');
				}				
				
				if (isset($_POST['showthumbnails'])) {
					array_push($options, 'showthumbnails');
				}				

				echo('&lt;gallery ' . implode(' ', $options) . "> \n");

				foreach( $queries as $query ) {
								
					

	if (sizeof($query->query->categorymembers) > 0) {
							
							$files = $query->query->categorymembers;
					
						
										
						foreach ($files as $file) {
							if($file->ns == 6) {
							echo($file->title . "\n");
							}
						}
						
					} else {
						echo('<b>WARNING!</b> The category you want to generate a gallery from is empty.');
					}
			}
			echo('&lt;gallery/>');

		}

		?>
	</pre>
	</div>
	<?php 
	if(!isset($_POST['action'])) {
		?>
		<pre>Created by <a href="https://meta.wikimedia.org/wiki/User:Ferdi2005">Ferdinando Traversa</a> - Contact him at wiki@traversa.me - Source: <a href="https://github.com/ferdi2005/gallery">on Github</a> - v 1.0</pre>
		<?php
	}	
	?>
</body>
</html>