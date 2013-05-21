<?PHP
			header ("Content-Type:text/html; charset=utf-8");  
			include 'dbconnect.php';
			
			dbConnect();
			
			//---------------------------------------------------------------------------------------------------------------
			// Search Query!
			//---------------------------------------------------------------------------------------------------------------

			$tourney_id = filter_var($_GET['tourney_id'],FILTER_VALIDATE_INT);
			if ($tourney_id){
				$querystring="SELECT * FROM players_playing where tourney_id = ".$tourney_id." order by game_id;";
			} else {
				$querystring="SELECT * FROM players_playing order by game_id;";
			}
			$result=mysql_query($querystring);
			
			if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
 
			echo '<h2>Active players:</h2>'."\n";
			$last_id = -1;
			if (mysql_num_rows($result) > 0){
				echo '<table id="activeGame">'."\n";
				 while ($row = mysql_fetch_assoc($result)){
					if ($last_id < $row['game_id'] && $last_id != -1) {
						echo '<tr><td colspan=3>';
						echo $tourney_name;
						echo '</td></tr>';
						echo '<tr>'."\n";
						echo '<td colspan=3><form class="playersPlayingForm" id="form_game_'.$last_id.'">'."\n";
						echo '<input type="button" value="Submit score" onClick="sendScore('.$last_id.')">'."\n";
						echo '<input type="button" value="Who starts?" onClick="getRandomStarter('.$last_id.')">';
						echo '</td></tr></table><table id="activeGame">'."\n";				
					}
					$tourney_name = $row['tourney_name'];
					echo '<tr>'."\n";
					echo '<td>'.$row['player_name'].'</td>'."\n";
					echo '<td>('.$row['deck_owner'].' - '.$row['deck_name'].')</td>'."\n";
					echo '<td><input type="text" size=2 value=0 class="form_game_'.$row['game_id'].'_score" id="'.$row['player_id'].'"></td>'."\n";
					echo '</tr>'."\n";
					$last_id = $row['game_id'];
				}
				echo '<tr><td colspan=3>';
				echo $tourney_name;
				echo '</td></tr>';
				echo '<tr>'."\n";
				echo '<td colspan=3><form class="playersPlayingForm" id="form_game_'.$last_id.'">'."\n";
				echo '<input type="button" value="Submit score" onClick="sendScore('.$last_id.')">'."\n";
				echo '<input type="button" value="Who starts?" onClick="getRandomStarter('.$last_id.')">';
				echo '</td>'."\n";
				echo '</tr></table><table>'."\n";	
				echo '</table>';
			}
?>
