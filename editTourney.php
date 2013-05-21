<?PHP
			header ("Content-Type:text/html; charset=utf-8");  
			include 'dbconnect.php';
			
			dbConnect();
			
			//---------------------------------------------------------------------------------------------------------------
			// Search Query!
			//---------------------------------------------------------------------------------------------------------------

			$tourney_id = filter_var($_GET['tourney_id'],FILTER_VALIDATE_INT);
			$name = filter_var($_GET['name'],FILTER_SANITIZE_SPECIAL_CHARS);
			$randomAllowed = $_GET['randomAllowed'];
			
			if ($name == "") err("\nName is required");
			if ($randomAllowed != "true" && $randomAllowed != "false") err("\nYou went full baka");
			if ($tourney_id) {
				$querystring="UPDATE tourney SET name = \"".$name."\", randomAllowed = ".$randomAllowed." where id = ".$tourney_id.";";
			} else {
				$querystring="INSERT INTO tourney (name,randomAllowed) VALUES (\"$name\",$randomAllowed);";
			}
			$result=mysql_query($querystring);
			if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");

			if ($tourney_id){
				$querystring="delete from tourney_player where tourney_id = ".$tourney_id.";";
				$result=mysql_query($querystring);
				if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
				$querystring="delete from tourney_deck where tourney_id = ".$tourney_id.";";
				$result=mysql_query($querystring);
				if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
			} else {
				$tourney_id = mysql_insert_id();
			}
			
			$querystring="insert into tourney_player (tourney_id,player_id) values ";
			foreach($_GET["player_id"] as $k => $v){
				$player_id = filter_var($v,FILTER_VALIDATE_INT);
				if ($k > 0) $querystring .= ",";
				$querystring .="(".$tourney_id.",".$player_id.")";
			}
			$querystring .= ";";
			$result=mysql_query($querystring);
			if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
			$querystring="insert into tourney_deck (tourney_id,deck_id) values ";
			foreach($_GET["deck_id"] as $k => $v){
				$deck_id = filter_var($v,FILTER_VALIDATE_INT);
				if ($k > 0) $querystring .= ",";
				$querystring .= "(".$tourney_id.",".$deck_id.")";
			}
			$result=mysql_query($querystring);
			if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");			
			
			echo "ok";
?>
