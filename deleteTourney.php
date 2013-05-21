<?PHP
			header ("Content-Type:text/html; charset=utf-8");  
			include 'dbconnect.php';
			
			dbConnect();
			
			//---------------------------------------------------------------------------------------------------------------
			// Search Query!
			//---------------------------------------------------------------------------------------------------------------

			$tourney_id = filter_var($_GET['tourney_id'],FILTER_VALIDATE_INT);

			$querystring="DELETE FROM tourney_player where tourney_id = ".$tourney_id.";";
			$result=mysql_query($querystring);
			if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
			
			$querystring="DELETE FROM tourney_deck where tourney_id = ".$tourney_id.";";
			$result=mysql_query($querystring);
			if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
			
			$querystring="DELETE FROM tourney where id = ".$tourney_id.";";
			$result=mysql_query($querystring);
			if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
			echo "ok";
?>
