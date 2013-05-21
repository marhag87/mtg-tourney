<?PHP
			header ("Content-Type:text/html; charset=utf-8");  
			include 'dbconnect.php';
			
			dbConnect();
			
			//---------------------------------------------------------------------------------------------------------------
			// Search Query!
			//---------------------------------------------------------------------------------------------------------------

			$player_id = filter_var($_GET['player_id'],FILTER_VALIDATE_INT);
			$tourney_id = filter_var($_GET["tourney_id"],FILTER_VALIDATE_INT);
			if ($tourney_id) {
				$querystring="select distinct(g.deck_id) as deck_id,p.played,coalesce(w.wins,0) as wins,round((coalesce(w.wins,0)/p.played)*100) as ratio, deck.name as deck_name, player.name as owner_name from gamepart g join (select deck_id,count(gamepart.id) as played from gamepart join game on game.id = gamepart.game_id where game.end is not null and gamepart.player_id = ".$player_id." and tourney_id = ".$tourney_id." group by deck_id) p on g.deck_id = p.deck_id left join (select t.deck_id,count(t.deck_id) as wins from (select m.deck_id,deck.name as deck_name,player.name as player_name from (max_score_game m join deck on deck.id = m.deck_id and m.player_id = ".$player_id." and m.tourney_id = ".$tourney_id.") join player on player.id = deck.owner_id) t group by t.deck_id) w on w.deck_id = g.deck_id join deck on deck.id = g.deck_id join player on player.id = deck.owner_id order by wins desc,played desc,owner_name,deck_name;";
			} else {
				$querystring="select distinct(g.deck_id) as deck_id,p.played,coalesce(w.wins,0) as wins,round((coalesce(w.wins,0)/p.played)*100) as ratio, deck.name as deck_name, player.name as owner_name from gamepart g join (select deck_id,count(gamepart.id) as played from gamepart join game on game.id = gamepart.game_id where game.end is not null and gamepart.player_id = ".$player_id." group by deck_id) p on g.deck_id = p.deck_id left join (select t.deck_id,count(t.deck_id) as wins from (select m.deck_id,deck.name as deck_name,player.name as player_name from (max_score_game m join deck on deck.id = m.deck_id and m.player_id = ".$player_id.") join player on player.id = deck.owner_id) t group by t.deck_id) w on w.deck_id = g.deck_id join deck on deck.id = g.deck_id join player on player.id = deck.owner_id order by wins desc,played desc,owner_name,deck_name;";
			}		
			$result=mysql_query($querystring);
			
			if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");

			echo '<h2>Deck wins:</h2><table>';
			echo '<tr><th align="left">Wins</th><th align="left">Played</th><th align="left">Ratio</th><th align="left">Deck</th><th align="left">Owner</th></tr>';
			$n = 0;
			while ($row = mysql_fetch_assoc($result)) {
				echo '<tr><td class="playerDeckWinsNumber" id="playerDeckWinsNumber'.$n.'" style="background-color: red">'.$row['wins'].'</td>';
				echo '<td>'.$row['played'].'</td>';
				echo '<td>'.$row['ratio'].'%</td>';
				echo '<td>'.$row['deck_name'].'</td>';
				echo '<td>'.$row['owner_name'].'</td>';
				$n++;
			}
			echo '</table>';
?>
