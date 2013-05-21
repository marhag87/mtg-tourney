<?PHP
			header ("Content-Type:text/html; charset=utf-8");  
			include 'dbconnect.php';
			
			dbConnect();
			
			//---------------------------------------------------------------------------------------------------------------
			// Search Query!
			//---------------------------------------------------------------------------------------------------------------

			$deck_id = filter_var($_GET['id'],FILTER_VALIDATE_INT);
			
			$querystring="SELECT * FROM player";
			$result=mysql_query($querystring);
			if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");

			if ($_GET['new'] == "true"){
				echo '<h2>New deck:</h2><form><table>';
				echo '<tr><td>Name</td><td><input type="text" id="editDeckName"></td></tr>';
			} else {
				echo '<h2>Edit deck:</h2><form><table>';
				$querystring="SELECT * FROM deck where id = ".$deck_id.";";
				$result_deck=mysql_query($querystring);

				if (!$result_deck) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
				$deck = mysql_fetch_assoc($result_deck);
				echo '<tr><td>Name</td><td><input type="text" id="editDeckName" value="'.$deck['name'].'"></td></tr>';
				echo '<input id="editDeckId" type="hidden" value="'.$deck[id].'">';
			}
			
			echo '<tr><td>Owner</td><td><select id="editDeckOwner">';
			while ($player = mysql_fetch_assoc($result)) {
				if ($player['id'] == $deck['owner_id']){
					echo '<option value="'.$player['id'].'" selected>'.$player['name'].'</option>';
				} else {
					echo '<option value="'.$player['id'].'">'.$player['name'].'</option>';
				}
			}
			echo '</select></td></tr>';
			
			echo '<tr><td>Available</td><td>';
			if ($_GET['new'] == "true"){
				echo '<input id="editDeckAvailable" type="checkbox" checked>';
				//echo '</td></tr></table>';
				//echo '<input type="button" value="Submit" id="editDeckFormButton" onClick="newDeck($(\'#editDeckName\').val(),$(\'#editDeckOwner\').val(),$(\'#editDeckAvailable:checked\').val())">';
				//echo '<input type="reset" value="Clear">';
			} else {
				if ($deck['available'] == 0){
					echo '<input id="editDeckAvailable" type="checkbox">';
				} else {
					echo '<input id="editDeckAvailable" type="checkbox" checked>';
				}
			}
			echo '</td></tr></table>';
			echo '<input type="button" value="Submit" onClick="editDeck($(\'#editDeckName\').val(),$(\'#editDeckOwner\').val(),$(\'#editDeckAvailable:checked\').val(),$(\'#editDeckId\').val())">';
			echo '<input type="reset" value="Clear">';
			echo '</form>';
?>
