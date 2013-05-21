<?PHP
			header ("Content-Type:text/html; charset=utf-8");  
			include 'dbconnect.php';
			
			dbConnect();
			
			//---------------------------------------------------------------------------------------------------------------
			// Search Query!
			//---------------------------------------------------------------------------------------------------------------
			$tourney_id = filter_var($_GET["tourney_id"],FILTER_VALIDATE_INT);
			if ($tourney_id) {
				$querystring="SELECT game.id,game.start,game.end,game.tourney_id,tourney.name FROM game INNER JOIN tourney ON game.tourney_id = tourney.id WHERE end IS NOT NULL AND tourney.id = ".$tourney_id." ORDER BY end DESC";
			} else {
				$querystring="SELECT game.id,game.start,game.end,game.tourney_id,tourney.name FROM game INNER JOIN tourney ON game.tourney_id = tourney.id WHERE end IS NOT NULL ORDER BY end DESC";
			}
			if ($_GET['limit'] == "true"){
				$querystring.=" LIMIT 5;";
			} else {
				$querystring.=";";
			}
			$result=mysql_query($querystring);
			
			if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
			
			echo '<h2>Old games:</h2>';
 
			while ($row = mysql_fetch_assoc($result)) {
				echo '<table id="oldGame"><tr>';
				echo '<td align="right">Game nr:</td><td colspan=4>'.$row['id']."</td>\n";
				echo '<td align="right"><input type="button" value="Delete" onClick="deleteGame('.$row['id'].')"><input type="button" value="Edit (NYI)" onClick="getEditGameForm('.$row['id'].')"></td></tr>';
				echo '<td align="right">Tourney:</td><td colspan=5>'.$row['name']."</td></tr>\n";
				echo '<tr><td align="right">Started:</td><td colspan=5>'.$row['start'].'</td></tr>';
				echo '<tr><td align="right">Ended:</td><td colspan=5>'.$row['end']."</td>\n";
				
				$querystring = "select gamepart.score as score, player.name as player_name, deck.name as deck_name, b.name as deck_owner from gamepart join player on gamepart.player_id = player.id join deck on deck.id = gamepart.deck_id join player b on deck.owner_id = b.id where gamepart.game_id = ".$row['id']." order by score desc;";
				$result_gamepart=mysql_query($querystring);
				if (!$result_gamepart) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
				while ($row_gamepart = mysql_fetch_assoc($result_gamepart)){
					echo '<tr><td align="right">Player:</td><td>'.$row_gamepart['player_name'].'</td><td align="right">Score:</td><td>'.$row_gamepart['score'].'</td><td align="right">Deck:</td><td>'.$row_gamepart['deck_owner']." - ".$row_gamepart['deck_name']."</td></tr>\n";
				}
				echo "</table>";
			}
			echo '<input type="button" value="All games" onClick="getOldGames(false);$(\'#oldGamesButton\').hide();">';

?>
