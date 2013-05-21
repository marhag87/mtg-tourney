<?PHP
			header ("Content-Type:text/html; charset=utf-8");  
			include 'dbconnect.php';
			
			dbConnect();
			
			//---------------------------------------------------------------------------------------------------------------
			// Search Query!
			//---------------------------------------------------------------------------------------------------------------

			
			$tourney_id = filter_var($_GET["tourney_id"],FILTER_VALIDATE_INT);
			if ($tourney_id) {
				$querystring="select distinct(g.deck_id),coalesce(w.wins,0) as wins,p.played,round((coalesce(w.wins,0)/p.played)*100) as ratio, deck.name as name,player.name as deck_owner from gamepart g join (select deck_id,count(gamepart.id) as played from gamepart join game on game.id = gamepart.game_id where game.end is not null and tourney_id = ".$tourney_id." group by deck_id) p on g.deck_id = p.deck_id left join (select t.deck_id,count(t.deck_id) as wins from (select m.deck_id,deck.name as deck_name,player.name as player_name from (max_score_game m join deck on deck.id = m.deck_id and m.tourney_id = ".$tourney_id.") join player on player.id = deck.owner_id) t group by t.deck_id) w on w.deck_id = g.deck_id join deck on deck.id = g.deck_id join player on player.id = deck.owner_id join game on g.game_id = game.id where game.tourney_id = ".$tourney_id." order by wins desc,played desc,deck_owner,name;";
			} else {
				$querystring="select distinct(g.deck_id),coalesce(w.wins,0) as wins,p.played,round((coalesce(w.wins,0)/p.played)*100) as ratio, deck.name as name,player.name as deck_owner from gamepart g join (select deck_id,count(gamepart.id) as played from gamepart join game on game.id = gamepart.game_id where game.end is not null group by deck_id) p on g.deck_id = p.deck_id left join (select t.deck_id,count(t.deck_id) as wins from (select m.deck_id,deck.name as deck_name,player.name as player_name from (max_score_game m join deck on deck.id = m.deck_id) join player on player.id = deck.owner_id) t group by t.deck_id) w on w.deck_id = g.deck_id join deck on deck.id = g.deck_id join player on player.id = deck.owner_id order by wins desc,played desc,deck_owner,name;";
			}		
			$result=mysql_query($querystring);
			
			if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
 
			echo '<h2>Deck wins:</h2><table>';
			echo '<tr><th align="left">Wins</th><th align="left">Played</th><th align="left">Ratio</th><th align="left">Deck</th><th align="left">Owner</th></tr>';

			while ($row = mysql_fetch_assoc($result)) {
				echo '<tr><td>'.$row['wins'].'</td>';
				echo '<td>'.$row['played'].'</td>';
				echo '<td>'.$row['ratio'].'%</td>';
				echo '<td class="deckWinsName" onClick="getDeckPlayerWins('.$row['deck_id'].',this)">'.$row['name'].'</td>';
				echo '<td>'.$row['deck_owner'].'</td></tr>';
			}
			echo '</table>';
?>
