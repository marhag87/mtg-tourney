<?PHP
	header ("Content-Type:text/html; charset=utf-8");  
	include 'dbconnect.php';
	
	dbConnect();
	
	//---------------------------------------------------------------------------------------------------------------
	// Search Query!
	//---------------------------------------------------------------------------------------------------------------

	$game_id = filter_var($_GET['game_id'],FILTER_VALIDATE_INT);

	$querystring="call deleteGame(".$game_id.");";
	$result=mysql_query($querystring);
	if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
	echo "ok";
?>
