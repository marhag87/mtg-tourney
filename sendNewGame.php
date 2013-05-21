<?PHP
			header ("Content-Type:text/html; charset=utf-8");  
			include 'dbconnect.php';
			
			dbConnect();
			
			//---------------------------------------------------------------------------------------------------------------
			// Search Query!
			//---------------------------------------------------------------------------------------------------------------

			$tourney_id = filter_var($_GET["tourney_id"],FILTER_VALIDATE_INT);
			if ($tourney_id == 0) {
				echo "You need to select a tournament";
				die();
			} else {
				$querystring = "SELECT * FROM tourney WHERE id = ".$tourney_id.";";
				$result=mysql_query($querystring);
				if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
				$row = mysql_fetch_assoc($result);
				if (!$row["randomAllowed"]){
					echo "You are not allowed to use random decks in this tournament";
					die();
				}
			}
			$querystring="INSERT INTO game (start,tourney_id) VALUES (now(),".$tourney_id.");";
			$result=mysql_query($querystring);
			if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
			$game_id = mysql_insert_id();
			
			foreach($_GET["players_id"] as $k => $v){
				$player_id = filter_var($v,FILTER_VALIDATE_INT);
				if ($tourney_id){
					$querystring="select `deck`.`id` AS `id` from `deck` join (select * from tourney_deck where tourney_id = ".$tourney_id.") t on t.deck_id = deck.id  where ((`deck`.`available` = 1) and (not(`deck`.`id` in (select `used_decks`.`deck_id` from `used_decks`)))) order by rand() limit 1;";
				} else {
					$querystring= "select * from available_decks order by rand() limit 1;";
				}
				$result=mysql_query($querystring);
				if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
				$row = mysql_fetch_assoc($result);
				$deck_id = $row['id'];
				$querystring="INSERT INTO gamepart (game_id,player_id,deck_id) VALUES (".$game_id.",".$player_id.",".$deck_id.");";
				$result=mysql_query($querystring);
				if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
			}
			echo "ok";
?>
