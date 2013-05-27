<?PHP
	header ("Content-Type:text/html; charset=utf-8");  
	include 'dbconnect.php';
	
	dbConnect();
	
	//---------------------------------------------------------------------------------------------------------------
	// Search Query!
	//---------------------------------------------------------------------------------------------------------------
	$tourney_id = filter_var($_GET["tourney_id"],FILTER_VALIDATE_INT);
	$querystring="call getPlayerWins(".$tourney_id.")";
	$result=mysql_query($querystring);
	
	if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");

	echo '<h2>Player wins:</h2><table>';
	echo '<tr><th align="left">Wins</th><th align="left">Played</th><th align="left">Ratio</th><th align="left">Player</th></tr>';
	while ($row = mysql_fetch_assoc($result)) {
		echo '<tr><td>'.$row['wins'].'</td>';
		echo '<td>'.$row['played'].'</td>';
		echo '<td>'.$row['ratio'].'%</td>';
		echo '<td class="playerWinsName" onClick="getPlayerDeckWins('.$row['player_id'].',this)">'.$row['name'].'</td>';
	}
	echo '</table>';
?>
