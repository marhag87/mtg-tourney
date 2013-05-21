<?PHP
			header ("Content-Type:text/html; charset=utf-8");  
			include 'dbconnect.php';
			
			dbConnect();
			
			//---------------------------------------------------------------------------------------------------------------
			// Search Query!
			//---------------------------------------------------------------------------------------------------------------

			$deck_id = filter_var($_GET['game_id'],FILTER_VALIDATE_INT);

			$querystring="DELETE FROM game WHERE id = ".$deck_id.";";
			$result=mysql_query($querystring);
			if (!$result) err("\nSQL Query Error: ".mysql_error(),"Conference filter database querying error");
			echo "ok";
?>
