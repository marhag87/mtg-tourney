<?PHP
			header ("Content-Type:text/html; charset=utf-8");  
			include 'dbconnect.php';
			
			dbConnect();
			
			//---------------------------------------------------------------------------------------------------------------
			// Search Query!
			//---------------------------------------------------------------------------------------------------------------

			$game_id = filter_var($_GET['game_id'],FILTER_VALIDATE_INT);
			$players = $_GET['player_id'];
			$scores = $_GET['score'];
			$sortedScores = $scores;

			sort($sortedScores);
			$sortedScores = array_reverse($sortedScores);
			if ($sortedScores[0] == $sortedScores[1]) err("You need to have a winner");

			$options = array('options' => array('default' => -1,'min_range' => 0));
			foreach($players as $k => $player){
				$player_id = filter_var($player,FILTER_VALIDATE_INT);
				$score = filter_var($scores[$k],FILTER_VALIDATE_INT,$options);
				if ($score < 0) err("You need to supply score to run this function");
				if (!$game_id) err("You need to supply game_id to run this function");
				if (!$player_id) err("You need to supply player_id to run this function");			
				$querystring="UPDATE gamepart SET score = ".$score." WHERE game_id = ".$game_id." and player_id = ".$player_id.";";
				$result=mysql_query($querystring);
				if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
				$querystring="UPDATE game SET end = now() WHERE id = ".$game_id.";";
				$result=mysql_query($querystring);
				if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
			}
			echo 'ok';
?>
