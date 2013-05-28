<?PHP
	header ("Content-Type:text/html; charset=utf-8");  
	include 'dbconnect.php';
	
	dbConnect();
	
	//---------------------------------------------------------------------------------------------------------------
	// Search Query!
	//---------------------------------------------------------------------------------------------------------------

	$deck_id = filter_var($_GET['deck_id'],FILTER_VALIDATE_INT);
	$owner_id = filter_var($_GET['owner_id'],FILTER_VALIDATE_INT);
	$name = filter_var($_GET['name'],FILTER_SANITIZE_SPECIAL_CHARS);
	$available = $_GET['available'];
	
	if ($name == "") err("\nName is required");
	if ($available != "true" && $available != "false") err("\nYou went full baka");
	$querystring="call editDeck(\"".$name."\",".$owner_id.",".$available.",".$deck_id.");";
	$result=mysql_query($querystring);
	if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
	echo "ok";
?>
