<?PHP
			header ("Content-Type:text/html; charset=utf-8");  
			include 'dbconnect.php';
			
			dbConnect();
			
			//---------------------------------------------------------------------------------------------------------------
			// Search Query!
			//---------------------------------------------------------------------------------------------------------------

			$tourney_id = filter_var($_GET['id'],FILTER_VALIDATE_INT);
			
			echo '<table><tr><td style="vertical-align:top;">';
			
			if ($_GET['new'] == "true"){
				echo '<h2>New tourney:</h2><form><table>';
				echo '<tr><td>Name</td><td><input type="text" size="30" id="editTourneyName"></td></tr>';
			} else {
				echo '<h2>Edit tourney:</h2><form><table>';
				$querystring="SELECT * FROM tourney where id = ".$tourney_id.";";
				$result_tourney=mysql_query($querystring);
				if (!$result_tourney) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
				$tourney = mysql_fetch_assoc($result_tourney);
				echo '<tr><td>Name</td><td><input type="text" size="30" id="editTourneyName" value="'.$tourney['name'].'"></td></tr>';
				echo '<input id="editTourneyId" type="hidden" value="'.$tourney[id].'">';
			}
			echo '<tr><td>Random deck allowed</td><td>';
			if ($_GET['new'] == "true"){
				echo '<input id="editTourneyRandom" type="checkbox" checked>';
			} else {
				if ($tourney['randomAllowed'] == 0){
					echo '<input id="editTourneyRandom" type="checkbox">';
				} else {
					echo '<input id="editTourneyRandom" type="checkbox" checked>';
				}
			}
			echo '</td></tr></table>';
			echo '</td><td><div style="width:20px"></div></td><td style="vertical-align:top;">';
			
			//-----------------------Players
			echo '<h2>Players:</h2>';

			if ($_GET['new'] == "true"){
				$querystring="select * from player where available = 1 order by name;";
			} else {
				$querystring="select player.id, player.name from tourney_player join player on player.id = tourney_player.player_id where tourney_player.tourney_id = ".$tourney_id." order by name;";			
			}
			$result=mysql_query($querystring);
			if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
			while ($row = mysql_fetch_assoc($result)) {
				echo '<input type="checkbox" checked class="editTourneyPlayerCheckbox" value="'.$row['id'].'">'.$row['name'].'<br>';
			}
			
			if ($_GET['new'] != "true"){
				$querystring="select * from player where id not in (select player.id from tourney_player join player on player.id = tourney_player.player_id where player.available = 1 and tourney_player.tourney_id = ".$tourney_id.") and available = 1 order by name;";
				$result=mysql_query($querystring);
				if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
				while ($row = mysql_fetch_assoc($result)) {
					echo '<input type="checkbox" class="editTourneyPlayerCheckbox" value="'.$row['id'].'">'.$row['name'].'<br>';
				}			
			}
			
			echo '</td><td><div style="width:20px"></div></td><td style="vertical-align:top;">';
			
			//-----------------------Decks
			echo '<h2>Decks:</h2>';
			
			if ($_GET['new'] == "true"){
				$querystring="select deck.id,deck.name as deck_name,player.name as player_name from deck join player on deck.owner_id = player.id where deck.available = 1 order by player_name;";
			} else {
				$querystring="select deck.id, deck.name as deck_name, player.name as player_name from tourney_deck join deck on deck.id = tourney_deck.deck_id join player on player.id = deck.owner_id where tourney_deck.tourney_id = ".$tourney_id." order by player_name;";
			}
			$result=mysql_query($querystring);
			if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
			while ($row = mysql_fetch_assoc($result)) {
				echo '<input type="checkbox" checked class="editTourneyDeckCheckbox" value="'.$row['id'].'">'.$row['player_name']." - ".$row['deck_name'].'<br>';
			}
			
			if ($_GET['new'] != "true"){
				$querystring="select deck.id, deck.name as deck_name, player.name as player_name from deck join player on player.id = deck.owner_id where deck.id not in (select deck.id from tourney_deck join deck on deck.id = tourney_deck.deck_id where deck.available = 1 and tourney_deck.tourney_id = ".$tourney_id.") and deck.available = 1 order by player_name;";
				$result=mysql_query($querystring);
				if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
				while ($row = mysql_fetch_assoc($result)) {
					echo '<input type="checkbox" class="editTourneyDeckCheckbox" value="'.$row['id'].'">'.$row['player_name']." - ".$row['deck_name'].'<br>';
				}			
			}
			
			echo '</td></tr></table>';
			echo '<input type="button" value="Submit" onClick="editTourney($(\'#editTourneyName\').val(),$(\'#editTourneyRandom:checked\').val(),$(\'#editTourneyId\').val())">';
			echo '</form>';
?>
