<?PHP
			header ("Content-Type:text/html; charset=utf-8");  
			include 'dbconnect.php';
			
			dbConnect();
			
			//---------------------------------------------------------------------------------------------------------------
			// Search Query!
			//---------------------------------------------------------------------------------------------------------------
			$tourney_id = filter_var($_GET['tourney_id'],FILTER_VALIDATE_INT);

			echo '<h2>Inactive players:</h2>';

			if ($tourney_id){
				$querystring="select player.id,player.name from player join (select * from tourney_player where tourney_id = ".$tourney_id.") t on player.id = t.player_id where ((not(`player`.`id` in (select `players_playing`.`player_id` AS `id` from `players_playing`))) and (`player`.`available` = 1));";
			} else {
				//$querystring="SELECT * FROM players_available ORDER BY name;";
				echo "Select a tourney to play.";
				die();
			}
			$result=mysql_query($querystring);
			
			if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
 
			while ($row = mysql_fetch_assoc($result)) {
				echo '<input class="playersAvailableCheckbox" type="checkbox" id="'.$row['id'].'">'.$row['name'].'<br />';

			}
			if ($tourney_id){
				$querystring="SELECT * FROM tourney WHERE id = ".$tourney_id.";";
				$result=mysql_query($querystring);
				if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
				$row = mysql_fetch_assoc($result);
				if ($row['randomAllowed'] == 1){
					echo '<input type="button" value="Random decks" onClick="newGame(true)">';
				}
			} else {
				echo '<input type="button" value="Random decks" onClick="newGame(true)">';
			}
			echo '<input type="button" value="Custom decks" onClick="newGame(false)">';
?>

