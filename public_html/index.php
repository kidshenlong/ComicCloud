<?php
require('include.php');

$script = '
<script src="js/jquery.masonry.min.js"></script>
<script type="text/javascript">
	$(window).load(function(){
		var columns = 4,
        setColumns = function() { columns = $( window ).width() > 1200 ? 4 : $( window ).width() > 800 ? 3 : 2; };
 
		setColumns();
		$( window ).resize( setColumns );

		$("#content").masonry({
			itemSelector: ".block",
			// set columnWidth a fraction of the container width
			columnWidth:  function( containerWidth ) { return containerWidth / columns; }
		});
	});

</script>
';

echo createHeader('Home');

echo createMenu();

//$query = "SELECT id, series, issue FROM comics";

/*foreach($db->query('SELECT * FROM comicSeries') as $row) {
    //echo $row['series'].' '.$row['issue']; //etc...
    echo "<img src='".$row['seriesCover']."'/>";
}*/
echo "<div id='ajaxLoader'></div>";
echo "<div id='ajaxLoader2'></div>";
echo "<div id='content'></div>";
		