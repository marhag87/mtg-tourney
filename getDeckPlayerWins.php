<?PHP
			header ("Content-Type:text/html; charset=utf-8");  
			include 'dbconnect.php';
			
			dbConnect();
			
			//---------------------------------------------------------------------------------------------------------------
			// Search Query!
			//---------------------------------------------------------------------------------------------------------------

			$deck_id = filter_var($_GET['deck_id'],FILTER_VALIDATE_INT);
			$tourney_id = filter_var($_GET["tourney_id"],FILTER_VALIDATE_INT);
			if ($tourney_id) {
				$querystring="select distinct(g.player_id) as player_id, p.played, coalesce(w.wins,0) as wins,round((coalesce(w.wins,0)/p.played)*100) as ratio, player.name as player_name from gamepart g join (select gamepart.player_id,tourney_id,count(gamepart.id) as played from gamepart join game on game.id = gamepart.game_id where game.end is not null and gamepart.deck_id = ".$deck_id." and tourney_id = ".$tourney_id." group by player_id) p on g.player_id = p.player_id left join (select m.player_id,count(m.player_id) AS wins from max_score_game m where deck_id = ".$deck_id." and m.tourney_id = ".$tourney_id." group by m.player_id) w on g.player_id = w.player_id join player on player.id = g.player_id where g.deck_id = ".$deck_id." order by wins desc,name;";
			} else {
				$querystring="select distinct(g.player_id) as player_id, p.played, coalesce(w.wins,0) as wins,round((coalesce(w.wins,0)/p.played)*100) as ratio, player.name as player_name from gamepart g join (select gamepart.player_id,tourney_id,count(gamepart.id) as played from gamepart join game on game.id = gamepart.game_id where game.end is not null and gamepart.deck_id = ".$deck_id." group by player_id) p on g.player_id = p.player_id left join (select m.player_id,count(m.player_id) AS wins from max_score_game m where deck_id = ".$deck_id."  group by m.player_id) w on g.player_id = w.player_id join player on player.id = g.player_id where g.deck_id = ".$deck_id." order by wins desc,name;";
			}		
			$result=mysql_query($querystring);
			
			if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
 
			echo '<h2>Player wins:</h2><table>';
			echo '<tr><th align="left">Wins</th><th align="left">Played</th><th align="left">Ratio</th><th align="left">Player</th></tr>';
			$n = 0;
			while ($row = mysql_fetch_assoc($result)) {
				echo '<tr><td class="deckPlayerWinsNumber" id="deckPlayerWinsNumber'.$n.'">'.$row['wins'].'</td>';
				echo '<td>'.$row['played'].'</td>';
				echo '<td>'.$row['ratio'].'%</td>';
				echo '<td>'.$row['player_name'].'</td>';
				$n++;
			}
			echo '</table>';
?>
