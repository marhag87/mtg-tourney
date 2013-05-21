<?PHP
			header ("Content-Type:text/html; charset=utf-8");  
			include 'dbconnect.php';
			
			dbConnect();
			
			//---------------------------------------------------------------------------------------------------------------
			// Search Query!
			//---------------------------------------------------------------------------------------------------------------

			$game_id = filter_var($_GET["game_id"],FILTER_VALIDATE_INT);

			$querystring="select player.name as player_name from gamepart join game on gamepart.game_id = game.id join player on player.id = gamepart.player_id where game_id = ".$game_id." order by rand(start) limit 1;";
			$result=mysql_query($querystring);
			
			if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
 
			$row = mysql_fetch_assoc($result);
			echo $row['player_name'];
?>
