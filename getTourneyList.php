<?PHP
	header ("Content-Type:text/html; charset=utf-8");  
	include 'dbconnect.php';

	dbConnect();

	//---------------------------------------------------------------------------------------------------------------
	// Search Query!
	//---------------------------------------------------------------------------------------------------------------
	$querystring="SELECT * FROM tourney order by id desc;";
	$result=mysql_query($querystring);
	if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");

	echo 'Tourney: <select id="tourneyList">';
	echo '<option selected value="0">All</option>';
	while ($row = mysql_fetch_assoc($result)) {
		echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
	}
	echo '</select>';
?>

