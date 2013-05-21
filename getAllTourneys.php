<?PHP
	header ("Content-Type:text/html; charset=utf-8");  
	include 'dbconnect.php';

	dbConnect();

	//---------------------------------------------------------------------------------------------------------------
	// Search Query!
	//---------------------------------------------------------------------------------------------------------------
	$querystring="SELECT * FROM tourney order by id desc;";
	$result=mysql_query($querystring);
	if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");

	echo '<h2>All tourneys</h2>'."\n";
	echo '<form><table>'."\n";
			echo '<tr><th></th><th align="left">Name</th><th>Random decks allowed</th></tr>'."\n";
			while ($row = mysql_fetch_assoc($result)) {
				echo '<td><input type="radio" class="editTourneyRadio" name="tourneyEdit" value="'.$row['id'].'"></td>'."\n";
				echo '<td>'.$row['name'].'</td>'."\n";
				if ($row['randomAllowed'] == true){
					echo '<td>Yes</td>'."\n";
				} else {
					echo '<td>No</td>'."\n";
				}
				echo '</tr>'."\n";
			}
			echo '<td style="background-color:#fff"></td><td colspan=2 style="background-color:#fff"><input type="button" value="Edit" onClick="editTourneyForm(false)">'."\n";
			echo '<input type="button" value="Delete" onClick="deleteTourney()">'."\n";
			echo '<input type="button" value="New" onClick="editTourneyForm(true)"></td>'."\n";
			echo '</table>'."\n";
			echo '</form>'."\n";
?>

