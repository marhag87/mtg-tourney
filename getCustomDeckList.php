<?PHP
			header ("Content-Type:text/html; charset=utf-8");  
			include 'dbconnect.php';
			
			dbConnect();
			
			//---------------------------------------------------------------------------------------------------------------
			// Search Query!
			//---------------------------------------------------------------------------------------------------------------

			$tourney_id = filter_var($_GET['tourney_id'],FILTER_VALIDATE_INT);

			if ($tourney_id){
				$querystring="select `deck`.`id` AS `id`,`deck`.`name` AS `deck_name`,`player`.`name` AS `player_name` from ((`available_decks` join `deck` on((`deck`.`id` = `available_decks`.`id`))) join `player` on((`deck`.`owner_id` = `player`.`id`))) join (select * from tourney_deck where tourney_id = ".$tourney_id.") t on t.deck_id = deck.id where (`deck`.`available` = 1) order by player_name,deck_name;";
			} else {
				$querystring="SELECT * FROM available_decks_info ORDER BY player_name;";
			}
			
			$result=mysql_query($querystring);
			
			if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");

			echo '<h2>Choose custom decks:</h2>';			
			$decks = array();
			while ($row = mysql_fetch_assoc($result)) {
				array_push($decks,array("id" => $row['id'], "player_name" => $row['player_name'], "deck_name" => $row['deck_name']));
			}

			echo '<form id="customDeckListForm"><table>';
			foreach($_GET["players_id"] as $k => $v){
				$v = filter_var($v,FILTER_VALIDATE_INT);
				$querystring="SELECT * FROM player where id = ".$v.";";
				$result=mysql_query($querystring);
				if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
				while ($row = mysql_fetch_assoc($result)) {
					echo '<tr><td>'.$row['name']."</td>";
					echo '<td><select class="customDeckSelector" id="'.$v.'">';
					foreach($decks as $key => $deck){
						echo '<option value="'.$deck['id'].'">'.$deck['player_name']." - ".$deck['deck_name'].'</option>';
					}
					echo '</select></td></tr>';
				}
			}
			echo '<tr><td colspan=2><input onClick="submitCustomDeckList()" type="button" value="Create">';
			echo '<input type="reset" value="Clear"></td></tr>';
			echo '</table></form>';

?>

