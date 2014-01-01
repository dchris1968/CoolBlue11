<?php
//These lines get the database ready and puts it in the $con string
$con = mysqli_connect("127.0.0.1", "root","","cars");
$sql = "SELECT count(id) FROM car";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_row($query);

//Here we have the total row count
$rows = $row[0];

//This is the number of results we want displayed per page
$page_rows = 5;

//This tells us the page number of our last page
$last = ceil($rows/$page_rows);

//This makes sure last cannot be less than 1
if($last < 1)
{
	$last = 1;
}
//Establish the $pagenum variable
$pagenum =1;

if(isset($_GET['pn']))
{
	$pagenum = $_GET['pn'];
}
//This makes sure the page number isn't below 1, or more than our $last page
if($pagenum < 1) 
{
	$pagenum = 1;
}
else if ($pagenum > $last) 
{
	$pagenum = $last;
}
//This sets the range of rows to query for the chosen $pagenum
$limit = 'LIMIT '.($pagenum -1) * $page_rows.','.$page_rows;

//This is the query getting just one page worth of rows by applying $limit
$sql = "SELECT * FROM car $limit;";
$query = mysqli_query($con, $sql);

//Establish the $paginationCtrls variable
$paginationCtrls = '';

//If there is more than 1 page worth of results
if($last != 1)
{
	/* First we check if we are on page one.  If we are then we don't need a link to
	   the previous page or the first page so we do nothing.  If we aren't then we 
	   generate links to the first page, and to the previous page. */
	if ($pagenum > 1) {
		$previous = $pagenum - 1;
		$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'">Previous</a> &nbsp; &nbsp;';
		
		//Render clickable number links that should appear on the left of the target page number
		for($i = $pagenum-4; $i < $pagenum; $i++){
			if($i > 0){
				$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp;';
			}
		}
	}
	//Render the target page number, but without it being a link
	$paginationCtrls .= ''.$pagenum.' &nbsp; ';
	
	//Render clickable number links that should appear on the right of the target page number
	for($i = $pagenum+1; $i <= $last; $i++)
	{
		$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp;';
		if($i >= $pagenum+4){
			break;
		}
	}
	
	//This does the same as above, only checking if we are on the last page, and then generating the "Next"
	if($pagenum != $last){
		$next = $pagenum + 1;
		$paginationCtrls .= ' &nbsp; &nbsp; <a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'">Next</a>';
	}
}
	$list = '';
	echo "<table border='1'>
	<tr>
	<th>ID</th>
	<th>Make</th>
	<th>Model</th>
	<th>Year</th>
	<th>Color</th>
	</tr>";
	while($row = mysqli_fetch_array($query, MYSQLI_ASSOC))
	{
		echo "<tr>";
		echo "<td>" . $row['id'] . "</td>";
		echo "<td>" . $row['make'] . "</td>";
		echo "<td>" . $row['model'] . "</td>";
		echo "<td>" . $row['year'] . "</td>";
		echo "<td>" . $row['color'] . "</td>";
	}
	echo "</table>";
//Close your database connection
mysqli_close($con);

?>
<!DOCTYPE html>

<head>
	<title>Pager Project Intro</title>
	<meta charset="utf-8" />
	<style type="text/css">
		body{ font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;}
		div#pagination_controls{font-size:18px;}
		div#pagination_controls > a{ color:#000; }
		div#pagination_controls > a:visited{ color:#000; }
	</style>
</head>

<body>

	<div id="main-content">
		
		<?php echo $list; ?> 
		
		<div id="pagination_controls"><?php echo $paginationCtrls; ?></div>
	</div>

</body>
</html>