<?PHP
			header ("Content-Type:text/html; charset=utf-8");  
			include 'dbconnect.php';
			
			dbConnect();
			
			//---------------------------------------------------------------------------------------------------------------
			// Search Query!
			//---------------------------------------------------------------------------------------------------------------
			$game_id = filter_var($_GET["game_id"],FILTER_VALIDATE_INT);
			$querystring = "SELECT game.id,game.start,game.end,game.tourney_id,tourney.name FROM game INNER JOIN tourney ON game.tourney_id = tourney.id WHERE game.id = ".$game_id." ORDER BY end DESC";
			$result=mysql_query($querystring);
			if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
			
			echo '<h2>Edit game:</h2>';
			while ($row = mysql_fetch_assoc($result)) {
				echo '<form><div id="editGameForm"><div class="editGameFormRow">';
				echo '<span>Game nr:</span><span class="editGameFormValue">'.$row['id']."</span></div>\n";
				
				$querystring = "select id,name from tourney order by id desc;";
				$result_tourney=mysql_query($querystring);
				if (!$result_tourney) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
				echo '<div class="editGameFormRow"><span>Tourney:</span><span class="editGameFormValue"><select id="editGameFormTourney">';
				while ($tourney = mysql_fetch_assoc($result_tourney)) {
					$selected = "";
					if ($tourney['id'] == $row['tourney_id']){
						$selected = "selected";
					}
					echo '<option '.$selected.' value="'.$tourney['id'].'">'.$tourney['name'].'</option>';
				}
				echo '</select></span></div>';
				
				
				echo '<div class="editGameFormRow"><span>Started:</span><span class="editGameFormValue"><input type="text" id="editGameFormTourney" value="'.$row['start'].'"></span></div>';
				echo '<div class="editGameFormRow"><span>Ended:</span><span class="editGameFormValue"><input type="text" id="editGameFormTourney" value="'.$row['end'].'"></span></div>';
			}
			//----------------Get all players
			$querystring = "SELECT * FROM player";
			$result=mysql_query($querystring);
			if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");		
			$players = Array();
			while ($row = mysql_fetch_assoc($result)) {
				$players[$row['id']] = $row['name'];
			}
			//----------------Get all decks
			$querystring = "select deck.id,deck.name as deck_name, player.name as owner_name from deck join player on player.id = deck.owner_id;";
			$result=mysql_query($querystring);
			if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");		
			$decks = Array();
			while ($row = mysql_fetch_assoc($result)) {
				$decks[$row['id']] = $row['owner_name']." - ".$row['deck_name'];
			}
			//----------------Get players that were originally in the game
			$querystring = "select * from gamepart where game_id = 169;";
			$result=mysql_query($querystring);
			if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");		
			
			$id = 0;
			echo '<div><table id="editGameFormPlayerTable">';
			while ($row = mysql_fetch_assoc($result)) {
				$id = $row['id'];
				echo '<tr ><td align="right">Player:</td>';
				echo '<td><select>';
				foreach ($players as $k => $v){
					$selected = "";
					if ($row['player_id'] == $k) $selected = "selected";
					echo '<option '.$selected.'>'.$v.'</option>';
				}
				echo '</select></td>';
				echo '<td align="right">Score:</td>';
				echo '<td><input type="text" size="2" value="'.$row['score'].'"></td>';
				echo '<td align="right">Deck:</td>';
				echo '<td><select>';
				foreach ($decks as $k => $v){
					$selected = "";
					if ($row['deck_id'] == $k) $selected = "selected";
					echo '<option '.$selected.'>'.$v.'</option>';
				}
				echo '</select></td>';
				echo '</td><td onClick="$(this).parent().remove()"><input type="button" value="Remove player"></td></tr>';
			}	
			//---------------------------------Make hidden row to be cloned when adding players
			echo '<tr id="editGameFormPlayerRow0" style="display:none"><td align="right">Player:</td>';
			echo '<td><select>';
			foreach ($players as $k => $v){
				echo '<option '.$selected.'>'.$v.'</option>';
			}
			echo '</select></td>';
			echo '<td align="right">Score:</td>';
			echo '<td><input type="text" size="2" value="0"></td>';
			echo '<td align="right">Deck:</td>';
			echo '<td><select>';
			foreach ($decks as $k => $v){
				echo '<option '.$selected.'>'.$v.'</option>';
			}
			echo '</select></td>';
			echo '</td><td onClick="$(this).parent().remove()"><input type="button" value="Remove player"></td></tr>';
			//----------------------------------------			
			echo '</table></div>';
			echo '<div><input type="button" value="Add player" onClick="$(\'#editGameFormPlayerRow0\').clone().appendTo(\'#editGameFormPlayerTable\').show()"></div>';
			echo '<div><span><input type="button" value="Submit (NYI)"></span>';
			echo '<span><input type="button" value="Clear" onClick="getEditGameForm('.$game_id.')"></span></div>';
			echo '</div></form>';

?>
