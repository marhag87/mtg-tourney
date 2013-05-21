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
			}
			$querystring="INSERT INTO game (start,tourney_id) VALUES (now(),".$tourney_id.");";
			$result=mysql_query($querystring);
			if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
			$game_id = mysql_insert_id();
			foreach($_GET["player_id"] as $k => $v){
				$player_id = filter_var($v,FILTER_VALIDATE_INT);
				$deck_id = filter_var($_GET['deck_id'][$k],FILTER_VALIDATE_INT);
				$querystring="INSERT INTO gamepart (game_id,player_id,deck_id) VALUES (".$game_id.",".$player_id.",".$deck_id.");";
				$result=mysql_query($querystring);
				if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
			}
			echo "ok";

?>