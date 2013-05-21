<?PHP
			header ("Content-Type:text/html; charset=utf-8");  
			include 'dbconnect.php';
			
			dbConnect();
			
			//---------------------------------------------------------------------------------------------------------------
			// Search Query!
			//---------------------------------------------------------------------------------------------------------------

			$querystring="select deck.id,deck.name,deck.available,player.name as deck_owner,player.id as player_id from deck join player on player.id = deck.owner_id order by deck_owner,name;";
			$result=mysql_query($querystring);
			
			if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
 
			echo '<h2>All decks:</h2><form><table>';
			echo '<tr><th></th><th align="left">Deck</th><th align="left">Owner</th></tr>';
			while ($row = mysql_fetch_assoc($result)) {
				echo '<td><input type="radio" class="editDeckRadio" name="deckEdit" value="'.$row['id'].'"></td><td>';
				//','.$row['name'].','.$row['player_id'].','.$row['deck_owner'].','.$row['available'].
				if ($row['available'] == false){
					echo '<span style="text-decoration:line-through">'.$row['name'].'</span>';
					echo '</td><td>';
					echo '<span style="text-decoration:line-through">'.$row['deck_owner'].'</span>';
				} else {
					echo $row['name'];
					echo '</td><td>';
					echo $row['deck_owner'];
				}
				echo '</td></tr>';
			}
			echo '<td style="background-color:#fff"></td><td colspan=2 style="background-color:#fff"><input type="button" value="Edit" onClick="editDeckForm(false)">';
			echo '<input type="button" value="Delete" onClick="deleteDeck()">';
			echo '<input type="button" value="New" onClick="editDeckForm(true)"></td>';
			echo '</table>';
			echo '</form>';
?>
